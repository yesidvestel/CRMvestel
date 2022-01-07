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

class Templates extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('templates_model','templates');

    }


    public function email()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emails'] = $this->templates->get_template(6,13);
        $head['title'] = 'Email Templates';
        $this->load->view('fixed/header');
        $this->load->view('templates/email',$data);
        $this->load->view('fixed/footer');
    }

    public function email_update()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $subject = $this->input->post('subject');
            $body = $this->input->post('body');

             $this->templates->edit($id,$subject,$body);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $id = $this->input->get('id');
            $head['title'] = 'Edit Email Template';
            $data['email'] = $this->templates->template_info($id );
            $this->load->view('fixed/header');
            $this->load->view('templates/email-edit', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function sms()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emails'] = $this->templates->get_template();
        $head['title'] = 'Email Templates';
        $this->load->view('fixed/header');
        $this->load->view('templates/sms',$data);
        $this->load->view('fixed/footer');
    }

    public function sms_update()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $subject = 'SMS';
            $body = $this->input->post('body');

            $this->templates->edit($id,$subject,$body);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $id = $this->input->get('id');
            $head['title'] = 'Edit SMS Template';
            $data['sms'] = $this->templates->template_info($id );
            $this->load->view('fixed/header');
            $this->load->view('templates/sms-edit', $data);
            $this->load->view('fixed/footer');
        }
    }
	public function sms_add()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emails'] = $this->templates->get_template(30,40);
        $head['title'] = 'Email Templates';
        $this->load->view('fixed/header');
        $this->load->view('templates/sms-add');
        $this->load->view('fixed/footer');
    }
	 public function sms_input()
    {
        
            $name = $this->input->post('nombre');
            $body = $this->input->post('body');
            $this->templates->input($name,$body);

    } 
	public function local()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['barrios'] = $this->templates->get_barrios();
        $head['title'] = 'Email Templates';
        $this->load->view('fixed/header');
        $this->load->view('templates/localizaciones',$data);
        $this->load->view('fixed/footer');
    }
	public function barrio_add()
    {
		$this->load->model('customers_model', 'customers');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['departamentos'] = $this->customers->departamentos_list();
        $head['title'] = 'lista barrios';
        $this->load->view('fixed/header');
        $this->load->view('templates/barrio-add',$data);
        $this->load->view('fixed/footer');
    }
	public function barrio_input()
    {
        
            $depar = $this->input->post('depar');
            $ciudad = $this->input->post('ciudad');
            $localidad = $this->input->post('localidad');
            $barrio = $this->input->post('barrio');
            $this->templates->input_barrio($depar,$ciudad,$localidad,$barrio);

    }
	public function barrio_edit()
    {
			$this->load->model('customers_model', 'customers');
            $head['usernm'] = $this->aauth->get_user()->username;
            $id = $this->input->get('id');
            $head['title'] = 'Edit barrio';
			$data['departamentos'] = $this->customers->departamentos_list();
            $data['infobarrio'] = $this->templates->barrio_info($id);
            $this->load->view('fixed/header');
            $this->load->view('templates/barrio-edit', $data);
            $this->load->view('fixed/footer');
        
    }
	public function barrio_update()
    {
			$id = $this->input->post('id');
			$depar = $this->input->post('depar');
            $ciudad = $this->input->post('ciudad');
            $localidad = $this->input->post('localidad');
            $barrio = $this->input->post('barrio');
            $this->templates->edit_barrio($id,$depar,$ciudad,$localidad,$barrio);
        
    }
	public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->templates->delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	public function local_add()
    {
		$this->load->model('customers_model', 'customers');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['departamentos'] = $this->customers->departamentos_list();
        $head['title'] = 'lista barrios';
        $this->load->view('fixed/header');
        $this->load->view('templates/local-add',$data);
        $this->load->view('fixed/footer');
    }
	public function local_input()
    {
        
            $depar = $this->input->post('depar');
            $ciudad = $this->input->post('ciudad');
            $localidad = $this->input->post('localidad');
            $this->templates->input_local($depar,$ciudad,$localidad);

    }
	public function ciudad_add()
    {
		$this->load->model('customers_model', 'customers');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['departamentos'] = $this->customers->departamentos_list();
        $head['title'] = 'agregar ciudad';
        $this->load->view('fixed/header');
        $this->load->view('templates/ciudad-add',$data);
        $this->load->view('fixed/footer');
    }
	public function ciudad_input()
    {
        
            $depar = $this->input->post('depar');
            $ciudad = $this->input->post('ciudad');
            $this->templates->input_ciudad($depar,$ciudad);

    }
	public function depar_add()
    {
		$this->load->model('customers_model', 'customers');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['departamentos'] = $this->customers->departamentos_list();
        $head['title'] = 'agregar ciudad';
        $this->load->view('fixed/header');
        $this->load->view('templates/depar-add',$data);
        $this->load->view('fixed/footer');
    }
	public function depar_input()
    {
        
            $depar = $this->input->post('depar');
            $this->templates->input_depar($depar);

    }
}