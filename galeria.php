<?php 
    include_once("Conexao/conexao.php");
    session_start(); 

    $usuario = $_SESSION['IdUsuario']; 

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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="icon" href="Arquivos/VisArt/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="CSS/estilos.css">
</head>

<body>
    <header class="container-fluid"><br>
        <div class="row" id="header">     
            <div class="col-sm-2" style="padding: 10px;" align="center"> <img src="Arquivos/VisArt/marca.png" class="img-responsive" width="150"> </div>
            
            <div class="col-sm-7" style="padding: 1.5% 1.5% 10px;" align="center">
                <a class="col-sm-2" href="home.php">Home</a>
                <a class="col-sm-2" href="galeria.php">Galeria</a>
                <a class="col-sm-2" href="grupos.php">Grupos</a>
                <?php 
                    if ($usuario == "") { echo "<a class='col-sm-2' href='login.php'>Login</a>"; }
                    else { echo "<a class='col-sm-2' href='perfil.php'>Perfil</a>"; }
                ?>
            </div>

            <div class="col-sm-3" style="padding: 1.5% 1.5% 10px;" align="right">   
                <form id="buscar" action="galeria.php" method='post'>
                    <input id="text_busca" type="text" name="texto" placeholder="Buscar artes" style="width: 80%">
                    <button class="icon" type="submit" name="buscar" style="margin: 0; padding: 0px 5px 5px;"> <span class="glyphicon glyphicon-search"></span> </button> 
                </form>
            </div>
        </div><br>
        <div class="row" id="titulo" style="padding: 10px;"> Galeria </div>
    </header>
    
    <section class="container-fluid">
        <div class="row" align="right">     
            <div class="col-sm-7" style="padding: 20px 25px 0px 25px;">
                <form id="buscar" action='galeria.php' method='post'>
                    <label style="padding: 0px 0px 0px 10px; margin: 0px;"> Pesquisar: </label>
                    <input class="pesquisar" id="text_busca" type='text' style="width: 65%;">      
                </form>
            </div>
            
            <div class="col-sm-5" style="padding-top: 10px; padding-bottom: 10px;" align="right">
                <?php
                    echo "<form action='galeria.php' method='post'> 
                            <select name='tipo' onchange='this.form.submit()' style='width: -webkit-fill-available;'> 
                                <option> Tipos </option> <option value='0'> Todos </option>";      
                    for ($i=1; $i <= $maxT; $i++) { 
                        $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome from artes_tipos where IdTipo='$i'"));  
                        echo "<option value='$i'>". $tipo['nome'] ."</option>";
                    } 
                    echo "</select></form>";
                ?>
            </div>    
        </div>
        
        <div class="row" id="filtro" style="padding: 10px;">
            <?php
                if(isset($_POST['tipo'])) {
                    $select = $_POST['tipo'];

                    if ($select == 0) {
                        for ($i=1; $i <= $maxA; $i++) { 
                            $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$i'"));
                            
                            if ($arte != "") {
                                echo "<form action='galeria.php' method='post' class='bloco'> <div class='col-sm-4'> 
                                        <h5>".$arte['TituloArte']." <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> <span class='glyphicon glyphicon-option-vertical'></span> </button>";
                                
                                if ($usuario != "") {
                                   echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> <span class='glyphicon glyphicon-heart'></span>
                                            <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label></button>";
                                } 

                                if ($arte['IdTipo'] == 4) { 
                                    echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'> </video> </div></div></form>";
                                }
                                else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'></div> </div></form>";}  
                            }                                  
                        }
                    }
                    else {
                        for ($j=1; $j <= $maxT; $j++) { 
                            if ($select == $j) {
                                for ($l=1; $l <= $maxA; $l++) { 
                                    $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$l' AND IdTipo='$j'"));
                                    
                                    if ($arte != "") {
                                        echo "<form action='galeria.php' method='post' class='bloco'> <div class='col-sm-4'> 
                                                <h5>".$arte['TituloArte']." <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> <span class='glyphicon glyphicon-option-vertical'></span> </button>";
                                        
                                        if ($usuario != "") {
                                           echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> <span class='glyphicon glyphicon-heart'></span>
                                                    <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label></button>";
                                        } 
        
                                        if ($arte['IdTipo'] == 4) { 
                                            echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'> </video> </div></div></form>";
                                        }
                                        else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'></div> </div></form>";}  
                                    }                    
                                }
                            }
                        } 
                    } 
                }
                else if(isset($_POST['buscar'])){
                    $texto = $_POST['texto'];

                    for ($i=1; $i <= $maxA; $i++) { 
                        $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$i' AND TituloArte LIKE '%$texto%'"));
                        
                        if ($arte != "") {
                            echo "<form action='galeria.php' method='post' class='bloco'> <div class='col-sm-4'> 
                                    <h5>".$arte['TituloArte']." <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> <span class='glyphicon glyphicon-option-vertical'></span> </button>";
                            
                            if ($usuario != "") {
                               echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> <span class='glyphicon glyphicon-heart'></span>
                                        <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label></button>";
                            } 

                            if ($arte['IdTipo'] == 4) { 
                                echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'> </video> </div></div></form>";
                            }
                            else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'></div> </div></form>";}    
                        }                                    
                    }
                }
                else {
                    for ($i=1; $i <= $maxA; $i++) { 
                        $arte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdTipo, TituloArte, LocalArquivo, curtidas FROM artes WHERE IdArte='$i'"));
                        
                        if ($arte != "") {
                            echo "<form action='galeria.php' method='post' class='bloco'> <div class='col-sm-4'> 
                                    <h5>".$arte['TituloArte']." <button class='descricao' type='submit' name='desc".$i."' data-title='Descrição'> <span class='glyphicon glyphicon-option-vertical'></span> </button>";
                            
                            if ($usuario != "") {
                               echo "<button class='descricao' type='submit' name='curt".$i."' data-title='Curtir' style='float:left;'> <span class='glyphicon glyphicon-heart'></span> 
                                        <label style='padding: 0px;font-size: 12px;font-weight: lighter;'>".$arte['curtidas']."</label> </button>";
                            } 

                            if ($arte['IdTipo'] == 4) { 
                                echo "</h5> <div id='arte'> <video id='img_arte' controls> <source src='".$arte['LocalArquivo']."' type='video/mp4'></video> </div></div></form>";
                            }
                            else {echo "</h5> <div id='arte'><img id='img_arte' src='".$arte['LocalArquivo']."'></div> </div></form>";}  
                        }                                    
                    }
                }   
            ?>
        </div>
        
        <?php 
            for ($i=1; $i <= $maxA; $i++) { 
                if (isset($_POST["desc$i"])) {
                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte='$i'")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    $_SESSION['IdArte'] = $DadosArte['IdArte'];
                    
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
                }

                if (isset($_POST["curt$i"])){
                    $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT curtidas FROM artes WHERE IdArte='$i'"));
                    $curtidas = (int) $curtidas['curtidas'];
    
                    $curt = $curtidas + 1;
                    $update = mySqli_query($conexao, "UPDATE artes SET curtidas='$curt' WHERE IdArte='$i'");
                    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=galeria.php">';
                }
            } 

            for ($j=1; $j <= $maxC; $j++) { 
                if(isset($_POST["coment$j"])) { 
                    $_SESSION['IdComentario'] = $j;
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#excluir_coment').modal('show'); }); </script>";
                }
            }

            if(isset($_POST['add_coment'])){
                $comentario = $_POST['comentario'];

                if ($comentario != "") {
                    mySqli_query($conexao, "INSERT INTO artes_comentarios(IdUsuario, IdArte, texto) VALUES('$usuario', ".$_SESSION['IdArte'].", '$comentario')");

                    $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte']."")); 
                    $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                    echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
                }
            }

            if(isset($_POST['excluir_coment'])) { 
                mySqli_query($conexao, "DELETE FROM artes_comentarios WHERE IdComentario=".$_SESSION['IdComentario']."");
                
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>";
            }

            if(isset($_POST['voltar'])){
                $DadosArte = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdArte, IdTipo, IdUsuario, TituloArte, LocalArquivo, Descricao, Curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $us = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$DadosArte['IdUsuario'].""));
                echo "<script> document.addEventListener('DOMContentLoaded', function(){ $('#descricao_arte').modal('show'); }); </script>"; 
            }

            if(isset($_POST['curtir'])){
                $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT curtidas FROM artes WHERE IdArte=".$_SESSION['IdArte'].""));
                $curtidas = (int) $curtidas['curtidas'];

                $curt = $curtidas + 1;
                $update = mySqli_query($conexao, "UPDATE artes SET curtidas='$curt' WHERE IdArte=".$_SESSION['IdArte']."");
                echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=galeria.php">';
            }  
        ?>      

    <div class="modal fade" id="descricao_arte" role="dialog">
            <div class="modal-dialog">  
                <div class="modal-content">
                    
                    <div class='modal-header'>
                        <?php 
                            if ($usuario != "") {
                                echo "<form action='galeria.php' method='post'>
                                        <button class='descricao' type='submit' name='curtir' title='curtir' style='float:left;'> 
                                        <span class='glyphicon glyphicon-heart'> ".$DadosArte['Curtidas']."</span> </button>
                                    </form>";
                            }
                        ?>
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

                                    echo "<button type='text' style='width:250px;'> Autor(a): ".$us['Nome']." </button>
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
                        </div>
                        
                        <div class='row'>
                            <form action='galeria.php' method='post'>
                                <?php 
                                    if ($usuario != "") {
                                        echo "<div class='form-group' align='center' id='comentario' style='margin: 25px;'>
                                                <textarea name='comentario' rows='1' placeholder='Escrever Comentario' class='icon' style='width:70%; float: left;'></textarea>
                                                <input type='submit' name='add_coment' value='Enviar' style='width: 100px;'>
                                            </div>";
                                    }
                                ?>
                            </form>
                        </div>
                    </div>

                    <div class='modal-footer'></div>
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
                        <form action='galeria.php' method='post'>
                            <div class='form-group' align="center">
                                <label> Tem certeza que deseja excluir esse comentario?</label> <br>
                                <input type='submit' name='excluir_coment' value='Excluir' style='width: 120px;'>
                                <input type='submit' name='voltar' value='Voltar' style='width: 120px;'>
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
            
            $(".pesquisar").keyup(function(){
                var texto = $(this).val();
                
                $(".bloco").each(function(){
                    var resultado = $(this).text().toUpperCase().indexOf(' '+texto.toUpperCase());
                     
                    if(resultado < 0) { $(this).fadeOut(); }
                    else { $(this).fadeIn(); }
                }); 
            });
        });

        document.getElementById('tipo').addEventListener('change', function() { this.form.submit(); });
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
                <p> Sistema voltado para a exposição de trabalhos de diferentes artistas com o intuito de proporcionar um espaço de integração e colaboração entre os usuários. 
                    Assim sendo um espaço onde possam aprimorar e compartilhar suas habilidades artísticas, tornando-se, não somente um espaço para visibilidade, mas também para aprendizado.
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