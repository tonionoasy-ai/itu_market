
<?php
    session_start();
    include_once '../inc/functions.php';

    $id_membre = $_SESSION['id_membre'] ?? null;

    $nom_membre = get_nom_membre($id_membre);

    // $produits = get_produits_en_vente();

    $id_categorie_filtre = $_GET['id_categorie'] ?? null;
    $id_produit_filtre   = $_GET['id_produit'] ?? null;

    $produits = getProduitsFiltres($id_categorie_filtre, $id_produit_filtre);
    $categories  = getAllCategories();
    $tous_produits = get_all_produits();
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
            <span class="navbar-text me-2">
                    <span class="text-info"><i class="bi-person"></i></span>  <b><i><?php echo $nom_membre; ?></i></b>
            </span>
            <a class="navbar-brand" href="accueil.php">ITU Market</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="accueil.php">Accueil</a>
                <a class="nav-link" href="vendre.php">Vendre</a>
                <a class="nav-link" href="mes_ventes.php">Mes ventes</a>
                <a class="nav-link" href="statistiques.php">Statistiques</a>
                <a class="nav-link" href="produit.php">Produits</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Produits en vente</h1>

        <!-- MODIF: tout ce formulaire de filtre (catégorie + produit) est nouveau -->
        <form method="get" class="row g-2 mb-4">
            <div class="col-auto">
                <select name="id_categorie" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?php echo $categorie['id_categorie']; ?>"
                            <?php echo ($id_categorie_filtre == $categorie['id_categorie']) ? 'selected' : ''; ?>>
                            <?php echo $categorie['nom_categorie']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="id_produit" class="form-select" onchange="this.form.submit()">
                    <option value="">Tous les produits</option>
                    <?php foreach ($tous_produits as $p): ?>
                        <option value="<?php echo $p['id_produit']; ?>"
                            <?php echo ($id_produit_filtre == $p['id_produit']) ? 'selected' : ''; ?>>
                            <?php echo $p['nom']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- MODIF: bouton de réinitialisation, affiché seulement si un filtre est actif -->
            <?php if ($id_categorie_filtre || $id_produit_filtre): ?>
            <div class="col-auto">
                <a href="accueil.php" class="btn btn-outline-secondary">Réinitialiser</a>
            </div>
            <?php endif; ?>
        </form>

        <?php if (empty($produits)): ?>
            <p class="text-muted">Aucun produit disponible pour le moment.</p>
        <?php endif; ?>

        <div class="row g-3">
            <?php foreach ($produits as $produit): ?>
                <?php
                    $photo = $produit['image'] ?: $produit['image_defaut'];
                ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">
                        <img src="../assets/images/<?php echo $photo; ?>" class="card-img-top" alt="<?php echo $produit['nom_produit']; ?>" style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <span class="badge bg-secondary mb-2">
                                <?php echo $produit['nom_categorie']; ?>
                            </span>
                            <h5 class="card-title"><?php echo $produit['nom_produit']; ?></h5>
                            <p class="card-text text-muted mb-1">
                                Vendu par <?php echo $produit['nom_vendeur']; ?>
                            </p>
                            <p class="card-text mb-1">
                                <strong><?php echo $produit['prix_vente']; ?> Ar</strong>
                            </p>
                            <p class="card-text text-muted">
                                Quantité disponible : <?php echo $produit['quantite_dispo']; ?>
                            </p>

                            <form action="../inc/traitement_achat.php" method="post" class="row g-2 align-items-center">
                                <input type="hidden" name="id_produit_membre" value="<?php echo $produit['id_produit_membre']; ?>">
                                <div class="col-6">
                                    <input type="number" name="quantite" class="form-control" min="1" max="<?php echo $produit['quantite_dispo']; ?>" value="1" required>
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100">Acheter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>