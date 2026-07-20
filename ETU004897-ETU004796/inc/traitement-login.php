<?php
session_start();
include 'functions.php';
$etu = $_POST['ETU'] ?? '';
if ($etu === '') {
    header('Location: index.php?error=1');
    exit();
}
$membre = get_membre_by_etu($etu);
if ($membre) {
    $_SESSION['id_membre'] = $membre['id_membre'];
    header('Location: ../pages/accueil.php');
    exit();
} else {
    header('Location: ../pages/inscription.php?etu=' . urlencode($etu));
    exit();
}