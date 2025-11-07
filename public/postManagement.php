<?php
// Start session / Démarrer la session
session_start();

// Include database configuration / Inclure la configuration de la base de données
include("../config/config.php");

// Retrieve all posts with author information / Récupérer tous les posts avec les informations de l'auteur
$postQuery = "
    SELECT 
        p.post_id,
        p.titre,
        p.message,
        p.date_post,
        u.pseudo AS user_pseudo
    FROM post p
    LEFT JOIN utilisateurs u ON p.utilisateur_id = u.utilisateur_id
    ORDER BY p.date_post DESC
";
$postResult = mysqli_query($link, $postQuery);
?>

<?php include '../templates/head.html'; ?> <!-- Include HTML head / Inclure le head HTML -->
<?php include '../templates/header.php'; ?> <!-- Include header / Inclure le header -->
<section>
    <div class="forums">
        <h1>Gestion des posts</h1>
    </div>

    <div class="post-table" style="display:flex; justify-content:center;">
        <?php if ($postResult && mysqli_num_rows($postResult) > 0): ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Titre</th> <!-- Post title / Titre du post -->
                        <th>Message</th> <!-- Post content / Contenu du post -->
                        <th>Utilisateur</th> <!-- Author / Auteur -->
                        <th>Date</th> <!-- Post date / Date du post -->
                        <th>Action</th> <!-- Action buttons / Boutons d'action -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($postResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['titre']); ?></td> <!-- Display title / Afficher le titre -->
                            <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td> <!-- Display message / Afficher le message -->
                            <td><?php echo htmlspecialchars($row['user_pseudo'] ?? 'Inconnu'); ?></td> <!-- Display author / Afficher l'auteur -->
                            <td><?php echo date("d/m/Y H:i", strtotime($row['date_post'])); ?></td> <!-- Format and display date / Formater et afficher la date -->
                            <td>
                                <!-- Delete post button / Bouton pour supprimer le post -->
                                <button class="btn btn-delete delete-post" data-id="<?php echo intval($row['post_id']); ?>">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No posts found / Aucun post trouvé.</p>
        <?php endif; ?>
    </div>

    <!-- Scroll to top link / Remonter en haut de la page -->
    <a href="#" class="ancrage">↑</a>
</section>

<?php include '../templates/footer.html'; ?> <!-- Include footer / Inclure le footer -->
