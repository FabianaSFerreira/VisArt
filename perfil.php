<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['IdUsuario'];

    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$usuario'"));
    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT SUM(Curtidas) AS curt FROM artes WHERE IdUsuario='$usuario'"));

    $maxUsuario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdUsuario) AS max FROM usuarios"));
    $maxU = (int) $maxUsuario['max'];

    $maxTipos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdTipo) AS max FROM artes_tipos"));
    $maxT = (int) $maxTipos['max'];

    $maxGrupos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdGrupo) AS max FROM grupos"));
    $maxG = (int) $maxGrupos['max'];

    $maxEventos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdEvento) AS max FROM evento"));
    $maxE = (int) $maxEventos['max'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <?php include('html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php include('html/header.php');?> 

        <?php
            for ($i=0; $i < $maxU; $i++) { 
                if (isset($_POST["perfil$i"]) && $i!=$usuario) {
                    $perfil_usuario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$i'")); 
                    $_SESSION['IdPerfil'] = $i; break;
                }
                else {
                    $perfil_usuario = "";
                    $_SESSION['IdPerfil'] = "";
                }
            }        
            
            if ($perfil_usuario != "") {
                echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="perfil">           
                        <div class="navbar-brand" id="img_perfil"> 
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
                                <li class="nav-item"> <a class="nav-link" href="meus_eventos.php">Eventos</a> </li>
                            </ul>
                        </div>  
                    </nav>';
            }  
            else {
                echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="perfil">           
                        <div class="navbar-brand" id="img_perfil"> 
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
                                <li class="nav-item"> <a class="nav-link" href="meus_eventos.php">Eventos</a> </li><br>

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
        <div class="modal fade" id="add_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Arte</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action='perfil.php' method='post' enctype="multipart/form-data" style="padding: 10px; width: -webkit-fill-available;">                                 
                                <div class='form-group' align="center" style='margin: 0;'>
                                    <div style="float: left;"><label> Imagem: </label></div><br>
                                    <div><input type="file" name="arquivo" style='width:-webkit-fill-available; overflow: hidden;'></div>
                                    
                                    <div style="float: left;"><label> Nome: </label></div><br>
                                    <div><input type='text' name='nome' placeholder='Título' style='width:-webkit-fill-available;' required></div>
                                    
                                    <div style="float: left;"><label> Tipo: </label></div><br>
                                    <div>
                                        <?php 
                                            echo "<select name='tipo' style='width:-webkit-fill-available;'>";      
                                            for ($i=1; $i <= $maxT; $i++) { 
                                                $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo=$i"));  
                                                echo "<option value='$i'>". $tipo['nome'] ."</option>";
                                            } echo "</select>";
                                        ?>
                                    </div>

                                    <div style="float: left;"><label> Descrição: </label></div>
                                    <div><textarea name="descricao" rows="3" placeholder='Escreva aqui...' style='width:-webkit-fill-available;' required></textarea></div>

                                    <div> <input type='submit' name='add_arte' value='Adicionar'> </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action='perfil.php' method='post' enctype="multipart/form-data" style="padding: 10px; width: -webkit-fill-available;">                                 
                                <div class='form-group' align="center" style='margin: 0;'> 
                                    <div style="float: left;"><label> Imagem: </label></div><br>
                                    <div><input type="file" name="imagem" style='width:-webkit-fill-available; overflow: hidden;'></div>
                                    
                                    <div style="float: left;"><label> Nome: </label></div><br>
                                    <div><input type='text' name='nome' placeholder='Título' style='width:-webkit-fill-available;' required></div>
                                    
                                    <div style="float: left;"><label> Status: </label></div><br>
                                    <div> <select name='status' style='width:-webkit-fill-available;'> <option value='aberto'> Aberto </option> <option value='fechado'> Fechado </option> </select></div>

                                    <div style="float: left;"><label> Descrição: </label></div><br>
                                    <div><textarea name="descricao" rows="3" placeholder='Escreva aqui...' style='width:-webkit-fill-available;' required></textarea></div>

                                    <div align="center"> <input type='submit' name='add_grupo' value='Adicionar'> </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_evento" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Adicionar Evento</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action='perfil.php' method='post' enctype="multipart/form-data" style="padding: 10px; width: -webkit-fill-available;">                                 
                                <div class='form-group' align="center" style='margin: 0;'> 
                                    <div style="float: left;"><label> Imagem: </label></div><br>
                                    <div><input type="file" name="imagem" style='width:-webkit-fill-available; overflow: hidden;'></div>
                                    
                                    <div style="float: left;"><label> Nome: </label></div><br>
                                    <div><input type='text' name='nome' placeholder='Título' style='width:-webkit-fill-available;' required></div>

                                    <div style="float: left;"><label> Descrição: </label></div><br>
                                    <div><textarea name="descricao" rows="3" placeholder='Escreva aqui...' style='width:-webkit-fill-available;' required></textarea></div>

                                    <div align="center"> <input type='submit' name='add_evento' value='Adicionar'> </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="configuracoes" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Configurações</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row" id="campo" style="margin: 0;">
                            <label style="width: 90%; text-align: left;"> Alterar Perfil </label>
                            <button type="button" class="alt_perfil"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"/></svg>
                            </button>
                            
                            <div class="form_perfil" style="width: -webkit-fill-available;">
                                <form action='perfil.php' method='post' enctype="multipart/form-data">
                                    <div class='form-group'> <br>
                                        <label style="float: left;"> Nome: </label>
                                        <?php echo "<input type='text' name='nome' value='".$select['nome']."' style='width:-webkit-fill-available;'>";?>
                                        
                                        <label style="float: left;"> Email: </label>
                                        <?php echo "<input type='email' name='email' value='".$select['email']."' style='width:-webkit-fill-available;'>";?>

                                        <label style="float: left;"> Imagem: </label>
                                        <input type="file" name="new_imagem" style='width:-webkit-fill-available; overflow: hidden;'>
                                        
                                        <div align="center"> <input type='submit' name='alt_perfil' value='Alterar' style='width: 120px;'> </div>
                                    </div>
                                </form>
                            </div>  
                        </div><br>

                        <div class="row" id="campo" style="margin: 0;">
                            <label style="width: 90%; text-align: left;"> Alterar Senha </label>
                            <button type="button" class="alt_senha"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-11.5.5a.5.5 0 0 1 0-1h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5z"/>></svg>
                            </button>
                            
                            <div class="form_senha" style="width: -webkit-fill-available;">
                                <form action='perfil.php' method='post'>
                                    <div class='form-group' align="center">
                                        <input type='password' name='senha' placeholder='Nova Senha' style='width:-webkit-fill-available;'> <br> 
                                        <input type='password' name='con_senha' placeholder='Confirma Senha' style='width:-webkit-fill-available;'> <br>
                                        <input type='submit' name='alt_senha' value='Alterar' style='width: 120px;'>
                                    </div>
                                </form>
                            </div>  
                        </div><br>

                        <div class="row" id="campo" style="margin: 0;">
                            <form action='perfil.php' method='post' style="width: -webkit-fill-available;">
                                <label style="width: 89%; text-align: left;"> Excluir Perfil </label>
                                <button class="icon" type="button" data-toggle="modal" data-target="#excluir_perfil" style="float: none;">  
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16"> 
                                    <path fill-rule="evenodd" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                                </button>
                            </form>  
                        </div> <br> 

                        <div class="row" id="campo" style="margin: 0;">
                            <form action='perfil.php' method='post' style="width: -webkit-fill-available;">
                                <label style="width: 89%; text-align: left;"> Sair </label>
                                <button class="sair" type="submit" name="sair" style="float: none;"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/></svg>
                                </button>
                            </form> 
                        </div>     
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_perfil" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Perfil</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='perfil.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir seu perfil? <br> Após a exclusão sua conta não poderá ser recuperada </label> <br>
                                <input type='submit' name='excluir_perfil' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='configuracoes' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        
        <?php
            if ($_SESSION['Alert'] != "") { 
                echo $_SESSION['Alert'];
                $_SESSION['Alert'] = ""; 
            }

            if(isset($_POST['modalArte'])) { 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#add_arte').modal('show'); }); </script>";
            } 

            if(isset($_POST['modalGrupo'])) { 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#add_grupo').modal('show'); }); </script>";
            } 

            if(isset($_POST['modalEvento'])) { 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#add_evento').modal('show'); }); </script>";
            } 

            if(isset($_POST['configuracoes'])) { 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#configuracoes').modal('show'); }); </script>";
            }
        ?>
        
        <?php    
            if(isset($_POST['add_arte'])){
                $nome = $_POST["nome"];
                $tipo = (int) $_POST["tipo"];
                $descricao = $_POST["descricao"];
                
                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif', 'mp4');
                $extensao = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);

                $NomeTipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo='$tipo'"));

                if(in_array($extensao, $formatosPermitidos)) {
                    $arquivo = $_FILES["arquivo"]["tmp_name"];
                    $novoNome = uniqid().".$extensao";
                    $pasta = "Arquivos/".$NomeTipo['nome']."/";

                    if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                        $inserir = mySqli_query($conexao, "INSERT INTO artes(IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao) values('$tipo', '$usuario', '$nome', '$pasta$novoNome', '$descricao')");
                        
                        if ($inserir != "") {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Arte adicionada com sucesso </strong> </div>";
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha ao Adicionar Arte!</strong> Por favor, tente novamente. </div>";
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                        } 
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload do Arquivo!</strong> Por favor, tente novamente. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }   
                }
                else {
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Arquivo inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'.</div>"; 
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                }
            }

            if(isset($_POST['add_grupo'])){
                $nome = $_POST["nome"];
                $status = $_POST["status"];
                $descricao = $_POST["descricao"];

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Grupos/";               

                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $inserir = mySqli_query($conexao, "INSERT INTO grupos(administrador, LocalImagem, TituloGrupo, descricao, status) values('$usuario', '$pasta$novoNome', '$nome', '$descricao', '$status')");
                            
                            if ($inserir != "") {
                                $maxG ++;
                                mySqli_query($conexao, "INSERT INTO grupos_usuarios(IdGrupo, IdUsuario, solicitacao) VALUES('$maxG', '$usuario', '0')");

                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Grupo adicionado com sucesso </strong> </div>";
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }
                            else {
                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha ao Adicionar Grupo!</strong> Por favor, tente novamente. </div>"; 
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }  
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload da Imagem!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                        }   
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'.</div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }
                }
                else {
                    $inserir = mySqli_query($conexao, "INSERT INTO grupos(administrador, TituloGrupo, descricao, status) values('$usuario', '$nome', '$descricao', '$status')");

                    if ($inserir != "") {
                        $maxG ++;
                        mySqli_query($conexao, "INSERT INTO grupos_usuarios(IdGrupo, IdUsuario, solicitacao) VALUES('$maxG', '$usuario', '0')");
                        
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Grupo adicionado com sucesso </strong> </div>";
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    } 
                }
            }

            if(isset($_POST['add_evento'])){
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Eventos/";               

                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $inserir = mySqli_query($conexao, "INSERT INTO evento(IdUsuario, LocalImagem, NomeEvento, descricao) values('$usuario', '$pasta$novoNome', '$nome', '$descricao')");
                            
                            if ($inserir != "") {
                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Evento adicionado com sucesso </strong> </div>";
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }
                            else {
                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha ao Adicionar Evento!</strong> Por favor, tente novamente. </div>"; 
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }  
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload da Imagem!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                        }   
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'.</div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }
                }
                else {
                    $inserir = mySqli_query($conexao, "INSERT INTO evento(IdUsuario, NomeEvento, descricao) values('$usuario', '$nome', '$descricao')");

                    if ($inserir != "") {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Evento adicionado com sucesso </strong> </div>";
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    } 
                }
            }

            if(isset($_POST['alt_perfil'])){
                $alt_nome = $_POST["nome"];
                $alt_email = $_POST["email"];

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["new_imagem"]["name"], PATHINFO_EXTENSION);

                if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $alt_email)){
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>E-mail Inválido! </strong> Por favor, insira um endereço de e-mail válido.</div>";
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                }
                else {
                    $update = mySqli_query($conexao, "UPDATE usuarios SET nome='$alt_nome', email='$alt_email' WHERE IdUsuario='$usuario';");
                    
                    if ($update != "") {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Dados do perfil alterados com sucesso </strong> </div>";
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }
                } 

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Perfil/";                
    
                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $update = mySqli_query($conexao, "UPDATE usuarios SET LocalFoto='$pasta$novoNome' WHERE IdUsuario='$usuario';");
                            
                            if ($update != "") {
                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Dados do perfil alterados com sucesso </strong> </div>";
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload da Imagem!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'.</div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }
                }  
            }

            if(isset($_POST['alt_senha'])){
                $alt_senha = $_POST["senha"];
                $con_senha = $_POST["con_senha"];

                if (($alt_senha != "") && ($con_senha != "") && ($alt_senha == $con_senha)) {
                    $update = mySqli_query($conexao, "UPDATE usuarios SET senha= MD5('$alt_senha') WHERE IdUsuario='$usuario';");
                    
                    if ($update != "") {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Senha alterada com sucesso </strong> </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';  
                    }  
                }
                else {
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Falha ao alterar senha! </strong> </div>"; 
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                }   
            } 

            if(isset($_POST['excluir_perfil'])) { 
                $_SESSION['IdUsuario'] = "";
                
                mySqli_query($conexao, "DELETE FROM usuarios WHERE IdUsuario='$usuario';"); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">';
            }

            if(isset($_POST['sair'])){
                $_SESSION['IdUsuario'] = "";
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
            }
        ?>
    </section>

    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); });

            $(".form_perfil").hide();
            $(".form_senha").hide();
           
            $(".alt_perfil").click(function(){ $(".form_perfil").toggle(); });        
            $(".alt_senha").click(function(){ $(".form_senha").toggle(); });
        });
    </script>
    
    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <?php include('html/footer.html');?>
    </footer>
</body>
</html>