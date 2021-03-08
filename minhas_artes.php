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
    <?php include('html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php 
            include('html/header.php');
            include('html/header_perfil.php');
        ?>  
    </header>
    
    <section class="container-fluid">
        <div class="row" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxA; $i++) { 
                    if($_SESSION['IdPerfil'] != "") {
                        $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdArte='$i' AND IdUsuario=".$_SESSION['IdPerfil'].""));
                    }
                    else { $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdArte='$i' AND IdUsuario='$usuario'"));}

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

            if(isset($_POST['curtir'])){
                $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $curtidas = (int) $curtidas['curtidas'];

                $curt = $curtidas + 1;
                $update = mySqli_query($conexao, "UPDATE artes SET curtidas='$curt' WHERE IdArte=".$_SESSION['IdArte']."");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
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

                                    if ($usuario != "") {
                                        echo "<form action='minhas_artes.php' method='post' class='col'>
                                                <button class='descricao' type='submit' name='curtir' data-title='curtir'> 
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> 
                                                        <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/>
                                                    </svg> &nbsp".$DadosArte['Curtidas']."
                                                </button>
                                            </form>";
                                    }
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

                                                if ($meu_coment != "") {
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
        <?php include('html/footer.html');?>
    </footer>
</body>
</html>