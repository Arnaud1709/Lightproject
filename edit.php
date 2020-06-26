<?php
        require_once('db.php');
?>
<?php
$date = '';
$etage = '';    
$position = '';
$puissance = '';
$marque = '';
$id = '';
$error = false;

    if(isset($_GET['id']) && isset($_GET['edit'])){
        $sql = 'SELECT id, date_changement, etage, position, puissance, marque FROM ampoule WHERE id=:id';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $sth->execute();
        $data = $sth->fetch(PDO::FETCH_ASSOC);
        if( gettype($data) === "boolean"){            
            header('Location: index.php');
            exit;
        }

    $date = $data['date_changement'];
    $etage = $data['etage'];
    $position = $data['position'];
    $puissance = $data['puissance'];
    $marque = $data['marque'];
    $id = htmlentities($_GET['id']);

    }

    if(count($_POST) > 0 ){

        if(strlen(trim($_POST['date'])) !== 0){
            $date = trim($_POST['date']);
        }else{
            $error = true;
        }

        if(strlen(trim($_POST['etage'])) !== 0){
            $etage = trim($_POST['etage']);
        }else{
            $error = true;
        }

        if(strlen(trim($_POST['position'])) !== 0){
            $position = trim($_POST['position']);
        }else{
            $error = true;
        }

        if(strlen(trim($_POST['puissance'])) !== 0){
            $puissance = trim($_POST['puissance']);
        }else{
            $error = true;
        }

        if(strlen(trim($_POST['marque'])) !== 0){
            $marque = trim($_POST['marque']);
        }else{
            $error = true;
        }

        if(isset($_POST['edit']) && isset($_POST['id'])){
            $id = htmlentities($_POST['id']);
        }


    if($error === false){
        if(isset($_POST['edit']) && isset($_POST['id'])){
            $sql = 'UPDATE ampoule SET date_changement=:date, etage=:etage, position=:position, puissance=:puissance, marque=:marque WHERE id=:id';
        }else{
            $sql = "INSERT INTO ampoule(date_changement,etage,position,puissance,marque) VALUES(:date,:etage,:position,:puissance,:marque)";
        }
    

        $sth = $dbh->prepare($sql);

        $sth->bindValue(':date', strftime("%Y-%m-%d", strtotime($date)), PDO::PARAM_STR);
        $sth->bindParam(':etage', $etage, PDO::PARAM_STR);
        $sth->bindParam(':position', $position, PDO::PARAM_STR);
        $sth->bindParam(':puissance', $puissance, PDO::PARAM_STR);
        $sth->bindParam(':marque', $marque, PDO::PARAM_STR);
        if(isset($_POST['edit']) && isset($_POST['id'])){
            $sth->bindParam('id', $id, PDO::PARAM_INT);
        }
        $sth->execute();

        header('Location: index.php');
        }
    }
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
</head>
<body>

    <?php
        if( isset($_GET['id']) && isset($_GET['edit'])){
            echo'<h1>Modifier des informations</h1>';
        }else{
            echo'<h1>Ajouter une ampoule</h1>';
        }
    ?>
    <div>
        <form action="" method="post">
            <div>
                <input type="date" name="date" placeholder="Date du changement" value="<?=$date; ?>">
            </div>
            <div>
                <select name="etage" id="etage">   
                <?php 
                    for($i=0; $i<12; $i++){
                        $selected = '';

                        if ($etage == $i){
                            $selected = "selected";
                        }
                        echo '<option value="' .$i. '"' .$selected. '>'.$i.'</option>', "\n";               
                    } 
                ?>
                </option>

                    </select>  
            </div>
            <div>
                <select name="position">
                <?php
                    $array = array('Fond', 'Droite', 'Gauche');
                
                foreach($array as $arraypos){ 
                    $select = '';                   
                    if($position == $arraypos){
                    $select = "selected";
                    }
                    echo '<option value="'.$arraypos.'"' .$select. '>'.$arraypos.'</option>';
                }
                ?>
                    </select>            
            </div>
            <div>
                <input type="text" name="puissance" placeholder="Puissance" value="<?=$puissance?>">            
            </div>
            <div>
                <input type="text" name="marque" placeholder="Marque" value="<?=$marque?>">
            </div>

            <?php
                if(isset($_GET['id']) && isset($_GET['edit'])){
                    $texteButton = "Modifier";
                }else{
                    $texteButton = "Ajouter";
                }
            ?>

            <div>
                <button type="submit"><?=$texteButton ?></button>
            </div>

            <?php 
                if( isset($_GET['id']) && isset($_GET['edit'])){
            ?>
                    <input type="hidden" name="edit" value="1" />
                    <input type="hidden" name="id" value="<?=$id ?>">
            <?php
                }
            ?>
        </form>
    </div>
</body>
</html>