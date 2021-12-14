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
    var $column_search = array('tid', 'name', 'abonado', 'invoicedate', 'total','refer');
    var $order = array('tid' => 'desc');

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

        $this->db->select('invoices.*,customers.*,customers.id AS cid,billing_terms.id AS termid,billing_terms.title AS termtit,billing_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('invoices.tid', $id);
        if ($eid) {
            $this->db->where('invoices.eid', $eid);
        }
        $this->db->join('customers', 'invoices.csd = customers.id', 'left');
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
            if($calculo[0]['calculo']>$value['total']){
                    $informacion['tr_saldo_adelantado']= $this->db->query("select * from transactions where tid=".$value['tid']." and estado is null and credit>0 order by credit desc limit 1")->result_array();//si no bota la transaccion correcta se debe de colocar en orden ascendente
                    $informacion['factura_saldo_adelantado']=$value;
                    
                    $disponible=$calculo[0]['calculo']-$value['total'];
                    $informacion['facturas_adelantadas']= $this->calculo_de_facturas_adelantadas($disponible,$id);

            }
        }
        return $informacion;
    }
    public function calculo_de_facturas_adelantadas($vrm,$csd){
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

                $total+=$punto['product_price'];
            }
        }

    }
    $total+=$iva;
    
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
        $retorno[]=array("mes"=> strftime("%B", strtotime($f1)),"valor_a_colocar"=>$valor_a_colocar,"fecha_final"=>$fecha_2);        
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
		$data = array(
			'finicial' => $bill_fecha,
			'hinicial' => $hora,
			'roleid' => $status,
			);
		//$this->db->set($data);
        $this->db->where('id', $tid);
        if($this->db->update('aauth_users', $data)){
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
	public function paquetes()
    {
		$sede = $this->aauth->get_user()->sede_accede;
		$this->db->select('*');
        $this->db->from('products');
		if ($sede == '0'){
			$this->db->where('sede >', 0);
		}else{
		$this->db->where('sede', $sede);
		}
        $query = $this->db->get();
        return $query->result_array();
    }
	public function sede()
    {
		$sedeacc = $this->aauth->get_user()->sede_accede;
		$this->db->select('*');
        $this->db->from('customers_group');
		if ($sedeacc != '0'){
		$this->db->where('id', $sedeacc);
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
        } else {
            $res = $this->db->delete('invoices', array('tid' => $id));
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
            }
			}


            $this->db->delete('invoice_items', array('tid' => $id));

            if ($this->db->trans_complete()) {
                return true;
            } else {
                return false;
            }
        }
    }


    private function _get_datatables_query($opt = '')
    {

        $this->db->from($this->table);
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

    function get_datatables($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($opt = '')
    {
        $this->_get_datatables_query($opt);
        if ($opt) {
            $this->db->where('eid', $opt);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($opt = '')
    {
        $this->db->from($this->table);
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

}