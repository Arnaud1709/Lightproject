<?php 
    session_start();
    $titre="Connexion";
    include("includes/login.php");
    include("includes/debut.php");
    include("includes/menu.php");
    echo '<p><i>Vous êtes ici</i> : <a href="./index.php">Index du site</a> --> Connexion';

    echo '<h1>Connexion</h1>';
    if ($id!=0) erreur(ERR_IS_CO);

    