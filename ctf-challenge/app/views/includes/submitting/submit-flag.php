<div id="form-submit-flag">
<h2>Soumettre un flag</h2>
    <form action="/soumettre.php" method="post">
    <label for="pseudo">Votre pseudo :</label>
    <input type="text" id="pseudo" name="pseudo" required>

    <label for="niveau">Choisissez un challenge :</label>
    <select id="niveau" name="niveau" required>
        <option value="">--Choisir un challenge--</option>
        <option value="facile">Facile</option>
        <option value="moyen">Moyen</option>
        <option value="difficile">Difficile</option>
    </select>

    <label for="reponse">Flag :</label>
    <input type="text" id="reponse" name="reponse" required>
    <p>En cas de mauvaise réponse, le participant sera envoyé en prison et ne pourra pas aider son équipe pendant un certain temps.</p>
    <div id="submit-flag-button">
        <button type="submit">Soumettre le flag</button>
    </div>
    </form>
</div>