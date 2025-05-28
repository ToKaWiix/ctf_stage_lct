<div id="player-dashboard">
    <div id="player-list-title">
        <h2>Gestion des joueurs</h2>
    </div>
    <div id="card-player-list">
        <div id="card-player-list-content">
            <h3>Liste des équipes</h3>
            <div id="player-list-table">
                <button class="accordion">Équipe 1 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>
                <button class="accordion">Équipe 2 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>
                <button class="accordion">Équipe 3 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>
                <button class="accordion">Équipe 4 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>
                <button class="accordion">Équipe 5 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>
                <button class="accordion">Équipe 6 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>
                <button class="accordion">Équipe 7 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>
                <button class="accordion">Équipe 8 :</button>
                <div class="panel">
                    <p>Lorem ipsum...</p>
                </div>

            </div>
        </div>
    </div>
    <div id="card-add-player">
        <div id="add-player-title">
            <h3>Ajouter un joueur</h3>
        </div>
        <form action="/create.php" method="post">
            <label for="username">Prénom du joueur :</label>
            <input type="text" id="username" name="username" required>
            <label for="username">Nom du joueur :</label>
            <input type="text" id="username" name="username" required>
            <label for="username">Surnom du joueur :</label>
            <input type="text" id="username" name="username" required>
            <label for="file">Photo du joueur :</label>
            <input type="file" id="file" name="file" required/>
            <label for="file">Équipe :</label>
            <select id="select" name="select">
            <option value="Équipe">-- Sélectionnez --</option>
                <option value="option1">Équipe 1</option>
                <option value="option2">Équipe 2</option>
            </select>
            <div id="submit-login-button">
                <button type="submit">Ajouter le joueur</button>
            </div>
        </form>
    </div>
</div>

<script>
    var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    /* Toggle between adding and removing the "active" class,
    to highlight the button that controls the panel */
    this.classList.toggle("active");

    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>