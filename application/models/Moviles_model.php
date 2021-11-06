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

class Moviles_model extends CI_Model
{
	var $column_order2 = array("#",'moviles.id_movil','moviles.nombre', 'employee_profile.name', 'moviles.fecha_creacion', 'moviles.fecha_edicion','moviles.estado');
    var $column_search2 = array("#",'moviles.id_movil','moviles.nombre', 'employee_profile.name', 'moviles.fecha_creacion', 'moviles.fecha_edicion','moviles.estado');
    var $order2 = array('moviles.id_movil' => 'DESC');
    var $table="moviles";
private function _get_datatables_query2()
    {

        
        $this->db->select('moviles.*,employee_profile.name');
        $this->db->from("moviles");
        //$this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $this->db->join("employee_profile","employee_profile.id = moviles.id_usuario_crea","left");
    $this->db->where("moviles.estado!=","Temporal");

        
        $i = 0;
        foreach ($this->column_search2 as $item) // loop column
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

                if (count($this->column_search2) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order2)) {
            $order = $this->order2;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables1()
    {
        $this->_get_datatables_query2();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered2()
    {
        $this->_get_datatables_query2();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all2()
    {
        $this->_get_datatables_query2();
        $query = $this->db->get();      
        return $query->num_rows();
    }
}
 ?>