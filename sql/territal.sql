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
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    Main_Phone VARCHAR(11) NOT NULL,
    Gender TEXT,
    Age INT(3),
    CONSTRAINT Tenants_pk_index PRIMARY KEY (TenantID),
    CONSTRAINT Tenants_UserID_fk_index FOREIGN KEY (UserID) REFERENCES Users (UserID)
);
CREATE TABLE Properties
(
    PropertyID INT(10) AUTO_INCREMENT,
    TenantID INT(10),
    UserID INT(10),
    BuildingName_StreetNo VARCHAR(40) NOT NULL,
    Street VARCHAR(30) NOT NULL,
    City VARCHAR(30),
    Postcode VARCHAR(9)  NOT NULL,
    PropertyType VARCHAR(18),
    Bedrooms INT(1),
    MonthlyRent INT(4),
    CONSTRAINT Properties_pk_index PRIMARY KEY (PropertyID),
    CONSTRAINT Properties_TenantID_fk_index FOREIGN KEY (TenantID) REFERENCES Tenants (TenantID),
    CONSTRAINT Properties_UserID_fk_index FOREIGN KEY (UserID) REFERENCES Users (UserID)
);