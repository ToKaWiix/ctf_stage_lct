<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/controllers/ScoreboardController.php';

$pdo = getPDO();
$controller = new \Anna\CtfChallenge\Controllers\ScoreboardController($pdo);
$challenges = $controller->getChallengesForScoreboard();
?>

<script>
    window.challenges = <?php echo json_encode($challenges); ?>;
</script>

<table>
    <thead>
        <tr>
            <th>Équipe</th>
            <?php foreach ($challenges as $challenge): ?>
                <th><?php echo htmlspecialchars($challenge['ctf_nom_challenge']); ?></th>
            <?php endforeach; ?>
            <th>Challenges réussis</th>
            <th>Score total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($GLOBALS['teams'] as $team): ?>
        <tr>
            <td><?php echo htmlspecialchars($team['ctf_nom_equipe']); ?></td>
            <?php for ($i = 0; $i < 5; $i++): ?>
                <td>🔴</td>
            <?php endfor; ?>
            <td>0</td>
            <td><?php echo htmlspecialchars($team['ctf_score_total']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>