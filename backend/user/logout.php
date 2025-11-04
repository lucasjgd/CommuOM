<?php
session_start(); // Start session / Démarrer la session

// Clear all session variables / Supprimer toutes les variables de session
$_SESSION = [];

// Destroy the session / Détruire la session
session_destroy();

// Redirect to homepage / Rediriger vers la page d'accueil
header("Location: ./index.php");
exit();
