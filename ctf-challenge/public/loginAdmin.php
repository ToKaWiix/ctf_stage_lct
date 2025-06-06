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
    header('Location: /ctf_anna/ctf-challenge/public/dashboard.php');
    exit;
}

$error = null; // Initialiser l'erreur à null par défaut

// Vérifier si le formulaire a été soumis (méthode POST et données présentes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifier que les champs ne sont pas vides
    if (empty($username) || empty($password)) {
        $error = 'Champs manquants';
    } else {
        try {
            $pdo = getPDO();
            $adminModel = new \Anna\CtfChallenge\Models\AdminModel($pdo);
            $authController = new \Anna\CtfChallenge\Controllers\AuthController($pdo);

            // Tenter la connexion
            if ($authController->login($username, $password)) {
                // Redirection vers le dashboard en cas de succès
                header('Location: /ctf_anna/ctf-challenge/public/dashboard.php');
                exit;
            } else {
                $error = 'Identifiants invalides';
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
    }
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
                <!-- La div d'erreur est toujours présente -->
                <div class="error-message" style="text-align: center; color: red; margin-top: 10px;">
                    <?= htmlspecialchars($error ?? '') // Affiche l'erreur si définie, sinon une chaîne vide ?>
                </div>
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
        const content = errorMessageDiv.textContent;
        const trimmedContent = content.trim();
        console.log("Contenu brut de la div d'erreur : '" + content + "'");
        console.log("Contenu trimé de la div d'erreur : '" + trimmedContent + "'");
        console.log("Longueur du contenu trimé : " + trimmedContent.length);

        // Vérifie si la div existe et si elle contient du texte (pas juste des espaces blancs)
        if (trimmedContent.length > 0) {
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