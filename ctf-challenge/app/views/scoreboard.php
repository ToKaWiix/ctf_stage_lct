<?php include __DIR__ . '/includes/scoreboard/header.php'; ?>
<?php include __DIR__ . '/includes/scoreboard/navbar.php'; ?>

<main>
    <div id="main-scoreboard">
        <div id="top-scoreboard">
            <?php include __DIR__ . '/includes/scoreboard/scoreboard-table.php'; ?>
            <?php include __DIR__ . '/includes/scoreboard/partenaire.php'; ?>
        </div>
        <div id="bottom-scoreboard">
            <?php include __DIR__ . '/includes/scoreboard/player-cards.php'; ?>
            <?php include __DIR__ . '/includes/scoreboard/legend.php'; ?>
            <?php include __DIR__ . '/includes/scoreboard/total-flags.php'; ?>
            <?php include __DIR__ . '/includes/scoreboard/prison-scoreboard.php'; ?>
        </div>
    </div>
</main>
</body>
</html>