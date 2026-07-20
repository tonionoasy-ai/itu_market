<?php
session_start();
include_once '../inc/functions.php';

$categories = get_ventes_par_categorie();
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
        <h1 class="mb-4">Statistiques - Ventes par catégorie</h1>

        <?php if (empty($categories)): ?>
            <p class="text-muted">Aucune vente pour le moment.</p>
        <?php else: ?>
            <div class="card">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Montant total des ventes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $categorie): ?>
                            <tr>
                                <td>
                                    <a href="stats_produits.php?id_categorie=<?php echo $categorie['id_categorie']; ?>">
                                        <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($categorie['total']); ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>