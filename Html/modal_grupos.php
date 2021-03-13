<div class='modal-dialog'>  
    <div class='modal-content'>   

        <div class='modal-header'>
            <?php echo "<h4 class='modal-title'>".$DadosGrupo['TituloGrupo']."</h4><br>";?>
            <button type='button' class='close' data-dismiss='modal'>&times;</button>
        </div>

        <div class='modal-body' align="center">
            <div class='row' style='width: -webkit-fill-available; margin: 10px 30px;'>
                <?php
                    $admin = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT administrador FROM grupos WHERE IdGrupo=".$DadosGrupo['IdGrupo']." AND administrador='$usuario'"));

                    if ($admin != "") {
                        echo '<button class="descricao" type="button" data-toggle="modal" data-target="#editar_grupo" data-title="Editar" style="float:left;"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/> </svg>
                            </button>
    
                            <button class="descricao" type="button" data-toggle="modal" data-target="#excluir_grupo" data-title="Excluir" style="float:left;"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/> </svg>
                            </button>';
                    }
                ?>
            </div>

            <div class='row' align="center">  
                <?php
                    if ($DadosGrupo['LocalImagem'] != ""){
                        echo "<div id='descricao'> <img src='".$DadosGrupo['LocalImagem']."' style='width: -webkit-fill-available;'> </div><br>";
                    }
                    
                    echo "<button type='text'> Descrição: ".$DadosGrupo['descricao']." </button><br>";
                    echo "<form action='perfil.php' method='post' style='width: -webkit-fill-available; padding: 0px 15px;'>
                            <input id='usuario' type='submit' name='perfil".$DadosGrupo['administrador']."' value='Administrador(a): ".$admin['Nome']."' style='width: -webkit-fill-available; padding: 10px;'>
                        </form>";

                    if ($DadosGrupo['status'] == 'aberto') { echo "<button type='text'> Status: Aberto </button>"; }
                    else if ($DadosGrupo['status'] == 'fechado') { echo "<button type='text'> Status: Fechado </button>"; }

                    $UsGrupos = mySqli_query($conexao, "SELECT IdUsuario FROM grupos_usuarios WHERE IdGrupo=".$DadosGrupo['IdGrupo']." AND Solicitacao='0'");  

                    if ($admin != "") {
                        echo "<div id='membros' style='width: -webkit-fill-available; margin: 25px;'> <label style='padding: inherit;'> Membros do grupo: </label>";
                        while($us = mysqli_fetch_array($UsGrupos)) {
                            $nome = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$us['IdUsuario'].""));

                            if ($us['IdUsuario'] == $DadosGrupo['administrador']) {
                                echo "<button type='text' class='icon' style='width:70%; float: none; margin: 0px;'> ".$nome['Nome']." </button>";
                            }
                            else {
                                echo "<form action='meus_grupos.php' method='post'>                                 
                                        <button type='text' class='icon' style='width:70%; float: none; margin: 0px;'> ".$nome['Nome']." </button>
                                        <button type='submit' class='icon' name='us".$us['IdUsuario']."' data-title='Excluir' style='margin: 0px;'> 
                                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'> <path fill-rule='evenodd' d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z'/> </svg>
                                        </button>                                                   
                                    </form>"; 
                            }  
                        }
                        echo "</div>";
                        
                    }
                    else {
                        echo "<select id='descricao'> <option> Membros </option>"; 
                        while($us = mysqli_fetch_array($UsGrupos)) {
                            $nome = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT Nome FROM usuarios WHERE IdUsuario=".$us['IdUsuario'].""));
                            echo "<option>". $nome['Nome'] ."</option>"; 
                        }
                        echo "</select>";

                        echo "<button type='button' data-toggle='modal' data-target='#sair_grupo' style='margin: auto;'> Sair do Grupo </button>";
                    }
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