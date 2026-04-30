<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Agence de Voyage</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/auth.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="icon" type="image/png" href="rsc/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="auth-container">
        <div class="auth-content">
            <div class="auth-form-wrapper">
                <h2>Inscription</h2>

                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = $_POST["email"];
                        $pseudo = trim($_POST["pseudo"]);
                        $password = $_POST["password"];
                        $confirm_password = $_POST["confirm_password"];
                        
                        if (empty($pseudo)) {
                            echo "<p class='error'>Le pseudo est obligatoire.</p>";
                        } elseif ($password !== $confirm_password) {
                            echo "<p class='error'>Les mots de passe ne correspondent pas.</p>";
                        } else {
                            include 'config/pdo.php';
                            
                            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                            $stmt->execute([$email]);
                            if ($stmt->rowCount() > 0) {
                                echo "<p class='error'>Cette adresse email est déjà utilisée.</p>";
                            } else {
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                $stmt = $pdo->prepare("INSERT INTO users (email, pseudo, password, `rank`) VALUES (?, ?, ?, ?)");
                                $stmt->execute([$email, $pseudo, $hashed_password, 'Client']);
                                echo "<p class='success'>Votre compte a été créé avec succès.</p>";
                            }
                        }
                    }
                    ?>

                <p class="auth-subtitle">Créez votre compte pour réserver vos voyages</p>
                
                <form class="auth-form" action="register.php" method="post">
                    <div class="form-group">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" id="pseudo" name="pseudo" placeholder="VoyageurDuMonde" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="votre.email@exemple.fr" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirmer le mot de passe</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="submit-btn">Créer mon compte</button>
                </form>
                
                <div class="auth-footer">
                    <p>Déjà un compte ? <a href="login.php">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
