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


class Plugins_model extends CI_Model
{


    public function recaptcha($captcha, $public_key, $private_key)
    {
        $data = array(
            'recaptcha_p' => $public_key,
            'captcha' => $captcha,
            'recaptcha_s' => $private_key
        );

        $this->db->set($data);
        $this->db->where('id', 1);

        if ($this->db->update('conf', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function config_general()
    {
        $this->db->select('*');
        $this->db->from('conf');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function universal_api($id)
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_api($id, $key1, $key2, $enable, $url = '', $other = '')
    {
        $data = array(
            'key1' => $key1,
            'key2' => $key2,
            'url' => $url,
            'active' => $enable,
            'other' => $other
        );

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('univarsal_api', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


}