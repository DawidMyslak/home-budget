CREATE TABLE user
(
	id INT NOT NULL AUTO_INCREMENT,
	username VARCHAR(128) NOT NULL,
	password VARCHAR(256) NOT NULL,
	auth_key VARCHAR(128) NOT NULL,
	access_token VARCHAR(128) NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE category
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	user_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id)
);

CREATE TABLE subcategory
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	user_id INT,
	category_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id),
	FOREIGN KEY(category_id) REFERENCES category(id)
);

CREATE TABLE keyword
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	user_id INT,
	category_id INT,
	subcategory_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id),
	FOREIGN KEY(category_id) REFERENCES category(id),
	FOREIGN KEY(subcategory_id) REFERENCES subcategory(id)
);

CREATE TABLE transaction
(
	id INT NOT NULL AUTO_INCREMENT,
	date DATETIME,
	description VARCHAR(128) NOT NULL,
	money_in DECIMAL(8,2),
	money_out DECIMAL(8,2),
	balance DECIMAL(8,2),
	hash VARCHAR(32),
	user_id INT,
	category_id INT,
	subcategory_id INT,
	keyword_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id),
	FOREIGN KEY(category_id) REFERENCES category(id),
	FOREIGN KEY(subcategory_id) REFERENCES subcategory(id),
	FOREIGN KEY(keyword_id) REFERENCES keyword(id)
);