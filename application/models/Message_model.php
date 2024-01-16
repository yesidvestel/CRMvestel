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

class Message_model extends CI_Model
{


    public function employee_details($send,$receiber)
    {

        $this->db->select('employee_profile.*,aauth_pms.*');
        $this->db->from('employee_profile')
			->group_start()
				->where('aauth_pms.sender_id', $send)
				->where('aauth_pms.receiver_id', $receiber)
				->or_group_start()
					->where('aauth_pms.sender_id', $receiber)
					->where('aauth_pms.receiver_id', $send)
				->group_end()
			->group_end();
        $this->db->join('aauth_pms', 'employee_profile.id = aauth_pms.sender_id', 'left');
		$this->db->order_by("aauth_pms.date_sent","desc");
        $query = $this->db->get();
        return $query->result_array();
    }


}