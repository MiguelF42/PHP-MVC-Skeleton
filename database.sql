-- Template of a database --
-- this file contain only 2 tables : 
-- user
-- log
-- You must create the others tables to use it.

DROP TABLE IF EXISTS log;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
    user_id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(40) NOT NULL,
    lastname VARCHAR(40) NOT NULL,
    birth_department TINYINT NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(250) NOT NULL,
    is_admin BOOLEAN DEFAULT 0 NOT NULL,
    token VARCHAR(250) NULL,
    token_datetime DATETIME NULL,
    PRIMARY KEY (user_id)
)ENGINE = InnoDB;

CREATE TABLE log (
    log_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id SMALLINT UNSIGNED NOT NULL, -- FOREIGN KEY
    content VARCHAR(512) NOT NULL,
    log_datetime DATETIME DEFAULT NOW() NOT NULL,
    PRIMARY KEY (log_id),
    CONSTRAINT FK_log_user_trattoria FOREIGN KEY (user_id) REFERENCES user(user_id)
)ENGINE = InnoDB;