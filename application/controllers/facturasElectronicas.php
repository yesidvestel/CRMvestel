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

class facturasElectronicas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }
    public function index(){
    	$head['title'] = "Administrar Facturas Electronicas Customer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/facturas_electronicas');
        $this->load->view('fixed/footer');
    }

    public function ajax_list()
    {
    	$this->load->model('Facturas_electronicas_model', 'facturas');

        $list = $this->facturas->get_datatables();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $facturas) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $facturas->consecutivo_siigo;
            $row[] = dateformat($facturas->fecha);
            $row[] = $facturas->customer_id;
            if($facturas->invoice_id=="" || $facturas->invoice_id==null || $facturas->invoice_id=="")
            $row[] = $facturas->invoice_id;
            $row[] = $facturas->servicios_facturados;
            $row[] = amountFormat($facturas->s1TotalValue);
           // $row[] = '<span class="st-' . $invoices->status . '">' . $invoices->status . '</span>';			
           // $row[] = '<a href="' . base_url("purchase/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp';
			

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->facturas->count_all(),
            "recordsFiltered" => $this->facturas->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }
    public function guardar(){
    	$this->load->library('SiigoAPI');
        $api = new SiigoAPI();
        $this->load->model("customers_model","customers");
        $dataApi= $this->customers->getClientData();
        $dataApi=json_decode($dataApi);
        $consecutivo_siigo=$this->db->select("max(consecutivo_siigo)+1 as consecutivo_siigo")->from("facturacion_electronica_siigo")->get()->result();
        $dataApi->Header->Number=$consecutivo_siigo[0]->consecutivo_siigo;
        //customer data and facturacion_electronica_siigo table insert
        $customer = $this->db->get_where("customers",array('id' =>$_POST['id']))->row();
        //data siigo api
       	$dataApi->Header->Account->FullName=strtoupper($customer->name." ".$customer->dosnombre." ".$customer->unoapellido." ".$customer->dosapellido);       	
       	$dataApi->Header->Account->FullName=str_replace("?", "Ñ", $dataApi->Header->Account->FullName);
       	$dataApi->Header->Account->FirstName=strtoupper(str_replace("?", "Ñ",$customer->name));
       	$dataApi->Header->Account->LastName=strtoupper(str_replace("?", "Ñ",$customer->unoapellido));
       	$dataApi->Header->Account->Identification=$customer->documento;
       	if(strpos(strtolower($customer->ciudad),"monterrey" )!==false){
           	$dataApi->Header->Account->City->CityCode="85162";	                                 
        }else if(strpos(strtolower($customer->ciudad),"villanueva" )!==false){
           	$dataApi->Header->Account->City->CityCode="85440";	                                 
        }else if(strpos(strtolower($customer->ciudad),"mocoa" )!==false){
           	$dataApi->Header->Account->City->StateCode="86";	                                 
           	$dataApi->Header->Account->City->CityCode="86001";
        }

        $dataApi->Header->Account->Address=$customer->nomenclatura . ' ' . $customer->numero1 . $customer->adicionauno.' Nº '.$customer->numero2.$customer->adicional2.' - '.$customer->numero3;
        $dataApi->Header->Account->Phone->Number=$customer->celular;
        $dataApi->Header->Contact->Phone1->Number=$customer->celular2;
        $dataApi->Header->Contact->EMail=$customer->email;
        $dataApi->Header->Contact->FirstName=$dataApi->Header->Account->FirstName;
        $dataApi->Header->Contact->LastName=$dataApi->Header->Account->LastName;
        $dateTime=new DateTime($_POST['sdate']);
        $dataApi->Header->DocDate=$dateTime->format("Ymd");
        $dataApi->Payments[0]->DueDate=$dateTime->format("Ymd");
       	//falta el manejo de los saldos saldos
       	var_dump($dateTime->format("Ymd"));
       	var_dump($dataApi->Payments[0]->DueDate);
        var_dump($dataApi->Header->Number);
        var_dump($dataApi->Header->Account->Phone->Number);
        //facturacion_electronica_siigo table insert        
        $dataInsert=array();
        $dataInsert['consecutivo_siigo']=$dataApi->Header->Number;
        $dataInsert['fecha']=$dateTime->format("Y-m-d");
        $dataInsert['customer_id']=$_POST['id'];
        $dataInsert['servicios_facturados']=$_POST['servicios'];
        // end customer data facturacion_electronica_siigo table insert
        $dataApi=json_encode($dataApi);        
        //$api->accionar($api,$dataApi); 
    }
}