<?php

/*
@author: Alexandro Castro
@sistema: Bear Software

*/
	# Carregar bibliotecas
	require 'autoload.php';
	Autoload::Carregar();

	# Dependências
	use Bear\Banco\Database;
    use Bear\Security\Seguranca;
    use Bear\Security\Login;
		
	# Conexão com o banco de dados
    $db = Database::conexao();
    
    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);

    $login = new Login;
    $login->logar($db, $usuario,$senha)

    


?>