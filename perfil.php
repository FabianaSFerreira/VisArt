<?php 
    include_once("conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['usuario'];               
    $nome = mysqli_fetch_assoc(mySqli_query($conexao, "select nome from usuario where usuario='$usuario'"));
    $email = mysqli_fetch_assoc(mySqli_query($conexao, "select email from usuario where usuario='$usuario'"));
    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "select curtidas from usuario where usuario='$usuario'"));
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
    
        <div class="row" id="perfil">     
            <div class="col-sm-7" style="padding: 15px 20px 10px;" align="center"> 
                <div class="col-sm-7" id="img_perfil"> 
                    
                </div>

                <div class="col-sm-5" style="margin: 3% 0px 3%;"> 
                    <?php
                        echo "<label>".$nome['nome']."</label><br>";
                        echo "<label> $usuario </label>";
                        echo "<label>".$curtidas['curtidas']."</label>";
                    ?> 
                </div>
            </div>

            <div class="col-sm-5" style="padding: 15px; margin: 3% 0px 3%;" align="right"> 
                <form action="perfil.php" method="post">
                    <button class="col-sm-5 col-xs-5" type="submit" name="artes"> Minhas Artes </button>
                    <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#adicionar"> Adicionar</button>
                    <button class="col-sm-5 col-xs-5" type="submit" name="grupos"> Meus Grupos </button>
                    <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#configurar"> Configurações </button>                           
                </form>
            </div>
        </div>        
    </header>
    
    <section class="container-fluid">
        <div class="modal fade" id="adicionar" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adicionar</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action='perfil.php' method='post' enctype="multipart/form-data">                                 
                                <div class='form-group' align="center"> 
                                    <label id="imagem"> <input type="file" name="imagem"> <span class="glyphicon glyphicon-cloud-download"></span> Escolher Imagem </label><br>   
                                    <input type='text' name='nome' placeholder='Nome' required><br>
                                   
                                    <?php                                           
                                        $cont_tipo = mysqli_fetch_assoc(mySqli_query($conexao, "select count(*) as cont from tipoarte"));
                                        $cont = (int) $cont_tipo['cont'];

                                        echo "<select name='tipo'> <option> Tipos </option>";      
                                        for ($i=1; $i <= $cont; $i++) { 
                                            $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "select nome from tipoarte where IdTipo=$i"));  
                                            echo "<option value='$i'>". $tipo['nome'] ."</option>";
                                        } echo "</select>";
                                    ?> <br>

                                    <textarea name="descricao" rows="2" placeholder='Descricao'></textarea> <br>  
                                    <input type='submit' name='adicionar' value='Adicionar'>                                     
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="configurar" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Configurações</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row" id="campo">
                            <label> Alterar Nome </label>
                            <button type="button" class="alt_nome"> <span class="glyphicon glyphicon-triangle-right"></span> </button>
                            
                            <div class="form_nome">
                                <form action='perfil.php' method='post'>
                                    <div class='form-group' align="center">
                                        <?php
                                            echo "<input type='text' name='nome' placeholder='".$nome['nome']."' style='width: -webkit-fill-available;'><br>
                                            <input type='submit' name='alt_nome' value='Alterar' style='width: 120px;'>"; 
                                        ?>    
                                    </div>
                                </form>
                            </div>  
                        </div>

                        <div class="row" id="campo">
                            <label> Alterar E-mail </label>
                            <button type="button" class="alt_email"> <span class="glyphicon glyphicon-triangle-right"></span> </button>
                            
                            <div class="form_email">
                                <form action='perfil.php' method='post'>
                                    <div class='form-group' align="center">
                                        <?php 
                                            echo "<input type='email' name='email' placeholder='".$email['email']."' style='width: -webkit-fill-available;'><br>
                                            <input type='submit' name='alt_email' value='Alterar' style='width: 120px;'> ";  
                                        ?>                                         
                                    </div>  
                                </form>
                            </div>  
                        </div>

                        <div class="row" id="campo">
                            <label> Alterar Senha </label>
                            <button type="button" class="alt_senha"> <span class="glyphicon glyphicon-triangle-right"></span> </button>
                            
                            <div class="form_senha">
                                <form action='perfil.php' method='post'>
                                    <div class='form-group' align="center">
                                        <?php                                        
                                            echo "<input type='password' name='senha' placeholder='Nova Senha'> 
                                            <input type='password' name='con_senha' placeholder='Confirma Senha'> <br>
                                            <input type='submit' name='alt_senha' value='Alterar' style='width: 120px;'>";
                                        ?>  
                                    </div>
                                </form>
                            </div>  
                        </div> 

                        <div class="row" id="campo">
                            <label> Alterar Foto de Perfil </label>
                            <button type="button" class="alt_foto"> <span class="glyphicon glyphicon-triangle-right"></span> </button>
                            
                            <div class="form_foto">
                                <form action='perfil.php' method='post'>
                                    <label id="imagem"> <input type="file" name="new_imagem"> <span class="glyphicon glyphicon-cloud-download"></span> Escolher Imagem </label><br>   
                                </form>
                            </div>  
                        </div> 

                        <div class="row" id="campo">
                            <form action='perfil.php' method='post'>
                                <label> Sair </label>
                                <button class="sair" type="submit" name="sair"> <span class="glyphicon glyphicon-off"></span> </button>
                            </form> 
                        </div>     
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <?php
            $cont_artes = mysqli_fetch_assoc(mySqli_query($conexao, "select count(*) as cont from artes where usuario='$usuario'"));
            $conA = (int) $cont_artes['cont'];
                                        
            for ($l=1; $l <= $conA; $l++) { 
                $nome = mysqli_fetch_assoc(mySqli_query($conexao, "select nome_arte from artes where IdArte='$l'"));
                $imagem = mysqli_fetch_object(mySqli_query($conexao, "select imagem from artes where IdArte='$l'"));
                echo "<div class='col-sm-4'> <h4>". $nome['nome_arte'] ."</h4> 
                <img src='perfil.php?id=".$l."' style='width:100%;'> </div>";  
                //header("Content-type: image/png");    
                //echo $imagem->imagem;
            }
        ?>


        <?php
            if(isset($_POST['adicionar'])){
                define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

                $nome_arte = $_POST["nome"];
                $tipo_arte = $_POST["tipo"];
                $descricao = $_POST["descricao"];
                
                $imagem = $_FILES["imagem"];
                $nome_imagem = $imagem['name'];
                $tipo_imagem = $imagem['type'];
                $tamanho_imagem = $imagem['size'];
                
                if ($imagem != "none" ) {
                    if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipo_imagem)) {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: jpeg, jpeg, png, gif, bmp.
                            </div>"; 
                    }
                    else if ($tamanho_imagem > TAMANHO_MAXIMO) {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Tamanho maximo exedido!</strong> A imagem deve possuir no máximo 2 MB.
                            </div>";
                    }
                    else {
                        $fp = fopen($imagem, "rb");
                        $conteudo_imagem = fread($fp, $tamanho_imagem);
                        $conteudo = addslashes($conteudo_imagem);
                        fclose($fp);

                        $inserir = mySqli_query($conexao, "insert into artes(imagem, nome_imagem, tipo_imagem, tamanho_imagem, nome_arte, tipo_arte, descricao, usuario) 
                        values('$conteudo', '$nome_imagem', '$tipo_imagem', '$tamanho_imagem', '$nome_arte', '$tipo_arte', '$descricao', '$usuario')");
                    }
                }
                else {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Erro ao selecionar a imagem!</strong> Por favor, tente novamente.
                        </div>";  
                }
                
                /*else {
                    if ( $imagem != "none" )
                    {
                        $fp = fopen($imagem, "rb");
                        $conteudo = fread($fp, $tamanho);
                        $conteudo = addslashes($conteudo);
                        fclose($fp);
                    
                    $queryInsercao = "INSERT INTO tabela_imagens (nome_evento, 
                    descrição_evento, nome_imagem, 
                    tamanho_imagem, tipo_imagem, imagem) VALUES ('$nomeEvento', 
                    '$descricaoEvento','$nome','$tamanho', '$tipo','$conteudo')";
                    
                    mysql_query($queryInsercao) or die("Algo deu errado ao inserir 
                    o registro. Tente novamente.");
                    echo 'Registro inserido com sucesso!'; 
                    header('Location: index.php');
                    if(mysql_affected_rows($conexao) > 0)
                        print "A imagem foi salva na base de dados.";
                    else
                        print "Não foi possível salvar a imagem na base de dados.";
                    }
                    
                        
                    $conteudo = file_get_contents($imagem['tmp_name']);
                
                   
                    
                    echo "'$nome_imagem', '$tipo_imagem', '$tamanho_imagem', '$nome_arte', '$tipo_arte', '$descricao', '$usuario'";
                    //echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                } */
            }

            if(isset($_POST['alt_nome'])){
                $alt_nome = $_POST["nome"];

                if ($alt_nome != "") {
                    $update = mySqli_query($conexao, "update usuario set nome='$alt_nome' where usuario='$usuario';");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';   
                }   
            }

            if(isset($_POST['alt_email'])){
                $alt_email = $_POST["email"];
                
                if ($alt_email != "") {
                    if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $alt_email)){
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>E-mail Inválido! </strong> Por favor, insira um endereço de e-mail válido.
                            </div>";
                    }
                    else {
                        $update = mySqli_query($conexao, "update usuario set email='$alt_email' where usuario='$usuario';");
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';   
                    } 
                }    
            }

            if(isset($_POST['alt_senha'])){
                $alt_senha = $_POST["senha"];
                $con_senha = $_POST["con_senha"];

                if (($alt_senha != "") && ($con_senha != "") && ($alt_senha == $con_senha)) {
                    $update = mySqli_query($conexao, "update usuario set senha='$alt_senha' where usuario='$usuario';");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';   
                }   
            }

            /* if(isset($_POST['alt_foto'])){
                define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

                if (!isset($_FILES['new_imagem'])) {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Erro ao selecionar a imagem!</strong> Por favor, tente novamente.
                        </div>"; 
                }
                else {
                    $imagem = $_FILES["new_imagem"];
                    $nome_imagem = $imagem['name'];
                    $tipo_imagem = $imagem['type'];
                    $tamanho_imagem = $imagem['size'];
                    
                    if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipo_imagem)) {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: jpeg, jpeg, png, gif, bmp.
                            </div>"; 
                    }
                    
                    if ($tamanho_imagem > TAMANHO_MAXIMO) {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Tamanho maximo exedido!</strong> A imagem deve possuir no máximo 2 MB.
                            </div>";
                    }
                    
                    $conteudo = file_get_contents($imagem['tmp_name']);
                    
                    $update = mySqli_query($conexao, "update usuario set imagem='$conteudo', nome_imagem='$nome_imagem', tipo_imagem='$tipo_imagem', tamanho_imagem='$tamanho_imagem' where usuario='$usuario';");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';                          
            } */

            if(isset($_POST['sair'])){
                $_SESSION['usuario'] = "usuario";
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
            }

            if(isset($_POST['artes'])){}            
            if(isset($_POST['grupos'])){}  
        ?>
    </section>

    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); });

            $(".form_nome").hide();
            $(".form_email").hide();
            $(".form_senha").hide();
            $(".form_foto").hide();
           
            $(".alt_nome").click(function(){ $(".form_nome").toggle(); });
            $(".alt_email").click(function(){ $(".form_email").toggle(); });           
            $(".alt_senha").click(function(){ $(".form_senha").toggle(); });
            $(".alt_foto").click(function(){ $(".form_foto").toggle(); });
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