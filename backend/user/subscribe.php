<?php

/**
 * Handle user registration process
 * / Gère le processus d’inscription des utilisateurs
 *
 * This script:
 * - Processes only POST requests
 * - Retrieves and sanitizes form inputs (pseudo, email, password)
 * - Checks for required fields and password confirmation
 * - Verifies if the email is already registered
 * - Hashes the password and inserts the new user into the database
 * - Sends a welcome email using PHPMailer
 * - Redirects to the authentication page after successful registration
 *
 * / Ce script :
 * - Traite uniquement les requêtes POST
 * - Récupère et nettoie les données du formulaire (pseudo, email, mot de passe)
 * - Vérifie la complétude des champs et la correspondance des mots de passe
 * - Vérifie si l’adresse e-mail est déjà utilisée
 * - Hash le mot de passe et insère le nouvel utilisateur dans la base de données
 * - Envoie un mail de bienvenue avec PHPMailer
 * - Redirige vers la page d’authentification après inscription réussie
 *
 * Expected POST parameters / Paramètres POST attendus :
 * @param string $_POST['pseudo']            Username / Pseudo de l’utilisateur
 * @param string $_POST['email']             User email / Adresse e-mail
 * @param string $_POST['password']          Password / Mot de passe
 * @param string $_POST['password_confirm']  Password confirmation / Confirmation du mot de passe
 *
 * Email sent / Mail envoyé :
 * - Subject / Sujet : “Bienvenue sur notre site !”
 * - Body / Contenu : Message HTML et texte alternatif (avec lien vers la page de connexion)
 *
 * Redirection :
 * - On success → authentification.php / En cas de succès → authentification.php
 *
 * @return void Redirects or displays an error message / Redirige ou affiche un message d’erreur
 */

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

        $messageHtml = '
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Bienvenue sur CommuOM</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; margin:20px auto; border-radius:8px; overflow:hidden; box-shadow:0 0 10px rgba(0,0,0,0.1);">
          <tr>
            <td style="padding:30px; color:#3b6e99;">
              <h1 style="color:#3b6e99; text-align:center;">CommuOM</h1>
              <h2 style="color:#333; text-align:center;">Bienvenue ' . $pseudo . ' !</h2>
              <p style="font-size:16px; line-height:1.6; text-align:center; color: #333;">
                Merci de vous être inscrit sur notre site ! <br>
                Nous sommes ravis de vous accueillir dans la communauté !
              </p>
              <p style="text-align:center; margin-top:30px;">
                <a href="https://joagand.alwaysdata.net//authentification.php" 
                   style="display:inline-block; padding:12px 25px; background-color:#3b6e99; color:#ffffff; text-decoration:none; border-radius:5px; font-weight:bold;">
                  Se connecter
                </a>
              </p>
            </td>
          </tr>
          <tr style="background-color:#3b6e99; text-align:center;">
            <td style="padding:15px; font-size:12px; color:#fff;">
              &copy; ' . date("Y") . ' CommuOM. Tous droits réservés.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
';

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
