<?php session_start(); ?>
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<section class="welcome-page">
  <div class="welcome-content">
    <h1>Bienvenue sur CommuOM ! 💙</h1>
    <p>Le forum dédié aux fans de l’OM. Partagez vos idées, vos analyses et vos émotions avec la communauté !</p>
    <div class="welcome-images">
      <div class="image-card">
        <img src="./public/assets/images/VieOM.png" alt="Vie de l'OM">
        <h3>Vie de l'OM</h3>
      </div>
      <div class="image-card">
        <img src="./public/assets/images/MercatOM.png" alt="Mercato">
        <h3>Mercato</h3>
      </div>
      <div class="image-card">
        <img src="./public/assets/images/MatchOM.png" alt="Matchs">
        <h3>Matchs</h3>
      </div>
    </div>
    <a href="forum.php" class="btn btn-primary">Rejoindre la discussion</a>
  </div>
</section>

<?php include 'footer.html'; ?>

<style>
.welcome-page {
    display: flex;
    justify-content: center;
    align-items: center;
}

.welcome-content h1 {
    font-size: 2.5rem;
    color: #3b6e99;
    margin-bottom: 15px;
}

.welcome-content p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    color: #3b6e99;
}

.welcome-images {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.image-card {
    background: #ffffffbb;
    border-radius: 12px;
    overflow: hidden;
    width: 400px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.image-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.image-card h3 {
    margin: 10px 0;
    font-size: 1.1rem;
    color: #3b6e99;
}

.image-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
</style>
