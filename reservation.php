
<?php 
include 'includes/utils.php';
include 'config/pdo.php';
$destination = $_GET["select"] ?? null;
$info = $destination ? getDestinationInfo($destination) : null;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Si la session est pas demarré
if(!isset($_SESSION)) {
    session_start();
}

if(!(isset($_SESSION['user_id']))) {
    header('Location: login.php');
    exit();
}

if (!$info) {
    echo json_encode(["success" => false, "error" => "Destination non trouvée"]);
    exit();
} else {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["depart"], $_GET["retour"])) {
            $dateArrivee = $_GET["depart"];
            $dateDepart  = $_GET["retour"];

            if (!$dateArrivee || !$dateDepart) {
                echo json_encode(["success" => false, "error" => "Dates invalides"]);
                exit();
            }
            if(!(isset($_SESSION['user_id']))) {
                echo json_encode(["success" => false, "error" => "Utilisateur non connecté"]);
                exit();
            }


            global $pdo;
            $stmt = $pdo->prepare(
                    "INSERT INTO reservation (voyage_id, user_id, nbPersonnes, statut, dateArrivee, dateDepart) 
                VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$info["id"], $_SESSION['user_id'], 1, "Wait", $dateArrivee, $dateDepart]);
            if($stmt->rowCount() > 0) {
                echo json_encode(["success" => true, "reservation" => $info]);
            } else {
                echo json_encode(["success" => false]);
            }
            exit();
        }
    }
}

$prixBase = intval(preg_replace('/[^0-9]/', '', $info["prix"]));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - <?php echo $destination ?></title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/forms.css">
    <link rel="stylesheet" href="styles/reservation.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="styles/footer.css?v=<?php echo time(); ?>">
    <link rel="icon" type="image/png" href="rsc/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="resa-page">
        <div class="resa-container">

            <h1 class="resa-title">Réservation</h1>

            <div class="resa-summary">
                <img src="<?php echo $info["image"] ?>" alt="<?php echo $info["nom"] ?>">
                <div class="resa-summary-info">
                    <h2 id="nomvoy"><?php echo $info["nom"] ?></h2>
                    <p class="resa-meta"><i class="fa-solid fa-wallet"></i> À partir de <?php echo $info["prix"] ?> / pers.</p>
                    <p class="resa-meta"><i class="fa-solid fa-cloud-sun"></i> Meilleure période : <?php echo $info["meilleurPeriode"] ?></p>
                    <p class="resa-meta"><i class="fa-solid fa-bullseye"></i> <?php echo $info["activite"] ?></p>
                </div>
            </div>

            <form id="resaForm" class="resa-form" onsubmit="return false;">

                <div class="resa-section">
                    <h3>Dates du voyage</h3>
                    <div class="resa-dates">
                        <div class="resa-field">
                            <label for="date-depart">Départ</label>
                            <input type="date" id="date-depart" required>
                        </div>
                        <div class="resa-field">
                            <label for="date-retour">Retour</label>
                            <input type="date" id="date-retour" required>
                        </div>
                    </div>
                </div>

                <div class="resa-section">
                    <h3>Voyageurs</h3>
                    <div class="resa-voyageurs">
                        <div class="resa-field">
                            <label for="adultes">Adultes</label>
                            <div class="resa-counter">
                                <button type="button" onclick="changeCount('adultes', -1)">−</button>
                                <input type="number" id="adultes" value="1" min="1" max="10" readonly>
                                <button type="button" onclick="changeCount('adultes', 1)">+</button>
                            </div>
                        </div>
                        <div class="resa-field">
                            <label for="enfants">Enfants</label>
                            <div class="resa-counter">
                                <button type="button" onclick="changeCount('enfants', -1)">−</button>
                                <input type="number" id="enfants" value="0" min="0" max="10" readonly>
                                <button type="button" onclick="changeCount('enfants', 1)">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="errorLabel" id="error"></h2>
                <button type="button" class="resa-pay-btn" onclick="payer()">Ajouter au panier</button>
            </form>

            <div class="resa-confirm" id="resaConfirm" style="display:none;">
                <i class="fa-solid fa-circle-check"></i>
                <h2>Confirmé !</h2>
                <p>Votre voyage à <strong><?php echo $destination ?></strong> est dans votre panier.</p>
                <a class="gotopanier" href="panier.php">Acceder au panier</a>
            </div>
            <div class="resa-confirm" id="resaError" style="display:none;">
                <i class="fa-solid fa-circle-xmark errorIcon"></i>
                <h2>Erreur !</h2>
                <p>Veillez re-esseyer plus tard.</p>
            </div>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script>
        const prixBase = <?php echo $prixBase ?>;

        // La date est minimum Aujourd'ui
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date-depart').min = today;
        document.getElementById('date-retour').min = today;

        document.getElementById('date-depart').addEventListener('change', function() {
            document.getElementById('date-retour').min = this.value;

        });

        function changeCount(id, delta) {
            const input = document.getElementById(id);
            let val = parseInt(input.value) + delta;
            if (val < parseInt(input.min)) val = parseInt(input.min);
            if (val > parseInt(input.max)) val = parseInt(input.max);
            input.value = val;
        }


        function payer() {
            const depart = document.getElementById('date-depart').value;
            const retour = document.getElementById('date-retour').value;
            const nomvoy = document.getElementById("nomvoy").textContent;

            const errorlabel = document.getElementById("error");
            errorlabel.style.display = 'none';

            if (!depart || !retour) {
                errorlabel.textContent = "Veuillez sélectionner les dates de départ et de retour.";
                errorlabel.style.display = 'flex';
                return;
            }
            if (new Date(retour) <= new Date(depart)) {
                errorlabel.textContent = 'La date de retour doit être après la date de départ.';
                errorlabel.style.display = 'flex';
                return;
            }

            document.getElementById('resaForm').style.display = 'none';

            console.log(nomvoy, depart, retour);
            fetch("reservation.php?select=" + nomvoy + "&depart=" + depart + "&retour=" + retour)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log("Réservation OK !");
                        document.getElementById('resaConfirm').style.display = 'flex';
                    } else {
                        console.error("Erreur:", data.error);
                        document.getElementById('resaError').style.display = 'flex';
                    }
                })
                .catch(err => {
                        console.error("Fetch ou JSON error:", err);
                        document.getElementById('resaError').style.display = 'flex';
                });
        }
    </script>
</body>
</html>

