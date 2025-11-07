<?php

/**
 * Handle the creation of a new forum post (AJAX endpoint)
 * / Gère la création d’un nouveau post sur le forum (point d’accès AJAX)
 *
 * This script:
 * - Checks if the user is logged in via the session
 * - Retrieves and validates form data (title, message)
 * - Inserts the post into the database
 * - Returns a JSON response indicating success or error
 *
 * / Ce script :
 * - Vérifie si l'utilisateur est connecté via la session
 * - Récupère et valide les données du formulaire (titre, message)
 * - Insère le post dans la base de données
 * - Retourne une réponse JSON indiquant le succès ou l'erreur
 *
 * Expected POST parameters / Paramètres POST attendus :
 * @param string $_POST['titre']   Post title / Titre du post
 * @param string $_POST['message'] Post content / Contenu du post
 *
 * Session variables used / Variables de session utilisées :
 * @param int    $_SESSION['utilisateur_id'] ID of the logged-in user / ID de l’utilisateur connecté
 * @param string $_SESSION['pseudo']         Pseudo of the logged-in user / Pseudo de l’utilisateur connecté
 *
 * JSON Response / Réponse JSON :
 * - success (bool) : true on success, false otherwise / true si succès, false sinon
 * - message (string) : status or error message / message de statut ou d’erreur
 * - post (array, optional) : contains the new post’s data / contient les données du nouveau post
 *
 * @return void Outputs a JSON response directly / Retourne directement une réponse JSON
 */


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
