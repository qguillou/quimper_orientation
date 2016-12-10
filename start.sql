INSERT INTO `quimpero`.`type` (`id`, `nom`, `color`) VALUES (NULL, 'Ecole de CO', '#b21168');

INSERT INTO `quimpero`.`course` (`id`, `type_id`, `nom`, `lieu`, `site`, `date`, `inscription`, `modification`, `gps`, `organisateur`) VALUES (NULL, '1', 'Ecole de CO semaine 49', 'Bois d''amour', NULL, '2016-12-10 10:00:00', '1', '2016-12-09 20:00:00', NULL, 'Quimper Orientation 2904BR');

INSERT INTO `quimpero`.`role` (`id`, `user`, `role`) VALUES (NULL, 'Quentin', 'ROLE_ADMIN');

INSERT INTO `quimpero`.`user` (`id`, `username`, `password`, `email`, `is_active`, `newsletter`, `base_id`, `nom`, `prenom`) VALUES
(1, 'Quentin', '$2y$13$7i6BeNBlozrVav/lNuFbRO1rFcsxoaVfrOanK.nmvoaykCiSUqF6y', 'guillou.quentin.29@gmail.com', 1, 1, NULL, 'Guillou', 'Quentin')
