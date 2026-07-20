<?php
session_start();
include_once '../inc/functions.php';

$id_produit = $_GET['id_produit'];
$membres = get_ventes_par_membre_pour_produit($id_produit);
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
        <p><a href="javascript:history.back()"> << Retour aux produits</a></p>
        <h1 class="mb-4">Ventes par membre</h1>

        <?php if (empty($membres)): ?>
            <p class="text-muted">Aucune vente pour ce produit.</p>
        <?php else: ?>
            <div class="card">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Membre (vendeur)</th>
                            <th>Montant total des ventes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($membres as $membre): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($membre['nom_membre']); ?></td>
                                <td><?php echo htmlspecialchars($membre['total']); ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>