<?php
session_start();
include_once '../inc/functions.php';

$id_produit = $_GET['id_produit'] ?? null;
$produit    = $id_produit ? getProduit($id_produit) : null;
$categories = getAllCategories();
$message    = '';

if (isset($_POST['btn_enregistrer'])) {
    $nom            = $_POST['nom'];
    $id_categorie   = $_POST['id_categorie'];
    $prix_reference = $_POST['prix_reference'];
    $perime         = isset($_POST['perime']) ? 1 : 0;

    // Upload de l'image par défaut (facultatif)
    $image_defaut = null;
    if (isset($_FILES['image_defaut']) && $_FILES['image_defaut']['error'] === UPLOAD_ERR_OK) {
        $nom_fichier = uniqid() . '_' . basename($_FILES['image_defaut']['name']);
        move_uploaded_file($_FILES['image_defaut']['tmp_name'], '../assets/uploads/' . $nom_fichier);
        $image_defaut = $nom_fichier;
    }

    if ($id_produit) {
        modifierProduit($id_produit, $nom, $id_categorie, $prix_reference, $perime, $image_defaut);
        $message = "Produit modifié avec succès !";
        $produit = getProduit($id_produit); // on recharge les données à jour
    } else {
        $nouvel_id  = ajouterProduit($nom, $id_categorie, $prix_reference, $perime, $image_defaut);
        $message    = "Produit ajouté avec succès !";
        $id_produit = $nouvel_id;
        $produit    = getProduit($id_produit);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="accueil.php">ITU Market</a>
            <div class="navbar-nav">
                <a class="nav-link" href="accueil.php">Accueil</a>
                <a class="nav-link" href="vendre.php">Vendre</a>
                <a class="nav-link" href="mes_ventes.php">Mes ventes</a>
                <a class="nav-link active" href="produit.php">Produits</a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 500px;">
        <h1 class="mb-4"><?php echo $id_produit ? 'Modifier le produit' : 'Ajouter un produit'; ?></h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="card p-4">

            <div class="mb-3">
                <label class="form-label">Nom du produit</label>
                <input type="text" name="nom" class="form-control"
                       value="<?php echo $produit['nom'] ?? ''; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="id_categorie" class="form-select" required>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?php echo $categorie['id_categorie']; ?>"
                            <?php echo (isset($produit['id_categorie']) && $produit['id_categorie'] == $categorie['id_categorie']) ? 'selected' : ''; ?>>
                            <?php echo $categorie['nom_categorie']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix de référence (Ar)</label>
                <input type="number" name="prix_reference" class="form-control" min="0"
                       value="<?php echo $produit['prix_reference'] ?? '1000'; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Photo par défaut (facultatif)</label>
                <input type="file" name="image_defaut" class="form-control" accept="image/*">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="perime" class="form-check-input" id="perime"
                    <?php echo (!empty($produit['perime'])) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="perime">Produit périmé</label>
            </div>

            <button type="submit" name="btn_enregistrer" class="btn btn-primary w-100">
                <?php echo $id_produit ? 'Enregistrer les modifications' : 'Ajouter le produit'; ?>
            </button>
        </form>

        <h2 class="h5 mt-4 mb-3">Produits existants</h2>
        <div class="list-group">
            <?php foreach (get_all_produits() as $p): ?>
                <a href="produit.php?id_produit=<?php echo $p['id_produit']; ?>"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <?php echo $p['nom']; ?>
                    <?php if (!empty($p['perime'])): ?>
                        <span class="badge bg-danger">périmé</span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>