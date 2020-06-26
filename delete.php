 <?php
    require_once('db.php');

    if (isset( $_GET['id'])){
        $sql = 'DELETE FROM ampoule WHERE id=:id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();

    }
    
    header('Location: index.php');

    ?>