<header>
  <img src="public/assets/images/logo.png" alt="Logo OM">
  <nav>
    <a href="index.php">Accueil</a> |
    <a href="forum.php">Forums</a> |
    
    <?php if (isset($_SESSION['utilisateur_id'])): ?>
      
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1): ?>
        <a href="categories.php">Gestion des catégories</a> |
        <a href="utilisateurs.php">Gestion des utilisateurs</a> |
        <a href="posts.php">Gestion des posts</a> |
      <?php endif; ?>
      
      <a href="logout.php">Se déconnecter</a>
    
    <?php else: ?>
      <a href="identification.php">Connexion/Inscription</a>
    <?php endif; ?>
  </nav>
</header>
        