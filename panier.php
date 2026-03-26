<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon panier</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/panier.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="icon" type="image/png" href="rsc/icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
<?php include 'includes/header.php'; ?>
<?php include 'includes/utils.php'; ?>

<main class="panier-page">
    <section class="panier-section">
        <h1 class="titlepanier">Mon panier</h1>

        <div class="panier-items">

        </div>

        <div class="panier-empty">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Votre panier est vide</p>
            <a href="destinations.php">Voir les destinations</a>
        </div>
    </section>
</main>


<?php include 'includes/footer.php'; ?>
</body>
</html>