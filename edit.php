<?php
// Ouverture de session
    session_start();
    require_once('db.php');
    
    if(empty($_SESSION['utilisateur'])){
        header('Location: login.php');
    }    

    //Vérifie si on est en état d'ajout ou d'édition
    if( isset($_GET['id']) && isset($_GET['edit'])){
            $titre='Modifier des informations';
        }else{
            $titre='Ajouter un changement';
        }

    ?>
<?php
// Variables vide à remplir
$date = '';
$etage = '';    
$position = '';
$puissance = '';
$marque = '';
$id = '';
$error = false;

// Requête sql pour éxtraire les valrus du tableau si on est en état d'édition
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

    // Remplissage des variables vides
    $date = $data['date_changement'];
    $etage = $data['etage'];
    $position = $data['position'];
    $puissance = $data['puissance'];
    $marque = $data['marque'];
    $id = htmlentities($_GET['id']);

    }

    // Vérifie si des valeurs ont bien été rentrées
    if(count($_POST) > 0 ){
        // Vérifie la valeur de la date
        if(strlen(trim($_POST['date'])) !== 0){
            $date = trim($_POST['date']);
        }else{
            $error = true;
        }
        // Vérifie la valeur de l'étage
        if(strlen(trim($_POST['etage'])) !== 0){
            $etage = trim($_POST['etage']);
        }else{
            $error = true;
        }
        // Vérifie la valeur de la position
        if(strlen(trim($_POST['position'])) !== 0){
            $position = trim($_POST['position']);
        }else{
            $error = true;
        }
        // Vérifie la valeur de la puissance
        if(strlen(trim($_POST['puissance'])) !== 0){
            $puissance = trim($_POST['puissance']);
        }else{
            $error = true;
        }
        // Vérifie la valeur de la marque
        if(strlen(trim($_POST['marque'])) !== 0){
            $marque = trim($_POST['marque']);
        }else{
            $error = true;
        }
        // Vérifie la valeur de l'id
        if(isset($_POST['edit']) && isset($_POST['id'])){
            $id = htmlentities($_POST['id']);
        }

// Si il n'y a pas d'erreur de remplissage, vérifie si on est en état d'édition ou d'ajout et créé une requête sql
    if($error === false){
        if(isset($_POST['edit']) && isset($_POST['id'])){
            $sql = 'UPDATE ampoule SET date_changement=:date, etage=:etage, position=:position, puissance=:puissance, marque=:marque WHERE id=:id';
        }else{
            $sql = "INSERT INTO ampoule(date_changement,etage,position,puissance,marque) VALUES(:date,:etage,:position,:puissance,:marque)";
        }
    
// Préparation, protection et execution de la requête sql
        $sth = $dbh->prepare($sql);
            //Protection des requêtes sql
        $sth->bindValue(':date', strftime("%Y-%m-%d", strtotime($date)), PDO::PARAM_STR);
        $sth->bindParam(':etage', $etage, PDO::PARAM_STR);
        $sth->bindParam(':position', $position, PDO::PARAM_STR);
        $sth->bindParam(':puissance', $puissance, PDO::PARAM_STR);
        $sth->bindParam(':marque', $marque, PDO::PARAM_STR);
        if(isset($_POST['edit']) && isset($_POST['id'])){
            $sth->bindParam('id', $id, PDO::PARAM_INT);
        }
        $sth->execute();
        // Après l'exécution, redirection vers l'index
        header('Location: index.php');
    }
}
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/png" href="getsupercustomizedimage.png" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$titre</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fontdiner+Swanky&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- On intègre le header -->   
<?php require_once('header.php'); ?>
    <!-- Création du formulaire --> 
    <div>
        <form action="" method="post" class="uk-form-horizontal uk-margin-auto-left uk-margin-auto-right uk-margin-xlarge-top uk-width-1-2 uk-margin">
            <!-- Entrée de date --> 
            <div>
                <input type="date" name="date" placeholder="Date du changement" value="<?=$date; ?>" class="uk-input">
            </div>
            <!-- Selection de l'étage--> 
            <div>
                <select name="etage" id="etage" class="uk-select">   
                <?php 
                    for($i=0; $i<12; $i++){
                        $selected = '';
                        // Sauvegarde l'étage si extrait pour l'édition
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
            <!-- Selection de la position --> 
                <select name="position" class="uk-select">
                <?php
                    $array = array('Fond', 'Droite', 'Gauche');
                
                    foreach($array as $arraypos){ 
                        $select = '';  
                        // Sauvegarde la position si extrait pour l'édition                 
                        if($position == $arraypos){
                        $select = "selected";
                        }
                        echo '<option value="'.$arraypos.'"' .$select. '>'.$arraypos.'</option>';
                    }
                ?>
                </select>            
            </div>
            <div>
            <!-- Sélection de la puissance --> 
                <select name="puissance" class="uk-select">
                <?php
                    $array = array('25W', '60W', '75W', '100W', '150W');
                
                    foreach($array as $arraylight){ 
                        $select = '';    
                        // Sauvegarde de la puissance sélectionnée en cas d'édition               
                        if($puissance == $arraylight){
                        $select = "selected";
                        }
                        echo '<option value="'.$arraylight.'"' .$select. '>'.$arraylight.'</option>';
                    }
                ?>            
            </div>
            <div>
                <input type="text" name="marque" placeholder="Marque" value="<?=$marque?>" class="uk-input">
            </div>

            <?php
            // Affiche un boutton en fonction de l'état édition ou insertion
                if(isset($_GET['id']) && isset($_GET['edit'])){
                    $texteButton = "Modifier";
                }else{
                    $texteButton = "Ajouter";
                }
            ?>

            <!-- Input de validation du formulaire --> 
            <div class="uk-margin">
                <button class="uk-button uk-button-default uk-margin-auto-left uk-margin-auto-right" type="submit"><?=$texteButton ?></button>
                <?php 
                // Boutton de retour si on a accidentellement cliqué sur l'ajout
                if( !isset($_GET['id']) && !isset($_GET['edit'])){?>
                    <a class="uk-button uk-button-default uk-margin-auto-left uk-margin-auto-right" type="submit" href="index.php"> Retour </a>
                
                <?php } ?>
            </div>

            <!-- Si on est en état d'édition, cache les valeurs d'edit et id, qui peuvent quand me^me être exploitées--> 
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