<?php
session_start();
header('Content-Type: application/json');
include("config.php");

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Vérifie si le post existe
    $check = $link->prepare("SELECT COUNT(*) AS total FROM post WHERE post_id = ?");
    $check->bind_param("i", $id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();
    $check->close();

    if ($result['total'] == 0) {
        echo json_encode([
            "success" => false,
            "message" => "Ce post n'existe pas ou a déjà été supprimé."
        ]);
        exit;
    }

    // Supprime le post
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
    echo json_encode([
        "success" => false,
        "message" => "ID manquant."
    ]);
}

$link->close();
?>
