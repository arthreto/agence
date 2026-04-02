<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rank'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

include 'config/pdo.php';

$message = '';
$messageType = '';

/* ── ACTIONS CRUD ───────────────────────────────────────── */

// SUPPRIMER
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = (int) $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM voyages WHERE id = ?");
    $stmt->execute([$id]);
    $message = 'Destination supprimée avec succès.';
    $messageType = 'success';
}

// AJOUTER
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom          = trim($_POST['nom']);
    $description  = trim($_POST['description']);
    $image        = trim($_POST['image']);
    $prix         = (int) $_POST['prix'];
    $periode      = trim($_POST['meilleurPeriode']);
    $activite     = trim($_POST['activite']);

    if ($nom && $description && $image && $periode && $activite) {
        $stmt = $pdo->prepare("INSERT INTO voyages (nom, description, image, prix, meilleurPeriode, activite) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$nom, $description, $image, $prix, $periode, $activite]);
        $message = 'Destination ajoutée avec succès.';
        $messageType = 'success';
    } else {
        $message = 'Veuillez remplir tous les champs obligatoires.';
        $messageType = 'error';
    }
}

// MODIFIER
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id           = (int) $_POST['id'];
    $nom          = trim($_POST['nom']);
    $description  = trim($_POST['description']);
    $image        = trim($_POST['image']);
    $prix         = (int) $_POST['prix'];
    $periode      = trim($_POST['meilleurPeriode']);
    $activite     = trim($_POST['activite']);

    if ($id && $nom && $description && $image && $periode && $activite) {
        $stmt = $pdo->prepare("UPDATE voyages SET nom=?, description=?, image=?, prix=?, meilleurPeriode=?, activite=? WHERE id=?");
        $stmt->execute([$nom, $description, $image, $prix, $periode, $activite, $id]);
        $message = 'Destination modifiée avec succès.';
        $messageType = 'success';
    } else {
        $message = 'Veuillez remplir tous les champs obligatoires.';
        $messageType = 'error';
    }
}

/* ── RÉCUPÉRER TOUTES LES DESTINATIONS ──────────────────── */
$stmt = $pdo->query("SELECT * FROM voyages ORDER BY id ASC");
$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Agence de Voyage</title>
    <link rel="stylesheet" href="styles/base.css">
    <link rel="stylesheet" href="styles/navigation.css">
    <link rel="stylesheet" href="styles/components.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/panel.css">
    <link rel="icon" type="image/png" href="rsc/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="panel-container">

        <!-- En-tête panel -->
        <div class="panel-header">
            <div class="panel-title">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <h1>Panel Admin</h1>
                </div>
            </div>
            <button class="btn-add" onclick="openModal()">
                <i class="fa-solid fa-plus"></i> Ajouter une destination
            </button>
        </div>

        <!-- Message de retour -->
        <?php if ($message): ?>
            <div class="panel-alert <?= $messageType ?>">
                <i class="fa-solid <?= $messageType === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation' ?>"></i>
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Tableau des destinations -->
        <div class="panel-card">
            <div class="panel-card-header">
                <h2><i class="fa-solid fa-map-location-dot"></i> Destinations (<?= count($destinations) ?>)</h2>
            </div>

            <?php if (empty($destinations)): ?>
                <div class="panel-empty">
                    <i class="fa-solid fa-map"></i>
                    <p>Aucune destination pour l'instant.</p>
                </div>
            <?php else: ?>
            <div class="panel-table-wrapper">
                <table class="panel-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Meilleure période</th>
                            <th>Activités</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($destinations as $dest): ?>
                        <tr>
                            <td class="td-id"><?= $dest['id'] ?></td>
                            <td class="td-img">
                                <img src="<?= htmlspecialchars($dest['image']) ?>" alt="<?= htmlspecialchars($dest['nom']) ?>" onerror="this.src='rsc/icon.png'">
                            </td>
                            <td class="td-nom"><strong><?= htmlspecialchars($dest['nom']) ?></strong></td>
                            <td class="td-desc"><?= htmlspecialchars($dest['description']) ?></td>
                            <td class="td-prix"><?= $dest['prix'] > 0 ? $dest['prix'] . ' €' : '<span class="gratuit">Gratuit</span>' ?></td>
                            <td><?= htmlspecialchars($dest['meilleurPeriode']) ?></td>
                            <td class="td-activite"><?= htmlspecialchars($dest['activite']) ?></td>
                            <td class="td-actions">
                                <button class="btn-edit" onclick='openEditModal(<?= json_encode($dest) ?>)'>
                                    <i class="fa-solid fa-pen"></i> Modifier
                                </button>
                                <form method="POST" onsubmit="return confirm('Supprimer cette destination ?');" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $dest['id'] ?>">
                                    <button type="submit" class="btn-delete">
                                        <i class="fa-solid fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── MODAL AJOUTER / MODIFIER ──────────────────────── -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal()"></div>

    <div class="modal" id="modal">
        <div class="modal-header">
            <h3 id="modalTitle"><i class="fa-solid fa-plus"></i> Ajouter une destination</h3>
            <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <form method="POST" id="modalForm">
            <input type="hidden" name="action" id="formAction" value="add">
            <input type="hidden" name="id" id="formId" value="">

            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nom <span class="required">*</span></label>
                        <input type="text" name="nom" id="fieldNom" placeholder="Ex: Paris" required>
                    </div>
                    <div class="form-group">
                        <label>Prix (€)</label>
                        <input type="number" name="prix" id="fieldPrix" placeholder="0" min="0" value="0">
                    </div>
                </div>
                <div class="form-group">
                    <label>Description <span class="required">*</span></label>
                    <textarea name="description" id="fieldDescription" placeholder="Décrivez cette destination..." rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Chemin de l'image <span class="required">*</span></label>
                    <input type="text" name="image" id="fieldImage" placeholder="rsc/monimage.jpg" required>
                </div>
                <div class="form-group">
                    <label>Meilleure période <span class="required">*</span></label>
                    <input type="text" name="meilleurPeriode" id="fieldPeriode" placeholder="Ex: Juin - Septembre" required>
                </div>
                <div class="form-group">
                    <label>Activités <span class="required">*</span></label>
                    <input type="text" name="activite" id="fieldActivite" placeholder="Ex: Randonnée - Plongée - Cuisine" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal()">Annuler</button>
                <button type="submit" class="btn-save" id="btnSave">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        function openModal() {
            document.getElementById('formAction').value = 'add';
            document.getElementById('formId').value = '';
            document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-plus"></i> Ajouter une destination';
            document.getElementById('btnSave').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Ajouter';
            document.getElementById('fieldNom').value = '';
            document.getElementById('fieldPrix').value = '0';
            document.getElementById('fieldDescription').value = '';
            document.getElementById('fieldImage').value = '';
            document.getElementById('fieldPeriode').value = '';
            document.getElementById('fieldActivite').value = '';
            document.getElementById('modal').classList.add('open');
            document.getElementById('modalOverlay').classList.add('open');
        }

        function openEditModal(dest) {
            document.getElementById('formAction').value = 'edit';
            document.getElementById('formId').value = dest.id;
            document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-pen"></i> Modifier une destination';
            document.getElementById('btnSave').innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Enregistrer';
            document.getElementById('fieldNom').value = dest.nom;
            document.getElementById('fieldPrix').value = dest.prix;
            document.getElementById('fieldDescription').value = dest.description;
            document.getElementById('fieldImage').value = dest.image;
            document.getElementById('fieldPeriode').value = dest.meilleurPeriode;
            document.getElementById('fieldActivite').value = dest.activite;
            document.getElementById('modal').classList.add('open');
            document.getElementById('modalOverlay').classList.add('open');
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('open');
            document.getElementById('modalOverlay').classList.remove('open');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</body>
</html>

