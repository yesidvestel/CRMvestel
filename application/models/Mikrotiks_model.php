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

class Mikrotiks_model extends CI_Model
{
    var $table="mikrotiks";
    var $column_order = array("id","nombre","ip","puerto","tegnologia","sede","usuario","password");
    var $column_search = array("mk1.id","mk1.nombre","mk1.ip","mk1.puerto","mk1.tegnologia","mk1.sede","mk1.usuario","mk1.password","cg.title");
    
    private function _get_datatables_query()
    {
         if($_SESSION[md5("variable_datos_pin")]['db_name']=="admin_crmvestel"){
            $this->db->select("mk1.id as id ,mk1.nombre as nombre,mk1.ip as ip,mk1.puerto as puerto,mk1.tegnologia as tegnologia,mk1.sede as sede,mk1.usuario as usuario,mk1.password as password,cg.ciudad as title, mk1.defecto as defecto,mk1.estado_coneccion as estado");
         }else{
            $this->db->select("mk1.id as id ,mk1.nombre as nombre,mk1.ip as ip,mk1.puerto as puerto,mk1.tegnologia as tegnologia,mk1.sede as sede,mk1.usuario as usuario,mk1.password as password,cg.title as title, mk1.defecto as defecto,mk1.estado_coneccion as estado");    
         }
        
        $this->db->from($this->table." as mk1");
          if($_SESSION[md5("variable_datos_pin")]['db_name']=="admin_crmvestel"){
            $this->db->join("ciudad as cg","cg.idCiudad=mk1.sede");
          }else{
            $this->db->join("customers_group as cg","cg.id=mk1.sede");    
          }
        
        if($this->input->post('search')['value']!=""){
            $this->db->where("(''");    
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
        $this->db->order_by("sede","desc");
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
      public function get_estado_mikrotik($id_mk,$API){
        
        set_time_limit(500);
        
        
        $datos_mkt=$this->db->get_where("mikrotiks",array("id"=>$id_mk))->row();
        if ($API->connect($datos_mkt->ip.":".$datos_mkt->puerto, $datos_mkt->usuario, $datos_mkt->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall");
         $API->disconnect();
         
            return $arrID[0]['disabled'];    
         
         

        }else{
            
        }
    }
    
}