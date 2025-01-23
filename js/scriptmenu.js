document.addEventListener('DOMContentLoaded', () => {
    const menuLinks = document.querySelectorAll('.menu a');
    const currentPage = new URLSearchParams(window.location.search).get('page') || 'dashboard';

    menuLinks.forEach(link => {
        // Vérifier si le lien correspond à la page actuelle
        const linkPage = link.getAttribute('href').split('page=')[1];
        if (linkPage === currentPage) {
            link.classList.add('active');
        }

        // Gérer le clic sur les liens
        link.addEventListener('click', () => {
            menuLinks.forEach(l => l.classList.remove('active'));
            link.classList.add('active');
        });
    });
}); 