<?php 
    include_once("Conexao/conexao.php"); 
    session_start(); 

    $usuario = $_SESSION['usuario'];               
    $select = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome, email, imagem, curtidas FROM usuario WHERE usuario='$usuario'"));

    $maxMembros = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT MAX(IdMembro) AS max FROM membros_grupo"));
    $maxM = (int) $maxMembros['max'];

    $cont = 0;
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
                <form id="buscar" action="galeria.php" method='post'>
                    <input id="text_busca" type="text" name="texto" placeholder="Buscar ..." style="width: 80%">
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
            for ($i=1; $i <= $maxM; $i++) {
                $solicitacao = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT M.IdMembro, G.nome, M.usuario FROM membros_grupo M JOIN grupos G ON M.IdGrupo = G.IdGrupo WHERE M.IdMembro='$i' AND M.solicitacao='1' AND G.Administrador='$usuario'")); 
                
                if ($solicitacao != "") {
                    echo "<div class='row' id='notificacao'>
                            <form action='notificacao.php' method='post'>
                                <div class='col-sm-7'>
                                    <p> O usuário <strong>'".$solicitacao['usuario']."'</strong> enviou uma solicitação para participar do grupo <strong>'".$solicitacao['nome']."'</strong>.</p>
                                </div>
                                
                                <div class='col-sm-5' align='center'>
                                    <input type='submit' name='aceitar$i' value='Aceitar' style='width: 100px; background: none;'>
                                    <input type='submit' name='recusar$i' value='Recusar' style='width: 100px; background: none;'>
                                </div>
                            </form>    
                        </div>"; 
                } 
                else {
                    $cont ++;
                }
                
                if(isset($_POST["aceitar$i"])) { 
                    $update = mySqli_query($conexao, "UPDATE membros_grupo SET solicitacao='0' WHERE IdMembro='$i'");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=notificacao.php">';
                }
    
                if(isset($_POST["recusar$i"])) { 
                    mySqli_query($conexao, "DELETE FROM membros_grupo WHERE IdMembro='$i'");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=notificacao.php">';
                }
            } 

            if ($cont == $maxM) {
                echo "<div class='row' id='notificacao'> <strong> Você não possue nenhuma notificação </strong> </div>";
            }
        ?>
    </section>
    
    <footer class="container-fluid">
        <div class="row" id="footer">
            <div class="col-sm-10"> <p>Instituto Federal Sul-rio-grandense - Campus Gravataí, Curso Técnico em Informética para a Internet. Trabalho de Conclusão de Curso - Fabiana da Silveira Ferreira </p> </div>
            <div class="col-sm-2" style="padding-top: 10px;"> <img src="Arquivos/marca.png" class="img-responsive" width="100" align="right"> </div>
        </div>
    </footer>
</body>
</html>