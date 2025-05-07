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
	use Bear\Perfil\Usuarios;
	use Bear\Analytics\Analises;
		
	# Conexão com o banco de dados
	$db = Database::conexao();

	# Carregar Sessão
	session_start();
	$user = $_SESSION['AuthBear'];

	$status = new Seguranca();
	$status->verificacao_login($user, $db);



	$template = new Template();
	$template->assign( 'titulo', Template::informacao($db, $dado = 'titulo') );
	$template->assign( 'posts_mais_visitados', Analises::posts_visitados($db, $dado = 'post_nome'));
	$template->assign( 'posts_mais_visitados_qnt', Analises::posts_visitados($db, $dado = 'TOTAL'));
	$template->assign( 'posts_ativos', Analises::posts_ativos($db));
	$template->assign( 'caminho', 'template/'.Template::informacao($db, $dado = 'template').DIRECTORY_SEPARATOR );
	$template->assign( 'uploads_perfil', Usuarios::perfil_img($db,$user));
	$template->assign( 'usuario', Usuarios::perfil($db,$user,$dado = 'usuario_login'));
	$template->parse(Template::diretorio($db,$raiz).'home.html');
	
?>