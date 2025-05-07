<?php

namespace Bear\Security;

use PDO;

class Seguranca {

    function verificacao_login($db, $hash) {
        if(!isset($_SESSION['AuthBear'])) {
            header('location: /login');
            exit();
        } else {

        }
    }
}

class Login {

    function logar($db, $usuario, $senha) {
        $credenciais  = $db->prepare("
        SELECT usuario_login, usuario_email, usuario_senha
        FROM usuarios
        WHERE usuario_login = :u1 OR usuario_email = :u2
        AND usuario_senha = :u3
    ");
    $credenciais->bindParam(':u1', $usuario ,PDO::PARAM_STR);
    $credenciais->bindParam(':u2', $usuario ,PDO::PARAM_STR);
    $credenciais->bindParam(':u3', $senha ,PDO::PARAM_STR);
    $credenciais->execute();
    $result = $credenciais->fetch(PDO::FETCH_ASSOC);
    $result2 = $credenciais->rowCount();
    $hash = password_hash($result['usuario_senha'], PASSWORD_ARGON2I);

        if($result2 > 0) {
            if (password_verify($senha, $hash)) {
            self::Auth($usuario,$hash,$db);
            } else {
            $retorno = array('codigo' => 0, 'mensagem' => 'Senha Incorreta');
            echo json_encode($retorno);
            }
            
        } else {
            $retorno = array('codigo' => 0, 'mensagem' => 'Este usuário não existe!');
            echo json_encode($retorno);
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
    $retorno = array('codigo' => 1, 'mensagem' => 'Validado!');
    echo json_encode($retorno);
    }

}

?>