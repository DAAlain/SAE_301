let str=window.location.href;
var url= new URL(str);
var action= url.searchParams.get("action");
console.log(action);

const container = document.querySelector('.container');
const boutoni = document.querySelector('.btn-register');
const boutonc = document.querySelector('.btn-login');

if(action == "inscription"){
    container.classList.add('active');
}

boutoni.addEventListener('click', () => {
    container.classList.add('active');
})

boutonc.addEventListener('click', () => {
    container.classList.remove('active');
})

document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const errorDiv = document.getElementById('error-messages');

    // Fonctions de validation
    function validatePassword(password) {
        if (password.length < 8) {
            return "Le mot de passe doit contenir au moins 8 caractères";
        }
        if (!/[a-z]/.test(password)) {
            return "Le mot de passe doit contenir au moins une minuscule";
        }
        if (!/[A-Z]/.test(password)) {
            return "Le mot de passe doit contenir au moins une majuscule";
        }
        if (!/\d/.test(password)) {
            return "Le mot de passe doit contenir au moins un chiffre";
        }
        return null; // Pas d'erreur
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Afficher un message d'erreur
    function showError(message) {
        errorDiv.innerHTML = ''; // Nettoie les messages précédents
        const errorElement = document.createElement('div');
        errorElement.className = 'error-message';
        errorElement.textContent = message;
        errorDiv.appendChild(errorElement);
    }

    // Validation du formulaire d'inscription
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Empêche l'envoi du formulaire par défaut

        const username = this.querySelector('input[name="Nom"]').value;
        const email = this.querySelector('input[name="Mail"]').value;
        const password = this.querySelector('input[name="Mdp"]').value;

        // Réinitialiser les messages d'erreur
        errorDiv.innerHTML = '';

        // 1. Validation du nom d'utilisateur
        if (username.trim() === '') {
            showError("Le nom d'utilisateur est requis");
            return;
        }
        if (username.length < 3) {
            showError("Le nom d'utilisateur doit contenir au moins 3 caractères");
            return;
        }

        // 2. Validation de l'email
        if (email.trim() === '') {
            showError("L'adresse email est requise");
            return;
        }
        if (!validateEmail(email)) {
            showError("L'adresse email n'est pas valide");
            return;
        }

        // 3. Validation du mot de passe
        if (password.trim() === '') {
            showError("Le mot de passe est requis");
            return;
        }
        
        const passwordError = validatePassword(password);
        if (passwordError) {
            showError(passwordError);
            return;
        }

        // Si on arrive ici, il n'y a pas d'erreur, on peut soumettre le formulaire
        this.submit();
    });
});
