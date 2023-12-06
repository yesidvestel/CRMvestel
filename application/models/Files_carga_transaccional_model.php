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

class Files_carga_transaccional_model extends CI_Model
{
    var $table="files_carga_transaccional";
    var $column_order = array("id","nombre","fecha","id_usuario","estado");
    var $column_search = array("nombre","fecha","id_usuario","estado");
    
    private function _get_datatables_query()
    {
        $this->db->select("fl1.id as id,fl1.nombre_real_file as nombre_real_file,fl1.nombre as nombre,fl1.fecha as fecha,fl1.estado as estado,us.username as username");
        $this->db->from($this->table." as fl1");
        $this->db->join("aauth_users as us","us.id=fl1.id_usuario");
        
        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        $this->db->order_by("fecha","desc");
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
		
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
		
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function facturar_customer($data,$cs){
        set_time_limit(150);
        ini_set ( 'max_execution_time', 150);
        
        $this->load->model('customers_model', 'customers');
$_POST['no_email']=true;
$_POST['EFECTY']=true;
//traer lista de todos los customers con ese documento, hacer la resta entre la deuda de cada cuenta y el monto a pagar, luego ejecutar pago de esa cuenta hasta terminar el saldo de $data->monto;
//$cuentas_del_usuario=$this->db->query("select * from customers where documento='".$cs->documento."'")->result_array();
//SELECT * FROM `invoices` inner join customers on invoices.csd=customers.id where customers.documento=1037570816 GROUP by invoices.csd;
$cuentas_del_usuario=$this->db->query("SELECT customers.id as csd_c FROM invoices inner join customers on invoices.csd=customers.id where customers.id='".$cs->id."' and invoices.total>0 GROUP by invoices.csd;")->result_array();
/*if($_SESSION[md5("variable_datos_pin")]['db_name']=="admin_vestel"){
    $cuentas_del_usuario=array();
}*/
$creo=false;
if(count($cuentas_del_usuario)>1){
foreach ($cuentas_del_usuario as $key => $value) {
        $due=$this->customers->due_details($value['csd_c']);
        $deuda=$due['total']-$due['pamnt'];
        $monto_pagar=$data->monto;
        if($deuda>0){
            if($data->monto>=$deuda && $key<(count($cuentas_del_usuario)-1) ){
                $monto_pagar=$deuda;
                $data->monto=$data->monto-$deuda;
            }else{
                $data->monto=0;
            }
            
            $creo=$this->customers->pay_invoices($value['csd_c'],$monto_pagar,$data->ref_efecty);
        }
        if($data->monto<=0){
            break;
        }
        
    } 
    if($data->monto>0){
         
            $creo=$this->customers->pay_invoices($cuentas_del_usuario[0]['csd_c'],$data->monto,$data->ref_efecty);
    }   
   
}else{
    //$creo=$this->customers->pay_invoices($cs->id,$data->monto,$data->ref_efecty);
    if(count($cuentas_del_usuario)==0){
        $creo=false;
    }else{
        $creo=$this->customers->pay_invoices($cuentas_del_usuario[0]['csd_c'],$data->monto,$data->ref_efecty);
    }
    
}
//falta condicionar que esto solo sea para ottis
if($_SESSION[md5("variable_datos_pin")]['db_name']=="admin_crmvestel"){
        $lista_invoices=$this->db->query("select * from invoices where csd=".$cs->id." and metodo_pago_f_e='credito' and total>0 and pamnt>=total")->result_array();
    if(count($lista_invoices)>0){
            $this->load->library('SiigoAPI');
            $api = new SiigoAPI();
            $api->getAuth(1);
            $_SESSION['api_siigox']=$api;
            $this->load->model("facturas_electronicas_model","facturas_electronicas");
            

            foreach ($lista_invoices as $key1 => $inv) {
                //obtener lista, recorrer y actualizar factura
                //si es apta, 
                $fecha_actualx=date("Y-m-d");
                //$datos=array("id_facturar"=>$inv['id'],"sdate"=>$fecha_actualx,"estcuenta"=>"6960");
                //$this->facturas_electronicas->generar_factura_customer_para_multiple_ottis($datos,$_SESSION['api_siigo']);   
                $_POST['invoice_actualizacion_fe']=$inv;
                $fe=$this->facturas_electronicas->get_invoice_credito($cs->documento,$inv['fecha_f_electronica_generada']);
                
            }
    }
}
        return $creo;
    }
    public function facturar_customer_copia_reanudar_para_pagos_equitativos($data,$cs){
        set_time_limit(150);
        ini_set ( 'max_execution_time', 150);
        
        $this->load->model('customers_model', 'customers');
$_POST['no_email']=true;
$_POST['EFECTY']=true;
//traer lista de todos los customers con ese documento, hacer la resta entre la deuda de cada cuenta y el monto a pagar, luego ejecutar pago de esa cuenta hasta terminar el saldo de $data->monto;
//$cuentas_del_usuario=$this->db->query("select * from customers where documento='".$cs->documento."'")->result_array();
//SELECT * FROM `invoices` inner join customers on invoices.csd=customers.id where customers.documento=1037570816 GROUP by invoices.csd;
$cuentas_del_usuario=$this->db->query("SELECT customers.id as csd_c FROM invoices inner join customers on invoices.csd=customers.id where customers.documento='".$cs->documento."' and invoices.total>0 GROUP by invoices.csd;")->result_array();
if($_SESSION[md5("variable_datos_pin")]['db_name']=="admin_vestel"){
    $cuentas_del_usuario=array();
}
$creo=false;
if(count($cuentas_del_usuario)>1){
$array_pago_users=array();
$monto_equitativo=($data->monto/count($cuentas_del_usuario));
$data_monto_resp=$data->monto;
$monto_sobrante=0;
$deuda_total=0;
$deuda_totalx=0;
$salir=true;
var_dump($monto_equitativo);echo "ss -- ";
do {
       foreach ($cuentas_del_usuario as $key => $value) {
            $due=$this->customers->due_details($value['csd_c']);
            $deuda=$due['total']-$due['pamnt'];

            $deuda_total=0;
            if(isset($array_pago_users[$value['csd_c']]['deuda'])){
                $deuda=$array_pago_users[$value['csd_c']]['deuda'];
            }
            $monto_pagar=$monto_equitativo;
            if($deuda>0){
                //$monto_pagar=$deuda;
                if($monto_equitativo>$deuda){
                    $monto_sobrante=$monto_sobrante+($monto_pagar-$deuda);
                    $monto_pagar=$deuda;
                    $deuda_total=0;
                }else if($monto_equitativo<$deuda){
                    $deuda_total=$deuda-$monto_equitativo;
                }else{
                    $deuda_total=0;
                }
            }else{
                $monto_sobrante+=$monto_equitativo;
                $monto_pagar=0;
                $deuda_total=0;
            }
            $deuda_totalx+=$deuda_total;
            $array_pago_users[$value['csd_c']]['monto_pagar']+=$monto_pagar;
            $array_pago_users[$value['csd_c']]['deuda']=$deuda_total;
           
            
    }
    var_dump($monto_sobrante);
    var_dump($array_pago_users);
    var_dump($deuda_totalx);
    if($monto_sobrante>0){
        $monto_equitativo=($monto_sobrante/count($cuentas_del_usuario));
        if($deuda_totalx>0){
            $deuda_totalx=0;
            $salir=false;    
        }else{
            foreach ($array_pago_users as $key => $value) {
                $array_pago_users[$key]['monto_pagar']+=$monto_equitativo;
            }
            $salir=true;
        }
        
        
        
        
    }else {
        $salir=true;
    }
} while (!$salir);
 
var_dump($array_pago_users);
exit();
foreach ($array_pago_users as $key => $value) {
    //$creo=$this->customers->pay_invoices($key,$value['monto_pagar'],$data->ref_efecty);
}
//nw code end
   
}else{
    //$creo=$this->customers->pay_invoices($cs->id,$data->monto,$data->ref_efecty);
    if(count($cuentas_del_usuario)==0){
        $creo=false;
    }else{
        $creo=$this->customers->pay_invoices($cuentas_del_usuario[0]['csd_c'],$data->monto,$data->ref_efecty);
    }
    
}

        
        return $creo;
    }
    public function recorrer_archivo_y_guardar_datos_inicial($id_file,$ruta){
            $this->load->library('ExcelReaderDuber');
            $reader= new ExcelReaderDuber();
            $reader=$reader->get_reader();
            $reader->setReadDataOnly(true);
            $spreadsheet=$reader->load($ruta);
            $sheet=$spreadsheet->getActiveSheet(0);
            //echo "<table>";
            $string_inserts="";
$fecha_actual=date("Y-m-d H:i:s");
if($_POST['cambiar_fecha']=="si"){
    $f1=new DateTime($_POST['sdate']);
    $fecha_actual=$f1->format("Y-m-d");
}
            foreach ($sheet->getRowIterator() as $key => $row) {
                    $cellIterator=$row->getCellIterator("a","e");
                    $cellIterator->setIterateOnlyExistingCells(false);
                   // echo "<tr><td>".$key."</td>";
                    if($key>1){
                        //$valido=true;
                        $in="";
                            $montox=0;
                            $documentox=0;
                            $ref_efecty=0;
                            $medio_pago="EFECTY";
                        foreach ($cellIterator as $key2 => $cell) {
                            if(!is_null($cell)){
                                $value=$cell->getValue();
                                if($key2=="C"){
                                    $montox=str_replace("$", "", $value);
                                    $montox=str_replace(".", "", $montox);
                                    $montox=intval($montox);

                                    //echo "<td>".$key2." - ".intval($montox)."</td>";
                                    //echo "<td>".$key2." - ".$value."</td>";
                                }else if($key2=="E"){
                                    $ref_efecty=$value;
                                    //echo "<td>".$key2." - ".$value."</td>";
                                }else if($key2=="B") {
                                    $documentox=$value;
                                }else if($key2=="D") {
                                    $medio_pago=$value;
                                    if($medio_pago=="" || $medio_pago==null){
                                        $medio_pago="EFECTY";
                                    }
                                }else if($key2=="A" && $_POST['cambiar_fecha']!="si") {
                                    //$medio_pago=$value;
                                    
                                    $excelDateValue=$value;
                                    $unixTimestamp = ($excelDateValue - 25568) * 86400;
                                    // Convertir a formato de fecha legible
                                    $formattedDate = date('Y-m-d', $unixTimestamp);                                    
                                    $fecha_actual=$formattedDate;
                                }
                            }
                        }//fin iteracion celdas
                        if($montox>0 && intval($documentox)>0){
                            if($string_inserts!=""){
                                $in=",";
                            }
                            $in.="('".$fecha_actual."', '".$documentox."', '".$montox."', 'Inicial', '".$id_file."','".$ref_efecty."','".$medio_pago."')";
                            $string_inserts.=$in;
                        }
                        

                    }//fin validacion >1
                    //echo "</tr>";
            }//fin iteracion filas
            if($string_inserts!=""){
                //echo $string_inserts;
                $x1="INSERT INTO datos_archivo_excel_cargue ( fecha, documento, monto, estado, id_archivo,ref_efecty,metodo_pago) VALUES ";
                $string_inserts=$x1.$string_inserts.";";
                //echo $string_inserts;
                $this->db->query($string_inserts);
            }
            //echo "<table>";

    }
    
}