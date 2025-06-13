<?php
require_once dirname(dirname(__DIR__)) . '/vendor/autoload.php';
require_once dirname(dirname(__DIR__)) . '/app/core/database.php';

use App\Controllers\ScoreboardController;

header('Content-Type: application/json');

// Vérifier si la requête est en POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Récupérer les données JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['player_id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID du joueur manquant']);
    exit;
}

try {
    $pdo = getPDO();
    $controller = new ScoreboardController($pdo);
    
    // Libérer le joueur
    $success = $controller->releasePrisoner($data['player_id']);
    
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Joueur libéré avec succès']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la libération du joueur']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
} 