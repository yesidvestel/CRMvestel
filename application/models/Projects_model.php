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

class Projects_model extends CI_Model
{

    var $column_order = array('projects.status', 'projects.name', 'projects.edate', 'projects.worth', null);
    var $column_search = array('projects.name', 'projects.edate', 'projects.status');
    var $tcolumn_order = array('status', 'name', 'duedate', 'start', null, null);
    var $tcolumn_search = array('name', 'edate', 'status');
    var $order = array('id' => 'desc');


    public function explore($id)
    {
        //project
        $this->db->select('projects.*,customers.name AS customer,customers.email');
        $this->db->from('projects');
        $this->db->where('projects.id', $id);
        $this->db->join('customers', 'projects.cid = customers.id', 'left');
        $query = $this->db->get();
        $project = $query->row_array();
        //employee
        $this->db->select('employee_profile.name');
        $this->db->from('project_meta');
        $this->db->where('project_meta.pid', $id);
        $this->db->where('project_meta.meta_key', 6);
        $this->db->join('employee_profile', 'project_meta.meta_data = employee_profile.id', 'left');
        $query = $this->db->get();
        $employee = $query->result_array();
        //invoices
        $this->db->select('invoices.*');
        $this->db->from('project_meta');
        $this->db->where('project_meta.pid', $id);
        $this->db->where('project_meta.meta_key', 11);
        $this->db->join('invoices', 'project_meta.meta_data = invoices.tid', 'left');
        $query = $this->db->get();
        $invoices = $query->result_array();

        return array('project' => $project, 'employee' => $employee, 'invoices' => $invoices);

    }

    public function details($id)
    {
//project
        $this->db->select('projects.*,projects.id AS prj, customers.name AS customer,project_meta.*');
        $this->db->from('projects');
        $this->db->where('projects.id', $id);
        $this->db->where('project_meta.meta_key', 2);
        $this->db->join('customers', 'projects.cid = customers.id', 'left');
        $this->db->join('project_meta', 'project_meta.pid = projects.id', 'left');

        $query = $this->db->get();
        return $query->row_array();
    }

    private function _project_datatables_query($cday = '')
    {
        $this->db->select("projects.*,customers.name AS customer");
        $this->db->from('projects');
        $this->db->join('customers', 'projects.cid = customers.id', 'left');

        if ($cday) {
            $this->db->where('DATE(projects.edate)=', $cday);
        }


        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function project_datatables($cday = '')
    {


        $this->_project_datatables_query($cday);

        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function project_count_filtered($cday = '')
    {
        $this->_project_datatables_query($cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function project_count_all($cday = '')
    {
        $this->_project_datatables_query($cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addproject($name, $status, $priority, $progress, $customer, $sdate, $edate, $tag, $phase, $content, $budget, $customerview, $customer_comment, $link_to_cal, $color, $ptype, $employee)
    {
        $data = array('name' => $name, 'status' => $status, 'priority' => $priority, 'progress' => $progress, 'cid' => $customer, 'sdate' => $sdate, 'edate' => $edate, 'tag' => $tag, 'phase' => $phase, 'note' => $content, 'worth' => $budget, 'ptype' => $ptype);
        $this->db->insert('projects', $data);
        $last = $this->db->insert_id();
        $title = '[Project Created] ';
        $this->add_activity($title, $last);
        $data = array('pid' => $last, 'meta_key' => 2, 'meta_data' => $customerview, 'value' => $customer_comment);
        $this->db->insert('project_meta', $data);

        if ($employee) {
            foreach ($employee as $key => $value) {

                $data = array('pid' => $last, 'meta_key' => 19, 'meta_data' => $value);
                $this->db->insert('project_meta', $data);
            }
        } else {
            $data = array('pid' => $last, 'meta_key' => 19, 'meta_data' => $this->aauth->get_user()->id);
            $this->db->insert('project_meta', $data);
        }


        if ($link_to_cal > 0) {
            if ($link_to_cal == 1) {
                $sdate = $edate;
            }
            $data = array(
                'title' => '[Project] ' . $name,
                'start' => $sdate,
                'end' => $edate,
                'description' => $priority . ' priority. Start date: ' . $sdate . ' End Date: ' . $edate, 'color' => $color,
                'rel' => 1,
                'rid' => $last
            );
            $this->db->insert('events', $data);
        }

        return $last;
    }

    public function editproject($id, $name, $status, $priority, $progress, $customer, $sdate, $edate, $tag, $phase, $content, $budget, $customerview, $customer_comment, $link_to_cal, $color, $ptype, $employee)
    {
        $title = '[Project Edited] ';
        $this->add_activity($title, $id);
        $data = array('name' => $name, 'status' => $status, 'priority' => $priority, 'progress' => $progress, 'cid' => $customer, 'sdate' => $sdate, 'edate' => $edate, 'tag' => $tag, 'phase' => $phase, 'note' => $content, 'worth' => $budget, 'ptype' => $ptype);
        $this->db->set($data);
        $this->db->where('id', $id);
        $out = $this->db->update('projects');

        $this->db->delete('events', array('rel' => 1, 'rid' => $id));
        if ($link_to_cal > 0) {
            if ($link_to_cal == 1) {
                $sdate = $edate;
            }
            $data = array(
                'title' => '[Project] ' . $name,
                'start' => $sdate,
                'end' => $edate,
                'description' => $priority . ' priority. Start date: ' . $sdate . ' End Date: ' . $edate, 'color' => $color,
                'rel' => 1,
                'rid' => $id
            );
            $this->db->insert('events', $data);
        }
        if ($employee) {
            $this->db->delete('project_meta', array('pid' => $id, 'meta_key' => 19));
            foreach ($employee as $key => $value) {

                $data = array('pid' => $id, 'meta_key' => 19, 'meta_data' => $value);
                $this->db->insert('project_meta', $data);
            }
        }

        $data1 = array('meta_data' => $customerview, 'value' => $customer_comment);
        $this->db->set($data1);
        $this->db->where('pid', $id);
        $this->db->where('meta_key', 2);

        return $this->db->update('project_meta');
    }


    public function addtask($name, $status, $priority, $stdate, $tdate, $employee, $assign, $content, $prid, $milestone)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'aid' => $assign, 'related' => 1, 'priority' => $priority, 'rid' => $prid);
        if ($prid) {

            $this->db->insert('todolist', $data);
            $last = $this->db->insert_id();

            if ($milestone) {
                $this->meta_insert($prid, 8, $milestone, $last);
            }

            $out = $this->communication($prid, $name);

            return 1;
        } else {
            return 0;
        }
    }

    public function add_milestone($name, $stdate, $tdate, $content, $color, $prid)
    {

        $data = array('pid' => $prid, 'name' => $name, 'sdate' => $stdate, 'edate' => $tdate, 'color' => $color, 'exp' => $content);
        if ($prid) {

            $title = '[Milestone] ' . $name;
            $this->add_activity($title, $prid);

            return $this->db->insert('milestones', $data);

        } else {
            return 0;
        }
    }

    public function edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'related' => 0, 'priority' => $priority, 'rid' => 0);
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('todolist');
        //return $this->db->insert('todolist', $data);
    }

    public function settask($id, $stat)
    {

        $data = array('status' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('todolist');
    }

    public function setnote($id, $stat)
    {

        $data = array('note' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('projects');
    }

    public function deletetask($id)
    {

        return $this->db->delete('todolist', array('id' => $id));
    }

    public function deleteproject($id)
    {
        $this->db->delete('todolist', array('related' => 1, 'rid' => $id));

        return $this->db->delete('projects', array('id' => $id));
    }

    public function viewtask($id)
    {

        $this->db->select('todolist.*,employee_profile.name AS emp, assi.name AS assign');
        $this->db->from('todolist');
        $this->db->where('todolist.id', $id);
        $this->db->join('employee_profile', 'employee_profile.id = todolist.eid', 'left');
        $this->db->join('employee_profile AS assi', 'assi.id = todolist.aid', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function project_stats($project)
    {

        $query = $this->db->query("SELECT
				COUNT(IF( status = 'Waiting', id, NULL)) AS Waiting,
				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,
				COUNT(IF( status = 'Finished', id, NULL)) AS Finished			
				FROM projects");

        echo json_encode($query->result_array());

    }

    //project tasks

    private function _task_datatables_query($cday = '')
    {

        $this->db->from('todolist');
        $this->db->where('related', 1);
        if ($cday) {

            $this->db->where('rid=', $cday);
        }


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->tcolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function task_datatables($cday = '')
    {


        $this->_task_datatables_query($cday);

        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $this->db->where('related', 1);
        $this->db->where('rid=', $cday);
        $query = $this->db->get();
        return $query->result();
    }

    function task_count_filtered($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('related', 1);
        $this->db->where('rid=', $cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function task_count_all($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('related', 1);
        $this->db->where('rid=', $cday);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //thread task


    public function task_thread($id)
    {

        $this->db->select('todolist.*, employee_profile.name AS emp');
        $this->db->from('todolist');
        $this->db->where('todolist.related', 1);
        $this->db->where('todolist.rid', $id);
        $this->db->join('employee_profile', 'todolist.eid = employee_profile.id', 'left');
        $this->db->order_by('todolist.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function milestones($id)
    {

        $this->db->select('*');
        $this->db->from('milestones');
        $this->db->where('pid', $id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function milestones_list($id)
    {

        $query = $this->db->query('SELECT milestones.*,todolist.name as task FROM milestones LEFT JOIN project_meta ON project_meta.meta_data=milestones.id AND project_meta.meta_key=8 LEFT JOIN todolist ON project_meta.value=todolist.id WHERE milestones.pid=' . $id . ' ORDER BY milestones.id DESC;');
        return $query->result_array();


    }

    public function activities($id)
    {

        $this->db->select('project_meta.value');
        $this->db->from('project_meta');
        $this->db->where('pid', $id);
        $this->db->where('meta_key', 12);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function p_files($id)
    {

        $this->db->select('*');
        $this->db->from('project_meta');
        $this->db->where('pid', $id);
        $this->db->where('meta_key', 9);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_activity($name, $prid)
    {

        $data = array('pid' => $prid, 'meta_key' => 12, 'value' => $name . ' @' . date('Y-m-d H:i:s'));
        if ($prid) {
            return $this->db->insert('project_meta', $data);
        } else {
            return 0;
        }
    }

    public function meta_insert($prid, $meta_key, $meta_data, $value)
    {

        $data = array('pid' => $prid, 'meta_key' => $meta_key, 'meta_data' => $meta_data, 'value' => $value);
        if ($prid) {
            return $this->db->insert('project_meta', $data);
        } else {
            return 0;
        }
    }

    public function deletefile($pid, $mid)
    {

        $this->db->select('value');
        $this->db->from('project_meta');
        $this->db->where('pid', $pid);
        $this->db->where('meta_key', 9);
        $this->db->where('meta_data', $mid);
        $query = $this->db->get();
        $result = $query->row_array();
        unlink(FCPATH . 'userfiles/project/' . $result['value']);
        $this->db->delete('project_meta', array('pid' => $pid, 'meta_key' => 9, 'meta_data' => $mid));
    }

    public function deletemilestone($mid)
    {
        $this->db->delete('milestones', array('id' => $mid));
    }

    //comments

    public function comments_thread($id)
    {

        $this->db->select('project_meta.value, project_meta.key3,employee_profile.name AS employee, customers.name AS customer');
        $this->db->from('project_meta');
        $this->db->where('project_meta.pid', $id);
        $this->db->where('project_meta.meta_key', 13);
        $this->db->join('employee_profile', 'project_meta.meta_data = employee_profile.id', 'left');
        $this->db->join('customers', 'project_meta.key3 = customers.id', 'left');
        $this->db->order_by('project_meta.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_comment($comment, $prid, $emp)
    {

        $data = array('pid' => $prid, 'meta_key' => 13, 'meta_data' => $emp, 'value' => $comment . '<br><small>@' . date('Y-m-d H:i:s') . '</small>');
        if ($prid) {
            return $this->db->insert('project_meta', $data);
        } else {
            return 0;
        }
    }

    public function progress($id, $val)
    {
        if ($val == 100) $stat = 'Finished'; else $stat = 'Progress';
        $data = array('status' => $stat, 'progress' => $val);
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('projects');
    }


    public function task_stats($id)
    {
        $query = $this->db->query("SELECT
				COUNT(IF( status = 'Due', id, NULL)) AS Due,
				COUNT(IF( status = 'Progress', id, NULL)) AS Progress,
				COUNT(IF( status = 'Done', id, NULL)) AS Done
				FROM todolist WHERE related=1 AND rid=$id");

        echo json_encode($query->result_array());

    }

    public function list_project_employee($id)
    {
        $this->db->select('employee_profile.*');
        $this->db->from('project_meta');
        $this->db->where('project_meta.pid', $id);
        $this->db->where('project_meta.meta_key', 19);
        $this->db->join('employee_profile', 'employee_profile.id = project_meta.meta_data', 'left');
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $this->db->order_by('aauth_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    private function communication($id, $sub)
    {

        $this->db->select('projects.name as pname,projects.ptype,customers.name as cust,customers.email');
        $this->db->from('projects');
        $this->db->where('projects.id', $id);
        $this->db->join('customers', "customers.id = projects.cid", 'left');
        $query = $this->db->get();
        $result = $query->row_array();

        if ($result['ptype'] == '1') {
            $this->db->select('aauth_users.email,aauth_users.username');
            $this->db->from('project_meta');
            $this->db->where('project_meta.pid', $id);
            $this->db->where('project_meta.meta_key', 19);
            $this->db->join('aauth_users', "project_meta.meta_data = aauth_users.id", 'left');
            $query = $this->db->get();
            $result_c = $query->result_array();
            $message = '<h3>Dear Project Participant,</h3>
                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added ' . $sub . '</p><p>With Reagrds,<br>Project Communication Manager';
            foreach ($result_c as $row) {
                $this->send_email($row['email'], $row['username'], '[Task Added]' . $sub, $message);
            }


        } else if ($result['ptype'] == '2') {

            $this->db->select('aauth_users.email,aauth_users.username');
            $this->db->from('project_meta');
            $this->db->where('project_meta.pid', $id);
            $this->db->where('project_meta.meta_key', 19);
            $this->db->join('aauth_users', "project_meta.meta_data = aauth_users.id", 'left');
            $query = $this->db->get();
            $result_c = $query->result_array();
            $message = '<h3>Dear Project Participant,</h3>
                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added <strong>' . $sub . '</strong></p><p>With Regards,<br>Project Communication Manager</p>';
            foreach ($result_c as $row) {
                $this->send_email($row['email'], $row['username'], '[Task Added] ' . $sub, $message);
            }

            $message = '<h3>Dear Customer,</h3>
                        <p>This is an update mail regarding your project ' . $result['pname'] . '</p> <p>A new task has been added <strong>' . $sub . '</strong></p><p>With Warm Regards,<br>Project Communication Manager</p>';

            $this->send_email($result['email'], $result['cust'], '[Task Added] ' . $sub, $message);

        }

    }

    private function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,username,password,sender');
        $this->db->from('sys_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->bin_send($host, $port, $auth, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);

    }


}