document.addEventListener('DOMContentLoaded', function() {
    let div = document.getElementById('auth');
    div.style.display = 'none';   
});



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


