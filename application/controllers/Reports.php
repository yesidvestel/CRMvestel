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

class Reports extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('reports_model', 'reports');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

    }

    public function index()
    {


    }

    //Statistics

    public function statistics()

    {
		$this->load->model("dashboard_model");
		$today = date("Y-m-d");
        $month = date("m");
        $month2 = date("m",strtotime($today."- 1 month"));
        $year = date("Y");
		$sede = "";//$this->input->get('sede');
        $data['stat'] = $this->reports->statistics();
		$data['incomechart'] = $this->dashboard_model->incomeChart($today, $month, $year,$sede);
		$data['incomechart2'] = $this->dashboard_model->incomeChart($today, $month2, $year,$sede);
        $data['expensechart'] = $this->dashboard_model->expenseChart($today, $month2, $year,$sede);
        $head['title'] = "Statisticst";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/stat', $data);
        $this->load->view('fixed/footer');

    }
	//estadisticas tecnicos
public function historial_crm(){

        $head['title'] = "Historial CRM";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        if ($this->aauth->get_user()->roleid >= 5) {
            $this->load->view('reports/historial_crm');
        }
        $this->load->view('fixed/footer');
}
public function historial_list(){
    $this->load->model("Historial_model","historial");
    $list = $this->historial->get_datatables();
    $data = array();
    $no = $this->input->post('start');
    setlocale(LC_TIME, "spanish");

    foreach ($list as $key => $value) {            
            $no++;  
            $row = array();
            $row[]=$value->id;
            $x=new DateTime($value->fecha);
            $row[]= utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime($value->fecha)))."-<u>".$x->format("g").":".$x->format("s")." ".$x->format("a")."</u>";
            $row[]=$value->modulo;
            $row[]=$value->accion;
            if($value->id_fila==""||$value->id_fila==0||$value->id_fila==null){
                $row[]=$value->tabla;
            }else{
                if($value->tabla=="equipos"){
                    $prod=$this->db->get_where("equipos",array("id"=>$value->id_fila))->row();
                    if(isset($prod)){
                        $row[]=$value->tabla.", "."codigo"."=".$prod->codigo;       
                    }else{
                        $row[]=$value->tabla.", ".$value->nombre_columna."=".$value->id_fila;    
                    }
                    
                }else if($value->nombre_columna=="pid" && isset($value->id_fila) && $value->id_fila!=0){
                    $prod=$this->db->get_where("products",array("pid"=>$value->id_fila))->row();
                    if(isset($prod)){
                        $row[]=$value->tabla.", "."codigo"."=".$prod->product_code;        
                    }else{
                        $row[]=$value->tabla.", ".$value->nombre_columna."=".$value->id_fila;    
                    }
                }else{
                    $row[]=$value->tabla.", ".$value->nombre_columna."=".$value->id_fila;    
                }
                
            }
            $user=$this->db->get_where("aauth_users",array("id"=>$value->id_usuario))->row();
            $row[]=$user->username;
            $row[]="<div style='text-align:center'><a class='btn-small btn-info ver-mas'  data-descripcion='".$value->descripcion."'><i class='icon-book'></i></a></div>";
            $data[]=$row;

    }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->historial->count_all(),
            "recordsFiltered" => $this->historial->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

}
    public function statecnicos()

    {

        $data['tickets'] = $this->reports->tickets();
		//$data['stat'] = $this->reports->statistics();
        $head['title'] = "estadisticaTecnico";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/estatecnicos', $data);
        $this->load->view('fixed/footer');

    }
 	public function metas()

    {
		$today = date("Y-m-d");
        $month = date("m");
        $year = date("Y");
		$gsto = $this->input->get('tipo');
		//var_dump($gsto);
		$this->load->model('tools_model');
        $gastototal = $this->reports->gastos($month,$year);
		$data['gasvesagro']=$gastototal['vesagro'];
		$data['servicios']=$gastototal['servicios'];
		$data['compras']=$gastototal['compras'];
		$data['purchase']=$gastototal['purchase'];
		$data['nomina']=$gastototal['nomina'];
		$data['socios']=$gastototal['socios'];
		$data['oficial']=$gastototal['oficial'];
		$data['creditos']=$gastototal['creditos'];
		$data['creditos']=$gastototal['creditos'];
		$data['goals'] = $this->tools_model->goals(1);
        $head['title'] = "Metas Mensuales";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/metas', $data);
        $this->load->view('fixed/footer');

    }

    //accounts section

    public function accountstatement()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/statement', $data);
        $this->load->view('fixed/footer');

    }
	//filtro reporte tecnico

    public function filreptec()

    {
        $this->load->model('ticket_model');
		$this->load->model('customers_model');
		//$data['accounts'] = $this->transactions_model->acc_list();
		$data['sede'] = $this->customers_model->group_list();
        $data['tecnicos'] = $this->ticket_model->tecnico_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/filreptec', $data);
        $this->load->view('fixed/footer');

    }
	public function cierre()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('invoices/cierre', $data);
        $this->load->view('fixed/footer');

    }

    public function customerstatement()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/customer_statement', $data);
        $this->load->view('fixed/footer');

    }

    public function supplierstatement()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/supplier_statement', $data);
        $this->load->view('fixed/footer');

    }

    public function viewstatement()

    {
        $this->load->model('accounts_model', 'accounts');
        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $ttype = $this->input->post('ttype');
        $account = $this->accounts->details($pay_acc);
        $data['filter'] = array($pay_acc, $trans_type, $sdate, $edate, $ttype, $account['holder']);
		$data['income'] = $this->reports->incomestatement();
        $head['title'] = "Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;


        //datos para fechas de cierre 
            $iduser = $this->aauth->get_user()->id;
            $fecha = date("Y-m-d");
            $hora = date("H:i");
            $datec = array(
                'fcierre' => $fecha,
                'hcierre' => $hora,
                //'roleid' => '0'
            );
            $this->db->where('id', $iduser);
            $this->db->update('aauth_users', $datec);
            //$this->load->view('dashboard');
        //fin datos para fechas cierre

        $data['datos_informe']=array("pay_acc"=>$pay_acc,"trans_type"=>$trans_type,"sdate"=>$sdate,"edate"=>$edate);
        //codigo listar
            

            $datex=new DateTime($sdate);
            $data['is_multiple']="no";
            if(!empty($this->input->post('is_multiple'))){
                   $datex=new DateTime($edate);
                   $data['is_multiple']="si";
            }
            $edate=$datex->format('Y-m-d')." 23:59:00";
            
            $caja1=$this->db->get_where('accounts',array('id' =>$pay_acc))->row();
            $_SESSION['pay_acc__']=$pay_acc;
            //egresos
            $list = $this->reports->get_statements($pay_acc, $trans_type, $sdate, $edate);
            $ordenes_compra=$this->reports->get_statements($pay_acc, "Expense", $sdate, $edate);//listo gastos en esta cuenta
            $ordenes_compra_c1=$this->reports->get_statements(6, "Expense", $sdate, $edate);
            $ordenes_compra_c2=$this->reports->get_statements(7, "Expense", $sdate, $edate);
            $ordenes_compra_c3=$this->reports->get_statements(8, "Expense", $sdate, $edate);

            //falta agregar las transferencias echas 
            
            foreach ($ordenes_compra_c1 as $key => $value) {
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                if($purchase->refer!=null){
                    $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                    if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                        $ordenes_compra[]=$value;
                    }
                }


            }
            foreach ($ordenes_compra_c2 as $key => $value) {
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                if($purchase->refer!=null){

                    $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                    if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                        $ordenes_compra[]=$value;
                    }
                }


            }
            foreach ($ordenes_compra_c3 as $key => $value) {
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                if($purchase->refer!=null){

                    $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                    if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                        $ordenes_compra[]=$value;
                    }
                }


            }
            $tr1=$this->reports->get_statements($pay_acc, "Transfer", $sdate, $edate);

            $data['ordenes_compra']=$ordenes_compra;
            $data['tr1']=$tr1;

            //end egresos
            $lista2=array();
            foreach ($list as $key => $value) {
                if($value['estado']!="Anulada"){
                    $lista2[]=$value;    
                }
                
            }
            $anulaciones=array();
            foreach ($list as $key => $value) {
                if($value["estado"]=="Anulada"){
                    $anulaciones[]=$value;
                }
            }

            $cuenta1 = $this->reports->get_statements(6, $trans_type, $sdate, $edate);
            $cuenta2 = $this->reports->get_statements(7, $trans_type, $sdate, $edate);
            $cuenta3 = $this->reports->get_statements(8, $trans_type, $sdate, $edate);
            $cuenta4 = $this->reports->get_statements(11, $trans_type, $sdate, $edate);
            $data['cuenta1']=$cuenta1;
            $data['cuenta2']=$cuenta2;
            $data['cuenta3']=$cuenta3;
            $data['cuenta4']=$cuenta4;//caja virtual
            
            foreach ($cuenta1 as $key => $value) {
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }
                
                if($value['estado']!="Anulada"){                
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $lista2[]=$value;
                        
                    }
                }else{
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $anulaciones[]=$value;                        
                    }
                }
            }
         
         foreach ($cuenta2 as $key => $value) {         
            $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
            if($invoice->refer!=null){
                $invoice->refer=str_replace(" ","",$invoice->refer);                                    
            }
            if($value['estado']!="Anulada"){                
                if(strtolower($invoice->refer)==strtolower($caja1->holder)){
                    $lista2[]=$value;
                }
            }else{
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $anulaciones[]=$value;
                    }
            }
         }
         
         foreach ($cuenta3 as $key => $value) {         
            $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
            if($invoice->refer!=null){
                $invoice->refer=str_replace(" ","",$invoice->refer);                                    
            }
            if($value['estado']!="Anulada"){
                if(strtolower($invoice->refer)==strtolower($caja1->holder)){
                    $lista2[]=$value;
                }
            }else{
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $anulaciones[]=$value; 
                    }
            }
         }
    if($caja1->holder=="Caja Virtual"){
         foreach ($cuenta4 as $key => $value) {         
            if($value['estado']=="Anulada"){
               $anulaciones[]=$value; 
            }
         }
     }
         $data['lista']=$lista2;
         $data['lista_anulaciones']=$anulaciones;
            
            //obteniendo datos mes actual
            $dia_inicial_mes_actual = date($datex->format("Y-m")."-01 00:00:00");
            $dia_final_de_mes_actual=date($datex->format("Y-m")."-t 23:00:00", strtotime($dia_inicial_mes_actual));
            
            //end obteniendo datos mes actual
            
            //obteniendo datos mes anterior
            $xdate=strtotime($datex->format("Y-m-d")." 00:00:00");
            $dia_inicial_mes_anterior=date("Y-m", strtotime("-1 month", $xdate))."-01 00:00:00";
            $dia_final_de_mes_anterior=date("Y-m-t 23:00:00", strtotime($dia_inicial_mes_anterior));
        //fin codigo listar
            $data['texto_mes_actual']=$this->reports->devolver_nombre_mes($datex->format('m'))." ".$datex->format('Y');
            $d1=new DateTime($dia_inicial_mes_anterior);
            $data['texto_mes_anterior']=$this->reports->devolver_nombre_mes($d1->format("m"))." ".$d1->format("Y");

            //meses anteriores list
            
            //resumen por meses code
            //mes anterior
            $list3 =array();
            $fecha_inicial_m_anterior=strtotime($dia_inicial_mes_anterior);
            $fecha_final_m_anterior=strtotime($dia_final_de_mes_anterior);
           
            //mes actual
            $fecha_inicial_m_actual=strtotime($dia_inicial_mes_actual);
            $fecha_final_m_actual=strtotime($dia_final_de_mes_actual);
            $lista4=array();
           
            //resumen por meses code end
            //new code
      
            $lista_meses_anteriores=array();
            foreach ($lista2 as $key => $value) {
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                $fecha_invoice=strtotime($invoice->invoicedate);
                if ($fecha_invoice>=$fecha_inicial_m_anterior && $fecha_invoice<=$fecha_final_m_anterior) {
                    $list3[]=$value;
                }else if($fecha_invoice>=$fecha_inicial_m_actual && $fecha_invoice<=$fecha_final_m_actual){
                    $lista4[]=$value;
                }else{
                    $lista_meses_anteriores[]=$value;
                }
            }
            $data['lista_mes_anterior']=$list3;
            $data['lista_mes_actual']=$lista4;
            $data['lista_meses_anteriores']=$lista_meses_anteriores;
        //end new code
        $this->load->library("Festivos");
                        $festivos = new Festivos();//ejemplo para saber si un dia es festivo
                        
                        $fechax1 = $datex->format("Y-m-d");
                        $dias_a_sumar=1;
                        $fechax1=date("Y-m-d",strtotime($datex->format("Y-m-d")."- ".$dias_a_sumar." days"));
                        $ciclo=true;
                        while($ciclo){
                            if($festivos->esFestivoFecha($fechax1)){
                                $dias_a_sumar++;
                                //es festivo
                                $ciclo=true;
                            }else{
                                $ciclo=false;
                            } 
                            if(date("w",strtotime($fechax1))=="0"){
                                $dias_a_sumar++;
                                $ciclo=true;
                            }
                            
                            if($ciclo){
                                $fechax1=date("Y-m-d",strtotime($datex->format("Y-m-d")."- ".$dias_a_sumar." days"));    
                            }
                            
                            
                        }
        $saldo_anterior=$this->db->query("select * from transactions where account='".$caja1->holder."' and date='".$datex->format("Y-m-d")."' and note='Saldo ".$fechax1."' and estado is null")->result();
        $data['saldo_anterior']=0;
        if(count($saldo_anterior)>0){
            $data['saldo_anterior']=$saldo_anterior[0]->credit;
        }
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/statement_list', $data);
        $this->load->view('fixed/footer');
    }

    public function sacar_pdf(){
         //$this->load->model('accounts_model', 'accounts');
        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $is_multiple = $this->input->post('is_multiple');
        //$ttype = $this->input->post('ttype');
        //$account = $this->accounts->details($pay_acc);
        //$data['filter'] = array($pay_acc, $trans_type, $sdate, $edate, $ttype, $account['holder']);
        //$data['income'] = $this->reports->incomestatement();
        //$head['title'] = "Account Statement";
        //$head['usernm'] = $this->aauth->get_user()->username;
		$data['datos_informe']=array("trans_type"=>$trans_type);
        //codigo listar
          $data['fecha']=$sdate;  
             //hice esto para hacer que el cierre sea de un dia si se desea reestablecer a entre fechas solo comentar la linea 57;
              $datex=new DateTime($sdate);
              $data['text_add']="";
            if($is_multiple=="si"){
                    $datex=new DateTime($edate);
                    $data['text_add']=" - ".$datex->format("Y-m-d");
            }

            $edate=$datex->format('Y-m-d')." 23:59:00";
            $caja1=$this->db->get_where('accounts',array('id' =>$pay_acc))->row();
            
            $list = $this->reports->get_statements($pay_acc, $trans_type, $sdate, $edate);
            //egresos
                 $ordenes_compra=$this->reports->get_statements($pay_acc, "Expense", $sdate, $edate);//listo gastos en esta cuenta
            $ordenes_compra_c1=$this->reports->get_statements(6, "Expense", $sdate, $edate);
            $ordenes_compra_c2=$this->reports->get_statements(7, "Expense", $sdate, $edate);
            $ordenes_compra_c3=$this->reports->get_statements(8, "Expense", $sdate, $edate);

            //falta agregar las transferencias echas 
            
            foreach ($ordenes_compra_c1 as $key => $value) {
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                if($purchase->refer!=null){
                    $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                    if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                        $ordenes_compra[]=$value;
                    }
                }


            }
            foreach ($ordenes_compra_c2 as $key => $value) {
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                if($purchase->refer!=null){

                    $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                    if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                        $ordenes_compra[]=$value;
                    }
                }


            }
            foreach ($ordenes_compra_c3 as $key => $value) {
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                if($purchase->refer!=null){

                    $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                    if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                        $ordenes_compra[]=$value;
                    }
                }


            }
            $tr1=$this->reports->get_statements($pay_acc, "Transfer", $sdate, $edate);
            $data['ordenes_compra']=$ordenes_compra;
            $data['tr1']=$tr1;
            //end egresos
            $lista2=array();
            foreach ($list as $key => $value) {
                if($value['estado']!="Anulada"){
                    $lista2[]=$value;    
                }
                
            }
            $anulaciones=array();
            foreach ($list as $key => $value) {
                if($value["estado"]=="Anulada"){
                    $anulaciones[]=$value;
                }
            }

            $cuenta1 = $this->reports->get_statements(6, $trans_type, $sdate, $edate);
            $cuenta2 = $this->reports->get_statements(7, $trans_type, $sdate, $edate);
            $cuenta3 = $this->reports->get_statements(8, $trans_type, $sdate, $edate);
            $cuenta4 = $this->reports->get_statements(11, $trans_type, $sdate, $edate);
            $data['cuenta1']=$cuenta1;
            $data['cuenta2']=$cuenta2;
            $data['cuenta3']=$cuenta3;
            $data['cuenta4']=$cuenta4;
            

            foreach ($cuenta1 as $key => $value) {
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }                                
                if($value['estado']!="Anulada"){                
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $lista2[]=$value;
                        
                    }
                }else{
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $anulaciones[]=$value;                        
                    }
                }
            }
         
         foreach ($cuenta2 as $key => $value) {         
            $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
             if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }
            if($value['estado']!="Anulada"){                
                if(strtolower($invoice->refer)==strtolower($caja1->holder)){
                    $lista2[]=$value;
                }
            }else{
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $anulaciones[]=$value;
                    }
            }
         }
         
         foreach ($cuenta3 as $key => $value) {         
            $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
             if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }
            if($value['estado']!="Anulada"){
                if(strtolower($invoice->refer)==strtolower($caja1->holder)){
                    $lista2[]=$value;
                }
            }else{
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $anulaciones[]=$value; 
                    }
            }
         }
             if($caja1->holder=="Caja Virtual"){
                 foreach ($cuenta4 as $key => $value) {         
                    if($value['estado']=="Anulada"){
                       $anulaciones[]=$value; 
                    }
                 }
             }
         $data['lista']=$lista2;
         $data['lista_anulaciones']=$anulaciones;
            
            //obteniendo datos mes actual
            $dia_inicial_mes_actual = date($datex->format("Y-m")."-01 00:00:00");
            $dia_final_de_mes_actual=date($datex->format("Y-m")."-t 23:00:00", strtotime($dia_inicial_mes_actual));
            
            //end obteniendo datos mes actual
            
            //obteniendo datos mes anterior
            $xdate=strtotime($datex->format("Y-m-d")." 00:00:00");
            $dia_inicial_mes_anterior=date("Y-m", strtotime("-1 month", $xdate))."-01 00:00:00";
            $dia_final_de_mes_anterior=date("Y-m-t 23:00:00", strtotime($dia_inicial_mes_anterior));
        //fin codigo listar
            $data['texto_mes_actual']=$this->reports->devolver_nombre_mes($datex->format('m'))." ".$datex->format('Y');
            $d1=new DateTime($dia_inicial_mes_anterior);
            $data['texto_mes_anterior']=$this->reports->devolver_nombre_mes($d1->format("m"))." ".$d1->format("Y");

            
            //resumen por meses code
            //mes anterior
            $list3 =array();
            $fecha_inicial_m_anterior=strtotime($dia_inicial_mes_anterior);
            $fecha_final_m_anterior=strtotime($dia_final_de_mes_anterior);
           
            //mes actual
            $fecha_inicial_m_actual=strtotime($dia_inicial_mes_actual);
            $fecha_final_m_actual=strtotime($dia_final_de_mes_actual);
            $lista4=array();
           
            //resumen por meses code end
            //new code
      
            $lista_meses_anteriores=array();
            foreach ($lista2 as $key => $value) {
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                $fecha_invoice=strtotime($invoice->invoicedate);
                if ($fecha_invoice>=$fecha_inicial_m_anterior && $fecha_invoice<=$fecha_final_m_anterior) {
                    $list3[]=$value;
                }else if($fecha_invoice>=$fecha_inicial_m_actual && $fecha_invoice<=$fecha_final_m_actual){
                    $lista4[]=$value;
                }else{
                    $lista_meses_anteriores[]=$value;
                }
            }
            $data['lista_mes_anterior']=$list3;
            $data['lista_mes_actual']=$lista4;
            $data['lista_meses_anteriores']=$lista_meses_anteriores;
        //end new code

           $data['lista_datos']=$this->statements_para_pdf();
           $data['caja']=$this->input->post('caja');
           //cambiando rol usario
            $iduser = $this->aauth->get_user()->id;        
            $datec = array(
                //'fcierre' => $fecha,
                //'hcierre' => $hora,
                'conue' => null,
				'cocie' => null,
            );
			$this->db->where('id', $iduser);
			$this->db->update('aauth_users', $datec);
			//QUITAR PERMISOS
            $this->db->where('id_usuario', $iduser);
			$this->db->where('id_modulo', 3);
				$this->db->set('is_checked', null);
				$this->db->update('permisos_usuario');
			$this->db->where('id_usuario', $iduser);
			$this->db->where('id_modulo', 5);
				$this->db->set('is_checked', null);
				$this->db->update('permisos_usuario');
			
            		
            $valor_efectivo_caja=intval($_SESSION['valor_efectivo_caja']);
            $this->load->library("Festivos");
            if($valor_efectivo_caja>0){
                //$validar_no_repit=$this->db->get_where("transactions",array("note"=>"Saldo ".$datex->format("Y-m-d"),"estado"=>null))->row();
                $saldo_anterior=$this->db->query("select * from transactions where account='".$caja1->holder."' and date='".$datex->format("Y-m-d")."' and note='Saldo ".$datex->format("Y-m-d")."' and estado is null")->result();
                
                    if(count($saldo_anterior)==0){
                    
                        $festivos = new Festivos();//ejemplo para saber si un dia es festivo
                        
                        $fechax1 = $datex->format("Y-m-d");
                        $dias_a_sumar=1;
                        $fechax1=date("Y-m-d",strtotime($datex->format("Y-m-d")."+ ".$dias_a_sumar." days"));
                        $ciclo=true;
                        while($ciclo){
                            if($festivos->esFestivoFecha($fechax1)){
                                $dias_a_sumar++;
                                //es festivo
                                $ciclo=true;
                            }else{
                                $ciclo=false;
                            } 
                            if(date("w",strtotime($fechax1))=="0"){
                                $dias_a_sumar++;
                                $ciclo=true;
                            }
                            
                            if($ciclo){
                                $fechax1=date("Y-m-d",strtotime($datex->format("Y-m-d")."+ ".$dias_a_sumar." days"));    
                            }
                            
                            
                        }
                        $data_tr_efectivo=array();
                        $data_tr_efectivo['acid']=$_SESSION['valor_efectivo_caja_acid'];
                        $data_tr_efectivo['account']=$_SESSION['valor_efectivo_account'];
                        $data_tr_efectivo['type']="Expense";
                        $data_tr_efectivo['cat']="sales";
                        $data_tr_efectivo['debit']=$valor_efectivo_caja;
                        $data_tr_efectivo['credit']="0.00";
                        $cajero = $this->db->get_where('employee_profile', array('id' => $iduser))->row();
                        $data_tr_efectivo['payer']=$cajero->name;
                        $data_tr_efectivo['payerid']=0;
                        $data_tr_efectivo['method']="Cash";
                        $data_tr_efectivo['date']=$datex->format("Y-m-d");
                        $data_tr_efectivo['tid']="-1";
                        $data_tr_efectivo['eid']=$iduser;
                        $data_tr_efectivo['note']="Saldo ".$data_tr_efectivo['date'];
                        //$this->db->insert("transactions",$data_tr_efectivo);
                        $data_tr_efectivo['debit']="0.00";
                        $data_tr_efectivo['credit']=$valor_efectivo_caja;
                        $fecha_actual = date("Y-m-d");                
                        $data_tr_efectivo['date']= $fechax1; 
                        $data_tr_efectivo['type']="Income";
                        //$this->db->insert("transactions",$data_tr_efectivo);
                    }
            }
            // fin cambiando rol usario
           //$this->load->view('reports/sacar_pdf', $data);
            //sacar pdf

                        $festivos = new Festivos();//ejemplo para saber si un dia es festivo
                        
                        $fechax1 = $datex->format("Y-m-d");
                        $dias_a_sumar=1;
                        $fechax1=date("Y-m-d",strtotime($datex->format("Y-m-d")."- ".$dias_a_sumar." days"));
                        $ciclo=true;
                        while($ciclo){
                            if($festivos->esFestivoFecha($fechax1)){
                                $dias_a_sumar++;
                                //es festivo
                                $ciclo=true;
                            }else{
                                $ciclo=false;
                            } 
                            if(date("w",strtotime($fechax1))=="0"){
                                $dias_a_sumar++;
                                $ciclo=true;
                            }
                            
                            if($ciclo){
                                $fechax1=date("Y-m-d",strtotime($datex->format("Y-m-d")."- ".$dias_a_sumar." days"));    
                            }
                            
                            
                        }
        $saldo_anterior=$this->db->query("select * from transactions where account='".$caja1->holder."' and date='".$datex->format("Y-m-d")."' and note='Saldo ".$fechax1."' and estado is null")->result();
        $data['saldo_anterior']=0;
        if(count($saldo_anterior)>0){
            $data['saldo_anterior']=$saldo_anterior[0]->credit;
        }


           ini_set('memory_limit', '64M');
                    $data_h=array();
                    $data_h['modulo']="Ventas";
                    $data_h['accion']="Cierre > Ver > Cierre de Caja {view}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']="Se realizo el cierre de caja de la sede ".$caja1->holder;
                    $data_h['id_fila']=0;
                    $data_h['tabla']="";
                    $data_h['nombre_columna']="";
                    $this->db->insert("historial_crm",$data_h);
           $foot= $this->load->view('fixed/footer', $head,true);
            $contenido=$this->load->view('reports/sacar_pdf_editado', $data,true);
            $this->load->library('pdf_cierre_de_caja');
            $pdf = $this->pdf_cierre_de_caja->load();
           
           //$pdf->SetHTMLHeader($head);
           $pdf->SetHTMLFooter("<hr style='margin-bottom: 1px;'><div style='text-align:right;'><i><b><small>Pagina N° {PAGENO} de {nb}</small></b></i></div>");
    
            $pdf->WriteHTML($contenido);
            $fecha =new DateTime($sdate);

            $pdf->SetTitle('Cierre de Caja '.$this->reports->obtener_dia($fecha->format("N")).', '.$fecha->format("d-m-Y"));
            $pdf->Output('Cierre de Caja '.$this->reports->obtener_dia($fecha->format("N")).', '.$fecha->format("d-m-Y").'.pdf',"I");

    }

    public function customerviewstatement()

    {
        $this->load->model('customers_model', 'customer');
        $cid = $this->input->post('customer');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $ttype = $this->input->post('ttype');
        $customer = $this->customer->details($cid);
        $data['filter'] = array($cid, $trans_type, $sdate, $edate, $ttype, $customer['name']);

        //  print_r( $data['statement']);
        $head['title'] = "Customer Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/customerstatement_list', $data);
        $this->load->view('fixed/footer');


    }
	public function estadisticaportecnico()

    {
        set_time_limit(10000);
        $this->load->model('customers_model', 'customer');
        $tec = $this->input->post('tecnico');
        $sede = $this->input->post('sede');
        $sdate = datefordatabase($this->input->post('sdate'));
        
        $data['filter'] = array($tec, $sede, $sdate);
		$data['tipos'] = $this->reports->filtrotipos($tec, $sede, $sdate);
        $data['lista_datos_cuentas_tipos_por_tecnico']=$data['tipos']['lista_datos_cuentas_tipos_por_tecnico'];
        $data['lista_de_tecnicos']=$data['tipos']['lista_tecnicos'];
        $data['lista_por_tecnicos']=$data['tipos']['lista_tecnicos_organizada'];
        $data['tipos']=$data['tipos']['lista_datos'];
        $data['stat'] = $this->reports->get_estadisticas_tecnicos($tec, $sede, $sdate);
        //  print_r( $data['statement']);
        $head['title'] = "reporte tecnico";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/estatecnicos', $data);
        $this->load->view('fixed/footer');


    }

    public function supplierviewstatement()

    {
        $this->load->model('supplier_model', 'supplier');
        $cid = $this->input->post('supplier');
        $trans_type = $this->input->post('trans_type');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));
        $ttype = $this->input->post('ttype');
        $customer = $this->supplier->details($cid);
        $data['filter'] = array($cid, $trans_type, $sdate, $edate, $ttype, $customer['name']);

        //  print_r( $data['statement']);
        $head['title'] = "Supplier Account Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/supplierstatement_list', $data);
        $this->load->view('fixed/footer');


    }


    //

    public function statements()
    {

        $pay_acc = $this->input->post('ac');
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));
        $is_multiple = $this->input->post('ism');
          $datex=new DateTime($sdate);
          if($is_multiple=="si"){
                $datex=new DateTime($edate);
          }
            $edate=$datex->format('Y-m-d')." 23:59:00";
            
        $list = $this->reports->get_statements($pay_acc, $trans_type, $sdate, $edate);
        $balance = 0;
            $cuenta1 = $this->reports->get_statements(6, $trans_type, $sdate, $edate);
            //tengo un inconveniente pues debo agregar las facturas, luego los expense(purchase) y luego las transferencias
            $cuenta2 = $this->reports->get_statements(7, $trans_type, $sdate, $edate);
            $cuenta3 = $this->reports->get_statements(8, $trans_type, $sdate, $edate);
            $caja1=$this->db->get_where('accounts',array('id' =>$pay_acc))->row();
            foreach ($cuenta1 as $key => $value) {
                if($value['type']=="Income"){
                    $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                    if($invoice->refer!=null){
                        $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                    }
                    if($value['estado']!="Anulada"){                
                        if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                            $list[]=$value;                        
                        }
                    }
                }else if($value['type']=="Expense"){
                    $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                        if($purchase->refer!=null){

                            $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                            if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                                $list[]=$value;
                            }
                        }
                }

            }
         
         foreach ($cuenta2 as $key => $value) {         
            if($value['type']=="Income"){
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }
                if($value['estado']!="Anulada"){                
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $list[]=$value;                        
                    }
                }
            }else if($value['type']=="Expense"){
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                    if($purchase->refer!=null){

                        $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                        if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                            $list[]=$value;
                        }
                    }
            }
         }
         
         foreach ($cuenta3 as $key => $value) {         
            if($value['type']=="Income"){
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }
                if($value['estado']!="Anulada"){                
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $list[]=$value;                        
                    }
                }
            }else if($value['type']=="Expense"){
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                    if($purchase->refer!=null){

                        $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                        if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                            $list[]=$value;
                        }
                    }
            }
         }
         //transferencias para cuando solo son debito caso especial
         if($trans_type=="Expense"){
            $cuenta1 = $this->reports->get_statements($pay_acc, "Transfer", $sdate, $edate);

            foreach ($cuenta1 as $key => $value) {            
                    if(strpos(strtolower($value['note']), strtolower($caja1->holder))!==false){
                        $list[]=$value;
                    }
             }
           
         
         }
   
         $balance2=0;
         $valor_efectivo_caja_acid="0";
         $account_ef="";
        foreach ($list as $row) {
            
            if($row['estado']!="Anulada"){
                $balance += $row['credit'] - $row['debit'];
                if($row['method']=="Cash" || $row['method']=="cash"){
                    $balance2 += $row['credit'] - $row['debit'];
                    $valor_efectivo_caja_acid=$row['acid'];
                    $account_ef=$row['account'];
                }
                if($row['type']=="Transfer"){
                    $balance2 += $row['credit'] - $row['debit'];
                }
                $img="";
                $file_is=null;
                if($row['type']=="Expense"){
                    $file_is=$this->db->get_where("meta_data",array("type"=>"4","rid"=>$row['tid'],"col2"=>"Pago"))->row();
                }else{
                    $file_is=$this->db->get_where("meta_data",array("type"=>"77","rid"=>$row['id']))->row();    
                }
                
                if(!empty($file_is)){
                    $img="<a title='Descargar Comprobante' class='btn-sm btn-info' href='".base_url()."userfiles/attach/".$file_is->col1."' ><i class='icon-download'></i></a>&nbsp;&nbsp;";
                }else{
                    $img="<a title='Sin Comprobante' style='background-color:gray;cursor:default;'  class='btn-sm btn-info desabilitado' href='#'><i class='icon-download'></i></a>&nbsp;&nbsp;";
                }
            echo '<tr><td>'.$img.$row['id'].' - '. $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountFormat($row['debit']) . '</td><td>' . amountFormat($row['credit']) . '</td><td>' . amountFormat($balance) . ' </td></tr>';
            }
        }
        echo '<script type="text/javascript">valida_cierre('.$balance2.');$("#efectivo-caja").text("Efectivo Caja: '.amountFormat($balance2).'")</script>';
        $_SESSION['valor_efectivo_caja']=$balance2; 
        $_SESSION['valor_efectivo_caja_acid']=$valor_efectivo_caja_acid;
        $_SESSION['valor_efectivo_account']=$account_ef;
    }
    public function statements_para_pdf()
    {

        $pay_acc = $this->input->post('pay_acc');
        $trans_type = $this->input->post('trans_type');
        $sdate = $this->input->post('sdate');
        $edate = $this->input->post('edate');
        $is_multiple = $this->input->post('is_multiple');
          $datex=new DateTime($sdate);
          if($is_multiple=="si"){
            $datex=new DateTime($edate);
          }
            $edate=$datex->format('Y-m-d')." 23:59:00";
            
        $list = $this->reports->get_statements($pay_acc, $trans_type, $sdate, $edate);
        $cuenta1 = $this->reports->get_statements(6, $trans_type, $sdate, $edate);
            $cuenta2 = $this->reports->get_statements(7, $trans_type, $sdate, $edate);
            $cuenta3 = $this->reports->get_statements(8, $trans_type, $sdate, $edate);
            $caja1=$this->db->get_where('accounts',array('id' =>$pay_acc))->row();
            foreach ($cuenta1 as $key => $value) {
               if($value['type']=="Income"){
                    $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                    if($invoice->refer!=null){
                        $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                    }
                    if($value['estado']!="Anulada"){                
                        if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                            $list[]=$value;                        
                        }
                    }
                }else if($value['type']=="Expense"){
                    $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                        if($purchase->refer!=null){

                            $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                            if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                                $list[]=$value;
                            }
                        }
                }
            }
         
         foreach ($cuenta2 as $key => $value) {         
             if($value['type']=="Income"){
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }
                if($value['estado']!="Anulada"){                
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $list[]=$value;                        
                    }
                }
            }else if($value['type']=="Expense"){
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                    if($purchase->refer!=null){

                        $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                        if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                            $list[]=$value;
                        }
                    }
            }
         }
         
         foreach ($cuenta3 as $key => $value) {         
             if($value['type']=="Income"){
                $invoice = $this->db->get_where("invoices",array("tid"=>$value['tid']))->row(); 
                if($invoice->refer!=null){
                    $invoice->refer=str_replace(" ","",$invoice->refer);                                    
                }
                if($value['estado']!="Anulada"){                
                    if(strtolower($invoice->refer)==strtolower($caja1->holder)){                    
                        $list[]=$value;                        
                    }
                }
            }else if($value['type']=="Expense"){
                $purchase=$this->reports->db->get_where('purchase',array('tid' =>$value['tid']))->row();
                    if($purchase->refer!=null){

                        $purchase->refer=str_replace(" ","",$purchase->refer);                                    
                        if(strtolower($purchase->refer)==strtolower($caja1->holder)){
                            $list[]=$value;
                        }
                    }
            }
         }

          //transferencias para cuando solo son debito caso especial
         if($trans_type=="Expense"){
            $cuenta1 = $this->reports->get_statements($pay_acc, "Transfer", $sdate, $edate);
            
            foreach ($cuenta1 as $key => $value) {            
                    if(strpos(strtolower($value['note']), strtolower($caja1->holder))!==false){
                        $list[]=$value;
                    }
             }
             
         
         }
        $balance = 0;
        $var_lista="";
        $conteo=0;
        foreach ($list as $row) {
            
            if($row['estado']!="Anulada"){
                $balance += $row['credit'] - $row['debit'];
                $conteo++;
                if($conteo%2==0){
                    $texto_style="style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;text-align: center;'";    
                }else{
                    $texto_style="style='padding: 0.75rem 2rem;border-bottom: 1px solid #e3ebf3;color: #333;font-size: 12px;background-color: rgba(0, 0, 0, 0.05);text-align: center;'";                
                }
                
                $var_lista.= '<tr><td '.$texto_style.'>' . $row['date'] .'</td><td '.$texto_style.'>' . $row['note'] . '</td><td '.$texto_style.'>' . amountFormat($row['debit']) . '</td><td '.$texto_style.'>' . amountFormat($row['credit']) . '</td><td '.$texto_style.'>' . amountFormat($balance) . '</td></tr>';
            }
        }
        return $var_lista;

    }
    public function pruebas(){

ini_set('memory_limit', '-1');
$this->load->model("customers_model","customers");
$lista_customers_activos=$this->db->query("select * from customers where (gid='2' or gid='3' or gid='4') and  (usu_estado='Activo' or usu_estado='Compromiso')")->result();
        $lista_customers_cortados=$this->db->query("select * from customers where gid='2' or gid='3' or gid='4'")->result();
        $lista_customers_cartera=$this->db->query("select * from customers where (gid='2' or gid='3' or gid='4') and usu_estado='Cartera'")->result();
        //$lista_customers_suspendidos=$this->db->query("select * from customers where gid='2' and usu_estado='Suspendido'")->result();
        $lista_customers_retirado=$this->db->query("select * from customers where (gid='2' or gid='3' or gid='4') and usu_estado='Retirado'")->result();
        $this->load->model("customers_model","customers");
        $obtenido_activos=$this->customers->conteo($lista_customers_activos);
        $obtenido_cortados=$this->customers->conteo($lista_customers_cortados);
        $obtenido_cartera=$this->customers->conteo($lista_customers_cartera);
        $obtenido_retirado=$this->customers->conteo($lista_customers_retirado);


    }
    public function pr1(){
        $lista_customers_activos=$this->db->query("select * from customers where gid='2' and  (usu_estado='Activo' or usu_estado='Compromiso')")->result();
        $this->load->model("customers_model","customers");
        $internet=0;
        $tv=0;
        $activo_con_algun_servicio=0;
        $internet_y_tv=0;
        foreach ($lista_customers_activos as $key => $value) {
            $servicios=$this->customers->servicios_detail($value->id);
            $servicios=$this->customers->servicios_detail($value->id);
            $validar=false;
            if($servicios["television"]=="Television"){
                $tv++;
                $validar=true;
            } 
            if($servicios["combo"]!="no" ){
                $internet++;      
                if($validar){
                    $internet_y_tv++;
                }
                $validar=true;
            } 
            if($validar){
                $activo_con_algun_servicio++;
            }
        }
        var_dump($tv);
    }
	public function statistics_services1()

    {
        $lista_estadisticas=$this->db->order_by("fecha","asc")->get_where("estadisticas_servicios")->result_array();
        $datos=array("lista_estadisticas"=>$lista_estadisticas);
		$this->load->model('dashboard_model');
		$datos['list_users'] = $this->dashboard_model->lista_usuarios();
        $head['title'] = "Por estados";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view("fixed/header");
        $this->load->view("reports/statistics_services",$datos);
        $this->load->view("fixed/footer");

    }
public function statistics_services(){
    $extraccion_dia=$this->db->get_where("estadisticas_servicios",array("fecha"=>date("Y-m-d")))->row();
    $data=array();
    ini_set('memory_limit', '-1');
    if(empty($extraccion_dia) || (isset($_GET['tipo']) && $_GET['tipo']=="process")){
        $lista_customers_activos=$this->db->query("select * from customers where gid='2' and  (usu_estado='Activo' or usu_estado='Compromiso')")->result();
        $lista_customers_cortados=$this->db->query("select * from customers where gid='2' and usu_estado='Cortado'")->result();
        $lista_customers_cartera=$this->db->query("select * from customers where gid='2' and usu_estado='Cartera'")->result();
        $lista_customers_suspendidos=$this->db->query("select * from customers where gid='2' and usu_estado='Suspendido'")->result();
        $lista_customers_retirado=$this->db->query("select * from customers where gid='2' and usu_estado='Retirado'")->result();
        $this->load->model("customers_model","customers");
        $obtenido_activos=$this->customers->conteo($lista_customers_activos);
        $obtenido_cortados=$this->customers->conteo($lista_customers_cortados);
        $obtenido_cartera=$this->customers->conteo($lista_customers_cartera);
        $obtenido_suspendidos=$this->customers->conteo($lista_customers_suspendidos);
        $obtenido_retirado=$this->customers->conteo($lista_customers_retirado);
		$lista_vill_activos=$this->db->query("select * from customers where gid='3' and  (usu_estado='Activo' or usu_estado='Compromiso')")->result();
        $lista_vill_cortados=$this->db->query("select * from customers where gid='3' and usu_estado='Cortado'")->result();
        $lista_vill_cartera=$this->db->query("select * from customers where gid='3' and usu_estado='Cartera'")->result();
        $lista_vill_suspendidos=$this->db->query("select * from customers where gid='3' and usu_estado='Suspendido'")->result();
        $lista_vill_retirado=$this->db->query("select * from customers where gid='3' and usu_estado='Retirado'")->result();        
        $obtenido_activos_vill=$this->customers->conteo($lista_vill_activos);
        $obtenido_cortados_vill=$this->customers->conteo($lista_vill_cortados);
        $obtenido_cartera_vill=$this->customers->conteo($lista_vill_cartera);
        $obtenido_suspendidos_vill=$this->customers->conteo($lista_vill_suspendidos);
        $obtenido_retirado_vill=$this->customers->conteo($lista_vill_retirado);
		$lista_mon_activos=$this->db->query("select * from customers where gid='4' and  (usu_estado='Activo' or usu_estado='Compromiso')")->result();
        $lista_mon_cortados=$this->db->query("select * from customers where gid='4' and usu_estado='Cortado'")->result();
        $lista_mon_cartera=$this->db->query("select * from customers where gid='4' and usu_estado='Cartera'")->result();
        $lista_mon_suspendidos=$this->db->query("select * from customers where gid='4' and usu_estado='Suspendido'")->result();
        $lista_mon_retirado=$this->db->query("select * from customers where gid='4' and usu_estado='Retirado'")->result();        
        $obtenido_activos_mon=$this->customers->conteo($lista_mon_activos);
        $obtenido_cortados_mon=$this->customers->conteo($lista_mon_cortados);
        $obtenido_cartera_mon=$this->customers->conteo($lista_mon_cartera);
        $obtenido_suspendidos_mon=$this->customers->conteo($lista_mon_suspendidos);
        $obtenido_retirado_mon=$this->customers->conteo($lista_mon_retirado);
		
        $data['n_internet']=$obtenido_activos['net']-$obtenido_activos['activo_con_algun_servicio'];
        $data['n_tv']=$obtenido_activos['tv']-$obtenido_activos['int_tvcor'];
        $data['internet_y_tv']=$obtenido_activos['internet_y_tv']-($obtenido_activos['int_tvcor']+$obtenido_activos['activo_con_algun_servicio']);
        $data['n_activo']=$obtenido_activos['activo_con_algun_servicio'];
        $data['cor_int']=$obtenido_cortados['internetcor'];
        $data['cor_tv']=$obtenido_cortados['tvcor'];
        $data['internet_y_tv_cor']=$obtenido_cortados['internet_y_tv_cor'];
        $data['car_int']=$obtenido_cartera['net'];
        $data['car_tv']=$obtenido_cartera['tv'];
        $data['internet_y_tv_car']=$obtenido_cartera['internet_y_tv'];
        $data['sus_int']=$obtenido_suspendidos['internet_sus'];
        $data['sus_tv']=$obtenido_suspendidos['tv_sus'];
        $data['internet_y_tv_sus']=$obtenido_suspendidos['internet_y_tv'];
        $data['ret_int']=$obtenido_retirado['net'];
        $data['ret_tv']=$obtenido_retirado['tv'];
        $data['internet_y_tv_ret']=$obtenido_retirado['internet_y_tv'];
        $data['debido_activos']=$obtenido_activos['deuda_todos'];
        $data['debido_cortados']=$obtenido_cortados['deuda_todos'];
        $data['debido_cartera']=$obtenido_cartera['deuda_todos'];
        $data['debido_suspendidos']=$obtenido_suspendidos['deuda_todos'];
        $data['debido_retirados']=$obtenido_retirado['deuda_todos'];
		$data['n_internet_vill']=$obtenido_activos_vill['net']-$obtenido_activos_vill['activo_con_algun_servicio'];
        $data['n_tv_vill']=$obtenido_activos_vill['tv']-$obtenido_activos_vill['int_tvcor'];
        $data['internet_y_tv_act_vill']=$obtenido_activos_vill['internet_y_tv']-($obtenido_activos_vill['activo_con_algun_servicio']+$obtenido_activos_vill['int_tvcor']);
        $data['cor_int_vill']=$obtenido_cortados_vill['internetcor'];
        $data['cor_tv_vill']=$obtenido_cortados_vill['tvcor'];
        $data['internet_y_tv_cor_vill']=$obtenido_cortados_vill['internet_y_tv_cor'];
        $data['car_int_vill']=$obtenido_cartera_vill['net'];
        $data['car_tv_vill']=$obtenido_cartera_vill['tv'];
        $data['internet_y_tv_car_vill']=$obtenido_cartera_vill['internet_y_tv'];
        $data['sus_int_vill']=$obtenido_suspendidos_vill['internet_sus'];
        $data['sus_tv_vill']=$obtenido_suspendidos_vill['tv_sus'];
        $data['internet_y_tv_sus_vill']=$obtenido_suspendidos_vill['internet_y_tv'];
        $data['ret_int_vill']=$obtenido_retirado_vill['net'];
        $data['ret_tv_vill']=$obtenido_retirado_vill['tv'];
        $data['internet_y_tv_ret_vill']=$obtenido_retirado_vill['internet_y_tv'];
        $data['debido_act_vill']=$obtenido_activos_vill['deuda_todos'];
        $data['debido_cor_vill']=$obtenido_cortados_vill['deuda_todos'];
        $data['debido_car_vill']=$obtenido_cartera_vill['deuda_todos'];
        $data['debido_sus_vill']=$obtenido_suspendidos_vill['deuda_todos'];
        $data['debido_ret_vill']=$obtenido_retirado_vill['deuda_todos'];
		$data['n_internet_mon']=$obtenido_activos_mon['net']-$obtenido_activos_mon['activo_con_algun_servicio'];
        $data['n_tv_mon']=$obtenido_activos_mon['tv']-$obtenido_activos_mon['int_tvcor'];
        $data['internet_y_tv_act_mon']=$obtenido_activos_mon['internet_y_tv']-($obtenido_activos_mon['activo_con_algun_servicio']+$obtenido_activos_mon['int_tvcor']);
        $data['cor_int_mon']=$obtenido_cortados_mon['internetcor'];
        $data['cor_tv_mon']=$obtenido_cortados_mon['tvcor'];
        $data['internet_y_tv_cor_mon']=$obtenido_cortados_mon['internet_y_tv_cor'];
        $data['car_int_mon']=$obtenido_cartera_mon['net'];
        $data['car_tv_mon']=$obtenido_cartera_mon['tv'];
        $data['internet_y_tv_car_mon']=$obtenido_cartera_mon['internet_y_tv'];
        $data['sus_int_mon']=$obtenido_suspendidos_mon['internet_sus'];
        $data['sus_tv_mon']=$obtenido_suspendidos_mon['tv_sus'];
        $data['internet_y_tv_sus_mon']=$obtenido_suspendidos_mon['internet_y_tv'];
        $data['ret_int_mon']=$obtenido_retirado_mon['net'];
        $data['ret_tv_mon']=$obtenido_retirado_mon['tv'];
        $data['internet_y_tv_ret_mon']=$obtenido_retirado_mon['internet_y_tv'];
        $data['debido_act_mon']=$obtenido_activos_mon['deuda_todos'];
        $data['debido_cor_mon']=$obtenido_cortados_mon['deuda_todos'];
        $data['debido_car_mon']=$obtenido_cartera_mon['deuda_todos'];
        $data['debido_sus_mon']=$obtenido_suspendidos_mon['deuda_todos'];
        $data['debido_ret_mon']=$obtenido_retirado_mon['deuda_todos'];
        $data['fecha']=date("Y-m-d");
        if(empty($extraccion_dia)){
            $this->db->insert("estadisticas_servicios",$data);    
        }else{
            $this->db->update("estadisticas_servicios",$data,array("id_estadisticas_servicios"=>$extraccion_dia->id_estadisticas_servicios));
        }
        
    }
    if(empty($_GET['tipo'])){
        $lista_estadisticas=$this->db->order_by("fecha","asc")->get_where("estadisticas_servicios")->result_array();
        $datos=array("lista_estadisticas"=>$lista_estadisticas);
		$this->load->model('dashboard_model');
		$datos['list_users'] = $this->dashboard_model->lista_usuarios();
        $this->load->view("fixed/header");
        $this->load->view("reports/statistics_services",$datos);
        $this->load->view("fixed/footer");    
    }else{
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Calculated')));
    }
    
}
	
    public function customerstatements()
    {


        $pay_acc = $this->input->post('ac');
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));


        $list = $this->reports->get_customer_statements($pay_acc, $trans_type, $sdate, $edate);
        $balance = 0;

        foreach ($list as $row) {
            $balance += $row['credit'] - $row['debit'];
            echo '<tr><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountFormat($row['debit']) . '</td><td>' . amountFormat($row['credit']) . '</td><td>' . amountFormat($balance) . '</td></tr>';
        }

    }

    public function supplierstatements()
    {


        $pay_acc = $this->input->post('ac');
        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));


        $list = $this->reports->get_supplier_statements($pay_acc, $trans_type, $sdate, $edate);
        $balance = 0;

        foreach ($list as $row) {
            $balance += $row['debit'] - $row['credit'];
            echo '<tr><td>' . $row['date'] . '</td><td>' . $row['note'] . '</td><td>' . amountFormat($row['debit']) . '</td><td>' . amountFormat($row['credit']) . '</td><td>' . amountFormat($balance) . '</td></tr>';
        }

    }


    // income section


    public function incomestatement()

    {
        $head['title'] = "Income Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $data['income'] = $this->reports->incomestatement();
        $this->load->view('reports/incomestatement', $data);
        $this->load->view('fixed/footer');

    }


    public function customincome()
    {

        if ($this->input->post('check')) {
            $acid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);

            $diff = $date2->diff($date1)->format("%a");
            if ($diff < 90) {
                $income = $this->reports->customincomestatement($acid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<b>Income between the dates is ' . amountFormat(floatval($income['credit'])) . '</b>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 90 days', 'param1' => ''));
            }

        }
    }

    // expense section


    public function expensestatement()

    {
        $head['title'] = "Expense Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);

        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $data['income'] = $this->reports->expensestatement();


        $this->load->view('reports/expensestatement', $data);


        $this->load->view('fixed/footer');

    }


    public function customexpense()
    {

        if ($this->input->post('check')) {
            $acid = $this->input->post('pay_acc');
            $sdate = datefordatabase($this->input->post('sdate'));
            $edate = datefordatabase($this->input->post('edate'));

            $date1 = new DateTime($sdate);
            $date2 = new DateTime($edate);

            $diff = $date2->diff($date1)->format("%a");
            if ($diff < 90) {
                $income = $this->reports->customexpensestatement($acid, $sdate, $edate);

                echo json_encode(array('status' => 'Success', 'message' => 'Calculated', 'param1' => '<b>Expense between the dates is ' . amountFormat(floatval($income['debit'])) . '</b>'));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => 'Date range should be within 90 days', 'param1' => ''));
            }

        }

    }


    public function refresh_data()

    {


        $head['title'] = "Refreshing Reports";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data=array();
        if(isset($_GET['tipo']) && $_GET['tipo']=="estadisticas_servicios"){
            $data['tipo']="estadisticas_servicios";
        }
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/refresh_data',$data);
        $this->load->view('fixed/footer');

    }

    public function refresh_process()

    {

        $this->load->model('cronjob_model');
        if ($this->cronjob_model->reports()) {

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Calculated')));
        }

    }

    public function taxstatement()

    {
        $this->load->model('transactions_model');
        $data['accounts'] = $this->transactions_model->acc_list();
        $head['title'] = "TAX Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/tax_statement', $data);
        $this->load->view('fixed/footer');

    }

    public function taxviewstatement()

    {


        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sdate'));
        $edate = datefordatabase($this->input->post('edate'));

        $data['filter'] = array($sdate, $edate, $trans_type);

        //  print_r( $data['statement']);
        $head['title'] = "TAX Statement";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('reports/tax_out', $data);
        $this->load->view('fixed/footer');


    }

    public function taxviewstatements_load()
    {


        $trans_type = $this->input->post('ty');
        $sdate = datefordatabase($this->input->post('sd'));
        $edate = datefordatabase($this->input->post('ed'));

if($trans_type=='Sales') {
    $where = " WHERE DATE(invoices.invoicedate) BETWEEN '$sdate' AND '$edate' ";
    $query = $this->db->query("SELECT customers.taxid AS VAT_Number,invoices.tid AS invoice_number,invoices.total AS amount,invoices.tax AS tax,customers.name AS customer_name,customers.company AS Company_Name,invoices.invoicedate AS date FROM invoices LEFT JOIN customers ON invoices.csd=customers.id" . $where);
}
else
{

    $where = " WHERE (DATE(purchase.invoicedate) BETWEEN '$sdate' AND '$edate') ";
    $query = $this->db->query("SELECT supplier.taxid AS VAT_Number,purchase.tid AS invoice_number,purchase.total AS amount,purchase.tax AS tax,supplier.name AS customer_name,supplier.company AS Company_Name,purchase.invoicedate AS date FROM purchase LEFT JOIN supplier ON purchase.csd=supplier.id" . $where);
}


//echo $where;


        $balance = 0;

        foreach ($query->result_array() as $row) {
            $balance += $row['tax'];
            echo '<tr><td>' . $row['invoice_number'] . '</td><td>' . $row['customer_name'] . '</td><td>' . $row['VAT_Number'] . '</td><td>' . amountFormat($row['amount']) . '</td><td>' . amountFormat($row['tax']) . '</td><td>' . amountFormat($balance) . '</td></tr>';
        }




    }


}