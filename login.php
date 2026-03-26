<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Agence de Voyage</title>
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
                <h2>Connexion</h2>

                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        
                        include 'config/pdo.php';

                        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
                        $stmt->execute([$email]);
                        if ($stmt->rowCount() == 0) {
                            echo "<p class='error'>Aucun compte trouvé avec cette adresse email.</p>";
                        } else {
                            $user = $stmt->fetch();
                            if (password_verify($password, $user['password'])) {
                                $stmt = $pdo->prepare("UPDATE FROM users token=:token WHERE user_id=:user_id");
                                $GenerateToken = bin2hex(random_bytes(32));
                                $stmt->bindParam(':token', $GenerateToken, PDO::PARAM_STR);
                                $stmt->execute();

                                session_start();
                                $_SESSION['token'] = $GenerateToken;
                                $_SESSION['email'] = $user['email'];
                                header("Location: index.php");
                                exit();
                            } else {
                                echo "<p class='error'>Mot de passe incorrect.</p>";
                            }
                        }
                    }
                    ?>

                <p class="auth-subtitle">Accédez à votre compte</p>
                
                
                <form class="auth-form" action="login.php" method="post">
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="votre.email@exemple.fr" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" class="submit-btn">Se connecter</button>
                </form>
                
                <div class="auth-footer">
                    <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>
