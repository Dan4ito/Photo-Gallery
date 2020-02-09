DROP DATABASE IF EXISTS php_gallery;

CREATE DATABASE php_gallery CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE php_gallery.roles (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type VARCHAR(255) NOT NULL UNIQUE
);

INSERT INTO php_gallery.roles(type) VALUES('Admin');
INSERT INTO php_gallery.roles(type) VALUES('User');

CREATE TABLE php_gallery.users (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(255) NOT NULL UNIQUE,
	username VARCHAR(100) CHARACTER SET utf8 NOT NULL,
	password VARCHAR(2056) NOT NULL,
	roleId INT NOT NULL,
	FOREIGN KEY (roleId) REFERENCES roles(id)
);

INSERT INTO php_gallery.users(email, username, password, roleId) VALUES('yordan.petkov97@gmail.com', 'Dan4ito', '$2y$10$LLyr9O/5n9.MJtGYMCltUerYIO8pbfzWYBJxT9EbCnIqF84PIJqLa', '1');

CREATE TABLE php_gallery.images (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	description VARCHAR(128) NOT NULL,
	name VARCHAR(100) CHARACTER SET utf8 NOT NULL,
	userId INT NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (userId) REFERENCES users(id)
);

CREATE TABLE php_gallery.galleryTypes (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type VARCHAR(64) NOT NULL UNIQUE
);

INSERT INTO php_gallery.galleryTypes(type) VALUES('public');
INSERT INTO php_gallery.galleryTypes(type) VALUES('private');


CREATE TABLE php_gallery.galleries (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(128) NOT NULL,
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	userId INT NOT NULL,
	typeId INT NOT NULL DEFAULT 1,
	FOREIGN KEY (userId) REFERENCES users(id),
	FOREIGN KEY (typeId) REFERENCES galleryTypes(id)
);

INSERT INTO php_gallery.galleries (name, userId, typeId) VALUES ('Ime na GALERIQ',1 , 1);
INSERT INTO php_gallery.galleries (name, userId) VALUES ('Drugo ime',1);

CREATE TABLE php_gallery.image_gallery (
	imageId INT NOT NULL,
	galleryId INT NOT NULL,
	FOREIGN KEY (imageId) REFERENCES images(id),
	FOREIGN KEY (galleryId) REFERENCES galleries(id),
	CONSTRAINT PK_StudentClassroom PRIMARY KEY (imageId, galleryId)
);
