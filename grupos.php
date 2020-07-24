<?php 
    include_once("Conexao/conexao.php"); 
    session_start();
     
    $usuario = $_SESSION['usuario'];  
    
    $maxGrupos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdGrupo) AS max FROM grupos"));
    $maxG = (int) $maxGrupos['max'];
    
    $maxMembros = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdMembro) AS max FROM membros_grupo"));
    $maxM = (int) $maxMembros['max'];
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
        </div>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxG; $i++) { 
                    $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, imagem FROM grupos WHERE IdGrupo='$i'"));

                    if ($grupo != "") {
                        echo "<div class='col-sm-3'> 
                                <h5>".$grupo['nome']." 
                                    <button type='button' class='descricao' data-toggle='modal' data-target='#descricao_grupo".$i."'> 
                                        <span class='glyphicon glyphicon-option-vertical'></span> 
                                    </button>
                                </h5> 
                                <div id='grupo'> <img src='".$grupo['imagem']."'> </div>
                            </div>"; 
                    } 
                }
            ?>
        </div> 
        
        
        <?php 
            for ($i=1; $i <= $maxG; $i++) { 
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "Select IdGrupo, nome, administrador, status, descricao, imagem FROM grupos WHERE IdGrupo='$i'")); 
                

                if ($DadosGrupo != "") {
                    $IdGrupo = $DadosGrupo['IdGrupo'];
                
                    echo "";
            }}     
        ?>
        
        <div class='modal fade' id='descricao_grupo$i' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <?php echo "<h4 class='modal-title'>".$DadosGrupo['nome']."</h4>"; ?>
                    </div>

                    <div class='modal-body'>
                        <div class='row'> 
                            <div class='col-sm-6'>
                                <?php echo "<div id='arte'> <img src='".$DadosGrupo['imagem']."'> </div>"; ?>
                            </div>

                            <div class='col-sm-6'>
                                <?php
                                    echo "<button type='text'> Descrição: ".$DadosGrupo['descricao']." </button><br>";
                                    echo "<button type='text'> Administrador: ".$DadosGrupo['administrador']." </button><br>";

                                    if ($DadosGrupo['status'] == 1) { echo "<button type='text'> Status: Aberto </button>"; }
                                    else if ($DadosGrupo['status'] == 2) { echo "<button type='text'> Status: Fechado </button>"; }

                                    echo "<select> <option> Membros </option>";      
                                    for ($i=1; $i <= $maxM; $i++) { 
                                        $membros = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario FROM membros_grupo WHERE IdMembro='$i' AND Grupo='$IdGrupo' AND Solicitacao='1'"));  
                                        if ($membros != "") { echo "<option>". $membros['usuario'] ."</option>"; }
                                    } echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class='row'> 
                            <form action='grupos.php' method='post'>
                                <div class='form-group' align='center'>";
                                    <?php
                                        if ($usuario != "") {
                                            if ($DadosGrupo['status'] == 1) { echo "<input type='submit' name='entrar' value='Participar do grupo'>"; }
                                            else if ($DadosGrupo['status'] == 2) { echo "<input type='submit' name='solicitar' value='Enviar Solicitação'>"; }
                                        } 
                                    ?>
                                </div>
                            </form>
                        </div>     
                    </div>

                    <div class='modal-footer'></div>
                </div>
            </div>
        </div>

        <?php 
            if(isset($_POST['solicitar'])) {
                $inserir = mySqli_query($conexao, "INSERT INTO membros_grupo(grupo, usuario, solicitacao) VALUES('$IdGrupo', '$usuario', '1')");
            }  
            
            if(isset($_POST['entrar'])) {
                $inserir = mySqli_query($conexao, "INSERT INTO membros_grupo(grupo, usuario, solicitacao) VALUES('$IdGrupo', '$usuario', '0')");
            }    
        ?>
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
            <div class="col-sm-2" style="padding-top: 10px;"> <img src="Arquivos/marca.png" class="img-responsive" width="100" align="right"> </div>
        </div>
    </footer>
</body>
</html>