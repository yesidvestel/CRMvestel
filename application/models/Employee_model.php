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

class Employee_model extends CI_Model
{

    public function list_employee()
    {
        $this->db->select('employee_profile.*,aauth_users.banned,aauth_users.roleid');
        $this->db->from('employee_profile');
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $this->db->order_by('aauth_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
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

    public function employee_details($id)
    {
        $this->db->select('employee_profile.*,aauth_users.email');
        $this->db->from('employee_profile');
        $this->db->where('employee_profile.id', $id);
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_employee($id, $name, $phone, $phonealt, $address, $city, $region, $country, $postbox)
    {
        $data = array(
            'name' => $name,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox
        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('employee_profile')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function update_password($id, $cpassword, $newpassword, $renewpassword)
    {
        $data = array(
            'name' => $name,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox
        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('employee_profile')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from('employee_profile');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('employee_profile')) {
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('aauth_users');
            unlink(FCPATH . 'userfiles/employee/' . $result['picture']);
            unlink(FCPATH . 'userfiles/employee/thumbnail/' . $result['picture']);
        }


    }


    public function editsign($id, $pic)
    {
        $this->db->select('sign');
        $this->db->from('employee_profile');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'sign' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('employee_profile')) {

            unlink(FCPATH . 'userfiles/employee_sign/' . $result['sign']);
            unlink(FCPATH . 'userfiles/employee_sign/thumbnail/' . $result['sign']);
        }


    }


    var $table = 'invoices';
    var $column_order = array(null, 'invoices.tid', 'invoices.invoicedate', 'invoices.total', 'invoices.status');
    var $column_search = array('invoices.tid', 'invoices.invoicedate', 'invoices.total', 'invoices.status');
    var $order = array('invoices.tid' => 'asc');


    private function _invoice_datatables_query($id)
    {

        $this->db->from('invoices');
        $this->db->where('invoices.eid', $id);
        $this->db->join('customers', 'invoices.csd=customers.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
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
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function invoice_datatables($id)
    {
        $this->_invoice_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function invoicecount_filtered($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('invoices.eid', $id);
        }
        return $query->num_rows($id);
    }

    public function invoicecount_all($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('invoices.eid', $id);
        }
        return $query->num_rows($id = '');
    }

    //transaction


    var $tcolumn_order = array(null, 'account', 'type', 'cat', 'amount', 'stat');
    var $tcolumn_search = array('id', 'account');
    var $torder = array('id' => 'asc');
    var $eid = '';

    private function _get_datatables_query()
    {

        $this->db->from('transactions');

        $this->db->where('eid', $this->eid);


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($eid)
    {
        $this->eid = $eid;
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('transactions');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('transactions');
        $this->db->where('eid', $this->eid);
        return $this->db->count_all_results();
    }


    public function add_employee($id, $username, $name, $roleid, $phone, $address, $city, $region, $country, $postbox)
    {
        $data = array(
            'id' => $id,
            'username' => $username,
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox,
            'phone' => $phone
        );


        if ($this->db->insert('employee_profile', $data)) {
            $data1 = array(
                'roleid' => $roleid
            );

            $this->db->set($data1);
            $this->db->where('id', $id);

            $this->db->update('aauth_users');
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function employee_validate($email)
    {
        $this->db->select('*');
        $this->db->from('aauth_users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function money_details($eid)
    {
        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('transactions');
        $this->db->where('eid', $eid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sales_details($eid)
    {
        $this->db->select('SUM(pamnt) AS total');
        $this->db->from('invoices');
        $this->db->where('eid', $eid);
        $query = $this->db->get();
        return $query->row_array();
    }


}