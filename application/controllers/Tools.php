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

class Tools Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tools_model', 'tools');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 0) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

    }

    //todo section

    public function todo()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'ToDo List';
        $data['totalt'] = $this->tools->task_count_all();
		
        $this->load->view('fixed/header', $head);
        $this->load->view('todo/index', $data);
        $this->load->view('fixed/footer');

    }

    public function addtask()
    {
        $this->load->model('employee_model', 'employee');
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['emp'] = $this->employee->list_employee();
        $head['title'] = 'Add Task';

        $this->load->view('fixed/header', $head);
        $this->load->view('todo/addtask', $data);
        $this->load->view('fixed/footer');

    }

    public function edittask()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $estado = $this->input->post('status');
            $priority = $this->input->post('priority');
            $stdate = $this->input->post('staskdate');
            $tdate = $this->input->post('taskdate');
            $employee = $this->input->post('employee');
            $content = $this->input->post('content');
            $puntuacion = $this->input->post('puntuacion');
            $stdate = datefordatabase($stdate);
            $tdate = datefordatabase($tdate);
        $agendar = $this->input->post('agendar');
        $fagenda = $this->input->post('f_agenda');
        $hora = $this->input->post('hora');
            if ($this->tools->edittask($id, $name, $estado, $priority, $stdate, $tdate, $employee, $content,$puntuacion,$agendar,$fagenda,$hora)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {

            $this->load->model('employee_model', 'employee');
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['emp'] = $this->employee->list_employee();
            $head['title'] = 'Edit Task';
            $id = $this->input->get('id');
			$data['attach'] = $this->tools->attach($id);
            $data['task'] = $this->tools->viewtask($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('todo/edittask', $data);
            $this->load->view('fixed/footer');
        }

    }
	public function file_handling()
   {ini_set('memory_limit', '500M');
        if($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->tools->meta_delete($invoice, 8, $name)){
                echo json_encode(array('status' => 'Success'));
            }
        }
        else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->tools->meta_insert($id, 8, $files);
            }
        }


    }

    public function save_addtask()
    {
        $name = $this->input->post('name');
        $estado = $this->input->post('status');
        $priority = $this->input->post('priority');
        $stdate = $this->input->post('staskdate');
        $tdate = $this->input->post('taskdate');
        $employee = $this->input->post('employee');
        $content = $this->input->post('content');
        $agendar = $this->input->post('agendar');
        $fagenda = $this->input->post('f_agenda');
        $hora = $this->input->post('hora');
        $assign = $this->aauth->get_user()->id;
		$ordenn = '';
        $stdate = datefordatabase($stdate);
        $tdate = datefordatabase($tdate);

        if ($this->tools->addtask2($name, $estado, $priority, $stdate, $tdate, $employee, $assign, $content, $ordenn,$agendar,$fagenda,$hora)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('New Task Added')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

    }

    public function set_task()
    {
        $id = $this->input->post('tid');
        $stat = $this->input->post('stat');
        $this->tools->settask($id, $stat);
        echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED'), 'pstatus' => 'Success'));


    }

    public function view_task()
    {
        $id = $this->input->post('tid');
		
        $task = $this->tools->viewtask($id);
		$data['attach'] = $this->tools->attach($id);
        echo json_encode(array(
			'name' => $task['name'], 
			'description' => $task['description'], 
			'employee' => $task['emp'],
			'idorden' => $task['idorden'], 
			'assign' => $task['assign'], 
            'puntuacion' => $task['puntuacion'],
			'priority' => $task['priority'], 
			'archivo' => $data['attach']));
    }

    public function task_stats()
    {

        $this->tools->task_stats();


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->tools->deletetask($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function todo_load_list()
    {
        $cday = $this->input->get('cday');
        $list = $this->tools->task_datatables($cday);
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
            $row[] = $task->id;
            $row[] = '<a href="#" class="btn btn-primary btn-sm rounded set-task" data-id="' . $task->id . '" data-stat="0"> SET </a>' . $name;
            $row[] = dateformat($task->start);
            $row[] = dateformat($task->duedate);
            $row[] = $task->emp;
            $row[] = '<span class="task_' . $task->status . '">' . $this->lang->line($task->status) . '</span>';
            $row[] = '<a class="btn-info btn-sm" href="edittask?id=' . $task->id . '" data-object-id="' . $task->id . '"> <i class="icon-pencil"></i> </a>&nbsp;<a href="'.base_url().'manager/historial?id='.$task->id.'" data-id="' . $task->id . '" class="historial_task btn-sm btn-indigo" title="Historial"> <i class="icon-eye"></i> </a>';
			if ($this->aauth->get_user()->roleid == 5) {
			$row[] = '<a class="btn-brown btn-sm delete-object" href="#" data-object-id=" ' . $task->id . '"> <i class="icon-trash-o"></i> </a>';
			}
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->task_count_all($cday),
            "recordsFiltered" => $this->tools->task_count_filtered($cday),
            "data" => $data,
        );
        echo json_encode($output);
    }


    //set goals

    public function setgoals()
    {
        if ($this->input->post('income')) {

            $income = $this->input->post('income');
            $expense = $this->input->post('expense');
            $sales = $this->input->post('sales');
            $netincome = $this->input->post('netincome');
            $users = $this->input->post('usuarios');
            $vesagro = $this->input->post('vesagro');
            $servicios = $this->input->post('servicios');
            $compras = $this->input->post('compras');
            $creditos = $this->input->post('creditos');
            $nomina = $this->input->post('nomina');
            $socios = $this->input->post('socios');
            $oficial = $this->input->post('oficial');
            $purchase = $this->input->post('purchase');
            $internet = $this->input->post('internet');
            $programadora = $this->input->post('programadora');
            $impuestos = $this->input->post('impuestos');
            $publicos = $this->input->post('publicos');
            $comisiones = $this->input->post('comisiones');
            $celulares = $this->input->post('celulares');


            if ($this->tools->setgoals($income, $expense, $sales, $netincome, $users,$vesagro,$servicios,$compras,$creditos,$nomina,$socios,$oficial,$purchase,$internet,$programadora,$impuestos,$publicos,$comisiones,$celulares)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Set Goals';
            $data['goals'] = $this->tools->goals(1);

            $this->load->view('fixed/header', $head);
            $this->load->view('goals/index', $data);
            $this->load->view('fixed/footer');
        }

    }

    //notes

    public function notes()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Notes';
        $this->load->view('fixed/header', $head);
        $this->load->view('notes/index');
        $this->load->view('fixed/footer');
    }


    public function notes_load_list()
    {
        $list = $this->tools->notes_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $note) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $note->title;
            $row[] = dateformat($note->cdate);

            $row[] = '<a href="editnote?id=' . $note->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-sm delete-object" href="#" data-object-id="' . $note->id . '"> <i class="icon-trash-o "></i> </a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->notes_count_all(),
            "recordsFiltered" => $this->tools->notes_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function addnote()
    {
        if ($this->input->post('title')) {

            $title = $this->input->post('title');
            $content = $this->input->post('content');

            if ($this->tools->addnote($title, $content)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Add Note';
            $this->load->view('fixed/header', $head);
            $this->load->view('notes/addnote');
            $this->load->view('fixed/footer');
        }

    }

    public function editnote()
    {
        if ($this->input->post('title')) {
            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $content = $this->input->post('content');

            if ($this->tools->editnote($id, $title, $content)) {
                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('UPDATED')));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
            }
        } else {
            $id = $this->input->get('id');
            $data['note'] = $this->tools->note_v($id);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit';
            $this->load->view('fixed/header', $head);
            $this->load->view('notes/editnote', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function delete_note()
    {
        $id = $this->input->post('deleteid');

        if ($this->tools->deletenote($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    //documents


    public function documents()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Documents';
        $this->load->view('fixed/header', $head);
        $this->load->view('notes/documents');
        $this->load->view('fixed/footer');


    }

    public function document_load_list()
    {
        $list = $this->tools->document_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $document) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $document->title;
            $row[] = dateformat($document->cdate);

            $row[] = '<a href="' . base_url('userfiles/documents/' . $document->filename) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> <a class="btn btn-danger btn-xs delete-object" href="#" data-object-id="' . $document->id . '"> <i class="icon-trash-o "></i> </a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tools->document_count_all(),
            "recordsFiltered" => $this->tools->document_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function adddocument()
    {

        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Document';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('title')) {
            $title = $this->input->post('title');
            $config['upload_path'] = './userfiles/documents';
            $config['allowed_types'] = 'docx|docs|txt|pdf|xls|xlsx';
            $config['max_size'] = 3000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully.';
                $filename = $this->upload->data()['file_name'];
                $this->tools->adddocument($title, $filename);
            }

            $this->load->view('notes/adddocument', $data);
        } else {


            $this->load->view('notes/adddocument', $data);


        }
        $this->load->view('fixed/footer');


    }


    public function delete_document()
    {
        $id = $this->input->post('deleteid');

        if ($this->tools->deletedocument($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }


    public function pendingtasks()
    {
        $tasks = $this->tools->pending_tasks();

        $tlist = '';
        $tc = 0;
        foreach ($tasks as $row) {


            $tlist .= '<a href="javascript:void(0)" class="list-group-item">
                      <div class="media">
                        <div class="media-left valign-middle"><i class="icon-bullhorn2 icon-bg-circle bg-cyan"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row['name'] . '</h6>
                          <p class="notification-text font-small-2 text-muted">Due date is ' . dateformat($row['duedate']) . '.</p><small>
                            Start <time  class="media-meta text-muted">' . dateformat($row['start']) . '</time></small>
                        </div>
                      </div></a>';
            $tc++;
        }

        echo json_encode(array('tasks' => $tlist, 'tcount' => $tc));


    }

function vistas_notificaciones(){
    $id_us=$this->aauth->get_user()->id;
    $this->db->update("notificaciones_tarea",array("estado"=>"aceptada"),array("id_notificar"=>$id_us));
}
function borrar_notifiaciones(){
    $id_us=$this->aauth->get_user()->id;
    $this->db->delete("notificaciones_tarea",array("id_notificar"=>$id_us));
}
    function obtener_notificaciones(){
               $retorno=$this->tools->obtener_notificaciones();
               if($retorno['hay_emitidas']==false){
                    $retorno['str_retorno']="";
               }
               echo json_encode($retorno);
    }
}