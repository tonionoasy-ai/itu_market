<?php
session_start();
include_once '../inc/functions.php';

$id_membre_connecte = $_SESSION['id_membre'] ?? null;

$message = '';

if (isset($_POST['btn_vendre'])) {
    $id_produit     = $_POST['id_produit'];
    $prix_vente     = $_POST['prix_vente'];
    $quantite_dispo = $_POST['quantite_dispo'];
    $date_dispo     = $_POST['date_dispo'];

    $image = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['photo'];
        $maxSize = 10 * 1024 * 1024; // 10 Mo
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $uploadDir = '../assets/images/';

        // Vérifie l'erreur d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            die('Erreur lors de l\'upload : ' . $file['error']);
        }

        // Vérifie la taille
        if ($file['size'] > $maxSize) {
            die('Erreur : Le fichier est trop volumineux.');
        }

        // Vérifie le type MIME avec finfo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedMimeTypes)) {
            die('Type de fichier non autorisé : ' . $mime);
        }

        // Assure que le dossier existe avec les bons droits
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $nom_fichier = uniqid() . '_' . basename($file['name']);
        
        // Déplace le fichier vers le dossier physique
        if (!move_uploaded_file($file['tmp_name'], $uploadDir . $nom_fichier)) {
            die('Erreur : Impossible de télécharger le fichier.');
        }

        // On n'enregistre QUE le nom unique dans la variable de la base
        $image = $nom_fichier;
    }

    ajouter_vente_membre($id_produit, $id_membre_connecte, $prix_vente, $quantite_dispo, $date_dispo, $image);

    $message = "Produit mis en vente avec succès !";
}

$produits = get_all_produits();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="../bootstrap/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="accueil.php">ITU Market</a>
            <div class="navbar-nav">
                <a class="nav-link" href="accueil.php">Accueil</a>
                <a class="nav-link active" href="vendre.php">Vendre</a>
                <a class="nav-link" href="mes_ventes.php">Mes ventes</a>
                <a class="nav-link" href="statistiques.php">Statistiques</a>
                <a class="nav-link" href="produit.php">Produits</a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 700px;">
        <h1 class="mb-4">Mettre un produit en vente</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" class="card p-4" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Produit</label>
                <select name="id_produit" class="form-select" required>
                    <?php foreach ($produits as $produit): ?>
                        <option value="<?php echo $produit['id_produit']; ?>">
                            <?php echo htmlspecialchars($produit['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Photo du plat (facultatif)</label>
                <input type="file" name="photo" class="form-control" accept="image/*">
                <div class="form-text">Si vous ne mettez pas de photo, la photo par défaut du produit sera utilisée.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix de vente (Ar)</label>
                <input type="number" name="prix_vente" class="form-control" min="0" value="1000" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Quantité disponible</label>
                <input type="number" name="quantite_dispo" class="form-control" min="1" value="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date de disponibilité</label>
                <input type="date" name="date_dispo" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <button type="submit" name="btn_vendre" class="btn btn-primary w-100">Mettre en vente</button>
        </form>
    </div>

</body>
</html>