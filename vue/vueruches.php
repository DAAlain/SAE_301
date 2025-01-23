<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Ruches</title>
    <link rel="stylesheet" href="style/styleadmin.css">
</head>

<body>
    <header>
        <div class="logo">
            <img src="assets/img/Logo.webp" alt="BeeConnect">
        </div>
        <nav>
            <a href="index.php?acces=admin">GÉRER UTILISATEURS</a>
            <a href="index.php?acces=ruches" class="active">GÉRER RUCHES</a>
        </nav>
        <div class="quitter">
            <a href="index.php?action=quitter"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                </svg>
            </a>
        </div>
        <div class="admin-badge">
            [ADMIN]
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>
    </header>

    <main>
        <div class="ruches-container">
            <div class="ruches-list">
                <h2>GÉRER RUCHES</h2>
                <h3>Nouvelles demandes de ruche</h3>
                <?php $demandes_ruches = demandes(); ?>
                <?php if (isset($demandes_ruches) && !empty($demandes_ruches)): ?>
                    <?php foreach ($demandes_ruches as $demande): ?>
                        <div class="ruche-demande" onclick="afficherDetails('<?= $demande['id'] ?>', '<?= $demande['nom_compte'] ?>')">
                            <div class="ruche-header">
                                <h4>Ruche #<?= $demande['id'] ?> - <?= $demande['nom_compte'] ?></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune nouvelle demande de ruche</p>
                <?php endif; ?>
            </div>

            <div class="ruche-details" id="ruche-details">
                <h2>DÉTAILS DE LA DEMANDE</h2>
                <div class="action-buttons">
                    <form method="POST" action="index.php?acces=ruches&action=gerer">
                        <input type="hidden" name="demande_id" id="demande_id" value="">
                        <button type="submit" name="action" value="accepter" class="accept-ruche">ACCEPTER DEMANDE</button>
                        <button type="submit" name="action" value="refuser" class="delete-ruche">REFUSER DEMANDE</button>
                    </form>
                </div>
                <div class="ruche-image">
                    <img src="assets/img/ruche-abeilles.png" alt="Ruche et abeilles">
                </div>
            </div>
        </div>
    </main>

    <script>
        function afficherDetails(id, nom) {
            document.getElementById('demande_id').value = id;
            document.querySelector('.ruche-details h2').textContent = `DEMANDE DE RUCHE #${id} - ${nom}`;
            document.getElementById('ruche-details').style.display = 'block';
        }
    </script>
</body>

</html>