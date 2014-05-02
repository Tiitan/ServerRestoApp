SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema restoAppDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `restoAppDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `restoAppDB` ;

-- -----------------------------------------------------
-- Table `restoAppDB`.`Restaurant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restoAppDB`.`Restaurant` (
  `idRestaurant` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `pass` VARCHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  PRIMARY KEY (`idRestaurant`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restoAppDB`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restoAppDB`.`User` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `pass` VARCHAR(45) NULL,
  `phone` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`idUser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restoAppDB`.`Meal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restoAppDB`.`Meal` (
  `idMeal` INT NOT NULL AUTO_INCREMENT,
  `idRestaurant` INT NOT NULL,
  `name` VARCHAR(45) NULL,
  `type` VARCHAR(45) NULL,
  PRIMARY KEY (`idMeal`),
  INDEX `idRestaurant_idx` (`idRestaurant` ASC),
  CONSTRAINT `fk_Meal_Restaurant_idRestaurant`
    FOREIGN KEY (`idRestaurant`)
    REFERENCES `restoAppDB`.`Restaurant` (`idRestaurant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restoAppDB`.`Reservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restoAppDB`.`Reservation` (
  `idReservation` INT NOT NULL AUTO_INCREMENT,
  `idUser` INT NOT NULL,
  `idRestaurant` INT NOT NULL,
  `personNumber` INT NULL,
  `date` DATETIME NULL,
  `state` ENUM('inv','val','conf','rej') NULL,
  `emails` VARCHAR(45) NULL,
  PRIMARY KEY (`idReservation`),
  INDEX `idUser_idx` (`idUser` ASC),
  INDEX `idRestaurant_idx` (`idRestaurant` ASC),
  CONSTRAINT `fk_Reservation_User_idUser`
    FOREIGN KEY (`idUser`)
    REFERENCES `restoAppDB`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reservation_Restaurant_idRestaurant`
    FOREIGN KEY (`idRestaurant`)
    REFERENCES `restoAppDB`.`Restaurant` (`idRestaurant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `restoAppDB`.`mealReservation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `restoAppDB`.`mealReservation` (
  `idmealReservation` INT NOT NULL AUTO_INCREMENT,
  `idReservation` INT NOT NULL,
  `idMeal` INT NOT NULL,
  `number` INT NULL,
  PRIMARY KEY (`idmealReservation`),
  INDEX `idReservation_idx` (`idReservation` ASC),
  INDEX `idMeal_idx` (`idMeal` ASC),
  CONSTRAINT `fk_MealReservation_Reservation_idReservation`
    FOREIGN KEY (`idReservation`)
    REFERENCES `restoAppDB`.`Reservation` (`idReservation`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MealReservation_Meal_idMeal`
    FOREIGN KEY (`idMeal`)
    REFERENCES `restoAppDB`.`Meal` (`idMeal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
