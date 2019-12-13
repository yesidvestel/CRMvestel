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

class Quote_model extends CI_Model
{
    var $table = 'quotes';
    var $column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('tid' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastquote()
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

    public function quote_details($id)
    {

        $this->db->select('quotes.*,customers.*,customers.id AS cid,billing_terms.id AS termid,billing_terms.title AS termtit,billing_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('quotes.tid', $id);
        $this->db->join('customers', 'quotes.csd = customers.id', 'left');
        $this->db->join('billing_terms', 'billing_terms.id = quotes.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function quote_products($id)
    {

        $this->db->select('*');
        $this->db->from('quotes_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }


    public function quote_delete($id)
    {

        $this->db->trans_start();


        $this->db->delete('quotes', array('tid' => $id));
        $this->db->delete('quotes_items', array('tid' => $id));

        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }


    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $this->db->join('customers', 'quotes.csd=customers.id', 'left');

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
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('billing_terms');
        $this->db->where('type', 2);
        $this->db->or_where('type', 0);
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

    public function convert($id)
    {

        $invoice = $this->quote_details($id);
        $products = $this->quote_products($id);
        $this->db->trans_start();

        $this->db->select('tid');
        $this->db->from('invoices');
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $iid = $query->row()->tid + 1;
        } else {
            $iid = 1000;
        }
        $productlist = array();
        $prodindex = 0;

        foreach ($products as $row) {

            $amt = $row['qty'];

            $data = array(
                'tid' => $iid,
                'pid' => $row['pid'],
                'product' => $row['product'],
                'qty' => $amt,
                'price' => $row['price'],
                'tax' => $row['tax'],
                'discount' => $row['discount'],
                'subtotal' => $row['subtotal'],
                'totaltax' => $row['totaltax'],
                'totaldiscount' => $row['totaldiscount'],
				'product_des' => $row['product_des']
            );

            $productlist[$prodindex] = $data;
            $prodindex++;

            $this->db->set('qty', "qty-$amt", FALSE);
            $this->db->where('pid', $row['pid']);
            $this->db->update('products');
        }


        $this->db->insert_batch('invoice_items', $productlist);


        $data = array('tid' => $iid, 'invoicedate' => $invoice['invoicedate'], 'invoiceduedate' => $invoice['invoicedate'], 'subtotal' => $invoice['invoicedate'], 'shipping' => $invoice['shipping'], 'discount' => $invoice['discount'], 'tax' => $invoice['tax'], 'total' => $invoice['total'], 'notes' => $invoice['notes'], 'csd' => $invoice['csd'], 'eid' => $invoice['eid'], 'items' => $invoice['items'], 'taxstatus' => $invoice['taxstatus'], 'discstatus' => $invoice['discstatus'], 'format_discount' => $invoice['format_discount'], 'refer' => $invoice['refer'], 'term' => $invoice['term']);

        $this->db->insert('invoices', $data);

        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }


    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('currencies');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('currencies');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('meta_data', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('meta_data.*');
        $this->db->from('meta_data');
        $this->db->where('meta_data.type', 2);
        $this->db->where('meta_data.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id,$type,$name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('meta_data', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }



}