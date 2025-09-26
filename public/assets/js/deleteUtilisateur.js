document.querySelectorAll('.delete-user').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) return;

        let userId = this.dataset.id;

        fetch("deleteUtilisateur.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + userId
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