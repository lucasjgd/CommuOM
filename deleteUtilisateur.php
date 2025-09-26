<?php
session_start();
header('Content-Type: application/json');
include("config.php");

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Vérifie si l'utilisateur a des posts
    $check = $link->prepare("SELECT COUNT(*) AS total FROM post WHERE utilisateur_id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();
    $check->close();

    if ($result['total'] > 0) {
        // ⚠️ Impossible de supprimer car il a des posts
        echo json_encode([
            "success" => false,
            "message" => "Impossible de supprimer : cet utilisateur possède encore des posts."
        ]);
        exit;
    }

    // Supprime l'utilisateur
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
    echo json_encode([
        "success" => false,
        "message" => "ID manquant."
    ]);
}
$link->close();
?>