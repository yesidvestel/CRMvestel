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

class Customers extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/clist');
        $this->load->view('fixed/footer');
    }

    public function create()
    {

        $data['customergrouplist'] = $this->customers->group_list();				
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['codigo'] = $this->customers->codigouser();
        $head['title'] = 'Create Customer';		 
		$data['departamentos'] = $this->customers->departamentos_list();
        
        $data['ips_remotas']=$this->customers->devolver_ips_proximas();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/create', $data);
        $this->load->view('fixed/footer');
    }
    public function conectar_microtik(){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = true;
        
        if ($API->connect('190.14.233.186:8728', 'soporte.yopal', 'duber123')) {

         $API->comm("/ppp/secret/add", array(
              "name"     => "user_prueba_duber_disabled",
              "password" => "user_prueba_duber_disabled",
              "remote-address" => "172.16.1.11",
              "local-address" => "10.0.0.5",
              "profile" => "5Megas",
              "comment"  => "{new VPN user}",
              "service"  => "pppoe",
              "disabled"=>"yes"
           ));
        


         $API->disconnect();

        }else{
            echo "no conecto";
        }

    }
    public function conectar_microtik_activos(){
        //para desactivar
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = true;
        
        if ($API->connect('190.14.233.186:8728', 'soporte.yopal', 'duber123')) {

          $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => "PaolaJimenez",
                  ));
        $API->comm("/ppp/active/remove",
            array(
                ".id" => $arrID[0][".id"],
                )
            );
        //var_dump($arrID);
        $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  ".proplist"=> ".id",
                  "?name" => "PaolaJimenez",
                  ));
        $API->comm("/ppp/secret/set",
              array(
                   ".id" => $arrID[0][".id"],
                   "disabled"  => "yes",
                   )
              );
        //var_dump($arrID);


         $API->disconnect();

        }else{
            echo "no conecto";
        }

    }
    public function conectar_microtik_edicion(){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = true;
        
        if ($API->connect('190.14.233.186:8728', 'soporte.yopal', 'duber123')) {

            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  //".proplist"=> ".id",
                  "?name" => "PaolaJimenez",
                  ));

           /* $API->comm("/ppp/secret/set",
              array(
                   ".id" => $arrID[0][".id"],
                   "disabled"  => "no",
                   )
              );
*/
            var_dump($arrID);
        


         $API->disconnect();

        }else{
           
        }

    }
	
	public function ciudades_list()
	{ 
		$id = $this->input->post('idDepartamento');
		$ciudades = $this->customers->ciudades_list($id);
		//echo '<select  id="cmbCiudades"  class="selectpicker form-control"><option>Seleccionar</option>';
		foreach ($ciudades as $row) {
			echo '<option value="' . $row['idCiudad'] . '">' . $row['ciudad'] . '</option>';
		}
		//echo '</select>'; 
	}
	
	public function localidades_list()
	{ 
		$id = $this->input->post('idCiudad');
		$ciudades = $this->customers->localidades_list($id);
		//echo '<select class="selectpicker form-control"><option>Seleccionar</option>';
		foreach ($ciudades as $row) {
			echo '<option value="' . $row['idLocalidad'] . '">' . $row['localidad'] . '</option>';
		}
		//echo '</select>'; 
	}
	
	public function barrios_list()
	{ 
		$id = $this->input->post('idLocalidad');
		$ciudades = $this->customers->barrios_list($id);
		//echo '<select class="selectpicker form-control"><option>Seleccionar</option>';
		foreach ($ciudades as $row) {
			echo '<option value="' . $row['idBarrio'] . '">' . $row['barrio'] . '</option>';
		}
		//echo '</select>'; 
	}

    public function view()
    {
		
        $custid = $this->input->get('id');		
        $data['details'] = $this->customers->details($custid);
        $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
		$data['departamentos'] = $this->customers->group_departamentos($data['details']['departamento']);
		$data['ciudad'] = $this->customers->group_ciudad($data['details']['ciudad']);
		$data['localidad'] = $this->customers->group_localidad($data['details']['localidad']);
		$data['barrio'] = $this->customers->group_barrio($data['details']['barrio']);
        $data['money'] = $this->customers->money_details($custid);
        $data['due'] = $this->customers->due_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['activity']=$this->customers->activity($custid);
        $data['estado_mikrotik']=$this->customers->get_estado_mikrotik($data['details']['name_s']);
        $head['title'] = 'View Customer';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
        $list = $this->customers->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {
            $no++;

            $row = array();
            $row[] = $no;
			$row[] = $customers->abonado;
            $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
			$row[] = $customers->celular;
			$row[] = $customers->documento;
            $row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
			$row[] = $customers->usu_estado;
            $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span>  '.$this->lang->line('Edit').'</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all(),
            "recordsFiltered" => $this->customers->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edita_estado_usuario(){
        $this->customers->editar_estado_usuario($_GET['username']);
        redirect(base_url()."customers/view?id=".$_GET['id_cm']);
    }

    public function validar_user_name(){
        $resultado =$this->customers->validar_user_name($_POST['username']);
        if($resultado==null){
            echo "disponible";
        }else{
            echo "existe";
        }
       
        
    }
    //edit section
    public function edit()
    {
        $pid = $this->input->get('id');

        $data['customer'] = $this->customers->details($pid);
        $data['customergroup'] = $this->customers->group_info($data['customer']['gid']);
		$data['departamentos'] = $this->customers->group_departamentos($data['customer']['departamento']);		
		$data['ciudad'] = $this->customers->group_ciudad($data['customer']['ciudad']);
		$data['localidad'] = $this->customers->group_localidad($data['customer']['localidad']);
		$data['barrio'] = $this->customers->group_barrio($data['customer']['barrio']);
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Customer';	
		$data['departamentoslist'] = $this->customers->departamentos_list();		
        $data['ips_remotas']=$this->customers->devolver_ips_proximas();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function addcustomer()
    {
		$bill_due_date = datefordatabase($this->input->post('nacimiento'));
        $abonado = $this->input->post('abonado');
		$name = $this->input->post('name');
		$dosnombre = $this->input->post('dosnombre');
        $unoapellido = $this->input->post('unoapellido');
		$dosapellido = $this->input->post('dosapellido');
        $company = $this->input->post('company');
        $celular = $this->input->post('celular');
        $celular2 = $this->input->post('celular2');
        $email = $this->input->post('email');
        $nacimiento = $bill_due_date;
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
		$Ipremota = $this->input->post('Ipremota2');
		$comentario = $this->input->post('comentario');
        $this->customers->add($abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario);

    }

    public function editcustomer()
    {
		$bill_due_date = datefordatabase($this->input->post('nacimiento'));
        $id = $this->input->post('id');
		$abonado = $this->input->post('abonado');
        $name = $this->input->post('name');
		$dosnombre = $this->input->post('dosnombre');
        $unoapellido = $this->input->post('unoapellido');
		$dosapellido = $this->input->post('dosapellido');
        $company = $this->input->post('company');
        $celular = $this->input->post('celular');
        $celular2 = $this->input->post('celular2');
        $email = $this->input->post('email');
        $nacimiento = $bill_due_date;
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
        if ($id) {
            $this->customers->edit($id, $abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario);
        }
   
    }

    public function changepassword()
    {
        if ($id = $this->input->post()) {
            $id = $this->input->post('id');
            $password = $this->input->post('password');

            if ($id) {
                $this->customers->changepassword($id, $password);
            }
        } else {
            $pid = $this->input->get('id');
            $data['customer'] = $this->customers->details($pid);
            $data['customergroup'] = $this->customers->group_info($pid);
            $data['customergrouplist'] = $this->customers->group_list();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/edit_password', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }  $id = $this->input->post('deleteid');

        if ($this->customers->delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Customer details deleted Successfully!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }
	public function delete_obs()
    {  
        $id = $this->input->post('deleteid');

        if ($this->customers->deleteobs($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function displaypic()
    {

		$id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->customers->editpicture($id, $img);
        }


    }


    public function translist()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->trans_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');

        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
            $row[] = $prd->account;
            $row[] = $prd->payer;
			$row[] = $prd->estado;
            $row[] = $this->lang->line($prd->method);

            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>  '.$this->lang->line('Delete').'</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->trans_count_all($cid),
            "recordsFiltered" => $this->customers->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function suporlist()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->supor_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');

        foreach ($list as $ticket) {
            $row = array();
            $no++;			
            $row[] = $no;			
			$row[] = $ticket->idt;
            $row[] = $ticket->subject;
			$row[] = $ticket->detalle;
            $row[] = $ticket->created;          
			$row[] = $ticket->fecha_final;			
          if($ticket->id_factura !=null){
                $row[]='<a href="'.base_url("invoices/view?id=".$ticket->id_factura).'">'.$ticket->id_factura.'</a>';
            }else{
                 $row[]="Sin Factura";
            }

            if($ticket->asignado!=null){
                $tecnico=$this->db->get_where('aauth_users',array('id'=>$ticket->asignado))->row();
                $row[]=$tecnico->username;
            }else{
                $row[] = "--";    
            }
			
			$row[] = '<span class="st-' . $ticket->status . '">' . $ticket->status . '</span>';
            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->idt) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> ';

            

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->supor_count_all($cid),
            "recordsFiltered" => $this->customers->sup_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function equipolist()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->equipo_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');

        foreach ($list as $prd) {
            $no++;
            $row = array();
            $row[] = $no;
           	$pid = $prd->id;
			$row[] = $prd->codigo;
            $row[] = $prd->mac;
            $row[] = $prd->serial;
			$row[] = $prd->estado;			
			$row[] = $prd->marca;            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->equi_count_all($cid),
            "recordsFiltered" => $this->customers->equi_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function dev_equipo()
    {
        $id = $this->input->post('iduser');
        $nota = $this->input->post('nota');
		$estado = $this->input->post('estado');
		$codigo = $this->input->post('codigo');
		$this->db->set('macequipo', 'sin asignar');		
        $this->db->where('id', $id);
        $this->db->update('customers');
		
		$this->db->set('observacion', $nota);
		$this->db->set('estado', $estado);
		$this->db->set('asignado', 0);
        $this->db->where('codigo', $codigo);
        $this->db->update('equipos');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
	public function act_titular()
    {
        $id = $this->input->post('iduser');
        $nombres = $this->input->post('dtosantes2');
		$doc_anterior = $this->input->post('doc12');
		$tcliente = $this->input->post('tcliente');
		$tdocumento = $this->input->post('tdocumento');
		$bill_due_date = datefordatabase($this->input->post('fecha'));
		$fecha = $bill_due_date;
		$observacion = $this->input->post('observ');
		$nom1 = $this->input->post('nom1');
        $nom2 = $this->input->post('nom2');
		$ape1 = $this->input->post('ape1');
		$ape2 = $this->input->post('ape2');
		$cel = $this->input->post('cel');
		$tipo_cliente = $this->input->post('tipo_cliente');
		$tipo_documento = $this->input->post('tipo_documento');
		$doc2 = $this->input->post('doc2');
		
		
		$data2 = array(			
			'name' => $nom1,
			'dosnombre' => $nom2,
			'unoapellido' => $ape1,
			'dosapellido' => $ape2,
			'celular' => $cel,
			'tipo_cliente' => $tipo_cliente,
			'tipo_documento' => $tipo_documento,
			'documento' => $doc2);
        $this->db->where('id', $id);
        $this->db->update('customers', $data2);
		$dt1=new DateTime($fecha);
        $fecha=$dt1->format("Y-m-d");
		$data1 = array(				
			'id_user' => $id,
			'tipos' => 'Cambio Titular',
			'nombres' => $nombres,
			'tcliente' => $tcliente,
			'tdocumento' => $tdocumento,
			'documento2' => $doc_anterior,
			'fecha' => $fecha,
			'observacion' => $observacion);		
       $this->db->insert('historiales', $data1);
		
		

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
	public function obser()
    {
        $id = $this->input->post('iduser2');
        $tipo = $this->input->post('tipo');
		$detalle = $this->input->post('detalle2');
		$fcha = $this->input->post('fecha2');
		$dt1=new DateTime($fcha);
        $fecha=$dt1->format("Y-m-d");
		$datos = array(				
			'id_user' => $id,
			'tipos' => $tipo,
			'nombres' => $detalle,
			'tcliente' => '',
			'tdocumento' => '',
			'documento2' => '',
			'fecha' => $fecha,
			'observacion' => '');		
       $this->db->insert('historiales', $datos);
		
		

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }

    public function inv_list()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->inv_datatables($cid);
        $data = array();

        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            if($invoices->ron=="Cortado"){
                $row[] = '<a href="'.base_url().'invoices/view?id='.$invoices->tid.'">Cortado</a>';
            }else if($invoices->status=="paid"){
                $row[]="";
            }else{
                $total_factura=$invoices->total;
                if($invoices->status=="partial"){
                    $total_factura=$invoices->total-$invoices->pamnt;
                }
                $row[] = '<input type="checkbox" name="x" class="facturas_para_pagar" data-total=" '.$total_factura.'" data-idfacturas="'.$invoices->tid.'" data-status="'.$invoices->status.'" style="cursor:pointer; margin-left: 9px;" onclick="agregar_factura(this)" ></input>';    
            }
			
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
			$row[] = '<span class="st-' . $invoices->ron . '">' . $invoices->ron . '</span>';
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> '.$this->lang->line('View').'</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>'; 
            $data[] = $row;
        }
		

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }
	
 	

    public function transactions()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/transactions', $data);
        $this->load->view('fixed/footer');
    }
	public function soporte()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);        
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/tickets', $data);
        $this->load->view('fixed/footer');
    }
	public function equipos()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);        
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/equipos', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['invoice'] = $this->customers->invoice_details($custid, $this->limited);
        $head['title'] = 'View Customer Invoices';
		$data['due'] = $this->customers->due_details($custid);
		$this->load->model('accounts_model');
		$data['acclist'] = $this->accounts_model->accountslist();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function balance()
    {

        if($this->input->post()){
            $id = $this->input->post('id');
            $amount = $this->input->post('amount');


                 if ( $this->customers->recharge($id,$amount)) {
                     echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Balance Added')));
                 } else {
                     echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
                 }

        }
        else {
            $custid = $this->input->get('id');
            $data['details'] = $this->customers->details($custid);
            $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
            $data['money'] = $this->customers->money_details($custid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['activity'] = $this->customers->activity($custid);
            $head['title'] = 'View Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/recharge', $data);
            $this->load->view('fixed/footer');
        }
    }


}