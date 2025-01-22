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
    if (!$ruches_utilisateur) {
        die("Aucune ruches associées à votre compte");
    }

    
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

    ?>

    

    <?php if (!empty($ruches_filtrees)): ?>
        <?php foreach ($ruches_filtrees as $id => $ruche): ?>
            <h2>Ruche ID : <?= htmlspecialchars($id) ?></h2>
            <p><strong>GPS :</strong> [<?= implode(', ', $ruche['gps']) ?>]</p>
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
                    <?php foreach ($ruche['data'] as $data): ?>
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
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune donnée disponible pour vos ruches.</p>
    <?php endif; ?>

</body>

</html>