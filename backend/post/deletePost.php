<?php

/**
 * Handle the deletion of a forum post (AJAX endpoint)
 * / Gère la suppression d’un post sur le forum (point d’accès AJAX)
 *
 * This script:
 * - Checks if the user session is active
 * - Verifies that a post ID has been provided
 * - Checks if the post exists in the database
 * - Deletes the post if found
 * - Returns a JSON response indicating success or error
 *
 * / Ce script :
 * - Vérifie si la session utilisateur est active
 * - Vérifie qu’un identifiant de post a été transmis
 * - Vérifie si le post existe dans la base de données
 * - Supprime le post s’il est trouvé
 * - Retourne une réponse JSON indiquant le succès ou l’erreur
 *
 * Expected POST parameters / Paramètres POST attendus :
 * @param int $_POST['id'] Post ID to delete / ID du post à supprimer
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
    $id = intval($_POST['id']); // Get post ID and ensure it is an integer / Récupérer l'ID du post et le convertir en entier

    // Check if the post exists / Vérifier si le post existe
    $check = $link->prepare("SELECT COUNT(*) AS total FROM post WHERE post_id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();
    $check->close();

    if ($result['total'] == 0) {
        // Post does not exist / Ce post n'existe pas ou a déjà été supprimé
        echo json_encode([
            "success" => false,
            "message" => "Ce post n'existe pas ou a déjà été supprimé."
        ]);
        exit;
    }

    // Delete the post / Supprimer le post
    $stmt = $link->prepare("DELETE FROM post WHERE post_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Post supprimé avec succès."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Erreur lors de la suppression du post."
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
