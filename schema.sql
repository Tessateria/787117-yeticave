CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category TEXT
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  lot_name TEXT,
  specification TEXT,
  image TEXT,
  start_price FLOAT,
  date_finish DATETIME,
  step_up_value FLOAT,
  author_id INT,
  winner_id INT,
  category_id INT
)

CREATE TABLE rates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  cost FLOAT,
  user_id INT,
  lot_id INT
  )

CREATE TABLE users (
  id  INT AUTO_INCREMENT PRIMARY KEY,
  date_registr TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email CHAR(128) NOT NULL UNIQUE,
  username TINYTEXT UNIQUE ,
  password CHAR(64) NOT NULL,
  avatar TEXT,
  contacts TEXT,
  lots_create INT,
  rates_done INT
)
