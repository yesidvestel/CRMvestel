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

class Products_model extends CI_Model
{

    var $table = 'products';
	var $table2 = 'equipos';
    var $column_order = array(null, 'product_name', 'qty', 'product_code', 'title', 'product_price', null, 'mac', 'serial'); //set column field database for datatable orderable
    var $column_search = array('product_name', 'product_code','product_cat.title' ); //Establecer base de datos de campo de columna para la tabla de datos
	var $column_search_equi = array('id', 'codigo','proveedor','almacen','mac','serial','llegada','final','marca','asignado','estado','observacion');
	var $column_order_equi = array(null, 'id', 'codigo','mac','serial','estado','asignado','marca','null');
    var $order = array('pid' => 'desc'); // default order
	var $order_equi = array('id' => 'desc'); 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
		
        //if ($w) {
			$this->db->select('products.*,product_warehouse.*,product_cat.*, product_cat.title AS cate');
            $this->db->from($this->table);
            $this->db->join('product_warehouse', 'product_warehouse.id = products.warehouse');
			$this->db->join('product_cat', 'product_cat.id = products.pcat');
            //if ($id > 0) {
		
			if($_GET['categoria']!="" && $_GET['categoria']!=null && $_GET['categoria']!="null"){
            $this->db->where('pcat' , $_GET['categoria']);       
        	}
                $this->db->where("product_warehouse.id = ".$_GET['id']);
            //}
			
       /* } else {
			//$this->db->select('products.*,product_warehouse.*,product_cat.*, product_cat.title AS cate');
            $this->db->from($this->table);
            $this->db->join('product_cat', 'product_cat.id = products.pcat');
            if ($id > 0) {
                $this->db->where("product_cat.id = $id");
            } 
        }*/
		
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

    function get_datatables()
    {
	 
        
		$this->_get_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
	function equi_get_datatables($id = '', $w = '')
    {
        if ($id > 0) {
            $this->equi_get_datatables_query($id, $w);
        } else {
            $this->equi_get_datatables_query();
        }
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
	 private function equi_get_datatables_query($id = '', $w = '')
    {
        if ($w) {
            $this->db->from($this->table2);
            $this->db->join('almacen_equipos', 'almacen_equipos.id = equipos.almacen');
            if ($id > 0) {
                $this->db->where("almacen_equipos.id = $id");
            }
        }
        $i = 0;
        foreach ($this->column_search_equi as $item) // loop column 
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

                if (count($this->column_search_equi) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order_equi[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order_equi)) {
            $order = $this->order_equi;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
	public function codigoequipo()
    {
        $this->db->select('codigo');
        $this->db->from($this->table2);
        $this->db->order_by('codigo', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->codigo;
        } else {
            return 1000;
        }
    }

    function count_filtered()
    {
        
		$this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
	

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
	

    public function addnew($catid, $warehouse, $sede, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc,$valores_servicio,$tipo_servicio,$servicio_pertenece_a)
    {
        $data = array(
            'pcat' => $catid,
            'warehouse' => $warehouse,
			'sede' => $sede,
            'product_name' => $product_name,
            'product_code' => $product_code,
            'product_price' => $product_price,
            'fproduct_price' => $factoryprice,
            'taxrate' => $taxrate,
            'disrate' => $disrate,
            'qty' => $product_qty,
            'product_des' => $product_desc,
            'tipo_servicio' => $tipo_servicio,
            'valores' => $valores_servicio,
            'pertence_a_tv_o_net' => $servicio_pertenece_a
        );

        if ($this->db->insert('products', $data)) {
            $data2=array();
            $data2['modulo']="Inventarios";
            $data2['accion']="Ingreso de material {insert}";
            $data2['id_usuario']=$this->aauth->get_user()->id;
            $data2['fecha']=date("Y-m-d H:i:s");
            $data2['descripcion']=json_encode($data);
            $data2['id_fila']=$this->db->insert_id();
            $data2['tabla']="products";
            $this->db->insert("historial_crm",$data2);
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
                    $data_h=array();
                    $data_h['modulo']="Redes";
                    $data_h['accion']="Ingreso de equipo {insert}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode($data);
                    $data_h['id_fila']=$this->db->insert_id();
                    $data_h['tabla']="equipos";
                    $data_h['nombre_columna']="id";
                    $this->db->insert("historial_crm",$data_h);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($pid, $catid, $warehouse, $sede, $product_name, $product_code,  $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc,$valores_servicio,$tipo_servicio,$servicio_pertenece_a)
    {
        $data = array(
            'pcat' => $catid,
            'warehouse' => $warehouse,
			'sede' => $sede,
            'product_name' => $product_name,
            'product_code' => $product_code,
            'product_price' => $product_price,
            'fproduct_price' => $factoryprice,
            'taxrate' => $taxrate,
            'disrate' => $disrate,
            'qty' => $product_qty,
            'product_des' => $product_desc,
            'alert' => $product_qty_alert,
			'tipo_servicio' => $tipo_servicio,
            'valores' => $valores_servicio,
            'pertence_a_tv_o_net' => $servicio_pertenece_a
        );


        $this->db->set($data);
        $this->db->where('pid', $pid);

        if ($this->db->update('products')) {

            $data_h=array();
            $data_h['modulo']="Inventarios";
            $data_h['accion']="Editar producto {update}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode($data);
            $data_h['id_fila']=$pid;
            $data_h['tabla']="products";
            $data_h['nombre_columna']="pid";
            
            $this->db->insert("historial_crm",$data_h);
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
	public function editequipo($pid, $codigo, $proveedor, $almacen, $mac, $serial, $llegada, $final, $marca, $asignado, $estado, $observacion)
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


        $this->db->set($data);
        $this->db->where('id', $pid);

        if ($this->db->update('equipos')) {
                    $data_h=array();
                    $data_h['modulo']="Redes";
                    $data_h['accion']="Administrar Equipos > Editar Equipo {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode($data);
                    $data_h['id_fila']=$pid;
                    $data_h['tabla']="equipos";
                    $data_h['nombre_columna']="id";
                    $this->db->insert("historial_crm",$data_h);
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
	public function sede_list($sedep)
    {
        $this->db->select('*');
        $this->db->from('customers_group');
        $this->db->where('id', $sedep);
        $query = $this->db->get();
        return $query->row_array();

    }
	public function proveedor_list($id)
    {
        $this->db->select('*');
        $this->db->from('supplier');        
        $query = $this->db->get();
        return $query->result_array();

    }
    public function transfer($from_warehouse,$products_l,$to_warehouse)
    {   
        foreach ($products_l as $key => $value) {
            $producto = $this->db->get_where('products',array("pid"=>$value['pid']))->row();
            if($value['qty']>0){
                $qty_nuevo_pt=intval($value['qty']);//cantidad que se quiere transferir
                $qty_viejo_pt=intval($producto->qty);//cantidad que hay en existencia
                $qty_viejo_pt=$qty_viejo_pt-$qty_nuevo_pt;//cantidad que quedara al transferir las unidades
                //trabajando sobre el producto transferido

            $transferencia_creada=$this->db->select('transferencias.id_transferencia,transferencias.producto_a,transferencias.producto_b,rel_a.warehouse as almacen_a,rel_b.warehouse as almacen_b')->from('transferencias')->join('products as rel_a','rel_a.pid=transferencias.producto_a')->join('products as rel_b','rel_b.pid=transferencias.producto_b')->where('(rel_a.pid='.$value["pid"].' or rel_b.pid='.$value["pid"].') and (rel_a.warehouse='.$to_warehouse.' or rel_b.warehouse='.$to_warehouse.')')->get()->result();
            
            if(!empty($transferencia_creada)){
                $id_a_transferir;
                if($value['pid']==$transferencia_creada[0]->producto_a){
                    $id_a_transferir=$transferencia_creada[0]->producto_b;                    
                }else{
                    $id_a_transferir=$transferencia_creada[0]->producto_a;
                }
                $producto_b=$this->db->get_where('products',array('pid'=>$id_a_transferir))->row();
                $transferido_a=$producto_b->pid;
                $datay['qty']=$qty_nuevo_pt+intval($producto_b->qty);
                $this->db->update('products',$datay,array("pid"=>$id_a_transferir));

                    $data_h=array();
                    $data_h['modulo']="Inventarios";
                    $data_h['accion']="Transferencia de acciones {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode($datay);
                    $data_h['id_fila']=$id_a_transferir;
                    $data_h['tabla']="products";
                    $data_h['nombre_columna']="pid";
                    $this->db->insert("historial_crm",$data_h);

            }else{

                $producto_por_nombre = $this->db->get_where('products',array('product_name'=>$producto->product_name,'warehouse'=>$to_warehouse))->row();

                    $proximo_pid=$this->db->select('max(pid)+1 as pid')->from('products')->get()->result();
                    $value['warehouse']=$to_warehouse;
                    $value['pid']=null;
                    //aqui es donde tengo que verificar por el nombre like y por el almacen claro esta al que se le transfiere el producto
                    // si existe el primero en coincidir crea la relacion y la transferencia
                    
                    $data_transfer['producto_a']=$producto->pid;
                    $data_transfer['producto_b']=$proximo_pid[0]->pid;
                    
                    if(!empty($producto_por_nombre)){
                        $data_transfer['producto_b']=$producto_por_nombre->pid;
                        if($producto_por_nombre->qty<0){
                            $producto_por_nombre->qty=0;
                        }
                        $datay['qty']=$qty_nuevo_pt+intval($producto_por_nombre->qty);
                        
                        $this->db->update('products',$datay,array("pid"=>$producto_por_nombre->pid));
                                $data_h=array();
                                $data_h['modulo']="Inventarios";
                                $data_h['accion']="Transferencia de acciones {update}";
                                $data_h['id_usuario']=$this->aauth->get_user()->id;
                                $data_h['fecha']=date("Y-m-d H:i:s");
                                $data_h['descripcion']=json_encode($datay);
                                $data_h['id_fila']=$producto_por_nombre->pid;
                                $data_h['tabla']="products";
                                $data_h['nombre_columna']="pid";
                                $this->db->insert("historial_crm",$data_h);
                    }else{
                        $this->db->insert('products',$value);  

                            $data_h=array();
                            $data_h['modulo']="Inventarios";
                            $data_h['accion']="Transferencia de acciones {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($value);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="products";
                            $data_h['nombre_columna']="pid";
                            $this->db->insert("historial_crm",$data_h);  
                    }
                    
                    $transferido_a=$data_transfer['producto_b'];

                    $this->db->insert('transferencias',$data_transfer);

                            $data_h=array();
                            $data_h['modulo']="Inventarios";
                            $data_h['accion']="Transferencia de acciones {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data_transfer);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="transferencias";
                            $data_h['nombre_columna']="id_transferencia";
                            $this->db->insert("historial_crm",$data_h); 
            }
            //trabajando sobre el producto a transferir
            $datax['qty']=$qty_viejo_pt;
            $this->db->update('products',$datax,array('pid'=>$producto->pid));

                $data_h=array();
                $data_h['modulo']="Inventarios";
                $data_h['accion']="Transferencia de acciones {update}";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=json_encode($datax);
                $data_h['id_fila']=$producto->pid;
                $data_h['tabla']="products";
                $data_h['nombre_columna']="pid";
                $this->db->insert("historial_crm",$data_h);

            }
        }
        echo json_encode(array('status'=>"success",'transferido_a'=>$transferido_a));
    }

}