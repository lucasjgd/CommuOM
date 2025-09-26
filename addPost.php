<?php
session_start();
include("config.php");

header('Content-Type: application/json');

if (!isset($_SESSION['utilisateur_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($titre) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis.']);
        exit;
    }

    $titre_safe = mysqli_real_escape_string($link, $titre);
    $message_safe = mysqli_real_escape_string($link, $message);
    $user_id = intval($_SESSION['utilisateur_id']);

    $query = "INSERT INTO post (titre, message, utilisateur_id, date_post) 
              VALUES ('$titre_safe', '$message_safe', $user_id, NOW())";

    if (mysqli_query($link, $query)) {
        $post_id = mysqli_insert_id($link);
        $pseudo = $_SESSION['pseudo'];
        $date_post = date("d/m/Y H:i");

        echo json_encode([
            'success' => true,
            'post' => [
                'post_id' => $post_id,
                'titre' => htmlspecialchars($titre),
                'message' => nl2br(htmlspecialchars($message)),
                'pseudo' => htmlspecialchars($pseudo),
                'date_post' => $date_post
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur base de données : ' . mysqli_error($link)]);
    }
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Méthode HTTP non autorisée']);
}
?>
