<?php
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
