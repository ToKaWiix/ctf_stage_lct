<?php
namespace Anna\CtfChallenge\Controllers;

use Anna\CtfChallenge\Models\SubmitModel;

class SubmitController {
    private $pdo;
    private $submitModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->submitModel = new SubmitModel($pdo);
    }

    public function index() {
        $challenges = $this->submitModel->getChallengesForSubmit();
        include __DIR__ . '/../views/submitting.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $challengeId = $_POST['challenge_id'] ?? null;
            $flag = $_POST['flag'] ?? null;
            $pseudo = $_POST['pseudo'] ?? null;

            if (!$challengeId || !$flag || !$pseudo) {
                $_SESSION['error'] = "Tous les champs sont requis";
                header('Location: /ctf_anna/ctf-challenge/public/submit.php');
                exit;
            }

            if ($this->submitModel->verifyFlag($challengeId, $flag)) {
                $_SESSION['success'] = "Flag correct !";
            } else {
                $_SESSION['error'] = "Flag incorrect";
            }

            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }
    }
} 