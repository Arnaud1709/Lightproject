<?php
// Identifiants de connexion à la databse wamp
define('DATABASE', 'lightproject');
define('USER', 'root');
define('PWD', '');
define('HOST', 'localhost');

// Identifiants de connexion au serveur ACS
/*define('DATABASE', 'arnaudd452_lightproject ');
define('USER', 'arnaudd452');
define('PWD', 'nGPn9aQAqQfgpA==');
define('HOST', 'localhost');*/

//requête sql de connexion
    try{
        $dbh = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    } catch (PDOException $e) {
        print "Erreur !:" . $e->getMessage() . "<br/>";
        die();
    }