<header>
  <!-- Site logo / Logo du site -->
  <img src="assets/images/logo.webp" alt="Logo du site CommuOM, forum des fans de l’Olympique de Marseille">

  <!-- Main navigation / Menu principal -->
  <nav aria-label="Menu principal">
    <a href="./index.php">Accueil</a> <!-- Homepage / Accueil -->
    <a href="./forum.php">Forum</a> <!-- Forum page / Forum -->

      <?php if (isset($_SESSION['utilisateur_id'])): ?>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
          <a href="./userManagement.php">Gestion des utilisateurs</a> <!-- Admin: User management / Admin : Gestion utilisateurs -->
          <a href="./postManagement.php">Gestion des posts</a> <!-- Admin: Post management / Admin : Gestion posts -->
        <?php endif; ?>

        <a href="./logout.php">Se déconnecter</a> <!-- Logout / Déconnexion -->
      <?php else: ?>
        <a href="./authentification.php">Connexion / Inscription</a> <!-- Login/Register / Connexion/Inscription -->
      <?php endif; ?>
    </ul>
  </nav>
</header>
