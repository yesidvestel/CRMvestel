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

class Manager Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('manager_model', 'manager');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


    }

    public function todo()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'ToDo List';

        $this->load->view('fixed/header', $head);
        $this->load->view('todo/employee');
        $this->load->view('fixed/footer');

    }


    public function set_task()
    {
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $this->manager->settask($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function view_task()
    {
        $id = $this->input->post('tid');
		$this->load->model('tools_model', 'tools');
        $task = $this->manager->viewtask($id);
		$data['attach'] = $this->tools->attach($id);
        echo json_encode(array(
			'name' => $task['name'], 
			'description' => $task['description'], 
			'idorden' => $task['idorden'],
			'employee' => $task['emp'], 
			'assign' => $task['assign'], 
			'priority' => $task['priority'], 
			'archivo' => $data['attach']));
    }

    public function historial(){
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'historial tarea';
        $data['id_tarea']=$_GET['id'];
        $data['tarea']=$this->manager->get_tarea($_GET['id']);
        $data['historial']=$this->manager->getHistorialTareas($_GET['id']);
        $data['p_files']=$this->manager->p_files($_GET['id']);
        $orden = $this->aauth->get_user()->username;
        
        $almacen= $this->db->get_where('product_warehouse',array('id_tecnico'=>$orden))->row();
        $data['lista_productos_tecnico']=$this->db->get_where('products',array('warehouse'=>$almacen->id))->result_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('todo/historial',$data);
        $this->load->view('fixed/footer');
    }
    public function add_products_tarea(){
        
        foreach ($_POST['lista'] as $key => $producto) {
             $vary=intval($producto['qty']);
             if($vary>0){
                $tf_prod_orden=$this->db->get_where('transferencia_products_orden',array("products_pid"=>$producto['pid'],"id_tarea"=>$_POST['id_orden_n']))->row();
                if(empty($tf_prod_orden)){
                    $dats['products_pid']=$producto['pid'];
                    $dats['id_tarea']=$_POST['id_orden_n'];
                    $dats['cantidad']=$producto['qty'];
                    //proceso de descontar cantidades del almacen
                    $producto_padre=$this->db->get_where('products',array('pid'=>$producto['pid']))->row();
                    $x1=intval($producto_padre->qty);
                    $x1=$x1-$vary;
                    $datx['qty']=$x1;
                    $this->db->update('products',$datx,array('pid'=>$producto['pid']));
                    // end proceso de descontar cantidades del almacen
                    $this->db->insert('transferencia_products_orden',$dats);
                }
             }
        }

        echo "Correcto";
    }

     public function file_handling()
    {
        $id = $this->input->get('id');
        $this->load->library("Uploadhandler_generic", array(
            'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/historias_tareas/', 'upload_url' => base_url() . 'userfiles/historias_tareas/'
        ));
        $files = (string)$this->uploadhandler_generic->filenaam();
        if ($files != '') {
            //$fid = rand(100, 9999);
            $data=array();
            $data['id_tarea']=$id;
            if(!empty($_GET['historia_id'])){
                $data['id_historia_tarea']=$_GET['historia_id'];
            }
            $data['nombre']=$files;
            $this->manager->save_file($data);
        }


    }

    public function guardar_historia_tarea(){
        $data=array();
        $data['titulo']=$this->input->post("titulo");
        $data['comentario']=$this->input->post("content");
        $data['id_tarea']=$this->input->post("id_tarea");
        $data['id_usuario_historial']=$this->aauth->get_user()->id;

        $this->manager->guardar($data);

    }
    public function borrar_historia_tarea(){
        $this->db->delete("historial_tareas",array("id_historial_tareas"=>$_POST['id']));
    }

    public function todo_load_list()
    {
        $cday = $this->input->get('cday');
        $list = $this->manager->task_datatables($cday);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $task) {
            $no++;
            $name = '<a class="check text-default" data-id="' . $task->id . '" data-stat="Due"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            if ($task->status == 'Done') {
                $name = '<a class="check text-success" data-id="' . $task->id . '" data-stat="Done"> <i class="icon-check"></i> </a><a href="#" data-id="' . $task->id . '" class="view_task">' . $task->name . '</a>';
            }
            $row = array();
            $row[] = $no;
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> SET </a>' . $name;
            $row[] = $task->duedate;
            $row[] = $task->start;
            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';

            $row[] = '<a href="#" data-id="' . $task->id . '" class="view_task btn-sm btn-indigo"> <i class="icon-eye"> View</i> </a>&nbsp; <a href="'.base_url().'manager/historial?id='.$task->id.'" data-id="' . $task->id . '" class="historial_task btn-sm btn-indigo"> <i class="icon-eye"> Historial</i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->manager->task_count_all($cday),
            "recordsFiltered" => $this->manager->task_count_filtered($cday),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function pendingtasks()
    {
        $user = $this->aauth->get_user()->id;

        $tasks = $this->manager->pending_tasks_user($user);

        $tlist = '';
        $tc = 0;
        foreach ($tasks as $row) {


            $tlist .= '<a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] . '</h6>
                          <p class="notification-text font-small-2 text-muted">Due date is ' . $row['duedate'] . '.</p><small>
                            Start date <time  class="media-meta text-muted">' . $row['start'] . '</time></small>
                        </div>
                      </div></a>';
            $tc++;
        }

        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));


    }


}