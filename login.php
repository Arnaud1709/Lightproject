<?php
// Lien vers la database 
    require_once('db.php');

// Création de variables utilisateur et mot de passe
    $utilisateur = '';
    $mdp = '';

// Requête sql d'extraction de données pour comparer aux valeurs inscrites
    if(isset($_POST['connexion']) && !empty($_POST['utilisateur']) && !empty($_POST['mot_de_passe'])){   

        $sql='SELECT utilisateur, mot_de_passe FROM membre WHERE utilisateur=:utilisateur';
        $sth = $dbh->prepare($sql);
        $sth->bindValue(':utilisateur', $_POST['utilisateur'], PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetch();
    //Insertions des identifiants extraits dans les variables
    $utilisateur = $data['utilisateur'];
    $mdp = $data['mot_de_passe'];
    //Ouverture de la session
    session_start();
    // Comparaison des valeurs extraites et celle des formulaires
        if($_POST['utilisateur'] == $utilisateur && $_POST['mot_de_passe'] == $mdp){
            //Si elles sont bonne, création d'une session
            $_SESSION['timeout'] = time();
            $_SESSION['utilisateur'] = $utilisateur;
            header('Location: index.php');
        //Si elles sont fausses, message d'erreur
        }else{            
            echo'<div class="uk-alert-danger uk-overlay uk-position-cover uk-position-top" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <h3>ATTENTION!</h3>
                <p>Mauvais indentifiant ou mot de passe!</p>
            </div>';
        }
    }
    ?>



<!-- Corps du login-->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fontdiner+Swanky&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>   
    <!-- Header personnalisé -->
    <header>
        <div class="titre">            
            <h1 class="idea">
                <img class="logo" src="getsupercustomizedimage.png">
                GOOD IDEA
            </h1>

            <div class="page">
                <h1 class="localisation">Connexion</h1>
            </div>

            <nav class="user">
                <!-- Nav vide pour centrer le titre-->
            </nav>
        </div>
    </header>

    <div class="uk-form-horizontal uk-margin-auto-left uk-margin-auto-right uk-margin-xlarge-top uk-width-1-2 uk-margin">
        <!--Formulaire de connexion -->
        <form action="login.php" method="POST">
            <!-- Input de l'identifiant -->           
            <label><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrer le nom d'utilisateur" name="utilisateur" required class="uk-input">
            <!-- Input du mot de passse -->
            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="mot_de_passe" required class="uk-input">
            <!-- Boutton de validation du formulaire -->
            <input type="submit" id='submit' value='connexion' name='connexion' class="uk-button uk-button-default" >
        </form>
    </div>
    
</body>
</html>