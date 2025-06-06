<?php
require_once dirname(__DIR__) . '/app/core/database.php';
require_once dirname(__DIR__) . '/app/core/auth.php';

// --- TEST DE DEFINITION --- 
if (function_exists('isLoggedIn')) {
    error_log("TEST: isLoggedIn est bien définie APRES require_once auth.php");
} else {
    error_log("TEST: ERREUR GRAVE - isLoggedIn n'est PAS définie APRES require_once auth.php");
}
// --- FIN TEST --- 

require_once dirname(__DIR__) . '/app/models/AdminModel.php';
require_once dirname(__DIR__) . '/app/controllers/AuthController.php';

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si l'utilisateur est déjà connecté, rediriger vers le dashboard
if (isLoggedIn()) {
    error_log("loginAdmin.php - Utilisateur déjà connecté, redirection vers dashboard");
    header('Location: /ctf_anna/ctf-challenge/public/dashboard.php');
    exit;
}

$error = null; // Initialiser l'erreur à null par défaut

// Vérifier si le formulaire a été soumis en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("loginAdmin.php - Formulaire soumis en POST");
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier que les champs ne sont pas vides
    if (empty($username) || empty($password)) {
        error_log("loginAdmin.php - Champs vides");
        $error = 'Identifiant ou mot de passe manquant.';
    } else {
        try {
            $pdo = getPDO();
            $authController = new \Anna\CtfChallenge\Controllers\AuthController($pdo);

            // Tenter la connexion
            error_log("loginAdmin.php - Tentative de connexion pour: " . $username);
            if ($authController->login($username, $password)) {
                error_log("loginAdmin.php - Connexion réussie, redirection vers dashboard");
                // Redirection vers le dashboard en cas de succès
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php');
                exit;
            } else {
                error_log("loginAdmin.php - Échec de la connexion");
                $error = 'Identifiants invalides.';
            }
        } catch (\Exception $e) {
            error_log("loginAdmin.php - Exception: " . $e->getMessage());
            $error = 'Une erreur est survenue lors de la connexion.';
        }
    }
} else {
    error_log("loginAdmin.php - Pas de soumission de formulaire ou méthode non POST");
}

// --- La div d'erreur est maintenant toujours générée, sa visibilité est contrôlée par JS ---

// Inclure le header
include dirname(__DIR__) . '/app/views/includes/admin/login/headerAdmin.php';

?>

<main>
    <div id="login-page">
        <div id="login-form">
            <div class="logo-lct">
                <img src="/ctf_anna/ctf-challenge/public/images/LCT-03.png" alt="Logo LCT">
            </div>
            <div id="card-login">
                <h2>connexion<br>administrateur</h2>
                <form method="post">
                    <label for="username">Identifiant :</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                    <div id="submit-login-button">
                        <button type="submit">Connexion</button>
                    </div>
                </form>
                <?php if (!empty($error)): ?>
                    <div class="error-message" style="text-align: center; color: red; margin-top: 10px;">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
// Script pour contrôler la visibilité du message d'erreur
document.addEventListener('DOMContentLoaded', function() {
    console.log("Script JS pour l'erreur exécuté !");
    const errorMessageDiv = document.querySelector('.error-message');

    if (errorMessageDiv) {
        const content = errorMessageDiv.textContent.trim();
        console.log("Contenu brut de la div d'erreur : '" + content + "'");
        console.log("Longueur du contenu trimé : " + content.length);

        // Vérifie si la div existe et si elle contient du texte (pas juste des espaces blancs)
        if (content.length > 0) {
            console.log("Contenu détecté, affiche la div.");
            errorMessageDiv.style.display = 'block'; // Rend la div visible
        } else {
            console.log("Aucun contenu détecté, cache la div.");
            errorMessageDiv.style.display = 'none'; // Cache la div si elle est vide
        }
    }
});
</script>

</body>
</html> 