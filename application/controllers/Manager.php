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

        $task = $this->manager->viewtask($id);

        echo json_encode(array('name' => $task['name'], 'description' => $task['description'], 'employee' => $task['emp'], 'assign' => $task['assign'], 'priority' => $task['priority']));
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
            $row[] = '<span class="task_' . $task->status . '">' . $task->status . '</span>';

            $row[] = '<a href="#" data-id="' . $task->id . '" class="view_task btn-sm btn-indigo"> <i class="icon-eye"> View</i> </a>';


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