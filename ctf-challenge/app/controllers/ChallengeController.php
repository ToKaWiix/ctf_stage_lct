<?php
namespace App\Controllers;

require_once dirname(__DIR__) . '/models/ChallengeModel.php';

use App\Models\ChallengeModel;

class ChallengeController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        error_log("ChallengeController::__construct - Session démarrée");
    }

    public function index() {
        try {
            error_log("ChallengeController::index - Début");
            $challengeModel = new ChallengeModel($this->pdo);
            $challenges = $challengeModel->getAll();
            error_log("ChallengeController::index - Challenges récupérés : " . print_r($challenges, true));
            
            // Stocker les données dans la session
            $_SESSION['challenges_data'] = [
                'challenges' => $challenges
            ];
            error_log("ChallengeController::index - Données stockées en session : " . print_r($_SESSION['challenges_data'], true));
            
        } catch (\Exception $e) {
            error_log("Erreur dans ChallengeController::index : " . $e->getMessage());
            error_log("Trace : " . $e->getTraceAsString());
            header('Location: ' . BASE_URL . '/dashboard.php?page=challenges&error=' . urlencode("Une erreur est survenue lors du chargement des challenges"));
            exit;
        }
    }

    public function addChallenge() {
        if (!isset($_POST['challenge_name']) || !isset($_POST['points']) || !isset($_POST['flag'])) {
            header('Location: ' . BASE_URL . '/dashboard.php?page=challenges&error=Données manquantes');
            exit;
        }

        try {
            $challengeModel = new ChallengeModel($this->pdo);
            $challengeModel->add($_POST);
            header('Location: ' . BASE_URL . '/dashboard.php?page=challenges&success=1');
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . '/dashboard.php?page=challenges&error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function deleteChallenge() {
        if (!isset($_GET['id'])) {
            header('Location: ' . BASE_URL . '/dashboard.php?page=challenges&error=ID du challenge manquant');
            exit;
        }

        try {
            $challengeModel = new ChallengeModel($this->pdo);
            $challengeModel->delete($_GET['id']);
            header('Location: ' . BASE_URL . '/dashboard.php?page=challenges&success=2');
        } catch (\Exception $e) {
            header('Location: ' . BASE_URL . '/dashboard.php?page=challenges&error=' . urlencode($e->getMessage()));
        }
        exit;
    }
} 