<div id="config-dashboard">
    <div id="config-title">
        <h2>Configuration</h2>
    </div>
    <div id="card-add-admin">
        <div id="card-add-admin-content">
            <h3>Ajout administrateur</h3>
            <div id="add-admin-form">
                <form action="/ctf_anna/ctf-challenge/public/dashboard.php?page=config&action=add" method="post">
                    <label for="username">Identifiant :</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Mot de passe :</label>
                    <input type="text" id="password" name="password" required>
                    <div id="submit-login-button">
                        <button type="submit">Ajouter l'administrateur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="card-list-admin">
        <div id="list-admin-title">
            <h3>Liste des administrateurs</h3>
        </div>
        <div id="list-admin-content">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Identifiant</th>
                            <th>Mot de passe</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($admins as $admin) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($admin['ctf_username']) . '</td>';
                            echo '<td>******************</td>';
                            echo '<td id="actions-icons">';
                            echo '<svg class="delete-admin" width="30" height="30" viewBox="0 0 45 43" fill="none" xmlns="http://www.w3.org/2000/svg" data-admin-id="' . htmlspecialchars($admin['id_ctf_admin']) . '" data-admin-username="' . htmlspecialchars($admin['ctf_username']) . '">';
                            echo '<path d="M5.625 10.7507H9.375M9.375 10.7507H39.375M9.375 10.7507V35.834C9.375 36.7843 9.77009 37.6958 10.4733 38.3678C11.1766 39.0398 12.1304 39.4173 13.125 39.4173H31.875C32.8696 39.4173 33.8234 39.0398 34.5266 38.3678C35.2299 37.6958 35.625 36.7843 35.625 35.834V10.7507M15 10.7507V7.16732C15 6.21696 15.3951 5.30552 16.0984 4.63352C16.8016 3.96151 17.7554 3.58398 18.75 3.58398H26.25C27.2446 3.58398 28.1984 3.96151 28.9016 4.63352C29.6049 5.30552 30 6.21696 30 7.16732V10.7507M18.75 19.709V30.459M26.25 19.709V30.459" stroke="var(--color-action-red)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />';
                            echo '</svg>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="card-time-ctf">
        <div id="ctf-time-title">
            <h3>Durée du CTF</h3>
        </div>
        <form action="/ctf_anna/ctf-challenge/public/dashboard.php?page=config&action=update_ctf_time" method="post" id="ctf-time-form">
            <div class="ctf-time-row">
                <label for="start-time">Début du CTF :</label>
                <input type="datetime-local" id="start-time" name="start-time" required
                    value="<?= isset($ctfTime['ctf_start_time']) ? date('Y-m-d\TH:i', strtotime($ctfTime['ctf_start_time'])) : '' ?>">
            </div>
            <div class="ctf-time-row">
                <label for="end-time">Fin du CTF :</label>
                <input type="datetime-local" id="end-time" name="end-time" required
                    value="<?= isset($ctfTime['ctf_end_time']) ? date('Y-m-d\TH:i', strtotime($ctfTime['ctf_end_time'])) : '' ?>">
            </div>
            <div class="ctf-time-btn-row">
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
    <div id="card-time-prison">
        <div id="prison-time-title">
            <h3>Temps passé en prison</h3>
        </div>
        <form action="/ctf_anna/ctf-challenge/public/dashboard.php?page=config&action=update_prison_time" method="post" id="prison-time-form">
            <div class="prison-time-row">
                <label for="prison-time" class="sr-only">Temps passé en prison :</label>
                <input type="time" id="prison-time" name="prison-time" required
                    value="<?= isset($prisonTime) ? htmlspecialchars($prisonTime) : '' ?>" step="1">
            </div>
            <div class="prison-time-btn-row">
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
    <div id="card-partenaires">
        <div id="partenaires-title">
            <h3>Partenaires</h3>
        </div>
        <form action="/ctf_anna/ctf-challenge/public/dashboard.php?page=config&action=update_partner_text" method="post" id="partenaires-form">
            <div class="partenaires-row">
                <label for="partner_text" class="sr-only">Partenaires :</label>
                <input type="text" id="partner_text" name="partner_text" required value="<?= isset($partnerText) ? htmlspecialchars($partnerText) : '' ?>">
            </div>
            <div class="partenaires-btn-row">
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
    <div id="card-give-pts">
        <div id="give-pts-title">
            <h3>Attribuer les points</h3>
        </div>
        <form action="/ctf_anna/ctf-challenge/public/dashboard.php?page=config&action=distribute_points" method="post" id="give-pts-form">
            <div class="give-pts-btn-row">
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de confirmation de suppression admin -->
<div id="delete-admin-modal" class="modal" style="display:none;">
    <div class="modal-content">
        <h3>Confirmation de suppression</h3>
        <p>Êtes-vous sûr de vouloir supprimer l'administrateur <span id="admin-username"></span> ?</p>
        <div class="modal-buttons">
            <button id="confirm-delete-admin" class="btn-danger">Confirmer</button>
            <button id="cancel-delete-admin" class="btn-secondary">Annuler</button>
        </div>
    </div>
</div>

<form id="delete-admin-form" action="/ctf_anna/ctf-challenge/public/dashboard.php?page=config&action=delete" method="post" style="display:none;">
    <input type="hidden" name="admin_id" id="delete-admin-id">
</form>

<script src="/ctf_anna/ctf-challenge/public/js/config.js"></script>