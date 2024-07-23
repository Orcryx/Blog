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

function sendComment() {
    const xhr = new XMLHttpRequest();
    const xmlString = document.getElementById('commentAdd-btn');
    const btnId = xmlString.id;
    xhr.open('POST', ' ', true);
    xhr.setRequestHeader('Content-Type', 'application/xml');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                showDialogue();
            } else {
                console.error('Erreur:', xhr.statusText);
            }
        }
    };

    xhr.send("id" + btnId);
}