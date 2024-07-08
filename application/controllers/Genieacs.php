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

class Genieacs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 1) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        echo '<script> $("img[alt=branding logo"]").removeClass("height-60-per");</script>';
    }

   public function index(){
    $head['title'] = 'Mikrotiks';
        $data=array();
       
            $data['lista_sedes']=$this->db->get_where("customers_group")->result_array();
            $this->load->view('fixed/header', $head);
            $this->load->view('genieacs/lista_conexiones',$data);
            $this->load->view('fixed/footer');
   }
    
    public function estado_mikrotik(){
        include (APPPATH."libraries/RouterosAPI.php");
        $API = new RouterosAPI();
        $API->debug = false;
        $res=$this->mikrotiks->get_estado_mikrotik($_POST['id'],$API);
        if(empty($res)) {
            $this->db->update("mikrotiks",array("estado_coneccion"=>0),array("id"=>$_POST['id']));
        } else{
            $this->db->update("mikrotiks",array("estado_coneccion"=>1),array("id"=>$_POST['id']));
        }

    }
    public function list_json_conections(){
        ob_clean();
        $this->load->model('Genieacs_model', 'genieacs_model');
             $list = $this->genieacs_model->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //setlocale(LC_TIME, "spanish");

        foreach ($list as $key => $value) {            
                $no++;  
                $row = array();
                $row[]="#".$value->id;
                $row[]=$value->nombre;
                $row[]=$value->ip_remota;
                $row[]=$value->puerto;
                $row[]=$value->title;
                $row[]=$value->comentarios;
                
                
                $row[]="<a href='#' data-datos='".json_encode($value)."' class='btn btn-info update_mk'><i class='icon-eye'></i></a>";                
                $data[]=$row;

        }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->genieacs_model->count_all(),
                "recordsFiltered" => $this->genieacs_model->count_filtered(),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);
    }
    public function save_ajax_conection(){
        $data=array();
        $data['nombre']=$_POST['nombre'];
        $data['ip_remota']=$_POST['ip_remota'];
        $data['puerto']=$_POST['puerto'];
        $data['sede']=$_POST['sede'];
        $data['comentarios']=$_POST['comentarios'];
        $data['id_user_actualiza']=$this->aauth->get_user()->id;
        
        if($_POST['id_configuracion']=="0"){
            $this->db->insert("genieacs_conections",$data);    
        }else{
            $this->db->update("genieacs_conections",$data,array("id_conexion"=>$_POST['id_configuracion']));
        }
    }

}