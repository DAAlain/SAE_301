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

const quitter = document.querySelector(".quitter_form");
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

document.addEventListener('DOMContentLoaded', function () {
    const profileImage = document.querySelector('.profile-image-container');
    const photoInput = document.querySelector('#photo-input');
    const photoForm = document.querySelector('#photo-form');

    if (profileImage && photoInput) {
        profileImage.addEventListener('click', function () {
            photoInput.click();
        });

        photoInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                // Soumettre le formulaire automatiquement quand une image est sélectionnée
                photoForm.submit();
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const ajoutruche = document.getElementById("ajoutruche");
    const ajoutruche2 = document.getElementById("ajoutruche2");
    const quitter = document.querySelector(".quitter");
    const fermer = document.getElementById("fermer");
    const formajoutruche = document.getElementById("formajoutruche");

    function openForm() {
        formajoutruche.classList.remove('closing');
        formajoutruche.classList.add('active');
    }

    function closeForm() {
        formajoutruche.classList.add('closing');
        formajoutruche.addEventListener('animationend', function handler() {
            formajoutruche.classList.remove('active', 'closing');
            formajoutruche.style.display = 'none';
            formajoutruche.removeEventListener('animationend', handler);
        });
    }

    if (ajoutruche) {
        ajoutruche.addEventListener("click", function (e) {
            e.preventDefault();
            formajoutruche.style.display = 'block';
            requestAnimationFrame(() => openForm());
        });
    }

    if (ajoutruche2) {
        ajoutruche2.addEventListener("click", function (e) {
            e.preventDefault();
            formajoutruche.style.display = 'block';
            requestAnimationFrame(() => openForm());
        });
    }

    if (quitter) {
        quitter.addEventListener("click", closeForm);
    }

    if (fermer) {
        fermer.addEventListener("click", closeForm);
    }
});

// Initialisation de la carte
document.addEventListener('DOMContentLoaded', function () {
    // Vérifier si l'élément map existe
    const mapElement = document.getElementById('map');
    if (!mapElement) return;

    // Initialiser la carte
    const map = L.map('map').setView([47.769622034321365, 7.270559009574735], 13);

    // Ajouter la couche OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Icône personnalisée pour les ruches
    const rucheIcon = L.icon({
        iconUrl: 'assets/img/ruche-marker.png', // Créez cette icône ou utilisez une existante
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    // Parcourir toutes les ruches et ajouter les marqueurs
    Object.entries(ruches).forEach(([id, ruche]) => {
        if (ruche.gps && ruche.gps.length === 2) {
            const marker = L.marker(ruche.gps, { icon: rucheIcon }).addTo(map);

            // Ajouter un popup avec les informations de la ruche
            const lastData = ruche.data[ruche.data.length - 1];
            const popupContent = `
                <strong>Ruche N°${id}</strong><br>
                Température: ${lastData.temperature}°C<br>
                Humidité: ${lastData.humidite}%<br>
                Poids: ${lastData.poids}kg<br>
                Fréquence: ${lastData.frequence}hz
            `;
            marker.bindPopup(popupContent);
        }
    });

    // Ajuster la vue pour montrer toutes les ruches
    const markers = Object.values(ruches)
        .filter(ruche => ruche.gps && ruche.gps.length === 2)
        .map(ruche => ruche.gps);

    if (markers.length > 0) {
        map.fitBounds(markers);
    }
});

// Initialisation de Quill.js et gestion des notes
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const rucheId = urlParams.get('id');
    
    if (!rucheId) return;

    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Écrivez vos notes ici...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['clean']
            ]
        }
    });

    const notesList = document.querySelector('.notes-list');
    const editor = document.getElementById('editor');
    let currentNoteId = null;

    // Charger la liste des notes
    function loadNotesList() {
        fetch(`save_note.php?action=list&ruche_id=${rucheId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data || !data.success) {
                    throw new Error(data?.error || 'Erreur lors du chargement des notes');
                }
                
                notesList.innerHTML = '';
                
                if (!data.notes || data.notes.length === 0) {
                    notesList.innerHTML = '<div class="note-item empty">Aucune note</div>';
                    return;
                }

                data.notes.forEach(note => {
                    const noteItem = document.createElement('div');
                    noteItem.className = 'note-item';
                    noteItem.dataset.noteId = note.id;
                    noteItem.onclick = () => loadNote(note.id);
                    
                    // Ligne principale contenant le titre et le bouton de suppression
                    const mainLine = document.createElement('div');
                    mainLine.className = 'note-main-line';
                    
                    // Contenu de la note (titre)
                    const noteContent = document.createElement('div');
                    noteContent.className = 'note-content';
                    noteContent.textContent = note.title || `Note du ${new Date(note.created_at).toLocaleDateString()}`;
                    
                    // Bouton de suppression
                    const deleteButton = document.createElement('button');
                    deleteButton.className = 'delete-note-btn';
                    deleteButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
                    
                    // Conteneur de confirmation
                    const confirmDelete = document.createElement('div');
                    confirmDelete.className = 'confirm-delete';
                    confirmDelete.innerHTML = `
                        <span>Confirmer la suppression ?</span>
                        <button class="confirm-yes">Oui</button>
                        <button class="confirm-no">Non</button>
                    `;
                    
                    // Assemblage des éléments
                    mainLine.appendChild(noteContent);
                    mainLine.appendChild(deleteButton);
                    noteItem.appendChild(mainLine);
                    noteItem.appendChild(confirmDelete);
                    
                    // Gestion des événements
                    deleteButton.onclick = (e) => {
                        e.stopPropagation();
                        confirmDelete.style.display = 'flex';
                        deleteButton.style.display = 'none';
                    };
                    
                    confirmDelete.onclick = (e) => {
                        e.stopPropagation();
                    };
                    
                    confirmDelete.querySelector('.confirm-yes').onclick = (e) => {
                        e.stopPropagation();
                        deleteNote(note.id);
                    };
                    
                    confirmDelete.querySelector('.confirm-no').onclick = (e) => {
                        e.stopPropagation();
                        confirmDelete.style.display = 'none';
                        deleteButton.style.display = 'flex';
                    };
                    
                    notesList.appendChild(noteItem);
                });
            })
            .catch(error => {
                console.error('Erreur:', error);
                notesList.innerHTML = '<div class="note-item error">Erreur de chargement</div>';
            });
    }

    // Charger une note spécifique
    function loadNote(noteId) {
        currentNoteId = noteId;
        fetch(`save_note.php?action=get&note_id=${noteId}`)
            .then(response => response.json())
            .then(data => {
                if (data.content) {
                    quill.root.innerHTML = data.content;
                    editor.style.display = 'block';
                    // Afficher le bouton enregistrer et cacher le bouton ajouter
                    document.getElementById('add-new-note').style.display = 'none';
                    document.getElementById('save-note').style.display = 'block';
                }
                // Mettre à jour la sélection visuelle
                document.querySelectorAll('.note-item').forEach(item => {
                    item.classList.toggle('active', item.dataset.noteId === noteId);
                });
            })
            .catch(error => console.error('Erreur:', error));
    }

    // Gérer le bouton "Nouvelle note"
    document.getElementById('add-note').addEventListener('click', function() {
        currentNoteId = null;
        quill.root.innerHTML = '';
        editor.style.display = 'block';
        // Désélectionner la note active
        document.querySelectorAll('.note-item').forEach(item => {
            item.classList.remove('active');
        });
        // Afficher le bouton ajouter et cacher le bouton enregistrer
        document.getElementById('add-new-note').style.display = 'block';
        document.getElementById('save-note').style.display = 'none';
    });

    // Gérer l'ajout d'une nouvelle note
    document.getElementById('add-new-note').addEventListener('click', function() {
        const content = quill.root.innerHTML;
        const urlParams = new URLSearchParams(window.location.search);
        const rucheId = urlParams.get('id');
        
        fetch('save_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                content: content,
                ruche_id: rucheId,
                action: 'add'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotesList();
                editor.style.display = 'none';
                document.getElementById('add-new-note').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    });

    // Gérer la modification d'une note existante
    document.getElementById('save-note').addEventListener('click', function() {
        if (!currentNoteId) return;

        const content = quill.root.innerHTML;
        const urlParams = new URLSearchParams(window.location.search);
        const rucheId = urlParams.get('id');

        fetch('save_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                content: content,
                ruche_id: rucheId,
                note_id: currentNoteId,
                action: 'update'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotesList();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    });

    // Fonction pour supprimer une note
    function deleteNote(noteId) {
        fetch('save_note.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                note_id: noteId,
                action: 'delete'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotesList();
                editor.style.display = 'none';
                document.getElementById('add-new-note').style.display = 'none';
                document.getElementById('save-note').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    }

    // Charger la liste des notes au démarrage
    loadNotesList();
});
