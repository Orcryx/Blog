document.addEventListener('DOMContentLoaded', function() {
    let div = document.getElementById('auth');
    div.style.display = 'none';   
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