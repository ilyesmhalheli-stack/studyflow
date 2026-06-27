<?php
session_start();
include 'connect_pdo.php';

if (isset($_POST['register'])) {
    $nom      = $_POST['nom'];
    $email    = $_POST['email'];
    $password = $_POST['mot_de_passe'];
    $confirm  = $_POST['confirmer'];

    if ($password !== $confirm) {
        $erreur = "Les mots de passe ne correspondent pas !";
    } elseif (strlen($password) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères !";
    }elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== 0) {
        $erreur = "Veuillez sélectionner une photo de profil !";
    
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .register-container { max-width: 420px; margin: 60px auto; padding: 0 20px; }
        .register-box { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .register-box h2 { margin-bottom: 0.5rem; color: #007bff; }
        .register-box p { color: #666; font-size: 0.9rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.4rem; font-weight: 500; font-size: 0.9rem; color: #333; }
        .form-group input { width: 100%; padding: 0.7rem 1rem; border: 1px solid #ddd; border-radius: 6px; font-size: 0.95rem; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #007bff; }
        .btn-register { width: 100%; padding: 0.8rem; background: #007bff; color: white; border: none; border-radius: 6px; font-size: 1rem; cursor: pointer; margin-top: 0.5rem; }
        .btn-register:hover { background: #0056b3; }
        .erreur { background: #f8d7da; color: #721c24; padding: 0.7rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem; }
        .succes { background: #d4edda; color: #155724; padding: 0.7rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem; }
        .lien-login { text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #666; }
        .lien-login a { color: #007bff; text-decoration: none; }
        .password-hint { font-size: 0.8rem; color: #999; margin-top: 0.3rem; }
        .photo-preview { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-top: 0.5rem; display: none; border: 3px solid #007bff; }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>StudyFlow</h1>
        </nav>
    </header>

    <main>
        <div class="register-container">
            <div class="register-box">
                <h2>Inscription</h2>
                <p>Créez votre compte pour gérer vos tâches</p>

                <?php if (isset($erreur)): ?>
                    <div class="erreur"><?php echo $erreur; ?></div>
                <?php endif; ?>

                <?php if (isset($succes)): ?>
                    <div class="succes">
                        <?php echo $succes; ?>
                        <br><a href="login.php" style="color:#155724;font-weight:500">Se connecter maintenant</a>
                    </div>
                <?php endif; ?>

                <form method="POST" action="register.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" name="nom" placeholder="Ahmed Ben Ali" required
                               value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="votre@email.com" required
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="mot_de_passe" placeholder="••••••••" required>
                        <p class="password-hint">Minimum 6 caractères</p>
                    </div>
                    <div class="form-group">
                        <label>Confirmer le mot de passe</label>
                        <input type="password" name="confirmer" placeholder="••••••••" required>
                    </div>

                    <?php /* ✅ ajout photo de profil */ ?>
                    <div class="form-group">
                        <label>Photo de profil (optionnel)</label>
                        <input type="file" name="photo" accept="image/*"
                               onchange="previewPhoto(this)">
                        <img id="photoPreview" class="photo-preview" src="#" alt="Aperçu">
                    </div>

                    <button type="submit" name="register" class="btn-register">Créer mon compte</button>
                </form>

                <div class="lien-login">
                    Déjà un compte ? <a href="login.php">Se connecter</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025-2026 StudyFlow - ENSI</p>
    </footer>

    <script>
    // ✅ Aperçu de la photo avant upload
    function previewPhoto(input) {
        const preview = document.getElementById('photoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</body>
</html>