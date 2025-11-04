document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('add-post-form'); // Post form / Formulaire d'ajout de post
    const chatList = document.querySelector('.chat-list'); // Container for posts / Conteneur des posts

    if (!form) return; // If no form, do nothing / Si pas de formulaire, ne rien faire

    // Handle form submission / Gérer la soumission du formulaire
    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // Prevent default form submission / Empêcher le comportement par défaut du formulaire

        const formData = new FormData(form); // Collect form data / Récupérer les données du formulaire

        try {
            // Send POST request to addPost API / Envoyer la requête POST à l'API addPost
            const response = await fetch('/api/addPost.php', { 
                method: 'POST',
                body: formData,
            });

            const data = await response.json(); // Parse JSON response / Parser la réponse JSON

            if (data.success) {
                // Create post in the DOM / Créer le post dans le DOM
                const postDiv = document.createElement('div');
                postDiv.classList.add('chat-message');
                postDiv.innerHTML = `
                    <div class="chat-header">
                        <strong>${data.post.pseudo}</strong>
                        <span class="chat-date">${data.post.date_post}</span>
                    </div>
                    <div class="chat-content">
                        <h4>${data.post.titre}</h4>
                        <p>${data.post.message}</p>
                    </div>
                `;
                chatList.prepend(postDiv); // Add post to top of chat list / Ajouter le post en haut de la liste

                form.reset(); // Reset form fields / Réinitialiser le formulaire
            } else {
                alert(data.message); // Show error message / Afficher un message d'erreur
            }
        } catch (err) {
            console.error('Erreur fetch addPost:', err); // Log fetch error / Afficher l'erreur dans la console
            alert('Une erreur est survenue lors de l\'ajout du post.'); // Show alert for fetch error / Message d'erreur pour l'utilisateur
        }
    });
});
