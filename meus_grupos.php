<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['usuario'];
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, email, imagem, curtidas FROM usuario WHERE usuario='$usuario'"));                 
    
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
                
                <div class="col-sm-5 col-xs-5" style="padding: initial; margin: 0px 10px;">
                    <form action="perfil.php" method="post">
                        <input type="submit" name="modalArte" value="Adicionar Arte" style="background: #ffffee;  width: -webkit-fill-available; margin: 10px 0px;">
                    </form>
                </div>
                
                <a class="col-sm-5 col-xs-5" href="meus_grupos.php" style="margin: 10px;"> Meus Grupos </a>
                
                <div class="col-sm-5 col-xs-5" style="padding: initial; margin: 0px 10px;">
                    <form action="perfil.php" method="post">
                        <input type="submit" name="modalGrupo" value="Adicionar Grupo" style="background: #ffffee;  width: -webkit-fill-available; margin: 10px 0px;">
                    </form>
                </div>
                
                <a class="col-sm-5 col-xs-5" href="notificacao.php" style="margin: 10px;"> Notificações </a>
                
                <div class="col-sm-5 col-xs-5" style="padding: initial; margin: 0px 10px;">
                    <form action="perfil.php" method="post">
                        <input type="submit" name="configuracoes" value="Configurações" style="background: #ffffee;  width: -webkit-fill-available; margin: 10px 0px;">
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <section class="container-fluid">
        <?php
            if ($_SESSION['Alert'] != "") { 
                echo $_SESSION['Alert'];
                $_SESSION['Alert'] = ""; 
            }

            for ($i=1; $i <= $maxG; $i++) { 
                $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, imagem FROM grupos WHERE IdGrupo='$i'"));

                if ($grupo != "") {
                    echo "<form action='meus_grupos.php' method='post'>
                            <div class='col-sm-3'> 
                                <h5>".$grupo['nome']." <button type='submit' name='botG".$i."' class='descricao'> <span class='glyphicon glyphicon-option-vertical'></span> </button></h5> 
                                <div id='grupo'> <img src='".$grupo['imagem']."'> </div>
                            </div>
                        </form>"; 
                } 
            }

            for ($j=1; $j <= $maxG; $j++) { 
                if (isset($_POST["botG$j"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, nome, administrador, status, descricao, imagem FROM grupos WHERE IdGrupo='$j'")); 
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";     
                }
            } 

            if(isset($_POST['edt_grupo'])){
                $nome = $_POST["nome"];
                $status = (int) $_POST["status"];
                $descricao = $_POST["descricao"];
                
                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["new_imagem"]["name"], PATHINFO_EXTENSION);

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Grupos/";                
    
                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            mySqli_query($conexao, "UPDATE grupos SET nome='$nome', status='$status', descricao='$descricao', imagem='$pasta$novoNome' WHERE IdGrupo=".$_SESSION['IdGrupo']."");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                        }
                        else {
                            $_SESSION['Alert'] =  "<div id='alert'> <button type='button' class='close'>&times;</button><strong>Falha no Upload!</strong> Por favor, tente novamente.</div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] =  "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                    }
                } 
                else {
                    mySqli_query($conexao, "UPDATE grupos SET nome='$nome', status='$status', descricao='$descricao' WHERE IdGrupo=".$_SESSION['IdGrupo']."");
                    
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, nome, administrador, status, descricao, imagem FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>"; 
                }  
            } 

            if(isset($_POST['excluir_grupo'])) { 
                $delete = mySqli_query($conexao, "DELETE FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."");
                
                if ($delete != "") {
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Grupo deletado com sucesso!</strong> </div>"; 
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
                }
            }

            if(isset($_POST['voltar_grupo'])) { 
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, nome, administrador, status, descricao, imagem FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";
            } 
        ?>  

        <div class='modal fade' id='descricao_grupo' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <?php ?>
                        <button class="descricao" type="button" data-toggle="modal" data-target="#editar_grupo" style='float:left;'> <span class="glyphicon glyphicon-pencil"></span> </button>
                        <button class="descricao" type="button" data-toggle="modal" data-target="#excluir_grupo" style='float:left;'> <span class="glyphicon glyphicon-trash"></span> </button>
                        
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
                                        $membros = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario FROM membros_grupo WHERE IdMembro='$i' AND Grupo=".$DadosGrupo['IdGrupo']." AND Solicitacao='0'"));  
                                        if ($membros != "") { echo "<option>". $membros['usuario'] ."</option>"; }
                                    } echo "</select>";
                                ?>
                            </div>
                        </div>     
                    </div>

                    <div class='modal-footer'></div>
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
                        <form action='meus_grupos.php' method='post' enctype="multipart/form-data">
                            <div class='form-group' align="center">
                                <div class="col-sm-2" align="left"><label> Imagem: </label></div>
                                <div class="col-sm-10" align="left"><label id='imagem' style='width:-webkit-fill-available;'> <input type="file" name='new_imagem'> <span class="glyphicon glyphicon-cloud-download"></span> Escolher Imagem </label></div>

                                <div class="col-sm-2" align="left"><label> Nome: </label></div>
                                <div class="col-sm-10" align="left"><?php echo "<input type='text' name='nome' value='".$DadosGrupo['nome']."' style='width:-webkit-fill-available;'>";?></div>

                                <div class="col-sm-2" align="left"><label> Descrição: </label></div>
                                <div class="col-sm-10" align="left"><?php echo "<textarea name='descricao' rows='3' style='width:-webkit-fill-available;'>".$DadosGrupo['descricao']."</textarea>";?></div>

                                <div class="col-sm-2" align="left"><label> Status: </label></div>
                                <div class="col-sm-10" align="left">
                                    <?php 
                                        echo "<select name='status' style='width:-webkit-fill-available;'>";
                                        if ($DadosGrupo['status'] == 1) { echo "<option value='1'> Aberto </option> <option value='2'> Fechado </option> </select>"; } 
                                        else { echo "<option value='2'> Fechado </option> <option value='1'> Aberto </option> </select>"; }   
                                    ?>
                                </div>

                                <div align="center"> <input type='submit' name='edt_grupo' value='Editar'> </div> 
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
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse grupo? </label> <br>
                                <input type='submit' name='excluir_grupo' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_grupo' value='Voltar' style='width: 120px;'>
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
    
    <footer class="container-fluid">
        <div class="row" id="footer">
            <div class="col-sm-10"> <p>Instituto Federal Sul-rio-grandense - Campus Gravataí, Curso Técnico em Informética para a Internet. Trabalho de Conclusão de Curso - Fabiana da Silveira Ferreira </p> </div>
            <div class="col-sm-2" style="padding-top: 10px;"> <img src="Arquivos/marca.png" class="img-responsive" width="100" align="right"> </div>
        </div>
    </footer>
</body>
</html>