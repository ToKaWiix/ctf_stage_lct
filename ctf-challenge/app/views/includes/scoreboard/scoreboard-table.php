<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';

$pdo = getPDO();
$controller = new \App\Controllers\ScoreboardController($pdo);
$challenges = $controller->getChallengesForScoreboard();
?>

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
            <?php foreach ($challenges as $challenge): 
                $hasSolved = $controller->hasTeamSolvedChallenge($team['id_ctf_equipe'], $challenge['id_ctf_challenge']);
                $showPoints = $controller->isChallengePointsVisible($challenge['id_ctf_challenge']);
                
                if ($hasSolved) {
                    $circleColor = $showPoints ? '🟢' : '🟣';
                } else {
                    $circleColor = '🔴';
                }
            ?>
                <td><?php echo $circleColor; ?></td>
            <?php endforeach; ?>
            <td><?php echo $controller->countSolvedChallenges($team['id_ctf_equipe']); ?></td>
            <td><?php echo htmlspecialchars($team['ctf_score_total']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    window.challenges = <?php echo json_encode($challenges); ?>;
</script>