<?php
session_start();
include 'connect_pdo.php';

// Si pas connecté → rediriger vers login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyFlow</title>
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
                <li><a href="contact.php">Contact</a></li>
                

            </ul>
        </nav>
    </header>

    <main>
        <div style="position:fixed; top:85px; right:20px; width:300px; z-index:9999;">
            <video id="video" src="video.webm" controls muted style="width:100%; border-radius:8px; box-shadow: 0 4px 10px rgba(0,0,0,0.3);"></video>
            <audio id="audio" src="audio.webm" hidden loop></audio>
        </div>

        <section class="hero">
            <h2>Gérez vos délais académiques</h2>
            <p>StudyFlow aide les étudiants à organiser leurs tâches et délais</p>
            <a href="dashboard.php" class="btn">Commencer</a>
        </section>

        <section class="features">
            <h3>Fonctionnalités</h3>
            <div class="feature-grid">
                <div class="feature">
                    <h4><a href="tasks.php" >Ajouter des tâches </a></h4>
                    <p>Gérez vos examens et devoirs</p>
                </div>
                <div class="feature">
                    <h4><a href="planning.php" >planning  </a></h4>
                    <p>Voyez votre semaine d'un coup</p>
                </div>
                <div class="feature">
                    <h4><a href="dashboard.php" >Alertes  </a></h4>
                    <p>Ne manquez aucun délai</p>
                </div>
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

    <script>
    const video = document.getElementById("video");
    const audio = document.getElementById("audio");

    video.addEventListener("play", () => {
        audio.currentTime = video.currentTime;
        audio.play().catch(() => {});
    });

    video.addEventListener("pause", () => {
        audio.pause();
    });

    video.addEventListener("seeked", () => {
        audio.currentTime = video.currentTime;
    });
    </script>

</body>

</html>