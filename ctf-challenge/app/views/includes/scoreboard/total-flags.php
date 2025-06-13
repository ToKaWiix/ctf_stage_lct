<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';

$pdo = getPDO();
$controller = new \Anna\CtfChallenge\Controllers\ScoreboardController($pdo);
$totalFlags = $controller->getTotalSolvedChallenges();
?>

<div id="total-flags">
    <div id="text-total-flag">
        <h4>Total de flags trouvés :</h4>
    </div>
    <div id="int-total-flag">
        <h4><?php echo $totalFlags; ?></h4>
    </div>
</div>