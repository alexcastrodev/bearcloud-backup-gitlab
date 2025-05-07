<?php

namespace Bear\perfil;

use PDO;

class Usuarios
{

    public static function perfil($db,$user,$dado) {
        $Perfil  = $db->prepare("
			SELECT usuario_login
			FROM usuarios
			WHERE usuario_hash = :u1
	");
		$Perfil->execute(array(':u1'=>$user));
        $uPerfil = $Perfil->fetch(PDO::FETCH_ASSOC);
        return $uPerfil[$dado];
    }

    public static function perfil_img($db,$user) {
        $Perfil  = $db->prepare("
			SELECT usuario_perfil_url
			FROM usuarios
			WHERE usuario_hash = :u1
	");
		$Perfil->execute(array(':u1'=>$user));
        $uPerfil = $Perfil->fetch(PDO::FETCH_ASSOC);
        $noIMG = 'perfil.jpg';
        if(empty($uPerfil['usuario_perfil_url'])) { return $noIMG; } else { return $uPerfil['usuario_perfil_url']; }
        
    }

}   