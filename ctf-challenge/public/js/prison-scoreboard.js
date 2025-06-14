function updatePrisonTimers() {
    const prisonPlayers = document.querySelectorAll('.prison-player');
    
    prisonPlayers.forEach(player => {
        const timerElement = player.querySelector('.prison-timer');
        const playerId = player.dataset.playerId;
        const prisonTime = parseInt(player.dataset.prisonTime) || 0;
        const startTime = new Date(player.dataset.startTime);
        const now = new Date();
        
        // Logs pour le débogage
        console.log('Player ID:', playerId);
        console.log('Prison Time:', prisonTime);
        console.log('Start Time:', startTime);
        console.log('Now:', now);
        
        // Calculer le temps passé en secondes
        const timeSpent = Math.floor((now - startTime) / 1000);
        console.log('Time Spent:', timeSpent);
        
        // Calculer le temps restant
        const remainingTime = Math.max(0, prisonTime - timeSpent);
        console.log('Remaining Time:', remainingTime);
        
        // Si le temps est écoulé, libérer le joueur
        if (remainingTime <= 0) {
            console.log('Temps écoulé pour le joueur:', playerId);
            // Appeler l'API pour libérer le joueur
            fetch(`${window.API_URL}/release-prisoner.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ player_id: playerId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Joueur libéré avec succès:', playerId);
                    // Supprimer la carte du joueur
                    player.remove();
                    
                    // Si c'était le dernier joueur, rafraîchir la page
                    const remainingPlayers = document.querySelectorAll('.prison-player');
                    if (remainingPlayers.length === 0) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }
            })
            .catch(error => {
                console.error('Erreur lors de la libération du joueur:', error);
            });
            
            return;
        }
        
        // Mettre à jour l'affichage du timer
        const minutes = Math.floor(remainingTime / 60);
        const seconds = remainingTime % 60;
        const timerText = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        console.log('Timer Text:', timerText);
        timerElement.textContent = timerText;
    });
}

// Fonction pour actualiser la carte prison
function refreshPrisonCard() {
    console.log('Rafraîchissement de la carte prison');
    fetch(`${window.API_URL}/get-prison-players.php`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newPrisonPlayers = doc.querySelector('#prison-players');
            const currentPrisonPlayers = document.querySelector('#prison-players');
            
            if (newPrisonPlayers && currentPrisonPlayers) {
                // Ne mettre à jour que si la liste des joueurs a changé
                const currentIds = Array.from(currentPrisonPlayers.querySelectorAll('.prison-player')).map(p => p.dataset.playerId);
                const newIds = Array.from(newPrisonPlayers.querySelectorAll('.prison-player')).map(p => p.dataset.playerId);
                
                console.log('Current IDs:', currentIds);
                console.log('New IDs:', newIds);
                
                if (JSON.stringify(currentIds) !== JSON.stringify(newIds)) {
                    console.log('Mise à jour de la carte prison');
                    currentPrisonPlayers.innerHTML = newPrisonPlayers.innerHTML;
                } else {
                    console.log('Pas de changement dans la liste des joueurs');
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'actualisation de la carte prison:', error);
        });
}

// Mettre à jour les timers toutes les secondes
setInterval(updatePrisonTimers, 1000);

// Actualiser la carte prison toutes les 5 secondes
setInterval(refreshPrisonCard, 5000);

// Mettre à jour immédiatement au chargement
console.log('Initialisation des timers');
updatePrisonTimers(); 