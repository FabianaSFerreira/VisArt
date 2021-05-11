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
        <?php 
            include('../html/header.php');
            include('../html/header_perfil.php');
        ?>  
    </header>
    
    <section class="container-fluid">
        <div class="row" style="padding: 10px;">
            <?php
                for ($i=1; $i <= $maxE; $i++) { 
                    if($perfil != "") { $evento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT E.NomeEvento, E.LocalImagem FROM evento E JOIN eventos_usuarios EU ON E.IdEvento=EU.IdEvento WHERE E.IdEvento='$i' AND EU.IdUsuario='$perfil'"));}
                    else { $evento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT E.NomeEvento, E.LocalImagem FROM evento E JOIN eventos_usuarios EU ON E.IdEvento=EU.IdEvento WHERE E.IdEvento='$i' AND EU.IdUsuario='$usuario'"));}
                    
    
                    if ($evento != "") {
                        echo "<form class='col-sm-3' action='perfil_eventos.php' method='post'> <h5>".$evento['NomeEvento']." 
                                <button class='descricao' type='submit' name='bot".$i."' data-title='Descrição'> 
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle-fill' viewBox='0 0 16 16'> <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/> </svg>
                                </button></h5>
                                 
                                <div id='evento'> <img id='img_evento' src='../../".$evento['LocalImagem']."'> </div>
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

            for ($i=1; $i <= $maxE; $i++) { 
                if (isset($_POST["bot$i"])) {
                    $DadosEvento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario, NomeEvento, Organizador, Endereco, Data, Hora, Descricao, LocalImagem FROM evento WHERE IdEvento='$i'")); 
                    $participantes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdEvento) AS part FROM evento WHERE IdEvento='$i'"));
                    $_SESSION['IdEvento'] = $i;
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_evento').modal('show'); }); </script>";     
                }
            } 

            if(isset($_POST['edt_evento'])){
                $nome = $_POST["nome"];
                $org = $_POST["org"];
                $end = $_POST["end"];
                $data = $_POST["data"];
                $hora = $_POST["hora"];
                $descricao = $_POST["descricao"];
                
                $formatosPermitidos = array('png', 'jpeg', 'jpg', 'gif');
                $extensao = pathinfo($_FILES["new_imagem"]["name"], PATHINFO_EXTENSION);

                if ($extensao != "") {
                    if(in_array($extensao, $formatosPermitidos)) {
                        $arquivo = $_FILES["new_imagem"]["tmp_name"];
                        $novoNome = uniqid().".$extensao";
                        $pasta = "Arquivos/Eventos/";                

                        if (move_uploaded_file($arquivo, $pasta.$novoNome)) {
                            mySqli_query($conexao, "UPDATE evento SET NomeEvento='$nome', Organizador='$org', Endereco='$end', Data='$data', Hora='$hora', Descricao='$descricao', LocalImagem='$pasta$novoNome' WHERE IdEvento=".$_SESSION['IdEvento']."");
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_eventos.php">';
                        }
                        else {
                            $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button><strong>Falha no Upload!</strong> Por favor, tente novamente.</div>"; 
                            echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_eventos.php">';
                        }    
                    }
                    else {
                        $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Formato de Imagem inválido!</strong> O sistema suporta os siguintes formatos: 'png', 'jpeg', 'jpg', 'gif'. </div>"; 
                        echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_eventos.php">';
                    }
                } 
                else {
                    mySqli_query($conexao, "UPDATE evento SET NomeEvento='$nome', Organizador='$org', Endereco='$end', Data='$data', Hora='$hora', Descricao='$descricao' WHERE IdEvento=".$_SESSION['IdEvento']."");
                    
                    $DadosEvento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario, NomeEvento, Organizador, Endereco, Data, Hora, Descricao, LocalImagem FROM evento WHERE IdEvento=".$_SESSION['IdEvento']."")); 
                    $participantes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdEvento) AS part FROM evento WHERE IdEvento='$i'"));
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_evento').modal('show'); }); </script>"; 
                }  
            } 

            if(isset($_POST['excluir_evento'])) { 
                $delete = mySqli_query($conexao, "DELETE FROM evento WHERE IdEvento=".$_SESSION['IdEvento']."");
                
                if ($delete != "") {
                    $_SESSION['Alert'] = "<div id='alert'> <button type='button' class='close'>&times;</button> <strong>Evento deletado com sucesso!</strong> </div>"; 
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_eventos.php">';
                }
            }

            if(isset($_POST['voltar_evento'])) { 
                $DadosEvento = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdUsuario, NomeEvento, Organizador, Endereco, Data, Hora, Descricao, LocalImagem FROM evento WHERE IdEvento=".$_SESSION['IdEvento']."")); 
                $participantes = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdEvento) AS part FROM evento WHERE IdEvento='$i'"));
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
        });
    </script>
    
    <footer class="container" style="margin: 15px; width: auto; max-width: max-content;">
        <?php include('../html/footer.html');?>
    </footer>
</body>
</html>