<?php
// Récupérer les messages de session
$successMessage = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : null;

// Effacer les messages après les avoir récupérés
unset($_SESSION['success']);
unset($_SESSION['error']);
?>

<!-- Modale pour les messages -->
<div id="messageModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title"></h2>
            <button class="close">&times;</button>
        </div>
        <div class="modal-body">
            <p class="modal-message"></p>
        </div>
        <div class="modal-footer">
            <button class="modal-button">OK</button>
        </div>
    </div>
</div>

<div id="form-submit-flag">
    <h2>Soumettre un flag</h2>
    <form action="/ctf_anna/ctf-challenge/public/submit.php" method="post">
        <label for="pseudo">Votre pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required>

        <label for="challenge_id">Choisissez un challenge :</label>
        <select id="challenge_id" name="challenge_id" required>
            <option value="">--Choisir un challenge--</option>
            <?php foreach ($challenges as $challenge): ?>
                <option value="<?= htmlspecialchars($challenge['id_ctf_challenge']) ?>">
                    <?= htmlspecialchars($challenge['ctf_nom_challenge']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="flag">Flag :</label>
        <input type="text" id="flag" name="flag" required>
        <p>En cas de mauvaise réponse, le participant sera envoyé en prison et ne pourra pas aider son équipe pendant un certain temps.</p>
        <div id="submit-flag-button">
            <button type="submit">Soumettre le flag</button>
        </div>
    </form>
</div>

<script>
    // Fonction pour afficher la modale
    function showModal(title, message) {
        const modal = document.getElementById('messageModal');
        const modalTitle = modal.querySelector('.modal-title');
        const modalMessage = modal.querySelector('.modal-message');
        
        // Adapter le message en fonction du contenu
        if (message.includes('Flag correct')) {
            if (message.includes('Les points seront attribués')) {
                modalTitle.textContent = 'Challenge en cours';
                modalMessage.innerHTML = '🟣 ' + message;
            } else {
                modalTitle.textContent = 'Challenge réussi';
                modalMessage.innerHTML = '🟢 ' + message;
            }
        } else {
            modalTitle.textContent = 'Challenge échoué';
            modalMessage.innerHTML = '⛓️ ' + message;
        }
        
        modal.style.display = 'block';
    }

    // Fonction pour fermer la modale
    function closeModal() {
        const modal = document.getElementById('messageModal');
        modal.style.display = 'none';
    }

    // Fermer la modale quand on clique sur le X
    document.querySelector('.close').onclick = closeModal;

    // Fermer la modale quand on clique sur le bouton OK
    document.querySelector('.modal-button').onclick = closeModal;

    // Fermer la modale quand on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('messageModal');
        if (event.target == modal) {
            closeModal();
        }
    }

    // Afficher la modale si un message existe
    <?php if ($successMessage): ?>
        showModal('Succès', '<?php echo addslashes($successMessage); ?>');
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        showModal('Erreur', '<?php echo addslashes($errorMessage); ?>');
    <?php endif; ?>
</script>