<?php
// Start session / Démarrer la session
session_start();

// Include mail sender and database configuration / Inclure le système d'envoi de mail et la configuration de la base de données
require __DIR__ . '/../backend/mail/mailer.php';
require __DIR__ . '/../config/config.php'; // Include database connection / Inclure la connexion MySQL ($link)

// Initialize message variable / Initialiser le message d'information
$message = '';

// Handle form submission / Traiter le formulaire envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); // Sanitize email input / Nettoyer l'email

    // Check if email exists in database / Vérifier si l'email existe dans la base
    $result = mysqli_query(
        $link,
        "SELECT * FROM utilisateurs WHERE mail = '" . mysqli_real_escape_string($link, $email) . "'"
    );
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Generate password reset link / Générer le lien de réinitialisation du mot de passe
        $resetLink = "https://joagand.alwaysdata.net/resetPassword.php?mail=" . urlencode($email);

        // Define mail subject / Définir le sujet du mail
        $subject = "Reinitialisation de votre mot de passe";

        // Build HTML email body / Construire le corps HTML de l'email
        $bodyHtml = '
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Reinitialisation de votre mot de passe</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; margin:20px auto; border-radius:8px; overflow:hidden; box-shadow:0 0 10px rgba(0,0,0,0.1);">
          <tr>
            <td style="padding:30px; color:#3b6e99;">
              <h1 style="color:#3b6e99; text-align:center;">CommuOM</h1>
              <h2 style="color:#333; text-align:center;">Bonjour ' . htmlspecialchars($user['pseudo']) . '</h2>
              <p style="font-size:16px; line-height:1.6; text-align:center; color:#333;">
                Vous avez demandé la réinitialisation de votre mot de passe.<br>
                Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe :
              </p>
              <p style="text-align:center; margin-top:30px;">
                <a href="' . $resetLink . '" 
                   style="display:inline-block; padding:12px 25px; background-color:#3b6e99; color:#ffffff; text-decoration:none; border-radius:5px; font-weight:bold;">
                  Réinitialiser le mot de passe
                </a>
              </p>
              <p style="font-size:14px; color:#666; text-align:center; margin-top:20px;">
                Si vous n\'êtes pas à l\'origine de cette demande, ignorez simplement cet e-mail.
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
</html>';

        // Send email using PHPMailer / Envoyer l'email avec PHPMailer
        $send = sendMail($email, $subject, $bodyHtml);

        // Handle result / Gérer le résultat
        if ($send === true) {
            $message = "Un email de réinitialisation a été envoyé à $email.";
        } else {
            $message = "Erreur lors de l'envoi de l'email : $send";
        }
    } else {
        // If email not found / Si l'email n'existe pas
        $message = "Le mail n'est pas associé à un compte.";
    }
}
?>

<?php include '../templates/head.html'; ?> <!-- Include HTML head / Inclure le head HTML -->
<?php include '../templates/header.php'; ?> <!-- Include header / Inclure le header -->

<section class="form-card">
  <!-- Forgot password form section / Section du formulaire de mot de passe oublié -->
  <h1>Mot de passe oublié</h1>

  <?php if ($message): ?>
    <!-- Display feedback message / Afficher le message de retour -->
    <p><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <!-- Form to enter email address / Formulaire pour entrer l'adresse email -->
  <form action="forgotPassword.php" method="POST">
    <label for="email">Entrez votre email</label>
    <input type="email" name="email" id="email" required>
    <button type="submit" class="btn">Envoyer</button>
  </form>
</section>

<?php include '../templates/footer.html'; ?> <!-- Include footer / Inclure le footer -->
