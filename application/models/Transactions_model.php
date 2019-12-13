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

class Transactions_model extends CI_Model
{
    var $table = 'transactions';
    var $column_order = array('date', 'acid', 'debit', 'credit', 'payer', 'method');
    var $column_search = array('id', 'account', 'payer');
    var $order = array('id' => 'desc');
    var $opt = '';

    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;
        }
        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($opt = 'all')
    {
        $this->opt = $opt;
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('transactions');
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;

        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
                break;
            case 'expense':
                $this->db->where('type', 'Expense');
                break;

        }
        return $this->db->count_all_results();
    }

    public function categories()
    {
        $this->db->select('*');
        $this->db->from('transactions_cat');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function acc_list()
    {
        $this->db->select('id,acn,holder');
        $this->db->from('accounts');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function addcat($name)
    {
        $data = array(
            'name' => $name
        );

        return $this->db->insert('transactions_cat', $data);
    }

    public function addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $eid)
    {

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('accounts');
            $this->db->where('id', $pay_acc);
            $query = $this->db->get();
            $account = $query->row_array();


            $data = array(
                'payerid' => $payer_id,
                'payer' => $payer_name,
                'acid' => $pay_acc,
                'account' => $account['holder'],
                'date' => $date,
                'debit' => $debit,
                'credit' => $credit,
                'type' => $pay_type,
                'cat' => $pay_cat,
                'method' => $paymethod,
                'eid' => $eid,
                'note' => $note
            );
            $amount = $credit - $debit;
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $pay_acc);
            $this->db->update('accounts');

            return $this->db->insert('transactions', $data);
        }
    }

    public function addtransfer($pay_acc, $pay_acc2, $amount, $eid)
    {

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('accounts');
            $this->db->where('id', $pay_acc);
            $query = $this->db->get();
            $account = $query->row_array();
            $this->db->select('holder');
            $this->db->from('accounts');
            $this->db->where('id', $pay_acc2);
            $query = $this->db->get();
            $account2 = $query->row_array();


            $data = array(
                'payerid' => '',
                'payer' => '',
                'acid' => $pay_acc2,
                'account' => $account2['holder'],
                'date' => date('Y-m-d'),
                'debit' => 0,
                'credit' => $amount,
                'type' => 'Transfer',
                'cat' => '',
                'method' => '',
                'eid' => $eid,
                'note' => 'Transferred by ' . $account['holder'],
                'ext'=>9
            );
            $this->db->insert('transactions', $data);


            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $pay_acc2);
            $this->db->update('accounts');
            $datec = date('Y-m-d');

            $data = array(
                'payerid' => '',
                'payer' => '',
                'acid' => $pay_acc,
                'account' => $account['holder'],
                'date' => $datec,
                'debit' => $amount,
                'credit' => 0,
                'type' => 'Transfer',
                'cat' => '',
                'method' => '',
                'eid' => $eid,
                'note' => 'Transferred to ' . $account['holder'],
                'ext'=>9
            );

            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $pay_acc);
            $this->db->update('accounts');

            return $this->db->insert('transactions', $data);
        }
    }


    public function delt($id)
    {
        $this->db->select('acid,credit,debit,tid,ext');
        $this->db->from('transactions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $trans = $query->row_array();
        $amt = $trans['credit'] - $trans['debit'];
        $this->db->set('lastbal', "lastbal-$amt", FALSE);
        $this->db->where('id', $trans['acid']);
        $this->db->update('accounts');
echo $trans['tid'];
if($trans['tid']>0) {
    switch ($trans['ext']) {
        case 0 :

            $this->db->set('pamnt', "pamnt-$amt", FALSE);
            $this->db->where('tid', $trans['tid']);
            $this->db->update('invoices');
            break;

        case 1 :
            $this->db->set('pamnt', "pamnt-$amt", FALSE);
            $this->db->where('tid', $trans['tid']);
            $this->db->update('purchase');
            break;

    }
}

        $this->db->delete('transactions', array('id' => $id));
        return array('status' => 'Success', 'message' => $this->lang->line('DELETED'));


    }

    public function view($id)
    {
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function cview($id,$ext=0)
    {

		$this->db->select('*');
        if($ext==1){
 $this->db->from('supplier');
		}else{


		
        $this->db->from('customers');
		}
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();

		
    }

    public function cat_details($id)
    {

        $this->db->select('*');
        $this->db->from('transactions_cat');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function cat_update($id, $cat_name)
    {

        $data = array(
            'name' => $cat_name

        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('transactions_cat')) {
            return true;
        } else {
            return false;
        }
    }

    public function check_balance($id)
    {
        $this->db->select('balance');
        $this->db->from('customers');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


}