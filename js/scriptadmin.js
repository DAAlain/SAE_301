document.addEventListener('DOMContentLoaded', function() {
    const profileImage = document.querySelector('.profile-image-container');
    const photoInput = document.querySelector('#photo-input');
    const photoForm = document.querySelector('#photo-form');

    if (profileImage && photoInput) {
        profileImage.addEventListener('click', function() {
            photoInput.click();
        });

        photoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Soumettre le formulaire automatiquement quand une image est sélectionnée
                photoForm.submit();
            }
        });
    }
});