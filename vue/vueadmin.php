<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>js</p>
    <a href="index.php?action=quitter">Quitter</a>
    <?php
    require_once "controlleur/controlleur.php";
    $demandes = demandes();
    ?>
    <h1>Demandes d'ajout de ruche</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom Ruche</th>
            <th>Nom Compte</th>
            <th>Action</th>
        </tr>
        <?php foreach ($demandes as $demande): ?>
            <tr>
                <td><?= htmlspecialchars($demande['id']) ?></td>
                <td><?= htmlspecialchars($demande['nom_ruche']) ?></td>
                <td><?= htmlspecialchars($demande['nom_compte']) ?></td>
                <td>
                    <form method="POST" action="<?= $_SERVER["PHP_SELF"]."?action=gerer"?>">
                        <input type="hidden" name="demande_id" value="<?= $demande['id'] ?>">
                        <button name="action" value="accepter">Accepter</button>
                        <button name="action" value="refuser">Refuser</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>