document.addEventListener('DOMContentLoaded', function () {
    const profileImage = document.querySelector('.profile-image-container');
    const photoInput = document.querySelector('#photo-input');
    const photoForm = document.querySelector('#photo-form');

    if (profileImage && photoInput) {
        profileImage.addEventListener('click', function () {
            photoInput.click();
        });

        photoInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                // Soumettre le formulaire automatiquement quand une image est sélectionnée
                photoForm.submit();
            }
        });
    }

    // Nouveau code pour la gestion des ruches
    const rucheDemandes = document.querySelectorAll('.ruche-demande');
    const rucheDetails = document.getElementById('ruche-details');

    function afficherDetails(id, nom) {
        // Retirer la classe active de toutes les demandes
        rucheDemandes.forEach(demande => {
            demande.classList.remove('active');
        });

        // Ajouter la classe active à la demande sélectionnée
        const selectedDemande = document.querySelector(`.ruche-demande[onclick*="${id}"]`);
        if (selectedDemande) {
            selectedDemande.classList.add('active');
        }

        // Mettre à jour les détails
        document.getElementById('demande_id').value = id;
        document.querySelector('.ruche-details h2').textContent = `DEMANDE DE RUCHE #${id} - ${nom}`;

        // Afficher le panneau de détails avec animation
        rucheDetails.classList.add('active');
    }

    // Rendre la fonction disponible globalement
    window.afficherDetails = afficherDetails;
});

// Gestion du menu hamburger
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.createElement('div');
    hamburger.className = 'hamburger-menu';
    hamburger.innerHTML = '<span></span><span></span><span></span>';
    document.body.appendChild(hamburger);

    const overlay = document.createElement('div');
    overlay.className = 'menu-overlay';
    document.body.appendChild(overlay);

    hamburger.addEventListener('click', function() {
        const header = document.querySelector('header');
        this.classList.toggle('active');
        header.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', function() {
        const header = document.querySelector('header');
        hamburger.classList.remove('active');
        header.classList.remove('active');
        this.classList.remove('active');
    });
});
