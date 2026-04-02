<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/footer.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" href="rsc/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/utils.php'; ?>
    <h1 class="titre">Agence de voyage</h1>

    <?php if (isset($_SESSION['email'])): ?>
        <div class="welcome-container">
            <p class="inpresentation" style="text-align: center; font-weight: bold; font-size: 1.2em; padding-bottom: 30px;">
                Bienvenue, <?php echo htmlspecialchars(explode('@', $_SESSION['email'])[0]); ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="presentation">
        <p class="inpresentation">Bienvenue sur notre site d'agence de voyage ! Nous sommes ravis de vous aider à planifier votre prochaine aventure. Que vous rêviez de plages paradisiaques, de montagnes majestueuses ou de villes animées, nous avons des offres pour tous les goûts et tous les budgets. Explorez nos destinations, découvrez nos forfaits exclusifs et laissez-nous vous accompagner dans la création de souvenirs inoubliables. Votre voyage commence ici !</p>
    </div>

    <h1 class="titre">Voyages en tendances</h1>
    <div class="tendances">
        <?php 
        $allDestination = getAllDestinations(); 
        foreach ($allDestination as $info) {
            echo '<div class="city"><a href="destinationinfo.php?select=' . $info["nom"] . '"><img src="' . $info["image"] . '" alt="' . $info["nom"] . '"><h2 class="nom">' . $info["nom"] . '</h2></a></div>';
        } ?>
    </div>   
    <?php include 'includes/footer.php'; ?>
</body>
</html>