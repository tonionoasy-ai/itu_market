<?php
// traitement-inscription.php
session_start();
include 'functions.php';

$etu = trim($_POST['ETU'] ?? '');
$nom = trim($_POST['nom'] ?? '');

if ($etu === '' || $nom === '') {
    header('Location: inscritpion.php?error=1');
    exit();
}
$id_membre = add_membre($etu, $nom);
$_SESSION['id_membre'] = $id_membre;
$_SESSION['nom'] = $nom;

header('Location: ../pages/accueil.php');
exit();