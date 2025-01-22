<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>Hello <?= $_SESSION["nom"] ?></div>
    <p>js</p>
    <a href="index.php?action=quitter">Quitter</a>
    <br>
    <br>
    <!--A mettre dans un popup ou autre-->
    <form method="post" action="<?= $_SERVER["PHP_SELF"] . "?action=ajout" ?>">
        <input type="text" name="id_ruche" placeholder="Id de votre ruche" value="" required>
        <input type="text" name="nom_ruche" placeholder="Nom pour votre ruche" value="" required>
        <button type="submit" name="ruche" value="Valider">Envoyer la demande</button>
    </form>

    <h2>Vos ruches</h2>
    <?php
    require_once "modele/bdd.php";
    $user_id = $_SESSION["id"];
    $requete = "SELECT id FROM ruche WHERE id_compte = ?";
    $ruches_utilisateur = execReqPrepAll($requete, [$user_id]);

    //Pour afficher la liste des ruches que l'utilisateur possède
    if (!empty($ruches_utilisateur)): ?>
        <ul>
            <?php foreach ($ruches_utilisateur as $ruche): ?>
                <li>
                    <a href="?id=<?= htmlspecialchars($ruche['id']) ?>">Ruche n°<?= $ruche['id'] ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Vous n'avez aucune ruche pour le moment.</p>
    <?php endif;
    

    //Pour trouver les données du fichier dataruche.js
    $filename = "js/dataruches.js";
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
        <h2>Données de la ruche : <?=htmlspecialchars($ruche["id"]) ?></h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Température (°C)</th>
                    <th>Poids (kg)</th>
                    <th>Humidité (%)</th>
                    <th>Fréquence (Hz)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rucheData['data'] as $data): ?>
                    <tr>
                        <td><?= htmlspecialchars($data['date']) ?></td>
                        <td><?= htmlspecialchars($data['temperature']) ?></td>
                        <td><?= htmlspecialchars($data['poids']) ?></td>
                        <td><?= htmlspecialchars($data['humidite']) ?></td>
                        <td><?= htmlspecialchars($data['frequence']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($_GET['id'])): ?>
        <p>Aucune donnée disponible pour cette ruche ou elle ne vous appartient pas.</p>
    <?php endif; ?>
</body>

</html>