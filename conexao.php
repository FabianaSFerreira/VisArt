<?php
	$host = "localhost";
	$usuario = "root";
	$senha = "";
	$db = "visart";
	$conexao = mysqli_connect($host, $usuario, $senha, $db);

	if (!$conexao){
		die("Algo deu errado: ".mysqli_connect_error());
	}
?>
