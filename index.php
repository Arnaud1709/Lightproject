<?php
        require_once('db.php');
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

        <div class="titre">            
            <h1 class="idea">
            <img class="logo" src="getsupercustomizedimage.png">
                GOOD IDEA
            </h1>
        </div>

        <p><a class="uk-button uk-button-default" href="edit.php"> Ajouter </a></p>

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
        
            foreach( $datas as $data){
                echo'<tbody>';
                    echo'<td>'.$data['id'].'</td>';
                    echo'<td>'.$intlDateFormatter->format(strtotime($data['date_changement'])).'</td>';
                    echo'<td>'.$data['etage'].'</td>';
                    echo'<td>'.$data['position'].'</td>';
                    echo'<td>'.$data['puissance'].'</td>';
                    echo'<td>'.$data['marque'].'</td>';
                    echo'<td><a class="modif" uk-icon="file-edit" href="edit.php?edit=1&id='.$data['id'].'"></a> <a uk-icon="trash" href="delete.php?id='.$data['id'].'"></a></td>';
                echo'</tbody>';
            }
            ?>
        </table>
        <?php        
            if(count($datas) === 0){
                echo'<p class="null"> Ancun changement</p>';
            }
        ?>   
    </div>
    
</body>
</html>