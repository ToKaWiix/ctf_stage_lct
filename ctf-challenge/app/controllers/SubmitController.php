<?php
namespace Anna\CtfChallenge\Controllers;

class SubmitController {
    private $pdo;
    private $submitModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->submitModel = new \Anna\CtfChallenge\Models\SubmitModel($pdo);
    }

    public function index() {
        $challenges = $this->submitModel->getChallengesForSubmit();
        require_once dirname(__DIR__) . '/views/submitting.php';
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        // Vérifier que tous les champs sont remplis
        if (empty($_POST['pseudo']) || empty($_POST['challenge_id']) || empty($_POST['flag'])) {
            $_SESSION['error'] = "Tous les champs sont requis";
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        $pseudo = trim($_POST['pseudo']);
        $challengeId = (int)$_POST['challenge_id'];
        $flag = trim($_POST['flag']);

        // Vérifier le format du pseudo
        if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $pseudo)) {
            $_SESSION['error'] = "Le pseudo doit contenir entre 3 et 20 caractères (lettres, chiffres et underscore uniquement)";
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        // Vérifier le format du flag
        if (!preg_match('/^[a-zA-Z0-9_\-]{3,50}$/', $flag)) {
            $_SESSION['error'] = "Le flag doit contenir entre 3 et 50 caractères (lettres, chiffres, underscore et tiret uniquement)";
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        // Vérifier si le joueur existe
        $player = $this->submitModel->getPlayerByPseudo($pseudo);
        if (!$player) {
            $_SESSION['error'] = "Joueur non trouvé";
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        // Vérifier si le joueur est en prison
        if ($player['ctf_prison'] == 1) {
            $_SESSION['error'] = "Vous êtes en prison et ne pouvez pas soumettre de flag";
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        // Vérifier si le challenge existe
        $challenges = $this->submitModel->getChallengesForSubmit();
        $challengeExists = false;
        foreach ($challenges as $challenge) {
            if ($challenge['id_ctf_challenge'] == $challengeId) {
                $challengeExists = true;
                break;
            }
        }
        if (!$challengeExists) {
            $_SESSION['error'] = "Challenge invalide";
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        // Vérifier si le joueur a déjà soumis ce challenge
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM ctf_soumission 
            WHERE id_ctf_joueur = :player_id AND id_ctf_challenge = :challenge_id
        ");
        $stmt->execute([
            'player_id' => $player['id_ctf_joueur'],
            'challenge_id' => $challengeId
        ]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "Vous avez déjà soumis ce challenge";
            header('Location: /ctf_anna/ctf-challenge/public/submit.php');
            exit;
        }

        // Vérifier le flag
        $isCorrect = $this->submitModel->verifyFlag($challengeId, $flag);

        // Enregistrer la soumission
        $this->submitModel->recordSubmission($player['id_ctf_joueur'], $challengeId, $isCorrect);

        if ($isCorrect) {
            // Enregistrer le score pour l'équipe
            if ($this->submitModel->recordScore($player['id_ctf_equipe'], $challengeId)) {
                // Mettre à jour le score total de l'équipe
                $this->submitModel->updateTeamScore($player['id_ctf_equipe'], $challengeId);
                $_SESSION['success'] = "Flag correct ! Points ajoutés à votre équipe.";
            } else {
                $_SESSION['error'] = "Votre équipe a déjà résolu ce challenge";
            }
        } else {
            $_SESSION['error'] = "Flag incorrect";
        }

        header('Location: /ctf_anna/ctf-challenge/public/submit.php');
        exit;
    }
} 