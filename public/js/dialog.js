
document.addEventListener('DOMContentLoaded', () => {

    const buttons = document.querySelectorAll('.content-button');
    // console.log(buttons);
    const dialog = document.getElementById('dialogDiv');
    // console.log(dialog);
    
    // Fonction pour gérer les clics sur les boutons
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            // Récupérer l'attribut data-content du bouton cliqué
            const content = this.getAttribute('data-content');
            console.log(content);
           // dialog.showModal();
           
            // Envoie d'une requête AJAX pour charger le contenu dynamique
            fetch('/action', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'dataContent=' + encodeURIComponent(dataContent) // encode la valeur pour l'envoyer
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Affiche la réponse du serveur (optionnel)
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

})