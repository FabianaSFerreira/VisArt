<?php
    if(isset($_COOKIE["usuario"])) {
        $usuario = $_COOKIE["usuario"];
        $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$usuario'"));
    } 
    else { $usuario = "";}
    
    $maxUsuarios = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdUsuario) AS max FROM usuarios"));
    $maxU = (int) $maxUsuarios['max'];


    $maxArtes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdArte) AS max FROM artes"));
    $maxA = (int) $maxArtes['max'];

    $maxTipos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdTipo) AS max FROM artes_tipos"));
    $maxT = (int) $maxTipos['max'];

    $maxComentarios = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdComentario) AS max FROM artes_comentarios"));
    $maxC = (int) $maxComentarios['max'];

    
    $maxGrupos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdGrupo) AS max FROM grupos"));
    $maxG = (int) $maxGrupos['max'];

    $maxMensagens = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdMensagem) AS max FROM grupos_mensagens"));
    $maxMsg = (int) $maxMensagens['max'];

    
    $maxEventos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdEvento) AS max FROM evento"));
    $maxE = (int) $maxEventos['max'];      

    
    $pag = basename($_SERVER['PHP_SELF']);
 
    if ($pag == "home.php") $pag = "home/home.php";
    else 
    if (($pag == "sign_in.php")) $pag = "sign/sign_in.php";
    else 
    if (($pag == "show_artes.php") || ($pag == "show_grupos.php") || ($pag == "show_eventos.php")) $pag = "show/$pag";
    else
    if (($pag == "perfil.php") || ($pag == "perfil_artes.php") || ($pag == "perfil_grupos.php") || ($pag == "perfil_eventos.php") || ($pag == "perfil_notificacao.php")) $pag = "perfil/$pag"; 
?>