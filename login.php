<?php
session_start();
require_once 'config.php'; // contient la connexion MySQL $link

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données
    $mail = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Vérification que tous les champs sont remplis
    if (empty($mail) || empty($password)) {
        // Redirection avec message d'erreur
        header("Location: ./identification.php");
        exit();
    }

    // Échapper l'email pour éviter les injections SQL
    $mail_safe = mysqli_real_escape_string($link, $mail);

    // Récupération de l'utilisateur depuis la base
    $query = "SELECT utilisateur_id, mail, mdp, pseudo, role FROM utilisateurs WHERE mail='$mail_safe'";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Erreur : impossible d'exécuter la requête - " . mysqli_error($link));
    }

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Vérification du mot de passe
        if (password_verify($password, $user['mdp'])) {
            // Mot de passe correct : démarrage de la session
            $_SESSION['utilisateur_id'] = $user['utilisateur_id'];
            $_SESSION['pseudo'] = $user['pseudo'];
            $_SESSION['mail'] = $user['mail'];
            $_SESSION['role'] = $user['role'];

            // Redirection vers le forum
            header("Location: forum.php");
            exit();
        } else {
            // Mot de passe incorrect
            header("Location: ./identification.php");
            exit();
        }
    } else {
        // Utilisateur inexistant
        header("Location: ./identification.php");
        exit();
    }
}

// Si l'utilisateur accède directement à la page sans POST
header("Location: ./identification.php");
exit();
?>
