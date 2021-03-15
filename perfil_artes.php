<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 
    include('Conexao/max.php');
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
                        echo "<form class='col-sm-4' action='perfil_artes.php' method='post'> <h5>".$arte['TituloArte']." 
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
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_artes.php">';
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_artes.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Arquivo inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_artes.php">';
                    }
                }
                else {
                    mySqli_query($conexao, "UPDATE artes SET IdTipo='$tipo', TituloArte='$nome', descricao='$descricao' WHERE IdArte=".$_SESSION['IdArte']."");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_artes.php">';
                }     
            }

            if(isset($_POST['excluir_arte'])) { 
                mySqli_query($conexao, "DELETE FROM artes WHERE IdArte=".$_SESSION['IdArte'].""); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_artes.php">';
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
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_artes.php">';
            }  
        ?>

        <div class="modal" id="descricao_arte" role="dialog">   
            <?php include('html/modal_artes.php');?>
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