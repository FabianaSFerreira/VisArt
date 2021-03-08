<?php 
    include_once("Conexao/conexao.php"); 
    session_start();
     
    $_SESSION['IdPerfil'] = "";
    $usuario = $_SESSION['IdUsuario'];  
    
    $maxGrupos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdGrupo) AS max FROM grupos"));
    $maxG = (int) $maxGrupos['max'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <?php include('html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php include('html/header.php');?>
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Grupos </nav>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">
            <div class="col-sm-7" style="padding: 20px 25px;">
                <form id="buscar" action='grupos.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
        </div>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxG; $i++) { 
                    $grupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT TituloGrupo, LocalImagem FROM grupos WHERE IdGrupo='$i'"));

                    if ($grupo != "") {
                        echo "<form class='col-sm-3 bloco' action='grupos.php' method='post'>
                                <h5> <span>".$grupo['TituloGrupo']."</span>                                   
                                <button class='descricao' type='submit' name='bot".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                </button></h5> 
                                <div id='grupo'> <img id='img_grupo' src='".$grupo['LocalImagem']."'> </div>
                            </form>"; 
                    } 
                }
            ?>
        </div> 
        
        <?php 
            for ($i=1; $i <= $maxG; $i++) { 
                if (isset($_POST["bot$i"])) {
                    $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo='$i'")); 
                    $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                    $_SESSION['IdGrupo'] = $DadosGrupo['IdGrupo'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";     
                }
            } 

            if(isset($_POST['solicitar'])) {
                mySqli_query($conexao, "INSERT INTO grupos_usuarios (IdGrupo, IdUsuario, solicitacao) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '1')");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=grupos.php">'; 
            }  
            
            if(isset($_POST['entrar'])) {
                mySqli_query($conexao, "INSERT INTO grupos_usuarios (IdGrupo, IdUsuario, solicitacao) VALUES(".$_SESSION['IdGrupo'].", '$usuario', '0')");

                $DadosGrupo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdGrupo, administrador, LocalImagem, TituloGrupo, descricao, status FROM grupos WHERE IdGrupo=".$_SESSION['IdGrupo']."")); 
                $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosGrupo['administrador'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_grupo').modal('show'); }); </script>";    
            }
        ?>
        
        <div class='modal fade' id='descricao_grupo' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <?php echo "<h4 class='modal-title'>".$DadosGrupo['TituloGrupo']."</h4>"; ?>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>  
                    </div>

                    <div class='modal-body'>
                        <div class='row'> 
                            <?php 
                                echo "<div id='descricao'> <img src='".$DadosGrupo['LocalImagem']."' style='width: -webkit-fill-available;'> </div><br>"; 
                                echo "<button type='text'> Descrição: ".$DadosGrupo['descricao']." </button><br>";
                                echo "<form action='perfil.php' method='post' style='width: -webkit-fill-available; padding: 0px 15px;'>
                                        <input id='usuario' type='submit' name='perfil".$DadosGrupo['administrador']."' value='Administrador(a): ".$admin['Nome']."' style='width: -webkit-fill-available; padding: 10px;'>
                                    </form>";

                                if ($DadosGrupo['status'] == 'aberto') { echo "<button type='text'> Status: Aberto </button>"; }
                                else if ($DadosGrupo['status'] == 'fechado') { echo "<button type='text'> Status: Fechado </button>"; }
                                        
                                $UsGrupos = mySqli_query($conexao, "SELECT IdUsuario FROM grupos_usuarios WHERE IdGrupo=".$DadosGrupo['IdGrupo']." AND Solicitacao='0'");  
                            
                                echo "<select id='descricao'> <option> Membros </option>"; 
                                while($us = mysqli_fetch_array($UsGrupos)) {
                                    $nome = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$us['IdUsuario'].""));
                                    echo "<option>". $nome['Nome'] ."</option>"; 
                                }
                                echo "</select>";
                            ?>
                        </div>  
                    </div>

                    <div class='modal-footer'>
                        <form action='grupos.php' method='post' style="width: -webkit-fill-available;">
                            <div class='form-group align-center' align="center">
                                <?php
                                    if ($usuario != "") {
                                        if ($DadosGrupo['administrador'] != $usuario) {
                                            if ($DadosGrupo['status'] == 'aberto') { echo "<input type='submit' name='entrar' value='Participar do grupo'>"; }
                                            else if ($DadosGrupo['status'] == 'fechado') { echo "<input type='submit' name='solicitar' value='Enviar Solicitação'>"; }
                                        }
                                    } 
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        $(document).ready(function(){
            $(".close").click(function(){ $("#alert").hide(); }); 
            
            $(".pesquisar").keyup(function(){
                var texto = $(this).val();
                
                $(".bloco").each(function(){
                    var nomeGrupo = $(this).find("span").text().toUpperCase()
                    var resultado = nomeGrupo.indexOf(texto.toUpperCase())
                     
                    if(resultado < 0) { $(this).hide(); }
                    else { $(this).show(); }
                }); 
            });
        });
    </script>

    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <?php include('html/footer.html');?>
    </footer>
</body>
</html>