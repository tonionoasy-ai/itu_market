# Tâches — ITU Market

## Version 1

## itu_market.sql
    - Création de la base de données (ETU004796)
        -> tables
            - membre
            - categorie
            - produit
            - produit_membre
            - vente
    - Insertion des données de test (ETU4897)
        - 10 membres
        - 4 catégories
        - 15 produits
        - 20 produits à vendre

## pages/index.php
    - affichage (ETU4897)
        - css
        - bootstrap
        - html
    - base
        - itu_market
            -> tables
                - membre
    - function
        - get_membre_by_etu
    - code dynamique
        - formulaire de connexion par numéro ETU

## pages/inscription.php
    - affichage (ETU4897)
        - css
        - bootstrap
        - html
    - base
        - itu_market
            -> tables
                - membre
    - function
        - add_membre
    - code dynamique
        - formulaire nom (+ image facultative) affiché si ETU inconnu

## inc/traitement-login.php
    - code dynamique (ETU4897)
        - appel fonction get_membre_by_etu
        - redirection vers accueil.php ou inscription.php

## inc/traitement-inscription.php
    - code dynamique (ETU4897)
        - appel fonction add_membre
        - redirection vers accueil.php

## pages/accueil.php
    - affichage (ETU4897)
        - css
        - bootstrap
        - html
    - base
        - itu_market
            -> tables
                - produit_membre
                - produit
                - membre
    - function
        - getAllProduitsAVendre
    - code dynamique
        - appel fonction getAllProduitsAVendre
        - bouton "acheter" + champ quantité sur chaque produit

## pages/vendre.php
    - affichage (ETU004796)
        - css
        - bootstrap
        - html
    - base
        - itu_market
            -> tables
                - produit
                - produit_membre
    - function
        - getAllProduits
        - ajouterProduitAVendre
    - code dynamique
        - appel fonction getAllProduits
        - appel fonction ajouterProduitAVendre

## pages/mes_ventes.php
    - affichage (ETU004796)
        - css
        - bootstrap
        - html
    - base
        - itu_market
            -> tables
                - vente
                - produit_membre
                - produit
    - function
        - getMontantTotalVentes
    - code dynamique
        - appel fonction getMontantTotalVentes

## inc/functions.php
    - dbconnect
    - get_all_lines
    - get_one_line
    - execute_query
    - get_membre_by_etu
    - add_membre
    - getAllProduitsAVendre
    - getAllProduits
    - ajouterProduitAVendre
    - getMontantTotalVentes
