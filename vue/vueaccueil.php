<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Accueil</title>
    <link rel="stylesheet" href="style/styleaccueil.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bakbak+One&display=swap" rel="stylesheet">
</head>

<body>
    <div class="page1">
        <header>
            <img src="assets/img/Logo.png" alt="Logo bee connect" loading="lazy">
            <div class="header-milieu">
                <a href="">ACCUEIL</a>
                <a href="">LE PROJET</a>
                <a href="">VOUS SENSIBILISER</a>
            </div>
            <div class="header-fin">
                <a href="index.php?action=inscription" class="header-inscription">S'INSCRIRE</a>
                <a href="index.php?action=connexion" class="header-connexion">SE CONNECTER</a>
            </div>
        </header>

        <div class="page1-content">
            <div class="content-gauche">
                <h1>PROJET RUCHES CONNECTÉES</h1>
                <p>Le projet <strong>“Ruches connectées” </strong>consiste à offrir aux apiculteurs des outils modernes pour surveiller la santé des ruches et optimiser leurs productions de miel tout en simplifiant le travail.</p>
                <a href="">DÉCOUVRIR</a>
            </div>
            <div class="content-droite">
                <img src="assets/img/abeille-page1.png" alt="Abeille" loading="lazy">
            </div>
        </div>
        <table>
            <tr>
                <td>La France compte environ 1,3 million de colonies d’abeilles.</td>
                <td>Les abeilles pollinisent environ
                    80 % des espèces végétales en France</td>
                <td>Leur activité est estimée à 2 milliards d’euros par an pour l’économie française.</td>
                <td>Elles contribuent à la reproduction de 75 % des cultures agricoles</td>
            </tr>
        </table>
    </div>
    <div class="wrapper">
        <div class="scroll-horizontal">
            <div class="page2">
                <div class="page2-container">
                    <div class="page2-content">
                        <h2>AVANTAGES POUR LES APICULTEURS</h2>
                        <p>Grâce à ce système, les apiculteurs peuvent :</p>
                        <div class="content-details">
                            <img src="assets/img/up 1.png" alt="">
                            <p>Améliorer la <strong>gestion de leurs ruches.</strong></p>
                        </div>
                        <div class="content-details">
                            <img src="assets/img/shield 1.png" alt="">
                            <p>Garantir <strong>la santé</strong> à long terme de leurs colonies.</p>
                        </div>
                        <div class="content-details">
                            <img src="assets/img/fast-service 1.png" alt="">
                            <p><strong>Réagir rapidement</strong> aux situations inhabituelles, comme l'essaimage ou le vol.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page3"></div>
            <div class="page4"></div>
        </div>
        <div class="scroll-vertical">
            <div class="page5"></div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Animation horizontale pour .scroll-horizontal
        gsap.to(".scroll-horizontal", {
            x: () => -(document.querySelector(".scroll-horizontal").scrollWidth - window.innerWidth),
            ease: "none",
            scrollTrigger: {
                trigger: ".scroll-horizontal",
                start: "top top",
                end: () => "+=" + (document.querySelector(".scroll-horizontal").scrollWidth - window.innerWidth),
                scrub: true,
                pin: true,
            }
        });

        // Scroll vertical pour .scroll-vertical
        ScrollTrigger.create({
            trigger: ".scroll-vertical",
            start: "top top",
            end: "bottom bottom",
            pinSpacing: false,
        });
    </script>

</body>

</html>