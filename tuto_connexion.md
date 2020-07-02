# Tutoriel: Se connecter et se déconnecter sur un site, puis maintenir une session ouverte
## Se connecter 
### Préparations

Pour se connecter et créer une session, il y a besoin de préparer certaines choses au préalable:

Tout d'abord, il faut créer dans la base de donnée un tableau qui acceuillera les noms d'```utilisateur``` et ```mot_de_passe```. Nous nomerons ce tableau ```membre```. Ici, il n'est pas encore question d'inscription, donc pour le moment rentrons les données sur ```phpMyAdmin``` en prenant le risque de ne pas ```crypter``` le mot de passe. Ce sera le sujet d'un prochain tutoriel. Ici le nom d'utilisateur sera ```Maurice``` et le mot de passe sera ```0000```

Une fois la base de donnée créée, il faut ensuite lier une page ```login.php```, créée au préalable, avec ```db.php``` (cf tuto base de donnée php).

On s'occupe ensuite de préparer le login. Pour faciliser le design, on utilisera le frameworks ```Uikit```

```
<body>   
    <div class="uk-form-horizontal uk-margin-auto-left uk-margin-auto-right uk-margin-xlarge-top uk-width-1-2 uk-margin">
        <form action="login.php" method="POST">
            
            
            <label><b>Nom d'utilisateur</b></label>
            <input type="text" placeholder="Entrer le nom d'utilisateur" name="utilisateur" required class="uk-input">

            <label><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer le mot de passe" name="mot_de_passe" required class="uk-input">

            <input type="submit" id='submit' value='connexion' name='connexion' class="uk-button uk-button-default" >
        </form>
    </div>    
</body>
```

Dans une structure html, on créé 3 formulaires: un formulaire type ```texte``` qui permet de saisir un identifiant, un formulaire de type ```password``` qui permet de saisir le mot de passe tout en cachant les caractères saisis et un formulaire type submit qui enverra la valeur ```connexion``` lorsqu'on aura cliqué dessus.

Il reste maintenant à préparer la ```requête sql``` qui permettra la connexion et la créassion d'une session.

### Formulaire de connexion

Pour pouvoir se connecter, nous allons comparer les valeurs saisies par l'utilisateur avec les valeurs dur tableau ```membre```.

```
<?php
    require_once('db.php');


    $utilisateur = '';
    $mdp = '';


    if(isset($_POST['connexion']) && !empty($_POST['utilisateur']) && !empty($_POST['mot_de_passe'])){   

    }
?>
```

Comme demandé auparavant, on commence à lier ```login.php``` à ```db.php``` grâce au ```require_once```. Une fois le lien établi, on créé deux variables vides qui porteront les noms de ```$utilisateur```et ```$mdp```. On va ensuite vérifier certaines conditions grâve à ```if```, ici on vérifie grâce à ```isset``` que l'input ```connexion``` ait bien été cliqué. On vérifie aussi, grace au ```&&``` qui demande à ce que la condition suivant soit aussi vérifiée, si la zone de saisie ```utilisateur``` ne soit pas vide, ```!``` inversant la valeur de ```empty```. On fini la condition par vérifier si la zone de saisie ```mot_de_passe``` est elle aussi remplie. Si ces conditions sont respectées, on lance la requête ```sql```.

```
if(isset($_POST['connexion']) && !empty($_POST['utilisateur']) && !empty($_POST['mot_de_passe'])){   

        $sql='SELECT utilisateur, mot_de_passe FROM membre WHERE utilisateur=:utilisateur';
        $sth = $dbh->prepare($sql);
        $sth->bindValue(':utilisateur', $_POST['utilisateur'], PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetch();

    $utilisateur = $data['utilisateur'];
    $mdp = $data['mot_de_passe'];
    }
?>
```

Si vous avez déjà regardé mes autres tutos, vous pouvez remarquer que la ```requête sql``` est similaire à celle de l'extraction de données pour l'édition. C'est normal, notre objectif est le même, ```extraire les valeurs``` qui nous intéressent pour les inclures dans des ```variables```. 

On crée donc la variable ```$sql``` à qui on alloue une requête sql. On lui demande via ```SELECT``` de sélectionner les colonnes ```utilisateur``` et ```mot_de_passe``` dans le tableau ```membre``` désigné par ```FROM```, on précisie ensuite avec ```WHERE``` qu'il en doit cible que la zone ou la valeur du tableau ```utilisateur``` est égale à la valeur ```:utilisateur``` qui représente la valeur inscrite dans le formulaire de connexion.

Grâce à on prépare la variable ```$sth``` qui demande à ```$sbh``` (soit l'autorisation de connexion) de préparer la requête de ```$sql``` en attendant qu'on lui donne l'ordre de l'executer. On protège ensuite l'injection de la valeur de ```:utilisateur``` dans la base de donnée grâce à ```bindValue``` qui empêche l'injection de ```sql```. Une fois la valeur d'```utilisateur``` protégée, on ```execute``` la requête.

Pour finir, on créé la variable ```$data``` qui, gâce à ```fetch```, va pouvoir extraire les valeurs qui ont été extraites lors de la requête ```sql```, donc les valeurs de ```utilisateur``` et ```mot_de_passe``` où ```utilisateur=:utilisateur```. Une fois ces valeurs extraites, on peut les insérer dans les variable ```$utilisateur``` et ```$mdp``` préalablement créées.


```
if(isset($_POST['connexion']) && !empty($_POST['utilisateur']) && !empty($_POST['mot_de_passe'])){   

        $sql='SELECT utilisateur, mot_de_passe FROM membre WHERE utilisateur=:utilisateur';
        $sth = $dbh->prepare($sql);
        $sth->bindValue(':utilisateur', $_POST['utilisateur'], PDO::PARAM_STR);
        $sth->execute();
        $data = $sth->fetch();

    $utilisateur = $data['utilisateur'];
    $mdp = $data['mot_de_passe'];

    session_start();
    
        if($_POST['utilisateur'] == $utilisateur && $_POST['mot_de_passe'] == $mdp){
            $_SESSION['timeout'] = time();
            $_SESSION['utilisateur'] = $utilisateur;
            header('Location: index.php');
        }else{
            echo'<div class="uk-alert-danger uk-overlay uk-position-cover uk-position-top" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <h3>ATTENTION!</h3>
                <p>Mauvais indentifiant ou mot de passe!</p>
            </div>';
        }
    }
?>
```

Toujours dans notre première condition ```if```, on débute une session de connexion grâce à ```session_start();```. 

ATTENTION! Ce n'est pas une bonne pratique! En théorie, ```session_start();``` doit toujours être la première ligne de commande suivant l'ouverture de la balise ```<?php``` du haut de page. Mais par soucis de lecture et d'organisation, je l'ouvre ici, ce qui n'empêche pas son bon focntionnement.

Une fois la session débuté, on peut comparer les valeurs entrées par l'utilisateur et les valeurs inclues dans la base de données. On inclus donc une nouvelle condition ```if``` qui compare les valeurs postées dans ```utilisateur```, grâce à ```$_POST```, avec les valeurs extraites de la base de données inclues dans les variables, donc ```$_POST['utilisateur'] == $utilisateur && $_POST['mot_de_passe'] == $mdp```, ```&&``` indiquant que les deux conditions doivent être valides. Si c'est le cas, on créé la session dans la superglobale (superglobale veut dire que sa valeur à une visibilité dans tout les scripts) ```$_SESSION```. On commence par allouer à ```$_SESSION``` une durée jusqu'au ```timeout```, ici laisser la valeur de ```time()``` vide indique qu'il ne sera déconnecté que manuellement ou en fonction de la durée de session du serveur, on peut y intégrer une valeur en seconde (ex: time(1800) pour 30 minutes). On donne ensuite a ```$_SESSION['utilisateur']``` la valeur de la variable ```$utilisateur``` ce qui permettra de personnaliser le texte des autres pages.

Par exemple, dans le header de l'index, si j'écris: ```<?php echo 'Bonjour ' .$_SESSION['utilisateur']. ' !'?>``` Alors, le navigateur affichera ```Bonjour Maurice !```.

Une fois la valeurs ajoutées dans ```$_SESSION```, on lance un ```header``` vers ```index.php```. 

Pour signaler les erreurs de saisie ou l'absence de compte, on créé un ```else``` à cette condition. Ici, on va simplement signaler par un message d'alerte, créé grâce à ```uikit```, que les informations saisies ne sont pas bonnes.

Pour maintenir les sessions sur toutes les pages ou c'est nécessaire, nous y intégrons une ```session_start();```, ce qui viendra chercher les valeurs de ```$_SESSION``` tant que celle-ci est active. Pour éviter ques les informations contenues dans le tableau, l'édition et l'ajout d'informations ne soient accessibles à tout le monde, nous alons ajouter une condition dans chaque en-tête php:

```
session_start();
if(empty($_SESSION['utilisateur'])){
        header('Location: login.php');
    }   
```

Ici, nous lançons une session avec ```session_start();```, une fois lancée nous lançons une condition ```if```. Si ```$_SESSION['utilisateur']``` est vide, nous déclenchons une redirection vers ```login.php```.


## Se déconnecter
### Préparations

Ici, les conditions à remplir pour la déconnection sont plus simples que d'habitude. Normalement, il faudrait créer une condition pour vérifier si on est dans une session, dans ce cas là on ferait apparaitre un lien vers ```deconnexion.php```, mais ici, on ne peut être sur les page qu'en étant connecté, dont il suffit de créer un ```input``` de déconnexion redirigeant vers ```deconnexion.php``` sur toutes les pages (autre que la page de connexion).

```
<?php
echo '<a title="Au revoir'.$_SESSION['utilisateur'].'!" uk-icon="sign-out" class="delet" href="deconnexion.php"></a>'
?>
```

Dans le ```header```, j'ai simplement créé une ```icone``` vers le lien de déconnexion avec un petit message personnalisé grâce à ```$_SESSION``` qui apparrait au survol grâce à une balise ```<title>```.

### Déconnexion

Pour se déconnecter, la fonction est beaucoup plus simple:

```
<?php
session_start();

session_destroy();
header('Location: login.php');
exit;
?>
```

Voici l'unique contenu de la page ```deconnexion.php```, on y lance simplement la session en cours avec ```session_start();``` avant de la détruire avec ```session_destroy();```. Une fois la session détruite, un ```header``` nous redirige vers le ```login.php```.