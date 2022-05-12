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

class Events extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 0) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $this->load->model('events_model');

    }


    public function index()
    {
        $this->load->model("Ticket_model","ticket");
        $this->load->model("Moviles_model","moviles");
        $data['tecnicoslista'] = $this->ticket->tecnico_list();
        $data['moviles'] = $this->moviles->get_datatables1();
        //var_dump($data['tecnicoslista']);
        $this->load->view('fixed/header');
        $this->load->view('events/cal2',$data);
        $this->load->view('fixed/footer');


    }
    public function prueba()
    {
        $this->load->model("Ticket_model","ticket");
        $this->load->model("Moviles_model","moviles");
        $data['tecnicoslista'] = $this->ticket->tecnico_list();
        $data['moviles'] = $this->moviles->get_datatables1();
        //var_dump($data['tecnicoslista']);
        $head['title']="Calendario";
        $this->load->view('fixed/header',$head);
        $this->load->view('events/cal2',$data);
        $this->load->view('fixed/footer');


    }

    /*Get all Events */

    public function getEvents()
    {
        $start = $this->input->get('start');
        $end = $this->input->get('end');
        if(isset($_COOKIE['tecnico'])){
            $_POST['tecnico']=$_COOKIE['tecnico'];
        }
        $result = $this->events_model->getEvents($start, $end);
        echo json_encode($result);
    }
    public function fecha_ultimo_evento_set(){
        $data=array();

          $data['fecha_ultimo_evento']=$this->input->post('fecha');
          
          if($data['fecha_ultimo_evento']==""){
                $data['fecha_ultimo_evento']=null;
          }
          $id= $this->aauth->get_user()->id;
        $this->db->update("aauth_users",$data,array("id"=>$id));
    }
    public function get_nombre_movil(){
        $var=$this->db->get_where("moviles",array('id_movil'=>$_POST['id']))->row();
        echo "movil#".$var->id_movil." - ".$var->nombre;
    }

    /*Add new event */
    public function addEvent()
    {
		$idorden = $this->input->post('idorden');
        $title = $this->input->post('title');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $description = $this->input->post('description');
        $color = $this->input->post('color');
		$rol = $this->input->post('rol');
        $result = $this->events_model->addEvent($idorden, $title, $start, $end, $description, $color, $rol);

    }

    /*Update Event */
    public function updateEvent()
    {
        $title = $this->input->post('title');
		$idorden = $this->input->post('idorden');
        $idtarea = $this->input->post('idtarea');
        $id = $this->input->post('id');
        $description = $this->input->post('description');
        $color = $this->input->post('color');
		$rol = $this->input->post('rol');
        $data_h['modulo']="Events";
            $data_h['accion']="Editando evento updateEvent";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']="";
            $data_h['id_fila']=$idorden;
            $data_h['tabla']="events";
            $data_h['nombre_columna']="idorden";
            $this->db->insert("historial_crm",$data_h);
        $result = $this->events_model->updateEvent($id, $idorden,$idtarea, $title, $description, $color, $rol);
        echo $result;
    }

    /*Delete Event*/
    public function deleteEvent()
    {
        $result = $this->events_model->deleteEvent();
        echo $result;
    }

    public function dragUpdateEvent()
    {
        $data_h['modulo']="Events";
            $data_h['accion']="Editando evento ".$_POST['id']." events dragUpdateEvent";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=$_POST['start']." | ". $_POST['end'];
            $data_h['id_fila']=$_POST['id'];
            $data_h['tabla']="events";
            $data_h['nombre_columna']="id";
            $this->db->insert("historial_crm",$data_h);
        if($this->aauth->get_user()->roleid!="2" && $this->aauth->get_user()->roleid!=2){
                $result = $this->events_model->dragUpdateEvent();
                echo $result;
        }
        
    }

}