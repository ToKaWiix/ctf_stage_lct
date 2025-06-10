<?php
error_log("Début du script challenges.php");
error_log("Session avant récupération : " . print_r($_SESSION, true));

// Récupérer les données de la session
$challenges = $_SESSION['challenges_data']['challenges'] ?? [];
error_log("Challenges récupérés : " . print_r($challenges, true));

// Nettoyer la session après utilisation
unset($_SESSION['challenges_data']);
error_log("Session après nettoyage : " . print_r($_SESSION, true));
?>

<div id="team-dashboard">
    <div id="team-list-title">
        <h2>Gestion des challenges</h2>
    </div>
    <div id="card-team-list">
        <div id="card-team-list-content">
            <h3>Liste des challenges</h3>
            <div id="team-list-table">
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Nom du défi</th>
                                <th>Flag</th>
                                <th>Points</th>
                                <th>Afficher les points ?</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($challenges)): ?>
                                <?php foreach ($challenges as $challenge): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($challenge['ctf_nom_challenge']) ?></td>
                                        <td>***************</td>
                                        <td><?= htmlspecialchars($challenge['ctf_pts']) ?></td>
                                        <td><?= $challenge['ctf_show_pts'] ? 'Oui' : 'Non' ?></td>
                                        <td id="actions-icons">
                                            <svg class="delete-challenge" width="45" height="43" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                 data-challenge-id="<?= htmlspecialchars($challenge['id_ctf_challenge']) ?>"
                                                 data-challenge-name="<?= htmlspecialchars($challenge['ctf_nom_challenge']) ?>">
                                                <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="var(--color-action-red)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">Aucun challenge trouvé.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="card-add-challenge">
        <div id="add-challenge-title">
            <h3>Ajouter un challenge</h3>
        </div>
        <form action="/ctf_anna/ctf-challenge/public/dashboard.php?page=challenges&action=add" method="post">
            <label for="challenge_name">Nom du défi :</label>
            <input type="text" id="challenge_name" name="challenge_name" required>
            <label for="flag">Flag :</label>
            <input type="text" id="flag" name="flag" required>
            <label for="points">Points :</label>
            <input type="text" id="points" name="points" required>
            <label>Afficher les points :</label>
            <div class="show-points-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="show_points" value="oui">
                    <span>Oui</span>
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" name="show_points" value="non">
                    <span>Non</span>
                </label>
            </div>
            <div id="submit-challenge-button">
                <button type="submit">Ajouter le défi</button>
            </div>
        </form>
    </div>
</div>



<!-- Modale de suppression -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <h3>Confirmation de suppression</h3>
        <p>Êtes-vous sûr de vouloir supprimer ce challenge ?</p>
        <div class="modal-buttons">
            <button class="btn-secondary">Annuler</button>
            <button class="btn-danger">Confirmer</button>
        </div>
    </div>
</div>

<script src="/ctf_anna/ctf-challenge/public/js/challenges.js"></script>