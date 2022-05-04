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

class Productcategory Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categories_model', 'products_cat');
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
        $data['cat'] = $this->products_cat->category_stock();
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category', $data);
        $this->load->view('fixed/footer');
    }

    public function warehouse()
    {
        $data['cat'] = $this->products_cat->warehouse();
        $head['title'] = "Product Warehouse";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse', $data);
        $this->load->view('fixed/footer');
    }
	public function almacen()
    {
        $data['cat'] = $this->products_cat->almacenquery();
        $head['title'] = "Product Warehouse";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/almacen', $data);
        $this->load->view('fixed/footer');
    }


    public function view()
    {
        $data['cat'] = $this->products_cat->category_stock();
        $head['title'] = "View Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_view', $data);
        $this->load->view('fixed/footer');
    }

    public function viewwarehouse()
    {
        $data['cat'] = $this->products_cat->warehouse();
        $data['categoria'] = $this->products_cat->category_list();
        $head['title'] = "View Product Warehouse";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/warehouse_view', $data);
        $this->load->view('fixed/footer');
    }
	public function explortar_a_excel(){
        
        $this->db->select("*");
        $this->db->from("products");
		$this->db->join('product_cat', 'products.pcat=product_cat.id', 'left');
		//$this->db->join('barrio', 'customers.barrio=barrio.idBarrio', 'left');
        $this->db->order_by("pid","DESC");
		//$usuario=$this->db->get_where("customers",array('id' => $_GET['id']))->row();
		$this->db->where("warehouse",$_GET['id']);
		
        $lista_products=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_products2=array();
		
    
    //define column headers
    $headers = array(
		'Item' => 'string',
        'Codigo' => 'string', 
        'Categoria' => 'string', 
        'cantidad' => 'string');
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte Tickets ');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte Inventarios ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Inventarios ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
));
    
    //write rows to sheet1
	
    foreach ($lista_products as $key => $productos) {
            $writer->writeSheetRow('Inventarios ',array(
				$productos->product_name,
				$productos->product_code,
				$productos->title,
				$productos->qty));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Inventario '.$fecha_actual.'.xlsx';
    
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
	public function viewalmacen()
    {
		$this->load->model('ticket_model', 'ticket');
        $data['cat'] = $this->products_cat->warehouse();
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
        $head['title'] = "Vista Productos Almacen";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/almacen_vista', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $data['cat'] = $this->products_cat->category_list();
        $head['title'] = "Add Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/category_add', $data);
        $this->load->view('fixed/footer');
    }
	public function addalmacen()
    {
        $data['cat'] = $this->products_cat->category_list();
        $head['title'] = "Nuevo almacen de equipos";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/almacen_add', $data);
        $this->load->view('fixed/footer');
    }

    public function addwarehouse()
    {
        if ($this->input->post()) {
            $cat_name = $this->input->post('product_catname');
            $cat_desc = $this->input->post('product_catdesc');
            $tecnico = $this->input->post('id_del_tecnico');
            if ($cat_name) {
                $this->products_cat->addwarehouse($cat_name, $cat_desc, $tecnico);
            }
        } else {

            $data['cat'] = $this->products_cat->category_list();
            $data['lista_de_tecnicos']=$this->db->get_where('aauth_users',array("roleid">5))->result_array();

            $head['title'] = "Add Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/warehouse_add', $data);
            $this->load->view('fixed/footer');
        }
    }
	

    public function addcat()
    {
        $cat_name = $this->input->post('product_catname');
        $cat_desc = $this->input->post('product_catdesc');

        if ($cat_name) {
            $this->products_cat->addnew($cat_name, $cat_desc);
        }
    }
	 public function addalmacenequipo()
    {
        $cat_name = $this->input->post('almacen_name');
        $cat_desc = $this->input->post('almacen_desc');

        if ($cat_name) {
            $this->products_cat->addalequipo($cat_name, $cat_desc);
        }
    }
	

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('products', array('pcat' => $id));
            $data2=array();
            $data2['modulo']="Inventarios";
            $data2['accion']="Eliminacion de material en categoria de materiales {delete}";
            $data2['id_usuario']=$this->aauth->get_user()->id;
            $data2['fecha']=date("Y-m-d H:i:s");
            $data2['descripcion']="Todos los productos donde pcat=".$id;
            $data2['tabla']="products";
            $data2['nombre_columna']="pcat";
            $data2['id_fila']=$id;
            $this->db->insert("historial_crm",$data2);
            
            $this->db->delete('product_cat', array('id' => $id));

            $data2=array();
            $data2['modulo']="Inventarios";
            $data2['accion']="Eliminacion de material en categoria de materiales {delete}";
            $data2['id_usuario']=$this->aauth->get_user()->id;
            $data2['fecha']=date("Y-m-d H:i:s");
            $data2['descripcion']="Eliminacion de la Categoria";
            $data2['tabla']="product_cat";
            $data2['id_fila']=$id;
            $data2['nombre_columna']="id";
            $this->db->insert("historial_crm",$data2);

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	public function delete_a()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('equipos', array('almacen' => $id));
            $this->db->delete('almacen_equipos', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Category with products')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function delete_warehouse()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('products', array('pcat' => $id));

            $data_h=array();
            $data_h['modulo']="Inventarios";
            $data_h['accion']="Eliminacion de Almacen {delete}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']="Todos los productos donde pcat=".$id;
            $data_h['tabla']="products";
            $data_h['nombre_columna']="pcat";
            $data_h['id_fila']=$id;
            $this->db->insert("historial_crm",$data_h);

            $this->db->delete('product_warehouse', array('id' => $id));

            $data_h=array();
            $data_h['modulo']="Inventarios";
            $data_h['accion']="Eliminacion de Almacen {delete}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']="Eliminacion de product_warehouse";
            $data_h['tabla']="product_warehouse";
            $data_h['id_fila']=$id;
            $data_h['nombre_columna']="id";
            $this->db->insert("historial_crm",$data_h);

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Product Warehouse with products')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

//view for edit
    public function edit()
    {
        $catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('product_cat');
        $this->db->where('id', $catid);
        $query = $this->db->get();
        $data['productcat'] = $query->row_array();

        $head['title'] = "Edit Product Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/product-cat-edit', $data);
        $this->load->view('fixed/footer');

    }
	public function editalmacenvista()
    {
        $catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('almacen_equipos');
        $this->db->where('id', $catid);
        $query = $this->db->get();
        $data['almacenes'] = $query->row_array();
        $head['title'] = "Edit almacen";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('products/almacen_edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editwarehouse()
    {
        if ($this->input->post()) {
            $cid = $this->input->post('catid');
            $cat_name = $this->input->post('product_cat_name');
            $cat_desc = $this->input->post('product_cat_desc');
            $id_del_tecnico = $this->input->post('id_del_tecnico');
            if ($cat_name) {
                $this->products_cat->editwarehouse($cid, $cat_name, $cat_desc,$id_del_tecnico);
            }
        } else {
            $catid = $this->input->get('id');
            $this->db->select('*');
            $this->db->from('product_warehouse');
            $this->db->where('id', $catid);
            $query = $this->db->get();
            $data['warehouse'] = $query->row_array();

            $head['title'] = "Edit Product Warehouse";
            $head['usernm'] = $this->aauth->get_user()->username;
            
            $data['lista_de_tecnicos']=$this->db->get_where('aauth_users',array("roleid"=>3))->result_array();
            $this->load->view('fixed/header', $head);
            $this->load->view('products/product-warehouse-edit', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function editcat()
    {
        $cid = $this->input->post('catid');
        $product_cat_name = $this->input->post('product_cat_name');

        $product_cat_desc = $this->input->post('product_cat_desc');
        if ($cid) {
            $this->products_cat->edit($cid, $product_cat_name, $product_cat_desc);
        }
    }
	public function editalmacenes()
    {
        $cid = $this->input->post('catid');
        $almacen = $this->input->post('almacen');
        $descripcion = $this->input->post('descripcion');
        if ($cid) {
            $this->products_cat->editalmacen($cid, $almacen, $descripcion);
        }
    }


}