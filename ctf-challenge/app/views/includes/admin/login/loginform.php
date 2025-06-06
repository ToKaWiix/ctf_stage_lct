<div id="login-page">
    <div id="login-form">
            <div class="logo-lct">
                <img src="/ctf_anna/ctf-challenge/public/images/LCT-03.png" alt="Logo LCT">
            </div>
            <div id="card-login">
            <h2>connexion<br>administrateur</h2>
            <form action="/ctf_anna/ctf-challenge/public/loginAdmin.php" method="post">
            <label for="username">Identifiant :</label>
            <input type="text" id="username" name="username" required>

            <label for="reponse">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <div id="submit-login-button">
                <button type="submit">Connexion</button>
            </div>
            </form>
        </div>
    </div>
</div>