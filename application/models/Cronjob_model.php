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


class Cronjob_model extends CI_Model
{
    var $table = 'accounts';

    public function __construct()
    {
        parent::__construct();

    }

    public function config()
    {
        $this->db->select('*');
        $this->db->from('corn_job');
        $query = $this->db->get();
        return $query->row_array();
    }


    public function generate()
    {

        $random = rand(11111111, 99999999);
        $data = array(
            'cornkey' => $random

        );
        $this->db->set($data);
        $this->db->where('id', 1);


        if ($this->db->update('corn_job')) {
            return true;
        } else {
            return false;

        }

    }

    public function rec_inv()
    {

        $this->db->select('*');
        $this->db->from('corn_job');
        $query = $this->db->get();
        $result = $query->row_array();
        $config = $result['rec_due'];


        if ($config == 0) {

            $duedate = date('Y-m-d');
            $data = array('status' => 'due');


            $this->db->set($data);
            $this->db->where('DATE(invoiceduedate)<=', $duedate);
            $this->db->where('status', 'paid');
            $this->db->where('ron', 'Recurring');
			$this->db->where('pamnt<=', 'total');


            if ($this->db->update('rec_invoices')) {
                return true;

            } else {
                return false;

            }

        }

    }

    public function rec_inv_due_mail()
    {

        $duedate = date('Y-m-d');

        $this->db->select('rec_invoices.*,customers.name,customers.email');
        $this->db->from('rec_invoices');
        $this->db->where('DATE(rec_invoices.invoiceduedate)<=', $duedate);
        $this->db->where('rec_invoices.status', 'paid');
        $this->db->where('rec_invoices.ron', 'Recurring');
        $this->db->join('customers', 'customers.id=rec_invoices.csd', 'left');
        $query = $this->db->get();
        return $query->result_array();


    }

    public function due_mail()
    {

        $duedate = date('Y-m-d');

        $this->db->select('invoices.*,customers.name,customers.email');
        $this->db->from('invoices');
        $this->db->where('DATE(invoices.invoiceduedate)<=', $duedate);
        $this->db->where('invoices.status', 'due');
        $this->db->join('customers', 'customers.id=invoices.csd', 'left');
        $query = $this->db->get();
        return $query->result_array();


    }


    public function reports()
    {

        $year = date('Y');

        $this->db->delete('reports', array('year' => $year));


        $query = $this->db->query("SELECT MONTH(invoicedate) AS month,YEAR(invoicedate) AS year,COUNT(tid) AS invoices,SUM(total) AS sales,SUM(items) AS items FROM invoices WHERE (YEAR(invoicedate)='$year') GROUP BY MONTH(invoicedate)");
        $arrayA = $query->result_array();

        $query = $this->db->query("SELECT MONTH(date) AS month,YEAR(date) AS year,SUM(credit) AS income,SUM(debit) AS expense FROM transactions WHERE (YEAR(date)='$year') GROUP BY MONTH(date)");
        $arrayB = $query->result_array();
        $output = array();

        $arrayAB = array_merge($arrayA, $arrayB);



            foreach ($arrayAB as $value) {
                $id = $value['month'];
                if (!isset($output[$id])) {
                    $output[$id] = array();
                }
                    $output[$id] = array_merge($output[$id], $value);
            }





        uasort($output, array_compare('month'));
        print_r($output);

        $batch = array();
        $i = 0;
        foreach ($output as $row) {

            $batch[$i] = array('month' => $row['month'], 'year' => $row['year'], 'invoices' => @$row['invoices'], 'sales' => @$row['sales'], 'items' => @$row['items'], 'income' => @$row['income'], 'expense' => @$row['expense']);
            $i++;
        }

        $this->db->insert_batch('reports', $batch);

        return true;


    }

    public function exchange_rate($base, $exchangeRates = '')
    {

        $updateData = array();
        //$cindex = 0;
        $this->db->select('id,code,rate');
        $this->db->from('currencies');
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $key => $value) {

            $index = $base . $value['code'];
            $updateData[] = array('id' => $value['id'], 'rate' => $exchangeRates[$index]);
            //  print_r($value);

        }
//print_r($updateData);
        $this->db->update_batch('currencies', $updateData, 'id');


    }


}