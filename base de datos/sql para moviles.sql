SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';



CREATE TABLE IF NOT EXISTS `moviles` (
  `id_movil` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NULL DEFAULT NULL,
  `estado` ENUM('Activa', 'Temporal', 'Inactiva') NULL DEFAULT NULL,
  `id_usuario_crea` INT(11) NULL DEFAULT NULL COMMENT  "el id de la tabla aauth_users que crea la movil",
  `id_usuario_edita` INT(11) NULL DEFAULT NULL COMMENT  " el id de la tabla aauth_users que edita la movil",
  `fecha_creacion` DATETIME NULL DEFAULT NULL,
  `fecha_edicion` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`id_movil`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `empleados_moviles` (
  `id_empleados_moviles` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_movil` INT(10) UNSIGNED NOT NULL,
  `id_empleado` INT(11) NOT NULL COMMENT  " id del tecnico asociado a la movil",
  `rol` VARCHAR(200) NULL DEFAULT NULL COMMENT  " es una idea por si a futuro se emplea un rol dentro de la movil",
  PRIMARY KEY (`id_empleados_moviles`),
  INDEX `fk_empleados_moviles_moviles1_idx` (`id_movil` ASC),
  INDEX `fk_empleados_moviles_employee_profile1_idx` (`id_empleado` ASC),
  CONSTRAINT `fk_empleados_moviles_moviles1`
    FOREIGN KEY (`id_movil`)
    REFERENCES `moviles` (`id_movil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_empleados_moviles_employee_profile1`
    FOREIGN KEY (`id_empleado`)
    REFERENCES `employee_profile` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;