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
        <?php include('html/header.php');?>
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Top Artes </nav>
    </header>
    
    <section class="container-fluid" align="center">
        <div class="row" style="margin:10px;" align="center">
            <div id="Carousel" class="carousel slide col-12" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#Carousel" data-slide-to="1"></li>
                    <li data-target="#Carousel" data-slide-to="2"></li>
                    <li data-target="#Carousel" data-slide-to="3"></li>
                    <li data-target="#Carousel" data-slide-to="4"></li>
                    <li data-target="#Carousel" data-slide-to="5"></li>
                    <li data-target="#Carousel" data-slide-to="6"></li>
                    <li data-target="#Carousel" data-slide-to="7"></li>
                    <li data-target="#Carousel" data-slide-to="8"></li>
                    <li data-target="#Carousel" data-slide-to="9"></li>
                </ol>

                <div id='hanking' class="carousel-inner">           
                    <?php
                        $art = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo!=4 ORDER BY curtidas DESC LIMIT 1"));
                        $select = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo!=4 ORDER BY curtidas DESC LIMIT 10");
                        $cont = 2;

                        while($arte = mysqli_fetch_array($select)){
                            if ($art['IdArte'] == $arte['IdArte']) {
                                echo "<div class='carousel-item active'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                    <h3>".$arte['TituloArte']."</h3> 
                                                    <p>Top 1</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";
                            }
                            else {
                                echo "<div class='carousel-item'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                    <h3>".$arte['TituloArte']."</h3> 
                                                    <p>Top $cont</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";

                                $cont ++;
                            }
                        }
                    ?>
                </div>

                <a class="carousel-control-prev" href="#Carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#Carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Próximo</span>
                </a>
            </div>
            
            <div id="Carousel_Pintura" class="carousel slide col-6" data-ride="carousel">
                <h5> Top Pinturas </h5>
                <ol class="carousel-indicators">
                    <li data-target="#Carousel_Pintura" data-slide-to="0" class="active"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="1"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="2"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="3"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="4"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="5"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="6"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="7"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="8"></li>
                    <li data-target="#Carousel_Pintura" data-slide-to="9"></li>
                </ol>

                <div id='hanking' class="carousel-inner">           
                    <?php
                        $art = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo=1 ORDER BY curtidas DESC LIMIT 1"));
                        $select = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo=1 ORDER BY curtidas DESC LIMIT 10");
                        $cont = 2;

                        while($arte = mysqli_fetch_array($select)){
                            if ($art['IdArte'] == $arte['IdArte']) {
                                echo "<div class='carousel-item active'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                    <h3>".$arte['TituloArte']."</h3> 
                                                    <p>Top 1</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";
                            }
                            else {
                                echo "<div class='carousel-item'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                    <h3>".$arte['TituloArte']."</h3> 
                                                    <p>Top $cont</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";

                                $cont ++;
                            }
                        }
                    ?>
                </div>

                <a class="carousel-control-prev" href="#Carousel_Pintura" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#Carousel_Pintura" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Próximo</span>
                </a>
            </div>

            <div id="Carousel_Fotografia" class="carousel slide col-6" data-ride="carousel">
                <h5> Top Fotografias </h5>
                <ol class="carousel-indicators">
                    <li data-target="#Carousel_Fotografia" data-slide-to="0" class="active"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="1"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="2"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="3"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="4"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="5"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="6"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="7"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="8"></li>
                    <li data-target="#Carousel_Fotografia" data-slide-to="9"></li>
                </ol>

                <div id='hanking' class="carousel-inner">           
                    <?php
                        $art = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo=3 ORDER BY curtidas DESC LIMIT 1"));
                        $select = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo=3 ORDER BY curtidas DESC LIMIT 10");
                        $cont = 2;

                        while($arte = mysqli_fetch_array($select)){
                            if ($art['IdArte'] == $arte['IdArte']) {
                                echo "<div class='carousel-item active'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                    <h3>".$arte['TituloArte']."</h3> 
                                                    <p>Top 1</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";
                            }
                            else {
                                echo "<div class='carousel-item'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                    <h3>".$arte['TituloArte']."</h3> 
                                                    <p>Top $cont</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";

                                $cont ++;
                            }
                        }
                    ?>
                </div>

                <a class="carousel-control-prev" href="#Carousel_Fotografia" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#Carousel_Fotografia" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Próximo</span>
                </a>
            </div>
        </div> 

        <?php 
            for ($i=1; $i <= $maxA; $i++) { 
                if (isset($_POST["desc$i"])) {
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte='$i'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    $_SESSION['IdArte'] = $DadosArte['IdArte'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
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
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
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
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">';
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
                                    echo "<div id='descricao'> <video id='img_arte' controls> <source src='".$DadosArte['LocalArquivo']."' type='video/mp4'></video> </div>";
                                }
                                else {echo "<div id='descricao'> <img src='".$DadosArte['LocalArquivo']."'  style='width: -webkit-fill-available;'> </div>";}  
                             
                                if ($usuario != "") {
                                    echo "<form action='home.php' method='post' style='margin-right: 30px; width: -webkit-fill-available;'>
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
                                                    echo "<form action='home.php' method='post'>
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
                        <form action='home.php' method='post'>
                            <?php 
                                if ($usuario != "") {
                                    echo "<div class='form-group row align-items-center' style='flex-wrap: initial;'>
                                            <textarea class='col-7' name='comentario' rows='1' placeholder='Comente...'></textarea>
                                            <input class='col-3' type='submit' name='add_coment' value='Enviar' style='background: #ffffee;'>
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
                        <form action='home.php' method='post'>
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
        });

        $(function(){
            var scroll = document.getElementById("scroll_coment");
                scroll.scrollTop = scroll.scrollHeight;
        });
    </script>
    
    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <?php include('html/footer.html');?>
    </footer>
</body>
</html>