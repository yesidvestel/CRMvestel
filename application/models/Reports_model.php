<?php
/**
 * Neo Billing -  Accounting,  Invoicing  and CRM Software
 * Copyright (c) Rajesh Dukiya. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model
{

    public function index()
    {


        $query = $this->db->query("SELECT pid,product_name,product_price FROM products WHERE UPPER(product_name) LIKE '" . strtoupper($name) . "%'");

        $result = $query->result_array();

        return $result;
    }

    public function viewstatement($pay_acc, $trans_type, $sdate, $edate, $ttype)
    {

        if ($trans_type == 'All') {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') ";
        } else {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function get_statements($pay_acc, $trans_type, $sdate, $edate)
    {
       
        if ($trans_type == 'All') {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate')  ";
        } else {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        //  $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }
    function devolver_nombre_mes($numero){
        if($numero=="1"){
            return "Enero";
        }else if($numero=="2"){
            return "Febrero";
        }else if($numero=="3"){
            return "Marzo";
        }else if($numero=="4"){
            return "Abril";
        }else if($numero=="5"){
            return "Mayo";
        }else if($numero=="6"){
            return "Junio";
        }else if($numero=="7"){
            return "Julio";
        }else if($numero=="8"){
            return "Agosto";
        }else if($numero=="9"){
            return "Septiembre";
        }else if($numero=="10"){
            return "Octubre";
        }else if($numero=="11"){
            return "Noviembre";
        }else if($numero=="12"){
            return "Diciembre";
        }
    }
    public function obtener_dia($numero){
        if($numero==1){
            return "Lunes";
        }else if($numero==2){
            return "Martes";
        }else if($numero==3){
            return "Miercoles";
        }else if($numero==4){
            return "Jueves";
        }else if($numero==5){
            return "Viernes";
        }else if($numero==6){
            return "Sabado";
        }else {
            return "Domingo";
        }
    }
    //transaction account statement

    var $table = 'transactions';
    var $column_order = array(null, 'account', 'type', 'cat', 'amount', 'stat');
    var $column_search = array('id', 'account');
    var $order = array('id' => 'asc');
    var $opt = '';


    //income statement


    public function incomestatement()
    {


        $this->db->select_sum('lastbal');
        $this->db->from('accounts');
        $query = $this->db->get();
        $result = $query->row_array();

        $lastbal = $result['lastbal'];

        $this->db->select_sum('credit');
        $this->db->from('transactions');

        $this->db->where('type', 'Income');
        $this->db->where('estado');
        $month = date('Y-m');
        $today = date('Y-m-d');
        $this->db->where('DATE(date) >=', "$month-01");
        $this->db->where('DATE(date) <=', $today);

        $query = $this->db->get();
        $result = $query->row_array();

        $motnhbal = $result['credit'];
        return array('lastbal' => $lastbal, 'monthinc' => $motnhbal);

    }

    public function customincomestatement($acid, $sdate, $edate)
    {


        $this->db->select_sum('credit');
        $this->db->from('transactions');
        if ($acid > 0) {
            $this->db->where('acid', $acid);
        }
        $this->db->where('estado');
        $this->db->where('type', 'Income');
        $this->db->where('DATE(date) >=', $sdate);
        $this->db->where('DATE(date) <=', $edate);
        // $this->db->where("DATE(date) BETWEEN '$sdate' AND '$edate'");
        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }
	// tipos de ticket
	public function filtrotipos($tec, $sede, $sdate)
    {
		$filtro_tecnico="";
        $fecha =new DateTime($sdate);
		  if ($tec != 'all') {

            $emp=$this->db->query("SELECT GROUP_CONCAT(id_movil) as ids FROM `empleados_moviles` join aauth_users on empleados_moviles.id_empleado=aauth_users.id WHERE aauth_users.username ='".$tec."'")->result_array();
            $in='';
            if(isset($emp[0]['ids']) && $emp[0]['ids']!=null){
                $filtro_tecnico=" and (tickets.asignado='".$tec."' or tickets.asignacion_movil in(".$emp[0]['ids']."))";
                
            }else{
                $filtro_tecnico=' and tickets.asignado="'.$tec.'"';    
            }
            
        }
        //, datetable.date
        $header_sql='SELECT t1.id_factura as id_factura_orden,t1.asignado as tec_asignado,t1.detalle as detalle,t1.section as section, datetable.date as fecha1 
            from datetable left join (select * from tickets 
            join customers on tickets.cid=customers.id where';
        $text_sede_fot="";
        if($sede!="all"){
            $text_sede_fot=" and customers.gid=".$sede;
        }
        $footer_sql='  tickets.status="Resuelto" '.$text_sede_fot.' '.$filtro_tecnico.') as t1 
            on datetable.date = date_format(t1.fecha_final,"%Y-%m-%d") 
            where datetable.date BETWEEN date_format("'.$fecha->format("Y-m").'-01","%Y-%m-%d") 
            and date_format("'.$fecha->format("Y-m-t").'","%Y-%m-%d")
            ';

$header_sql2='select * from todolist 
            join aauth_users on todolist.eid=aauth_users.id where start BETWEEN date_format("'.$fecha->format("Y-m").'-01","%Y-%m-%d") 
            and date_format("'.$fecha->format("Y-m-t").'","%Y-%m-%d") and status="Done" and puntuacion is not null';
$lista_tareas=$this->db->query($header_sql2)->result_array();
           
        //nuevo codigo //falta utilizar el last_date($fecha); y colocar $fecha->format("Y-m")."01"; para el tema de las fechas


$lista_datos=array();
        
        $est=$this->db->query($header_sql." ".$footer_sql)->result_array();
        $lista_datos['instalaciones_tv_e_internet']=array();
        $lista_datos['instalaciones_tv']=array();
        $lista_datos['instalaciones_internet']=array();
        $lista_datos['instalaciones_Agregar_Tv']=array();
        $lista_datos['instalaciones_punto_nuevo']=array();
        $lista_datos['instalaciones_AgregarInternet']=array();
        $lista_datos['instalaciones_Traslado']=array();
        $lista_datos['instalaciones_Revision_tv_e_internet']=array();
        $lista_datos['instalaciones_Revision_tv']=array();
        $lista_datos['instalaciones_Revision_internet']=array();
        $lista_datos['instalaciones_Reconexion_tv_e_internet']=array();
        $lista_datos['instalaciones_Reconexion_tv']=array();
        $lista_datos['instalaciones_Reconexion_internet']=array();
        $lista_datos['instalaciones_Suspension_Combo']=array();
        $lista_datos['instalaciones_Suspension_Internet']=array();
        $lista_datos['instalaciones_Suspension_Television']=array();
        $lista_datos['instalaciones_Corte_Tv']=array();
        $lista_datos['instalaciones_Corte_Internet']=array();
        $lista_datos['instalaciones_Corte_tv_e_internet']=array();
        $lista_datos['instalaciones_migracion']=array();
        $lista_datos['instalaciones_recuperacion_cable_modem']=array();
        $lista_datos['instalaciones_veeduria']=array();
        $lista_datos['tareas_en_proyectos']=array();
        $lista_datos['total_dia']=array();

        $lista_datos_cuentas_tipos_por_tecnico=$lista_datos;
        $lista_tecnicos=array();
        if ($tec != 'all') {
            $lista_tecnicos=$this->db->query("SELECT username from aauth_users where username='".$tec."'")->result_array();    
        }else{
            if($sede=="all"){
                $sede="";
            }else{
                $sede="and sede_accede=".$sede;    
            }
            

            $lista_tecnicos=$this->db->query("SELECT username from aauth_users where (roleid=2 or roleid=3 )  ".$sede." or (username='NaimeSistemas' or username='CamiloSistemas' or username='CesarRiosTEC' or username='AnnieAtencion' or username='SoniaCajera' or username='LuisHurtadoTEC' or username='YesidBarrera' or username='LinaPaola')")->result_array();    
            $lista_tecnicos[]=array("username"=>"Sin_Asignar");
        }
        
        $lista_tecnicos_organizada=array();
        
$date1=$fecha->format("Y-m")."-01";
for ($i=1; $i <=intval($fecha->format("t")) ; $i++) { 
            if($i!=1){
                $date1=date("Y-m-d",strtotime($date1."+ 1 days")); 
                //var_dump($date1);
            }            
            foreach ($lista_datos as $key => $value) {
                $lista_datos[$key][$date1]=0;
                foreach ($lista_tecnicos as $key2 => $value2) {
                    if($key=="instalaciones_tv_e_internet" || $key=="instalaciones_internet" || $key=="instalaciones_tv" || $key=="instalaciones_Traslado" || $key=="instalaciones_AgregarInternet"){
                            $lista_tecnicos_organizada[$key][$date1][$value2['username']]=array("EOC"=>array("cantidad"=>0,"puntuacion"=>0),
                                "FTTH"=>array("cantidad"=>0,"puntuacion"=>0),"TV"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales_multiples"=>array("cantidad"=>0,"puntuacion"=>0));
                    }else if($key=="instalaciones_Agregar_Tv" || $key=="instalaciones_punto_nuevo"){
                                $lista_tecnicos_organizada[$key][$date1][$value2['username']]=array("Agregar_Tv"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales_multiples"=>array("cantidad"=>0,"puntuacion"=>0));
                    }else if($key=="instalaciones_Revision"){
                                $lista_tecnicos_organizada[$key][$date1][$value2['username']]=array("Revision_de_Internet"=>array("cantidad"=>0,"puntuacion"=>0),
                                "Revision_de_television"=>array("cantidad"=>0,"puntuacion"=>0));
                    }else if($key=="instalaciones_veeduria" ||$key=="instalaciones_recuperacion_cable_modem" ||$key=="instalaciones_Suspension_Television" ||$key=="instalaciones_Suspension_Internet" ||$key=="instalaciones_Suspension_Combo" ||$key=="instalaciones_Corte_Tv" || $key=="instalaciones_Corte_Internet" || $key=="instalaciones_Corte_tv_e_internet" || $key=="instalaciones_Reconexion_tv_e_internet" || $key=="instalaciones_Reconexion_tv" || $key=="instalaciones_Reconexion_internet" || $key=="instalaciones_Revision_tv_e_internet" || $key=="instalaciones_Revision_tv" || $key=="instalaciones_Revision_internet" || $key=="instalaciones_migracion" || $key=="tareas_en_proyectos"){
                                $lista_tecnicos_organizada[$key][$date1][$value2['username']]=array("cantidad"=>0,"puntuacion"=>0);
                    }else{

                        $lista_tecnicos_organizada[$key][$date1][$value2['username']]=0;
                    }
                    //$lista_tecnicos_organizada[$value2['username']][$date1]=0;
                }
            }
            
            /*$estadistica['instalaciones_tv']['fecha']=$date1;$estadistica['instalaciones_internet']['fecha']=$date1;$estadistica['instalaciones_Agregar_Tv']['fecha']=$date1;$estadistica['instalaciones_AgregarInternet']=$date1;$estadistica['instalaciones_Traslado']['fecha']=$date1;$estadistica['instalaciones_Revision']['fecha']=$date1;$estadistica['instalaciones_Reconexion']['fecha']=$date1;$estadistica['instalaciones_Suspension_Combo']['fecha']=$date1;$estadistica['instalaciones_Suspension_Internet']['fecha']=$date1;$estadistica['instalaciones_Suspension_Television']['fecha']=$date1;$estadistica['instalaciones_Corte_Television']['fecha']=$date1;*/


        }

    $puntuacion_instalaciones_FTTH=4;
    $puntuacion_instalaciones_EOC=2;
    $puntuacion_traslado_EOC=2;
    $puntuacion_traslado_FTTH=4;
    $puntuacion_migracion_FTTH=4;//preguntar a cuales ordenes se relaciona
    $puntuacion_agregar_internet_FTTH=4;
    $puntuacion_agregar_tv=2;
    $puntuacion_punto_adicional=2;
    $puntuacion_punto_adicional_multiple=4;
    $puntuacion_revision_internet=2;
    $puntuacion_revision_tv=2;
    $puntuacion_reconexion=1;
    $puntuacion_desconexion=1;


        foreach ($lista_datos_cuentas_tipos_por_tecnico as $key2 => $value2) {
                   foreach ($lista_tecnicos as $key => $value) {
                        if($key2=="instalaciones_tv_e_internet" || $key2=="instalaciones_internet"|| $key2=="instalaciones_tv" || $key2=="instalaciones_Traslado" || $key2=="instalaciones_AgregarInternet"){
                            $lista_datos_cuentas_tipos_por_tecnico[$key2][$value['username']]=array("EOC"=>array("cantidad"=>0,"puntuacion"=>0),
                                "FTTH"=>array("cantidad"=>0,"puntuacion"=>0),"TV"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales_multiples"=>array("cantidad"=>0,"puntuacion"=>0));
                        }else if($key2=="instalaciones_Agregar_Tv" || $key2=="instalaciones_punto_nuevo"){
                            $lista_datos_cuentas_tipos_por_tecnico[$key2][$value['username']]=array("Agregar_Tv"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales"=>array("cantidad"=>0,"puntuacion"=>0),
                                "puntos_adicionales_multiples"=>array("cantidad"=>0,"puntuacion"=>0));
                        }else if($key2=="instalaciones_Revision"){
                                $lista_datos_cuentas_tipos_por_tecnico[$key2][$value['username']]=array("Revision_de_Internet"=>array("cantidad"=>0,"puntuacion"=>0),
                                "Revision_de_television"=>array("cantidad"=>0,"puntuacion"=>0));
                        }else if($key2=="instalaciones_veeduria" ||$key2=="instalaciones_recuperacion_cable_modem" ||$key2=="instalaciones_Suspension_Television" ||$key2=="instalaciones_Suspension_Internet" ||$key2=="instalaciones_Suspension_Combo" || $key2=="instalaciones_Corte_Tv" || $key2=="instalaciones_Corte_Tv" || $key2=="instalaciones_Corte_Internet" || $key2=="instalaciones_Corte_tv_e_internet" || $key2=="instalaciones_Reconexion_tv_e_internet" || $key2=="instalaciones_Reconexion_tv" || $key2=="instalaciones_Reconexion_internet" || $key2=="instalaciones_Revision_tv_e_internet" || $key2=="instalaciones_Revision_tv" || $key2=="instalaciones_Revision_internet" || $key2=="instalaciones_migracion" || $key2=="tareas_en_proyectos"){
                                $lista_datos_cuentas_tipos_por_tecnico[$key2][$value['username']]=array("cantidad"=>0,"puntuacion"=>0);
                        }else{
                            $lista_datos_cuentas_tipos_por_tecnico[$key2][$value['username']]=0;
                        }
                       

                   }
            }

foreach ($est as $key => $value) {
    //var_dump($value);
    
    $key1=$value['fecha1'];
    $value['detalle']=mb_strtolower($value['detalle'],"UTF-8");
    $value['section']=mb_strtolower($value['section'],"UTF-8");
    if($value['tec_asignado']==""){
        $value['tec_asignado']="Sin_Asignar";
    }
    if($value['detalle']=="instalacion"){
        //var_dump($value);
            
            $x1=strpos($value['section'], "mega");
            $x2=strpos($value['section'], "television");
            $x3=strpos($value['section'], "mg");
            $x4=strpos($value['section'], "tv");
            $x5=strpos($value['section'], "internet");
            $x7=strpos($value['section'], "mb");
            if(($x1!==false || $x3!==false || $x5!==false || $x7!==false) && ($x2!==false || $x4!==false)){
                $lista_datos['instalaciones_tv_e_internet'][$key1]++;
                $lista_datos['total_dia'][$key1]++;
                
                //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;

                $invoice=$this->db->get_where("invoices",array("tid"=>$value['id_factura_orden']))->row();
                $equipo=$this->db->get_where("equipos",array("asignado"=>$invoice->csd))->row();
                if(isset($equipo)){
                    if($equipo->t_instalacion=="FTTH"){
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['FTTH']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_instalaciones_FTTH;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['FTTH']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_instalaciones_FTTH;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_FTTH;
                    }else if($equipo->t_instalacion=="EOC"){
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['EOC']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_instalaciones_EOC;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['EOC']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_instalaciones_EOC;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                    }else{
                        /*var_dump("inicio 4");
                                var_dump($value);
                                var_dump($invoice);
                                var_dump($equipo);
                                var_dump("fin");*/
                                $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                               
                    }

                }else{ //esto son las que por alguna razon ya no tienen un equipo asignado
                        //$lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]++;//esta es para las cuentas diarias de tipo de servicio por dia
                        //$lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]++;//esta para la totalizacion del tipo de servicio por tecnico    
                            /*var_dump("inicio 3");
                                var_dump($value);
                                var_dump($invoice);
                                var_dump($equipo);
                                var_dump("fin");*/
                                $lista_tecnicos_organizada['instalaciones_tv'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_tv'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv'][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                }

                if($invoice->puntos=="1" || $invoice->puntos==1){
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_punto_adicional;
                }else if($invoice->puntos>=2){
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional_multiple;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['puntos_adicionales_multiples']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]['puntos_adicionales_multiples']['puntuacion']+=$puntuacion_punto_adicional_multiple;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_punto_adicional_multiple;
                }
                
            }else{
                if($x1===false && $x3===false && $x5===false && $x7===false){                    
                    $lista_datos['instalaciones_tv'][$key1]++;   
                    $lista_datos['total_dia'][$key1]++;
                    $lista_tecnicos_organizada['instalaciones_tv'][$key1][$value['tec_asignado']]++;
                    //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;//al final creo que se puede elimianar este array
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv'][$value['tec_asignado']]++;

                    $lista_tecnicos_organizada['instalaciones_tv'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_tv'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv'][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                }
                if($x2===false && $x4===false ){
                        $lista_datos['instalaciones_internet'][$key1]++;   
                        $lista_datos['total_dia'][$key1]++;
                        
                        //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;

                            $invoice=$this->db->get_where("invoices",array("tid"=>$value['id_factura_orden']))->row();
                            $equipo=$this->db->get_where("equipos",array("asignado"=>$invoice->csd))->row();
                            if(isset($equipo)){
                                if($equipo->t_instalacion=="FTTH"){
                                    $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['FTTH']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_instalaciones_FTTH;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['FTTH']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_instalaciones_FTTH;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_FTTH;
                                }else if($equipo->t_instalacion=="EOC"){
                                    $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['EOC']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['EOC']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                                }else{
                                    /*var_dump("inicio 1");
                                var_dump($value);
                                var_dump($invoice);
                                var_dump($equipo);
                                var_dump("fin");*/
                                     $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                               
                                }

                            }else{ //esto son las que por alguna razon ya no tienen un equipo asignado
                                    //$lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]++;//esta es para las cuentas diarias de tipo de servicio por dia
                                    //$lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]++;//esta para la totalizacion del tipo de servicio por tecnico    
                               /* var_dump("inicio 2");
                                var_dump($value);
                                var_dump($invoice);
                                var_dump($equipo);
                                var_dump("fin");*/
                                $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_internet'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_internet'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                               
                            }
                        
                        
                }    
            }
            
                

    }else if($value['detalle']=="agregartelevision"){
        $lista_datos['instalaciones_Agregar_Tv'][$key1]++;        
        $lista_datos['total_dia'][$key1]++;
        //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;
        
        $invoice=$this->db->get_where("invoices",array("tid"=>$value['id_factura_orden']))->row();

                        $lista_tecnicos_organizada['instalaciones_Agregar_Tv'][$key1][$value['tec_asignado']]['Agregar_Tv']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_Agregar_Tv'][$key1][$value['tec_asignado']]['Agregar_Tv']['puntuacion']+=$puntuacion_agregar_tv;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$value['tec_asignado']]['Agregar_Tv']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$value['tec_asignado']]['Agregar_Tv']['puntuacion']+=$puntuacion_agregar_tv;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_agregar_tv;
                if($invoice->puntos=="1" || $invoice->puntos==1){
                        $lista_tecnicos_organizada['instalaciones_Agregar_Tv'][$key1][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_Agregar_Tv'][$key1][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_punto_adicional;
                }else if($invoice->puntos>=2){
                        $lista_tecnicos_organizada['instalaciones_Agregar_Tv'][$key1][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_Agregar_Tv'][$key1][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional_multiple;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$value['tec_asignado']]['puntos_adicionales_multiples']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Agregar_Tv'][$value['tec_asignado']]['puntos_adicionales_multiples']['puntuacion']+=$puntuacion_punto_adicional_multiple;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_punto_adicional_multiple;
                }
    }else if($value['detalle']=="agregarinternet"){
        $lista_datos['instalaciones_AgregarInternet'][$key1]++;        
        $lista_datos['total_dia'][$key1]++;
        //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;


                            $invoice=$this->db->get_where("invoices",array("tid"=>$value['id_factura_orden']))->row();
                            $equipo=$this->db->get_where("equipos",array("asignado"=>$invoice->csd))->row();
                            //si no aparece es porque no tiene equipo asignado

                            if(isset($equipo)){
                                if($equipo->t_instalacion=="FTTH"){
                                    $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['FTTH']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_agregar_internet_FTTH;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['FTTH']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_agregar_internet_FTTH;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_agregar_internet_FTTH;
                                }else if($equipo->t_instalacion=="EOC"){
                                    $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['EOC']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['EOC']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                                }else{
                                    $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                                }

                            }else{ //esto son las que por alguna razon ya no tienen un equipo asignado
                                    //$lista_tecnicos_organizada['instalaciones_tv_e_internet'][$key1][$value['tec_asignado']]++;//esta es para las cuentas diarias de tipo de servicio por dia
                                    //$lista_datos_cuentas_tipos_por_tecnico['instalaciones_tv_e_internet'][$value['tec_asignado']]++;//esta para la totalizacion del tipo de servicio por tecnico    
                                /*var_dump("inicio");
                                var_dump($value);
                                var_dump($invoice);
                                var_dump($equipo);
                                var_dump("fin"); sin teg*/
                                $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_tecnicos_organizada['instalaciones_AgregarInternet'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['TV']['cantidad']++;
                                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_AgregarInternet'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_instalaciones_EOC;
                                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_instalaciones_EOC;
                            }


        
    }else if($value['detalle']=="traslado"){
        $lista_datos['instalaciones_Traslado'][$key1]++;        
        $lista_datos['total_dia'][$key1]++;
        //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;


        $invoice=$this->db->get_where("invoices",array("tid"=>$value['id_factura_orden']))->row();
        $equipo=$this->db->get_where("equipos",array("asignado"=>$invoice->csd))->row();
        if(isset($equipo)){
            if($equipo->t_instalacion=="FTTH"){
                $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['FTTH']['cantidad']++;
                $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_traslado_FTTH;
                $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['FTTH']['cantidad']++;
                $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['FTTH']['puntuacion']+=$puntuacion_traslado_FTTH;
                $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_traslado_FTTH;
            }else if($equipo->t_instalacion=="EOC"){
                $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['EOC']['cantidad']++;
                $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_traslado_EOC;
                $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['EOC']['cantidad']++;
                $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_traslado_EOC;
                $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_traslado_EOC;
            }

        }else{ //esto son las que por alguna razon ya no tienen un equipo asignado
                // $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]++;
        
                //$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]++;
            $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['TV']['cantidad']++;
                $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_traslado_EOC;
                $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['TV']['cantidad']++;
                $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['TV']['puntuacion']+=$puntuacion_traslado_EOC;
                $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_traslado_EOC;
            /*var_dump("inicio");
            var_dump($value);
            var_dump($invoice);
            var_dump($equipo);
            var_dump("fin");*/
        }

       
    }else if(strpos($value['detalle'], "revision")!==false){
        


        

            $x2=strpos($value['detalle'], "television");            
            $x4=strpos($value['detalle'], "tv");
            $x5=strpos($value['detalle'], "internet");
            $x7=strpos($value['detalle'], "combo");
//$key=="instalaciones_Revision_tv_e_internet" || $key=="instalaciones_Revision_tv" || $key=="instalaciones_Revision_internet"
            if($x7!==false){
                //if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Revision_tv_e_internet'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Revision_tv_e_internet'][$key1][$value['tec_asignado']]['puntuacion']+=($puntuacion_revision_tv+$puntuacion_revision_internet);
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv_e_internet'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv_e_internet'][$value['tec_asignado']]['puntuacion']+=($puntuacion_revision_tv+$puntuacion_revision_internet);
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=($puntuacion_revision_tv+$puntuacion_revision_internet);
                //}
                $lista_datos['instalaciones_Revision_tv_e_internet'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }else if($x2!==false || $x4!==false){
                //if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Revision_tv'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Revision_tv'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_revision_tv;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_tv'][$value['tec_asignado']]['puntuacion']+=$puntuacion_revision_tv;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_revision_tv;
                //}
                $lista_datos['instalaciones_Revision_tv'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }else if($x5!==false){
               // if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Revision_internet'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Revision_internet'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_revision_internet;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_internet'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision_internet'][$value['tec_asignado']]['puntuacion']+=$puntuacion_revision_internet;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_revision_internet;
                //}
                $lista_datos['instalaciones_Revision_internet'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }
            
        //$lista_tecnicos_organizada['instalaciones_Revision'][$key1][$value['tec_asignado']]++;        
        //$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Revision'][$value['tec_asignado']]++;    
    }else if(strpos($value['detalle'], "reconexion")!==false){
       
            $x2=strpos($value['detalle'], "television");            
            $x4=strpos($value['detalle'], "tv");
            $x5=strpos($value['detalle'], "internet");
            $x7=strpos($value['detalle'], "combo");
        //$key2=="instalaciones_Reconexion_tv_e_internet" || $key2=="instalaciones_Reconexion_tv" || $key2=="instalaciones_Reconexion_internet"
            if($x7!==false){
                //if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Reconexion_tv_e_internet'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Reconexion_tv_e_internet'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_reconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv_e_internet'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv_e_internet'][$value['tec_asignado']]['puntuacion']+=$puntuacion_reconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_reconexion;
                //}
                $lista_datos['instalaciones_Reconexion_tv_e_internet'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }else if($x2!==false || $x4!==false){
                //if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Reconexion_tv'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Reconexion_tv'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_reconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_tv'][$value['tec_asignado']]['puntuacion']+=$puntuacion_reconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_reconexion;
                //}
                $lista_datos['instalaciones_Reconexion_tv'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }else if($x5!==false){
               // if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Reconexion_internet'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Reconexion_internet'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_reconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_internet'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Reconexion_internet'][$value['tec_asignado']]['puntuacion']+=$puntuacion_reconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_reconexion;
                //}
                $lista_datos['instalaciones_Reconexion_internet'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }
        
    }else if($value['detalle']=="suspension combo"){
     
              $lista_datos['instalaciones_Suspension_Combo'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
            //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;
                    $lista_tecnicos_organizada['instalaciones_Suspension_Combo'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Suspension_Combo'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Combo'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Combo'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
                          
    }else if($value['detalle']=="suspension internet"){
         $lista_datos['instalaciones_Suspension_Internet'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
            //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;
                    $lista_tecnicos_organizada['instalaciones_Suspension_Internet'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Suspension_Internet'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Internet'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Internet'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
          
    }else if($value['detalle']=="suspension television"){
        $lista_datos['instalaciones_Suspension_Television'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
            //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;
                    $lista_tecnicos_organizada['instalaciones_Suspension_Television'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Suspension_Television'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Television'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Suspension_Television'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
    }else if(strpos($value['detalle'], "corte")!==false){
        
        

       
            $x2=strpos($value['detalle'], "television");            
            $x4=strpos($value['detalle'], "tv");
            $x5=strpos($value['detalle'], "internet");
            $x7=strpos($value['detalle'], "combo");

        //$key=="instalaciones_Corte_Tv" || $key=="instalaciones_Corte_Internet" || $key=="instalaciones_Corte_tv_e_internet"
                
        //if($value['tec_asignado']!=""){
            if($x7!==false){
                //if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Corte_tv_e_internet'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Corte_tv_e_internet'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_tv_e_internet'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_tv_e_internet'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
                //}
                $lista_datos['instalaciones_Corte_tv_e_internet'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }else if($x2!==false || $x4!==false){
                //if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Corte_Tv'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Corte_Tv'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Tv'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Tv'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
                //}
                $lista_datos['instalaciones_Corte_Tv'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }else if($x5!==false){
               // if($value['tec_asignado']!=""){
                    $lista_tecnicos_organizada['instalaciones_Corte_Internet'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Corte_Internet'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Internet'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Corte_Internet'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
                //}
                $lista_datos['instalaciones_Corte_Internet'][$key1]++;        
                $lista_datos['total_dia'][$key1]++;
            }
        //}

        
        
    }else if($value['detalle']=="migracion"){
            $lista_datos['instalaciones_migracion'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
            //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;


            $invoice=$this->db->get_where("invoices",array("tid"=>$value['id_factura_orden']))->row();
            $equipo=$this->db->get_where("equipos",array("asignado"=>$invoice->csd))->row();
            if(isset($equipo)){
                if($equipo->t_instalacion=="FTTH"){
                    $lista_tecnicos_organizada['instalaciones_migracion'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_migracion'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_migracion_FTTH;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_migracion'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_migracion'][$value['tec_asignado']]['puntuacion']+=$puntuacion_migracion_FTTH;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_migracion_FTTH;
                }else if($equipo->t_instalacion=="EOC"){
                    /*$lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['EOC']['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_traslado_EOC;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['EOC']['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]['EOC']['puntuacion']+=$puntuacion_traslado_EOC;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_traslado_EOC;
                    */
                }

            }else{ //esto son las que por alguna razon ya no tienen un equipo asignado
                    // $lista_tecnicos_organizada['instalaciones_Traslado'][$key1][$value['tec_asignado']]++;
            
                    //$lista_datos_cuentas_tipos_por_tecnico['instalaciones_Traslado'][$value['tec_asignado']]++;
            }
    }else if($value['detalle']=="punto nuevo"){
            $lista_datos['instalaciones_punto_nuevo'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
        //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;
        
        $invoice=$this->db->get_where("invoices",array("tid"=>$value['id_factura_orden']))->row();
        $px=0;
                if($invoice->puntos=="0"|| $invoice->puntos==0 || $invoice->puntos=="1" || $invoice->puntos==1){$px=$puntuacion_punto_adicional;
                        $lista_tecnicos_organizada['instalaciones_punto_nuevo'][$key1][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_punto_nuevo'][$key1][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_punto_adicional;
                }else if($invoice->puntos>=2){$px=$puntuacion_punto_adicional_multiple;
                        $lista_tecnicos_organizada['instalaciones_punto_nuevo'][$key1][$value['tec_asignado']]['puntos_adicionales']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_punto_nuevo'][$key1][$value['tec_asignado']]['puntos_adicionales']['puntuacion']+=$puntuacion_punto_adicional_multiple;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'][$value['tec_asignado']]['puntos_adicionales_multiples']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'][$value['tec_asignado']]['puntos_adicionales_multiples']['puntuacion']+=$puntuacion_punto_adicional_multiple;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_punto_adicional_multiple;
                }

                         $lista_tecnicos_organizada['instalaciones_punto_nuevo'][$key1][$value['tec_asignado']]['Agregar_Tv']['cantidad']++;
                        $lista_tecnicos_organizada['instalaciones_punto_nuevo'][$key1][$value['tec_asignado']]['Agregar_Tv']['puntuacion']+=$px;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'][$value['tec_asignado']]['Agregar_Tv']['cantidad']++;
                        $lista_datos_cuentas_tipos_por_tecnico['instalaciones_punto_nuevo'][$value['tec_asignado']]['Agregar_Tv']['puntuacion']+=$px;
                        $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$px;
             
    }else if($value['detalle']=="recuperación cable modem"){

            $lista_datos['instalaciones_recuperacion_cable_modem'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
            //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;
                    $lista_tecnicos_organizada['instalaciones_recuperacion_cable_modem'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_recuperacion_cable_modem'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_recuperacion_cable_modem'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_recuperacion_cable_modem'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
    }else if($value['detalle']=="veeduria"){
        
                $lista_datos['instalaciones_veeduria'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
            //$lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]++;
                    $lista_tecnicos_organizada['instalaciones_veeduria'][$key1][$value['tec_asignado']]['cantidad']++;
                    $lista_tecnicos_organizada['instalaciones_veeduria'][$key1][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_veeduria'][$value['tec_asignado']]['cantidad']++;
                    $lista_datos_cuentas_tipos_por_tecnico['instalaciones_veeduria'][$value['tec_asignado']]['puntuacion']+=$puntuacion_desconexion;
                    $lista_tecnicos_organizada['total_dia'][$key1][$value['tec_asignado']]+=$puntuacion_desconexion;
    }
 
}

foreach ($lista_tareas as $key => $value) {
    $key1=$value['start'];
    if(isset($lista_tecnicos_organizada['tareas_en_proyectos'][$key1][$value['username']])){
            $lista_datos['tareas_en_proyectos'][$key1]++;        
            $lista_datos['total_dia'][$key1]++;
            $lista_tecnicos_organizada['tareas_en_proyectos'][$key1][$value['username']]['cantidad']++;
            $lista_tecnicos_organizada['tareas_en_proyectos'][$key1][$value['username']]['puntuacion']+=intval($value['puntuacion']);
            $lista_datos_cuentas_tipos_por_tecnico['tareas_en_proyectos'][$value['username']]['cantidad']++;
            $lista_datos_cuentas_tipos_por_tecnico['tareas_en_proyectos'][$value['username']]['puntuacion']+=intval($value['puntuacion']);
            $lista_tecnicos_organizada['total_dia'][$key1][$value['username']]+=intval($value['puntuacion']);
     
    }
}

        /*$lista_datos=array();

        $lista_datos['instalaciones_tv_e_internet']=$this->db->query($header_sql.' tickets.detalle="Instalacion" and tickets.section like "%mega%" and tickets.section like "%Television%" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_tv']=$this->db->query($header_sql.' tickets.detalle="Instalacion" and tickets.section not like "%mega%" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_internet']=$this->db->query($header_sql.' tickets.detalle="Instalacion" and tickets.section not like "%Television%"  '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Agregar_Tv']=$this->db->query($header_sql.' tickets.detalle="AgregarTelevision" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_AgregarInternet']=$this->db->query($header_sql.' tickets.detalle="AgregarInternet" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Traslado']=$this->db->query($header_sql.' tickets.detalle="Traslado" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Revision']=$this->db->query($header_sql.' tickets.detalle like"%Revision%" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Reconexion']=$this->db->query($header_sql.' tickets.detalle like "%Reconexion%" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Suspension_Combo']=$this->db->query($header_sql.' tickets.detalle="Suspension Combo" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Suspension_Internet']=$this->db->query($header_sql.' tickets.detalle="Suspension Internet" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Suspension_Television']=$this->db->query($header_sql.' tickets.detalle="Suspension Television" '.$footer_sql)->result_array();
        $lista_datos['instalaciones_Corte_Television']=$this->db->query($header_sql.' tickets.detalle="Corte Television" '.$footer_sql)->result_array();
        //para seguir agregando ordenes segun el tipo apartir de aca
        

        $lista_datos['total_dia']=$this->db->query(($header_sql.' '.substr($footer_sql,5)))->result_array();//el subtring es para quitar el and de el footer
*/
        $footer_sql=str_replace("Resuelto","Pendiente",$footer_sql);//el replace para cambiar por pendientes
        $footer_sql=str_replace("fecha_final","created",$footer_sql);//el subtring es para quitar el and de el footer y el replace es para filtrar en ves de con fecha final con created

        $lista_datos['pendientes']=$this->db->query('SELECT count(idt) as numero, datetable.date as fecha1 
            from datetable left join (select * from tickets 
            join customers on tickets.cid=customers.id where '.$footer_sql." GROUP by datetable.date ")->result_array();
        $lista_datos['cuantos_dias_a_imprimir']=intval($fecha->format("t"));
        
        return array("lista_tecnicos_organizada"=>$lista_tecnicos_organizada,"lista_datos"=>$lista_datos,"lista_tecnicos"=>$lista_tecnicos,"lista_datos_cuentas_tipos_por_tecnico"=>$lista_datos_cuentas_tipos_por_tecnico);
    }


	


    //expense statement


    public function expensestatement()
    {


        $this->db->select_sum('debit');
        $this->db->from('transactions');

        $this->db->where('type', 'Expense');
        $this->db->where('estado');
        $this->db->where('tid!=',-1);
        $month = date('Y-m');
        $today = date('Y-m-d');
        $this->db->where('DATE(date) >=', "$month-01");
        $this->db->where('DATE(date) <=', $today);

        $query = $this->db->get();
        $result = $query->row_array();

        $motnhbal = $result['debit'];
        return array('monthinc' => $motnhbal);

    }

    public function customexpensestatement($acid, $sdate, $edate)
    {


        $this->db->select_sum('debit');
        $this->db->from('transactions');
        $this->db->where('estado');
        if ($acid > 0) {
            $this->db->where('acid', $acid);
        }
        $this->db->where('type', 'Expense');
        $this->db->where('DATE(date) >=', $sdate);
        $this->db->where('DATE(date) <=', $edate);
        // $this->db->where("DATE(date) BETWEEN '$sdate' AND '$edate'");
        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    public function statistics($limit = false)
    {
        $this->db->from('reports');
        // if($limit) $this->db->limit(12);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
	
    public function get_estadisticas_tecnicos($tec, $sede, $sdate){
        


        $filtro_tecnico="";
        $fecha =new DateTime($sdate);
        if ($tec != 'all') {

            $emp=$this->db->query("SELECT GROUP_CONCAT(id_movil) as ids FROM `empleados_moviles` join aauth_users on empleados_moviles.id_empleado=aauth_users.id WHERE aauth_users.username ='".$tec."'")->result_array();
            $in='';
            if(isset($emp[0]['ids']) && $emp[0]['ids']!=null){
                $filtro_tecnico=" and (tickets.asignado='".$tec."' or tickets.asignacion_movil in(".$emp[0]['ids']."))";
                
            }else{
                $filtro_tecnico=' and tickets.asignado="'.$tec.'"';    
            }
            
        }
        //, datetable.date
        /*$header_sql='SELECT count(idt) as numero,YEAR(datetable.date) as year,MONTH(datetable.date) as month
            from datetable left join (select * from tickets 
            join customers on tickets.cid=customers.id where';

            $footer_sql=' and tickets.status="Resuelto" and 
            customers.gid='.$sede.' '.$filtro_tecnico.') as t1 
            on datetable.date = date_format(t1.fecha_final,"%Y-%m-%d") 
            where datetable.date BETWEEN date_format("'.(date("Y-m-d",strtotime($fecha->format("Y-m")."-01"."- 1 year"))).'","%Y-%m-%d") 
            and date_format("'.$fecha->format("Y-m-t").'","%Y-%m-%d")
            GROUP by YEAR(datetable.date),MONTH(datetable.date)';*/
$date1=date("Y-m-d",strtotime($fecha->format("Y-m")."-01"."- 1 year"));
            $header_sql='SELECT  t1.detalle as detalle,t1.section as section, YEAR(datetable.date) as year,MONTH(datetable.date) as month
            from datetable left join (select * from tickets 
            join customers on tickets.cid=customers.id where';
$texto_sede="";
if($sede!="all"){
    $texto_sede=" and customers.gid=".$sede;
}
        $footer_sql='  tickets.status="Resuelto" '.$texto_sede.' '.$filtro_tecnico.') as t1 
            on datetable.date = date_format(t1.fecha_final,"%Y-%m-%d") 
            where datetable.date BETWEEN date_format("'.($date1).'","%Y-%m-%d") 
            and date_format("'.$fecha->format("Y-m-t").'","%Y-%m-%d")';
            //GROUP by YEAR(datetable.date),MONTH(datetable.date)';
		//nuevo codigo //falta utilizar el last_date($fecha); y colocar $fecha->format("Y-m")."01"; para el tema de las fechas
        $estadistica=array();
		
        $est=$this->db->query($header_sql." ".$footer_sql)->result_array();
        $estadistica['instalaciones_tv_e_internet']=array();
        $estadistica['instalaciones_tv']=array();
        $estadistica['instalaciones_internet']=array();
        $estadistica['instalaciones_Agregar_Tv']=array();
        $estadistica['instalaciones_AgregarInternet']=array();
        $estadistica['instalaciones_Traslado']=array();
        $estadistica['instalaciones_Revision']=array();
        $estadistica['instalaciones_Reconexion']=array();
        $estadistica['instalaciones_Suspension_Combo']=array();
        $estadistica['instalaciones_Suspension_Internet']=array();
        $estadistica['instalaciones_Suspension_Television']=array();
        $estadistica['instalaciones_Corte_Television']=array();

        for ($i=0; $i <=12 ; $i++) { 
            if($i!=0){
                $date1=date("Y-m",strtotime($date1."+ 1 month"))."-01"; 
                //var_dump($date1);
            }            
            foreach ($estadistica as $key => $value) {
                $estadistica[$key][$date1]=0;
            }
            /*$estadistica['instalaciones_tv']['fecha']=$date1;$estadistica['instalaciones_internet']['fecha']=$date1;$estadistica['instalaciones_Agregar_Tv']['fecha']=$date1;$estadistica['instalaciones_AgregarInternet']=$date1;$estadistica['instalaciones_Traslado']['fecha']=$date1;$estadistica['instalaciones_Revision']['fecha']=$date1;$estadistica['instalaciones_Reconexion']['fecha']=$date1;$estadistica['instalaciones_Suspension_Combo']['fecha']=$date1;$estadistica['instalaciones_Suspension_Internet']['fecha']=$date1;$estadistica['instalaciones_Suspension_Television']['fecha']=$date1;$estadistica['instalaciones_Corte_Television']['fecha']=$date1;*/


        }

foreach ($est as $key => $value) {
    //var_dump($value);
    if($value['month']<10){
        $value['month']="0".$value['month'];
    }
    $key1=$value['year']."-".$value['month']."-01";
    $value['detalle']=strtolower($value['detalle']);
    $value['section']=strtolower($value['section']);
    if($value['detalle']=="instalacion"){
        //var_dump($value);
            
            $x1=strpos($value['section'], "mega");
            $x2=strpos($value['section'], "television");
            $x3=strpos($value['section'], "mg");
            $x4=strpos($value['section'], "tv");
            $x5=strpos($value['section'], "internet");
            $x7=strpos($value['section'], "mb");
            if(($x1!==false || $x3!==false || $x5!==false || $x7!==false) && ($x2!==false || $x4!==false)){
                $estadistica['instalaciones_tv_e_internet'][$key1]++;
            }else{
                if($x1===false && $x3===false && $x5===false && $x7===false){                    
                    $estadistica['instalaciones_tv'][$key1]++;   
                }
                if($x2===false && $x4===false ){
                        $estadistica['instalaciones_internet'][$key1]++;   
                }    
            }
            
            

    }else if($value['detalle']=="agregartelevision"){
        $estadistica['instalaciones_Agregar_Tv'][$key1]++;        
    }else if($value['detalle']=="agregarinternet"){
        $estadistica['instalaciones_AgregarInternet'][$key1]++;        
    }else if($value['detalle']=="traslado"){
        $estadistica['instalaciones_Traslado'][$key1]++;        
    }else if(strpos($value['detalle'], "revision")!==false){
        $estadistica['instalaciones_Revision'][$key1]++;        
    }else if(strpos($value['detalle'], "reconexion")!==false){
        $estadistica['instalaciones_Reconexion'][$key1]++;        
    }else if($value['detalle']=="suspension combo"){
        $estadistica['instalaciones_Suspension_Combo'][$key1]++;        
    }else if($value['detalle']=="suspension internet"){
        $estadistica['instalaciones_Suspension_Internet'][$key1]++;        
    }else if($value['detalle']=="suspension television"){
        $estadistica['instalaciones_Suspension_Television'][$key1]++;        
    }else if($value['detalle']=="corte television"){
        $estadistica['instalaciones_Corte_Television'][$key1]++;        
    }

}
        /*
        $estadistica['instalaciones_tv_e_internet']=$this->db->query($header_sql.' tickets.detalle="Instalacion" and tickets.section like "%mega%" and tickets.section like "%Television%"  '.$footer_sql)->result_array();
        $estadistica['instalaciones_tv']=$this->db->query($header_sql.' tickets.detalle="Instalacion" and tickets.section not like "%mega%" '.$footer_sql)->result_array();
        $estadistica['instalaciones_internet']=$this->db->query($header_sql.' tickets.detalle="Instalacion" and tickets.section not like "%Television%"  '.$footer_sql)->result_array();
        $estadistica['instalaciones_Agregar_Tv']=$this->db->query($header_sql.' tickets.detalle="AgregarTelevision" '.$footer_sql)->result_array();
        $estadistica['instalaciones_AgregarInternet']=$this->db->query($header_sql.' tickets.detalle="AgregarInternet" '.$footer_sql)->result_array();
        $estadistica['instalaciones_Traslado']=$this->db->query($header_sql.' tickets.detalle="Traslado" '.$footer_sql)->result_array();
        $estadistica['instalaciones_Revision']=$this->db->query($header_sql.' tickets.detalle like"%Revision%" '.$footer_sql)->result_array();
        $estadistica['instalaciones_Reconexion']=$this->db->query($header_sql.' tickets.detalle like "%Reconexion%" '.$footer_sql)->result_array();
        $estadistica['instalaciones_Suspension_Combo']=$this->db->query($header_sql.' tickets.detalle="Suspension Combo" '.$footer_sql)->result_array();
        $estadistica['instalaciones_Suspension_Internet']=$this->db->query($header_sql.' tickets.detalle="Suspension Internet" '.$footer_sql)->result_array();
        $estadistica['instalaciones_Suspension_Television']=$this->db->query($header_sql.' tickets.detalle="Suspension Television" '.$footer_sql)->result_array();
        $estadistica['instalaciones_Corte_Television']=$this->db->query($header_sql.' tickets.detalle="Corte Television" '.$footer_sql)->result_array();*/
        //para seguir agregando ordenes segun el tipo apartir de aca
		//echo date("d-m-Y",strtotime($fecha->format("Y-m")."-01"."- 1 year"));

        return $estadistica;
    }
	public function tickets()
    {
		$this->db->select('*');
        $this->db->from('tickets');
        // if($limit) $this->db->limit(12);
        //$this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
	

    public function get_customer_statements($pay_acc, $trans_type, $sdate, $edate)
    {

        if ($trans_type == 'All') {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND ext=0";
        } else {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type' AND ext=0";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        //  $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function get_supplier_statements($pay_acc, $trans_type, $sdate, $edate)
    {

        if ($trans_type == 'All') {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND ext=1";
        } else {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type' AND ext=1";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        //  $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }


}

