<?php
require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/app/core/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= CSS_URL ?>/loginAdmin.css">
    <script>
        const BASE_URL = '<?= BASE_URL ?>';
    </script>
    <title>Connexion Administrateur</title>
</head>
<body>