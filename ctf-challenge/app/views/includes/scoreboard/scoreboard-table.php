<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/controllers/ScoreboardController.php';

$pdo = getPDO();
$controller = new \Anna\CtfChallenge\Controllers\ScoreboardController($pdo);
$challenges = $controller->getChallengesForScoreboard();

// Fonction pour vérifier si une équipe a résolu un challenge
function hasTeamSolvedChallenge($pdo, $teamId, $challengeId) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM ctf_score 
        WHERE id_ctf_equipe = :team_id AND id_ctf_challenge = :challenge_id
    ");
    $stmt->execute([
        'team_id' => $teamId,
        'challenge_id' => $challengeId
    ]);
    return $stmt->fetchColumn() > 0;
}

// Fonction pour vérifier si un challenge affiche ses points
function isChallengePointsVisible($pdo, $challengeId) {
    $stmt = $pdo->prepare("
        SELECT ctf_show_pts 
        FROM ctf_challenge 
        WHERE id_ctf_challenge = :challenge_id
    ");
    $stmt->execute(['challenge_id' => $challengeId]);
    $result = $stmt->fetch();
    return $result && $result['ctf_show_pts'] == 1;
}
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
            <?php foreach ($challenges as $challenge): 
                $hasSolved = hasTeamSolvedChallenge($pdo, $team['id_ctf_equipe'], $challenge['id_ctf_challenge']);
                $showPoints = isChallengePointsVisible($pdo, $challenge['id_ctf_challenge']);
                
                if ($hasSolved) {
                    $circleColor = $showPoints ? '🟢' : '🟣';
                } else {
                    $circleColor = '🔴';
                }
            ?>
                <td><?php echo $circleColor; ?></td>
            <?php endforeach; ?>
            <td>0</td>
            <td><?php echo htmlspecialchars($team['ctf_score_total']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>