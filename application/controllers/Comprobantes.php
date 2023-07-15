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
class Comprobantes extends CI_Controller
{
    
    public function __construct()
    {

        parent::__construct();
        $this->load->model('clientgroup_model', 'clientgroup');
        $this->load->model('customers_model', 'customers');
        ob_end_clean();
        
        
        
       
        
    }

    //groups
    public function index()
    {
        ini_set('memory_limit', '128M');
        $nombre_fichero=$this->input->get("name").".txt";

        $html = file_get_contents('userfiles/txt_para_pdf_resivos/body_'.$nombre_fichero, FILE_USE_INCLUDE_PATH);
        $html2 = file_get_contents('userfiles/txt_para_pdf_resivos/header_'.$nombre_fichero, FILE_USE_INCLUDE_PATH);

        //PDF Rendering
        $this->load->library('pdf_invoice');

        $pdf = $this->pdf_invoice->load();
        $pdf->SetHTMLHeader($html2);
        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:0pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');
//echo $html;
        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Invoice_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Invoice_#' . $tid . '.pdf', 'I');
        }


    }
    public function estado_de_cuenta(){
        ob_end_clean();
        setlocale(LC_TIME, "spanish");
        ini_set('memory_limit', '1500000M');
        ini_set("pcre.backtrack_limit", "3000000");

        $data=array();
        $data['lista']=$this->db->query("SELECT * FROM customers where id=".$_GET['clcs'])->result();
        $fecha_actual= new DateTime(date("Y-m-d 00:00:00"));
        $sede=$this->db->get_where("accounts",array("sede"=>$data['lista'][0]->gid))->row();
        $data['sede']=$sede->holder;
        $data['sede_var']=$sede;
        $data['company']=$this->db->get_where("app_system",array("id"=>1))->row();
        $data['fecha']=$fecha_actual->format("Y-m-d");
        $x= new DateTime($data['fecha']);
        $data['fecha']=utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime($data['fecha'])));
        
        //var_dump($lista[0]['abonado']);
        /*datos nuevos*/
         $this->load->model('accounts_model',"accounts_model");
         $this->load->model('invoices_model', 'invocies');
        
        $data['acclist'] = $this->accounts_model->accountslist('');
        //$csd = intval($this->input->get('id'));
        //$data['customer'] = $this->db->get_where("customers",array("id"=>$csd))->row();
        
        /*$data['due'] = $this->customers->due_details($csd);
        $total_customer=$data['due']['total']-$data['due']['pamnt'];
        //$data['transaccion'] = $this->invocies->ultima_transaccion_realizada($csd);
        if($total_customer>0){
            $data['products'] = $this->invocies->invoice_sin_pagar($csd);        
        }else if($total_customer==0){
            $data['products'] = $this->invocies->ultima_factura($csd);        
        }else{
            $informacion = $this->invocies->pagadas_adelantadas($csd);        
            $data['products']=array("0"=>$informacion['factura_saldo_adelantado']);
            $data['tr_saldo_adelantado']=$informacion['tr_saldo_adelantado'][0];
            //$data['transaccion']=$informacion['tr_saldo_adelantado'];
            $data['facturas_adelantadas']=$informacion['facturas_adelantadas'];

        }
        $data['total_customer']=$total_customer;
        */

//end cambios nuevos


        $data['id'] = $tid;
        $data['title'] = "Estado Usuario $tid";
       // $data['customer']->ciudad=$this->db->get_where("ciudad",array("idCiudad"=>$data['customer']->ciudad))->row()->ciudad;               
        //$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        //if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if(isset($data['products'][0]['eid'])){
            $data['employee']=$this->invocies->employee($data['products'][0]['eid']);     
        }else{
            $data['employee']=null;
        }

        //PDF Rendering
        
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $data['pdf']=$pdf;
        $html = $this->load->view('invoices/generar_pdf_facturas_media_carta.php', $data, true);
       // $pdf->SetHTMLFooter("<div style='text-align:right;'><i><b><small>{PAGENO}/{nbpg}</small></b></i></div>");
        $pdf->WriteHTML($html);
        if ($this->input->get('d')) {
            $pdf->Output('Reporte Facturas Generadas '.$data['sede']." - ".$fecha_actual->format("Y-m-d").".pdf", 'D');
        } else {
            $pdf->Output('Reporte Facturas Generadas '.$data['sede']." - ".$fecha_actual->format("Y-m-d").".pdf", 'I');
        }

    }
    public function prueba() {
        $this->customers->send_mail("x","y","z");
    }
}