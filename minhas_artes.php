<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['IdUsuario'];
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$usuario'"));               
    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT SUM(Curtidas) AS curt FROM artes WHERE IdUsuario='$usuario'"));

    $maxTipos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdTipo) AS max FROM artes_tipos"));
    $maxT = (int) $maxTipos['max'];

    $maxArtes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdArte) AS max FROM artes"));
    $maxA = (int) $maxArtes['max'];

    $maxComentarios = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdComentario) AS max FROM artes_comentarios"));
    $maxC = (int) $maxComentarios['max'];
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
                for ($i=1; $i <= $maxA; $i++) { 
                    $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdArte='$i' AND IdUsuario='$usuario'"));
                    
                    if ($arte != "") {
                        echo "<form class='col-sm-4' action='minhas_artes.php' method='post'> <h5>".$arte['TituloArte']." 
                                <button type='submit' name='botA".$i."' class='descricao' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg> 
                                </button></h5>";
    
                        if ($arte['IdTipo'] == 4) { 
                            echo "<div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'></video> </div></form>";
                        }
                        else {echo "<div id='arte'> <img id='img_arte' src='".$arte['LocalArquivo']."'> </div></form>";}  
                    }                                      
                }   
            ?>
        </div>

        <?php   
            if ($_SESSION['Alert'] != "") { 
                echo $_SESSION['Alert'];
                $_SESSION['Alert'] = ""; 
            }      
            
            for ($j=1; $j <= $maxA; $j++) { 
                if (isset($_POST["botA$j"])) {
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte='$j'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    $_SESSION['IdArte'] = $DadosArte['IdArte'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['edt_arte'])){
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];
                $tipo = (int) $_POST["tipo"]; 

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif', 'mp4');
                $extensao = pathinfo($_FILES["new_arquivo"]["name"], PATHINFO_EXTENSION);
                $NomeTipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo='$tipo'"));

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_arquivo"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/".$NomeTipo['nome']."/";                 
    
                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            mySqli_query($conexao, "UPDATE artes SET IdTipo='$tipo', TituloArte='$nome', LocalArquivo='$pasta$novoNome', descricao='$descricao' WHERE IdArte=".$_SESSION['IdArte']."");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Arquivo inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                    }
                }
                else {
                    mySqli_query($conexao, "UPDATE artes SET IdTipo='$tipo', TituloArte='$nome', descricao='$descricao' WHERE IdArte=".$_SESSION['IdArte']."");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                }     
            }

            if(isset($_POST['excluir_arte'])) { 
                mySqli_query($conexao, "DELETE FROM artes WHERE IdArte=".$_SESSION['IdArte'].""); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
            }

            if(isset($_POST['voltar_arte'])) { 
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
            }
        ?>  

        <?php
            for ($l=1; $l <= $maxC; $l++) { 
                if(isset($_POST["coment$l"])) { 
                    $_SESSION['IdComentario'] = $l;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_coment').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['add_coment'])){
                $comentario = $_POST['comentario'];

                if ($comentario != "") {
                    mySqli_query($conexao, "INSERT INTO artes_comentarios (IdUsuario, IdArte, texto) VALUES('$usuario', ".$_SESSION['IdArte'].", '$comentario')");

                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte']."")); 
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
                }
            }

            if(isset($_POST['excluir_coment'])) { 
                mySqli_query($conexao, "DELETE FROM artes_comentarios WHERE IdComentario=".$_SESSION['IdComentario']."");
                
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
            }
        ?>

        <div class="modal" id="descricao_arte" role="dialog">   
            <div class="modal-dialog">  
                <div class="modal-content">
                    
                    <div class='modal-header'>
                        <?php echo "<h4 class='modal-title'>".$DadosArte['TituloArte']."</h4>"; ?>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>

                    <div class='modal-body' align='center'>
                        <div class='row'>                                
                            <div class='row' style='width: -webkit-fill-available; margin: 10px 30px;'>
                                <?php
                                    if (($usuario != "") && ($_SESSION['IdPerfil'] == "")) {  
                                        if($DadosArte['IdUsuario'] == $usuario) {
                                            echo '<button class="descricao col-1" type="button" data-toggle="modal" data-target="#editar_arte" data-title="Editar"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/> </svg>
                                                </button>
                        
                                                <button class="descricao col-1" type="button" data-toggle="modal" data-target="#excluir_arte" data-title="Excluir"> 
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/> </svg>
                                                </button>';
                                        }
                                    }

                                    echo "<button class='descricao col' type='submit' name='curtir' data-title='curtir' style='text-align: right;'> 
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> 
                                                <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/>
                                            </svg> &nbsp".$DadosArte['Curtidas']."
                                        </button>";
                                ?>
                            </div>

                            <?php
                                if ($DadosArte['IdTipo'] == 4) { 
                                    echo "<div id='descricao'> <video id='img_arte' controls> <source src='".$DadosArte['LocalArquivo']."' type='video/mp4' style='width: -webkit-fill-available;'></video> </div>";
                                }
                                else {echo "<div id='descricao'> <img src='".$DadosArte['LocalArquivo']."' style='width: -webkit-fill-available;'> </div>";}  
                                
                                echo "<form action='perfil.php' method='post' style='width: -webkit-fill-available; padding: 0px 15px;'>
                                            <input id='usuario' type='submit' name='perfil".$DadosArte['IdUsuario']."' value='Autor(a): ".$us['Nome']."' style='width: -webkit-fill-available; padding: 10px;'>
                                        </form>";

                                echo "<button type='text'> Descrição: ".$DadosArte['Descricao']." </button>"; 
                            ?>

                            <div class="row" id='descricao' style="margin-top: 20px;">
                                <label> Comentarios: </label><br>
                                
                                <div id='scroll_coment'>
                                    <?php 
                                        for ($i=1; $i <= $maxC; $i++) { 
                                            $comentario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario, texto FROM artes_comentarios WHERE IdComentario='$i' AND IdArte=".$DadosArte['IdArte'].""));                                               
                                            
                                            if ($comentario != "") {
                                                $meu_coment = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario FROM artes_comentarios WHERE IdComentario='$i' AND IdUsuario='$usuario'")); 

                                                if ($meu_coment['IdComentario'] != "") {
                                                    echo "<form action='minhas_artes.php' method='post'>
                                                            <div id='comentario'>
                                                                <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$comentario['texto']." </button>
                                                                <button type='submit' class='icon' name='coment".$i."' data-title='Excluir' style='margin: 5px; padding-top: 10px;'> 
                                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/> </svg>
                                                                </button>
                                                            </div>
                                                        </form>"; 
                                                }
                                                else {
                                                    echo "<div id='comentario'><button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$comentario['texto']." </button></div>"; 
                                                }  
                                            } 
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='modal-footer' style="justify-content: center;">
                        <form action='minhas_artes.php' method='post'>
                            <?php 
                                if ($usuario != "") {
                                    echo "<div class='form-group row align-items-center' style='flex-wrap: initial;'>
                                            <textarea class='col-7' name='comentario' rows='1' placeholder='Comente...'></textarea>
                                            <input class='col-3' type='submit' name='add_coment' value='Enviar'>
                                        </div>";
                                }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editar_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                <div class="modal-header">
                        <h4 class="modal-title">Editar Arte</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action='minhas_artes.php' method='post' enctype="multipart/form-data" style="padding: 10px; width: -webkit-fill-available;">                                 
                                <div class='form-group' align="center" style='margin: 0;'> 
                                    <div style="float: left;"><label> Imagem: </label></div>
                                    <div><input type="file" name="new_arquivo" style='width:-webkit-fill-available;'></div>
                                    
                                    <div style="float: left;"><label> Nome: </label></div>
                                    <div><?php echo "<input type='text' name='nome' value='".$DadosArte['TituloArte']."' style='width:-webkit-fill-available;'>";?></div>
                                    
                                    <div style="float: left;"><label> Tipo: </label></div>
                                    <div>
                                        <?php 
                                            $NomeTipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo=".$DadosArte['IdTipo'].""));
                                            
                                            echo "<select name='tipo' style='width:-webkit-fill-available;'> <option value=".$DadosArte['IdTipo'].">".$NomeTipo['nome']."</option>";      
                                            for ($i=1; $i <= $maxT; $i++) { 
                                                if ($i != $DadosArte['tipo']) {
                                                    $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo=$i"));  
                                                    echo "<option value='$i'>". $tipo['nome'] ."</option>";
                                                }  
                                            } echo "</select>";
                                        ?>
                                    </div>

                                    <div style="float: left;"><label> Descrição: </label></div>
                                    <div><?php echo "<textarea name='descricao' rows='3' style='width:-webkit-fill-available;'>".$DadosArte['Descricao']."</textarea>";?></div>

                                    <div> <input type='submit' name='edt_arte' value='Editar'> </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>         
        
        <div class="modal fade" id="excluir_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Arte</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='minhas_artes.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir essa arte? </label> <br>
                                <input type='submit' name='excluir_arte' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_arte' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_coment" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Comentario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='minhas_artes.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse comentario?</label> <br>
                                <input type='submit' name='excluir_coment' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_arte' value='Voltar' style='width: 120px;'>
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