<?php
namespace App\Controllers;

require_once dirname(__DIR__) . '/models/TeamModel.php';
require_once dirname(dirname(__DIR__)) . '/app/core/config.php'; // Inclure config.php

use App\Models\TeamModel;

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
                header('Location: ' . BASE_URL . '/dashboard.php?page=teams&success=1');
            } catch (\Exception $e) {
                header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=' . urlencode($e->getMessage()));
            }
            exit;
        }

        header('Location: ' . BASE_URL . '/dashboard.php?page=teams');
        exit;
    }

    public function editTeam() {
        error_log("editTeam: Début de la méthode.");
        error_log("editTeam: POST data: " . print_r($_POST, true));

        if (!isset($_POST['team_id']) || !isset($_POST['team_name'])) {
            error_log("editTeam: Données manquantes (team_id ou team_name)");
            header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=Données manquantes');
            exit;
        }

        $teamId = $_POST['team_id'];
        $teamName = trim($_POST['team_name']);
        error_log("editTeam: teamId = " . $teamId . ", teamName = " . $teamName);

        if (empty($teamName)) {
            error_log("editTeam: Le nom de l'équipe est vide");
            header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=Le nom de l\'équipe ne peut pas être vide');
            exit;
        }

        $model = new TeamModel($this->pdo);
        
        try {
            error_log("editTeam: Tentative de mise à jour de l'équipe");
            if ($model->update($teamId, $teamName)) {
                error_log("editTeam: Mise à jour réussie");
                header('Location: ' . BASE_URL . '/dashboard.php?page=teams&success=3');
            } else {
                error_log("editTeam: Échec de la mise à jour (modèle a retourné false)");
                header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=Erreur lors de la modification de l\'équipe');
            }
        } catch (\Exception $e) {
            error_log("editTeam: Exception lors de la mise à jour: " . $e->getMessage());
            header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function deleteTeam() {
        if (!isset($_GET['id'])) {
            header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=ID de l\'équipe manquant');
            exit;
        }

        $teamId = $_GET['id'];
        error_log("Tentative de suppression de l'équipe avec l'ID: " . $teamId);

        try {
            // Commencer une transaction
            $this->pdo->beginTransaction();
            
            // Supprimer d'abord tous les scores de l'équipe
            $stmtScores = $this->pdo->prepare("DELETE FROM ctf_score WHERE id_ctf_equipe = :id");
            $stmtScores->execute(['id' => $teamId]);

            // Supprimer ensuite tous les joueurs de l'équipe
            $stmtJoueurs = $this->pdo->prepare("DELETE FROM ctf_joueur WHERE id_ctf_equipe = :id");
            $stmtJoueurs->execute(['id' => $teamId]);
            
            // Enfin, supprimer l'équipe
            $teamModel = new TeamModel($this->pdo);
            if ($teamModel->delete($teamId)) {
                // Valider la transaction
                $this->pdo->commit();
                error_log("Équipe, ses joueurs et ses scores supprimés avec succès");
                header('Location: ' . BASE_URL . '/dashboard.php?page=teams&success=2');
            } else {
                // Annuler la transaction en cas d'échec de suppression de l'équipe
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }
                error_log("Échec de la suppression de l'équipe");
                header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=Erreur lors de la suppression de l\'équipe');
            }
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log("Exception lors de la suppression: " . $e->getMessage());
            header('Location: ' . BASE_URL . '/dashboard.php?page=teams&error=' . urlencode($e->getMessage()));
        }
        exit;
    }
}