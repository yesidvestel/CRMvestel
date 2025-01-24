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

class Redes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('redes_model', 'redes');
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
		$sede = $this->input->get('id');
		$data['vlan2'] = $this->redes->vlansdos($sede);
        $head['title'] = "Distribuciones";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/distribucion',$data);
        $this->load->view('fixed/footer');
		//var_dump($data['vlan2']);

    }
	public function vlanadd()
    {
		$this->load->model('categories_model');
		$sede = $this->input->get('id');
		$data['almacen'] = $this->categories_model->almacen_list();
        $head['title'] = "Agregar vlan";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/vlan-add',$data);
        $this->load->view('fixed/footer');
		//var_dump($data['vlan2']);

    }
	public function vlanedit()
    {
		$this->load->model('categories_model');
		$sede = $this->input->get('id');
		$data['info'] = $this->redes->vlan($sede);
		$data['almacen'] = $this->categories_model->almacen_list();
        $head['title'] = "Editar vlan";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/vlan-edit',$data);
        $this->load->view('fixed/footer');

    }
	public function vlan_input()
    {
        	
            $id = $this->input->post('id');
            $almacen = $this->input->post('almacen');
            $vlan = $this->input->post('vlan');
            $detalle = $this->input->post('detalle');
            $olt = $this->input->post('olt');
            $bandeja = $this->input->post('bandeja');
            $puertolt = $this->input->post('puertolt');
            $this->redes->input_vlan($id,$almacen,$vlan,$olt,$bandeja,$puertolt,$detalle);

    }
	public function napadd()
    {
		$this->load->model('categories_model');
		$sede = $this->input->get('id');
		$data['almacen'] = $this->categories_model->almacen_list();
        $head['title'] = "Agregar Nap";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/nap-add',$data);
        $this->load->view('fixed/footer');
		//var_dump($data['vlan2']);

    }
	public function napedit()
    {
		$this->load->model('categories_model');
		$sede = $this->input->get('id');
		$data['info'] = $this->redes->nap($sede);
		$data['almacen'] = $this->categories_model->almacen_list();
        $head['title'] = "Editar Nap";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/nap-edit',$data);
        $this->load->view('fixed/footer');
		//var_dump($data['vlan2']);

    }
	public function vlan_list()
	{ 
		$id = $this->input->post('id');
		$vlans = $this->redes->vlan_list($id);
		//echo '<select  id="cmbCiudades"  class="selectpicker form-control"><option>Seleccionar</option>';
		$lista_opciones="<option value=''>Seleccionar</option>";
		foreach ($vlans as $row) {
			$lista_opciones.= '<option value="' . $row->idv . '">' . $row->vlan . '</option>';
			
		}
		
		echo $lista_opciones; 
	}
	public function puertos_list()
	{ 
		$id = $this->input->post('idn');
		var_dump($id);
		$vlans = $this->redes->puertos_group($id);
		//echo '<select  id="cmbCiudades"  class="selectpicker form-control"><option>Seleccionar</option>';
		$lista_opciones="<option value=''>Seleccionar</option>";
		foreach ($vlans as $row) {
			$lista_opciones.= '<option value="' . $row->idp . '">' . $row->puerto . '</option>';
			
		}
		
		echo $lista_opciones; 
	}
	public function nap_input()
    {
        
            $id = $this->input->post('id');
            $almacen = $this->input->post('almacen');
            $vlan = $this->input->post('vlan');
            $nap = $this->input->post('nap');
            $puertos = $this->input->post('puertos');
            $detalle = $this->input->post('detalle');
            $cor1 = $this->input->post('cor1');
            $cor2 = $this->input->post('cor2');
            $this->redes->input_nap($id,$almacen,$vlan,$nap,$puertos,$detalle,$cor1,$cor2);

    }
	public function puertosadd()
    {
		$this->load->model('categories_model');
		$sede = $this->input->get('id');
		$data['almacen'] = $this->categories_model->almacen_list();
        $head['title'] = "Agregar Puerto";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/puertos-add',$data);
        $this->load->view('fixed/footer');
		//var_dump($data['vlan2']);

    }
	public function puertosedit()
    {
		$this->load->model('categories_model');
		$sede = $this->input->get('id');
		$vlans = $this->redes->puerto($id);
		$data['info'] = $this->redes->puertoinfo($sede);
		$data['almacen'] = $this->categories_model->almacen_list();
        $head['title'] = "Puerto add";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/puertos-edit',$data);
        $this->load->view('fixed/footer');
		//var_dump($data['vlan2']);

    }
	public function nap_list()
	{ 
		$id = $this->input->post('idv');
		$vlans = $this->redes->nap_list($id);
		//echo '<select  id="cmbCiudades"  class="selectpicker form-control"><option>Seleccionar</option>';
		$lista_opciones="<option value=''>Seleccionar</option>";
		foreach ($vlans as $row) {
			$lista_opciones.= '<option value="' . $row->idn . '">' . $row->nap . '</option>';
			
		}
		
		echo $lista_opciones; 
	}
	public function puerto_input()
    {
        
            $id = $this->input->post('id');
            $almacen = $this->input->post('almacen');
            $vlan = $this->input->post('vlan');
            $nap = $this->input->post('nap');
            $puerto = $this->input->post('puerto');
            $estado = $this->input->post('estado');
            $detalle = $this->input->post('detalle');
            $this->redes->input_puerto($id,$almacen,$vlan,$nap,$puerto,$estado,$detalle);

    }
	public function conexionlist()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->redes->almacenquery();
        $head['title'] = 'Lista conexiones';
        $this->load->view('fixed/header');
        $this->load->view('redes/olts',$data);
        $this->load->view('fixed/footer');
    }
	public function conexionview()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
		$sede = $this->input->get('id');
        $data['puertos'] = $this->redes->puertos_list($sede);
        $head['title'] = 'Lista conexiones';
        $this->load->view('fixed/header');
        $this->load->view('redes/conexionlist',$data);
        $this->load->view('fixed/footer');
    }
	 public function sedes()
    {
		$data['cat'] = $this->redes->almacenquery();
        $head['title'] = "Distribuciones";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/lugar', $data);
        $this->load->view('fixed/footer');
		//var_dump($data['vlan2']);

    }
	
	public function cajasnap()
    {
		
        $vlan_orig = $this->db->get_where("vlans",array("idv"=>$this->input->get('id')))->row();
        $almacen_obj = $this->db->get_where("almacen_equipos",array("id"=>$vlan_orig->sede))->row();
        $caja = $this->input->get('id');
        $data['vlan']=$vlan_orig->vlan;
        $nap=$this->db->get_where("naps",array("idvlan"=>$caja))->row();
        $data['almacen']=$almacen_obj->almacen;
		$data['naps'] = $this->redes->naplista($caja);
		$data['puertos'] = $this->redes->puertolista($nap->idn);
		$arrayx=array();
		foreach ($data['puertos'] as $key => $value) {
			$arrayx[$value['puerto']]=$value['nat'];		
		}
		$data['comprobacion']=$arrayx;
		//var_dump($data['comprobacion']);
        $head['title'] = "Cajas NAP";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('redes/naps', $data);
        $this->load->view('fixed/footer');
		//var_dump($data['puertos']);
    }
	public function get_puertos_html(){
		$id_nat=$_POST['nat'];
        $id_equipo=$_POST['id_equipo'];
        $equipo_obj=$this->db->get_where("equipos",array("id"=>$id_equipo))->row();
		$nap=$this->db->get_where("naps",array("idn"=>$id_nat))->row();
		$puertos = $this->redes->puertolista($id_nat);
		$return="";
		$arrayx=array();
		foreach ($puertos as $key => $value) {
			//$arrayx[$value['puerto']]=$value['nap'];		
            $arrayx[$value['puerto']]=$value;        
		}
		for ($i=1;$i<=$nap->puertos;$i++){
			
			$color="teal";
            $user = "";
            $ids = "";    
			if (isset($arrayx[$i])){ 
				
                $usuario=$this->db->get_where("customers",array("id"=>$arrayx[$i]['asignado']))->row();
                if(isset($usuario)){
                    $user = $usuario->abonado;
                    $ids = $usuario->id;    
                    $color= 'pink';
                }
				
			}else{ 
				$color ='teal';
				$user = '';
			}
			/*$return.='<td>
									<i class="icon-circle contenedor font-large-1">
									<h5 style="position: absolute" class="centrado2">a</h5></i>
								</td>';*/
            if (isset($arrayx[$i])){ 
			     $return.='<td><i class="icon-circle contenedor '.$color.' font-large-1"><h5 style="position: absolute" class="centrado2">'.$i.'</h5></i><div style="text-align:center;"><a href="'.base_url("customers/view?id=".$ids).'"  style="text-align: center;font-size: 10px">'.$user.'</a></div></td>';
            }
		}
		$array_datos=array();
        $array_datos['datos']=$return;
        $array_datos['coor1']=$nap->coor1;
        $array_datos['coor2']=$nap->coor2;
		echo json_encode($array_datos);
		
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
			if ($prd->asignado > 0 ){
            $row[]= $usuario->abonado;
			}else{ $row[] = $prd->asignado;}
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
			if(empty($prd->imagen)){
                $row[]="Sin Img.";
            }else{
                $row[] = '<img class="cl-imagen_equipo" data-codigo="'.$prd->codigo.'" style="cursor:pointer" src="'.base_url().'userfiles/support/'.$prd->imagen.'" width="50px;">';              
            }
            $row[] = '<a href="' . base_url() . 'products/editequipoview?id=' . $prd->id . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> 
					  <a href="#" data-object-id="' . $prd->id  . '" class="btn btn-danger btn-xs  delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>
					  <a href="#" data-object-id2="' . $prd->id  . '" class="btn btn-warning clasignar"><span class="icon-arrow-up"></span> ' . $this->lang->line('') . 'Asignar</a>';
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
        $valores_servicio = $this->input->post('valores_servicio');
        $tipo_servicio = $this->input->post('tipo_servicio');
        $servicio_pertenece_a = $this->input->post('servicio_pertenece_a');
        if ($catid) {
            $this->products->addnew($catid, $warehouse, $sede, $product_name, $product_code,  $product_price, $factoryprice, $taxrate, $disrate, $product_qty,$product_qty_alert,$product_desc,$valores_servicio,$tipo_servicio,$servicio_pertenece_a);
        }


    }
	public function addequipo()
    {ini_set('memory_limit', '500M');
            set_time_limit(200000);
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
            $codigo_equipo=$codigo;
            $attach = $_FILES['equipofile']['name'];

           
             if ($attach) {
                $config['upload_path'] = './userfiles/support';
                $config['allowed_types'] = 'png|jpg|jpeg|gif';
                $config['max_size'] = 900000;
                $extencion=explode(".", $attach);
                $config['file_name'] = "imagen_equipo_".$codigo_equipo.".".$extencion[1];
                
              
    
                
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('equipofile')) {
                        
                        $data['response'] = 0;
                        $data['responsetext'] = 'File Upload Error 2';

                    } else {
                        $data['response'] = 1;
                        $data['responsetext'] = 'Reply Added Successfully.';
                        $filename = $this->upload->data()['file_name'];
                        $this->equipos->editar_imagen_equipo($codigo_equipo,$filename);
                        
                    }
                
             }
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
                       $data_h=array();
                        $data_h['modulo']="Inventarios";
                        $data_h['accion']="Eliminacion de productos en lista de almacenes {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode($value);
                        $data_h['tabla']="transferencias";
                        $data_h['nombre_columna']="id_transferencia";
                        $data_h['id_fila']=$value->id_transferencia;
                        $this->db->insert("historial_crm",$data_h);
            }
            foreach ($transferencia_ordenes as $key => $value) {
                $this->db->delete('transferencia_products_orden', array('idtransferencia_products_orden' => $value->idtransferencia_products_orden));
                  
                        $data_h=array();
                        $data_h['modulo']="Inventarios";
                        $data_h['accion']="Eliminacion de productos en lista de almacenes {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode($value);
                        $data_h['tabla']="transferencia_products_orden";
                        $data_h['nombre_columna']="idtransferencia_products_orden";
                        $data_h['id_fila']=$value->idtransferencia_products_orden;
                        $this->db->insert("historial_crm",$data_h);
            }

            $this->db->delete('products', array('pid' => $id));

                        $data_h=array();
                        $data_h['modulo']="Inventarios";
                        $data_h['accion']="Eliminacion de productos en lista de almacenes {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']="Eliminacion del producto {delete}";
                        $data_h['tabla']="products";
                        $data_h['nombre_columna']="pid";
                        $data_h['id_fila']=$id;
                        $this->db->insert("historial_crm",$data_h);
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

                      $data_h=array();
                        $data_h['modulo']="Redes";
                        $data_h['accion']="Administrar Equipos > Borrar {delete}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']="Eliminacion";
                        $data_h['tabla']="equipos";
                        $data_h['nombre_columna']="id";
                        $data_h['id_fila']=$id;
                        $this->db->insert("historial_crm",$data_h);
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	public function asigna_e()
    {
		
		
        $id = $this->input->post('deleteid');
        $tecnico = $this->input->post('tecnico');		
        if (isset($id) && $id!=null && $id!="null") {
				
			$equipo=$this->db->get_where("equipos",array('id' =>$id))->row();
			$almacen=$this->db->get_where("product_warehouse",array('id_tecnico' =>$tecnico))->row();	
            $data2 = array(					
				'pcat' => 3,
				'warehouse' => $almacen->id,
				'product_name' => $equipo->mac,
				'product_code' => $equipo->codigo,
				'qty' => 1,
				'alert' => 0
			);
			if ($this->db->insert('products', $data2)){
				//agregar par de tickets
				$this->db->set('asignado', $almacen->id_tecnico);		
				$this->db->where('id', $equipo->id);
				$this->db->update('equipos');
			}
            echo json_encode(array('status' => 'Success', 'message' => 'ASIGNADO'));
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
	public function delete_p()
    {
        $id = $this->input->post('deleteid');

        if ($this->redes->delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function warehouseproduct_list()
    {
        $catid = $this->input->get('id');
        $list = $this->products->get_datatables();
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
            $row[] = $prd->cate;
            $row[] = amountFormat($prd->product_price);
            $row[] = '<a href="' . base_url() . 'products/edit?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs  delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->products->count_all(),
            "recordsFiltered" => $this->products->count_filtered(),
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

    public function stock_transfer()
    {
        if ($this->input->post()) {
            
            $this->redes->transfer($_POST['from_warehouse'],$_POST['lista'],$_POST['to_warehouse']);

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
	public function stock_transfer_products()
    {
		
		$this->load->model('products_model', 'products');
        $wid = $this->input->get('wid');
        $result=$this->products->products_alm_list($wid);
        
        echo json_encode($result);


    }
	public function equip_transfer()
    {
        /*if ($this->input->post()) {
            
            $this->products->transfer($_POST['from_warehouse'],$_POST['lista'],$_POST['to_warehouse']);

        } else {*/

            //$data['cat'] = $this->categories_model->category_list();
            $data['warehouse'] = $this->categories_model->almacen_list();
            $head['title'] = "Stock Transfer";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('redes/equip_transfer', $data);
            $this->load->view('fixed/footer');
        //}


    }
	public function transferencias()
	{
        $head=array("title"=>"Administrar Actas de Transferencias");
        $this->load->view('fixed/header',$head);
        //$data['lista_tecnicos']=$this->db->get_where("employee_profile")->result_array();

        $this->load->view('redes/list_transfer');
        $this->load->view('fixed/footer');
    }
	public function actas_list(){
        
        $list = $this->redes->get_datatables_actas();
        $data = array();
        $no = $this->input->post('start');
        //setlocale(LC_TIME, "spanish");

        foreach ($list as $key => $value) {            
                $no++;  
                $row = array();
                $row[]="Acta#".$value->teid;
               // $x=new DateTime($value->fecha);
               // $row[]= utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime($value->fecha)))."-<u>".$x->format("g").":".$x->format("i")." ".$x->format("a")."</u>";
                $row[]=$value->fecha;
                $row[]=$value->almacen_origen;
                $row[]=$value->almacen_destino;
                
                
                $row[]=$value->username;
                if($value->estado==null){
                    $value->estado="Emitida";
                }
                $row[]=$value->estado;
                $row[]="<a href='".base_url()."redes/view_acta?id=".$value->teid."' class='btn btn-info'><i <i class='icon-eye'></i></a>";
                $data[]=$row;

        }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->redes->count_all_actas(),
                "recordsFiltered" => $this->redes->count_filtered_actas(),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);

    }
	public function view_acta(){
        
        $data=array("id_acta"=>$_GET['id']);
        $data['acta']=$this->db->get_where("transfer_equipos",array("teid"=>$_GET['id']))->row();
        $data['almacen_origen']=$this->db->get_where("almacen_equipos",array("id"=>$data['acta']->almacen_origen))->row();
        $data['almacen_destino']=$this->db->get_where("almacen_equipos",array("id"=>$data['acta']->almacen_destino))->row();
        if($data['almacen_destino']->id_tecnico!=null){
            $data['almacen_destino']->id_tecnico=$this->db->get_where("employee_profile",array("username"=>$data['almacen_destino']->id_tecnico))->row();
        }
        $data['lista_productos']=$this->db->query("select eq.codigo, eq.mac, eq.serial, eq.marca, eq.estado from equipos as eq inner join item_transfer_equipos as equi_tr on equi_tr.id_equipo=eq.id inner join transfer_equipos as tr_eq on tr_eq.teid=equi_tr.id_transfer where equi_tr.id_transfer=".$_GET['id'])->result();
        $data['employee']=$this->db->get_where("employee_profile",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();
        $data['employee_aauth_users']=$this->db->get_where("aauth_users",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();

        //var_dump($data['tecnicoslista']);
        $head['title']="Acta De Transferencia de Equipos #".$_GET['id'];
        $this->load->view('fixed/header',$head);

        $this->load->view('redes/view_acta',$data);
        $this->load->view('fixed/footer');
    }
	public function printacta()
    {
        $data=array("id_acta"=>$_GET['id']);
        $data['acta']=$this->db->get_where("transfer_equipos",array("teid"=>$_GET['id']))->row();
        $data['almacen_origen']=$this->db->get_where("almacen_equipos",array("id"=>$data['acta']->almacen_origen))->row();
        $data['almacen_destino']=$this->db->get_where("almacen_equipos",array("id"=>$data['acta']->almacen_destino))->row();
        /*if($data['almacen_destino']->id_tecnico!=null){
            $data['almacen_destino']->id_tecnico=$this->db->get_where("employee_profile",array("username"=>$data['almacen_destino']->id_tecnico))->row();
            $data['almacen_destino']->aauth_users=$this->db->get_where("aauth_users",array("id"=>$data['almacen_destino']->id_tecnico->id))->row();
        }*/
        $data['lista_productos']=$this->db->query("select eq.codigo, eq.mac, eq.serial, eq.marca, eq.estado from equipos as eq inner join item_transfer_equipos as equi_tr on equi_tr.id_equipo=eq.id inner join transfer_equipos as tr_eq on tr_eq.teid=equi_tr.id_transfer where equi_tr.id_transfer=".$_GET['id'])->result();
        $data['employee']=$this->db->get_where("employee_profile",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();
        $data['employee_aauth_users']=$this->db->get_where("aauth_users",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();

        //var_dump($data['tecnicoslista']);
        $head['title']="Acta De Transferencia de Equipos #".$_GET['id'];
//before
       /* $id = $this->input->get('id');

        $data['id'] = $id;
        $data['title'] = "Acta #$tid";
        $data['acta'] = $this->actas->purchase_details($id);
        $data['products'] = $this->purchase->purchase_products($id);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['employeeaut'] = $this->purchase->employee($data['invoice']['aid']);
        $data['invoice']['multi'] = 0;
*/
        ini_set('memory_limit', '128M');

        $html = $this->load->view('redes/view-print-'.LTR, $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #959595; font-weight: bold; font-style: italic;"><tr><td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $tid . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Acta #' . $data['id_acta'] . '.pdf', 'D');
        } else {
            $pdf->Output('Acta #' . $data['id_acta'] . '.pdf', 'I');
        }


    }
	


}