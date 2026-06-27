<?php
session_start();
include 'connect_pdo.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$user_id  = $_SESSION['user_id'];
$user_nom = $_SESSION['user_nom'];
$succes = $erreur = '';

if (isset($_POST['supprimer'])) {
    $id = intval($_POST['id']);
    $stmt = $pdo->prepare("SELECT id FROM taches WHERE id=:id AND utilisateur_id=:uid");
    $stmt->execute([':id'=>$id, ':uid'=>$user_id]);
    if ($stmt->fetch()) {
        $stmt2 = $pdo->prepare("DELETE FROM taches WHERE id=:id AND utilisateur_id=:uid");
        $stmt2->execute([':id'=>$id, ':uid'=>$user_id]);
        $succes = "Tâche supprimée !";
    } else {
        $erreur = "Tâche introuvable.";
    }
}

$stmt_list = $pdo->prepare("SELECT * FROM taches WHERE utilisateur_id=? ORDER BY date_creation DESC");
$stmt_list->execute([$user_id]);
$liste = $stmt_list->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Suppression - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header><nav><h1>StudyFlow</h1>
<ul>
    <li><a href="index.php">Accueil</a></li>
    <li><a href="tasks.php">Tâches</a></li>
    <li><a href="search.php">Recherche</a></li>
    <li><a href="update.php">Modification</a></li>
    <li><a href="delete.php" class="active">Suppression</a></li>
</ul>
</nav></header>
<main>
    <section class="page-header"><h2>Suppression PDO</h2></section>
    <div style="max-width:800px;margin:2rem auto;padding:0 20px;">
        <?php if ($succes): ?><div style="background:#d4edda;color:#155724;padding:1rem;border-radius:6px;margin-bottom:1rem;">✅ <?php echo $succes; ?></div><?php endif; ?>
        <?php if ($erreur): ?><div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:6px;margin-bottom:1rem;">❌ <?php echo $erreur; ?></div><?php endif; ?>

        <div style="background:white;padding:1.5rem;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            <h3 style="color:#dc3545;margin-bottom:1rem;">🗑️ Mes tâches (<?php echo count($liste); ?>)</h3>
            <?php if (empty($liste)): ?>
                <p style="text-align:center;color:#999;padding:2rem;">Aucune tâche.</p>
            <?php else: ?>
                <?php foreach ($liste as $t): ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:0.8rem;border-bottom:1px solid #f0f0f0;">
                        <div>
                            <strong><?php echo htmlspecialchars($t['titre']); ?></strong>
                            <br><small style="color:#666;"><?php echo $t['statut']; ?> | <?php echo $t['date_limite']; ?></small>
                        </div>
                        <form method="POST" onsubmit="return confirm('Supprimer ?')">
                            <input type="hidden" name="id" value="<?php echo $t['id']; ?>">
                            <button type="submit" name="supprimer" style="background:#dc3545;color:white;border:none;padding:0.4rem 1rem;border-radius:4px;cursor:pointer;">🗑️ Supprimer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>
<footer>
    <p>&copy; 2025-2026 StudyFlow - ENSI</p>
    <div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" style="color:white;background:#dc3545;padding:0.4rem 1rem;border-radius:4px;text-decoration:none;">
                Déconnexion (<?php echo $user_nom; ?>)
            </a>
        <?php endif; ?>
    </div>
</footer>
</body>
</html>