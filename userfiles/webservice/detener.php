<?php 

$file = fopen($_SERVER['DOCUMENT_ROOT']."/CRMvestel/assets/facturas_electronicas_seguimiento.txt", "w");            
                fwrite($file, $_GET['accion']);
                fclose($file);
 ?>