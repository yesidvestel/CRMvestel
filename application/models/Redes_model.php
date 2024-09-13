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

class Redes_model extends CI_Model
{

   	var $table = 'equipos';
    var $column_order = array(null, 'product_name', 'qty', 'product_code', 'title', 'product_price', null, 'mac', 'serial'); //set column field database for datatable orderable
    var $column_order_actas = array('id', 'fecha', 'almacen_origen', 'almacen_destino'); //set column field database for datatable orderable
    var $column_search = array('product_name', 'product_code','product_cat.title' ); //Establecer base de datos de campo de columna para la tabla de datos
    var $column_search_actas = array('id', 'fecha', 'almacen_origen', 'almacen_destino' ); //Establecer base de datos de campo de columna para la tabla de datos
	var $column_search_equi = array('id', 'codigo','proveedor','almacen','mac','serial','llegada','final','marca','asignado','estado','observacion');
	var $column_order_equi = array(null, 'id', 'codigo','mac','serial','estado','asignado','marca','null');
    var $order = array('pid' => 'desc'); // default order
    var $order_actas = array('teid' => 'desc'); // default order
	var $order_equi = array('id' => 'desc'); 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	public function vlansdos($sede)
    {
        $this->db->select('*');
        $this->db->from('vlans');
		$this->db->where('sede', $sede);
        $query = $this->db->get();
        return $query->result_array();
    }
	public function input_vlan($id,$almacen,$vlan,$olt,$bandeja,$puertolt,$detalle)
    {
        $data = array(
			'sede' => $almacen,
			'vlan' => $vlan,
			'olt' => $olt,
			'bandeja' => $bandeja,
			'puertolt' => $puertolt,
			'det_vlan' => $detalle,
        );

        $this->db->set($data);
		if ($id!=""){
			$this->db->where('idv', $id);
			$in=$this->db->update('vlans');
		}else{
			$in=$this->db->insert('vlans');
		}
        if ($in) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function input_nap($id,$almacen,$vlan,$nap,$puertos,$detalle,$cor1,$cor2)
    {
        $data = array(
			'sede' => $almacen,
			'idvlan' => $vlan,
			'nap' => $nap,
			'puertos' => $puertos,
			'dir_nap' => $detalle,
			'coor1' => $cor1,
			'coor2' => $cor2,
        );

        $this->db->set($data);
        $id_nap=null;
		if ($id!=""){
			$this->db->where('idn', $id);
			$in=$this->db->update('naps');
            $id_nap=$id;
		}else{
			$in=$this->db->insert('naps');
            $id_nap=$this->db->insert_id();
		}
        $var_i=intval($puertos);
        $data_consulta=array(
            'sede' => $almacen,
            'idvlan' => $vlan,
            'idnap' => $id_nap);

        for ($i=1; $i <= $var_i; $i++) { 
            $data_consulta['puerto']=$i;

            $puerto_x=$this->db->get_where("puertos",$data_consulta)->row();
            if(empty($puerto_x)){
                $data_x2=$data_consulta;
                $data_x2['estado']="Disponible";
                $data_x2['detalle']="Puerto ".$i;
                
                $this->db->insert('puertos',$data_x2);
            }
        }
        if ($in) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function input_puerto($id,$almacen,$vlan,$nap,$puerto,$estado,$detalle)
    {
        $data = array(
			'sede' => $almacen,
			'idvlan' => $vlan,
			'idnap' => $nap,
			'puerto' => $puerto,
			'estado' => $estado,
			'detalle' => $detalle,
        );

        $this->db->set($data);
		if ($id!=""){
			$this->db->where('idp', $id);
			$in=$this->db->update('puertos');
		}else{
			$in=$this->db->insert('puertos');
		}
        if ($in) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function almacenquery()
    {
        $query = $this->db->query("SELECT c.*,p.pc FROM almacen_equipos AS c LEFT JOIN ( SELECT almacen,COUNT(id) AS pc FROM equipos GROUP BY almacen) AS p ON c.id=p.almacen");
        return $query->result_array();
    }
	public function naplista($caja)
    {
        $this->db->select('*');
        $this->db->from('naps');
		$this->db->where('idvlan', $caja);
        $query = $this->db->get();
        return $query->result_array();
    }
	public function vlan_list($id)
    {
        $this->db->select('*');
        $this->db->from('vlans');
		$this->db->where('sede', $id);
        $query = $this->db->get();
        return $query->result();
    }
	public function vlan($sede)
    {
        $this->db->select('*');
        $this->db->from('vlans');
		$this->db->where('idv', $sede);
		$this->db->join('almacen_equipos', 'almacen_equipos.id = vlans.sede');
        $query = $this->db->get();
        return $query->row_array();
    }
	public function nap($sede)
    {
        $this->db->select('*');
        $this->db->from('naps');
		$this->db->where('idn', $sede);
		$this->db->join('almacen_equipos', 'almacen_equipos.id = naps.sede');
		$this->db->join('vlans', 'vlans.idv = naps.idvlan');
        $query = $this->db->get();
        return $query->row_array();
    }
	public function puertoinfo($sede)
    {
        $this->db->select('*');
        $this->db->from('puertos');
		$this->db->where('idp', $sede);
		$this->db->join('almacen_equipos', 'almacen_equipos.id = puertos.sede');
		$this->db->join('vlans', 'vlans.idv = puertos.idvlan');
		$this->db->join('naps', 'naps.idn = puertos.idnap');
        $query = $this->db->get();
        return $query->row_array();
    }
	public function nap_list($id)
    {
        $this->db->select('*');
        $this->db->from('naps');
		$this->db->where('idvlan', $id);
        $query = $this->db->get();
        return $query->result();
    }
	public function puertos_group($id)
    {
        $this->db->select('*');
        $this->db->from('puertos');
		$this->db->where('idnap', $id);
		$this->db->where('estado', 'Disponible');
        $query = $this->db->get();
        return $query->result();
    }
	public function puerto($id)
    {
        $this->db->select('*');
        $this->db->from('puertos');
		$this->db->where('idp', $id);
		$this->db->join('almacen_equipos', 'almacen_equipos.id = puertos.sede');
		$this->db->join('naps', 'naps.idn = puertos.idnap');
		$this->db->join('vlans', 'vlans.idv = puertos.idvlan');
        $query = $this->db->get();
        return $query->result();
    }
	public function nap_todas()
    {
		$sede = $this->aauth->get_user()->sede_accede;
        $sede =str_replace("-", "",$sede);
		$tdx=explode(",", $sede);
        $this->db->select('*');
        $this->db->from('naps');
		if($sede!=0 && $this->config->item('ctitle')=='VESTEL S.A.S'){
			if (in_array(3, $tdx)) {
				$almacen = 2; // Asignamos el almacén correspondiente
			}elseif (in_array(2, $tdx)) {
				$almacen = 4;
			}elseif (in_array(4, $tdx)) {
				$almacen = 5;
			}elseif (in_array(6, $tdx)) {
				$almacen = 7;
			}elseif (in_array(7, $tdx)) {
				$almacen = 8;
			}
			$this->db->or_where_in('sede', $almacen);
		}
        $query = $this->db->get();
        return $query->result_array();
    }
	public function puertos_list($sede)
    {
        $this->db->select('*');
        $this->db->from('puertos');
		$this->db->where('puertos.sede', $sede);
		$this->db->join('almacen_equipos', 'almacen_equipos.id = puertos.sede');
		$this->db->join('naps', 'naps.idn = puertos.idnap');
		$this->db->join('vlans', 'vlans.idv = puertos.idvlan');
		//$this->db->join('customers', 'customers.id = puertos.asignado');
        $query = $this->db->get();
        return $query->result_array();
    }
	public function puertolista($id=null)
    {
        $this->db->select('*');
        $this->db->from('puertos');
		if($id!=null){
			$this->db->where('idnap', $id);
			$this->db->join('naps', 'naps.idn = puertos.idnap');
		}
		
        $query = $this->db->get();
        return $query->result_array();
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
	
	public function vlans()
    {
        $this->db->select('*');
        $this->db->from($this->table2);
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->codigo;
        } else {
            return 1000;
        }
    }
	public function delete($id)
    {

        return $this->db->delete('puertos', array('idp' => $id));
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

    public function edit($pid, $catid, $warehouse, $sede, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc)
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
            'alert' => $product_qty_alert
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
		$data = array(
				'fecha' => date("Y-m-d H:i:s"),
				'almacen_origen' => $from_warehouse,
				'almacen_destino' => $to_warehouse,
				'observaciones' => $_POST['observaciones_acta'],
				'id_usuario_que_transfiere' => $this->aauth->get_user()->id,
				);
			$this->db->set($data);
			if ($this->db->insert("transfer_equipos",$data)){
			$idacta =  $this->db->insert_id();
			foreach ($products_l as $key => $value) {
				$this->db->set('almacen', $to_warehouse);
				$this->db->where('id', $value['id']);
				if ($this->db->update('equipos')){
						$datae = array(
							'id_transfer' => $idacta,
							'id_equipo' => $value['id'],
							);
						$this->db->set($datae);
						$this->db->insert("item_transfer_equipos",$datae);
					}
				}
			$data_h=array();
			$data_h['modulo']="Redes";
			$data_h['accion']="Transferencia equipos";
			$data_h['id_usuario']=$this->aauth->get_user()->id;
			$data_h['fecha']=date("Y-m-d H:i:s");
			$data_h['descripcion']="Se realiza transferencia de equipos ".json_encode($value);
			$data_h['id_fila']=$this->db->insert_id();
			$data_h['tabla']="transfer_equipos";
			$data_h['nombre_columna']="teid";
			$this->db->insert("historial_crm",$data_h);			
			
            echo json_encode(array('status'=>"success",'id_acta'=>$idacta));    
        }else{
            echo json_encode(array('status' => 'Error', 'message' =>$this->lang->line('ERROR')));    
        }
	}
	private function _get_datatables_query_actas()
    {
        $this->db->select("transfer_equipos.teid, transfer_equipos.fecha, alm_o.almacen as almacen_origen, alm_d.almacen as almacen_destino, emp1.username as username");
        $this->db->from("transfer_equipos");
        $i=0;
        $this->db->join("aauth_users as emp1","emp1.id=transfer_equipos.id_usuario_que_transfiere");
        $this->db->join("almacen_equipos as alm_o","alm_o.id=transfer_equipos.almacen_origen");
        $this->db->join("almacen_equipos as alm_d","alm_d.id=transfer_equipos.almacen_destino");
        /*if($this->aauth->get_user()->roleid<=2){
            $this->db->where("alm_d.id_tecnico='".$this->aauth->get_user()->username."'");
        }else if(isset($_GET['tecnico'])){

            $this->db->where("tr1.fecha>='".(new DateTime ($_GET['sdate']))->format("Y-m-d 00:00:01")."'");
            $this->db->where("tr1.fecha<='".(new DateTime ($_GET['edate']))->format("Y-m-d 23:59:59")."'");
            $this->db->where("alm_d.id_tecnico='".$_GET['tecnico']."'");
        }*/
        foreach ($this->column_search_actas as $item) // loop column
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

                if (count($this->column_search_actas) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order_actas[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order_actas)) {
            $order = $this->order_actas;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables_actas()
    {
        $this->_get_datatables_query_actas();
        $this->db->order_by("teid","desc");
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered_actas()
    {
        $this->_get_datatables_query_actas();
		
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all_actas()
    {
        $this->_get_datatables_query_actas();
		
        $query = $this->db->get();
        return $query->num_rows();
    }

}