<?php
require_once dirname(dirname(dirname(__DIR__))) . '/app/core/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <base href="<?= BASE_URL ?>/">
    <?php
    // Choix du CSS selon la page
    switch ($page) {
        case 'teams':
            echo '<link rel="stylesheet" href="' . CSS_URL . '/teams.css">';
            break;
        case 'players':
            echo '<link rel="stylesheet" href="' . CSS_URL . '/players.css">';
            break;
        case 'challenges':
            echo '<link rel="stylesheet" href="' . CSS_URL . '/challenges.css">';
            break;
        case 'config':
            echo '<link rel="stylesheet" href="' . CSS_URL . '/config.css">';
            break;
        case 'homeAdmin':
        default:
            echo '<link rel="stylesheet" href="' . CSS_URL . '/dashboard.css">';
            break;
    }
    ?>
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
</head>
<body>
    <?php include dirname(__DIR__) . '/includes/admin/dashboard/navAdmin.php'; ?>
    <main>
        <?php include $view; ?>
    </main>
</body>
</html>
