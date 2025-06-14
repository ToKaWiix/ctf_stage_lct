document.addEventListener('DOMContentLoaded', function() {
    console.log('Script players.js chargé');
    
    // Sélection des éléments
    const deleteButtons = document.querySelectorAll('.delete-player');
    const editButtons = document.querySelectorAll('.edit-player');
    const deleteModal = document.getElementById('delete-modal');
    const editModal = document.getElementById('edit-modal');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const cancelEditBtn = document.getElementById('cancel-edit');
    const playerNameSpan = document.getElementById('player-name');
    const editForm = document.getElementById('edit-player-form');

    // Gestion des accordéons
    const accordions = document.querySelectorAll(".accordion");
    console.log('Accordéons trouvés:', accordions.length);
    
    accordions.forEach(accordion => {
        accordion.addEventListener("click", function() {
            console.log('Clic sur accordéon');
            this.classList.toggle("active");
            const panel = this.nextElementSibling;
            const icon = this.querySelector('.accordion-icon');
            
            if (this.classList.contains("active")) {
                panel.classList.add("active");
                icon.textContent = '-';
            } else {
                panel.classList.remove("active");
                icon.textContent = '+';
            }
        });
    });

    // Ouvrir l'accordéon de l'équipe spécifiée dans l'URL
    const urlParams = new URLSearchParams(window.location.search);
    const openTeamId = urlParams.get('open_team');
    if (openTeamId) {
        const accordions = document.querySelectorAll('.accordion');
        accordions.forEach(accordion => {
            const teamId = accordion.getAttribute('data-team-id');
            if (teamId === openTeamId) {
                accordion.classList.add("active");
                const panel = accordion.nextElementSibling;
                panel.classList.add("active");
                const icon = accordion.querySelector('.accordion-icon');
                icon.textContent = '-';
            }
        });
    }

    // Gestion de la suppression
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const playerId = this.dataset.playerId;
            const playerName = this.dataset.playerName;
            
            playerNameSpan.textContent = playerName;
            deleteModal.style.display = 'block';
            
            confirmDeleteBtn.onclick = function() {
                window.location.href = `${BASE_URL}/dashboard.php?page=players&action=delete&id=${playerId}`;
            };
        });
    });

    // Gestion de la modification
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const playerId = this.dataset.playerId;
            const playerFirstname = this.dataset.playerFirstname;
            const playerLastname = this.dataset.playerLastname;
            const playerNickname = this.dataset.playerNickname;
            const playerTeam = this.dataset.playerTeam;
            const playerPrison = this.dataset.playerPrison === '1';
            
            document.getElementById('edit-player-id').value = playerId;
            document.getElementById('edit-player-firstname').value = playerFirstname;
            document.getElementById('edit-player-lastname').value = playerLastname;
            document.getElementById('edit-player-nickname').value = playerNickname;
            document.getElementById('edit-player-team').value = playerTeam;
            document.getElementById('edit-player-prison').checked = playerPrison;
            
            editModal.style.display = 'block';
        });
    });

    // Fermeture des modals
    function closeModal(modal) {
        modal.style.display = 'none';
    }

    // Fermeture au clic sur Annuler
    cancelDeleteBtn.addEventListener('click', () => closeModal(deleteModal));
    cancelEditBtn.addEventListener('click', () => closeModal(editModal));

    // Fermeture au clic en dehors du modal
    window.addEventListener('click', function(event) {
        if (event.target === deleteModal) {
            closeModal(deleteModal);
        }
        if (event.target === editModal) {
            closeModal(editModal);
        }
    });
}); 