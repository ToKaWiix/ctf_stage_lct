<?php
require_once dirname(__DIR__, 2) . '/app/core/database.php';
require_once dirname(__DIR__, 2) . '/app/models/ConfigModel.php';

use App\Models\ConfigModel;

header('Content-Type: application/json');

try {
    $pdo = getPDO();
    $configModel = new ConfigModel($pdo);
    $ctfTime = $configModel->getCtfTime();

    if ($ctfTime) {
        echo json_encode([
            'start_time' => $ctfTime['ctf_start_time'],
            'end_time' => $ctfTime['ctf_end_time']
        ]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Temps du CTF non trouvé']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur']);
} 