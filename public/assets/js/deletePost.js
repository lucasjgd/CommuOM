document.querySelectorAll('.delete-post').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm("Êtes-vous sûr de vouloir supprimer ce post ?")) return;

        let postId = this.dataset.id;

        fetch("deletePost.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + postId
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                this.closest("tr").remove(); 
            } else {
                alert("Erreur : " + data.message);
            }
        })
        .catch(err => alert("Erreur serveur : " + err));
    });
});
