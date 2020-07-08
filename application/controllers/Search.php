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

class Search extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('search_model', 'search');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

    }

    public function search_invoice()
    {
        $invoicenumber = $this->input->post('');

        $data['search'] = $this->search->invoice($invoicenumber);

        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Product Categories";
        $head['usernm'] = $this->aauth->get_user()->username;

        $this->load->view('fixed/header', $head);
        $this->load->view('search/invoice', $data);
        $this->load->view('fixed/footer');

    }


    public function invoice()
    {
        $result = array();
        $out = array();
        $tid = $this->input->get('keyword', true);


        if ($tid) {
            $query = $this->db->query("SELECT tid FROM invoices WHERE UPPER(tid)  LIKE '" . $tid . "%' LIMIT 4");

            $result = $query->result_array();

            echo '<ul>';
            $i = 1;
            foreach ($result as $row) {


                echo "<li ><a href='" . base_url('invoices/view?id=' . $row['tid']) . "'>" . $row['tid'] . "</a></li>";
                $i++;
            }
            echo '</ul>';


        }

    }

    public function customer()
    {

        $name = $this->input->get('keyword', true);


        if ($name) {
            $query = $this->db->query("SELECT id,name,documento,company,celular,email FROM customers WHERE UPPER(name)  LIKE '" . strtoupper($name) . "%' OR UPPER(documento)  LIKE '" . strtoupper($name) . "%' LIMIT 6");

            $result = $query->result_array();


            $i = 1;
            foreach ($result as $row) {


                echo ' 
                    <a href="' . base_url('customers/view?id=' . $row['id']) . '" class="list-group-item">  <div class="media">
                        <div class="media-left valign-middle"><i class="icon-user1 icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] .$row['unoapellido']. '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row['documento'] . ',' . $row['celular'] . '</p><small><i class="icon-phone"></i> ' . $row['unoapellido'] . '</small>
                        </div>
                      </div></a>
                 
               ';
                $i++;
            }


        }

    }

    public function user()
    {

        $name = $this->input->get('username', true);


        if (!$name = NULL) {
            $query = $this->db->query("SELECT id,username FROM aauth_users WHERE username  LIKE '" . $name . "%' LIMIT 6");

            $result = $query->result_array();


            $i = 1;
            echo '<div>';
            foreach ($result as $row) {


                echo '<kbd class="selectuser" data-username="' . $row['username'] . '" data-userid="' . $row['id'] . '">' . $row['username'] . '</kbd> ';

            }
            echo '</div>';


        }

    }

    public function customer_select()
    {

        $name = $this->input->post('customer', true);


        if ($name) {
            $query = $this->db->query("SELECT id,,name,unoapellido,company,celular,email FROM customers WHERE UPPER(name)  LIKE '" . strtoupper($name['term']) . "%' OR UPPER(celular)  LIKE '" . strtoupper($name['term']) . "%' LIMIT 6");

            $result = $query->result_array();


            echo json_encode($result);


        }

    }

    public function supplier_select()
    {

        $name = $this->input->post('supplier', true);


        if ($name) {
            $query = $this->db->query("SELECT id,,name,apellidos,company,celular,email FROM supplier WHERE UPPER(name)  LIKE '" . strtoupper($name['term']) . "%' OR UPPER(celular)  LIKE '" . strtoupper($name['term']) . "%' LIMIT 6");

            $result = $query->result_array();


            echo json_encode($result);


        }

    }


}