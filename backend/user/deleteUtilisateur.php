<?php
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
