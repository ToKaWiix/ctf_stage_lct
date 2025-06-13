<?php
require_once dirname(dirname(dirname(__DIR__))) . '/vendor/autoload.php';
require_once dirname(dirname(dirname(__DIR__))) . '/app/core/database.php';

use App\Controllers\ScoreboardController;

header('Content-Type: application/json');

// Vérifier si c'est une requête POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['playerId'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID du joueur manquant']);
    exit;
}

$pdo = getPDO();
$controller = new ScoreboardController($pdo);

try {
    $success = $controller->releasePrisoner($data['playerId']);
    echo json_encode(['success' => $success]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} 