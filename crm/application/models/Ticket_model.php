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

class Ticket_model extends CI_Model
{


    //documents list

    var $doccolumn_order = array('id', 'subject', 'created', null);
    var $doccolumn_search = array('subject', 'created');
    var $order = array('id' => 'desc');


    public function thread_list($id)
    {
        $this->db->select('tickets_th.*,customers.name AS custo,employee_profile.name AS emp');
        $this->db->from('tickets');
        $this->db->join('tickets_th', 'tickets.id=tickets_th.tid', 'left');
        $this->db->join('customers', 'tickets_th.cid=customers.id', 'left');
        $this->db->join('employee_profile', 'tickets_th.eid=employee_profile.id', 'left');
        $this->db->where('tickets.cid', $this->session->userdata('user_details')[0]->cid);
        $this->db->where('tickets_th.tid', $id);

        $query = $this->db->get();
        return $query->result_array();
    }

    public function ticket()
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 3);
        $query = $this->db->get();
        return $query->row();
    }

    public function thread_info($id)
    {
        $this->db->select('tickets.*, customers.name');
        $this->db->from('tickets');
        $this->db->join('customers', 'tickets.cid=customers.id', 'left');
        $this->db->where('tickets.id', $id);
        $this->db->where('tickets.cid', $this->session->userdata('user_details')[0]->cid);
        $query = $this->db->get();
        return $query->row_array();
    }

    function addreply($thread_id, $message, $filename)
    {

        $valid = $this->thread_info($thread_id);

        if($valid['cid']==$this->session->userdata('user_details')[0]->cid) {

            $data = array('tid' => $thread_id, 'message' => $message, 'cid' => $this->session->userdata('user_details')[0]->cid, 'eid' => 0, 'cdate' => date('Y-m-d H:i:s'), 'attach' => $filename);
            $data1 = array(
                'status' => 'Waiting'
            );


            $this->db->set($data1);
            $this->db->where('id', $thread_id);
            $this->db->update('tickets');

            if ($this->ticket()->key2) {


                $this->send_email($this->ticket()->url, $this->ticket()->name, '[Customer Reply] #' . $thread_id, $message, $attachmenttrue = false, $attachment = '');

            }


            return $this->db->insert('tickets_th', $data);
        }
        else{
            return false;
        }

    }


    function addticket($subject, $message, $filename)
    {
        $data = array('subject' => $subject, 'created' => date('Y-m-d H:i:s'), 'cid' => $this->session->userdata('user_details')[0]->cid, 'status' => 'Waiting');
        $this->db->insert('tickets', $data);
        $thread_id = $this->db->insert_id();


        $data = array('tid' => $thread_id, 'message' => $message, 'cid' => $this->session->userdata('user_details')[0]->cid, 'eid' => 0, 'cdate' => date('Y-m-d H:i:s'), 'attach' => $filename);
        if ($this->ticket()->key2) {


            $this->send_email($this->ticket()->url, $this->ticket()->name, '[Customer Ticket] #' . $thread_id, $message, $attachmenttrue = false, $attachment = '');

        }

        return $this->db->insert('tickets_th', $data);


    }

    private function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('sys_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);

    }

    function deleteticket($id)
    {
        $this->db->select('attach');
        $this->db->from('tickets_th');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        if ($this->db->delete('documents', array('id' => $id))) {

            unlink(FCPATH . 'userfiles/support/' . $result['filename']);
            return true;
        } else {
            return false;
        }

    }


    function ticket_datatables()
    {
        $this->ticket_datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function ticket_datatables_query()
    {

        $this->db->from('tickets');
        $this->db->where('cid', $this->session->userdata('user_details')[0]->cid);

        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
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

                if (count($this->doccolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        $order = $this->order;
        $this->db->order_by(key($order), $order[key($order)]);

    }

    function ticket_count_filtered()
    {
        $this->ticket_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function ticket_count_all()
    {
        $this->ticket_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }


}