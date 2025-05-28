<?php include __DIR__ . '/includes/admin/dashboard/headerDashboard.php'; ?>
<?php include __DIR__ . '/includes/admin/dashboard/navAdmin.php'; ?>

<main>
<?php
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'teams':
        include __DIR__ . '/includes/admin/dashboard/teams.php';
        break;
    case 'players':
        include __DIR__ . '/includes/admin/dashboard/players.php';
        break;
    case 'challenges':
        include __DIR__ . '/includes/admin/dashboard/challenges.php';
        break;
    case 'config':
        include __DIR__ . '/includes/admin/dashboard/config.php';
        break;
    default:
        include __DIR__ . '/includes/admin/dashboard/homeAdmin.php';
        break;
}
?>
</main>

</body>
</html>
