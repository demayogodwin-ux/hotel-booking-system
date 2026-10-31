CREATE DATABASE user_db;
USE user_db;

CREATE TABLE form(
userID int (50) PRIMARY KEY AUTO_INCREMENT,
firstname VARCHAR (100) NOT NULL,
lastname VARCHAR (100) NOT NULL,
email VARCHAR (100) NOT NULL,
password VARCHAR (255) NOT NULL,
contact VARCHAR(50) NOT NULL,
gender VARCHAR (50) NOT NULL
);
-- admin accounts have is_admin = 1
ALTER TABLE form ADD COLUMN is_admin TINYINT(1) NOT NULL DEFAULT 0;
