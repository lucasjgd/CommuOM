<?php
session_start();
include("config.php");

// Récupère tous les utilisateurs
$userQuery = "SELECT * FROM utilisateurs";
$userResult = mysqli_query($link, $userQuery);
?>
<?php include 'head.html'; ?>
<?php include 'header.php'; ?>

<section class="forums">
    <h1>Gestion des utilisateurs</h1>
    <br>
    <a href="addUtilisateur.php" class="btn-primary btn">Ajouter un utilisateur</a>
</section>

<section class="user-table" style="display:flex; justify-content:center;">
    <?php if ($userResult && mysqli_num_rows($userResult) > 0): ?>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($userResult)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['pseudo']); ?></td>
                        <td><?php echo htmlspecialchars($row['mail']); ?></td>
                        <td><?php echo ($row['role'] == 1 ? 'Admin' : 'Utilisateur'); ?></td>
                        <td>
                            <a href="editUtilisateur.php?id=<?php echo intval($row['utilisateur_id']); ?>"
                                class="btn btn-edit">Éditer</a>
                            <button class="btn btn-delete delete-user"
                                data-id="<?php echo intval($row['utilisateur_id']); ?>">Supprimer</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun utilisateur trouvé.</p>
    <?php endif; ?>
</section>

<?php include 'footer.html'; ?>