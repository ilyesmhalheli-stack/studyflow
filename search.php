<?php
session_start();
include 'connect_pdo.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$user_id = $_SESSION['user_id'];
$user_nom = $_SESSION['user_nom'];
$objetsTaches = [];
$nb = 0;
$recherche = '';
$statut_filtre = '';
$search_performed = false;
$results = [];

if (isset($_POST['search'])) {
    $search_performed = true;

    $titre = trim($_POST['titre'] ?? '');
    $statut_filtre = $_POST['statut'] ?? ''; 
    $type_filtre = $_POST['type'] ?? '';
    $priorite_filtre = $_POST['priorite'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';

    $sql = "SELECT * FROM taches WHERE utilisateur_id = ?";
    $params = [$user_id];

    if ($titre !== '') {
        $sql .= " AND titre LIKE ?";
        $params[] = "%$titre%";
    }

    if ($statut_filtre !== '') {
        $sql .= " AND statut = ?";
        $params[] = $statut_filtre;
    }

    if ($type_filtre !== '') {
        $sql .= " AND type = ?";
        $params[] = $type_filtre;
    }

    if ($priorite_filtre !== '') {
        $sql .= " AND priorite = ?";
        $params[] = $priorite_filtre;
    }

    if ($date_debut !== '') {
        $sql .= " AND date_limite >= ?";
        $params[] = $date_debut;
    }

    if ($date_fin !== '') {
        $sql .= " AND date_limite <= ?";
        $params[] = $date_fin;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .search-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        
        .search-form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            margin-bottom: 0.5rem;
            font-weight: bold;
            color: #333;
        }
        
        .form-group input,
        .form-group select {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }
        
        .results-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .task-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: box-shadow 0.3s;
        }
        
        .task-card:hover {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .task-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }
        
        .task-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }
        
        .task-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 0.5rem;
        }
        
        .meta-item {
            background: #f8f9fa;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.9rem;
        }
        
        .priority-haute { background: #f8d7da; color: #721c24; }
        .priority-moyenne { background: #fff3cd; color: #856404; }
        .priority-basse { background: #d4edda; color: #155724; }
        
        .statut-en_attente { background: #fff3cd; color: #856404; }
        .statut-en_cours { background: #cce5ff; color: #004085; }
        .statut-termine { background: #d4edda; color: #155724; }
        
        .no-results {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .search-stats {
            background: #e3f2fd;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>StudyFlow</h1>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="tasks.php">Tâches</a></li>
                <li><a href="search.php" class="active">Recherche</a></li>
                <li><a href="updateall.php">Modification</a></li>
</li>
                <li><a href="delete.php">Suppression</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="page-header">
            <h2>Recherche de tâches</h2>
            <p>Recherchez vos tâches selon différents critères</p>
        </section>

        <div class="search-container">
            <form class="search-form" method="POST">
                <h3 style="margin-bottom: 1.5rem; color: #007bff;">Critères de recherche</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="titre">Titre (contient)</label>
                        <input type="text" id="titre" name="titre" placeholder="Mot-clé dans le titre..." 
                               value="<?php echo isset($_POST['titre']) ? htmlspecialchars($_POST['titre']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut">
                            <option value="">Tous les statuts</option>
                            <option value="en_attente" <?php echo (isset($_POST['statut']) && $_POST['statut'] == 'en_attente') ? 'selected' : ''; ?>>En attente</option>
                            <option value="en_cours" <?php echo (isset($_POST['statut']) && $_POST['statut'] == 'en_cours') ? 'selected' : ''; ?>>En cours</option>
                            <option value="termine" <?php echo (isset($_POST['statut']) && $_POST['statut'] == 'termine') ? 'selected' : ''; ?>>Terminé</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type">
                            <option value="">Tous les types</option>
                            <option value="examen" <?php echo (isset($_POST['type']) && $_POST['type'] == 'examen') ? 'selected' : ''; ?>>Examen</option>
                            <option value="devoir" <?php echo (isset($_POST['type']) && $_POST['type'] == 'devoir') ? 'selected' : ''; ?>>Devoir</option>
                            <option value="projet" <?php echo (isset($_POST['type']) && $_POST['type'] == 'projet') ? 'selected' : ''; ?>>Projet</option>
                            <option value="autre" <?php echo (isset($_POST['type']) && $_POST['type'] == 'autre') ? 'selected' : ''; ?>>Autre</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="priorite">Priorité</label>
                        <select id="priorite" name="priorite">
                            <option value="">Toutes les priorités</option>
                            <option value="haute" <?php echo (isset($_POST['priorite']) && $_POST['priorite'] == 'haute') ? 'selected' : ''; ?>>Haute</option>
                            <option value="moyenne" <?php echo (isset($_POST['priorite']) && $_POST['priorite'] == 'moyenne') ? 'selected' : ''; ?>>Moyenne</option>
                            <option value="basse" <?php echo (isset($_POST['priorite']) && $_POST['priorite'] == 'basse') ? 'selected' : ''; ?>>Basse</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="date_debut">Date limite début</label>
                        <input type="date" id="date_debut" name="date_debut" 
                               value="<?php echo isset($_POST['date_debut']) ? htmlspecialchars($_POST['date_debut']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="date_fin">Date limite fin</label>
                        <input type="date" id="date_fin" name="date_fin" 
                               value="<?php echo isset($_POST['date_fin']) ? htmlspecialchars($_POST['date_fin']) : ''; ?>">
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" name="search" class="btn">Rechercher</button>
                    <button type="reset" class="btn btn-secondary">Effacer</button>
                </div>
            </form>

            <?php if ($search_performed): ?>
                <div class="results-section">
                    <h3 style="margin-bottom: 1rem; color: #007bff;">Résultats de recherche</h3>
                    
                    <?php if (!empty($results)): ?>
                        <div class="search-stats">
                            <strong><?php echo count($results); ?></strong> tâche(s) trouvée(s)
                        </div>
                        
                        <?php foreach ($results as $task): ?>
                            <div class="task-card">
                                <div class="task-header">
                                    <div class="task-title"><?php echo htmlspecialchars($task['titre']); ?></div>
                                </div>
                                
                                <div class="task-meta">
                                    <span class="meta-item statut-<?php echo $task['statut']; ?>">
                                        <?php echo ucfirst($task['statut']); ?>
                                    </span>
                                    <span class="meta-item priority-<?php echo $task['priorite']; ?>">
                                        Priorité: <?php echo ucfirst($task['priorite']); ?>
                                    </span>
                                    <span class="meta-item">
                                        Type: <?php echo ucfirst($task['type']); ?>
                                    </span>
                                </div>
                                
                                <?php if (!empty($task['description'])): ?>
                                    <p style="margin-bottom: 1rem; color: #666;">
                                        <?php echo htmlspecialchars($task['description']); ?>
                                    </p>
                                <?php endif; ?>
                                
                                <div class="task-meta">
                                    <span class="meta-item">
                                        📅 Limite: <?php echo date('d/m/Y', strtotime($task['date_limite'])); ?>
                                    </span>
                                    <span class="meta-item">
                                        🕐 Travail: <?php echo date('d/m/Y', strtotime($task['date_travail'])); ?> à <?php echo $task['heure_travail']; ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                    <?php else: ?>
                        <div class="no-results">
                            <h4>😔 Aucune tâche trouvée</h4>
                            <p>Essayez d'élargir vos critères de recherche</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
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