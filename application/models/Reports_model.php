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

class Reports_model extends CI_Model
{

    public function index()
    {


        $query = $this->db->query("SELECT pid,product_name,product_price FROM products WHERE UPPER(product_name) LIKE '" . strtoupper($name) . "%'");

        $result = $query->result_array();

        return $result;
    }

    public function viewstatement($pay_acc, $trans_type, $sdate, $edate, $ttype)
    {

        if ($trans_type == 'All') {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') ";
        } else {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function get_statements($pay_acc, $trans_type, $sdate, $edate)
    {

        if ($trans_type == 'All') {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') ";
        } else {
            $where = "acid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type'";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        //  $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }
    function devolver_nombre_mes($numero){
        if($numero=="1"){
            return "Enero";
        }else if($numero=="2"){
            return "Febrero";
        }else if($numero=="3"){
            return "Marzo";
        }else if($numero=="4"){
            return "Abril";
        }else if($numero=="5"){
            return "Mayo";
        }else if($numero=="6"){
            return "Junio";
        }else if($numero=="7"){
            return "Julio";
        }else if($numero=="8"){
            return "Agosto";
        }else if($numero=="9"){
            return "Septiembre";
        }else if($numero=="10"){
            return "Octubre";
        }else if($numero=="11"){
            return "Noviembre";
        }else if($numero=="12"){
            return "Diciembre";
        }
    }
    //transaction account statement

    var $table = 'transactions';
    var $column_order = array(null, 'account', 'type', 'cat', 'amount', 'stat');
    var $column_search = array('id', 'account');
    var $order = array('id' => 'asc');
    var $opt = '';


    //income statement


    public function incomestatement()
    {


        $this->db->select_sum('lastbal');
        $this->db->from('accounts');
        $query = $this->db->get();
        $result = $query->row_array();

        $lastbal = $result['lastbal'];

        $this->db->select_sum('credit');
        $this->db->from('transactions');

        $this->db->where('type', 'Income');
        $month = date('Y-m');
        $today = date('Y-m-d');
        $this->db->where('DATE(date) >=', "$month-01");
        $this->db->where('DATE(date) <=', $today);

        $query = $this->db->get();
        $result = $query->row_array();

        $motnhbal = $result['credit'];
        return array('lastbal' => $lastbal, 'monthinc' => $motnhbal);

    }

    public function customincomestatement($acid, $sdate, $edate)
    {


        $this->db->select_sum('credit');
        $this->db->from('transactions');
        if ($acid > 0) {
            $this->db->where('acid', $acid);
        }
        $this->db->where('type', 'Income');
        $this->db->where('DATE(date) >=', $sdate);
        $this->db->where('DATE(date) <=', $edate);
        // $this->db->where("DATE(date) BETWEEN '$sdate' AND '$edate'");
        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    //expense statement


    public function expensestatement()
    {


        $this->db->select_sum('debit');
        $this->db->from('transactions');

        $this->db->where('type', 'Expense');
        $month = date('Y-m');
        $today = date('Y-m-d');
        $this->db->where('DATE(date) >=', "$month-01");
        $this->db->where('DATE(date) <=', $today);

        $query = $this->db->get();
        $result = $query->row_array();

        $motnhbal = $result['debit'];
        return array('monthinc' => $motnhbal);

    }

    public function customexpensestatement($acid, $sdate, $edate)
    {


        $this->db->select_sum('debit');
        $this->db->from('transactions');
        if ($acid > 0) {
            $this->db->where('acid', $acid);
        }
        $this->db->where('type', 'Expense');
        $this->db->where('DATE(date) >=', $sdate);
        $this->db->where('DATE(date) <=', $edate);
        // $this->db->where("DATE(date) BETWEEN '$sdate' AND '$edate'");
        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    public function statistics($limit = false)
    {
        $this->db->from('reports');
        // if($limit) $this->db->limit(12);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_customer_statements($pay_acc, $trans_type, $sdate, $edate)
    {

        if ($trans_type == 'All') {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND ext=0";
        } else {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type' AND ext=0";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        //  $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function get_supplier_statements($pay_acc, $trans_type, $sdate, $edate)
    {

        if ($trans_type == 'All') {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND ext=1";
        } else {
            $where = "payerid='$pay_acc' AND (DATE(date) BETWEEN '$sdate' AND '$edate') AND type='$trans_type' AND ext=1";
        }
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where($where);
        //  $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }


}

