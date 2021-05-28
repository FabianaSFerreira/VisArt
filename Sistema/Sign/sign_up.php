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
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Cadastro </nav>
    </header>
    
    <section class="container-fluid">
        <?php
            if(isset($_POST['cadastrar'])){
                $usuario = $_POST["usuario"];
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $senha = $_POST["senha"];
                $con_senha = $_POST["con_senha"];  
                
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario FROM usuarios WHERE usuario='$usuario'")); 

                if($us != "") {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Usuário Inválido! </strong> Esse nome de usuário já esta cadastrado.
                        </div>";           
                }
                else if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)){
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>E-mail Inválido! </strong> Por favor, insira um endereço de e-mail válido.
                        </div>";
                }
                else if($senha != $con_senha) {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Senha Inválida! </strong> Por favor, confirme sua senha.
                        </div>";
                }
                else {
                    $senha = md5($senha);
                    $inserir = mySqli_query($conexao, "INSERT INTO usuarios(usuario, nome, email, senha) VALUES('$usuario', '$nome', '$email', '$senha')");
                    
                    if ($inserir != "") {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Usuario cadastrado com sucesso! </strong>
                            </div>";
                    } else {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Erro ao cadastrar! </strong> Por favor, tente novamente.
                            </div>";
                    }
                }
            }
        ?> <br>

        <form action='sign_up.php' method='post'>
            <div class="form-group" align="center">
                <input type='text' name='nome' placeholder='Nome' required><br>
                <input type='text' name='usuario' placeholder='Usuario' required><br>
                <input type='email' name='email' placeholder='E-mail' required><br>
                <input type='password' name='senha' placeholder='Senha' required><br>
                <input type='password' name='con_senha' placeholder='Confirma Senha' required><br>
                <input type='submit' name='cadastrar' value='Cadastrar' style='background-image: radial-gradient(circle, #f9cb9c, #f0a963, #ff9900);'><br>
            </div>
        </form> <br>

        <div align="center"> 
            <p>Voce já tem conta?<a style="box-shadow: none; padding: 0px;" href="sign_in.php">Logue-se</a></p>
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