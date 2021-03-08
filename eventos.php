<?php 
    include_once("Conexao/conexao.php"); 
    session_start();
     
    $_SESSION['IdPerfil'] = "";
    $usuario = $_SESSION['IdUsuario'];  
    
    $maxEventos = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdEvento) AS max FROM evento"));
    $maxE = (int) $maxEventos['max'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <?php include('html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php include('html/header.php');?>
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Eventos </nav>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">
            <div class="col-sm-7" style="padding: 20px 25px;">
                <form id="buscar" action='eventos.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
        </div>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxE; $i++) { 
                    $evento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT NomeEvento, LocalImagem FROM evento WHERE IdEvento='$i'"));

                    if ($evento != "") {
                        echo "<form class='col-sm-3 bloco' action='eventos.php' method='post'>
                                <h5> <span>".$evento['NomeEvento']."<span>                                   
                                <button class='descricao' type='submit' name='bot".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                                </button></h5> 
                                <div id='grupo'> <img id='img_grupo' src='".$evento['LocalImagem']."'> </div>
                            </form>"; 
                    } 
                }
            ?>
        </div> 
        
        <?php 
            for ($i=1; $i <= $maxE; $i++) { 
                if (isset($_POST["bot$i"])) {
                    $DadosEvento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdEvento, Criador, LocalImagem, NomeEvento, descricao, participantes FROM evento WHERE IdEvento='$i'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosEvento['Criador'].""));
                    $_SESSION['IdEvento'] = $DadosEvento['IdEvento'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_evento').modal('show'); }); </script>";     
                }
            } 
            
            if(isset($_POST['presenca'])) {
                $insert = mySqli_query($conexao, "INSERT INTO eventos_usuarios(IdEvento, IdUsuario) VALUES (".$_SESSION['IdEvento'].", '$usuario')");
                $count = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdUsuario) AS count FROM eventos_usuarios WHERE IdEvento=".$_SESSION['IdEvento'].""));
                $update = mySqli_query($conexao, "UPDATE evento SET participantes=".$count['count']." WHERE IdEvento=".$_SESSION['IdEvento']."");
                
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=eventos.php">';
            }
        ?>
        
        <div class='modal fade' id='descricao_evento' role='dialog'>
            <div class='modal-dialog'>  
                <div class='modal-content'>   

                    <div class='modal-header'>
                        <?php echo "<h4 class='modal-title'>".$DadosEvento['NomeEvento']."</h4>"; ?>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>  
                    </div>

                    <div class='modal-body'>
                        <div class='row'> 
                            <?php 
                                echo "<div id='descricao'> <img src='".$DadosEvento['LocalImagem']."' style='width: -webkit-fill-available;'> </div><br>"; 
                                echo "<button type='text'> Descrição: ".$DadosEvento['descricao']." </button><br>";
                                
                                echo "<form action='perfil.php' method='post' style='width: -webkit-fill-available; padding: 0px 15px;'>
                                        <input id='usuario' type='submit' name='perfil".$DadosEvento['Criador']."' value='Criador(a): ".$us['Nome']."' style='width: -webkit-fill-available; padding: 10px;'>
                                    </form>";
                                
                                echo "<button type='text'> Número de participantes: ".$DadosEvento['participantes']." </button><br>";                                      
                            ?>
                        </div>  
                    </div>

                    <div class='modal-footer'>
                        <form action='eventos.php' method='post' style="width: -webkit-fill-available;">
                            <div class='form-group align-center' align="center">
                                <?php
                                    $presenca = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario FROM eventos_usuarios WHERE IdEvento=".$_SESSION['IdEvento']." AND IdUsuario='$usuario'"));

                                    if ($usuario != "" && $presenca == "") {
                                        echo "<input type='submit' name='presenca' value='Confirmar presença no evento'>";
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
                    var nomeEvento = $(this).find("span").text().toUpperCase()
                    var resultado = nomeEvento.indexOf(texto.toUpperCase())
                     
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