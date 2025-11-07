<?php
// Start session / Démarrer la session
session_start();

// Handle POST requests for login or registration / Traiter les requêtes POST pour la connexion ou l'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pseudo'])) {
        require __DIR__ . '/../backend/user/subscribe.php'; // Include registration logic / Inclure la logique d'inscription
    } elseif (isset($_POST['email']) && isset($_POST['password'])) {
        require __DIR__ . '/../backend/user/login.php'; // Include login logic / Inclure la logique de connexion
    }
}
?>

<?php include '../templates/head.html'; ?> <!-- Include HTML head / Inclure le head HTML -->
<?php include '../templates/header.php'; ?> <!-- Include header / Inclure le header -->

<section class="auth-section">
  <?php if (!isset($_SESSION['utilisateur_id'])): ?>
    <!-- Login and registration forms / Formulaires de connexion et d'inscription -->
    <h1>Connectez-vous ou inscrivez-vous pour rejoindre la communauté !</h1>
    <div class="forms-container">

      <!-- Login form / Formulaire de connexion -->
      <div class="form-card">
        <h2>Connexion</h2>
        <form action="authentification.php" method="POST">
          <label for="email_login">Email</label>
          <input type="email" id="email_login" name="email" required>

          <label for="password_login">Mot de passe</label>
          <input type="password" id="password_login" name="password" required>

          <button type="submit" class="btn">Se connecter</button>
          <a class = "forgotPassword" href = "/forgotPassword.php">Mot de passe oublié ?</a>
        </form>
      </div>

      <!-- Registration form / Formulaire d'inscription -->
      <div class="form-card"> 
        <h2>Inscription</h2>
        <form action="authentification.php" method="POST">
          <label for="pseudo">Pseudo</label>
          <input type="text" id="pseudo" name="pseudo" required>

          <label for="email_register">Email</label>
          <input type="email" id="email_register" name="email" required>

          <label for="password_register">Mot de passe</label>
          <input type="password" id="password_register" name="password" required>

          <label for="password_register_confirm">Confirmation du mot de passe</label>
          <input type="password" id="password_register_confirm" name="password_confirm" required>

          <!-- Password strength checklist / Liste des critères du mot de passe -->
          <div id="passwordChecklist" style="margin-top:10px; font-size:0.9em;">
            <p id="length" style="color:red;">- 12 caractères minimum</p>
            <p id="uppercase" style="color:red;">- 1 majuscule</p>
            <p id="lowercase" style="color:red;">- 1 minuscule</p>
            <p id="number" style="color:red;">- 1 chiffre</p>
            <p id="special" style="color:red;">- 1 caractère spécial</p>
            <p id="match" style="color:red;">- Les mots de passe correspondent</p>
          </div>

          <button type="submit" class="btn">S'inscrire</button>
        </form>
      </div>
    </div>
  <?php else: ?>
    <!-- Message if user is already logged in / Message si l'utilisateur est déjà connecté -->
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?> !</h1>
    <p>Vous êtes déjà connecté.</p>
  <?php endif; ?>
</section>

<?php include '../templates/footer.html'; ?> <!-- Include footer / Inclure le footer -->
