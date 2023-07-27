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

class Customers_model extends CI_Model
{

    var $table = 'customers';
    var $column_order = array(null, 'name', 'address', 'email', 'phone', null);
    var $column_search = array('id','abonado','name', 'celular', 'documento', 'unoapellido', 'email','usu_estado');
    var $trans_column_order = array('date', 'debit', 'credit', 'account', null);
    var $trans_column_search = array('id', 'date');
	var $sup_column_order = array(null, 'codigo', 'subject', 'detalle', 'created','fecha_final','id_factura','status', null);
    var $sup_column_search = array('idt', 'codigo', 'detalle', 'created', 'abonado', 'id_factura', 'ciudad','asignado','status',);
	var $equi_column_search = array('id', 'codigo');
	var $equi_column_order = array('null', 'codigo', 'mac', 'serial', 'estado', 'marca', null);
    var $inv_column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $inv_column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('id' => 'desc');
    var $inv_order = array('invoices.tid' => 'desc');
	var $sup_order = array('tickets.codigo' => 'desc');
	var $equi_order = array('equipos.id' => 'desc');
    //var $ip_coneccion_mikrotik='190.14.233.186:8728';//192.168.201.1:8728 ip jefe |||| 190.14.233.186:8728 ip duber

    private function _get_datatables_query($id = '')
    {

        if (isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null) {
            $this->db->select("*,cus1.id as idx");
            
        }
        $this->db->from($this->table." as cus1");

        if (isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null) {
            $this->db->join("invoices as inv1","cus1.id=inv1.csd and inv1.tid=(select max(tid) from invoices as inv2 where inv2.csd=cus1.id and ((inv2.combo !='no' and inv2.combo !='' and inv2.combo !='-') or  (inv2.television !='no' and inv2.television !='' and inv2.television !='-')))");
            if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                $this->db->where('combo!=',"no" );
                $this->db->where('combo!=',"" );
                $this->db->where('combo!=',"-" );   
            }else if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
               $this->db->where('television=',"television" );                
            }
        }
        if ($id != '') {
            $this->db->where('cus1.gid', $id);
        }
        if (isset($_GET['estado']) && $_GET['estado'] != '' && $_GET['estado'] != null) {
            $this->db->where('usu_estado=', $_GET['estado']);
        }
        if (isset($_GET['direccion']) &&$_GET['direccion'] =="Personalizada"){ 
            if ($_GET['localidad'] != '' && $_GET['localidad'] != '-') {
                $this->db->where('localidad=', $_GET['localidad']);
            }

            if ($_GET['barrio'] != '' && $_GET['barrio'] != '-') {
                $this->db->where('barrio=', $_GET['barrio']);
            }
            if ($_GET['nomenclatura'] != '' && $_GET['nomenclatura'] != '-') {
                $this->db->where('nomenclatura=', $_GET['nomenclatura']);
            }
            if ($_GET['numero1'] != '') {
                $this->db->where('numero1=', $_GET['numero1']);
            }
            if ($_GET['adicionauno'] != '' && $_GET['adicionauno'] != '-') {
                $this->db->where('adicionauno=', $_GET['adicionauno']);
            }
            if ($_GET['numero2'] != '' && $_GET['numero2'] != '-') {
                $this->db->where('numero2=', $_GET['numero2']);
            }
            if ($_GET['adicional2'] != '' && $_GET['adicional2'] != '-') {
                $this->db->where('adicional2=', $_GET['adicional2']);
            }
            if ($_GET['numero3'] != '' && $_GET['numero3'] != '-') {
                $this->db->where('numero3=', $_GET['numero3']);
            }
        }
        
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if (isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null) {
                    if($item=="id"){
                        $item="cus1.id";
                    }
                }

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
            $this->db->order_by("cus1.".$this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by("cus1.".key($order), $order[key($order)]);
        }
    }

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    public function validar_firma($id){
        $nombre="assets/firmas_digitales/".$id.".png";
        return file_exists($nombre);
    }
	public function invoice_details($custid)
    {

        $this->db->select('invoices.*,customers.*');
        $this->db->from('invoices');
        $this->db->where('invoices.csd', $custid);        
        $this->db->join('customers', 'invoices.csd = customers.id', 'left');
        
        $query = $this->db->get();
        return $query->row_array();

    }
	public function invoice_list($custid)
    {

        $this->db->select('*');
        $this->db->from('invoices');
        $this->db->where('csd', $custid);
		$this->db->order_by('invoicedate', 'desc');
        $query = $this->db->get();
        return $query->result_array();

    }
	public function estado_list($custid)
    {
        $this->db->select('*');
        $this->db->from('estados');
		$this->db->join('customers', 'estados.cid=customers.id', 'left');
		$this->db->where('cid', $custid);
        $query = $this->db->get();
        return $query->result_array();
    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        return $query->num_rows($id = '');
    }
	public function codigouser()
    {
        $this->db->select('abonado');
        $this->db->from($this->table);
        $this->db->where("abonado!=","OS724");
        $this->db->order_by('abonado', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->abonado;
        } else {
            return 1000;
        }
    }

    public function details($custid)
    {

        $this->db->select('*');
        $this->db->from($this->table);
		//$this->db->join('departamentos', 'customers.departamento = departamentos.idDepartamento', 'left');
		//$this->db->join('ciudad', 'customers.ciudad = ciudad.idCiudad', 'left');
		//$this->db->join('localidad', 'customers.localidad = localidad.idLocalidad', 'left');
		//$this->db->join('barrio', 'customers.barrio = barrio.idBarrio', 'left');
        $this->db->where('id', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function equipo_details($custid)
    {

        $this->db->select('*');
        $this->db->from('equipos');
		$this->db->join('naps', 'naps.idn = equipos.nat','left');
		$this->db->join('vlans', 'vlans.idv = naps.idvlan','left');
		$this->db->join('puertos', 'puertos.idnap = naps.idn','left');
        $this->db->where('equipos.asignado', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function list_promos()
    {	
		$user = $this->aauth->get_user()->id;
        $this->db->select('*');
        $this->db->from('promos');
		$this->db->where('f_inicio<=', date('Y-m-d'));
		$this->db->where('f_final>=', date('Y-m-d'));
		$this->db->group_start();
		$this->db->like('colaborador', $user);
		$this->db->or_where('colaborador', 'null');
		$this->db->group_end();
        $query = $this->db->get();
        return $query->result_array();
    }
	 public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('meta_data', $data);
        } else {
            return 0;
        }
    }

    public function attach($id,$cat)
    {
        $this->db->select('meta_data.*');
        $this->db->from('meta_data');
        $this->db->where('meta_data.type', $cat);
        $this->db->where('meta_data.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
	public function meta_delete($id,$type,$name)
    {
        $x=@unlink(FCPATH . 'userfiles/attach/' . $name);
        $y=@unlink(FCPATH . 'userfiles/attach/thumbnail/' . $name);
        //$x=true;
        
        if ($x || $y) {
            /*if($type==null){
                $type=6;
            }*/
            return $this->db->delete('meta_data', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }

    public function money_details($custid)
    {

        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('transactions');
        $this->db->where('payerid', $custid);
		$this->db->where('estado' , null);
		$this->db->where('ext', '0');
        if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="fecha_ingreso" && $_GET['ingreso_select']!=null){
                $dateTime= new DateTime($_GET['sdate']);
                $sdate=$dateTime->format("Y-m-d");
                $dateTime= new DateTime($_GET['edate']);
                $edate=$dateTime->format("Y-m-d");

                $this->db->where("date>=",$sdate);
                $this->db->where("date<=",$edate);
        }
        $query = $this->db->get();
        return $query->row_array();
    }
      public function actualizar_debit_y_credit($id_customer){
        set_time_limit(20000);
        $array=$this->money_details($id_customer);
        $data=array();
        $data['debit']=$array['debit'];
        $data['credit']=$array['credit'];
        $this->db->update("customers",$data,array("id"=>$id_customer));

    }

        public function due_details($custid)
    {

       $this->db->select('*, SUM(total) AS total,SUM(pamnt) AS pamnt,MAX(television) AS television,MAX(combo) AS combo,MAX(puntos) AS puntos,MAX(ron) AS estado');
        $this->db->from('invoices');
        $this->db->where('csd', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function pago_details($custid,$fcha,$fchavence)
    {

       $this->db->select('*, SUM(credit) AS pago');
        $this->db->from('transactions');
        $this->db->where('payerid', $custid);
        $this->db->where('date>=', $fcha);
        $this->db->where('date<=', $fchavence);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function due_details2($custid)
    {

       $this->db->select('SUM(total) AS total,SUM(pamnt) AS pamnt,estado_tv,estado_combo');
        $this->db->from('invoices');
        $this->db->where('csd', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function conteo($lista_customers){
        $tv=0;
$internet=0;
$internet_y_tv=0;
$activo_con_algun_servicio=0;
$tvcor=0;
$internetcor=0;
$internet_y_tv_cor=0;
$tv_sus=0;
$internet_sus=0;
$internet_y_tv_sus=0;
$deuda_todos=0;
$int_tvcor=0;

foreach ($lista_customers as $key => $customer) {
$var_excluir=false;
            $lista_invoices = $this->db->from("invoices")->where("csd",$customer->id)->order_by('invoicedate,tid',"DESC")->get()->result();
            $customer_moroso=false;
            $valor_ultima_factura=0;
            $_var_tiene_internet=false;
            $_var_tiene_tv=false;
            $suscripcion_str="";
            $tv_cortado=false;
            $net_cortado=false;
            $tv_suspendido=false;
            $net_suspendido=false;
            
                $fact_valida=false;
                $filtros_deuda_customers=0;
                $deuda_todos_=$this->due_details2($customer->id);
                $deuda_todos_=$deuda_todos_['total']-$deuda_todos_['pamnt'];
                if($deuda_todos_>0){
                    //var_dump($deuda_todos_);
                    $deuda_todos+=intval($deuda_todos_);
                }
                foreach ($lista_invoices as $key => $invoice) {
                    $suma=0;
                    if($invoice->combo!="no" && $invoice->combo!="" && $invoice->combo!="-"){
                        $fact_valida=true;
                        $_var_tiene_internet=true;
                    }
                    if($invoice->television!="no" && $invoice->television!="" && $invoice->television!="-"){
                        $fact_valida=true;
                        $_var_tiene_tv=true;
                    }
                    if($invoice->ron!="" && $invoice->ron!=null){
                        $fact_valida=true;
                    }
                    $afiliacion_traslado_omitir=$this->db->query('SELECT * FROM `invoice_items` where (product like "%afiliacion%" or product like "%traslado%") and tid="'.$invoice->tid.'"')->result_array();
                        if(count($afiliacion_traslado_omitir)!=0){
                            $fact_valida=false;
                    }

                    if($invoice->tipo_factura=="Fija" || $invoice->tipo_factura=="Nota Credito" || $invoice->tipo_factura=="Nota Debito"){
                         $fact_valida=false;
                    }
                    if($fact_valida){
                        if($_var_tiene_tv){
                            $var_excluir=false;
                                          
                            
                        }
                  
                        
                //esto es para los estados
                            if($_var_tiene_tv && $invoice->estado_tv=="Cortado"){
                               $tv_cortado=true;
                                $var_excluir=false; 
                               
                            }else if($_var_tiene_tv && $invoice->estado_tv=="Suspendido"){
                                $var_excluir=false; 
                                $tv_suspendido=true;
                               
                            }

                //esto es para los estados 

                        if($_var_tiene_internet){
							$var_excluir=false;
                            $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                           
                            
                                    if($invoice->estado_combo=="Cortado"){
                                        $var_excluir=false; 
                                        $net_cortado=true;                                        
                                    }else if($invoice->estado_combo=="Suspendido"){
                                        $var_excluir=false; 
                                        $net_suspendido=true;                                        
                                    }                                  
                               
                            
                        }
                        
                    }else{
                        $var_excluir=true;
                    }
                    if($fact_valida){
                            $customer_moroso=true;
                            //$valor_ultima_factura=$invoice->total;
                            break;
                        }

        }
                $mor_tv=$customer_moroso;
                $mor_net=$customer_moroso;
                if( !$_var_tiene_tv){//preguntar que si solo debe de filtrar los que tienen tv o si tiene tv pero tambien internet lo puede listar lo mismo con la de internet
                            $mor_tv=false;     
                }
                if(!$_var_tiene_internet){
                            $mor_net=false;     
                }
            //$customer_moroso=true;
            /*if($var_excluir){
                $mor_tv=false;     
                $mor_net=false;     
            }*/
            if($mor_tv){
                $tv++;
                if($tv_cortado){
                    $tvcor++;

                }
                if($tv_suspendido){
                    $tv_sus++;
                }
            }
            if($mor_net){
                $internet++;
                if($net_cortado){
                    $internetcor++;
                }
                 if($net_suspendido){
                    $internet_sus++;
                }
            }
            if($mor_tv && ($net_cortado || $net_suspendido)){
                $activo_con_algun_servicio++;
            }
            if($mor_net && ($tv_cortado || $tv_suspendido)){
               $int_tvcor++; 
            }
            if($mor_tv  && $mor_net ){
               $internet_y_tv++;
               if($tv_cortado && $net_cortado){
                    $internet_y_tv_cor++;
                    
                } 
                 if($tv_suspendido && $net_suspendido){
                    $internet_y_tv_sus++;
                }
            }
			
      			
        
        }

        //var_dump($deuda_todos);
        //exit();
        return array("tv"=>$tv,"net"=>$internet,"int_tvcor"=>$int_tvcor,"activo_con_algun_servicio"=>$activo_con_algun_servicio,"internet_y_tv"=>$internet_y_tv,"tvcor"=>$tvcor,"internetcor"=>$internetcor,"internet_y_tv_cor"=>$internet_y_tv_cor,"tv_sus"=>$tv_sus,"internet_sus"=>$internet_sus,"internet_y_tv_sus"=>$internet_y_tv_sus,"deuda_todos"=>$deuda_todos);
        
    }
         public function servicios_detail($custid)
    {
        $lista_invoices = $this->db->from("invoices")->where("csd",$custid)->order_by('invoicedate,tid',"DESC")->get()->result();
        $customer_moroso=false;
        $valor_ultima_factura=0;
        $_var_tiene_internet=false;
        $_var_tiene_tv=false;

        $servicios= array('television' =>"no",'combo' =>"no","puntos"=>"no","estado"=>"Inactivo","estado_combo"=>null,"estado_tv"=>null,"paquete"=>"","tipo_retencion"=>null);
        foreach ($lista_invoices as $key => $invoice) {
            if($invoice->combo!="no" && $invoice->combo!="" && $invoice->combo!="-" && $invoice->tipo_factura!="Fija"){
                if($invoice->estado_combo=="null" || $invoice->estado_combo==null){
                        $fact_valida=true;
                        $_var_tiene_internet=true;
                        $servicios['combo']=$invoice->combo;
                }else{
                      $servicios['estado_combo']=$invoice->estado_combo;  
                      $servicios['paquete']=$invoice->combo;
                }
                    
            }
            if($invoice->television!="no" && $invoice->television!="" && $invoice->television!="-" && $invoice->tipo_factura!="Fija"){
                if($invoice->estado_tv=="null" || $invoice->estado_tv==null){
                        $fact_valida=true;
                        $_var_tiene_tv=true;
                        $servicios['television']=$invoice->television;
					
                }else{
                        $servicios['estado_tv']=$invoice->estado_tv;  
                }
                $servicios['puntos']=$invoice->puntos;
                    
            }
            if($invoice->ron!="" && $invoice->ron!=null){
                        $fact_valida=true;
            }

            $afiliacion_traslado_omitir=$this->db->query('SELECT * FROM `invoice_items` where (product like "%afiliacion%" or product like "%traslado%") and tid="'.$invoice->tid.'"')->result_array();
            if(count($afiliacion_traslado_omitir)!=0){
                $fact_valida=false;
            }
            if($invoice->tipo_factura=="Fija" || $invoice->tipo_factura=="Nota Credito" || $invoice->tipo_factura=="Nota Debito"){
                $fact_valida=false;
            }
            
                if($fact_valida){
                    $servicios['tid']=$invoice->tid;
                    $servicios['subtotal']=$invoice->subtotal;
                    $servicios['total']=$invoice->total;
                    $servicios['items']=$invoice->items;
                    $servicios['tipo_retencion']=$invoice->tipo_retencion;
                    //var_dump($invoice->ron);
                    $servicios['estado']=$invoice->ron;
                    if($invoice->ron=="Suspendido"){
                        $servicios['television']="no";
                        $servicios['combo']="no";
                        $servicios['estado']="Suspendido";
                    }else if($servicios['television']!="no" ||$servicios['combo']!="no"){

                        if($servicios['television']!="no" && $invoice->television=="no"){
                            $servicios['television']="no";
                            $servicios['estado']="Television suspendida";
                        }
                        if($servicios['combo']!="no" && $invoice->combo=="no"){
                            $servicios['combo']="no";
                            $servicios['estado']="Internet suspendido";
                        }

                    }
                    break;
                }
            

        }
        //var_dump($servicios);
        return $servicios;
        
    }
public function calculo_ultimo_estado ($array_add,$customers){
 $sdate=new DateTime($_GET['sdate3']." 00:00:00");
 $edate=new DateTime($_GET['edate2']." 23:59:59");
    if(empty($customers->ultimo_estado)){
 $ul_estado="Activo";
                                $actual="";
                                $lista_ordenes=$this->db->select("*")->from("tickets")->where("cid=".$customers->id)->order_by("fecha_final,idt","desc")->get()->result();
                                $array_add['fecha_ultimo_estado']=null;
                                foreach ($lista_ordenes as $key2 => $value3 ) {
                                    if($value3->status=="Resuelto" ){
                                        if($customers->usu_estado=="Suspendido" ){


                                                       
                                                if(strpos($value3->detalle, "Suspension")!==false || !empty($array_add['fecha_ultimo_estado'])){
                                                     /*var_dump($value3->detalle);
                                                       var_dump($value3->cid);
                                                       var_dump($lista_ordenes[$key2+1]->detalle);*/
                                                    $varx=false;
                                                $actual="Suspendido";
                                                if(isset($lista_ordenes[$key2+1]->detalle)){
                                                    if((strpos($lista_ordenes[$key2+1]->detalle, "Reconexion")!==false || strpos($lista_ordenes[$key2+1]->detalle, "Corte")!==false) && $lista_ordenes[$key2+1]->status=="Resuelto"){
                                                        $ul_estado="Cortado";
                                                       
                                                       $varx=true;
                                                    }else if(strpos($lista_ordenes[$key2+1]->detalle, "Instalacion")!==false){
                                                        if($lista_ordenes[$key2+1]->status=="Resuelto"){
                                                            $ul_estado="Activo";
                                                        }else{
                                                            $ul_estado="Instalar";
                                                        }
                                                        $varx=true;
                                                    }                                                    
                                                   }//var_dump("fin");
                                                        if(empty($array_add['fecha_ultimo_estado'])){
                                                           if(!empty($value3->fecha_final)){
                                                                $array_add['fecha_ultimo_estado']=$value3->fecha_final;    
                                                            }else {
                                                                $array_add['fecha_ultimo_estado']=$value3->created;    
                                                            }
                                                        }
                                                    if($varx){
                                                           
                                                     break;
                                                    }
                                                }
                                        }else if($customers->usu_estado=="Cortado"){
                                                if(strpos($value3->detalle, "Corte")!==false || !empty($array_add['fecha_ultimo_estado'])){
                                                     /*var_dump($value3->detalle);
                                                       var_dump($value3->cid);
                                                       var_dump($lista_ordenes[$key2+1]->detalle);*/
                                                    $varx=false;
                                                $actual="Cortado";
                                                if(isset($lista_ordenes[$key2+1]->detalle)){
                                                    if(strpos($lista_ordenes[$key2+1]->detalle, "Suspension")!==false  && $lista_ordenes[$key2+1]->status=="Resuelto"){
                                                        $ul_estado="Suspendido";
                                                       
                                                       $varx=true;
                                                    }else if(strpos($lista_ordenes[$key2+1]->detalle, "Instalacion")!==false){
                                                        if($lista_ordenes[$key2+1]->status=="Resuelto"){
                                                            $ul_estado="Activo";
                                                        }else{
                                                            $ul_estado="Instalar";
                                                        }
                                                        $varx=true;
                                                    }                                                    
                                                   }//var_dump("fin");
                                                        if(empty($array_add['fecha_ultimo_estado'])){
                                                           if(!empty($value3->fecha_final)){
                                                                $array_add['fecha_ultimo_estado']=$value3->fecha_final;    
                                                            }else {
                                                                $array_add['fecha_ultimo_estado']=$value3->created;    
                                                            }
                                                        }
                                                    if($varx){
                                                           
                                                     break;
                                                    }
                                                }
                                        }else if($customers->usu_estado=="Instalar"){
                                                if(strpos($value3->detalle, "Corte")!==false || !empty($array_add['fecha_ultimo_estado'])){
                                                     /*var_dump($value3->detalle);
                                                       var_dump($value3->cid);
                                                       var_dump($lista_ordenes[$key2+1]->detalle);*/
                                                    $varx=false;
                                                $actual="Instalar";
                                                if(isset($lista_ordenes[$key2+1]->detalle)){
                                                    if((strpos($lista_ordenes[$key2+1]->detalle, "Reconexion")!==false || strpos($lista_ordenes[$key2+1]->detalle, "Corte")!==false) && $lista_ordenes[$key2+1]->status=="Resuelto"){
                                                        $ul_estado="Cortado";
                                                       
                                                       $varx=true;
                                                    }else if(strpos($lista_ordenes[$key2+1]->detalle, "Suspension")!==false  && $lista_ordenes[$key2+1]->status=="Resuelto"){
                                                        $ul_estado="Suspendido";
                                                       
                                                       $varx=true;
                                                    }else if(strpos($lista_ordenes[$key2+1]->detalle, "Instalacion")!==false){
                                                        if($lista_ordenes[$key2+1]->status=="Resuelto"){
                                                            $ul_estado="Activo";
                                                        }else{
                                                            $ul_estado="Instalar";
                                                        }
                                                        $varx=true;
                                                    }                                                    
                                                   }//var_dump("fin");
                                                        if(empty($array_add['fecha_ultimo_estado'])){
                                                           if(!empty($value3->fecha_final)){
                                                                $array_add['fecha_ultimo_estado']=$value3->fecha_final;    
                                                            }else {
                                                                $array_add['fecha_ultimo_estado']=$value3->created;    
                                                            }
                                                        }
                                                    if($varx){
                                                           
                                                     break;
                                                    }
                                                }
                                        }else if($customers->usu_estado=="Activo"){

                                                if(strpos($value3->detalle, "Instalacion")!==false || !empty($array_add['fecha_ultimo_estado'])){
                                                     /*var_dump($value3->detalle);
                                                       var_dump($value3->cid);
                                                       var_dump($lista_ordenes[$key2+1]->detalle);*/
                                                    $varx=false;
                                                $actual="Instalar";
                                                if(isset($lista_ordenes[$key2+1]->detalle)){
                                                    if((strpos($lista_ordenes[$key2+1]->detalle, "Reconexion")!==false || strpos($lista_ordenes[$key2+1]->detalle, "Corte")!==false) && $lista_ordenes[$key2+1]->status=="Resuelto"){
                                                        $ul_estado="Cortado";
                                                       
                                                       $varx=true;
                                                    }else if(strpos($lista_ordenes[$key2+1]->detalle, "Suspension")!==false  && $lista_ordenes[$key2+1]->status=="Resuelto"){
                                                        $ul_estado="Suspendido";
                                                       
                                                       $varx=true;
                                                    }else if(strpos($lista_ordenes[$key2+1]->detalle, "Instalacion")!==false){
                                                        if($lista_ordenes[$key2+1]->status=="Resuelto"){
                                                            $ul_estado="Activo";
                                                        }else{
                                                            $ul_estado="Instalar";
                                                        }
                                                        $varx=true;
                                                    }                                                    
                                                   }else{
                                                        $varx=true;
                                                        $ul_estado="Instalar";
                                                   }//var_dump("fin");
                                                        if(empty($array_add['fecha_ultimo_estado'])){
                                                           if(!empty($value3->fecha_final)){
                                                                $array_add['fecha_ultimo_estado']=$value3->fecha_final;    
                                                            }else {
                                                                $array_add['fecha_ultimo_estado']=$value3->created;    
                                                            }
                                                        }
                                                    if($varx){
                                                           
                                                     break;
                                                    }
                                                }
                                        }
                                    }
                                        
                                }
                                //var_dump($ul_estado);
                                if(!empty($array_add['fecha_ultimo_estado'])){
                                    //$array_add['fecha_ultimo_estado']=$lista_ordenes[0]->fecha_final;
                                    $array_add['ultimo_estado']=$ul_estado;
                                    $fecha_ultimo_estado= new DateTime($array_add['fecha_ultimo_estado']);
                                    if($_GET['sel_filtrar_fecha_cambio']=="Si"){
                                        if($sdate<=$fecha_ultimo_estado && $edate>=$fecha_ultimo_estado){
                                            $array_add['valido']=true;
                                        }else{
                                            $array_add['valido']=false;
                                        }
                                    }
                                }else{
                                    $array_add['fecha_ultimo_estado']="Sin Orden";
                                    $array_add['ultimo_estado']="Sin Orden";
                                    /*var_dump($lista_ordenes);
                                                       var_dump($value3->cid);
                                                       var_dump("fin");*/
                                     
                                    if($_GET['sel_filtrar_fecha_cambio']=="Si"){
                                        $array_add['valido']=false;
                                    }
                                }
                                return $array_add;
                            }else{
                                    $array_add['fecha_ultimo_estado']=$customers->fecha_cambio;
                                    $array_add['ultimo_estado']=$customers->ultimo_estado;
                                    $fecha_ultimo_estado= new DateTime($array_add['fecha_ultimo_estado']);
                                    if($_GET['sel_filtrar_fecha_cambio']=="Si"){
                                        if($sdate<=$fecha_ultimo_estado && $edate>=$fecha_ultimo_estado){
                                            $array_add['valido']=true;
                                        }else{
                                            $array_add['valido']=false;
                                        }
                                    }
                                    return $array_add;
                            }
}
    public function get_ip_coneccion_microtik_por_sede($datos){
        //$this->load->library("Aauth");
        //$id_sede=$this->aauth->get_user()->sede_accede;
        $id_sede=$datos['id_sede'];
        $resultado_mkts=$this->db->get_where("mikrotiks",array("sede"=>$id_sede))->result_array();
        $dat_return=null;
        $defecto=null;
        
        foreach ($resultado_mkts as $k => $mk) {
            if($dat_return==null && $mk['tegnologia']==$datos['tegnologia']){
                $dat_return=array("ip_mikrotik"=>$mk['ip'].":".$mk['puerto'],"usuario"=>$mk['usuario'],"password"=>$mk['password'],"var"=>$mk);
            }
            if($mk["defecto"]=="1"){
                $defecto=$k;
            }
        }
        if(empty($dat_return)){
            $mk=$resultado_mkts[$defecto];
            $dat_return=array("ip_mikrotik"=>$mk['ip'].":".$mk['puerto'],"usuario"=>$mk['usuario'],"password"=>$mk['password'],"var"=>$mk);
        }
        return $dat_return;
       /* if($id_sede==2){//yopal
            return $_SESSION['variables_MikroTik']->ip_Yopal;//190.14.233.186:8728
        }else if($id_sede==3){//Villanueva
            if($datos['tegnologia']=="GPON"){
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_GPON;
            }else if($datos['tegnologia']=="EPON"){
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_EPON;
            }else if($datos['tegnologia']=="EOC"){
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_EOC;
            }else{
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_GPON;//default
                //return $_SESSION['variables_MikroTik']->ip_Villanueva;//190.14.238.114:8728
            }
            
        }else if($id_sede==4){//Monterrey
            return $_SESSION['variables_MikroTik']->ip_Monterrey;//190.14.248.42:8728
        }else if($id_sede==6){//Monterrey
            return $_SESSION['variables_MikroTik']->ip_Aguazul;//190.14.248.42:8728
        }else if($id_sede==7){//Monterrey
            return $_SESSION['variables_MikroTik']->ip_tauramena;//190.14.248.42:8728
        }else if($id_sede==8){//villavo
            return $_SESSION['variables_MikroTik']->ip_villavo;//190.14.248.42:8728
        }else{//default
            return $_SESSION['variables_MikroTik']->ip_Yopal;//190.14.233.186:8728
        }*/
    }

    public function add($abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $fcontrato, $estrato, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $coor1, $coor2, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario,$tegnologia_instalacion)
    {
        if($tegnologia_instalacion==""){
            $tegnologia_instalacion=null;
        }
        $data = array(
			'abonado' => $abonado,
            'name' => $name,
			'dosnombre' => $dosnombre,
            'unoapellido' => $unoapellido,
			'dosapellido' => $dosapellido,
            'company' => $company,
            'celular' => $celular,
            'celular2' => $celular2,
            'email' => $email,
            'nacimiento' => $nacimiento,
            'tipo_cliente' => $tipo_cliente,
            'tipo_documento' => $tipo_documento,
            'documento' => $documento,
			'f_contrato' => $fcontrato,
			'estrato' => $estrato,
            'departamento' => $departamento,
            'ciudad' => $ciudad,
            'localidad' => $localidad,
            'barrio' => $barrio,
            'nomenclatura' => $nomenclatura,
            'numero1' => $numero1,
            'adicionauno' => $adicionauno,
            'numero2' => $numero2,
            'adicional2' => $adicional2,
			'numero3' => $numero3,
			'residencia' => $residencia,
			'referencia' => $referencia,
			'gid' => $customergroup,
			'name_s' => $name_s,
			'contra' => $contra,
			'servicio' => $servicio,
			'perfil' => $perfil,
			'Iplocal' => $Iplocal,
			'Ipremota' => $Ipremota,
			'comentario' => $comentario,
			'tegnologia_instalacion'=>$tegnologia_instalacion,
			'coor1'=> $coor1,
			'coor2'=> $coor2,
			
        );

        if($data['name_s']=="" || $data['name_s']==null){
            //si no agrega un username no agregue ip
            $data['Ipremota']="";            
        }

        if ($this->db->insert('customers', $data)) {
            $cid = $this->db->insert_id();
            $temp_password = rand(200000, 999999);
            $pass = password_hash($temp_password, PASSWORD_DEFAULT);
            $data = array(
                'user_id' => 1,
                'status' => 'active',
                'is_deleted' => 0,
                'name' => $name,
                'password' => $pass,
                'email' => $email,
                'user_type' => 'Member',
                'cid' => $cid
            );

            $this->db->insert('users', $data);
            if($name_s!=""){
                include (APPPATH."libraries/RouterosAPI.php");
                set_time_limit(3000);
                 $API = new RouterosAPI();
                $API->debug = false;
                //192.168.201.1:8728 ip jefe
                $datos_consulta_ip=array("id_sede"=>$customergroup,"tegnologia"=>$tegnologia_instalacion);
                $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
                if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
                        $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$barrio))->row();
                        if(isset($obj_barrio)){
                            
                            $barrio = $obj_barrio->barrio;    
                        }

                 $API->comm("/ppp/secret/add", array(
                      "name"     => str_replace(' ', '', $name_s),
                      "password" => $contra,
                      "remote-address" => $Ipremota,
                      "local-address" => $Iplocal,
                      "profile" => $perfil,
                      "comment"  => $barrio." ".$abonado,
                      "service"  => $servicio,
                   ));
        

                $API->disconnect();

                }else{
                    //echo "no conecto";
                }
        }
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . ' Temporary Password is ' . $temp_password . ' &nbsp;<a href="' . base_url('customers/view?id=' . $cid) . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>' . $this->lang->line('View') . '</a>', 'cid' => $cid, 'pass' => $temp_password));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
        

    }


    public function edit($id, $abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $fcontrato, $estrato, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $coor1, $coor2, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario,$tegnologia_instalacion)
    {
        if($tegnologia_instalacion==""){
            $tegnologia_instalacion=null;
        }
        $data = array(
			'abonado' => $abonado,
            'name' => $name,
			'dosnombre' => $dosnombre,
            'unoapellido' => $unoapellido,
			'dosapellido' => $dosapellido,
            'company' => $company,
            'celular' => $celular,
            'celular2' => $celular2,
            'email' => $email,
            'nacimiento' => $nacimiento,
            'tipo_cliente' => $tipo_cliente,
            'tipo_documento' => $tipo_documento,
            'documento' => $documento,
			'f_contrato' => $fcontrato,
			'estrato'	=> $estrato,
            'departamento' => $departamento,
            'ciudad' => $ciudad,
            'localidad' => $localidad,
            'barrio' => $barrio,
            'nomenclatura' => $nomenclatura,
            'numero1' => $numero1,
            'adicionauno' => $adicionauno,
            'numero2' => $numero2,
            'adicional2' => $adicional2,
			'numero3' => $numero3,
			'residencia' => $residencia,
			'referencia' => $referencia,
			'gid' => $customergroup,
			'name_s' => $name_s,
			'contra' => $contra,
			'servicio' => $servicio,
			'perfil' => $perfil,
			'Iplocal' => $Iplocal,
			'Ipremota' => $Ipremota,
			'comentario' => $comentario,
            'tegnologia_instalacion'=>$tegnologia_instalacion,
            'coor1'=>$coor1,
            'coor2'=>$coor2,
        );

        if($data['name_s']=="" || $data['name_s']==null){
            //si no agrega un username no agregue ip
            $data['Ipremota']="";            
        }

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('customers')) {
            $data_h['modulo']="Customers";
                $data_h['accion']="Editando customer";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=json_encode($data);
                $data_h['id_fila']=$id;
                $data_h['tabla']="customers";
                $data_h['nombre_columna']="id";
                $this->db->insert("historial_crm",$data_h);
            $data = array(
                'name' => $name,
                'email' => $email
            );
            $this->db->set($data);
            $this->db->where('cid', $id);
            $this->db->update('users');
            if($name_s!=""){
                include (APPPATH."libraries/RouterosAPI.php");
                set_time_limit(3000);
                $API = new RouterosAPI();
                $API->debug = false;
                $datos_consulta_ip=array("id_sede"=>$customergroup,"tegnologia"=>$tegnologia_instalacion);
                $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
                if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {

                    $arrID=$API->comm("/ppp/secret/getall", 
                          array(
                          ".proplist"=> ".id",
                          "?name" => $name_s,
                          ));
                    if($arrID[0][".id"]!=null){
                        $API->comm("/ppp/secret/set",
                          array(
                               ".id" => $arrID[0][".id"],
                               "name"     => str_replace(' ', '', $name_s),
                               "password" => $contra,
                               "remote-address" => $Ipremota,
                               "local-address" => $Iplocal,
                               "profile" => $perfil,
                               "comment"  => $comentario,
                               "service"  => $servicio,
                               //"disabled"  => "no",
                               )
                          );  
                    }else{
                        $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$barrio))->row();
                        if(isset($obj_barrio)){
                            
                            $barrio = $obj_barrio->barrio;    
                        }
                        $API->comm("/ppp/secret/add", array(
                          "name"     => str_replace(' ', '', $name_s),
                          "password" => $contra,
                          "remote-address" => $Ipremota,
                          "local-address" => $Iplocal,
                          "profile" => $perfil,
                          "comment"  => $barrio." ".$abonado." ".$comentario,
                          "service"  => $servicio,
                          "disabled"  => "no",
                        ));
                        
                    }
                    $API->disconnect();

                }else{
                   
                }
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
    public function edit_profile_mikrotik($id_sede,$name_s,$profile,$tegnologia_instalacion){
        include (APPPATH."libraries/RouterosAPI.php");
                set_time_limit(3000);
                $API = new RouterosAPI();
                $API->debug = false;
                $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
                $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
                if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
                $arrID=$API->comm("/ppp/secret/getall", 
                          array(
                          ".proplist"=> ".id",
                          "?name" => $name_s,
                          ));
                    if($arrID[0][".id"]!=null){
                        $API->comm("/ppp/secret/set",
                          array(
                               ".id" => $arrID[0][".id"],
                               //"name"     => str_replace(' ', '', $name_s),
                               //"password" => $contra,
                               //"remote-address" => $Ipremota,
                               //"local-address" => $Iplocal,
                               "profile" => $profile,
                               //"comment"  => $barrio." ".$abonado,
                               //"service"  => $servicio,
                               "disabled"  => "no",
                               )
                          );  
                    }
            }

    }
    public function obtener_comentario_mikrotik($username,$customergroup,$tegnologia_instalacion){
        include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
        $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$customergroup,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
                if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $username,
                  ));
         $API->disconnect();

         return $arrID[0]['comment'];

        }else{
            
        }
        return "No se pudo conectar a la mikrotik";
    }
    public function changepassword($id, $password)
    {
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $data = array(
            'password' => $pass

        );
        $customer1 = $this->db->get_where("customers",array("id"=>$id))->row();
        $data['name']=$customer1->name." ".$customer1->dosnombre." ".$customer1->unoapellido." ".$customer1->dosapellido;
        $data['email']=$customer1->email;
        $data['cid']=$id;
        $data['userid']=$this->aauth->get_user()->id;
        $this->load->model('notas_model', 'notas');
        $cuerpo='"cid": '.$id.',"name":"'.$data['name'].'","email":"'.$data['email'].'","ps":"'.$pass.'","userid":"'.$data['userid'].'",';
        $respuesta=$this->notas->update_7878($cuerpo,"update_user");
        
        

        if ($respuesta=="1") {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from($this->table);
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('customers') AND $result['picture']!='example.png') {

            unlink(FCPATH . 'userfiles/customers/' . $result['picture']);
            unlink(FCPATH . 'userfiles/customers/thumbnail/' . $result['picture']);
        }


    }

    public function group_sedes()
    {
		$sede = $this->aauth->get_user()->sede_accede;
        $sede =str_replace("-", "",$sede);
        $str_condition="";
        if($this->aauth->get_user()->roleid<5){
            $str_condition="WHERE c.id IN(".$sede.")";    
        }
        
        $query = $this->db->query("SELECT c.*,p.pc FROM customers_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM customers GROUP BY gid) AS p ON p.gid=c.id ".$str_condition);
        return $query->result_array();
    }
	public function group_list()
    {
		$sede = $this->aauth->get_user()->sede_accede;
        $sede =str_replace("-", "",$sede);
        $query = $this->db->query("SELECT c.*,p.pc FROM customers_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM customers GROUP BY gid) AS p ON p.gid=c.id");
        return $query->result_array();
    }
	
	
	public function departamentos_list()
    {
        $query = $this->db->query("SELECT idDepartamento,departamento FROM departamentos ");
        return $query->result_array();
		
    }
	public function group_departamentos($id)
    {

        $this->db->from('departamentos');
        $this->db->where('idDepartamento', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function ciudades_list($id)
    { 
		$this->db->select('*');
        $this->db->from('ciudad');
        $this->db->where('idDepartamento', $id);
        $query = $this->db->get();
        return $query->result_array(); 
    }
	public function group_ciudad($id)
    {

        $this->db->from('ciudad');
        $this->db->where('idCiudad', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function localidades_list($id)
    { 
		$this->db->select('*');
        $this->db->from('localidad');
        $this->db->where('idCiudad', $id);
        $query = $this->db->get();
        return $query->result(); 
    }
	public function group_localidad($id)
    {

        $this->db->from('localidad');
        $this->db->where('idLocalidad', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function barrios_list($id)
    { 
		$this->db->select('*');
        $this->db->from('barrio');
        $this->db->where('idLocalidad', $id);
        $query = $this->db->get();
        return $query->result_array(); 
    }
	public function group_barrio($id)
    {

        $this->db->from('barrio');
        $this->db->where('idBarrio', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete($id)
    {
        $this->db->delete('users', array('cid' => $id));
        return $this->db->delete('customers', array('id' => $id));
    }
	public function deleteobs($id)
    {
        $this->db->delete('historiales', array('idn' => $id));
        return true;    
    }


    //transtables

    function trans_table($id)
    {
        $this->_get_trans_table_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	function supor_table($id)
    {
        $this->_sup_datatables_query($id);
        $this->db->order_by("codigo","DESC");
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	


    private function _get_trans_table_query($id)
    {

        $this->db->from('transactions');


        $this->db->where('payerid', $id);
        $this->db->where('ext', '0');

        $i = 0;

        foreach ($this->trans_column_search as $item) // loop column
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

                if (count($this->trans_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->trans_column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function trans_count_filtered($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }
        return $query->num_rows($id = '');
    }
	function sup_count_filtered($id = '')
    {
        $this->_sup_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('cid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function trans_count_all($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }


    }
	public function supor_count_all($id = '')
    {
        $this->_sup_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('cid', $id);
        }


    }

    private function _inv_datatables_query($id)
    {

        $this->db->from('invoices');
        $this->db->where('invoices.csd', $id);
        if(isset($_GET['filtrar'])){
            $this->db->where('invoices.status', 'due');    
        }
        
        $this->db->join('customers', 'invoices.csd=customers.id', 'left');

        $i = 0;

        foreach ($this->inv_column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->inv_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->inv_order)) {
            $order = $this->inv_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	private function _sup_datatables_query($id)
    {

        $this->db->from('tickets');
        $this->db->where('tickets.cid', $id);
        if(isset($_POST['tipo']) && $_POST['tipo']=="pendientes"){
            $this->db->where("status",'Pendiente');
        }
        $this->db->join('customers', 'tickets.cid=customers.id', 'left');

        $i = 0;

        foreach ($this->sup_column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->sup_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->sup_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->sup_order)) {
            $order = $this->sup_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	//busqueda equipo
	private function _equi_datatables_query($id)
    {

        $this->db->from('equipos');
        $this->db->where('equipos.asignado', $id);
        $this->db->join('customers', 'equipos.asignado=customers.id', 'left');
		$this->db->join('naps', 'naps.idn = equipos.nat','left');
		$this->db->join('vlans', 'vlans.idv = naps.idvlan','left');
		$this->db->join('puertos', 'puertos.asignado = equipos.asignado','left');

        $i = 0;

        foreach ($this->equi_column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->equi_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->equi_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->equi_order)) {
            $order = $this->equi_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	function equipo_table($id)
    {
        $this->_equi_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	public function equi_count_all($id = '')
    {
        $this->_equi_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('abonado', $id);
        }


    }
	function equi_count_filtered($id = '')
    {
        $this->_equi_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('abonado', $id);
        }
        return $query->num_rows($id = '');
    }

    function inv_datatables($id)
    {
        $this->_inv_datatables_query($id);
        
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function inv_count_filtered($id)
    {
        $this->_inv_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function inv_count_all($id)
    {
        $this->db->from('invoices');
        $this->db->where('csd', $id);
        return $this->db->count_all_results();
    }

    public function group_info($id)
    {

        $this->db->from('customers_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function activity($id)
    {
        $this->db->select('*');
        $this->db->from('historiales');
        //$this->db->where('type', 21);
        $this->db->where('id_user', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recharge($id, $amount)
    {

        $this->db->set('balance', "balance+$amount", FALSE);
        $this->db->where('id', $id);

        $this->db->update('customers');

        $data = array(
            'type' => 21,
            'rid' => $id,
            'col1' => $amount,
            'col2' => date('Y-m-d H:i:s').' Account Recharge by '.$this->aauth->get_user()->username
        );


        if ($this->db->insert('meta_data', $data)) {
            return true;
        } else {
            return false;
        }

    }
public function get_datos_trafico($user_name,$id_sede,$tegnologia_instalacion){
    include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
            $rows = array(); $rows2 = array();  $rows3 = array();  
        $API->debug = false;
        $interface = "<pppoe-".$user_name.">"; 
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
$datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
                if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
           /* //$user_name="user_prueba_duber_disabled";
           /* $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
                  $arrID=$API->comm("/tool/graphing/interface/print");*/
                  /*$API->write("/interface/monitor-traffic",false);
           $API->write("=interface=".$interface,false);  
           $API->write("=once=",true);
           $READ = $API->read(false);*/
          //$arrID=$API->comm("/interface/monitor-traffic",array("?interface"=>"pppoe-ANDERSONGIOVANNIWILCHESLAVERDEasdasd"));
           $API->write("/interface/monitor-traffic",false);
           $API->write("=interface=".$interface,false);
            $API->write("=once=",true);
            $READ = $API->read(false);
             //$READ=$API->comm("/interface/pppoe-server/getall",array("?name"=>"<pppoe-ALBALUCEROARISTIZABALRIVERA>"));
            $ARRAY = $API->parse_response($READ);
            
                $rx = number_format($ARRAY[0]["rx-bits-per-second"]/1024,1);
                $tx = number_format($ARRAY[0]["tx-bits-per-second"]/1024,1);
                $rows['name'] = 'Tx';
                $rows['data'][] = $tx;
                $rows2['name'] = 'Rx';
                $rows2['data'][] = $rx;
                //$rows3=$ARRAY[0];
         $API->disconnect();

       /* foreach ($arrID as $key => $value) {
            var_dump($value);
        }*/
        $result = array();
    array_push($result,$rows);
    array_push($result,$rows2);
    //array_push($result,$rows3);
    print json_encode($result, JSON_NUMERIC_CHECK);

        }else{
            
        }
}
public function get_datos_trafico2($user_name,$id_sede,$tegnologia_instalacion){
    include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
            $rows = array(); $rows2 = array();  $rows3 = array();  
        $API->debug = false;
        $interface = "<pppoe-".$user_name.">"; 
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
       var_dump( $this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip));
        /*if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
           
             $READ=$API->comm("/queue/simple/print",array("?name"=>$interface));
            
            var_dump();    
        $datos=explode("/", $READ[0]['bytes']);
        $descarga=0;
        $subida=0;
        $descarga=intval((intval($datos[1])/1024)/1024);
        $subida=intval((intval($datos[0])/1024)/1024);
        ob_clean();
        var_dump("Descarga ".$descarga." MG");
        echo "<br>";
        var_dump("Carga ".$subida." MG");
                 $API->disconnect();

       /* foreach ($arrID as $key => $value) {
            var_dump($value);
        }
       
        }else{
            
        }*/
}
public function get_gasto_datos($user_name,$id_sede,$tegnologia_instalacion){
    include (APPPATH."libraries/RouterosAPI.php");
    $datos=array("descarga"=>"","subida"=>"");
        set_time_limit(3000);
         $API = new RouterosAPI();
            $rows = array(); $rows2 = array();  $rows3 = array();  
        $API->debug = false;
        $interface = "<pppoe-".$user_name.">"; 
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
        if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
           //$READ=$API->comm("/queue/simple/print");
             $READ=$API->comm("/queue/simple/print",array("?name"=>$interface));
            
            
            //var_dump($READ)  ;
        $datos2=explode("/", $READ[0]['bytes']);
        $descarga=0;
        $subida=0;
        $descarga=intval((intval($datos2[1])/1024)/1024);
        $subida=intval((intval($datos2[0])/1024)/1024);
        if($descarga>1024){
            $descarga=$descarga/1024;
            $datos['descarga']="Descarga ".$descarga." Gb";
        }else{
            $datos['descarga']="Descarga ".$descarga." Mb";
        }
        
        $datos['subida']="Carga ".$subida." Mb";
                 $API->disconnect();

       /* foreach ($arrID as $key => $value) {
            var_dump($value);
        }*/
       
        }else{
            
        }
        return $datos;
}
    public function get_estado_mikrotik($user_name,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
        if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
         $API->disconnect();

         return $arrID[0]['disabled'];

        }else{
            
        }
    }
    public function get_estado_mikrotik2($id_sede,$tegnologia_instalacion,$API){
        
        set_time_limit(3000);
        
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
        if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall");
         $API->disconnect();
         
            return $arrID[0]['disabled'];    
         
         

        }else{
            
        }
    }
     public function validar_user_name($user_name,$id_sede,$tegnologia_instalacion){
        //include (APPPATH."libraries/RouterosAPI.php");
            //$user_name="10.20.2.189";
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
        if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
         $API->disconnect();

        return $arrID[0]['.id'];

        }else{
            
        }
    }
     public function validar_ip($ip_remote,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries/RouterosAPI.php");
        //$user_name="10.20.2.189";
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
        if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?remote-address" => $ip_remote,
                  ));
         $API->disconnect();

        //return $arrID[0]['.id'];


 // ips yopal
        $ciclo=true;
        $ip=ip2long($ip_remote);//+intval($customers_yopal[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            //$comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2"))->row();
            //$comprovar=$this->db->query("select * from customers where gid='2' and Ipremota='".long2ip($nmask)."' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
            if(count($comprovar)==0){
                //no existe
                $ips_remotas['yopal']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips yopal
        }else{
            
        }
    }
     public function editar_estado_usuario($user_name,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
        if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            
            if($arrID[0]['disabled']=='false'){
               $secret_id=$arrID[0][".id"];
               $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => $user_name,
                  ));
                $API->comm("/ppp/active/remove",
                    array(
                        ".id" => $arrID[0][".id"],
                        )
                    );

                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $secret_id,
                       "disabled"  => "yes",
                       )
                  );  
                //var_dump($secret_id);
                //var_dump($arrID[0][".id"]);
                
            }else{
                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $arrID[0][".id"],
                       "disabled"  => "no",
                       )
                  );    
            }
            

         $API->disconnect();
         

        }else{
            
        }
    }

    public function activar_estado_usuario($user_name,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
        if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            //activate
            $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $arrID[0][".id"],
                       "disabled"  => "no",
                       )
                  );              
         $API->disconnect();
         

        }else{
            
        }
    }

    public function desactivar_estado_usuario($user_name,$id_sede,$tegnologia_instalacion){
          include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        $datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
                if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            
            //desactivate
               $secret_id=$arrID[0][".id"];
               $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => $user_name,
                  ));
                $API->comm("/ppp/active/remove",
                    array(
                        ".id" => $arrID[0][".id"],
                        )
                    );

                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $secret_id,
                       "disabled"  => "yes",
                       )
                  );  
                //var_dump($secret_id);
                //var_dump($arrID[0][".id"]);                            

         $API->disconnect();
         

        }else{
            
        }
    }

    public function desactivar_estado_usuario_multiple($user_name,$id_sede,$API,$tegnologia_instalacion){
          //include (APPPATH."libraries/RouterosAPI.php");
        set_time_limit(3000);
         //$API = new RouterosAPI();
        //$API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
$datos_mkt=$this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip);
                if ($API->connect($datos_mkt['ip_mikrotik'], $datos_mkt['usuario'], $datos_mkt['password'])) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            
            //desactivate
               $secret_id=$arrID[0][".id"];
               $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => $user_name,
                  ));
                $API->comm("/ppp/active/remove",
                    array(
                        ".id" => $arrID[0][".id"],
                        )
                    );

                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $secret_id,
                       "disabled"  => "yes",
                       )
                  );  
                //var_dump($secret_id);
                //var_dump($arrID[0][".id"]);                            

         $API->disconnect();
         

        }else{
            
        }
    }

    public function dev_ips_dinamic(){
        $ips_remotas = array();    
        $lista_x=$this->db->query("select ipk.id as id,ipk.ip_local as ip_local,ipk.ip_remota as ip_remota,ipk.tegnologia as tegnologia,ipk.sede as sede, cs.title as title, ipk.perfiles as perfil  from ips_users_mk as ipk inner join customers_group as cs on cs.id=ipk.sede order by ipk.sede")->result();

        foreach ($lista_x as $k => $vl) {
            
            $nombre_row="ips_".$vl->sede;
            $aditional_condition="";
            
            if($vl->tegnologia!=""){
                    $nombre_row.="_".$vl->tegnologia;
                    $aditional_condition.=" and tegnologia_instalacion='".$vl->tegnologia."'";
            }else{
                $validacion=$this->db->query("select * from ips_users_mk where tegnologia!='' and sede=".$vl->sede)->result();
                if(count($validacion)>0){
                    //para saber como hacer el 2do select;
                    $aditional_condition=" and ((";
                    
                    foreach ($validacion as $k2 => $vl2) {
                        if($k2==0){
                            $aditional_condition.=" tegnologia_instalacion!='".$vl2->tegnologia."' ";
                            
                        }else if($k2 <(count($validacion)-1) ){
                            $aditional_condition.=" and ";
                            
                        }
                    }
                    $aditional_condition.=") or tegnologia_instalacion is null) ";
                    
                }                
            }
            $vl->perfil="Seleccione...,".$vl->perfil;
            $vl->perfil=explode(",", $vl->perfil);
            $ips_remotas[$nombre_row]=$vl;
            $str_query="select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='".$vl->sede."' and Ipremota is not null and Ipremota!='' and Ipremota!='0' ".$aditional_condition;
            $customers_x=$this->db->query($str_query)->result_array();
           // var_dump($aditional_condition);echo $nombre_row." aa<br>";
        // ips yopal
        $ciclo=true;
        $ip=ip2long($customers_x[0]['c_usuarios'])+1;//+intval($customers_yopal[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            //$comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2"))->row();
            $comprovar=$this->db->query("select * from customers where gid='".$vl->sede."' and Ipremota='".long2ip($nmask)."' ".$aditional_condition)->result_array();
            if(count($comprovar)==0){
                //no existe
                $ips_remotas[$nombre_row]->ip_remota=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        } 

        }
        //todas las sedes estan bien excepto villavicencio revisar
        return $ips_remotas;
    }
    public function devolver_ips_proximas(){
        $ips_remotas = array('yopal' =>'10.0.0.2', 'yopal_gpon' =>'10.100.0.2', 'aguazul' =>'10.100.0.2', 'tauramena'=>'10.100.0.2','villavo'=>'10.0.0.2',"monterrey"=>'10.1.100.2','villanueva'=>"80.0.0.2",'villanueva_gpon'=>"10.20.0.2" );    
        /*$customers_yopal=$this->db->query("select count(*) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
        $customers_yopal_gpon=$this->db->query("select count(*) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0' and tegnologia_instalacion='GPON'")->result_array();
        $customers_monterrey=$this->db->query("select count(*) as c_usuarios from customers where gid='4' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
        $customers_villanueva=$this->db->query("select count(*) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
        $customers_villanueva_gpon=$this->db->query("select count(*) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and tegnologia_instalacion='GPON'")->result_array();
*/
        $customers_yopal=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
        $customers_yopal_gpon=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0' and tegnologia_instalacion='GPON'")->result_array();
        $customers_monterrey=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='4' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
		$customers_aguazul=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='6' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
		$customers_tauramena=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='7' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
		$customers_villavo=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='8' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
        $customers_villanueva=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
        $customers_villanueva_gpon=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and tegnologia_instalacion='GPON'")->result_array();
        //var_dump($customers_villavo);echo " ee<br>";
        // ips yopal
        $ciclo=true;
        $ip=ip2long($customers_yopal[0]['c_usuarios'])+1;//+intval($customers_yopal[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            //$comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2"))->row();
            $comprovar=$this->db->query("select * from customers where gid='2' and Ipremota='".long2ip($nmask)."' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
            if(count($comprovar)==0){
                //no existe
                $ips_remotas['yopal']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips yopal

        // ips yopal gpon
        $ciclo=true;
        $ip=ip2long($customers_yopal_gpon[0]['c_usuarios'])+1;//+intval($customers_yopal[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            //$comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2"))->row();
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2","tegnologia_instalacion"=>"GPON"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['yopal_gpon']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips yopal gpon
        // ips monterrey
        $ciclo=true;
        $ip=ip2long($customers_monterrey[0]['c_usuarios'])+1;//+intval($customers_monterrey[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"4"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['monterrey']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips monterrey
		// ips aguazul
        $ciclo=true;
        $ip=ip2long($customers_aguazul[0]['c_usuarios'])+1;//+intval($customers_monterrey[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"6"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['aguazul']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips monterrey
		// ips tauramena
        $ciclo=true;
        $ip=ip2long($customers_tauramena[0]['c_usuarios'])+1;//+intval($customers_monterrey[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"7"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['tauramena']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips tauramena
		// ips villavo
        $ciclo=true;
        $ip=ip2long($customers_villavo[0]['c_usuarios'])+1;//+intval($customers_monterrey[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"8"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['villavo']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips villavo

        // ips villanueva
        $ciclo=true;
        $ip=ip2long($customers_villanueva[0]['c_usuarios'])+1;//+intval($customers_villanueva[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->query("select * from customers where gid='3' and Ipremota='".long2ip($nmask)."' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
            if(count($comprovar)==0){
                //no existe
                $ips_remotas['villanueva']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips villanueva
         // ips customers_villanueva_gpon
        $ciclo=true;
        $ip=ip2long($customers_villanueva_gpon[0]['c_usuarios'])+1;//+intval($customers_villanueva_gpon[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"3","tegnologia_instalacion"=>"GPON"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['villanueva_gpon']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips customers_villanueva_gpon
return $ips_remotas;

        /* $bcast = ip2long("10.20.2.0"); //codigo de ejemplo de como sumar ips basico
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            var_dump( long2ip($nmask)); // Will give 192.168.178.0*/
    }
    public function getClientData(){
        $data_json_string='{
    "Header": {
        "Id": 0,
        "DocCode": 12434,
        "EmailToSend": null,
        "DocDate": "20210427",
        "MoneyCode": "COP",
        "ExchangeValue": 0,
        "DiscountValue": 0,
        "VATTotalValue": 3992,
        "ConsumptionTaxTotalValue": 0,
        "TaxDiscTotalValue": 0,
        "RetVATTotalID": -1,
        "RetVATTotalPercentage": -1,
        "RetVATTotalValue": 0,
        "RetICATotalID": -1,
        "RetICATotalValue": 0,
        "RetICATotaPercentage": -1,
        "TotalValue": 25000,
        "TotalBase": 21008,
        "SalesmanIdentification": "963852741",
        "Observations": "Registro automático API",
        "Account": {
            "IsSocialReason": true,
            "FullName": "JANNINI MAZIEL ESTUPIÑAN ALFONSO",
            "FirstName": "JANNINI",
            "LastName": "ESTUPIÑAN",
            "IdTypeCode": "13",
            "Identification": "1118197537",
            "CheckDigit": 0,
            "BranchOffice": 0,
            "IsVATCompanyType": false,
            "City": {
                "CountryCode": "Co",
                "StateCode": "85",
                "CityCode": "85001"
            },
            "Address": "Dirección Tercero prueba",
            "Comments": "",
            "Phone": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            }
        },
        "Contact": {
            "Code": 1,
            "Phone1": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "Mobile": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "EMail": "vestelsas@gmail.com",
            "FirstName": "Contacto",
            "LastName": "JOAO",
            "IsPrincipal": true,
            "Gender": 1,
            "BirthDate": ""
        },
        "CostCenterCode": "Y01",
        "SubCostCenterCode": "1"
    },
    "Items": [
        {
            "ProductCode": "001",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        }
    ],
    "Payments": [
        {
            "PaymentMeansCode": 2863,
            "Value": 25000,
            "DueDate": "20210427",
            "DueQuote": 0
        }
    ]
}';
return $data_json_string;
    }

public function getClientData2Productos(){
        $data_json_string='{
    "Header": {
        "Id": 0,
        "DocCode": 12434,
        
        "EmailToSend": null,
        "DocDate": "20210427",
        "MoneyCode": "COP",
        "ExchangeValue": 0,
        "DiscountValue": 0,
        "VATTotalValue": 3992,
        "ConsumptionTaxTotalValue": 0,
        "TaxDiscTotalValue": 0,
        "RetVATTotalID": -1,
        "RetVATTotalPercentage": -1,
        "RetVATTotalValue": 0,
        "RetICATotalID": -1,
        "RetICATotalValue": 0,
        "RetICATotaPercentage": -1,
        "TotalValue": 25000,
        "TotalBase": 21008,
        "SalesmanIdentification": "963852741",
        "Observations": "Registro automático API",
        "Account": {
            "IsSocialReason": true,
            "FullName": "JANNINI MAZIEL ESTUPIÑAN ALFONSO",
            "FirstName": "JANNINI",
            "LastName": "ESTUPIÑAN",
            "IdTypeCode": "13",
            "Identification": "1118197537",
            "CheckDigit": 0,
            "BranchOffice": 0,
            "IsVATCompanyType": false,
            "City": {
                "CountryCode": "Co",
                "StateCode": "85",
                "CityCode": "85001"
            },
            "Address": "Dirección Tercero prueba",
            "Comments": "",
            "Phone": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            }
        },
        "Contact": {
            "Code": 1,
            "Phone1": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "Mobile": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "EMail": "vestelsas@gmail.com",
            "FirstName": "Contacto",
            "LastName": "JOAO",
            "IsPrincipal": true,
            "Gender": 1,
            "BirthDate": ""
        },
        "CostCenterCode": "Y01",
        "SubCostCenterCode": "1"
    },
    "Items": [
        {
            "ProductCode": "001",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        },{
            "ProductCode": "l01",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        }
    ],
    "Payments": [
        {
            "PaymentMeansCode": 2863,
            "Value": 25000,
            "DueDate": "20210427",
            "DueQuote": 0
        }
    ]
}';
return $data_json_string;
    }

public function getClientData3Productos(){
        $data_json_string='{
    "Header": {
        "Id": 0,
        "DocCode": 12434,
        
        "EmailToSend": null,
        "DocDate": "20210427",
        "MoneyCode": "COP",
        "ExchangeValue": 0,
        "DiscountValue": 0,
        "VATTotalValue": 3992,
        "ConsumptionTaxTotalValue": 0,
        "TaxDiscTotalValue": 0,
        "RetVATTotalID": -1,
        "RetVATTotalPercentage": -1,
        "RetVATTotalValue": 0,
        "RetICATotalID": -1,
        "RetICATotalValue": 0,
        "RetICATotaPercentage": -1,
        "TotalValue": 25000,
        "TotalBase": 21008,
        "SalesmanIdentification": "963852741",
        "Observations": "Registro automático API",
        "Account": {
            "IsSocialReason": true,
            "FullName": "JANNINI MAZIEL ESTUPIÑAN ALFONSO",
            "FirstName": "JANNINI",
            "LastName": "ESTUPIÑAN",
            "IdTypeCode": "13",
            "Identification": "1118197537",
            "CheckDigit": 0,
            "BranchOffice": 0,
            "IsVATCompanyType": false,
            "City": {
                "CountryCode": "Co",
                "StateCode": "85",
                "CityCode": "85001"
            },
            "Address": "Dirección Tercero prueba",
            "Comments": "",
            "Phone": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            }
        },
        "Contact": {
            "Code": 1,
            "Phone1": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "Mobile": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "EMail": "vestelsas@gmail.com",
            "FirstName": "Contacto",
            "LastName": "JOAO",
            "IsPrincipal": true,
            "Gender": 1,
            "BirthDate": ""
        },
        "CostCenterCode": "Y01",
        "SubCostCenterCode": "1"
    },
    "Items": [
        {
            "ProductCode": "001",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        },{
            "ProductCode": "l01",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        },
        {
            "ProductCode": "l01",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        }
    ],
    "Payments": [
        {
            "PaymentMeansCode": 2863,
            "Value": 25000,
            "DueDate": "20210427",
            "DueQuote": 0
        }
    ]
}';
return $data_json_string;
    }

public function getCustomerJson(){
        $str='{
  "type": "Customer",
  "person_type": "Person",
  "id_type": "13",
  "identification": "13832081",
  "check_digit": "4",
  "name": [
    "Marcos",
    "Castillo"
  ],
  "commercial_name": "Siigo",
  "branch_office": 0,
  "active": true,
  "vat_responsible": false,
  "fiscal_responsibilities": [
    {
      "code": "R-99-PN"
    }
  ],
  "address": {
    "address": "Cra. 18 #79A - 42",
    "city": {
      "country_code": "Co",
      "state_code": "85",
      "city_code": "85001"
    },
    "postal_code": "00000"
  },
  "phones": [
    {
      "indicative": "57",
      "number": "3006003345",
      "extension": "000"
    }
  ],
  "contacts": [
    {
      "first_name": "Marcos",
      "last_name": "Castillo",
      "email": "marcos.castillo@contacto.com",
      "phone": {
        "indicative": "57",
        "number": "3006003345",
        "extension": "000"
      }
    }
  ],
  "comments": "Comentarios",
  "related_users": {
    "seller_id": 321,
    "collector_id": 321
  }
}';
return $str;
    }

    public function getFacturaElectronica($n_productos=null){
        
    $otro_producto=',{
              "code": "001",
              "description": "DESCRIPCION",
              "quantity": 1,
              "price": 21008,
              "discount": 0.0              
            }';
            if($n_productos==null){
                $otro_producto="";
            }

        $str='{
  "document": {
    "id": 12434
  },
  "date": "2021-12-31",
  "customer": {
    "identification": "13832081",
    "branch_office": 0
  },
  "cost_center": 1074,
  "seller": 1011,
  "observations": "Observaciones",
  "items": [
    {
      "code": "001",
      "description": "DESCRIPCION",
      "quantity": 1,
      "price": 21008.4,
      "discount": 0.0,
      "taxes": [
        {"id": 6688,
         "name": "IVA 19%",
         "type": "IVA",
         "percentage": 19,
         "value": 3991.6
        }
      ]
    }'.$otro_producto.'
  ],
  "payments": [
    {
      "id": 2863,
      "value": 25000,
      "due_date": "2021-12-31"
    }
  ],
  "additional_fields": {}
  
}';
return $str;
    }

    public function getFacturaElectronicaOttis($n_productos=null,$t_retencion=null){
        
    $row_retencion="";
    $rete_iva="";
    if($t_retencion!=null){
        
        if($t_retencion=="Retefuente Servicios"){
            $row_retencion=',
                 {
                    "id": 16984,
                    "name": "RETEFUENTE Servicios declarante",
                    "type": "Retefuente",
                    "percentage": 4.0,
                    "value": 4800.0
                }';
        }else if($t_retencion=="Compras"){
            $row_retencion=',
                  {
                    "id": 16991,
                    "name": "RETEFUENTE Compras declarante",
                    "type": "Retefuente",
                    "percentage": 2.5,
                    "value": 3000.0
                }';
        }else if($t_retencion=="Personas no declarantes"){
            $row_retencion=',
                 {
                    "id": 16992,
                    "name": "RETEFUENTE Compras no declarantes",
                    "type": "Retefuente",
                    "percentage": 3.5,
                    "value": 4200.0
                }';
        }else{
            $rete_iva='"retentions": [
                {
                    "id": 17085,
                    "name": "RETEIVA 15% del IVA",
                    "type": "ReteIVA",
                    "percentage": 15.0,
                    "value": 3420.0
                }
            ],';
        }
        
    }    

    $otro_producto=',{
              "code": "12SOPIVA1",
              "description": "DESCRIPCION",
              "quantity": 1,
              "price": 21008,
              "discount": 0.0,
              "taxes": [
                {"id": 4189,
                 "name": "IVA 19% sev",
                 "type": "IVA",
                 "percentage": 19,
                 "value": 3991.6
                }
              ]            
            }';
            $total_prods="";
            for ($i=1; $i <=$n_productos ; $i++) { 
                $total_prods.=$otro_producto;
            }
            if($n_productos==null){
                $otro_producto="";
            }else{
                $otro_producto=$total_prods;
            }

        $str='{
  "document": {
    "id": 27183
  },
  "date": "2021-12-31",
  "customer": {
    "identification": "13832081",
    "branch_office": 0
  },
  "cost_center": 341,
  "seller": 201,'.$rete_iva.'
  "observations": "Observaciones",
  "items": [
    {
      "code": "12SOPIVA1",
      "description": "DESCRIPCION",
      "quantity": 1,
      "price": 21008.4,
      "discount": 0.0,
      "taxes": [
        {"id": 4189,
         "name": "IVA 19% sev",
         "type": "IVA",
         "percentage": 19,
         "value": 3991.6
        }'.$row_retencion.'
      ]
    }'.$otro_producto.'
  ],
  "payments": [
    {
      "id": 6960,
      "value": 25000,
      "due_date": "2021-12-31"
    }
  ],
  "additional_fields": {}
  
}';
return $str;
    }

    public function calculoParaFacturaElectronica($valor_sin_iva){
        $iva=19;
        $valortotal=0;
        $valor_iva=0;
        //$valor_sin_iva=$valor_sin_iva;
        $valor_iva=($valor_sin_iva*$iva)/100;
        $valortotal=$valor_iva+$valor_sin_iva;

        
        if($valortotal!=round($valortotal)){
            $explode_iva=explode(".",$valor_iva);
            $decima1=$explode_iva[1][0];
            //$decima1=1;
            if($decima1==0){
                $valor_sin_iva--;
                $decima1=1;    
            }
            $decimal2=10-$decima1;
            $vari=($explode_iva[0].".".$decima1);
            
            $var_sub=($valor_sin_iva.".".$decimal2);
            $v=($var_sub*19)/100;
            $vt=$v+$var_sub;
            
            if($vt!=round($valortotal)){
                $decima1++;
                $decimal2=10-$decima1;
                $vari=($explode_iva[0].".".$decima1);
                $var_sub=($valor_sin_iva.".".$decimal2);
                $v=$vari;
                
                $valor_iva=$v;
                $valor_sin_iva=$var_sub;
                
            }else{
                $valor_iva=$v;
                $valor_sin_iva=$var_sub;
            }
        }


        
        $valortotal=$valor_iva+$valor_sin_iva;
        return array("valor_iva"=>$valor_iva,"valor_sin_iva"=>$valor_sin_iva,"valortotal"=>$valortotal);
      /*  var_dump($valor_iva); 
        var_dump($valor_sin_iva); 
        var_dump($valortotal);*/
    }
    public function get_customer_id($cid){
        return $this->db->get_where("customers",array("id"=>$cid))->row();
    }
    public function pay_invoices($cid,$monto,$id_orden){
         
        $array_facturas=$this->db->query('SELECT * FROM invoices WHERE csd='.$cid.' and ( status="partial" or status="due") ORDER BY invoices.invoicedate ASC, tid asc')->result();
        if(count($array_facturas)==0){
            $array_facturas=$this->db->query('SELECT * FROM invoices WHERE csd='.$cid.' ORDER BY invoices.invoicedate desc, tid desc limit 1')->result();
        }
        //SELECT * FROM `invoices` WHERE csd=101 and ( status="partial" or status="due") ORDER BY `invoices`.`invoicedate` ASC, tid asc
        $monto=$monto;
        $monto_aux=$monto;
        $valor_restante_monto=0;
        $montos=array();
        $array_facturas2=array();
        $_id_last_invoice_procesed=0;
        $factura_var=null;
        $pmethod = "WOMPI";
        $pa="no";
            foreach ($array_facturas as $key => $factura_l1) {
                $id_factura=$factura_l1->tid;
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
            $cal1=$factura_var->pamnt-$factura_var->total;
            if($cal1>=0 && $factura_var->status=="paid"){//validar el igual a 0
                 $valor_restante_monto=$cal1+$monto_aux;
                 $pa="si";
            }

            
        $id_fact_pagadas="";
        $reconexion_gen="no";
        foreach ($array_facturas2 as $key => $id_factura) {
            if($id_fact_pagadas==""){
                $id_fact_pagadas="".$id_factura;
            }else{
                $id_fact_pagadas.=",".$id_factura;
            }            
            $factura_var = $this->db->get_where('invoices',array('tid'=>$id_factura))->row();
            $customer=$this->db->get_where('customers',array('id'=>$factura_var->csd))->row();
            $ultima_factura=$this->customers->servicios_detail($factura_var->csd);
            //codigo copiado
             $tid = $id_factura;
        $amount = $montos[$id_factura];
        $paydate = date("Y-m-d");
        
        
        if(isset($_POST['EFECTY'])){
            $pmethod = "EFECTY";
            $paydate = (new DateTime($_POST['fecha_x']))->format("Y-m-d");
        }
        $banco = "";
        $acid = $customer->gid;
        $cid = $factura_var->csd;
        $cname = $customer->name;
        $paydate = datefordatabase($paydate);
        $this->db->select('holder,id');
        $this->db->from('accounts');
        $this->db->where('sede', $acid);
        $query = $this->db->get();
        $account = $query->row_array();
        $note = "Pago de la factura #".$id_factura." metodo: ".$pmethod.", Sede: ".$account['holder'].", referencia: ".$id_orden;
        $mt=$this->db->get_where("accounts",array("holder"=>$pmethod))->row();
        $acid=$mt->id;
        $reconexion = "no";
        $fu=null;
        $var_net_="no";
        $var_tv_="no";
        if(!empty($ultima_factura['tid'])){

               $fu= $this->db->get_where("invoices",array("tid"=>$ultima_factura['tid']))->row();
               //if($fu->ron=="Cortado" || $fu->rec=="1"){
                   
                   
                   
                   
                    $reconexion="si";
                    
                    $combo1=strtolower($fu->combo);
                    $var_net=false;
                    $var_tv=false;
                    if(strpos($combo1,"mega")){
                        if($fu->ron=="Activo" || $fu->ron=="Compromiso"){
                            if($fu->estado_combo=="Cortado"){
                                $var_net=true;
                                $var_net_=$fu->combo;
                            }
                        }else{
                               $var_net=true;
                               $var_net_=$fu->combo;
                        }
                        
                    }
                    if($fu->television!="" && $fu->television!=null && $fu->television!="no"){                                                
                        if($fu->ron=="Activo" || $fu->ron=="Compromiso"){
                            if($fu->estado_tv=="Cortado"){
                                $var_tv=true;
                                $var_tv_=$fu->television;
                            }
                        }else{
                              $var_tv=true;
                               $var_tv_=$fu->television;
                        }
                    }
                    if($var_tv && $var_net){
                            $tipo="Reconexion Combo";
                    }else if($var_tv){
                            $tipo="Reconexion Television";
                    }else if($var_net){
                            $tipo="Reconexion Internet";
                    }else{
                        $reconexion="no";
                    }

                    
               //}

        }
        
        
        
        
        if($reconexion=="si"){
            $factura_asociada = $ultima_factura['tid']; 
     if($reconexion_gen=="no"){//&& $factura_asociada==$factura_var->tid
        $factura_asociada = $this->db->get_where('invoices',array('tid'=>$factura_asociada))->row();
        $fcuenta = $factura_asociada->invoicedate;
        $paquete=$var_net_;
        
        

        $mes1 = date("Y-m",strtotime($fcuenta));
        $mes2 = date("Y-m");
        if ($tipo==='Reconexion Combo'){
            $tv = 'Television';
        }if ($tipo==='Reconexion Television'){
            $tv = 'Television';
        }if ($tipo==='Reconexion Internet'){
            $tv = 'no';
        }
        //generar reconexion
        $username = $this->aauth->get_user()->username;
        $tidactualmasuno= $this->db->select('max(codigo)+1 as tid,max(idt)+1 as idt')->from('tickets')->get()->result();
        $datos_tarea=array();
        $datos_tarea['idorden']=$tidactualmasuno[0]->tid;
        $datos_tarea['tdate']=$paydate;
        $datos_tarea['name']="Revisar orden #".$tidactualmasuno[0]->tid;
        $datos_tarea['description']="<a href='". base_url()."tickets/thread/?id=".$tidactualmasuno[0]->idt."'>Revisar orden #".$tidactualmasuno[0]->tid."</a>";
        $datos_tarea['status']="Due";
        $datos_tarea['start']=$paydate;
        $datos_tarea['duedate']=$paydate;
        $datos_tarea['eid']=8;
        $datos_tarea['aid']=8;
        $datos_tarea['priority']="Medium";
        $datos_tarea['related']=0;
        $datos_tarea['rid']=0;
        $this->db->insert("todolist",$datos_tarea);
        
        if ($reconexion=="si" && $mes2===$mes1){
            $data2['codigo']=$tidactualmasuno[0]->tid;
                $data2['subject']='servicio';
                $data2['detalle']=$tipo;
                $data2['created']=$paydate;
                $data2['cid']=$cid;
                $data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$paquete;
                $data2['id_factura']=$factura_asociada->tid;
                $this->db->insert('tickets',$data2);

                          $data_h=array();
                            $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data2);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="tickets";
                            $data_h['nombre_columna']="idt";
                            $this->db->insert("historial_crm",$data_h);
                $reconexion_gen="si";
        }if ($reconexion=="si" && $mes2>$mes1){
                $data2['codigo']=$tidactualmasuno[0]->tid;
                $data2['subject']='servicio';
                $data2['detalle']=$tipo.'2';
                $data2['created']=$paydate;
                $data2['cid']=$cid;
                $data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$paquete;
                $data2['id_factura']='';
                $this->db->insert('tickets',$data2);
                            $data_h=array();
                            $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data2);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="tickets";
                            $data_h['nombre_columna']="idt";
                            $this->db->insert("historial_crm",$data_h);
                $data4 = array(
                'corden' => $data2['codigo'],
                'tv' => $tv,
                'internet' => $paquete,             
            );      
                $reconexion_gen="si";
            $this->db->insert('temporales', $data4);
                            $data_h=array();
                            $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data4);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="temporales";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
            }
        }
}
        
        $id_banco=null;
        $banco=null;
        
            if ($pmethod=="Cash"){
        $note="Pago de la factura #".$tid." ".$customer->name." ".$customer->unoapellido." ".$customer->documento." metodo: efectivo ".$pmethod;
            }
    $data = array(
            'acid' => $acid,
            'account' => $mt->id,
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $cname,
            'payerid' => $cid,
            'method' => $pmethod,
            'date' => $paydate,
            'eid' => 0,
            'tid' => $tid,
            'note' => $note,
            'ext' => 0,
            'nombre_banco'=>$banco,
            'id_banco'=>$id_banco,
            'id_orden_payu'=>$id_orden
        );

        $this->db->insert('transactions', $data);
        $h_x1=$this->db->insert_id();

                            $data_h=array();
                            $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data);
                            $data_h['id_fila']=$h_x1;
                            $data_h['tabla']="transactions";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
        $idtr = $this->db->select('max(id) as id')->from('transactions')->where(array("tid"=>$tid))->get()->result();
        $ids_transacciones[]=$idtr[0]->id;

        $this->db->select('invoiceduedate,total,csd,pamnt,rec');
        $this->db->from('invoices');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $invresult = $query->row();

        $totalrm = $invresult->total - $invresult->pamnt;

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');

                        $data_h=array();
                            $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("status"=>"partial","pamnt"=>"pamnt+$amount","pmethod"=>$pmethod));
                            $data_h['id_fila']=$tid;
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);
            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');

                    $data_h=array();
                            $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                            $data_h['id_fila']=$acid;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
        } else {

            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');
                    $data_h=array();
                           $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("status"=>"paid","pamnt"=>"pamnt+$amount","pmethod"=>$pmethod));
                            $data_h['id_fila']=$tid;
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                        $data_h=array();
                            $data_h['modulo']="Usuarios Servicio ".$pmethod;
                            $data_h['accion']="Hacer el Pago {update}";
                            $data_h['id_usuario']=$cid;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                            $data_h['id_fila']=$acid;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);

            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;


        }
        }
        
        $this->actualizar_debit_y_credit($cid);

        if(is_array($ids_transacciones) && count($ids_transacciones)!=0){
            $this->generar_pdf_tirilla_de_pago($id_fact_pagadas,"si",$valor_restante_monto,$pa,$ids_transacciones,$factura_var->csd);
            //$this->input->set_cookie("ids_transacciones",json_encode($ids_transacciones),3600,null);
            return true;
        }else{
            return false;
            //$this->input->set_cookie("ids_transacciones",null,3600,null);
            
        }
    }
    public function generar_pdf_tirilla_de_pago($id,$multiple,$vrm,$pa,$ids_transacciones,$csd)
    {
$this->load->model('invoices_model', 'invocies');
        $tid = $id;
        $is_multiple = false;
        if(!empty($multiple)){
                $is_multiple=true;
        }
        
        $lista= explode(",",$tid);
        $tid=$lista[0];

        $data['id'] = $tid;
        $data['is_multiple'] = $is_multiple;
        $data['title'] = "Invoice $tid";
        $data['vrm']=0;
        $data['pa']="no";
        if(!empty($vrm)){
                $data['vrm']=$vrm;
        }
        if(!empty($pa)){
                $data['pa']=$pa;
        }

        $data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if ($data['invoice']) $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $this->load->model('customers_model', 'customers');
        $data['due'] = $this->due_details($data['invoice']['csd']);
        
        
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

$customer=$this->db->get_where("customers",array("id"=>$csd))->row();
$this->load->model('Communication_model', 'communication'); 
$cuerpo="Saludos cordiales de parte de VESTEL, para nosotros es muy satisfactorio contar contigo, por tal motivo te enviamos el comprobante de pago de tu factura, gracias por utilizar nuestros servicios, abre la siguiente url para visualizarlo : http://www.saves-vestel.com/comprobantes?name=".$tid."_".$x;
        $ids_transactions=$ids_transacciones;

foreach ($lista as $key => $value) {
        $inv=$this->db->get_where("invoices",array("tid"=>$value))->row();   
         if($ids_transactions!=null && is_array($ids_transactions)){
                 $fecha_actual=new DateTime();

                $data_recib=array("date"=>$fecha_actual->format("Y-m-d h:i:s"),"file_name"=>$tid."_".$x,"tid"=>$value);
                $this->db->insert("recibos_de_pago",$data_recib);
                $id_recibo=$this->db->insert_id();
                foreach ($ids_transactions as $key_tr => $value_tr) {
                    $data_xy=array("id_recibo_de_pago"=>$id_recibo,"id_transaccion"=>$value_tr);
                    $this->db->insert("transactions_ids_recibos_de_pago",$data_xy);
                }
            
         }

    }
    if(empty($_POST['no_email'])){
    $this->communication->send_email($customer->email,"Comprobante de pago VESTEL","Comprobante de pago VESTEL",$cuerpo);    
    $this->communication->send_email("pescafelipe@gmail.com","Comprobante de pago VESTEL","Comprobante de pago VESTEL",$cuerpo);
    }
    



}
public function tiene_afiliacion($id){
        $lista_facturas=$this->db->query("SELECT * FROM invoice_items inner join invoices on invoices.tid=invoice_items.tid where invoices.csd=".$id." and invoice_items.product LIKE '%Afiliación%'  group by invoice_items.product order by invoices.tid desc")->result_array();
        if(count($lista_facturas)>0){
            //var_dump($lista_facturas[0]['pid']);
            return array("estado"=>true,"pid"=>$lista_facturas[0]['pid']);
        }else{
            return array("estado"=>false);
        }
        
    }
    public function convert_string_bool_to_int($str){
        if($str=="true"){
            return 1;
        }else{
            return 0;
        }
    }
    public function get_config_campos_faltantes_customer($id_c){
        return $this->db->get_where("config_campos_faltantes_customer",array("id_customer"=>$id_c))->row();
    }
    public function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}
public function array_sortOBJECT($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v->$on;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[] = $array[$k];
        }
    }

    return $new_array;
}
}
