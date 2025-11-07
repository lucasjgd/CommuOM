<?php
// Start session / Démarrer la session
session_start();

// Include database configuration / Inclure la configuration de la base de données
require __DIR__ . '/../config/config.php'; // Contains MySQLi connection ($link) / Contient la connexion MySQLi ($link)

// Initialize variables / Initialiser les variables
$message = '';
$email = $_GET['mail'] ?? '';

// Check that email parameter exists / Vérifier que le paramètre email existe
if (!$email) {
    die("Lien invalide.");
}

// Check if the email exists in database / Vérifier si l’e-mail existe dans la base de données
$result = mysqli_query($link, "SELECT * FROM utilisateurs WHERE mail = '" . mysqli_real_escape_string($link, $email) . "'");
$user = mysqli_fetch_assoc($result);

// Stop if user does not exist / Arrêter si l’utilisateur n’existe pas
if (!$user) {
    die("Ce compte n'existe pas.");
}

// Handle form submission / Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve passwords / Récupérer les mots de passe
    $mdp1 = $_POST['password'];
    $mdp2 = $_POST['password_confirm'];

    // Hash password / Hacher le mot de passe
    $hash = password_hash($mdp1, PASSWORD_DEFAULT);
    $hash_escaped = mysqli_real_escape_string($link, $hash);
    $email_escaped = mysqli_real_escape_string($link, $email);

    // Update password in database / Mettre à jour le mot de passe dans la base de données
    $query = "UPDATE utilisateurs SET mdp = '$hash_escaped' WHERE mail = '$email_escaped'";
    if (mysqli_query($link, $query)) {

        // Set success message and redirect / Définir le message de succès et rediriger
        $_SESSION['reset_success'] = "Votre mot de passe a été réinitialisé avec succès.";
        header("Location: authentification.php");
        exit;
    } else {

        // Display SQL error message / Afficher le message d’erreur SQL
        $message = "Erreur lors de la mise à jour du mot de passe : " . mysqli_error($link);
    }
}
?>

<?php include '../templates/head.html'; ?> <!-- Include HTML head / Inclure le head HTML -->

<!-- Password reset form section / Section du formulaire de réinitialisation du mot de passe -->
<section class="form-card"> 
    <h1>Réinitialiser le mot de passe</h1>
    <p>Pour :
        <?php echo htmlspecialchars($email); ?>
    </p>

    <!-- Display error message if any / Afficher le message d’erreur s’il y en a un -->
    <?php if ($message): ?>
        <p style="color:red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Password reset form / Formulaire de réinitialisation du mot de passe -->
    <form action="resetPassword.php?mail=<?php echo urlencode($email); ?>" method="POST">
        <label for="password_register">Nouveau mot de passe</label>
        <input type="password" name="password" id="password_register" required>

        <label for="password_register_confirm">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" id="password_register_confirm" required>

        <!-- Password checklist / Liste de vérification du mot de passe -->
        <div id="passwordChecklist" style="margin-top:10px; font-size:0.9em;">
            <p id="length" style="color:red;">- 12 caractères minimum</p>
            <p id="uppercase" style="color:red;">- 1 majuscule</p>
            <p id="lowercase" style="color:red;">- 1 minuscule</p>
            <p id="number" style="color:red;">- 1 chiffre</p>
            <p id="special" style="color:red;">- 1 caractère spécial</p>
            <p id="match" style="color:red;">- Les mots de passe correspondent</p>
        </div>

        <button type="submit" id="submitBtn" class="btn" disabled>Valider</button>
    </form>
</section>

<!-- Include footer / Inclure le footer -->
<?php include '../templates/footer.html'; ?>
