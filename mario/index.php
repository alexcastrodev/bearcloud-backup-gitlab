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

	# Conexão com o banco de dados
	$db = Database::conexao();

	# Carregar Sessão
	session_start();
	$hash = $_SESSION['AuthBear'];

	$secure = new Seguranca();
	$secure->Logs($hash, $db);	
?>


Bem vindo,<p style="font-weight:bold;">ID:</p> <?php echo $hash ?>
