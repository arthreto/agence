<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - Agence de Voyage</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/auth.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/compte.css?v=<?php echo time(); ?>">
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
                <h2>Mon Compte</h2>
                <div class="compte-info">
                    <div class="compte-avatar">
                        <i class="fa-solid fa-circle-user"></i>
                    </div>

                    <div class="compte-details">

                        <div class="compte-field">
                            <span class="compte-label">Email</span>
                            <span class="compte-value"><?= htmlspecialchars($_SESSION['email']) ?></span>
                        </div>

                        <div class="compte-field">
                            <span class="compte-label">Grade</span>
                            <span class="compte-badge <?= strtolower($_SESSION['rank']) ?>">
                                <?php if ($_SESSION['rank'] === 'Admin'): ?>
                                    <i class="fa-solid fa-shield-halved"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-user"></i>
                                <?php endif; ?>
                                <?= htmlspecialchars($_SESSION['rank']) ?>
                            </span>
                        </div>
                    </div>
                </div>

                <?php if ($_SESSION['rank'] === 'Admin'): ?>
                <div class="auth-footer" style="margin-top: 25px;">
                    <a href="panel.php" class="submit-btn" id="gotopanel">
                        <i class="fa-solid fa-shield-halved"></i> Accéder au Panel Admin
                    </a>
                </div>
                <?php endif; ?>

                <div class="auth-footer">
                    <p><a href="index.php?logout=1">Se déconnecter</a></p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

