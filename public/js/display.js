// ***
//Fichier de base pour le layout


// Afficher et masquer la div de connexion présente dans le layout

document.addEventListener('DOMContentLoaded', function() {
    let div = document.getElementById('dialogue');
    div.style.display = 'none';   
});

function showDialogue(){
    let div = document.getElementById('dialogue');
    if(div)
    {
        div.removeAttribute('style');
    }
}

function hideDialogue(){
    let div = document.getElementById('dialogue');
    div.style.display = 'none';  
}

