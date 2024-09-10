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

class Invoices extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('Communication_model', 'communication');
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
        $_SESSION['user_p']="8wOQ5r2pCRoSTjG";
        $_SESSION['key_p']="K4N2CDMArYqCPshu5rvbycCnOG";
    }

    //invoices list
    public function index()
    {date_default_timezone_set('America/Bogota');
        $head['title'] = "Manage Invoices";
        //$_SESSION['url_web_service']="http://localhost/crm_consultas/Servicio";//pruebas_locales
        $cid=$this->session->userdata('user_details')[0]->cid;
        $this->load->model('Payments_model', 'payments');
       //$data['list_banks']= $this->payments->get_list_banks_pse();
        $cuerpo='"cid": '.$cid.",";
        
        $data['dt']=$this->communication->obtener($cuerpo,"get_due_customer");

        $data['dt']=json_decode($data['dt']);

        $data['due']=$data['dt']->due;
        $_SESSION['dt_customer']=$data['dt']->data_customer;
        $data['promo1']=$data['dt']->data_promos;
        $data['wompi_data']=array();
        $x=(new DateTime())->format("U");
        $x=$x."_".$cid;
        $x=md5($x);
        $data['wompi_data']['reference']=$x;
        $data['wompi_data']['debe']=$data['due']->total-$data['due']->pamnt;
        $x=$x.$data['wompi_data']['debe']."00COP".$_SESSION['wompi']['integridad_key'];
        $data['wompi_data']['firma_integridad']=hash ("sha256", $x);
        //$dx=$this->db->sql("select * from wompi_data_orden where cid_user='".$cid."' and estado='Inicial' order by desc")->result_array();
        $data['wompi_data']['fecha']=date("Y-m-d H:i:s");
        $data['wompi_data']['cid_user']=$cid;
        $data['wompi_data']['estado']='Inicial';
        if($data['wompi_data']['debe']>=1000){
            $this->db->insert("wompi_data_orden",$data['wompi_data']);    
        }
        $data['wompi_data']['public_key']=$_SESSION['wompi']['public_key'];
        

        $this->load->view('includes/header');
        $this->load->view('invoices/invoices',$data);
        $this->load->view('includes/footer');
    }

public function aplicar_prom(){
    $cid=$this->session->userdata('user_details')[0]->cid;
    //promo es el porsentaje de la promo 
    $cuerpo='"cid": '.$cid.',"promo":5,';
     $respuesta=$this->communication->obtener($cuerpo,"aplicar_discount");
        echo $respuesta;
}
    public function ajax_list()
    { 
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $_POST['search']['value'];
        if($search!=""){
            $search='"search": '.$search.',';
        }
        $order = $this->input->post('order');
        if($order==null){
            $order="";
        }else{
            $order='"order":'.json_encode($order).',';
        }
        $cid=$this->session->userdata('user_details')[0]->cid;

        //var_dump($search);
        $cuerpo='"cid": '.$cid.',"start": '.$start.',"length": '.$length.','.$search.$order;

        $respuesta=$this->communication->obtener($cuerpo,"inv_list");
        echo $respuesta;
        /*$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://localhost/webservice/consulta.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;*/

       /* $query = $this->db->query("SELECT currency FROM app_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();

        $this->config->set_item('currency', $row["currency"]);


        $list = $this->invocies->get_datatables();
        $data = array();

        $no = $this->input->post('start');
        $curr = $this->config->item('currency');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountExchange($invoices->total,$invoices->multi);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="fa fa-file-text"></i> ' . $this->lang->line('View') . '</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->invocies->count_all(),
            "recordsFiltered" => $this->invocies->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    */
    }

    public function view()
    {
          $tid = intval($this->input->get('id'));
        $cuerpo='"tid": '.$tid.",";
        $respuesta=$this->communication->obtener($cuerpo,"view_service");
         $this->load->view('includes/header');
        echo $respuesta;
        $this->load->view('includes/footer');
        
    

    }


}