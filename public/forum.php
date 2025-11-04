<?php
// Start session / Démarrer la session
session_start();

// Include database configuration / Inclure la configuration de la base de données
include("../config/config.php");

// Retrieve posts with their author (pseudo) / Récupérer les posts avec leur auteur (pseudo)
$query = "
    SELECT p.post_id, p.titre, p.message, p.date_post, u.pseudo
    FROM post p
    INNER JOIN utilisateurs u ON p.utilisateur_id = u.utilisateur_id
    ORDER BY p.date_post DESC
";
$result = mysqli_query($link, $query);

// Check if query executed successfully / Vérifier si la requête s'est exécutée correctement
if (!$result) {
  echo "Impossible d'exécuter la requête $query : " . mysqli_error($link);
  exit;
}
?>

<?php include '../templates/head.html'; ?> <!-- Include HTML head / Inclure le head HTML -->
<?php include '../templates/header.php'; ?> <!-- Include header / Inclure le header -->

<section class="forums">
  <!-- Forum section / Section du forum -->
  <h1>FORUM</h1>
  <p>Partagez vos idées et échangez avec les autres membres !</p>
</section>

<div class="chat-page">
  <div class="chat-list">
    <!-- Display posts / Afficher les posts -->
    <?php
    if ($result && mysqli_num_rows($result) > 0):
      while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="chat-message">
          <div class="chat-header">
            <strong><?php echo htmlspecialchars($row['pseudo']); ?></strong> <!-- Author / Auteur -->
            <span class="chat-date"><?php echo date("d/m/Y H:i", strtotime($row['date_post'])); ?></span> <!-- Post date / Date du post -->
          </div>
          <div class="chat-content">
            <h4><?php echo htmlspecialchars($row['titre']); ?></h4> <!-- Post title / Titre du post -->
            <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p> <!-- Post message / Message du post -->
          </div>
        </div>
        <?php
      endwhile;
    endif;
    ?>
  </div>

  <?php if (isset($_SESSION['utilisateur_id'])): ?>
    <!-- Form to add a new post / Formulaire pour ajouter un post -->
    <div class="chat-form">
      <h3>Ajouter un post</h3>
      <form id="add-post-form">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Publier</button>
      </form>
    </div>
  <?php else: ?>
    <!-- Message for users not logged in / Message pour les utilisateurs non connectés -->
    <div class="chat-form">
      <p>Connectez-vous pour pouvoir ajouter un post.</p>
    </div>
  <?php endif; ?>
</div>

<!-- Scroll to top link / Lien pour remonter en haut de la page -->
<a href="#" class="ancrage">↑</a>

<?php include '../templates/footer.html'; ?> <!-- Include footer / Inclure le footer -->
