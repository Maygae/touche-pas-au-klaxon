-- ============================================
-- TOUCHE PAS AU KLAXON
-- Création de la base et des tables
-- ============================================

CREATE DATABASE IF NOT EXISTS klaxon
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE klaxon;

-- ============================================
-- Table agences
-- ============================================

CREATE TABLE IF NOT EXISTS agences (
  id_agence INT AUTO_INCREMENT PRIMARY KEY,
  nom       VARCHAR(100) NOT NULL UNIQUE
);

-- ============================================
-- Table users
-- ============================================

CREATE TABLE IF NOT EXISTS users (
  id_user      INT AUTO_INCREMENT PRIMARY KEY,
  nom          VARCHAR(100) NOT NULL,
  prenom       VARCHAR(100) NOT NULL,
  telephone    VARCHAR(20)  NOT NULL,
  email        VARCHAR(255) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  role         ENUM('user', 'admin') NOT NULL DEFAULT 'user'
);

-- ============================================
-- Table trajets
-- ============================================

CREATE TABLE IF NOT EXISTS trajets (
  id_trajet         INT AUTO_INCREMENT PRIMARY KEY,
  id_user           INT NOT NULL,
  id_agence_depart  INT NOT NULL,
  id_agence_arrivee INT NOT NULL,
  date_depart       DATETIME NOT NULL,
  date_arrivee      DATETIME NOT NULL,
  places_totales    INT NOT NULL,
  places_disponibles INT NOT NULL,

  CONSTRAINT fk_trajet_user
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE,

  CONSTRAINT fk_trajet_agence_depart
    FOREIGN KEY (id_agence_depart) REFERENCES agences(id_agence) ON DELETE CASCADE,

  CONSTRAINT fk_trajet_agence_arrivee
    FOREIGN KEY (id_agence_arrivee) REFERENCES agences(id_agence) ON DELETE CASCADE,

  CONSTRAINT chk_agences_differentes
    CHECK (id_agence_depart <> id_agence_arrivee),

  CONSTRAINT chk_places_valides
    CHECK (places_disponibles >= 0 AND places_disponibles <= places_totales),

  CONSTRAINT chk_dates_valides
    CHECK (date_arrivee > date_depart)
);