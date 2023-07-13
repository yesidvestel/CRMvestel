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
	var $opt = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function accountslist($opts)
    {
		$this->opt = $opts;
        if(isset($_GET['clcs'])){
            $cs1=$this->db->get_where("customers",array("id"=>$_GET['clcs']))->row();
             $this->db->select('*');
            $this->db->from($this->table);
            $sedeacc = str_replace("-","", $cs1->gid);
            /*if ($sedeacc != '0'){
                $this->db->where('id', $asignacion->tipo);
                $this->db->or_where('sede', '0');
            }*/
            $query = $this->db->get();
            return $query->result_array();
        }else{
    		$sedeacc = $this->aauth->get_user()->sede_accede;
    		$user = $this->aauth->get_user()->id;
    		$asignacion = $this->db->get_where('asignaciones', array('detalle' => 'caja','colaborador'=>$user))->row();		
            $this->db->select('*');
            $this->db->from($this->table);
            $sedeacc = str_replace("-","", $sedeacc);
			switch ($this->opt) {
            case 'asig':
                //if ($sedeacc != '0'){
    			$this->db->where('id', $asignacion->tipo);
    			//$this->db->or_where('sede', '0');
    			//}
                //$this->db->where('warehouse', 1);
                break;
            case 'banco':
                $this->db->where('sede', '0');
                //$this->db->where('warehouse', 1);
                break;
			
        }
    		
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    public function details($acid)
    {

        $this->db->select('*');
        $this->db->from('accounts');
        $this->db->where('id', $acid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function addnew($accno, $holder, $sede, $intbal, $acode)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
			'sede' => $sede,
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

    public function edit($acid, $accno, $holder, $sede, $acode)
    {
        $data = array(
            'acn' => $accno,
            'holder' => $holder,
			'sede' => $sede,
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