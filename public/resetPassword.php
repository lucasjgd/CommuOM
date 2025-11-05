<?php
session_start();
require __DIR__ . '/../config/config.php'; // Connexion MySQLi ($link)

$message = '';
$email = $_GET['mail'] ?? '';

if (!$email) {
    die("Lien invalide.");
}

// Vérifier que l'email existe
$result = mysqli_query($link, "SELECT * FROM utilisateurs WHERE mail = '" . mysqli_real_escape_string($link, $email) . "'");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Ce compte n'existe pas.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mdp1 = $_POST['password'];
    $mdp2 = $_POST['password_confirm'];

    // Hash du mot de passe
    $hash = password_hash($mdp1, PASSWORD_DEFAULT);
    $hash_escaped = mysqli_real_escape_string($link, $hash);
    $email_escaped = mysqli_real_escape_string($link, $email);

    $query = "UPDATE utilisateurs SET mdp = '$hash_escaped' WHERE mail = '$email_escaped'";
    if (mysqli_query($link, $query)) {
        $_SESSION['reset_success'] = "Votre mot de passe a été réinitialisé avec succès ✅";
        header("Location: authentification.php");
        exit;
    } else {
        $message = "Erreur lors de la mise à jour du mot de passe : " . mysqli_error($link);
    }
}
?>

<?php include '../templates/head.html'; ?>
<?php include '../templates/header.php'; ?>

    <section class="form-card"> <h1>Réinitialiser le mot de passe</h1>
    <p>Pour : <?php echo htmlspecialchars($email); ?></p>


    <?php if ($message): ?>
        <p style="color:red;"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form action="resetPassword.php?mail=<?php echo urlencode($email); ?>" method="POST">
        <label for="password_register">Nouveau mot de passe</label>
        <input type="password" name="password" id="password_register" required>

        <label for="password_register_confirm">Confirmer le mot de passe</label>
        <input type="password" name="password_confirm" id="password_register_confirm" required>

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
<?php include '../templates/footer.html'; ?>

