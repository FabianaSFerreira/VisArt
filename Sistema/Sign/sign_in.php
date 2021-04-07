<?php
    //Projeto VisArt - Trabalho de conclusão de curso
    //Autor: Fabiana da Silvaira Ferreira
    //Ano: 2020-2021


    include_once("../../Conexao/conexao.php");
    session_start(); 
    include('../../Conexao/max.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <?php include('../html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php include('../html/header.php');?>
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Login </nav>
    </header>
    
    <section class="container-fluid">
        <?php
            if(isset($_POST['logar'])){
                $usuario = $_POST["usuario"];
                $senha = md5($_POST["senha"]);

                $valida = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario FROM usuarios WHERE usuario='$usuario' AND senha='$senha'"));

                if ($valida == "") {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Usuário ou senha Incorreto! </strong> Por favor, tente novamente
                        </div>";          
                }
                else {   
                    $_SESSION['IdUsuario'] = $valida['IdUsuario'];
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=../home/home.php">'; 
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
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=sign_in.php">'; 
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
        
        <form action='sign_in.php' method='post'>
            <div class="form-group" align="center">
                <input type='text' name='usuario' placeholder='Usuario' required><br>
                <input type='password' name='senha' placeholder='Senha' required><br>
                <input type='submit' name='logar' value='Logar' style="background-image: radial-gradient(circle, #f9cb9c, #f0a963, #ff9900);">
            </div>
        </form>

        <div class="form-group" align="center">
            <button type="button" data-toggle="modal" data-target="#esqueceu_senha" style="background: none; border: 0; box-shadow: 0 0 0;"> Esqueceu sua senha? </button>
        </div> <br>

        <div align="center"> 
            <p>Voce não tem conta? <a style="box-shadow: none; padding: 0px;" href="sign_up.php">Cadastre-se</a></p> 
        </div>

        <div class="modal fade" id="esqueceu_senha" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Esqueceu sua senha?</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    </div>

                    <div class="modal-body">  
                            <form action='sign_in.php' method='post'>
                                <div class='form-group' align="center">                                     
                                    <input type='text' name='usuario' placeholder='Usuario'> <br>
                                    <input type='email' name='email' placeholder='Email'> <br>
                                    <input type='password' name='senha' placeholder='Nova Senha'> <br>
                                    <input type='password' name='con_senha' placeholder='Confirma Senha'> <br>
                                    <input type='submit' name='alt_senha' value='Alterar'> 
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
    
    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <?php include('../html/footer.html');?>
    </footer>
</body>
</html> 