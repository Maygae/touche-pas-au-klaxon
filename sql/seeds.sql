-- ============================================
-- TOUCHE PAS AU KLAXON
-- Données initiales (jeu d'essais)
-- ============================================

USE klaxon;

-- ============================================
-- Agences (Annexe 1)
-- ============================================

INSERT INTO agences (nom) VALUES
  ('Paris'),
  ('Lyon'),
  ('Marseille'),
  ('Toulouse'),
  ('Nice'),
  ('Nantes'),
  ('Strasbourg'),
  ('Montpellier'),
  ('Bordeaux'),
  ('Lille'),
  ('Rennes'),
  ('Reims');

-- ============================================
-- Utilisateurs (Annexe 2)
-- Mot de passe pour tous : "password"
-- Hash bcrypt standard : password_hash("password", PASSWORD_BCRYPT)
-- ============================================

INSERT INTO users (nom, prenom, telephone, email, mot_de_passe, role) VALUES
  ('Martin',    'Alexandre', '0612345678', 'alexandre.martin@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Dubois',    'Sophie',    '0698765432', 'sophie.dubois@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Bernard',   'Julien',    '0622446688', 'julien.bernard@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Moreau',    'Camille',   '0611223344', 'camille.moreau@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Lefèvre',   'Lucie',     '0777889900', 'lucie.lefevre@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Leroy',     'Thomas',    '0655443322', 'thomas.leroy@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Roux',      'Chloé',     '0633221199', 'chloe.roux@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Petit',     'Maxime',    '0766778899', 'maxime.petit@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Garnier',   'Laura',     '0688776655', 'laura.garnier@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Dupuis',    'Antoine',   '0744556677', 'antoine.dupuis@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Lefebvre',  'Emma',      '0699887766', 'emma.lefebvre@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Fontaine',  'Louis',     '0655667788', 'louis.fontaine@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Chevalier', 'Clara',     '0788990011', 'clara.chevalier@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Robin',     'Nicolas',   '0644332211', 'nicolas.robin@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Gauthier',  'Marine',    '0677889922', 'marine.gauthier@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Fournier',  'Pierre',    '0722334455', 'pierre.fournier@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Girard',    'Sarah',     '0688665544', 'sarah.girard@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Lambert',   'Hugo',      '0611223366', 'hugo.lambert@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Masson',    'Julie',     '0733445566', 'julie.masson@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
  ('Henry',     'Arthur',    '0666554433', 'arthur.henry@email.fr',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- ============================================
-- Compte administrateur
-- Email : admin@klaxon.fr
-- Mot de passe : admin
-- ============================================

INSERT INTO users (nom, prenom, telephone, email, mot_de_passe, role) VALUES
  ('Admin', 'Johanne', '0600000000', 'admin@klaxon.fr',
   '$2y$10$e0MYzXyjpJS7Pd0RVXYwvOYEKSMBSHD6gka3lISgzzSrT3c.MVwTy', 'admin');

-- ============================================
-- Trajets d'exemple (tous dans le futur,
-- avec places disponibles > 0)
-- ============================================

INSERT INTO trajets (
  id_user,
  id_agence_depart,
  id_agence_arrivee,
  date_depart,
  date_arrivee,
  places_totales,
  places_disponibles
) VALUES
  (1,  1,  2, '2026-04-15 08:00:00', '2026-04-15 12:00:00', 4, 3),
  (2,  3,  5, '2026-04-16 09:30:00', '2026-04-16 12:30:00', 3, 2),
  (3,  2,  9, '2026-04-17 07:00:00', '2026-04-17 12:00:00', 5, 4),
  (4,  4,  8, '2026-04-18 14:00:00', '2026-04-18 16:30:00', 3, 1),
  (1,  6, 11, '2026-04-20 06:00:00', '2026-04-20 09:00:00', 4, 3),
  (5, 10, 12, '2026-04-21 08:00:00', '2026-04-21 10:30:00', 2, 1),
  (6,  7,  1, '2026-04-22 16:00:00', '2026-04-22 21:00:00', 4, 2),
  (3,  9,  3, '2026-04-23 10:00:00', '2026-04-23 16:00:00', 5, 5);