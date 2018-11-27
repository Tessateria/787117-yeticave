CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(255)
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  lot_name VARCHAR(255),
  specification TEXT,
  image VARCHAR(255),
  start_price FLOAT,
  date_finish DATETIME,
  step_up_value FLOAT,
  author_id INT,
  winner_id INT,
  category_id INT
);

CREATE TABLE rates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  cost FLOAT,
  user_id INT,
  lot_id INT
);

CREATE TABLE users (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  date_registr TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(100) NOT NULL UNIQUE,
  username VARCHAR(100) UNIQUE ,
  password CHAR(64) NOT NULL,
  avatar VARCHAR(255),
  contacts TEXT,
  lots_create INT,
  rates_done INT
);
