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

class Historial_model extends CI_Model
{
    var $table="historial_crm";
    var $column_order = array("id","fecha","modulo","accion",null,"id_usuario");
    var $column_search = array("id","fecha","modulo","accion","tabla","id_fila");
    
    private function _get_datatables_query($mod)
    {

        $this->db->from($this->table);
		if($mod!=""){
			$this->db->where('modulo',$mod);
			if($_GET['filtro_fecha']!='' && $_GET['filtro_fecha']!='undefined'){
				if($_GET['filtro_fecha']=='fcreada'){
				$fecha_incial= new DateTime($_GET['sdate']);
				$fecha_final= new DateTime($_GET['edate']);
				$condicion1='fecha >="'. $fecha_incial->format("Y-m-d 00:00:00").'" AND fecha <="'. $fecha_final->format("Y-m-d 23:59:59").'"';
				$this->db->where($condicion1); 
				}
			}
		}

        
        $i=0;
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
    function get_datatables($mod)
    {
        $this->_get_datatables_query($mod);
        $this->db->order_by("id","desc");
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered($mod)
    {
        $this->_get_datatables_query($mod);
		if ($mod != '') {
            $this->db->where('modulo', $mod);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all($mod)
    {
        $this->_get_datatables_query($mod);
		if ($mod != '') {
            $this->db->where('modulo', $mod);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
}