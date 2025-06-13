<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';

$pdo = getPDO();
$controller = new \App\Controllers\ScoreboardController($pdo);
$prisonPlayers = $controller->getPrisonPlayers();

// Débogage
foreach ($prisonPlayers as $player) {
    error_log("Player ID: " . $player['id_ctf_joueur']);
    error_log("Prison Time Seconds: " . $player['prison_time_seconds']);
    error_log("Time Spent: " . $player['time_spent']);
}
?>

<div id="prison-scoreboard">
    <div id="card-text-prison">
        <h4>prison</h4>
    </div>
    <div id="prison-players">
        <?php foreach ($prisonPlayers as $player): ?>
            <div class="prison-player" 
                 data-player-id="<?php echo htmlspecialchars($player['id_ctf_joueur']); ?>" 
                 data-prison-time="<?php echo htmlspecialchars($player['prison_time_seconds']); ?>"
                 data-start-time="<?php echo htmlspecialchars($player['ctf_prison_start_time']); ?>">
                <div class="prison-player-photo">
                    <img src="/ctf_anna/ctf-challenge/public/images/<?php echo htmlspecialchars($player['ctf_photo'] ?? 'default.jpg'); ?>" alt="Photo de <?php echo htmlspecialchars($player['ctf_pseudo']); ?>">
                </div>
                <div class="prison-player-info">
                    <div class="prison-timer">
                        <?php 
                        $remainingTime = intval($player['prison_time_seconds']) - intval($player['time_spent']);
                        if ($remainingTime > 0) {
                            $minutes = floor($remainingTime / 60);
                            $seconds = $remainingTime % 60;
                            echo sprintf("%02d:%02d", $minutes, $seconds);
                        } else {
                            echo "00:00";
                        }
                        ?>
                    </div>
                    <span class="prison-player-name"><?php echo htmlspecialchars($player['ctf_pseudo']); ?></span>
                    <span class="prison-player-team"><?php echo htmlspecialchars($player['ctf_nom_equipe']); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
function updatePrisonTimers() {
    const prisonPlayers = document.querySelectorAll('.prison-player');
    
    prisonPlayers.forEach(player => {
        const timerElement = player.querySelector('.prison-timer');
        const playerId = player.dataset.playerId;
        const prisonTime = parseInt(player.dataset.prisonTime) || 0;
        const timeSpent = parseInt(player.dataset.timeSpent) || 0;
        
        // Calculer le temps restant
        const remainingTime = Math.max(0, prisonTime - timeSpent);
        
        // Si le temps est écoulé, libérer le joueur
        if (remainingTime <= 0) {
            // Appeler l'API pour libérer le joueur
            fetch('/ctf_anna/ctf-challenge/public/api/release-prisoner.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ player_id: playerId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
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
        timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        
        // Mettre à jour le temps passé
        player.dataset.timeSpent = timeSpent + 1;
    });
}

// Fonction pour actualiser la carte prison
function refreshPrisonCard() {
    fetch('/ctf_anna/ctf-challenge/public/api/get-prison-players.php')
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newPrisonPlayers = doc.querySelector('#prison-players');
            const currentPrisonPlayers = document.querySelector('#prison-players');
            
            // Mettre à jour le contenu si nécessaire
            if (newPrisonPlayers.innerHTML !== currentPrisonPlayers.innerHTML) {
                currentPrisonPlayers.innerHTML = newPrisonPlayers.innerHTML;
                
                // Réinitialiser les timers pour les nouveaux joueurs
                document.querySelectorAll('.prison-player').forEach(player => {
                    const startTime = player.dataset.startTime;
                    player.dataset.timeSpent = Math.floor((new Date() - new Date(startTime)) / 1000);
                });
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'actualisation de la carte prison:', error);
        });
}

// Initialize timers for all prisoners
document.querySelectorAll('.prison-player').forEach(player => {
    const startTime = player.dataset.startTime;
    player.dataset.timeSpent = Math.floor((new Date() - new Date(startTime)) / 1000);
});

// Mettre à jour les timers toutes les secondes
setInterval(updatePrisonTimers, 1000);

// Actualiser la carte prison toutes les 5 secondes
setInterval(refreshPrisonCard, 1000);

// Mettre à jour immédiatement au chargement
updatePrisonTimers();
</script>