<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
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
    <h1 class="titre">Destinations</h1>

    <h1 class="titre">Voyages en tendances</h1>
    <div class="tendances">
        <?php 
        $allDestination = getAllDestinations(); 
        foreach ($allDestination as $destination) { 
            $info = getDestinationInfo($destination); 
            echo '<div class="city"><a href="destinationinfo.php?select=' . $destination . '"><img src="' . $info["image"] . '" alt="' . $destination . '"><h2 class="nom">' . $destination . '</h2></a></div>'; 
        } ?>
    </div>  
    <?php include 'includes/footer.php'; ?>
</body>
</html>