<?php

/**
 * Handle the deletion of a user (AJAX endpoint)
 * / Gère la suppression d’un utilisateur (point d’accès AJAX)
 *
 * This script:
 * - Checks if a user ID has been provided
 * - Verifies if the user still has posts in the database
 * - Prevents deletion if posts exist
 * - Deletes the user if no posts are found
 * - Returns a JSON response indicating success or error
 *
 * / Ce script :
 * - Vérifie si un identifiant d’utilisateur a été transmis
 * - Vérifie si l’utilisateur possède encore des posts dans la base de données
 * - Empêche la suppression si des posts existent
 * - Supprime l’utilisateur s’il n’a plus de posts
 * - Retourne une réponse JSON indiquant le succès ou l’erreur
 *
 * Expected POST parameters / Paramètres POST attendus :
 * @param int $_POST['id'] User ID to delete / ID de l’utilisateur à supprimer
 *
 * JSON Response / Réponse JSON :
 * - success (bool) : true if deletion was successful / true si la suppression a réussi
 * - message (string) : status or error message / message de statut ou d’erreur
 *
 * @return void Outputs a JSON response directly / Retourne directement une réponse JSON
 */

session_start(); // Start session / Démarrer la session
header('Content-Type: application/json'); // Set response type to JSON / Définir le type de réponse en JSON
include("../../config/config.php"); // Include database connection / Inclure la connexion à la base de données

if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Get user ID and ensure it is an integer / Récupérer l'ID de l'utilisateur et le convertir en entier

    // Check if the user has posts / Vérifier si l'utilisateur a des posts
    $check = $link->prepare("SELECT COUNT(*) AS total FROM post WHERE utilisateur_id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();
    $check->close();

    if ($result['total'] > 0) {
        // Cannot delete user because they have posts / ⚠️ Impossible de supprimer car il a des posts
        echo json_encode([
            "success" => false,
            "message" => "Impossible de supprimer : cet utilisateur possède encore des posts."
        ]);
        exit;
    }

    // Delete the user / Supprimer l'utilisateur
    $stmt = $link->prepare("DELETE FROM utilisateurs WHERE utilisateur_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Utilisateur supprimé avec succès."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Erreur lors de la suppression."
        ]);
    }

    $stmt->close();

} else {
    // Missing ID parameter / ID manquant
    echo json_encode([
        "success" => false,
        "message" => "ID manquant."
    ]);
}

$link->close(); // Close database connection / Fermer la connexion à la base de données
?>
