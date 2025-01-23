<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs</title>
    <link rel="stylesheet" href="style/styleadmin.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="assets/img/Logo.webp" alt="BeeConnect">
        </div>
        <nav>
            <a href="index.php?acces=admin" class="active">GÉRER UTILISATEURS</a>
            <a href="index.php?acces=ruches">GÉRER RUCHES</a>
        </nav>

        <div class="profile">
            <div class="profile-container">
                <div class="quitter">
                    <a href="index.php?action=quitter"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                        </svg>
                    </a>
                </div>
                <form method="post" action="index.php?action=update_photo" enctype="multipart/form-data" id="photo-form">
                    <div class="profile-image-container">
                        <img src="assets/img/profiles/<?= !empty($_SESSION['photo_profil']) ? htmlspecialchars($_SESSION['photo_profil']) : 'default.png' ?>" alt="Photo de profil" class="profile-image">
                        <div class="profile-image-overlay">
                            <span>Modifier</span>
                        </div>
                    </div>
                    <input type="file" name="photo" id="photo-input" accept="image/*" style="display: none;">
                </form>
                <span>[ADMIN] <?= htmlspecialchars($_SESSION["nom"]) ?></span>
            </div>
        </div>
    </header>

    <main>
        <div class="users-container">
            <div class="users-list">
                <h2>GÉRER UTILISATEURS</h2>
                <div class="users-grid">
                    <?php $users = admin_users(); ?>
                    <?php if (isset($users) && $users): ?>
                        <?php foreach ($users as $user): ?>
                            <div class="user-item" data-userid="<?= $user['id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span><?= $user['Nom'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun utilisateur trouvé</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="user-details" style="display: none;">
                <h2>UTILISATEUR <span class="user-name"></span></h2>
                <div class="action-buttons">
                    <button class="delete-user">SUPPRIMER UTILISATEUR</button>
                </div>
                <div class="ruches-list">
                    <!-- Les ruches seront injectées ici par JavaScript -->
                </div>
            </div>
        </div>
    </main>

    <script src="js/dataruches.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userItems = document.querySelectorAll('.user-item');
            const userDetails = document.querySelector('.user-details');
            const ruchesList = document.querySelector('.ruches-list');
            let currentUserId = null;

            // Récupérer toutes les ruches de la base de données
            const allRuches = <?php echo json_encode(get_ruches()); ?>; //Attention ici seulement pour l'utilisateur 3
            console.log('Ruches:', allRuches); // Pour déboguer

            userItems.forEach(item => {
                item.addEventListener('click', function() {
                    currentUserId = parseInt(this.dataset.userid);
                    const userName = this.querySelector('span').textContent;

                    // Afficher le panneau et mettre à jour le nom
                    userDetails.style.display = 'block';
                    userDetails.querySelector('.user-name').textContent = userName;

                    // Vider la liste des ruches
                    ruchesList.innerHTML = '';

                    // Filtrer les ruches pour cet utilisateur
                    const userRuches = allRuches.filter(ruche => parseInt(ruche.id_compte) === currentUserId);

                    if (userRuches && userRuches.length > 0) {
                        userRuches.forEach(ruche => {
                            // Vérifier si les données de la ruche existent dans dataruches.js
                            if (ruches[ruche.id]) {
                                const rucheData = ruches[ruche.id];
                                const lastData = rucheData.data[rucheData.data.length - 1];

                                const rucheElement = document.createElement('div');
                                rucheElement.className = 'ruche-item';
                                rucheElement.innerHTML = `
                                    <div class="ruche-header">
                                        <h3>RUCHE ${ruche.id} - ${ruche.nom_ruche}</h3>
                                        <button class="delete-ruche" data-ruche="${ruche.id}">Supprimer</button>
                                    </div>
                                    <div class="ruche-data">
                                        <div class="data-item">
                                            <span class="label">Température:</span>
                                            <span class="value">${lastData.temperature}°C</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="label">Humidité:</span>
                                            <span class="value">${lastData.humidite}%</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="label">Poids:</span>
                                            <span class="value">${lastData.poids}kg</span>
                                        </div>
                                        <div class="data-item">
                                            <span class="label">Fréquence:</span>
                                            <span class="value">${lastData.frequence}Hz</span>
                                        </div>
                                    </div>
                                `;
                                ruchesList.appendChild(rucheElement);
                            }
                        });
                    } else {
                        ruchesList.innerHTML = '<p>Cet utilisateur n\'a pas de ruches.</p>';
                    }
                });
            });

            // Gestion de la suppression d'un utilisateur
            document.querySelector('.delete-user').addEventListener('click', async function() {
                if (currentUserId && confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur et toutes ses ruches ?')) {
                    try {
                        const response = await fetch('index.php?acces=admin&action=delete_user', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                user_id: currentUserId
                            })
                        });

                        if (response.ok) {
                            // Supprimer l'élément utilisateur de l'interface
                            document.querySelector(`[data-userid="${currentUserId}"]`).remove();
                            userDetails.style.display = 'none';
                            alert('Utilisateur supprimé avec succès');
                        }
                    } catch (error) {
                        console.error('Erreur lors de la suppression:', error);
                        alert('Erreur lors de la suppression de l\'utilisateur');
                    }
                }
            });

            // Gestion de la suppression d'une ruche
            ruchesList.addEventListener('click', async function(e) {
                if (e.target.classList.contains('delete-ruche')) {
                    const rucheId = e.target.dataset.ruche;
                    if (confirm('Êtes-vous sûr de vouloir supprimer cette ruche ?')) {
                        try {
                            const response = await fetch('index.php?acces=admin&action=delete_ruche', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({
                                    ruche_id: rucheId
                                })
                            });

                            if (response.ok) {
                                // Supprimer l'élément ruche de l'interface
                                e.target.closest('.ruche-item').remove();
                                alert('Ruche supprimée avec succès');
                            }
                        } catch (error) {
                            console.error('Erreur lors de la suppression:', error);
                            alert('Erreur lors de la suppression de la ruche');
                        }
                    }
                }
            });
        });
    </script>
    <script src="js/scriptadmin.js"></script>
</body>

</html>