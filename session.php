<?php
	session_start();
	
	$_SESSION['Alert'] = "";
	
	$_SESSION['IdArte'] = "";
	
	$_SESSION['IdGrupo'] = "";
	
	$_SESSION['IdEvento'] = "";

	$_SESSION['IdUsuario'] = "1";

	$_SESSION['IdUsGrupo'] = "";

	$_SESSION['IdMensagem'] = ""; 

	$_SESSION['IdComentario'] = "";

	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
?>