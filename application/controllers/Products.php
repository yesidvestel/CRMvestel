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

class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('products_model', 'products');
		$this->load->model('equipos_model', 'equipos');
        $this->load->model('categories_model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid != 1 AND $this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

    }

    public function index()
    {
        $head['title'] = "Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/products');
        $this->load->view('fixed/footer');

    }
	public function equipos()
    {
        $head['title'] = "Equipos";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/equipos');
        $this->load->view('fixed/footer');

    }

    public function cat()
    {
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/cat_productlist');
        $this->load->view('fixed/footer');

    }


    public function add()
    {
        $this->load->model('customers_model', 'customers');
		$data['cat'] = $this->categories_model->category_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();
		$data['customergrouplist'] = $this->customers->group_list();
        $head['title'] = "Add Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-add', $data);
        $this->load->view('fixed/footer');
    }
	public function equipoadd()
    {
        $data['customer'] = $this->categories_model->customers_list();
		$data['codigo'] = $this->equipos->codigoequipo();
		$data['supplier'] = $this->categories_model->supplier_list();
        $data['almacen'] = $this->categories_model->almacen_list();
        $head['title'] = "Add Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/equipo-add', $data);
        $this->load->view('fixed/footer');
    }


    public function product_list()
    {
        $catid = $this->input->get('id');

        if ($catid > 0) {
            $list = $this->products->get_datatables($catid);
        } else {
            $list = $this->products->get_datatables();
        }
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->pid;
			$row[] = $pid;
            $row[] = $prd->product_name;
            $row[] = $prd->qty;
            $row[] = $prd->product_code;
            $row[] = $prd->title;
            $row[] = amountFormat($prd->product_price);
            $row[] = $prd->warehouse;
            $row[] = '<a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs  delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->products->count_all($catid),
            "recordsFiltered" => $this->products->count_filtered($catid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function equipos_list()
    {
        $alid = $this->input->get('id');
		if ($alid > 0){
        $list = $this->equipos->get_datatables($alid);
		} else {
		$list = $this->equipos->get_datatables();
		}
        $data = array();
        $no = $this->input->post('start');
		
        foreach ($list as $prd) {
			$usuario = $this->db->get_where('customers', array('id' => $prd->asignado))->row();
            $no++;
            $row = array();
            $row[] = $no;           	
			$row[] = $prd->codigo;
            $row[] = $prd->mac;
            $row[] = $prd->serial;
			$row[] = $prd->estado;
			if ($prd->asignado == 0){
            $row[]= 'Sin asignar';
			}else{ $row[] = $usuario->abonado;}
			$row[] = $prd->marca;
			$row[] = $prd->t_instalacion;
			if ($prd->vlan!=='0'){
			$row[] = $prd->vlan;
			}else{$row[]= 'N/A';}
			if ($prd->nat!=='0'){
			$row[] = $prd->nat;
			}else{$row[]= 'N/A';}
			if ($prd->puerto!=='0'){
			$row[] = $prd->puerto;
			}else{$row[]= 'N/A';}	
            $row[] = '<a href="' . base_url() . 'products/editequipoview?id=' . $prd->id . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $prd->id  . '" class="btn btn-danger btn-xs  delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }
		
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->equipos->count_all($alid),
            "recordsFiltered" => $this->equipos->count_filtered($alid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addproduct()
    {
        $product_name = $this->input->post('product_name');
        $catid = $this->input->post('product_cat');
        $warehouse = $this->input->post('product_warehouse');
        $product_code = $this->input->post('product_code');
		$sede = $this->input->post('sede');
        $product_price = $this->input->post('product_price');
        $factoryprice = $this->input->post('fproduct_price');
        $taxrate = $this->input->post('product_tax');
        $disrate = $this->input->post('product_disc');
        $product_qty = $this->input->post('product_qty');
        $product_qty_alert = $this->input->post('product_qty_alert');
        $product_desc = $this->input->post('product_desc');
        if ($catid) {
            $this->products->addnew($catid, $warehouse, $sede, $product_name, $product_code,  $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc);
        }


    }
	public function addequipo()
    {
        $codigo = $this->input->post('codigo');
        $proveedor = $this->input->post('proveedor');
        $almacen = $this->input->post('almacen');
        $mac = $this->input->post('mac');
        $serial = $this->input->post('serial');
        $llegada = $this->input->post('llegada');
        $final = $this->input->post('final');
        $marca = $this->input->post('marca');
        $asignado = $this->input->post('asignado');
        $estado = $this->input->post('estado');
        $observacion = $this->input->post('observacion');
		if ($codigo) {
        	$this->products->addequipo($codigo,$proveedor,$almacen,$mac,$serial,$llegada,$final,$marca,$asignado,$estado,$observacion);
		}


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $transferencia = $this->db->select("*")->from("transferencias")->where("producto_a=".$id." OR producto_b=".$id)->get()->result();
            $transferencia_ordenes = $this->db->select("*")->from("transferencia_products_orden")->where("products_pid=".$id)->get()->result();
            //var_dump($transferencia_ordenes);
            foreach ($transferencia as $key => $value) {
                $this->db->delete('transferencias', array('id_transferencia' => $value->id_transferencia));
                  
            }
            foreach ($transferencia_ordenes as $key => $value) {
                $this->db->delete('transferencia_products_orden', array('idtransferencia_products_orden' => $value->idtransferencia_products_orden));
                  
            }

            $this->db->delete('products', array('pid' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	public function delete_e()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('equipos', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function edit()
    {
        $this->load->model('customers_model', 'customers');
		$pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('pid', $pid);
        $query = $this->db->get();
        $data['product'] = $query->row_array();
		$prod = $this->db->get_where('products', array('pid' => $pid))->row();
		$sedep = $prod->sede;
        $data['cat_ware'] = $this->categories_model->cat_ware($pid);
		$data['customergrouplist'] = $this->customers->group_list();
		$data['sede'] = $this->products->sede_list($sedep);
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $data['cat'] = $this->categories_model->category_list();
        $head['title'] = "Edit Product";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-edit', $data);
        $this->load->view('fixed/footer');

    }
	public function editequipoview()
    {
        $pid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('equipos');
        $this->db->where('id', $pid);
        $query = $this->db->get();
        $data['equipos'] = $query->row_array();
		$data['cat_ware'] = $this->categories_model->pro_ware($pid);
        $data['supplier'] = $this->categories_model->supplier_list();
        $data['almacen'] = $this->categories_model->almacen_list();
		$data['alm_ware'] = $this->categories_model->alm_ware($pid);
        $data['customer'] = $this->categories_model->customers_list();
		$data['cus_ware'] = $this->categories_model->cus_ware($pid);
        $head['title'] = "Edit equipo";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/equipo-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editproduct()
    {
        $pid = $this->input->post('pid');
        $product_name = $this->input->post('product_name');
        $catid = $this->input->post('product_cat');
        $warehouse = $this->input->post('product_warehouse');
		$sede = $this->input->post('sede');
        $product_code = $this->input->post('product_code');
        $product_price = $this->input->post('product_price');
        $factoryprice = $this->input->post('fproduct_price');
        $taxrate = $this->input->post('product_tax');
        $disrate = $this->input->post('product_disc');
        $product_qty = $this->input->post('product_qty');
        $product_qty_alert = $this->input->post('product_qty_alert');
        $product_desc = $this->input->post('product_desc');
        if ($pid) {
            $this->products->edit($pid, $catid, $warehouse, $sede, $product_name, $product_code, $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc);
        }


    }
	public function editequipos()
    {
        $pid = $this->input->post('pid');
        $codigo = $this->input->post('codigo');
        $proveedor = $this->input->post('proveedor');
        $almacen = $this->input->post('almacen');
        $mac = $this->input->post('mac');
        $serial = $this->input->post('serial');
        $llegada = $this->input->post('llegada');
        $final = $this->input->post('final');
        $marca = $this->input->post('marca');
        $asignado = $this->input->post('asignado');
        $estado = $this->input->post('estado');
        $observacion = $this->input->post('observacion');
        if ($pid) {
            $this->products->editequipo($pid, $codigo, $proveedor, $almacen, $mac, $serial, $llegada, $final, $marca, $asignado, $estado, $observacion);
        }


    }


    public function warehouseproduct_list()
    {
        $catid = $this->input->get('id');


        $list = $this->products->get_datatables($catid, true);

        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->pid;
            $row[] = $prd->product_name;
            $row[] = $prd->qty;
            $row[] = $prd->product_code;
            $row[] = $prd->title;
            $row[] = amountFormat($prd->product_price);
            $row[] = '<a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs  delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->products->count_all($catid, true),
            "recordsFiltered" => $this->products->count_filtered($catid, true),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function almacenequipos_list()
    {
        $catid = $this->input->get('id');
        $list = $this->products->get_datatables2($catid, true);

        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
            $pid = $prd->pid;
            $row[] = $prd->mac;
            $row[] = $prd->qty;
            $row[] = $prd->product_code;
            $row[] = $prd->title;
            $row[] = amountFormat($prd->product_price);
            $row[] = '<a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs  delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->products->count_all($catid, true),
            "recordsFiltered" => $this->products->count_filtered($catid, true),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function prd_stats()
    {

        $this->products->prd_stats();


    }

    public function stock_transfer_products()
    {
        $wid = $this->input->get('wid');
        $result=$this->products->products_list($wid);
        
        echo json_encode($result);


    }

    public function stock_transfer()
    {
        if ($this->input->post()) {
            
            $this->products->transfer($_POST['from_warehouse'],$_POST['lista'],$_POST['to_warehouse']);

        } else {

            $data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->warehouse_list();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/stock_transfer', $data);
            $this->load->view('fixed/footer');
        }


    }


}