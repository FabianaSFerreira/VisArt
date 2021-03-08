<?php 
    include_once("Conexao/conexao.php");
    session_start(); 

    $_SESSION['IdPerfil'] = "";
    $usuario = $_SESSION['IdUsuario']; 

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
        <?php include('html/header.php');?>
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Galeria </nav>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">     
            <div class="col-sm-7" style="padding: 20px 25px 0px 25px;">
                <form id="buscar" action='galeria.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
            
            <div class="col-sm-5" style="padding-top: 10px; padding-bottom: 10px;" align="right">
                <?php
                    echo "<form action='galeria.php' method='post'> 
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
                if(isset($_POST['tipo'])) {
                    $select = $_POST['tipo'];

                    if ($select == 0) {
                        for ($i=1; $i <= $maxA; $i++) { 
                            $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$i'"));
                            
                            if ($arte != "") {
                                echo "<form class='col-sm-4 bloco' action='galeria.php' method='post'> <h5> <span>".$arte['TituloArte']."</span>
                                        <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> 
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                        </button>";

                                if ($usuario != "") {
                                   echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> 
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/> </svg>
                                            <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label> 
                                        </button>";
                                } 

                                if ($arte['IdTipo'] == 4) { 
                                    echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'> </video> </div></form>";
                                }
                                else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'> </div></form>";}  
                            }                                  
                        }
                    }
                    else {
                        for ($j=1; $j <= $maxT; $j++) { 
                            if ($select == $j) {
                                for ($l=1; $l <= $maxA; $l++) { 
                                    $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$l' AND IdTipo='$j'"));
                                    
                                    if ($arte != "") {
                                        echo "<form class='col-sm-4 bloco' action='galeria.php' method='post'> <h5> <span>".$arte['TituloArte']."<span> 
                                                <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> 
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                                </button>";
                                        if ($usuario != "") {
                                           echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> 
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/> </svg>
                                                    <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label> 
                                                </button>";
                                        } 
        
                                        if ($arte['IdTipo'] == 4) { 
                                            echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'> </video> </div></form>";
                                        }
                                        else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'> </div></form>";}  
                                    }                    
                                }
                            }
                        } 
                    } 
                }
                else if(isset($_POST['buscar'])){
                    $texto = $_POST['texto'];

                    for ($i=1; $i <= $maxA; $i++) { 
                        $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$i' AND TituloArte LIKE '%$texto%'"));
                        
                        if ($arte != "") {
                            echo "<form class='col-sm-4 bloco' action='galeria.php' method='post'> <h5> <span>".$arte['TituloArte']."<span> 
                                    <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                    </button>";

                            if ($usuario != "") {
                               echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> 
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/> </svg>
                                        <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label> 
                                    </button>";
                            } 

                            if ($arte['IdTipo'] == 4) { 
                                echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'> </video> </div></form>";
                            }
                            else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'> </div></form>";}    
                        }                                    
                    }
                }
                else {
                    for ($i=1; $i <= $maxA; $i++) { 
                        $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$i'"));
                        
                        if ($arte != "") {
                            echo "<form class='col-sm-4 bloco' action='galeria.php' method='post'> <h5> <span>".$arte['TituloArte']."</span> 
                                    <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                    </button>";
                            
                            if ($usuario != "") {
                               echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> 
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/> </svg>
                                        <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label> 
                                    </button>";
                            } 

                            if ($arte['IdTipo'] == 4) { 
                                echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'></video> </div></form>";
                            }
                            else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'> </div></form>";}  
                        }                                    
                    }
                }   
            ?>
        </div>
        
        <?php 
            for ($i=1; $i <= $maxA; $i++) { 
                if (isset($_POST["desc$i"])) {
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte='$i'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    $_SESSION['IdArte'] = $DadosArte['IdArte'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
                }

                if (isset($_POST["curt$i"])){
                    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT curtidas FROM artes WHERE IdArte='$i'"));
                    $curtidas = (int) $curtidas['curtidas'];
    
                    $curt = $curtidas + 1;
                    $update = mySqli_query($conexao, "UPDATE artes SET curtidas='$curt' WHERE IdArte='$i'");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=galeria.php">';
                }
            } 

            for ($j=1; $j <= $maxC; $j++) { 
                if(isset($_POST["coment$j"])) { 
                    $_SESSION['IdComentario'] = $j;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_coment').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['add_coment'])){
                $comentario = $_POST['comentario'];

                if ($comentario != "") {
                    mySqli_query($conexao, "INSERT INTO artes_comentarios(IdUsuario, IdArte, texto) VALUES('$usuario', ".$_SESSION['IdArte'].", '$comentario')");

                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte']."")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
                }
            }

            if(isset($_POST['excluir_coment'])) { 
                mySqli_query($conexao, "DELETE FROM artes_comentarios WHERE IdComentario=".$_SESSION['IdComentario']."");
                
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
            }

            if(isset($_POST['voltar'])){
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
            }

            if(isset($_POST['curtir'])){
                $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $curtidas = (int) $curtidas['curtidas'];

                $curt = $curtidas + 1;
                $update = mySqli_query($conexao, "UPDATE artes SET curtidas='$curt' WHERE IdArte=".$_SESSION['IdArte']."");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=galeria.php">';
            }  
        ?>      

        <div class="modal" id="descricao_arte" role="dialog">   
            <div class="modal-dialog">  
                <div class="modal-content">
                    
                    <div class='modal-header'>
                        <?php echo "<h4 class='modal-title'>".$DadosArte['TituloArte']."</h4>"; ?>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>

                    <div class='modal-body'  align='center'>
                        <div class='row'> 
                            <?php 
                                if ($DadosArte['IdTipo'] == 4) { 
                                    echo "<div id='descricao'> <video id='img_arte' controls> <source src='".$DadosArte['LocalArquivo']."' type='video/mp4' style='width: -webkit-fill-available;'></video> </div>";
                                }
                                else {echo "<div id='descricao'> <img src='".$DadosArte['LocalArquivo']."' style='width: -webkit-fill-available;'> </div>";}  
                             
                                if ($usuario != "") {
                                    echo "<form action='galeria.php' method='post' style='margin-right: 30px; width: -webkit-fill-available;'>
                                            <button class='descricao' type='submit' name='curtir' data-title='curtir'> 
                                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> 
                                                    <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/>
                                                </svg> &nbsp".$DadosArte['Curtidas']."
                                            </button>
                                        </form>";
                                }

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
                                                    echo "<form action='galeria.php' method='post'>
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
                        <form action='galeria.php' method='post'>
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

        <div class="modal fade" id="excluir_coment" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Comentario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='galeria.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse comentario?</label> <br>
                                <input type='submit' name='excluir_coment' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar' value='Voltar' style='width: 120px;'>
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
        <?php include('html/footer.html');?>
    </footer>
</body>
</html>