<?php 
    include_once("conexao.php"); 
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
        <div class="row" id="titulo" style="padding: 10px;"> Grupos </div>
    </header>
    
    <section class="container-fluid">
        <div class="row" style="padding: 10px;" align="right">
            <div class="col-sm-5" style="padding: 10px;">
                <form id="buscar" action='grupo.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 70%;">      
                </form>
            </div>
        </div><br><br>
        
        <div class="row" id="filtro">
            <?php
                $cont_grupo = mysqli_fetch_assoc(mySqli_query($conexao, "select count(*) as cont from grupo"));
                $cont = (int) $cont_grupo['cont'];

                for ($i=1; $i <= $cont; $i++) { 
                    $nome = mysqli_fetch_assoc(mySqli_query($conexao, "select nome from grupo where IdGrupo='$i'"));
                    $img = mysqli_fetch_assoc(mySqli_query($conexao, "select imagem from grupo where IdGrupo='$i'"));
                    echo "<div class='col-sm-4'> <h4>". $nome['nome'] ."</h4> <img src='".$img['imagem']."' style='width:100%;'> </div>";                 
                }
            ?>
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