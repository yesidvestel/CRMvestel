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
        $this->realizar_proceso_de_reportes($year-1);
        $this->realizar_proceso_de_reportes($year);
        
        return true;


    }
    public function realizar_proceso_de_reportes($year){
        

        $this->db->delete('reports', array('year' => $year));


        $query = $this->db->query("SELECT MONTH(invoicedate) AS month,YEAR(invoicedate) AS year,COUNT(tid) AS invoices,SUM(total) AS sales,SUM(items) AS items FROM invoices WHERE (YEAR(invoicedate)='$year') GROUP BY MONTH(invoicedate)");
        $arrayA = $query->result_array();

        $query = $this->db->query("SELECT MONTH(date) AS month,YEAR(date) AS year,SUM(credit) AS income,SUM(debit) AS expense FROM transactions WHERE (YEAR(date)='$year') and type!='Transfer' and estado is null and tid!=-1 GROUP BY MONTH(date)");
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
        //print_r($output);

        $batch = array();
        $i = 0;
        foreach ($output as $row) {

            $batch[$i] = array('month' => $row['month'], 'year' => $row['year'], 'invoices' => @$row['invoices'], 'sales' => @$row['sales'], 'items' => @$row['items'], 'income' => @$row['income'], 'expense' => @$row['expense']);
            $i++;
        }

        $this->db->insert_batch('reports', $batch);

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
	public function reports_tickets()
    {

        $year = date('Y');
        $this->conteo_tickets($year-1);
        $this->conteo_tickets($year);
        
        return true;


    }
	public function conteo_tickets($year){
        

        $this->db->delete('reports_tickets', array('year' => $year));


        $query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS ins, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Instalacion' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $Ins = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS ret, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Retiro voluntario' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $ret = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS agint, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='AgregarInternet' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $agint = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS agtv, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='AgregarTelevision' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $agtv = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS caequi, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Cambio de equipo' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $caequi = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS caclv, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Cambio de clave' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $caclv = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS corcom, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Corte Combo' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $corcom = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS corint, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Corte Internet' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $corint = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS cortv, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Corte Television' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $cortv = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS eqad, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Equipo adicional' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $eqad = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS ptnv, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Punto nuevo' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $ptnv = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS vee, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Veeduria' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $vee = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS revint, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Revision de Internet' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $revint = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS revtv, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Revision de television' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $revtv = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS revtvint, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Revision tv e internet' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $revtvint = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS rectvint, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Reconexion Combo' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $rectvint = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS rein, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Reinstalación' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $rein = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS recint, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Reconexion Internet' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $recint = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS rectv, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Reconexion Television' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $rectv = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS recmodem, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Recuperación cable modem' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $recmodem = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS submegas, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Subir megas' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $submegas = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS bajmegas, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Bajar megas' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $bajmegas = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS suscom, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Suspension Combo' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $suscom = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS susint, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Suspension Internet' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $susint = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS sustv, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Suspension Television' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $sustv = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS tras, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Traslado' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $tras = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS toma, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Toma Adicional' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $toma = $query->result_array();
		
		$query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS migra, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Migracion' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $migra = $query->result_array();
		
        $output = array();

        $arrayAB = array_merge($Ins, $ret, $agint, $agtv, $caequi, $caclv, $corcom, $corint, $cortv, $eqad, $ptnv, $vee, $revint, $revtv, $revtvint, $rectvint, $rein, $recint, $rectv, $recmodem, $submegas, $bajmegas, $suscom, $susint, $sustv, $tras, $toma, $migra);



            foreach ($arrayAB as $value) {
                $id = $value['month']. '-' . $value['sede'];
                if (!isset($output[$id])) {
                    $output[$id] = array();
                }
                    $output[$id] = array_merge($output[$id], $value);
            }





        uasort($output, array_compare('month'));
        //print_r($output);

        $batch = array();
        $i = 0;
        foreach ($output as $row) {

            $batch[$i] = array('month' => $row['month'], 'year' => $row['year'],'sede' => $row['sede'], 'Instalacion' => @$row['ins'], 'Retiro_voluntario' => @$row['ret'], 'AgregarInternet' => @$row['agint'], 'AgregarTelevision' => @$row['agtv'], 'Cambio_equipo' => @$row['caequi'], 'Cambio_clave' => @$row['caclv'], 'Corte_Combo' => @$row['corcom'], 'Corte_Internet' => @$row['corint'], 'Corte_Television' => @$row['cortv'], 'Equipo_adicional' => @$row['eqad'], 'Punto_nuevo' => @$row['ptnv'], 'Veeduria' => @$row['vee'], 'Revision_Internet' => @$row['revint'], 'Revision_television' => @$row['revtv'], 'Revision_tv_internet' => @$row['revtvint'], 'Reconexion_Combo' => @$row['rectvint'], 'Reinstalación' => @$row['rein'], 'Reconexion_Internet' => @$row['recint'], 'Reconexion_Television' => @$row['rectv'], 'Recuperación_modem' => @$row['recmodem'], 'Subir_megas' => @$row['submegas'], 'Bajar_megas' => @$row['bajmegas'], 'Suspension_Combo' => @$row['suscom'], 'Suspension_Internet' => @$row['susint'], 'Suspension_Television' => @$row['sustv'], 'Traslado' => @$row['tras'], 'Toma_Adicional' => @$row['toma'], 'Migracion' => @$row['migra']);
            $i++;
        }

        $this->db->insert_batch('reports_tickets', $batch);

    }
	public function reports_estados()
    {

        $year = date('Y');
        $this->conteo_estados($year-1);
        $this->conteo_estados($year);
        
        return true;


    }
	public function conteo_tickets($year){
        

        //$this->db->delete('reports_estados', array('year' => $year));


        $query = $this->db->query("SELECT MONTH(fecha_final) AS month,YEAR(fecha_final) AS year,COUNT(idt) AS ins, customers.gid AS sede FROM tickets JOIN customers ON tickets.cid = customers.id  WHERE (YEAR(fecha_final)='$year') and detalle='Instalacion' and status='Resuelto' and fecha_final IS NOT NULL GROUP BY MONTH(fecha_final), customers.gid");
        $Ins = $query->result_array();
		
		
		
        $output = array();

        $arrayAB = array_merge($Ins);



            foreach ($arrayAB as $value) {
                $id = $value['month']. '-' . $value['sede'];
                if (!isset($output[$id])) {
                    $output[$id] = array();
                }
                    $output[$id] = array_merge($output[$id], $value);
            }





        uasort($output, array_compare('month'));
        //print_r($output);

        $batch = array();
        $i = 0;
        foreach ($output as $row) {

            $batch[$i] = array('month' => $row['month'], 'year' => $row['year'],'sede' => $row['sede'], 'Instalacion' => @$row['ins']);
            $i++;
        }

        $this->db->insert_batch('reports_estados', $batch);

    }

}