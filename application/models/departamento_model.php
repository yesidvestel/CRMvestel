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

class departamento_model extends CI_Model
{


    public function details($idDepartamento)
    {

        $this->db->select('*');
        $this->db->from('departamentos');
        $this->db->where('idDepartamento', $idDepartamento);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function recipients($id)
    {

        $this->db->select('name,email');
        $this->db->from('customers');
        $this->db->where('gid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function add($departamento)
    {
        $data = array(
            'departamento' => $departamento,
            
        );

        if ($this->db->insert('departamentos', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function editdepartamento($gid, $departamento)
    {
        $data = array(
            'departamento' => $departamento,
        );


        $this->db->set($data);
        $this->db->where('idDepartamento', $gid);

        if ($this->db->update('departamentos')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
}