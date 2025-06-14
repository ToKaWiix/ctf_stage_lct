document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM chargé');
    
    // Gestion des boutons de suppression
    const deleteButtons = document.querySelectorAll('.delete-challenge');
    console.log('Nombre de boutons de suppression trouvés:', deleteButtons.length);
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Clic sur le bouton de suppression');
            
            const challengeId = this.dataset.challengeId;
            const challengeName = this.dataset.challengeName;
            console.log('ID du challenge:', challengeId);
            console.log('Nom du challenge:', challengeName);
            
            // Mettre à jour le message de confirmation
            const confirmMessage = document.querySelector('#deleteModal p');
            if (confirmMessage) {
                confirmMessage.textContent = `Êtes-vous sûr de vouloir supprimer le challenge "${challengeName}" ?`;
            }
            
            // Afficher la modale
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.style.display = 'block';
                console.log('Modal affiché');
            } else {
                console.error('Modal non trouvé');
            }
            
            // Gérer la confirmation
            const confirmButton = document.querySelector('#deleteModal .btn-danger');
            if (confirmButton) {
                confirmButton.onclick = function() {
                    window.location.href = `${BASE_URL}/dashboard.php?page=challenges&action=delete&id=${challengeId}`;
                };
            }
        });
    });
    
    // Gestion des boutons de fermeture des modals
    const closeButtons = document.querySelectorAll('.btn-secondary');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });
    
    // Fermer le modal en cliquant en dehors
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            e.target.style.display = 'none';
        }
    });

    // Gestion des erreurs dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        const errorMessage = decodeURIComponent(error);
        const errorModal = document.createElement('div');
        errorModal.className = 'modal';
        errorModal.innerHTML = `
            <div class="modal-content">
                <h3>Erreur</h3>
                <p>${errorMessage}</p>
                <div class="modal-buttons">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()">Fermer</button>
                </div>
            </div>
        `;
        document.body.appendChild(errorModal);
        errorModal.style.display = 'block';

        // Nettoyer l'URL
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
}); 