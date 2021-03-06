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
	FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE subcategory
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	user_id INT,
	category_id INT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(category_id) REFERENCES category(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE keyword
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	user_id INT,
	category_id INT,
	subcategory_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(category_id) REFERENCES category(id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(subcategory_id) REFERENCES subcategory(id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE bank
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64) NOT NULL,
	file_fields VARCHAR(256) NOT NULL,
	file_date_format VARCHAR(32) NOT NULL,
	user_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE import
(
	id INT NOT NULL AUTO_INCREMENT,
	file_original_name VARCHAR(256) NOT NULL,
	file_name VARCHAR(256) NOT NULL,
	date DATETIME,
	user_id INT,
	bank_id INT NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(bank_id) REFERENCES bank(id) ON DELETE CASCADE ON UPDATE CASCADE
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
	import_id INT,
	category_id INT,
	subcategory_id INT,
	keyword_id INT,
	PRIMARY KEY(id),
	FOREIGN KEY(user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(import_id) REFERENCES import(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(category_id) REFERENCES category(id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(subcategory_id) REFERENCES subcategory(id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(keyword_id) REFERENCES keyword(id) ON DELETE SET NULL ON UPDATE CASCADE
);
