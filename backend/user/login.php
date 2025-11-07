<?php

/**
 * Handle user authentication (login process)
 * / Gère l’authentification des utilisateurs (processus de connexion)
 *
 * This script:
 * - Checks if the request method is POST
 * - Retrieves and sanitizes user credentials (email, password)
 * - Verifies the user's existence in the database
 * - Validates the password using password_verify()
 * - Starts a session and stores user information if successful
 * - Redirects the user based on authentication success or failure
 *
 * / Ce script :
 * - Vérifie si la requête est de type POST
 * - Récupère et nettoie les identifiants de connexion (email, mot de passe)
 * - Vérifie l’existence de l’utilisateur dans la base de données
 * - Valide le mot de passe à l’aide de password_verify()
 * - Démarre une session et stocke les informations de l’utilisateur en cas de succès
 * - Redirige l’utilisateur selon le résultat de la connexion
 *
 * Expected POST parameters / Paramètres POST attendus :
 * @param string $_POST['email']    User email / Adresse e-mail de l’utilisateur
 * @param string $_POST['password'] User password / Mot de passe de l’utilisateur
 *
 * Session variables created / Variables de session créées :
 * @param int    $_SESSION['utilisateur_id'] User ID / ID de l’utilisateur
 * @param string $_SESSION['pseudo']         Username / Pseudo
 * @param string $_SESSION['mail']           User email / Adresse e-mail
 * @param string $_SESSION['role']           User role / Rôle de l’utilisateur
 *
 * Redirections :
 * - On success → forum.php / En cas de succès → forum.php
 * - On failure or direct access → authentification.php / En cas d’échec ou d’accès direct → authentification.php
 *
 * @return void Redirects the user based on login result / Redirige l’utilisateur selon le résultat de la connexion
 */

session_start(); // Start session / Démarrer la session
require __DIR__ . '/../../config/config.php'; // Contains MySQL connection $link / Contient la connexion MySQL $link

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize input / Récupération et nettoyage des données
    $mail = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check that all fields are filled / Vérifier que tous les champs sont remplis
    if (empty($mail) || empty($password)) {
        header("Location: ./authentification.php"); // Redirect with error / Redirection avec message d'erreur
        exit();
    }

    // Escape email to prevent SQL injection / Échapper l'email pour éviter les injections SQL
    $mail_safe = mysqli_real_escape_string($link, $mail);

    // Fetch user from database / Récupération de l'utilisateur depuis la base
    $query = "SELECT utilisateur_id, mail, mdp, pseudo, role FROM utilisateurs WHERE mail='$mail_safe'";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Erreur : impossible d'exécuter la requête - " . mysqli_error($link));
    }

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify password / Vérification du mot de passe
        if (password_verify($password, $user['mdp'])) {
            // Password correct: start session / Mot de passe correct : démarrage de la session
            $_SESSION['utilisateur_id'] = $user['utilisateur_id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['mail'] = $user['mail'];
            $_SESSION['role'] = $user['role'];

            header("Location: ./forum.php"); // Redirect to forum / Redirection vers le forum
            exit();
        } else {
            // Incorrect password / Mot de passe incorrect
            header("Location: ./authentification.php");
            exit();
        }
    } else {
        // User does not exist / Utilisateur inexistant
        header("Location: ./authentification.php");
        exit();
    }
}

// If accessed directly without POST / Si l'utilisateur accède directement à la page sans POST
header("Location: ./authentification.php");
exit();
?>
