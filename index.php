<?php
session_start();
include("config.php"); // connexion à la BDD

// Récupérer les 4 derniers posts avec le pseudo de l'utilisateur et le nom de la catégorie
$query = "
    SELECT p.post_id, p.titre, p.message, p.image, p.date_post, u.pseudo, c.libelle AS categorie
    FROM post p
    JOIN utilisateurs u ON p.utilisateur_id = u.utilisateur_id
    JOIN categorie c ON p.categorie_id = c.categorie_id
    ORDER BY p.date_post DESC
    LIMIT 4
";
$result = mysqli_query($link, $query);
?>

<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<section class="welcome">
    <h1>Bienvenue sur CommuOM ! Forum dédié aux fans de l’OM 💪</h1>
    <h2>Les derniers posts :</h2>
</section>

<section class="cards">
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($post = mysqli_fetch_assoc($result)) {
            echo '<div class="post-card">';
            
            if (!empty($post['image'])) {
                echo '<img src="'.htmlspecialchars($post['image']).'" alt="'.htmlspecialchars($post['titre']).'">';
            }

            echo '<div class="post-content">
                    <div class="category">'.htmlspecialchars($post['categorie']).'</div>
                    <h3>'.htmlspecialchars($post['titre']).'</h3>
                    <p>'.nl2br(htmlspecialchars($post['message'])).'</p>
                    <small>Posté le '.date("d/m/Y H:i", strtotime($post['date_post'])).' - par '.htmlspecialchars($post['pseudo']).'</small>
                  </div>
                </div>';
        }
    } else {
        echo "<p>Aucun post récent disponible.</p>";
    }
    ?>
</section>

<?php include 'footer.html'; ?>

