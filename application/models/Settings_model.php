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

class Settings_model extends CI_Model
{


    public function company_details($id)
    {

        $this->db->select('*');
        $this->db->from('app_system');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function update_company($id, $name, $phone, $email, $address, $city, $region, $country, $PBX, $postbox, $taxid)
    {
        $data = array(
            'cname' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
			'PBX' => $PBX,
            'postbox' => $postbox,
            'taxid' => $taxid
        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('app_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function update_billing($id, $invoiceprefix, $taxid, $taxstatus, $lang)
    {
        $data = array(
            'taxid' => $taxid,
            'tax' => $taxstatus,
            'prefix' => $invoiceprefix,
            'lang' => $lang

        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('app_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

      public function prefix()
    {

        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 51);
        $query = $this->db->get();
        return $query->row_array();
    }

     public function update_prefix($q_prefix, $p_prefix, $r_prefix, $s_prefix, $t_prefix,$o_prefix)
    {
        $data = array(
            'name' => $q_prefix,
            'key1' => $p_prefix,
            'key2' => $r_prefix,
            'url' => $s_prefix,
            'method' => $t_prefix,
             'other' => $o_prefix
        );


        $this->db->set($data);
        $this->db->where('id', 51);
        $this->db->update('univarsal_api');
    }


    public function update_dtformat($id, $tzone, $dateformat)
    {
        $data = array(
            'dformat' => $dateformat,
            'zone' => $tzone
        );
        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('app_system')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function companylogo($id, $pic)
    {
        $this->db->select('logo');
        $this->db->from('app_system');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'logo' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('app_system')) {

            unlink(FCPATH . 'userfiles/company/' . $result['logo']);
            unlink(FCPATH . 'userfiles/company/thumbnail/' . $result['logo']);
        }


    }

    //email

    public function email_smtp()
    {
        $this->db->select('*');
        $this->db->from('sys_smtp');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_smtp($host, $port, $auth,$auth_type, $username, $password, $sender)
    {
        $data = array(
            'host' => $host,
            'port' => $port,
            'auth' => $auth,
            'auth_type' => $auth_type,
            'username' => $username,
            'password' => $password,
            'sender' => $sender,
        );


        $this->db->set($data);
        $this->db->where('id', 1);


        if ($this->db->update('sys_smtp')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    private function validate_p($var1, $var2)
    {
        $var2 .= '&app=' . base_url();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, SERVICE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=" . $var1 . "&var2=" . $var2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function update_atformat($var1, $var2)
    {

        $output = $this->validate_p($var1, $var2);
        $this->load->driver('cache');
        $this->cache->file->save('cache_validation', $output);
        active($output);

    }

    public function get_terms($id)
    {
        $this->db->select('*');
        $this->db->from('billing_terms');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function billingterms()
    {
        $this->db->select('id,title,type');
        $this->db->from('billing_terms');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function add_term($title,$type, $term)
    {
        $data = array(
            'title' => $title,
            'type' => $type,
            'terms' => $term
        );

        if ($this->db->insert('billing_terms', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit_term($id, $title,$type, $term)
    {
        $data = array(
            'title' => $title,
            'type' => $type,
            'terms' => $term
        );

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('billing_terms', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function edit_terms()
    {

        $this->db->select('id,title');
        $this->db->from('billing_terms');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function theme($tdirection)
    {
        if ($tdirection != LTR) {
            $config_file_path = APPPATH . "config/constants.php";
            $config_file = file_get_contents($config_file_path);
            $config_file = str_replace(LTR, $tdirection, $config_file);
            file_put_contents($config_file_path, $config_file);
        }
        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED')));
    }

    public function currency()
    {
        $this->db->select('app_system.currency,univarsal_api.*');
        $this->db->from('app_system');
        $this->db->where('univarsal_api.id', 4);
        $this->db->where('app_system.id', 1);
        $this->db->join('univarsal_api', 'app_system.id = 1', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_currency($id, $currency, $thous_sep, $deci_sep, $decimal, $method)
    {
        $data = array(
            'currency' => $currency
        );
        $this->db->set($data);
        $this->db->where('id', $id);
        $this->db->update('app_system');

        $data = array(
            'key1' => $deci_sep,
            'key2' => $thous_sep,
            'url' => $decimal,
            'method' => $method
        );
        $this->db->set($data);
        $this->db->where('id', 4);


        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

	public function delete_terms($id)
    {
       $this->db->select('id');
        $this->db->from('billing_terms');
       
        $query = $this->db->get();
        if ($query->num_rows() > 1) {
            return $this->db->delete('billing_terms', array('id' => $id));
        }
		else{
			return false;
		}
       
    }



}