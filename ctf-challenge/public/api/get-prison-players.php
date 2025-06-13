<?php
require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
require_once dirname(dirname(__DIR__)) . '/app/core/database.php';

use App\Controllers\ScoreboardController;

error_log("=== Début de get-prison-players.php ===");

$pdo = getPDO();
$controller = new ScoreboardController($pdo);
$prisonPlayers = $controller->getPrisonPlayers();

error_log("Nombre de joueurs en prison: " . count($prisonPlayers));
foreach ($prisonPlayers as $player) {
    error_log("Joueur en prison - ID: " . $player['id_ctf_joueur'] . 
              ", Pseudo: " . $player['ctf_pseudo'] . 
              ", Temps restant: " . ($player['prison_time_seconds'] - $player['time_spent']));
}

// Retourner uniquement la partie HTML des joueurs en prison
?>
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
<?php
error_log("=== Fin de get-prison-players.php ===");
?> 