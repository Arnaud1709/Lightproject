//Script pour le modal de suppression de ligne 
function confirmation(id){ 
    const confirm=document.getElementById("confirmation")
    confirm.setAttribute("data", "delete.php?id="+id)
}

function trash(){
    const confirm=document.getElementById("confirmation")
    const url=confirm.getAttribute("data")
    window.location.href = url;
}

//Script pour le modal de deconnexion
//on sélectionne tous le lien deconnexion
const deleteLinks = document.getElementsByClassName('delet');

const btnYes = document.getElementById('validation');


for( deleteLink of deleteLinks ){
    // Affecte l'évenement click
    // sur click s'executera une fonction sans nom (dite anonyme)
    deleteLink.addEventListener('click', function(e){
    // pour ne pas executer les évènements par défauts (là aller sur la page deconnexion.php)
    e.preventDefault();
    //Selectionne l'element ayant l'id deco
    const modal = document.getElementById('deco');
    modal.classList.toggle('hidden');
    //ajout de la classe ready-to-delete au lien que l'on vient de cliquer
    this.classList.toggle('ready-to-delete');
    //console.log('test');
    });
}

btnYes.addEventListener('click', function(){
    const modal = document.getElementById('deco');
    modal.classList.toggle('hidden');
     // on fait une sélection du lien ayant la classe ready-to-delete
     const elementsToDelete = document.getElementsByClassName('ready-to-delete')
     for(elementToDelete of elementsToDelete){
         //du moment qu'il y a une collection on fait une boucle
        location.href = elementToDelete.getAttribute('href');
        
        }
});
