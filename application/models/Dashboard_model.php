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
            $account1=$this->db->get_where('accounts',array('holder' =>$sede))->row();
            $query=$this->db->query("SELECT SUM(debit) as debit,SUM(credit) as credit FROM transactions where DATE(date) ='$today' and account='$account1->holder'  and estado is null and tid!=-1")->result();
            $valores_banks=$this->add_banks($today,$today,$account1->id);
            $query[0]->credit+=$valores_banks['credit'];

        }else{
            $query=$this->db->query("SELECT SUM(debit) as debit,SUM(credit) as credit FROM transactions where DATE(date) ='$today'  and estado is null and tid!=-1")->result();
        }


        return $query;
    }
public function add_banks($sdate,$edate,$pay_acc){
            $retorno=array("credit"=>0,"debit"=>0);
            $caja1=$this->db->get_where('accounts',array('id' =>$pay_acc))->row();
            
            $edate=$edate.=" 23:59:00";
            $trans_type="All";
            $cuentas=array();
            $cuentas['cuenta1'] = $this->reports->get_statements(6, $trans_type, $sdate, $edate);
            $cuentas['cuenta2'] = $this->reports->get_statements(7, $trans_type, $sdate, $edate);
            $cuentas['cuenta3'] = $this->reports->get_statements(8, $trans_type, $sdate, $edate);
            $cuentas['cuenta4'] = $this->reports->get_statements(11, $trans_type, $sdate, $edate);
            $cuentas['cuenta5'] = $this->reports->get_statements(23, $trans_type, $sdate, $edate);

            foreach ($cuentas as $key => $cuentax) {
                if($key!=11){
                    foreach ($cuentax as $key => $value) {
                        $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                        if($invoice->refer!=null){
                            $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                        }
                        if($value['estado']!="Anulada"){                
                            if(strtolower($invoice->refer)==strtolower($caja1->holder)){
                                //$lista2[]=$value;
                                $retorno['credit']+=$value['credit'];
                                $retorno['debit']+=$value['debit'];
                            }
                        }else{
                                /*if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                                    $anulaciones[]=$value;
                                }*/
                        }
                    }
                }
            }

            return $retorno;
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
        $query = $this->db->query("SELECT * FROM products WHERE qty<=alert AND warehouse<'6' ORDER BY product_name ASC");
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
			if ($year==''){
				$query = $this->db->query("SELECT SUM(credit) AS total,date FROM transactions WHERE (( CURDATE()) AND type!='Transfer')and estado is null and tid!=-1 GROUP BY date DESC");
			}else{
				$query = $this->db->query("SELECT SUM(credit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE()) )and estado is null and tid!=-1 GROUP BY date DESC");
			}
        return $query->result_array();
		}else{
            $account1=$this->db->get_where('accounts',array('holder' =>$sede))->row();
            $query = $this->db->query("SELECT SUM(credit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE()) and account='$sede') and estado is null and tid!=-1 GROUP BY date DESC");    

            $valores_banks=$this->add_banks($year.'-'.$month.'-01',date("Y-m-d"),$account1->id);
            $query=$query->result_array();
            $query[0]['total']+=$valores_banks['credit'];
        return $query;
        }
		
        
    }

    public function expenseChart($today, $month, $year, $sede)
    {
		if ($sede ==''){
        $query = $this->db->query("SELECT SUM(debit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE()) ) and estado is null and tid!=-1 GROUP BY date DESC");
		return $query->result_array();
		}else{
             $account1=$this->db->get_where('accounts',array('holder' =>$sede))->row();
        $query = $this->db->query("SELECT SUM(debit) AS total,date FROM transactions WHERE ((DATE(date) BETWEEN DATE('$year-$month-01') AND CURDATE())  AND account='$sede') and estado is null and tid!=-1 GROUP BY date DESC");
        $valores_banks=$this->add_banks($year.'-'.$month.'-01',date("Y-m-d"),$account1->id);
            $query=$query->result_array();
            $query[0]['total']+=$valores_banks['debit'];
        return $query;            
        }

    }

    public function countmonthlyChart()
    {

        $query = $this->db->query("SELECT COUNT(id) AS ttlid,SUM(total) AS total,DATE(invoicedate) as date FROM invoices WHERE (DATE(invoicedate) BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE()) and tipo_factura!='Nota Credito' GROUP BY date DESC");
        return $query->result_array();
    }
	public function grupo()
    {
        $this->db->select('*');
        $this->db->from('customers_group');
        $query = $this->db->get();
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
		$this->db->select('DATE(fecha) as fecha, SUM(act_int) as act_internet, SUM(act_tv) as act_television, SUM(internet_y_tv_act) as act_totales');
		$this->db->from('reports_estados');
		$this->db->group_by('DATE(fecha)');
		$this->db->order_by('fecha', 'DESC');
		$query = $this->db->get();
		$result = $query->row_array(); // Cambiado a result_array para múltiples filas
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