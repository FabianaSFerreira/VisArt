<?php 
    include_once("Conexao/conexao.php");
    session_start(); 

    $usuario = $_SESSION['IdUsuario'];

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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   
    <link rel="icon" href="Arquivos/VisArt/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>

<body>
    <header class="container-fluid"><br>
        <div class="row" id="header">     
            <div class="col-sm-2" style="padding: 10px; margin-top: 10px;" align="center"> <img src="Arquivos/VisArt/marca.png" class="img-responsive" width="150"> </div>
            
            <div class="col-sm-10" style="padding: 1.5%" align="center">
                <a class="col-sm-2" style="margin-top: 10px;" href="home.php">Home</a>
                <a class="col-sm-2" style="margin-top: 10px;" href="galeria.php">Galeria</a>
                <a class="col-sm-2" style="margin-top: 10px;" href="grupos.php">Grupos</a>
                <?php 
                    if ($usuario == "") { echo "<a class='col-sm-2' style='margin-top: 10px;' href='login.php'>Login</a>"; }
                    else { echo "<a class='col-sm-2' style='margin-top: 10px;' href='perfil.php'>Perfil</a>"; }
                ?>

                <div class="col-sm-3" style="margin-top: 10px;" align="right">   
                    <form id="buscar" action="galeria.php" method='post'>
                        <input id="text_busca" type="text" name="texto" placeholder="Buscar artes" style="width: 80%">
                        <button class="icon" type="submit" name="buscar" style="margin: 0; padding: 0px 5px 5px;"> <span class="glyphicon glyphicon-search"></span> </button> 
                    </form>
                </div>
            </div>  
        </div><br>

        <div class="row" id="titulo" style="padding: 10px;"> Top Artes </div>
    </header>
    
    <section class="container-fluid" align="center">
        <div style="margin:10px;" align="center">
            <div id="Carousel" class="carousel slide" data-ride="carousel">
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
                                echo "<div class='item active'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption'> 
                                                    <h3>Top 1</h3> 
                                                    <p>".$arte['TituloArte']."</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";
                            }
                            else {
                                echo "<div class='item'>
                                        <form action='home.php' method='post'>
                                            <button class='descricao' type='submit' name='desc".$arte['IdArte']."'>
                                                <img id='img_hg' src='".$arte['LocalArquivo']."'>
                                                <div class='carousel-caption'> 
                                                    <h3>Top $cont</h3> 
                                                    <p>".$arte['TituloArte']."</p>
                                                </div>
                                            </button>
                                        </form>
                                    </div>";

                                $cont ++;
                            }
                        }
                    ?>
                </div>

                <a class="left carousel-control" href="#Carousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a>
                <a class="right carousel-control" href="#Carousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a>
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

        <div class="modal fade" id="descricao_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    
                    <div class='modal-header'>
                        <?php 
                            if ($usuario != "") {
                                echo "<form action='home.php' method='post'>
                                        <button class='descricao' type='submit' name='curtir' title='curtir' style='float:left;'> 
                                        <span class='glyphicon glyphicon-heart'> ".$DadosArte['Curtidas']."</span> </button>
                                    </form>";
                            }
                        ?>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <?php echo "<h4 class='modal-title'>".$DadosArte['TituloArte']."</h4>"; ?>
                    </div>

                    <div class='modal-body'>
                        <div class='row'> 
                            <div class='col-sm-6' align='center'>
                                <?php 
                                    if ($DadosArte['IdTipo'] == 4) { 
                                        echo "<div id='descricao'> <video id='img_arte' controls> <source src='".$DadosArte['LocalArquivo']."' type='video/mp4'></video> </div>";
                                    }
                                    else {echo "<div id='descricao'> <img src='".$DadosArte['LocalArquivo']."'> </div>";}  

                                    echo "<button type='text' style='width:250px;'> Autor(a): ".$us['Nome']." </button>
                                        <button type='text' style='width:250px;'> Descrição: ".$DadosArte['Descricao']." </button>"; 
                                ?>
                            </div>

                            <div class='col-sm-6' align='center'>
                                <label> Comentarios: </label><br>
                                
                                <div style="height: 280px; overflow-y: scroll;">
                                    <?php 
                                        for ($i=1; $i <= $maxC; $i++) { 
                                            $comentario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario, texto FROM artes_comentarios WHERE IdComentario='$i' AND IdArte=".$DadosArte['IdArte'].""));                                               
                                            
                                            if ($comentario != "") {
                                                $meu_coment = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario FROM artes_comentarios WHERE IdComentario='$i' AND IdUsuario='$usuario'")); 

                                                if ($meu_coment['IdComentario'] != "") {
                                                    echo "<form action='home.php' method='post'>
                                                            <div id='comentario'>
                                                                <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$comentario['texto']." </button>
                                                                <button type='submit' class='icon' name='coment".$i."' data-title='Excluir' style='margin: 5px;'> <span class='glyphicon glyphicon-trash'></span> </button>
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
                        
                        <div class='row'>
                            <form action='home.php' method='post'>
                                <?php 
                                    if ($usuario != "") {
                                        echo "<div class='form-group' align='center' id='comentario' style='margin: 25px;'>
                                                <textarea name='comentario' rows='1' placeholder='Escrever Comentario' class='icon' style='width:70%; float: left;'></textarea>
                                                <input type='submit' name='add_coment' value='Enviar' style='width: 100px;'>
                                            </div>";
                                    }
                                ?>
                            </form>
                        </div>
                    </div>

                    <div class='modal-footer'></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_coment" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Excluir Comentario</h4>
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
        });
    </script>
    
    <footer class="container-fluid">
        <div class="row">
            <div class="col-sm-4" style="padding: 10px 30px;"> 
                <label>Instituição</label>
                <p> Instituto Federal Sul-rio-grandense, Campus Gravataí - Curso Técnico em Informática para Internet.
                <br>Trabalho de Conclusão de Curso - Fabiana da Silveira Ferreira.</p>
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
                    <label>Redes Sociais</label><br>
                    <img src="Arquivos/VisArt/redes1.png" class="img-responsive col-xs-6" style="width: 45px; height: 45px; padding: 5px;">
                    <img src="Arquivos/VisArt/redes2.png" class="img-responsive col-xs-6" style="width: 45px; height: 45px; padding: 5px;">
                    <img src="Arquivos/VisArt/redes3.png" class="img-responsive col-xs-6" style="width: 45px; height: 45px; padding: 5px;">
                    <img src="Arquivos/VisArt/redes4.png" class="img-responsive col-xs-6" style="width: 45px; height: 45px; padding: 5px;">
                    <p class="col-xs-12" style="font-size: 10px; padding: 5px;"> 2020 VisArt - Fabiana Ferreira</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>