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

class Events_model extends CI_Model
{


    /*Read the data from DB */
    public function getEvents($start, $end)
    {
		$us = $this->aauth->get_user()->roleid;
		$tec = $this->aauth->get_user()->username;
		$idagendor = $this->aauth->get_user()->id;
        if(isset($_POST['tecnico'])){
            $var_tec=$this->db->get_where("aauth_users",array("username"=>$_POST['tecnico']))->row();
            $us=2;
            $idagendor=$var_tec->id;
            $tec=$_POST['tecnico'];
            //var_dump($tec);
        }
        //obener lista de moviles en las que esta el usuario para hacer un where in 
        $emp=$this->db->query("SELECT GROUP_CONCAT(id_movil) as ids FROM `empleados_moviles` WHERE `id_empleado` =".$idagendor)->result_array();
        $in='';
        if(isset($emp[0]['ids']) && $emp[0]['ids']!=null){
            $in="or tickets.asignacion_movil in(".$emp[0]['ids'].")";
            
        }
//        $sql = "SELECT * FROM events inner join tickets on tickets.codigo=events.idorden WHERE rol='$tec' OR $us>=4 OR asigno='$idagendor' ".$in." AND events.start BETWEEN ? AND ? ORDER BY events.start  ASC ";
        $sql = "SELECT title,DATE_FORMAT(start, '%Y-%m-%dT%H:%i:%s') as start ,DATE_FORMAT(end, '%Y-%m-%dT%H:%i:%s') as end,color,events.id as idevent,idorden,description,rol,asigno,tickets.idt as idt,asignacion_movil, color as colorx, id_tarea FROM events left join tickets on tickets.codigo=events.idorden WHERE rol='$tec' ".$in." AND events.start BETWEEN ? AND ? ORDER BY events.start  ASC ";
        
        return $this->db->query($sql, array($start, $end))->result();
		
    }

    /*Create new events */

    public function addEvent($idorden, $title, $start, $end, $description, $color, $rol)
    {
        
        $data = array(
			'idorden' => $idorden,
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'description' => $description,
            'color' => $color,
			'rol' => $rol,
            'asigno'=>$this->aauth->get_user()->id
        );

        if ($this->db->insert('events', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /*Update  event */

    public function updateEvent($id, $idorden,$idtarea, $title, $description, $color, $rol)
    {

        $sql = "UPDATE events SET idorden = ?,id_tarea = ?, title = ?, description = ?, color = ?, rol = ? WHERE id = ?";
        $this->db->query($sql, array($idorden,$idtarea, $title, $description, $color, $rol, $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }


    /*Delete event */

    public function deleteEvent()
    {

        $sql = "DELETE FROM events WHERE id = ?";
        $this->db->query($sql, array($_GET['id']));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    /*Update  event */

    public function dragUpdateEvent()
    {

        $sql = "UPDATE events SET  events.start = ? ,events.end = ?  WHERE id = ?";
        $this->db->query($sql, array($_POST['start'], $_POST['end'], $_POST['id']));
        return ($this->db->affected_rows() != 1) ? false : true;


    }

}