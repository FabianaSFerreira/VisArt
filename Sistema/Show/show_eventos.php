<?php
    //Projeto VisArt - Trabalho de conclusão de curso
    //Autor: Fabiana da Silvaira Ferreira
    //Ano: 2020-2021


    include_once("../../Conexao/conexao.php");
    session_start(); 
    include('../../Conexao/max.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head> 
    <?php include('../html/head.html');?>
</head>

<body>
    <header class="container-fluid"><br>
        <?php include('../html/header.php');?>
        <nav lass="navbar navbar-expand-lg navbar-light bg-light" id="titulo"> Eventos </nav>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">
            <div class="col-sm-7" style="padding: 20px 25px;">
                <form id="buscar" action='show_eventos.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
        </div>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                $event = mySqli_query($conexao, "SELECT IdEvento, NomeEvento, LocalImagem FROM evento ORDER BY data DESC");
                
                while($evento = mysqli_fetch_array($event)){
                    echo "<form class='col-sm-3 bloco' action='show_eventos.php' method='post'>
                            <h5> <span>".$evento['NomeEvento']."<span>                                   
                            <button class='descricao' type='submit' name='bot".$evento['IdEvento']."' data-title='Descrição'> 
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-square-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z'/></svg>
                            </button></h5> 
                            <div id='grupo'> <img id='img_grupo' src='".$evento['LocalImagem']."'> </div>
                        </form>"; 
                }
            ?>
        </div> 
        
        <?php 
            for ($i=1; $i <= $maxE; $i++) { 
                if (isset($_POST["bot$i"])) {
                    $DadosEvento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario, NomeEvento, Organizador, Endereco, Data, Hora, Descricao, LocalImagem FROM evento WHERE IdEvento='$i'")); 
                    $participantes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdEvento) AS part FROM eventos_usuarios WHERE IdEvento='$i'"));
                    $_SESSION['IdEvento'] = $i;
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_evento').modal('show'); }); </script>";     
                }
            } 
            
            if(isset($_POST['presenca'])) {
                $insert = mySqli_query($conexao, "INSERT INTO eventos_usuarios(IdEvento, IdUsuario) VALUES (".$_SESSION['IdEvento'].", '$usuario')"); 
                
                $DadosEvento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario, NomeEvento, Organizador, Endereco, Data, Hora, Descricao, LocalImagem FROM evento WHERE IdEvento='$i'")); 
                $participantes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdEvento) AS part FROM eventos_usuarios WHERE IdEvento='$i'"));
                
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_evento').modal('show'); }); </script>";
            }
        ?>
        
        <div class='modal fade' id='descricao_evento' role='dialog'>
            <?php include('../modal/modal_eventos.php');?>
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
        <?php include('../html/footer.html');?>
    </footer>
</body>
</html>