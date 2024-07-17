document.addEventListener('DOMContentLoaded', function() {
    let div = document.getElementById('auth');
    div.style.display = 'none';   
    initLinkDivToggle();
    // initShowDiv();
});

// function showAuth(){

//     // let div = document.getElementById('auth');
//     // if(div)
//     // {
//     //     div.removeAttribute('style');
//     // }

// }

// function showAuth(event) {

//     event.preventDefault();
//     let currentUrl = window.location.href;
//     let linkUrl = event.target.closest('a').href;;

//     //alert(linkUrl);

//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', '/auth', true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.send("current_url=" + encodeURIComponent(currentUrl));
//     xhr.onload = function() {
//         if (xhr.status === 200) {
//            window.location.href = linkUrl;
//         } else {
//              alert('La requête a échoué. Statut retourné : ' + xhr.status);
//         }
//     };
  
// }

function hideAuth(){
    let div = document.getElementById('blurred');
    div.style.display = 'none';  
}


function initLinkDivToggle() {
    // Sélectionne tous les liens et toutes les divs
  

}

function showDiv(button) {
    const dataId = button.getAttribute('data-id');
    const contents = document.querySelectorAll('.content');

    contents.forEach(content => {
        if (content.getAttribute('data-id') === dataId) {
            content.classList.add('active');
        } else {
            content.classList.remove('active');
        }
    });
}


// function initShowDiv(){
// const div = document.getElementById('signIn'); 
// div.style.display = "block";
// }