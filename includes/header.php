<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="menu-principal">
        <ul>
            <li><a class="home" href="index.php">Accueil</a></li>
            <li><a class="destinations" href="destinations.php">Destinations</a></li>
            <li><a class="contact" href="contact.php">Nous contacter</a></li>

            <?php 
            session_start();
            if (isset($_SESSION['user_id'])) {
                echo '<li class="menu-secondaire"><a class="profile" href="profile.php">Profil</a></li>';
                echo '<li class="menu-secondaire" style="margin-left: 0vw;"><a class="logout" href="header.php?logout=1">Logout</a></li>';
            } else {
                echo '<li class="menu-secondaire"><a class="login" href="login.php">Login</a></li>';
            }
            ?>
        </ul>
    </nav>


</body>
</html>