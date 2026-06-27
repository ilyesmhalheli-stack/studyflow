<?php
session_start();
include 'connect_pdo.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id  = $_SESSION['user_id'];
$user_nom = $_SESSION['user_nom'];
 
// ── Ajouter une tâche ─────────────────────────────────────────
if (isset($_POST['ajouter'])) {
    $titre         = $_POST['titre']        ?? '';
    $description   = $_POST['description']  ?? '';
    $statut        = 'en_attente';
    $type          = $_POST['type']         ?? '';
    $priorite      = $_POST['priority']     ?? '';
    $date_limite   = $_POST['date']         ?? '';
    $date_travail  = $_POST['date_travail'] ?? '';
    $heure_travail = $_POST['heure']        ?? '';

 
    // prepare() + execute() avec paramètres NOMMÉS
    $stmt = $pdo->prepare("INSERT INTO taches 
                            (utilisateur_id, titre, description, statut, type, priorite, date_limite, date_travail, heure_travail) 
                            VALUES 
                            (:user_id, :titre, :description, :statut, :type, :priorite, :date_limite, :date_travail, :heure_travail)");
    $stmt->execute([
        ':user_id'       => $user_id,
        ':titre'         => $titre,
        ':description'   => $description,
        ':statut'        => $statut,
        ':type'          => $type,
        ':priorite'      => $priorite,
        ':date_limite'   => $date_limite,
        ':date_travail'  => $date_travail,
        ':heure_travail' => $heure_travail,
    ]);
 
    header("Location: tasks.php?message=ajoute");
    exit();
}
 
// ── Terminer une tâche (UPDATE) ───────────────────────────────
foreach ($_POST as $key => $value) {
    if (str_starts_with($key, 'terminer_')) {
        $id = intval($value);
 
        // prepare() + execute() POSITIONNEL (?)
        $stmt = $pdo->prepare("UPDATE taches SET statut='termine' WHERE id = ? AND utilisateur_id = ?");
        $stmt->execute([$id, $user_id]);
        if (basename($_SERVER['PHP_SELF']) === 'dashboard.php') {
            header("Location: dashboard.php?message=termine");
        } elseif (basename($_SERVER['PHP_SELF']) === 'tasks.php') {
            header("Location: tasks.php?message=termine");
        }
        
        exit();
    }
 
    if (str_starts_with($key, 'supprimer_')) {
        $id = intval($value);
 
        // exec() pour suppression directe
        $pdo->exec("DELETE FROM taches WHERE id = $id AND utilisateur_id = $user_id");
 
        if (basename($_SERVER['PHP_SELF']) === 'dashboard.php') {
            header("Location: dashboard.php?message=supprime");
        } else {
            header("Location: tasks.php?message=supprime");
        }
        exit();
    }
}


$taches = $pdo->prepare("SELECT * FROM taches WHERE utilisateur_id = ? ORDER BY date_creation DESC");
$taches->execute([$user_id]);
$taches = $taches->fetchAll(); // fetchAll() retourne toutes les lignes
 
// Statistiques avec fetch()
$stmt = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id = ?");
$stmt->execute([$user_id]);
$total = $stmt->fetch()['n'];
 
$stmt = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id = ? AND statut = 'en_cours'");
$stmt->execute([$user_id]);
$en_cours = $stmt->fetch()['n'];
 
$stmt = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id = ? AND statut = 'termine'");
$stmt->execute([$user_id]);
$terminees = $stmt->fetch()['n'];
 
$stmt = $pdo->prepare("SELECT COUNT(*) as n FROM taches WHERE utilisateur_id = ? AND statut = 'en_attente'");
$stmt->execute([$user_id]);
$en_attente = $stmt->fetch()['n'];

if (isset($_POST['submit1'])) {
    $prenom     = $_POST['prenom'] ?? '';
    $nom        = $_POST['nom'] ?? '';
    $email      = $_POST['email'] ?? '';
    $sujet      = $_POST['sujet'] ?? '';
    $message    = $_POST['message'] ?? '';
    $priorite   =$_POST['priorite'] ?? '';
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;

    $sql = "INSERT INTO contact
        (prenom, nom, email, sujet, message, priorite, newsletter) 
        VALUES 
        (:prenom, :nom, :email, :sujet, :message, :priorite, :newsletter)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':prenom' => $prenom,
        ':nom' => $nom,
        ':email' => $email,
        ':sujet' => $sujet,
        ':message' => $message,
        ':priorite' => $priorite,
        ':newsletter' => $newsletter
    ]);

    if ($stmt->rowCount() > 0   ) {
        echo "<script>alert('Message envoyé avec succès!'); window.location='contact.php';</script>";
    } else {
        echo "Erreur : " . $conn->error;
    }

    $conn->close();
}

if (isset($_POST['submit'])) {
    $nomComplet      = $_POST['nomComplet']      ?? '';
    $email           = $_POST['email']           ?? '';
    $typeUtilisateur = $_POST['typeUtilisateur'] ?? '';
    $frequence       = $_POST['frequence']       ?? '';
    $commentaires    = $_POST['commentaires']    ?? '';
    $satisfaction    = $_POST['satisfaction']    ?? '';

    $fonctionnalites = isset($_POST['fonctionnalites']) 
                       ? implode(', ', (array)$_POST['fonctionnalites']) 
                       : '';

    $stmt = $pdo->prepare("INSERT INTO questionnaire 
                           (nom_complet, email, vous_etes, frequence, fonctionnalites, commentaires, note_satisfaction) 
                           VALUES (:nom, :email, :type, :frequence, :fonctionnalites, :commentaires, :satisfaction)");
    $stmt->execute([
        ':nom'             => $nomComplet,
        ':email'           => $email,
        ':type'            => $typeUtilisateur,
        ':frequence'       => $frequence,
        ':fonctionnalites' => $fonctionnalites,
        ':commentaires'    => $commentaires,
        ':satisfaction'    => $satisfaction,
    ]);

    echo '<script>alert("Merci ! Vos réponses ont été soumises."); window.location="questionnaire.php";</script>';
}
if (isset($_POST['register'])) {
    $nom      = $_POST['nom'];
    $email    = $_POST['email'];
    $password = $_POST['mot_de_passe'];
    $confirm  = $_POST['confirmer'];

    if ($password !== $confirm) {
        $erreur = "Les mots de passe ne correspondent pas !";
    } elseif (strlen($password) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères !";
    } else {
        $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $check->execute([$email]);
        if ($check->fetchColumn() > 0) {
            $erreur = "Cet email est déjà utilisé !";
        } else {
            // ✅ Gestion de la photo
            $photo = 'default.jpg';
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $nom_fichier = time() . '_' . basename($_FILES['photo']['name']);
                $dossier     = 'uploads/';

                // Créer le dossier s'il n'existe pas
                if (!is_dir($dossier)) {
                    mkdir($dossier, 0755, true);
                }

                // Déplacer le fichier
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $nom_fichier)) {
                    $photo = $nom_fichier;
                }
            }

            $hash = password_hash($password, PASSWORD_DEFAULT);

            // ✅ INSERT avec photo
            $sql = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, photo) VALUES (?, ?, ?, ?)");
            if ($sql->execute([$nom, $email, $hash, $photo])) {
                $succes = "Compte créé avec succès ! Vous pouvez vous connecter.";
            } else {
                $erreur = "Erreur : " . $pdo->errorInfo()[2];
            }
        }
    }
}

?>