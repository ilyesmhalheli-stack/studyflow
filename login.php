<?php
session_start();
include 'connect_pdo.php';

if (isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['user_nom'] = $user['nom'];
        header("Location: index.php");
        exit();
    } else {
        $erreur = "Email ou mot de passe incorrect !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - StudyFlow</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 0 20px;
        }
        .login-box {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .login-box h2 {
            margin-bottom: 0.5rem;
            color: #007bff;
        }
        .login-box p {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95rem;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        .btn-login:hover {
            background: #0056b3;
        }
        .erreur {
            background: #f8d7da;
            color: #721c24;
            padding: 0.7rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .lien-register {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #666;
        }
        .lien-register a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>StudyFlow</h1>
        </nav>
    </header>

    <main>
        <div class="login-container">
            <div class="login-box">
                <h2>Connexion</h2>
                <p>Accédez à vos tâches personnelles</p>

                <?php if (isset($erreur)): ?>
                    <div class="erreur"><?php echo $erreur; ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="votre@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe</label>
                        <input type="password" name="mot_de_passe" placeholder="••••••••" required>
                    </div>
                    <button type="submit" name="login" class="btn-login">Se connecter</button>
                </form>

                <div class="lien-register">
                    Pas de compte ? <a href="register.php">S'inscrire</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025-2026 StudyFlow - ENSI</p>
    </footer>
</body>
</html>