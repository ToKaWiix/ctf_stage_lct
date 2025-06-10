document.addEventListener('DOMContentLoaded', function() {
    // Gestion des modales
    const deleteButtons = document.querySelectorAll('.delete-admin');
    const deleteModal = document.getElementById('delete-admin-modal');
    const confirmDeleteBtn = document.getElementById('confirm-delete-admin');
    const cancelDeleteBtn = document.getElementById('cancel-delete-admin');
    const adminUsernameSpan = document.getElementById('admin-username');
    let adminIdToDelete = null;

    // Gestionnaire d'événements pour les boutons de suppression
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            adminIdToDelete = this.getAttribute('data-admin-id');
            const username = this.getAttribute('data-admin-username');
            adminUsernameSpan.textContent = username;
            deleteModal.style.display = 'block';
        });
    });

    // Fermeture de la modale au clic sur Annuler
    cancelDeleteBtn.addEventListener('click', function() {
        deleteModal.style.display = 'none';
        adminIdToDelete = null;
    });

    // Fermeture de la modale au clic en dehors
    window.addEventListener('click', function(event) {
        if (event.target === deleteModal) {
            deleteModal.style.display = 'none';
            adminIdToDelete = null;
        }
    });

    // (La gestion de la suppression réelle sera ajoutée plus tard)

    confirmDeleteBtn.addEventListener('click', function() {
        if (adminIdToDelete) {
            document.getElementById('delete-admin-id').value = adminIdToDelete;
            document.getElementById('delete-admin-form').submit();
        }
    });
});