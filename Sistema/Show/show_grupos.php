<?php
    //Projeto VisArt - Trabalho de conclusão de curso
    //Autor: Fabiana da Silvaira Ferreira
    //Ano: 2020-2021


    include_once("../../Conexao/conexao.php");
    session_start(); 
    include('../../Conexao/max.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <?php include('../html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php include('../html/header.php');?>
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Grupos </nav>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">
            <div class="col-sm-7" style="padding: 20px 25px;">
                <form id="buscar" action='show_grupos.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
        </div>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxG; $i++) { 
                    $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT TituloGrupo, LocalImagem FROM grupos WHERE IdGrupo='$i'"));

                    if ($grupo != "") {
                        echo "<form class='col-sm-3 bloco' action='show_grupos.php' method='post'>
                                <h5> <span>".$grupo['TituloGrupo']."</span>                                   
                                <button class='descricao' type='submit' name='bot".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                </button></h5> 
                                <div id='grupo'> <img id='img_grupo' src='".$grupo['LocalImagem']."'> </div>
                            </form>"; 
                    } 
                }
            ?>
        </div> 
        
        <?php 
            for ($i=1; $i <= $maxG; $i++) { 
                if (isset($_POST["bot$i"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo='$i'")); 
                    $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                    $_SESSION['IdGrupo'] = $i;
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";     
                }
            } 

            if(isset($_POST['solicitar'])) {
                mySqli_query($conexao, "INSERT INTO grupos_usuarios (IdGrupo, IdUsuario, solicitacao) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '1')");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=show_grupos.php">'; 
            }  
            
            if(isset($_POST['entrar'])) {
                mySqli_query($conexao, "INSERT INTO grupos_usuarios (IdGrupo, IdUsuario, solicitacao) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '0')");

                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";    
            }
        ?>
        
        <div class='modal fade' id='descricao_grupo' role='dialog'>
            <?php include('../modal/modal_grupos.php');?>
        </div>
    </section>
    
    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); }); 
            
            $(".pesquisar").keyup(function(){
                var texto = $(this).val();
                
                $(".bloco").each(function(){
                    var nomeGrupo = $(this).find("span").text().toUpperCase()
                    var resultado = nomeGrupo.indexOf(texto.toUpperCase())
                     
                    if(resultado < 0) { $(this).hide(); }
                    else { $(this).show(); }
                }); 
            });
        });
    </script>

    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <?php include('../html/footer.html');?>
    </footer>
</body>
</html>