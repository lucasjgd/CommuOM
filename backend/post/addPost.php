<?php
session_start(); // Start session / Démarrer la session
include("../../config/config.php"); // Include database connection / Inclure la connexion à la base de données

header('Content-Type: application/json'); // Set response type to JSON / Définir le type de réponse en JSON

// Check if user is logged in / Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    echo json_encode(['success' => false, 'message' => 'Vous devez être connecté.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize input / Récupérer et nettoyer les données
    $titre = trim($_POST['titre'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Check required fields / Vérifier que tous les champs sont remplis
    if (empty($titre) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis.']);
        exit;
    }

    // Escape data for database / Échapper les données pour la base de données
    $titre_safe = mysqli_real_escape_string($link, $titre);
    $message_safe = mysqli_real_escape_string($link, $message);
    $user_id = intval($_SESSION['utilisateur_id']);

    // Insert post into database / Insérer le post dans la base de données
    $query = "INSERT INTO post (titre, message, utilisateur_id, date_post) 
              VALUES ('$titre_safe', '$message_safe', $user_id, NOW())";

    if (mysqli_query($link, $query)) {
        $post_id = mysqli_insert_id($link); // Get new post ID / Récupérer l'ID du nouveau post
        $pseudo = $_SESSION['pseudo'];
        $date_post = date("d/m/Y H:i");

        // Return JSON with new post data / Retourner les données du post en JSON
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
        // Database error / Erreur base de données
        echo json_encode(['success' => false, 'message' => 'Erreur base de données : ' . mysqli_error($link)]);
    }
    exit;

} else {
    // HTTP method not allowed / Méthode HTTP non autorisée
    echo json_encode(['success' => false, 'message' => 'Méthode HTTP non autorisée']);
}
?>
