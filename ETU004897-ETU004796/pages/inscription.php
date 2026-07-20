<!-- inscription.php -->
<?php
include_once '../inc/functions.php';

$etu = $_GET['etu'] ?? '';
if ($etu === '') {
    header('Location: index.php');
    exit();
}
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

<h1 class="h4 mb-3">Nouveau membre</h1>
<p class="text-muted">Numéro ETU <strong><?= htmlspecialchars($etu) ?></strong> introuvable, complète ton profil pour t'inscrire.</p>

<hr />

<form action="../inc/traitement-inscription.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="ETU" value="<?= htmlspecialchars($etu) ?>" />
<div class="mb-3">
<label for="nom" class="form-label">Nom</label>
<input type="text" class="form-control" id="nom" name="nom" required />
</div>
<div class="mb-3">
<label for="image_profil" class="form-label">Photo de profil (facultatif)</label>
<input type="file" class="form-control" id="image_profil" name="image_profil" accept="image/*" />
</div>
<button type="submit" class="btn btn-primary w-100">S'inscrire</button>
</form>

</div>
</div>
<script src="../assist/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>