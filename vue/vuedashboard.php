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
    <form method="post" action="<?= $_SERVER["PHP_SELF"] ."?action=ajout"?>">
        <input type="text" name="id_ruche" placeholder="Id de votre ruche" value="" required>
        <input type="text" name="nom_ruche" placeholder="Nom pour votre ruche" value="" required>
        <button type="submit" name="ruche" value="Valider">Envoyer la demande</button>
    </form>

</body>

</html>