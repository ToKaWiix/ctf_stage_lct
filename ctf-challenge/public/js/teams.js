document.addEventListener('DOMContentLoaded', function() {
    console.log('Script teams.js chargé');
    
    // Sélectionner tous les boutons de suppression
    const deleteButtons = document.querySelectorAll('.delete-team');
    console.log('Boutons de suppression trouvés:', deleteButtons.length);
    
    // Sélectionner la modal et ses éléments
    const modal = document.getElementById('delete-modal');
    const teamNameSpan = document.getElementById('team-name');
    const confirmButton = document.getElementById('confirm-delete');
    const cancelButton = document.getElementById('cancel-delete');
    
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
            modal.style.display = 'block';
            
            // Stocker l'ID de l'équipe dans le bouton de confirmation
            confirmButton.setAttribute('data-team-id', teamId);
        });
    });
    
    // Gérer le clic sur le bouton de confirmation
    confirmButton.addEventListener('click', function() {
        const teamId = this.getAttribute('data-team-id');
        console.log('Confirmation de suppression pour l\'équipe ID:', teamId);
        
        // Rediriger vers la page de suppression
        window.location.href = `/ctf_anna/ctf-challenge/public/dashboard.php?page=teams&action=delete&id=${teamId}`;
    });
    
    // Gérer le clic sur le bouton d'annulation
    cancelButton.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Fermer la modal si l'utilisateur clique en dehors
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}); 