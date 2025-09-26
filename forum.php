<?php
session_start();
include("config.php");

// Récupérer les posts avec leur auteur (pseudo)
$query = "
    SELECT p.post_id, p.titre, p.message, p.date_post, u.pseudo
    FROM post p
    INNER JOIN utilisateurs u ON p.utilisateur_id = u.utilisateur_id
    ORDER BY p.date_post DESC
";
$result = mysqli_query($link, $query);

if (!$result) {
  echo "Impossible d'exécuter la requête $query : " . mysqli_error($link);
  exit;
}
?>
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<section class="forums">
  <h1>FORUM</h1>
  <p>Partagez vos idées et échangez avec les autres membres !</p>
</section>

<div class="chat-page">
  <div class="chat-list">
    <?php
    if ($result && mysqli_num_rows($result) > 0):
      while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="chat-message">
          <div class="chat-header">
            <strong><?php echo htmlspecialchars($row['pseudo']); ?></strong>
            <span class="chat-date"><?php echo date("d/m/Y H:i", strtotime($row['date_post'])); ?></span>
          </div>
          <div class="chat-content">
            <h4><?php echo htmlspecialchars($row['titre']); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
          </div>
        </div>
        <?php
      endwhile;
    endif;
    ?>
  </div>

  <?php if (isset($_SESSION['utilisateur_id'])): ?>
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
    <div class="chat-form">
      <p>Connectez-vous pour pouvoir ajouter un post.</p>
    </div>
  <?php endif; ?>
</div>

<?php include 'footer.html'; ?>

<style>
  .chat-page {
    display: flex;
    gap: 20px;
    max-width: 1200px;
    margin: 20px auto;
  }

  /* Liste des posts */
  .chat-list {
    flex: 3;
    max-height: 80vh;
    overflow-y: auto;
  }

  .chat-message {
    background: #ffffff;
    margin-bottom: 15px;
    padding: 12px 15px;
    border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
  }

  .chat-header {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    margin-bottom: 8px;
    color: #333;
  }

  .chat-header strong {
    color: #3b6e99;
  }

  .chat-date {
    color: #777;
    font-size: 0.8rem;
  }

  .chat-content h4 {
    margin: 0 0 5px 0;
    font-size: 1rem;
    color: #222;
  }

  .chat-content p {
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.4rem;
    color: #444;
  }

  /* Formulaire ajouter un post */
  .chat-form {
    flex: 1;
    background: #ececec;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    height: fit-content;
  }

  .chat-form h3 {
    margin-top: 0;
    color: #3b6e99;
  }

  .chat-form label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
  }

  .chat-form input,
  .chat-form textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 6px;
    resize: vertical;
  }

  .chat-form button {
    margin-top: 10px;
    background-color: #3b6e99;
    color: #fff;
    padding: 8px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .chat-form button:hover {
    background-color: #2e5678;
  }

  /* Scrollbar */
  .chat-list::-webkit-scrollbar {
    width: 8px;
  }

  .chat-list::-webkit-scrollbar-thumb {
    background-color: #3b6e99;
    border-radius: 4px;
  }
</style>