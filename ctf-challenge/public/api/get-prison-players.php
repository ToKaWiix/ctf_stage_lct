<?php
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/app/core/config.php';
require_once dirname(__DIR__, 2) . '/app/core/database.php';

use App\Controllers\ScoreboardController;

error_log("=== Début de get-prison-players.php ===");

// Définir IMAGES_URL si non défini
if (!defined('IMAGES_URL')) {
    define('IMAGES_URL', '/ctf_anna/ctf-challenge/public/images');
}

$pdo = getPDO();
$controller = new ScoreboardController($pdo);
$prisonPlayers = $controller->getPrisonPlayers();

error_log("Nombre de joueurs en prison: " . count($prisonPlayers));
foreach ($prisonPlayers as $player) {
    error_log("Player ID: " . $player['id_ctf_joueur']);
    error_log("Prison Time: " . $player['prison_time']);
    error_log("Start Time: " . $player['ctf_prison_start_time']);
}

// Retourner uniquement la partie HTML des joueurs en prison
?>
<div id="prison-players">
    <?php foreach ($prisonPlayers as $player): ?>
        <div class="prison-player" 
             data-player-id="<?php echo $player['id_ctf_joueur']; ?>"
             data-prison-time="<?php echo $player['prison_time']; ?>"
             data-start-time="<?php echo $player['ctf_prison_start_time']; ?>">
            <div class="prison-player-photo">
                <img src="<?php echo IMAGES_URL . '/' . ($player['ctf_photo'] ?? 'default.jpg'); ?>" alt="Photo de <?php echo htmlspecialchars($player['ctf_pseudo']); ?>">
            </div>
            <div class="prison-player-info">
                <div class="prison-player-name"><?php echo htmlspecialchars($player['ctf_pseudo']); ?></div>
                <div class="prison-player-team"><?php echo htmlspecialchars($player['ctf_nom_equipe']); ?></div>
                <div class="prison-timer">00:00</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
error_log("=== Fin de get-prison-players.php ===");
?> 