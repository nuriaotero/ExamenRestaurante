-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema examen_uf1844
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema examen_uf1844
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `examen_uf1844` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `examen_uf1844` ;

-- -----------------------------------------------------
-- Table `examen_uf1844`.`mesas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `examen_uf1844`.`mesas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `numero` INT(11) NOT NULL,
  `plazas` INT(11) NOT NULL,
  `activa` TINYINT(1) NOT NULL DEFAULT 1,
  `created` TIMESTAMP NULL DEFAULT NULL,
  `modified` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `numero_UNIQUE` (`numero` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `examen_uf1844`.`phinxlog`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `examen_uf1844`.`phinxlog` (
  `version` BIGINT(20) NOT NULL,
  `migration_name` VARCHAR(100) NULL DEFAULT NULL,
  `start_time` TIMESTAMP NULL DEFAULT NULL,
  `end_time` TIMESTAMP NULL DEFAULT NULL,
  `breakpoint` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`version`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `examen_uf1844`.`tramos_horarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `examen_uf1844`.`tramos_horarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created` TIMESTAMP NULL DEFAULT NULL,
  `modified` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `examen_uf1844`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `examen_uf1844`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nombre_completo` VARCHAR(255) NULL DEFAULT NULL,
  `telefono` VARCHAR(20) NULL DEFAULT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created` TIMESTAMP NULL DEFAULT NULL,
  `modified` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `examen_uf1844`.`reservas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `examen_uf1844`.`reservas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(11) NOT NULL,
  `mesa_id` INT(11) NOT NULL,
  `tramo_horario_id` INT(11) NOT NULL,
  `fecha_reserva` DATE NOT NULL,
  `numero_personas` INT(11) NOT NULL,
  `comentarios` TEXT NULL DEFAULT NULL,
  `estado` VARCHAR(50) NOT NULL DEFAULT 'confirmada',
  `created` TIMESTAMP NULL DEFAULT NULL,
  `modified` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `unique_reserva` (`fecha_reserva` ASC, `mesa_id` ASC, `tramo_horario_id` ASC) VISIBLE,
  INDEX `FK_reservas_usuarios` (`usuario_id` ASC) VISIBLE,
  INDEX `FK_reservas_mesas` (`mesa_id` ASC) VISIBLE,
  INDEX `FK_reservas_tramos_horarios` (`tramo_horario_id` ASC) VISIBLE,
  CONSTRAINT `FK_reservas_mesas_fk`
    FOREIGN KEY (`mesa_id`)
    REFERENCES `examen_uf1844`.`mesas` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_reservas_tramos_horarios_fk`
    FOREIGN KEY (`tramo_horario_id`)
    REFERENCES `examen_uf1844`.`tramos_horarios` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `FK_reservas_usuarios_fk`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `examen_uf1844`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `examen_uf1844`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `examen_uf1844`.`usuario` (
  `usuario_id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`usuario_id`),
  UNIQUE INDEX `email` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
