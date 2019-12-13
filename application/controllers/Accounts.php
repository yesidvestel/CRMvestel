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

class Accounts Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('accounts_model', 'accounts');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 4) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {
        $data['accounts'] = $this->accounts->accountslist();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Accounts';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/list', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {
        $acid = $this->input->get('id');
        $data['account'] = $this->accounts->details($acid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Account';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/view', $data);
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Account';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/add');
        $this->load->view('fixed/footer');
    }

    public function addacc()
    {
        $accno = $this->input->post('accno');
        $holder = $this->input->post('holder');
        $intbal = $this->input->post('intbal');
        $acode = $this->input->post('acode');

        if ($accno) {
            $this->accounts->addnew($accno, $holder, $intbal, $acode);
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('accounts', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ACC_DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

//view for edit
    public function edit()
    {
        $catid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('accounts');
        $this->db->where('id', $catid);
        $query = $this->db->get();
        $data['account'] = $query->row_array();

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Account';
        $this->load->view('fixed/header', $head);
        $this->load->view('accounts/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function editacc()
    {
        $acid = $this->input->post('acid');
        $accno = $this->input->post('accno');
        $holder = $this->input->post('holder');
        $acode = $this->input->post('acode');
        if ($acid) {
            $this->accounts->edit($acid, $accno, $holder, $acode);
        }
    }

    public function balancesheet()
    {


        $head['title'] = "Balance Summary";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['accounts'] = $this->accounts->accountslist();

        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/balance', $data);
        $this->load->view('fixed/footer');

    }

    public function account_stats()
    {

        $this->accounts->account_stats();


    }


}