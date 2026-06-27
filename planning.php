<?php
// planning.php 
session_start();
include 'connect_pdo.php';
include_once 'classe_tache.php';

function getDayName($date) {
    return date('l', strtotime($date));
}


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];



$lundi = strtotime('monday this week');
$taches     = $pdo->prepare("SELECT * FROM taches WHERE utilisateur_id = :user_id ORDER BY date_creation DESC");
$taches->execute([':user_id' => $user_id]);
$total      = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id=:user_id");
$total->execute([':user_id' => $user_id]);
$total = $total->fetch(PDO::FETCH_ASSOC)['n'];
$en_cours   = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id=:user_id AND statut='en_cours'");
$en_cours->execute([':user_id' => $user_id]);
$en_cours = $en_cours->fetch(PDO::FETCH_ASSOC)['n'];
$terminees  = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id=:user_id AND statut='termine'");
$terminees->execute([':user_id' => $user_id]);
$terminees = $terminees->fetch(PDO::FETCH_ASSOC)['n'];
$en_attente = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id=:user_id AND statut='en_attente'");
$en_attente->execute([':user_id' => $user_id]);
$en_attente = $en_attente->fetch(PDO::FETCH_ASSOC)['n'];
function get_taches($date, $heure) {
    global $pdo, $user_id;

    $stmt = $pdo->prepare("SELECT titre FROM taches 
                           WHERE utilisateur_id = :user_id 
                           AND date_travail = :date 
                           AND heure_travail = :heure");
    $stmt->execute([
        ':user_id' => $user_id,
        ':date'    => $date,
        ':heure'   => $heure
    ]);

    $rows   = $stmt->fetchAll();
    $taches = [];
    foreach ($rows as $row) {
        $taches[] = $row['titre'];
    }
    return implode("<br>", $taches);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning - StudyFlow</title>
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
                <li><a href="planning.php" class="active">Planning</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="questionnaire.php">Questionnaire</a></li>
                <li><a href="funpage.php">Fun Page</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="page-header planning-header">
            <h2>Planning hebdomadaire</h2>
            <p>Vos tâches de la semaine</p>
        </section>

        <section style="max-width: 1200px; margin: 0 auto; padding: 2rem 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
                <button class="btn">&lt; Semaine précédente</button>
                <h3 style="color: #007bff; margin: 0;"><?php echo date("d M Y"); ?></h3>
                <button class="btn">Semaine suivante &gt;</button>
            </div>

            <!-- Tableau avec fusions de cellules -->
            <table class="calendar-table" style="width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <thead>
                    <tr style="background: #007bff; color: white;">
                        <th style="padding: 1rem; border: 1px solid #ddd;"><?php echo getDayName(date("Y-m-d")); ?></th>
                        <th style="padding: 1rem; border: 1px solid #ddd;"><?php echo getDayName(date("d M Y", strtotime("+1 days"))); ?></th>
                        <th style="padding: 1rem; border: 1px solid #ddd;"><?php echo getDayName(date("d M Y", strtotime("+2 days"))); ?></th>
                        <th style="padding: 1rem; border: 1px solid #ddd;"><?php echo getDayName(date("d M Y", strtotime("+3 days"))); ?></th>
                        <th style="padding: 1rem; border: 1px solid #ddd;"><?php echo getDayName(date("d M Y", strtotime("+4 days"))); ?></th>
                        <th style="padding: 1rem; border: 1px solid #ddd;"><?php echo getDayName(date("d M Y", strtotime("+5 days"))); ?></th>
                        <th style="padding: 1rem; border: 1px solid #ddd;"> <?php echo getDayName(date("Y-m-d", strtotime("+6 days"))); ?>
                           
                            
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <!-- Matin -->
                    <tr>
                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d"); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">9h-12h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d"), "9h-12h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d", strtotime("+1 days")); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">9h-12h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+1 days")), "9h-12h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d", strtotime("+2 days")); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">9h-12h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+2 days")), "9h-12h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d", strtotime("+3 days")); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">9h-12h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+3 days")), "9h-12h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d", strtotime("+4 days")); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">9h-12h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+4 days")), "9h-12h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d", strtotime("+5 days")); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">9h-12h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+5 days")), "9h-12h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d", strtotime("+6 days")); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">9h-12h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+6 days")), "9h-12h"); ?></div>
                        </td>
                    </tr>

                    <!-- Après-midi -->
                    <tr>
                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo date("m-d"); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">14h-17h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d"), "14h-17h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+1 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">14h-17h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+1 days")), "14h-17h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+2 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">14h-17h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+2 days")), "14h-17h"); ?></div>
                        </td>

                        <td class="split-cell" rowspan="2" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top; background: #e3f2fd;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+3 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">14h-21h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+3 days")), "14h-21h"); ?></div>
                        </td>

                        <td class="split-cell" colspan="2" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top; background: #fff3cd;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+4 days"))); ?>/<?php echo (date("m-d", strtotime("+5 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">14h-17h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+4 days")), "14h-17h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+6 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">14h-17h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+6 days")), "14h-17h"); ?></div>
                        </td>
                    </tr>

                    <!-- Soir -->
                    <tr>
                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d")); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">18h-21h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d"), "18h-21h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+1 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">18h-21h</div>
                            <div class="cell-content"><?php echo get_taches(date("Y-m-d", strtotime("+1 days")), "18h-21h"); ?></div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+2 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">18h-21h</div>
                            <div class="cell-content">
                                <?php echo get_taches(date("Y-m-d", strtotime("+2 days")), "18h-21h"); ?>
                            </div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+4 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">18h-21h</div>
                            <div class="cell-content">
                            <?php
                                // Affiche les tâches du jour +4 à 18h-21h
                                echo get_taches(date("Y-m-d", strtotime("+4 days")), "18h-21h");    

?>
                            </div>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+5 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">18h-21h</div>
                            <div class="cell-content">
                            <?php
                                // Affiche les tâches du jour +5 à 18h-21h
                                echo get_taches(date("Y-m-d", strtotime("+5 days")), "18h-21h");    
?>
                        </td>

                        <td class="split-cell" style="padding: 1rem; border: 1px solid #ddd; vertical-align: top;">
                            <div class="cell-date" style="font-weight: bold; color: #007bff;"><?php echo (date("m-d", strtotime("+6 days"))); ?></div>
                            <div class="cell-hours" style="color: #666; font-size: 0.9rem;">18h-21h</div>
                            <div class="cell-content">
                                <?php echo get_taches(date("Y-m-d", strtotime("+6 days")), "18h-21h"); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Légende simple -->
            <div style="background: white; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;">
                <h4 style="color: #007bff; margin-bottom: 1rem;">Légende</h4>
                <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                    <div>🔴 Urgent</div>
                    <div>🟡 Important</div>
                    <div>🟢 Normal</div>
                </div>
            </div>

            <!-- Statistiques simples -->
            <div style="background: white; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;">
                <h4 style="color: #007bff; margin-bottom: 1rem;">Cette semaine</h4>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: #007bff;"><?php echo $total?></div>
                        <div>Tâches totales</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: #dc3545;"><?php echo $en_cours?></div>
                        <div>En cours</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: #ffc107;"><?php echo $terminees?></div>
                        <div>Terminées</div>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #f8f9fa; border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: bold; color: #28a745;"><?php echo $en_attente?></div>
                        <div>En attente</div>
                    </div>
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
            <a href="logout.php" style="
                color: white;
                text-decoration: none;
            ">Déconnexion</a>
        <?php endif; ?>
    </div>
</footer>
</body>
</html>
