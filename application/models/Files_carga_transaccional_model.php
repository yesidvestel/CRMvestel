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

class Files_carga_transaccional_model extends CI_Model
{
    var $table="files_carga_transaccional";
    var $column_order = array("id","nombre","fecha","id_usuario","estado");
    var $column_search = array("nombre","fecha","id_usuario","estado");
    
    private function _get_datatables_query()
    {
        $this->db->select("fl1.id as id,fl1.nombre_real_file as nombre_real_file,fl1.nombre as nombre,fl1.fecha as fecha,fl1.estado as estado,us.username as username");
        $this->db->from($this->table." as fl1");
        $this->db->join("aauth_users as us","us.id=fl1.id_usuario");
        
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
        $this->db->order_by("fecha","desc");
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
    public function facturar_customer(){
        set_time_limit(150);
        ini_set ( 'max_execution_time', 150);
        ini_set ( 'max_execution_time', 150);
        //$creo=$this->facturas_electronicas->generar_factura_customer_para_multiple($datos,$_SESSION['api_siigo']);
                        $creo=array("status"=>true);
                        //sleep(7);
        if($creo['status']==true){
                return  true;                        
        }else{
            $_SESSION['errores'][]=array("id"=>$value['id'],"error"=>$creo['respuesta']);                            
            return false;
        }
    }
    public function recorrer_archivo_y_guardar_datos_inicial($id_file,$ruta){
            $this->load->library('ExcelReaderDuber');
            $reader= new ExcelReaderDuber();
            $reader=$reader->get_reader();
            $reader->setReadDataOnly(true);
            $spreadsheet=$reader->load($ruta);
            $sheet=$spreadsheet->getActiveSheet(0);
            echo "<table>";
            $string_inserts="";
            foreach ($sheet->getRowIterator() as $key => $row) {
                    $cellIterator=$row->getCellIterator("d","f");
                    $cellIterator->setIterateOnlyExistingCells(false);
                    echo "<tr><td>".$key."</td>";
                    if($key>1){
                        $valido=true;
                        foreach ($cellIterator as $key2 => $cell) {
                            if(!is_null($cell)){
                                $value=$cell->getValue();
                                echo "<td>".$value."</td>";
                            }
                        }
                    }
                    echo "</tr>";
            }
            echo "<table>";

    }
    
}