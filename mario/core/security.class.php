<?php

namespace Bear\Security;

use PDO;

class Seguranca {

   public static function Logs($hash,$db) {
        if(isset($_SESSION['AuthBear'])) {
            $dual = $db->prepare("
            SELECT usuario_hash
            FROM usuarios
            WHERE usuario_hash = :u1
            ");
            $dual->bindParam(':u1', $hash ,PDO::PARAM_STR);
            $dual->execute();
            $fetch = $dual->fetch(PDO::FETCH_ASSOC);
            $result = $dual->rowCount();
            $hash_verificador = $fetch['usuario_hash'];
            if($result < 1) {
            session_destroy();
            } else {
            self::Auth_Verificador($hash,$hash_verificador);
            }
        } else {
            header('location: login.php');
            exit();
        }
    }

    private static function Auth_Verificador($hash,$hash_verificador) {
        if($hash != $hash_verificador) {
            session_destroy();
            header('login.php');
        }
    }
}


class Login {

    function logar($db, $usuario, $senha) {
        $credenciais  = $db->prepare("
        SELECT usuario_login, usuario_senha
        FROM usuarios
        WHERE usuario_login = :u1
        AND usuario_senha = :u2
    ");
    $credenciais->bindParam(':u1', $usuario ,PDO::PARAM_STR);
    $credenciais->bindParam(':u2', $senha ,PDO::PARAM_STR);
    $credenciais->execute();
    $result = $credenciais->fetch(PDO::FETCH_ASSOC);
    $result2 = $credenciais->rowCount();
    $hash = password_hash($result['usuario_senha'], PASSWORD_ARGON2I);

        if($result2 > 0) {
            if (password_verify($senha, $hash)) {
            self::Auth($usuario,$hash,$db);
            } else {
        echo "senha errada!";
            }
                } else {
            echo "usuario não existe";
        }
    }

    private static function Auth($usuario,$hash,$db) {
    session_start();
    $credenciais  = $db->prepare("
        UPDATE usuarios 
        SET usuario_hash = :u1
        WHERE usuario_login = :u2
    ");
    $credenciais->bindParam(':u1', $hash ,PDO::PARAM_STR);
    $credenciais->bindParam(':u2', $usuario ,PDO::PARAM_STR);
    $credenciais->execute();
    $_SESSION['AuthBear'] = $hash;
    header('location: index.php');
    }

    

}

?>