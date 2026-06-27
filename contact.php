<?php

include 'insert.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
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
                <li><a href="questionnaire.php">Questionnaire</a></li>
                <li><a href="funpage.php">Fun Page</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        
        <section class="animated-banner">
            <div class="banner-content" id="bannerText">
                Bienvenue sur le site StudyFlow!
                <h2> 
                    echo ""
                </h2>
            </div>
        </section>

        <section class="image-gallery">
            <h3>Galerie d'images</h3>
            <div class="gallery-container">
                <img id="galleryImage" src="https://images.unsplash.com/photo-1513258496099-48168024aec0" alt="Image galerie">
                <div class="gallery-controls">
                    <button class="btn" onclick="previousImage()"> &#8249;</button>
                    <button class="btn" onclick="nextImage()"> &#8250;</button>
                </div>
            </div>
        </section>

        <section class="contact-layout">
            <div class="contact-form-section">
                <h3>Envoyez-nous un message</h3>
                <form action="contact.php" method="POST" class="task-form">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input type="text" name="prenom" placeholder="Med Aziz" required>
                    </div>
                    <div class="form-group">
                        <label>Nom</label>
                        <input type="text" name="nom" placeholder="Gaddour" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="MedAziz.Gaddour@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Sujet</label>
                        <select name="sujet" required>
                            <option value="">Sélectionnez</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="bug">Rapport de bug</option>
                            <option value="question">Question</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="6" placeholder="Votre message..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Priorité</label>
                        <select name="priorite">
                            <option value="basse">Basse</option>
                            <option value="moyenne">Moyenne</option>
                            <option value="haute">Haute</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="newsletter"> Recevoir des nouvelles de StudyFlow
                        </label>
                    </div>
                    <button type="submit" name="submit1" class="btn">Envoyer</button>
                    <button type="reset" class="btn">Effacer</button>
                </form>
            </div>

            <div class="contact-info-section">
                <h3>Informations</h3>
                <div style="margin-bottom: 2rem;">
                    <h4 style="color: #007bff;">📧 Email</h4>
                    <a href="mailto:studyflow@ensi.tn" style="color: #007bff;">studyflow@ensi.tn</a>
                    <p style="font-size: 0.9rem; color: #666;">Réponse sous 24-48h</p>
                </div>
                <div style="margin-bottom: 2rem;">
                    <h4 style="color: #007bff;">🏫 Adresse</h4>
                    <p>École Nationale des Sciences de l'Informatique (ENSI)</p>
                    <p>Campus Universitaire de La Manouba, 2010, Tunisie</p>
                </div>
                <div style="margin-bottom: 2rem;">
                    <h4 style="color: #007bff;">📅 Disponibilité</h4>
                    <p>Lundi - Vendredi : 9h - 17h</p>
                    <p>Samedi : 9h - 12h</p>
                    <p>Dimanche : Fermé</p>
                </div>
                <div>
                    <h4 style="color: #007bff;">🎯 Objectif</h4>
                    <p>Aider les étudiants à mieux gérer leur temps académique</p>
                </div>
            </div>
        </section>

        <section class="quick-nav-section">
            <h3>Navigation rapide</h3>
            <div class="quick-nav-links">
                <a href="questionnaire.php" class="quick-nav-link">
                    <div class="nav-icon">📋</div>
                    <div class="nav-content">
                        <h4>Questionnaire</h4>
                        <p>Participez à notre questionnaire</p>
                    </div>
                </a>
                <a href="funpage.php" class="quick-nav-link">
                    <div class="nav-icon">🎮</div>
                    <div class="nav-content">
                        <h4>Fun Page</h4>
                        <p>Détendez-vous avec nos jeux</p>
                    </div>
                </a>
            </div>
        </section>
    </main>

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

    <script src="contact.js"></script>
</body>
</html>