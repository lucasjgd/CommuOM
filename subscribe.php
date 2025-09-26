<?php
session_start();

require_once __DIR__ . '/config.php'; // Connexion MySQL
require_once __DIR__ . '/mailer.php'; // Fonction sendMail()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pseudo = trim($_POST['pseudo'] ?? '');
    $mail = trim($_POST['email'] ?? '');
    $password_register = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($pseudo) || empty($mail) || empty($password_register) || empty($password_confirm)) {
        die("Erreur : Tous les champs doivent être remplis.");
    }

    if ($password_register !== $password_confirm) {
        die("Erreur : Les mots de passe ne correspondent pas.");
    }

    $mail_safe = mysqli_real_escape_string($link, $mail);
    $check_query = "SELECT utilisateur_id FROM utilisateurs WHERE mail='$mail_safe'";
    $result = mysqli_query($link, $check_query);

    if (!$result) {
        die("Erreur SQL : " . mysqli_error($link));
    }

    if (mysqli_num_rows($result) > 0) {
        die("Erreur : Cet email est déjà utilisé.");
    }

    $password_hash = password_hash($password_register, PASSWORD_DEFAULT);
    $pseudo_safe = mysqli_real_escape_string($link, $pseudo);

    $insert_query = "INSERT INTO utilisateurs (pseudo, mail, mdp) 
                     VALUES ('$pseudo_safe', '$mail_safe', '$password_hash')";

    if (mysqli_query($link, $insert_query)) {

        // Préparer le mail de bienvenue
        // Préparer le mail de bienvenue stylé
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
            <img src="https://joagand.alwaysdata.net//public/assets/images/logo.png" alt="CommuOM" width="100" style="display:block; margin:0 auto;">
              <h1 style="color:#333; text-align:center;">Bienvenue ' . $pseudo . ' !</h1>
              <p style="font-size:16px; line-height:1.6; text-align:center; color: #333;">
                Merci de vous être inscrit sur notre site ! <br>
                Nous sommes ravis de vous accueillir dans la communauté !
              </p>
              <p style="text-align:center; margin-top:30px;">
                <a href="https://joagand.alwaysdata.net//identification.php" 
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

        $messageAlt = "Bienvenue $pseudo ! Merci de vous être inscrit sur notre site. Connectez-vous ici : https://ton-domaine.com/identification.php";


        // Envoi du mail (debug désactivé par défaut)
        $resultMail = sendMail($mail, $sujet, $messageHtml, $messageAlt);

        if ($resultMail !== true) {
            // Log l'erreur pour analyse mais ne bloque pas l'inscription
            error_log($resultMail);
        }

        // Redirection après inscription
        header("Location: identification.php");
        exit();
    } else {
        die("Erreur SQL : " . mysqli_error($link));
    }
}

mysqli_close($link);
