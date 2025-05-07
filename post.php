<?php

/*

@author: Alexandro Castro
@sistema: Bear Software

*/
	# Carregar bibliotecas
	require 'config.php';
	require 'autoload.php';
	Autoload::Carregar();

	# Dependências
	use Bear\Layout\Template;
	use Bear\Banco\Database;
	use Bear\Security\Seguranca;
		
	# Conexão com o banco de dados
	$db = Database::conexao();

	$template = new Template();
	$template->assign( 'titulo', Template::informacao($db, $dado = 'titulo') );
	$template->assign( 'caminho', 'template/'.Template::informacao($db, $dado = 'template').DIRECTORY_SEPARATOR );
	$template->parse(Template::diretorio($db,$raiz).'post.html');
	
?>