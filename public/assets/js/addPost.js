const form = document.getElementById('add-post-form');
const chatList = document.querySelector('.chat-list');

form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Crée le FormData à partir du formulaire
    const formData = new FormData(form);

    fetch('addPost.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
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
            chatList.prepend(postDiv);

            // Vide le formulaire
            form.reset();
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Une erreur est survenue.');
    });
});
