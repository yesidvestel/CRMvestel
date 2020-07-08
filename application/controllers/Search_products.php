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

class Search_products extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('search_model');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

//search product in invoice
    public function search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "warehouse='$wid' AND ";
        }


        if ($name) {
            $query = $this->db->query("SELECT pid,product_name,product_price,taxrate,disrate,product_des  FROM products WHERE " . $qw . "UPPER(product_name) LIKE '" . strtoupper($name) . "%' OR UPPER(product_code) LIKE '" . strtoupper($name) . "%' LIMIT 6");

            $result = $query->result_array();


            foreach ($result as $row) {
                $name = array($row['product_name'],$row['product_price'],$row['pid'],$row['taxrate'],$row['disrate'],$row['product_des'] , $row_num);
                array_push($out, $name);
            }

            echo json_encode($out);
        }

    }

    public function puchase_search()
    {
        $result = array();
        $out = array();
        $row_num = $this->input->post('row_num', true);
        $name = $this->input->post('name_startsWith', true);
        $wid = $this->input->post('wid', true);
        $qw = '';
        if ($wid > 0) {
            $qw = "warehouse='$wid' AND ";
        }


        if ($name) {
            $query = $this->db->query("SELECT pid,product_name,fproduct_price,taxrate,disrate,product_des FROM products WHERE " . $qw . "UPPER(product_name) LIKE '" . strtoupper($name) . "%' OR UPPER(product_code) LIKE '" . strtoupper($name) . "%' LIMIT 6");

            $result = $query->result_array();




            foreach ($result as $row) {
                $name = array($row['product_name'],$row['fproduct_price'],$row['pid'],$row['taxrate'],$row['disrate'],$row['product_des'] , $row_num);
                array_push($out, $name);
            }

            echo json_encode($out);
        }

    }

    public function csearch()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);


        if ($name) {
            $query = $this->db->query("SELECT id,name,company,documento,celular,email FROM customers WHERE UPPER(name)  LIKE '" . strtoupper($name) . "%' OR UPPER(celular)  LIKE '" . strtoupper($name) . "%' OR UPPER(id)  LIKE '" . strtoupper($name) ."%' LIMIT 6");

            $result = $query->result_array();

            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {


                echo "<li onClick=\"selectCustomer('" . $row['id'] . "','" . $row['name'] . " ','" . $row['company'] . "','" . $row['documento'] . "','" . $row['celular'] . "','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['celular'] . "</p></li>";
                $i++;
            }
            echo '</ol>';


        }

    }


    public function supplier()
    {
        $result = array();
        $out = array();
        $name = $this->input->get('keyword', true);


        if ($name) {
            $query = $this->db->query("SELECT id,name,address,city,phone,email FROM supplier WHERE UPPER(name)  LIKE '" . strtoupper($name) . "%' OR UPPER(phone)  LIKE '" . strtoupper($name) . "%' LIMIT 6");

            $result = $query->result_array();

            echo '<ol>';
            $i = 1;
            foreach ($result as $row) {

                echo "<li onClick=\"selectSupplier('" . $row['id'] . "','" . $row['name'] . " ','" . $row['address'] . "','" . $row['city'] . "','" . $row['phone'] . "','" . $row['email'] . "')\"><span>$i</span><p>" . $row['name'] . " &nbsp; &nbsp  " . $row['phone'] . "</p></li>";
                $i++;
            }
            echo '</ol>';


        }

    }
}