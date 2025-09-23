<?php session_start(); ?>
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>
<section class="auth-section">
  <?php if (!isset($_SESSION['utilisateur_id'])): ?>
    <h1>Connectez-vous ou inscrivez-vous pour rejoindre la communauté !</h1>
    <div class="forms-container">
      <!-- Formulaire de connexion -->
      <div class="form-card">
        <h2>Connexion</h2>
        <form action="login.php" method="POST">
          <label for="email_login">Email</label>
          <input type="email" id="email_login" name="email" required>

          <label for="password_login">Mot de passe</label>
          <input type="password" id="password_login" name="password" required>

          <button type="submit">Se connecter</button>
        </form>
      </div>

      <!-- Formulaire d'inscription -->
      <div class="form-card">
        <h2>Inscription</h2>
        <form action="subscribe.php" method="POST">
          <label for="pseudo">Pseudo</label>
          <input type="text" id="pseudo" name="pseudo" required>

          <label for="email_register">Email</label>
          <input type="email" id="email_register" name="email" required>

          <label for="password_register">Mot de passe</label>
          <input type="password" id="password_register" name="password" required>

          <label for="password_register_confirm">Confirmation du mot de passe</label>
          <input type="password" id="password_register_confirm" name="password_confirm" required>

          <button type="submit">S'inscrire</button>
        </form>
      </div>
    </div>
  <?php else: ?>
    <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['pseudo']); ?> !</h1>
    <p>Vous êtes déjà connecté.</p>
  <?php endif; ?>
</section>

<?php include 'footer.html'; ?>