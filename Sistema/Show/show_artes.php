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
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Galeria </nav>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">     
            <div class="col-sm-7" style="padding: 20px 25px 0px 25px;">
                <form id="buscar" action='show_artes.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
            
            <div class="col-sm-5" style="padding-top: 10px; padding-bottom: 10px;" align="right">
                <?php
                    echo "<form action='show_artes.php' method='post'> 
                            <select name='tipo' onchange='this.form.submit()' style='width:-webkit-fill-available;'> 
                                <option style='display:none;'> Tipos de Arte </option> <option value='0'> Ver Todas </option>";      
                    for ($i=1; $i <= $maxT; $i++) { 
                        $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome from artes_tipos where IdTipo='$i'"));  
                        echo "<option value='$i'>". $tipo['nome'] ."</option>";
                    } 
                    echo "</select></form>";
                ?>
            </div>    
        </div>

        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                if (isset($_POST['tipo'])) {
                    $select = $_POST['tipo'];

                    if ($select == 0) {
                        $Arte = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes");                                 
                    }
                    else {
                        $Arte = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo='$select'");                    
                    } 
                }
                else if (isset($_POST['buscar'])){
                    $texto = $_POST['texto'];
                    $Arte = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE TituloArte LIKE '%$texto%'");                                    
                }
                else {
                    $Arte = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes");                                   
                } 
                
                while($arte = mysqli_fetch_array($Arte)) {
                    if ($arte != "") {
                        $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdArte) AS curt FROM artes_curtidas WHERE IdArte=".$arte['IdArte']." AND Curtida='1'"));

                        echo "<form class='col-sm-4 bloco' action='show_artes.php' method='post'> <h5> <span>".$arte['TituloArte']."</span> 
                                <button class='descricao' type='submit' name='desc".$arte['IdArte']."' data-title='Descrição'> 
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                </button>";
                        
                        if ($usuario != "") {
                           echo "<button class='descricao' type='submit' name='curtir".$arte['IdArte']."' data-title='Curtir' style='float:left;'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/> </svg>
                                    <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$curtidas['curt']."</label> 
                                </button>";
                        } 

                        if ($arte['IdTipo'] == 4) { 
                            echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'></video> </div></form>";
                        }
                        else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'> </div></form>";}  
                    }
                }
            ?>
        </div>
        
        <?php 
            for ($i=1; $i <= $maxA; $i++) { 
                if (isset($_POST["desc$i"])) {
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao FROM artes WHERE IdArte='$i'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    $_SESSION['IdArte'] = $DadosArte['IdArte'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
                }

                if (isset($_POST["curtir$i"]) || isset($_POST["curt$i"])){
                    $curtir = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte FROM artes_curtidas WHERE IdArte='$i' AND IdUsuario='$usuario' AND Curtida='0'"));
                    $descurtir = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte FROM artes_curtidas WHERE IdArte='$i' AND IdUsuario='$usuario' AND Curtida='1'"));

                    if ($curtir != "") {
                        mySqli_query($conexao, "UPDATE artes_curtidas SET Curtida='1' WHERE IdArte='$i' AND IdUsuario='$usuario'");
                    }
                    else if ($descurtir != "") {
                        mySqli_query($conexao, "DELETE FROM artes_curtidas WHERE IdArte='$i' AND IdUsuario='$usuario'");
                    }
                    else {
                        mySqli_query($conexao, "INSERT INTO artes_curtidas (IdArte, IdUsuario, Curtida) VALUES($i, '$usuario', '1')");
                    }              
        
                    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdArte) AS curt FROM artes_curtidas WHERE IdArte='$i' AND Curtida='1'"));
                    mySqli_query($conexao, "UPDATE artes SET Curtidas='".$curtidas['curt']."' WHERE IdArte='$i'");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=show_artes.php">';
                }
    
                if(isset($_POST["voltar_arte$i"])){
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao FROM artes WHERE IdArte='$i'"));
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
                }
            } 

            if(isset($_POST['add_coment'])){
                $comentario = $_POST['comentario'];
        
                if ($comentario != "") {
                    mySqli_query($conexao, "INSERT INTO artes_comentarios (IdUsuario, IdArte, texto) VALUES('$usuario', ".$_SESSION['IdArte'].", '$comentario')");
        
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao FROM artes WHERE IdArte=".$_SESSION['IdArte']."")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
                }
            }
        
            for ($l=1; $l <= $maxC; $l++) { 
                if(isset($_POST["coment$l"])) { 
                    $_SESSION['IdComentario'] = $l;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_coment').modal('show'); }); </script>";
                }

                if(isset($_POST["excluir_coment$l"])) { 
                    $IdArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte FROM artes_comentarios WHERE IdComentario='$l'"));
                    
                    mySqli_query($conexao, "DELETE FROM artes_comentarios WHERE IdComentario='$l'");
                    
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao FROM artes WHERE IdArte=".$IdArte['IdArte'].""));
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));

                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
                }
            } 
        ?>      

        <div class="modal" id="descricao_arte" role="dialog">   
            <?php include('../modal/modal_artes.php');?>
        </div>

        <div class="modal fade" id="excluir_coment" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Comentario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <?php echo "<form action='../".$pag."' method='post'>"; ?>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse comentario?</label> <br>
                                <?php
                                    echo "<input type='submit' name='excluir_coment".$_SESSION['IdComentario']."' value='Excluir' style='width: 120px;'>";
                                    echo "<input type='submit' name='voltar_arte".$_SESSION['IdArte']."' value='Voltar' style='width: 120px;'>";
                                ?>
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
            
            $(".pesquisar").keyup(function(){
                var texto = $(this).val();
                
                $(".bloco").each(function(){
                    var nomeArte = $(this).find("span").text().toUpperCase()
                    var resultado = nomeArte.indexOf(texto.toUpperCase())
                     
                    if(resultado < 0) { $(this).hide(); }
                    else { $(this).show(); }
                }); 
            });
        });

        $(function(){
            var scroll = document.getElementById("scroll_coment");
                scroll.scrollTop = scroll.scrollHeight;
        });

        document.getElementById('tipo').addEventListener('change', function() { this.form.submit(); });
    </script>

    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <?php include('../html/footer.html');?>
    </footer>
</body>
</html>