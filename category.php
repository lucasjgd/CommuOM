<?php
session_start();
include("config.php"); 

// Récupérer l'id de la catégorie depuis l'URL
$catId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer les informations de la catégorie
$catQuery = "SELECT libelle, image FROM categorie WHERE categorie_id = $catId";
$catResult = mysqli_query($link, $catQuery);

if (!$catResult || mysqli_num_rows($catResult) == 0) {
    echo "Catégorie introuvable.";
    exit;
}

$category = mysqli_fetch_assoc($catResult);

// Récupérer les posts associés avec le pseudo de l'utilisateur
$postQuery = "
    SELECT p.post_id, p.titre, p.message, p.date_post, p.image, u.pseudo
    FROM post p
    JOIN utilisateurs u ON p.utilisateur_id = u.utilisateur_id
    WHERE p.categorie_id = $catId
    ORDER BY p.date_post DESC
";
$postResult = mysqli_query($link, $postQuery);
?>

<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<section class="category-banner" style="background-image: url('<?php echo htmlspecialchars($category['image']); ?>');"></section>

<section class="category-header">
    <h1><?php echo htmlspecialchars($category['libelle']); ?></h1>
    <div class="category-buttons">
        <a href="forum.php" class="btn">Retour</a>
        <a href="create_post.php?categorie_id=<?php echo $catId; ?>" class="btn btn-primary">Créer un post</a>
    </div>
</section>

<section class="category-posts">
    <?php 
    if ($postResult && mysqli_num_rows($postResult) > 0) {
        while ($post = mysqli_fetch_assoc($postResult)) {
            echo '
            <div class="post-card">
                '.($post['image'] ? '<img src="'.htmlspecialchars($post['image']).'" alt="'.htmlspecialchars($post['titre']).'">' : '').'
                <div class="post-content">
                    <h3>'.htmlspecialchars($post['titre']).'</h3>
                    <p>'.nl2br(htmlspecialchars($post['message'])).'</p>
                    <small>Posté le '.date("d/m/Y H:i", strtotime($post['date_post'])).' - Par '.htmlspecialchars($post['pseudo']).'</small>
                </div>
            </div>
            ';
        }
    } else {
        echo "<p>Aucun post pour cette catégorie pour le moment.</p>";
    }
    ?>
</section>

<?php include 'footer.html'; ?>

