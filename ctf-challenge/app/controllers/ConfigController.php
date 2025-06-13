<?php
namespace App\Controllers;

require_once dirname(__DIR__) . '/models/ConfigModel.php';

use App\Models\ConfigModel;

class ConfigController {
    private $pdo;
    private $configModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->configModel = new ConfigModel($pdo);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function route() {
        // Vérifier si l'utilisateur est connecté
        requireLogin();

        if (isset($_GET['action'])) {
            if ($_GET['action'] === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->deleteAdmin();
                return;
            }
            if ($_GET['action'] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->addAdmin();
                return;
            }
            if ($_GET['action'] === 'update_ctf_time' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->updateCtfTime();
                return;
            }
            if ($_GET['action'] === 'update_prison_time' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->updatePrisonTime();
                return;
            }
            if ($_GET['action'] === 'update_partner_text' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->updatePartnerText();
                return;
            }
        }
        
        $admins = $this->configModel->getAllAdmins();
        $ctfTime = $this->configModel->getCtfTime();
        $prisonTime = $this->configModel->getPrisonTime();
        $partnerText = $this->configModel->getPartnerText();
        $view = dirname(__DIR__) . '/views/includes/admin/dashboard/config.php';
        $page = 'config';
        include dirname(__DIR__) . '/views/layouts/admin.php';
    }

    public function addAdmin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&error=Champs manquants');
            exit;
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Ajout dans la BDD
        $this->configModel->addAdmin($username, $hashedPassword);

        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&success=1');
        exit;
    }

    public function deleteAdmin() {
        $adminId = $_POST['admin_id'] ?? null;
        if (!$adminId) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&error=ID manquant');
            exit;
        }

        $this->configModel->deleteAdmin($adminId);
        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&success=2');
        exit;
    }

    public function updateCtfTime() {
        $start = $_POST['start-time'] ?? null;
        $end = $_POST['end-time'] ?? null;

        if (!$start || !$end) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&error=Champs manquants');
            exit;
        }

        $this->configModel->updateCtfTime($start, $end);
        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&success=3');
        exit;
    }

    public function updatePrisonTime() {
        $prisonTime = $_POST['prison-time'] ?? null;

        if (!$prisonTime) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&error=Champ manquant');
            exit;
        }

        $this->configModel->updatePrisonTime($prisonTime);
        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&success=4');
        exit;
    }

    public function updatePartnerText() {
        $libelle = $_POST['partner_text'] ?? null;

        if ($libelle === null) {
            header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&error=Champ partenaire manquant');
            exit;
        }

        $this->configModel->updatePartnerText($libelle);
        header('Location: /ctf_anna/ctf-challenge/public/dashboard.php?page=config&success=5');
        exit;
    }
} 