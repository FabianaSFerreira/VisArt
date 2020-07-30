<?php
	session_start();
	
	$_SESSION['usuario'] = "";
	$_SESSION['IdGrupo'] = "";
	$_SESSION['IdArte'] = "";
	$_SESSION['IdComentario'] = "";
	$_SESSION['Alert'] = "";

	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
?>