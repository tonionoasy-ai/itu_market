<?php
session_start();
include_once '../inc/functions.php';

$id_categorie = $_GET['id_categorie'];
$produits = get_ventes_par_produit($id_categorie);
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
                <a class="nav-link" href="vendre.php">Vendre</a>
                <a class="nav-link" href="mes_ventes.php">Mes ventes</a>
                <a class="nav-link active" href="statistiques.php">Statistiques</a>
                <a class="nav-link" href="produit.php">Produits</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <p><a href="statistiques.php"> << Retour aux catégories</a></p>
        <h1 class="mb-4">Ventes par produit</h1>

        <?php if (empty($produits)): ?>
            <p class="text-muted">Aucune vente pour cette catégorie.</p>
        <?php else: ?>
            <div class="card">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Montant total des ventes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $produit): ?>
                            <tr>
                                <td>
                                    <a href="stats_membres.php?id_produit=<?php echo $produit['id_produit']; ?>">
                                        <?php echo htmlspecialchars($produit['nom_produit']); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($produit['total']); ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>