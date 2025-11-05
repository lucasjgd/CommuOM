// Select all delete user buttons and add click event / Sélectionner tous les boutons de suppression d'utilisateur et ajouter un événement au clic
document.querySelectorAll('.delete-user').forEach(btn => {
    btn.addEventListener('click', function() {
        // Confirm deletion / Confirmer la suppression
        if (!window.confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) return;

        // Get user ID from data attribute / Récupérer l'ID de l'utilisateur depuis l'attribut data
        let userId = this.dataset.id;

        // Send POST request to delete user API / Envoyer une requête POST à l'API de suppression d'utilisateur
        fetch("/api/deleteUser.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + userId
        })
        .then(res => res.json()) // Parse JSON response / Parser la réponse JSON
        .then(data => {
            if (data.success) {
                alert(data.message); // Show success message / Afficher le message de succès
                this.closest("tr").remove(); // Remove user row from table / Supprimer la ligne de l'utilisateur dans le tableau
            } else {
                alert("Erreur : " + data.message); // Show error message / Afficher le message d'erreur
            }
        })
        .catch(err => alert("Erreur serveur : " + err)); // Handle server error / Gérer l'erreur serveur
    });
});
