# Tutoriel: Utilisation de selected dans une base de donnée
## A quoi sert "selected"?
### Utilisation

Selected est un attribut de la balise ```<option>``` qui se trouve au sein d'en élement ```<select>```. Il défini l'option selectionnée comme l'option initiale dans les choix proposés. La valeur de l'option ```selected``` apparaitra donc en premier lors du chargement de la page. 

### Utilité en base de donnée?

Lors qu'une donnée est ```selected```, elle apparaitra lors d'une édition de ligne ce qui évitera de revenir au début de la liste déroulante et ainsi éviter des erreurs.

## Application
### Dans la lecture d'une boucle

```
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
```

Ici nous devons intégrer un ```selected``` dans une liste déroulante de 11 étages.

On commence par créer une boucle```for($i=0; $i<12; $i++)``` dans notre ```<select>```. On créé ensuite une variable ```$selected``` vide. On établi ensuite une condition ```if($etage == $i)```, ```$etage``` représentant la valeur extraite de la base de donnée, nous demandons à la condition de vérifier quand la valeur de ```$i``` est égale en valeur à ```$étage```. Si la contion est respectée, ```$selected``` devient alors l'option ```"selected"```.

On fait donc apparaitre le résultat du```for``` grâce à un ```echo```, la boucle complète apparaitra, affichant donc les étage de 0 à 11. On attribue ensuite à ```value``` la valeur de ```$i```, si la condition du ```if``` est respectée, dans ce cas là, le ```"selected"``` va s'insérer automatiquement, sinon le champ restera vide. Pour finir, on affiche tout les ```$i``` de la boucle ```for``` en sautant des lignes entre chaque valeur grace à ```\n```.


### Dans la lecture d'un tableau

```
    <select name="position" class="uk-select">
        <?php
        $array = array('Fond', 'Droite', 'Gauche');
            foreach($array as $arraypos){ 
                $select = '';                   
                if($position == $arraypos){
                $select = "selected";
                }
            echo '<option value="'.$arraypos.'"' .$select. '>'.$arraypos.'</option>', "\n";
            }
        ?>
    </select>  
```

Ici nous devons intégrer un ```selected``` dans une liste déroulante composée de trois valeurs: Fond, Droite et Gauche.

On commence par créer une varriable ```$array``` qui a comme valeur le tableau ```array('Fond', 'Droite', 'Gauche');```. On va donc parcourir le tableau grâce à un ```foreach``` qui lira les valeurs de ```$array``` comme des variable nommées ```$arraypos```. On créé ensuite une variable nommée ```$select``` (pour ne pas créer de conflis avec ```$selected``` bien qu'elles aient le me^me objectif) qu'on laisse vide.

On établit ensuite une condition ```if``` qui va comparer ```$position```, la valeur extraite de la base de donnée, et ```$arraypos```. Si la contion est respectée, ```$select``` devient alors l'option ```"selected"```. 

On fait donc apparaitre le résultat du```foreach``` grâce à un ```echo```, le tableau apparaitra. On attribue ensuite à ```value``` la valeur de ```$arraypos```, si la condition du ```if``` est respectée, dans ce cas là, le ```"selected"``` va s'insérer automatiquement, sinon le champ restera vide. Pour finir, on affiche tout les ```$arraypos``` de la boucle ```foreach``` en sautant des lignes entre chaque valeur grace à ```\n```.
