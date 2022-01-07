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

class Templates_model extends CI_Model
{


    /*Read the data from DB */
    public function get_template()
    {   //$where = "id BETWEEN $start AND $end";
        $this->db->from('univarsal_api');
        $this->db->where('key1','SMS');
        $query = $this->db->get();
        return $query->result_array();
    }
	public function get_barrios()
    {   //$where = "id BETWEEN $start AND $end";
		$this->db->select('*');
        $this->db->from('barrio');
		$this->db->join('departamentos', 'barrio.idDepartamento = departamentos.idDepartamento', 'left');
		$this->db->join('ciudad', 'barrio.idCiudad = ciudad.idCiudad', 'left');
		$this->db->join('localidad', 'barrio.idLocalidad = localidad.idLocalidad', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function template_info($id)
    {
        $this->db->from('univarsal_api');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function barrio_info($id)
    {
		$this->db->select('*');
        $this->db->from('barrio');
		$this->db->join('departamentos', 'barrio.idDepartamento = departamentos.idDepartamento', 'left');
		$this->db->join('ciudad', 'barrio.idCiudad = ciudad.idCiudad', 'left');
		$this->db->join('localidad', 'barrio.idLocalidad = localidad.idLocalidad', 'left');
        $this->db->where('idBarrio',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function delete($id)
    {

        return $this->db->delete('barrio', array('idBarrio' => $id));
    }
	public function input($name, $body)
    {
        $data = array(
			'name' => $name,
            'key1' => 'SMS',
            'other' => $body
        );

        $this->db->set($data);

        if ($this->db->insert('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function input_barrio($depar,$ciudad,$localidad,$barrio)
    {
        $data = array(
			'idDepartamento' => $depar,
            'idCiudad' => $ciudad,
            'idLocalidad' => $localidad,
            'barrio' => $barrio
        );

        $this->db->set($data);

        if ($this->db->insert('barrio')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function edit_barrio($id,$depar,$ciudad,$localidad,$barrio)
    {
        $data = array(
            'idDepartamento' => $depar,
            'idCiudad' => $ciudad,
            'idLocalidad' => $localidad,
            'barrio' => $barrio,
        );

        $this->db->set($data);
        $this->db->where('idBarrio', $id);

        if ($this->db->update('barrio')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function input_local($depar,$ciudad,$localidad)
    {
        $data = array(
			'idDepartamento' => $depar,
            'idCiudad' => $ciudad,
            'localidad' => $localidad
        );

        $this->db->set($data);

        if ($this->db->insert('localidad')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function input_ciudad($depar,$ciudad)
    {
        $data = array(
			'idDepartamento' => $depar,
            'ciudad' => $ciudad
        );

        $this->db->set($data);

        if ($this->db->insert('ciudad')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
	public function input_depar($depar)
    {
        $data = array(
			'departamento' => $depar
        );

        $this->db->set($data);

        if ($this->db->insert('departamentos')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }
    public function edit($id, $subect, $body)
    {
        $data = array(
            'key1' => $subect,
            'other' => $body
        );

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }


}