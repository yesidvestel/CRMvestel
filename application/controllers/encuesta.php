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

class encuesta extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('encuesta_model', 'encuesta');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('encuestas/clist');
        $this->load->view('fixed/footer');
    }

    public function create()
    {
		
		$this->load->model('ticket_model', 'ticket');
		$codigo = $this->input->get('id');
		$ticket = $this->db->get_where('tickets',array('codigo'=>$codigo))->row();
		$thread_id = $ticket->idt;
		$data['thread_info'] = $this->ticket->thread_info($thread_id);
		$data['thread_list'] = $this->ticket->thread_list($thread_id);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Nueva Encuesta';
        $this->load->view('fixed/header', $head);
        $this->load->view('encuestas/create',$data);
        $this->load->view('fixed/footer');
    }
	public function newats()
    {
		
		$this->load->model('ticket_model', 'ticket');
		$codigo = $this->input->get('id');
		$ticket = $this->db->get_where('tickets',array('codigo'=>$codigo))->row();
		$thread_id = $ticket->idt;
		$data['colaborador'] = $this->encuesta->info_colaborador();
		$data['rol'] = $this->aauth->get_user()->roleid;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Nueva Encuesta';
        $this->load->view('fixed/header', $head);
        $this->load->view('encuestas/newats',$data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        $custid = $this->input->get('id');
        $data['rta'] = $this->encuesta->detall_colaborador($custid);
        //$data['customergroup'] = $this->supplier->group_info($data['details']['gid']);
        //$data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('encuestas/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
        $list = $this->encuesta->get_datatables();
        $data = array();
		$encuestador = $this->db->get_where('aauth_users',array('id'=>$encuesta->idemp))->row();
        $no = $this->input->post('start');
        foreach ($list as $encuesta) {
            $no++;
			$encuestador = $this->db->get_where('aauth_users',array('id'=>$encuesta->idemp))->row();
            $row = array();
            $row[] = $no;
            $row[] = $encuesta->norden;
            $row[] = $encuesta->idtec;
            $row[] = $encuestador->username;
            $row[] = $encuesta->presentacion;
            $row[] = $encuesta->trato;
			$row[] = $encuesta->estado;
			$row[] = $encuesta->tiempo;
			$row[] = $encuesta->recomendar;
			$row[] = $encuesta->observacion;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->encuesta->count_all(),
            "recordsFiltered" => $this->encuesta->count_filtered(),
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

    public function addencuesta()
    {
        $codigo = $this->input->post('norden');
		$us = $this->aauth->get_user()->id;
		$emp = $this->input->post('tecnico');
        $presentar = $this->input->post('uno');
        $trato = $this->input->post('dos');
        $estado = $this->input->post('tres');
        $tiempo = $this->input->post('cuatro');
        $recomendar = $this->input->post('cinco');
        $obs = $this->input->post('observacion');
        $detalle = $this->input->post('detalle');        

        $this->encuesta->add($us, $emp, $codigo, $detalle, $presentar, $trato, $estado, $tiempo, $recomendar, $obs);

    }
	public function addats()
    {
        $us = $this->aauth->get_user()->id;
		$ubicacion = $this->input->post('ubicacion');
        $fecha = date("Y-m-d",strtotime($this->input->post('fecha')));
        $lugar = $this->input->post('lugar');
        $horain = date("H:i",strtotime($this->input->post('horain')));
        $horafin = date("H:i",strtotime($this->input->post('horafin')));
		$tarea = $this->input->post('tarea');
        $alturas = $this->input->post('alturas');
        $casco = $this->input->post('casco');
        $gafas = $this->input->post('gafas');
		$monogafas = $this->input->post('monogafas');
		$tapaoidos = $this->input->post('tapaoidos');
		$guantes = $this->input->post('guantes');
		$careta = $this->input->post('careta');
		$arnes = $this->input->post('arnes');
		$aux = $this->input->post('1er_aux');
		$eslinga = $this->input->post('eslinga');
		$respirador = $this->input->post('respirador');
		$mosquete = $this->input->post('mosquete');
		$otros = $this->input->post('otros');
		$manual1 = $this->input->post('manual1');
		$manual2 = $this->input->post('manual2');
		$electro1 = $this->input->post('electro1');
		$electro2 = $this->input->post('electro2');
		$mecan1 = $this->input->post('mecan1');
		$mecan2 = $this->input->post('mecan2');
		$otras1 = $this->input->post('otras1');
		$otras2 = $this->input->post('otras2');
		$alto = $this->input->post('alto');
		$acceso = $this->input->post('acceso');
		$puntos = $this->input->post('puntos');
		$distancia = $this->input->post('distancia');
		$prevencion = $this->input->post('prevencion');
		$proteccion = $this->input->post('proteccion');
		$trabajadores = $this->input->post('trabajadores');
		$materiales = $this->input->post('materiales');
		$peligros = $this->input->post('peligros');
		$peligro_otros = $this->input->post('peligro_otros');
		$tarea1 = $this->input->post('tarea1');
		$tarea2 = $this->input->post('tarea2');
		$tarea3 = $this->input->post('tarea3');
		$tarea4 = $this->input->post('tarea4');
		$tarea5 = $this->input->post('tarea5');
		$riesgo1 = $this->input->post('riesgo1');
		$riesgo2 = $this->input->post('riesgo2');
		$riesgo3 = $this->input->post('riesgo3');
		$riesgo4 = $this->input->post('riesgo4');
		$riesgo5 = $this->input->post('riesgo5');
		$consecuencia1 = $this->input->post('consecuencia1');
		$consecuencia2 = $this->input->post('consecuencia2');
		$consecuencia3 = $this->input->post('consecuencia3');
		$consecuencia4 = $this->input->post('consecuencia4');
		$consecuencia5 = $this->input->post('consecuencia5');
		$control1 = $this->input->post('control1');
		$control2 = $this->input->post('control2');
		$control3 = $this->input->post('control3');
		$control4 = $this->input->post('control4');
		$control5 = $this->input->post('control5');
		$incidente = $this->input->post('incidente');
		$seguro = $this->input->post('seguro');
        $this->encuesta->addats($us, $ubicacion, $fecha, $lugar, $horain, $horafin, $tarea, $alturas, $casco, $gafas, $monogafas, $tapaoidos, $guantes, $careta, $arnes, $aux, $eslinga, $respirador, $mosquete, $otros,
							$manual1, $manual2, $electro1,$electro2,$mecan1,$mecan2,$otras1,$otras2,$alto,$acceso,$puntos,$distancia,$prevencion,$proteccion,$trabajadores,$materiales,$peligros,$peligro_otros,$tarea1,
							 $tarea2,$tarea3,$tarea4,$tarea5,$riesgo1,$riesgo2,$riesgo3,$riesgo4,$riesgo5,$consecuencia1,$consecuencia2,$consecuencia3,$consecuencia4,$consecuencia5,$control1,$control2,$control3,
							 $control4,$control5,$incidente,$seguro);

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


    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->supplier->delete($id)) {
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
            $this->supplier->editpicture($id, $img);
        }


    }


    public function translist()
    {
        $cid = $this->input->post('cid');
        $list = $this->encuesta->trans_table();
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->idats;
			$row[] = $prd->fecha;
			$row[] = $prd->name;
			$row[] = $prd->dto;
			$row[] = $prd->phone;
			$row[] = $prd->city;
            $row[] = '<a href="' . base_url() . 'encuesta/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span> ' . $this->lang->line('Delete') . '</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->encuesta->trans_count_all(),
            "recordsFiltered" => $this->encuesta->trans_count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function inv_list()
    {
        $cid = $this->input->post('cid');
        $list = $this->supplier->inv_datatables($cid);
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->inv_count_all($cid),
            "recordsFiltered" => $this->supplier->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }


    public function listats()
    {
        $custid = $this->input->get('id');
        //$data['details'] = $this->supplier->details($custid);
        //$data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier';
        $this->load->view('fixed/header', $head);
        $this->load->view('encuestas/listats');
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {
        $custid = $this->input->get('id');
        $data['details'] = $this->supplier->details($custid);

        $data['money'] = $this->supplier->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Supplier Invoices';
        $this->load->view('fixed/header', $head);
        $this->load->view('supplier/invoices', $data);
        $this->load->view('fixed/footer');
    }


}