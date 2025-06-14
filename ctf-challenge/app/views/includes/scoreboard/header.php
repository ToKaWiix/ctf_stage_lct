<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bg-image: url('<?= IMAGES_URL ?>/prison.jpg');
            --bg-image-player-one: url('<?= IMAGES_URL ?>/bg7.jpg');
            --bg-image-player-two: url('<?= IMAGES_URL ?>/bg8.jpg');
        }
    </style>
    <link rel="stylesheet" href="<?= CSS_URL ?>/scoreboard.css">
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <script src="<?= JS_URL ?>/scoreboard.js"></script>
    <title>Tableau des scores</title>
</head>
<body>