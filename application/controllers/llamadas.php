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

class llamadas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('llamadas_model', 'llamadas');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {$this->load->model('invoices_model', 'invocies');
		$id = $this->input->get('id');
		$data['attach'] = $this->llamadas->attach($id);
        $this->db->group_by("product_name");
        $data['paquete']=$this->invocies->paquetes('tv');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Llamadas';
        $this->load->view('fixed/header', $head);
        $this->load->view('llamadas/clist', $data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {
		
		$this->load->model('ticket_model', 'ticket');
		$codigo = $this->input->get('id');
		$ticket = $this->db->get_where('tickets',array('codigo'=>$codigo))->row();
		$thread_id = $ticket->idt;
		//$data['thread_info'] = $this->ticket->thread_info($thread_id);
		//$data['thread_list'] = $this->ticket->thread_list($thread_id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Nueva Encuesta';
        $this->load->view('fixed/header', $head);
        $this->load->view('llamadas/create',$data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        $custid = $this->input->get('id');
        $data['details'] = $this->supplier->details($custid);
        $data['customergroup'] = $this->supplier->group_info($data['details']['gid']);
        $data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
		$id = $this->input->post('cid');
        $list = $this->llamadas->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $encuesta) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $encuesta->id;
            $row[] = date("d/m/Y", strtotime($encuesta->fcha));
            $row[] = date("g:i a", strtotime($encuesta->hra));
            $row[] = $encuesta->responsable;
            $row[] = $encuesta->tllamada;
			$row[] = $encuesta->trespuesta;
			$row[] = $encuesta->drespuesta;
			$row[] = $encuesta->notes;
			

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->llamadas->count_all($id),
            "recordsFiltered" => $this->llamadas->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    //edit section
    public function edit()
    {
        $pid = $this->input->get('id');

        $data['customer'] = $this->supplier->details($pid);
        $data['customergroup'] = $this->supplier->group_info($pid);
        $data['customergrouplist'] = $this->supplier->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function addllamada()
    {
        $iduser = $this->input->post('iduser');
		$tllamada = $this->input->post('tllamada');
        $trespuesta = $this->input->post('trespuesta');
        $drespuesta = $this->input->post('drespuesta');
        $responsable = $this->input->post('responsable');
        $fcha = $this->input->post('fcha');
        $fchavence = $this->input->post('fchavence');
		$fecha = datefordatabase($fcha);
		if($drespuesta!='Acuerdo de Pago'){
			$fechavence ='0000-00-00';
		}else{
			$fechavence = datefordatabase($fchavence);
		}
        $hra = date("H:i",strtotime($this->input->post('hra')));
        $notes = $this->input->post('notes');        
        $this->llamadas->add($iduser, $tllamada, $trespuesta, $drespuesta, $responsable, $fecha, $hra, $fechavence, $notes);
        echo json_encode(array('status' => 'Success', 'message' => "Agregado Exitoso"));

    }

    public function editsupplier()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
		$nit = $this->input->post('nit');
        $company = $this->input->post('company');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $region = $this->input->post('region');
        $cuenta = $this->input->post('cuenta');
        $typo = $this->input->post('typo');
        $banco = $this->input->post('banco');

        if ($id) {
            $this->supplier->edit($id, $name, $nit, $company, $phone, $email, $address, $city, $region, $cuenta, $typo,$banco);
        }
    }


   /* public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->supplier->delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }*/

    public function displaypic()
    {
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->supplier->editpicture($id, $img);
        }


    }
	public function file_handling()
    {
        if($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->llamadas->meta_delete($invoice, 7, $name)){
                echo json_encode(array('status' => 'Success'));
            }
        }
        else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->llamadas->meta_insert($id, 7, $files);
            }
        }


    }

    public function translist()
    {
        $cid = $this->input->get('tecnico');
        $list = $this->supplier->trans_table($cid);
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
            $row[] = $this->lang->line($prd->method);

            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->trans_count_all($cid),
            "recordsFiltered" => $this->supplier->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->llamadas->inv_datatables($cid);
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $llamada) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date("d/m/Y", strtotime($llamada->fcha));
            $row[] = date("g:i a", strtotime($llamada->hra));
            $row[] = $llamada->responsable;
            $row[] = $llamada->tllamada;
			$row[] = $llamada->trespuesta;
			$row[] = $llamada->drespuesta;
			$row[] = $llamada->notes;
            $row[] = '<a href="' . base_url("customers/view?id=$llamada->iduser") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View').' Usuario' . '</a> &nbsp; &nbsp;<a href="#" data-object-id="' . $llamada->id . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->llamadas->inv_count_all($cid),
            "recordsFiltered" => $this->llamadas->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }
	//lista de acuerdos
	public function com_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->llamadas->com_datatables($cid);
        $data = array();
		$this->load->model('customers_model', 'customers');
        $no = $this->input->post('start');

        foreach ($list as $llamada) {
			$idusuario = $llamada->iduser;
			$fcha = $llamada->fcha;
			$fchavence = $llamada->fecha_vence;
			$due=$this->customers->due_details($idusuario);
			$debe_customer=($due['total']-$due['pamnt']);
			$pagos=$this->customers->pago_details($idusuario,$fcha,$fchavence);
			$pago_customer=$pagos['pago'];
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = date("d/m/Y", strtotime($llamada->fcha));
            $row[] = date("g:i a", strtotime($llamada->hra));
            $row[] = date("d/m/Y", strtotime($llamada->fecha_vence));
			if ($this->aauth->get_user()->roleid > 3) {
            $row[] = $llamada->responsable;
			}
            $row[] = $llamada->name.' '.$llamada->unoapellido;
            $row[] = $llamada->documento;
			$row[] = amountFormat($debe_customer);
			$row[] = amountFormat($pago_customer);			
			$row[] = $llamada->notes;
            $row[] = '<a href="' . base_url("customers/view?id=$llamada->iduser") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View').' Usuario' . '</a>';
			if ($this->aauth->get_user()->roleid > 4) {
            $row[] = '<a href="#" data-object-id="' . $llamada->id . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';
			}
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->llamadas->com_count_all($cid),
            "recordsFiltered" => $this->llamadas->com_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }
	public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->llamadas->llamada_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "llamada #$id a sido eliminada!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "Ocurrio un error! la llamada no fue eliminada."));
        }

    }


    public function transactions()
    {
        $custid = $this->input->get('id');
        $data['details'] = $this->supplier->details($custid);
        $data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function list_llamadas()
    {
        $custid = $this->input->get('id');
        $this->load->model('ticket_model', 'ticket');
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
        //$data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('llamadas/invoices', $data);
        $this->load->view('fixed/footer');
    }
	public function list_compromisos()
    {
        $custid = $this->input->get('id');
		$this->load->model('customers_model', 'customers');
        $this->load->model('ticket_model', 'ticket');
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
        $data['acuerdos'] = $this->llamadas->lista_acuerdo();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('llamadas/compromisos', $data);
        $this->load->view('fixed/footer');
    }
	public function explortar_acuerdos(){
		set_time_limit(20000);
        $this->load->model('customers_model', 'customers');
        $col = $this->aauth->get_user()->username;
		$rol = $this->aauth->get_user()->roleid;
		$this->db->select('llamadas.*,customers.id AS idcus,customers.name,customers.unoapellido,customers.documento');
        $this->db->from('llamadas');
		$this->db->where('drespuesta', 'Acuerdo de Pago');
		if($rol<4){
		$this->db->where("responsable", $col);
		}
		if($_GET['tecnico']!='' && $_GET['tecnico']!='0' && $_GET['tecnico']!='undefined'){
         		$this->db->where('responsable=', $_GET['tecnico']);
        }
		if($_GET['tipo']!='' && $_GET['tipo']!='0' && $_GET['tipo']!='undefined'){
         $this->db->where('tllamada=', $_GET['tipo']);   
        }
        if($_GET['filtro_fecha']!='' && $_GET['filtro_fecha']!='undefined'){
            if($_GET['filtro_fecha']=='fcreada'){
            $fecha_incial= new DateTime($_GET['sdate']);
            $fecha_final= new DateTime($_GET['edate']);
         $this->db->where('fcha>=', $fecha_incial->format("Y-m-d"));   
         $this->db->where('fcha<=', $fecha_final->format("Y-m-d"));
			} if($_GET['filtro_fecha']=='fecha_final'){
				$fecha_incial2= new DateTime($_GET['sdatefin']);
            	$fecha_final2= new DateTime($_GET['edatefin']);
         		$this->db->where('fecha_vence>=', $fecha_incial2->format("Y-m-d"));   
         		$this->db->where('fecha_vence<=', $fecha_final2->format("Y-m-d"));
			}
        }
		$this->db->join('customers', 'llamadas.iduser=customers.id', 'left');
        $this->db->order_by("fcha","DESC");
        $lista_debito=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_debito2=array();
		
    
    //define column headers
    $headers = array(
        'Fecha' => 'date', 
        'hora' => 'string',
		'vence' => 'date',
		'Realizado por' => 'string',
		'Usuario' => 'string',
		'Documento' => 'integer',
		'Debe' => 'integer',
		'Pago' => 'integer',
		'Nota' => 'string');
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte acuerdos ');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte acuerdos ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Acuerdos ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
));
    
    //write rows to sheet1
	
    foreach ($lista_debito as $key => $acuerdo) {
			$idusuario = $acuerdo->iduser;
			$fcha = $acuerdo->fcha;
			$fchavence = $acuerdo->fecha_vence;
			$due=$this->customers->due_details($idusuario);
			$debe_customer=($due['total']-$due['pamnt']);
			$pagos=$this->customers->pago_details($idusuario,$fcha,$fchavence);
			$pago_customer=$pagos['pago'];
				$fecha = date("d/m/Y",strtotime($debito->date));
					$writer->writeSheetRow('Acuerdos ',array(
						$acuerdo->fcha,
						$acuerdo->hra,
						$acuerdo->fecha_vence,
						$acuerdo->responsable,
						$acuerdo->name.' '.$acuerdo->unoapellido,
						$acuerdo->documento,
						$debe_customer,
						$pago_customer,
						$acuerdo->notes));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Acuerdos '.$fecha_actual.'.xlsx';
    
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
	public function explortar_a_excel2(){
        
        $this->db->select("*");
        $this->db->from("llamadas");
		//$this->db->join('customers', 'tickets.cid=customers.id', 'left');
		if ($_GET['tecnico'] != '' && $_GET['tecnico'] != '-' && $_GET['tecnico'] != '0') {
                $this->db->where('responsable=', $_GET['tecnico']);
            }
		if ($_GET['tipo'] != '' && $_GET['tipo'] != '-' && $_GET['tipo'] != '0') {
                $this->db->where('tllamada=', $_GET['tipo']);
           }
		if($_GET['opcselect']!=''){

            $dateTime= new DateTime($_GET['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($_GET['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($_GET['opcselect']=="fcreada"){
                $this->db->where('fcha>=', $sdate);   
                $this->db->where('fcha<=', $edate);       
            }
            
        }
        $this->db->order_by("id","DESC");
        $lista_creditos=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_creditos2=array();
		
    
    //define column headers
    $headers = array(
        'Fecha' => 'date', 
        'Hora' => 'string',
        'Responsable' => 'string',
		'Tipo de llamada' => 'string',
		'Respuesta' => 'string',
		'Detalle' => 'string',
		'Observacion' => 'string');
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte llamadas ');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte llamadas ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Llamadas ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
));
    
    //write rows to sheet1
	
    foreach ($lista_creditos as $key => $creditos) {
		//$fecha = date("d/m/Y",strtotime($creditos->date));
            $writer->writeSheetRow('Llamadas ',array(
				$creditos->fcha,
				$creditos->hra,
				$creditos->responsable,
				$creditos->tllamada,
				$creditos->trespuesta,
				$creditos->drespuesta,
				$creditos->notes));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Creditos '.$fecha_actual.'.xlsx';
    
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


}