<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeeConnect - Inscription et connexion</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="assets/img/Logo.webp">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style/styleinscription.css">
</head>
<body>
    <div class="container">

        <!--Formulaire Connexion-->
        <div class="form-box login">
            <form method="post" action="<?= $_SERVER["PHP_SELF"] ."?action=login"?>" id="loginForm">
                <h1 class="bakbak-one-regular">Connexion</h1>
                <div class="input-box">
                    <input class="exo-regular" type="email" placeholder="E-mail" name="mail" value="" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input class="exo-regular" type="password" placeholder="Mot de passe" name="mdp" value="" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <a href="#" class="exo-regular">Mot de passe oublié ?</a>
                </div>
                <button type="submit" class="btn bakbak-one-regular valid" name="ok" value="Valider" >Connexion</button>
                <div id="error-messages-login" class="error-messages">
                </div>
            </form>
        </div>

        <!--Formulaire Inscription-->
        <div class="form-box register">
            <form method="post" action="<?= $_SERVER["PHP_SELF"] ."?action=register"?>" id="registerForm" novalidate>
                <h1 class="bakbak-one-regular">Inscription</h1>
                <div class="input-box">
                    <input class="exo-regular" type="text" placeholder="Nom d'utilisateur" name="Nom" value="" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input class="exo-regular" type="email" placeholder="E-mail" name="Mail" value="" required>
                    <i class='bx bxs-envelope'></i>
                </div>
                <div class="input-box">
                    <input class="exo-regular" type="password" placeholder="Mot de passe *" name="Mdp" value="" 
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$"
                        title="Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre"
                        required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <label for="">* Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre</label>
                <button type="submit" class="btn bakbak-one-regular" name="ajout" value="Valider">Inscription</button>
                <div id="error-messages" class="error-messages"></div>
            </form>
        </div>

        <!--Redirection Formulaire Inscription/Connexion-->
        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1 class="bakbak-one-regular">Hello, Bienvenue !</h1>
                <p class="exo-regular">Pas encore de compte ?</p>
                <button class="btn btn-register bakbak-one-regular">Inscription</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1 class="bakbak-one-regular">Bon Retour !</h1>
                <p class="exo-regular">Vous avez déjà un compte ?</p>
                <button class="btn btn-login bakbak-one-regular">Connexion</button>
            </div>
        </div>


    </div>
    <script src="js/scriptinscription.js"></script>
</body>
</html>