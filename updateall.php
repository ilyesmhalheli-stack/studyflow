<?php
session_start();
include 'connect_pdo.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$user_id  = $_SESSION['user_id'];
$user_nom = $_SESSION['user_nom'];
$succes = $erreur = '';
$tache = null;

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM taches WHERE id=:id AND utilisateur_id=:uid");
    $stmt->execute([':id' => intval($_GET['id']), ':uid' => $user_id]);
    $tache = $stmt->fetch();
}

if (isset($_POST['modifier'])) {
    $id    = intval($_POST['id']);
    $titre = $_POST['titre'] ?? '';
    $statut       = $_POST['statut'] ?? '';
    $date_limite  = $_POST['date_limite'] ?? '';

    if (empty($titre) || empty($date_limite)) {
        $erreur = "Champs obligatoires manquants.";
    } else {
        $stmt = $pdo->prepare("UPDATE taches SET titre=:titre, statut=:statut, date_limite=:date_limite WHERE id=:id AND utilisateur_id=:uid");
        $stmt->execute([':titre'=>$titre, ':statut'=>$statut, ':date_limite'=>$date_limite, ':id'=>$id, ':uid'=>$user_id]);
        $succes = "Tâche modifiée !";
        $stmt2 = $pdo->prepare("SELECT * FROM taches WHERE id=:id AND utilisateur_id=:uid");
        $stmt2->execute([':id'=>$id, ':uid'=>$user_id]);
        $tache = $stmt2->fetch();
    }
}

$stmt_list = $pdo->prepare("SELECT id, titre FROM taches WHERE utilisateur_id=?");
$stmt_list->execute([$user_id]);
$liste = $stmt_list->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header><nav><h1>StudyFlow</h1>
<ul>
    <li><a href="index.php">Accueil</a></li>
    <li><a href="tasks.php">Tâches</a></li>
    <li><a href="search.php">Recherche</a></li>
    <li><a href="update.php" class="active">Modification</a></li>
    <li><a href="delete.php">Suppression</a></li>
</ul>
</nav></header>
<main>
    <section class="page-header"><h2>Modification PDO</h2></section>
    <div style="max-width:700px;margin:2rem auto;padding:0 20px;">
        <?php if ($succes): ?><div style="background:#d4edda;color:#155724;padding:1rem;border-radius:6px;margin-bottom:1rem;">✅ <?php echo $succes; ?></div><?php endif; ?>
        <?php if ($erreur): ?><div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:6px;margin-bottom:1rem;">❌ <?php echo $erreur; ?></div><?php endif; ?>

        <?php if ($tache): ?>
        <div style="background:white;padding:2rem;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);margin-bottom:2rem;">
            <h3 style="color:#007bff;margin-bottom:1rem;">Modifier : <?php echo htmlspecialchars($tache['titre']); ?></h3>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $tache['id']; ?>">
                <div class="form-group"><label>Titre *</label><input type="text" name="titre" value="<?php echo htmlspecialchars($tache['titre']); ?>" required></div>
                <div class="form-group"><label>Statut</label>
                    <select name="statut">
                        <option value="en_attente" <?php echo $tache['statut']==='en_attente'?'selected':''; ?>>En attente</option>
                        <option value="en_cours"   <?php echo $tache['statut']==='en_cours'  ?'selected':''; ?>>En cours</option>
                        <option value="termine"    <?php echo $tache['statut']==='termine'   ?'selected':''; ?>>Terminée</option>
                    </select>
                </div>
                <div class="form-group"><label>Date limite *</label><input type="date" name="date_limite" value="<?php echo $tache['date_limite']; ?>" required></div>
                <button type="submit" name="modifier" class="btn">✏️ Modifier</button>
            </form>
        </div>
        <?php endif; ?>

        <div style="background:white;padding:1.5rem;border-radius:8px;box-shadow:0 2px 5px rgba(0,0,0,0.1);">
            <h3 style="color:#007bff;margin-bottom:1rem;">Choisir une tâche</h3>
            <?php foreach ($liste as $t): ?>
                <div style="display:flex;justify-content:space-between;padding:0.7rem;border-bottom:1px solid #f0f0f0;">
                    <span><?php echo htmlspecialchars($t['titre']); ?></span>
                    <a href="update.php?id=<?php echo $t['id']; ?>" style="background:#007bff;color:white;padding:0.3rem 0.8rem;border-radius:4px;text-decoration:none;font-size:0.85rem;">Modifier</a>
                </div>
            <?php endforeach; ?>
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