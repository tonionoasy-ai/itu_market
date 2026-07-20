CREATE DATABASE IF NOT EXISTS itu_market;
USE itu_market;


-- TABLE MEMBRE

CREATE TABLE membre(
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    numero_etu VARCHAR(20) UNIQUE NOT NULL,
    image_profil VARCHAR(255)
);


-- TABLE CATEGORIE

CREATE TABLE categorie(
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(50) NOT NULL
);


-- TABLE PRODUIT

CREATE TABLE produit(
    id_produit INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    id_categorie INT NOT NULL,
    prix_reference DECIMAL(10,2) NOT NULL,
    image_defaut VARCHAR(255) DEFAULT 'uploads/defaut.jpg',
    FOREIGN KEY(id_categorie) REFERENCES categorie(id_categorie)
);


-- TABLE PRODUIT_MEMBRE

CREATE TABLE produit_membre(
    id_produit_membre INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_membre INT NOT NULL,
    prix_vente DECIMAL(10,2) NOT NULL,
    quantite_dispo INT NOT NULL,
    date_dispo DATE NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY(id_produit) REFERENCES produit(id_produit),
    FOREIGN KEY(id_membre) REFERENCES membre(id_membre)
);


-- TABLE VENTE

CREATE TABLE vente(
    id_vente INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    heure TIME NOT NULL,
    id_produit_membre INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY(id_produit_membre) REFERENCES produit_membre(id_produit_membre)
);


-- MEMBRES (10)

INSERT INTO membre(nom, numero_etu, image_profil) VALUES
('Andry','ETU001',NULL),
('Tahina','ETU002',NULL),
('Faniry','ETU003',NULL),
('Miora','ETU004',NULL),
('Aina','ETU005',NULL),
('Feno','ETU006',NULL),
('Hery','ETU007',NULL),
('Nirina','ETU008',NULL),
('Ony','ETU009',NULL),
('Tiana','ETU010',NULL);


-- CATEGORIES

INSERT INTO categorie(nom_categorie) VALUES
('Plat'),
('Boisson'),
('Snack'),
('Dessert');


-- PRODUITS (15)

INSERT INTO produit(nom,id_categorie,prix_reference) VALUES
('Romazava',1,7000),
('Ravitoto',1,8000),
('Akoho sy Rony',1,9000),
('Henakisoa',1,8500),
('Vary amin''anana',1,5000),

('Ranovola',2,1000),
('Jus de tamarin',2,2500),
('Jus de mangue',2,3000),
('Coca-Cola',2,3500),

('Mofo Gasy',3,500),
('Koba',3,1500),
('Sambos',3,1000),

('Bonbon Coco',4,1200),
('Cake chocolat',4,3500),
('Salade de fruits',4,3000);


-- PRODUITS MIS EN VENTE (20)

INSERT INTO produit_membre(id_produit,id_membre,prix_vente,quantite_dispo,date_dispo) VALUES
(1,1,7500,10,'2026-07-20'),
(2,2,8500,8,'2026-07-20'),
(3,3,9500,6,'2026-07-20'),
(4,4,9000,5,'2026-07-20'),
(5,5,5500,12,'2026-07-20'),

(6,6,1200,20,'2026-07-20'),
(7,7,2800,15,'2026-07-20'),
(8,8,3200,10,'2026-07-20'),
(9,9,3800,18,'2026-07-20'),

(10,10,700,30,'2026-07-20'),
(11,1,1800,15,'2026-07-20'),
(12,2,1200,25,'2026-07-20'),

(13,3,1500,20,'2026-07-20'),
(14,4,4000,8,'2026-07-20'),
(15,5,3500,10,'2026-07-20'),

(10,6,650,20,'2026-07-20'),
(6,7,1000,15,'2026-07-20'),
(1,8,7200,5,'2026-07-20'),
(11,9,1700,12,'2026-07-20'),
(15,10,3300,7,'2026-07-20');


ALTER TABLE produit
ADD COLUMN image_defaut VARCHAR(255) DEFAULT NULL;

ALTER TABLE produit_membre
ADD COLUMN image VARCHAR(255) DEFAULT NULL;

UPDATE produit
SET image_defaut = CONCAT(id_produit, '.png');

ALTER TABLE produit ADD COLUMN perime TINYINT(1) NOT NULL DEFAULT 0;