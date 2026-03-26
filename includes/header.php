<?php
if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header("Location: index.php");
    exit();
}?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav class="menu-principal">
        <ul>
            <li><a class="home" href="index.php">Accueil</a></li>
            <li><a class="destinations" href="destinations.php">Destinations</a></li>
            <li><a class="contact" href="contact.php">Nous contacter</a></li>

            <?php
            if(!isset($_SESSION)) {
                session_start();
            }
            if (isset($_SESSION['user_id'])) {

                echo '<li class="menu-secondaire"><a class="logout" href="index.php?logout=1">Logout</a></li>';
                echo '<li class="menu-secondaire" style="margin-left: 0px;"><a class="cart" href="panier.php" title="Mon panier"><span>Panier</span></a></li>';
            } else {
                echo '<li class="menu-secondaire"><a class="login" href="login.php">Login</a></li>';
            }
            ?>
        </ul>
    </nav>


</body>
</html>
