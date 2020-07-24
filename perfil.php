<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['usuario'];               
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, email, imagem, curtidas FROM usuario WHERE usuario='$usuario'"));
    
    $maxTipos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdTipo) AS max FROM tipo_arte"));
    $maxT = (int) $maxTipos['max'];

    $maxArtes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdArte) AS max FROM artes"));
    $maxA = (int) $maxArtes['max'];
    
    $maxGrupos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdGrupo) AS max FROM grupos"));
    $maxG = (int) $maxGrupos['max'];
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

            <div class="col-sm-6" style="padding: 15px; margin: 2% 0px 2%;" align="right"> 
                <form action="perfil.php" method="post">
                    <button class="col-sm-5 col-xs-5" type="submit" name="artes"> Minhas Artes </button>
                    <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#add_arte"> Adicionar Arte </button>
                    <button class="col-sm-5 col-xs-5" type="submit" name="grupos"> Meus Grupos </button>
                    <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#add_grupo"> Adicionar Grupo </button>
                    <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#configuracoes"> Configurações </button>   
                    <button class="col-sm-5 col-xs-5" type="button" data-toggle="modal" data-target="#configuracoes"> Configurações </button>                          
                </form>
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
                                    <label id="imagem"> <input type="file" name="arquivo"> <span class="glyphicon glyphicon-cloud-download"></span> Escolher Arquivo </label><br>   
                                    <input type='text' name='nome' placeholder='Nome' required><br>
                                   
                                    <?php 
                                        echo "<select name='tipo'> <option> Tipos </option>";      
                                        for ($i=1; $i <= $maxT; $i++) { 
                                            $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM tipo_arte WHERE IdTipo=$i"));  
                                            echo "<option value='$i'>". $tipo['nome'] ."</option>";
                                        } echo "</select>";
                                    ?> <br>

                                    <textarea name="descricao" rows="3" placeholder='Descricao'></textarea> <br>  
                                    <input type='submit' name='add_arte' value='Adicionar'>                                     
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
                                    <label id="imagem"> <input type="file" name="arquivo"> <span class="glyphicon glyphicon-cloud-download"></span> Escolher Foto de Capa </label><br>   
                                    <input type='text' name='nome' placeholder='Nome' required><br>
                                    <select name='status'> 
                                        <option value='0'> Status </option>
                                        <option value='1'> Aberto </option>
                                        <option value='2'> Fechado </option>
                                    </select><br>
                                    <textarea name="descricao" rows="3" placeholder='Descricao'></textarea> <br>  
                                    <input type='submit' name='add_grupo' value='Adicionar'>                                     
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        
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

                    for ($j=1; $j <= $conT; $j++) { 
                        if ($tipo == $j) {
                            $pasta = "Arquivos/".$NomeTipo['nome']."/";
                        }
                    }                   

                    if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                        $inserir = mySqli_query($conexao, "INSERT INTO artes(arquivo, nome, tipo, descricao, usuario) 
                        values('$pasta$novoNome', '$nome', '$tipo', '$descricao', '$usuario')");
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                    }
                    else {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Falha no Upload!</strong> Por favor, tente novamente.
                            </div>"; 
                    }    
                }
                else {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Formato de Arquivo inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'.
                        </div>"; 
                }
            }

            if(isset($_POST['add_grupo'])){
                $nome = $_POST["nome"];
                $status = (int) $_POST["status"];
                $descricao = $_POST["descricao"];
                
                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);
                
                if(in_array($extensao, $formatosPermitidos)) {
                    $arquivo = $_FILES["arquivo"]["tmp_name"];
                    $novoNome = uniqid().".$extensao";
                    $pasta = "Arquivos/Grupos/";               

                    if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                        $inserir = mySqli_query($conexao, "INSERT INTO grupos(imagem, nome, administrador, status, descricao) 
                        values('$pasta$novoNome', '$nome', '$usuario', '$status', '$descricao')");
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                    }
                    else {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Falha no Upload!</strong> Por favor, tente novamente.
                            </div>"; 
                    }    
                }
                else {
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'.
                        </div>"; 
                }
            }
        ?>

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
                                <input type='submit' name='voltar_perfil' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <?php
            if(isset($_POST['alt_perfil'])){
                $alt_nome = $_POST["nome"];
                $alt_email = $_POST["email"];

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif', 'mp4');
                $extensao = pathinfo($_FILES["new_imagem"]["name"], PATHINFO_EXTENSION);

                if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $alt_email)){
                    echo "<div id='alert'>
                            <button type='button' class='close'>&times;</button>
                            <strong>E-mail Inválido! </strong> Por favor, insira um endereço de e-mail válido.
                        </div>";
                }
                else {
                    $update = mySqli_query($conexao, "UPDATE usuario SET nome='$alt_nome', email='$alt_email' WHERE usuario='$usuario';");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                } 

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Perfil/";                
    
                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $update = mySqli_query($conexao, "UPDATE usuario SET imagem='$pasta$novoNome' WHERE usuario='$usuario';");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                        }
                        else {
                            echo "<div id='alert'>
                                    <button type='button' class='close'>&times;</button>
                                    <strong>Falha no Upload da Imagem!</strong> Por favor, tente novamente.
                                </div>"; 
                        }    
                    }
                    else {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'.
                            </div>"; 
                    }
                }  
            }

            if(isset($_POST['alt_senha'])){
                $alt_senha = $_POST["senha"];
                $con_senha = $_POST["con_senha"];

                if (($alt_senha != "") && ($con_senha != "") && ($alt_senha == $con_senha)) {
                    $update = mySqli_query($conexao, "UPDATE usuario SET senha='$alt_senha' WHERE usuario='$usuario';");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';   
                }   
            } 

            if(isset($_POST['sair'])){
                $_SESSION['usuario'] = "";
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">'; 
            }

            if(isset($_POST['excluir_perfil'])) { 
                $_SESSION['usuario'] = "usuario";
                mySqli_query($conexao, "DELETE FROM usuario WHERE usuario='$usuario';"); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=home.php">';
            }
        ?>

        <?php 
            if(isset($_POST['artes'])) {                           
                for ($l=1; $l <= $maxA; $l++) { 
                    $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, arquivo FROM artes WHERE IdArte='$l'"));

                    if ($arte != "") {
                        echo "<div class='col-sm-4'> 
                                <h5>".$arte['nome']." <button type='button' class='descricao' data-toggle='modal' data-target='#descricao_arte'> <span class='glyphicon glyphicon-option-vertical'></span> </button> </h5> 
                                <div id='arte'> <img src='".$arte['arquivo']."'> </div></div>";  
                    }
                }
            }            
            
            if(isset($_POST['grupos'])) {
                for ($i=1; $i <= $maxG; $i++) { 
                    $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, imagem FROM grupos WHERE IdGrupo='$i'"));
                    
                    if ($grupo != "") {
                        echo "<div class='col-sm-3'> 
                            <h5>".$grupo['nome']." <button type='button' class='descricao' data-toggle='modal' data-target='#descricao_grupo'> <span class='glyphicon glyphicon-option-vertical'></span> </button></h5> 
                            <div id='grupo'> <img src='".$grupo['imagem']."'> </div></div>";  
                    }                       
                }
            }  
        ?>

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

        <div class="modal fade" id="editar_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar Arte</h4>
                    </div>

                    <div class="modal-body">
                        <form action='perfil.php' method='post'>
                            <div class='form-group' align="center">
                            
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="excluir_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Excluir Arte</h4>
                    </div>

                    <div class="modal-body">
                        <form action='perfil.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir essa arte? </label> <br>
                                <input type='submit' name='excluir_arte' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_perfil' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="descricao_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <?php $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT FROM grupos WHERE IdGrupo='$IdGrupo'")); ?> 

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php echo "<h4 class='modal-title'>".$DadosGrupo['nome']."</h4>" ?>  
                    </div>

                    <div class="modal-body">
                        <div class="row"> 
                            <button class="icon" type="button" data-toggle="modal" data-target="#editar_grupo"> <span class="glyphicon glyphicon-pencil"></span> </button>
                            <button class="icon" type="button" data-toggle="modal" data-target="#excluir_grupo"> <span class="glyphicon glyphicon-lixo"></span> </button>
                        </div>

                        <div class="row"> 
                            <div class="col-sm-6">
                                <?php echo "<div id='arte'> <img src='".$DadosGrupo['imagem']."'> </div>"; ?>
                            </div>

                            <div class="col-sm-6">
                                
                            </div>
                        </div>    
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="editar_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar Grupo</h4>
                    </div>

                    <div class="modal-body">
                        <form action='perfil.php' method='post'>
                            <div class='form-group' align="center">
                                <?php
                                    echo "<label id='imagem'> <input type='file' name='arquivo'> <span class='glyphicon glyphicon-cloud-download'></span> Escolher Foto de Capa </label><br>
                                        <label> Nome </label> <input type='text' name='nome' value='".$DadosGrupo['nome']."'><br>
                                        <select name='status'>";

                                        if ($DadosGrupo['status'] == 1) { echo " <option value='0'> Status: Aberto </option>"; } 
                                        else { echo " <option value='0'> Status: Fechado </option>"; } 
                                        
                                    echo"   <option value='1'> Aberto </option>
                                            <option value='2'> Fechado </option>
                                        </select><br>
                                        <textarea name='descricao' rows='3' value='".$DadosGrupo['descricao']."'></textarea> <br>
                                        <input type='submit' name='edt_grupo' value='Editar'>";
                                ?>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Excluir Grupo</h4>
                    </div>

                    <div class="modal-body">
                        <form action='perfil.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse grupo? </label> <br>
                                <input type='submit' name='excluir_grupo' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_perfil' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <?php /*
            if(isset($_POST['edt_arte'])){
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];

                if ($_POST["tipo"] != "") { $tipo = (int) $_POST["tipo"]; }
                else { $tipo = $DadosArte["tipo"];}

                if ($_POST["arquivo"] != "") { 
                    $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif', 'mp4');
                    $extensao = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);
                    
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["arquivo"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Grupos/";               

                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $update = mySqli_query($conexao, "UPDATE grupos SET nome='$nome', status='$status', descricao='$descricao', imagem='$pasta$novoNome'  WHERE IdArte="$DadosGrupo['IdArte']"");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                        }
                        else {
                            echo "<div id='alert'>
                                    <button type='button' class='close'>&times;</button>
                                    <strong>Falha no Upload!</strong> Por favor, tente novamente.
                                </div>"; 
                        }    
                    }
                    else {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Formato de Arquivo inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'.
                            </div>"; 
                    }
                }   
            } 
            if(isset($_POST['edt_grupo'])){
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];

                if ($_POST["status"] != "") { $status = (int) $_POST["status"]; }
                else { $status = $DadosGrupo["status"];}

                if ($_POST["arquivo"] != "") { 
                    $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                    $extensao = pathinfo($_FILES["arquivo"]["name"], PATHINFO_EXTENSION);
                    
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["arquivo"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Grupos/";               

                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            $update = mySqli_query($conexao, "UPDATE grupos SET nome='$nome', status='$status', descricao='$descricao', imagem='$pasta$novoNome'  WHERE IdGrupo="$DadosGrupo['IdGrupo']"");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
                        }
                        else {
                            echo "<div id='alert'>
                                    <button type='button' class='close'>&times;</button>
                                    <strong>Falha no Upload!</strong> Por favor, tente novamente.
                                </div>"; 
                        }    
                    }
                    else {
                        echo "<div id='alert'>
                                <button type='button' class='close'>&times;</button>
                                <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'.
                            </div>"; 
                    }
                }   
            }     

            if(isset($_POST['excluir_arte'])) { 
                mySqli_query($conexao, "DELETE FROM artes WHERE IdArte="$DadosArte['IdArte']""); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
            }

            if(isset($_POST['excluir_grupo'])) { 
                mySqli_query($conexao, "DELETE FROM grupos WHERE IdGrupo="$DadosArte['IdGrupo']""); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">';
            }

            if(isset($_POST['voltar_perfil'])) { 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil.php">'; 
            } 
        */ ?> 
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