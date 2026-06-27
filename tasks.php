<?php include 'insert.php'; ?>  
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâches - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">   
</head>
<body>
    <header>
        <nav>
            <h1>StudyFlow</h1>
            <ul>
                <li ><a href="index.php">Accueil</a></li>
                <li ><a href="dashboard.php">Tableau de bord</a></li>
                <li ><a href="tasks.php" class="active">Tâches</a></li>
                <li ><a href="planning.php">Planning</a></li>
                <li ><a href="about.php">À propos</a></li>
                <li ><a href="questionnaire.php">Questionnaire</a></li>
                <li ><a href="funpage.php">Fun Page</a></li>
                <li ><a href="contact.php">Contact</a></li>
                
            </ul>
        </nav>
    </header>

    <main>


        <section class="tasks-header">
            <h2>Gestion des tâches</h2>
            <p>Ajoutez et suivez vos tâches</p>

        </section>

        <section class="tasks-layout">
            <!-- Formulaire ajout -->
            <div class="form-section">
                <h3>Ajouter une tâche</h3>
                <form action="tasks.php" method="POST" class="task-form">
                    <div class="form-group">
                        <label>Titre</label>
                        <input type="text" name="titre" placeholder="Ex: Réviser pour l'examen" required>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" required>
                            <option value="">Sélectionnez</option>
                            <option value="examen">Examen</option>
                            <option value="devoir">Devoir</option>
                            <option value="projet">Projet</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date limite</label>
                        <input type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Date de travail</label>
                        <input type="date" name="date_travail" required>
                    </div>
                    <div class="form-group">
                        <label>Heure de travail</label>
                        <select name="heure" required>
                            <option value="">Sélectionnez</option>
                            <option value="9h-12h">9h-12h</option>
                            <option value="14h-17h">14h-17h</option>
                            <option value="18h-21h">18h-21h</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Priorité</label>
                        <select name="priority" required>
                            <option value="haute">Haute</option>
                            <option value="moyenne">Moyenne</option>
                            <option value="basse">Basse</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" placeholder="Détails..."></textarea>
                    </div>
                    <button type="submit" name="ajouter" class="btn">Ajouter</button>
                    <button type="reset" class="btn">Effacer</button>
                </form>
            </div>
            <!-- Liste des tâches -->
             <!-- appeler la fonction search.php pour afficher les tâches -->
            <div class="tasks-list-section">
                <h3>Mes tâches (<?php echo $total; ?>)</h3>

                <li class="btn"><a href="search.php" class="active">Recherche</a></li>

                <?php foreach ($taches as $tache): ?>
                <div style="border:1px solid #ddd; border-radius:8px; padding:1rem; margin-bottom:1rem;">
                    <h4><?php echo htmlspecialchars($tache['titre']); ?></h4>
                    <p><?php echo htmlspecialchars($tache['description']); ?></p>
                    <p><strong>Statut :</strong> <?php echo $tache['statut']; ?></p>
                    <p><strong>Date limite :</strong> <?php echo $tache['date_limite']; ?></p>
                    <p><strong>Travail :</strong> <?php echo $tache['date_travail']; ?> à <?php echo $tache['heure_travail']; ?></p>

                    <form method="POST" action="tasks.php">
                        <button type="submit" class="btn" name="terminer_<?php echo $tache['id']; ?>" value="<?php echo $tache['id']; ?>">Terminé</button>
                        <a href="update.php?id=<?php echo $tache['id']; ?>" class="btn" style="text-decoration:none; display:inline-block;">Modifier</a>
                        <button type="submit" class="btn" name="supprimer_<?php echo $tache['id']; ?>" value="<?php echo $tache['id']; ?>" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </div>
                <?php endforeach; ?>
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