<header>
  <img src="public/assets/images/logo.png" alt="Logo OM">
  <nav>
    <a href="index.php">Accueil</a> |
    <a href="forum.php">Forum</a> |
    
    <?php if (isset($_SESSION['utilisateur_id'])): ?>
      
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
        <a href="gestionUtilisateurs.php">Gestion des utilisateurs</a> |
        <a href="gestionPosts.php">Gestion des posts</a> |
      <?php endif; ?>
      
      <a href="logout.php">Se déconnecter</a>
    
    <?php else: ?>
      <a href="identification.php">Connexion/Inscription</a>
    <?php endif; ?>
  </nav>
</header>
