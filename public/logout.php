<?php

require __DIR__ . '/../backend/user/logout.php'; // Include logout logic / Inclure la logique de déconnexion

// Redirect to homepage after successful logout / Rediriger vers la page d'accueil après déconnexion
header('Location: ./index.php');
exit(); // Stop further script execution / Arrêter l'exécution du script
?>
