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
    public function input_mask(){
        $this->load->view('fixed/header');
        $data=array();
        $this->load->view('transactions/mask',$data);
        $this->load->view('fixed/footer');
    }
	public function explortar_a_excel(){
        
        $this->db->select("*");
        $this->db->from("transactions");
		//$this->db->join('customers', 'tickets.cid=customers.id', 'left');
		$this->db->where('type', 'Expense');
		$this->db->where('tid !=', -1);
		$this->db->where('estado');
		if ($_GET['cuentas'] != '' && $_GET['cuentas'] != '-' && $_GET['cuentas'] != '0') {
                $this->db->where('account=', $_GET['cuentas']);
            }
		if ($_GET['categorias'] != '' && $_GET['categorias'] != '-' && $_GET['categorias'] != '0') {
                $this->db->where('cat=', $_GET['categorias']);
           }
		if($_GET['opcselect']!=''){

            $dateTime= new DateTime($_GET['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($_GET['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($_GET['opcselect']=="fcreada"){
                $this->db->where('date>=', $sdate);   
                $this->db->where('date<=', $edate);       
            }
            
        }
        $this->db->order_by("id","DESC");
        $lista_debito=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_debito2=array();
		
    
    //define column headers
    $headers = array(
        'Fecha' => 'date', 
        'Cuenta' => 'string',
		'Valor' => 'integer',
		'Motivo' => 'string',
		'Categoria' => 'string',
		'Orden N' => 'string',
		'Detalle' => 'string',
		'Metodo' => 'string');
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte debitos ');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte Debito ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Debito ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
));
    
    //write rows to sheet1
	
    foreach ($lista_debito as $key => $debito) {
		$fecha = date("d/m/Y",strtotime($debito->date));
            $writer->writeSheetRow('Debito ',array($debito->date,$debito->account,$debito->debit,$debito->playerid,$debito->cat,$debito->tid,$debito->note,$debito->method));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Debito '.$fecha_actual.'.xlsx';
    
    //write to xlsx file
    $writer->writeToFile($fileLocation);
    //echo $writer->writeToString();
    
    //force download
    header('Content-Description: File Transfer');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=".basename($fileLocation));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Length: ' . filesize($fileLocation)); //Remove

    ob_clean();
    flush();

    readfile($fileLocation);
    unlink($fileLocation);
    exit(0);
       

    }
	public function explortar_a_excel2(){
        
        $this->db->select("*");
        $this->db->from("transactions");
		//$this->db->join('customers', 'tickets.cid=customers.id', 'left');
		$this->db->where('type', 'Income');
		$this->db->where('estado');
		$this->db->where('tid !=', -1);
		if ($_GET['cuentas'] != '' && $_GET['cuentas'] != '-' && $_GET['cuentas'] != '0') {
                $this->db->where('account=', $_GET['cuentas']);
            }
		if ($_GET['metodo'] != '' && $_GET['metodo'] != '-' && $_GET['metodo'] != '0') {
                $this->db->where('method=', $_GET['metodo']);
           }
		if($_GET['opcselect']!=''){

            $dateTime= new DateTime($_GET['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($_GET['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($_GET['opcselect']=="fcreada"){
                $this->db->where('date>=', $sdate);   
                $this->db->where('date<=', $edate);       
            }
            
        }
        $this->db->order_by("id","DESC");
        $lista_creditos=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_creditos2=array();
		
    
    //define column headers
    $headers = array(
        'Fecha' => 'string', 
        'Cuenta' => 'string',
		'Valor' => 'integer',
		'Motivo' => 'string',
		'Categoria' => 'string',
		'Cuenta N' => 'string',
		'Detalle' => 'string',
		'Metodo' => 'string');
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte creditos ');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte creditos ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Creditos ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
));
    
    //write rows to sheet1
	
    foreach ($lista_creditos as $key => $creditos) {
		$fecha = date("d/m/Y",strtotime($creditos->date));
            $writer->writeSheetRow('Creditos ',array($fecha,$creditos->account,$creditos->credit,$creditos->payer,$creditos->cat,$creditos->tid,$creditos->note,$creditos->method));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Creditos '.$fecha_actual.'.xlsx';
    
    //write to xlsx file
    $writer->writeToFile($fileLocation);
    //echo $writer->writeToString();
    
    //force download
    header('Content-Description: File Transfer');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=".basename($fileLocation));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Length: ' . filesize($fileLocation)); //Remove

    ob_clean();
    flush();

    readfile($fileLocation);
    unlink($fileLocation);
    exit(0);
       

    }
	public function explortar_a_excel3(){
        
        $this->db->select("*");
        $this->db->from("transactions");
		$this->db->join('anulaciones', 'transactions.id=anulaciones.transactions_id', 'left');
		$this->db->where('estado', 'Anulada');
        $this->db->order_by("id","DESC");
        $lista_creditos=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_creditos2=array();
		
    
    //define column headers
    $headers = array(
        'Fecha' => 'string', 
        'Centro de costo' => 'string',
		'Debito' => 'integer',
		'Credito' => 'integer',
		'Motivo' => 'string',
		'Codigo cuenta' => 'string',
		'Razon' => 'string',
		'Responsable' => 'string'
		);
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte Anulaciones ');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte Anulaciones ');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Anulaciones ',$headers,$col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
));
    
    //write rows to sheet1
	
    foreach ($lista_creditos as $key => $creditos) {
		$fecha = date("d/m/Y",strtotime($creditos->date));
            $writer->writeSheetRow('Anulaciones ',array($fecha,$creditos->account,$creditos->debit,$creditos->credit,$creditos->detalle,$creditos->tid,$creditos->razon_anulacion,$creditos->usuario_anula));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Anulaciones '.$fecha_actual.'.xlsx';
    
    //write to xlsx file
    $writer->writeToFile($fileLocation);
    //echo $writer->writeToString();
    
    //force download
    header('Content-Description: File Transfer');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=".basename($fileLocation));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Length: ' . filesize($fileLocation)); //Remove

    ob_clean();
    flush();

    readfile($fileLocation);
    unlink($fileLocation);
    exit(0);
       

    }
    public function index()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $head['title'] = "Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data= array();
        if(isset($_GET['id_tr'])){
            $data['id_tr']=$_GET['id_tr'];
        }
		$this->load->model('accounts_model', 'accounts');
		$data['cta'] = $this->accounts->accountslist();
		$data['cat'] = $this->transactions->categories();
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/index',$data);
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

    /*public function facturas_customer(){
        $this->load->model('ticket_model', 'ticket');
        $facturalist = $this->ticket->factura_list($this->input->post("id_customer"));
        $lista=array();
        foreach ($facturalist as $row) {
            $cid = $row['id'];
            $title = $row['tid'];
            setlocale(LC_TIME, "spanish");
            $mes = date(" F ",strtotime($row['invoicedate']));
            
            $lista[]= "<option value='$title'>$title".' '. strftime("%B del %Y", strtotime($mes))." </option>";
        }
        echo json_encode($lista);
    }*/

    public function transfer()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $data['cat'] = $this->transactions->categories();
        $data['accounts'] = $this->transactions->acc_list();
        $data['tcuentas'] = $this->transactions->tdascuentas();
        $head['title'] = "New Transfer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/transfer', $data);
        $this->load->view('fixed/footer');

    }
    public function payinvoicemultiple(){$this->load->helper('cookie');
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $ids_transacciones=array();
        $ids_facturas =$this->input->post('facturas_seleccionadas');
            $x="";
        $array_facturas=explode("-", $ids_facturas);
        $monto=$this->input->post('amount');
        $monto_aux=$monto;
        $valor_restante_monto=0;
        $montos=array();
        $array_facturas2=array();
        $_id_last_invoice_procesed=0;
        $factura_var=null;
        $pa="no";
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
                    $_id_last_invoice_procesed=$id_factura;
                }else if($monto>0 && $factura_var->status!="partial"){
                    $montos[$id_factura]=$monto;
                    $array_facturas2[]=$id_factura;
                    $monto=$valor_restante_monto;  
                    $_id_last_invoice_procesed=$id_factura;
                }else if($valor_restante_monto<0 && $monto>0 && $factura_var->status=="partial"){
                    $montos[$id_factura]=$monto;
                    $array_facturas2[]=$id_factura;
                    $monto=$valor_restante_monto;
                    $_id_last_invoice_procesed=$id_factura;  
                    break;
                }
                
            }
            //var_dump($valor_restante_monto);
            if($valor_restante_monto>0){
                $montos[$_id_last_invoice_procesed]+=$valor_restante_monto;
            }
            $cal1=$factura_var->pamnt-$factura_var->total;
            if($cal1>=0 && $factura_var->status=="paid"){//validar el igual a 0
                 $valor_restante_monto=$cal1+$monto_aux;
                 $pa="si";
            }

            
        $id_fact_pagadas="";
        $reconexion_gen="no";
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

        $reconexion = $this->input->post('reconexion');
        
        $tipo = $this->input->post('tipo');
        
        if($reconexion=="si"){
            $factura_asociada = $this->input->post('factura_asociada');    
     if($reconexion_gen=="no"){//&& $factura_asociada==$factura_var->tid
        $factura_asociada = $this->db->get_where('invoices',array('tid'=>$factura_asociada))->row();
        $fcuenta = $factura_asociada->invoicedate;
        /*$paquete="no";
        $var1 = $this->input->post('paquete_yopal_monterrey');
        $var2 = $this->input->post('paquete_villanueva');
        if($var1!="no"){
            $paquete=$var1;    
        }else if($var2!="no"){
            $paquete=$var2;    
        }else{
            $paquete = "no";    
        }*/
        

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
		$username = $this->aauth->get_user()->username;
        $tidactualmasuno= $this->db->select('max(codigo)+1 as tid')->from('tickets')->get()->result();
        $tidactualmasdos= $this->db->select('max(codigo)+2 as tid')->from('tickets')->get()->result();
		$parmasuno= $this->db->select('max(par)+1 as par')->from('tickets')->get()->result();
        if ($reconexion==si && $mes2===$mes1){
			if ($tipo=='Reconexion Combo'){
				//internet
				$data2['codigo']=$tidactualmasuno[0]->tid;
                $data2['subject']='servicio';
                $data2['detalle']='Reconexion Internet';
                $data2['created']=$paydate;
                $data2['cid']=$cid;
				$data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$factura_asociada->combo;
                $data2['id_factura']=$factura_asociada->tid;
                $this->db->insert('tickets',$data2);
				//tv
				$data3['codigo']=$tidactualmasdos[0]->tid;
                $data3['subject']='servicio';
                $data3['detalle']='Reconexion Television';
                $data3['created']=$paydate;
                $data3['cid']=$cid;
				$data3['col']=$username;
                $data3['status']='Pendiente';
                $data3['section']='Television';
                $data3['id_factura']=$factura_asociada->tid;
                $this->db->insert('tickets',$data3);
			}else{
				$data2['codigo']=$tidactualmasuno[0]->tid;
                $data2['subject']='servicio';
                $data2['detalle']=$tipo;
                $data2['created']=$paydate;
                $data2['cid']=$cid;
				$data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$factura_asociada->combo;
                $data2['id_factura']=$factura_asociada->tid;
                $this->db->insert('tickets',$data2);
			}
           

                          $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data2);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="tickets";
                            $data_h['nombre_columna']="idt";
                            $this->db->insert("historial_crm",$data_h);
                $reconexion_gen="si";
        }if ($reconexion==si && $mes2>$mes1){
			if ($tipo=='Reconexion Combo'){
				//internet
				$data2['codigo']=$tidactualmasuno[0]->tid;
                $data2['subject']='servicio';
                $data2['detalle']='Reconexion Internet2';
                $data2['created']=$paydate;
                $data2['cid']=$cid;
				$data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$factura_asociada->combo;
                $data2['id_factura']='';
                $data2['par']=$parmasuno[0]->par;
                $this->db->insert('tickets',$data2);
				//tv
				$data3['codigo']=$tidactualmasdos[0]->tid;
                $data3['subject']='servicio';
                $data3['detalle']='Reconexion Television2';
                $data3['created']=$paydate;
                $data3['cid']=$cid;
				$data3['col']=$username;
                $data3['status']='Pendiente';
                $data3['section']='Television';
                $data3['id_factura']='';
                $data3['par']=$parmasuno[0]->par;
                $this->db->insert('tickets',$data3);
			}else{
				$data2['codigo']=$tidactualmasuno[0]->tid;
                $data2['subject']='servicio';
                $data2['detalle']=$tipo.'2';
                $data2['created']=$paydate;
                $data2['cid']=$cid;
				$data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$factura_asociada->combo;
                $data2['id_factura']='';
                $this->db->insert('tickets',$data2);
			}
                
                            $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data2);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="tickets";
                            $data_h['nombre_columna']="idt";
                            $this->db->insert("historial_crm",$data_h);
                $data4 = array(
                'corden' => $data2['codigo'],
                'tv' => $tv,
                'internet' => $factura_asociada->combo,             
            );      
                $reconexion_gen="si";
            $this->db->insert('temporales', $data4);
                            $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data4);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="temporales";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
            }
        }
}
        if($pmethod=='Balance'){

            $customer = $this->transactions->check_balance($cid);
            if($customer['balance']>=$amount){

                $this->db->set('balance', "balance-$amount", FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');
                            $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("balance"=>"balance-$amount"));
                            $data_h['id_fila']=$cid;
                            $data_h['tabla']="customers";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
            }
            else{

                $amount=$customer['balance'];
                $this->db->set('balance', 0, FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');

                         $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("balance"=>"0"));
                            $data_h['id_fila']=$cid;
                            $data_h['tabla']="customers";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
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

                            $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data5);
                            $data_h['id_fila']=$id_banco;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h); 
                }
                
            }else{
                $cuenta = $this->db->select("*")->from('accounts')->like('holder','BBVA','both')->get();
                $cuenta = $cuenta->result();
                if($cuenta!=null){
                    $id_banco=$cuenta[0]->id;
                    $mas=intval($cuenta[0]->lastbal)+intval($amount);
                    $data5['lastbal']=$mas;
                    $this->db->update('accounts',$data5,array('id' =>$id_banco )); 
                            $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data5);
                            $data_h['id_fila']=$id_banco;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);    
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
        $h_x1=$this->db->insert_id();

                            $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data);
                            $data_h['id_fila']=$h_x1;
                            $data_h['tabla']="transactions";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
        $idtr = $this->db->select('max(id) as id')->from('transactions')->where(array("tid"=>$tid))->get()->result();
        $ids_transacciones[]=$idtr[0]->id;

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

                        $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("status"=>"partial","pamnt"=>"pamnt+$amount","pmethod"=>$pmethod));
                            $data_h['id_fila']=$tid;
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);
            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');

                    $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                            $data_h['id_fila']=$acid;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
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
                    $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("status"=>"paid","pamnt"=>"pamnt+$amount","pmethod"=>$pmethod));
                            $data_h['id_fila']=$tid;
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                        $data_h=array();
                            $data_h['modulo']="Usuarios";
                            $data_h['accion']="Administrar Usuarios > Ver Usuario > Ver Facturas > Hacer el Pago (pago multiple) {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                            $data_h['id_fila']=$acid;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);

            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;


        }


       // $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";


        //echo json_encode(array('status' => 'Success', 'message' =>
            //$this->lang->line('Transaction has been added'), 'pstatus' => $this->lang->line($status), 'activity' => $activitym, 'amt' => $totalrm, 'ttlpaid' => $paid_amount));
            //codigo cop fin
        }
        $this->load->model('customers_model', 'customers');
        $this->customers->actualizar_debit_y_credit($cid);
        if(count($ids_transacciones)!=0){
            
            $data_ids=array("ids_transacciones_rp"=>json_encode($ids_transacciones));
            $this->db->update("customers",$data_ids,array("id"=>$cid));
            
        }else{
            $data_ids=array("ids_transacciones_rp"=>json_encode($ids_transacciones));
            $this->db->update("customers",$data_ids,array("id"=>$cid));
            
        }
        
        $link ="<a href='".base_url()."invoices/printinvoice?id=".$id_fact_pagadas."' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span>Ver PDF Facturas Pagadas</a>";
        echo json_encode(array('status'=>"Success",'message' =>$this->lang->line('Transaction has been added ').$link,"id_fact_pagadas"=>$id_fact_pagadas,"valor_restante_monto"=>$valor_restante_monto,"pa"=>$pa));
    }
    public function payinvoice()
    {
$this->load->helper('cookie');
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $ids_transacciones=array();
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
		$username = $this->aauth->get_user()->username;
		$tidactualmasuno= $this->db->select('max(codigo)+1 as tid')->from('tickets')->get()->result();
		if ($reconexion==si && $mes2===$mes1){
			$data2['codigo']=$tidactualmasuno[0]->tid;
				$data2['subject']='servicio';
				$data2['detalle']=$tipo;
                $data2['created']=$paydate;
                $data2['cid']=$cid;
				$data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$factura->combo;
                $data2['id_factura']=$tid;
                $this->db->insert('tickets',$data2);
                         $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data2);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="tickets";
                            $data_h['nombre_columna']="idt";
                            $this->db->insert("historial_crm",$data_h);
		}if ($reconexion==si && $mes2>$mes1){
				$data2['codigo']=$tidactualmasuno[0]->tid;
				$data2['subject']='servicio';
				$data2['detalle']=$tipo.'2';
                $data2['created']=$paydate;
                $data2['cid']=$cid;
				$data2['col']=$username;
                $data2['status']='Pendiente';
                $data2['section']=$factura->combo;
                $data2['id_factura']='';
                $this->db->insert('tickets',$data2);
                        $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data2);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="tickets";
                            $data_h['nombre_columna']="idt";
                            $this->db->insert("historial_crm",$data_h);
				$data4 = array(
				'corden' => $data2['codigo'],
				'tv' => $tv,
				'internet' => $factura->combo,				
			);		
			$this->db->insert('temporales', $data4);
                    $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data4);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="temporales";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
			}

        if($pmethod=='Balance'){

            $customer = $this->transactions->check_balance($cid);
            if($customer['balance']>=$amount){

                $this->db->set('balance', "balance-$amount", FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');
                        $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("balance"=>"balance-$amount"));
                            $data_h['id_fila']=$cid;
                            $data_h['tabla']="customers";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
            }
            else{

                $amount=$customer['balance'];
                $this->db->set('balance', 0, FALSE);
                $this->db->where('id', $cid);
                $this->db->update('customers');
                        $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("balance"=>"0"));
                            $data_h['id_fila']=$cid;
                            $data_h['tabla']="customers";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
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
       $ins_x= $this->db->insert_id();
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data);
                            $data_h['id_fila']=$ins_x;
                            $data_h['tabla']="transactions";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
        $idtr = $this->db->select('max(id) as id')->from('transactions')->where(array("tid"=>$tid))->get()->result();
        $ids_transacciones[]=$idtr[0]->id;

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
                        $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("status"=>"partial","pamnt"=>"pamnt+$amount","pmethod"=>$pmethod));
                            $data_h['id_fila']=$tid;
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);

            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                            $data_h['id_fila']=$acid;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
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
			                $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("status"=>"paid","pamnt"=>"pamnt+$amount","pmethod"=>$pmethod));
                            $data_h['id_fila']=$acid;
                            $data_h['tabla']="invoices";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                            $data_h=array();
                            $data_h['modulo']="Ventas";
                            $data_h['accion']="Administrar Facturas > Ver Factura > Hacer el pago {update}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                            $data_h['id_fila']=$acid;
                            $data_h['tabla']="accounts";
                            $data_h['nombre_columna']="tid";
                            $this->db->insert("historial_crm",$data_h);
            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;			
						
				
		

        }
		
		

        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";

        $this->load->model('customers_model', 'customers');
        $this->customers->actualizar_debit_y_credit($cid);
        if(count($ids_transacciones)!=0){
            $data_ids=array("ids_transacciones_rp"=>json_encode($ids_transacciones));
            $this->db->update("customers",$data_ids,array("id"=>$cid));
            
        }else{
            $data_ids=array("ids_transacciones_rp"=>json_encode($ids_transacciones));
            $this->db->update("customers",$data_ids,array("id"=>$cid));
            
        }
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
        $nop = $this->input->post('nop');
        $paydate = datefordatabase($paydate);

        $this->db->select('holder');
        $this->db->from('accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        $account = $query->row_array();
        if($nop==null){
            $nop=0;
        }else{
            $nop=1;
        }
      
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
            'no_mostrar'=>$nop,
            'ext' => 1
        );

        $this->db->insert('transactions', $data);
       $id_h= $this->db->insert_id();
            $data_h=array();
            $data_h['modulo']="Orden de Compra";
            $data_h['accion']="Hacer el Pago {insert}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode($data);
            $data_h['id_fila']=$id_h;
            $data_h['tabla']="transactions";
            $data_h['nombre_columna']="id";
            $this->db->insert("historial_crm",$data_h);
        $this->db->select('total,csd,pamnt');
        $this->db->from('purchase');
        $this->db->where('tid', $tid);
        $query = $this->db->get();
        $invresult = $query->row();

        $totalrm = $invresult->total - $invresult->pamnt;

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'abonado');
            $this->db->where('tid', $tid);
            $this->db->update('purchase');
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Hacer el Pago {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=$pmethod." - abonado, pamnt+$amount";
                    $data_h['id_fila']=$tid;
                    $data_h['tabla']="purchase";
                    $data_h['nombre_columna']="tid";
                    $this->db->insert("historial_crm",$data_h);

            //account update
            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Hacer el Pago {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']="lastbal-$amount";
                    $data_h['id_fila']=$acid;
                    $data_h['tabla']="accounts";
                    $data_h['nombre_columna']="id";
                    $this->db->insert("historial_crm",$data_h);
            $paid_amount = $invresult->pamnt + $amount;
            $status = 'Partial';
            $totalrm = $totalrm - $amount;
        } else {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'Cancelado');
            $this->db->where('tid', $tid);
            $this->db->update('purchase');
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Hacer el Pago {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=$pmethod." - Cancelado, pamnt+$amount";
                    $data_h['id_fila']=$tid;
                    $data_h['tabla']="purchase";
                    $data_h['nombre_columna']="tid";
                    $this->db->insert("historial_crm",$data_h);
            //acount update
            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Hacer el Pago {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']="lastbal-$amount";
                    $data_h['id_fila']=$acid;
                    $data_h['tabla']="accounts";
                    $data_h['nombre_columna']="id";
                    $this->db->insert("historial_crm",$data_h);
            $totalrm = 0;
            $status = 'Cancelado';
            $paid_amount = $amount;		


        }


        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";

$this->load->model('customers_model', 'customers');
        $this->customers->actualizar_debit_y_credit($cid);
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
       $id_t= $this->db->insert_id();
             $data_h=array();
            $data_h['modulo']="Reciclaje de ventas";
            $data_h['accion']="Adminstrar Facturas > Ver > Hacer el pago {insert}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode($data);
            $data_h['id_fila']=$this->db->insert_id();
            $data_h['tabla']="transactions";
            $data_h['nombre_columna']="id";
            $this->db->insert("historial_crm",$data_h);


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
                     $data_h=array();
                    $data_h['modulo']="Reciclaje de ventas";
                    $data_h['accion']="Adminstrar Facturas > Ver > Hacer el pago {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode(array("pamnt"=>"pamnt+$amount","pmethod"=>$pmethod));
                    $data_h['id_fila']=$tid;
                    $data_h['tabla']="rec_invoices";
                    $data_h['nombre_columna']="tid";
                    $this->db->insert("historial_crm",$data_h);


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                    $data_h=array();
                    $data_h['modulo']="Reciclaje de ventas";
                    $data_h['accion']="Adminstrar Facturas > Ver > Hacer el pago {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                    $data_h['id_fila']=$acid;
                    $data_h['tabla']="accounts";
                    $data_h['nombre_columna']="id";
                    $this->db->insert("historial_crm",$data_h);
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
                         $data_h=array();
                        $data_h['modulo']="Reciclaje de ventas";
                        $data_h['accion']="Adminstrar Facturas > Ver > Hacer el pago {update}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array("pmethod"=>$pmethod,"pamnt"=>"pamnt+$amount","status"=>"paid"));
                        $data_h['id_fila']=$tid;
                        $data_h['tabla']="rec_invoices";
                        $data_h['nombre_columna']="tid";
                        $this->db->insert("historial_crm",$data_h);
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $acid);
            $this->db->update('accounts');
                        $data_h=array();
                        $data_h['modulo']="Reciclaje de ventas";
                        $data_h['accion']="Adminstrar Fcaturas > Ver > Hacer el pago {update}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amount"));
                        $data_h['id_fila']=$acid;
                        $data_h['tabla']="accounts";
                        $data_h['nombre_columna']="id";
                        $this->db->insert("historial_crm",$data_h);
            $totalrm = 0;
            $status = 'Paid';
            $paid_amount = $amount;


        }


        $activitym = "<tr><td>" . substr($paydate, 0, 10) . "</td><td>$pmethod</td><td>$amount</td><td>$note</td></tr>";

$this->load->model('customers_model', 'customers');
        $this->customers->actualizar_debit_y_credit($cid);
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
        $this->db->set('status', 'canceled');
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

        $data_h=array();
            $data_h['modulo']="Ventas";
            $data_h['accion']="Administrar Facturas > ver factura > anular {update}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']="se anula la factura en cuestion realizando la devolucion de las cantidades de productos y eliminando las trasnsacciones asociadas";
            $data_h['id_fila']=$tid;
            $data_h['tabla']="invoices";
            $data_h['nombre_columna']="tid";
            $this->db->insert("historial_crm",$data_h);
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
                    $data_h=array();
                        $data_h['modulo']="Reciclaje de ventas";
                        $data_h['accion']="Adminstrar Facturas > Ver > Cancelar {update}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']=json_encode(array("ron"=>"Stopped","status"=>"canceled"));
                        $data_h['id_fila']=$tid;
                        $data_h['tabla']="rec_invoices";
                        $data_h['nombre_columna']="tid";
                        $this->db->insert("historial_crm",$data_h);
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
                $data_h=array();
                $data_h['modulo']="Orden de Compra";
                $data_h['accion']="Cancelar orden de compra {update}";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']=json_encode(array("pamnt"=>"0.00","status"=>"anular"));
                $data_h['id_fila']=$tid;
                $data_h['tabla']="purchase";
                $data_h['nombre_columna']="tid";
                $this->db->insert("historial_crm",$data_h);
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
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Cancelar orden de compra {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode(array("lastbal"=>"lastbal+$amt"));
                    $data_h['id_fila']=$trans['acid'];
                    $data_h['tabla']="accounts";
                    $data_h['nombre_columna']="id";
                    $this->db->insert("historial_crm",$data_h);
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
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Cancelar orden de compra {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode(array("qty"=>"qty-$amt"));
                    $data_h['id_fila']=$prd['pid'];
                    $data_h['tabla']="products";
                    $data_h['nombre_columna']="pid";
                    $this->db->insert("historial_crm",$data_h);
        }
        $this->db->delete('transactions', array('tid' => $tid, 'ext' => 1));

                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Cancelar orden de compra {delete}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode(array('tid' => $tid, 'ext' => 1));
                    $data_h['id_fila']=$tid;
                    $data_h['tabla']="transactions";
                    $data_h['nombre_columna']="tid,ext";
                    $this->db->insert("historial_crm",$data_h);
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Purchase canceled!')));
    }


    public function translist()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $ttype = $this->input->get('type');
        $list = $this->transactions->get_datatables($ttype,$_GET);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $pid;
            $row[] = dateformat($prd->date);
            $row[] = $prd->account;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
            $row[] = $prd->payer;
			$row[] = $prd->tid.' '.$prd->note;
            $row[] = $this->lang->line($prd->method);
			$row[] = $prd->cat;
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
            "recordsTotal" => $this->transactions->count_all($ttype,$_GET),
            "recordsFiltered" => $this->transactions->count_filtered($ttype,$_GET),
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


            
            $tr1=$this->db->get_where("transactions",array("id"=>$id))->row();
$ids_tr=$this->db->get_where("transactions_ids_recibos_de_pago",array("id_transaccion"=>$id))->result_array();
$recibo_pago=$this->db->get_where("recibos_de_pago",array("id"=>$ids_tr[0]['id_recibo_de_pago']))->row();
$lista_resivos=$this->db->get_where("recibos_de_pago",array("file_name"=>$recibo_pago->file_name))->result_array();
if(count($lista_resivos)>0){
$result=array();
        foreach ($lista_resivos as $key_r => $value_r) {
            $lista_tr_rb=$this->db->get_where("transactions_ids_recibos_de_pago",array("id_recibo_de_pago"=>$value_r['id']))->result_array();
                    foreach ($lista_tr_rb as $key_tr => $value_tr) {
                            $tr=$this->db->get_where("transactions",array("id"=>$value_tr['id_transaccion'],"estado"=>null))->row();
                            if(isset($tr)){
                               $res= $this->transactions->delt($value_tr['id_transaccion']);
                                if($value_tr['id_transaccion']==$id){
                                    $result=$res;
                                }
                            }         
                    }
            $this->db->delete("transactions_ids_recibos_de_pago",array("id_recibo_de_pago"=>$value_r['id']));
            $this->db->delete("recibos_de_pago",array("id"=>$value_r['id']));

        }
    echo json_encode($result);
}else{
    echo json_encode($this->transactions->delt($id));//liena importante
}
     
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }

    public function income()
    {
		$this->load->model('accounts_model', 'accounts');
		$this->load->model("customers_model","customers");
        if ($this->aauth->get_user()->roleid < 2) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
		$data['cta'] = $this->transactions->tdascuentas();
		$data['meto2'] = $this->transactions->metodos();
        $head['title'] = "Income Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/income', $data);
        $this->load->view('fixed/footer');
    }
	public function transferencia()
    {
        if ($this->aauth->get_user()->roleid < 2) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $head['title'] = "Transferencias";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/transferencia');
        $this->load->view('fixed/footer');
    }

    public function expense()
    {
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
		$this->load->model('accounts_model', 'accounts');
        $head['title'] = "Expense Transaction";
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['cta'] = $this->transactions->tdascuentas();
		$data['cat'] = $this->transactions->categories();
        $this->load->view('fixed/header', $head);
        $this->load->view('transactions/expense',$data);
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