<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?= BASE_URL ?>/">
    <link rel="stylesheet" href="<?= CSS_URL ?>/submitting.css">
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <title>Soumettre un flag</title>
</head>
<body>