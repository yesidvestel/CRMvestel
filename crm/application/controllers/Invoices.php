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
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Invoices";
        //$_SESSION['url_web_service']="http://localhost/CRMvestel/Servicio";//pruebas_locales
        $cid=$this->session->userdata('user_details')[0]->cid;
        $cuerpo='"cid": '.$cid.",";
        
        $data['due']=$this->communication->obtener($cuerpo,"get_due_customer");
        $data['due']=json_decode($data['due']);
        
        $this->load->view('includes/header');
        $this->load->view('invoices/invoices',$data);
        $this->load->view('includes/footer');
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



        $data['acclist'] = '';
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
var_dump($tid);
        $data['invoice'] = $this->invocies->invoice_details($tid);
        if($data['invoice']['csd']==$this->session->userdata('user_details')[0]->cid){
        $data['products'] = $this->invocies->invoice_products($tid);
        $data['activity'] = $this->invocies->invoice_transactions($tid);
        $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
        $this->load->view('includes/header');
        $this->load->view('invoices/view', $data);
        $this->load->view('includes/footer');
    }

    }


}