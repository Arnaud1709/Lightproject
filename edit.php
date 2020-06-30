<?php
    session_start();
    require_once('db.php');
    
    if(empty($_SESSION['utilisateur'])){
        header('Location: login.php');
    }    


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

        header('Location: index.php');
    }
}
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        if( isset($_GET['id']) && isset($_GET['edit'])){
            echo'<title>Modifier des informations</title>';
        }else{
            echo'<title>Ajouter un changement</title>';
        }
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fontdiner+Swanky&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <div class="titre">            
            <h1 class="idea">
                <img class="logo" src="getsupercustomizedimage.png">
                GOOD IDEA
            </h1>

            <div class="page">
                <?php
                    if( isset($_GET['id']) && isset($_GET['edit'])){
                        echo'<h1 class="localisation">Modifier des informations</h1>';
                    }else{
                        echo'<h1 class="localisation">Ajouter une ampoule</h1>';
                    }
                ?>
            </div>

            <nav class="user">
                <p class="session">
                    <span>
                        <?php                
                            echo 'Bonjour ' .$_SESSION['utilisateur'].' !'
                        ?>
                    </span>
                    <a title="Au revoir <?= $_SESSION['utilisateur']?> !" uk-icon="sign-out" class="delet" href="deconnexion.php"></a>
                </p>
            </nav>
        </div>
    </header>
    
    <div>
        <form action="" method="post" class="uk-form-horizontal uk-margin-auto-left uk-margin-auto-right uk-margin-xlarge-top uk-width-1-2 uk-margin">
            <div>
                <input type="date" name="date" placeholder="Date du changement" value="<?=$date; ?>" class="uk-input">
            </div>
            <div>
                <select name="etage" id="etage" class="uk-select">   
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
                <select name="position" class="uk-select">
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
                <select name="puissance" class="uk-select">
                <?php
                    $array = array('25W', '60W', '75W', '100W', '150W');
                
                    foreach($array as $arraylight){ 
                        $select = '';                   
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
                if(isset($_GET['id']) && isset($_GET['edit'])){
                    $texteButton = "Modifier";
                }else{
                    $texteButton = "Ajouter";
                }
            ?>

            <div class="uk-margin">
                <button class="uk-button uk-button-default uk-margin-auto-left uk-margin-auto-right" type="submit"><?=$texteButton ?></button>
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