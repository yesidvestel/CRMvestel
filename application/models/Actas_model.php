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
    var $column_order = array("id","fecha","almacen_origen","almacen_destino","username","estado");
    var $column_search = array("tr1.id","tr1.fecha","alm_o.title","alm_d.title","emp1.username","tr1.estado");
    
    private function _get_datatables_query()
    {
        $this->db->select("tr1.id as id,tr1.fecha as fecha,alm_o.title as almacen_origen,alm_d.title as almacen_destino,emp1.username as username,tr1.estado as estado");
        $this->db->from($this->table." as tr1");
        $i=0;
        $this->db->join("aauth_users as emp1","emp1.id=tr1.id_usuario_que_transfiere");
        $this->db->join("product_warehouse as alm_o","alm_o.id=tr1.almacen_origen");
        $this->db->join("product_warehouse as alm_d","alm_d.id=tr1.almacen_destino");
        if($this->aauth->get_user()->roleid<=2){
            $this->db->where("alm_d.id_tecnico='".$this->aauth->get_user()->username."'");
        }else if(isset($_GET['tecnico'])){

            $this->db->where("tr1.fecha>='".(new DateTime ($_GET['sdate']))->format("Y-m-d 00:00:01")."'");
            $this->db->where("tr1.fecha<='".(new DateTime ($_GET['edate']))->format("Y-m-d 23:59:59")."'");
            $this->db->where("alm_d.id_tecnico='".$_GET['tecnico']."'");
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
    public function get_items_report(){
        $fecha_inicial=(new DateTime($_POST['sdate']))->format("Y-m-d 00:00:01");
        $fecha_final=(new DateTime($_POST['edate']))->format("Y-m-d 23:59:59");
        $tecnico=$_POST['tecnico'];
        return $this->db->query('SELECT sum(items.cantidad) as cant_transferida,(select sum(tpo.cantidad) as c1 from transferencia_products_orden as tpo where tpo.products_pid=tr1.producto_b and tpo.fecha >="'.$fecha_inicial.'" and tpo.fecha <="'.$fecha_final.'")as cantidad_gastada, tr1.producto_b as pid,pr1.product_name as name FROM `items_acta_transferencias` as items inner join acta_transferencias as act1 on items.id_acta_transferencia=act1.id inner join transferencias as tr1 on tr1.id_transferencia=items.id_transferencia inner join products as pr1 on pr1.pid=tr1.producto_b inner join product_warehouse as alm_d on alm_d.id=act1.almacen_destino where alm_d.id_tecnico="'.$tecnico.'" and act1.fecha>="'.$fecha_inicial.'" and act1.fecha<="'.$fecha_final.'"  GROUP by tr1.producto_b;')->result_array();

    }
}