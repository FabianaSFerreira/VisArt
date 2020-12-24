<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['IdUsuario'];
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$usuario'"));
    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT SUM(Curtidas) AS curt FROM artes WHERE IdUsuario='$usuario'"));
    
    $maxUsuarios = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdUsuario) AS max FROM usuarios"));
    $maxU = (int) $maxUsuarios['max'];

    $maxGrupos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdGrupo) AS max FROM grupos"));
    $maxG = (int) $maxGrupos['max'];

    $maxMensagens = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdMensagem) AS max FROM grupos_mensagens"));
    $maxMsg = (int) $maxMensagens['max'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <meta charset="UFT-8">
    <title>VisArt</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
   
    <link rel="icon" href="Arquivos/VisArt/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>

<body>
    <header class="container-fluid"><br>
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">
            <a class="navbar-brand" href="home.php"> <img src="Arquivos/VisArt/marca.png" width="150" height="50"> </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Alterna navegação"><span class="navbar-toggler-icon"></span></button>

            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item"> <a class="nav-link" href="home.php">Home</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="galeria.php">Galeria</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="grupos.php">Grupos</a> </li>
                    <li class="nav-item"> <a class="nav-link" href="eventos.php">Eventos</a> </li>
                    <li class="nav-item">
                        <?php 
                            if ($usuario == "") { echo "<a class='nav-link' href='login.php'>Login</a>"; }
                            else { echo "<a class='nav-link active' href='perfil.php'>Perfil</a>"; }
                        ?>
                    </li>
                </ul>
                <form class="form-inline" id="buscar" action="galeria.php" method='post' align="rigth">
                    <input id="text_busca" type="text" name="texto" placeholder="Buscar artes" style="width: 90%;">
                    <button class="icon" type="submit" name="buscar" align="left" style="margin: 0; padding: 0; width: 10%;"> 
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                        </svg>
                    </button> 
                </form>  
            </div>  
        </nav><br>

        <?php 
            if ($_SESSION['IdPerfil'] != "") {
                $perfil_usuario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$i'"));

                echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="perfil">           
                        <div class="navbar-brand" id="img_perfil" style="width:-webkit-fill-available;"> 
                            <img src="'.$perfil_usuario['LocalFoto'].'" style="width:100%; height:100%;"><br> 
                            <label style="margin: 0; padding: 10px; float: left;">'.$perfil_usuario['nome'].'</label>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPerfil" aria-controls="navbarPerfil" aria-expanded="false" aria-label="Alterna navegação" style="margin: 0; padding: 10px; float: right;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/> </svg>
                            </button>
                        </div>
                            
                        <div class="collapse navbar-collapse" id="navbarPerfil" align="center">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item"> <a class="nav-link" href="minhas_artes.php">Portfólio</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="meus_grupos.php">Grupos</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="meus_grupos.php">Eventos</a> </li>
                            </ul>
                        </div>  
                    </nav>';
            }
            else {
                echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="perfil">           
                        <div class="navbar-brand" id="img_perfil" style="width:-webkit-fill-available;"> 
                            <img src="'.$select['LocalFoto'].'" style="width:100%; height:100%;"><br>
                            <label style="margin: 0; padding: 10px; float: left;">'.$select['nome'].'</label>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPerfil" aria-controls="navbarPerfil" aria-expanded="false" aria-label="Alterna navegação" style="margin: 0; padding: 10px; float: right;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/> </svg>
                            </button>
                        </div>
                            
                        <div class="collapse navbar-collapse" id="navbarPerfil" align="center">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item"> <a class="nav-link" href="minhas_artes.php">Portfólio</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="meus_grupos.php">Grupos</a> </li>
                                <li class="nav-item"> <a class="nav-link" href="meus_grupos.php">Eventos</a> </li><br>

                                <li class="nav-item"> <form action="perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="modalArte" value="Adicionar Arte"></form> </li>
                                <li class="nav-item"> <form action="perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="modalGrupo" value="Adicionar Grupo"></form> </li>
                                <li class="nav-item"> <form action="perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="modalEvento" value="Adicionar Evento"></form> </li><br>
                                
                                <li class="nav-item"> <a class="nav-link" href="notificacao.php">Notificações</a> </li>                    
                                <li class="nav-item"> <form action="perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="configuracoes" value="Configurações"></form> </li>
                            </ul>
                        </div>  
                    </nav>';
            }
        ?>
    </header>
    
    <section class="container-fluid">
        <div class="row" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxG; $i++) { 
                    $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT G.TituloGrupo, G.LocalImagem FROM grupos G JOIN grupos_usuarios GU ON G.IdGrupo = GU.IdGrupo WHERE G.IdGrupo='$i' AND GU.IdUsuario='$usuario' AND GU.solicitacao='0'"));
    
                    if ($grupo != "") {
                        echo "<form class='col-sm-3' action='meus_grupos.php' method='post'> <h5>".$grupo['TituloGrupo']." 
                                <button class='descricao' type='submit' name='botG".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle-fill' viewBox='0 0 16 16'> <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/> </svg>
                                </button>

                                <button class='descricao' type='submit' name='bp".$i."' data-title='Bate-Papo' style='float:left;'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-text-fill' viewBox='0 0 16 16'> <path d='M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z'/> </svg>
                                </button></h5>
                                 
                                <div id='grupo'> <img id='img_grupo' src='".$grupo['LocalImagem']."'> </div>
                            </form>"; 
                    } 
                }
            ?>
        </div>

        <?php
            if ($_SESSION['Alert'] != "") { 
                echo $_SESSION['Alert'];
                $_SESSION['Alert'] = ""; 
            }

            for ($j=1; $j <= $maxG; $j++) { 
                if (isset($_POST["botG$j"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo='$j'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";     
                }

                if (isset($_POST["bp$j"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo='$j'")); 
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>";     
                }
            } 

            for ($l=1; $l <= $maxU; $l++) { 
                if (isset($_POST["us$l"])) {
                    $_SESSION['IdUsGrupo'] = $l;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_usuario').modal('show'); }); </script>";      
                }
            } 

            if(isset($_POST['edt_grupo'])){
                $nome = $_POST["nome"];
                $status = (int) $_POST["status"];
                $descricao = $_POST["descricao"];
                
                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["new_imagem"]["name"], PATHINFO_EXTENSION);

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Grupos/";                
    
                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            mySqli_query($conexao, "UPDATE grupos SET LocalImagem='$pasta$novoNome', TituloGrupo='$nome' descricao='$descricao', status='$status' WHERE IdGrupo=".$_SESSION['IdGrupo']."");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                        }
                        else {
                            $_SESSION['Alert'] =  "<div id='alert'> <button type='button' class='close'>&times;</button><strong>Falha no Upload!</strong> Por favor, tente novamente.</div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] =  "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                    }
                } 
                else {
                    mySqli_query($conexao, "UPDATE grupos SET TituloGrupo='$nome' descricao='$descricao', status='$status' WHERE IdGrupo=".$_SESSION['IdGrupo']."");
                    
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>"; 
                }  
            } 

            if(isset($_POST['excluir_grupo'])) { 
                $delete = mySqli_query($conexao, "DELETE FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."");
                
                if ($delete != "") {
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Grupo deletado com sucesso!</strong> </div>"; 
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                }
            }

            if(isset($_POST['voltar_grupo'])) { 
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";
            } 

            if(isset($_POST['sair_grupo'])) { 
                $delete = mySqli_query($conexao, "DELETE FROM grupos_usuarios WHERE IdGrupo=".$_SESSION['IdGrupo']." AND IdUsuario='$usuario'");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
            }

            if(isset($_POST['excluir_usuario'])) {
                $delete = mySqli_query($conexao, "DELETE FROM grupos_usuarios WHERE IdUsuario=".$_SESSION['IdUsGrupo']." AND IdGrupo=".$_SESSION['IdGrupo']."");

                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";
            } 
        ?>  

        <?php
            for ($l=1; $l <= $maxMsg; $l++) { 
                if(isset($_POST["msg$l"])) { 
                    $_SESSION['IdMensagem'] = $l;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_mensagem').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['add_mensagem'])){
                $mensagem = $_POST['mensagem'];

                if ($mensagem != "") {
                    mySqli_query($conexao, "INSERT INTO grupos_mensagens(IdGrupo, IdUsuario, texto) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '$mensagem')");

                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>"; 
                }
            }

            if(isset($_POST['excluir_msg'])) { 
                mySqli_query($conexao, "DELETE FROM grupos_mensagens WHERE IdMensagem=".$_SESSION['IdMensagem']."");
                
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>";
            }

            if(isset($_POST['voltar_bp'])){
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>"; 
            }
        ?>  

        <div class='modal fade' id='descricao_grupo' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <?php echo "<h4 class='modal-title'>".$DadosGrupo['TituloGrupo']."</h4><br>";?>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>

                    <div class='modal-body' align="center">
                        <div class='row' style='width: -webkit-fill-available; margin: 10px 30px;'>
                            <?php
                                $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT administrador FROM grupos WHERE IdGrupo=".$DadosGrupo['IdGrupo']." AND administrador='$usuario'"));

                                if ($admin != "") {
                                    echo '<button class="descricao" type="button" data-toggle="modal" data-target="#editar_grupo" data-title="Editar" style="float:left;"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/> </svg>
                                        </button>
                
                                        <button class="descricao" type="button" data-toggle="modal" data-target="#excluir_grupo" data-title="Excluir" style="float:left;"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/> </svg>
                                        </button>';
                                }
                            ?>
                        </div>

                        <div class='row' align="center">  
                            <?php
                                if ($DadosGrupo['LocalImagem'] != ""){
                                    echo "<div id='descricao'> <img src='".$DadosGrupo['LocalImagem']."' style='width: -webkit-fill-available;'> </div><br>";
                                }
                                
                                echo "<button type='text'> Descrição: ".$DadosGrupo['descricao']." </button><br>";
                                echo "<button type='text'> Administrador: ".$us['Nome']." </button><br>";

                                if ($DadosGrupo['status'] == 'aberto') { echo "<button type='text'> Status: Aberto </button>"; }
                                else if ($DadosGrupo['status'] == 'fechado') { echo "<button type='text'> Status: Fechado </button>"; }

                                $UsGrupos = mySqli_query($conexao, "SELECT IdUsuario FROM grupos_usuarios WHERE IdGrupo=".$DadosGrupo['IdGrupo']." AND Solicitacao='0'");  

                                if ($admin != "") {
                                    echo "<div id='membros' style='width: -webkit-fill-available; margin: 25px;'> <label style='padding: inherit;'> Membros do grupo: </label>";
                                    while($us = mysqli_fetch_array($UsGrupos)) {
                                        $nome = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$us['IdUsuario'].""));

                                        if ($us['IdUsuario'] == $admin['administrador']) {
                                            echo "<button type='text' class='icon' style='width:70%; float: none; margin: 0px;'> ".$nome['Nome']." </button>";
                                        }
                                        else {
                                            echo "<form action='meus_grupos.php' method='post'>                                 
                                                    <button type='text' class='icon' style='width:70%; float: none; margin: 0px;'> ".$nome['Nome']." </button>
                                                    <button type='submit' class='icon' name='us".$us['IdUsuario']."' data-title='Excluir' style='margin: 0px;'> 
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/> </svg>
                                                    </button>                                                   
                                                </form>"; 
                                        }  
                                    }
                                    echo "</div>";
                                    
                                }
                                else {
                                    echo "<select id='descricao'> <option> Membros </option>"; 
                                    while($us = mysqli_fetch_array($UsGrupos)) {
                                        $nome = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$us['IdUsuario'].""));
                                        echo "<option>". $nome['Nome'] ."</option>"; 
                                    }
                                    echo "</select>";

                                    echo "<button type='button' data-toggle='modal' data-target='#sair_grupo' style='margin: auto;'> Sair do Grupo </button>";
                                }
                            ?>
                        </div>     
                    </div>

                    <div class='modal-footer'></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editar_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post' enctype="multipart/form-data">
                            <div class='form-group' align="center">
                                <div style="float: left;"><label> Imagem: </label></div>
                                <div><input type="file" name="new_imagem" style='width:-webkit-fill-available;'></div>

                                <div style="float: left;"><label> Nome: </label></div>
                                <div><?php echo "<input type='text' name='nome' value='".$DadosGrupo['TituloGrupo']."' style='width:-webkit-fill-available;'>";?></div>

                                <div style="float: left;"><label> Descrição: </label></div>
                                <div><?php echo "<textarea name='descricao' rows='3' style='width:-webkit-fill-available;'>".$DadosGrupo['descricao']."</textarea>";?></div>

                                <div style="float: left;"><label> Status: </label></div>
                                <div>
                                    <?php 
                                        echo "<select name='status' style='width:-webkit-fill-available;'>";
                                        if ($DadosGrupo['status'] == "aberto") { echo "<option value='1'> Aberto </option> <option value='2'> Fechado </option> </select>"; } 
                                        else { echo "<option value='2'> Fechado </option> <option value='1'> Aberto </option> </select>"; }   
                                    ?>
                                </div>

                                <div align="center"> <input type='submit' name='edt_grupo' value='Editar'> </div> 
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse grupo? </label> <br>
                                <input type='submit' name='excluir_grupo' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_grupo' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="sair_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sair do Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja sair do grupo? </label> <br>
                                <input type='submit' name='sair_grupo' value='Sair' style='width: 120px;'>
                                <input type='submit' name='voltar_grupo' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_usuario" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse usuário do grupo? </label> <br>
                                <input type='submit' name='excluir_usuario' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_grupo' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class='modal fade' id='bate_papo' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <?php echo "<h4 class='modal-title'> Bate-Papo - ".$DadosGrupo['TituloGrupo']."</h4>"; ?>                     
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>

                    <div class='modal-body'>
                        <div class='row' id="sala_BP">
                            <?php 
                                for ($l=$maxMsg; $l > 0; $l--) { 
                                    $mensagem = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario, texto FROM grupos_mensagens WHERE IdMensagem='$l' AND IdGrupo=".$DadosGrupo['IdGrupo'].""));                                               

                                    if ($mensagem != "") {
                                        $msg = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdMensagem FROM grupos_mensagens WHERE IdMensagem='$l' AND IdUsuario='$usuario'")); 
                                        $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$mensagem['IdUsuario'].""));

                                        if ($msg['IdMensagem'] != "") {
                                            echo "<form action='meus_grupos.php' method='post'>
                                                    <div id='mensagem' style='width:-webkit-fill-available; float:right; margin:10px;'>
                                                        <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$mensagem['texto']." </button>
                                                        <button type='submit' class='icon' name='msg".$l."' data-title='Excluir' style='margin: 5px;'> 
                                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/> </svg>
                                                        </button>
                                                    </div>
                                                    <p style='width:50%;float:right;margin: 0px 15px;text-align: right;'>".$us['Nome']."</p>
                                                </form>"; 
                                        }
                                        else {
                                            echo "<div>
                                                    <div id='mensagem' style='width:-webkit-fill-available; float:left; margin:10px;'> <button type='text' class='icon' style='width:70%; float:none; margin:5px;'> ".$mensagem['texto']." </button> </div>
                                                    <p style='width:50%;float:left;margin: 0px 15px;'>".$us['Nome']."</p>
                                                </div>"; 
                                        }  
                                    } 
                                } 
                            ?>
                        </div> 
                    </div>

                    <div class='modal-footer' style="justify-content: center;">
                        <form action='meus_grupos.php' method='post'>
                            <?php 
                                if ($usuario != "") {
                                    echo "<div class='form-group row align-items-center'>
                                            <textarea class='col-7' name='mensagem' rows='1' placeholder='Escrever mensagem'></textarea>
                                            <input class='col-3' type='submit' name='add_mensagem' value='Enviar' style='width: 100px;'>
                                        </div>";
                                }
                            ?>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_mensagem" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Mensagem</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir essa mensagem?</label> <br>
                                <input type='submit' name='excluir_msg' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_bp' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); });
        });
    </script>
    
    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <div class="row" >
            <div class="col-sm-4" style="padding: 10px 30px;"> 
                <label>Instituição</label>
                <p> Instituto federal de educação, ciência e tecnologia sul-rio-grandense, campus Gravataí - curso técnico em informática para internet.
                    Trabalho de conclusão de curso - Fabiana da Silveira Ferreira.</p>
            </div>

            <div class="col-sm-6" style="padding: 10px 30px;">
                <label>Conteúdo</label> 
                <p> Projeto voltado para a exposição de artes autorais de diferentes usuários, com o objetivo de incentivar o pensamento artístico, 
                    bem como proporcionar um espaço de integração e colaboração entre os usuários através da criação de grupos e salas de bate-papo, 
                    visando promover o aprendizado e a troca de ideias, além de propiciar visibilidade para todos os tipos de artistas.
                </p>
            </div>

            <div class="col-sm-2" style="padding: 10px 30px;"> 
                <div class="row">
                    <label>Redes Sociais</label>
                    <p style="font-size: 10px; padding: 5px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/> </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16"> <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/> </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16"> <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/> </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/> </svg>
                        <br>2020 VisArt
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>