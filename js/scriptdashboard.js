const ajoutruche = document.getElementById("ajoutruche");
if (ajoutruche) {
    ajoutruche.addEventListener("click", function () {
        document.getElementById("formajoutruche").style.display = 'block';
    });
};

const ajoutruche2 = document.getElementById("ajoutruche2");
if (ajoutruche2) {
    ajoutruche2.addEventListener("click", function () {
        document.getElementById("formajoutruche").style.display = 'block';
    });
};

const quitter = document.querySelector(".quitter");
if (quitter) {
    quitter.addEventListener("click", function () {
        document.getElementById("formajoutruche").style.display = 'none';
    });
};

const fermer = document.getElementById("fermer");
if (fermer) {
    fermer.addEventListener("click", function () {
        document.getElementById("formajoutruche").style.display = 'none';
    });
};

// Fonction pour mettre à jour les données
function updateDashboardData() {
    const urlParams = new URLSearchParams(window.location.search);
    const rucheId = urlParams.get('id');

    if (rucheId) {
        // On récupère les dernières données de la ruche sélectionnée
        const rucheData = ruches[rucheId].data;
        const latestData = rucheData[rucheData.length - 1];

        // Mise à jour des valeurs dans les cases
        document.querySelector('.frequence-value').textContent = `${latestData.frequence} hz`;
        document.querySelector('.temp-value').textContent = `${latestData.temperature}°C`;
        document.querySelector('.humidity-value').textContent = `${latestData.humidite}%`;
        document.querySelector('.weight-value').textContent = `${latestData.poids}kg`;
    }
}

// Mettre à jour les données toutes les 5 secondes
setInterval(updateDashboardData, 5000);

// Mettre à jour les données immédiatement au chargement
document.addEventListener('DOMContentLoaded', updateDashboardData);

class Calendar {
    constructor(rucheId) {
        this.date = new Date();
        this.rucheId = rucheId;
        this.selectedDate = null;
        this.init();
    }

    getDatesWithData() {
        if (!this.rucheId || !ruches[this.rucheId]) return new Set();

        return new Set(ruches[this.rucheId].data.map(item => {
            try {
                // Vérifier si item.date est valide
                const date = new Date(item.date);
                if (isNaN(date.getTime())) {
                    console.warn('Date invalide détectée:', item.date);
                    return null;
                }
                return date.toISOString().split('T')[0];
            } catch (error) {
                console.warn('Erreur lors du traitement de la date:', error);
                return null;
            }
        }).filter(date => date !== null)); // Filtrer les dates invalides
    }

    renderCalendar() {
        const year = this.date.getFullYear();
        const month = this.date.getMonth();

        // Mettre à jour l'en-tête du mois
        const monthNames = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        document.querySelector('.current-month').textContent = `${monthNames[month]} ${year}`;

        const calendarDays = document.querySelector('.calendar-days');
        calendarDays.innerHTML = '';

        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay();

        const datesWithData = this.getDatesWithData();
        const today = new Date();

        // Jours du mois précédent
        for (let i = startingDay - 1; i >= 0; i--) {
            const dayDiv = document.createElement('div');
            dayDiv.className = 'calendar-day other-month';
            dayDiv.textContent = new Date(year, month, 0).getDate() - i;
            calendarDays.appendChild(dayDiv);
        }

        // Jours du mois actuel
        for (let day = 1; day <= daysInMonth; day++) {
            const dayDiv = document.createElement('div');
            dayDiv.className = 'calendar-day';
            dayDiv.textContent = day;

            // Format de date YYYY-MM-DD
            const dateString = new Date(year, month, day).toISOString().split('T')[0];

            // Vérifier si cette date a des données
            if (datesWithData.has(dateString)) {
                dayDiv.classList.add('has-data');
            }

            // Marquer la date sélectionnée
            if (this.selectedDate &&
                this.selectedDate.getDate() === day &&
                this.selectedDate.getMonth() === month &&
                this.selectedDate.getFullYear() === year) {
                dayDiv.classList.add('selected');
            }

            // Marquer aujourd'hui
            if (today.getDate() === day &&
                today.getMonth() === month &&
                today.getFullYear() === year) {
                dayDiv.classList.add('today');
            }

            // Ajouter l'événement de clic
            dayDiv.addEventListener('click', () => {
                const clickedDate = new Date(year, month, day);
                this.selectDate(clickedDate);
            });

            calendarDays.appendChild(dayDiv);
        }
    }

    selectDate(date) {
        this.selectedDate = date;
        this.renderCalendar();

        // Mettre à jour les données affichées
        if (this.rucheId && ruches[this.rucheId]) {
            const selectedData = ruches[this.rucheId].data.find(item => {
                const itemDate = new Date(item.date);
                return itemDate.toISOString().split('T')[0] === date.toISOString().split('T')[0];
            });

            if (selectedData) {
                document.querySelector('.frequence-value').textContent = `${selectedData.frequence} hz`;
                document.querySelector('.temp-value').textContent = `${selectedData.temperature}°C`;
                document.querySelector('.humidity-value').textContent = `${selectedData.humidite}%`;
                document.querySelector('.weight-value').textContent = `${selectedData.poids}kg`;
            }
        }
    }

    attachEventListeners() {
        document.querySelector('.prev-month').addEventListener('click', () => {
            this.date.setMonth(this.date.getMonth() - 1);
            this.renderCalendar();
        });

        document.querySelector('.next-month').addEventListener('click', () => {
            this.date.setMonth(this.date.getMonth() + 1);
            this.renderCalendar();
        });
    }

    init() {
        this.renderCalendar();
        this.attachEventListeners();
    }
}

// Initialiser le calendrier quand une ruche est sélectionnée
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const rucheId = urlParams.get('id');

    if (rucheId) {
        new Calendar(rucheId);
    }
});

// Gestion de la sélection active des ruches
document.addEventListener('DOMContentLoaded', () => {
    const rucheButtons = document.querySelectorAll('.ruches a:not(#ajoutruche):not(#ajoutruche2)');
    const urlParams = new URLSearchParams(window.location.search);
    const activeRucheId = urlParams.get('id');

    rucheButtons.forEach(button => {
        // Mettre la classe active sur le bouton de la ruche sélectionnée
        if (button.getAttribute('href') === `?id=${activeRucheId}`) {
            button.classList.add('active');
        }

        // Ajouter l'écouteur d'événements pour le clic
        button.addEventListener('click', (e) => {
            // Retirer la classe active de tous les boutons
            rucheButtons.forEach(btn => btn.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            button.classList.add('active');
        });
    });
});

