<?php 
    include_once("conexao.php"); 
    session_start(); 

    $cont_tipo = mysqli_fetch_assoc(mySqli_query($conexao, "select count(*) as cont from tipoarte"));
    $conT = (int) $cont_tipo['cont'];
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

    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <header class="container-fluid"><br>
        <div class="row" id="header">     
            <div class="col-sm-2" style="padding: 10px;" align="center"> <img src="img/marca.png" class="img-responsive" width="150"> </div>
            
            <div class="col-sm-7" style="padding: 1.5% 1.5% 10px;" align="center">
                <a class="col-sm-2" href="home.php">Home</a>
                <a class="col-sm-2" href="galeria.php">Galeria</a>
                <a class="col-sm-2" href="grupos.php">Grupos</a>
                <?php 
                    if ($_SESSION['usuario'] == "usuario") { echo "<a class='col-sm-2' href='login.php'>Login</a>"; }
                    else { echo "<a class='col-sm-2' href='perfil.php'>Perfil</a>"; }
                ?>
            </div>

            <div class="col-sm-3" style="padding: 1.5% 1.5% 10px;" align="right">   
                <form id="buscar" action="galeria.php">
                    <input id="text_busca" type="text" name="nome" placeholder="Buscar ..." style="width: 80%">
                    <button class="buscar" type="submit" name="buscar" style="margin: 0; padding: 0px 5px 5px;"> <span class="glyphicon glyphicon-search"></span> </button> 
                </form>
            </div>
        </div><br>
        <div class="row" id="titulo" style="padding: 10px;"> Galeria </div>
    </header>
    
    <section class="container-fluid">
        <div class="row" style="padding: 10px;" align="right">     
            <div class="col-sm-5" style="padding: 10px;">
                <form id="buscar" action='galeria.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 70%;">      
                </form>
            </div>
            
            <div class="col-sm-7">
                <?php
                    echo "<form action='galeria.php' method='post'> <select name='tipo'> <option value='0'> Tipos </option>";      
                    for ($i=1; $i <= $conT; $i++) { 
                        $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "select nome from tipoarte where IdTipo='$i'"));  
                        echo "<option value='$i'>". $tipo['nome'] ."</option>";
                    } echo "</select></form>";
                ?>
            </div>    
        </div><br><br>
        
        <div class="row" id="filtro">
            <?php
                $select = $_POST['tipo'];
                echo $select;
                
                if ($select == 0) {
                    $cont_artes = mysqli_fetch_assoc(mySqli_query($conexao, "select count(*) as cont from artes"));
                    $conA = (int) $cont_artes['cont'];

                    for ($i=1; $i <= $conA; $i++) { 
                        $nome = mysqli_fetch_assoc(mySqli_query($conexao, "select nome_arte from artes where IdArte='$i'"));
                        $imagem = mysqli_fetch_object(mySqli_query($conexao, "select imagem from artes where IdArte='$i'"));
                        echo "<div class='col-sm-4'> <h4>". $nome['nome_arte'] ."</h4> <img src='galeria.php?id=".$i."' style='width:100%;'> </div>";                   
                    }
                }
                else {
                    for ($j=1; $j <= $conT; $j++) { 
                        if ($select == $j) {
                            $cont_artes = mysqli_fetch_assoc(mySqli_query($conexao, "select count(*) as cont from artes where tipo_arte='$j'"));
                            $conA = (int) $cont_artes['cont'];
        
                            for ($l=1; $l <= $conA; $l++) { 
                                $nome = mysqli_fetch_assoc(mySqli_query($conexao, "select nome_arte from artes where IdArte='$l'"));
                                $imagem = mysqli_fetch_object(mySqli_query($conexao, "select imagem from artes where IdArte='$l'"));
                                echo "<div class='col-sm-4'> <h4>". $nome['nome_arte'] ."</h4> <img src='galeria.php?id=".$l."' style='width:100%;'> </div>";                  
                            }
                        }
                    }
                }
            ?>
        </div><br><br> 

        <?php
            if(isset($_POST['anterior'])){
                
            }
            
            if(isset($_POST['proximo'])){
                
            }
        ?>
        
        <div class="row" style="padding: 15px;"> 
            <form action="galeria.php" method='post'>           
                <button class="col-sm-2 col-xs-5" type="submit" name="anterior" style="float: left;"> Anterior </button>
                <button class="col-sm-2 col-xs-5" type="submit" name="proximo" style="float: right;"> Próximo </button>
            </form>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); });
            
            $(".pesquisar").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#filtro *").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>

    <footer class="container-fluid">
        <div class="row" id="footer">
            <div class="col-sm-10"> <p>Instituto Federal Sul-rio-grandense - Campus Gravataí, Curso Técnico em Informética para a Internet. Trabalho de Conclusão de Curso - Fabiana da Silveira Ferreira </p> </div>
            <div class="col-sm-2" style="padding-top: 10px;"> <img src="img/marca.png" class="img-responsive" width="100" align="right"> </div>
        </div>
    </footer>
</body>
</html>