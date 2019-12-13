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

class Rec_invoices_model extends CI_Model
{
    var $table = 'rec_invoices';
    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastinvoice()
    {
        $this->db->select('tid');
        $this->db->from($this->table);
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->tid;
        } else {
            return 1000;
        }
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('product_warehouse');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_details($id)
    {

        $this->db->select('rec_invoices.*,customers.*,customers.id AS cid,billing_terms.id AS termid,billing_terms.title AS termtit,billing_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('rec_invoices.tid', $id);
        $this->db->where('rec_invoices.csd', $this->session->userdata('user_details')[0]->cid);
        $this->db->join('customers', 'rec_invoices.csd = customers.id', 'left');
        $this->db->join('billing_terms', 'billing_terms.id = rec_invoices.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function invoice_products($id)
    {

        $this->db->select('*');
        $this->db->from('rec_invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function invoice_transactions($id)
    {

        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('tid', $id);
        $this->db->where('ext', 2);
        $query = $this->db->get();
        return $query->result_array();

    }



    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $this->db->where('rec_invoices.csd', $this->session->userdata('user_details')[0]->cid);
        $this->db->join('customers', 'rec_invoices.csd=customers.id', 'left');

        $i = 0;

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
        $this->db->where('rec_invoices.csd', $this->session->userdata('user_details')[0]->cid);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $this->db->where('rec_invoices.csd', $this->session->userdata('user_details')[0]->cid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $this->db->where('rec_invoices.csd', $this->session->userdata('user_details')[0]->cid);
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

    public function rec_stats()
    {

        $query = $this->db->query("SELECT COUNT(id) AS rec,ron FROM rec_invoices WHERE csd=".$this->session->userdata('user_details')[0]->cid." GROUP BY ron");


        echo json_encode($query->result_array());

    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('currencies');

        $query = $this->db->get();
        return $query->result_array();

    }


}