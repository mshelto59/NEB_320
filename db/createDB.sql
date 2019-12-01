-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=1;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema NEB_DB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `NEB_DB` ;

-- -----------------------------------------------------
-- Schema NEB_DB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `NEB_DB` DEFAULT CHARACTER SET utf8 ;
USE `NEB_DB` ;

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
  `cpassword` VARCHAR(45) NOT NULL,
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
-- Table `payments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `payments` ;

CREATE TABLE IF NOT EXISTS `payments` (
  `pid` INT NOT NULL AUTO_INCREMENT,
  `pnumber` INT(16) NOT NULL,
  `pexpire_date` DATE NOT NULL,
  `pcvv` INT(3) NOT NULL,
  `pzip` CHAR(5) NOT NULL,
  `cemail` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`pid`),
  CONSTRAINT `fk_payments_customers1`
    FOREIGN KEY (`cemail`)
    REFERENCES `customers` (`cemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `address` ;

CREATE TABLE IF NOT EXISTS `address` (
  `aid` INT NOT NULL AUTO_INCREMENT,
  `street` VARCHAR(45) NOT NULL,
  `city` VARCHAR(45) NOT NULL,
  `st` CHAR(2) NOT NULL,
  `zip` CHAR(5) NOT NULL,
  `cemail` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`aid`),
  CONSTRAINT `fk_address_customers1`
    FOREIGN KEY (`cemail`)
    REFERENCES `customers` (`cemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `orders`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `orders` ;

CREATE TABLE IF NOT EXISTS `orders` (
  `cemail` VARCHAR(45) NOT NULL,
  `products_pid` INT NOT NULL,
  `date` DATE NOT NULL,
  `count` INT NOT NULL,
  PRIMARY KEY (`cemail`),
  CONSTRAINT `fk_customers_has_products_customers1`
    FOREIGN KEY (`cemail`)
    REFERENCES `customers` (`cemail`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_customers_has_products_products1`
    FOREIGN KEY (`products_pid`)
    REFERENCES `products` (`pid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
