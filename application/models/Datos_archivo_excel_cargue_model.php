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

class Datos_archivo_excel_cargue_model extends CI_Model
{
    var $table="datos_archivo_excel_cargue";
    var $column_order = array("id","documento","monto","estado","ref_efecty");
    var $column_search =array("id","documento","monto","estado","ref_efecty","name","unoapellido");
    
    private function _get_datatables_query()
    {
       
        
        
        if(isset($_GET['tipo_consulta']) && $_GET['tipo_consulta']=="Errores"){
            $this->db->select("*");
             $this->db->from($this->table);
            $this->db->where('estado!=','Cargado' );
        }else{
             $this->db->select("fl1.id as id,cs.id as idc,cs.documento as documento, fl1.monto as monto, fl1.estado as estado,fl1.ref_efecty as ref_efecty,cs.name as name,cs.unoapellido as unoapellido");
            $this->db->from($this->table." as fl1");
            $this->db->join("customers as cs","cs.id=fl1.id_customer");
            $this->db->where('estado','Cargado' );    
        }
        $this->db->where('id_archivo',$_GET['id'] );
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