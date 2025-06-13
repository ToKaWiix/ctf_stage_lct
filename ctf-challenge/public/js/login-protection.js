document.addEventListener('DOMContentLoaded', function() {
    console.log('Script de protection chargé');
    
    const loginForm = document.getElementById('loginForm');
    const loginButton = document.getElementById('loginButton');
    const attemptsMessage = document.getElementById('attempts-message');
    
    if (!loginForm || !loginButton || !attemptsMessage) {
        console.error('Éléments du formulaire non trouvés');
        return;
    }

    const MAX_ATTEMPTS = 3;
    const LOCKOUT_TIME = 30; // 30 secondes

    // Récupérer le nombre de tentatives depuis le localStorage
    let attempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
    let lockoutEndTime = parseInt(localStorage.getItem('lockoutEndTime')) || 0;

    console.log('État initial:', {
        attempts: attempts,
        lockoutEndTime: new Date(lockoutEndTime).toLocaleString(),
        currentTime: new Date().toLocaleString()
    });

    // Vérifier si on est en période de blocage
    if (lockoutEndTime > Date.now()) {
        console.log('En période de blocage');
        const remainingTime = Math.ceil((lockoutEndTime - Date.now()) / 1000);
        disableButton();
        startCountdown(remainingTime);
    }

    // Fonction pour désactiver le bouton
    function disableButton() {
        console.log('Désactivation du bouton');
        loginButton.disabled = true;
        loginButton.style.opacity = '0.5';
        loginButton.style.cursor = 'not-allowed';
    }

    // Fonction pour activer le bouton
    function enableButton() {
        console.log('Activation du bouton');
        loginButton.disabled = false;
        loginButton.style.opacity = '1';
        loginButton.style.cursor = 'pointer';
    }

    // Fonction pour démarrer le compte à rebours
    function startCountdown(initialTime = LOCKOUT_TIME) {
        console.log('Démarrage du compte à rebours:', initialTime);
        let timeLeft = initialTime;
        attemptsMessage.style.display = 'block';
        attemptsMessage.textContent = `Trop de tentatives. Réessayez dans ${timeLeft} secondes.`;
        
        const countdown = setInterval(() => {
            timeLeft--;
            attemptsMessage.textContent = `Trop de tentatives. Réessayez dans ${timeLeft} secondes.`;
            
            if (timeLeft <= 0) {
                console.log('Fin du compte à rebours');
                clearInterval(countdown);
                enableButton();
                attemptsMessage.style.display = 'none';
                attempts = 0;
                localStorage.removeItem('loginAttempts');
                localStorage.removeItem('lockoutEndTime');
            }
        }, 1000);
    }

    // Gestionnaire d'événement pour la soumission du formulaire
    loginForm.addEventListener('submit', function(e) {
        console.log('Tentative de soumission du formulaire');
        
        // Vérifier si on est en période de blocage
        if (lockoutEndTime > Date.now()) {
            console.log('Blocage actif, empêcher la soumission');
            e.preventDefault();
            return;
        }

        attempts++;
        console.log('Nouvelle tentative:', attempts);
        localStorage.setItem('loginAttempts', attempts);
        
        if (attempts >= MAX_ATTEMPTS) {
            console.log('Limite de tentatives atteinte');
            e.preventDefault();
            disableButton();
            lockoutEndTime = Date.now() + (LOCKOUT_TIME * 1000);
            localStorage.setItem('lockoutEndTime', lockoutEndTime);
            startCountdown();
        }
    });

    // Empêcher la soumission si le bouton est désactivé
    loginButton.addEventListener('click', function(e) {
        if (this.disabled) {
            console.log('Clic sur bouton désactivé ignoré');
            e.preventDefault();
            return false;
        }
    });
}); 