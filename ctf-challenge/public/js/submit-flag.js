console.log('Script submit-flag.js chargé');

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