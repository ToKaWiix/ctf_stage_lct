<div id="form-submit-flag">
    <h2>Soumettre un flag</h2>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <?= htmlspecialchars($_SESSION['error']) ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-message">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
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