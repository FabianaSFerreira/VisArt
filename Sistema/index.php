<?php
	//Projeto VisArt - Trabalho de conclusão de curso
    //Autor: Fabiana da Silvaira Ferreira
    //Ano: 2020-2021

	
	session_start();
	
	$_SESSION['Alert'] = "";
	
	$_SESSION['IdArte'] = "";
	
	$_SESSION['IdGrupo'] = "";
	
	$_SESSION['IdEvento'] = "";

	$_SESSION['IdPerfil'] = "";

	$_SESSION['IdUsuario'] = "";

	$_SESSION['IdUsGrupo'] = "";

	$_SESSION['IdMensagem'] = ""; 

	$_SESSION['IdComentario'] = "";

	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home/home.php">'; 
?>