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
        $head['title']="Administrar Moviles";
        $this->load->view("fixed/header",$head);
        $this->load->view("moviles/admin");
        $this->load->view("fixed/footer");
    }
    public function create(){
        $head['usern']=$this->aauth->get_user()->username;
        $head['title']="Nueva Movil";
        $data_view=array();
        //la idea es que se crea al dar en nueva movil una movil temporal  vacia se le puede cambiar el nombre e ir agregando los empleados al dar guardar se cambia de temporal a nueva movil y aparecera en administrar moviles
        if(isset($_GET['id'])){
            $temporal_user=$this->db->get_where("moviles",array("id_movil"=>$_GET['id']))->row();    
        }else{
            $temporal_user=$this->db->get_where("moviles",array("id_usuario_crea"=>$this->aauth->get_user()->id,"estado"=>"Temporal"))->row();    
        }
        
        if(isset($temporal_user)){
            $data_view['movil_temporal_user']=$temporal_user;
        }else{
            $data=array();
            $data['nombre']="Nueva";
            $data['estado']="Temporal";
            $data['id_usuario_crea']=$this->aauth->get_user()->id;
            $data['fecha_creacion']=date("Y-m-d H:i:s");
            $this->db->insert("moviles",$data);
            $temporal_user=$this->db->get_where("moviles",array("id_usuario_crea"=>$this->aauth->get_user()->id,"estado"=>"Temporal"))->row();
            $data_view['movil_temporal_user']=$temporal_user;
        }

        


        $this->load->view("fixed/header",$head);
        $this->load->view("moviles/create",$data_view);
        $this->load->view("fixed/footer");
    }
public function agregar_empleado_a_la_movil(){
    $id_empleado_asignar=$this->input->post("id_empleado_asignar");
    $id_movil_temporal=$this->input->post("id_movil_temporal");
    //var_dump($id_empleado_asignar);
    //var_dump($id_movil_temporal);
    $validar_empleado_movil=$this->db->get_where("empleados_moviles",array("id_movil"=>$id_movil_temporal,"id_empleado"=>$id_empleado_asignar))->row();
    if(!isset($validar_empleado_movil)){
        $data['id_movil']=$id_movil_temporal;
        $data['id_empleado']=$id_empleado_asignar;
        echo $this->db->insert("empleados_moviles",$data);
    }else{
        echo "ya existe en la movil";
    }
}
public function desvincular_empleado_de_la_movil(){
 $id_empleado_desvincular=$this->input->post("id_empleado_desvincular");
    $id_movil_temporal=$this->input->post("id_movil_temporal");
    $validar_empleado_movil=$this->db->get_where("empleados_moviles",array("id_movil"=>$id_movil_temporal,"id_empleado"=>$id_empleado_desvincular))->row();
    if(isset($validar_empleado_movil)){
       
        echo $this->db->delete("empleados_moviles",array('id_empleados_moviles'=>$validar_empleado_movil->id_empleados_moviles));
    }else{
        echo "ya no existe en la movil";
    }   
}
    public function cargar_emptable(){
        $this->load->model('employee_model', 'employee');
        
        $_POST['id_m_temporal']=$_GET['id_m_temporal'];
        $_POST['tb']=$_GET['tb'];

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
            $row[]=date("g:i a",strtotime($empleado->last_login));
            if($_POST['tb']=="1"){
                $row[]="<a href='' type='button' class='btn btn-success cl_agregar' data-id-empleado='".$empleado->id."'><i class='icon-sort-down'></i> Agregar <i class='icon-sort-down'></a>";
            }else{
                $row[]="<a href='' type='button' class='btn btn-danger cl_desvincular' data-id-empleado='".$empleado->id."'><i class='icon-sort-up'></i> Desvincular <i class='icon-sort-up'></a>";
            }
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
    public function guardar_movil(){
        $nombre=$this->input->post("nombre");
        $id_movil_temporal=$_GET['id_m_temporal'];
        $fs='fecha_creacion';
        if(isset($_GET["type"])){
            $fs="fecha_edicion";
            $data['id_usuario_edita']=$this->aauth->get_user()->id;
        }
        $data[$fs]=date("Y-m-d H:i:s");
        $data['estado']="Activa";
        $data['nombre']=$nombre;
        echo $this->db->update("moviles",$data,array("id_movil"=>$id_movil_temporal));
    }
    public function cargar_movtable(){
        $this->load->model('moviles_model', 'moviles');
        

        $list = $this->moviles->get_datatables1();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $key => $movil) {
            $no++;
            $row=array();
            $row[]=$no;
            $row[]=$movil->id_movil;
            $row[]=$movil->nombre;
            $row[]=$movil->name;
            
            $row[]=date("d-m-Y g:i a",strtotime($movil->fecha_creacion));
            if($movil->fecha_edicion==null){
                $row[]="--";
            }else{
                $row[]=date("d-m-Y g:i a",strtotime($movil->fecha_edicion));
            }
            $row[]=$movil->estado;
            if($movil->estado=="Activa"){
                $row[]="<a href='moviles/create?id=".$movil->id_movil."' type='button' class='btn btn-success cl_editar' data-id-movil='".$movil->id_movil."'><i class='icon-pencil'></i> Editar </a>&nbsp<a href='' type='button' class='btn btn-danger cl_desactivar' data-id-movil='".$movil->id_movil."'><i class='icon-trash'></i></a>";    
            }else{
                $row[]="<a href='' type='button' class='btn btn-success cl_desactivar' data-id-movil='".$movil->id_movil."'>Activar&nbsp<i class='icon-thumbs-up'></i></a>";    
            }

            
            $data[]=$row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->moviles->count_all2(),
            "recordsFiltered" => $this->moviles->count_filtered2(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function desactivar_activar_movil(){
        $id_movil=$this->input->post("id_movil");        
        $movil=$this->db->get_where("moviles",array("id_movil"=>$id_movil))->row();
        if($movil->estado=="Activa"){
            $this->db->update("moviles",array("estado"=>"Inactiva"),array("id_movil"=>$id_movil));
        }else{
            $this->db->update("moviles",array("estado"=>"Activa"),array("id_movil"=>$id_movil));
        }
    }


}