<?php
//Ouverture de session et vérification de l'utilisateur
    session_start();
    require_once('db.php');
    
    if(empty($_SESSION['utilisateur'])){
        header('Location: login.php');
    }    
//Variable du titre de la page créée
    $titre='Index';

    ?>
	
    
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$titre?></title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.4/dist/js/uikit-icons.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fontdiner+Swanky&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>
<!-- Intégration du header.php --> 
<?php require_once('header.php'); ?>

<body>
<!-- Ouvertue d'une section englobant l'intérieur du body -->
    <section>
        <div class="nav uk-background-muted">
            <div>
                <!-- Fromulaire de recherche dans la base de donnée-->
                <form action="" method="post" class="uk-search">
                    <div class="uk-flex-row">
                        <input class="uk-search-input uk-search-default" name="rechercher" type="text" class="search-query" placeholder="Chercher une ampoule">
                        <button type="submit" class=""><i uk-icon="search"></i></button>
                    </div>
                </form>
            </div>
            <!-- Lien vers l'ajout d'une ampoule -->
            <a href="edit.php" title="Ajouter une ampoule" class="uk-link-reset">
                <i uk-icon="push"></i>
            </a>
            <!-- Lien de retour vers l'index-->
            <a href="index.php" title="Revenir à l'index" class="uk-link-reset">
                <i uk-icon="refresh"></i>
            </a>
        </div>

        <!-- Création du tableau -->
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

        <!-- Requête sql d'éxtracton d'informations de la base de donnée-->    
        <?php
            $sql = 'SELECT id, date_changement, etage, position, puissance, marque FROM ampoule';
            $sth = $dbh->prepare($sql);
            $sth->execute();
        /* Affichage et protection des valeurs extraites*/
        $datas = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        /* Date mise au format français*/
        $intlDateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
        
        /* Création d'une condition pour vérifier si on est en train de chercher une valeur */
        if(!isset($_POST['rechercher'])){
            /* Si la barre de recherche est vide, on affiche les $data pour chaque valeur extraites */
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
            /* Si elle est pleine, on compare les valeurs selectionnées et la valeur recherchée*/
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
        /* Message à afficher su le tableau est vide */
            if(count($datas) === 0){
                echo'<p class="null"> Ancun changement</p>';
            }
        ?> 
        <!-- Modal de supression de ligne-->
        <div id="modal" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-text-center">
                <h1 class="warning">Suppression</h1>
                <p>Êtes-vous sur de vouloir supprimer cette ligne?</p>
                <p class="uk-text-center">
                    <button class="uk-button uk-button-default yes" id="confirmation" onclick="trash()" type="button" href="delete.php">Oui</button>
                    <button class="uk-button uk-button-default uk-modal-close nope" type="button">Non</button>
                </p>
            </div>
        </div>

        </section>
    <!-- Lien vers le script-->
    <script src="script.js"></script>
</body>
</html>