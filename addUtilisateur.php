<?php
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo']);
    $mail = trim($_POST['mail']);
    $role = intval($_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $link->prepare("INSERT INTO utilisateurs (pseudo, mail, mdp, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $pseudo, $mail, $password, $role);

    if ($stmt->execute()) {
        header("Location: gestionUtilisateurs.php?success=1");
        exit;
    } else {
        echo "Erreur : " . $stmt->error;
    }
}
?>
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<section class="forums" style="max-width:600px; margin:30px auto; text-align:center;">
    <h1>Ajouter un utilisateur</h1>
    <br> 
    <a href="gestionUtilisateurs.php" class="btn" style="margin-bottom:20px; display:inline-block;">← Retour</a>

    <form method="POST" style="background:#ececec; padding:20px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <label>Pseudo :</label>
        <input type="text" name="pseudo" required>

        <label>Email :</label>
        <input type="email" name="mail" required>

        <label>Mot de passe :</label>
        <input type="password" name="password" required>

        <label>Rôle :</label>
        <select name="role">
            <option value="0">Utilisateur</option>
            <option value="1">Admin</option>
        </select>

        <button type="submit" class = "btn-primary btn">
            Ajouter
        </button>
    </form>
</section>

<?php include 'footer.html'; ?>
