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
CREATE TABLE Tenants
(
    TenantID INT(10) AUTO_INCREMENT,
    UserID INT(10),
    TenantForename VARCHAR(255),
    TenantSurname VARCHAR(255),
    TenantGender TEXT,
    TenantAge TEXT,
    TenantAddress TEXT,
    CONSTRAINT Tenants_pk_index PRIMARY KEY (TenantID),
    CONSTRAINT Tenants_UserID_fk_index FOREIGN KEY (UserID) REFERENCES Users (UserID)
);
CREATE TABLE Properties
(
    PropertyID INT(10) AUTO_INCREMENT,
    TenantID INT(10),
    UserID INT(10),
    PropertyAddress TEXT,
    PropertyRent INT(4),
    CONSTRAINT Properties_pk_index PRIMARY KEY (PropertyID),
    CONSTRAINT Properties_TenantID_fk_index FOREIGN KEY (TenantID) REFERENCES Tenants (TenantID),
    CONSTRAINT Properties_UserID_fk_index FOREIGN KEY (UserID) REFERENCES Users (UserID)
);