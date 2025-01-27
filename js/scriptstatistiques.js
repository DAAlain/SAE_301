document.addEventListener('DOMContentLoaded', () => {
    const charts = {};
    let activeRucheId = null;

    

    // Configuration commune pour les graphiques
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'day',
                    displayFormats: {
                        day: 'DD/MM'
                    }
                }
            }
        }
    };

    // Création des graphiques
    function createCharts(rucheId) {
        const data = ruches[rucheId].data;
        const dates = data.map(item => new Date(item.date));

        // Graphique Fréquence
        charts.frequence = new Chart(document.getElementById('frequenceChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    data: data.map(item => item.frequence),
                    borderColor: '#2196F3',
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        title: {
                            display: true,
                            text: 'Hz'
                        }
                    }
                }
            }
        });

        // Graphique Température
        charts.temperature = new Chart(document.getElementById('temperatureChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    data: data.map(item => item.temperature),
                    borderColor: '#F44336',
                    backgroundColor: 'rgba(244, 67, 54, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        title: {
                            display: true,
                            text: '°C'
                        }
                    }
                }
            }
        });

        // Graphique Humidité
        charts.humidite = new Chart(document.getElementById('humiditeChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    data: data.map(item => item.humidite),
                    borderColor: '#4CAF50',
                    backgroundColor: 'rgba(76, 175, 80, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        title: {
                            display: true,
                            text: '%'
                        }
                    }
                }
            }
        });

        // Graphique Poids
        charts.poids = new Chart(document.getElementById('poidsChart'), {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    data: data.map(item => item.poids),
                    borderColor: '#FFC107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    ...commonOptions.scales,
                    y: {
                        title: {
                            display: true,
                            text: 'kg'
                        }
                    }
                }
            }
        });
    }

    // Gestion des boutons de sélection de ruche
    const rucheBtns = document.querySelectorAll('.ruche-btn');
    rucheBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const rucheId = btn.dataset.ruche;

            // Mise à jour de l'état actif des boutons
            rucheBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Destruction des graphiques existants
            Object.values(charts).forEach(chart => chart.destroy());

            // Création des nouveaux graphiques
            createCharts(rucheId);
            activeRucheId = rucheId;
        });
    });

    // Sélectionner automatiquement la première ruche
    if (rucheBtns.length > 0) {
        rucheBtns[0].click();
    }
}); 



// Gestion du menu hamburger
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.createElement('div');
    hamburger.className = 'hamburger-menu';
    hamburger.innerHTML = '<span></span><span></span><span></span>';
    document.body.appendChild(hamburger);

    const overlay = document.createElement('div');
    overlay.className = 'menu-overlay';
    document.body.appendChild(overlay);

    hamburger.addEventListener('click', function() {
        const header = document.querySelector('header');
        this.classList.toggle('active');
        header.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', function() {
        const header = document.querySelector('header');
        hamburger.classList.remove('active');
        header.classList.remove('active');
        this.classList.remove('active');
    });
});