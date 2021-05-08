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

class Tickets Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ticket_model', 'ticket');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

    }


    //documents


    public function index()
    {
		$this->load->model("customers_model","customers");
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Support Tickets';
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
        $data['totalt'] = $this->ticket->ticket_count_all('');
        $data['listaclientgroups'] = $this->customers->group_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('support/tickets', $data);
        $this->load->view('fixed/footer');


    }
	public function ticketfil()
    {
		$head['usernm'] = $this->aauth->get_user()->username;
		$tec = $this->input->post('tec');
		$trans_type = $this->input->post('trans_type');
        $head['title'] = 'Support Tickets';
		$list = $this->ticket->get_ticfiltrado($tec, $trans_type);
        $data['lista']=$list;
		$data['filter'] = array($tec,$trans_type);
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
        $data['totalt'] = $this->ticket->ticket_count_all('');
		$this->load->view('fixed/header', $head);
        $this->load->view('support/ticketsfiltrado', $data);
        $this->load->view('fixed/footer');


    }
	public function statements()
    {

        $tec = $this->input->post('ac');
        $trans_type = $this->input->post('ty');        
        $list = $this->ticket->get_ticfiltrado($tec, $trans_type);       

        foreach ($list as $row) { 
			$no++;
            echo '<tr><td>' . $no . '</td><td>' . $row['idt'] . '</td><td>' . $row['subject'] . '</td><td>' . $row['detalle'] . '</td><td>' . $row['created'] . '</td><td>' . $row['abonado'] . '</td><td>' . $row['name'] . '</td><td><span class="st-'. $row['status'] .'">' .$row['status'] .'</span></td><td><a href="' . base_url('tickets/thread/?id=' . $row['idt']) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> ' .  '</td></tr>';
        }

    }

    public function tickets_load_list()
    {
        $filt = $this->input->get('stat');
        $list = $this->ticket->ticket_datatables($filt,$_GET);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $ticket) {
            $row = array();
            $no++;			
            $row[] = $no;
			$row[] = '<input id="input_'.$ticket->codigo.'" type="checkbox" style="margin-left: 9px;cursor:pointer;" onclick="asignar_orden(this)" data-id="'.$ticket->codigo.'">';
			$row[] = $ticket->codigo;
            $row[] = $ticket->subject;
			$row[] = $ticket->detalle;
            $row[] = $ticket->created;
			if ($ticket->fecha_final == '0000-00-00'){
				$row[]="sin realizar";
			}else{
				$row[] = $ticket->fecha_final;
			}
			
			if($ticket->cid !=null){
                $row[]='<a href="'.base_url("customers/view?id=".$ticket->cid).'">'.$ticket->abonado.'</a>';
            }
			$row[] = $ticket->name.' '.$ticket->unoapellido;
          if($ticket->id_factura !=null || $ticket->id_factura !==0 ){
                $row[]='<a href="'.base_url("invoices/view?id=".$ticket->id_factura).'">'.$ticket->id_factura.'</a>';
            }else{
                 $row[]="Sin Factura";
            }

            if($ticket->asignado!=null){
                //$tecnico=$this->db->get_where('aauth_users',array('id'=>$ticket->asignado))->row();
                $row[]=$ticket->asignado;
            }else{
                $row[] = "--";    
            }
			$row[] = $ticket->ciudad;
			$row[] = $ticket->barrio;
			$row[] = '<span class="st-' . $ticket->status . '">' . $ticket->status . '</span>';
            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->idt) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a>';
			if ($this->aauth->get_user()->roleid >= 3) {
			$row[] ='<a href="' . base_url('quote/edit/?id=' . $ticket->idt) . '" class="btn btn-primary btn-sm"><i class="icon-pencil"></i> ' . 'Editar' . '</a>';}
			if ($this->aauth->get_user()->roleid > 2) {
			$row[] =	'<a class="btn btn-danger" onclick="eliminar_ticket('.$ticket->idt.')" > <i class="icon-trash-o "></i> </a>';}
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all($filt),
            "recordsFiltered" => $this->ticket->ticket_count_filtered($filt),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    
    public function asignar_ordenes(){
        foreach ($_POST['lista'] as $key => $id_orden) {
            $datos['asignado']=$_POST['id_tecnico_seleccionado'];
            $condicion['codigo']=$id_orden;
            $this->db->update('tickets',$datos,$condicion);
			
			$data2['rol']=$_POST['id_tecnico_seleccionado'];
			$condicion2['idorden']=$id_orden;
			$this->db->update('events',$data2,$condicion2);
        }
        echo "correcto";
    }

    public function ticket_stats()
    {

        $this->ticket->ticket_stats();


    }


    public function thread()
    {

        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');		
        $data['response'] = 3;
        $data['id_orden_n']	=$thread_id;
        $orden = $this->db->get_where('tickets',array('idt'=>$thread_id))->row();		
        $almacen= $this->db->get_where('product_warehouse',array('id_tecnico'=>$orden->asignado))->row();
		$data['lista_productos_tecnico']=$this->db->get_where('products',array('warehouse'=>$almacen->id))->result_array();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Support Reply';		
        $this->load->view('fixed/header', $head);

        if ($this->input->post('content')) {

            $message = $this->input->post('content');
            $attach = $_FILES['userfile']['name'];
            if ($attach) {
                $config['upload_path'] = './userfiles/support';
                $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                $config['max_size'] = 3000;
                $config['file_name'] = time() . $attach;
                $crear=true;
              
                if(empty($_SESSION['archivo_subido'])){
                    $_SESSION['archivo_subido']=$attach;
                    $_SESSION['id_ticket']=$thread_id;    
                }else{
                    if($_SESSION['archivo_subido']==$attach && $id_ticket!=$_SESSION['id_ticket']){
                        $crear=false;
                    }else{
                      $_SESSION['archivo_subido']=$attach;     
                      $_SESSION['id_ticket']=$thread_id;
                    }
                }
    
                if($crear){
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('userfile')) {
                        $data['response'] = 0;
                        $data['responsetext'] = 'File Upload Error';

                    } else {
                        $data['response'] = 1;
                        $data['responsetext'] = 'Reply Added Successfully.';
                        $filename = $this->upload->data()['file_name'];
                        $this->ticket->addreply($thread_id, $message, $filename);
                    }
                }
            } else {
                $crear=true;
                if(empty($_SESSION['mensaje_subido'])){
                    $_SESSION['mensaje_subido']=$message;
                    $_SESSION['id_ticket']=$thread_id;    
                }else{
                    if($_SESSION['mensaje_subido']==$message && $id_ticket!=$_SESSION['id_ticket']){
                        $crear=false;
                    }else{
                      $_SESSION['mensaje_subido']=$message;     
                      $_SESSION['id_ticket']=$thread_id;
                    }
                }
                if($crear){
                    $this->ticket->addreply($thread_id, $message, '');
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                }
            }

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);			
            $this->load->view('support/thread', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);			
            $this->load->view('support/thread', $data);


        }
        $this->load->view('fixed/footer');
		


    }
    //consultas ajax referentes a tikets materiales add delet
    public function add_products_orden(){
        
        foreach ($_POST['lista'] as $key => $producto) {
             $vary=intval($producto['qty']);
             if($vary>0){
                $tf_prod_orden=$this->db->get_where('transferencia_products_orden',array("products_pid"=>$producto['pid'],"tickets_id"=>$_POST['id_orden_n']))->row();
                if(empty($tf_prod_orden)){
                    $dats['products_pid']=$producto['pid'];
                    $dats['tickets_id']=$_POST['id_orden_n'];
                    $dats['cantidad']=$producto['qty'];
                    //proceso de descontar cantidades del almacen
                    $producto_padre=$this->db->get_where('products',array('pid'=>$producto['pid']))->row();
                    $x1=intval($producto_padre->qty);
                    $x1=$x1-$vary;
                    $datx['qty']=$x1;
                    $this->db->update('products',$datx,array('pid'=>$producto['pid']));
                    // end proceso de descontar cantidades del almacen
                    $this->db->insert('transferencia_products_orden',$dats);
                }
             }
        }

        echo "Correcto";
    }

    public function eliminar_prod_lista(){
        $transferencia =  $this->db->get_where('transferencia_products_orden',array("idtransferencia_products_orden"=>$_POST['idt']))->row();
        $producto=$this->db->get_where('products',array("pid"=>$transferencia->products_pid))->row();
        $x1=intval($producto->qty);
        $y1=intval($transferencia->cantidad);
        $x1=$x1+$y1;
        $datosx['qty']=$x1;
        $this->db->update('products',$datosx,array('pid'=>$producto->pid));
        $this->db->delete('transferencia_products_orden',array("idtransferencia_products_orden"=>$_POST['id']));
        echo "Eliminado";
    }
    //fin consultas ajax referentes a tikets materiales add delet
    public function delete_ticket()
    {   
       
       
        $id = $this->input->post('deleteid');

        if ($this->ticket->deleteticket($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	public function delete_documento()
    {  
        $id = $this->input->post('deleteid');

        if ($this->ticket->deletedoc($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	public function asig_equipo()
    {
        $id = $this->input->post('iduser');
        $mac = $this->input->post('mac');
		$tinstalacion = $this->input->post('tinstalacion');
		$puerto = $this->input->post('puerto');
		$vlan = $this->input->post('vlan');
		$nat = $this->input->post('nat');
		$idequipo = $this->input->post('idequipo');
		$this->db->set('macequipo', $mac);		
        $this->db->where('id', $id);
        $this->db->update('customers');
		//datos de equipo
		$datae = array(
				't_instalacion' => $tinstalacion,
				'puerto' => $puerto,
			  	'vlan' => $vlan,
				'nat' => $nat,
				'asignado' => $id			
			);	
        $this->db->where('id', $idequipo);
        $this->db->update('equipos', $datae);

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
	public function explortar_a_excel(){
        
        $this->db->select("*");
        $this->db->from("tickets");
		$this->db->join('customers', 'tickets.cid=customers.id', 'left');
        $this->db->order_by("idt","DESC");
		//$usuario=$this->db->get_where("customers",array('id' => $_GET['id']))->row();
		if ($_GET['detalle'] != '' && $_GET['detalle'] != '-' && $_GET['detalle'] != '0') {
                $this->db->where('detalle=', $_GET['detalle']);
            }
		if ($_GET['tecnico'] != '' && $_GET['tecnico'] != '-' && $_GET['tecnico'] != '0') {
                $this->db->where('asignado=', $_GET['tecnico']);
            }
		if ($_GET['estado'] != '' && $_GET['estado'] != '-' && $_GET['estado'] != '0') {
                $this->db->where('status=', $_GET['estado']);
            }
		if ($_GET['sede_filtrar'] != '' && $_GET['sede_filtrar'] != '-' && $_GET['sede_filtrar'] != '0') {
                $this->db->where('gid=', $_GET['sede_filtrar']);
           }
		if($_GET['opcselect']!=''){

            $dateTime= new DateTime($_GET['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($_GET['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($_GET['opcselect']=="fcreada"){
                $this->db->where('created>=', $sdate);   
                $this->db->where('created<=', $edate);       
            }else{
                $this->db->where('fecha_final>=', $sdate);   
                $this->db->where('fecha_final<=', $edate);       
            }
            
        }
        //$this->db->where("idt",$_GET['id']);
        $lista_tickets=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_tickets2=array();
		
    
    //define column headers
    $headers = array('N° Orden' => 'string',
        'Tema' => 'string', 
        'Detalle' => 'string', 
        'Fecha Creada' => 'string',
		'Fecha Cierre' => 'string',
        'Abonado' => 'string',
		'Usuario' => 'string',			 
        'Estado' => 'string', 
        'Observacion' => 'string',
		'Factura #' => 'string',			 
		'Asignado' => 'string',
		'Direccion' => 'string',
		'Barrio' => 'string',					 
        'Sede' => 'string');
    
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
    $writer->setDescription('Reporte Tickets ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Tickets ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
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
	
    foreach ($lista_tickets as $key => $tickets) {
		$obsv = str_replace('<p>','',$tickets->section);
		$obsv2 = str_replace('</p>','',$obsv);
        if($tickets->codigo=="" || $tickets->codigo==null){
            $tickets->codigo="Sin Codigo";
        }
        if($tickets->fecha_final == '0000-00-00' || $tickets->fecha_final == '' || $tickets->fecha_final == null){
            $tickets->fecha_final="Sin Realizar";
        }
            $writer->writeSheetRow('Tickets ',array($tickets->codigo,$tickets->subject ,$tickets->detalle, $tickets->created,$tickets->fecha_final,$tickets->abonado ,$tickets->name.' '.$tickets->unoapellido,$tickets->status,$obsv2,$tickets->id_factura,$tickets->asignado,$tickets->nomenclatura.' '.$tickets->numero1.$tickets->adicionauno.' # '.$tickets->numero2.$tickets->adicional2.' - '.$tickets->numero3,$tickets->barrio,$tickets->ciudad));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Tickets '.$fecha_actual.'.xlsx';
    
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
	public function dividir()
    {
        $id = $this->input->post('id');
		$ticket = $this->db->get_where('tickets', array('idt' => $id))->result_array();
		$ticket2 = $this->db->get_where('tickets', array('idt' => $id))->row();
		$invoice = $this->db->get_where('invoices',array('tid'=>$ticket2->id_invoice))->row();
		$temporal = $this->db->get_where('temporales',array('corden'=>$ticket2->codigo))->row();
		$codmasuno= $this->db->select('max(codigo)+1 as codigo')->from('tickets')->get()->result();
		$parmasuno= $this->db->select('max(par)+1 as par')->from('tickets')->get()->result();
		$servicio = $this->input->post('servicio');
		//confirmar si hay afiliacion
        if($parmasuno[0]->par==null|| $parmasuno[0]->par==0 ||$parmasuno[0]->par==''){
            $parmasuno[0]->par=1;
        }
		if ($ticket2->id_invoice==='0'){
			$tv = $temporal->tv;
			$inter = $temporal->internet;
		}else{
			$tv = $invoice->television;
			$inter = $invoice->combo;
		}
		//confirmar paquete a instalar
        if ($servicio==='television'){
			$this->db->set('corden', $codmasuno[0]->codigo);
			$this->db->set('tv', 'no');		
        	$this->db->set('internet', $inter);
        	if ($this->db->insert('temporales')){
        	$this->db->set('internet', 'no');
			$this->db->where('corden', $ticket2->codigo);
        	$this->db->update('temporales');}
			$tele = $tv;
			$net = 'no';
			$detalle = 'Reinstalacion Internet';
		}if ($servicio==='internet'){
			$this->db->set('corden', $codmasuno[0]->codigo);
			$this->db->set('tv', $tv);		
        	$this->db->set('internet', 'no');
        	if ($this->db->insert('temporales')){
			$this->db->set('tv', 'no');
			$this->db->where('corden', $ticket2->codigo);
        	$this->db->update('temporales');}
			$tele = 'no';
			$net = $inter;
			$detalle = 'Reinstalacion Television';
		}
		//datos de duplicado
		foreach ($ticket[0] as $key => $value) {
            if($key!='idt' && $key!='detalle'  && $key!='status' && $key!='par'){
             $datat[$key]=$value;
            }
        }
		$datat['codigo']=$codmasuno[0]->codigo;
		$datat['detalle']=$detalle;
		$datat['status']='Pendiente';
		$datat['par']=$parmasuno[0]->par;
        $this->db->insert('tickets',$datat);
		//agregar par de tickets
		$this->db->set('par', $parmasuno[0]->par);		
        $this->db->where('idt', $id);
        $this->db->update('tickets');
		//actualizar servicios asignados en factura
		$this->db->set('television', $tele);
		$this->db->set('combo', $net);
        $this->db->where('tid', $ticket2->id_invoice);
        $this->db->update('invoices');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }

    public function update_status()
    {
        $this->load->model('tools_model', 'tools');
        $this->load->model('customers_model', 'customers');
		$tid = $this->input->post('tid');		
        $status = $this->input->post('status');
        $fecha_final = $this->input->post('fecha_final'); 
		$ticket = $this->db->get_where('tickets', array('idt' => $tid))->row();
		$usuario = $this->db->get_where('customers', array('id' => $ticket->cid))->row();
        $invoice = $this->db->get_where('invoices',array('tid'=>$ticket->id_invoice))->result_array();
		$temporal=$this->db->get_where('temporales',array('corden'=>$ticket->codigo))->row();
		$tv = $temporal->tv;
		$inter = $temporal->internet;
		$ptos = $temporal->puntos;
		$idfactura = $ticket->id_factura;
        $data;
		$detalle = $this->input->post('detalle');
		$est_afiliacion = $ticket->id_invoice;		
		//cambiar estado afiliacion
		$this->db->set('ron', 'Activo');
        $this->db->where('tid', $est_afiliacion);
        $this->db->update('invoices');
		
		//alerta de revision
		$ciudad = $usuario->ciudad;
		if ($status==='Resuelto' && $ticket->detalle==='Instalacion'){
		$stdate2 = datefordatabase($fecha_final);
		$name = 'Revisar orden #'.$ticket->codigo;
		$estado = 'Due';
		$priority = 'Low';
		$stdate = $stdate2;
		$tdate = '';
		if($ciudad==YOPAL || $ciudad==Yopal){
		$employee = 32;
		}if($ciudad==Monterrey){
			$employee = 52;
		}if($ciudad==Villanueva){
			$employee = 46;
		}
		$assign = $this->aauth->get_user()->id;
		$content = 'Revisar orden #'.$ticket->codigo;
		$ordenn = $ticket->codigo;
		$this->tools->addtask($name, $estado, $priority, $stdate, $tdate, $employee, $assign, $content, $ordenn);
			//cambio color al finalizar
			$this->db->set('color', '#a3a3a3');
        	$this->db->where('idorden', $ticket->codigo);
        	$this->db->update('events');
		}
        if(isset($invoice[0])){
            foreach ($invoice[0] as $key => $value) {
                if($key!='id' && $key!='pmethod' && $key!='status' && $key!='pamnt'){
                 $data[$key]=$value;
                }
            }
        }
        $tidactualmasuno= $this->db->select('max(tid)+1 as tid')->from('invoices')->get()->result();
        //esta data es de la nueva factura para insertar
        $data['tid']=$tidactualmasuno[0]->tid;
        $data['status']='due';
        $data['ron']='Activo';
		$data['refer']=$ciudad;
        //ssss
        $date_fecha_final = new DateTime($fecha_final);
        
        $xdate=strtotime($date_fecha_final->format("Y-m-d")." 00:00:00");
        //$dia_inicial_mes_anterior=date("Y-m", strtotime("-+ month", $xdate))."-01 00:00:00";
        $dia_final_de_mes=date("Y-m-t 23:00:00", $xdate);
        $date_fecha_corte=new DateTime($dia_final_de_mes);
        if($date_fecha_final->format("d")==$date_fecha_corte->format("d")){
            $d1=date($date_fecha_final->format("Y-m-d"));
           $date_fecha_final= new DateTime(date("Y-m-d",strtotime($d1." - 1 days")));
        }

        $diferencia = $date_fecha_final->diff($date_fecha_corte);
        $data['invoicedate']=$date_fecha_final->format("Y-m-d");
        $data['invoiceduedate']=$date_fecha_corte->format('Y-m-d');
        
        //ya tengo la diferencia entre las fechas ahora tengo que cojer el valortotal y dividirlo por los dias para obtener el valor de la factura que se cambia en $data['total'] y se insertan los datos al igual con cada item luego lo mando a http://localhost/CRMvestel/invoices/view?id=ticket->id_factura
        //end sss
        // lista_de_invoice_items es la lista de itemes para insertar
        $lista_de_invoice_items = $this->db->select('*')->from('invoice_items')->where("tid='".$ticket->id_invoice."' && ( pid =23 or pid =27)")->get()->result();
        $total=0;
		$tax2=0;
        //cod x
		if ($ticket->codigo===$temporal->corden){
			$data['csd']=$ticket->cid;
			$data['television']=$temporal->tv;
			$data['combo']=$temporal->internet;
			$data['puntos']=$temporal->puntos;
		}
        $datay['tid']=$data['tid'];
        $datay['qty']=1;
        $datay['tax']=19;
        $datay['discount']=0;
        
        $datay['totaldiscount']=0;			
                if($data['combo']!==no || $inter===no){
                    if($data['combo']==='1Mega' || $inter==='1Mega'){
                        $datay['pid']=125;
                    }else if($data['combo']==='2Megas' || $inter==='2Megas'){
                        $datay['pid']=126;
                    }else if($data['combo']==='3Megas'|| $inter==='3Megas'){
                        $datay['pid']=24;
					}else if($data['combo']==='3MegasV'|| $inter==='3MegasV'){
                        $datay['pid']=243;
					}else if($data['combo']==='3MegasSolo' || $inter==='3MegasSolo'){
                        $datay['pid']=170;
                    }else if($data['combo']==='5Megas' || $inter==='5Megas'){
                        $datay['pid']=25;
					}else if($data['combo']==='5MegasV'|| $inter==='5MegasV'){
                        $datay['pid']=244;
					}else if($data['combo']==='5MegasVS'|| $inter==='5MegasVS'){
                        $datay['pid']=247;
					}else if($data['combo']==='5MegasSolo'|| $inter==='5MegasSolo'){
                        $datay['pid']=171;					
                    }else if($data['combo']==='5MegasD'|| $inter==='5MegasD'){
                        $datay['pid']=223;					
                    }else if($data['combo']==='10Megas'|| $inter==='10Megas'){
                        $datay['pid']=26;
					}else if($data['combo']==='10MegasV'|| $inter==='10MegasV'){
                        $datay['pid']=245;
					}else if($data['combo']==='10MegasVS'|| $inter==='10MegasVS'){
                        $datay['pid']=246;
					}else if($data['combo']==='10MegasSolo'|| $inter==='10MegasSolo'){
                        $datay['pid']=172;
                    }else if($data['combo']==='50Megas'|| $inter==='50Megas'){
                        $datay['pid']=222;
                    }
                    $producto = $this->db->get_where('products',array('pid'=>$datay['pid']))->row();
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;
                    $total+=$x;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
					$tax2+=$datay['totaltax'];
					$datay['tax']=0;
					$datay['totaltax']=0;
                    $datay['price']=$x;
                    $datay['subtotal']=$x;     
                    if($ticket->detalle=="Instalacion" && $ticket->id_factura==null  && $status=="Resuelto" || $ticket->id_factura==0 || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Reconexion Television2" || $ticket->detalle=="Reconexion Internet2"){
                        $this->db->insert('invoice_items',$datay);    
                    }
                }
                
                if($data['television']!==no AND $data['refer']!==Mocoa || $tv!==no && $ciudad!==Mocoa){                
                    $producto = $this->db->get_where('products',array('pid'=>27))->row();
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;					
                    $y=(3992/31)*$diferencia->days;
                    $total+=$x;
					$tax2+=$datay['totaltax'];
					$datay['price']=$x;
                    $datay['tax']=19;
					$datay['totaltax']=$y;
					$datay['subtotal']=$x+$datay['totaltax'];
                    if($ticket->detalle=="Instalacion" && $ticket->id_factura==null || $ticket->id_factura==0 && $status=="Resuelto" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Reconexion Television2" || $ticket->detalle=="Reconexion Internet2"){
                        $this->db->insert('invoice_items',$datay);
                    }
				}
					if($data['puntos']!=='0' || $ptos!=='0'){                
                    $producto = $this->db->get_where('products',array('pid'=>158))->row();
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=$data['puntos'];
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;
                    $total+=$x*$datay['qty'];
					$tax2+=$datay['totaltax'];
					$datay['tax']=0;
					$datay['totaltax']='';
					$datay['price']=$x;
					$datay['subtotal']=$x*$datay['qty'];
                    if($ticket->detalle=="Instalacion" && $ticket->id_factura==null || $ticket->id_factura==0 && $status=="Resuelto" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Reconexion Television2" || $ticket->detalle=="Reconexion Internet2"){
                        $this->db->insert('invoice_items',$datay);
                    }
                }
				if($data['television']!==no AND $data['refer']==Mocoa || $tv!==no && $ciudad==Mocoa){                
                    $producto = $this->db->get_where('products',array('pid'=>159))->row();
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;
                    $total+=$x;
					$tax2+=$datay['totaltax'];
                    $datay['price']=$x;
					$datay['totaltax']='';
                    $datay['subtotal']=$x;
					
                    if($ticket->detalle=="Instalacion" && $ticket->id_factura==null || $ticket->id_factura==0 && $status=="Resuelto" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Reconexion Television2" || $ticket->detalle=="Reconexion Internet2"){
                        $this->db->insert('invoice_items',$datay);
                    }
                }
                
			
                
               
        //end cod x
		
        
        $data['subtotal']=$total;
		$data['tax']=$y;
        $data['total']=$data['subtotal']+$data['tax'];
        //no haga ni insert ni update si no es instalacion y tambien si ya existe una factura
        $msg1="";
        if($ticket->detalle=="Instalacion" && $ticket->id_factura==null || $ticket->id_factura==0 && $status=="Resuelto" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Reconexion Television2" || $ticket->detalle=="Reconexion Internet2"){
            $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
            $this->db->insert('invoices',$data);    
            $dataz['id_factura']=$data['tid'];
			//actualizar estado usuario
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
				//id factura si se dividio orden
				$this->db->set('id_factura', $data['tid']);							
        		$this->db->where('par', $ticket->par);
				//$this->db->where('codigo'!== $ticket->codigo);
                if($ticket->par!=null){
        		  $this->db->update('tickets');
                }
                //mikrotik
                
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid);
        }else{
            $msg1="no redirect";        
		}
		if($ticket->detalle=="Subir 5 Mg"){			
			$this->db->set('combo', '5Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Subir 10 Mg"){			
			$this->db->set('combo', '10Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Bajar 5 Mg"){			
			$this->db->set('combo', '5Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Bajar 3 Mg"){			
			$this->db->set('combo', '3Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Bajar 3 Mg"){			
			$this->db->set('combo', '3Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Reconexion Combo"){
			$paquete = $this->input->post('paquete');
			$this->db->set('combo', $paquete);
			$this->db->set('television', 'Television');
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
             //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid);
		}		
		if($ticket->detalle=="Reconexion Internet"){
			$paquete = $this->input->post('paquete');
			$this->db->set('combo', $paquete);			
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid);
		}
		if($ticket->detalle=="Reconexion Television"){
			$paquete = $this->input->post('paquete');
			$this->db->set('television', 'Television');			
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
		}
		if($ticket->detalle=="Corte Combo"){
			//agregar reconexion
			$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexion Combo'))->row();
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);
			//actualizar factura
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('ron', 'Cortado');				
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);
				$this->db->set('television', 'no');
				$this->db->set('combo', 'no');
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
			//actualizar estado usuario
				$this->db->set('usu_estado', 'Cortado');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');

                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid);
		}
		if($ticket->detalle=="Corte Internet"){
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
			$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexión Internet'))->row();
			if ($factura->television===no){
				$nestado = 'Cortado';
				$reconexion = '0';
			}else{
				$nestado = 'Activo';
				$reconexion = '1';
			}
				//actualizar estado usuario
				$this->db->set('usu_estado', $nestado);
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
				//agregar reconexion	
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);
			//actualizar factura
				$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);
				$this->db->set('ron', $nestado);
				$this->db->set('rec', $reconexion);
				$this->db->set('combo', 'no');
				$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');

			
             //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid);
		}
		if($ticket->detalle=="Corte Television"){
			//agregar reconexion
			$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexión Television'))->row();
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);
			//actualizar factura
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);
				$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
			if ($factura->combo===no){
				$this->db->set('ron', 'Cortado');
				$this->db->set('television', 'no');
				$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
				//actualizar estado usuario
				$this->db->set('usu_estado', 'Cortado');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
			}else{
				//actualizar factura
				$this->db->set('ron', 'Activo');
				//para generar reconexion
				$this->db->set('rec', '1');	
				$this->db->set('television', 'no');			
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
				//actualizar estado usuario
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
			}
				
			
		}
		if($ticket->detalle=="Traslado"){
			$codigo = $ticket->codigo;
			$traslados=$this->db->get_where('temporales',array('corden'=>$codigo))->row();
			$datat = array(
				'localidad' => $traslados->localidad,
				'barrio' => $traslados->barrio,
			  	'nomenclatura' => $traslados->nomenclatura,
				'numero1' => $traslados->nuno,
				'adicionauno' => $traslados->auno,
				'numero2' => $traslados->ndos,
				'adicional2' => $traslados->ados,
				'numero3' => $traslados->ntres,
				'residencia' => $traslados->residencia,
				'referencia' => $traslados->referencia,
			);
			//actualizar estado usuario				
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers', $datat);
		}
		if($ticket->detalle=="Suspension Combo"){			
			$this->db->set('ron', 'Suspendido');
			$this->db->set('television', 'no');
			$this->db->set('combo', 'no');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
				$this->db->set('usu_estado', 'Suspendido');
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid);
		}
		if($ticket->detalle=="Suspension Television"){
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
			if ($factura->combo===no){
				$status2 = 'Suspendido';
			}else{
				$status2 = 'Activo';
			}
			$this->db->set('ron', $status2);
			$this->db->set('television', 'no');			
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
				$this->db->set('usu_estado', $status2);
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
		}
		if($ticket->detalle=="Suspension Internet"){
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
			if ($factura->television===no){
				$status2 = 'Suspendido';
			}else{
				$status2 = 'Activo';
			}
			$this->db->set('ron', $status2);
			$this->db->set('combo', 'no');			
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
				$this->db->set('usu_estado', $status2);
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid);
		}
		if($ticket->detalle=="AgregarTelevision"){			
			$producto = $this->db->get_where('products',array('product_name'=>'Television'))->row();
					$datay['tid']=$idfactura;
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;					
                    $y=(3992/31)*$diferencia->days;
                    $total+=$x;
					$tax2+=$datay['totaltax'];
					$datay['price']=$x;
                    $datay['tax']=19;
					$datay['totaltax']=$y;
					$datay['subtotal']=$x+$datay['totaltax'];                    
                    $this->db->insert('invoice_items',$datay);
            $factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$total);
				$this->db->set('tax', $factura->tax+$tax2);
				$this->db->set('total', $factura->total+$total+$tax2);
				$this->db->set('television', 'Television');
				$this->db->set('puntos', $ptos);
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
			
		}
		//nuevo servicio
		if($ticket->detalle=="AgregarInternet"){	
		$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
		$datay['tid']=$idfactura;
        $datay['qty']=1;
        $datay['tax']=0;
        $datay['discount']=0;        
        $datay['totaldiscount']=0;
			//agregar servicio nuevo
                if($data['combo']!==no){
                    $producto = $this->db->get_where('products',array('product_name'=>$inter))->row();
					$datay['pid']=$producto->pid;
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;
                    $total=$x;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
					$tax2+=$datay['totaltax'];
					$datay['tax']=0;
					$datay['totaltax']=0;
                    $datay['price']=$x;
                    $datay['subtotal']=$x;     
                    $this->db->insert('invoice_items',$datay);

                }
            
				$this->db->set('subtotal', $factura->subtotal+$total);
				$this->db->set('tax', $factura->tax);
				$this->db->set('total', $factura->total+$total);
				$this->db->set('combo', $inter);
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');

                  //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid);
			
		}
		if($ticket->detalle=="Toma Adicional"){
			$punto = $this->input->post('puntos');
			$producto2 = $this->db->get_where('products',array('pid'=>69))->row();
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
				$x=intval($producto2->product_price);
                $x=($x/31)*$diferencia->days;
                $data2['price']=$x;
				$data2['qty']=$punto;
				$valorit = $x*$punto;
                $data2['subtotal']=$valorit;			
            	$this->db->insert('invoice_items',$data2);
			//actualizar factura
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$valorit);
				$this->db->set('total', $factura->total+$valorit);
				$this->db->set('items', $factura->items+1);
				$this->db->set('puntos', $punto);							
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');			
		}
		
        $dataz['status']=$status;
        $dataz['fecha_final']=$fecha_final;
        $this->db->update('tickets',$dataz,array('idt'=>$tid));
				
		
		
		
        echo json_encode(array('msg1'=>$msg1,'tid'=>$data['tid'],'status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
		
		
	}

	  
	
	public function addticket()
    {
        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');
		$data2['barrio'] = $this->ticket->group_barrio($data['details']['barrio']);
        $data['response'] = 3;		
		
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add ticket';		
        $this->load->view('fixed/header', $head);

        if ($this->input->post('content')) {

            $message = $this->input->post('content');
            $attach = $_FILES['userfile']['name'];
            if ($attach) {
                $config['upload_path'] = './userfiles/support';
                $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                $config['max_size'] = 3000;
                $config['file_name'] = time() . $attach;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('userfile')) {
                    $data['response'] = 0;
                    $data['responsetext'] = 'File Upload Error';

                } else {
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                    $filename = $this->upload->data()['file_name'];
                    $this->ticket->addreply($thread_id, $message, $filename);
                }
            } else {
                $this->ticket->addreply($thread_id, $message, '');
                $data['response'] = 1;
                $data['responsetext'] = 'Reply Added Successfully.';
            }

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);

            $this->load->view('support/addticket', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);


            $this->load->view('support/addticket', $data);


        }
        $this->load->view('fixed/footer');
		


    }


    


}