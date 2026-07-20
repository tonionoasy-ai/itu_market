
<?php
include_once '../inc/functions.php';
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
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-4">

            <h1 class="h4 text-center mb-3">Se connecter à ITU Market</h1>

            <hr />

            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="alert alert-warning" role="alert">
                Numéro ETU inconnu, veuillez d'abord vous inscrire ci-dessous.
            </div>
            <?php endif; ?>

            <form action="../inc/traitement-login.php" method="POST">
                <div class="mb-3">
                    <label for="ETU" class="form-label">ETU</label>
                    <input type="text" class="form-control" id="ETU" name="ETU" placeholder="ETU00xxxx" value="ETU001" required />
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>

        </div>
    </div>

</body>
</html>