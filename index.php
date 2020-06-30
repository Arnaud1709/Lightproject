<?php
    session_start();
    require_once('db.php');
    
    if(empty($_SESSION['utilisateur'])){
        header('Location: login.php');
    }    


    ?>
	
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fontdiner+Swanky&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="color">
    <header>
        <div class="titre">            
            <h1 class="idea">
                <img class="logo" src="getsupercustomizedimage.png">
                GOOD IDEA
            </h1>

            <div class="page">
                <h1 class="localisation">Index</h1>
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

        <div class="nav uk-background-muted">
            <div>
                <form action="" method="post" class="uk-search">
                    <div class="uk-flex-row">
                        <input class="uk-search-input uk-search-default" name="rechercher" type="text" class="search-query" placeholder="Chercher une ampoule">
                        <button type="submit" class=""><i uk-icon="search"></i></button>
                    </div>
                </form>
            </div>
            <a href="edit.php" title="Ajouter une ampoule" class="uk-link-reset">
                <i uk-icon="push"></i>
            </a>
            <a href="index.php" title="Revenir à l'index" class="uk-link-reset">
                <i uk-icon="refresh"></i>
            </a>
        </div>

        <table class="uk-table uk-table-striped uk-table-responsive uk-table-hover">
            <thead class="tableau">
                <tr>
                    <th>ID</th>
                    <th>Date de changement</th>
                    <th>Étage</th>
                    <th>Position</th>
                    <th>Puissance</th>
                    <th>Marque</th>
                    <th>Modifier/Supprimer</th>
                </tr>
            </thead>
            
        <?php
            $sql = 'SELECT id, date_changement, etage, position, puissance, marque FROM ampoule';
            $sth = $dbh->prepare($sql);
            $sth->execute();
        
        $datas = $sth->fetchAll(PDO::FETCH_ASSOC);
            
        $intlDateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
        
        if(!isset($_POST['rechercher'])){
            foreach( $datas as $data){
                echo'<tbody>';
                    echo'<td>'.$data['id'].'</td>';
                    echo'<td>'.$intlDateFormatter->format(strtotime($data['date_changement'])).'</td>';
                    echo'<td>'.$data['etage'].'</td>';
                    echo'<td>'.$data['position'].'</td>';
                    echo'<td>'.$data['puissance'].'</td>';
                    echo'<td>'.$data['marque'].'</td>';
                    echo'<td><a class="modif" uk-icon="file-edit" title="Modifier" href="edit.php?edit=1&id='.$data['id'].'"></a> <a class="delet" uk-icon="trash" title="Supprimer" uk-toggle="target: #modal" onclick="confirmation('.$data['id'].')" href="delete.php?id='.$data['id'].'"></a></td>';
                echo'</tbody>';
            }
        }else{
            foreach( $datas as $data){
                if(($data['id'] == $_POST['rechercher']) || ($data['date_changement'] == $_POST['rechercher']) || $data['etage'] == $_POST['rechercher'] || $data['position'] == $_POST['rechercher'] || $data['puissance'] == $_POST['rechercher'] || $data['marque'] == $_POST['rechercher']){
                    echo'<tbody>';
                        echo'<td>'.$data['id'].'</td>';
                        echo'<td>'.$intlDateFormatter->format(strtotime($data['date_changement'])).'</td>';
                        echo'<td>'.$data['etage'].'</td>';
                        echo'<td>'.$data['position'].'</td>';
                        echo'<td>'.$data['puissance'].'</td>';
                        echo'<td>'.$data['marque'].'</td>';
                        echo'<td><a class="modif" title="Modifier" uk-icon="file-edit" href="edit.php?edit=1&id='.$data['id'].'"></a> <a class="delet" uk-icon="trash" title="Supprimer" uk-toggle="target: #modal" onclick="confirmation('.$data['id'].')" href="delete.php?id='.$data['id'].'"></a></td>';
                    echo'</tbody>';
                    $test = 0;
                }
            }
        }
            ?>
        </table>
        <?php        
            if(count($datas) === 0){
                echo'<p class="null"> Ancun changement</p>';
            }
        ?>
        <div id="modal" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <p>Êtes-vous sur de vouloir supprimer cette ligne?</p>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default" id="confirmation" onclick="trash()" type="button" href="delete.php">Oui</button>
            <button class="uk-button uk-button-default uk-modal-close" type="button">Non</button>
        </p>
    </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>