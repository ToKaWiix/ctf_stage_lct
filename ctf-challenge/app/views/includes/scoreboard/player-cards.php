<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/controllers/ScoreboardController.php';

$pdo = getPDO();
$controller = new \App\Controllers\ScoreboardController($pdo);
$players = $controller->getPlayersForScoreboard();

// N'afficher les cartes que si nous avons des joueurs avec des équipes
if (!empty($players)): 
?>

<?php if (isset($players[0])): ?>
<div id="player-card-one" style="background-image: url('/ctf_anna/ctf-challenge/public/images/<?= htmlspecialchars($players[0]['ctf_background_equipe']) ?>'); background-size: cover; background-position: center;">
    <div id="player-card-one-name"><?= htmlspecialchars(($players[0]['ctf_prenom'] ?? '') . ' ' . ($players[0]['ctf_nom'] ?? '')) ?></div>
    <div id="card-team-img">
        <div id="player-card-one-img">
            <img id="player-pic" src="/ctf_anna/ctf-challenge/public/images/<?= htmlspecialchars($players[0]['ctf_photo'] ?? 'default.jpg') ?>" alt="Photo du joueur">
            <img id="lct-pic" src="/ctf_anna/ctf-challenge/public/images/LCT-03.png" alt="Logo LCT">
        </div> 
        <div id="player-card-one-team"><?= htmlspecialchars($players[0]['ctf_nom_equipe'] ?? '') ?></div>
    </div>
    <div id="player-card-one-pseudo"><?= htmlspecialchars($players[0]['ctf_pseudo'] ?? '') ?></div>
</div>
<?php endif; ?>

<?php if (isset($players[1])): ?>
<div id="player-card-two" style="background-image: url('/ctf_anna/ctf-challenge/public/images/<?= htmlspecialchars($players[1]['ctf_background_equipe']) ?>'); background-size: cover; background-position: center;">
    <div id="player-card-two-name"><?= htmlspecialchars(($players[1]['ctf_prenom'] ?? '') . ' ' . ($players[1]['ctf_nom'] ?? '')) ?></div>
    <div id="card-team-img">
        <div id="player-card-two-img">
            <img id="player-pic" src="/ctf_anna/ctf-challenge/public/images/<?= htmlspecialchars($players[1]['ctf_photo'] ?? 'default.jpg') ?>" alt="Photo du joueur">
            <img id="lct-pic" src="/ctf_anna/ctf-challenge/public/images/LCT-03.png" alt="Logo LCT">
        </div> 
        <div id="player-card-two-team"><?= htmlspecialchars($players[1]['ctf_nom_equipe'] ?? '') ?></div>
    </div>
    <div id="player-card-two-pseudo"><?= htmlspecialchars($players[1]['ctf_pseudo'] ?? '') ?></div>
</div>
<?php endif; ?>

<?php endif; ?>