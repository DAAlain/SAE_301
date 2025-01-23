document.addEventListener('DOMContentLoaded', function () {
    const userItems = document.querySelectorAll('.user-item');
    const userDetails = document.querySelector('.user-details');

    userItems.forEach(item => {
        item.addEventListener('click', function () {
            // Afficher le panneau de détails
            userDetails.style.display = 'block';

            // Récupérer l'ID de l'utilisateur
            const userId = this.dataset.userid;

            // Mettre à jour le titre avec l'ID de l'utilisateur
            const userTitle = userDetails.querySelector('h2');
            userTitle.textContent = `UTILISATEUR [USER${userId}]`;
        });
    });
}); 