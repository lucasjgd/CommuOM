const password = document.getElementById('password_register'); // Password input / Champ du mot de passe
const confirm = document.getElementById('password_register_confirm'); // Confirm password input / Champ de confirmation du mot de passe
const btn = document.getElementById('submitBtn'); // Submit button / Bouton de soumission

// Checklist elements / Éléments de la checklist
const length = document.getElementById('length');
const uppercase = document.getElementById('uppercase');
const lowercase = document.getElementById('lowercase');
const number = document.getElementById('number');
const special = document.getElementById('special');
const match = document.getElementById('match');

// Check each password criterion / Vérification de chaque critère du mot de passe
function checkPasswordCriteria(pwd, conf) {
    let valid = true;

    // Length / Longueur
    if (pwd.length >= 12) {
        length.textContent = "- 12 caractères minimum";
        length.style.color = "green";
    } else {
        length.style.color = "red";
        valid = false;
    }

    // Uppercase / Majuscule
    if (/[A-Z]/.test(pwd)) {
        uppercase.style.color = "green";
    } else {
        uppercase.style.color = "red";
        valid = false;
    }

    // Lowercase / Minuscule
    if (/[a-z]/.test(pwd)) {
        lowercase.style.color = "green";
    } else {
        lowercase.style.color = "red";
        valid = false;
    }

    // Number / Chiffre
    if (/\d/.test(pwd)) {
        number.style.color = "green";
    } else {
        number.style.color = "red";
        valid = false;
    }

    // Special character / Caractère spécial
    if (/[^A-Za-z0-9]/.test(pwd)) {
        special.style.color = "green";
    } else {
        special.style.color = "red";
        valid = false;
    }

    // Match confirmation / Correspondance
    if (pwd === conf && pwd !== "") {
        match.style.color = "green";
    } else {
        match.style.color = "red";
        valid = false;
    }

    return valid; // Return overall validity / Retourne la validité générale
}

// Simulated AJAX check for real-time validation / "AJAX" pour validation en temps réel
function simulateAjaxCheck() {
    const pwd = password.value;
    const conf = confirm.value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "#", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200 || xhr.status === 0) {
            // Use JS only to update checklist / On utilise juste JS pour la checklist
            const allValid = checkPasswordCriteria(pwd, conf);
            btn.disabled = !allValid; // Enable submit if all criteria met / Activer le bouton si tous les critères sont remplis
        }
    };

    // Send request / Envoi
    xhr.send("password=" + encodeURIComponent(pwd));
}

// Event listeners for real-time validation / Écouteurs d'événements pour validation en temps réel
password.addEventListener('input', simulateAjaxCheck);
confirm.addEventListener('input', simulateAjaxCheck);
