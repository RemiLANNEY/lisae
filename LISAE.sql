-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 12 Octobre 2017 à 12:37
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.1.10-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `LISAE`
--

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2014_10_12_000000_create_users_table', 1),
(13, '2014_10_12_100000_create_password_resets_table', 2),
(14, '2017_03_05_174100_create_promo_table', 2),
(15, '2017_10_10_165951_create_questions_table', 3),
(16, '2017_10_11_113113_create_candidats_table', 4);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promos`
--

CREATE TABLE `promos` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Fr',
  `dateDebutPromo` date NOT NULL,
  `dateFinPromo` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `promos`
--

INSERT INTO `promos` (`id`, `created_at`, `updated_at`, `titre`, `ville`, `pays`, `dateDebutPromo`, `dateFinPromo`, `description`, `user_id`) VALUES
(1, '2017-03-05 23:00:00', '2017-03-06 10:48:34', 'Simplon Nice', 'Nice', 'Fr', '2016-09-19', '2017-03-17', 'Simplon Nice', 1),
(2, '2017-03-05 23:00:00', '2017-03-06 10:48:34', 'Simplon Belvédère', 'Belvédère', 'Fr', '2016-09-19', '2017-03-17', 'Simplon Test', 2),
(3, '2017-09-29 08:42:12', '2017-09-29 08:42:12', 'Initiation Kung-fu', 'Belvedere', 'test', '2017-11-06', '2018-06-08', '<p>test klnlwfdg</p>\r\n\r\n<p>fkjvwhxnfgwfdswghffgbfvwxfdrwfdwdf</p>\r\n\r\n<p>fwdgwdfgdwxf</p>\r\n\r\n<p>gwd</p>', 1),
(6, '2017-09-29 10:29:05', '2017-09-29 11:43:16', 'Promo test', 'Belvedere 06450', 'test', '2017-11-06', '2018-06-08', '<p>Ceci est un test 3</p>', 1),
(7, '2017-10-03 13:17:23', '2017-10-03 13:17:23', 'test', 'Cannes', 'Fr', '2017-10-24', '2018-06-08', '<p>dsqfsdfsdfsqdfqsdf</p>\r\n\r\n<p>sqdfqsdf</p>\r\n\r\n<p>qsdfqsdf</p>\r\n\r\n<p>sqdfqsd</p>\r\n\r\n<p>f</p>', 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `privileges` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Users',
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `promo_id` int(10) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `privileges`, `role`, `admin`, `promo_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Rémi LANNEY', 'rlanney@simplon.co', '$2y$10$F0L2oOLDZuoKDXzq7av6..55neoXxVYSo3betEdj4fb/WzUqefhDa', 'SuperAdmin', 'Super Admin de la mort qui tue 2', 1, NULL, '00VRMVxsD6vYS1e9FntL7oJIHbytSlo677m0Y2SSunL0Pse6yOSleT01J53k', '2017-03-04 18:37:00', '2017-03-23 08:46:43'),
(2, 'Test admin 2', 'test@test.com', '$2y$10$OnZIdJs0JGPdecGqvZnWJ.MFPVHI1Tt8fnooNFNrItwiG7tUafEX6', 'Admin', 'Chef de projet', 1, NULL, 'qRxdkP9ctrtSlv6Sl4R0Ua1Vo0KIVq7IZL8u6W03PQfpsy4psxpjnzDeob6h', '2017-03-04 21:42:25', '2017-09-29 12:02:55'),
(5, 'Users test', 'user@test.com', '$2y$10$uk.CuxhNCswdm5mVAg9xfO4kJJSzAfS3XyH6VEqycFRFx9FTq7EzG', 'Users', 'testeur', 2, NULL, 'u7OzmoGsF7vQRvW0a3VJd13lgie3KXTWJ7rr11G2Wy02tEZQFVYEJUThdGrn', '2017-03-04 22:37:57', '2017-10-08 14:53:19'),
(6, 'users 2', 'users2@test.com', '$2y$10$EeJIYTXHRz3O2.I3v/JUf.VDEFVmYnfiLRs4sI1WVreqL1uM01BIS', 'Users', NULL, 2, NULL, '', '2017-03-04 22:41:00', '2017-03-04 23:17:53'),
(7, 'users 3', 'users3@test.com', '$2y$10$Mi0G9YoVy/TeH6iRvS7RsuYJiu1gBQcg/IQrUXJD9U2o7OQRIU6ri', 'Users', NULL, 2, NULL, NULL, '2017-03-04 23:20:18', '2017-03-04 23:20:18');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Index pour la table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `promos_user_id_foreign` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_promo_id_foreign` (`promo_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `promos`
--
ALTER TABLE `promos`
  ADD CONSTRAINT `promos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_promo_id_foreign` FOREIGN KEY (`promo_id`) REFERENCES `promos` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
