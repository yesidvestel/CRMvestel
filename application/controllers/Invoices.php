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

class Invoices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < -1) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        if ($this->aauth->get_user()->roleid == 0) {
            $this->limited = $this->aauth->get_user()->id;
        } else {
            $this->limited = '';
        }

    }
public function notas(){
        $head['title'] = "Notas Debito/Credito";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/notas_credito_debito');
        $this->load->view('fixed/footer');

}
public function explortar_a_excel_notas(){
        
        $this->db->select("invoice_items.*,invoices.tid as itid,invoices.invoicedate,invoice_items.id as id2,customers.id as id3, customers.name");
        $this->db->from("invoice_items");
		$this->db->where_in("invoice_items.product",array("Nota Credito","Nota Debito"));
		$this->db->join("invoices","invoice_items.tid=invoices.tid", 'left');
        $this->db->join("customers","invoices.csd=customers.id", 'left');
        $this->db->order_by("fecha_creacion","DESC");
        $lista_debito=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_debito2=array();
		
    
    //define column headers
    $headers = array(
        'Id' => 'string', 
        '# Cuenta' => 'string', 
        'Fecha cuenta' => 'date',
		'Fcha creada' => 'datetime',
		'Usuario' => 'string',
		'Valor' => 'integer',
		'Tipo' => 'string',
		'Responsable' => 'string',
	);
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte Notas ');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte Notas ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Reporte Notas ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
));
    
    //write rows to sheet1
	
    foreach ($lista_debito as $key => $debito) {
		//$fecha = date("d/m/Y",strtotime($debito->fecha_creacion));
		 $us1=$this->db->get_where("employee_profile",array("id"=>$debito->id_usuario_crea))->row();
            $writer->writeSheetRow('Reporte Notas ',array($debito->id,$debito->tid,$debito->invoicedate,$debito->fecha_creacion,$debito->name,$debito->subtotal,$debito->product,$us1->name));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Notas '.$fecha_actual.'.xlsx';
    
    //write to xlsx file
    $writer->writeToFile($fileLocation);
    //echo $writer->writeToString();
    
    //force download
    header('Content-Description: File Transfer');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=".basename($fileLocation));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Length: ' . filesize($fileLocation)); //Remove

    ob_clean();
    flush();

    readfile($fileLocation);
    unlink($fileLocation);
    exit(0);
       

    }
public function notas_list(){
$this->load->model("Notas_model","notas");
    $list = $this->notas->get_datatables();
    $data = array();
    $no = $this->input->post('start');
    //setlocale(LC_TIME, "spanish");

    foreach ($list as $key => $value) { 
		
            $no++;  
            $row = array();
            $row[]=$value->id2;
            $row[]="<a href='".base_url()."invoices/view?id=".$value->tid."'>Fac. #".$value->tid."</a>";;
            $row[]=$value->invoicedate;
            if(isset($value->fecha_creacion)){
                $row[]=$value->fecha_creacion;    
            }else{
                $row[]="Sin Fecha";    
            }
            
            $row[]="<a href='".base_url()."customers/view?id=".$value->csd."'>".$value->name." ".$value->apellido."</a>";
            $row[]=amountFormat($value->subtotal);
            $row[]=$value->product;
            if(isset($value->id_usuario_crea)){
                $us1=$this->db->get_where("employee_profile",array("id"=>$value->id_usuario_crea))->row();
                 $row[]=$us1->name;  
            }else{
                $row[]="NN";    
            }
            
            $row[]='<a href="#" class="btn btn-danger btn-sm eliminar_nota" data-id="'.$value->id.'"><span class="icon-trash"></span></a>&nbsp';//"<div style='text-align:center'><a class='btn-small btn-info ver-mas'  data-descripcion='".$value->descripcion."'><i class='icon-book'></i></a></div>";
            $data[]=$row;

    }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->notas->count_all(),
            "recordsFiltered" => $this->notas->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
}
    //create invoice
    public function create()
    {
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->invocies->lastinvoice();			
        $data['warehouse'] = $this->invocies->warehouses();
		$data['sede'] = $this->invocies->sede();
		$ttype = $this->input->get('type');
		$data['paquete'] = $this->invocies->paquetes('tv');
		$data['paqueteinter'] = $this->invocies->paquetes('inter');
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $head['title'] = "New Invoice";
		$data['departamentos'] = $this->customers->departamentos_list();
        $data['servicios_por_sedes']=$this->invocies->get_servicios();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/newinvoice', $data);
        $this->load->view('fixed/footer');
    }	
     public function generar_facturas()
    {
        $this->load->model('customers_model', 'customers');
        $this->load->model('transactions_model');
        $head['title'] = "Generar Facturas";        
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/generar_facturas', $data);
        $this->load->view('fixed/footer');
    }
    public function generar_facturas_action(){
        set_time_limit(20000);
        
        $caja1=$this->db->get_where('accounts',array('id' =>$_POST['pay_acc']))->row();
        //$customers = $this->db->get_where("customers", array("usu_estado"=>'Activo',"ciudad"=>$caja1->holder))->result_array();
        $customers_list = $this->db->query("select * from customers where (usu_estado='Activo' or usu_estado='Compromiso') and gid ='".$caja1->sede."'")->result_array();
        $ciudades= array();
        $sdate=$this->input->post("sdate");
        $date1= new DateTime($sdate);
        $sdate1=$date1->format("Y-m-d");
        $time_sdate1=strtotime($sdate1);
        $customers_afectados=array();
$this->load->model('customers_model', 'customers');
        foreach ($customers_list as $key => $value) {          
            $invoices = $this->db->select("*")->from("invoices")->where('csd='.$value['id'])->order_by('invoicedate',"DESC")->get()->result();
            
            $este_usuario_sele_creo_ahora=false;
            //echo "<br>";
            //var_dump("customer = ".$value['id']." |");
            $_customer_factura_creada=false;
            foreach ($invoices as $key => $value2) {
                $time_dateinv=strtotime($value2->invoicedate);
                $dtime2=new DateTime($value2->invoicedate);
                //para omitir los traslados y afiliaciones
                 $afiliacion_traslado_omitir=$this->db->query('SELECT * FROM `invoice_items` where (product like "%afiliacion%" or product like "%traslado%") and tid="'.$invoice->tid.'"')->result_array();
                 if($value2->tipo_factura=="Fija" || $value2->tipo_factura=="Nota Credito" || $value2->tipo_factura=="Nota Debito"){

                 }else if(count($afiliacion_traslado_omitir)!=0){
                            //con este condicional si existen estos items omite esta factura 
                }else if($time_dateinv>$time_sdate1){
                    $_customer_factura_creada=true;
                    //echo "Ya tiene factura ".$sdate1." | ".$value2->invoicedate;
                }else if($date1->format("Y-m")==$dtime2->format("Y-m")){
                    $_customer_factura_creada=true;
                   // echo "Ya tiene factura 2 ".$sdate1." | ".$value2->invoicedate;
                }else{                                                                                    
                    $internet="";
                    $television="";
                    $puntos=0;
                    $_tiene_internet=false;
                    $_tiene_television=false;
                    if($value2->combo!="no" && $value2->combo!="" && $value2->combo!="-"){                    
                        $_tiene_internet=true;
                        $internet=$value2->combo;
                        if($value2->television!="no" && $value2->television!="" && $value2->television!="-"){
                            $_tiene_television=true;
                        }
                    }else if($value2->television!="no" && $value2->television!="" && $value2->television!="-"){
                        $_tiene_television=true;
                    }
                    if($value2->puntos!=null && $value2->puntos!=0 && $value2->puntos!=''  && $value2->puntos!='no'){
                                $puntos=$value2->puntos;
                        }
                    
                    $lista_items=$this->db->get_where("invoice_items", array('tid' => $value2->tid))->result_array();
                    foreach ($lista_items as $key => $item_invoic) {
                        if(strpos(strtolower($item_invoic['product']), "reconexi")!==false){

                        }else if(strpos(strtolower($item_invoic['product']), "afiliaci")!==false){
                            
                        }else{
                            if(strpos(strtolower($item_invoic['product']), "tele")!==false){
                                //$_tiene_television=true;
                            }else{
                                if($item_invoic['product']=="Punto Adicional"){
                                    //$puntos=$item_invoic['qty'];
                                }
                            }

                            

                        }
                    }
                    if($_customer_factura_creada==false){

                            
                            $internet_data= array();
                            $television_data= array();
                            $factura_data=array();
                            $tidactualmasuno= $this->db->select('max(tid)+1 as tid')->from('invoices')->get()->result();
                            //esta data es de la nueva factura para insertar
                            $factura_data['tid']=$tidactualmasuno[0]->tid;
                            $factura_data['tax']=0;
                            $factura_data['total']=0;
                            $factura_data['subtotal']=0;
                            if($_tiene_television==true && ($value2->estado_tv==null || $value2->estado_tv=='null')){
                                if(strpos(strtolower($caja1->holder), strtolower("mocoa"))!==false){
                                    $tv_product= $this->db->get_where("products", array('pid' => "159"))->row();
                                    $television_data['pid']=$tv_product->pid;
                                    $television_data['price']=$tv_product->product_price;
                                    $television_data['subtotal']=$tv_product->product_price;
                                    $television_data['totaltax']=0;
                                    $television_data['tax']=0;
                                    $television_data['product']="Television";
                                    $factura_data['subtotal']=$tv_product->product_price;
                                    $factura_data['total']=$tv_product->product_price;
                                }else{
                                    $tv_product= $this->db->get_where("products", array('pid' => "27"))->row();
                                    $x1=3992+$tv_product->product_price;
                                    $television_data['pid']=$tv_product->pid;
                                    $television_data['price']=$tv_product->product_price;
                                    $television_data['subtotal']=$x1;
                                    $television_data['totaltax']=3992;
                                    $television_data['tax']=$tv_product->taxrate;
                                    $factura_data['tax']=3992;
                                    $factura_data['subtotal']=$tv_product->product_price;
                                    $factura_data['total']=$x1;

                                    
                                        $television_data['product']="Television";
                                    
                                }
                                $television_data['tid']=$factura_data['tid'];
                                $television_data['qty']=1;
                                $television_data['discount']=0;                                
                                $television_data['totaldiscount']=0;
                                
                                    $this->db->insert("invoice_items",$television_data);

                                


                            }                                                                                    
                            //estan listos los datos de tv item invoice falta llenar los campos faltantes 
                            //falta llenar los datos de internet y posteriormente insertar

                            if($_tiene_internet==true && ($value2->estado_combo==null || $value2->estado_combo=='null')){
                                
                                $str1=str_replace(" ", "", strtolower($internet));
                                $producto_internet=$this->db->query('SELECT * FROM products WHERE lower(REPLACE(product_name," ","")) = "'.$str1.'"')->result_array();
                                $producto_internet=$producto_internet[0];
                                $internet_data['tid']=$factura_data['tid'];
                                $internet_data['pid']=$producto_internet['pid'];
                                $internet_data['product']=$producto_internet['product_name'];
                                $internet_data['qty']=1;
                                $internet_data['price']=$producto_internet['product_price'];
                                $internet_data['tax']=0;
                                $internet_data['discount']=0;
                                $internet_data['subtotal']=$producto_internet['product_price'];
                                $internet_data['totaldiscount']=0;
                                $internet_data['totaltax']=0;

                                if($producto_internet['taxrate']!=0 ){
                                    $iva=($producto_internet['product_price']*$producto_internet['taxrate'])/100;
                                    $internet_data['tax']=$producto_internet['taxrate'];
                                    $internet_data['totaltax']=$iva;
                                    $internet_data['subtotal']=$producto_internet['product_price']+$iva;

                                    $factura_data['subtotal']+=$producto_internet['product_price'];
                                    $factura_data['total']+=($producto_internet['product_price']+$iva); 
                                    $factura_data['tax']+=$iva;
                                }else{
                                    $factura_data['subtotal']+=$producto_internet['product_price'];
                                    $factura_data['total']+=$producto_internet['product_price'];    
                                }

                                
                                
                                    $this->db->insert("invoice_items",$internet_data);
                                
                            }
                            $puntos_data= array();
                            if($puntos!=0){
                                $punto_adicional=$this->db->get_where("products", array('product_name' =>"Punto Adicional"))->row();
                                $puntos_data['tid']=$factura_data['tid'];
                                $puntos_data['pid']=$punto_adicional->pid;
                                $puntos_data['product']=$punto_adicional->product_name;
                                $puntos_data['qty']=$puntos;
                                $puntos_data['price']=$punto_adicional->product_price;
                                $puntos_data['tax']=0;
                                $puntos_data['discount']=0;
                                $puntos_data['subtotal']=$punto_adicional->product_price*$puntos;
                                $puntos_data['totaldiscount']=0;
                                $puntos_data['totaltax']=0;
                                $factura_data['subtotal']+=$puntos_data['subtotal'];
                                $factura_data['total']+=$puntos_data['subtotal'];
                                
                                    $this->db->insert("invoice_items",$puntos_data);
                                
                            }
                            $factura_data['puntos']=$puntos;
$list_servs=$this->invocies->servicios_adicionales_recurrentes($value2->tid);

                                 foreach ($list_servs as $key_s => $serv_val) {
                                    $data_serv=array();
                                    $data_serv['tid_invoice']=$factura_data['tid'];
                                    $data_serv['pid']=$serv_val['pid'];
                                    $data_serv['valor']=$serv_val['valor'];
                                    $data_serv['subtotal']=$serv_val['subtotal'];
                                    $data_serv['total']=$serv_val['total'];
                                    $this->db->insert("servicios_adicionales",$data_serv);
                                    $producto = $this->db->get_where('products',array('pid'=>$serv_val['pid']))->row();
                                            $data_item_serv=array();
                                            $data_item_serv['pid']=$producto->pid;
                                            $data_item_serv['tid']=$factura_data['tid'];
                                            $data_item_serv['product']=$producto->product_name;
                                            $data_item_serv['qty']=$serv_val['valor'];
                                            //var_dump($data_item_serv['qty']);
                                            if(!is_numeric($serv_val['valor'])){
                                                $data_item_serv['qty']=1;
                                            }
                                            
                                            /*falta calcular el precio segun los dias y añadir el valor de estos item_invoice al valor de la factura*/
                                            $x=0;
                                            $x=$producto->product_price;
                                       
                                        
                                        $factura_data['subtotal']+=round($x*$data_item_serv['qty']);;
                                        $factura_data['total']+=round($x*$data_item_serv['qty']);;
                                        //$tax2+=$datay['totaltax'];
                                            $data_item_serv['tax']=0;
                                            $data_item_serv['totaltax']='';
                                            $data_item_serv['price']=$x;
                                            $data_item_serv['subtotal']=round($x*$data_item_serv['qty']);
                                            $this->db->insert('invoice_items',$data_item_serv);
                                }
                            //falta los puntos no se olvide hacer igual que en tickets y luego preguntar que alli se valora cada uno en ves de despues de 3 puntos
                            //y crear el invoice
                            if($factura_data['total']!=0){
                                $dia_final_de_mes=date("Y-m-t 23:00:00", $time_sdate1);
                                $date_fecha_corte=new DateTime($dia_final_de_mes);
                                
                                $factura_data['invoicedate']=$sdate1;
                                $factura_data['invoiceduedate']=$date_fecha_corte->format("Y-m-d");
                                $factura_data['discount']=0;
                                $factura_data['notes']=".";
                                $factura_data['status']="due";
                                $factura_data['csd']=$value2->csd;
                                $factura_data['eid']=$value2->eid;
                                $factura_data['pamnt']=0;
                                $factura_data['items']=$value2->items;
                                $factura_data['taxstatus']=$value2->taxstatus;
                                $factura_data['discstatus']=$value2->discstatus;
                                $factura_data['format_discount']=$value2->format_discount;
                                $factura_data['refer']=$value2->refer;
                                $factura_data['tipo_factura']="Recurrente";
                                if($_tiene_television==true){
                                    $factura_data['television']="Television";
                                }else{
                                    $factura_data['television']="no";
                                }
                                if($_tiene_internet==true){
                                    $factura_data['combo']=str_replace(" ","",$internet);
                                }else{
                                    $factura_data['combo']="no";
                                }
                                $factura_data['estado_combo']=$value2->estado_combo;
                                $factura_data['estado_tv']=$value2->estado_tv;
                                $factura_data['term']=$value2->term;
                                $factura_data['rec']=$value2->rec;
                                if($value['usu_estado']=="Compromiso"){
                                    $factura_data['ron']=$value['usu_estado'];
                                }else{
                                    $factura_data['ron']=$value2->ron;    
                                }
                                
                                $factura_data['multi']=$value2->multi;
                                
                                    


                                    $this->db->insert("invoices",$factura_data);
                                    $customers_afectados[]=array('csd' => $value2->csd,"tid"=>$factura_data['tid'],"nombres"=>$value['name']." ".$value['unoapellido'],"celular"=>$value['celular'],"cedula"=>$value['documento']);
                                    
                                    //var_dump("INSERTADO");
                                    //var_dump($factura_data);
                                                           
                                $_customer_factura_creada=true;
                                $este_usuario_sele_creo_ahora=true;
                                
                            }



                            
                        
                    }


                }   
                
            }
            //var_dump($value['name']);
            //codigo para pagar con saldo ya existente
            if($este_usuario_sele_creo_ahora==false){
                $invoices=array();
            }else{
                $invoices = $this->db->select("*")->from("invoices")->where('csd='.$value['id'])->order_by('invoicedate',"ASC")->get()->result();//$invoices = $this->db->select("*")->from("invoices")->where('csd='.$value['id'])->order_by('invoicedate',"ASC")->get()->result();
            }
            
            $lista_para_pagos_adelantados=array();
            $lista_para_pagos_faltantes=array();
            $saldo_dispo_total=0;
            foreach ($invoices as $key => $inv) {
               
                if($inv->tipo_factura=="Fija" || $inv->tipo_factura=="Nota Credito" || $inv->tipo_factura=="Nota Debito"){
                        //para que se salte este tipo de facturas
                }else{
                     if($inv->pamnt<0 || $inv->total<0){
                                            break;
                                    }
                    
                if($inv->status=="paid" && $inv->pamnt==0){
                    $this->db->update("invoices",array('status' =>"due"),array("id"=>$inv->id));
                    $inv->status="due";
                }

                if(($inv->status=="due" || $inv->status=="partial") && $inv->pamnt==$inv->total){
                    $this->db->update("invoices",array('status' =>"paid"),array("id"=>$inv->id));
                    $inv->status="paid";   
                }
                
                if($inv->pamnt>$inv->total){
                    
                    /*if($inv->total==$tr_verificacion[0]['calculo']){
                        $this->db->update("invoices",array("pamnt"=>$inv->total),array("tid"=>$inv->tid));
                    }else{*/
                        $saldo_dispo=$inv->pamnt-$inv->total;
                        $saldo_dispo_total+=$saldo_dispo;
                        $lista_para_pagos_adelantados[]= array("tid"=>$inv->tid,"saldo_disponible"=>$saldo_dispo,"pamnt"=>$inv->pamnt);    
                    //}
                    
                }else if($inv->status=="due" || $inv->status=="partial"){
                    $total_a_cubrir=$inv->total;
                    if($inv->status=="partial"){
                        $total_a_cubrir=$total_a_cubrir-$inv->pamnt;
                    }
                    $lista_para_pagos_faltantes[]=array("tid"=>$inv->tid,"status"=>$inv->status,"pamnt"=>$inv->pamnt,"total_a_cubrir"=>$total_a_cubrir,"total"=>$inv->total,"factura_totalizada"=>false);
                }else if($inv->status=="paid" && $inv->pamnt<$inv->total && $inv->pamnt!=0){ 
                        $total_a_cubrir=$inv->total;                       
                        $total_a_cubrir=$total_a_cubrir-$inv->pamnt;
                        $status="partial";
                        $lista_para_pagos_faltantes[]=array("tid"=>$inv->tid,"status"=>$status,"pamnt"=>$inv->pamnt,"total_a_cubrir"=>$total_a_cubrir,"total"=>$inv->total,"factura_totalizada"=>false);
                        $this->db->update("invoices",array('status' =>$status),array("id"=>$inv->id));
                }
                }
            }

            /* datos para probar en local
                  delete from invoice_items where tid=37503;
                    delete from invoices where tid=37503;
                    update invoices set pamnt=64000 where tid=26261;
                    update invoices set pamnt=50000, status="partial" where tid=7549;
                    update transactions set credit="64000.00" where id=24870;*/



            

            if(count($lista_para_pagos_faltantes!=0) && $saldo_dispo_total!=0){//&& $value['id']==5605

                foreach ($lista_para_pagos_adelantados as $key => $valuey) {
                    foreach ($lista_para_pagos_faltantes as $key2 => $pag) { 
                   // var_dump("saldo_disponible =".$valuey['saldo_disponible']." total_a_cubrir=".$pag['total_a_cubrir']." , pag['pamnt']=".$pag['pamnt']);                       
                        if($valuey['saldo_disponible']>=$pag['total_a_cubrir'] && $pag['factura_totalizada']==false){//parte en la que sea mayor el saldo diponible completada parcialmente falta hacer lo de dividir transacciones
/*var_dump($value2->csd);
                            var_dump($valuey);
                            var_dump($pag);
var_dump("aqui2");*/
                            $camino1=true;
                            $camino3=false;
                            //$valor_debitados=0;
                            $tr = $this->db->get_where("transactions", array("tid"=>$valuey['tid'],"credit"=>$valuey['pamnt'],"estado"=>null,"cat!="=>"Purchase"))->row();
                            if($tr==null){
                                $camino1=false;
                                $tr = $this->db->get_where("transactions", array("tid"=>$valuey['tid'],"credit"=>$valuey['saldo_disponible'],"estado"=>null,"cat!="=>"Purchase"))->row();
                                if($tr==null){
                                    $camino3=true;
                                    $tr_verificacion = $this->db->query("select * from transactions where estado is null and cat!='Purchase' and tid=".$valuey['tid']." order by credit desc")->result_array();
                                    
                                    $tr = $this->db->get_where("transactions", array("id"=>$tr_verificacion[0]['id']))->row();
                                   //se debe de buscar la transaccion que se acomode a lo necesario si se cumple el tope de la factura y sobra saldo de las transacciones
                                }
                                
                            }
                            //actualizando datos de la factura a pagar
                            $data= array();
                            $data['pamnt']=$pag['total_a_cubrir']+$pag['pamnt'];
                            $data['status']="paid";
                            $lista_para_pagos_adelantados[$key]['saldo_disponible']-=$pag['total_a_cubrir'];
                            $valuey['saldo_disponible']=$lista_para_pagos_adelantados[$key]['saldo_disponible'];
                             $data['pmethod']="Cash";
                            $this->db->update("invoices",$data,array('tid' =>$pag['tid']));
                            //actualizando datos del invoice que contiene el pago adelantado
                            $data= array();
                            $data['pamnt']=$valuey['pamnt']-$pag['total_a_cubrir'];
                            $lista_para_pagos_adelantados[$key]['pamnt']=$data['pamnt'];
                            if($camino1){
                                $valuey['pamnt']=$data['pamnt'];                                                            
                            }else{

                                $valuey['pamnt']=$tr->credit-$pag['total_a_cubrir'];
                                /*if($camino3){
                                    $valuey['pamnt']=$valuey['pamnt']-$valor_debitados;
                                    //y aqui aplicarle logica para ver si cambia o no por el cambio de arriba
                                }*/
                                //y aqui restarle los debitados
                            }                             
                            $this->db->update("invoices",$data,array('tid' =>$valuey['tid']));                            
                            //editando transaccion que contiene el pago adelantado
                            $data_transaccion=array();                            
                            $data_transaccion['credit']=$valuey['pamnt'];

                            if(strpos(strtolower($tr->note), strtolower("credito_inicial"))!==false){
                                
                            }else{
                                $data_transaccion['note']=$tr->note." #credito_inicial=".$tr->credit;    
                            }                        

                            $this->db->update("transactions",$data_transaccion,array('id' =>$tr->id));
                            
                            //creando transaccion
                            $data_transaccion['acid']=$tr->acid;
                            
                            $data_transaccion['account']=$tr->account;
                            $data_transaccion['type']=$tr->type;
                            $data_transaccion['cat']=$tr->cat;
                            $data_transaccion['debit']=$tr->debit;
                            $data_transaccion['credit']=$pag['total_a_cubrir'];
                            $data_transaccion['payer']=$tr->payer;
                            $data_transaccion['payerid']=$tr->payerid;
                            $data_transaccion['method']=$tr->method;
                            $data_transaccion['date']=$tr->date;
                            $data_transaccion['tid']=$pag['tid'];

                           // var_dump($tr);

                            $data_transaccion['eid']=$tr->eid;
                            $note=str_replace("credito_inicial", "credito_tr_padre", $tr->note);
                            $data_transaccion['note']=$note;
                            $data_transaccion['note'] = str_replace("".$tr->tid."", $pag['tid'], $data_transaccion['note']);
                            $data_transaccion['note']=$data_transaccion['note']." #adelantado_de_tr_id=".$tr->id;
                            //var_dump(" note ".$data_transaccion['note']);

                            $data_transaccion['ext']=$tr->ext;
                            $data_transaccion['nombre_banco']=$tr->nombre_banco;
                            $data_transaccion['id_banco']=$tr->id_banco;
                            $data_transaccion['estado']=$tr->estado;


                            $this->db->insert("transactions",$data_transaccion);

                            //desactivar row para que no sea mas iterada si ya se cubrio la deuda
                            $data_transaccion['factura_totalizada']=true;
                            $pag['factura_totalizada']=true;
                            $lista_para_pagos_faltantes[$key2]['factura_totalizada']=true;

                        }else if($valuey['saldo_disponible']>50 && $pag['factura_totalizada']==false){//parte en la que sea menor el saldo diponible completada es decir pago parcial 
                            /*var_dump("aqui");
                            var_dump($value2->csd);
                            var_dump($valuey);
                            var_dump($pag);//http://localhost/CRMvestel/customers/invoices?id=14944
                           */
                            $camino1=true;
                            $camino3=false;
                            $tr = $this->db->get_where("transactions", array("tid"=>$valuey['tid'],"credit"=>$valuey['pamnt'],"estado"=>null,"cat!="=>"Purchase"))->row();
                            if($tr==null){
                                $camino1=false;
                                $tr = $this->db->get_where("transactions", array("tid"=>$valuey['tid'],"credit"=>$valuey['saldo_disponible'],"estado"=>null,"cat!="=>"Purchase"))->row();
                                if($tr==null){
                                    $camino3=true;
                                    $tr_verificacion = $this->db->query("select * from transactions where estado is null and cat!='Purchase' and tid=".$valuey['tid']." order by credit desc")->result_array();
                                    
                                    $tr = $this->db->get_where("transactions", array("id"=>$tr_verificacion[0]['id']))->row();
                                   //se debe de buscar la transaccion que se acomode a lo necesario si se cumple el tope de la factura y sobra saldo de las transacciones
                                }
                            }
                            //actualizando datos de la factura a pagar
                            $data= array();
                            $data['pamnt']=$valuey['saldo_disponible']+$pag['pamnt'];
                            $data['status']="partial";
                          
                             $data['pmethod']="Cash";
                             $lista_para_pagos_faltantes[$key2]['total_a_cubrir']=$pag['total']-$data['pamnt'];//paso necesario para cuando se pretenda pagar con dos saldos adelantados y no alcance el primero a totalizar la deuda
                             $pag['total_a_cubrir']=$lista_para_pagos_faltantes[$key2]['total_a_cubrir'];
                             $pag['pamnt']=$data['pamnt'];
                             $lista_para_pagos_faltantes[$key2]['pamnt']=$data['pamnt'];
                            $this->db->update("invoices",$data,array('tid' =>$pag['tid']));
                            //actualizando datos del invoice que contiene el pago adelantado
                            $data= array();
                            $data['pamnt']=$valuey['pamnt']-$valuey['saldo_disponible'];
                            $lista_para_pagos_adelantados[$key]['pamnt']=$data['pamnt'];
                            if($camino1){
                                $valuey['pamnt']=$data['pamnt'];                            
                                
                            }else{
                                $valuey['pamnt']=$tr->credit-$valuey['saldo_disponible'];
                            }                            
                            $this->db->update("invoices",$data,array('tid' =>$valuey['tid']));                            
                            //editando transaccion que contiene el pago adelantado
                            $data_transaccion=array();  

                            $data_transaccion['credit']=$valuey['pamnt'];

                            if(strpos(strtolower($tr->note), strtolower("credito_inicial"))!==false){
                                
                            }else{
                                $data_transaccion['note']=$tr->note." #credito_inicial=".$tr->credit;    
                            }  

                            $this->db->update("transactions",$data_transaccion,array('id' =>$tr->id));
                            
                            //creando transaccion
                            $data_transaccion['acid']=$tr->acid;
                            
                            $data_transaccion['account']=$tr->account;
                            $data_transaccion['type']=$tr->type;
                            $data_transaccion['cat']=$tr->cat;
                            $data_transaccion['debit']=$tr->debit;
                            $data_transaccion['credit']=$valuey['saldo_disponible'];
                            $data_transaccion['payer']=$tr->payer;
                            $data_transaccion['payerid']=$tr->payerid;
                            $data_transaccion['method']=$tr->method;
                            $data_transaccion['date']=$tr->date;
                            $data_transaccion['tid']=$pag['tid'];

                           // var_dump($tr);

                            $data_transaccion['eid']=$tr->eid;
                            $note=str_replace("credito_inicial", "credito_tr_padre", $tr->note);
                            $data_transaccion['note']=$note;
                            $data_transaccion['note'] = str_replace("".$tr->tid."", $pag['tid'], $data_transaccion['note']);
                            $data_transaccion['note']=$data_transaccion['note']." #adelantado_de_tr_id=".$tr->id;
                            //var_dump(" note ".$data_transaccion['note']);

                            $data_transaccion['ext']=$tr->ext;
                            $data_transaccion['nombre_banco']=$tr->nombre_banco;
                            $data_transaccion['id_banco']=$tr->id_banco;
                            $data_transaccion['estado']=$tr->estado;


                            $this->db->insert("transactions",$data_transaccion);

                            $lista_para_pagos_adelantados[$key]['saldo_disponible']=0;
                            $valuey['saldo_disponible']=0;

                            

                        }
                        if($valuey['saldo_disponible']<=0){
                            break;
                        }


                    }
                }
                $this->customers->actualizar_debit_y_credit($value['id']);
            }

            //end codigo para pagar con saldo ya existente
            

        }
        
         $data_h=array();
            $data_h['modulo']="Ventas";
            $data_h['accion']="Generar Facturas Mensuales {insert}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']="Generacion de facturacion mensual, junto con la acomodacion de pagos adelantados en sede ".$caja1->holder." fecha seleccionada ".$sdate;
            $data_h['id_fila']="0";
            $data_h['tabla']="invoices";
            $data_h['nombre_columna']="";
            $this->db->insert("historial_crm",$data_h);

        
        //$this->load->model('transactions_model');
        $head['title'] = "Generar Facturas";        
        $data['customers_afectados'] = $customers_afectados;
        $data['fecha'] = $sdate1;
        $data['pay_acc'] = $caja1->holder;
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/facturas_generadas', $data);
        $this->load->view('fixed/footer');
    }

    public function lista_facturas_generadas(){

        $lista_invoices=$this->db->get_where("invoices", array('invoicedate' =>$_GET['fecha'],"refer"=>$_GET['pay_acc'],"notes"=>"."))->result_array();
        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        $maximo=$minimo+10;
        foreach ($lista_invoices as $key => $value) {
            
            if($x>=$minimo && $x<$maximo){
                $no++;
                $customers = $this->db->get_where("customers", array('id' => $value['csd']))->row();
                $row = array();
                $row[] = $no;
                //$row[] = $customers->abonado;
                $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
                $row[] = $customers->celular;
                $row[] = $customers->documento;
                //$row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                //$row[] = $customers->usu_estado;
                $row[] = '<a href="'.base_url().'customers/invoices?id='.$value['csd'].'" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Facturas</a> <a href="'.base_url().'invoices/view?id='.$value['tid'].'" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Factura Creada</a>';
                $data[] = $row;

            }
            $x++;
             
             
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($lista_invoices),
            "recordsFiltered" => count($lista_invoices),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
public function generar_pdf_facturas_generadas(){
    ob_end_clean();
    ini_set('memory_limit', '1500000M');
    ini_set("pcre.backtrack_limit", "3000000");

    $lista_invoices=$this->db->query("SELECT  customers.id as id,customers.name as name, customers.unoapellido as apellido,customers.celular as celular,customers.documento as documento,invoices.tid as tid, invoices.total as total, invoices.television as television, invoices.combo as combo  FROM invoices inner join customers on invoices.csd=customers.id where invoices.invoicedate= '".$_GET['fecha']."' and refer='".$_GET['pay_acc']."' and  notes='.'")->result_array();
       //var_dump($lista_invoices[0]['name']);
    $data=array("lista"=>$lista_invoices);
    setlocale(LC_TIME, "spanish");
     $x= new DateTime($_GET['fecha']);
     $data['fecha']=utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime($_GET['fecha'])));
     //$data['fecha']=utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime("02-06-2022 00:00:00")))."-<u>".$x->format("g").":".$x->format("s")." ".$x->format("a")."</u>";
     $data['sede']=$_GET['pay_acc'];
        $html = $this->load->view('invoices/generar_pdf_facturas_generadas.php', $data, true);
        //echo $html;
        
        //PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetHTMLFooter("<div style='text-align:right;'><i><b><small>{PAGENO}/{nbpg}</small></b></i></div>");
        $pdf->WriteHTML($html);
        if ($this->input->get('d')) {
            $pdf->Output('Reporte Facturas Generadas '.$_GET['sede']." - ".$_GET['fecha'].".pdf", 'D');
        } else {
            $pdf->Output('Reporte Facturas Generadas '.$_GET['sede']." - ".$_GET['fecha'].".pdf", 'I');
        }
    
}
    public function generar_excel_facturas_generadas(){
        ob_end_clean();
        set_time_limit(3000);
         setlocale(LC_TIME, "spanish");
     $x= new DateTime($_GET['fecha']);
     $fecha=utf8_encode(strftime("%A ".$x->format("d")." de %B del ".$x->format("Y"), strtotime($_GET['fecha'])));
     //$data['fecha']=utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime("02-06-2022 00:00:00")))."-<u>".$x->format("g").":".$x->format("s")." ".$x->format("a")."</u>";
     $sede=$_GET['pay_acc'];
     $nombrex="Facturas Generadas - ".$sede." - ".$fecha;
     $nombrey="Facturas Generadas,".$sede;
        $lista_invoices=$this->db->query("SELECT  customers.id as id,customers.abonado as abonado,customers.name as name, customers.unoapellido as apellido,customers.celular as celular,customers.documento as documento,invoices.tid as tid, invoices.total as total, invoices.television as television, invoices.combo as combo  FROM invoices inner join customers on invoices.csd=customers.id where invoices.invoicedate= '".$_GET['fecha']."' and refer='".$_GET['pay_acc']."' and  notes='.'")->result_array();

         $this->load->library('Excel');
    
    //define column headers
        $headers = array('#' => 'integer','ID Usuario' => 'integer','Abonado' => 'integer','NOMBRE' => 'string', 'DOCUMENTO' => 'string', 'CELULAR' => 'string', 'TID FACTURA' => 'integer','SERVICIOS' => 'string','TOTAL' => 'string');

        $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    //$writer->setTitle('Reporte Facturas Generadas '.$sede." - ".$fecha);
    $writer->setTitle($nombrey);
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription($nombrey);
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
);
$writer->writeSheetHeader($nombrey, $headers,$col_options);
    foreach ($lista_invoices as $key => $value) {
        $array_facturas=array();
        $array_facturas[]=$key+1;
        $array_facturas[]=$value['id'];
        $array_facturas[]=$value['abonado'];
        $array_facturas[]=utf8_encode($value['name']." ".$value['apellido']);
        $array_facturas[]=number_format($value['documento'],0,",",".");

              $phoneNumber = $value['celular'];

                if(  strlen($phoneNumber)==10 )
                {
                    $areaCode = substr($phoneNumber, 0, 3);
                    $nextThree = substr($phoneNumber, 3, 3);
                    $lastFour = substr($phoneNumber, 6, 4);
                    $result =  $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
                }else{
                    $result=$value['celular'];
                }

                $servs="";
                if($value['television']!="no" && $value['television']!="" && $value['television']!="-"){
                    $servs="Tv";
                    if($value['combo']!="no" && $value['combo']!="" && $value['combo']!="-"){
                        $servs.="+".$value['combo'];
                    
                    }
                }else{
                    $servs=$value['combo'];
                }

        $array_facturas[]=$result;
        $array_facturas[]=$value['tid'];
        $array_facturas[]=$servs;
        $array_facturas[]="$ ".number_format($value['total'],0,",",".");

            $writer->writeSheetRow($nombrey,$array_facturas);



       }
       //$this->load->model('reports_model', 'reports');
       $fileLocation = $nombrex.'.xlsx';
       $writer->writeToFile($fileLocation);
    //echo $writer->writeToString();
    
    //force download
    header('Content-Description: File Transfer');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=".basename($fileLocation));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Length: ' . filesize($fileLocation)); //Remove

    ob_clean();
    flush();

    readfile($fileLocation);
    unlink($fileLocation);
    exit(0);
    

    }
    //edit invoice
    public function edit()
    {

        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['title'] = "Edit Invoice $tid";
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
		$data['paqueteinter'] = $this->invocies->paquetes('inter');
		$data['paquete'] = $this->invocies->paquetes('tv');
		$data['sede'] = $this->invocies->sede();
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->invocies->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['servicios_por_sedes']=$this->invocies->get_servicios();

        $this->load->view('fixed/header', $head);
        if ($data['invoice']) $this->load->view('invoices/edit', $data);
        $this->load->view('fixed/footer');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Invoices";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/invoices');
        $this->load->view('fixed/footer');
    }
	public function apertura()

    {
		if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('employee_model', 'employee');
        $id = $this->aauth->get_user()->id;
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);        
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/apertura', $data);
        $this->load->view('fixed/footer');

    }

    //action
    public function action()
    {
        
        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes');
        $tax = $this->input->post('tax_handle');
        $subtotal = $this->input->post('subtotal');
        $shipping = $this->input->post('shipping');
        $refer = $this->input->post('refer');
		$television = $this->input->post('television');
		$combo = $this->input->post('combo');
		$puntos = $this->input->post('puntos');
        $total = $this->input->post('total');
        $project = $this->input->post('prjid');
        $tipo_factura = $this->input->post('tipo_factura');
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $currency = $this->input->post('mcurrency');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new client')));
            exit;
        }
        $this->db->trans_start();
        //products

        $pid = $this->input->post('pid');
        $productlist = array();
        $prodindex = 0;
        $itc = 0;
        $flag = false;
        if ($tax == 'yes') {
            $textst = 1;

            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description');
                $total_discount += $ptotal_disc[$key];
                

                if($tipo_factura=="Nota Credito"){
                        $var1=$product_price[$key]*2;
                        $product_price[$key]=$product_price[$key]-$var1;
                        $var1=$product_subtotal[$key]*2;
                        $product_subtotal[$key]=$product_subtotal[$key]-$var1;
                        $var1=$ptotal_tax[$key]*2;
                        $ptotal_tax[$key]=$ptotal_tax[$key]-$var1;
                        
                 }
                $total_tax += $ptotal_tax[$key];
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'qty' => $product_qty[$key],
                    'price' => $product_price[$key],
                    'tax' => $product_tax[$key],
                    'discount' => $product_discount[$key],
                    'subtotal' => $product_subtotal[$key],
                    'totaltax' => $ptotal_tax[$key],
                    'totaldiscount' => $ptotal_disc[$key],
                    'product_des' => $product_des[$key]
                );

                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;


                $amt = intval($product_qty[$key]);
                if ($product_id[$key] > 0) {
                    $this->db->set('qty', "qty-$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('products');
                          $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Nueva Factura {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("qty"=>"qty-$amt"));
                            $data_h['id_fila']=$product_id[$key];
                            $data_h['tabla']="products";
                            $data_h['nombre_columna']="pid";
                            $this->db->insert("historial_crm",$data_h);
                }
                $itc += $amt;


            }
        } else {
            $textst = 0;
            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description');
                $total_discount += $ptotal_disc[$key];

                 if($tipo_factura=="Nota Credito"){
                        $var1=$product_price[$key]*2;
                        $product_price[$key]=$product_price[$key]-$var1;
                        $var1=$product_subtotal[$key]*2;
                        $product_subtotal[$key]=$product_subtotal[$key]-$var1;
                        
                 }
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'qty' => $product_qty[$key],
                    'price' => $product_price[$key],
                    'discount' => $product_discount[$key],
                    'subtotal' => $product_subtotal[$key],
                    'totaldiscount' => $ptotal_disc[$key],
                    'product_des' => $product_des[$key]
                );


                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
            }
            //stock

            $amt = intval($product_qty[$key]);
            if ($product_id[$key] > 0) {
                $this->db->set('qty', "qty-$amt", FALSE);
                $this->db->where('pid', $product_id[$key]);
                $this->db->update('products');
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Nueva Factura {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("qty"=>"qty-$amt"));
                            $data_h['id_fila']=$product_id[$key];
                            $data_h['tabla']="products";
                            $data_h['nombre_columna']="pid";
                            $this->db->insert("historial_crm",$data_h);
            }


            $itc += $amt;

        }


        $transok = true;


        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
		if (($television !== no) || $combo !== no){
			$estado = 'Instalar';
		}else{
			$estado = '';
		}
        if($tipo_factura=="Nota Credito"){
            $var1=$subtotal*2;
            $subtotal=$subtotal-$var1;
            $var1=$total_tax*2;
            $total_tax=$total_tax-$var1;
            $var1=$total*2;
            $total=$total-$var1;
			$status = 'paid';
        }else{
			$status = 'due';
		}
		if($total_tax>0){
            $subtotal=$total-$total_tax;
        }
        $data = array(
			'tid' => $invocieno, 
			'invoicedate' => $bill_date, 
			'invoiceduedate' => $bill_due_date, 
			'subtotal' => $subtotal, 
			'shipping' => $shipping, 
			'discount' => $total_discount, 
			'tax' => $total_tax, 
			'total' => $total, 
			'notes' => $notes, 
			'status' => $status,
			'csd' => $customer_id, 
			'eid' => $this->aauth->get_user()->id, 
			'items' => $itc, 
			'taxstatus' => $textst, 
			'discstatus' => $discstatus, 
			'format_discount' => $discountFormat, 
			'refer' => $refer, 
			'term' => $pterms, 
			'multi' => $currency, 
			'television' => $television, 
			'combo' => $combo,
			'puntos' => $puntos,
			'ron' => $estado,
            'tipo_factura'=>$tipo_factura
        );

        if ($flag == true) {
            $this->db->insert_batch('invoice_items', $productlist);

                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Nueva Factura {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($productlist);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="invoice_items";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
			$tidactualmasuno= $this->db->select('max(codigo)+1 as codigo')->from('tickets')->get()->result();
			if ($television=='no'){
				$tv = '';
			}else{
				$tv = $television;
			}
			if ($combo=='no'){
				$int = '';
			}else{
				$int = ' + '.$combo;
			}
			if ($puntos=='0'){
				$pto = '';
			}else{
				$pto = ' + '.$puntos.' Puntos';
			}
            if ($this->db->insert('invoices', $data)) {
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Nueva Factura {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
                            $servicios_adicionales="";
                            foreach ($_POST as $llave => $valor) {
                                    if(strpos($llave,"serv_add_")!==false){
                                        if($valor!="0"){
                                                $pid_serv=str_replace("serv_add_", "", $llave);
                                                $product_serv=$this->db->get_where("products",array("pid"=>$pid_serv))->row();
                                                $servicios_adicionales.=" + ".$valor." ".$product_serv->product_name;    
                                                $data_serv=array();
                                                $data_serv['tid_invoice']=$invocieno;
                                                $data_serv['pid']=$pid_serv;
                                                $data_serv['valor']=$valor;
                                                $precio=$product_serv->product_price;
                                                if(is_int($valor)){
                                                    //$precio*$valor;
                                                }
                                                $data_serv['subtotal']=$precio;
                                                $data_serv['total']=$precio;
                                                $this->db->insert("servicios_adicionales",$data_serv);
                                        }
                                        
                                    }
                            }

				$username = $this->aauth->get_user()->username;
				if (($television !== no) || $combo !== no){
				$data2['codigo']=$tidactualmasuno[0]->codigo;	
                $data2['subject']='servicio';
				$data2['detalle']='Instalacion';	
                $data2['created']=$bill_date;
                $data2['cid']=$customer_id;
				$data2['col']=$username;
                $data2['status']='Pendiente';
				$data2['section']=$tv.$int.$pto.$servicios_adicionales;	
                //Tipo de instalacion
					
                $data2['id_invoice']=$invocieno;
				$data2['id_factura']=null;
                $this->db->insert('tickets',$data2);
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Nueva Factura {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data2);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="tickets";
                            $data_h['nombre_columna']="idt";
                            $this->db->insert("historial_crm",$data_h);
				//actualizar estado usuario
                            $customerx1=$this->db->get_where("customers",array('id' =>$customer_id))->row();  
                $this->db->set("ultimo_estado",$customerx1->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));

				$this->db->set('usu_estado', 'Instalar');
        		$this->db->where('id', $customer_id);
        		$this->db->update('customers');
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Nueva Factura {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("usu_estado"=>"Instalar"));
                            $data_h['id_fila']=$customer_id;
                            $data_h['tabla']="customers";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
                    
				}
$this->load->model('customers_model', 'customers');
                $servicios_detail=$this->customers->servicios_detail($customer_id);            
                if($servicios_detail['tid']!=0 && $servicios_detail['tid']!=null && $servicios_detail['tid']!=''){
                    
                    $due=$this->customers->due_details($customer_id);

                    $datox=$due['total']-$due['pamnt'];

                    if($datox==0){
                            //due
                        $this->db->update("invoices",array("status"=>"paid"),array("tid"=>$servicios_detail['tid']));
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Nueva Factura {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("status"=>"paid"));
                            $data_h['id_fila']=$servicios_detail['tid'];
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);
                    }else if($datox>0){
                            //partial
                        $this->db->update("invoices",array("status"=>"partial"),array("tid"=>$servicios_detail['tid']));
                                $data_h=array();
                                $data_h['modulo']="Ventas";
                                $data_h['accion']="Nueva Factura {update}";
                                $data_h['id_usuario']=$this->aauth->get_user()->id;
                                $data_h['fecha']=date("Y-m-d H:i:s");
                                $data_h['descripcion']=json_encode(array("status"=>"partial"));
                                $data_h['id_fila']=$servicios_detail['tid'];
                                $data_h['tabla']="invoices";
                                $data_h['nombre_columna']="tid";
                                $this->db->insert("historial_crm",$data_h);
                    }
                }

                $validtoken = hash_hmac('ripemd160', $invocieno, $this->config->item('encryption_key'));
                $link = base_url('billing/view?id=' . $invocieno . '&token=' . $validtoken);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Invoice Success') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "  </a> &nbsp; &nbsp; <a href='$link' class='btn btn-orange btn-lg'><span class='icon-earth' aria-hidden='true'></span> " . $this->lang->line('Public View') . " </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Invalid Entry!"));
                $transok = false;
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please choose product from product list. Go to Item manager section if you have not added the products."));
            $transok = false;
        }

        if (($this->aauth->get_user()->roleid > 3) AND $project > 0) {

            $data = array('pid' => $project, 'meta_key' => 11, 'meta_data' => $invocieno, 'value' => '0');

            $this->db->insert('project_meta', $data);
                     $data_h=array();
                        $data_h['modulo']="Ventas";
                        $data_h['accion']="Nueva Factura {insert}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode($data);
                        $data_h['id_fila']=$this->db->insert_id();
                        $data_h['tabla']="project_meta";
                        $data_h['nombre_columna']="id";
                        $this->db->insert("historial_crm",$data_h);

        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }


    }
	 public function rec_status()
    {
        $tid = $this->input->post('tid');
		$usr = $this->input->post('usuario');
        $status = $this->input->post('status');
		$tv = $this->input->post('television');
		$int = $this->input->post('internet');
        $datax=array();
        if($tv!="por_defecto"){
			if($tv !='no'){
		  		$this->db->set('television', $tv);
				$this->db->set('estado_tv', '');
                $datax['television']=$tv;
                $datax['estado_tv']='';
			}else{
				$this->db->set('estado_tv', 'Cortado');

                $datax['estado_tv']='Cortado';
			}
        }
         if($int!="por_defecto" && $tv!="Television"){
			 if($int != 'no'){
                $this->db->set('combo', $int);
			 	$this->db->set('estado_combo', '');
                $datax['combo']=$int;
                $datax['estado_combo']='';
			 }else{
				$this->db->set('estado_combo', 'Cortado'); 
                $datax['estado_combo']='Cortado';
			 }
        }
        $this->db->set('ron', $status);
        $this->db->where('tid', $tid);
        $datax['ron']=$status;
        //$this->db->update('invoices');
		$this->db->update('invoices');	
             $data_h=array();
                $data_h['modulo']="Ventas";
                $data_h['accion']="Administrar Facturas > ver factura > instalar {update}";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=json_encode($datax);
                $data_h['id_fila']=$tid;
                $data_h['tabla']="invoices";
                $data_h['nombre_columna']="tid";
                $this->db->insert("historial_crm",$data_h);
		 //estado usuario
                $customerx1=$this->db->get_where("customers",array('id' =>$usr))->row();  
                $this->db->set("ultimo_estado",$customerx1->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));       
		$this->db->set('usu_estado', $status);
        $this->db->where('id', $usr);
		 //Historial estados
         if($this->db->update('customers')){
		 $dataes = array(
			'cid' => $usr,
			'fecha' => date("Y-m-d H:i:s"),
			'estado' => $status,
			'col' => $this->aauth->get_user()->id,
			);
			 $this->db->insert("estados",$dataes);
		}
            $data_h=array();
                $data_h['modulo']="Ventas";
                $data_h['accion']="Administrar Facturas > ver factura > instalar {update}";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=json_encode(array("usu_estado"=>$status));
                $data_h['id_fila']=$usr;
                $data_h['tabla']="customers";
                $data_h['nombre_columna']="id";
                $this->db->insert("historial_crm",$data_h);
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
	public function activar()
    {
		$tid = $this->input->post('iduser');
        $status = $this->input->post('perfil');
		$fecha = $this->input->post('fecha');
		$hora = $this->input->post('hora');
		$bill_fecha = datefordatabase($fecha);
		$link = base_url('invoices');
		if ($this->invocies->activar($tid,$status,$bill_fecha,$hora)) {                
                  echo json_encode(array('status' => 'Success', 'message' => 'Apertura realiza ir a las vistas' . " <a href='".$link."' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . 'Ir' . " </a> "));
		}else{
             echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
        }
		
    }


    public function ajax_list()
    {

        $list = $this->invocies->get_datatables($this->limited);

        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name ." ". $invoices->unoapellido;
			$row[] = $invoices->abonado;
            $row[] = dateformat($invoices->invoiceduedate);
			$row[] = $invoices->ron;
            $row[] = amountFormat($invoices->total);
			$row[] = $invoices->refer;
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp';
			if ($this->aauth->get_user()->roleid > 3) { 
			$row[] = '<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';}

            $data[] = $row;
        }


        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invocies->count_all($this->limited),
            "recordsFiltered" => $this->invocies->count_filtered($this->limited),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);

    }
public function lista_resivos_tb(){
    if(empty($_GET['tid'])){
        $_GET['tid']=-500;
    }
        $invoice=$this->db->get_where("invoices", array('tid' =>$_GET['tid']))->row();
        

        
        $lista_resivos=$this->db->get_where("recibos_de_pago",array("tid"=>$_GET['tid']))->result_array();
        
        
        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        $maximo=$minimo+10;
        foreach ($lista_resivos as $key => $value) {
            
            if($x>=$minimo && $x<$maximo){
                
                //http://localhost/CRMvestel/customers/invoices?id=16441
                $row = array();
                $row[] = "R".$no;
                //$row[] = $customers->abonado;
                //$row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
                $row[] = $value['date'];
                $row[] = '<iframe src="'.base_url().'invoices/printinvoice2?file_name='.$value['file_name'].'"></iframe>';
                $row[] = $value['file_name'];
                //$lista=explode(",", $value->id_transacciones);
                $str="";
                $ids_transactions=$this->db->get_where("transactions_ids_recibos_de_pago",array("id_recibo_de_pago"=>$value['id']))->result_array();
                foreach ($ids_transactions as $key => $value2) {
                    $tr=$this->db->get_where("transactions", array('id' =>$value2['id_transaccion']))->row();
                    $str.="<i style='cursor:pointer;' title='".$tr->note."'>".$value2['id_transaccion']."</i>,";
                }
                $row[] = $str;
                if($str!=""){
                    $row[] = "<a href='#' class='btn btn-danger eliminar_resivo' data-file-name='".$value['file_name']."'><span class='icon-trash'></span></a>";    
                }else{
                    $row[] ="Se creo antes de la actualizacion...";
                }
                
                //$row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                //$row[] = $customers->usu_estado;
                //$row[] = '<a href="'.base_url().'customers/invoices?id='.$value['csd'].'" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Facturas</a> <a href="'.base_url().'invoices/view?id='.$value['tid'].'" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Factura Creada</a>';
                $data[] = $row;
$no++;
            }
            $x++;
             
             
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($lista_resivos),
            "recordsFiltered" => count($lista_resivos),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
}
function eliminar_resivos_de_pago(){
    $this->load->model('transactions_model','transactions');
    $this->load->model('customers_model', 'customers');
    if(!is_dir("userfiles/txt_para_pdf_resivos_borrados/")){
             mkdir("userfiles/txt_para_pdf_resivos_borrados/", 0777, true);
        }
       try {
            rename("userfiles/txt_para_pdf_resivos/header_".$_GET['file_name'].".txt", "userfiles/txt_para_pdf_resivos_borrados/header_".$_GET['file_name'].".txt");
            rename("userfiles/txt_para_pdf_resivos/body_".$_GET['file_name'].".txt", "userfiles/txt_para_pdf_resivos_borrados/body_".$_GET['file_name'].".txt");   
       } catch (Exception $e) {
           
       }
        
        
        $lista_resivos=$this->db->get_where("recibos_de_pago",array("file_name"=>$_GET['file_name']))->result_array();
        foreach ($lista_resivos as $key_r => $value_r) {
            $lista_tr_rb=$this->db->get_where("transactions_ids_recibos_de_pago",array("id_recibo_de_pago"=>$value_r['id']))->result_array();
                    foreach ($lista_tr_rb as $key_tr => $value_tr) {
                            $tr=$this->db->get_where("transactions",array("id"=>$value_tr['id_transaccion'],"estado"=>null))->row();
                            if(isset($tr)){
                                $this->transactions->delt($value_tr['id_transaccion']);
                            }         
                    }
            $this->db->delete("transactions_ids_recibos_de_pago",array("id_recibo_de_pago"=>$value_r['id']));
            $this->db->delete("recibos_de_pago",array("id"=>$value_r['id']));

        }

            $due = $this->customers->due_details($_POST['id_customer']);
            $this->customers->actualizar_debit_y_credit($_POST['id_customer']);
            echo json_encode(array("status"=>"realizado","total"=>amountFormat(($due['total']-$due['pamnt']))));


}
    public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist();
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "View Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        $data['attach'] = $this->invocies->attach($tid);
		$data['paqueteinter'] = $this->invocies->paquetes('inter');
		$data['paquete'] = $this->invocies->paquetes('tv');
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['activity'] = $this->invocies->invoice_transactions($tid);

        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $data['servicios_adicionales'] = $this->invocies->servicios_adicionales($tid,true);

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($data['invoice']) $this->load->view('invoices/view', $data);
        $this->load->view('fixed/footer');

    }
    public function ver_estado_de_cuenta_user(){
        $this->load->model('accounts_model');
        $this->load->model('customers_model',"customers");
        $data['acclist'] = $this->accounts_model->accountslist();
        $csd = intval($this->input->get('id'));
        $data['id'] = $csd;
        $head['title'] = "Estado Cuenta Usuario $csd";
        $data['due'] = $this->customers->due_details($csd);
        $total_customer=$data['due']['total']-$data['due']['pamnt'];
        $data['customer']=$this->db->get_where("customers",array("id"=>$csd))->row();
        $data['transacciones'] = $this->invocies->ultima_transaccion_realizada($csd);
        if($total_customer>0){
            $data['products'] = $this->invocies->invoice_sin_pagar($csd);        
        }else if($total_customer==0){
            $data['products'] = $this->invocies->ultima_factura($csd);        
        }else{
            $informacion = $this->invocies->pagadas_adelantadas($csd);        
            $data['products']=array("0"=>$informacion['factura_saldo_adelantado']);
            $data['tr_saldo_adelantado']=$informacion['tr_saldo_adelantado'][0];
            $data['facturas_adelantadas']=$informacion['facturas_adelantadas'];

        }
        $data['total_customer']=$total_customer;
        
        $data['customer']->ciudad=$this->db->get_where("customers_group",array("id"=>$data['customer']->gid))->row()->title;               

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/estado_cuenta_user', $data);
        $this->load->view('fixed/footer');
    }

    public function printinvoice()
    {

        $tid = $this->input->get('id');
        $is_multiple = false;
        if(!empty($this->input->get('multiple'))){
                $is_multiple=true;
        }
        
        $lista= explode(",",$tid);
        $tid=$lista[0];

        $data['id'] = $tid;
        $data['is_multiple'] = $is_multiple;
        $data['title'] = "Invoice $tid";
        $data['vrm']=0;
        $data['pa']="no";
        if(!empty($this->input->get('vrm'))){
                $data['vrm']=$this->input->get('vrm');
        }
        if(!empty($this->input->get('pa'))){
                $data['pa']=$this->input->get('pa');
        }

        $data['invoice'] = $this->invocies->invoice_details($tid);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $this->load->model('customers_model', 'customers');
        $data['due'] = $this->customers->due_details($data['invoice']['csd']);
        
        
                $data['invoice']['total2']=$data['invoice']['total'];
                $data['invoice']['discount2']=$data['invoice']['discount'];
                $data['invoice']['multi2']=$data['invoice']['multi'];
                $data['invoice']['pamnt2']=$data['invoice']['pamnt'];
                $data['lista_invoices']= array();
        foreach ($lista as $key => $id_factura) {
            if($key!=0){
                $inv=$this->invocies->invoice_details($id_factura, $this->limited);
                $data['lista_invoices'][]=$inv;
                $data['invoice']['total2']+=$inv['total'];
                $data['invoice']['discount2']+=$inv['discount'];
                $data['invoice']['multi2']+=$inv['multi'];
                $data['invoice']['pamnt2']+=$inv['pamnt'];
                //$data['invoice']['termtit2'].=$inv['terms'];
               
            }
        }

        $lista_de_facturas_sin_pagar=$this->db->query('SELECT * FROM `invoices` WHERE csd="'.$data['invoice']['csd'].'" and (status="partial" or status="due")')->result_array();
        $data['lista_de_facturas_sin_pagar']=$lista_de_facturas_sin_pagar;
        $data['facturas_adelantadas_list']=$this->invocies->calculo_de_facturas_adelantadas($data['vrm'],$data['invoice']['csd']);
        ini_set('memory_limit', '128M');

        $html = $this->load->view('invoices/view-print-'.LTR, $data, true);
        $html2 = $this->load->view('invoices/header-print-'.LTR, $data, true);

        //PDF Rendering
        $this->load->library('pdf_invoice');

        $pdf = $this->pdf_invoice->load();
        $pdf->SetHTMLHeader($html2);
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

        $pdf->WriteHTML($html);
                /* Escritura de archivos para visualizar pdfs de resivos*/
        if(!is_dir("userfiles/txt_para_pdf_resivos/")){
             mkdir("userfiles/txt_para_pdf_resivos/", 0777, true);
        }
        $x=getdate()[0];
                    $file = fopen("userfiles/txt_para_pdf_resivos/header_".$tid."_".$x.".txt", "w");
            fwrite($file, $html2 );
            fclose($file);

            $file = fopen("userfiles/txt_para_pdf_resivos/body_".$tid."_".$x.".txt", "w");            
            fwrite($file, $html );
            fclose($file);
/* end  Escritura de archivos para visualizar pdfs de resivos*/
/* guardando datos de registro para la lectura de los pdfs*/
$ids_transactions=null;
$cust=$this->db->get_where("customers",array("id"=>$data['invoice']['csd']))->row();
foreach ($lista as $key => $value) {
        $inv=$this->db->get_where("invoices",array("tid"=>$value))->row();   
        try {
            $ids_transactions=json_decode($cust->ids_transacciones_rp); 
         } catch (Exception $e) {
             
         } 
            
            //si se siguen presentando errores se debe de pasar esto tambien a una tabla con registros individuales y no en json
        
         if($ids_transactions!=null && is_array($ids_transactions)){
                 $fecha_actual=new DateTime();

                $data_recib=array("date"=>$fecha_actual->format("Y-m-d h:i:s"),"file_name"=>$tid."_".$x,"tid"=>$value);
                $this->db->insert("recibos_de_pago",$data_recib);
                $id_recibo=$this->db->insert_id();
                foreach ($ids_transactions as $key_tr => $value_tr) {
                    $data_xy=array("id_recibo_de_pago"=>$id_recibo,"id_transaccion"=>$value_tr);
                    $this->db->insert("transactions_ids_recibos_de_pago",$data_xy);
                }
            $this->db->update("customers",array("ids_transacciones_rp"=>null),array("id"=>$data['invoice']['csd']));
         }
        
       
        //"id_transacciones"=>$ids_transactions
        //$array[]=$var_a;
        //$this->db->update("invoices",array("resivos_guardados"=>json_encode($array)),array("tid"=>$value));
}
       
        if ($this->input->get('d')) {

            $pdf->Output('Invoice_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Invoice_#' . $tid . '.pdf', 'I');
        }

    }
     public function printinvoice_estado_user()
    {

        $id = $this->input->get('id');
        
        
       
        

        
        
        $data['title'] = "Estado de cuemta usuario $id";
        $data['vrm']=0;
        if(!empty($this->input->get('vrm'))){
                //$data['vrm']=$this->input->get('vrm');
        }

        $data['customer'] = $this->db->get_where("customers",array("id"=>$id))->row();
        
 //de estado view

        $this->load->model('accounts_model');
        $this->load->model('customers_model',"customers");
        $data['acclist'] = $this->accounts_model->accountslist();
        $csd = intval($this->input->get('id'));
        $data['id'] = $csd;
        $head['title'] = "Estado Cuenta Usuario $csd";
        $data['due'] = $this->customers->due_details($csd);
        $total_customer=$data['due']['total']-$data['due']['pamnt'];
        $data['transacciones'] = $this->invocies->ultima_transaccion_realizada($csd);
        if($total_customer>0){
            $data['products'] = $this->invocies->invoice_sin_pagar($csd);        
        }else if($total_customer==0){
            $data['products'] = $this->invocies->ultima_factura($csd);        
        }else{
            $informacion = $this->invocies->pagadas_adelantadas($csd);        
            $data['products']=array("0"=>$informacion['factura_saldo_adelantado']);
            $data['tr_saldo_adelantado']=$informacion['tr_saldo_adelantado'][0];
            $data['facturas_adelantadas']=$informacion['facturas_adelantadas'];

        }
        $data['total_customer']=$total_customer;
               


        //end de estado view
       


        ini_set('memory_limit', '128M');

        $html = $this->load->view('invoices/view-print-'.LTR2, $data, true);
        $html2 = $this->load->view('invoices/header-print-'.LTR, $data, true);

        //PDF Rendering
        $this->load->library('pdf_invoice');

        $pdf = $this->pdf_invoice->load();
        $pdf->SetHTMLHeader($html2);
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

        $pdf->WriteHTML($html);
       
        if ($this->input->get('d')) {

            $pdf->Output('Invoice_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Invoice_#' . $tid . '.pdf', 'I');
        }

    }
    public function printinvoice_proforma()
    {

        $tid = intval($this->input->get('id'));

        
//cambios nuevos
         $this->load->model('accounts_model');
        $this->load->model('customers_model',"customers");
        $data['acclist'] = $this->accounts_model->accountslist();
        $csd = intval($this->input->get('id'));
        $data['customer'] = $this->db->get_where("customers",array("id"=>$csd))->row();
        
        $data['due'] = $this->customers->due_details($csd);
        $total_customer=$data['due']['total']-$data['due']['pamnt'];
        $data['transaccion'] = $this->invocies->ultima_transaccion_realizada($csd);
        if($total_customer>0){
            $data['products'] = $this->invocies->invoice_sin_pagar($csd);        
        }else if($total_customer==0){
            $data['products'] = $this->invocies->ultima_factura($csd);        
        }else{
            $informacion = $this->invocies->pagadas_adelantadas($csd);        
            $data['products']=array("0"=>$informacion['factura_saldo_adelantado']);
            $data['tr_saldo_adelantado']=$informacion['tr_saldo_adelantado'][0];
            $data['transaccion']=$informacion['tr_saldo_adelantado'];
            $data['facturas_adelantadas']=$informacion['facturas_adelantadas'];

        }
        $data['total_customer']=$total_customer;
        

//end cambios nuevos


        $data['id'] = $tid;
        $data['title'] = "Estado Usuario $tid";
        $data['customer']->ciudad=$this->db->get_where("ciudad",array("idCiudad"=>$data['customer']->ciudad))->row()->ciudad;               
        //$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        //if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if(isset($data['products'][0]['eid'])){
            $data['employee']=$this->invocies->employee($data['products'][0]['eid']);     
        }else{
            $data['employee']=null;
        }
       
        ini_set('memory_limit', '128M');
        $html = $this->load->view('invoices/proforma_estado_user', $data, true);
        //echo $html;
        
        //PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');
        $pdf->WriteHTML($html);
        if ($this->input->get('d')) {
            $pdf->Output('Proforma_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Proforma_#' . $tid . '.pdf', 'I');
        }


    }
    public function printinvoice2()
    {

        
        ini_set('memory_limit', '128M');
        $nombre_fichero=$this->input->get("file_name").".txt";

        $html = file_get_contents('userfiles/txt_para_pdf_resivos/body_'.$nombre_fichero, FILE_USE_INCLUDE_PATH);
        $html2 = file_get_contents('userfiles/txt_para_pdf_resivos/header_'.$nombre_fichero, FILE_USE_INCLUDE_PATH);

        //PDF Rendering
        $this->load->library('pdf_invoice');

        $pdf = $this->pdf_invoice->load();
        $pdf->SetHTMLHeader($html2);
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');
//echo $html;
        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Invoice_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Invoice_#' . $tid . '.pdf', 'I');
        }




    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->invocies->invoice_delete($id, $this->limited)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editaction()
    {


        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes');
        $tax = $this->input->post('tax_handle');
        $subtotal = $this->input->post('subtotal');
        $shipping = $this->input->post('shipping');
        $refer = $this->input->post('refer');
		$television = $this->input->post('television');
		$combo = $this->input->post('combo');
		$puntos = $this->input->post('puntos');
        $total = $this->input->post('total');
        $tipo_factura = $this->input->post('tipo_factura');
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $currency = $this->input->post('mcurrency');
        $i = 0;

        if ($this->limited) {
            $employee = $this->invocies->invoice_details($invocieno, $this->limited);
            if ($this->aauth->get_user()->id != $employee['eid']) exit();

        }
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new client')));
            exit;


        }


        $this->db->trans_start();
        $flag = false;
        $transok = true;


        //Product Data
        $pid = $this->input->post('pid');
        $productlist = array();

        $prodindex = 0;
        $itc = 0;

        $this->db->delete('invoice_items', array('tid' => $invocieno));

                        $data_h=array();
                        $data_h['modulo']="Ventas";
                        $data_h['accion']="Editar Factura {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array('tid' => $invocieno));
                        $data_h['tabla']="invoice_items";
                        $data_h['nombre_columna']="tid";
                        $data_h['id_fila']=$invocieno;
                        $this->db->insert("historial_crm",$data_h);
        if ($tax == 'yes') {
            $taxstatus = 1;

            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = $this->input->post('old_product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description');
                $total_discount += $ptotal_disc[$key];
                
                if($tipo_factura=="Nota Credito"){
                        $product_price[$key]=abs($product_price[$key]);
                        $var1=$product_price[$key]*2;
                        $product_price[$key]=$product_price[$key]-$var1;
                        $product_subtotal[$key]=abs($product_subtotal[$key]);
                        $var1=$product_subtotal[$key]*2;
                        $product_subtotal[$key]=$product_subtotal[$key]-$var1;
                        $ptotal_tax[$key]=abs($ptotal_tax[$key]);
                        $var1=$ptotal_tax[$key]*2;
                        $ptotal_tax[$key]=$ptotal_tax[$key]-$var1;
                        
                 }
                 $total_tax += $ptotal_tax[$key];
                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'qty' => $product_qty[$key],
                    'price' => $product_price[$key],
                    'tax' => $product_tax[$key],
                    'discount' => $product_discount[$key],
                    'subtotal' => $product_subtotal[$key],
                    'totaltax' => $ptotal_tax[$key],
                    'totaldiscount' => $ptotal_disc[$key],
                    'product_des' => $product_des[$key]

                );


                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;

                $amt = intval($product_qty[$key]) - intval(@$old_product_qty[$key]);

                if ($product_id[$key] > 0) {
                    $this->db->set('qty', "qty-$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('products');
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Editar Factura {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array('qty' => "qty-$amt"));
                            $data_h['tabla']="products";
                            $data_h['nombre_columna']="pid";
                            $data_h['id_fila']=$product_id[$key];
                            $this->db->insert("historial_crm",$data_h);
                }
                $itc += $amt;


            }
        } else {
            $taxstatus = 0;
            foreach ($pid as $key => $value) {
                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = $this->input->post('old_product_qty');
                $product_price = $this->input->post('product_price');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $product_des = $this->input->post('product_description');
                $ptotal_disc = $this->input->post('disca');
                $total_discount += $ptotal_disc[$key];

                if($tipo_factura=="Nota Credito"){
                        $product_price[$key]=abs($product_price[$key]);
                        $var1=$product_price[$key]*2;
                        $product_price[$key]=$product_price[$key]-$var1;
                        $product_subtotal[$key]=abs($product_subtotal[$key]);
                        $var1=$product_subtotal[$key]*2;
                        $product_subtotal[$key]=$product_subtotal[$key]-$var1;
                        
                 }

                $data = array(
                    'tid' => $invocieno,
                    'product' => $product_name1,
                    'qty' => $product_qty,
                    'price' => $product_price,
                    'discount' => $product_discount,
                    'subtotal' => $product_subtotal,
                    'product_des' => $product_des[$key]
                );


                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;

                if ($product_id[$key] > 0) {
                    $amt = intval($product_qty[$key]) - intval($old_product_qty[$key]);
                    $this->db->set('qty', "qty-$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('products');
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Editar Factura {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array('qty' => "qty-$amt"));
                            $data_h['tabla']="products";
                            $data_h['nombre_columna']="pid";
                            $data_h['id_fila']=$product_id[$key];
                            $this->db->insert("historial_crm",$data_h);
                }


                $itc += $amt;

            }
        }

        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
  if($tipo_factura=="Nota Credito"){
                    $subtotal=abs($subtotal);
                    $var1=$subtotal*2;
                    $subtotal=$subtotal-$var1;
                    $total_tax=abs($total_tax);
                    $var1=$total_tax*2;
                    $total_tax=$total_tax-$var1;
                    $total=abs($total);
                    $var1=$total*2;
                    $total=$total-$var1;
                    
                }
if($total_tax>0){
            $subtotal=$total-$total_tax;
        }
        $data = array(
			'invoicedate' => $bill_date,
			'invoiceduedate' => $bill_due_date,
			'subtotal' => $subtotal,
			'shipping' => $shipping,
			'discount' => $total_discount,
			'tax' => $total_tax,
			'total' => $total,
			'notes' => $notes,
			'csd' => $customer_id,
			'items' => $itc,
			'taxstatus' => $taxstatus,
			'discstatus' => $discstatus,
			'format_discount' => $discountFormat,
			'refer' => $refer,
			'television' => $television,
			'combo' => $combo,
			'puntos' => $puntos,
			'term' => $pterms,
			'multi' => $currency,
            'tipo_factura'=>$tipo_factura
        );
        $this->db->set($data);
        $this->db->where('tid', $invocieno);

        if ($flag) {
/**/
            if ($this->db->update('invoices', $data)) {

                            foreach ($_POST as $llave => $valor) {
                                    if(strpos($llave,"serv_add_")!==false){
                                        $pid_serv=str_replace("serv_add_", "", $llave);
                                        if($valor!="0"){
                                                
                                                $product_serv=$this->db->get_where("products",array("pid"=>$pid_serv))->row();
                                               // $servicios_adicionales.=" + ".$valor." ".$product_serv->product_name;    
                                                $data_serv=array();
                                                $data_serv['tid_invoice']=$invocieno;
                                                $data_serv['pid']=$pid_serv;
                                                $data_serv['valor']=$valor;
                                                $precio=$product_serv->product_price;
                                                if(is_int($valor)){
                                                 //   $precio*$valor;
                                                }
                                                $data_serv['subtotal']=$precio;
                                                $data_serv['total']=$precio;
                                                $servicios_adicional_antiguo=$this->db->get_where("servicios_adicionales",array("tid_invoice"=>$invocieno,"pid"=>$pid_serv))->row();
                                                
                                                if(isset($servicios_adicional_antiguo)){
                                                    $this->db->update("servicios_adicionales",array("valor"=>$valor),array("id"=>$servicios_adicional_antiguo->id));
                                                }else{
                                                    
                                                    $this->db->insert("servicios_adicionales",$data_serv);    
                                                }
                                                
                                        }else if($valor=="0"){
                                            $this->db->delete("servicios_adicionales",array("pid"=>$pid_serv,"tid_invoice"=>$invocieno));
                                        }
                                        
                                    }
                            }
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Editar Factura {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data);
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $data_h['id_fila']=$invocieno;
                            $this->db->insert("historial_crm",$data_h);
                $this->db->insert_batch('invoice_items', $productlist);
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Editar Factura {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($productlist);
                            $data_h['tabla']="invoice_items";
                            $data_h['nombre_columna']="id";
                            $data_h['id_fila']=$this->db->insert_id();
                            $this->db->insert("historial_crm",$data_h);
                $this->load->model('customers_model', 'customers');
                $servicios_detail=$this->customers->servicios_detail($customer_id);            
                if($servicios_detail['tid']!=0 && $servicios_detail['tid']!=null && $servicios_detail['tid']!=''){
                    
                    $due=$this->customers->due_details($customer_id);

                    $datox=$due['total']-$due['pamnt'];

                    if($datox==0){
                            //due
                        $this->db->update("invoices",array("status"=>"paid"),array("tid"=>$servicios_detail['tid']));
                                $data_h=array();
                                $data_h['modulo']="Ventas";
                                $data_h['accion']="Editar Factura {update}";
                                $data_h['id_usuario']=$this->aauth->get_user()->id;
                                $data_h['fecha']=date("Y-m-d H:i:s");
                                $data_h['descripcion']=json_encode(array("status"=>"paid"));
                                $data_h['tabla']="invoices";
                                $data_h['nombre_columna']="tid";
                                $data_h['id_fila']=$servicios_detail['tid'];
                                $this->db->insert("historial_crm",$data_h);
                    }else if($datox>0){
                            //partial
                        $this->db->update("invoices",array("status"=>"partial"),array("tid"=>$servicios_detail['tid']));
                                    $data_h=array();
                                    $data_h['modulo']="Ventas";
                                    $data_h['accion']="Editar Factura {update}";
                                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                                    $data_h['fecha']=date("Y-m-d H:i:s");
                                    $data_h['descripcion']=json_encode(array("status"=>"partial"));
                                    $data_h['tabla']="invoices";
                                    $data_h['nombre_columna']="tid";
                                    $data_h['id_fila']=$servicios_detail['tid'];
                                    $this->db->insert("historial_crm",$data_h);
                    }
                }
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Invoice has  been updated') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . " </a> "));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
                $transok = false;
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add at least one product in invoice"));
            $transok = false;
        }


        if ($this->input->post('restock')) {
            foreach ($this->input->post('restock') as $key => $value) {


                $myArray = explode('-', $value);
                $prid = $myArray[0];
                $dqty = $myArray[1];
                if ($prid > 0) {

                    $this->db->set('qty', "qty+$dqty", FALSE);
                    $this->db->where('pid', $prid);
                    $this->db->update('products');
                                    $data_h=array();
                                    $data_h['modulo']="Ventas";
                                    $data_h['accion']="Editar Factura {update}";
                                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                                    $data_h['fecha']=date("Y-m-d H:i:s");
                                    $data_h['descripcion']=json_encode(array("qty"=>"qty+$dqty"));
                                    $data_h['tabla']="products";
                                    $data_h['nombre_columna']="pid";
                                    $data_h['id_fila']=$prid;
                                    $this->db->insert("historial_crm",$data_h);
                }
            }


        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('tid', $tid);
        $this->db->update('invoices');
             $data_h=array();
            $data_h['modulo']="Ventas";
            $data_h['accion']="Administrar Facturas > ver factura > cambiar estado {update}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode(array("status"=>$status));
            $data_h['id_fila']=$tid;
            $data_h['tabla']="invoices";
            $data_h['nombre_columna']="tid";
            $this->db->insert("historial_crm",$data_h);
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }


    public function addcustomer()
    {
        $name = $this->input->post('name');
		$dosnombre = $this->input->post('dosnombre');
        $unoapellido = $this->input->post('unoapellido');
		$dosapellido = $this->input->post('dosapellido');
        $company = $this->input->post('company');
        $celular = $this->input->post('celular');
        $celular2 = $this->input->post('celular2');
        $email = $this->input->post('email');
        $nacimiento = $this->input->post('nacimiento');
        $tipo_cliente = $this->input->post('tipo_cliente');
        $tipo_documento = $this->input->post('tipo_documento');
        $documento = $this->input->post('documento');
        $departamento = $this->input->post('departamento');
        $ciudad = $this->input->post('ciudad');
        $localidad = $this->input->post('localidad');
        $barrio = $this->input->post('barrio');
        $nomenclatura = $this->input->post('nomenclatura');
        $numero1 = $this->input->post('numero1');
        $adicionauno = $this->input->post('adicionauno');
        $numero2 = $this->input->post('numero2');
        $adicional2 = $this->input->post('adicional2');
		$numero3 = $this->input->post('numero3');
		$residencia = $this->input->post('residencia');
		$referencia = $this->input->post('referencia');
		$customergroup = $this->input->post('customergroup');
		$name_s = $this->input->post('name_s');
		$contra = $this->input->post('contra');
		$servicio = $this->input->post('servicio');
		$perfil = $this->input->post('perfil');
		$Iplocal = $this->input->post('Iplocal');
		$Ipremota = $this->input->post('Ipremota');
		$comentario = $this->input->post('comentario');
        $this->customers->add($name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario);

    }

    public function file_handling()
    {
        if($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->invocies->meta_delete($invoice,1, $name)){
            echo json_encode(array('status' => 'Success'));
        }
        }
        else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->invocies->meta_insert($id, 1, $files);
            }
        }


    }

    	    public function delivery()
    {

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

        ini_set('memory_limit', '64M');

        $html = $this->load->view('invoices/del_note', $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('DO_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('DO_#' . $tid . '.pdf', 'I');
        }


    }

	    public function proforma()
    {

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;
        $data['title'] = "Invoice $tid";
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        ini_set('memory_limit', '128M');
        $html = $this->load->view('invoices/proforma', $data, true);
        //PDF Rendering
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');
        $pdf->WriteHTML($html);
        if ($this->input->get('d')) {
            $pdf->Output('Proforma_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Proforma_#' . $tid . '.pdf', 'I');
        }


    }


	 public function duplicate()
    {

        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['title'] = "New Invoice";
        $this->load->model('customers_model', 'customers');
		$data['lastinvoice'] = $this->invocies->lastinvoice();
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->invocies->billingterms();
        $data['currency'] = $this->invocies->currencies();
        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);

        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->invocies->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);

        $this->load->view('fixed/header', $head);
        if ($data['invoice']) $this->load->view('invoices/duplicate', $data);
        $this->load->view('fixed/footer');

    }

    public function prueba(){
        $lista=$this->db->query("SELECT invoice_items.id as id_i,invoice_items.tid as tid_i, invoice_items.subtotal as subtotal_item,invoices.subtotal as subtotal_inv,invoices.total as total_inv FROM `invoice_items` JOIN invoices ON invoice_items.tid=invoices.tid WHERE `status`='due' AND product='Reconexión internet'")->result();
        foreach ($lista as $key => $value) {
            $total=$value->total_inv-$value->subtotal_item;
            $subTotal=$value->subtotal_inv-$value->subtotal_item;
            $this->db->update("invoices",array("subtotal"=>$subTotal,"total"=>$total),array("tid"=>$value->tid_i));
            $this->db->delete("invoice_items",array("id"=>$value->id_i));
        }  

    }

    public function crear_nota_debito_credito(){
        $this->load->model('customers_model', 'customers');
        $array_facturas=$_POST['lista'];
        $monto=$_POST['valor_nota'];
        $valor_restante_monto=0;
        $montos=array();
        $array_facturas2=array();
        $_id_last_invoice_procesed=0;
            foreach ($array_facturas as $key => $id_factura) {
                $factura_var = $this->db->get_where('invoices',array('tid'=>$id_factura))->row();                                
                
                $total_factura=$factura_var->total;
                if($factura_var->status=="partial"){
                    $total_factura=$factura_var->total-$factura_var->pamnt;
                }
                $valor_restante_monto=$monto-$total_factura;

                if($valor_restante_monto>=0){
                    $montos[$id_factura]=$total_factura;
                    $array_facturas2[]=$id_factura;
                    $monto=$valor_restante_monto;
                    $_id_last_invoice_procesed=$id_factura;
                }else if($monto>0 && $factura_var->status!="partial"){
                    $montos[$id_factura]=$monto;
                    $array_facturas2[]=$id_factura;
                    $monto=$valor_restante_monto;  
                    $_id_last_invoice_procesed=$id_factura;
                }else if($valor_restante_monto<0 && $monto>0 && $factura_var->status=="partial"){
                    $montos[$id_factura]=$monto;
                    $array_facturas2[]=$id_factura;
                    $monto=$valor_restante_monto;
                    $_id_last_invoice_procesed=$id_factura;  
                    break;
                }
                
            }
            //var_dump($valor_restante_monto);
            if($valor_restante_monto>0){
                $montos[$_id_last_invoice_procesed]+=$valor_restante_monto;
            }
            
            foreach ($array_facturas2 as $key => $id_factura) {
                    $data_invoice_item=array();
                    $data_invoice_item['tid']=$id_factura;
                    $data_invoice_item['pid']=0;
                    $data_invoice_item['product']=$_POST['nota_seleccionada'];
                    $data_invoice_item['qty']=1;
                    $data_invoice_item['tax']=0;
                    $data_invoice_item['discount']=0;
                    $data_invoice_item['totaltax']=0;
                    $data_invoice_item['totaldiscount']=0;
                    if($_POST['des_nota']!="" && $_POST['des_nota']!=" " && $_POST['des_nota']!="null" && $_POST['des_nota']!=null){
                        $data_invoice_item['product_des']=$_POST['des_nota'];
                    }
                    $invoice=$this->db->get_where("invoices",array("tid"=>$id_factura))->row();
                    $data_invoice=array();
                if($_POST['nota_seleccionada']=="Nota Credito"){
                    $data_invoice_item['price']=-abs($montos[$id_factura]);  
                    
                    $data_invoice['subtotal']=$invoice->subtotal-$montos[$id_factura];
                    $data_invoice['total']=$invoice->total-$montos[$id_factura];
                    if($data_invoice['subtotal']<0){
                        $data_invoice['subtotal']=0;
                        $data_invoice['tax']=$data_invoice['total'];
                        $data_invoice_item['tax_removed']=$invoice->tax-$data_invoice['tax'];
                    }
                    if(($data_invoice['total']-$invoice->pamnt)<=0){
                        $data_invoice['status']="paid";
                    }

                }else{//nota debito
                    $data_invoice_item['price']=$montos[$id_factura];                    
                    $data_invoice['subtotal']=$invoice->subtotal+$montos[$id_factura];
                    $data_invoice['total']=$invoice->total+$montos[$id_factura];
                    //falta aca cuando aumenta el valor calcular el status si tiene transacciones
                    if($invoice->pamnt!=0){
                        if($invoice->pamnt<$data_invoice['total']){
                                $data_invoice['status']="partial";
                        }
                    }
                }
                    $data_invoice_item['subtotal']=$data_invoice_item['price'];
                    $data_invoice_item['id_usuario_crea']=$this->aauth->get_user()->id;
                    $data_invoice_item['fecha_creacion']=date("Y-m-d H:i:s");
                    //var_dump($data_invoice);
                    $this->db->insert("invoice_items",$data_invoice_item);
                    $this->db->update("invoices",$data_invoice,array("tid"=>$id_factura));

            }
            $due = $this->customers->due_details($_POST['id_customer']);
            $this->customers->actualizar_debit_y_credit($_POST['id_customer']);
            echo json_encode(array("status"=>"realizado","total"=>amountFormat(($due['total']-$due['pamnt']))));
    }

    function eliminar_nota(){
        $nota=$this->db->get_where("invoice_items",array("id"=>$_POST['id_nota']))->row();
        $invoice=$this->db->get_where("invoices",array("tid"=>$nota->tid))->row();
        $data_invoice=array();
        if($nota->product=="Nota Credito"){

                $data_invoice['total']=$invoice->total+abs($nota->price);
                $data_invoice['tax']=$invoice->tax;
                if($nota->tax_removed!=null && $nota->tax_removed>0){
                    $data_invoice['tax']=$invoice->tax+$nota->tax_removed;    
                }else{

                }
                $data_invoice['subtotal']=$data_invoice['total']-$data_invoice['tax'];
                if($invoice->pamnt!=0){
                        if($invoice->pamnt<$data_invoice['total']){
                                $data_invoice['status']="partial";
                        }
                }else{
                        if($invoice->pamnt==0){
                                $data_invoice['status']="due";
                        }
                }
                //var_dump($data_invoice);
                $this->db->update("invoices",$data_invoice,array("tid"=>$nota->tid));
                $this->db->delete("invoice_items",array("id"=>$nota->id));
                echo "Realizado";
        }else{
                $data_invoice['total']=$invoice->total-abs($nota->price);
                $data_invoice['tax']=$invoice->tax;
                $data_invoice['subtotal']=$data_invoice['total']-$data_invoice['tax'];
                 if(($data_invoice['total']-$invoice->pamnt)<=0){
                        $data_invoice['status']="paid";
                    }
                //var_dump($data_invoice);
                $this->db->update("invoices",$data_invoice,array("tid"=>$nota->tid));
                $this->db->delete("invoice_items",array("id"=>$nota->id));
                echo "Realizado";
        }
    }

}