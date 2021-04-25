SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_first_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_last_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_verified` tinyint(1) NOT NULL DEFAULT 0,
  `user_active` tinyint(1) NOT NULL DEFAULT 1,
  `user_is_staff` tinyint(1) NOT NULL DEFAULT 0,
  `user_last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_email` (`user_email`);

ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;