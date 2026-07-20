<?php
session_start();
include_once '../inc/functions.php';

$id_membre_connecte = $_SESSION['id_membre'] ?? null;

$ventes = get_ventes_membre($id_membre_connecte);
$total  = get_total_ventes_membre($id_membre_connecte);
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
                <a class="nav-link active" href="mes_ventes.php">Mes ventes</a>
                <a class="nav-link" href="statistiques.php">Statistiques</a>
                <a class="nav-link" href="produit.php">Produits</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Mes ventes</h1>

        <div class="card p-3 mb-4">
            <span class="text-muted">Montant total des ventes</span>
            <span class="fs-3 fw-bold">
                <?php echo $total; ?> Ar
            </span>
        </div>

        <?php if (empty($ventes)): ?>
            <p class="text-muted">Aucune vente pour le moment.</p>
        <?php else: ?>
            <div class="card">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventes as $vente): ?>
                            <tr>
                                <td><?php echo $vente['date']; ?> à <?php echo $vente['heure']; ?></td>
                                <td><?php echo $vente['nom_produit']; ?></td>
                                <td>x<?php echo $vente['quantite']; ?></td>
                                <td><?php echo $vente['montant']; ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>