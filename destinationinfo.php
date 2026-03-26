<!DOCTYPE html>
<html lang="en">
<?php 
include 'includes/utils.php'; 
$destination = $_GET["select"] ?? "Destination";
$info = getDestinationInfo($destination);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $destination ?> - Agence de Voyage</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/destination.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/footer.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" href="icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="destination-container">
        <div class="destination-hero">
            <img class="destination-banner" src="<?php echo $info["image"] ?>" alt="<?php echo $info["nom"] ?>">
            <div class="hero-overlay">
                <h1 class="destination-title"><?php echo $info["nom"] ?></h1>

            </div>
        </div>
        
        <div class="destination-content">
            <div class="destination-main">
                <div class="info-card">
                    <h2>À propos de cette destination</h2>
                    <p class="destination-description"><?php echo $info["description"] ?></p>
                </div>
            </div>
            
            <div class="destination-sidebar">
                <div class="booking-card">
                    <h3>Informations pratiques</h3>
                    
                    <div class="info-row">
                        <span class="info-icon"><i class="fa-solid fa-wallet" aria-hidden="true"></i></span>
                        <div class="info-text">
                            <span class="info-label">À partir de</span>
                            <span class="info-value"><?php echo $info["prix"] ?></span>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-icon"><i class="fa-solid fa-cloud-sun" aria-hidden="true"></i></span>
                        <div class="info-text">
                            <span class="info-label">Meilleure période</span>
                            <span class="info-value"><?php echo $info["meilleurPeriode"] ?></span>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-icon"><i class="fa-solid fa-bullseye" aria-hidden="true"></i></span>
                        <div class="info-text">
                            <span class="info-label">Activités</span>
                            <span class="info-value"><?php echo $info["activite"] ?></span>
                        </div>
                    </div>
                    
                    <a href="reservation.php?select=<?php echo urlencode($info["nom"]) ?>" class="book-btn">Réserver maintenant</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>