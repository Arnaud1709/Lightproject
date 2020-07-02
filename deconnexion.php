<?php
// Ouverture de session
session_start();
// Destruction de session
session_destroy();
// Redirection vers le login
header('Location: login.php');
exit;
?>