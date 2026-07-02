CREATE DATABASE IF NOT EXISTS `eduplatform` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON `eduplatform`.* TO 'eduplatform'@'%';
FLUSH PRIVILEGES;

ALTER USER 'eduplatform'@'%' IDENTIFIED BY '${MYSQL_PASSWORD}';
