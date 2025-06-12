<?php
namespace Anna\CtfChallenge\Models;

class SubmitModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getChallengesForSubmit() {
        $stmt = $this->pdo->query("
            SELECT id_ctf_challenge, ctf_nom_challenge, ctf_pts 
            FROM ctf_challenge 
            ORDER BY ctf_pts ASC, ctf_nom_challenge ASC
        ");
        return $stmt->fetchAll();
    }

    public function verifyFlag($challengeId, $flag) {
        $stmt = $this->pdo->prepare("
            SELECT ctf_flag 
            FROM ctf_challenge 
            WHERE id_ctf_challenge = :id
        ");
        $stmt->execute(['id' => $challengeId]);
        $challenge = $stmt->fetch();

        if (!$challenge) {
            return false;
        }

        return password_verify($flag, $challenge['ctf_flag']);
    }
} 