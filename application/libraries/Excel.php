
<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');   
/*  
 * Clase para la exportación de resultados a excel  
 * @version 0.1 Primera version  
 */ 
require_once APPPATH ."/third_party/Classes/PHPExcel.php";
class Excel extends PHPExcel {     
  public function __construct(){         
    parent::__construct();      
  } 
} 
?>