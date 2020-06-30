<?php
define('DATABASE', 'lightproject');
define('USER', 'root');
define('PWD', '');
define('HOST', 'localhost');

/*define('DATABASE', 'arnaudd452_lightproject ');
define('USER', 'arnaudd452');
define('PWD', 'nGPn9aQAqQfgpA==');
define('HOST', 'localhost');*/

    try{
        $dbh = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    } catch (PDOException $e) {
        print "Erreur !:" . $e->getMessage() . "<br/>";
        die();
    }