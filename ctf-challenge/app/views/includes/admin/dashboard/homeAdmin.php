<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/core/config.php';
require_once APP_PATH . '/core/database.php';

$pdo = getPDO();
$controller = new \App\Controllers\ScoreboardController($pdo);
$totalFlags = $controller->getTotalSolvedChallenges();
?>

<div id="admin-dashboard">
    <div id="home-title">
        <h2>Panneau d'administration</h2>
    </div>
    <div id="card-scoreboard-admin">
        <div id="card-scoreboard-admin-content">
            <h3>Tableau des scores par équipe</h3>
            <div id="scoreboard-admin">
                <table>
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Équipe</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        foreach ($teams as $team): 
                        ?>
                            <tr>
                                <td><?= $rank++ ?></td>
                                <td><?= htmlspecialchars($team['ctf_nom_equipe']) ?></td>
                                <td><?= $team['ctf_score_total'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="card-statistics">
        <div id="statistics-title">
            <h3>Statistiques</h3>
        </div>
        <div id="statistics-teams">
            <h5>Nombre d'équipes inscrites :</h5>
            <h3><?= $teamCount ?></h3>
        </div>
        <div id="statistics-flags">
            <h5>Total de flags trouvés :</h5>
            <h3><?= $totalFlags ?></h3>
        </div>
    </div>
    <div id="card-logout">
        <div id="logout-btn">
            <h5>Déconnexion</h5>
            <form action="<?= BASE_URL ?>/logoutAdmin.php" method="post">
                <button type="submit">Déconnexion</button>
            </form>
        </div>
    </div>
</div>