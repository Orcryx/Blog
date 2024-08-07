document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.getElementById('registerForm');
    const registerButton = document.getElementById('register-btn');

    registerButton.addEventListener('click', function (event) {
        event.preventDefault();
        validateRegisterForm();
    });

    function validateRegisterForm() {

        const name = document.getElementById('name').value.trim();
        const firstName = document.getElementById('firstName').value.trim();
        const nickname = document.getElementById('nickname').value.trim();
        const email = document.getElementById('mail').value.trim();
        const password = document.getElementById('pswd').value.trim();
        const passwordConfirm = document.getElementById('pswdC').value.trim();

        let isValid = true;
        let errorMessage = '';

        // Vérifier que tous les champs sont remplis
        if (!name || !firstName || !nickname || !email || !password) {
            isValid = false;
            errorMessage += 'Tous les champs sont obligatoires.\n';
        }

        // Vérifier le format de l'email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            isValid = false;
            errorMessage += 'L\'email n\'est pas valide.\n';
        }

        // Vérifier la longueur du mot de passe
        if (password.length < 6) {
            isValid = false;
            errorMessage += 'Le mot de passe doit contenir au moins 6 caractères.\n';
        }

        if (password !== passwordConfirm) {
            isValid = false;
            errorMessage += 'Les mots de passe ne correspondent pas.\n';
        }

        if (isValid) {
            registerForm.submit();
        } else {
            alert(errorMessage);
        }
    }
});