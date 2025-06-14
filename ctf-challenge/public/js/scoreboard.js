document.addEventListener('DOMContentLoaded', function() {
    const timerElement = document.getElementById('timer-scoreboard');
    let countdownInterval;
    
    // Récupération des éléments audio
    const countdownSound = document.getElementById('countdown-sound');
    const endSound = document.getElementById('end-sound');
    
    // Configuration des sons
    countdownSound.loop = false;
    countdownSound.volume = 1.0; // Volume maximum pour tester

    // Logs pour le chargement du son
    countdownSound.addEventListener('loadeddata', () => {
        console.log('Son de décompte chargé');
    });

    countdownSound.addEventListener('canplaythrough', () => {
        console.log('Son de décompte prêt à être joué');
    });

    countdownSound.addEventListener('error', (e) => {
        console.error('Erreur de chargement du son:', e);
    });
    
    // Variable pour suivre si le son de fin a déjà été joué
    let endSoundPlayed = false;
    let lastSecondPlayed = -1;

    // Fonction pour jouer le son de décompte
    function playCountdownSound(secondsRemaining) {
        console.log('Tentative de lecture du son pour la seconde:', secondsRemaining);
        
        // Ne jouer le son que si c'est une nouvelle seconde
        if (secondsRemaining !== lastSecondPlayed) {
            lastSecondPlayed = secondsRemaining;
            countdownSound.currentTime = 0;
            
            // Forcer le rechargement du son
            countdownSound.load();
            
            const playPromise = countdownSound.play();
            
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    console.log('Son joué avec succès');
                }).catch(error => {
                    console.error('Erreur lors de la lecture du son:', error);
                    // Afficher plus de détails sur l'erreur
                    console.log('État du son:', {
                        readyState: countdownSound.readyState,
                        error: countdownSound.error,
                        src: countdownSound.currentSrc,
                        volume: countdownSound.volume,
                        muted: countdownSound.muted
                    });
                });
            }
        }
    }

    // Fonction pour arrêter le son de décompte
    function stopCountdownSound() {
        countdownSound.pause();
        countdownSound.currentTime = 0;
        lastSecondPlayed = -1;
    }

    // Fonction pour jouer le son de fin
    function playEndSound() {
        if (!endSoundPlayed) {
            stopCountdownSound();
            endSound.currentTime = 0;
            const playPromise = endSound.play();
            
            if (playPromise !== undefined) {
                playPromise.then(() => {
                    endSoundPlayed = true;
                }).catch(error => {
                    console.error('Erreur lors de la lecture du son de fin:', error);
                });
            }
        }
    }

    // Fonction pour formater le temps restant
    function formatTimeRemaining(milliseconds) {
        if (milliseconds <= 0) {
            return "00:00:00";
        }

        const hours = Math.floor(milliseconds / (1000 * 60 * 60));
        const minutes = Math.floor((milliseconds % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((milliseconds % (1000 * 60)) / 1000);

        return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    // Fonction pour mettre à jour le timer
    function updateTimer() {
        fetch(`${BASE_URL}/api/ctf-time.php`)
            .then(response => response.json())
            .then(data => {
                const now = new Date(); // Obtenir l'heure actuelle en objet Date
                const startTime = new Date(data.start_time); // Convertir start_time en objet Date
                const endTime = new Date(data.end_time); // Convertir end_time en objet Date

                // Logs pour le débogage des heures
                console.log('Current Time (now):', now.toISOString());
                console.log('CTF Start Time (data.start_time):', data.start_time, '->', startTime.toISOString());
                console.log('CTF End Time (data.end_time):', data.end_time, '->', endTime.toISOString());

                // Si le CTF n'a pas encore commencé
                if (now.getTime() < startTime.getTime()) {
                    timerElement.textContent = "En attente";
                    endSoundPlayed = false;
                    stopCountdownSound();
                    return;
                }

                // Si le CTF est terminé
                if (now.getTime() >= endTime.getTime()) {
                    timerElement.textContent = "Terminé !";
                    playEndSound();
                    clearInterval(countdownInterval);
                    return;
                }

                // Calculer le temps restant
                const timeRemaining = endTime.getTime() - now.getTime();
                const secondsRemaining = Math.floor(timeRemaining / 1000);

                // Jouer le son de décompte pour les 5 dernières secondes
                if (secondsRemaining <= 5 && secondsRemaining > 0) {
                    playCountdownSound(secondsRemaining);
                } else {
                    stopCountdownSound();
                }

                timerElement.textContent = formatTimeRemaining(timeRemaining);
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des temps du CTF:', error);
                timerElement.textContent = "Erreur";
            });
    }

    // Mettre à jour le timer toutes les secondes
    updateTimer();
    countdownInterval = setInterval(updateTimer, 1000);

    // Animation du texte des partenaires
    function animatePartenaire() {
        const partenaireText = document.querySelector('#red-partenaires h3');
        if (!partenaireText) return;

        const container = document.querySelector('#red-partenaires');
        const textWidth = partenaireText.offsetWidth;
        const containerWidth = container.offsetWidth;
        
        // Récupérer la position actuelle du localStorage ou utiliser la largeur du conteneur
        let position = parseFloat(localStorage.getItem('partenairePosition')) || containerWidth;
        
        function animate() {
            position -= 1; // Vitesse de défilement
            if (position < -textWidth) {
                position = containerWidth;
            }
            partenaireText.style.transform = `translateX(${position}px)`;
            // Sauvegarder la position actuelle
            localStorage.setItem('partenairePosition', position);
            requestAnimationFrame(animate);
        }
        
        animate();
    }

    // Démarrer l'animation quand le DOM est chargé
    animatePartenaire();

    // Gestion de la rotation des challenges
    let currentChallengeIndex = 0;
    const challengesPerPage = 5;

    function updateChallengeHeaders() {
        const headers = document.querySelectorAll('th:nth-child(n+2):nth-child(-n+6)');
        const challenges = window.challenges || [];
        
        headers.forEach((header, index) => {
            const challengeIndex = (currentChallengeIndex + index) % challenges.length;
            const challenge = challenges[challengeIndex];
            if (challenge) {
                header.textContent = challenge.ctf_nom_challenge;
                // Ajuster la taille de la police si le texte est trop long
                if (challenge.ctf_nom_challenge.length > 15) {
                    header.style.fontSize = '1.2rem';
                } else {
                    header.style.fontSize = '1.563rem';
                }
            }
        });
    }

    // Initialiser la rotation des challenges
    updateChallengeHeaders();

    // Rafraîchir la page toutes les 5 secondes
    setInterval(function() {
        refreshPrisonCard();
        updateChallengeHeaders();
    }, 5000);

    // Fonction pour actualiser la carte prison
    function refreshPrisonCard() {
        const prisonContainer = document.getElementById('prison-players');
        if (!prisonContainer) return;

        fetch(`${BASE_URL}/api/get-prison-players.php`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(html => {
                prisonContainer.innerHTML = html;
                // Les timers individuels seront mis à jour par la logique HTML générée si nécessaire
            })
            .catch(error => {
                console.error('Erreur lors de l\'actualisation de la carte prison:', error);
            });
    }
}); 