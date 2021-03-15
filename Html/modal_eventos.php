<div class='modal-dialog'>  
    <div class='modal-content'>   

        <div class='modal-header'>
            <?php echo "<h4 class='modal-title'>".$DadosEvento['NomeEvento']."</h4>"; ?>
            <button type='button' class='close' data-dismiss='modal'>&times;</button>  
        </div>

        <div class='modal-body'>
            <div class='row'> 
                <div class='row' style='width: -webkit-fill-available; margin: 10px;'>
                    <?php
                        if (($usuario != "") && ($_SESSION['IdPerfil'] == "") && ($pag != "show_eventos.php")) {  
                            if($DadosEvento['IdUsuario'] == $usuario) {
                                echo '<button class="descricao col-1" type="button" data-toggle="modal" data-target="#editar_evento" data-title="Editar"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/> </svg>
                                    </button>
            
                                    <button class="descricao col-1" type="button" data-toggle="modal" data-target="#excluir_evento" data-title="Excluir"> 
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/> </svg>
                                    </button>';
                            }
                        }
                    ?>
                </div>

                <?php 
                    if ($DadosEvento['LocalImagem'] != "") {
                        echo "<div id='descricao'> <img src='".$DadosEvento['LocalImagem']."' style='width: -webkit-fill-available;'> </div><br>"; 
                    }
                    echo "<button type='text'> Descrição: ".$DadosEvento['Descricao']." </button><br>";
                    echo "<button type='text'> Organizador(es): ".$DadosEvento['Organizador']." </button><br>";
                    echo "<button type='text'> Endereço: ".$DadosEvento['Endereco']." </button><br>";
                    echo "<button type='text'> Data e Hora: ".$DadosEvento['Data']." às ".$DadosEvento['Hora']." </button><br>";
                    echo "<button type='text'> Número de participantes confirmados: ".$participantes['part']." </button><br>";                                      
                ?>
            </div>  
        </div>

        <div class='modal-footer'>
            <form action='show_eventos.php' method='post' style="width: -webkit-fill-available;">
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

<div class="modal fade" id="editar_evento" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Editar Evento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button> 
            </div>
            
            <form action='perfil_eventos.php' method='post' enctype="multipart/form-data" style="width: -webkit-fill-available;">
                <div class="modal-body form-group" align="center" style='margin: 0;'> 
                    <div style="float: left;"><label> Imagem: </label></div><br>
                    <div><input type="file" name="new_imagem" style='width:-webkit-fill-available;'></div>
                    
                    <div style="float: left;"><label> Nome: </label></div><br>
                    <div><?php echo "<input type='text' name='nome' value='".$DadosEvento['NomeEvento']."' style='width:-webkit-fill-available;'>";?></div>

                    <div style="float: left;"><label> Organizador(es): </label></div><br>
                    <div><?php echo "<input type='text' name='org' value='".$DadosEvento['Organizador']."' style='width:-webkit-fill-available;'>";?></div>

                    <div style="float: left;"><label> Endereço: </label></div><br>
                    <div><?php echo "<input type='text' name='end' value='".$DadosEvento['Endereco']."' style='width:-webkit-fill-available;'>";?></div>

                    <div class="row" style='margin:auto;'><label> Data e Hora: </label></div>
                    <div class="row" style='width:-webkit-fill-available; margin:auto;'>
                        <?php 
                            echo "<input class='col' type='date' name='data' value=".$DadosEvento['Data'].">";
                            echo "<input class='col' type='time' name='hora' value=".$DadosEvento['Hora'].">";
                        ?>
                    </div>

                    <div style="float: left;"><label> Descrição: </label></div><br>
                    <div><?php echo "<textarea name='descricao' rows='3' style='width:-webkit-fill-available;'>".$DadosEvento['Descricao']."</textarea>";?></div>       
                </div>

                <div class="modal-footer" style="justify-content: center;"> <input type='submit' name='edt_evento' value='Editar'> </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="excluir_evento" role="dialog">
    <div class="modal-dialog">  
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Excluir Evento</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form action='perfil_eventos.php' method='post'>
                    <div class='form-group' align="center">
                        <label> Tem certeza que deseja excluir esse evento? </label> <br>
                        <input type='submit' name='excluir_evento' value='Excluir' style='width: 120px;'>
                        <input type='submit' name='voltar_evento' value='Voltar' style='width: 120px;'>
                    </div>  
                </form>       
            </div>

            <div class="modal-footer"></div>
        </div>
    </div>
</div>