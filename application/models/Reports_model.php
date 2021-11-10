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
        $header_sql='SELECT count(idt) as numero, datetable.date as fecha1 
            from datetable left join (select * from tickets 
            join customers on tickets.cid=customers.id where';

        $footer_sql=' and tickets.status="Resuelto" and 
            customers.gid='.$sede.' '.$filtro_tecnico.') as t1 
            on datetable.date = date_format(t1.fecha_final,"%Y-%m-%d") 
            where datetable.date BETWEEN date_format("'.$fecha->format("Y-m").'-01","%Y-%m-%d") 
            and date_format("'.$fecha->format("Y-m-t").'","%Y-%m-%d")
            GROUP by datetable.date';

        //nuevo codigo //falta utilizar el last_date($fecha); y colocar $fecha->format("Y-m")."01"; para el tema de las fechas
        $lista_datos=array();

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

        $footer_sql=str_replace("Resuelto","Pendiente",$footer_sql);//el replace para cambiar por pendientes
        $footer_sql=substr(str_replace("fecha_final","created",$footer_sql),5);//el subtring es para quitar el and de el footer y el replace es para filtrar en ves de con fecha final con created

        $lista_datos['pendientes']=$this->db->query($header_sql.' '.$footer_sql)->result_array();
        $lista_datos['cuantos_dias_a_imprimir']=intval($fecha->format("t"));
        
        return $lista_datos;
    }


	


    //expense statement


    public function expensestatement()
    {


        $this->db->select_sum('debit');
        $this->db->from('transactions');

        $this->db->where('type', 'Expense');
        $this->db->where('estado');
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
        $header_sql='SELECT count(idt) as numero,YEAR(datetable.date) as year,MONTH(datetable.date) as month
            from datetable left join (select * from tickets 
            join customers on tickets.cid=customers.id where';

        $footer_sql=' and tickets.status="Resuelto" and 
            customers.gid='.$sede.' '.$filtro_tecnico.') as t1 
            on datetable.date = date_format(t1.fecha_final,"%Y-%m-%d") 
            where datetable.date BETWEEN date_format("'.(date("Y-m-d",strtotime($fecha->format("Y-m")."-01"."- 1 year"))).'","%Y-%m-%d") 
            and date_format("'.$fecha->format("Y-m-t").'","%Y-%m-%d")
            GROUP by YEAR(datetable.date),MONTH(datetable.date)';
		//nuevo codigo //falta utilizar el last_date($fecha); y colocar $fecha->format("Y-m")."01"; para el tema de las fechas
        $estadistica=array();
		
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
        $estadistica['instalaciones_Corte_Television']=$this->db->query($header_sql.' tickets.detalle="Corte Television" '.$footer_sql)->result_array();
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

