<?php

/**
 * Handle user logout
 * / Gère la déconnexion de l’utilisateur
 *
 * This script:
 * - Starts the session
 * - Clears all session variables
 * - Destroys the active session
 * - Redirects the user to the homepage
 *
 * / Ce script :
 * - Démarre la session
 * - Supprime toutes les variables de session
 * - Détruit la session active
 * - Redirige l’utilisateur vers la page d’accueil
 *
 * Redirection :
 * - index.php → Homepage after logout / Page d’accueil après la déconnexion
 *
 * @return void Redirects to homepage after session destruction / Redirige vers la page d’accueil après destruction de la session
 */

session_start(); // Start session / Démarrer la session

// Clear all session variables / Supprimer toutes les variables de session
$_SESSION = [];

// Destroy the session / Détruire la session
session_destroy();

// Redirect to homepage / Rediriger vers la page d'accueil
header("Location: ./index.php");
exit();
