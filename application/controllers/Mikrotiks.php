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

class Mikrotiks extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mikrotiks_model', 'mikrotiks');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 1) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        //echo '<script> $("img[alt=branding logo"]").removeClass("height-60-per");</script>';
    }

   public function index(){
    $head['title'] = 'Mikrotiks';
        $data=array();
        $data['title_1']="Sede";
     if($_SESSION[md5("variable_datos_pin")]['db_name']=="admin_crmvestel"){
        $data['lista_sedes']=$this->db->query("select ciudad.idCiudad as id,ciudad.ciudad as title  from ciudad")->result_array();
        $data['title_1']="Ciudad";
     }else{
        $data['lista_sedes']=$this->db->get_where("customers_group")->result_array();
     }
    
    $this->db->update("mikrotiks",array("estado_coneccion"=>null));
    $lista_mikrotiks=$this->db->get_where("mikrotiks")->result_array();
    $str_json=array();
    foreach ($lista_mikrotiks as $k => $mk) {
        $str_json[]=$mk['id'];
    }
    $data['lista_mks']=json_encode($str_json);
            $this->load->view('fixed/header', $head);
            $this->load->view('mikrotiks/index2',$data);
            $this->load->view('fixed/footer');
   }
   public function set_default(){
        $this->db->update("mikrotiks",array("defecto"=>null),array("sede"=>$_POST['sede']));
        $this->db->update("mikrotiks",array("defecto"=>1),array("id"=>$_POST['id']));
   }
     public function set_default_ips_user(){
        $this->db->update("ips_users_mk",array("defecto"=>null),array("sede"=>$_POST['sede']));
        $this->db->update("ips_users_mk",array("defecto"=>1),array("id"=>$_POST['id']));
   }
   public function mk_list(){
        
        $list = $this->mikrotiks->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //setlocale(LC_TIME, "spanish");

        foreach ($list as $key => $value) {            
                $no++;  
                $row = array();
                $row[]="MK#".$value->id;
                $row[]=$value->nombre;
                $row[]=$value->ip;
                $row[]=$value->puerto;
                $teg=$value->tegnologia;
              $cuantos=  $this->db->query("select count(*) as cuantos from mikrotiks where sede=".$value->sede)->result();
              //var_dump($cuantos[0]->cuantos);
                if(intval($cuantos[0]->cuantos)>1){
                    $color="";
                    $tit="";
                    if($value->defecto=="1"){
                        $color="green";
                        $tit="title='Mikrotik por defecto sede ".$value->title."'";
                    }else{
                        $value->defecto="0";
                    }
                    $array_set=array("id"=>$value->id,"defecto"=>$value->defecto,"sede"=>$value->sede);
                    $teg=" <a href='#' class='black set_default' data-datos='".json_encode($array_set)."'><i ".$tit." class='icon-flag ".$color."'></i></a> ".$teg;
                }
                $row[]=$teg;
                $row[]=$value->title;
                $row[]=$value->usuario; 
                $str1="";
                for ($i=0; $i < strlen($value->password) ; $i++) { 
                    $str1.="*";
                }               
                $row[]=$str1;   
                if($value->estado=="1"){
                    $row[]='<span class="st-Activo">Activa</span>';    
                }else if($value->estado=="0"){
                    $row[]='<span class="st-Inactivo">Inactiva</span>';    
                }else{
                    $row[]='--';    
                }
                
                $row[]="<a href='#' data-datos='".json_encode($value)."' class='btn btn-info update_mk'><i class='icon-eye'></i></a>&nbsp<a href='#' title='Validar Estado de Conexión' data-id='".$value->id."' class='btn btn-orange cl_calcula_estado'><i class='icon-bolt'></i></a>";                
                $data[]=$row;

        }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->mikrotiks->count_all(),
                "recordsFiltered" => $this->mikrotiks->count_filtered(),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);

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
    public function save_ajax(){
        $data=array();
        $data['nombre']=$_POST['nombre'];
        $data['ip']=$_POST['ip'];
        $data['puerto']=$_POST['puerto'];
        $data['tegnologia']=$_POST['tegnologia'];
        $data['sede']=$_POST['sede'];
        $data['usuario']=$_POST['usuario'];
        $data['password']=$_POST['password'];
        if($_POST['id_mikrotik']=="0"){
            
            if(empty($this->db->get_where("mikrotiks",array("sede"=>$data['sede']))->row())){
                    $data['defecto']=1;
            }
            $this->db->insert("mikrotiks",$data);    
        }else{
            $this->db->update("mikrotiks",$data,array("id"=>$_POST['id_mikrotik']));
        }
        
    }
    public function lista_vista_ips(){
        $head['title'] = 'Ips de los usuarios';
        $data['lista_sedes']=$this->db->get_where("customers_group")->result_array();
            $this->load->view('fixed/header', $head);
            $this->load->view('mikrotiks/ips_users',$data);
            $this->load->view('fixed/footer');
    }
    public function list_json_ips_users(){
        $this->load->model('Ips_users_mk_model', 'ips_users_mk');
             $list = $this->ips_users_mk->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //setlocale(LC_TIME, "spanish");

        foreach ($list as $key => $value) {            
                $no++;  
                $row = array();
                $row[]="#".$value->id;
                $row[]=$value->nombre;
                $row[]=$value->ip_local;
                $row[]=$value->ip_remota;
                $teg=$value->tegnologia;
              $cuantos=  $this->db->query("select count(*) as cuantos from ips_users_mk where sede=".$value->sede)->result();
              //var_dump($cuantos[0]->cuantos);
               if($teg==""){
                       $teg= "Default";
                }
                if(intval($cuantos[0]->cuantos)>1){
                    $color="";
                    $tit="";

                    
                    if($value->defecto=="1"){
                        $color="green";
                        $tit="title='Ip por defecto sede ".$value->title."'";
                    }else{
                        $value->defecto="0";
                    }
                    $array_set=array("id"=>$value->id,"defecto"=>$value->defecto,"sede"=>$value->sede);
                    $teg=" <a href='#' class='black set_default' data-datos='".json_encode($array_set)."'><i ".$tit." class='icon-flag ".$color."'></i></a> ".$teg;
                }
                $row[]=$teg;
                $row[]=$value->title;
                
                
                $row[]="<a href='#' data-datos='".json_encode($value)."' class='btn btn-info update_mk'><i class='icon-eye'></i></a>";                
                $data[]=$row;

        }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->ips_users_mk->count_all(),
                "recordsFiltered" => $this->ips_users_mk->count_filtered(),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);
    }
    public function save_ajax_ips_users(){
        $data=array();
        $data['nombre']=$_POST['nombre'];
        $data['ip_local']=$_POST['ip_local'];
        $data['ip_remota']=$_POST['ip_remota'];
        $data['tegnologia']=$_POST['tegnologia'];
        $data['sede']=$_POST['sede'];
        $data['perfiles']=$_POST['perfiles'];
        
        if($_POST['id_configuracion']=="0"){
            
            if(empty($this->db->get_where("ips_users_mk",array("sede"=>$data['sede']))->row())){
                    $data['defecto']=1;
            }
            $this->db->insert("ips_users_mk",$data);    
        }else{
            $this->db->update("ips_users_mk",$data,array("id"=>$_POST['id_configuracion']));
        }
    }

}