<nav>
    <div class="logo-lct">
        <img src="<?= IMAGES_URL ?>/LCT-03.png" alt="Logo LCT">
    </div>
    <div id="timer-scoreboard">Chargement...</div>
    <div id="lct-year">LCT 2025</div>
</nav>

<!-- Éléments audio -->
<audio id="countdown-sound" preload="auto">
    <source src="<?= BASE_URL ?>/sounds/beep.wav" type="audio/wav">
</audio>
<audio id="end-sound" preload="auto">
    <source src="<?= BASE_URL ?>/sounds/end.wav" type="audio/wav">
</audio>

<script src="<?= JS_URL ?>/scoreboard.js"></script>