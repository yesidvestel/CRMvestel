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

class Payments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payments_model', 'payments');
        
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Payments";

        
        
        $this->load->view('includes/header');
        $this->load->view('payments/payments');
        $this->load->view('includes/footer');
    }
    public function prueba(){
           $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://sandbox.api.payulatam.com/payments-api/4.0/service.cgi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "test": false,
                           "language": "es",
                           "command": "GET_PAYMENT_METHODS",
                           "merchant": {
                              "apiLogin": "8wOQ5r2pCRoSTjG",
                              "apiKey": "K4N2CDMArYqCPshu5rvbycCnOG"
                           }
                        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            //'Content-Length: length' //esta linea es la que causa el error por esta es la longitud de los bites de la informacion enviada por post, revisar codigo java en android ws
            
          ),
        ));

         $respuesta= curl_exec($curl);
        curl_close($curl);
        echo $respuesta;
    }

    public function recharge()
    {
        $head['title'] = "Payments";
        $data['balance']=$this->payments->balance($this->session->userdata('user_details')[0]->cid);
        $data['activity']=$this->payments->activity($this->session->userdata('user_details')[0]->cid);
        $this->load->view('includes/header');
        $this->load->view('payments/recharge',$data);
        $this->load->view('includes/footer');
    }


    public function ajax_list()
    {
        $query = $this->db->query("SELECT currency FROM app_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();

        $this->config->set_item('currency', $row["currency"]);


        $list = $this->payments->get_datatables();
        $data = array();

        $no = $this->input->post('start');
        $curr = $this->config->item('currency');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $invoices->date;
            $row[] = $curr . ' ' . $invoices->credit;
            $row[] = $curr . ' ' . $invoices->debit;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->payments->count_all(),
            "recordsFiltered" => $this->payments->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }




}