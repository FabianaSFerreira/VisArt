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
                        echo "<form action='meus_eventos.php' method='post'>
                                <div class='col-sm-3'> 
                                    <h5>".$grupo['TituloGrupo']." 
                                        <button class='descricao' type='submit' name='botG".$i."' data-title='Descrição'> <span class='glyphicon glyphicon-option-vertical'></span> </button>
                                        <button class='descricao' type='submit' name='bp".$i."' data-title='Bate-Papo' style='float:left;'> <span class='glyphicon glyphicon-comment'></span> </button>
                                    </h5> 
                                    <div id='grupo'> <img id='img_grupo' src='".$grupo['LocalImagem']."'> </div>
                                </div>
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
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";     
                }

                if (isset($_POST["bp$j"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, TituloGrupo FROM grupos WHERE IdGrupo='$j'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
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
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_eventos.php">';
                        }
                        else {
                            $_SESSION['Alert'] =  "<div id='alert'> <button type='button' class='close'>&times;</button><strong>Falha no Upload!</strong> Por favor, tente novamente.</div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_eventos.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] =  "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_eventos.php">';
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
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_eventos.php">';
                }
            }

            if(isset($_POST['voltar_grupo'])) { 
                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";
            } 

            if(isset($_POST['sair_grupo'])) { 
                $delete = mySqli_query($conexao, "DELETE FROM grupos_usuarios WHERE IdGrupo=".$_SESSION['IdGrupo']." AND IdUsuario='$usuario'");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=meus_eventos.php">';
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

        <div class='modal fade' id='descricao_evento' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <?php 
                            $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT administrador FROM grupos WHERE IdGrupo=".$DadosGrupo['IdGrupo']." AND administrador='$usuario'"));

                            if ($admin != "") {
                                echo "<button class='descricao' type='button' data-toggle='modal' data-target='#editar_grupo' data-title='Editar' style='float:left;'> <span class='glyphicon glyphicon-pencil'></span> </button>
                                    <button class='descricao' type='button' data-toggle='modal' data-target='#excluir_grupo' data-title='Excluir' style='float:left;'> <span class='glyphicon glyphicon-trash'></span> </button>";
                            }
                        ?>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <?php echo "<h4 class='modal-title'>".$DadosGrupo['TituloGrupo']."</h4>"; ?>
                    </div>

                    <div class='modal-body'>
                        <div class='row'> 
                            <div class='col-sm-6' align='center'>
                                <?php echo "<div id='descricao'> <img src='".$DadosGrupo['LocalImagem']."'> </div>"; ?>
                            </div>

                            <div class='col-sm-6' align='center'>
                                <?php
                                    echo "<button type='text'> Descrição: ".$DadosGrupo['descricao']." </button><br>";
                                    echo "<button type='text'> Administrador: ".$us['Nome']." </button><br>";

                                    if ($DadosGrupo['status'] == 'aberto') { echo "<button type='text'> Status: Aberto </button>"; }
                                    else if ($DadosGrupo['status'] == 'fechado') { echo "<button type='text'> Status: Fechado </button>"; }
                                    
                                    $UsGrupos = mySqli_query($conexao, "SELECT IdUsuario FROM grupos_usuarios WHERE IdGrupo=".$DadosGrupo['IdGrupo']." AND Solicitacao='0'");  

                                    if ($admin != "") {
                                        echo "<div id='membros' style='width: 250px; margin: 10px 10px 0px;'> <label style='padding: inherit;'> Membros do grupo: </label>";
                                        while($us = mysqli_fetch_array($UsGrupos)) {
                                            $nome = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$us['IdUsuario'].""));

                                            if ($us['IdUsuario'] == $admin['administrador']) {
                                                echo "<button type='text' class='icon' style='width:70%; float: none; margin: 0px;'> ".$nome['Nome']." </button>";
                                            }
                                            else {
                                                echo "<form action='meus_eventos.php' method='post'>                                 
                                                        <button type='text' class='icon' style='width:70%; float: none; margin: 0px;'> ".$nome['Nome']." </button>
                                                        <button type='submit' class='icon' name='us".$us['IdUsuario']."' data-title='Excluir' style='margin: 0px;'> <span class='glyphicon glyphicon-trash'></span> </button>                                                   
                                                    </form>"; 
                                            }  
                                        }
                                        echo "</div>";
                                    }
                                    else {
                                        echo "<select> <option> Membros </option>"; 
                                        while($us = mysqli_fetch_array($UsGrupos)) {
                                            $nome = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$us['IdUsuario'].""));
                                            echo "<option>". $nome['Nome'] ."</option>"; 
                                        }
                                        echo "</select>";

                                        echo "<button type='button' data-toggle='modal' data-target='#sair_grupo' style='background-image: radial-gradient(circle, #f9cb9c, #f0a963, #ff9900);'> Sair do Grupo </button>";
                                    }
                                ?>
                            </div>
                        </div>     
                    </div>

                    <div class='modal-footer'></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editar_evento" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar Grupo</h4>
                    </div>

                    <div class="modal-body">
                        <form action='meus_eventos.php' method='post' enctype="multipart/form-data" style="padding: 10px; width: -webkit-fill-available;">
                            <div class='form-group' align="center" style='margin: 0;'>
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

                                <div> <input type='submit' name='edt_grupo' value='Editar'> </div> 
                            </div>  
                        </form>       
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="excluir_evento" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Excluir Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_eventos.php' method='post'>
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

        <div class="modal fade" id="sair_evento" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sair do Grupo</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <form action='meus_eventos.php' method='post'>
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
                        <form action='meus_eventos.php' method='post'>
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
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <?php echo "<h4 class='modal-title'> Bate-Papo - ".$DadosGrupo['TituloGrupo']."</h4>"; ?>
                    </div>

                    <div class='modal-body'>
                        <div class='row' id="sala_BP">
                            <?php 
                                for ($l=$maxMsg; $l > 0; $l--) { 
                                    $mensagem = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdMensagem, IdUsuario, texto FROM grupos_mensagens WHERE IdMensagem='$l' AND IdGrupo=".$DadosGrupo['IdGrupo'].""));                                               

                                    if ($mensagem != "") {
                                        $meu_msg = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdMensagem FROM grupos_mensagens WHERE IdMensagem='$l' AND IdUsuario='$usuario'")); 
                                        $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$mensagem['IdUsuario'].""));

                                        if ($meu_msg['IdMensagem'] != "") {
                                            echo "<form action='meus_eventos.php' method='post'>
                                                    <div id='mensagem' style='width:50%; float:right; margin:10px;'>
                                                        <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$mensagem['texto']." </button>
                                                        <button type='submit' class='icon' name='msg".$l."' data-title='Excluir' style='margin: 5px;'> <span class='glyphicon glyphicon-trash'></span> </button>
                                                    </div>
                                                    <p style='width:50%;float:right;margin: 0px 15px;text-align: right;'>".$us['Nome']."</p>
                                                </form>"; 
                                        }
                                        else {
                                            echo "<div>
                                                    <div id='mensagem' style='width:50%; float:left; margin:10px;'> <button type='text' class='icon' style='width:70%; float:none; margin:5px;'> ".$mensagem['texto']." </button> </div>
                                                    <p style='width:50%;float:left;margin: 0px 15px;'>".$us['Nome']."</p>
                                                </div>"; 
                                        }  
                                    } 
                                } 
                            ?>
                        </div> 

                        <div class='row'>
                            <form action='meus_eventos.php' method='post'>
                                <div class='form-group' align='center' id='mensagem' style='margin: 20px;'>
                                    <textarea name="mensagem" rows="1" placeholder='Escrever Mensagem' class='icon' style='width:70%; float:left;'></textarea>
                                    <input type='submit' name='add_mensagem' value='Enviar' style='width: 100px;'>
                                </div>
                            </form>
                        </div>    
                    </div>

                    <div class='modal-footer'></div>
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
                        <form action='meus_eventos.php' method='post'>
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