<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <?php
    // Choix du CSS selon la page
    switch ($page) {
        case 'teams':
            echo '<link rel="stylesheet" href="/ctf_anna/ctf-challenge/public/css/teams.css">';
            break;
        case 'players':
            echo '<link rel="stylesheet" href="/ctf_anna/ctf-challenge/public/css/players.css">';
            break;
        case 'challenges':
            echo '<link rel="stylesheet" href="/ctf_anna/ctf-challenge/public/css/challenges.css">';
            break;
        case 'config':
            echo '<link rel="stylesheet" href="/ctf_anna/ctf-challenge/public/css/config.css">';
            break;
        case 'homeAdmin':
        default:
            echo '<link rel="stylesheet" href="/ctf_anna/ctf-challenge/public/css/homeAdmin.css">';
            break;
    }
    ?>
</head>
<body>
    <?php include dirname(__DIR__) . '/includes/admin/dashboard/navAdmin.php'; ?>
    <main>
        <?php include $view; ?>
    </main>
</body>
</html>
