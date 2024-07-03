document.addEventListener('DOMContentLoaded', function() {
    let div = document.getElementById('auth');
    div.style.display = 'none';   
    initLinkDivToggle();
    // initShowDiv();
});

function showAuth(){
    let div = document.getElementById('auth');
    if(div)
    {
        div.removeAttribute('style');
    }
}

function hideAuth(){
    let div = document.getElementById('auth');
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