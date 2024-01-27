CREATE TABLE IF NOT EXISTS subscribers (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `status` tinyint(1) NOT NULL,
    `subscribed_at` DATETIME NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE KEY `idx_unique_email` (`email`)
) CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
