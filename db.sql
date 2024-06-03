-- Create the 'php_starter' database
CREATE DATABASE IF NOT EXISTS php_starter;
USE php_starter;

-- Table structure for 'users' table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into 'users' table
INSERT INTO `users` VALUES
  (1,'John Doe','user1@gmail.com','$2y$10$UkdJDaWLRHPVwOu3lb9XW.FZWZmFaLM0BJbaj0/7dvPIqs7sdDlvK','Boston','MA','2023-11-18 13:55:59'),
  (2,'Jane Doe','user2@gmail.com','$2y$10$UkdJDaWLRHPVwOu3lb9XW.FZWZmFaLM0BJbaj0/7dvPIqs7sdDlvK','San Francisco','CA','2023-11-18 13:58:26'),
  (3,'Steve Smith','user3@gmail.com','$2y$10$UkdJDaWLRHPVwOu3lb9XW.FZWZmFaLM0BJbaj0/7dvPIqs7sdDlvK','Chicago','IL','2023-11-18 13:59:13');
