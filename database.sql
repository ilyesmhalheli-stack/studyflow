
INSERT INTO utilisateurs (nom, email, mot_de_passe, photo) VALUES
('Ahmed Ben Ali', 'ahmed.benali@ensi.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OIP.webp'),
('Sara Trabelsi', 'sara.trabelsi@ensi.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OIP(1).webp'),
('Yassine Gaddour', 'yassine.gaddour@ensi.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OIP(2).webp'),
('Med Aziz Karray', 'medaziz.karray@ensi.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OIP(3).webp'),
('Nour Hachani', 'nour.hachani@ensi.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OIP(4).webp');

INSERT INTO taches (utilisateur_id, titre, description, statut, type, priorite, date_limite, date_travail, heure_travail) VALUES

(1, 'Révision Base de Données', 'Réviser les chapitres 1-3 pour l\'examen', 'en_cours', 'examen', 'haute', '2026-04-25', '2026-04-23', '9h-12h'),
(1, 'Projet Web', 'Finaliser la partie PHP du projet', 'en_attente', 'projet', 'moyenne', '2026-04-30', '2026-04-24', '14h-17h'),
(1, 'Devoir Mathématiques', 'Exercices pages 45-50', 'termine', 'devoir', 'basse', '2026-04-22', '2026-04-22', '18h-21h'),
(1, 'Présentation POO', 'Préparer les slides pour la présentation', 'en_attente', 'autre', 'haute', '2026-04-26', '2026-04-25', '9h-12h'),
(1, 'TP Algorithmique', 'Terminer le TP sur les arbres', 'en_cours', 'devoir', 'moyenne', '2026-04-28', '2026-04-23', '18h-21h'),

(2, 'Examen Anglais', 'Réviser le vocabulaire technique', 'en_attente', 'examen', 'haute', '2026-04-27', '2026-04-24', '9h-12h'),
(2, 'Rapport Stage', 'Rédiger la conclusion du rapport', 'en_cours', 'projet', 'haute', '2026-05-02', '2026-04-25', '14h-17h'),
(2, 'Devoir Français', 'Analyse du texte page 120', 'termine', 'devoir', 'basse', '2026-04-20', '2026-04-20', '18h-21h'),
(2, 'Réseau TP', 'Configuration du réseau virtuel', 'en_attente', 'devoir', 'moyenne', '2026-04-29', '2026-04-26', '9h-12h'),
(2, 'Préparation Entretien', 'Recherches sur l\'entreprise', 'en_cours', 'autre', 'haute', '2026-04-25', '2026-04-23', '14h-17h'),

(3, 'Projet IA', 'Implémenter l\'algorithme de classification', 'en_cours', 'projet', 'haute', '2026-05-05', '2026-04-24', '18h-21h'),
(3, 'Examen Systèmes', 'Réviser la gestion mémoire', 'en_attente', 'examen', 'haute', '2026-04-29', '2026-04-25', '9h-12h'),
(3, 'Devoir Électronique', 'Exercices sur les circuits logiques', 'termine', 'devoir', 'moyenne', '2026-04-21', '2026-04-21', '14h-17h'),
(3, 'Documentation Code', 'Commenter le code source du projet', 'en_attente', 'autre', 'basse', '2026-05-01', '2026-04-27', '14h-17h'),
(3, 'Réunion Groupe', 'Préparer les points à discuter', 'en_cours', 'autre', 'moyenne', '2026-04-24', '2026-04-23', '9h-12h'),


(4, 'Thèse Recherche', 'Analyser les articles scientifiques', 'en_cours', 'projet', 'haute', '2026-05-10', '2026-04-24', '9h-12h'),
(4, 'Publication Article', 'Finaliser l\'article pour la conférence', 'en_attente', 'projet', 'haute', '2026-04-30', '2026-04-25', '18h-21h'),
(4, 'Examen Java', 'Réviser les design patterns', 'en_attente', 'examen', 'moyenne', '2026-04-28', '2026-04-26', '14h-17h'),
(4, 'Devoir Sécurité', 'Étude de cas sur les vulnérabilités', 'termine', 'devoir', 'moyenne', '2026-04-19', '2026-04-19', '9h-12h'),
(4, 'Encadrement TP', 'Préparer les sujets du TP', 'en_cours', 'autre', 'basse', '2026-04-27', '2026-04-24', '14h-17h'),

(5, 'Design Interface', 'Créer les maquettes UI/UX', 'en_cours', 'projet', 'moyenne', '2026-05-03', '2026-04-25', '9h-12h'),
(5, 'Examen Design', 'Préparer le portfolio', 'en_attente', 'examen', 'haute', '2026-05-01', '2026-04-26', '18h-21h'),
(5, 'Devoir Dessin', 'Finaliser les illustrations', 'termine', 'devoir', 'basse', '2026-04-22', '2026-04-22', '14h-17h'),
(5, 'Présentation Projet', 'Préparer la démo', 'en_attente', 'autre', 'haute', '2026-04-29', '2026-04-27', '9h-12h'),
(5, 'Veille Technologique', 'Recherches sur les nouvelles tendances', 'en_cours', 'autre', 'basse', '2026-04-30', '2026-04-24', '18h-21h');

INSERT INTO questionnaire (nom_complet, email, vous_etes, frequence, fonctionnalites, commentaires, note_satisfaction) VALUES
('Mohamed Ben Salah', 'mohamed.bensalah@email.com', 'etudiant', 'hebdomadaire', 'taches,planning', 'Application très utile pour organiser mon temps', 5),
('Leila Khaled', 'leila.khaled@email.com', 'enseignant', 'quotidien', 'dashboard,taches', 'Interface intuitive et fonctionnalités complètes', 4),
('Karim Trabelsi', 'karim.trabelsi@email.com', 'etudiant', 'mensuel', 'planning', 'Bon outil mais pourrait avoir plus de notifications', 3),
('Sonia Masmoudi', 'sonia.masmoudi@email.com', 'autre', 'premiere', 'taches', 'Première utilisation, semble prometteur', 4),
('Amine Gharbi', 'amine.gharbi@email.com', 'etudiant', 'rare', 'dashboard,questionnaire', 'Simple et efficace', 4);


INSERT INTO contact (prenom, nom, email, sujet, message, priorite, newsletter) VALUES
('Ali', 'Jaziri', 'ali.jaziri@email.com', 'suggestion', 'Ajouter une fonctionnalité de synchronisation avec Google Calendar', 'moyenne', TRUE),
('Fatma', 'Ben Hassen', 'fatma.benhassen@email.com', 'bug', 'Problème d\'affichage sur mobile', 'haute', FALSE),
('Walid', 'Kallel', 'walid.kallel@email.com', 'question', 'Comment exporter mes tâches en PDF ?', 'basse', TRUE),
('Mariem', 'Sassi', 'mariem.sassi@email.com', 'suggestion', 'Intégrer des thèmes personnalisables', 'moyenne', TRUE),
('Nizar', 'Baccouche', 'nizar.baccouche@email.com', 'autre', 'Félicitations pour cette excellente application', 'basse', FALSE);
