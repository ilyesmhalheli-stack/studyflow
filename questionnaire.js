// JavaScript pour la page questionnaire.html
// Auteur: Étudiants ENSI
// Projet: StudyFlow - Partie 3

// Fonction de validation du formulaire
function validateForm(event) {
    event.preventDefault(); // Empêche la soumission par défaut
    
    let isValid = true;
    
    // Réinitialiser les messages d'erreur
    hideAllErrors();
    
    // Validation du nom complet (au moins 2 caractères)
    const nom = document.getElementById('nomComplet').value.trim();
    if (nom.length < 2) {
        showError('nomError');
        isValid = false;
    }
    
    // Validation de l'email (format email valide)
    const email = document.getElementById('email').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('emailError');
        isValid = false;
    }
    
    // Validation du type d'utilisateur (au moins une sélection)
    const typeUtilisateur = document.querySelector('input[name="typeUtilisateur"]:checked');
    if (!typeUtilisateur) {
        showError('typeError');
        isValid = false;
    }
    
    // Validation de la fréquence (sélection requise)
    const frequence = document.getElementById('frequence').value;
    if (frequence === '') {
        showError('frequenceError');
        isValid = false;
    }
    
    // Validation de la note de satisfaction (sélection requise)
    const satisfaction = document.getElementById('satisfaction').value;
    if (satisfaction === '') {
        showError('satisfactionError');
        isValid = false;
    }
    
    // Si le formulaire est valide, afficher le message de succès
    if (isValid) {
        showSuccessMessage();
        // Réinitialiser le formulaire après 3 secondes
        setTimeout(() => {
            document.getElementById('questionnaireForm').reset();
            hideSuccessMessage();
        }, 3000);
    }
    
    return false; // Empêche la soumission réelle du formulaire
}

// Fonction pour afficher un message d'erreur
function showError(errorId) {
    document.getElementById(errorId).style.display = 'block';
}

// Fonction pour masquer tous les messages d'erreur
function hideAllErrors() {
    const errors = document.querySelectorAll('.error-message');
    errors.forEach(error => {
        error.style.display = 'none';
    });
}

// Fonction pour afficher le message de succès
function showSuccessMessage() {
    document.getElementById('successMessage').style.display = 'block';
    // Faire défiler vers le haut pour voir le message
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Fonction pour masquer le message de succès
function hideSuccessMessage() {
    document.getElementById('successMessage').style.display = 'none';
}

// Ajouter des écouteurs d'événements pour la validation en temps réel
document.addEventListener('DOMContentLoaded', function() {
    // Validation du nom en temps réel
    document.getElementById('nomComplet').addEventListener('blur', function() {
        const nom = this.value.trim();
        if (nom.length >= 2) {
            document.getElementById('nomError').style.display = 'none';
        }
    });
    
    // Validation de l'email en temps réel
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(email)) {
            document.getElementById('emailError').style.display = 'none';
        }
    });
    
    // Validation de la fréquence en temps réel
    document.getElementById('frequence').addEventListener('change', function() {
        if (this.value !== '') {
            document.getElementById('frequenceError').style.display = 'none';
        }
    });
    
    // Validation de la satisfaction en temps réel
    document.getElementById('satisfaction').addEventListener('change', function() {
        if (this.value !== '') {
            document.getElementById('satisfactionError').style.display = 'none';
        }
    });
    
    // Validation des boutons radio en temps réel
    document.querySelectorAll('input[name="typeUtilisateur"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('typeError').style.display = 'none';
        });
    });
});
