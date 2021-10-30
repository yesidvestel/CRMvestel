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
class Moviles extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
       
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }
    public function index(){
        $head['usern']=$this->aauth->get_user()->username;
        $head['title']="Administrar Movil";
        $this->load->view("fixed/header",$head);
        $this->load->view("moviles/admin");
        $this->load->view("fixed/footer");
    }
    public function create(){
        $head['usern']=$this->aauth->get_user()->username;
        $head['title']="Nueva Movil";
        $data_view=array();
        //la idea es que se crea al dar en nueva movil una movil temporal  vacia se le puede cambiar el nombre e ir agregando los empleados al dar guardar se cambia de temporal a nueva movil y aparecera en administrar moviles
        $temporal_user=$this->db->get_where("moviles",array("id_usuario_crea"=>$this->aauth->get_user()->id,"estado"=>"Temporal"))->row();
        if(isset($temporal_user)){
            $data_view['movil_temporal_user']=$temporal_user;
        }else{
            $data=array();
            $data['nombre']="Nueva";
            $data['estado']="Temporal";
            $data['id_usuario_crea']=$this->aauth->get_user()->id;
            $data['fecha_creacion']=date("Y-m-d H:m:s");
            $this->db->insert("moviles",$data);
            $temporal_user=$this->db->get_where("moviles",array("id_usuario_crea"=>$this->aauth->get_user()->id,"estado"=>"Temporal"))->row();
            $data_view['movil_temporal_user']=$temporal_user;
        }

        


        $this->load->view("fixed/header",$head);
        $this->load->view("moviles/create",$data_view);
        $this->load->view("fixed/footer");
    }
    public function cargar_emptable(){
        $this->load->model('employee_model', 'employee');
        $list = $this->employee->get_datatables1();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $key => $empleado) {
            $no++;
            $row=array();
            $row[]=$no;
            $row[]=$empleado->name;
            $row[]=user_role($empleado->roleid);
            $status=$empleado->banned;
            if ($status == 1) {
                        $status = 'Deactive';
            } else {
                        $status = 'Active';
            }   
            $row[]=$status;
            $row[]=date("g:i a",strtotime($empleado->last_login));;
            $row[]="<a href='#' type='button' class='btn btn-success'><i class='icon-sort-down'></i> Agregar <i class='icon-sort-down'></a>";
            $data[]=$row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all2(),
            "recordsFiltered" => $this->employee->count_filtered2(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}