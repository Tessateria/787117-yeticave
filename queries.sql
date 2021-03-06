INSERT INTO categories (category) VALUES ("Доски и лыжи"),
("Крепления"),
("Ботинки"),
("Одежда"),
("Инструменты"),
("Разное");

INSERT INTO users
	SET email = "fghj@hj.hj",
	username = "Fikus",
	password= "123",
	avatar="src/",
	contacts = "+365854185";

INSERT INTO users
	SET email = "kjhg@jhg.k",
	username = "Kaktus",
	password= "666",
	avatar="src/45",
	contacts = "+625464";

INSERT INTO lots
	SET lot_name ="2014 Rossignol District Snowboard",
	specification =" ",
	image ="img/lot-1.jpg",
	start_price = 10999,
	step_up_value = 10,
	author_id = 1,
	winner_id = 2,
	category_id = 1;

INSERT INTO lots
SET lot_name ="DC Ply Mens 2016/2017 Snowboard",
	specification =" ",
	image ="img/lot-2.jpg",
	start_price = 159999,
	step_up_value = 300,
	author_id = 1,
	winner_id = 2,
	category_id = 1;

INSERT INTO lots
SET lot_name ="Крепления Union Contact Pro 2015 года размер L/XL",
	specification =" ",
	image ="img/lot-3.jpg",
	start_price = 8000,
	step_up_value = 15,
	author_id = 2,
	winner_id = 1,
	category_id = 2;

INSERT INTO lots
SET lot_name ="Ботинки для сноуборда DC Mutiny Charocal",
	specification =" ",
	image ="img/lot-4.jpg",
	start_price = 10999,
	step_up_value = 100,
	author_id = 2,
	winner_id = 1,
	category_id = 3;

INSERT INTO lots
SET lot_name ="Куртка для сноуборда DC Mutiny Charocal",
	specification =" ",
	image ="img/lot-5.jpg",
	start_price = 7500,
	step_up_value = 25,
	author_id = 2,
	winner_id = 1,
	category_id = 4;

INSERT INTO lots
SET lot_name ="Маска Oakley Canopy",
	specification =" ",
	image ="img/lot-6.jpg",
	start_price = 5400,
	step_up_value = 50,
	author_id = 2,
	winner_id = 1,
	category_id = 6;

INSERT INTO rates
SET cost = 7525,
	user_id = 1,
	lot_id = 5;

INSERT INTO rates
SET cost = 11009,
	user_id = 2,
	lot_id = 1;


//получить все категории
SELECT * FROM categories;


//получить самые новые, открытые лоты. лот + название, стартовую цену, ссылку на изображение, цену, название категории
SELECT l.id, l.lot_name, l.start_price, l.image, c.category AS category, MAX(r.cost) AS cost
FROM lots l
LEFT OUTER JOIN categories c ON l.category_id=c.id
LEFT OUTER JOIN rates r ON l.id = r.lot_id
GROUP BY l.id
ORDER BY date_create DESC;


//показать лот по его id. Получите также название категории, к которой принадлежит лот
SELECT * FROM lots
INNER JOIN categories ON lots.category_id=categories.id
WHERE lots.id=2;


//обновить название лота по его идентификатору
UPDATE lots
SET lot_name = "Валенки для сноуборда"
WHERE id=4;


//получить список самых свежих ставок для лота по его идентификатору
SELECT * FROM rates
WHERE lot_id=1
ORDER BY date_add DESC LIMIT 1;
