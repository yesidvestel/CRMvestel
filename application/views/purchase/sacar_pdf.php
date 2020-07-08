    
<?php 
//para que muestre errores si los hay
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."/libraries/autoload.php";


$mpdf = new \Mpdf\Mpdf([

]);
$mpdf->SetTitle('Lista de Usuarios');
//obtengo la lista de usuarios
$users= $this->db->get_where('user',array('user_id'))->result_array();
//fecha actual para poder comparar y validar
$date_actual=intval(mktime(0, 0, 0, date("m"),   date("d"),   date("Y")));


//imagen del logo de la aplicacion
$imagenLogo1='<div align="center"><img src="'.base_url().'/assets/global/logo.png" style=" height: 32px;" /></div>';
//agrego a la variable del contenido de la tabla el correspondiente html
$contenidoTabla=$imagenLogo1."<table style='text-align:center;margin: 0 auto;'>
	<thead >
	<tr style='background-color: #BDBDBD;'>
		<th >#</th>
		<th>User Email</th>
		<th>Plan</th>
	</tr>
	</thead>
	<tbody>";
	//por cada iteracion agrego una fila o tr con sus td correspondientes 
foreach ($users as $key => $user) {
	

	$contenidoTabla.="<tr>";
	$contenidoTabla.="<td>".($key+1)."</td>";
	$contenidoTabla.="<td>".$user['email']."</td>";
//obtengo la suscripcion de el usuario
$suscripcion_actual = $this->db->get_where('subscription',array('user_id'=>$user['user_id'] ))->row(); 
	if(isset($suscripcion_actual)&& ( $date_actual<=intval($suscripcion_actual->timestamp_to) && $suscripcion_actual->status==1)){
		//valido si la suscripcion no esta vencida y busco el plan 
		$plan_v =$this->db->get_where("plan",array('plan_id' => $suscripcion_actual->plan_id))->row();
		//LO AGREGO
		$contenidoTabla.="<td style='background-color:#CEF6CE'>".$plan_v->name."</td>";	
	}else{
		//si no agrego en la columna que no tiene plan
		$contenidoTabla.="<td>Sin Plan</td>";
	}
	//cierro la fila actual		
	$contenidoTabla.="</tr>";
}
//cierro body y table
$contenidoTabla.="</tbody>
</table>";
//agrego al footer el numero de la pagina
$mpdf->setFooter('Pagina N° {PAGENO} de {nb}');
$mpdf->writeHtml($contenidoTabla,\Mpdf\HTMLParserMode::HTML_BODY);
$mpdf->Output();

 ?>

