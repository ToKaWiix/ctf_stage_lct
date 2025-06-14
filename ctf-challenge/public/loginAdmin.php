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
    header('Location: ' . BASE_URL . '/dashboard.php');
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
            $authController = new \App\Controllers\AuthController($pdo);

            // Tenter la connexion
            error_log("loginAdmin.php - Tentative de connexion pour: " . $username);
            if ($authController->login($username, $password)) {
                error_log("loginAdmin.php - Connexion réussie, redirection vers dashboard");
                // Redirection vers le dashboard en cas de succès
                header('Location: ' . BASE_URL . '/dashboard.php');
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

// Inclure le header
include dirname(__DIR__) . '/app/views/includes/admin/login/headerAdmin.php';
?>

<main>
    <?php include dirname(__DIR__) . '/app/views/includes/admin/login/loginform.php'; ?>
</main>

<!-- Inclure le script de protection -->
<script src="<?= JS_URL ?>/login-protection.js"></script>

</body>
</html> 