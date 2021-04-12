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

class Transactions extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('invoices_model');
        $this->load->model('transactions_model', 'transactions');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/index');
        $this->load->view('fixed/footer');

    }
     public function anulaciones()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/anulaciones');
        $this->load->view('fixed/footer');

    }

    public function add()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "Add Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/create', $data);
        $this->load->view('fixed/footer');

    }

    public function transfer()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $head['title'] = "New Transfer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/transfer', $data);
        $this->load->view('fixed/footer');

    }
    public function payinvoicemultiple(){
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $ids_facturas =$this->input->post('facturas_seleccionadas');
            $x="";
        $array_facturas=explode("-", $ids_facturas);
        $monto=$this->input->post('amount');
        $valor_restante_monto=0;
        $montos=array();
        $array_facturas2=array();
        
            foreach ($array_facturas as $key => $id_factura) {
                $factura_var = $this->db->get_where('invoices',array('tid'=>$id_factura))->row();                                
                
                $total_factura=$factura_var->total;
                if($factura_var->status=="partial"){
                    $total_factura=$factura_var->total-$factura_var->pamnt;
                }
                $valor_restante_monto=$monto-$total_factura;

                if($valor_restante_monto>=0){
                    $montos[$id_factura]=$total_factura;
                    $array_facturas2[]=$id_factura;
                    $monto=$valor_restante_monto;
                }else if($monto>0 && $factura_var->status!="partial"){
                    $montos[$id_factura]=$monto;
                    $array_facturas2[]=$id_factura;
                    $monto=$valor_restante_monto;  
                    
                }

                
            }

            
        $id_fact_pagadas="";
        foreach ($array_facturas2 as $key => $id_factura) {
            if($id_fact_pagadas==""){
                $id_fact_pagadas="".$id_factura;
            }else{
                $id_fact_pagadas.=",".$id_factura;
            }
            $factura_var = $this->db->get_where('invoices',array('tid'=>$id_factura))->row();
            $customer=$this->db->get_where('customers',array('id'=>$factura_var->csd))->row();
            //codigo copiado
             $tid = $id_factura;
        $amount = $montos[$id_factura];
        $paydate = $this->input->post('paydate');
        $note = $this->input->post('shortnote');
        $pmethod = $this->input->post('pmethod');
        $banco = $this->input->post('banco');
        $acid = $this->input->post('account');
        $cid = $factura_var->csd;
        $cname = $customer->name;
        $paydate = datefordatabase($paydate);

        $this->db->select('holder');
        $this->db->from('accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        $account = $query->row_array();

        if($pmethod=='Balance'){

            $customer = $this->transactions->check_balance($cid);
            if($customer['balance']>=$amount){

                $this->db->set('balance', "balance-$amount", FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');
            }
            else{

                $amount=$customer['balance'];
                $this->db->set('balance', 0, FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');
            }
        }
        $id_banco=null;
        if($pmethod!="Bank"){
            $banco=null;
        }else{
            if($banco=="Bancolombia"){
                $cuenta = $this->db->select("*")->from('accounts')->like('holder','Bancolombia','both')->get();
                $cuenta = $cuenta->result();
                if($cuenta!=null){
                    $id_banco=$cuenta[0]->id;
                    $mas=intval($cuenta[0]->lastbal)+intval($amount);
                    $data5['lastbal']=$mas;
                    $this->db->update('accounts',$data5,array('id' =>$id_banco ));    
                }
                
            }else{
                $cuenta = $this->db->select("*")->from('accounts')->like('holder','BBVA','both')->get();
                $cuenta = $cuenta->result();
                if($cuenta!=null){
                    $id_banco=$cuenta[0]->id;
                    $mas=intval($cuenta[0]->lastbal)+intval($amount);
                    $data5['lastbal']=$mas;
                    $this->db->update('accounts',$data5,array('id' =>$id_banco ));    
                }
                

            }
        }
			if ($pmethod==Cash){
        $note="Pago de la factura #".$tid." ".$customer->name." ".$customer->unoapellido." ".$customer->documento." metodo: efectivo";
			}if ($pmethod==Bank){
			$note="Pago de la factura #".$tid." ".$customer->name." ".$customer->unoapellido." ".$customer->documento." metodo: Consignacion";	
			}
    $data = array(
            'acid' => $acid,
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $cname,
            'payerid' => $cid,
            'method' => $pmethod,
            'date' => $paydate,
            'eid' => $this->aauth->get_user()->id,
            'tid' => $tid,
            'note' => $note,
            'ext' => 0,
            'nombre_banco'=>$banco,
            'id_banco'=>$id_banco
        );

        $this->db->insert('transactions', $data);
        $this->db->insert_id();

        $this->db->select('invoiceduedate,total,csd,pamnt,rec');
        $this->db->from('invoices');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $invresult = $query->row();

        $totalrm = $invresult->total - $invresult->pamnt;

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
        } else {

            //$today = $invresult->invoiceduedate;
            //$addday = $invresult->rec;


            //$ndate = date("Y-m-d", strtotime($today . " +" . $addday . 's'));

            //$this->db->set('invoiceduedate', $ndate);
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');

            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;


        }


       // $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";


        //echo json_encode(array('status' => 'Success', 'message' =>
            //$this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount));
            //codigo cop fin
        }
        $link ="<a href='".base_url()."invoices/printinvoice?id=".$id_fact_pagadas."' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span>Ver PDF Facturas Pagadas</a>";
        echo json_encode(array('status'=>"Success",'message' =>$this->lang->line('Transaction has been added ').$link,"id_fact_pagadas"=>$id_fact_pagadas));
    }
    public function payinvoice()
    {

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $tid = intval($this->input->post('tid'));
        $amount = $this->input->post('amount');
        $paydate = $this->input->post('paydate');
        $note = $this->input->post('shortnote');
        $pmethod = $this->input->post('pmethod');
		if ($pmethod=='Cash'){
			$metodo = 'Efectivo';
		}if ($pmethod=='Bank'){
			$metodo = 'Transferencia';
		}
        $banco = $this->input->post('banco');
        $acid = $this->input->post('account');
        $cid = $this->input->post('cid');
        $cname = $this->input->post('cname');
        $paydate = datefordatabase($paydate);
		$reconexion = $this->input->post('reconexion');
		$paquete = $this->input->post('paquete');
		$tipo = $this->input->post('tipo');
        $this->db->select('holder');
        $this->db->from('accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        $account = $query->row_array();
		$factura = $this->db->get_where('invoices',array('tid'=>$tid))->row();
		$fcuenta = $factura->invoicedate;
		$mes1 = date("Y-m",strtotime($fcuenta));
		$mes2 = date("Y-m");
		if ($tipo==='Reconexion Combo'){
			$tv = 'Television';
		}if ($tipo==='Reconexion Television'){
			$tv = 'Television';
		}if ($tipo==='Reconexion Internet'){
			$tv = 'no';
		}
		//generar reconexion
		$tidactualmasuno= $this->db->select('max(codigo)+1 as tid')->from('tickets')->get()->result();
		if ($reconexion==si && $mes2===$mes1){
			$data2['codigo']=$tidactualmasuno[0]->tid;
				$data2['subject']='servicio';
				$data2['detalle']=$tipo;
                $data2['created']=$paydate;
                $data2['cid']=$cid;
                $data2['status']='Pendiente';
                $data2['section']=$paquete;
                $data2['id_factura']=$tid;
                $this->db->insert('tickets',$data2);
		}if ($reconexion==si && $mes2>$mes1){
				$data2['codigo']=$tidactualmasuno[0]->tid;
				$data2['subject']='servicio';
				$data2['detalle']=$tipo.'2';
                $data2['created']=$paydate;
                $data2['cid']=$cid;
                $data2['status']='Pendiente';
                $data2['section']=$paquete;
                $data2['id_factura']='';
                $this->db->insert('tickets',$data2);
				$data4 = array(
				'corden' => $data2['codigo'],
				'tv' => $tv,
				'internet' => $paquete,				
			);		
			$this->db->insert('temporales', $data4);
			}

        if($pmethod=='Balance'){

            $customer = $this->transactions->check_balance($cid);
            if($customer['balance']>=$amount){

                $this->db->set('balance', "balance-$amount", FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');
            }
            else{

                $amount=$customer['balance'];
                $this->db->set('balance', 0, FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');
            }
        }
        $id_banco=null;
        if($pmethod!="Bank"){
            $banco=null;
        }else{
            /*if($banco=="Bancolombia"){
                $cuenta = $this->db->select("*")->from('accounts')->like('holder','Bancolombia','both')->get();
                $cuenta = $cuenta->result();
                if($cuenta!=null){
                    $id_banco=$cuenta[0]->id;
                    $mas=intval($cuenta[0]->lastbal)+intval($amount);
                    $data5['lastbal']=$mas;
                    $this->db->update('accounts',$data5,array('id' =>$id_banco ));    
                }
                
            }else{
                $cuenta = $this->db->select("*")->from('accounts')->like('holder','BBVA','both')->get();
                $cuenta = $cuenta->result();
                if($cuenta!=null){
                    $id_banco=$cuenta[0]->id;
                    $mas=intval($cuenta[0]->lastbal)+intval($amount);
                    $data5['lastbal']=$mas;
                    $this->db->update('accounts',$data5,array('id' =>$id_banco ));    
                }
                

            }*/
        }
    $data = array(
            'acid' => $acid,
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $cname,
            'payerid' => $cid,
            'method' => $pmethod,
            'date' => $paydate,
            'eid' => $this->aauth->get_user()->id,		
            'tid' => $tid,
            'note' => $note.'Metodo: '.$metodo,
            'ext' => 0,
            'nombre_banco'=>$banco,
            'id_banco'=>$id_banco
        );

        $this->db->insert('transactions', $data);
        $this->db->insert_id();

        $this->db->select('invoiceduedate,total,csd,pamnt,rec');
        $this->db->from('invoices');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $invresult = $query->row();

        $totalrm = $invresult->total - $invresult->pamnt;
		

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
			
        } else {

            //$today = $invresult->invoiceduedate;
            //$addday = $invresult->rec;


            //$ndate = date("Y-m-d", strtotime($today . " +" . $addday . 's'));
			

            //$this->db->set('invoiceduedate', $ndate);
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');
			
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');

            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;			
						
				
		

        }
		
		

        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";


        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount,"tid"=>$tid));
    } 


    public function paypurchase()
    {

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $tid = intval($this->input->post('tid'));
        $amount = $this->input->post('amount');
        $paydate = $this->input->post('paydate');
        $note = $this->input->post('shortnote');
        $pmethod = $this->input->post('pmethod');
        $acid = $this->input->post('account');
        $cid = $this->input->post('cid');
        $cname = $this->input->post('cname');
        $paydate = datefordatabase($paydate);

        $this->db->select('holder');
        $this->db->from('accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        $account = $query->row_array();

        $data = array(
            'acid' => $acid,
            'account' => $account['holder'],
            'type' => 'Expense',
            'cat' => 'Purchase',
            'debit' => $amount,
            'payer' => $cname,
            'payerid' => $cid,
            'method' => $pmethod,
            'date' => $paydate,
            'eid' => $this->aauth->get_user()->id,
            'tid' => $tid,
            'note' => $note,
            'ext' => 1
        );

        $this->db->insert('transactions', $data);
        $this->db->insert_id();

        $this->db->select('total,csd,pamnt');
        $this->db->from('purchase');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $invresult = $query->row();

        $totalrm = $invresult->total - $invresult->pamnt;

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'Recibido');
            $this->db->where('tid', $tid);
            $this->db->update('purchase');


            //account update
            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
        } else {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'Cancelado');
            $this->db->where('tid', $tid);
            $this->db->update('purchase');
            //acount update
            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');

            $totalrm = 0;
            $status = 'Cancelado';
            $paid_amount = $amount;		


        }


        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";


        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount));
    }

    public function pay_recinvoice()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $tid = intval($this->input->post('tid'));
        $amount = $this->input->post('amount');
        $paydate = $this->input->post('paydate');
        $note = $this->input->post('shortnote');
        $pmethod = $this->input->post('pmethod');
        $acid = $this->input->post('account');
        $cid = $this->input->post('cid');
        $cname = $this->input->post('cname');
        $paydate = datefordatabase($paydate);

        $this->db->select('holder');
        $this->db->from('accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        $account = $query->row_array();

        $data = array(
            'acid' => $acid,
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $cname,
            'payerid' => $cid,
            'method' => $pmethod,
            'date' => $paydate,
            'eid' => $this->aauth->get_user()->id,
            'tid' => $tid,
            'note' => $note,
            'ext' => 2
        );

        $this->db->insert('transactions', $data);
        $this->db->insert_id();

        $this->db->select('invoiceduedate,total,csd,pamnt,rec');
        $this->db->from('rec_invoices');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $invresult = $query->row();

        $totalrm = $invresult->total - $invresult->pamnt;

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('tid', $tid);
            $this->db->update('rec_invoices');


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
        } else {

            //$today = $invresult->invoiceduedate;
            //$addday = $invresult->rec;


            //$ndate = date("Y-m-d", strtotime($today . " +" . $addday . 's'));

            //$this->db->set('invoiceduedate', $ndate);
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('tid', $tid);
            $this->db->update('rec_invoices');
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');

            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;


        }


        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";


        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount));
    }

    public function cancelinvoice()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }


        $tid = intval($this->input->post('tid'));


        $this->db->set('pamnt', "0.00", FALSE);
        $this->db->set('total', "0.00", FALSE);
        $this->db->set('items', 0);
        $this->db->set('status', 'Anulado');
        $this->db->where('tid', $tid);
        $this->db->update('invoices');
        //reverse
        $this->db->select('credit,acid');
        $this->db->from('transactions');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $revresult = $query->result_array();
        foreach ($revresult as $trans) {
            $amt = $trans['credit'];
            $this->db->set('lastbal', "lastbal-$amt", FALSE);
            $this->db->where('id', $trans['acid']);
            $this->db->update('accounts');
        }
        $this->db->select('pid,qty');
        $this->db->from('invoice_items');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $prevresult = $query->result_array();
        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $this->db->set('qty', "qty+$amt", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->update('products');
        }
        $this->db->delete('transactions', array('tid' => $tid));
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Invoice canceled')));
    }


    public function cancelrec()
    {

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $tid = intval($this->input->post('tid'));
        $this->db->set('status', 'canceled');
        $this->db->set('ron', 'Stopped');
        $this->db->where('tid', $tid);
        $this->db->update('rec_invoices');
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Invoice canceled')));
    }


    public function cancelpurchase()
    {

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $tid = intval($this->input->post('tid'));


        $this->db->set('pamnt', "0.00", FALSE);
        $this->db->set('status', 'anulado');
        $this->db->where('tid', $tid);
        $this->db->update('purchase');
        //reverse
        $this->db->select('credit,acid');
        $this->db->from('transactions');
        $this->db->where('tid', $tid);
        $this->db->where('ext', 1);
        $query = $this->db->get();
        $revresult = $query->result_array();
        foreach ($revresult as $trans) {
            $amt = $trans['debit'];
            $this->db->set('lastbal', "lastbal+$amt", FALSE);
            $this->db->where('id', $trans['acid']);
            $this->db->update('accounts');
        }
        $this->db->select('pid,qty');
        $this->db->from('purchase_items');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $prevresult = $query->result_array();
        foreach ($prevresult as $prd) {
            $amt = $prd['qty'];
            $this->db->set('qty', "qty-$amt", FALSE);
            $this->db->where('pid', $prd['pid']);
            $this->db->update('products');
        }
        $this->db->delete('transactions', array('tid' => $tid, 'ext' => 1));
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Purchase canceled!')));
    }


    public function translist()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $ttype = $this->input->get('type');
        $list = $this->transactions->get_datatables($ttype);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = dateformat($prd->date);
            $row[] = $prd->account;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
            $row[] = $prd->payer;
			$row[] = $prd->tid;
            $row[] = $this->lang->line($prd->method);
            $row[] = "<span id='estado_".$prd->id."'>".$prd->estado."</span>";
            $texto="";
            if($prd->estado!=null){
                $anulacion = $this->db->get_where("anulaciones",array("transactions_id"=>$prd->id))->row();

                $texto='data-detalle="'.$anulacion->detalle.'" data-razon_anulacion="'.$anulacion->razon_anulacion.'" data-usuario_anula="'.$anulacion->usuario_anula.'"';
            }
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="' . base_url() . 'transactions/print_t?id=' . $pid . '" class="btn btn-info btn-xs"  title="Print"><span class="icon-print"></span></a>&nbsp; &nbsp;<a id="anula'.$pid.'" href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs" onclick="abrir_modal(this);" '.$texto.'><span class="icon-bin"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transactions->count_all(),
            "recordsFiltered" => $this->transactions->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
public function anullist()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('anulaciones_model', 'anulaciones');
        $ttype = $this->input->get('type');
        $list = $this->anulaciones->get_datatables($ttype);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = dateformat($prd->date);
            $row[] = $prd->account;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
            $row[] = $prd->payer;
            $row[] = $prd->tid;
            $row[] = $this->lang->line($prd->method);
            $row[] = "<span id='estado_".$prd->id."'>".$prd->estado."</span>";
            $row[] = $prd->razon_anulacion;
            $row[] = $prd->usuario_anula;
            $texto="";
            if($prd->estado!=null){
                $anulacion = $this->db->get_where("anulaciones",array("transactions_id"=>$prd->id))->row();

                $texto='data-detalle="'.$anulacion->detalle.'" data-razon_anulacion="'.$anulacion->razon_anulacion.'" data-usuario_anula="'.$anulacion->usuario_anula.'"';
            }
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="' . base_url() . 'transactions/print_t?id=' . $pid . '" class="btn btn-info btn-xs"  title="Print"><span class="icon-print"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anulaciones->count_all(),
            "recordsFiltered" => $this->anulaciones->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    // Category
    public function categories()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $data['catlist'] = $this->transactions->categories();
        $head['title'] = "Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/cat', $data);
        $this->load->view('fixed/footer');
    }

    public function createcat()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $head['title'] = "Category";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/cat_create');
        $this->load->view('fixed/footer');
    }

    public function editcat()
    {

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $head['title'] = "Category";
        $head['usernm'] = $this->aauth->get_user()->username;

        $id = $this->input->get('id');

        $data['cat'] = $this->transactions->cat_details($id);

        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/trans-cat-edit', $data);
        $this->load->view('fixed/footer');

    }

    public function save_createcat()
    {

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $name = $this->input->post('catname');

        if ($this->transactions->addcat($name)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editcatsave()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $id = $this->input->post('catid');
        $name = $this->input->post('cat_name');

        if ($this->transactions->cat_update($id, $name)) {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
        }


    }

    public function delete_cat()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $id = $this->input->post('deleteid');
        if ($id) {
            $this->db->delete('transactions_cat', array('id' => $id));
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }

    public function save_trans()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $credit = 0;
        $debit = 0;
        $payer_id = intval($this->input->post('payer_id'));
        $payer_name = $this->input->post('payer_name');
        $pay_acc = $this->input->post('pay_acc');
        $date = $this->input->post('date');
        $amount = $this->input->post('amount');
        $pay_type = $this->input->post('pay_type');
        if ($pay_type == 'Income') {
            $credit = $amount;
        } elseif ($pay_type == 'Expense') {
            $debit = $amount;
        }
        $pay_cat = $this->input->post('pay_cat');
        $paymethod = $this->input->post('paymethod');
        $note = $this->input->post('note');
        $date = datefordatabase($date);

        if ($this->transactions->addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $this->aauth->get_user()->id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Transaction has been')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
        }


    }

    public function save_transfer()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $pay_acc = $this->input->post('pay_acc');
        $pay_acc2 = $this->input->post('pay_acc2');
        $amount = $this->input->post('amount');


        if ($this->transactions->addtransfer($pay_acc, $pay_acc2, $amount, $this->aauth->get_user()->id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                'Transfer has been successfully done!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                'Error!'));
        }


    }


    public function delete_i()
    {
        if ($this->aauth->get_user()->roleid < 4) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $id = $this->input->post('deleteid');
        if ($id) {


            echo json_encode($this->transactions->delt($id));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }

    public function income()
    {
        if ($this->aauth->get_user()->roleid < 2) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $head['title'] = "Income Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/income');
        $this->load->view('fixed/footer');
    }

    public function expense()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Expense Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/expense');
        $this->load->view('fixed/footer');

    }

    public function view()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "View Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $data['trans'] = $this->transactions->view($id);
        if ($data['trans']['payerid'] > 0) {
            $data['cdata'] = $this->transactions->cview($data['trans']['payerid'],$data['trans']['ext']);
        } else {
            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
        }
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/view', $data);
        $this->load->view('fixed/footer');

    }


    public function print_t()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "View Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');
        $data['trans'] = $this->transactions->view($id);
        if ($data['trans']['payerid'] > 0) {
            $data['cdata'] = $this->transactions->cview($data['trans']['payerid'],$data['trans']['ext']);
        } else {
            $data['cdata'] = array('address' => 'Not Registered', 'city' => '', 'phone' => '', 'email' => '');
        }



        ini_set('memory_limit', '64M');

        $html = $this->load->view('transactions/view-print', $data,true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load_en();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;"><tr><td width="33%"></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#'.$id.'</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Trans_#' . $id . '.pdf', 'D');
        } else {
            $pdf->Output('Trans_#' . $id . '.pdf', 'I');
        }





    }


}