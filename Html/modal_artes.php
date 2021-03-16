<div class="modal-dialog">  
    <div class="modal-content">
        
        <div class='modal-header'>
            <?php echo "<h4 class='modal-title'>".$DadosArte['TituloArte']."</h4>"; ?>
            <button type='button' class='close' data-dismiss='modal'>&times;</button>
        </div>

        <div class='modal-body' align='center'>
            <div class='row'>                                
                <div class='row' style='width: -webkit-fill-available; margin: 10px;'>
                    <?php
                        $curtidas = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT COUNT(IdArte) AS curt FROM artes_curtidas WHERE IdArte=".$DadosArte['IdArte']." AND Curtida='1'"));

                        if (($usuario != "") && ($_SESSION['IdPerfil'] == "") && ($pag != "show_artes.php") && ($pag != "home.php")) {  
                            if($DadosArte['IdUsuario'] == $usuario) {
                                echo '<button class="descricao col-1" type="button" data-toggle="modal" data-target="#editar_arte" data-title="Editar"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/> </svg>
                                    </button>
            
                                    <button class="descricao col-1" type="button" data-toggle="modal" data-target="#excluir_arte" data-title="Excluir"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/> </svg>
                                    </button>';
                            }
                        }

                        if ($usuario != "") {
                            echo "<form action='".$pag."' method='post' class='col'>
                                    <button class='descricao' type='submit' name='curt".$DadosArte['IdArte']."' data-title='curtir'> 
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> 
                                            <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/>
                                        </svg> &nbsp ".$curtidas['curt']."
                                    </button>
                                </form>";
                        }
                    ?>
                </div>

                <?php
                    if ($DadosArte['IdTipo'] == 4) { 
                        echo "<div id='descricao'> <video id='img_arte' controls> <source src='".$DadosArte['LocalArquivo']."' type='video/mp4' style='width: -webkit-fill-available;'></video> </div>";
                    }
                    else {echo "<div id='descricao'> <img src='".$DadosArte['LocalArquivo']."' style='width: -webkit-fill-available;'> </div>";}  
                    
                    echo "<form action='perfil.php' method='post' style='width: -webkit-fill-available; padding: 0px 15px;'>
                                <input id='usuario' type='submit' name='perfil".$DadosArte['IdUsuario']."' value='Autor(a): ".$us['Nome']."' style='width: -webkit-fill-available; padding: 10px;'>
                            </form>";

                    echo "<button type='text'> Descrição: ".$DadosArte['Descricao']." </button>"; 
                ?>

                <div class="row" id='descricao' style="margin-top: 20px;">
                    <label> Comentarios: </label><br>
                    
                    <div id='scroll_coment'>
                        <?php 
                            $comentarios = mySqli_query($conexao, "SELECT IdComentario, IdUsuario, texto FROM artes_comentarios WHERE IdArte=".$DadosArte['IdArte']."");                                               
                            
                            while($coment = mysqli_fetch_array($comentarios)) {
                                if ($coment != "") {
                                    if ($coment['IdUsuario'] == $usuario) {
                                        echo "<form action='".$pag."' method='post'>
                                                <div id='comentario'>
                                                    <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$coment['texto']." </button>
                                                    <button type='submit' class='icon' name='coment".$coment['IdComentario']."' data-title='Excluir' style='margin: 5px; padding-top: 10px;'> 
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/> </svg>
                                                    </button>
                                                </div>
                                            </form>"; 
                                    }
                                    else {
                                        echo "<div id='comentario'><button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$coment['texto']." </button></div>"; 
                                    }  
                                } 
                            } 
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class='modal-footer' style="justify-content: center;">
            <?php echo "<form action='".$pag."' method='post' style='width:-webkit-fill-available;'>"; ?>
                <?php 
                    if ($usuario != "") {
                        echo "<div class='form-group row align-items-center' style='margin: auto;'>
                                <textarea class='col' name='comentario' rows='2' placeholder='Comente...'></textarea>
                                <input class='col-2' type='submit' name='add_coment' value='Enviar'>
                            </div>";
                    }
                ?>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editar_arte" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content">
        <div class="modal-header">
                <h4 class="modal-title">Editar Arte</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <form action='perfil_artes.php' method='post' enctype="multipart/form-data" style="padding: 10px; width: -webkit-fill-available;">                                 
                        <div class='form-group' align="center" style='margin: 0;'> 
                            <div style="float: left;"><label> Imagem: </label></div>
                            <div><input type="file" name="new_arquivo" style='width:-webkit-fill-available;'></div>
                            
                            <div style="float: left;"><label> Nome: </label></div>
                            <div><?php echo "<input type='text' name='nome' value='".$DadosArte['TituloArte']."' style='width:-webkit-fill-available;'>";?></div>
                            
                            <div style="float: left;"><label> Tipo: </label></div>
                            <div>
                                <?php 
                                    $NomeTipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo=".$DadosArte['IdTipo'].""));
                                    
                                    echo "<select name='tipo' style='width:-webkit-fill-available;'> <option value=".$DadosArte['IdTipo'].">".$NomeTipo['nome']."</option>";      
                                    for ($i=1; $i <= $maxT; $i++) { 
                                        if ($i != $DadosArte['tipo']) {
                                            $tipo = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT nome FROM artes_tipos WHERE IdTipo=$i"));  
                                            echo "<option value='$i'>". $tipo['nome'] ."</option>";
                                        }  
                                    } echo "</select>";
                                ?>
                            </div>

                            <div style="float: left;"><label> Descrição: </label></div>
                            <div><?php echo "<textarea name='descricao' rows='3' style='width:-webkit-fill-available;'>".$DadosArte['Descricao']."</textarea>";?></div>

                            <div> <input type='submit' name='edt_arte' value='Editar'> </div>                                    
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
                <h4 class="modal-title">Excluir Arte</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form action='perfil_artes.php' method='post'>
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