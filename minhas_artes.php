<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['IdUsuario'];
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$usuario'"));               
    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT SUM(Curtidas) AS curt FROM artes WHERE IdUsuario='$usuario'"));

    $maxTipos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdTipo) AS max FROM artes_tipos"));
    $maxT = (int) $maxTipos['max'];

    $maxArtes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdArte) AS max FROM artes"));
    $maxA = (int) $maxArtes['max'];

    $maxComentarios = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdComentario) AS max FROM artes_comentarios"));
    $maxC = (int) $maxComentarios['max'];
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

        <div class="row" id="perfil">     
            <div class="col-sm-6" style="padding: 15px;" align="center"> 
                <div class="col-sm-7" id="img_perfil"> 
                    <?php echo "<img src='".$select['LocalFoto']."' style='width:100%; height:100%;'>"; ?>
                </div>

                <div class="col-sm-5" style="padding: 0px; margin: 1% 0px;"> 
                    <?php
                        echo "<label>Nome: ".$select['nome']."</label><br>";
                        echo "<label>Usuário: ".$select['usuario']."</label><br>";
                        echo "<label>Curtidas ".$curtidas['curt']."</label>";
                    ?> 
                </div>
            </div>

            <div class="col-sm-6" style="padding: 15px; margin: 1% 0px;" align="right"> 
                <a class="col-sm-5 col-xs-5" href="minhas_artes.php" style="margin: 10px;"> Minhas Artes </a>
                
                <div class="col-sm-5 col-xs-5" style="padding: initial; margin: 0px 10px;">
                    <form action="perfil.php" method="post">
                        <input type="submit" name="modalArte" value="Adicionar Arte" style="background: #ffffee;  width: -webkit-fill-available; margin: 10px 0px; border: 0px; padding: 5px;">
                    </form>
                </div>
                
                <a class="col-sm-5 col-xs-5" href="meus_grupos.php" style="margin: 10px;"> Meus Grupos </a>
                
                <div class="col-sm-5 col-xs-5" style="padding: initial; margin: 0px 10px;">
                    <form action="perfil.php" method="post">
                        <input type="submit" name="modalGrupo" value="Adicionar Grupo" style="background: #ffffee;  width: -webkit-fill-available; margin: 10px 0px; border: 0px; padding: 5px;">
                    </form>
                </div>
                
                <a class="col-sm-5 col-xs-5" href="notificacao.php" style="margin: 10px;"> Notificações </a>
                
                <div class="col-sm-5 col-xs-5" style="padding: initial; margin: 0px 10px;">
                    <form action="perfil.php" method="post">
                        <input type="submit" name="configuracoes" value="Configurações" style="background: #ffffee;  width: -webkit-fill-available; margin: 10px 0px; border: 0px; padding: 5px;">
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

            for ($i=1; $i <= $maxA; $i++) { 
                $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo FROM artes WHERE IdArte='$i' AND IdUsuario='$usuario'"));
                
                if ($arte != "") {
                    echo "<form action='minhas_artes.php' method='post'> <div class='col-sm-4'> 
                            <h5>".$arte['TituloArte']." <button type='submit' name='botA".$i."' class='descricao' data-title='Descrição'> <span class='glyphicon glyphicon-option-vertical'></span> </button></h5>";

                    if ($arte['IdTipo'] == 4) { 
                        echo "<div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'></video> </div> </div></form>";
                    }
                    else {echo "<div id='arte'> <img id='img_arte' src='".$arte['LocalArquivo']."'> </div> </div></form>";}  
                }                                      
            }         
            
            for ($j=1; $j <= $maxA; $j++) { 
                if (isset($_POST["botA$j"])) {
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte='$j'")); 
                    $_SESSION['IdArte'] = $DadosArte['IdArte'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['edt_arte'])){
                $nome = $_POST["nome"];
                $descricao = $_POST["descricao"];
                $tipo = (int) $_POST["tipo"]; 

                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif', 'mp4');
                $extensao = pathinfo($_FILES["new_arquivo"]["name"], PATHINFO_EXTENSION);
                $NomeTipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo='$tipo'"));

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_arquivo"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/".$NomeTipo['nome']."/";                 
    
                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            mySqli_query($conexao, "UPDATE artes SET IdTipo='$tipo', TituloArte='$nome', LocalArquivo='$pasta$novoNome', descricao='$descricao' WHERE IdArte=".$_SESSION['IdArte']."");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Falha no Upload!</strong> Por favor, tente novamente. </div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Arquivo inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif', 'mp4'. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                    }
                }
                else {
                    mySqli_query($conexao, "UPDATE artes SET IdTipo='$tipo', TituloArte='$nome', descricao='$descricao' WHERE IdArte=".$_SESSION['IdArte']."");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
                }     
            }

            if(isset($_POST['excluir_arte'])) { 
                mySqli_query($conexao, "DELETE FROM artes WHERE IdArte=".$_SESSION['IdArte'].""); 
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=minhas_artes.php">';
            }

            if(isset($_POST['voltar_arte'])) { 
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
            }
        ?>  

        <?php
            for ($l=1; $l <= $maxC; $l++) { 
                if(isset($_POST["coment$l"])) { 
                    $_SESSION['IdComentario'] = $l;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_coment').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['add_coment'])){
                $comentario = $_POST['comentario'];

                if ($comentario != "") {
                    mySqli_query($conexao, "INSERT INTO artes_comentarios (IdUsuario, IdArte, texto) VALUES('$usuario', ".$_SESSION['IdArte'].", '$comentario')");

                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte']."")); 
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
                }
            }

            if(isset($_POST['excluir_coment'])) { 
                mySqli_query($conexao, "DELETE FROM artes_comentarios WHERE IdComentario=".$_SESSION['IdComentario']."");
                
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
            }
        ?>

        <div class="modal fade" id="descricao_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    
                    <div class='modal-header'>
                        <button class="descricao" type="button" data-toggle="modal" data-target="#editar_arte" data-title='Editar' style='float:left;'> <span class="glyphicon glyphicon-pencil"></span> </button>
                        <button class="descricao" type="button" data-toggle="modal" data-target="#excluir_arte" data-title='Excluir' style='float:left;'> <span class="glyphicon glyphicon-trash"></span> </button>
                        
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <?php echo "<h4 class='modal-title'>".$DadosArte['TituloArte']."</h4>"; ?>
                    </div>

                    <div class='modal-body'>
                        <div class='row'> 
                            <div class='col-sm-6' align='center'>
                                <?php 
                                   if ($DadosArte['IdTipo'] == 4) { 
                                    echo "<div id='descricao'> <video id='img_arte' controls> <source src='".$DadosArte['LocalArquivo']."' type='video/mp4'></video> </div>";
                                    }
                                    else {echo "<div id='descricao'> <img src='".$DadosArte['LocalArquivo']."'> </div>";}  

                                    echo "<button type='text' style='width:250px;'> Autor(a): ".$select['usuario']." </button>
                                        <button type='text' style='width:250px;'> Descrição: ".$DadosArte['Descricao']." </button>";
                                ?>
                            </div>

                            <div class='col-sm-6' align='center'>
                                <label> Comentarios: </label><br>
                                
                                <div style="height: 280px; overflow-y: scroll;">
                                    <?php 
                                        for ($i=1; $i <= $maxC; $i++) { 
                                            $comentario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario, texto FROM artes_comentarios WHERE IdComentario='$i' AND IdArte=".$DadosArte['IdArte'].""));                                               
                                            
                                            if ($comentario != "") {
                                                $meu_coment = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario FROM artes_comentarios WHERE IdComentario='$i' AND IdUsuario='$usuario'")); 

                                                if ($meu_coment['IdComentario'] != "") {
                                                    echo "<form action='galeria.php' method='post'>
                                                            <div id='comentario'>
                                                                <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$comentario['texto']." </button>
                                                                <button type='submit' class='icon' name='coment".$i."' data-title='Excluir' style='margin: 5px;'> <span class='glyphicon glyphicon-trash'></span> </button>
                                                            </div>
                                                        </form>"; 
                                                }
                                                else {
                                                    echo "<div id='comentario'><button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$comentario['texto']." </button></div>"; 
                                                }  
                                            } 
                                        } 
                                    ?>
                                </div>
                            </div>
                        </div><br>
                        
                        <div class='row'>
                            <form action='minhas_artes.php' method='post'>
                                <div class='form-group' align='center' id='comentario' style='margin: 20px;'>
                                    <textarea name="comentario" rows="1" placeholder='Escrever Comentario' class='icon' style='width:70%; float: left;'></textarea>
                                    <input type='submit' name='add_coment' value='Enviar' style='width: 100px;'>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class='modal-footer'></div>
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
                        <div class="row">
                            <form action='minhas_artes.php' method='post' enctype="multipart/form-data">                                 
                                <div class='form-group' align="center">
                                    <div class="col-sm-2" align="left"><label> Imagem: </label></div>
                                    <div class="col-sm-10" align="left"><input type="file" name="new_arquivo" style='width:-webkit-fill-available;'></div>
                                    
                                    <div class="col-sm-2" align="left"><label> Nome: </label></div>
                                    <div class="col-sm-10" align="left"><?php echo "<input type='text' name='nome' value='".$DadosArte['TituloArte']."' style='width:-webkit-fill-available;'>";?></div>
                                    
                                    <div class="col-sm-2" align="left"><label> Tipo: </label></div>
                                    <div class="col-sm-10" align="left">
                                        <?php 
                                            $NomeTipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo=".$DadosArte['IdTipo'].""));
                                            
                                            echo "<select name='tipo' style='width:-webkit-fill-available;'> <option value=".$DadosArte['tipo'].">".$NomeTipo['nome']."</option>";      
                                            for ($i=1; $i <= $maxT; $i++) { 
                                                if ($i != $DadosArte['tipo']) {
                                                    $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo=$i"));  
                                                    echo "<option value='$i'>". $tipo['nome'] ."</option>";
                                                }  
                                            } echo "</select>";
                                        ?>
                                    </div>

                                    <div class="col-sm-2" align="left"><label> Descrição: </label></div>
                                    <div class="col-sm-10" align="left"><?php echo "<textarea name='descricao' rows='3' style='width:-webkit-fill-available;'>".$DadosArte['descricao']."</textarea>";?></div>

                                    <div align="center"> <input type='submit' name='edt_arte' value='Editar'> </div>                                    
                                </div>
                            </form>
                        </div>
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
                        <form action='minhas_artes.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir essa arte? </label> <br>
                                <input type='submit' name='excluir_arte' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_arte' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_coment" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Excluir Comentario</h4>
                    </div>

                    <div class="modal-body">
                        <form action='minhas_artes.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse comentario?</label> <br>
                                <input type='submit' name='excluir_coment' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_arte' value='Voltar' style='width: 120px;'>
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