gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

// Animation simple du header
gsap.from('header', {
    y: -50,
    opacity: 0,
    duration: 1,
    ease: "power2.out"
});

// Animation simple du contenu principal
gsap.from('.content-gauche', {
    x: -50,
    opacity: 0,
    duration: 1,
    delay: 0.5,
    ease: "power2.out"
});

gsap.from('.content-droite img', {
    x: 50,
    opacity: 0,
    duration: 1,
    delay: 0.5,
    ease: "power2.out"
});

// Animation légère de l'image
gsap.to('.content-droite img', {
    y: 15,
    duration: 2,
    yoyo: true,
    repeat: -1,
    ease: "sine.inOut"
});

// Animation des statistiques
gsap.from('table tr td', {
    scrollTrigger: {
        trigger: 'table',
        start: "top 80%"
    },
    y: 30,
    opacity: 0,
    duration: 0.8,
    stagger: 0.2,
    ease: "power2.out"
});

// Animation simple des pages
['.page2', '.page3', '.page4', '.page5'].forEach(page => {
    gsap.from(page, {
        scrollTrigger: {
            trigger: page,
            start: "top 75%"
        },
        y: 50,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out"
    });
});

// Animation des titres
gsap.utils.toArray('h2').forEach(title => {
    gsap.from(title, {
        scrollTrigger: {
            trigger: title,
            start: "top 80%"
        },
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out"
    });
});

// Animation des content-details
gsap.utils.toArray('.content-details').forEach(detail => {
    gsap.from(detail, {
        scrollTrigger: {
            trigger: detail,
            start: "top 80%"
        },
        y: 30,
        opacity: 0,
        duration: 0.8,
        ease: "power2.out"
    });
});

// Animation simple du footer
gsap.from('footer', {
    scrollTrigger: {
        trigger: 'footer',
        start: "top 90%"
    },
    y: 30,
    opacity: 0,
    duration: 0.8,
    ease: "power2.out"
});

// Smooth scroll
gsap.utils.toArray('a[href^="#"]').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const target = document.querySelector(link.getAttribute('href'));
        if (target) {
            gsap.to(window, {
                duration: 0.8,
                scrollTo: {
                    y: target,
                    offsetY: 50
                },
                ease: "power2.inOut"
            });
        }
    });
});

document.getElementById('menuIcon').addEventListener('click', function() {
    document.querySelector('.menu-items').classList.toggle('active');
});

// Pour le footer accordéon
document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
        const item = header.parentElement;
        const isActive = item.classList.contains('active');
        
        // Ferme tous les accordéons
        document.querySelectorAll('.accordion-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Ouvre l'accordéon cliqué si il n'était pas déjà ouvert
        if (!isActive) {
            item.classList.add('active');
        }
    });
});