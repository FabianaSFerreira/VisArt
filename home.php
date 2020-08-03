<?php 
    include_once("Conexao/conexao.php");
    session_start(); 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <meta charset="UFT-8">
    <title>VisArt</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="icon" href="Arquivos/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>

<body>
    <header class="container-fluid"><br>
        <div class="row" id="header">     
            <div class="col-sm-2" style="padding: 10px;" align="center"> <img src="Arquivos/marca.png" class="img-responsive" width="150"> </div>
            
            <div class="col-sm-7" style="padding: 1.5% 1.5% 10px;" align="center">
                <a class="col-sm-2" href="home.php">Home</a>
                <a class="col-sm-2" href="galeria.php">Galeria</a>
                <a class="col-sm-2" href="grupos.php">Grupos</a>
                <?php 
                    if ($_SESSION['usuario'] == "") { echo "<a class='col-sm-2' href='login.php'>Login</a>"; }
                    else { echo "<a class='col-sm-2' href='perfil.php'>Perfil</a>"; }
                ?>
            </div>

            <div class="col-sm-3" style="padding: 1.5% 1.5% 10px;" align="right">   
                <form id="buscar" action="galeria.php" method='post'>
                    <input id="text_busca" type="text" name="texto" placeholder="Buscar ..." style="width: 80%">
                    <button class="icon" type="submit" name="buscar" style="margin: 0; padding: 0px 5px 5px;"> <span class="glyphicon glyphicon-search"></span> </button> 
                </form>
            </div>
        </div><br>
        <div class="row" id="titulo" style="padding: 10px;"> Top 10 da semana </div>
    </header>
    
    <section class="container-fluid" align="center">
        <div style="padding-left: 10%; padding-right: 10%; margin:10px;" align="center">
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
                
                <div class="carousel-inner">           
                    <?php
                        echo"<div class='item active'>
                                <img src='img/carosel/1.jpg' style='width:100%;'>
                                <div class='carousel-caption'> <h3>Top 1</h3> </div>
                            </div>";
                    
                            for ($i=2; $i <= 10; $i++) { 

                            $img = mySqli_query($conexao, "select imagem from artes where IdArte='$i'");

                            echo"<div class='item'>
                                    <img src='img/carosel/2.jpg' style='width:100%;'>
                                    <div class='carousel-caption'> <h3>Top $i</h3> </div>
                                </div>";
                        }    
                    ?>
                </div>

                <a class="left carousel-control" href="#Carousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a>
                <a class="right carousel-control" href="#Carousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a>
            </div>
        </div>

        <div class="modal fade" id="descricao" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Descrição</h4>
                    </div>

                    <div class="modal-body">
                        
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
        <div class="row" id="footer">
            <div class="col-sm-10"> <p>Instituto Federal Sul-rio-grandense - Campus Gravataí, Curso Técnico em Informética para a Internet. Trabalho de Conclusão de Curso - Fabiana da Silveira Ferreira </p> </div>
            <div class="col-sm-2" style="padding-top: 10px;"> <img src="Arquivos/marca.png" class="img-responsive" width="100" align="right"> </div>
        </div>
    </footer>
</body>
</html>