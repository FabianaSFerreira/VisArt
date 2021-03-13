<div class="modal-dialog">  
    <div class="modal-content">
        
        <div class='modal-header'>
            <?php echo "<h4 class='modal-title'>".$DadosArte['TituloArte']."</h4>"; ?>
            <button type='button' class='close' data-dismiss='modal'>&times;</button>
        </div>

        <div class='modal-body' align='center'>
            <div class='row'>                                
                <div class='row' style='width: -webkit-fill-available; margin: 10px 30px;'>
                    <?php
                        if (($usuario != "") && ($_SESSION['IdPerfil'] == "")) {  
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
                            echo "<form action='minhas_artes.php' method='post' class='col'>
                                    <button class='descricao' type='submit' name='curtir' data-title='curtir'> 
                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart-fill' viewBox='0 0 16 16'> 
                                            <path fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z'/>
                                        </svg> &nbsp".$DadosArte['Curtidas']."
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
                            for ($i=1; $i <= $maxC; $i++) { 
                                $comentario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario, texto FROM artes_comentarios WHERE IdComentario='$i' AND IdArte=".$DadosArte['IdArte'].""));                                               
                                
                                if ($comentario != "") {
                                    $meu_coment = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT IdComentario FROM artes_comentarios WHERE IdComentario='$i' AND IdUsuario='$usuario'")); 

                                    if ($meu_coment != "") {
                                        echo "<form action='minhas_artes.php' method='post'>
                                                <div id='comentario'>
                                                    <button type='text' class='icon' style='width:70%; float: none; margin: 5px;'> ".$comentario['texto']." </button>
                                                    <button type='submit' class='icon' name='coment".$i."' data-title='Excluir' style='margin: 5px; padding-top: 10px;'> 
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/> </svg>
                                                    </button>
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
        </div>

        <div class='modal-footer' style="justify-content: center;">
            <form action='minhas_artes.php' method='post'>
                <?php 
                    if ($usuario != "") {
                        echo "<div class='form-group row align-items-center' style='flex-wrap: initial;'>
                                <textarea class='col-7' name='comentario' rows='1' placeholder='Comente...'></textarea>
                                <input class='col-3' type='submit' name='add_coment' value='Enviar'>
                            </div>";
                    }
                ?>
            </form>
        </div>
    </div>
</div>