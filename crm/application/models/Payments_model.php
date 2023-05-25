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

class Payments_model extends CI_Model
{
    var $table = 'wompi_data_orden';
    var $column_order = array(null, 'fecha', 'debe', 'metodo_pago', "estado","reference");
    var $column_search = array('fecha', 'debe', 'metodo_pago', "estado","reference","id_wompi");
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }


    public function invoice_details($id)
    {

        $this->db->select('invoices.*,customers.*,customers.id AS cid,billing_terms.id AS termid,billing_terms.title AS termtit,billing_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('invoices.tid', $id);
        $this->db->join('customers', 'invoices.csd = customers.id', 'left');
        $this->db->join('billing_terms', 'billing_terms.id = invoices.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_transactions($id)
    {

        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('tid', $id);
        $this->db->where('ext', 0);
        $query = $this->db->get();
        return $query->result_array();

    }


    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $this->db->where('wompi_data_orden.cid_user', $this->session->userdata('user_details')[0]->cid);
        $this->db->where('wompi_data_orden.estado !=', "Inicial");

        $i = 0;
            if ($_POST['search']['value'] && strlen($_POST['search']['value'])>20) 
            {
                $_POST['search']['value']=str_replace(" ", "", $_POST['search']['value']);
                $_POST['search']['value']=str_replace("-", "", $_POST['search']['value']);
            }
        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        //$this->db->where('wompi_data_orden.cid_user', $this->session->userdata('user_details')[0]->cid);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->where('wompi_data_orden.cid_user', $this->session->userdata('user_details')[0]->cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('wompi_data_orden.cid_user', $this->session->userdata('user_details')[0]->cid);
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('billing_terms');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('employee_profile.name,employee_profile.sign,aauth_users.roleid');
        $this->db->from('employee_profile');
        $this->db->where('employee_profile.id', $id);
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function balance($id)
    {

        $this->db->select('balance');
        $this->db->from('customers');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result= $query->row_array();
        return $result['balance'];

    }

    public function activity($id)
    {
        $this->db->select('*');
        $this->db->from('meta_data');
        $this->db->where('type', 21);
        $this->db->where('rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_user_cid(){
        $id=$this->session->userdata('user_details')[0]->users_id;
        $user_data=$this->db->get_where("users",array("users_id"=>$id))->row();
        return $user_data->cid;
    }
    public function get_list_banks_pse(){

            $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.payulatam.com/payments-api/4.0/service.cgi',
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
                           "command": "GET_BANKS_LIST",
                           "merchant": {
                              "apiKey": "'.$_SESSION['key_p'].'",
                              "apiLogin": "'.$_SESSION['user_p'].'"
                           },
                            "bankListInformation": {
                              "paymentMethod": "PSE",
                              "paymentCountry": "CO"
                           }
                        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            
          ),
        ));

         $respuesta= curl_exec($curl);
        curl_close($curl);
        $lista=json_decode($respuesta);
        return $lista->banks;        

    }


}