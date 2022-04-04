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

class Equipos_model extends CI_Model
{

    var $table = 'equipos';	
    var $column_order = array(null,null, 'codigo','mac', 'serial', 'estado', 'asignado', 'marca', null); //set column field database for datatable orderable
    var $column_search = array('codigo', 'mac','serial','estado','almacen','asignado','marca'); //Establecer base de datos de campo de columna para la tabla de datos
    var $order = array('id' => 'desc'); // default order
	
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	// Consulta para tabla de equipos
	 private function _get_datatables_query($id = '')
    {
         
			$this->db->from($this->table);
		 	//$this->db->join('customers', 'customers.id = equipos.asignado');
		 if ($id > 0) {
			 $this->db->where("almacen = $id");
		 }        
        $i = 0;
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

    function get_datatables($id = '')
    {
        if ($id > 0) {
            $this->_get_datatables_query($id);
        } else {
            $this->_get_datatables_query();
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }  
	// Consecutivo equipos
	public function codigoequipo()
    {
        $this->db->select('codigo');
        $this->db->from($this->table);
        $this->db->order_by('codigo', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->codigo;
        } else {
            return 1000;
        }
    }

    function count_filtered($id)
    {
        if ($id > 0) {
            $this->_get_datatables_query($id);
        } else {
            $this->_get_datatables_query();
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
	

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
	

    public function addnew($catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc)
    {
        $data = array(
            'pcat' => $catid,
            'warehouse' => $warehouse,
            'product_name' => $product_name,
            'product_code' => $product_code,
            'product_price' => $product_price,
            'fproduct_price' => $factoryprice,
            'taxrate' => $taxrate,
            'disrate' => $disrate,
            'qty' => $product_qty,
            'product_des' => $product_desc,
            'alert' => $product_qty_alert
        );

        if ($this->db->insert('products', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
	public function addequipo($codigo, $proveedor, $almacen, $mac, $serial, $llegada, $final, $marca, $asignado,$estado,$observacion)
    {
		$bill_final = datefordatabase($final);
		$bill_llegada = datefordatabase($llegada);
        $data = array(
            'codigo' => $codigo,
            'proveedor' => $proveedor,
            'almacen' => $almacen,
            'mac' => $mac,
            'serial' => $serial,
            'llegada' => $bill_llegada,
            'final' => $bill_final,
            'marca' => $marca,
            'asignado' => $asignado,
            'estado' => $estado,
            'observacion' => $observacion
        );

        if ($this->db->insert('equipos', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
    public function editar_imagen_equipo($codigo,$nombre_img){
    $data_x['imagen']=$nombre_img;
    return $this->db->update("equipos",$data_x,array("codigo"=>$codigo));
}

    public function edit($pid, $catid, $warehouse, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc)
    {
        $data = array(
            'pcat' => $catid,
            'warehouse' => $warehouse,
            'product_name' => $product_name,
            'product_code' => $product_code,
            'product_price' => $product_price,
            'fproduct_price' => $factoryprice,
            'taxrate' => $taxrate,
            'disrate' => $disrate,
            'qty' => $product_qty,
            'product_des' => $product_desc,
            'alert' => $product_qty_alert
        );


        $this->db->set($data);
        $this->db->where('pid', $pid);

        if ($this->db->update('products')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function prd_stats()
    {

        $query = $this->db->query("SELECT
COUNT(IF( qty > 0, qty, NULL)) AS instock,
COUNT(IF( qty <= 0, qty, NULL)) AS outofstock,
COUNT(qty) AS total
FROM products ");
        //   return $query->result_array();

        echo json_encode($query->result_array());

    }

    public function products_list($id)
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('warehouse', $id);
        $query = $this->db->get();
        return $query->result_array();

    }
	public function proveedor_list($id)
    {
        $this->db->select('*');
        $this->db->from('supplier');        
        $query = $this->db->get();
        return $query->result_array();

    }
    public function transfer($from_warehouse,$products_l,$to_warehouse)
    {    $updateArray = array();
        foreach($products_l as $row){


            $updateArray[] = array(
                'pid' => $row,
                'warehouse' => $to_warehouse
            );


        }

        if ($this->db->update_batch('products',$updateArray, 'pid')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

}