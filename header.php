<header>
        <div class="titre">  
            <!-- Logo et nom du logiciel -->          
            <h1 class="idea">
                <img class="logo" src="getsupercustomizedimage.png">
                GOOD IDEA
            </h1>
            <!-- Nom de la page-->
            <div class="page">
                <h1 class="localisation"><?= $titre?></h1>
            </div>
            <!--Salutation personnalisé et déconnexion-->
            <nav class="user">
                <p class="session">
                    <span>
                        <?php                
                            echo 'Bonjour ' .$_SESSION['utilisateur'].' !'
                        ?>
                    </span>
                    <?php 
                    echo '<a title="Au revoir'.$_SESSION['utilisateur'].'!" uk-icon="sign-out" class="delet" uk-toggle="target: #deco" href="deconnexion.php"></a>'

                    ?>
                </p>
            </nav>
        </div>
    </header>
    
    <div id="deco" uk-modal>
        <div class="uk-modal-dialog uk-modal-body ">
            <h1>Déconnexion</h1>
            <p>Êtes-vous sur de vouloir vous déconnecter?</p>
            <p class="uk-text-center">
                <button class="uk-button uk-button-default" id="validation" onclick="deco()" type="button" href="deconnexion.php">Oui</button>
                <button class="uk-button uk-button-default uk-modal-close" type="button">Non</button>
            </p>
         </div>
    </div>

    <script src="script.js"></script>

