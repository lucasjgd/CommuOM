<?php
// Start session / Démarrer la session
session_start();

// Include database configuration / Inclure la configuration de la base de données
include("../config/config.php");

// Retrieve all users from the database / Récupérer tous les utilisateurs depuis la base de données
$userQuery = "SELECT * FROM utilisateurs";
$userResult = mysqli_query($link, $userQuery);
?>

<?php include '../templates/head.html'; ?>
<!-- Include HTML head / Inclure le head HTML -->
<?php include '../templates/header.php'; ?>
<!-- Include header / Inclure le header -->

<section>
    <div class="forums"> 
        <h1>Gestion des utilisateurs</h1><br>
    </div>

    <div class="user-table" style="display:flex; justify-content:center;">
        <?php if ($userResult && mysqli_num_rows($userResult) > 0): ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <!-- Username / Pseudo -->
                        <th>Email</th>
                        <!-- Email -->
                        <th>Rôle</th>
                        <!-- Role -->
                        <th>Actions</th>
                        <!-- Actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($userResult)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['pseudo']); ?></td>
                            <!-- Display username / Afficher le pseudo -->
                            <td><?php echo htmlspecialchars($row['mail']); ?></td>
                            <!-- Display email / Afficher l'email -->
                            <td><?php echo ($row['role'] == 1 ? 'Admin' : 'Utilisateur'); ?></td>
                            <!-- Display role / Afficher le rôle -->
                            <td>
                                <!-- Delete user button / Bouton pour supprimer l'utilisateur -->
                                <button class="btn btn-delete delete-user" data-id="<?php echo intval($row['utilisateur_id']); ?>">Supprimer</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found / Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Scroll to top link / Remonter en haut de la page -->
<a href="#" class="ancrage">↑</a>

<?php include '../templates/footer.html'; ?>
<!-- Include footer / Inclure le footer -->

