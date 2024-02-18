-- Create database
CREATE DATABASE IF NOT EXISTS bot;
USE bot;

-- Create table
CREATE TABLE IF NOT EXISTS chatbot (
    id INT(11) AUTO_INCREMENT,
    queries LONGTEXT,
    replies LONGTEXT,
    PRIMARY KEY (id)
);


