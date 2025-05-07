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

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>teste</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<form action="teste.php" method="POST">
	Login: <input name="usuario" type="text" id="teste">
	<br><br>
	Senha: <input name="senha" type="text" id="teste">
	<button type="submit">entrar</button>
	</form>
</body>
</html>

