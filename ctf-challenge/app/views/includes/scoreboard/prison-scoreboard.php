<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/config.php';
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';

$pdo = getPDO();
$controller = new \App\Controllers\ScoreboardController($pdo);
$prisonPlayers = $controller->getPrisonPlayers();

// Débogage
foreach ($prisonPlayers as $player) {
    error_log("Player ID: " . $player['id_ctf_joueur']);
    error_log("Prison Time: " . $player['prison_time']);
    error_log("Start Time: " . $player['ctf_prison_start_time']);
}
?>

<div id="prison-scoreboard">
    <div id="card-text-prison">
        <h4>Prison</h4>
    </div>
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
</div>