<div id="team-dashboard">
    <div id="team-list-title">
        <h2>Gestion des équipes</h2>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>
    <div id="card-team-list">
        <div id="card-team-list-content">
            <h3>Liste des équipes</h3>
            <div id="team-list-table">
                <table>
                    <thead>
                        <tr>
                            <th>Nom de l'équipe</th>
                            <th>Score total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($teams)): ?>
                            <?php foreach ($teams as $team): ?>
                                <tr>
                                    <td><?= htmlspecialchars($team['ctf_nom_equipe']) ?></td>
                                    <td><?= htmlspecialchars($team['ctf_score_total']) ?></td>
                                    <td id="actions-icons">
                                        <svg width="44" height="43" viewBox="0 0 44 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.66699 3.58398L30.2503 9.85482L33.0003 23.2923L23.8337 32.2507L10.0837 29.5632L3.66699 3.58398ZM3.66699 3.58398L17.5747 17.1756M22.0003 34.0423L34.8337 21.5007L40.3337 26.8757L27.5003 39.4173L22.0003 34.0423ZM23.8337 19.709C23.8337 21.688 22.192 23.2923 20.167 23.2923C18.1419 23.2923 16.5003 21.688 16.5003 19.709C16.5003 17.73 18.1419 16.1257 20.167 16.1257C22.192 16.1257 23.8337 17.73 23.8337 19.709Z" stroke="var(--color-secondary)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <svg class="delete-team" width="45" height="43" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg" data-team-name="<?= htmlspecialchars($team['ctf_nom_equipe']) ?>" data-team-id="<?= htmlspecialchars($team['id_ctf_equipe']) ?>">
                                            <path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="var(--color-action-red)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Aucune équipe trouvée.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="card-add-team">
        <div id="add-team-title">
            <h3>Ajouter une équipe</h3>
        </div>
        <form action="/ctf_anna/ctf-challenge/public/dashboard.php?page=teams&action=add" method="post">
            <label for="username">Nom de l'équipe :</label>
            <input type="text" id="username" name="username" required>
            <div id="submit-login-button">
                <button type="submit">Ajouter l'équipe</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="delete-modal" class="modal">
    <div class="modal-content">
        <h3>Confirmation de suppression</h3>
        <p>Êtes-vous sûr de vouloir supprimer l'équipe <span id="team-name"></span> ?</p>
        <div class="modal-buttons">
            <button id="confirm-delete" class="btn-danger">Confirmer</button>
            <button id="cancel-delete" class="btn-secondary">Annuler</button>
        </div>
    </div>
</div>

<script src="/ctf_anna/ctf-challenge/public/js/teams.js"></script>