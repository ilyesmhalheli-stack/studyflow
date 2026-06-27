<?php
session_start();
include 'connect_pdo.php'; // ✅ corrigé

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'] ?? null;
$task    = null;

if (!$task_id) {
    header("Location: tasks.php");
    exit();
}

// ✅ SELECT avec PDO prepare()
$stmt = $pdo->prepare("SELECT * FROM taches WHERE id = ? AND utilisateur_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch();

if (!$task) {
    header("Location: tasks.php");
    exit();
}

// ✅ UPDATE avec PDO prepare() nommé
if (isset($_POST['update'])) {
    $titre         = $_POST['titre']        ?? '';
    $description   = $_POST['description']  ?? '';
    $statut        = $_POST['statut']       ?? '';
    $type          = $_POST['type']         ?? '';
    $priorite      = $_POST['priorite']     ?? '';
    $date_limite   = $_POST['date']         ?? '';
    $date_travail  = $_POST['date_travail'] ?? '';
    $heure_travail = $_POST['heure']        ?? '';

    $stmt = $pdo->prepare("UPDATE taches SET 
                            titre        = :titre,
                            description  = :description,
                            statut       = :statut,
                            type         = :type,
                            priorite     = :priorite,
                            date_limite  = :date_limite,
                            date_travail = :date_travail,
                            heure_travail= :heure_travail
                            WHERE id = :id AND utilisateur_id = :user_id");

    $stmt->execute([
        ':titre'         => $titre,
        ':description'   => $description,
        ':statut'        => $statut,
        ':type'          => $type,
        ':priorite'      => $priorite,
        ':date_limite'   => $date_limite,
        ':date_travail'  => $date_travail,
        ':heure_travail' => $heure_travail,
        ':id'            => $task_id,
        ':user_id'       => $user_id,
    ]);

    header("Location: tasks.php?message=update_success");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Tâche - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .update-container { max-width: 600px; margin: 2rem auto; padding: 0 20px; }
        .update-form { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; color: #333; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; font-family: inherit; }
        .form-group textarea { resize: vertical; }
        .form-actions { display: flex; gap: 1rem; margin-top: 2rem; }
        .error-message { background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; }
        .breadcrumb { margin-bottom: 2rem; color: #666; }
        .breadcrumb a { color: #007bff; text-decoration: none; }
        .btn-secondary { background: #6c757d; color: white; padding: 1rem 2rem; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>StudyFlow</h1>
            <ul>
                
                <li><a href="index.php">Accueil</a></li>
                <li><a href="tasks.php">Tâches</a></li>
                <li><a href="search.php">Recherche</a></li>
                <li><a href="update.php" class="active">Modification</a></li>
                <li><a href="delete.php">Suppression</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="update-container">
            <div class="breadcrumb">
                <a href="tasks.php">← Retour aux tâches</a>
            </div>

            <section class="page-header">
                <h2>Modifier la tâche</h2>
                <p>Mettez à jour les informations de votre tâche</p>
            </section>

            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form class="update-form" method="POST">
                <div class="form-group">
                    <label>Titre *</label>
                    <input type="text" name="titre" required
                           value="<?php echo htmlspecialchars($task['titre']); ?>">
                </div>

                <div class="form-group">
                    <label>Type *</label>
                    <select name="type" required>
                        <option value="">Sélectionnez</option>
                        <option value="examen"  <?php echo $task['type'] == 'examen'  ? 'selected' : ''; ?>>Examen</option>
                        <option value="devoir"  <?php echo $task['type'] == 'devoir'  ? 'selected' : ''; ?>>Devoir</option>
                        <option value="projet"  <?php echo $task['type'] == 'projet'  ? 'selected' : ''; ?>>Projet</option>
                        <option value="autre"   <?php echo $task['type'] == 'autre'   ? 'selected' : ''; ?>>Autre</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Statut *</label>
                    <select name="statut" required>
                        <option value="en_attente" <?php echo $task['statut'] == 'en_attente' ? 'selected' : ''; ?>>En attente</option>
                        <option value="en_cours"   <?php echo $task['statut'] == 'en_cours'   ? 'selected' : ''; ?>>En cours</option>
                        <option value="termine"    <?php echo $task['statut'] == 'termine'    ? 'selected' : ''; ?>>Terminé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Priorité *</label>
                    <select name="priorite" required>
                        <option value="haute"   <?php echo $task['priorite'] == 'haute'   ? 'selected' : ''; ?>>Haute</option>
                        <option value="moyenne" <?php echo $task['priorite'] == 'moyenne' ? 'selected' : ''; ?>>Moyenne</option>
                        <option value="basse"   <?php echo $task['priorite'] == 'basse'   ? 'selected' : ''; ?>>Basse</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date limite *</label>
                    <input type="date" name="date" required
                           value="<?php echo $task['date_limite']; ?>">
                </div>

                <div class="form-group">
                    <label>Date de travail *</label>
                    <input type="date" name="date_travail" required
                           value="<?php echo $task['date_travail']; ?>">
                </div>

                <div class="form-group">
                    <label>Heure de travail *</label>
                    <select name="heure" required>
                        <option value="9h-12h"  <?php echo $task['heure_travail'] == '9h-12h'  ? 'selected' : ''; ?>>9h-12h</option>
                        <option value="14h-17h" <?php echo $task['heure_travail'] == '14h-17h' ? 'selected' : ''; ?>>14h-17h</option>
                        <option value="18h-21h" <?php echo $task['heure_travail'] == '18h-21h' ? 'selected' : ''; ?>>18h-21h</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" name="update" class="btn">Mettre à jour</button>
                    <a href="tasks.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>&copy; 2025-2026 StudyFlow - ENSI</p>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" style="color:white; background:#dc3545; padding:0.4rem 1rem; border-radius:4px; text-decoration:none; font-size:0.9rem;">
                    Déconnexion (<?php echo $_SESSION['user_nom']; ?>)
                </a>
            <?php else: ?>
                <a href="login.php" style="color:white; text-decoration:none;">Connexion</a>
            <?php endif; ?>
        </div>
    </footer>
</body>
</html>