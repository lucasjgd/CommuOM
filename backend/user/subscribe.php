<?php
// Include database configuration and mailer script / Inclure la configuration de la base de données et le script d'envoi de mail
require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../mail/mailer.php';

// Only process POST requests / Traiter uniquement les requêtes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize input / Récupérer et nettoyer les données du formulaire
    $pseudo = trim($_POST['pseudo'] ?? '');
    $mail = trim($_POST['email'] ?? '');
    $password_register = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Check required fields / Vérifier que tous les champs sont remplis
    if (empty($pseudo) || empty($mail) || empty($password_register) || empty($password_confirm)) {
        die("Erreur : Tous les champs doivent être remplis.");
    }

    // Check password match / Vérifier la correspondance des mots de passe
    if ($password_register !== $password_confirm) {
        die("Erreur : Les mots de passe ne correspondent pas.");
    }

    // Check if email already exists / Vérifier si l'email existe déjà
    $mail_safe = mysqli_real_escape_string($link, $mail);
    $check_query = "SELECT utilisateur_id FROM utilisateurs WHERE mail='$mail_safe'";
    $result = mysqli_query($link, $check_query);

    if (!$result) {
        die("Erreur SQL : " . mysqli_error($link));
    }

    if (mysqli_num_rows($result) > 0) {
        die("Erreur : Cet email est déjà utilisé.");
    }

    // Hash password / Hasher le mot de passe
    $password_hash = password_hash($password_register, PASSWORD_DEFAULT);
    $pseudo_safe = mysqli_real_escape_string($link, $pseudo);

    // Insert new user into database / Insérer le nouvel utilisateur dans la base
    $insert_query = "INSERT INTO utilisateurs (pseudo, mail, mdp) 
                     VALUES ('$pseudo_safe', '$mail_safe', '$password_hash')";

    if (mysqli_query($link, $insert_query)) {

        // Prepare welcome email / Préparer le mail de bienvenue
        $sujet = "Bienvenue sur notre site !";

        

        $messageAlt = "Bienvenue $pseudo ! Merci de vous être inscrit sur notre site. Connectez-vous ici : https://joagand.alwaysdata.net//authentification.php";

        // Send welcome email / Envoyer le mail de bienvenue
        $resultMail = sendMail($mail, $sujet, $messageHtml, $messageAlt);

        if ($resultMail !== true) {
            // Log error but do not block registration / Logger l'erreur mais ne pas bloquer l'inscription
            error_log($resultMail);
        }

        // Redirect to login page after registration / Redirection vers la page de connexion après inscription
        header("Location: ./authentification.php");
        exit();
    } else {
        die("Erreur SQL : " . mysqli_error($link));
    }
}

// Close database connection / Fermer la connexion à la base de données
mysqli_close($link);
