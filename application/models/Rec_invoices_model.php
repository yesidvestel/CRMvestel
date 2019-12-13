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

    public function invoice_delete($id)
    {

        $this->db->trans_start();

        $this->db->select('pid,qty');
        $this->db->from('rec_invoice_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        $prevresult = $query->result_array();

        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $this->db->set('qty', "qty+$amt", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->update('products');
        }

        $this->db->delete('rec_invoices', array('tid' => $id));
        $this->db->delete('rec_invoice_items', array('tid' => $id));

        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }


    private function _get_datatables_query()
    {

        $this->db->from($this->table);
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
        $this->db->where('type', 3);
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

    public function rec_stats()
    {

        $query = $this->db->query("SELECT COUNT(id) AS rec,ron FROM rec_invoices GROUP BY ron");


        echo json_encode($query->result_array());

    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('currencies');

        $query = $this->db->get();
        return $query->result_array();

    }

    //dashboard

    public function todayInvoice($today)
    {

        $where = "DATE(invoiceduedate) ='$today'";
        $this->db->where($where);
        $this->db->from('rec_invoices');
        return $this->db->count_all_results();

    }

    public function todaySales($today)
    {

        $where = "DATE(invoiceduedate) ='$today'";
        $this->db->select_sum('total');
        $this->db->from('rec_invoices');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->total;
    }

    public function todayInexp($today)
    {
        $this->db->select('SUM(debit) as debit,SUM(credit) as credit', FALSE);
        $this->db->where("DATE(date) ='$today'");
        $this->db->where("type!='Transfer'");
        $this->db->from('transactions');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recent_payments()
    {
        $this->db->limit(10);
        $this->db->order_by('id', 'DESC');
        $this->db->from('transactions');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function stock()
    {
        $query = $this->db->query("SELECT * FROM products WHERE qty<=alert ORDER BY product_name ASC");
        return $query->result_array();
    }


    public function todayItems($today)
    {

        $where = "DATE(invoiceduedate) ='$today'";
        $this->db->select_sum('items');
        $this->db->from('rec_invoices');
        $this->db->where($where);
        $query = $this->db->get();

        return $query->row()->items;
    }


    public function incomeChart($today, $month, $year)
    {

        $query = $this->db->query("SELECT SUM(credit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE()) AND type='Income') GROUP BY date DESC");
        return $query->result_array();
    }

    public function expenseChart($today, $month, $year)
    {

        $query = $this->db->query("SELECT SUM(debit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE()) AND type='Expense') GROUP BY date DESC");
        return $query->result_array();
    }

    public function countmonthlyChart()
    {

        $query = $this->db->query("SELECT COUNT(id) AS ttlid,SUM(total) AS total,DATE(invoiceduedate) as date FROM rec_invoices WHERE (DATE(invoiceduedate) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) GROUP BY date DESC");
        return $query->result_array();

    }


    public function monthlyInvoice($month, $year)
    {

        $where = "DATE(invoiceduedate) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->where($where);
        $this->db->from('rec_invoices');
        return $this->db->count_all_results();

    }

    public function monthlySales($month, $year)
    {

        $where = "DATE(invoiceduedate) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->select_sum('total');
        $this->db->from('rec_invoices');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->total;
    }


    public function recentInvoices()
    {

        $query = $this->db->query("SELECT i.tid,i.invoicedate,i.total,i.status,c.name
FROM rec_invoices AS i LEFT JOIN customers AS c ON i.csd=c.id

ORDER BY i.tid DESC LIMIT 10");
        return $query->result_array();

    }

    public function tasks($id)
    {
        $this->db->select('*');
        $this->db->from('todolist');
        $this->db->where('eid', $id);
        $this->db->limit(10);
        $this->db->order_by('DATE(duedate)', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
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
        $this->db->where('meta_data.type', 3);
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