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

    <link rel="icon" href="Arquivos/VisArt/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>

<body>
    <header class="container-fluid"><br>
        <div class="row" id="header">     
            <div class="col-sm-2" style="padding: 10px;" align="center"> <img src="Arquivos/VisArt/marca.png" class="img-responsive" width="150"> </div>
            
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
                    <input id="text_busca" type="text" name="texto" placeholder="Buscar artes" style="width: 80%">
                    <button class="icon" type="submit" name="buscar" style="margin: 0; padding: 0px 5px 5px;"> <span class="glyphicon glyphicon-search"></span> </button> 
                </form>
            </div>
        </div><br>
        <div class="row" id="titulo" style="padding: 10px;"> Grupos </div>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">
            <div class="col-sm-7" style="padding: 20px 25px;">
                <form id="buscar" action='grupos.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
        </div>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxG; $i++) { 
                    $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, imagem FROM grupos WHERE IdGrupo='$i'"));

                    if ($grupo != "") {
                        echo "<form action='grupos.php' method='post' class='bloco'>
                                <div class='col-sm-3'> 
                                    <h5>".$grupo['nome']." <button type='submit' name='bot".$i."' data-title='Descrição' class='descricao'> <span class='glyphicon glyphicon-option-vertical'></span> </button></h5> 
                                    <div id='grupo'> <img id='img_grupo' src='".$grupo['imagem']."'> </div>
                                </div>
                            </form>"; 
                    } 
                }
            ?>
        </div> 
        
        <?php 
            for ($i=1; $i <= $maxG; $i++) { 
                if (isset($_POST["bot$i"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, nome, administrador, status, descricao, imagem FROM grupos WHERE IdGrupo='$i'")); 
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";     
                }
            } 

            if(isset($_POST['solicitar'])) {
                mySqli_query($conexao, "INSERT INTO membros_grupo(IdGrupo, usuario, solicitacao) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '1')");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=grupos.php">'; 
            }  
            
            if(isset($_POST['entrar'])) {
                mySqli_query($conexao, "INSERT INTO membros_grupo(IdGrupo, usuario, solicitacao) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '0')");

                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, nome, administrador, status, descricao, imagem FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";    
            }
        ?>
        
        <div class='modal fade' id='descricao_grupo' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <?php echo "<h4 class='modal-title'>".$DadosGrupo['nome']."</h4>"; ?>
                    </div>

                    <div class='modal-body'>
                        <div class='row'> 
                            <div class='col-sm-6' align='center'>
                                <?php echo "<div id='descricao'> <img src='".$DadosGrupo['imagem']."'> </div>"; ?>
                            </div>

                            <div class='col-sm-6' align='center'>
                                <?php
                                    echo "<button type='text'> Descrição: ".$DadosGrupo['descricao']." </button><br>";
                                    echo "<button type='text'> Administrador: ".$DadosGrupo['administrador']." </button><br>";

                                    if ($DadosGrupo['status'] == 1) { echo "<button type='text'> Status: Aberto </button>"; }
                                    else if ($DadosGrupo['status'] == 2) { echo "<button type='text'> Status: Fechado </button>"; }

                                    echo "<select> <option> Membros </option>";      
                                    for ($i=1; $i <= $maxM; $i++) { 
                                        $membros = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario FROM membros_grupo WHERE IdMembro='$i' AND IdGrupo=".$DadosGrupo['IdGrupo']." AND Solicitacao='0'"));  
                                        if ($membros != "") { echo "<option>". $membros['usuario'] ."</option>"; }
                                    } echo "</select>";
                                ?>
                            </div>
                        </div>

                        <div class='row'> 
                            <form action='grupos.php' method='post'>
                                <div class='form-group' align='center'>
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
    </section>
    
    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); }); 
            
            $(".pesquisar").keyup(function(){
                var texto = $(this).val();
                
                $(".bloco").each(function(){
                    var resultado = $(this).text().toUpperCase().indexOf(' '+texto.toUpperCase());
                     
                    if(resultado < 0) { $(this).fadeOut(); }
                    else { $(this).fadeIn(); }
                }); 
            });
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
                <p> Sistema voltado para a exposição de trabalhos de diferentes artistas com o intuito de proporcionar um espaço de integração e colaboração entre os usuários. 
                    Assim sendo um espaço onde possam aprimorar e compartilhar suas habilidades artísticas, tornando-se, não somente um espaço para visibilidade, mas também para aprendizado.
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