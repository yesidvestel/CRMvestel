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


class Accounts_model extends CI_Model
{
    var $table = 'accounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function accountslist()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function details($acid)
    {

        $this->db->select('*');
        $this->db->from('accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function addnew($accno, $holder, $intbal, $acode)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'lastbal' => $intbal,
            'code' => $acode
        );

        if ($this->db->insert('accounts', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($acid, $accno, $holder, $acode)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
            'code' => $acode
        );


        $this->db->set($data);
        $this->db->where('id', $acid);

        if ($this->db->update('accounts')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function account_stats()
    {

        $query = $this->db->query("SELECT SUM(lastbal) AS balance,COUNT(id) AS count_a FROM accounts");


        echo json_encode($query->result_array());

    }

}