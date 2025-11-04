<header>
  <!-- Site logo / Logo du site -->
  <img src="assets/images/logo.webp" alt="Logo du site CommuOM, forum des fans de l’Olympique de Marseille">

  <!-- Main navigation / Menu principal -->
  <nav aria-label="Menu principal">
    <ul>
      <li><a href="./index.php">Accueil</a></li> <!-- Homepage / Accueil -->
      <li><a href="./forum.php">Forum</a></li> <!-- Forum page / Forum -->

      <?php if (isset($_SESSION['utilisateur_id'])): ?>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
          <li><a href="./userManagements.php">Gestion des utilisateurs</a></li> <!-- Admin: User management / Admin : Gestion utilisateurs -->
          <li><a href="./postManagement.php">Gestion des posts</a></li> <!-- Admin: Post management / Admin : Gestion posts -->
        <?php endif; ?>

        <li><a href="./logout.php">Se déconnecter</a></li> <!-- Logout / Déconnexion -->
      <?php else: ?>
        <li><a href="./authentification.php">Connexion / Inscription</a></li> <!-- Login/Register / Connexion/Inscription -->
      <?php endif; ?>
    </ul>
  </nav>
</header>
