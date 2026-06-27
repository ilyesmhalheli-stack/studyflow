
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - StudyFlow</title>
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
                <li><a href="about.php" class="active">À propos</a></li>
                <li><a href="questionnaire.php">Questionnaire</a></li>
                <li><a href="funpage.php">Fun Page</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="page-header about-header">
            <h2>À propos de StudyFlow</h2>
            <p>Découvrez notre projet</p>
        </section>

        <section style="max-width: 1200px; margin: 0 auto; padding: 2rem 20px;">
            <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="color: #007bff; margin-bottom: 1rem;">Notre mission</h3>
                <p>StudyFlow aide les étudiants de l'ENSI à mieux gérer leurs délais académiques. Centralisez vos tâches, organisez vos priorités et ne manquez aucun deadline.</p>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="color: #007bff; margin-bottom: 1rem;">Fonctionnalités principales</h3>
                <ul>
                    <li>✓ Ajouter des tâches académiques</li>
                    <li>✓ Planning visuel hebdomadaire</li>
                    <li>✓ Alertes de surcharge</li>
                    <li>✓ Statistiques de progression</li>
                </ul>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="color: #007bff; margin-bottom: 1rem;">Technologies</h3>
                <p>HTML5, CSS3, JavaScript, LocalStorage</p>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 8px; margin-bottom: 2rem;">
                <h3 style="color: #007bff; margin-bottom: 1rem;">Notre équipe</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                    <div style="text-align: center;">
                        <img src="d9499858-57db-439d-a750-3bfab9575778.jpg" alt="Med Aziz Gaddour" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; border: 3px solid #007bff;">
                        <h4>Med Aziz Gaddour</h4>
                        <p>Développeur Frontend</p>
                    </div>
                    <div style="text-align: center;">
                        <img src="ilyes.jpg" alt="Mhalheli Ilyes" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; border: 3px solid #007bff;">
                        <h4>Mhalheli Ilyes</h4>
                        <p>Développeur Frontend</p>
                    </div>
                </div>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 8px;">
                <h3 style="color: #007bff; margin-bottom: 1rem;">Contact</h3>
                <p><strong>Email:</strong> <a href="mailto:studyflow@ensi.tn" style="color: #007bff;">studyflow@ensi.tn</a></p>
                <p><strong>Établissement:</strong> École Nationale des Sciences de l'Informatique (ENSI)</p>
                <p><strong>Année:</strong> 2025-2026</p>
            </div>
        </section>
    </main>

<footer>
    <p>&copy; 2025-2026 StudyFlow - ENSI</p>
    <div>
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
    </div>
</footer>
</body>
</html>
