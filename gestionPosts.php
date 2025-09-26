<?php
session_start();
include("config.php");

// Récupérer tous les posts avec l'auteur
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
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<section class="forums">
    <h1>Gestion des posts</h1>
</section>

<section class="post-table" style="display:flex; justify-content:center;">
    <?php if ($postResult && mysqli_num_rows($postResult) > 0): ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Message</th>
                    <th>Utilisateur</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($postResult)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['titre']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                        <td><?php echo htmlspecialchars($row['user_pseudo'] ?? 'Inconnu'); ?></td>
                        <td><?php echo date("d/m/Y H:i", strtotime($row['date_post'])); ?></td>
                        <td>
                            <button class="btn btn-delete delete-post" data-id="<?php echo intval($row['post_id']); ?>">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun post trouvé.</p>
    <?php endif; ?>
</section>

<?php include 'footer.html'; ?>