<?php
session_start();
include_once 'functions.php';

// On récupère les infos envoyées par le formulaire d'accueil.php
$id_produit_membre = $_POST['id_produit_membre'];
$quantite           = $_POST['quantite'];

// On enregistre l'achat (insertion dans vente + diminution de la quantité dispo)
acheter_produit($id_produit_membre, $quantite);

// On revient sur la page d'accueil pour voir la quantité mise à jour
header('Location: ../pages/accueil.php');
exit;