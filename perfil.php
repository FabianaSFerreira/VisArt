<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['usuario'];               
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, email, imagem, curtidas FROM usuario WHERE usuario='$usuario'"));

    $maxTipos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdTipo) AS max FROM tipo_arte"));
    $maxT = (int) $maxTipos['max'];
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
        </div> <br>   

        <div class="row" id="perfil">     
            <div class="col-sm-6" style="padding: 15px;" align="center"> 
                <div class="col-sm-7" id="img_perfil"> 
                    <?php echo "<img src='".$select['imagem']."' style='width:100%; height:100%;'>"; ?>
                </div>

                <div class="col-sm-5" style="padding: 0px; margin: 3% 0px 3%;"> 
                    <?php
                        echo "<label>".$select['nome']."</label><br>";
                        echo "<label> $usuario </label><br>";
                        echo "<label>".$select['curtidas']."</label>";
                    ?> 
                </div>
            </div>

            <div class="col-sm-6" style="padding: 15px; margin: 1% 0px;" align="right"> 
                <a class="col-sm-5 col-xs-5" href="minhas_artes.php" style="margin: 10px;"> Minhas Artes </a>
                <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#add_arte"> Adicionar Arte </button>
                <a class="col-sm-5 col-xs-5" href="meus_grupos.php" style="margin: 10px;"> Meus Grupos </a>
                <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#add_grupo"> Adicionar Grupo </button>
                <a class="col-sm-5 col-xs-5" href="notificacao.php" style="margin: 10px;"> Notificações </a>
                <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#configuracoes"> Configurações </button>
            </div>
        </div>
    </header>
    
    <section class="container-fluid">
        <div class="modal fade" id="add_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adicionar Arte</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action='perfil.php' method='post' enctype="multipart/form-data">                                 
                                <div class='form-group' align="center">
                                    <div class="col-sm-2" align="left"><label> Imagem: </label></div>
                                    <div class="col-sm-10" align="left"><label id='imagem' style='width:-webkit-fill-available;'> <input type="file" name="arquivo"> <span class="glyphicon glyphicon-cloud-download"></span> Escolher Arquivo </label></div>
                                    
                                    <div class="col-sm-2" align="left"><label> Nome: </label></div>
                                    <div class="col-sm-10" align="left"><input type='text' name='nome' placeholder='Título' style='width:-webkit-fill-available;' required></div>
                                    
                                    <div class="col-sm-2" align="left"><label> Tipo: </label></div>
                                    <div class="col-sm-10" align="left">
                                        <?php 
                                            echo "<select name='tipo' style='width:-webkit-fill-available;'>";      
                                            for ($i=1; $i <= $maxT; $i++) { 
                                                $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM tipo_arte WHERE IdTipo=$i"));  
                                                echo "<option value='$i'>". $tipo['nome'] ."</option>";
                                            } echo "</select>";
                                        ?>
                                    </div>

                                    <div class="col-sm-2" align="left"><label> Descrição: </label></div>
                                    <div class="col-sm-10" align="left"><textarea name="descricao" rows="3" placeholder='Texto' style='width:-webkit-fill-available;' required></textarea></div>

                                    <div align="center"> <input type='submit' name='add_arte' value='Adicionar'> </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="add_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Adicionar Grupo</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <form action='perfil.php' method='post' enctype="multipart/form-data">                                 
                                <div class='form-group' align="center"> 
                                    <div class="col-sm-2" align="left"><label> Imagem: </label></div>
                                    <div class="col-sm-10" align="left"><label id='imagem' style='width:-webkit-fill-available;'> <input type="file" name="arquivo"> <span class="glyphicon glyphicon-cloud-download"></span> Escolher Imagem </label></div>
                                    
                                    <div class="col-sm-2" align="left"><label> Nome: </label></div>
                                    <div class="col-sm-10" align="left"><input type='text' name='nome' placeholder='Título' style='width:-webkit-fill-available;' required></div>
                                    
                                    <div class="col-sm-2" align="left"><label> Status: </label></div>
                                    <div class="col-sm-10" align="left"> <select name='status' style='width:-webkit-fill-available;'> <option value='1'> Aberto </option> <option value='2'> Fechado </option> </select></div>

                                    <div class="col-sm-2" align="left"><label> Descrição: </label></div>
                                    <div class="col-sm-10" align="left"><textarea name="descricao" rows="3" placeholder='Texto' style='width:-webkit-fill-available;' required></textarea></div>

                                    <div align="center"> <input type='submit' name='add_grupo' value='Adicionar'> </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="configuracoes" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Configurações</h4>
                    </div>

                    <div class="modal-body">
                        <div class="row" id="campo">
                            <label> Alterar Perfil </label>
                            <button type="button" class="alt_perfil"> <span class="glyphicon glyphicon-triangle-right"></span> </button>
                            
                            <div class="form_perfil">
                                <form action='perfil.php' method='post' enctype="multipart/form-data">
                                    <div class='form-group'> <br>
                                        <div class="col-sm-2" align="left"><label> Nome: </label></div>
                                        <div class="col-sm-10" align="left"><?php echo "<input type='text' name='nome' value='".$select['nome']."' style='width:-webkit-fill-available;'>";?></div>
                                        
                                        <div class="col-sm-2" align="left"><label> Email: </label></div>
                                        <div class="col-sm-10" align="left"><?php echo "<input type='email' name='email' value='".$select['email']."' style='width:-webkit-fill-available;'>";?></div>

                                        <div class="col-sm-2" align="left"><label> Imagem: </label></div>
                                        <div class="col-sm-10" align="left"><label id='imagem' style='width:-webkit-fill-available;'> <input type='file' name='new_imagem'><span class='glyphicon glyphicon-cloud-download'></span> Escolher Imagem </label></div>
                                        
                                        <div align="center"> <input type='submit' name='alt_perfil' value='Alterar' style='width: 120px;'> </div>
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
                                        <input type='password' name='senha' placeholder='Nova Senha'> <br> 
                                        <input type='password' name='con_senha' placeholder='Confirma Senha'> <br>
                                        <input type='submit' name='alt_senha' value='Alterar' style='width: 120px;'>
                                    </div>
                                </form>
                            </div>  
                        </div> 

                        <div class="row" id="campo">
                            <form action='perfil.php' method='post'>
                                <label> Excluir Perfil </label>
                                <button class="icon" type="button" data-toggle="modal" data-target="#excluir_perfil"> <span class="glyphicon glyphicon-triangle-right"></span> </button>
                            </form>  
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

        <div class="modal fade" id="excluir_perfil" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Excluir Perfil</h4>
                    </div>

                    <div class="modal-body">
                        <form action='perfil.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir seu perfil? <br> Após a exclusão sua conta não poderá ser recuperada </label> <br>
                                <input type='submit' name='excluir_perfil' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='configuracoes' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        
        <?php
            if ($_SESSION['Alert'] != "") { 
                echo $_SESSION['Alert'];
                $_SESSION['Alert'] = ""; 
            }

            if(isset($_POST['modalArte'])) { 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#add_arte').modal('show'); }); </script>";
            } 

            if(isset($_POST['modalGrupo'])) { 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#add_grupo').modal('show'); }); </script>";
            } 

            if(isset($_POST['configuracoes'])) { 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#configuracoes').modal('show'); }); </script>";
            }
        ?>
        
        <?php    
            if(isset($_POST['add_arte'])){
                $nome = $_POST["nome"];
                $tipo = (int) $_POST["tipo"];
                $descricao = $_POST["descricao"];
                
                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif', 'mp4');
                $extensao = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);

                $NomeTipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM tipo_arte WHERE IdTipo='$tipo'"));

                if(in_array($extensao, $formatosPermitidos)) {
                    $arquivo = $_FILES["arquivo"]["tmp_name"];
                    $novoNome = uniqid().".$extensao";
                    $pasta = "Arquivos/".$NomeTipo['nome']."/";  

                    if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                        $inserir = mySqli_query($conexao, "INSERT INTO artes(arquivo, nome, tipo, descricao, usuario) values('$pasta$novoNome', '$nome', '$tipo', '$descricao', '$usuario')");
                        
                        echo $inserir; die;

                        if ($inserir != "") {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Arte adicionada com sucesso </strong> </div>";
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha ao Adicionar Arte!</strong> Por favor, tente novamente. </div>";
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                        } 
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload do Arquivo!</strong> Por favor, tente novamente. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }   
                }
                else {
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Arquivo inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'.</div>"; 
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                }
            }

            if(isset($_POST['add_grupo'])){
                $nome = $_POST["nome"];
                $status = (int) $_POST["status"];
                $descricao = $_POST["descricao"];

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["arquivo"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Grupos/";               

                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $inserir = mySqli_query($conexao, "INSERT INTO grupos(imagem, nome, administrador, status, descricao) values('$pasta$novoNome', '$nome', '$usuario', '$status', '$descricao')");
                            
                            if ($inserir != "") {
                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Grupo adicionado com sucesso </strong> </div>";
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }
                            else {
                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha ao Adicionar Grupo!</strong> Por favor, tente novamente. </div>"; 
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }  
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload da Imagem!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                        }   
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'.</div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }
                }
                else {
                    $inserir = mySqli_query($conexao, "INSERT INTO grupos(nome, administrador, status, descricao) values('$nome', '$usuario', '$status', '$descricao')");
                    
                    if ($inserir != "") {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Grupo adicionado com sucesso </strong> </div>";
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    } 
                }
            }

            if(isset($_POST['alt_perfil'])){
                $alt_nome = $_POST["nome"];
                $alt_email = $_POST["email"];

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["new_imagem"]["name"], PATHINFO_EXTENSION);

                if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $alt_email)){
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>E-mail Inválido! </strong> Por favor, insira um endereço de e-mail válido.</div>";
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                }
                else {
                    $update = mySqli_query($conexao, "UPDATE usuario SET nome='$alt_nome', email='$alt_email' WHERE usuario='$usuario';");
                    
                    if ($update != "") {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Dados do perfil alterados com sucesso </strong> </div>";
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }
                } 

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Perfil/";                
    
                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $update = mySqli_query($conexao, "UPDATE usuario SET imagem='$pasta$novoNome' WHERE usuario='$usuario';");
                            
                            if ($update != "") {
                                $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Dados do perfil alterados com sucesso </strong> </div>";
                                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                            }
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload da Imagem!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'.</div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                    }
                }  
            }

            if(isset($_POST['alt_senha'])){
                $alt_senha = $_POST["senha"];
                $con_senha = $_POST["con_senha"];

                if (($alt_senha != "") && ($con_senha != "") && ($alt_senha == $con_senha)) {
                    $update = mySqli_query($conexao, "UPDATE usuario SET senha='$alt_senha' WHERE usuario='$usuario';");
                    
                    if ($update != "") {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Senha alterada com sucesso </strong> </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';  
                    }  
                }
                else {
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong> Falha ao alterar senha! </strong> </div>"; 
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
                }   
            } 

            if(isset($_POST['excluir_perfil'])) { 
                $_SESSION['usuario'] = "";
                
                mySqli_query($conexao, "DELETE FROM usuario WHERE usuario='$usuario';"); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">';
            }

            if(isset($_POST['sair'])){
                $_SESSION['usuario'] = "";
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
            }
        ?>
    </section>

    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); });

            $(".form_perfil").hide();
            $(".form_senha").hide();
           
            $(".alt_perfil").click(function(){ $(".form_perfil").toggle(); });        
            $(".alt_senha").click(function(){ $(".form_senha").toggle(); });
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