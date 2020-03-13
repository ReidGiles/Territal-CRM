DROP DATABASE IF EXISTS TerritalCRM;

CREATE DATABASE TerritalCRM;

USE TerritalCRM;

CREATE TABLE Users
(
    UserID INT(10) AUTO_INCREMENT,
    UserEmail VARCHAR(150),
    UserPassword VARCHAR(255),
    UserForename VARCHAR(255),
    UserCountry TEXT,
    UserGender TEXT,
    UserProfileImage TEXT,
    CONSTRAINT Users_pk_index PRIMARY KEY (UserID)
);