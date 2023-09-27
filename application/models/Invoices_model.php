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

class Invoices_model extends CI_Model
{
    var $table = 'invoices';
    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $column_search = array('tid', 'name', 'abonado', 'invoicedate', 'total','refer','customers.documento','customers.name','customers.dosnombre','customers.unoapellido','customers.dosapellido');
    var $order = array('tid' => 'desc');
	var $opt = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function lastinvoice()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }

    public function invoice_details($id, $eid = '')
    {

        $this->db->select('invoices.*,customers.*,departamentos.*,ciudad.*,customers_group.*,customers.id AS cid,billing_terms.id AS termid,billing_terms.title AS termtit,billing_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('invoices.tid', $id);
        if ($eid) {
            $this->db->where('invoices.eid', $eid);
        }
        $this->db->join('customers', 'invoices.csd = customers.id', 'left');
        $this->db->join('customers_group', 'customers.gid = customers_group.id', 'left');
        $this->db->join('departamentos', 'customers.departamento = departamentos.idDepartamento', 'left');
        $this->db->join('ciudad', 'customers.ciudad = ciudad.idCiudad', 'left');
        $this->db->join('billing_terms', 'billing_terms.id = invoices.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }
    public function invoice_sin_pagar($id)
    {
        return $this->db->query("select * from invoices where csd=".$id." and pamnt<total order by tid desc")->result_array();
    }
    public function ultima_factura($id)
    {
        return $this->db->query("select * from invoices where csd=".$id." order by tid desc limit 1")->result_array();
    }
	public function ultima_transaccion_realizada($id){
        return $this->db->query("select * from transactions where estado is null and payerid=".$id." order by id desc limit 1")->result_array();
    }
    public function pagadas_adelantadas($id){
        $informacion=array("tr_saldo_adelantado"=>null,"factura_saldo_adelantado"=>null,"facturas_adelantadas"=>null);
        $lista_facturas= $this->db->query("select * from invoices where csd=".$id." order by tid desc")->result_array();
        foreach ($lista_facturas as $key => $value) {
            $calculo= $this->db->query("select sum(credit-debit) as calculo from transactions where tid=".$value['tid']." and estado is null")->result_array();

            if($calculo[0]['calculo']>=$value['total']){
                    $informacion['tr_saldo_adelantado']= $this->db->query("select * from transactions where tid=".$value['tid']." and estado is null and credit>0 order by credit desc limit 1")->result_array();//si no bota la transaccion correcta se debe de colocar en orden ascendente
                    $informacion['factura_saldo_adelantado']=$value;
                    
                    $disponible=$calculo[0]['calculo']-$value['total'];
                    $informacion['facturas_adelantadas']= $this->calculo_de_facturas_adelantadas($disponible,$id);
                    break;
            }
        }
        return $informacion;
    }
    public function calculo_de_facturas_adelantadas($vrm,$csd){
        ini_set('memory_limit', '1000000000000M');

        $due=$this->customers->due_details($csd);
       $x1= $due['total']-$due['pamnt'];
       if($x1<0){
            $vrm=abs($x1);
       }
        /* codigo pagos adelantados*/ 
if($vrm>0){
setlocale(LC_TIME, "spanish");
    $iva=0;
    $total=0;
    $retorno=array();
    //esto es para el calculo de facturas sin crear al hacer pagos adelantados;
    $ultima_factura=$this->customers->servicios_detail($csd);
    if(isset($ultima_factura['tid'])){
        $var_factura=$this->db->get_where("invoices",array("tid"=>$ultima_factura['tid']))->row();
        $ticket_reconexion_internet=$this->db->query("select * from tickets where id_factura=".$ultima_factura['tid']." and (detalle like '%Reconexion Internet%' or detalle like '%Reconexion Combo%')")->result_array();
        $ticket_reconexion_internet2=$this->db->query("select * from tickets where created='".date("Y-m-d")."' and cid='".$csd."' and (detalle like '%Reconexion Internet2%' or detalle like '%Reconexion Combo2%')")->result_array();
        
    if(($ultima_factura['combo']!="no" && $ultima_factura['combo']!="" && $ultima_factura['combo']!="-") || count($ticket_reconexion_internet)!=0 || count($ticket_reconexion_internet2)!=0){
        $internet="";
        $total_factura=0;
                if($ultima_factura['estado_combo']=="null" || $ultima_factura['estado_combo']==null){
                        $internet=$ultima_factura['combo'];  
                }else{
                      $internet=$ultima_factura['paquete'];  
                }
                    
    }
    $str1=str_replace(" ", "", strtolower($internet));
    $producto_internet=$this->db->query('SELECT * FROM products WHERE lower(REPLACE(product_name," ","")) = "'.$str1.'"')->result_array();
    $producto_internet=$producto_internet[0];
    
    if($producto_internet!=null){
        
        if($producto_internet['taxrate']!=0){
                $iva+=round(($producto_internet['product_price']*$producto_internet['taxrate'])/100);
        }    
        $total+=$producto_internet['product_price'];
    }
    
    $television=0;
    $puntos=0;
    $ticket_reconexion_tv=$this->db->query("select * from tickets where id_factura=".$ultima_factura['tid']." and (detalle like '%Reconexion Television%' or detalle like '%Reconexion Combo%')")->result_array();
    $ticket_reconexion_tv2=$this->db->query("select * from tickets where created='".date("Y-m-d")."' and cid='".$csd."' and (detalle like '%Reconexion Television2%' or detalle like '%Reconexion Combo2%')")->result_array();
    if(($ultima_factura['television']!="no" && $ultima_factura['television']!="" && $ultima_factura['television']!="-" )|| count($ticket_reconexion_tv)!=0 ||  count($ticket_reconexion_tv2)!=0){
                if($ultima_factura['estado_tv']=="null" || $ultima_factura['estado_tv']==null){
                       $television=27;
                        
                }else{
                        $television=27;
                }
                $prod_add_tv=$this->db->get_where("products",array("product_name"=>$ultima_factura['television']))->row();
                if(isset($prod_add_tv) && strtolower($ultima_factura['television'])!="television"){
                    $television=$prod_add_tv->pid;
                }
                $puntos=intval($ultima_factura['puntos']);
    }
    if($television!=0){
        if(strpos(strtolower($var_factura->refer), strtolower("mocoa"))!==false){
            $television=159;
        }
        
        $producto_televison=$this->db->query('SELECT * FROM products WHERE pid='.$television)->result_array();
        $producto_televison=$producto_televison[0];
        if($producto_televison!=null){


            if($producto_televison['taxrate']!=0){
                $iva+=round(($producto_televison['product_price']*$producto_televison['taxrate'])/100);
            }

            $total+=$producto_televison['product_price'];
            if($puntos!=0 && $puntos!=null){
                $punto=$this->db->query('SELECT * FROM products WHERE pid=158')->result_array();
                $punto=$punto[0];
                if($punto['taxrate']!=0){
                    $iva+=round(($punto['product_price']*$punto['taxrate'])/100);
                }
                
                $punto['product_price']=$punto['product_price']*$puntos;
                $total+=$punto['product_price'];
            }
        }

    }
    $total+=$iva;
    if($total<=0){
        $total=round($var_factura->total);
    }
    $fecha_= $var_factura->invoicedate;
    $vrm_aux=$vrm;
    $retorno=array();
    while($vrm_aux>0){
        $valor_a_colocar=0;
        if($vrm_aux>=$total){
            $valor_a_colocar=$total;
            $vrm_aux=$vrm_aux-$total;
        }else{
            $valor_a_colocar=$vrm_aux;
            $vrm_aux=0;            
        }


        $fecha_=date("d-m-Y",strtotime($fecha_."+ 1 month"));
        $fecha_2=date("t-m-Y",strtotime($fecha_));
        $f1 = date(" F ",strtotime($fecha_));        
        $retorno[]=array("mes"=> strftime("%B", strtotime($fecha_)),"valor_a_colocar"=>$valor_a_colocar,"fecha_final"=>$fecha_2);        
    }
    


    

//end esto es para el calculo de facturas sin crear al hacer pagos adelantados;
    }
    return $retorno;
}
/* end codigo pagos adelantados*/
    }
    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('currencies');

        $query = $this->db->get();
        return $query->result_array();

    }
	public function activar($tid,$status,$bill_fecha,$hora)
    {
		//dar permisos
		
                $this->db->where('id_modulo', 3);
				$this->db->where('id_usuario', $tid);
				$this->db->set('is_checked', 0);
				$this->db->update('permisos_usuario');
		
			     $this->db->where('id_modulo', 5);
				$this->db->where('id_usuario', $tid);
				$this->db->set('is_checked', 0);
				$this->db->update('permisos_usuario');
			
		$data = array(
			'finicial' => $bill_fecha,
			'hinicial' => $hora,
			/*'conue' => 0,
			'cocie' => 0,*/
			);
		//$this->db->set($data);
		
        $this->db->where('id', $tid);
		
        if($this->db->update('aauth_users', $data)){
                  $data_h=array();
                    $data_h['modulo']="Ventas";
                    $data_h['accion']="Apertura de caja {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode($data);
                    $data_h['id_fila']=$tid;
                    $data_h['tabla']="aauth_users";
                    $data_h['nombre_columna']="id";
                    $this->db->insert("historial_crm",$data_h);
            return true;    
        }else{
            return false;
        }
		
        
    }
	

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('currencies');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_phons_csd($csd){
        $obj= $this->db->get_where("customers",array("id"=>$csd))->row();
        $str_retorn="";
        if(!(strlen($obj->celular)<10 || strlen($obj->celular)>10 || preg_match_all("/[^0-9]/",$obj->celular)!=0)){
                $str_retorn=$csd."-".$obj->celular;
        }        
        if(!(strlen($obj->celular2)<10 || strlen($obj->celular2)>10 || preg_match_all("/[^0-9]/",$obj->celular2)!=0)){
                $str_retorn=$csd."-".$obj->celular2;
        }

        return $str_retorn;
    }
	public function paquetes($opts)
    {//https://www.jose-aguilar.com/blog/multidimensional-array-sort/
        //como ordenar un array multidimencional
		$this->opt = $opts;
		$sede = $this->aauth->get_user()->sede_accede;
		$this->db->select('*');
        $this->db->from('products');
		switch ($this->opt) {
            case 'tv':
                $this->db->where('sede', 1);
                //$this->db->where('warehouse', 1);
                break;
            case 'inter':
                $this->db->where('sede', 2);
                //$this->db->where('warehouse', 1);
                break;
			case 'adint':
                $this->db->where('pertence_a_tv_o_net', 'Internet');
                //$this->db->where('warehouse', 1);
                break;
			case 'adtv':
                $this->db->where('pertence_a_tv_o_net', 'Tv');
                //$this->db->where('warehouse', 1);
                break;
			
        }
        $query = $this->db->get();
        $vr_ar=$query->result_array();
        $aux=array();
        foreach ($vr_ar as $key => $value) {
            preg_match('/^(\d+)/', $vr_ar[$key]['product_name'], $aux[$key]);
        }
        array_multisort($aux,SORT_ASC,$vr_ar);
        return $vr_ar;
    }
	public function sede()
    {
		$sedeacc = $this->aauth->get_user()->sede_accede;
		$this->db->select('*');
        $this->db->from('customers_group');
        $sedeacc = str_replace("-","", $sedeacc);
		if ($sedeacc != '0'){
		$this->db->where_in('id', explode(",", $sedeacc));
		}
        $query = $this->db->get();
        return $query->result_array();
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('product_warehouse');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_transactions($id)
    {

        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('tid', $id);
        $this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_delete($id, $eid = '')
    {

        $this->db->trans_start();

		$this->db->select('status');
        $this->db->from('invoices');
        $this->db->where('tid', $id);
		$query = $this->db->get();
        $result = $query->row_array();

        if ($eid) {
            $res = $this->db->delete('invoices', array('tid' => $id, 'eid' => $eid));
                        $data_h=array();
                        $data_h['modulo']="Ventas";
                        $data_h['accion']="Eliminar factura {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array('tid' => $id, 'eid' => $eid));
                        $data_h['tabla']="invoices";
                        $data_h['nombre_columna']="tid";
                        $data_h['id_fila']=$id;
                        $this->db->insert("historial_crm",$data_h);
        } else {
            $res = $this->db->delete('invoices', array('tid' => $id));
                        $data_h=array();
                        $data_h['modulo']="Ventas";
                        $data_h['accion']="Eliminar factura {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array('tid' => $id));
                        $data_h['tabla']="invoices";
                        $data_h['nombre_columna']="tid";
                        $data_h['id_fila']=$id;
                        $this->db->insert("historial_crm",$data_h);
        }

		
        if ($res) {
			if($result['status']!='canceled'){
            $this->db->select('pid,qty');
            $this->db->from('invoice_items');
            $this->db->where('tid', $id);
            $query = $this->db->get();
            $prevresult = $query->result_array();

            foreach ($prevresult as $prd) {
                $amt = $prd['qty'];
                $this->db->set('qty', "qty+$amt", FALSE);
                $this->db->where('pid', $prd['pid']);
                $this->db->update('products');
                        $data_h=array();
                        $data_h['modulo']="Ventas";
                        $data_h['accion']="Eliminar factura {update}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array('qty' => "qty+$amt"));
                        $data_h['tabla']="products";
                        $data_h['nombre_columna']="pid";
                        $data_h['id_fila']=$prd['pid'];
                        $this->db->insert("historial_crm",$data_h);
            }
			}


            $this->db->delete('invoice_items', array('tid' => $id));
                        $data_h=array();
                        $data_h['modulo']="Ventas";
                        $data_h['accion']="Eliminar factura {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array('tid' => $id));
                        $data_h['tabla']="invoice_items";
                        $data_h['nombre_columna']="tid";
                        $data_h['id_fila']=$id;
                        $this->db->insert("historial_crm",$data_h);

            if ($this->db->trans_complete()) {
                $this->db->delete("servicios_adicionales",array("tid_invoice"=>$id));
                return true;
            } else {
                return false;
            }
        }
    }


    private function _get_datatables_query($opt = '',$filt2)
    {
		$this->db->select('invoices.*,customers.name,customers.dosnombre,customers.unoapellido,customers.dosapellido,customers.abonado,customers.documento');
        $this->db->from($this->table);
		if($filt2['opcselect']!=''){

            $dateTime= new DateTime($filt2['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($filt2['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($filt2['opcselect']=="fcreada"){
                $this->db->where('invoicedate>=', $sdate);   
                $this->db->where('invoicedate<=', $edate);       
            }
            
        }
		if($filt2['estado']!=""){
            $this->db->where('status', $filt2['estado']);       
        }
		if($filt2['sede']!=""){
            $this->db->where('refer', $filt2['sede']);       
        }
		if($filt2['siigo']!=""){
			if($filt2['siigo']=="null"){
				$filt2['siigo']=null;
			}
            $this->db->where('facturacion_electronica', $filt2['siigo']);       
        }
        if ($opt) {
            $this->db->where('invoices.eid', $opt);
        }
        $this->db->join('customers', 'invoices.csd=customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
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

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = '',$filt2)
    {
        $this->_get_datatables_query($opt,$filt2);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($opt = '',$filt2)
    {
        $this->_get_datatables_query($opt,$filt2);
        if ($opt) {
            $this->db->where('eid', $opt);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '',$filt2)
    {
		$this->_get_datatables_query($opt,$filt2);
        if ($opt) {
            $this->db->where('eid', $opt);
        }
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('billing_terms');
        $this->db->where('type', 1);
        $this->db->or_where('type', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('employee_profile.name,employee_profile.sign,aauth_users.roleid');
        $this->db->from('employee_profile');
        $this->db->where('employee_profile.id', $id);
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
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

    public function attach($id)
    {
        $this->db->select('meta_data.*');
        $this->db->from('meta_data');
        $this->db->where('meta_data.type', 1);
        $this->db->where('meta_data.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id,$type,$name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('meta_data', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }
    public function get_servicios(){
        //$array=array();//array("servicios_tv"=>array(),"servicios_internet"=>array());
        $lista_sedes=$this->db->get_where("customers_group",array("id"=>"2"))->result_array();
        //$lista_sedes[]['id']="-1";
        //$lista_sedes[]['id']="-2";
        foreach($lista_sedes as $key=> $value){
            //$lista_sedes[$key]['servicios_tv']=$this->db->get_where("products",array("valores!="=>"","valores!="=>null,"pertence_a_tv_o_net"=>"Tv"))->result_array();
            //$lista_sedes[$key]['servicios_internet']=$this->db->get_where("products",array("valores!="=>"","valores!="=>null,"pertence_a_tv_o_net"=>"Internet"))->result_array();
            $lista_sedes[$key]['servicios_tv']=$this->db->query("select * from products where valores !='' and valores is not  null and  pertence_a_tv_o_net='Tv'")->result_array();
            $lista_sedes[$key]['servicios_internet']=$this->db->query("select * from products where valores !='' and valores is not  null and  pertence_a_tv_o_net='Internet'")->result_array();
            foreach ($lista_sedes[$key]['servicios_tv'] as $key2 => $value2) {
                
                $x1=explode("-", $value2['valores']);
                if(count($x1)==2){
                        if(is_numeric($x1[0]) && is_numeric($x1[1])){
                            $var1=array();
                            for ($i=$x1[0]; $i <=$x1[1]; $i++) { 
                                $var1[]=$i;
                            }
                            $lista_sedes[$key]['servicios_tv'][$key2]['valores']=$var1;
                        }else{
                            $lista_sedes[$key]['servicios_tv'][$key2]=array();
                        }
                }else{
                    try {
                        $lista_sedes[$key]['servicios_tv'][$key2]['valores']=explode(",", $value2['valores']);    
                    } catch (Exception $e) {
                        $lista_sedes[$key]['servicios_tv'][$key2]=array();
                    }
                    
                }
            }
            foreach ($lista_sedes[$key]['servicios_internet'] as $key2 => $value2) {
                
                $x1=explode("-", $value2['valores']);
                if(count($x1)==2){
                        if(is_numeric($x1[0]) && is_numeric($x1[1])){
                            $var1=array();
                            for ($i=$x1[0]; $i <=$x1[1]; $i++) { 
                                $var1[]=$i;
                            }
                            $lista_sedes[$key]['servicios_internet'][$key2]['valores']=$var1;
                        }else{
                            $lista_sedes[$key]['servicios_internet'][$key2]=array();
                        }
                }else{
                    try {
                        $lista_sedes[$key]['servicios_internet'][$key2]['valores']=explode(",", $value2['valores']);    
                    } catch (Exception $e) {
                        $lista_sedes[$key]['servicios_internet'][$key2]=array();
                    }
                    
                }
            }
            
        }
        //var_dump($lista_sedes);
        //var_dump($this->db->get_where("products",array("pcat"=>"4","warehouse"=>"7","sede"=>"2","pertence_a_tv_o_net"=>"Tv"))->result_array());
        return $lista_sedes;
    }
     public function validacion_generar_orden_traslado($cid){
        $ultima_factura_tr=$this->db->query('SELECT * FROM invoices as inv  inner join invoice_items  as inv_it on inv_it.tid=inv.tid where inv.csd ="'.$cid.'" and inv_it.product like "%traslado%" and inv.status="paid" order by inv.tid desc limit 1')->result_array();
        if(count($ultima_factura_tr)>0){
            $temporal =$this->db->get_where("temporales",array("tid_traslado"=>$ultima_factura_tr[0]['tid']))->row();
            
            if(isset($temporal)&& $temporal->corden==0){
                
                $tidactualmasuno1= $this->db->select('max(codigo)+1 as codigo')->from('tickets')->get()->result();
                $ultima_factura=$this->db->query('SELECT * from invoices  where csd="'.$cid.'" and tipo_factura="Recurrente"  order by tid desc limit 1')->result_array();
                 $username = $this->aauth->get_user()->username;
                    $datax2['codigo']=$tidactualmasuno1[0]->codigo;   
                    $datax2['subject']='servicio';
                    $datax2['detalle']='Traslado';    
                    $datax2['created']=date("Y-m-d");
                    $datax2['cid']=$cid;
                    $datax2['col']=$username;
                    $datax2['status']='Pendiente';
                    $datax2['section']=""; 
                    //Tipo de instalacion
                        
                    $datax2['id_invoice']=null;
                    $datax2['id_factura']=$ultima_factura[0]['tid'];
                    
                    $this->db->insert('tickets',$datax2);
                    $data_tem=array();
                    $data_tem['corden']=$datax2['codigo'];
                    $this->db->update("temporales",$data_tem,array("tid_traslado"=>$ultima_factura_tr[0]['tid']));
            }
        }

        //$ultima_factura=$this->db->query('SELECT * from invoices  where csd="'.$cid.'" and tipo_factura="Recurrente"  order by tid desc limit 1')->result_array();
     }
    public function validacion_generar_orden_instalacion($cid){
        $ultima_factura=$this->db->query('SELECT * from invoices  where csd="'.$cid.'" order by tid desc limit 1')->result_array();

        
        if($ultima_factura[0]['status']=='paid' ){
                $es_afili=$this->db->query('SELECT * FROM invoice_items WHERE tid ="'.$ultima_factura[0]['tid'].'" and product like "%afiliacion%" ')->result_array();    
                $no_orden=$this->db->query('SELECT * FROM tickets WHERE id_invoice ="'.$ultima_factura[0]['tid'].'" and detalle="Instalacion" ')->result_array();    
                if(count($es_afili)>0 && count($no_orden)==0){
                    $tidactualmasuno1= $this->db->select('max(codigo)+1 as codigo')->from('tickets')->get()->result();
                    $username = $this->aauth->get_user()->username;
                    $tv="";
                    if ($ultima_factura[0]['television']=='no'){
                        $tv = '';
                    }else{
                        $tv = $ultima_factura[0]['television'];
                    }
                    $int = '';
                    if ($ultima_factura[0]['combo']=='no'){
                        $int = '';
                    }else{
                        $int = ' + '.$ultima_factura[0]['combo'];
                    }
                    $pto = '';
                    if ($ultima_factura[0]['puntos']=='0'){
                        $pto = '';
                    }else{
                        $pto = ' + '.$ultima_factura[0]['puntos'].' Puntos';
                    }
                    $servicios_adicionales=$this->servicios_adicionales_tr_auto($ultima_factura[0]['tid']);
                    $datax2['codigo']=$tidactualmasuno1[0]->codigo;   
                    $datax2['subject']='servicio';
                    $datax2['detalle']='Instalacion';    
                    $datax2['created']=date("Y-m-d");
                    $datax2['cid']=$cid;
                    $datax2['col']=$username;
                    $datax2['status']='Pendiente';
                    $datax2['section']=$tv.$int.$pto.$servicios_adicionales; 
                    //Tipo de instalacion
                        
                    $datax2['id_invoice']=$ultima_factura[0]['tid'];
                    $datax2['id_factura']=null;
                    
                    $this->db->insert('tickets',$datax2);
                    $customerx1=$this->db->get_where("customers",array('id' =>$cid))->row();  
                    $this->db->set("ultimo_estado",$customerx1->usu_estado);
                    $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));

                    $this->db->set('usu_estado', 'Instalar');
                    $this->db->where('id', $cid);
                    $this->db->update('customers');
                }
        }
    }
    public function servicios_adicionales_tr_auto($tid){
        $lista_servs=$this->db->get_where("servicios_adicionales",array("tid_invoice"=>$tid))->result_array();
        $text="";
        foreach ($lista_servs as $key => $value) {
            $producto=$this->db->get_where("products",array("pid"=>$value['pid']))->row();
            $text.=" + ".$value['valor']." ".$producto->product_name;
        }
        return $text;        
    }
    public function servicios_adicionales($tid,$return_text){
        $lista_servs=$this->db->get_where("servicios_adicionales",array("tid_invoice"=>$tid))->result_array();
        $text="";
        foreach ($lista_servs as $key => $value) {
            $producto=$this->db->get_where("products",array("pid"=>$value['pid']))->row();
            $text.=" mas ".$value['valor']." ".$producto->product_name;
        }
        if($return_text){
            return $text;    
        }else{
            return $lista_servs;
        }
        

    }
    public function get_retenciones($tid){
        $retornar=array("retenciones"=>array(),"total"=>0);
        $x=$this->db->query("SELECT * FROM invoice_items where tid=".$tid." and tipo_retencion is not null")->result_array();
        foreach ($x as $key => $value) {
            $retornar['total']+=abs($value['price']);
        }
        $retornar['retenciones']=$x;
        return $retornar;
    }
    public function servicios_adicionales_idt($idt_ticket,$listax){
        $lista_servs=$this->db->get_where("servicios_adicionales",array("idt_ticket"=>$idt_ticket))->result_array();
        foreach ($lista_servs as $key => $value) {
            $listax[]=$value;
        }
        
        return $listax;
        

    }
    public function servicios_adicionales_recurrentes($tid){
        $lista_servs1=$this->db->get_where("servicios_adicionales",array("tid_invoice"=>$tid))->result_array();
        $lista_servs=array();
        
        foreach ($lista_servs1 as $key => $value) {
            $producto=$this->db->get_where("products",array("pid"=>$value['pid']))->row();
             if($producto->tipo_servicio=="Recurrente"){
                    $lista_servs[]=$value;
            }
            
        }
        
            
        
        return $lista_servs;
        
        

    }
    public function procesar_pagos_adelantados($id_customer){
        //codigo para pagar con saldo ya existente
             $this->load->model('customers_model', 'customers');
             $invoices = $this->db->select("*")->from("invoices")->where('csd='.$id_customer)->order_by('invoicedate',"ASC")->get()->result();//$invoices = $this->db->select("*")->from("invoices")->where('csd='.$value['id'])->order_by('invoicedate',"ASC")->get()->result();
            
            
            $lista_para_pagos_adelantados=array();
            $lista_para_pagos_faltantes=array();
            $saldo_dispo_total=0;
            foreach ($invoices as $key => $inv) {
                
                $validacion_fija=false;
                if($inv->tipo_factura=="Nota Credito" || $inv->tipo_factura=="Nota Debito"){
                        $validacion_fija=true;
                }else if($inv->tipo_factura=="Fija" && $_SESSION[md5("variable_datos_pin")]['db_name']!="admin_crmvestel"){
                    $validacion_fija=true;
                }

                if($validacion_fija){ //if($inv->tipo_factura=="Fija" || $inv->tipo_factura=="Nota Credito" || $inv->tipo_factura=="Nota Debito"){
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



            

            if(count($lista_para_pagos_faltantes) !=0 && $saldo_dispo_total!=0){//&& $value['id']==5605

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

}