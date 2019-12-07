-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=1;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mshelto_NEB_DB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mshelto_NEB_DB` ;

-- -----------------------------------------------------
-- Schema mshelto_NEB_DB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mshelto_NEB_DB` DEFAULT CHARACTER SET utf8 ;
USE `mshelto_NEB_DB` ;

-- -----------------------------------------------------
-- Table `products`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `products` ;

CREATE TABLE IF NOT EXISTS `products` (
  `pid` INT NOT NULL AUTO_INCREMENT,
  `pnumber` VARCHAR(10) NOT NULL,
  `pname` VARCHAR(45) NOT NULL,
  `pprice` DECIMAL(6,2) NOT NULL,
  `pdesc` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`pid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `customerLogin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `customerLogin` ;

CREATE TABLE IF NOT EXISTS `customerLogin` (
  `cemail` VARCHAR(45) NOT NULL,
  `cpassword` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`cemail`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `customers` ;

CREATE TABLE IF NOT EXISTS `customers` (
  `cfn` VARCHAR(45) NOT NULL,
  `cln` VARCHAR(45) NOT NULL,
  `cemail` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`cemail`),
  CONSTRAINT `fk_customers_customerLogin`
    FOREIGN KEY (`cemail`)
    REFERENCES `customerLogin` (`cemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ContactInfo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ContactInfo` ;

CREATE TABLE IF NOT EXISTS `ContactInfo` (
  `CIID` INT NOT NULL AUTO_INCREMENT,
  `street` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `st` CHAR(2) NOT NULL,
  `zip` CHAR(5) NOT NULL,
  `HomePhone` VARCHAR(10) NOT NULL,
  `WorkPhone` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`CIID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `paymentCard`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `paymentCard` ;

CREATE TABLE IF NOT EXISTS `paymentCard` (
  `pid` INT NOT NULL AUTO_INCREMENT,
  `pfn` VARCHAR(255) NOT NULL,
  `pln` VARCHAR(255) NOT NULL,
  `pnumber` INT(16) NOT NULL,
  `pcvv` INT(3) NOT NULL,
  `Month` VARCHAR(45) NOT NULL,
  `Year` VARCHAR(45) NOT NULL,
  `CIID` INT NOT NULL,
  PRIMARY KEY (`pid`),
  INDEX `fk_paymentCard_Address1_idx` (`CIID` ASC),
  CONSTRAINT `fk_paymentCard_Address1`
    FOREIGN KEY (`CIID`)
    REFERENCES `ContactInfo` (`CIID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orders` ;

CREATE TABLE IF NOT EXISTS `orders` (
  `oid` INT NOT NULL AUTO_INCREMENT,
  `cemail` VARCHAR(45) NOT NULL,
  `date` DATETIME NOT NULL,
  `count` INT NOT NULL,
  `pid` INT NOT NULL,
  `CIID` INT NOT NULL,
  INDEX `fk_customers_has_products_customers1_idx` (`cemail` ASC),
  INDEX `fk_orders_paymentCard1_idx` (`pid` ASC),
  INDEX `fk_orders_Address1_idx` (`CIID` ASC),
  PRIMARY KEY (`oid`),
  CONSTRAINT `fk_customers_has_products_customers1`
    FOREIGN KEY (`cemail`)
    REFERENCES `customers` (`cemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_paymentCard1`
    FOREIGN KEY (`pid`)
    REFERENCES `paymentCard` (`pid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_Address1`
    FOREIGN KEY (`CIID`)
    REFERENCES `ContactInfo` (`CIID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `orderProducts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orderProducts` ;

CREATE TABLE IF NOT EXISTS `orderProducts` (
  `oid` INT NOT NULL,
  `pid` INT NOT NULL,
  `count` INT NOT NULL,
  PRIMARY KEY (`oid`, `pid`),
  INDEX `fk_orders_has_products_products1_idx` (`pid` ASC),
  INDEX `fk_orders_has_products_orders1_idx` (`oid` ASC),
  CONSTRAINT `fk_orders_has_products_orders1`
    FOREIGN KEY (`oid`)
    REFERENCES `orders` (`oid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_orders_has_products_products1`
    FOREIGN KEY (`pid`)
    REFERENCES `products` (`pid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
