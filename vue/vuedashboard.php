<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/styledashboard.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
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

            <h2>TABLEAU DE BORD</h2>

            <?php
            require_once "modele/bdd.php";
            $user_id = $_SESSION["id"];
            $requete = "SELECT id FROM ruche WHERE id_compte = ?";
            $ruches_utilisateur = execReqPrepAll($requete, [$user_id]);

            //Pour afficher la liste des ruches que l'utilisateur possède
            if (!empty($ruches_utilisateur)): ?>
                <div class="ruches">
                    <?php foreach ($ruches_utilisateur as $ruche): ?>
                        <a href="?id=<?= htmlspecialchars($ruche['id']) ?>">RUCHE N°<?= $ruche['id'] ?></a>
                    <?php endforeach; ?>
                    <a href="#" id="ajoutruche">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg></a>
                </div>
                <!--A mettre dans un popup ou autre-->
                <div id="formajoutruche" style="display: none;">
                    <button class="quitter_form">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                    <form method="post" action="<?= $_SERVER["PHP_SELF"] . "?action=ajout" ?>">
                        <input type="text" name="id_ruche" placeholder="ID de votre appareil" value="" required>
                        <input type="text" name="nom_ruche" placeholder="Nom pour votre ruche" value="" required>
                        <button type="submit" name="ruche" value="Valider" id="fermer">Envoyer la demande</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Vous n'avez aucune ruche pour le moment.</p>
                <div id="formajoutruche" style="display: none;">
                    <button class="quitter_form">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                    <form method="post" action="<?= $_SERVER["PHP_SELF"] . "?action=ajout" ?>">
                        <input type="text" name="id_ruche" placeholder="ID de votre appareil" value="" required>
                        <input type="text" name="nom_ruche" placeholder="Nom pour votre ruche" value="" required>
                        <button type="submit" name="ruche" value="Valider" id="fermer">Envoyer la demande</button>
                    </form>
                </div>
                <a href="#" id="ajoutruche2"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg></a>
            <?php endif;
            ?>

            <!-- Nouvelle section carte -->

            <?php
            //Pour trouver les données du fichier dataruche.js
            $filename = "js/dataruches.json";
            if (file_exists($filename)) {
                $filecontent = file_get_contents($filename);

                $jsonString = preg_replace('/^ruches\s*=\s*/', '', trim($filecontent));

                $jsonString = rtrim($jsonString, ';');
                $ruches = json_decode($jsonString, true);
            }
            $ruches_filtrees = array_filter($ruches, function ($key) use ($ruches_utilisateur) {
                foreach ($ruches_utilisateur as $ruche) {
                    if ($key == $ruche['id']) {
                        return true;
                    }
                }
                return false;
            }, ARRAY_FILTER_USE_KEY);

            //Pour afficher les données d'une seule ruche
            $rucheData = null;
            if (isset($_GET['id'])) {
                $rucheId = $_GET['id'];

                // Vérifier que la ruche appartient bien à l'utilisateur
                $requeteRuche = "SELECT * FROM ruche WHERE id = ? AND id_compte = ?";
                $dataRuche = [$rucheId, $user_id];
                $ruche = execReqPrep($requeteRuche, $dataRuche);

                if (!empty($ruche)) {
                    // Récupérer les données de cette ruche
                    $rucheData = $ruches_filtrees["$rucheId"]; //trouver pour avoir que la ruche de l'id et que cela correspond avec le js.
                }
            }

            //Affichage des données pour la ruche selectionnée
            if ($rucheData): ?>
                <div class="dashboard-cards">
                    <div class="card frequence-card">
                        <h3>FRÉQUENCE</h3>
                        <div class="frequence-value"><?= htmlspecialchars(end($rucheData['data'])['frequence']) ?> hz</div>
                        <div class="frequence-graph">
                            <img src="assets/img/frequence.png" alt="Frequence" style="width: 70%">
                        </div>
                    </div>

                    <div class="card temperature-card"
                        style="background: <?php
                                            $temp = end($rucheData['data'])['temperature'];
                                            // Définir les plages de température
                                            $min_temp = -10; // Température minimale (bleu froid)
                                            $max_temp = 45;  // Température maximale (rouge chaud)

                                            // Limiter la température dans notre plage
                                            $temp = max($min_temp, min($max_temp, $temp));

                                            // Calculer le pourcentage sur notre plage étendue
                                            $percentage = (($temp - $min_temp) / ($max_temp - $min_temp)) * 100;

                                            if ($temp <= 10) {
                                                // Bleu froid (-10°C à 10°C)
                                                $r = round(($percentage * 135) / 50);  // 0 -> 135
                                                $g = round(($percentage * 206) / 50);  // 0 -> 206
                                                $b = 255;
                                            } elseif ($temp <= 25) {
                                                // Vert tempéré (10°C à 25°C)
                                                $r = round(135 + (($percentage - 50) * 120) / 50);  // 135 -> 255
                                                $g = 206;
                                                $b = round(255 - (($percentage - 50) * 255) / 50);  // 255 -> 0
                                            } else {
                                                // Rouge chaud (25°C à 45°C)
                                                $r = 255;
                                                $g = round(206 - (($percentage - 75) * 206) / 25);  // 206 -> 0
                                                $b = 0;
                                            }

                                            echo "rgba($r, $g, $b, 0.7)";
                                            ?>">
                        <h3>TEMPÉRATURE</h3>
                        <div class="flex-data">
                            <div class="temp-value"><?= htmlspecialchars(end($rucheData['data'])['temperature']) ?>°C</div>
                            <img src="assets/img/thermometres.png" alt="Température" style="width: 25%">
                        </div>
                    </div>

                    <div class="card humidite-card"
                        style="background: <?php
                                            $humidite = end($rucheData['data'])['humidite'];

                                            // L'humidité est déjà en pourcentage (0-100%)
                                            // Limiter l'humidité entre 0 et 100%
                                            $humidite = max(0, min(100, $humidite));

                                            // Plus l'humidité est élevée, plus la couleur sera bleue
                                            // Pour une humidité de 0%, r=255, g=255, b=255 (blanc)
                                            // Pour une humidité de 100%, r=0, g=150, b=255 (bleu)
                                            $r = round(255 - ($humidite * 255 / 100));
                                            $g = round(255 - ($humidite * 105 / 100));  // 255 -> 150
                                            $b = 255;

                                            echo "rgba($r, $g, $b, 0.7)";
                                            ?>">
                        <h3>HUMIDITÉ</h3>
                        <div class="flex-data">
                            <div class="humidity-value"><?= htmlspecialchars(end($rucheData['data'])['humidite']) ?>%</div>
                            <img src="assets/img/humidite.png" alt="Humidité">
                        </div>
                    </div>

                    <div class="card poids-card">
                        <h3>POIDS</h3>
                        <div class="flex-data">
                            <div class="weight-value"><?= htmlspecialchars(end($rucheData['data'])['poids']) ?> kg</div>
                            <img src="assets/img/poids.png" alt="Ruche" style="width: 30%">
                        </div>
                    </div>

                    <div class="card date-card">
                        <h3>DATE</h3>
                        <div class="calendar">
                            <div class="calendar-header">
                                <div class="calendar-nav">
                                    <span class="prev-month">&lt;</span>
                                    <span class="current-month"></span>
                                    <span class="next-month">&gt;</span>
                                </div>
                            </div>
                            <div class="weekdays">
                                <div>D</div>
                                <div>L</div>
                                <div>M</div>
                                <div>M</div>
                                <div>J</div>
                                <div>V</div>
                                <div>S</div>
                            </div>
                            <div class="calendar-days"></div>
                        </div>
                    </div>
                    <div class="map-section">
                        <h3>LOCALISATION DES RUCHES</h3>
                        <div id="map"></div>
                    </div>
                    <div class="notes-ruches">
                        <textarea name="" id=""></textarea>
                    </div>
                </div>
            <?php elseif (isset($_GET['id'])): ?>
                <p>Aucune donnée disponible pour cette ruche ou elle ne vous appartient pas.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Rendre les données disponibles pour JavaScript
        const ruches = <?php echo json_encode($ruches_filtrees); ?>;
    </script>
    <script src="js/scriptdashboard.js"></script>
</body>

</html>