 <?php
    require_once('db.php');
// Vérifie si il peut récupérer un id
    if (isset( $_GET['id'])){
        // Requête sql de supression
        $sql = 'DELETE FROM ampoule WHERE id=:id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();

    }
    // Redirection vers le header
    header('Location: index.php');

    ?>