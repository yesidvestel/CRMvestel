<?php 
/*if (!$enlace = mysql_connect('localhost', 'root', '12345678')) {
    echo 'No pudo conectarse a mysql';
    exit;
}

if (!mysql_select_db('crm3', $enlace)) {
    echo 'No pudo seleccionar la base de datos';
    exit;
}

$sql       = "SELECT count(*) FROM facturacion_electronica_siigo inner JOIN customers on customers.id=facturacion_electronica_siigo.customer_id WHERE fecha = '2022-02-01' and customers.gid=3 ORDER BY customers.id DESC";
$resultado = mysql_query($sql, $enlace);

if (!$resultado) {
    echo "Error de BD, no se pudo consultar la base de datos\n";
    echo "Error MySQL: " . mysql_error();
    exit;
}else {
	var_dump(mysql_fetch_assoc($resultado));
}*/

$x=file_get_contents($_SERVER['DOCUMENT_ROOT'].'/CRMvestel/assets/facturas_electronicas_seguimiento_'.$_GET['pay_acc'].'.txt', FILE_USE_INCLUDE_PATH);
echo $x;
 ?>