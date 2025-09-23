<?php
session_start();
include("config.php"); 

$query = "SELECT categorie_id, libelle, image, description FROM categorie";
$result = mysqli_query($link, $query);

if (!$result) {
    echo "Impossible d'exécuter la requête $query : " . mysqli_error($link);
}
?>
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

  <section class="forums">
    <h1>Les forums de CommuOM : choisissez une catégorie et partagez vos idées !</h1>
  </section>

  <section class="categories">
    <?php 
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
            <a href="category.php?id=' . intval($row['categorie_id']) . '" class="category-card">
              <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['libelle']) . '">
              <div class="content">
                <h3>' . htmlspecialchars($row['libelle']) . '</h3>
                <p>' . htmlspecialchars($row['description']) . '</p>
              </div>
            </a>
            ';
        }
    } else {
        echo "<p>Aucune catégorie trouvée.</p>";
    }
    ?>
</section>


<?php include 'footer.html'; ?>