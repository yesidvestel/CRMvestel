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
        $sql = "SELECT * FROM events  WHERE rol='$tec' OR $us>=4 AND events.start BETWEEN ? AND ? ORDER BY events.start  ASC ";
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
			'rol' => $rol
        );

        if ($this->db->insert('events', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /*Update  event */

    public function updateEvent($id, $idorden, $title, $description, $color, $rol)
    {

        $sql = "UPDATE events SET idorden = ?, title = ?, description = ?, color = ?, rol = ? WHERE id = ?";
        $this->db->query($sql, array($idorden, $title, $description, $color, $rol, $id));
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