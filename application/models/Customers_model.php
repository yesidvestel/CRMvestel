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

class Customers_model extends CI_Model
{

    var $table = 'customers';
    var $column_order = array(null, 'name', 'address', 'email', 'phone', null);
    var $column_search = array('name', 'celular', 'documento', 'apellidos', 'email');
    var $trans_column_order = array('date', 'debit', 'credit', 'account', null);
    var $trans_column_search = array('id', 'date');
    var $inv_column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $inv_column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('id' => 'desc');
    var $inv_order = array('invoices.tid' => 'desc');


    private function _get_datatables_query($id = '')
    {

        $this->db->from($this->table);
        if ($id != '') {
            $this->db->where('gid', $id);
        }
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

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function details($custid)
    {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function money_details($custid)
    {

        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('transactions');
        $this->db->where('payerid', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }

        public function due_details($custid)
    {

       $this->db->select('SUM(total) AS total,SUM(pamnt) AS pamnt');
        $this->db->from('invoices');
        $this->db->where('csd', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function add($name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario)
    {
        $data = array(
            'name' => $name,
			'dosnombre' => $dosnombre,
            'unoapellido' => $unoapellido,
			'dosapellido' => $dosapellido,
            'company' => $company,
            'celular' => $celular,
            'celular2' => $celular2,
            'email' => $email,
            'nacimiento' => $nacimiento,
            'tipo_cliente' => $tipo_cliente,
            'tipo_documento' => $tipo_documento,
            'documento' => $documento,
            'departamento' => $departamento,
            'ciudad' => $ciudad,
            'localidad' => $localidad,
            'barrio' => $barrio,
            'nomenclatura' => $nomenclatura,
            'numero1' => $numero1,
            'adicionauno' => $adicionauno,
            'numero2' => $numero2,
            'adicional2' => $adicional2,
			'numero3' => $numero3,
			'residencia' => $residencia,
			'referencia' => $referencia,
			'gid' => $customergroup,
			'name_s' => $name_s,
			'contra' => $contra,
			'servicio' => $servicio,
			'perfil' => $perfil,
			'Iplocal' => $Iplocal,
			'Ipremota' => $Ipremota,
			'comentario' => $comentario,
			
			
        );

        if ($this->db->insert('customers', $data)) {
            $cid = $this->db->insert_id();
            $temp_password = rand(200000, 999999);
            $pass = password_hash($temp_password, PASSWORD_DEFAULT);
            $data = array(
                'user_id' => 1,
                'status' => 'active',
                'is_deleted' => 0,
                'name' => $name,
                'password' => $pass,
                'email' => $email,
                'user_type' => 'Member',
                'cid' => $cid
            );

            $this->db->insert('users', $data);

            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . ' Temporary Password is ' . $temp_password . ' &nbsp;<a href="' . base_url('customers/view?id=' . $cid) . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>' . $this->lang->line('View') . '</a>', 'cid' => $cid, 'pass' => $temp_password));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function edit($id, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario)
    {
        $data = array(
            'name' => $name,
			'dosnombre' => $dosnombre,
            'unoapellido' => $unoapellido,
			'dosapellido' => $dosapellido,
            'company' => $company,
            'celular' => $celular,
            'celular2' => $celular2,
            'email' => $email,
            'nacimiento' => $nacimiento,
            'tipo_cliente' => $tipo_cliente,
            'tipo_documento' => $tipo_documento,
            'documento' => $documento,
            'departamento' => $departamento,
            'ciudad' => $ciudad,
            'localidad' => $localidad,
            'barrio' => $barrio,
            'nomenclatura' => $nomenclatura,
            'numero1' => $numero1,
            'adicionauno' => $adicionauno,
            'numero2' => $numero2,
            'adicional2' => $adicional2,
			'numero3' => $numero3,
			'residencia' => $residencia,
			'referencia' => $referencia,
			'gid' => $customergroup,
			'name_s' => $name_s,
			'contra' => $contra,
			'servicio' => $servicio,
			'perfil' => $perfil,
			'Iplocal' => $Iplocal,
			'Ipremota' => $Ipremota,
			'comentario' => $comentario,
        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('customers')) {
            $data = array(
                'name' => $name,
                'email' => $email
            );
            $this->db->set($data);
            $this->db->where('cid', $id);
            $this->db->update('users');
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function changepassword($id, $password)
    {
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $data = array(
            'password' => $pass

        );


        $this->db->set($data);
        $this->db->where('cid', $id);

        if ($this->db->update('users')) {
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
        $this->db->from($this->table);
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('customers') AND $result['picture']!='example.png') {

            unlink(FCPATH . 'userfiles/customers/' . $result['picture']);
            unlink(FCPATH . 'userfiles/customers/thumbnail/' . $result['picture']);
        }


    }

    public function group_list()
    {
        $query = $this->db->query("SELECT c.*,p.pc FROM customers_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM customers GROUP BY gid) AS p ON p.gid=c.id");
        return $query->result_array();
    }
	
	public function departamentos_list()
    {
        $query = $this->db->query("SELECT idDepartamento,departamento FROM departamentos ");
        return $query->result_array();
		
    }
	public function group_departamentos($id)
    {

        $this->db->from('departamentos');
        $this->db->where('idDepartamento', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function ciudades_list($id)
    { 
		$this->db->select('*');
        $this->db->from('ciudad');
        $this->db->where('idDepartamento', $id);
        $query = $this->db->get();
        return $query->result_array(); 
    }
	public function group_ciudad($id)
    {

        $this->db->from('ciudad');
        $this->db->where('idCiudad', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function localidades_list($id)
    { 
		$this->db->select('*');
        $this->db->from('localidad');
        $this->db->where('idCiudad', $id);
        $query = $this->db->get();
        return $query->result_array(); 
    }
	public function group_localidad($id)
    {

        $this->db->from('localidad');
        $this->db->where('idLocalidad', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function barrios_list($id)
    { 
		$this->db->select('*');
        $this->db->from('barrio');
        $this->db->where('idLocalidad', $id);
        $query = $this->db->get();
        return $query->result_array(); 
    }
	public function group_barrio($id)
    {

        $this->db->from('barrio');
        $this->db->where('idBarrio', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete($id)
    {
        $this->db->delete('users', array('cid' => $id));
        return $this->db->delete('customers', array('id' => $id));
    }


    //transtables

    function trans_table($id)
    {
        $this->_get_trans_table_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    private function _get_trans_table_query($id)
    {

        $this->db->from('transactions');


        $this->db->where('payerid', $id);
        $this->db->where('ext', 0);

        $i = 0;

        foreach ($this->trans_column_search as $item) // loop column
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

                if (count($this->trans_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->trans_column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function trans_count_filtered($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function trans_count_all($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }


    }

    private function _inv_datatables_query($id)
    {

        $this->db->from('invoices');
        $this->db->where('invoices.csd', $id);
        $this->db->join('customers', 'invoices.csd=customers.id', 'left');

        $i = 0;

        foreach ($this->inv_column_search as $item) // loop column
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

                if (count($this->inv_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->inv_order)) {
            $order = $this->inv_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function inv_datatables($id)
    {
        $this->_inv_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function inv_count_filtered($id)
    {
        $this->_inv_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function inv_count_all($id)
    {
        $this->db->from('invoices');
        $this->db->where('csd', $id);
        return $this->db->count_all_results();
    }

    public function group_info($id)
    {

        $this->db->from('customers_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function activity($id)
    {
        $this->db->select('*');
        $this->db->from('meta_data');
        $this->db->where('type', 21);
        $this->db->where('rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recharge($id, $amount)
    {

        $this->db->set('balance', "balance+$amount", FALSE);
        $this->db->where('id', $id);

        $this->db->update('customers');

        $data = array(
            'type' => 21,
            'rid' => $id,
            'col1' => $amount,
            'col2' => date('Y-m-d H:i:s').' Account Recharge by '.$this->aauth->get_user()->username
        );


        if ($this->db->insert('meta_data', $data)) {
            return true;
        } else {
            return false;
        }

    }



}
