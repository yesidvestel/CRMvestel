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

class Manager_model extends CI_Model
{

    var $column_order = array('status', 'name', 'duedate', 'tdate', null);
    var $column_search = array('name', 'duedate', 'tdate');
    var $notecolumn_order = array(null, 'title', 'cdate', null);
    var $notecolumn_search = array('id', 'title', 'cdate');
    var $order = array('id' => 'asc');

    private function _task_datatables_query($cday = '')
    {

        $this->db->from('todolist');
        if ($cday) {
            $this->db->where('DATE(duedate)=', $cday);
        }
        $this->db->where('eid', $this->aauth->get_user()->id);


        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
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
        if ($search) {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function task_datatables($cday = '')
    {


        $this->_task_datatables_query($cday);

        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $this->db->where('eid', $this->aauth->get_user()->id);
        $query = $this->db->get();
        return $query->result();
    }

    function task_count_filtered($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('eid', $this->aauth->get_user()->id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function task_count_all($cday = '')
    {
        $this->_task_datatables_query($cday);
        $this->db->where('eid', $this->aauth->get_user()->id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function addtask($name, $status, $priority, $stdate, $tdate, $employee, $content)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'related' => 0, 'priority' => $priority, 'rid' => 0);
        return $this->db->insert('todolist', $data);
    }

    public function edittask($id, $name, $status, $priority, $stdate, $tdate, $employee, $content)
    {

        $data = array('tdate' => date('Y-m-d H:i:s'), 'name' => $name, 'status' => $status, 'start' => $stdate, 'duedate' => $tdate, 'description' => $content, 'eid' => $employee, 'related' => 0, 'priority' => $priority, 'rid' => 0);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('eid', $this->aauth->get_user()->id);
        return $this->db->update('todolist');
        //return $this->db->insert('todolist', $data);
    }

    public function settask($id, $stat)
    {

        $data = array('status' => $stat);
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->where('eid', $this->aauth->get_user()->id);
        if($this->db->update('todolist')){
            if($stat=="Due"){//pendiente
                    $this->db->set('color', '#4CB0CB');
                    $this->db->where('id_tarea', $id);
                    $this->db->update('events');

            }else if($stat=="Progress"){//Realizando
                    $this->db->set('color', '#2DC548');
                    $fecha_final = date("Y-m-d H:i:s");     
                    $this->db->set('start', $fecha_final);
                    $this->db->where('id_tarea', $id);
                    $this->db->update('events');

            }else if($stat=="Done"){//Hecho
                    $fecha_final = date("Y-m-d H:i:s");     
                    $this->db->set('color', '#a3a3a3');
                    $this->db->set('end', $fecha_final);
                    $this->db->where('id_tarea', $id);
                    $this->db->update('events');
            }
            $data_h['modulo']="Tareas";
                $data_h['accion']="Editando evento tarea manager_model linea 144";
                $data_h['id_usuario']=$this->aauth->get_user()->id;
                $data_h['fecha']=date("Y-m-d H:i:s");
                $data_h['descripcion']="";
                $data_h['id_fila']=$id;
                $data_h['tabla']="events";
                $data_h['nombre_columna']="id";
                $this->db->insert("historial_crm",$data_h);
            return true;
        }else{
            return false ;    
        }
        
    }

    public function deletetask($id)
    {

        return $this->db->delete('todolist', array('id' => $id));
    }

    public function viewtask($id)
    {

        $this->db->select('todolist.*,employee_profile.name AS emp, assi.name AS assign');
        $this->db->from('todolist');
        $this->db->where('todolist.id', $id);
        $this->db->join('employee_profile', 'employee_profile.id = todolist.eid', 'left');
        $this->db->join('employee_profile AS assi', 'assi.id = todolist.aid', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function pending_tasks_user($id)
    {
        $this->db->select('*');
        $this->db->from('todolist');
        $this->db->where('status', 'Due');
        $this->db->where('eid', $id);
        $this->db->order_by('DATE(duedate)', 'ASC');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    public function getHistorialTareas($id){
        $historial=$this->db->query("select * from historial_tareas where id_tarea=".$id." order by fecha desc")->result_array();
         
         return $historial;
    }  
    public function guardar($data){
        $data['fecha']=date("Y-m-d H:i:s");
        $data['color']="#0b97f4";//$this->randomColor();
        $this->db->insert("historial_tareas",$data);
    }
    public function p_files($id)
    {

        $this->db->select('*');
        $this->db->from('archivos_historias_tareas');
        $this->db->where('id_tarea', $id);        
        $this->db->order_by("id","desc");
        $query = $this->db->get();
        return $query->result_array();
    }
    public function p_files_historial_tareas($id)
    {

        $this->db->select('*');
        $this->db->from('archivos_historias_tareas');
        $this->db->where('id_historia_tarea', $id); 
        $this->db->order_by("id","desc");       
        $query = $this->db->get();
        return $query->result_array();
    }
    public function save_file($data){
        $this->db->insert("archivos_historias_tareas",$data);
    }
    public function get_tarea($id){

        return $this->db->get_where("todolist",array("id"=>$id))->row();

    }
    function randomColor(){
         $str = "#";
         for($i = 0 ; $i < 6 ; $i++){
         $randNum = rand(0, 15);
         switch ($randNum) {
         case 10: $randNum = "A"; 
         break;
         case 11: $randNum = "B"; 
         break;
         case 12: $randNum = "C"; 
         break;
         case 13: $randNum = "D"; 
         break;
         case 14: $randNum = "E"; 
         break;
         case 15: $randNum = "F"; 
         break; 
         }
         $str .= $randNum;
         }
         return $str;
    }
}