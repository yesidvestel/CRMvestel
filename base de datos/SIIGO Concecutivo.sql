CREATE TABLE IF NOT EXISTS `crm`.`facturacion_electronica_siigo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `consecutivo_siigo` INT(11) NOT NULL,
  `fecha` DATE NOT NULL,
  `customer_id` INT(11) NOT NULL,
  `invoice_id` VARCHAR(45) NULL DEFAULT NULL,
  `servicios_facturados` VARCHAR(50) NULL DEFAULT NULL,
  `s1TotalValue` INT(11) NULL DEFAULT NULL,
  `s1TaxValue` INT(11) NULL DEFAULT NULL,
  `s2TotalValue` INT(11) NULL DEFAULT NULL,
  `s2TaxValue` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;

INSERT INTO `facturacion_electronica_siigo` (`id`, `consecutivo_siigo`, `fecha`, `customer_id`, `invoice_id`, `servicios_facturados`, `s1TotalValue`, `s1TaxValue`, `s2TotalValue`, `s2TaxValue`) VALUES (NULL, '511', '2021-04-29', '14181', NULL, 'Television', '25000', '7246', '', '');
