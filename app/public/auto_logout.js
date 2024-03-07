let timeout; // Variable pour stocker le temps d'inactivité

// Fonction pour réinitialiser le délai de déconnexion
function resetTimer() {
  clearTimeout(timeout);
  timeout = setTimeout(function() {
    // Rediriger l'utilisateur vers la page de déconnexion ou effectuer une action de déconnexion
    window.location.href = '../auth/deconnexion.php'; // Remplacez 'logout.php' par votre page de déconnexion
  }, 60 * 60 * 1000); // Déconnexion après une heure (60 minutes * 60 secondes * 1000 millisecondes)
}

// Réinitialiser le délai à chaque interaction utilisateur
document.addEventListener('mousemove', resetTimer);
document.addEventListener('mousedown', resetTimer);
document.addEventListener('keypress', resetTimer);
document.addEventListener('scroll', resetTimer);

// Démarrer le délai au chargement initial de la page
resetTimer();
