CREATE DATABASE IF NOT EXISTS websitebd
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
 
USE websitebd;
 
CREATE TABLE IF NOT EXISTS utilisateurs (
    id          INT UNSIGNED     NOT NULL AUTO_INCREMENT,
    nom         VARCHAR(100)     NOT NULL,
    email       VARCHAR(150)     NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255)   NOT NULL,
    photo       VARCHAR(255)     NOT NULL DEFAULT 'default.jpg',
    date_inscription DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
CREATE TABLE IF NOT EXISTS taches (
    id              INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    utilisateur_id  INT UNSIGNED    NOT NULL,
    titre           VARCHAR(200)    NOT NULL,
    description     TEXT,
    statut          ENUM('en_attente','en_cours','termine') NOT NULL DEFAULT 'en_attente',
    type            ENUM('examen','devoir','projet','autre') NOT NULL DEFAULT 'autre',
    priorite        ENUM('haute','moyenne','basse')          NOT NULL DEFAULT 'moyenne',
    date_limite     DATE,
    date_travail    DATE,
    heure_travail   VARCHAR(20),
    date_creation   DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
CREATE TABLE IF NOT EXISTS contact (
    id          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    prenom      VARCHAR(100)    NOT NULL,
    nom         VARCHAR(100)    NOT NULL,
    email       VARCHAR(150)    NOT NULL,
    sujet       ENUM('suggestion','bug','question','autre') NOT NULL DEFAULT 'autre',
    message     TEXT            NOT NULL,
    priorite    ENUM('basse','moyenne','haute')             NOT NULL DEFAULT 'basse',
    newsletter  TINYINT(1)      NOT NULL DEFAULT 0,
    date_envoi  DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
CREATE TABLE IF NOT EXISTS questionnaire (
    id               INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom_complet      VARCHAR(150) NOT NULL,
    email            VARCHAR(150) NOT NULL,
    vous_etes        ENUM('etudiant','enseignant','autre') NOT NULL DEFAULT 'etudiant',
    frequence        ENUM('quotidien','hebdomadaire','mensuel','rare','premiere') NOT NULL DEFAULT 'rare',
    fonctionnalites  VARCHAR(255),
    commentaires     TEXT,
    note_satisfaction TINYINT UNSIGNED,
    date_soumission  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
