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
function updateTimer(playerId, prisonTime, startTime) {
    const timerElement = document.querySelector(`[data-player-id="${playerId}"] .prison-timer`);
    if (!timerElement) return;

    const now = new Date();
    const start = new Date(startTime);
    const timeSpent = Math.floor((now - start) / 1000); // Convertir en secondes
    const remainingTime = Math.max(0, prisonTime - timeSpent);
    
    if (remainingTime <= 0) {
        timerElement.textContent = '00:00';
        releasePlayer(playerId);
        return;
    }

    const minutes = Math.floor(remainingTime / 60);
    const seconds = remainingTime % 60;
    timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    setTimeout(() => {
        updateTimer(playerId, prisonTime, startTime);
    }, 1000);
}

function releasePlayer(playerId) {
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
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error releasing player:', error);
    });
}

// Initialize timers for all prisoners
document.querySelectorAll('.prison-player').forEach(player => {
    const playerId = player.dataset.playerId;
    const prisonTime = parseInt(player.dataset.prisonTime);
    const startTime = player.dataset.startTime;
    
    updateTimer(playerId, prisonTime, startTime);
});
</script>