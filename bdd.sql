# All table exists in this application

DROP DATABASE IF EXISTS `social`;

CREATE DATABASE social CHARACTER SET 'utf8';

USE `social`;


CREATE TABLE IF NOT EXISTS users (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS comments (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    content VARCHAR(255) NOT NULL,
    commentable_id INT NOT NULL,
    commentable_type VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id, user_id)
);


CREATE TABLE IF NOT EXISTS messagesch(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    content TEXT(650000) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS messages(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    username VARCHAR(50) NOT NULL,
    message TEXT(650000) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS user_message(
    user_id INT UNSIGNED NOT NULL,
    messagech_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, messagech_id)
);

CREATE TABLE IF NOT EXISTS posts (
    id SMALLINT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT(650000) NOT NULL, 
    image VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (id, user_id)
);

CREATE TABLE IF NOT EXISTS likes(
    id SMALLINT NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    post_id INT UNSIGNED NOT NULL,
    likes INT UNSIGNED NOT NULL,
    textLike VARCHAR(50) NOT NULL,
    PRIMARY KEY ( id, user_id, post_id)
);

ALTER TABLE comments
ADD CONSTRAINT fk_user_comment FOREIGN KEY (user_id) REFERENCES
users(id)
    ON DELETE CASCADE 
    ON UPDATE RESTRICT

ALTER TABLE posts
ADD CONSTRAINT fk_user_post FOREIGN KEY (user_id) REFERENCES
users(id)
    ON DELETE CASCADE 
    ON UPDATE RESTRICT

ALTER TABLE likes
ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES 
users(id)
    ON DELETE CASCADE 
    ON UPDATE RESTRICT

ALTER TABLE likes
ADD CONSTRAINT fk_user FOREIGN KEY (post_id) REFERENCES 
posts(id)
    ON DELETE CASCADE 
    ON UPDATE RESTRICT

ALTER TABLE user_message
ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES 
users(id)
    ON DELETE CASCADE 
    ON UPDATE RESTRICT

ALTER TABLE user_message 
ADD CONSTRAINT fk_messagech FOREIGN KEY (messagech_id) REFERENCES 
messagesch(id)
    ON DELETE CASCADE 
    ON UPDATE RESTRICT

