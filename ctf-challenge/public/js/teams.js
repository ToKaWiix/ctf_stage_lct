document.addEventListener('DOMContentLoaded', function() {
    console.log('Script teams.js chargé');
    
    // Sélectionner tous les boutons de suppression et modification
    const deleteButtons = document.querySelectorAll('.delete-team');
    const editButtons = document.querySelectorAll('.edit-team');
    console.log('Boutons de suppression trouvés:', deleteButtons.length);
    console.log('Boutons de modification trouvés:', editButtons.length);
    
    // Sélectionner les modals et leurs éléments
    const deleteModal = document.getElementById('delete-modal');
    const editModal = document.getElementById('edit-modal');
    const errorModal = document.getElementById('error-modal');
    const teamNameSpan = document.getElementById('team-name');
    const errorMessage = document.getElementById('error-message');
    const confirmDeleteButton = document.getElementById('confirm-delete');
    const cancelDeleteButton = document.getElementById('cancel-delete');
    const cancelEditButton = document.getElementById('cancel-edit');
    const closeErrorButton = document.getElementById('close-error');
    const editTeamForm = document.getElementById('edit-team-form');
    const editTeamIdInput = document.getElementById('edit-team-id');
    const editTeamNameInput = document.getElementById('edit-team-name');

    // Vérifier s'il y a un message d'erreur dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        errorMessage.textContent = decodeURIComponent(error);
        errorModal.style.display = 'block';
    }

    // Gérer le clic sur le bouton de fermeture de la modale d'erreur
    closeErrorButton.addEventListener('click', function() {
        errorModal.style.display = 'none';
        // Nettoyer l'URL
        const newUrl = window.location.pathname + '?page=teams';
        window.history.replaceState({}, '', newUrl);
    });

    // Fermer la modale d'erreur si l'utilisateur clique en dehors
    window.addEventListener('click', function(event) {
        if (event.target === errorModal) {
            errorModal.style.display = 'none';
            // Nettoyer l'URL
            const newUrl = window.location.pathname + '?page=teams';
            window.history.replaceState({}, '', newUrl);
        }
    });
    
    // Ajouter un écouteur d'événement à chaque bouton de suppression
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Clic sur le bouton de suppression');
            const teamName = this.getAttribute('data-team-name');
            const teamId = this.getAttribute('data-team-id');
            console.log('Nom de l\'équipe:', teamName);
            console.log('ID de l\'équipe:', teamId);
            
            // Afficher le nom de l'équipe dans la modal
            teamNameSpan.textContent = teamName;
            
            // Afficher la modal
            deleteModal.style.display = 'block';
            
            // Stocker l'ID de l'équipe dans le bouton de confirmation
            confirmDeleteButton.setAttribute('data-team-id', teamId);
        });
    });

    // Ajouter un écouteur d'événement à chaque bouton de modification
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Clic sur le bouton de modification');
            const teamName = this.getAttribute('data-team-name');
            const teamId = this.getAttribute('data-team-id');
            console.log('Nom de l\'équipe:', teamName);
            console.log('ID de l\'équipe:', teamId);
            
            // Remplir le formulaire avec les données de l'équipe
            editTeamIdInput.value = teamId;
            editTeamNameInput.value = teamName;
            
            // Afficher la modal
            editModal.style.display = 'block';
        });
    });
    
    // Gérer le clic sur le bouton de confirmation de suppression
    confirmDeleteButton.addEventListener('click', function() {
        const teamId = this.getAttribute('data-team-id');
        console.log('Confirmation de suppression pour l\'équipe ID:', teamId);
        
        // Rediriger vers la page de suppression
        window.location.href = `/ctf_anna/ctf-challenge/public/teams.php?action=delete&id=${teamId}`;
    });
    
    // Gérer le clic sur le bouton d'annulation de suppression
    cancelDeleteButton.addEventListener('click', function() {
        deleteModal.style.display = 'none';
    });

    // Gérer le clic sur le bouton d'annulation de modification
    cancelEditButton.addEventListener('click', function() {
        editModal.style.display = 'none';
    });
    
    // Fermer les modals si l'utilisateur clique en dehors
    window.addEventListener('click', function(event) {
        if (event.target === deleteModal) {
            deleteModal.style.display = 'none';
        }
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });
}); 