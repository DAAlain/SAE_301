<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="style/styledashboard.css">
</head>

<body>
    <div class="page">
        <header>
            <div class="image">
                <img src="assets/img/Logo.webp" alt="">
            </div>
            <div class="menu">
                <h3>MENU</h3>
                <div class="menu-liens">
                    <div class="lien <?php echo (!isset($_GET['page']) || $_GET['page'] === 'dashboard') ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <a href="index.php?page=dashboard">TABLEAU DE BORD</a>
                    </div>
                    <div class="lien <?php echo (isset($_GET['page']) && $_GET['page'] === 'statistiques') ? 'active' : ''; ?>">
                        <svg fill="#000000" height="31" width="31" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 459.75 459.75" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path d="M447.652,304.13h-40.138c-6.681,0-12.097,5.416-12.097,12.097v95.805c0,6.681,5.416,12.098,12.097,12.098h40.138 c6.681,0,12.098-5.416,12.098-12.098v-95.805C459.75,309.546,454.334,304.13,447.652,304.13z"></path>
                                    <path d="M348.798,258.13H308.66c-6.681,0-12.098,5.416-12.098,12.097v141.805c0,6.681,5.416,12.098,12.098,12.098h40.138 c6.681,0,12.097-5.416,12.097-12.098V270.228C360.896,263.546,355.48,258.13,348.798,258.13z"></path>
                                    <path d="M151.09,304.13h-40.138c-6.681,0-12.097,5.416-12.097,12.097v95.805c0,6.681,5.416,12.098,12.097,12.098h40.138 c6.681,0,12.098-5.416,12.098-12.098v-95.805C163.188,309.546,157.771,304.13,151.09,304.13z"></path>
                                    <path d="M52.236,258.13H12.098C5.416,258.13,0,263.546,0,270.228v141.805c0,6.681,5.416,12.098,12.098,12.098h40.138 c6.681,0,12.097-5.416,12.097-12.098V270.228C64.333,263.546,58.917,258.13,52.236,258.13z"></path>
                                    <path d="M249.944,196.968h-40.138c-6.681,0-12.098,5.416-12.098,12.098v202.967c0,6.681,5.416,12.098,12.098,12.098h40.138 c6.681,0,12.098-5.416,12.098-12.098V209.066C262.042,202.384,256.625,196.968,249.944,196.968z"></path>
                                    <path d="M436.869,244.62c8.14,0,15-6.633,15-15v-48.479c0-8.284-6.716-15-15-15c-8.284,0-15,6.716-15,15v12.119L269.52,40.044 c-3.148-3.165-7.536-4.767-11.989-4.362c-4.446,0.403-8.482,2.765-11.011,6.445L131.745,209.185L30.942,144.969 c-6.987-4.451-16.26-2.396-20.71,4.592c-4.451,6.987-2.396,16.259,4.592,20.71l113.021,72c2.495,1.589,5.286,2.351,8.046,2.351 c4.783,0,9.475-2.285,12.376-6.507L261.003,74.025L400.8,214.62h-12.41c-8.284,0-15,6.716-15,15c0,8.284,6.716,15,15,15 c6.71,0,41.649,0,48.443,0H436.869z"></path>
                                </g>
                            </g>
                        </svg>
                        <a href="index.php?page=statistiques">STATISTIQUES</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="content">
            <div class="top-bar">
                <div class="notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </div>
                <div class="quitter">
                    <a href="index.php?action=quitter"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                        </svg>
                    </a>
                </div>
                <div class="profile">
                    <div class="profile-container">
                        <span><?= htmlspecialchars($_SESSION["nom"]) ?></span>
                        <form method="post" action="index.php?action=update_photo" enctype="multipart/form-data" id="photo-form">
                            <div class="profile-image-container">
                                <img src="assets/img/profiles/<?= !empty($_SESSION['photo_profil']) ? htmlspecialchars($_SESSION['photo_profil']) : 'default.png' ?>" alt="Photo de profil" class="profile-image">
                                <div class="profile-image-overlay">
                                    <span>Modifier</span>
                                </div>
                            </div>
                            <input type="file" name="photo" id="photo-input" accept="image/*" style="display: none;">
                        </form>
                    </div>
                </div>
            </div>

            <h2>STATISTIQUES</h2>

            <?php
            require_once "modele/bdd.php";
            $user_id = $_SESSION["id"];

            // Récupération des IDs des ruches
            $requete = "SELECT id FROM ruche WHERE id_compte = ?";
            $ruches_utilisateur = execReqPrepAll($requete, [$user_id]);
            ?>

            <div class="ruche-selector">
                <?php foreach ($ruches_utilisateur as $ruche): ?>
                    <button class="ruche-btn" data-ruche="<?= $ruche['id'] ?>">RUCHE N°<?= $ruche['id'] ?></button>
                <?php endforeach; ?>
            </div>

            <div class="stats-container">
                <div class="stats-card">
                    <h3>FRÉQUENCE</h3>
                    <canvas id="frequenceChart"></canvas>
                </div>
                <div class="stats-card">
                    <h3>TEMPÉRATURE</h3>
                    <canvas id="temperatureChart"></canvas>
                </div>
                <div class="stats-card">
                    <h3>HUMIDITÉ</h3>
                    <canvas id="humiditeChart"></canvas>
                </div>
                <div class="stats-card">
                    <h3>POIDS</h3>
                    <canvas id="poidsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        <?php
        // Charger les données JSON
        $jsonContent = file_get_contents("js/dataruches.json");
        echo "const ruches = " . $jsonContent . ";\n";
        ?>
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.1/dist/chartjs-adapter-moment.min.js"></script>
    <script src="js/scriptstatistiques.js"></script>
</body>

</html>