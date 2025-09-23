<?php
session_start();
require_once './config.php'; // contient la connexion MySQL $link

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération et nettoyage des données
    $pseudo = trim($_POST['pseudo'] ?? '');
    $mail = trim($_POST['email'] ?? '');
    $password_register = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Vérification que tous les champs sont remplis
    if (empty($pseudo) || empty($mail) || empty($password_register) || empty($password_confirm)) {
        die("Erreur : Tous les champs doivent être remplis.");
    }

    // Vérification que les mots de passe correspondent
    if ($password_register !== $password_confirm) {
        die("Erreur : Les mots de passe ne correspondent pas.");
    }

    // Vérification si l'email existe déjà
    $mail_safe = mysqli_real_escape_string($link, $mail);
    $check_query = "SELECT utilisateur_id FROM utilisateurs WHERE mail='$mail_safe'";
    $result = mysqli_query($link, $check_query);

    if (!$result) {
        die("Erreur : impossible d'exécuter la requête - " . mysqli_error($link));
    }

    if (mysqli_num_rows($result) > 0) {
        die("Erreur : Cet email est déjà utilisé.");
    }

    // Hachage du mot de passe
    $password_hash = password_hash($password_register, PASSWORD_DEFAULT);

    // Échapper le pseudo
    $pseudo_safe = mysqli_real_escape_string($link, $pseudo);

    // Insertion en base
    $insert_query = "INSERT INTO utilisateurs (pseudo, mail, mdp) 
                     VALUES ('$pseudo_safe', '$mail_safe', '$password_hash')";

    if (mysqli_query($link, $insert_query)) {
        // Redirection vers login.php après inscription réussie
        header("Location: identification.php");
        exit();
    } else {
        die("Erreur : impossible d'inscrire l'utilisateur - " . mysqli_error($link));
    }
}

mysqli_close($link);
?>
