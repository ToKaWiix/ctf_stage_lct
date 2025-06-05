<?php
namespace Anna\CtfChallenge\Models;

class TeamModel {
    private $pdo;
    private const MAX_TEAMS = 8;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT id_ctf_equipe, ctf_nom_equipe, ctf_score_total, ctf_background_equipe FROM ctf_equipe");
        return $stmt->fetchAll();
    }

    private function getTeamCount() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM ctf_equipe");
        return (int) $stmt->fetchColumn();
    }

    public function add($nomEquipe) {
        if ($this->getTeamCount() >= self::MAX_TEAMS) {
            throw new \Exception("Le nombre maximum d'équipes (8) a été atteint.");
        }

        $backgrounds = [
            'bg1.jpg',
            'bg2.jpg',
            'bg3.jpg',
            'bg4.jpg',
            'bg5.jpg',
            'bg6.jpg',
            'bg7.jpg',
            'bg8.jpg'
        ];

        $stmt = $this->pdo->query("SELECT ctf_background_equipe FROM ctf_equipe");
        $used = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $available = array_diff($backgrounds, $used);

        if (empty($available)) {
            $bg = $backgrounds[array_rand($backgrounds)];
        } else {
            $bg = $available[array_rand($available)];
        }

        $stmt = $this->pdo->prepare("INSERT INTO ctf_equipe (ctf_nom_equipe, ctf_background_equipe, ctf_score_total) VALUES (:nom, :bg, :score)");
        $stmt->execute([
            'nom' => $nomEquipe,
            'bg' => $bg,
            'score' => 0
        ]);
    }

    public function update($id, $nomEquipe) {
        $stmt = $this->pdo->prepare("UPDATE ctf_equipe SET ctf_nom_equipe = :nom WHERE id_ctf_equipe = :id");
        return $stmt->execute([
            'id' => $id,
            'nom' => $nomEquipe
        ]);
    }

    public function delete($id) {
        error_log("Tentative de suppression dans le modèle avec l'ID: " . $id);
        $stmt = $this->pdo->prepare("DELETE FROM ctf_equipe WHERE id_ctf_equipe = :id");
        $result = $stmt->execute(['id' => $id]);
        error_log("Résultat de la suppression: " . ($result ? "succès" : "échec"));
        return $result;
    }
}