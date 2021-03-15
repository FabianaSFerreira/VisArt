<?php   
    if ($pag == "home.php") $link_home = "nav-link active"; 
    else $link_home = "nav-link"; 

    if ($pag == "show_artes.php") $link_artes = "nav-link active"; 
    else $link_artes = "nav-link"; 

    if ($pag == "show_grupos.php") $link_grupos = "nav-link active"; 
    else $link_grupos = "nav-link"; 

    if ($pag == "show_eventos.php") $link_eventos = "nav-link active"; 
    else $link_eventos = "nav-link"; 

    if ($pag == "sign_in.php") $link_login = "nav-link active"; 
    else $link_login = "nav-link"; 

    if (($pag == "perfil.php") || ($pag == "perfil_artes.php") || ($pag == "perfil_grupos.php") || ($pag == "perfil_eventos.php") || ($pag == "perfil_notificacao.php")) 
        $link_perfil = "nav-link active"; 
    else $link_perfil = "nav-link"; 
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">
    <a class="navbar-brand" href="home.php"> <img src="Arquivos/VisArt/marca.png" width="150" height="50"> </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Alterna navegação"><span class="navbar-toggler-icon"></span></button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <?php 
                echo "<li class='nav-item'> <a class='".$link_home."' href='home.php'>Home</a> </li>";
                echo "<li class='nav-item'> <a class='".$link_artes."' href='show_artes.php'>Galeria</a> </li>";
                echo "<li class='nav-item'> <a class='".$link_grupos."' href='show_grupos.php'>Grupos</a> </li>";
                echo "<li class='nav-item'> <a class='".$link_eventos."' href='show_eventos.php'>Eventos</a> </li>";
                if ($usuario == "") { echo "<li class='nav-item'><a class='".$link_login."' href='sign_in.php'>Login</a></li>"; }
                else { echo "<li class='nav-item'><a class='".$link_perfil."' href='perfil.php'>Perfil</a></li>"; }
            ?>
        </ul>

        <form class="form-inline" id="buscar" action="show_artes.php" method="post" align="rigth">
            <input id="text_busca" type="text" name="texto" placeholder="Buscar artes" style="width: 90%;">
            <button class="icon" type="submit" name="buscar" align="left" style="margin: 0; padding: 0; width: 10%;"> 
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                    <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                </svg>
            </button> 
        </form>  
    </div>  
</nav><br>