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

class Dashboard_model extends CI_Model
{

     public function __construct(){
        parent::__construct();
     }

    public function todayInvoice($today)
    {

        $where = "DATE(invoicedate) ='$today'";
        $this->db->where($where);
        $this->db->from('invoices');
        return $this->db->count_all_results();

    }

    public function todaySales($today)
    {

        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('total');
        $this->db->from('invoices');
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

        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('items');
        $this->db->from('invoices');
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

        $query = $this->db->query("SELECT COUNT(id) AS ttlid,SUM(total) AS total,DATE(invoicedate) as date FROM invoices WHERE (DATE(invoicedate) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) GROUP BY date DESC");
        return $query->result_array();
    }


    public function monthlyInvoice($month, $year)
    {

        $where = "DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->where($where);
        $this->db->from('invoices');
        return $this->db->count_all_results();

    }

    public function monthlySales($month, $year)
    {

        $where = "DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-31'";
        $this->db->select_sum('total');
        $this->db->from('invoices');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row()->total;
    }


    public function recentInvoices()
    {

        $query = $this->db->query("SELECT i.tid,i.invoicedate,i.total,i.status,c.name
FROM invoices AS i LEFT JOIN customers AS c ON i.csd=c.id

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

}