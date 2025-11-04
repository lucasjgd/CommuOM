// Select all delete post buttons and add click event / Sélectionner tous les boutons de suppression de post et ajouter un événement au clic
document.querySelectorAll('.delete-post').forEach(btn => {
    btn.addEventListener('click', function() {
        // Confirm deletion / Confirmer la suppression
        if (!window.confirm("Êtes-vous sûr de vouloir supprimer ce post ?")) return;

        // Get post ID from data attribute / Récupérer l'ID du post depuis l'attribut data
        let postId = this.dataset.id;

        // Send POST request to delete post API / Envoyer une requête POST à l'API de suppression de post
        fetch("/api/deletePost.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + postId
        })
        .then(res => res.json()) // Parse JSON response / Parser la réponse JSON
        .then(data => {
            if (data.success) {
                window.alert(data.message); // Show success message / Afficher le message de succès
                this.closest("tr").remove(); // Remove post row from table / Supprimer la ligne du post dans le tableau
            } else {
                window.alert("Erreur : " + data.message); // Show error message / Afficher le message d'erreur
            }
        })
        .catch(err => window.alert("Erreur serveur : " + err)); // Handle server error / Gérer l'erreur serveur
    });
});
