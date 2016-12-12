INSERT INTO `quimpero`.`type` (`id`, `nom`, `color`) VALUES (NULL, 'Ecole de CO', '#b21168');

INSERT INTO `quimpero`.`course` (`id`, `type_id`, `nom`, `lieu`, `site`, `date`, `inscription`, `modification`, `gps`, `organisateur`) VALUES (NULL, '1', 'Ecole de CO semaine 49', 'Bois d''amour', NULL, '2016-12-10 10:00:00', '1', '2016-12-09 20:00:00', NULL, 'Quimper Orientation 2904BR');

INSERT INTO `quimpero`.`user` (`id`, `username`, `password`, `email`, `is_active`, `newsletter`, `base_id`, `nom`, `prenom`) VALUES
(1, 'Quentin', '$2y$13$7i6BeNBlozrVav/lNuFbRO1rFcsxoaVfrOanK.nmvoaykCiSUqF6y', 'guillou.quentin.29@gmail.com', 1, 1, NULL, 'Guillou', 'Quentin');

INSERT INTO `quimpero`.`role` (`id`, `user_id`, `role`) VALUES (NULL, 1, 'ROLE_ADMIN');

INSERT INTO `quimpero`.`circuit` (`id`, `course_id`, `nom`, `information`) VALUES (NULL, '1', 'A', 'Niveau noir 10Km');
