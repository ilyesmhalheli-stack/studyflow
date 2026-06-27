<?php

include 'insert.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .questionnaire-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        
        .questionnaire-form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }
        
        .radio-group,
        .checkbox-group {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }
        
        .radio-item,
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 0.25rem;
            display: none;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            display: none;
        }
        
        .btn {
            background: #007bff;
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background: #0056b3;
        }
        
        .btn-secondary {
            background: #6c757d;
            margin-left: 1rem;
        }
        
        .btn-secondary:hover {
            background: #545b62;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>StudyFlow</h1>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="dashboard.php">Tableau de bord</a></li>
                <li><a href="tasks.php">Tâches</a></li>
                <li><a href="planning.php">Planning</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="questionnaire.php" class="active">Questionnaire</a></li>
                <li><a href="funpage.php">Fun Page</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="page-header questionnaire-header">
            <h2>Questionnaire de satisfaction</h2>
            <p>Votre avis nous intéresse ! Aidez-nous à améliorer StudyFlow</p>
        </section>

        <div class="questionnaire-container">
            <div class="success-message" id="successMessage">
                Merci d'avoir rempli notre questionnaire ! Vos réponses ont été soumises avec succès.
            </div>

            <form class="questionnaire-form" method="post" id="questionnaireForm"  "return validateForm(event)">
                
                <div class="form-group">
                    <label for="nomComplet">Nom complet *</label>
                    <input type="text" id="nomComplet" name="nomComplet" placeholder="Entrez votre nom complet">
                    <div class="error-message" id="nomError">Veuillez entrer votre nom complet (au moins 2 caractères)</div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" placeholder="votre.email@example.com">
                    <div class="error-message" id="emailError">Veuillez entrer une adresse email valide</div>
                </div>

                <!-- Type d'utilisateur -->
                <div class="form-group">
                    <label>Vous êtes *</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="etudiant" name="typeUtilisateur" value="etudiant">
                            <label for="etudiant">Étudiant</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="enseignant" name="typeUtilisateur" value="enseignant">
                            <label for="enseignant">Enseignant</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="autre" name="typeUtilisateur" value="autre">
                            <label for="autre">Autre</label>
                        </div>
                    </div>
                    <div class="error-message" id="typeError">Veuillez sélectionner votre type d'utilisateur</div>
                </div>

                <!-- Fréquence d'utilisation -->
                <div class="form-group">
                    <label for="frequence">À quelle fréquence utilisez-vous StudyFlow ? *</label>
                    <select id="frequence" name="frequence">
                        <option value="">Sélectionnez...</option>
                        <option value="quotidien">Tous les jours</option>
                        <option value="hebdomadaire">Plusieurs fois par semaine</option>
                        <option value="mensuel">Quelques fois par mois</option>
                        <option value="rare">Rarement</option>
                        <option value="premiere">C'est ma première utilisation</option>
                    </select>
                    <div class="error-message" id="frequenceError">Veuillez sélectionner une fréquence d'utilisation</div>
                </div>

                <!-- Fonctionnalités préférées -->
                <div class="form-group">
                    <label>Quelles fonctionnalités utilisez-vous le plus ?</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="taches" name="fonctionnalites" value="taches">
                            <label for="taches">Gestion des tâches</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="planning" name="fonctionnalites" value="planning">
                            <label for="planning">Planning</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="dashboard" name="fonctionnalites" value="dashboard">
                            <label for="dashboard">Tableau de bord</label>
                        </div>
                    </div>
                </div>

                <!-- Commentaires -->
                <div class="form-group">
                    <label for="commentaires">Commentaires et suggestions</label>
                    <textarea id="commentaires" name="commentaires" rows="4" placeholder="Partagez vos idées pour améliorer StudyFlow..."></textarea>
                </div>

                <!-- Note de satisfaction -->
                <div class="form-group">
                    <label for="satisfaction">Note de satisfaction globale *</label>
                    <select id="satisfaction" name="satisfaction">
                        <option value="">Sélectionnez une note...</option>
                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                        <option value="4">⭐⭐⭐⭐ Très bon</option>
                        <option value="3">⭐⭐⭐ Bon</option>
                        <option value="2">⭐⭐ Moyen</option>
                        <option value="1">⭐ Médiocre</option>
                    </select>
                    <div class="error-message" id="satisfactionError">Veuillez donner une note de satisfaction</div>
                </div>

                <div class="form-group">
                    <button type="submit"  name="submit" class="btn">Soumettre le questionnaire</button>
                    <button type="reset" class="btn btn-secondary">Effacer</button>
                </div>
            </form>
        </div>
    </main>
    <script src="questionnaire.js"></script>
    <footer>
        <p>&copy; 2025-2026 StudyFlow - ENSI</p>
                <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" style="
                color: white;
                background: #dc3545;
                padding: 0.4rem 1rem;
                border-radius: 4px;
                text-decoration: none;
                font-size: 0.9rem;
            ">Déconnexion (<?php echo $_SESSION['user_nom']; ?>)</a>
        <?php else: ?>
            <a href="login.php" style="
                color: white;
                text-decoration: none;
            ">Connexion</a>
        <?php endif; ?>
    </footer>

</body>
</html>
