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

        <div class="row" id="titulo" style="padding: 10px;"> Login </div>
    </header>
    
    <section class="container-fluid">
        <?php
            if(isset($_POST['logar'])){
                $usuario = $_POST["usuario"];
                $senha = $_POST["senha"];
                
                mySqli_query($conexao, "DELIMITER $ DROP FUNCTION IF EXISTS `fun_valida_usuario`$  
                CREATE FUNCTION `fun_valida_usuario`(p_login VARCHAR(20), p_senha VARCHAR(50) ) RETURNS INT(1) BEGIN DECLARE l_ret INT(1) DEFAULT 0;  
                SET l_ret = IFNULL((SELECT DISTINCT 1 FROM usuarios WHERE usuario = p_usuario AND senha = MD5(p_senha)),0);                           
                RETURN l_ret; END$ DELIMITER;");
                
                $valida = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT fun_valida_usuario('$usuario','$senha') as Validou"));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario FROM usuarios WHERE Usuario='$usuario'"));

                if ($valida['Validou'] == "") {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Usuário ou senha Incorreto! </strong> Por favor, tente novamente
                        </div>";          
                }
                else {    
                    $_SESSION['IdUsuario'] = $us['IdUsuario'];
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
                }
            }

            if(isset($_POST['alt_senha'])){
                $usuario = $_POST["usuario"];
                $email = $_POST["email"];
                $nov_senha = $_POST["senha"];
                $con_senha = $_POST["con_senha"];

                if (($usuario != "") && ($email != "") && ($nov_senha != "") && ($con_senha != "") && ($nov_senha == $con_senha)) {
                    $update = mySqli_query($conexao, "UPDATE usuarios SET senha= MD5('$nov_senha') WHERE usuario='$usuario' AND email='$email';");

                    if ($update != "") {
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=login.php">'; 
                    }
                    else {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Erro ao alterar senha.</strong> Verifique se o nome de usuario e email estão cadastrados.
                            </div>";  
                    }
                }  
            }
        ?> <br>
        
        <form action='login.php' method='post'>
            <div class="form-group" align="center">
                <input type='text' name='usuario' placeholder='Usuario' required><br>
                <input type='password' name='senha' placeholder='Senha' required><br>
                <input type='submit' name='logar' value='Logar'>
            </div>
        </form>

        <div class="form-group" align="center">
            <button type="button" data-toggle="modal" data-target="#esqueceu_senha" style="background: none; border: 0; box-shadow: 0 0 0;"> Esqueceu sua senha? </button>
        </div> <br>

        <div class="row" align="center"> 
            <p>Voce não tem conta? <a style="box-shadow: none; padding: 0px;" href="cadastro.php">Cadastre-se</a></p> 
        </div>

        <div class="modal fade" id="esqueceu_senha" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Esqueceu sua senha?</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">     
                            <form action='login.php' method='post'>
                                <div class='form-group' align="center">                                     
                                    <input type='text' name='usuario' placeholder='Usuario'> <br>
                                    <input type='email' name='email' placeholder='Email'> <br>
                                    <input type='password' name='senha' placeholder='Nova Senha'> <br>
                                    <input type='password' name='con_senha' placeholder='Confirma Senha'> <br>
                                    <input type='submit' name='alt_senha' value='Alterar'> 
                                </div>
                            </form>
                        </div>
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

