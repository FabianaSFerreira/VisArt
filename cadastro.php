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
        <div class="row" id="titulo" style="padding: 10px;"> Cadastro </div>
    </header>
    
    <section class="container-fluid">
        <?php
            if(isset($_POST['cadastrar'])){
                $usuario = $_POST["usuario"];
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $senha = $_POST["senha"];
                $con_senha = $_POST["con_senha"];  
                
                $select = mysqli_fetch_assoc(mySqli_query($conexao, "select usuario from usuario where usuario='$usuario'")); 

                if($select["usuario"] != "") {
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
                    $inserir = mySqli_query($conexao, "insert into usuario(usuario, nome, email, senha) values('$usuario', '$nome', '$email', '$senha')");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">';
                }
            }
        ?> <br>

        <form action='cadastro.php' method='post'>
            <div class="form-group" align="center">
                <input type='text' name='nome' placeholder='Nome' required><br>
                <input type='text' name='usuario' placeholder='Usuario' required><br>
                <input type='email' name='email' placeholder='E-mail' required><br>
                <input type='password' name='senha' placeholder='Senha' required><br>
                <input type='password' name='con_senha' placeholder='Confirma Senha' required><br>
                <input type='submit' name='cadastrar' value='Cadastrar'><br>
            </div>
        </form> <br>

        <div class="row" align="center"> 
            <p>Voce já tem conta?<a style="box-shadow: none; padding: 0px;" href="login.php">Logue-se</a></p>
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
            <div class="col-sm-2" style="padding-top: 10px;"> <img src="img/marca.png" class="img-responsive" width="100" align="right"> </div>
        </div>
    </footer>
</body>
</html>