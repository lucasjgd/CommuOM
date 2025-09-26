<?php
session_start();
include("config.php");

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) die("Utilisateur invalide");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo']);
    $mail = trim($_POST['mail']);
    $role = intval($_POST['role']);

    $stmt = $link->prepare("UPDATE utilisateurs SET pseudo=?, mail=?, role=? WHERE utilisateur_id=?");
    $stmt->bind_param("ssii", $pseudo, $mail, $role, $id);

    if ($stmt->execute()) {
        header("Location: gestionUtilisateurs.php?success=1");
        exit;
    } else {
        echo "Erreur : " . $stmt->error;
    }
}

$res = $link->query("SELECT * FROM utilisateurs WHERE utilisateur_id=$id");
$user = $res->fetch_assoc();
?>
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<h1>Modifier l’utilisateur</h1>
<form method="POST">
    <label>Pseudo :</label>
    <input type="text" name="pseudo" value="<?php echo htmlspecialchars($user['pseudo']); ?>" required>
    <label>Email :</label>
    <input type="email" name="mail" value="<?php echo htmlspecialchars($user['mail']); ?>" required>
    <label>Rôle :</label>
    <select name="role">
        <option value="0" <?php if ($user['role']==0) echo "selected"; ?>>Utilisateur</option>
        <option value="1" <?php if ($user['role']==1) echo "selected"; ?>>Admin</option>
    </select>
    <button type="submit">Enregistrer</button>
</form>
<?php include 'footer.html'; ?>
