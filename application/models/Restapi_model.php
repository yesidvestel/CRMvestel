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


class Restapi_model extends CI_Model
{
    var $table = 'accounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function keylist()
    {
        $this->db->select('*');
        $this->db->from('api_keys');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function addnew()
    {

        $random = substr(md5(mt_rand()), 0, 24);
        $data = array(
            'user_id' => 0,
            'key' => $random,
            'level' => 0,
            'date_created' => date('Y-m-d')


        );

        if ($this->db->insert('api_keys', $data)) {
            return true;
        } else {
            return false;

        }

    }


}