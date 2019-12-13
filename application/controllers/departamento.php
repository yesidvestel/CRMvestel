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

class departamento extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('departamento_model', 'departamento');
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    //groups
    public function index()
    {
        $data['group'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'departamento';
        $this->load->view('fixed/header', $head);
        $this->load->view('departamento/departamento', $data);
        $this->load->view('fixed/footer');
    }

    //view
    public function groupview()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('idDepartamento');
        $data['group'] = $this->clientgroup->details($id);
        $head['title'] = 'departamento View';
        $this->load->view('fixed/header', $head);
        $this->load->view('departamento/departamentoview', $data);
        $this->load->view('fixed/footer');
    }

    //datatable
    public function departamentolist()

    {
        $base = base_url() . 'customers/';
        $id = $this->input->get('idDepartamento');
        $list = $this->customers->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = '<a href="' . $base . 'view?id=' . $customers->id . '">' . $customers->name . ' </a>';
            $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
            $row[] = $customers->email;
            $row[] = $customers->phone;
            $row[] = '<a href="' . $base . 'edit?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="icon-pencil"></span> '.$this->lang->line('Edit').'</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all($id),
            "recordsFiltered" => $this->customers->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function create()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create departamento';
        $this->load->view('fixed/header', $head);
        $this->load->view('departamento/add');
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $departamento = $this->input->post('departamento');
        

        if ($departamento) {
            $this->departamento->add($departamento);
        }
    }

    public function editdepartamento()
    {
        $gid = $this->input->get('idDepartamento');
        $this->db->select('*');
        $this->db->from('departamentos');
        $this->db->where('idDepartamentos', $gid);
        $query = $this->db->get();
        $data['group'] = $query->row_array();

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit departamento';
        $this->load->view('fixed/header', $head);
        $this->load->view('departamento/departamentoedit', $data);
        $this->load->view('fixed/footer');

    }

    public function editdepartamentoupdate()
    {
        $gid = $this->input->post('gid');
        $group_name = $this->input->post('departamento');        
        if ($gid) {
            $this->clientgroup->editgroupupdate($gid, $group_name);
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($idDepartamento != 1) {
            $this->db->delete('departamentos', array('idDepartamentos' => $id));
            $this->db->set(array('gid' => 1));
            $this->db->where('gid', $idDepartamento);
            $this->db->update('customers');
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else if ($id == 1) {
            echo json_encode(array('status' => 'Error', 'message' => 'You can not delete the default group!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    function sendGroup()
    {
        $id = $this->input->post('gid');
        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $recipients = $this->clientgroup->recipients($id);
        $this->load->model('communication_model');
        $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
    }
}
