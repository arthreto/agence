<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config/pdo.php';

if (isset($_POST['action']) && $_POST['action'] === 'cancel') {
    $reservationId = (int)($_POST['reservation_id'] ?? 0);

    if ($reservationId > 0) {
        $stmt = $pdo->prepare("DELETE FROM reservation WHERE reservation_id = ? AND user_id = ?");
        $stmt->execute([$reservationId, $_SESSION['user_id']]);
    }

    header('Location: panier.php');
    exit();
}

$stmt = $pdo->prepare(
    "SELECT
        reservation.reservation_id,
        reservation.nbPersonnes,
        reservation.statut,
        reservation.dateArrivee,
        reservation.dateDepart,
        voyages.nom,
        voyages.image,
        voyages.prix
    FROM reservation
    INNER JOIN voyages ON voyages.id = reservation.voyage_id
    WHERE reservation.user_id = ?
    ORDER BY reservation.reservation_id DESC"
);
$stmt->execute([$_SESSION['user_id']]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatDateFr($date) {
    return date('d/m/Y', strtotime($date));
}

function formatStatut($statut) {
    if ($statut === 'W' || $statut === 'Wait') {
        return 'En attente';
    }

    return $statut;
}
?>
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

<main class="panier-page">
    <section class="panier-section">
        <h1 class="titlepanier">Mon panier</h1>

        <div class="panier-items">
            <?php foreach ($reservations as $reservation): ?>
                <article class="panier-item">
                    <form method="POST" class="panier-cancel-form" onsubmit="return confirm('Annuler cette réservation ?');">
                        <input type="hidden" name="action" value="cancel">
                        <input type="hidden" name="reservation_id" value="<?= htmlspecialchars($reservation['reservation_id']) ?>">
                        <button type="submit" class="panier-cancel" title="Annuler la réservation" aria-label="Annuler la réservation">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                    <img
                        src="<?= htmlspecialchars($reservation['image']) ?>"
                        alt="<?= htmlspecialchars($reservation['nom']) ?>"
                        class="panier-item-image"
                    >
                    <div class="panier-item-content">
                        <div class="panier-item-header">
                            <h2><?= htmlspecialchars($reservation['nom']) ?></h2>
                            <span class="panier-status"><?= htmlspecialchars(formatStatut($reservation['statut'])) ?></span>
                        </div>
                        <div class="panier-details">
                            <p><i class="fa-solid fa-plane-departure"></i> Départ : <?= htmlspecialchars(formatDateFr($reservation['dateArrivee'])) ?></p>
                            <p><i class="fa-solid fa-plane-arrival"></i> Retour : <?= htmlspecialchars(formatDateFr($reservation['dateDepart'])) ?></p>
                            <p><i class="fa-solid fa-users"></i> Voyageurs : <?= htmlspecialchars($reservation['nbPersonnes']) ?></p>
                        </div>
                        <p class="panier-price">
                            <?= htmlspecialchars((int) $reservation['prix'] * (int) $reservation['nbPersonnes']) ?> €
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="panier-empty" <?php if (!empty($reservations)) echo 'style="display:none;"'; ?>>
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Votre panier est vide</p>
            <a href="destinations.php">Voir les destinations</a>
        </div>
    </section>
</main>


<?php include 'includes/footer.php'; ?>
</body>
</html>
