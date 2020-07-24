<?php 
    include_once("Conexao/conexao.php");
    session_start(); 

    $maxTipos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdTipo) AS max FROM tipo_arte"));
    $maxT = (int) $maxTipos['max'];
    
    $maxArtes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdArte) AS max FROM artes"));
    $maxA = (int) $maxArtes['max'];
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
                <form id="buscar" action="galeria.php">
                    <input id="text_busca" type="text" name="nome" placeholder="Buscar ..." style="width: 80%">
                    <button class="icon" type="submit" name="buscar" style="margin: 0; padding: 0px 5px 5px;"> <span class="glyphicon glyphicon-search"></span> </button> 
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
                    echo "<form action='galeria.php' method='post'> <select name='tipo' onchange='this.form.submit()'> <option> Tipos </option> <option value='0'> Todos </option>";      
                    for ($i=1; $i <= $maxT; $i++) { 
                        $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome from tipo_arte where IdTipo='$i'"));  
                        echo "<option value='$i'>". $tipo['nome'] ."</option>";
                    } echo "</select></form>";
                ?>
            </div>    
        </div><br>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                if(isset($_POST['tipo'])) {
                    $select = $_POST['tipo'];

                    if ($select == 0) {
                        for ($i=1; $i <= $maxA; $i++) { 
                            $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, arquivo FROM artes WHERE IdArte='$i'"));
                            echo "<div class='col-sm-4'> 
                                    <h5>".$arte['nome']." <button type='button' class='descricao' data-toggle='modal' data-target='#descricao_arte'> <span class='glyphicon glyphicon-option-vertical'></span> </button></h5> 
                                    <div id='arte'> <img src='".$arte['arquivo']."'> </div>
                                </div>";                                    
                        }
                    }
                    else {
                        for ($j=1; $j <= $maxT; $j++) { 
                            if ($select == $j) {
                                for ($l=1; $l <= $maxA; $l++) { 
                                    $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, arquivo FROM artes WHERE IdArte='$l' AND tipo='$j'"));
                                    
                                    if ($arte != "") {
                                        echo "<div class='col-sm-4'> 
                                            <h5>".$arte['nome']." <button type='button' class='descricao' data-toggle='modal' data-target='#descricao_arte'> <span class='glyphicon glyphicon-option-vertical'></span> </button></h5> 
                                            <div id='arte'> <img src='".$arte['arquivo']."'> </div>
                                        </div>";
                                    }                   
                                }
                            }
                        } 
                    } 
                }
                else {
                    for ($i=1; $i <= $maxA; $i++) { 
                        $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, arquivo FROM artes WHERE IdArte='$i'"));
                        echo "<div class='col-sm-4'> 
                                <h5>".$arte['nome']." <button type='button' class='descricao' data-toggle='modal' data-target='#descricao_arte'> <span class='glyphicon glyphicon-option-vertical'></span> </button></h5> 
                                <div id='arte'> <img src='".$arte['arquivo']."'> </div>
                            </div>";                                    
                    }
                }
            ?>
        </div><br><br> 

        <div class="modal fade" id="descricao_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <?php $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT FROM artes WHERE IdArte='$IdArte'")); ?> 

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php echo "<h4 class='modal-title'>".$DadosArte['nome']."</h4>" ?>  
                    </div>

                    <div class="modal-body">
                        <div class="row"> 
                            <button class="icon" type="button" data-toggle="modal" data-target="#editar_arte"> <span class="glyphicon glyphicon-pencil"></span> </button>
                            <button class="icon" type="button" data-toggle="modal" data-target="#excluir_arte"> <span class="glyphicon glyphicon-lixo"></span> </button>
                        </div>

                        <div class="row"> 
                            <div class="col-sm-6">
                                <?php echo "<div id='arte'> <img src='".$DadosArte['arquivo']."'> </div>"; ?>
                            </div>

                            <div class="col-sm-6">
                                
                            </div>
                        </div>    
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

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
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });


        document.getElementById('tipo').addEventListener('change', function() { this.form.submit(); });
    </script>

    <footer class="container-fluid">
        <div class="row" id="footer">
            <div class="col-sm-10"> <p>Instituto Federal Sul-rio-grandense - Campus Gravataí, Curso Técnico em Informética para a Internet. Trabalho de Conclusão de Curso - Fabiana da Silveira Ferreira </p> </div>
            <div class="col-sm-2" style="padding-top: 10px;"> <img src="Arquivos/marca.png" class="img-responsive" width="100" align="right"> </div>
        </div>
    </footer>
</body>
</html>