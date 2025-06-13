<div id="login-page">
    <div id="login-form">
        <div class="logo-lct">
            <img src="/ctf_anna/ctf-challenge/public/images/LCT-03.png" alt="Logo LCT">
        </div>
        <div id="card-login">
            <h2>connexion<br>administrateur</h2>
            <form action="/ctf_anna/ctf-challenge/public/loginAdmin.php" method="post" id="loginForm">
                <label for="username">Identifiant :</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
                <div id="submit-login-button">
                    <button type="submit" id="loginButton">Connexion</button>
                </div>
            </form>
            <div id="attempts-message" style="display: none; color: red; text-align: center; margin-top: 10px;"></div>
            <?php if (isset($error) && !empty($error)): ?>
                <div class="error-message" style="text-align: center; color: red; margin-top: 10px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="/ctf_anna/ctf-challenge/public/js/login-protection.js"></script>