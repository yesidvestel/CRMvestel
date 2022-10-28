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

class Quote extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('quote_model', 'quote');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    //create invoice
    public function create()
    {
        $this->load->model('customers_model', 'customers');
        $this->load->model('plugins_model', 'plugins');
		$this->load->model('ticket_model', 'ticket');
		$this->load->model('invoices_model', 'invocies');
        $this->load->model('Moviles_model', 'moviles');
		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['exchange'] = $this->plugins->universal_api(5);
		$data['paquete'] = $this->invocies->paquetes('tv');
		$data['paqueteinter'] = $this->invocies->paquetes('inter');
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
		$data['localidades'] =$this->customers->localidades_list($data['details']['ciudad']);
		$data['facturalist'] = $this->ticket->factura_list($custid);
        $data['currency'] = $this->quote->currencies();
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastquote'] = $this->quote->lastquote();
        $data['terms'] = $this->quote->billingterms();
        $head['title'] = "New Quote";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->quote->warehouses();
        $data['moviles'] = $this->moviles->get_datatables1();
        $data['servicios_por_sedes']=$this->invocies->get_servicios();
        if(isset( $data['details']['gid'])){
        	$data['sede_actual']=$this->db->get_where("customers_group",array("id"=>$data['details']['gid']))->row();
        }
        $conteo=$this->db->get_where("tickets",array("cid"=>$custid,"status"=>"Pendiente"))->result_array();        
        $data['conteo_pendientes']=count($conteo);
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/newquote', $data);
        $this->load->view('fixed/footer');
    }

    //edit invoice
    public function edit()
    {
        $this->load->model('ticket_model', 'ticket');
		$this->load->model('invoices_model', 'invocies');
		$this->load->model('customers_model', 'customers');
        $thread_id = intval($this->input->get('id'));
		$ticket = $this->db->get_where('tickets', array('idt' => $thread_id))->row();
		$custid = $ticket->cid;
		$codigo = $ticket->codigo;
        $data['id'] = $tid;
        $data['title'] = "Quote $tid";
        $data['thread_info'] = $this->ticket->thread_info($thread_id);
		$data['thread_agen'] = $this->ticket->thread_agen($codigo);
		$data['temporal'] = $this->quote->group_tempo($codigo);
		$data['local'] = $this->customers->group_localidad($data['temporal']['localidad']);
		$data['barrio'] = $this->customers->group_barrio($data['temporal']['barrio']);
		$data['localidades'] =$this->customers->localidades_list($data['thread_info']['ciudad']);
		$data['paquete'] = $this->invocies->paquetes('tv');
		$data['paqueteinter'] = $this->invocies->paquetes('inter');
        $data['thread_list'] = $this->ticket->thread_list($thread_id);
		$data['facturalist'] = $this->ticket->factura_list($custid);
        $head['title'] = "Edit Quote #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->quote->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/edit', $data);
        $this->load->view('fixed/footer');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Quote";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/quotes');
        $this->load->view('fixed/footer');
    }

    //action
    public function action()
    {
		
        $customer_id = $this->input->post('customer_id');
		$gen = $this->aauth->get_user()->username;
		$nticket = $this->input->post('ticketnumero');
        $subject = $this->input->post('subject');
        $detalle = $this->input->post('detalle');
        $created = $this->input->post('created');
		$problema = $this->input->post('problema_red');        
        $section = $this->input->post('section');
		$factura = $this->input->post('factura');
		$agendar = $this->input->post('agendar');
		$fagenda = $this->input->post('f_agenda');
		$tec = $this->input->post('tecnico');
        $movil = $this->input->post('movil');
		$nomen = $this->input->post('nomenclatura');
		$nuno = $this->input->post('numero1');
		$auno = $this->input->post('adicional1');
		$ndos = $this->input->post('numero2');
		$ados = $this->input->post('adicional2');
		$ntres = $this->input->post('numero3');
		$local = $this->input->post('localidad');
		$barrio = $this->input->post('barrio');
		$recider = $this->input->post('residencia');
		$refer = $this->input->post('referencia');
		$hora = $this->input->post('hora');
		$hora2 = date("H:i",strtotime($this->input->post('hora')));
		$tv = $this->input->post('tele');
		$inter = $this->input->post('inter');
		$bainter = $this->input->post('bainter');
		$suinter = $this->input->post('suinter');
		$punto = $this->input->post('punto');
        $bapaquete = $this->input->post('bapaquete');
        $supaquete = $this->input->post('supaquete');
        $detalle=str_replace("_"," ",$detalle);
     if($detalle=="AgregarInternet"){
            $inter = $this->input->post('interB');
            $tv="no";
     }else if($detalle=="AgregarTelevision"){
            $tv = $this->input->post('teleB');
            $inter="no";
            $punto = $this->input->post('puntoB');            
     }else if($detalle=="Revision_de_Internet"){
        $problema = $this->input->post('problema_red');
     }else if($detalle=="Revision_de_television"){
        $problema = $this->input->post('problema_tv');
     }
        if($detalle=="Instalacion"){
            $factura="null";
       }
        
        if ($customer_id) {
        	$this->quote->addticket($customer_id, $gen, $nticket, $subject, $detalle, $created, $problema, $bapaquete, $supaquete, $section, $factura,$agendar,$fagenda, $tec, $hora,$hora2,$nomen,$nuno,$auno,$ndos,$ados,$ntres,$local,$barrio,$recider, $refer, $tv,$inter,$bainter, $suinter, $punto,$movil);
			
		}


    }


    public function ajax_list()
    {

        $list = $this->quote->get_datatables();
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("quote/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("quote/printquote?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->quote->count_all(),
            "recordsFiltered" => $this->quote->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist();
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "Quote $tid";
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
        $data['attach'] = $this->quote->attach($tid);


        $data['employee'] = $this->quote->employee($data['invoice']['eid']);

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/view', $data);
        $this->load->view('fixed/footer');

    }


    public function printquote()
    {

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;
        $data['title'] = "Quote $tid";
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
        $data['employee'] = $this->quote->employee($data['invoice']['eid']);

        ini_set('memory_limit', '64M');

        $html = $this->load->view('quotes/view-print-'.LTR, $data, true);


        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Quote_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Quote_#' . $tid . '.pdf', 'I');
        }


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->quote->quote_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editaction()
    {

        $customer_id = $this->input->post('customer_id');
		$nticket = $this->input->post('ticketnumero');
		$agendar = $this->input->post('agendar');
		$fagenda = $this->input->post('f_agenda');
		$hora2 = $this->input->post('hora');
		$hora = date("H:i",strtotime($hora2));
        $subject = $this->input->post('subject');
        $detalle = $this->input->post('detalle');
        $created = $this->input->post('created');
		$problema = $this->input->post('problema');
        $section = $this->input->post('section');
		$factura = $this->input->post('factura');
		$nomen = $this->input->post('nomenclatura');
		$nuno = $this->input->post('numero1');
		$auno = $this->input->post('adicional1');
		$ndos = $this->input->post('numero2');
		$ados = $this->input->post('adicional2');
		$ntres = $this->input->post('numero3');
		$local = $this->input->post('localidad');
		$barrio = $this->input->post('barrio');
		$recider = $this->input->post('residencia');
		$refer = $this->input->post('referencia');
		$tv = $this->input->post('tele');
		$inter = $this->input->post('inter');
		$bainter = $this->input->post('bainter');
		$suinter = $this->input->post('suinter');
		$punto = $this->input->post('punto');
        $bill_date = datefordatabase($created);
		$supaquete = $this->input->post('supaquete');
		$bapaquete = $this->input->post('bapaquete');
		$detalle=str_replace("_"," ",$detalle);
        if($detalle=="AgregarInternet"){
            $inter = $this->input->post('interB');
            $tv="no";
         }else if($detalle=="AgregarTelevision"){
                $tv = $this->input->post('teleB');
                $inter="no";
                $punto = $this->input->post('puntoB');            
         }      
         if ($tv=='no' || $tv==''){
				$tv2 = '';
			}else{
				$tv2 = $tv;
			}
			if ($inter=='no' || $inter==''){
				$int2 = '';
			}else{
				$int2 = ' + '.$inter;
			}
			if ($punto=='0' || $punto==''){
				$pto2 = '';
			}else{
				$pto2 = ' + '.$punto.' Puntos';
			}    
        $data = array(
			'codigo' => $nticket, 
			'subject' => $subject, 
			'detalle' => $detalle, 
			'created' => $bill_date,
			'problema' => $problema,
			'section' => $section,
			'id_factura' => $factura
		);
        $this->db->set($data);
        $this->db->where('idt', $customer_id);
		$this->db->update('tickets');
		//traslado
		if ($detalle==='Traslado'){
			$data3 = array(					
					'nomenclatura' => $nomen,
					'nuno' => $nuno,            
					'auno' => $auno,
					'ndos' => $ndos,
					'ados' => $ados,
					'ntres' => $ntres,
					'localidad' => $local,
					'barrio' => $barrio,
					'residencia' => $recider,
					'referencia' => $refer
				);
				$this->db->where('corden', $nticket);
				$this->db->update('temporales', $data3);
		}
		//instalacion
		if ($detalle==='Instalacion' || $detalle==='Activacion'){
			$data3 = array(					
					'tv' => $tv,
					'internet' => $inter,            
					'puntos' => $punto
				);
				$this->db->where('corden', $nticket);
			if ($this->db->update('temporales', $data3)){
					$this->db->set('section',$tv2.' '.$int2.' '.$pto2.' '.$section);
        			$this->db->where('idt', $customer_id);
					$this->db->update('tickets');
				}
		}
		//agregar servicio
		if ($detalle==='AgregarTelevision'){
			$data3 = array(					
					'tv' => $tv,            
					'puntos' => $punto
				);
				$this->db->where('corden', $nticket);
				if ($this->db->update('temporales', $data3)){
					$this->db->set('section',$tv2.' '.$pto2.' '.$section);
        			$this->db->where('idt', $customer_id);
					$this->db->update('tickets');
				}
		}
		
		if ($detalle==='AgregarInternet'){
			$data3 = array(
					'internet' => $inter, 
				);
				$this->db->where('corden', $nticket);
				if ($this->db->update('temporales', $data3)){
					$this->db->set('section',$int2.' '.$section);
        			$this->db->where('idt', $customer_id);
					$this->db->update('tickets');
				}
		}
		//subir megas
			if ($detalle=='Subir megas'){
				$data4 = array(
				'internet' => $suinter,
				'puntos' => $supaquete,
			);
				$this->db->where('corden', $nticket);
				if ($this->db->update('temporales', $data4)){
					$this->db->set('section', $suinter.' '.$section);
        			$this->db->where('idt', $customer_id);
					$this->db->update('tickets');
				}
		}
		//subir megas
			if ($detalle=='Bajar megas'){
				$data4 = array(
				'internet' => $bainter,
				'puntos' => $bapaquete,
			);
				$this->db->where('corden', $nticket);
				if ($this->db->update('temporales', $data4)){
					$this->db->set('section', $bainter.' '.$section);
        			$this->db->where('idt', $customer_id);
					$this->db->update('tickets');
				}
		}
		$start = date("Y-m-d",strtotime($fagenda));
			//agenda
		$boleta = $this->db->get_where('tickets', array('codigo' => $nticket))->row();
		$abonado = $this->db->get_where('customers', array('id' => $boleta->cid))->row();
			if ($agendar==actualizar){
				
				$data2 = array(					
					'title' => 'Usuario #'.$abonado->abonado.' '.$detalle.' '.$hora2,
					'start' => $start.' '.$hora,            
					'description' => strip_tags($section),
					'rol' => $boleta->asignado,
					'asigno' => $this->aauth->get_user()->id
				);
				$this->db->where('idorden', $nticket);
				$this->db->update('events', $data2);
				$data_h['modulo']="Quotes";
                $data_h['accion']="Editando evento quotes linea 450";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=json_encode($data2);
                $data_h['id_fila']=$nticket;
                $data_h['tabla']="events";
                $data_h['nombre_columna']="idorden";
                $this->db->insert("historial_crm",$data_h);
			}else if ($agendar==si){
			$boleta = $this->db->get_where('tickets', array('codigo' => $nticket))->row();
			$abonado = $this->db->get_where('customers', array('id' => $boleta->cid))->row();
			
				$data2 = array(
					'idorden' => $nticket,
					'title' => 'Usuario #'.$abonado->abonado.' '.$detalle.' '.$hora2,
					'start' => $start.' '.$hora,            
					'description' => strip_tags($section),
					'rol' => $boleta->asignado,
					'asigno' => $this->aauth->get_user()->id
				);
				$this->db->insert('events', $data2);
			}
		
		

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
        


        
    }


    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');


        $this->db->set('status', $status);
        $this->db->where('tid', $tid);
        $this->db->update('quotes');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Quote Status updated') . '', 'pstatus' => $status));
    }

    public function convert()
    {
        $tid = $this->input->post('tid');


        if ($this->quote->convert($tid)) {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('Quote to invoice conversion')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function file_handling()
    {
        if($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->quote->meta_delete($invoice,2, $name)){
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
                $fid = rand(100, 9999);
                $this->quote->meta_insert($id, 2, $files);
            }
        }


    }


}