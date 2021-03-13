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