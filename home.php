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
                        $select = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo!=4 ORDER BY Curtidas DESC LIMIT 10");
                        $cont = 1;
                        
                        while($arte = mysqli_fetch_array($select)){
                            if ($cont == 1) $carousel_item = 'carousel-item active';
                            else $carousel_item = 'carousel-item';

                            echo "<div class='$carousel_item'>
                                    <form action='home.php' method='post'>
                                        <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                            <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                            <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                <h3>".$arte['TituloArte']."</h3> 
                                                <p>TOP $cont</p>
                                            </div>
                                        </button>
                                    </form>
                                </div>";
                            
                            $cont ++;
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
                        $select = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo=1 ORDER BY Curtidas DESC LIMIT 10");
                        $cont = 1;

                        while($arte = mysqli_fetch_array($select)){
                            if ($cont == 1) $carousel_item = 'carousel-item active';
                            else $carousel_item = 'carousel-item';

                            echo "<div class='$carousel_item'>
                                    <form action='home.php' method='post'>
                                        <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                            <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                            <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                <h3>".$arte['TituloArte']."</h3> 
                                                <p>TOP $cont</p>
                                            </div>
                                        </button>
                                    </form>
                                </div>";
                            
                            $cont ++;
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
                        $select = mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdTipo=3 ORDER BY Curtidas DESC LIMIT 10");
                        $cont = 1;

                        while($arte = mysqli_fetch_array($select)){
                            if ($cont == 1) $carousel_item = 'carousel-item active';
                            else $carousel_item = 'carousel-item';

                            echo "<div class='$carousel_item'>
                                    <form action='home.php' method='post'>
                                        <button class='descricao' type='submit' name='desc".$arte['IdArte']."' style='float: none;'>
                                            <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                            <div class='carousel-caption' style='text-shadow: 1px 1px 2px #073763;'> 
                                                <h3>".$arte['TituloArte']."</h3> 
                                                <p>TOP $cont</p>
                                            </div>
                                        </button>
                                    </form>
                                </div>";
                            
                            $cont ++;
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

                if (isset($_POST["curt$i"])){
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
                    
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte='$i'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
                }
            } 

            if(isset($_POST['voltar'])){
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
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
            }
        
            if(isset($_POST['excluir_coment'])) { 
                mySqli_query($conexao, "DELETE FROM artes_comentarios WHERE IdComentario=".$_SESSION['IdComentario']."");
                
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
            }
        ?>   

        <div class="modal" id="descricao_arte" role="dialog">
            <?php include('html/modal_artes.php');?>
        </div>

        <div class="modal fade" id="excluir_coment" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Comentario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <?php echo "<form action='".$pag."' method='post'>"; ?>
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