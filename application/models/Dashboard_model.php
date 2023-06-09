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

    public function todayInvoice($today, $sede)
    {

        $where = "DATE(invoicedate) ='$today'";
        $this->db->where($where);
		if ($sede != ''){
        $this->db->where('refer', $sede);
		}
        $this->db->from('invoices');
        return $this->db->count_all_results();

    }

    public function todaySales($today, $sede)
    {
		
    
        $query;
        if ($sede != '') {
            $query=$this->db->query("SELECT SUM(total) as total FROM invoices where DATE(invoicedate) ='$today' and refer='$sede' and tipo_factura!='Nota Credito'")->result();
        }else{
            $query=$this->db->query("SELECT SUM(total) as total FROM invoices where DATE(invoicedate) ='$today' and tipo_factura!='Nota Credito'")->result();    
        }
        return $query[0]->total;
    }

    public function todayInexp($today, $sede)
    {	
		
        $query;
        if ($sede != '') {
            $query=$this->db->query("SELECT SUM(debit) as debit,SUM(credit) as credit FROM transactions where DATE(date) ='$today' and account='$sede'  and estado is null and tid!=-1")->result();
        }else{
            $query=$this->db->query("SELECT SUM(debit) as debit,SUM(credit) as credit FROM transactions where DATE(date) ='$today' and type!='Transfer' and estado is null and tid!=-1")->result();
        }
        return $query;
    }

    public function recent_payments($sede)
    {
        $this->db->limit(10);
        $this->db->order_by('id', 'DESC');
        $this->db->from('transactions');
		if ($sede != ''){
        $this->db->where('account', $sede);
		}
        $this->db->where('tid!=',"-1" );
        $query = $this->db->get();
        return $query->result_array();
    }

    public function stock($sede)
    {
		if ($sede == ''){
        $query = $this->db->query("SELECT * FROM products WHERE qty<=alert ORDER BY product_name ASC");
        return $query->result_array();
		} if ($sede == 'Yopal'){
		$query = $this->db->query("SELECT * FROM products WHERE qty<=alert AND warehouse='2' ORDER BY product_name ASC");
        return $query->result_array();	
		} if ($sede == 'Monterrey'){
		$query = $this->db->query("SELECT * FROM products WHERE qty<=alert AND warehouse='3' ORDER BY product_name ASC");
        return $query->result_array();	
		} if ($sede == 'Mocoa'){
		$query = $this->db->query("SELECT * FROM products WHERE qty<=alert AND warehouse='4' ORDER BY product_name ASC");
        return $query->result_array();	
		} 
    }


    public function todayItems($today, $sede)
    {

        $where = "DATE(invoicedate) ='$today'";
        $this->db->select_sum('items');
        $this->db->from('invoices');
        $this->db->where($where);
		if ($sede != ''){
        $this->db->where('refer', $sede);
		}
        $query = $this->db->get();

        return $query->row()->items;
    }


    public function incomeChart($today, $month, $year, $sede)
    {
		if ($sede ==''){
        $query = $this->db->query("SELECT SUM(credit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND DATE('$year-$month-31')  AND CURDATE()) AND type!='Transfer')and estado is null and tid!=-1 GROUP BY date DESC");
        return $query->result_array();
		}else{
            $query = $this->db->query("SELECT SUM(credit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE()) and account='$sede') and estado is null and tid!=-1 GROUP BY date DESC");    
        return $query->result_array();
        }
		
        
    }

    public function expenseChart($today, $month, $year, $sede)
    {
		if ($sede ==''){
        $query = $this->db->query("SELECT SUM(debit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE()) and type!='Transfer' ) and estado is null and tid!=-1 GROUP BY date DESC");
		return $query->result_array();
		}else{
        $query = $this->db->query("SELECT SUM(debit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE())  AND account='$sede') and estado is null and tid!=-1 GROUP BY date DESC");
        return $query->result_array();            
        }

    }

    public function countmonthlyChart()
    {

        $query = $this->db->query("SELECT COUNT(id) AS ttlid,SUM(total) AS total,DATE(invoicedate) as date FROM invoices WHERE (DATE(invoicedate) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) and tipo_factura!='Nota Credito' GROUP BY date DESC");
        return $query->result_array();
    }


    public function monthlyInvoice($month, $year, $sede)
    {
		
        $where = "DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-31'";
		if ($sede != '') {
        $this->db->where('refer',$sede);
		}
		$this->db->where($where);
        $this->db->from('invoices');
        return $this->db->count_all_results();

    }

    public function monthlySales($month, $year, $sede)
    {
		
        $query;
        if ($sede != '') {
            $query=$this->db->query("SELECT SUM(total) as total FROM invoices where DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-31' and refer='$sede'")->result();
        }else{
            $query=$this->db->query("SELECT SUM(total) as total FROM invoices where DATE(invoicedate) BETWEEN '$year-$month-01' AND '$year-$month-31'")->result();    
        }
        return $query[0]->total;
    }


    public function recentInvoices($sede)
    {
		if ($sede == ''){
		$query = $this->db->query("SELECT i.tid,i.invoicedate,i.total,i.status,c.name
		FROM invoices AS i LEFT JOIN customers AS c ON i.csd=c.id ORDER BY i.tid DESC LIMIT 13");
		return $query->result_array();
		}
        $query = $this->db->query("SELECT i.tid,i.invoicedate,i.total,i.status,c.name
		FROM invoices AS i LEFT JOIN customers AS c ON i.csd=c.id WHERE refer='$sede' ORDER BY i.tid DESC LIMIT 13");
		return $query->result_array();
		
		
        

    }

    public function lista_usuarios()
    {
        $this->db->select('*');
        $this->db->from('estadisticas_servicios');
        //$this->db->limit(1);
        $this->db->order_by('DATE(fecha)','DESC');
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
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