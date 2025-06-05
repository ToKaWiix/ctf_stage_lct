<?php
// Récupérer les données de la session
$teams = $_SESSION['players_data']['teams'] ?? [];
$players = $_SESSION['players_data']['players'] ?? [];

// Nettoyer la session après utilisation
unset($_SESSION['players_data']);
?>

<div id="player-dashboard">
    <div id="player-list-title">
        <h2>Gestion des joueurs</h2>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case '1':
                    echo "Le joueur a été ajouté avec succès.";
                    break;
                case '2':
                    echo "Le joueur a été supprimé avec succès.";
                    break;
                case '3':
                    echo "Le joueur a été modifié avec succès.";
                    break;
            }
            ?>
        </div>
    <?php endif; ?>
    <div id="card-player-list">
        <div id="card-player-list-content">
            <h3>Liste des joueurs par équipe</h3>
            <div id="player-list-table">
                <?php
                $currentTeam = null;
                foreach ($players as $player):
                    if ($currentTeam !== $player['ctf_nom_equipe']):
                        if ($currentTeam !== null): ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif;
                $currentTeam = $player['ctf_nom_equipe']; ?>
                <button class="accordion">Équipe <?= htmlspecialchars($currentTeam) ?> :</button>
                <div class="panel">
                    <table>
                        <thead>
                            <tr>
                                <th>Prénom</th>
                                <th>Nom</th>
                                <th>Surnom</th>
                                <th>Photo</th>
                                <th>En prison</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                <?php endif; ?>
                <tr>
                    <td><?= htmlspecialchars($player['ctf_prenom']) ?></td>
                    <td><?= htmlspecialchars($player['ctf_nom']) ?></td>
                    <td><?= htmlspecialchars($player['ctf_pseudo']) ?></td>
                    <td>
                        <?php if (!empty($player['ctf_photo'])): ?>
                            <img src="/ctf_anna/ctf-challenge/public/images/<?= htmlspecialchars($player['ctf_photo']) ?>" 
                                 alt="<?= htmlspecialchars($player['ctf_prenom']) ?>" 
                                 style="width:40px;height:40px;border-radius:50%;">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?= $player['ctf_prison'] ? 'Oui' : 'Non' ?>
                    </td>
                    <td id="actions-icons">
                        <svg class="edit-player" width="30" height="30" viewBox="0 0 44 43" fill="none" xmlns="http://www.w3.org/2000/svg"
                             data-player-id="<?= htmlspecialchars($player['id_ctf_joueur']) ?>"
                             data-player-firstname="<?= htmlspecialchars($player['ctf_prenom']) ?>"
                             data-player-lastname="<?= htmlspecialchars($player['ctf_nom']) ?>"
                             data-player-nickname="<?= htmlspecialchars($player['ctf_pseudo']) ?>"
                             data-player-team="<?= htmlspecialchars($player['id_ctf_equipe']) ?>">
                            <path d="M3.66699 3.58398L30.2503 9.85482L33.0003 23.2923L23.8337 32.2507L10.0837 29.5632L3.66699 3.58398ZM3.66699 3.58398L17.5747 17.1756M22.0003 34.0423L34.8337 21.5007L40.3337 26.8757L27.5003 39.4173L22.0003 34.0423ZM23.8337 19.709C23.8337 21.688 22.192 23.2923 20.167 23.2923C18.1419 23.2923 16.5003 21.688 16.5003 19.709C16.5003 17.73 18.1419 16.1257 20.167 16.1257C22.192 16.1257 23.8337 17.73 23.8337 19.709Z" 
                                  stroke="var(--color-secondary)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <svg class="delete-player" width="30" height="30" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg"
                             data-player-id="<?= htmlspecialchars($player['id_ctf_joueur']) ?>"
                             data-player-name="<?= htmlspecialchars($player['ctf_prenom'] . ' ' . $player['ctf_nom']) ?>">
                            <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" 
                                  stroke="var(--color-action-red)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if ($currentTeam !== null): ?>
                    </tbody>
                </table>
            </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="card-add-player">
        <div id="add-player-title">
            <h3>Ajouter un joueur</h3>
        </div>
        <form action="/ctf_anna/ctf-challenge/public/players.php?action=add" method="post" enctype="multipart/form-data">
            <label for="firstname">Prénom du joueur :</label>
            <input type="text" id="firstname" name="firstname" required>
            <label for="lastname">Nom du joueur :</label>
            <input type="text" id="lastname" name="lastname" required>
            <label for="nickname">Surnom du joueur :</label>
            <input type="text" id="nickname" name="nickname" required>
            <label for="photo">Photo du joueur :</label>
            <input type="file" id="photo" name="photo" accept="image/*" required />
            <label for="team">Équipe :</label>
            <select id="team" name="team" required>
                <option value="">-- Sélectionnez --</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?= htmlspecialchars($team['id_ctf_equipe']) ?>">
                        <?= htmlspecialchars($team['ctf_nom_equipe']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div id="submit-login-button">
                <button type="submit">Ajouter le joueur</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="delete-modal" class="modal">
    <div class="modal-content">
        <h3>Confirmation de suppression</h3>
        <p>Êtes-vous sûr de vouloir supprimer le joueur <span id="player-name"></span> ?</p>
        <div class="modal-buttons">
            <button id="confirm-delete" class="btn-danger">Confirmer</button>
            <button id="cancel-delete" class="btn-secondary">Annuler</button>
        </div>
    </div>
</div>

<!-- Modal de modification de joueur -->
<div id="edit-modal" class="modal">
    <div class="modal-content">
        <h3>Modifier le joueur</h3>
        <form id="edit-player-form" action="/ctf_anna/ctf-challenge/public/players.php?action=edit" method="post">
            <input type="hidden" id="edit-player-id" name="player_id">
            <div class="form-group">
                <label for="edit-player-firstname">Prénom :</label>
                <input type="text" id="edit-player-firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="edit-player-lastname">Nom :</label>
                <input type="text" id="edit-player-lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="edit-player-nickname">Surnom :</label>
                <input type="text" id="edit-player-nickname" name="nickname" required>
            </div>
            <div class="form-group">
                <label for="edit-player-team">Équipe :</label>
                <select id="edit-player-team" name="team" required>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= htmlspecialchars($team['id_ctf_equipe']) ?>">
                            <?= htmlspecialchars($team['ctf_nom_equipe']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-buttons">
                <button type="submit" class="btn-primary">Valider</button>
                <button type="button" id="cancel-edit" class="btn-secondary">Annuler</button>
            </div>
        </form>
    </div>
</div>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>

<script src="/ctf_anna/ctf-challenge/public/js/players.js"></script>