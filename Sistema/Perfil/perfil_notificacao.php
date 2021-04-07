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
        <?php
            $solicitacao = mySqli_query($conexao, "SELECT G.TituloGrupo, GU.IdGrupo, GU.IdUsuario FROM grupos_usuarios GU JOIN grupos G ON GU.IdGrupo=G.IdGrupo WHERE GU.solicitacao='1' AND G.Administrador='$usuario'");  
            $cont = 1;

            while ($sol = mysqli_fetch_array($solicitacao)) { 
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$sol['IdUsuario'].""));

                echo "<form action='perfil_notificacao.php' method='post' style='padding: 10px; width: -webkit-fill-available;'>
                        <div class='row' id='notificacao'>
                            <div class='col-sm-8'>
                                <p> O usuário <strong>'".$us['Nome']."'</strong> enviou uma solicitação para participar do grupo <strong>'".$sol['TituloGrupo']."'</strong>.</p>
                            </div>
                            
                            <div class='col-sm-4' align='center'>
                                <input type='submit' name='aceitar$cont' value='Aceitar' style='width: 100px; background: none;'>
                                <input type='submit' name='recusar$cont' value='Recusar' style='width: 100px; background: none;'>
                            </div> 
                        </div>
                    </form>"; 

                if(isset($_POST["aceitar$cont"])) { 
                    $update = mySqli_query($conexao, "UPDATE grupos_usuarios SET solicitacao='0' WHERE IdUsuario=".$sol['IdUsuario']." AND IdGrupo=".$sol['IdGrupo']."");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_notificacao.php">';
                }
    
                if(isset($_POST["recusar$cont"])) { 
                    mySqli_query($conexao, "DELETE FROM grupos_usuarios WHERE IdUsuario=".$sol['IdUsuario']." AND IdGrupo=".$sol['IdGrupo']."");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=perfil_notificacao.php">';
                }
                
                $cont++;
            } 
            
            if ($cont == 1) {
                echo "<div class='row' id='notificacao'> <strong> Você não possue nenhuma notificação </strong> </div>";
            } 
        ?>
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