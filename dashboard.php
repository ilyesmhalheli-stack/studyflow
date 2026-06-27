<?php
include'insert.php';
include_once 'classe_tache.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$user_nom = $_SESSION['user_nom'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM taches WHERE utilisateur_id = :user_id ORDER BY date_creation DESC");
$stmt->execute([':user_id' => $user_id]);

$taches = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $taches[] = Tache::fromArray($row);
}

$total = count($taches);
$en_cours = 0;
$terminees = 0;
$en_retard = 0;
$compteur =0;
foreach ($taches as $tache) {
    if ($tache->getStatut() === 'en_cours') {
        $en_cours++;
    }
    if ($tache->getStatut() === 'termine') {
        $terminees++;
    }
    if ($tache->estEnRetard()) {
        $en_retard++;
    }
}

function afficherTableauDashboard(array $taches): void
{
    if (empty($taches)) {
        echo '<div class="no-tasks">';
        echo '<h3>Aucune tâche pour le moment</h3>';
        echo '<p>Ajoutez votre première tâche depuis la page des tâches.</p>';
        echo '</div>';
        return;
    }

    echo '<div class="table-container">';
    echo '<table class="tasks-table">';
    echo '<thead><tr>';
    echo '<th>Titre</th>';
    echo '<th>Type</th>';
    echo '<th>Statut</th>';
    echo '<th>Priorité</th>';
    echo '<th>Date limite</th>';
    echo '<th>Travail prévu</th>';
    echo '<th>Actions</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    foreach ($taches as $tache) {
        if ($compteur % 2 === 0) {

        echo '<tr class="task-row" background-color="#ff0000">';

        echo '<td>';
        echo '<div class="task-title-cell">';
        echo '<strong>' . htmlspecialchars($tache->getTitre()) . '</strong>';
        if ($tache->getDescription() !== '') {
            echo '<div class="task-description">' . htmlspecialchars($tache->getDescription()) . '</div>';
        }
        echo '</div>';
        echo '</td>';

        echo '<td><span class="badge type-badge">' . htmlspecialchars($tache->getTypeFormatte()) . '</span></td>';

        echo '<td><span class="badge ' . $tache->getStatutClass() . '">';
        echo htmlspecialchars($tache->getStatutFormatte());
        if ($tache->estEnRetard()) {
            echo ' ⚠️';
        }
        echo '</span></td>';

        echo '<td><span class="badge ' . $tache->getPrioriteClass() . '">';
        echo htmlspecialchars($tache->getPrioriteFormatte());
        echo '</span></td>';

        echo '<td>';
        echo '<div class="date-cell">' . htmlspecialchars($tache->getDateLimiteFormattee());
        if ($tache->estEnRetard()) {
            echo '<br><small class="text-danger">En retard</small>';
        } elseif ($tache->getJoursRestants() <= 3) {
            echo '<br><small class="text-warning">Bientôt</small>';
        }
        echo '</div>';
        echo '</td>';

        echo '<td>';
        echo '<div class="schedule-cell">' . htmlspecialchars($tache->getDateTravailFormattee()) . '<br>';
        echo '<small>' . htmlspecialchars($tache->getHeureTravail()) . '</small>';
        echo '</div>';
        echo '</td>';

        echo '<td>';
        echo '<div class="action-buttons">';
        echo '<a href="update.php?id=' . (int) $tache->getId() . '" class="btn-small btn-edit" title="Modifier">✏️</a>';
        echo '<form method="POST" action="dashboard.php" style="display:inline;">';
        echo '<button type="submit" name="terminer_' . (int) $tache->getId() . '" value="' . (int) $tache->getId() . '" class="btn-small btn-done" title="Terminer">✓</button>';
        echo '</form>';
        echo '<form method="POST" action="dashboard.php" style="display:inline;">';
        echo '<button type="submit" name="supprimer_' . (int) $tache->getId() . '" value="' . (int) $tache->getId() . '" class="btn-small btn-delete" title="Supprimer" onclick="return confirm(\'Supprimer cette tâche ?\')">🗑️</button>';
        echo '</form>';
        echo '</div>';
        echo '</td>';

        echo '</tr>';
    }


    else {
        
        echo '<tr class="task-row" background-color="#1e00ff">';

        echo '<td>';
        echo '<div class="task-title-cell">';
        echo '<strong>' . htmlspecialchars($tache->getTitre()) . '</strong>';
        if ($tache->getDescription() !== '') {
            echo '<div class="task-description">' . htmlspecialchars($tache->getDescription()) . '</div>';
        }
        echo '</div>';
        echo '</td>';

        echo '<td><span class="badge type-badge">' . htmlspecialchars($tache->getTypeFormatte()) . '</span></td>';

        echo '<td><span class="badge ' . $tache->getStatutClass() . '">';
        echo htmlspecialchars($tache->getStatutFormatte());
        if ($tache->estEnRetard()) {
            echo ' ⚠️';
        }
        echo '</span></td>';

        echo '<td><span class="badge ' . $tache->getPrioriteClass() . '">';
        echo htmlspecialchars($tache->getPrioriteFormatte());
        echo '</span></td>';

        echo '<td>';
        echo '<div class="date-cell">' . htmlspecialchars($tache->getDateLimiteFormattee());
        if ($tache->estEnRetard()) {
            echo '<br><small class="text-danger">En retard</small>';
        } elseif ($tache->getJoursRestants() <= 3) {
            echo '<br><small class="text-warning">Bientôt</small>';
        }
        echo '</div>';
        echo '</td>';

        echo '<td>';
        echo '<div class="schedule-cell">' . htmlspecialchars($tache->getDateTravailFormattee()) . '<br>';
        echo '<small>' . htmlspecialchars($tache->getHeureTravail()) . '</small>';
        echo '</div>';
        echo '</td>';

        echo '<td>';
        echo '<div class="action-buttons">';
        echo '<a href="update.php?id=' . (int) $tache->getId() . '" class="btn-small btn-edit" title="Modifier">✏️</a>';
        echo '<form method="POST" action="dashboard.php" style="display:inline;">';
        echo '<button type="submit" name="terminer_' . (int) $tache->getId() . '" value="' . (int) $tache->getId() . '" class="btn-small btn-done" title="Terminer">✓</button>';
        echo '</form>';
        echo '<form method="POST" action="dashboard.php" style="display:inline;">';
        echo '<button type="submit" name="supprimer_' . (int) $tache->getId() . '" value="' . (int) $tache->getId() . '" class="btn-small btn-delete" title="Supprimer" onclick="return confirm(\'Supprimer cette tâche ?\')">🗑️</button>';
        echo '</form>';
        echo '</div>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';

    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-shell {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 20px;
        }

        .dashboard-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.25rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-top: 4px solid #007bff;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.35rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.95rem;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .tasks-table {
            width: 100%;
            border-collapse: collapse;
        }

        .tasks-table th {
            background: linear-gradient(45deg, #0056b3, #003d82);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .tasks-table td {
            padding: 1rem;
            border-bottom: 1px solid #eef1f5;
            vertical-align: top;
        }

        .task-row:hover {
            background: #f8f9fa;
        }

        .task-title-cell strong {
            display: block;
            margin-bottom: 0.25rem;
            color: #0056b3;
        }

        .task-description {
            color: #666;
            font-size: 0.9rem;
        }

        .badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .type-badge {
            background: #e9ecef;
            color: #495057;
        }

        .priority-haute { background: #f8d7da; color: #721c24; }
        .priority-moyenne { background: #fff3cd; color: #856404; }
        .priority-basse { background: #d4edda; color: #155724; }
        .statut-en_attente { background: #fff3cd; color: #856404; }
        .statut-en_cours { background: #cce5ff; color: #004085; }
        .statut-termine { background: #d4edda; color: #155724; }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-small {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .btn-small:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-edit { background: #ffc107; color: #000; }
        .btn-done { background: #28a745; color: white; }
        .btn-delete { background: #dc3545; color: white; }

        .no-tasks {
            background: white;
            border-radius: 10px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .date-cell, .schedule-cell {
            font-size: 0.95rem;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-warning {
            color: #d39e00;
        }

        @media (max-width: 900px) {
            .tasks-table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>StudyFlow</h1>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="dashboard.php" class="active">Tableau de bord</a></li>
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
        <section class="page-header dashboard-page-header">
            <h2>Tableau de bord</h2>
            <p>Vue tableau de vos tâches</p>
        </section>

        <section class="dashboard-shell">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number" style="color:#0056b3;"> <?php echo $total; ?> </div>
                    <div class="stat-label">Total des tâches</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#004085;"> <?php echo $en_cours; ?> </div>
                    <div class="stat-label">En cours</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#155724;"> <?php echo $terminees; ?> </div>
                    <div class="stat-label">Terminées</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color:#dc3545;"> <?php echo $en_retard; ?> </div>
                    <div class="stat-label">En retard</div>
                </div>
            </div>

            <div class="dashboard-actions">
                <a href="tasks.php" class="btn">Vue normale</a>
                <a href="planning.php" class="btn">Planning</a>
                <a href="search.php" class="btn">Recherche</a>
            </div>

            <?php afficherTableauDashboard($taches); ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025-2026 StudyFlow - ENSI</p>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" style="color:white; background:#dc3545; padding:0.4rem 1rem; border-radius:4px; text-decoration:none;">
                    Déconnexion (<?php echo htmlspecialchars($user_nom); ?>)
                </a>
            <?php else: ?>
                <a href="login.php" style="color:white; text-decoration:none;">Connexion</a>
            <?php endif; ?>
        </div>
    </footer>
</body>
</html>