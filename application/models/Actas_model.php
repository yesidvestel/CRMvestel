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

class Actas_model extends CI_Model
{
    var $table="acta_transferencias";
    var $column_order = array("id","fecha","almacen_origen","almacen_destino","username");
    var $column_search = array("tr1.id","tr1.fecha","alm_o.title","alm_d.title","emp1.username");
    
    private function _get_datatables_query()
    {
        $this->db->select("tr1.id as id,tr1.fecha as fecha,alm_o.title as almacen_origen,alm_d.title as almacen_destino,emp1.username as username");
        $this->db->from($this->table." as tr1");
        $i=0;
        $this->db->join("aauth_users as emp1","emp1.id=tr1.id_usuario_que_transfiere");
        $this->db->join("product_warehouse as alm_o","alm_o.id=tr1.almacen_origen");
        $this->db->join("product_warehouse as alm_d","alm_d.id=tr1.almacen_destino");
        if($this->aauth->get_user()->roleid<=2){
            $this->db->where("alm_d.id_tecnico='".$this->aauth->get_user()->username."'");
        }
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
    function get_datatables()
    {
        $this->_get_datatables_query();
        $this->db->order_by("id","desc");
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
		
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
		
        $query = $this->db->get();
        return $query->num_rows();
    }
}