var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
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

    // Gestion de la suppression
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const playerId = this.dataset.playerId;
            const playerName = this.dataset.playerName;
            
            playerNameSpan.textContent = playerName;
            deleteModal.style.display = 'block';
            
            confirmDeleteBtn.onclick = function() {
                window.location.href = `/ctf_anna/ctf-challenge/public/dashboard.php?page=players&action=delete&id=${playerId}`;
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
            
            document.getElementById('edit-player-id').value = playerId;
            document.getElementById('edit-player-firstname').value = playerFirstname;
            document.getElementById('edit-player-lastname').value = playerLastname;
            document.getElementById('edit-player-nickname').value = playerNickname;
            document.getElementById('edit-player-team').value = playerTeam;
            
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

    // Gestion des accordéons
    const acc = document.getElementsByClassName("accordion");
    for (let i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            const panel = this.nextElementSibling;
            const icon = this.querySelector('.accordion-icon');
            
            if (panel.classList.contains("active")) {
                panel.classList.remove("active");
                icon.textContent = '+';
            } else {
                panel.classList.add("active");
                icon.textContent = '-';
            }
        });
    }
}); 