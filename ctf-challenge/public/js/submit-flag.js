console.log('Script submit-flag.js chargé');

// Variable globale pour stocker l'état du CTF
let isCTFActive = false;

// Fonction pour afficher la modale
function showModal(title, message) {
    console.log('Affichage de la modale:', title, message);
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

// Vérifier périodiquement si le CTF est en cours
function checkCTFStatus() {
    fetch('/ctf_anna/ctf-challenge/public/api/ctf-time.php')
        .then(response => response.json())
        .then(data => {
            const now = new Date().getTime();
            const startTime = new Date(data.start_time).getTime();
            const endTime = new Date(data.end_time).getTime();
            isCTFActive = now >= startTime && now <= endTime;
        })
        .catch(error => console.error('Erreur lors de la vérification du statut du CTF:', error));
}

// Gestionnaire de soumission du formulaire
document.getElementById('submitForm').addEventListener('submit', function(event) {
    if (!isCTFActive) {
        event.preventDefault();
        showModal('CTF non actif', '⏰ Le CTF n\'est pas en cours. Vous ne pouvez pas soumettre de flag pour le moment.');
    }
});

// Vérifier le statut toutes les 5 secondes
setInterval(checkCTFStatus, 5000);
// Vérifier immédiatement au chargement
checkCTFStatus(); 