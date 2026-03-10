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
    <link rel="stylesheet" href="styles/destination.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="icon" type="image/png" href="icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="destination-container">
        <div class="destination-hero">
            <img class="destination-banner" src="<?php echo $info["image"] ?>" alt="<?php echo $destination ?>">
            <div class="hero-overlay">
                <h1 class="destination-title"><?php echo $destination ?></h1>
                <div class="destination-rating">
                    <?php 
                    $note = $info["note"];
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= floor($note)) {
                            echo "⭐";
                        } elseif ($i - $note < 1) {
                            echo "⭐";
                        }
                    }
                    ?>
                    <span class="rating-number"><?php echo $note ?>/5</span>
                </div>
            </div>
        </div>
        
        <div class="destination-content">
            <div class="destination-main">
                <div class="info-card">
                    <h2>À propos de cette destination</h2>
                    <p class="destination-description"><?php echo $info["description"] ?></p>
                </div>
                
                <div class="info-card">
                    <h2>Points d'intérêt</h2>
                    <ul class="points-list">
                        <?php foreach ($info["points_interet"] as $point): ?>
                            <li>📍 <?php echo $point ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            
            <div class="destination-sidebar">
                <div class="booking-card">
                    <h3>Informations pratiques</h3>
                    
                    <div class="info-row">
                        <span class="info-icon">💰</span>
                        <div class="info-text">
                            <span class="info-label">À partir de</span>
                            <span class="info-value"><?php echo $info["prix"] ?></span>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-icon">⏱️</span>
                        <div class="info-text">
                            <span class="info-label">Durée recommandée</span>
                            <span class="info-value"><?php echo $info["duree"] ?></span>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-icon">🌤️</span>
                        <div class="info-text">
                            <span class="info-label">Meilleure période</span>
                            <span class="info-value"><?php echo $info["periode"] ?></span>
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-icon">🎯</span>
                        <div class="info-text">
                            <span class="info-label">Activités</span>
                            <span class="info-value"><?php echo $info["activites"] ?></span>
                        </div>
                    </div>
                    
                    <a href="contact.php" class="book-btn">Réserver maintenant</a>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>