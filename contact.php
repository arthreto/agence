<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Agence de Voyage</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/contact.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="icon" type="image/png" href="icon.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="contact-container">
        <div class="contact-content">
            <div class="contact-form-wrapper">
                <h2>Envoyez-nous un message</h2>
                <form class="contact-form" action="contact.php" method="post">
                    <div class="form-group">
                        <label for="name">Nom complet</label>
                        <input type="text" id="name" name="name" placeholder="Jean Dupont" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Adresse email</label>
                        <input type="email" id="email" name="email" placeholder="jean.dupont@exemple.fr" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <input type="text" id="subject" name="subject" placeholder="Demande d'information" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Votre message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Décrivez votre projet de voyage..." required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Envoyer le message</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>