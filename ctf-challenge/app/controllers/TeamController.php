<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\TeamModel;

class TeamController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        $model = new TeamModel($this->pdo);
        $teams = $model->getAll();
        require dirname(__DIR__) . '/views/includes/admin/dashboard/teams.php';
    }

    public function addTeam() {
        $model = new TeamModel($this->pdo);

        if (!empty($_POST['username'])) {
            try {
                $nomEquipe = trim($_POST['username']);
                $model->add($nomEquipe);
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&success=1');
            } catch (\Exception $e) {
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=' . urlencode($e->getMessage()));
            }
            exit;
        }

        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams');
        exit;
    }

    public function editTeam() {
        if (!isset($_POST['team_id']) || !isset($_POST['team_name'])) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=Données manquantes');
            exit;
        }

        $teamId = $_POST['team_id'];
        $teamName = trim($_POST['team_name']);

        if (empty($teamName)) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=Le nom de l\'équipe ne peut pas être vide');
            exit;
        }

        $model = new TeamModel($this->pdo);
        
        try {
            if ($model->update($teamId, $teamName)) {
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&success=3');
            } else {
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=Erreur lors de la modification de l\'équipe');
            }
        } catch (\Exception $e) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function deleteTeam() {
        if (!isset($_GET['id'])) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=ID de l\'équipe manquant');
            exit;
        }

        $teamId = $_GET['id'];
        error_log("Tentative de suppression de l'équipe avec l'ID: " . $teamId);

        $teamModel = new TeamModel($this->pdo);
        
        try {
            if ($teamModel->delete($teamId)) {
                error_log("Équipe supprimée avec succès");
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&success=2');
            } else {
                error_log("Échec de la suppression de l'équipe");
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=Erreur lors de la suppression de l\'équipe');
            }
        } catch (\Exception $e) {
            error_log("Exception lors de la suppression: " . $e->getMessage());
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=teams&error=' . urlencode($e->getMessage()));
        }
        exit;
    }
}