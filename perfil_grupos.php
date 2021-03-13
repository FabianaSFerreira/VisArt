<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['IdUsuario'];
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario='$usuario'"));
    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT SUM(Curtidas) AS curt FROM artes WHERE IdUsuario='$usuario'"));
    
    $maxUsuarios = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdUsuario) AS max FROM usuarios"));
    $maxU = (int) $maxUsuarios['max'];

    $maxGrupos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdGrupo) AS max FROM grupos"));
    $maxG = (int) $maxGrupos['max'];

    $maxMensagens = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdMensagem) AS max FROM grupos_mensagens"));
    $maxMsg = (int) $maxMensagens['max'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <?php include('html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php 
            include('html/header.php');
            include('html/header_perfil.php');
        ?>  
    </header>
    
    <section class="container-fluid">
        <div class="row" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxG; $i++) { 
                    $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT G.TituloGrupo, G.LocalImagem FROM grupos G JOIN grupos_usuarios GU ON G.IdGrupo = GU.IdGrupo WHERE G.IdGrupo='$i' AND GU.IdUsuario='$usuario' AND GU.solicitacao='0'"));
    
                    if ($grupo != "") {
                        echo "<form class='col-sm-3' action='meus_grupos.php' method='post'> <h5>".$grupo['TituloGrupo']." 
                                <button class='descricao' type='submit' name='botG".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle-fill' viewBox='0 0 16 16'> <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/> </svg>
                                </button>

                                <button class='descricao' type='submit' name='bp".$i."' data-title='Bate-Papo' style='float:left;'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-text-fill' viewBox='0 0 16 16'> <path d='M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z'/> </svg>
                                </button></h5>
                                 
                                <div id='grupo'> <img id='img_grupo' src='".$grupo['LocalImagem']."'> </div>
                            </form>"; 
                    } 
                }
            ?>
        </div>

        <?php
            if ($_SESSION['Alert'] != "") { 
                echo $_SESSION['Alert'];
                $_SESSION['Alert'] = ""; 
            }

            for ($j=1; $j <= $maxG; $j++) { 
                if (isset($_POST["botG$j"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo='$j'")); 
                    $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";     
                }

                if (isset($_POST["bp$j"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo='$j'")); 
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>";     
                }
            } 

            for ($l=1; $l <= $maxU; $l++) { 
                if (isset($_POST["us$l"])) {
                    $_SESSION['IdUsGrupo'] = $l;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_usuario').modal('show'); }); </script>";      
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
                            mySqli_query($conexao, "UPDATE grupos SET LocalImagem='$pasta$novoNome', TituloGrupo='$nome' descricao='$descricao', status='$status' WHERE IdGrupo=".$_SESSION['IdGrupo']."");
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
                    mySqli_query($conexao, "UPDATE grupos SET TituloGrupo='$nome' descricao='$descricao', status='$status' WHERE IdGrupo=".$_SESSION['IdGrupo']."");
                    
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
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
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";
            } 

            if(isset($_POST['sair_grupo'])) { 
                $delete = mySqli_query($conexao, "DELETE FROM grupos_usuarios WHERE IdGrupo=".$_SESSION['IdGrupo']." AND IdUsuario='$usuario'");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_grupos.php">';
            }

            if(isset($_POST['excluir_usuario'])) {
                $delete = mySqli_query($conexao, "DELETE FROM grupos_usuarios WHERE IdUsuario=".$_SESSION['IdUsGrupo']." AND IdGrupo=".$_SESSION['IdGrupo']."");

                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";
            } 
        ?>  

        <?php
            for ($l=1; $l <= $maxMsg; $l++) { 
                if(isset($_POST["msg$l"])) { 
                    $_SESSION['IdMensagem'] = $l;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_mensagem').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['add_mensagem'])){
                $mensagem = $_POST['mensagem'];

                if ($mensagem != "") {
                    mySqli_query($conexao, "INSERT INTO grupos_mensagens(IdGrupo, IdUsuario, texto) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '$mensagem')");

                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>"; 
                }
            }

            if(isset($_POST['excluir_msg'])) { 
                mySqli_query($conexao, "DELETE FROM grupos_mensagens WHERE IdMensagem=".$_SESSION['IdMensagem']."");
                
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>";
            }

            if(isset($_POST['voltar_bp'])){
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#bate_papo').modal('show'); }); </script>"; 
            }
        ?>  

        <div class='modal fade' id='descricao_grupo' role='dialog'>
            <?php include('html/modal_grupos.php');?>
        </div>

        <div class="modal fade" id="editar_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Editar Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post' enctype="multipart/form-data">
                            <div class='form-group' align="center">
                                <div style="float: left;"><label> Imagem: </label></div>
                                <div><input type="file" name="new_imagem" style='width:-webkit-fill-available;'></div>

                                <div style="float: left;"><label> Nome: </label></div>
                                <div><?php echo "<input type='text' name='nome' value='".$DadosGrupo['TituloGrupo']."' style='width:-webkit-fill-available;'>";?></div>

                                <div style="float: left;"><label> Descrição: </label></div>
                                <div><?php echo "<textarea name='descricao' rows='3' style='width:-webkit-fill-available;'>".$DadosGrupo['descricao']."</textarea>";?></div>

                                <div style="float: left;"><label> Status: </label></div>
                                <div>
                                    <?php 
                                        echo "<select name='status' style='width:-webkit-fill-available;'>";
                                        if ($DadosGrupo['status'] == "aberto") { echo "<option value='1'> Aberto </option> <option value='2'> Fechado </option> </select>"; } 
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
                        <h4 class="modal-title">Excluir Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
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

        <div class="modal fade" id="sair_grupo" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sair do Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja sair do grupo? </label> <br>
                                <input type='submit' name='sair_grupo' value='Sair' style='width: 120px;'>
                                <input type='submit' name='voltar_grupo' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_usuario" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Usuario</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse usuário do grupo? </label> <br>
                                <input type='submit' name='excluir_usuario' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_grupo' value='Voltar' style='width: 120px;'>
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class='modal fade' id='bate_papo' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <?php echo "<h4 class='modal-title'> Bate-Papo - ".$DadosGrupo['TituloGrupo']."</h4>"; ?>                     
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    </div>

                    <div class='modal-body'>
                        <div class='row' id="sala_BP">
                            <?php 
                                for ($l=$maxMsg; $l > 0; $l--) { 
                                    $mensagem = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario, texto FROM grupos_mensagens WHERE IdMensagem='$l' AND IdGrupo=".$DadosGrupo['IdGrupo'].""));                                               

                                    if ($mensagem != "") {
                                        $msg = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdMensagem FROM grupos_mensagens WHERE IdMensagem='$l' AND IdUsuario='$usuario'")); 
                                        $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$mensagem['IdUsuario'].""));

                                        if ($msg['IdMensagem'] != "") {
                                            echo "<form action='meus_grupos.php' method='post'>
                                                    <div id='mensagem' style='width:-webkit-fill-available; float:right; margin:10px;'>
                                                        <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$mensagem['texto']." </button>
                                                        <button type='submit' class='icon' name='msg".$l."' data-title='Excluir' style='margin: 5px;'> 
                                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/> </svg>
                                                        </button>
                                                    </div>
                                                    <p style='width:50%;float:right;margin: 0px 15px;text-align: right;'>".$us['Nome']."</p>
                                                </form>"; 
                                        }
                                        else {
                                            echo "<div>
                                                    <div id='mensagem' style='width:-webkit-fill-available; float:left; margin:10px;'> <button type='text' class='icon' style='width:70%; float:none; margin:5px;'> ".$mensagem['texto']." </button> </div>
                                                    <p style='width:50%;float:left;margin: 0px 15px;'>".$us['Nome']."</p>
                                                </div>"; 
                                        }  
                                    } 
                                } 
                            ?>
                        </div> 
                    </div>

                    <div class='modal-footer' style="justify-content: center;">
                        <form action='meus_grupos.php' method='post'>
                            <?php 
                                if ($usuario != "") {
                                    echo "<div class='form-group row align-items-center'>
                                            <textarea class='col-7' name='mensagem' rows='1' placeholder='Escrever mensagem'></textarea>
                                            <input class='col-3' type='submit' name='add_mensagem' value='Enviar' style='width: 100px;'>
                                        </div>";
                                }
                            ?>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_mensagem" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Mensagem</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_grupos.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir essa mensagem?</label> <br>
                                <input type='submit' name='excluir_msg' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar_bp' value='Voltar' style='width: 120px;'>
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
        <?php include('html/footer.html');?>
    </footer>
</body>
</html>