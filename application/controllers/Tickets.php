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
        $this->load->model('invoices_model', 'invoices');
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
        $this->load->model('Moviles_model', 'moviles');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Support Tickets';
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
        $data['totalt'] = $this->ticket->ticket_count_all('');
        $data['listaclientgroups'] = $this->customers->group_list();
        $data['moviles'] = $this->moviles->get_datatables1();
        $this->load->view('fixed/header', $head);
        $this->load->view('support/tickets', $data);
        $this->load->view('fixed/footer');
		$date1 = new DateTime("2015-02-14");
		$date2 = new DateTime("now");
		$diff = $date1->diff($date2);


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
		$obsv = str_replace('<p>','',$tickets->section);
		$obsv2 = str_replace('</p>','',$obsv);
		//date_default_timezone_set("America/Lima");
		$actual = new DateTime("now");
		
        foreach ($list as $ticket) {
			$ticketfcha = new DateTime($ticket->created);
			$dias=$actual->diff($ticketfcha);
			$creadamas1 = date("Y-m-d",strtotime($ticket->created."+ 1 days"));
			$creadamas2 = date("Y-m-d",strtotime($ticket->created."+ 3 days"));
			if($dias->days<=2){
				$color = '#24B130';
			}if($dias->days>=3 && $dias->days<=4){
				$color = '#C5962E';
			}if($dias->days>=5){
				$color = '#B82325';
			}
			$agenda=$this->db->get_where('events',array('idorden'=>$ticket->codigo))->row();
			$equipo=$this->db->get_where('equipos',array('asignado'=>$ticket->id))->row();
			$obsv = str_replace('<p>','',$ticket->section);
			$obsv2 = str_replace('</p>','',$obsv);
            $row = array();
            $no++;			
            $row[] = $no;
			$row[] = '<input id="input_'.$ticket->codigo.'" type="checkbox" style="margin-left: 9px;cursor:pointer;" onclick="asignar_orden(this)" data-id="'.$ticket->codigo.'">';
			$row[] = '<i class="icon-circle" style="color: '.$color.';"></i>';
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
			$row[] = $ticket->documento;
			$row[] = $obsv2.' '.$ticket->problema;
          if($ticket->id_factura !=null || $ticket->id_factura !==0 ){
                $row[]='<a href="'.base_url("invoices/view?id=".$ticket->id_factura).'">'.$ticket->id_factura.'</a>';
            }else{
                 $row[]="Sin Factura";
            }
			$row[]=$ticket->col;
            
            if($ticket->asignacion_movil!=null || $ticket->asignacion_movil!=''){
                $movil=$this->db->get_where("moviles",array("id_movil"=>$ticket->asignacion_movil))->row();
                $row[]="movil#".$movil->id_movil." - ".$movil->nombre;
            }else{
                if($ticket->asignado!=null){
                //$tecnico=$this->db->get_where('aauth_users',array('id'=>$ticket->asignado))->row();
                $row[]=$ticket->asignado;
                }else{
                    $row[] = "--";    
                }
            }
			$row[] = $ticket->ciudad;
			$row[] = $ticket->barrio;
			$row[] = $equipo->t_instalacion;
			if(isset($agenda->idorden)){
				$row[] = "<span class=' icon-check' style='color:green'></span>";
			}else{
				$row[] = "<span class=' icon-remove' style='color:red'></span>";
			}
			$row[] = '<span class="st-' . $ticket->status . '">' . $ticket->status . '</span>';
            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->idt) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i></a>';
			if ($this->aauth->get_user()->roleid >= 3) {
			$row[] ='<a href="' . base_url('quote/edit/?id=' . $ticket->idt) . '" class="btn btn-primary btn-xs"><i class="icon-pencil"></i> </a>';}
			if ($this->aauth->get_user()->roleid == 5) {
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
            
            if($_POST['id_movil_seleccionada']!=null){
                $datos['asignacion_movil']=$_POST['id_movil_seleccionada'];
            }else{
                $datos['asignado']=$_POST['id_tecnico_seleccionado'];
                $datos['asignacion_movil']=null;
            }
            $condicion['codigo']=$id_orden;
            $this->db->update('tickets',$datos,$condicion);
			
            if($_POST['id_movil_seleccionada']!=null){
                $data2['rol']=$_POST['id_movil_seleccionada'];
            }else{
                $data2['rol']=$_POST['id_tecnico_seleccionado'];
            }
			
			$condicion2['idorden']=$id_orden;
            $data_h['modulo']="tickets";
                $data_h['accion']="Editando evento ticket linea 187";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=json_encode($data2);
                $data_h['id_fila']=$id_orden;
                $data_h['tabla']="events";
                $data_h['nombre_columna']="idorden";
                $this->db->insert("historial_crm",$data_h);
			$this->db->update('events',$data2,$condicion2);
        }
        echo "correcto";
    }
    public function guardar_datos_firma(){
        $data['nombre_firma']=$_POST['nombre'];
        $data['cc_firma']=$_POST['cc'];
        $data['parentesco_firma']=$_POST['parentesco'];
        $this->db->update("tickets",$data,array("codigo"=>$_GET['codigo']));
        echo "Guardado";
        
    }
    public function ticket_stats()
    {

        $this->ticket->ticket_stats();


    }


    public function thread()
    {
		$this->load->model('redes_model', 'redes');
		$this->load->model('invoices_model', 'invocies');
		$this->load->model('customers_model', 'customers');
		$this->load->model('quote_model', 'quote');
        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');		
        $data['response'] = 3;
        $data['id_orden_n']	=$thread_id;
        $orden = $this->db->get_where('tickets',array('idt'=>$thread_id))->row();
		$codigo = $orden->codigo;
            $equipo_asignado = $this->db->get_where("equipos", array('asignado' =>$orden->cid))->row();
           $data['orden']=$orden; 
           $data['equipo_asignado']=$equipo_asignado; 

        $almacen= $this->db->get_where('product_warehouse',array('id_tecnico'=>$orden->asignado))->row();
		$data['lista_productos_tecnico']=$this->db->get_where('products',array('warehouse'=>$almacen->id))->result_array();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Support Reply';		
        $this->load->view('fixed/header', $head);
            ini_set('memory_limit', '500M');
		
	
        if ($this->input->post('content')) {
            set_time_limit(200000);
			$psolucion = $this->input->post('solucion');
			$message2 = $this->input->post('content');
            $message = $psolucion.'/ '.$message2;
            $attach = $_FILES['userfile']['name'];
            if ($attach) {
                $config['upload_path'] = './userfiles/support';
                $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|jpeg|gif';
                $config['max_size'] = 900000;
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
                        $data['responsetext'] = 'File Upload Error 2';

                    } else {
                        $data['response'] = 1;
                        $data['responsetext'] = 'Reply Added Successfully.';
                        $filename = $this->upload->data()['file_name'];
                        $this->ticket->addreply($thread_id, $message, $filename);
                    }
                }else{
                    $data['response'] = 0;
                    $data['responsetext'] = 'El archivo ya fue subido';
                    //var_dump($this->upload->display_errors());
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
			$data['naps'] = $this->redes->nap_todas();
            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);
			$data['temporal'] = $this->quote->group_tempo($codigo);
			$data['local'] = $this->customers->group_localidad($data['temporal']['localidad']);
			$data['barrio'] = $this->customers->group_barrio($data['temporal']['barrio']);
			$data['barrio2'] = $this->customers->group_barrio($data['thread_info']['barrio']);
			$data['paquete'] = $this->invocies->paquetes('tv');
            $this->load->view('support/thread', $data);
        } else {
			$data['naps'] = $this->redes->nap_todas();
            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);
			$data['temporal'] = $this->quote->group_tempo($codigo);
			$data['local'] = $this->customers->group_localidad($data['temporal']['localidad']);
			$data['barrio'] = $this->customers->group_barrio($data['temporal']['barrio']);
			$data['barrio2'] = $this->customers->group_barrio($data['thread_info']['barrio']);
			$data['paquete'] = $this->invocies->paquetes('tv');
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
        $transferencia =  $this->db->get_where('transferencia_products_orden',array("idtransferencia_products_orden"=>$_POST['id']))->row();
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
		$nap = $this->input->post('nap');
        $master = $this->input->post('master');
		$idequipo = $this->input->post('idequipo');
		$es_valido=true;
		$txt_error="";
        if($mac==""){
            $es_valido=false;
            $txt_error.="<li>Agrega una mac </li>";
        }else{
            $q=$this->db->query("select * from equipos inner join customers on equipos.asignado=customers.id where mac='".$mac."' and asignado>0")->result();

            if(count($q)>0){
                $es_valido=false;
                
                $txt_error.="<li>Esta mac ya a sido asignada a el usuario <a href='".base_url()."customers/view?id=".$q[0]->id."'><strong>".$q[0]->name." ".$q[0]->unoapellido."</strong></a></li>";  
            }
        }              
        if($tinstalacion=="" || $tinstalacion=="null"){
            $es_valido=false;
            $txt_error.="<li>Selecciona un tipo de instalacion</li>";
        }else if($tinstalacion=="EOC"){

                if($master==""){
                    $es_valido=false;
                    $txt_error.="<li>Ingresa una master</li>";
                }
        }else if($tinstalacion=="FTTH"){
               /*if($vlan=="null" || $vlan==""){
                    $es_valido=false;
                    $txt_error.="<li>Selecciona una vlan</li>";
               }*/
                if($puerto=="null" || $puerto==""){
                    $es_valido=false;
                    $txt_error.="<li>Selecciona un puerto nat</li>";
               }
                if($nap=="null" || $nap==""){
                    $es_valido=false;
                    $txt_error.="<li>ingresa una caja nat</li>";
               }
        }

        if(!$es_valido){
            if($txt_error!=""){
                $txt_error="<ul>".$txt_error."</ul>";
            }
            echo json_encode(array('status' => 'Error-Validacion', 'message' =>
                "Llena los campos correctamente por favor <br>".$txt_error, 'pstatus' => "error"));                
        }else{
            $this->db->set('macequipo', $mac);      
            $this->db->where('id', $id);
            $this->db->update('customers');
            //datos de equipo
            $datae = array(
                    't_instalacion' => $tinstalacion,
                    'puerto' => $puerto,
                    'nat' => $nap,
                    'master'=>$master,
                    'asignado' => $id           
                );  
            $this->db->where('id', $idequipo);
			//devolver equipo a bodega desde el almacen del tecnico
            if ($this->db->update('equipos', $datae)) {
				$this->db->delete('products', array('product_name' => $mac));
				$datap = array(
                    'estado' => 'Ocupado',
                    'asignado' => $id,          
                );
				$this->db->where('idp', $puerto);
				$this->db->update('puertos', $datap);
			}

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED'), 'pstatus' => $status));    
        }
		
    }
	public function explortar_a_excel(){
        
        $this->db->select("*");
        $this->db->from("tickets");
		$this->db->join('customers', 'tickets.cid=customers.id', 'left');
		$this->db->join('barrio', 'customers.barrio=barrio.idBarrio', 'left');
        $this->db->order_by("idt","DESC");
		//$usuario=$this->db->get_where("customers",array('id' => $_GET['id']))->row();
		if ($_GET['detalle'] != '' && $_GET['detalle'] != '-' && $_GET['detalle'] != '0' && $_GET['detalle']!=null && $_GET['detalle']!="null") {
                $this->db->where_in('detalle', explode(",", $_GET['detalle']));       
            }
		if ($_GET['tecnico'] != '' && $_GET['tecnico'] != '-' && $_GET['tecnico'] != '0' && $_GET['tecnico']!=null && $_GET['tecnico']!="null") {
            if(strpos($_GET['tecnico'],"Sin Asignar")!==false){
             $_GET['tecnico']= str_replace("Sin Asignar", "", $_GET['tecnico']);   
            }
            $this->db->where_in('asignado', explode(",", $_GET['tecnico']));       
            }
		if ($_GET['estado'] != '' && $_GET['estado'] != '-' && $_GET['estado'] != '0' && $_GET['estado']!=null && $_GET['estado']!="null") {
                $this->db->where_in('status', explode(",", $_GET['estado']));       
            }
		if ($_GET['sede_filtrar'] != '' && $_GET['sede_filtrar'] != '-' && $_GET['sede_filtrar'] != '0' && $_GET['sede_filtrar'] != 'null' && $_GET['sede_filtrar'] != null) {
                $this->db->where_in('gid', explode(",", $_GET['sede_filtrar']));       
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
        'Fecha Creada' => 'date',
		'Fecha Cierre' => 'string',
        'Abonado' => 'integer',
		'Usuario' => 'string',
		'Documento' => 'integer',
		'Celular' => 'integer',			 
        'Estado' => 'string', 
        'Observacion' => 'string',
		'Factura #' => 'integer',			 
		'Realizada' => 'string',
		'Asignado' => 'string',
		'Direccion' => 'string',
		'Referencia' => 'string',
		'Barrio' => 'string',					 
        'Sede' => 'string',
        'Tecnologia' => 'string');
    
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
		$sede=$this->db->get_where("ciudad",array("idCiudad"=>$tickets->ciudad))->row();
		$equipo=$this->db->get_where('equipos',array('asignado'=>$tickets->id))->row();
        if($tickets->codigo=="" || $tickets->codigo==null){
            $tickets->codigo="Sin Codigo";
        }
        if($tickets->fecha_final == '0000-00-00' || $tickets->fecha_final == '' || $tickets->fecha_final == null){
            $tickets->fecha_final="Sin Realizar";
        }
            $writer->writeSheetRow('Tickets ',array(
				$tickets->codigo,
				$tickets->subject,
				$tickets->detalle, 
				$tickets->created,
				$tickets->fecha_final,
				$tickets->abonado,
				$tickets->name.' '.$tickets->unoapellido,
				$tickets->documento,
				$tickets->celular,
				$tickets->status,
				$obsv2,
				$tickets->id_factura,
				$tickets->col,
				$tickets->asignado,
				$tickets->nomenclatura.' '.$tickets->numero1.$tickets->adicionauno.' # '.$tickets->numero2.$tickets->adicional2.' - '.$tickets->numero3,$tickets->residencia.'/'.$tickets->referencia,
				$tickets->barrio,
				$sede->ciudad,
				$equipo->t_instalacion));
        
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
			$detalle = 'AgregarInternet';
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
			$detalle = 'AgregarTelevision';
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
        if($fecha_final=="null" || $fecha_final==null || $this->aauth->get_user()->roleid=="2" || $this->aauth->get_user()->roleid==2){
            $fecha_final = date("Y-m-d H:i:s");     
        }
        
		$ticket = $this->db->get_where('tickets', array('idt' => $tid))->row();
		$usuario = $this->db->get_where('customers', array('id' => $ticket->cid))->row();
        $invoice = $this->db->get_where('invoices',array('tid'=>$ticket->id_invoice))->result_array();
		$temporal=$this->db->get_where('temporales',array('corden'=>$ticket->codigo))->row();
		if($status=="Realizando"){
			//cambio cuando se esta realizando
            $this->db->set('status', $status);
           // $this->db->set('inicio', date("Y-m-d h:i"));
            $this->db->where('idt', $tid);
            if ($this->db->update('tickets')){
				//cambio color realizando
				$this->db->set('color', '#2DC548');
				$this->db->set('start', date("Y-m-d H:i:s"));
                $this->db->set('end', date("Y-m-d H:i:s"));
				$this->db->where('idorden', $ticket->codigo);
				$this->db->update('events');
                $data_h['modulo']="tickets";
                $data_h['accion']="Editando evento ticket linea 703";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=$fecha_final;
                $data_h['id_fila']=$ticket->codigo;
                $data_h['tabla']="events";
                $data_h['nombre_columna']="idorden";
                $this->db->insert("historial_crm",$data_h);
        };
        echo json_encode(array('msg1'=>"Realizando",'tid'=>0,'status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
   } else if($status=="Anulada"){
    $dataz=array();
        $dataz['status']=$status;
        //$dataz['fecha_final']=$fecha_final;
        if ($this->db->update('tickets',$dataz,array('idt'=>$tid))){
            //cambio color al finalizar
            $this->db->set('color', '#a3a3a3');
            $this->db->where('idorden', $ticket->codigo);
            $this->db->update('events');
             $data_h['modulo']="Tickets";
                $data_h['accion']="Editando evento ticket linea 724";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']="";
                $data_h['id_fila']=$ticket->codigo;
                $data_h['tabla']="events";
                $data_h['nombre_columna']="idorden";
                $this->db->insert("historial_crm",$data_h);
        };
        echo json_encode(array('msg1'=>"Anulada",'tid'=>0,'status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
   }else{
    $ya_agrego_equipos=true;
    if(($ticket->detalle=="Instalacion" || $ticket->detalle=="Activacion") && $status=="Resuelto"){
            if(isset($temporal) && $temporal->internet!="no" && $temporal->internet!=null){
                $equipo=$this->db->get_where("equipos", array('asignado' => $ticket->cid))->row();
                if(empty($equipo)){
                        $ya_agrego_equipos=false;
                }
                
            }

            if(!empty($invoice)){
                
                $item_invoice=$this->db->get_where("invoice_items", array("tid"=>$invoice[0]['tid']))->result_array();
                $val_internet=false;
                foreach ($item_invoice as $key => $v1) {
                    if($v1['pid']=="47" || $v1['pid']=="209"){
                        $val_internet=true;
                    }
                }
                $equipo=$this->db->get_where("equipos", array('asignado' => $ticket->cid))->row();
                if($val_internet && empty($equipo)){
                    $ya_agrego_equipos=false;
                }
                
            }

    }
$hiso_devolucion_de_equipo=true;
    if($ticket->detalle=="Suspension Internet" || $ticket->detalle=="Suspension Combo"){
        $fecha_actual=new DateTime();
        
        $intervalo_de_5_dias_devolucion=date("Y-m-d",strtotime($fecha_actual->format("Y-m-d")."- 5 days")); 
        
        $historiales=$this->db->get_where("historiales",array('id_user' => $ticket->cid,'tipos' => 'Devolucion Equipo',"fecha>="=>$intervalo_de_5_dias_devolucion,"fecha<="=>$fecha_actual->format("Y-m-d")))->result_array();
        if(!empty($historiales) && count($historiales)!=0){
            $hiso_devolucion_de_equipo=true;
        }else{
            $hiso_devolucion_de_equipo=false;
        }
        $equipos=$this->db->get_where("equipos",array('asignado' => $ticket->cid))->result_array();
        if(empty($equipos)){
            $hiso_devolucion_de_equipo=true;
        }

    }
$nombre_archiv="assets/firmas_digitales/orden_".$ticket->codigo.".png";

if($status=="Resuelto" && file_exists($nombre_archiv)==false && strpos(strtolower($ticket->detalle), "reconexi")===false && strpos(strtolower($ticket->detalle), "corte")===false ){
          echo json_encode(array('status' => 'Error', 'message' =>"Por favor agrega la firma de quien resive el servicio para poder cerrar la orden ", 'pstatus' => "error"));
}else if($ya_agrego_equipos==false){
        echo json_encode(array('status' => 'Error', 'message' =>"Por favor agrega un equipo a esta orden antes de cerrarla ", 'pstatus' => "error"));
}else if($hiso_devolucion_de_equipo==false){
        echo json_encode(array('status' => 'Error', 'message' =>"Por favor realice la devolucion del equipo antes de cerrar la orden ", 'pstatus' => "error"));
}else{$y=0;
    $tv =null;
        $inter = null;
        $ptos = null;
    if(isset($temporal)){
        $tv = $temporal->tv;
        $inter = $temporal->internet;
        $ptos = $temporal->puntos;
    }
		
		$idfactura = $ticket->id_factura;
        $data;
		$detalle = $this->input->post('detalle');
		$est_afiliacion = $ticket->id_invoice;	
        $customer=$this->db->get_where("customers",array('id' =>$ticket->cid))->row();	
		//cambiar estado afiliacion
		$this->db->set('ron', 'Activo');
        $this->db->where('tid', $est_afiliacion);
        $this->db->update('invoices');
		
		//alerta de revision
		$ciudad2 = $usuario->ciudad;
        $ciudad3=$this->db->get_where("ciudad",array("idCiudad"=>$ciudad2))->row();
        $ciudad=$ciudad3->ciudad;
		if ($status==='Resuelto' && $ticket->detalle==='Instalacion'){
		$stdate2 = datefordatabase($fecha_final);
		$name = 'Revisar orden #'.$ticket->codigo;
		$estado = 'Due';
		$priority = 'Low';
		$stdate = $stdate2;
		$tdate = '';
		$asignacion = $this->db->get_where('asignaciones', array('detalle' => 'encuesta','tipo'=> $ciudad))->row();
		
			//var_dump($asignacion->colaborador);
		$employee = $asignacion->colaborador;
		/*if($ciudad=="YOPAL" || $ciudad=="Yopal"){
		$employee = 8;
		}if($ciudad=="Monterrey"){
			$employee = 52;
		}if($ciudad=="Villanueva"){
			$employee = 74;
		}*/
		$assign = $this->aauth->get_user()->id;
		$content = 'Revisar orden #'.$ticket->codigo;
		$ordenn = $ticket->codigo;
		$this->tools->addtask($name, $estado, $priority, $stdate, $tdate, $employee, $assign, $content, $ordenn);
			//cambio color al finalizar
			$this->db->set('color', '#a3a3a3');
        	$this->db->where('idorden', $ticket->codigo);
        	$this->db->update('events');
            $data_h['modulo']="tickets";
                $data_h['accion']="Editando evento ticket linea 832";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']="";
                $data_h['id_fila']=$ticket->codigo;
                $data_h['tabla']="events";
                $data_h['nombre_columna']="idorden";
                $this->db->insert("historial_crm",$data_h);
		}
        if(isset($invoice[0])){
            foreach ($invoice[0] as $key => $value) {
                if($key!='id' && $key!='pmethod' && $key!='status' && $key!='pamnt' && $key!='resivos_guardados'){
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
		$data['tipo_factura']='Recurrente';
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
		$tax2=0;//var_dump($invoice[0]);
        //cod x
		if (isset($temporal) && $ticket->codigo===$temporal->corden){
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
                if($data['combo']!=="no" || $inter==="no"){
                    $producto = $this->db->get_where('products',array('product_name'=>$data['combo']))->row();
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;
                    
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    if(isset($datay['totaltax'])){
                        $tax2+=$datay['totaltax'];    
                    }
					if($producto->taxrate!=0 && $producto->taxrate!=null){
                        $taxvalue=round(($producto->product_price*$producto->taxrate)/100);
                        $taxvalue=round(round(($taxvalue/31))*$diferencia->days);
                        $y=$taxvalue;
                        $total+=$x;
                        $datay['tax']=$producto->taxrate;
                        $datay['totaltax']=$taxvalue;
                        $datay['price']=$x;
                        $datay['subtotal']=($x+$taxvalue);         
                    }else{
                        $total+=$x;
                        $datay['tax']=0;
                        $datay['totaltax']=0;
                        $datay['price']=$x;
                        $datay['subtotal']=$x;         
                    }    
                    //var_dump($data);
                    if(($ticket->detalle=="Instalacion" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Activacion" || $ticket->detalle=="Reconexion Internet2") && ($ticket->id_factura==null || $ticket->id_factura==0)  && $status=="Resuelto"){
                        $this->db->insert('invoice_items',$datay);  
                    }
                }
                
                if($data['television']!=="no" AND $data['refer']!=="Mocoa" || $tv!=="no" && $ciudad!=="Mocoa"){                
                    $producto = $this->db->get_where('products',array('product_name'=>$data['television']))->row();
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $x=round($producto->product_price);
                    $x=round($x/31);
                    $x=round($x*$diferencia->days);					
                    /*$z=round(round(3992/31)*$diferencia->days);
                    $y+=$z;
                    $total+=$x;
					$tax2+=$datay['totaltax'];
					$datay['price']=$x;
                    $datay['tax']=19;
					$datay['totaltax']=$z;
					$datay['subtotal']=$x+$datay['totaltax'];
                    */
                    if($producto->taxrate!=0 && $producto->taxrate!=null){
                        $taxvalue=round(($producto->product_price*$producto->taxrate)/100);
                        $taxvalue=round(round(($taxvalue/31))*$diferencia->days);
                        $y+=$taxvalue;
                        $total+=$x;
                        $datay['tax']=$producto->taxrate;
                        $datay['totaltax']=$taxvalue;
                        $datay['price']=$x;
                        $datay['subtotal']=($x+$taxvalue);     //basarme en este cambio para agregar tv y hacer pruebas de todo, para mañana    
                    }else{
                        $total+=$x;
                        $datay['tax']=0;
                        $datay['totaltax']=0;
                        $datay['price']=$x;
                        $datay['subtotal']=$x;         
                    }  
                    if(($ticket->detalle=="Instalacion" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Activacion" || $ticket->detalle=="Reconexion Television2") && ($ticket->id_factura==null || $ticket->id_factura==0)  && $status=="Resuelto"){
                        $this->db->insert('invoice_items',$datay);
                    }
				}
					if($data['puntos']!=='0' && $ptos!=='0' && $ptos!==0 && $data['puntos']!=='' && $data['puntos']!==null){                
                    $producto = $this->db->get_where('products',array('pid'=>158))->row();
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=$data['puntos'];
                    $x=$producto->product_price;
                    $x=round($x/31);
                    $x=round($x*$diferencia->days);
                    $total+=$x*$datay['qty'];
					$tax2+=$datay['totaltax'];
					$datay['tax']=0;
					$datay['totaltax']='';
					$datay['price']=$x;
					$datay['subtotal']=$x*$datay['qty'];
                    if(($ticket->detalle=="Instalacion" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Activacion" || $ticket->detalle=="Reconexion Television2") && ($ticket->id_factura==null || $ticket->id_factura==0)  && $status=="Resuelto"){
                        $this->db->insert('invoice_items',$datay);
						
                    }
                }
				if($data['television']!=="no" AND $data['refer']=="Mocoa" || $tv!=="no" && $ciudad=="Mocoa"){                
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
					
                    if(($ticket->detalle=="Instalacion" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Activacion" || $ticket->detalle=="Reconexion Television2") && ($ticket->id_factura==null || $ticket->id_factura==0)  && $status=="Resuelto"){
                        $this->db->insert('invoice_items',$datay);
						
                    }
                }
                
			
       
               
        //end cod x
		
        
        $data['subtotal']=$total;
		$data['tax']=$y;
        $data['total']=$data['subtotal']+$data['tax'];
        //no haga ni insert ni update si no es instalacion y tambien si ya existe una factura
        $msg1="";
        if(($ticket->detalle=="Instalacion" || $ticket->detalle=="Reconexion Combo2" || $ticket->detalle=="Activacion" || $ticket->detalle=="Reconexion Television2" || $ticket->detalle=="Reconexion Internet2") && ($ticket->id_factura==null || $ticket->id_factura==0)  && $status=="Resuelto"){
            $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
           // if(isset($ticket->id_invoice) && $ticket->id_invoice!=0 && $ticket->id_invoice!="0" ){
                
                $list_servs=$this->invoices->servicios_adicionales($ticket->id_invoice,false);
                $list_servs=$this->invoices->servicios_adicionales_idt($ticket->idt,$lista_servs);
                //var_dump($ticket->id_invoice);
                //var_dump($list_servs);
                foreach ($list_servs as $key_s => $serv_val) {
                    $data_serv=array();
                    $data_serv['tid_invoice']=$data['tid'];
                    $data_serv['pid']=$serv_val['pid'];
                    $data_serv['valor']=$serv_val['valor'];
                    $data_serv['subtotal']=$serv_val['subtotal'];
                    $data_serv['total']=$serv_val['total'];
                    $this->db->insert("servicios_adicionales",$data_serv);
                        $producto = $this->db->get_where('products',array('pid'=>$serv_val['pid']))->row();
                        $data_item_serv=array();
                        $data_item_serv['pid']=$producto->pid;
                        $data_item_serv['tid']=$data['tid'];
                        $data_item_serv['product']=$producto->product_name;
                        $data_item_serv['qty']=$serv_val['valor'];
                        if(!is_numeric($serv_val['valor'])){
                            $data_item_serv['qty']=1;
                        }
                        /*falta calcular el precio segun los dias y añadir el valor de estos item_invoice al valor de la factura*/
$x=0;
                        $x=$producto->product_price;
                    $x=round($x/31);
                    $x=round($x*$diferencia->days);
                    $total+=round($x*$data_item_serv['qty']);
                    //$tax2+=$datay['totaltax'];
                        $data_item_serv['tax']=0;
                        $data_item_serv['totaltax']='';
                        $data_item_serv['price']=$x;
                        $data_item_serv['subtotal']=round($x*$data_item_serv['qty']);
                        $this->db->insert('invoice_items',$data_item_serv);
                }
           // }
            $data['subtotal']=$total;
            
            $data['total']=$data['subtotal']+$data['tax'];
            if($this->db->insert('invoices',$data)){
				if($ticket->par!=null && ($ticket->detalle=="Reconexion Internet2" || $ticket->detalle=="Reconexion Television2")){
						$this->db->set('id_factura', $data['tid']);
						$this->db->where('par', $ticket->par);
						$this->db->update('tickets');
					}
			}
				

            $dataz['id_factura']=$data['tid'];
			//actualizar estado usuario
                $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Activo');
			//cambiar fecha contrato
			if($ticket->detalle!="Reconexion Combo2" || $ticket->detalle!="Reconexion Television2" || 		$ticket->detalle!="Reconexion Internet2"){
                	$this->db->set("f_contrato",date("Y-m-d"));
				}
        		$this->db->where('id', $ticket->cid);
        		//historial estados
        		if($this->db->update('customers')){
					 $dataes = array(
						'cid' => $ticket->cid,
						'fecha' => date("Y-m-d H:i:s"),
						'estado' => 'Activo',
						'col' => $ticket->codigo,
						);
						 $this->db->insert("estados",$dataes);
					}
				//id factura si se dividio orden
				$this->db->set('id_factura', $data['tid']);							
        		
				//$this->db->where('codigo'!== $ticket->codigo);
                if($ticket->par!=null){
                    $this->db->where('par', $ticket->par);
        		  $this->db->update('tickets');
                }
                //mikrotik
                
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
        }else{
            $msg1="no redirect";        
		}

        if(strpos(strtolower($ticket->detalle), "reconexi")!==false){                        
                $datay=array();
                $datay['tid']=$ticket->id_factura;
                $insertar_tv=false;
                $insertar_internet=false;
                if($ticket->detalle=="Reconexion Combo" || $ticket->detalle=="Reconexion Television"){
                    //insertar tv si no hay en el invoice       
                    $insertar_tv=true;
                    $insertar_internet=true;
                }
                if($ticket->detalle=="Reconexion Internet"){
                    //insertar Internet si no hay en el invoice       
                    $insertar_internet=true;
                }

                    $producto = $this->db->query('SELECT * FROM products WHERE REPLACE(lower(product_name)," ","") LIKE "Television" ')->result_array();                    
                    $inv_item=$this->db->query('SELECT * from invoice_items WHERE REPLACE(lower(product)," ","") LIKE "%Television%" and tid="'. $datay['tid'].'"')->result_array();
                    if(count($inv_item)==0 && $insertar_tv==true){
                        $producto=$producto[0];
                       $datay['pid']=$producto['pid'];                        
                        $datay['tax']=$producto['taxrate'];
                        $datay['discount']=0;                        
                        $datay['totaldiscount']=0;
                        $x=intval($producto['product_price']);
                        $x=($x/31)*$diferencia->days;
                        $datay['product']=$producto['product_name'];
                        $datay['qty']=1;                        
                        $iva=round(($producto['product_price']*$producto['taxrate'])/100);
                        $iva=round(($iva/31)*$diferencia->days);
                        
                        $datay['price']=$x;
                        $datay['totaltax']=$iva;
                        $datay['subtotal']=$x+$iva;
                        $this->db->insert("invoice_items",$datay); //descomentar el lunes
                        $inv=$this->db->get_where("invoices",array("tid"=>$datay['tid']))->row();
                        $d_inv=array();
                        $d_inv['subtotal']=$inv->subtotal+$datay['price'];
                        $d_inv['total']=$inv->total+$datay['subtotal'];
                        $d_inv['tax']=$inv->tax+$datay['totaltax'];
                        $d_inv['estado_tv']=null;
                        
                        $this->db->update("invoices",$d_inv,array("tid"=>$datay['tid'])); //descomentar el lunes
                        
                    }    

                    $paquete = $this->input->post('paquete');
                    if($paquete=="null" || $paquete==null || $paquete=="" || $paquete=="-"){
                        $paquete = $ticket->section;
                    }
                    //insertar internet si no hay en el invoice       
                    $name=strtolower(str_replace(" ", "",$paquete ));
                    $producto = $this->db->query('SELECT * FROM products WHERE REPLACE(lower(product_name)," ","") LIKE "'.$name.'" ')->result_array();                    
                    $inv_item=$this->db->query('SELECT * from invoice_items WHERE REPLACE(lower(product)," ","") LIKE "%'.$name.'%" and tid="'. $datay['tid'].'"')->result_array();
                            if(count($inv_item)==0 && count($producto)!=0 && $insertar_internet==true){
                                $producto=$producto[0];
                               $datay['pid']=$producto['pid'];                        
                                $datay['tax']=$producto['taxrate'];
                                $datay['discount']=0;                        
                                $datay['totaldiscount']=0;
                                $x=intval($producto['product_price']);
                                $x=($x/31)*$diferencia->days;
                                $datay['product']=$producto['product_name'];
                                $datay['qty']=1;
                                $iva=0;
                                if($producto['taxrate']!=null && $producto['taxrate']!=0 && $producto['taxrate']!='0' && $producto['taxrate']!='null' && $producto['taxrate']!='' ){
                                    $iva=round(($producto['product_price']*$producto['taxrate'])/100);
                                    $iva=round(($iva/31)*$diferencia->days);
                                }
                                $datay['price']=$x;
                                $datay['totaltax']=$iva;
                                $datay['subtotal']=$x+$iva;

                                $this->db->insert("invoice_items",$datay); //descomentar el lunes
                                $inv=$this->db->get_where("invoices",array("tid"=>$datay['tid']))->row();
                                $d_inv=array();
                                $d_inv['subtotal']=$inv->subtotal+$datay['price'];
                                $d_inv['total']=$inv->total+$datay['subtotal'];
                                $d_inv['tax']=$inv->tax+$datay['totaltax'];
                                $d_inv['estado_combo']=null;
                                $this->db->update("invoices",$d_inv,array("tid"=>$datay['tid'])); //descomentar el lunes
                                
                            }                      
                            
                //termina reconexion combo o tv
                
                //completar el proceso aqui para cada uno de los casos insertar y actualizar valores monetarios
            


            
                
                

        }//abre en 868
		if($status=="Resuelto"){
        //var_dump($ticket->cid);
        //$customer=$this->db->get_where("customers",array('id' =>$ticket->cid))->row();
       
		if($ticket->detalle=="Subir megas" || $ticket->detalle=="Bajar megas"){
            $this->customers->edit_profile_mikrotik($customer->gid,$customer->name_s,$ptos,$customer->tegnologia_instalacion);
            $this->db->set('combo', $inter);

            $this->db->set('estado_combo', null);
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');

            $this->db->set('perfil', $ptos);
            $this->db->where('id', $ticket->cid);
            $this->db->update('customers');
		}
		if($ticket->detalle=="Reconexion Combo"){
			/*$paquete = $this->input->post('paquete');
            if($paquete=="null" || $paquete==null || $paquete=="" || $paquete=="-"){
                        $paquete = $ticket->section;
                    }*/
			//$this->db->set('combo', $paquete);
			$this->db->set('television', 'Television');
            $this->db->set('estado_tv', null);
            $this->db->set('estado_combo', null);
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		//historial estados
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Activo',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
             //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
		}		
		if($ticket->detalle=="Reconexion Internet"){
			/*$paquete = $this->input->post('paquete');
            if($paquete=="null" || $paquete==null || $paquete=="" || $paquete=="-"){
                        $paquete = $ticket->section;
                    }*/
			//$this->db->set('combo', $paquete);			
            $this->db->set('estado_combo', null);
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		//historial estados
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Activo',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
		}
		if($ticket->detalle=="Reconexion Television"){
			$paquete = $this->input->post('paquete');
			$this->db->set('television', 'Television');	
            $this->db->set('estado_tv', null);
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		//historial estados
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Activo',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
		}
       

		if($ticket->detalle=="Corte Combo"){

             /*$reconexion = '0';
                            if ($factura->combo!='no' || $factura->combo!='' || $factura->combo!='-'){
                                    $reconexion = '1';
                            } */ //preguntar si no es necesario este codigo
			//agregar reconexion
			//$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexion Combo'))->row();
				//$data2['tid']=$idfactura;
				//$data2['pid']=$producto2->pid;
                //$data2['product']=$producto2->product_name;
                //$data2['price']=$producto2->product_price;
				//$data2['qty']=1;
                //$data2['subtotal']=$producto2->product_price;			
            	//$this->db->insert('invoice_items',$data2);
			//actualizar factura
			//$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				//$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('ron', 'Cortado');				
				//$this->db->set('total', $factura->total+$producto2->product_price);
				//$this->db->set('items', $factura->items+1);
                //$this->db->set('rec', $reconexion);//preguntar por este campo
				
                /*$this->db->set('television', 'no');
				$this->db->set('combo', 'no');*/ //esto se comenta porque ya no se va a manejar con el no para cuando esta cortado sino con el estado del servicio si este campo esta en no quiere decir que no cuenta con este servicio el usuario
                $this->db->set('estado_tv', 'Cortado');
                $this->db->set('estado_combo', 'Cortado');
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
			//actualizar estado usuario
                $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Cortado');
        		$this->db->where('id', $ticket->cid);
        		//historial estados
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Cortado',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}

                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
		}
		if($ticket->detalle=="Corte Internet"){
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
			$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexión Internet'))->row();
			if ($factura->television==='no'  || $factura->television=='' || $factura->television==null || $factura->television=='-' || $factura->estado_tv=="Cortado" ||  $factura->estado_tv=="Suspendido"){
				$nestado = 'Cortado';
				$reconexion = '0';
			}else{
				$nestado = 'Activo';
				$reconexion = '1';
			}
				//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', $nestado);
        		$this->db->where('id', $ticket->cid);
        		//historial estado
				if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => $nestado,
					'col' => $ticket->codigo,
					);
					 if($this->db->insert("estados",$dataes)){
				//agregar reconexion	
				/*?>$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);<?php */
			//actualizar factura
				/*$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);*/
				$this->db->set('ron', $nestado);
				$this->db->set('rec', $reconexion);
				//$this->db->set('combo', 'no');
                $this->db->set('estado_combo', 'Cortado');
				$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');

			
             //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
				}
			}
		}
		if($ticket->detalle=="Corte Television"){
			//agregar reconexion
			/*$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexión Television'))->row();
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);*/
			//actualizar factura
			/*$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);*/
                $factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
                $this->db->set('estado_tv', 'Cortado');
				$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
			if ($factura->combo==='no' || $factura->combo=='' || $factura->combo==null || $factura->combo=='-' || $factura->estado_combo=="Cortado" || $factura->estado_combo=="Suspendido"){
                
				$this->db->set('ron', 'Cortado');
				//$this->db->set('television', 'no');
				$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
				//actualizar estado usuario
                $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Cortado');
        		$this->db->where('id', $ticket->cid);
        		//historial estado
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Cortado',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
			}else{
				//actualizar factura
				$this->db->set('ron', 'Activo');
				//para generar reconexion
				$this->db->set('rec', '1');	
				//$this->db->set('television', 'no');			
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
				//actualizar estado usuario
                $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Activo');
        		$this->db->where('id', $ticket->cid);
        		//historial estado
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Activo',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
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
			//$this->db->set('television', 'no');
			//$this->db->set('combo', 'no');
            $this->db->set('estado_tv', 'Suspendido');
            $this->db->set('estado_combo', 'Suspendido');

        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Suspendido');
        		$this->db->where('id', $ticket->cid);
        		//historial estados
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Suspendido',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
		}
		if($ticket->detalle=="Retiro voluntario"){			
			$this->db->set('ron', 'Retirado');
			//$this->db->set('television', 'no');
			//$this->db->set('combo', 'no');
            $this->db->set('estado_tv', 'Suspendido');
            $this->db->set('estado_combo', 'Suspendido');

        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', 'Retirado');
        		$this->db->where('id', $ticket->cid);
        		//historial estado
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => 'Retirado',
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
		}
		if($ticket->detalle=="Suspension Television"){
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
			if ($factura->combo===no){
				$status2 = 'Suspendido';
			}else{
				$status2 = 'Activo';
			}
			$this->db->set('ron', $status2);
			//$this->db->set('television', 'no');	
            $this->db->set('estado_tv', 'Suspendido');            	
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', $status2);
        		$this->db->where('id', $ticket->cid);
        		//historial estado
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => $status2,
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
		}
		if($ticket->detalle=="Suspension Internet"){
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
			if ($factura->television===no){
				$status2 = 'Suspendido';
			}else{
				$status2 = 'Activo';
			}
			$this->db->set('ron', $status2);
			//$this->db->set('combo', 'no');		            
            $this->db->set('estado_combo', 'Suspendido');	
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
			//actualizar estado usuario
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
				$this->db->set('usu_estado', $status2);
        		$this->db->where('id', $ticket->cid);
        		//historial estado
        		if($this->db->update('customers')){
				 $dataes = array(
					'cid' => $ticket->cid,
					'fecha' => date("Y-m-d H:i:s"),
					'estado' => $status2,
					'col' => $ticket->codigo,
					);
					 $this->db->insert("estados",$dataes);
				}
                 //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->desactivar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
		}
		if($ticket->detalle=="AgregarTelevision" || ($ticket->detalle=="Reconexion Television2" && ($ticket->id_factura!=0 || $ticket->id_factura!=null))){			
			$producto = $this->db->get_where('products',array('product_name'=>'Television'))->row();
            $total=0;
            $taxvalue=0;
            
					$datay['tid']=$idfactura;
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;					
                    /*$y=(3992/31)*$diferencia->days;
                    $total+=$x;
					$tax2+=$datay['totaltax'];
					$datay['price']=$x;
                    $datay['tax']=19;
					$datay['totaltax']=$y;
					$datay['subtotal']=$x+$datay['totaltax']; */
                    /*new changes*/    
                    if($producto->taxrate!=0 && $producto->taxrate!=null){
                        $taxvalue=round(($producto->product_price*$producto->taxrate)/100);
                        $taxvalue=round(round(($taxvalue/31))*$diferencia->days);
                        //$y+=$taxvalue;
                        $total+=$x;
                        $datay['tax']=$producto->taxrate;
                        $datay['totaltax']=$taxvalue;
                        $datay['price']=$x;
                        $datay['subtotal']=($x+$taxvalue);     //basarme en este cambio para agregar tv y hacer pruebas de todo, para mañana    
                    }else{
                        $total+=$x;
                        $datay['tax']=0;
                        $datay['totaltax']=0;
                        $datay['price']=$x;
                        $datay['subtotal']=$x;         
                    }   
                    /*end new changes*/    
                    //var_dump($total);
                    /*serv ads*/  
                    $list_servs=$this->invoices->servicios_adicionales($idfactura,false);
                $list_servs=$this->invoices->servicios_adicionales_idt($ticket->idt,$lista_servs);
                //var_dump($ticket->id_invoice);
                //var_dump($list_servs);
                foreach ($list_servs as $key_s => $serv_val) {
                    $data_serv=array();
                    $data_serv['tid_invoice']=$idfactura;
                    $data_serv['pid']=$serv_val['pid'];
                    $data_serv['valor']=$serv_val['valor'];
                    $data_serv['subtotal']=$serv_val['subtotal'];
                    $data_serv['total']=$serv_val['total'];
                    $this->db->insert("servicios_adicionales",$data_serv);
                        $producto = $this->db->get_where('products',array('pid'=>$serv_val['pid']))->row();
                        $data_item_serv=array();
                        $data_item_serv['pid']=$producto->pid;
                        $data_item_serv['tid']=$idfactura;
                        $data_item_serv['product']=$producto->product_name;
                        $data_item_serv['qty']=$serv_val['valor'];
                        if(!is_numeric($serv_val['valor'])){
                            $data_item_serv['qty']=1;
                        }
                        /*falta calcular el precio segun los dias y añadir el valor de estos item_invoice al valor de la factura*/
$x=0;
                        $x=$producto->product_price;
                    $x=round($x/31);
                    $x=round($x*$diferencia->days);
                    $total+=round($x*$data_item_serv['qty']);
                    //$tax2+=$datay['totaltax'];
                        $data_item_serv['tax']=0;
                        $data_item_serv['totaltax']='';
                        $data_item_serv['price']=$x;
                        $data_item_serv['subtotal']=round($x*$data_item_serv['qty']);
                        $this->db->insert('invoice_items',$data_item_serv);
                }
           // }
            //$data['subtotal']=$total;
            
            //$data['total']=$data['subtotal']+$data['tax'];             
                    /*end serv ads*/
                    $this->db->insert('invoice_items',$datay);
            $factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
            //var_dump($factura->subtotal);
            //var_dump($total);
				$this->db->set('subtotal', $factura->subtotal+$total);
				$this->db->set('tax', $factura->tax+$taxvalue);
				$this->db->set('total', $factura->total+$total+$taxvalue);
				$this->db->set('television', 'Television');
                $this->db->set('estado_tv', null);
				$this->db->set('puntos', $ptos);
        		$this->db->where('tid', $idfactura);
        		if ($this->db->update('invoices')){
			//actualizar contrato usuario
                $this->db->set("f_contrato",date("Y-m-d"));
        		$this->db->where('id', $ticket->cid);
        		$this->db->update('customers');
				}
			
		}
		//nuevo servicio
		if($ticket->detalle=="AgregarInternet" || ($ticket->detalle=="Reconexion Internet2" && ($ticket->id_factura!=0 || $ticket->id_factura!=null))){	
		$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
		$datay['tid']=$idfactura;
        $datay['qty']=1;
        $datay['tax']=0;
        $datay['discount']=0;        
        $datay['totaldiscount']=0;
			//agregar servicio nuevo
        $y=0;
                if($data['combo']!==no){
                    $producto = $this->db->get_where('products',array('product_name'=>$inter))->row();
					$datay['pid']=$producto->pid;
                    $x=intval($producto->product_price);
                    $x=($x/31)*$diferencia->days;
                    
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
					$tax2+=$datay['totaltax'];
					
                    /*new */
                    if($producto->taxrate!=0 && $producto->taxrate!=null){
                       /* $taxvalue=round(($producto->product_price*$producto->taxrate)/100);
                        $taxvalue=round(round(($taxvalue/31))*$diferencia->days);
                        $y=$taxvalue;
                        $total=($x-$taxvalue);
                        $datay['tax']=$producto->taxrate;
                        $datay['totaltax']=$taxvalue;
                        $datay['price']=($x-$taxvalue);
                        $datay['subtotal']=$x;  
*/
                        $taxvalue=round(($producto->product_price*$producto->taxrate)/100);
                        $taxvalue=round(round(($taxvalue/31))*$diferencia->days);
                        $y=$taxvalue;
                        $total=$x;
                        $datay['tax']=$producto->taxrate;
                        $datay['totaltax']=$taxvalue;
                        $datay['price']=$x;
                        $datay['subtotal']=($x+$taxvalue);       
                    }else{
                        $total=$x;
                        $datay['tax']=0;
                        $datay['totaltax']=0;
                        $datay['price']=$x;
                        $datay['subtotal']=$x;         
                    }  
                    /*end new*/   
                    $this->db->insert('invoice_items',$datay);

                }
             /*serv ads*/  
                    $list_servs=$this->invoices->servicios_adicionales($idfactura,false);
                $list_servs=$this->invoices->servicios_adicionales_idt($ticket->idt,$lista_servs);
                //var_dump($ticket->id_invoice);
                //var_dump($list_servs);
                foreach ($list_servs as $key_s => $serv_val) {
                    $data_serv=array();
                    $data_serv['tid_invoice']=$idfactura;
                    $data_serv['pid']=$serv_val['pid'];
                    $data_serv['valor']=$serv_val['valor'];
                    $data_serv['subtotal']=$serv_val['subtotal'];
                    $data_serv['total']=$serv_val['total'];
                    $this->db->insert("servicios_adicionales",$data_serv);
                        $producto = $this->db->get_where('products',array('pid'=>$serv_val['pid']))->row();
                        $data_item_serv=array();
                        $data_item_serv['pid']=$producto->pid;
                        $data_item_serv['tid']=$idfactura;
                        $data_item_serv['product']=$producto->product_name;
                        $data_item_serv['qty']=$serv_val['valor'];
                        if(!is_numeric($serv_val['valor'])){
                            $data_item_serv['qty']=1;
                        }
                        /*falta calcular el precio segun los dias y añadir el valor de estos item_invoice al valor de la factura*/
$x=0;
                        $x=$producto->product_price;
                    $x=round($x/31);
                    $x=round($x*$diferencia->days);
                    $total+=round($x*$data_item_serv['qty']);
                    //$tax2+=$datay['totaltax'];
                        $data_item_serv['tax']=0;
                        $data_item_serv['totaltax']='';
                        $data_item_serv['price']=$x;
                        $data_item_serv['subtotal']=round($x*$data_item_serv['qty']);
                        $this->db->insert('invoice_items',$data_item_serv);
                }
				$this->db->set('subtotal', $factura->subtotal+$total);
				$this->db->set('tax', ($factura->tax+$y));
				$this->db->set('total', $factura->total+($total+$y));
				$this->db->set('combo', $inter);
                $this->db->set('estado_combo', null);
        		$this->db->where('tid', $idfactura);
        		if ($this->db->update('invoices')){
					//actualizar contrato usuario
					$this->db->set("f_contrato",date("Y-m-d"));
					$this->db->where('id', $ticket->cid);
					$this->db->update('customers');
					}

                  //mikrotik
                $customerx=$this->db->get_where("customers",array('id' =>$ticket->cid ))->row();
                $this->customers->activar_estado_usuario($customerx->name_s,$customerx->gid,$customerx->tegnologia_instalacion);
			
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
		}//abre en line 963
		
        $dataz['status']=$status;
        $dataz['fecha_final']=$fecha_final;
        if ($this->db->update('tickets',$dataz,array('idt'=>$tid))){
			if ($status=='Pendiente'){
				$color = '#4CB0CB';
				$this->db->set('start', date("Y-m-d H:i:s"));
                $this->db->set('end', date("Y-m-d H:i:s"));
			}else{
				$color = '#a3a3a3';
				$this->db->set('end', $fecha_final);
			}
			//cambio color al finalizar
			$this->db->set('color', $color);
			
        	$this->db->where('idorden', $ticket->codigo);
        	$this->db->update('events');
            $data_h['modulo']="Tickets";
                $data_h['accion']="Editando evento ticket linea 1630";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']="editando end=".$fecha_final;
                $data_h['id_fila']=$ticket->codigo;
                $data_h['tabla']="events";
                $data_h['nombre_columna']="idorden";
                $this->db->insert("historial_crm",$data_h);
		};
				
		
		
		
        echo json_encode(array('msg1'=>$msg1,'tid'=>$data['tid'],'status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
		}//abre 676
    }
		
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
                $config['max_size'] = 900000;
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