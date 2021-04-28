CREATE TABLE IF NOT EXISTS `crm`.`consecutivos` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `consecutivo_siigo` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

INSERT INTO `consecutivos` (`id`, `consecutivo_siigo`) VALUES (NULL, '511');