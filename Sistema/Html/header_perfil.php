<?php 
    //Projeto VisArt - Trabalho de conclusão de curso
    //Autor: Fabiana da Silvaira Ferreira
    //Ano: 2020-2021

    $perfil = $_SESSION['perfil'];
    
    if ($perfil != "") {
        $perfil_usuario = mysqli_fetch_assoc(mySqli_query($conexao, "SELECT usuario, nome, email, LocalFoto FROM usuarios WHERE IdUsuario=".$perfil.""));

        echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="perfil">           
                <div class="navbar-brand" id="img_perfil"> 
                    <img src="../../'.$perfil_usuario['LocalFoto'].'" style="width:100%; height:100%;"><br> 
                    <label style="margin: 0; padding: 10px; float: left;">'.$perfil_usuario['nome'].'</label>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPerfil" aria-controls="navbarPerfil" aria-expanded="false" aria-label="Alterna navegação" style="margin: 0; padding: 10px; float: right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/> </svg>
                    </button>
                </div>
                    
                <div class="collapse navbar-collapse" id="navbarPerfil" align="center">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item"> <a class="nav-link" href="../perfil/perfil_artes.php">Portfólio</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="../perfil/perfil_grupos.php">Grupos</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="../perfil/perfil_eventos.php">Eventos</a> </li>
                    </ul>
                </div>  
            </nav>';
    }
    else {
        echo '<nav class="navbar navbar-expand-lg navbar-light bg-light" id="perfil">           
                <div class="navbar-brand" id="img_perfil"> 
                    <img src="../../'.$select['LocalFoto'].'" style="width:100%; height:100%;"><br>
                    <label style="margin: 0; padding: 10px; float: left;">'.$select['nome'].'</label>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPerfil" aria-controls="navbarPerfil" aria-expanded="false" aria-label="Alterna navegação" style="margin: 0; padding: 10px; float: right;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/> </svg>
                    </button>
                </div>
                    
                <div class="collapse navbar-collapse" id="navbarPerfil" align="center">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item"> <a class="nav-link" href="../perfil/perfil_artes.php">Portfólio</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="../perfil/perfil_grupos.php">Grupos</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="../perfil/perfil_eventos.php">Eventos</a> </li><br>

                        <li class="nav-item"> <form action="perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="modalArte" value="Adicionar Arte"></form> </li>
                        <li class="nav-item"> <form action="perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="modalGrupo" value="Adicionar Grupo"></form> </li>
                        <li class="nav-item"> <form action="perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="modalEvento" value="Adicionar Evento"></form> </li><br>
                        
                        <li class="nav-item"> <a class="nav-link" href="../perfil/perfil_notificacao.php">Notificações</a> </li>                    
                        <li class="nav-item"> <form action="../perfil/perfil.php" method="post"> <input  class="nav-link" id="nav_perfil" type="submit" name="configuracoes" value="Configurações"></form> </li>
                    </ul>
                </div>  
            </nav>';
    }
?>