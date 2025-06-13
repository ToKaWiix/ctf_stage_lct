<?php
require_once dirname(dirname(dirname(dirname(__DIR__)))) . '/app/core/database.php';

// Initialiser la connexion PDO
$pdo = getPDO();

// Récupérer les messages de session
$successMessage = isset($_SESSION['success']) ? $_SESSION['success'] : null;
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : null;

// Effacer les messages après les avoir récupérés
unset($_SESSION['success']);
unset($_SESSION['error']);

// Vérifier si le CTF est en cours
$stmt = $pdo->prepare("
    SELECT ctf_start_time, ctf_end_time 
    FROM ctf_config 
    WHERE id_ctf_config = 1
");
$stmt->execute();
$config = $stmt->fetch();

$isCTFActive = false;
if ($config) {
    $now = new DateTime();
    $startTime = new DateTime($config['ctf_start_time']);
    $endTime = new DateTime($config['ctf_end_time']);
    $isCTFActive = ($now >= $startTime && $now <= $endTime);
    
    // Log pour déboguer
    error_log("CTF Status Check:");
    error_log("Now: " . $now->format('Y-m-d H:i:s'));
    error_log("Start: " . $startTime->format('Y-m-d H:i:s'));
    error_log("End: " . $endTime->format('Y-m-d H:i:s'));
    error_log("Is Active: " . ($isCTFActive ? 'true' : 'false'));
}
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
    <form action="/ctf_anna/ctf-challenge/public/submit.php" method="post" id="submitForm">
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

<?php if ($successMessage): ?>
    <script>
        showModal('Succès', '<?php echo addslashes($successMessage); ?>');
    </script>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <script>
        showModal('Erreur', '<?php echo addslashes($errorMessage); ?>');
    </script>
<?php endif; ?>

<script src="/ctf_anna/ctf-challenge/public/js/submit-flag.js"></script>