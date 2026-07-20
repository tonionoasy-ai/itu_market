<?php
include_once 'connection.php';

function get_all_lines($sql){
    //echo $sql;
    $req = mysqli_query(dbconnect(),$sql );
    if (!$req) {
        die('Erreur SQL : ' . mysqli_error(dbconnect()));
    }
    $result = array();
    while ($line = mysqli_fetch_assoc($req)) {
        $result[] = $line;
    }
    mysqli_free_result($req);
    return $result;
}

function get_one_line($sql){

    $req = mysqli_query(dbconnect(),$sql );
    if (!$req) {
        die('Erreur SQL : ' . mysqli_error(dbconnect()));
    }
    $result = mysqli_fetch_assoc($req);
    mysqli_free_result($req);
    return $result;
}

function execute_query($sql)
{
    $req = mysqli_query(dbconnect(), $sql);
    if (!$req) {
        die('Erreur SQL : ' . mysqli_error(dbconnect()));
    }
    return $req;
}

function get_nom_membre($id_membre){
    $sql = "SELECT nom FROM membre WHERE id_membre = '%s'";
    $sql = sprintf($sql, $id_membre);
    $result = get_one_line($sql);
    return $result['nom'] ?? null;
}

function membre(){
    $sql = "SELECT * FROM membre";
    return get_all_lines($sql);
}

function get_membre_by_etu($etu){
    $sql = "SELECT * FROM membre WHERE numero_etu = '%s'";
    $sql = sprintf($sql, $etu);
    return get_one_line($sql);
}

function add_membre($etu, $nom){
    
        $sql = "INSERT INTO membre (nom, numero_etu)
                VALUES ('%s', '%s')";
        $sql = sprintf($sql, $nom, $etu);
    
    execute_query($sql);
    return mysqli_insert_id(dbconnect());
}

function get_produits_en_vente(){
    $sql = "SELECT pm.id_produit_membre,
                   p.nom AS nom_produit,
                   c.nom_categorie,
                   m.nom AS nom_vendeur,
                   pm.prix_vente,
                   pm.quantite_dispo,
                   pm.image,
                   p.image_defaut
            FROM produit_membre pm
            JOIN produit p ON pm.id_produit = p.id_produit
            JOIN categorie c ON p.id_categorie = c.id_categorie
            JOIN membre m ON pm.id_membre = m.id_membre
            WHERE pm.quantite_dispo > 0
            ORDER BY c.nom_categorie, p.nom";
    return get_all_lines($sql);
}

function get_all_produits(){
    $sql = "SELECT id_produit, nom FROM produit ORDER BY nom";
    return get_all_lines($sql);
}

function ajouter_vente_membre($id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo, $image = null){
    if ($image === null) {
        $sql = "INSERT INTO produit_membre (id_produit, id_membre, prix_vente, quantite_dispo, date_dispo)
                VALUES ('%s', '%s', '%s', '%s', '%s')";
        $sql = sprintf($sql, $id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo);
    } else {
        $sql = "INSERT INTO produit_membre (id_produit, id_membre, prix_vente, quantite_dispo, date_dispo, image)
                VALUES ('%s', '%s', '%s', '%s', '%s', '%s')";
        $sql = sprintf($sql, $id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo, $image);
    }
    return execute_query($sql);
}

function get_ventes_membre($id_membre){
    $sql = "SELECT p.nom AS nom_produit,
                   v.date,
                   v.heure,
                   v.quantite,
                   pm.prix_vente,
                   (v.quantite * pm.prix_vente) AS montant
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            JOIN produit p ON pm.id_produit = p.id_produit
            WHERE pm.id_membre = '%s'
            ORDER BY v.date DESC, v.heure DESC";
    $sql = sprintf($sql, $id_membre);
    return get_all_lines($sql);
}

function get_total_ventes_membre($id_membre){
    $sql = "SELECT SUM(v.quantite * pm.prix_vente) AS total
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            WHERE pm.id_membre = '%s'";
    $sql = sprintf($sql, $id_membre);
    $result = get_one_line($sql);
    return $result['total'] ?? 0;
}

function acheter_produit($id_produit_membre, $quantite){
    $sql = "INSERT INTO vente (date, heure, id_produit_membre, quantite)
            VALUES (CURDATE(), CURTIME(), '%s', '%s')";
    $sql = sprintf($sql, $id_produit_membre, $quantite);
    execute_query($sql);

    $sql = "UPDATE produit_membre
            SET quantite_dispo = quantite_dispo - %s
            WHERE id_produit_membre = '%s'";
    $sql = sprintf($sql, $quantite, $id_produit_membre);
    execute_query($sql);
}

// STATISTIQUES niveau 1 : montant total des ventes, regroupé par catégorie
function get_ventes_par_categorie(){
    $sql = "SELECT c.id_categorie,
                   c.nom_categorie,
                   SUM(v.quantite * pm.prix_vente) AS total
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            JOIN produit p ON pm.id_produit = p.id_produit
            JOIN categorie c ON p.id_categorie = c.id_categorie
            GROUP BY c.id_categorie, c.nom_categorie
            ORDER BY total DESC";
    return get_all_lines($sql);
}

// STATISTIQUES niveau 2 : montant total des ventes d'une catégorie, regroupé par produit
function get_ventes_par_produit($id_categorie){
    $sql = "SELECT p.id_produit,
                   p.nom AS nom_produit,
                   SUM(v.quantite * pm.prix_vente) AS total
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            JOIN produit p ON pm.id_produit = p.id_produit
            WHERE p.id_categorie = '%s'
            GROUP BY p.id_produit, p.nom
            ORDER BY total DESC";
    $sql = sprintf($sql, $id_categorie);
    return get_all_lines($sql);
}

// STATISTIQUES niveau 3 : montant total des ventes d'un produit, regroupé par membre vendeur
function get_ventes_par_membre_pour_produit($id_produit){
    $sql = "SELECT m.id_membre,
                   m.nom AS nom_membre,
                   SUM(v.quantite * pm.prix_vente) AS total
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            JOIN membre m ON pm.id_membre = m.id_membre
            WHERE pm.id_produit = '%s'
            GROUP BY m.id_membre, m.nom
            ORDER BY total DESC";
    $sql = sprintf($sql, $id_produit);
    return get_all_lines($sql);
}

// fonction ajouter
function getAllCategories(){
    $sql = "SELECT id_categorie, nom_categorie FROM categorie ORDER BY nom_categorie";
    return get_all_lines($sql);
}

function getProduit($id_produit){
    $sql = "SELECT * FROM produit WHERE id_produit = '%s'";
    $sql = sprintf($sql, $id_produit);
    return get_one_line($sql);
}

function ajouterProduit($nom, $id_categorie, $prix_reference, $perime, $image_defaut){
    $sql = "INSERT INTO produit (nom, id_categorie, prix_reference, perime, image_defaut)
            VALUES ('%s', '%s', '%s', '%s', '%s')";
    $sql = sprintf($sql, $nom, $id_categorie, $prix_reference, $perime, $image_defaut);
    execute_query($sql);
    return mysqli_insert_id(dbconnect());
}

function modifierProduit($id_produit, $nom, $id_categorie, $prix_reference, $perime, $image_defaut){
    if ($image_defaut !== null && $image_defaut !== '') {
        $sql = "UPDATE produit
                SET nom = '%s', id_categorie = '%s', prix_reference = '%s', perime = '%s', image_defaut = '%s'
                WHERE id_produit = '%s'";
        $sql = sprintf($sql, $nom, $id_categorie, $prix_reference, $perime, $image_defaut, $id_produit);
    } else {
        // on garde l'ancienne image si aucune nouvelle n'est envoyée
        $sql = "UPDATE produit
                SET nom = '%s', id_categorie = '%s', prix_reference = '%s', perime = '%s'
                WHERE id_produit = '%s'";
        $sql = sprintf($sql, $nom, $id_categorie, $prix_reference, $perime, $id_produit);
    }
    execute_query($sql);
}
function getProduitsFiltres($id_categorie = null, $id_produit = null){
    $sql = "SELECT pm.id_produit_membre,
                   p.nom AS nom_produit,
                   c.nom_categorie,
                   m.nom AS nom_vendeur,
                   pm.prix_vente,
                   pm.quantite_dispo,
                   pm.image,
                   p.image_defaut
            FROM produit_membre pm
            JOIN produit p ON pm.id_produit = p.id_produit
            JOIN categorie c ON p.id_categorie = c.id_categorie
            JOIN membre m ON pm.id_membre = m.id_membre
            WHERE pm.quantite_dispo > 0";

    if (!empty($id_categorie)) {
        $sql .= sprintf(" AND c.id_categorie = '%s'", $id_categorie);
    }
    if (!empty($id_produit)) {
        $sql .= sprintf(" AND p.id_produit = '%s'", $id_produit);
    }

    $sql .= " ORDER BY c.nom_categorie, p.nom";
    return get_all_lines($sql);
}