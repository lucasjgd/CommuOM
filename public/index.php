<?php session_start(); ?> <!-- Start session / Démarrer la session -->

<?php include '../templates/head.html'; ?> <!-- Include HTML head / Inclure le head HTML -->
<?php include '../templates/header.php'; ?> <!-- Include header / Inclure le header -->

<section class="welcome-page">
  <!-- Welcome section / Section d'accueil -->
  <div class="welcome-content">
    <h1>Bienvenue sur CommuOM !</h1>
    <p>Le forum dédié aux fans de l’OM. Partagez vos idées, vos analyses et vos émotions avec la communauté !</p>
    
    <div class="welcome-images">
      <!-- Image cards showcasing topics / Cartes d'images présentant les sujets -->
      <div class="image-card">
        <img src="assets/images/VieOM.webp" alt="Vie de l'OM">
        <h3>Vie de l'OM</h3>
      </div>
      <div class="image-card">
        <img src="assets/images/MercatOM.webp" alt="Mercato de l'OM">
        <h3>Mercato</h3>
      </div>
      <div class="image-card">
        <img src="assets/images/MatchOM.webp" alt="Matchs de l'OM">
        <h3>Matchs</h3>
      </div>
    </div>

    <!-- Button linking to the forum / Bouton vers le forum -->
    <a href="./forum.php" class="btn btn-primary">Rejoindre la discussion</a>
  </div>
</section>

<?php include '../templates/footer.html'; ?> <!-- Include footer / Inclure le footer -->
