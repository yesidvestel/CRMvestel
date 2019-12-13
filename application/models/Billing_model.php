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

class Billing_model extends CI_Model
{

    public function paynow($tid, $amount, $note, $pmethod)
    {


        $this->db->select('accounts.id,accounts.holder,');
        $this->db->from('online_payment');

        $this->db->join('accounts', 'online_payment.default_acid = accounts.id', 'left');

        $query = $this->db->get();
        $account = $query->row_array();

        $this->db->select('invoices.*,customers.name,customers.id AS cid');
        $this->db->from('invoices');
        $this->db->where('invoices.tid', $tid);
        $this->db->join('customers', 'invoices.csd = customers.id', 'left');

        $query = $this->db->get();
        $invoice = $query->row_array();

        // print_r($invoice);


        $data = array(
            'acid' => $account['id'],
            'account' => $account['holder'],
            'type' => 'Income',
            'cat' => 'Sales',
            'credit' => $amount,
            'payer' => $invoice['name'],
            'payerid' => $invoice['csd'],
            'method' => $pmethod,
            'date' => date('Y-m-d'),
            'eid' => $invoice['eid'],
            'tid' => $tid,
            'note' => $note
        );
        $this->db->trans_start();
        $this->db->insert('transactions', $data);
        $this->db->insert_id();


        $totalrm = $invoice['total'] - $invoice['pamnt'];

        if ($totalrm > $amount) {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);

            $this->db->set('status', 'partial');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');


            //account update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $account['id']);
            $this->db->update('accounts');

        } else {
            $this->db->set('pmethod', $pmethod);
            $this->db->set('pamnt', "pamnt+$amount", FALSE);
            $this->db->set('status', 'paid');
            $this->db->where('tid', $tid);
            $this->db->update('invoices');
            //acount update
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $account['id']);
            $this->db->update('accounts');

        }
        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }

    public function gateway($id)
    {

        $this->db->from('payment_gateways');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function gateway_list($enable = '')
    {

        $this->db->from('payment_gateways');
        if ($enable == 'Yes') {
            $this->db->where('enable', 'Yes');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function bank_accounts($enable = '')
    {

        $this->db->from('bank_accounts');
        if ($enable == 'Yes') {
            $this->db->where('enable', 'Yes');
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function bank_account_info($id)
    {

        $this->db->from('bank_accounts');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function gateway_update($gid, $currency, $key1, $key2, $enable, $devmode, $p_fee)
    {
        $data = array(
            'key1' => $key1,
            'key2' => $key2,
            'enable' => $enable,
            'dev_mode' => $devmode,
            'currency' => $currency,
            'surcharge' => $p_fee
        );


        $this->db->set($data);
        $this->db->where('id', $gid);

        if ($this->db->update('payment_gateways')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function online_pay_settings()
    {

        $this->db->select('online_payment.*,accounts.*');
        $this->db->from('online_payment');

        $this->db->join('accounts', 'online_payment.default_acid = accounts.id', 'left');

        $query = $this->db->get();
        return $query->row_array();
    }


    public function payment_settings($id, $enable, $bank)
    {
        $data = array(
            'default_acid' => $id,
            'enable' => $enable,
            'bank' => $bank
        );


        $this->db->set($data);
        $this->db->where('id', 1);

        if ($this->db->update('online_payment')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function bank_ac_add($name, $acn, $code, $enable, $bank, $branch, $address)
    {
        $data = array(
            'name' => $name,
            'acn' => $acn,
            'code' => $code,
            'enable' => $enable,
            'note' => $bank,
            'branch' => $branch,
            'address' => $address,
        );


        if ($this->db->insert('bank_accounts', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function bank_ac_update($gid, $name, $acn, $code, $enable, $bank, $branch, $address)
    {
        $data = array(
            'name' => $name,
            'acn' => $acn,
            'code' => $code,
            'enable' => $enable,
            'note' => $bank,
            'branch' => $branch,
            'address' => $address,
        );


        $this->db->set($data);
        $this->db->where('id', $gid);

        if ($this->db->update('bank_accounts')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function add_currency($code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep)
    {
        $data = array(
            'code' => $code,
            'symbol' => $symbol,
            'rate' => $rate,
            'thous' => $thous_sep,
            'dpoint' => $deci_sep,
            'decim' => $decimal,
            'cpos' => $spos
        );


        if ($this->db->insert('currencies', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit_currency($gid, $code, $symbol, $spos, $rate, $decimal, $thous_sep, $deci_sep)
    {
        $data = array(
            'code' => $code,
            'symbol' => $symbol,
            'rate' => $rate,
            'thous' => $thous_sep,
            'dpoint' => $deci_sep,
            'decim' => $decimal,
            'cpos' => $spos
        );
        $this->db->set($data);
        $this->db->where('id', $gid);
        if ($this->db->update('currencies')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function exchange($currency, $key1, $key2, $enable)
    {
        $data = array(
            'key1' => $key1,
            'key2' => $key2,
            'url' => $currency,
            'active' => $enable
        );

        $this->db->set($data);
        $this->db->where('id', 5);

        if ($this->db->update('univarsal_api')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function recharge_done($id, $amount)
    {

        $this->db->set('balance', "balance+$amount", FALSE);
        $this->db->where('id', $id);

        $this->db->update('customers');

        $data = array(
            'type' => 21,
            'rid' => $id,
            'col1' => $amount,
            'col2' => date('Y-m-d H:i:s').' Account Recharge'
        );


        if ($this->db->insert('meta_data', $data)) {
           return true;
        } else {
           return false;
        }

    }

      public function token($in=0,$type=1)
    {
        if($type==1){
             $data = array(
            'type' => 71,
            'rid' => $in,
            'col1' => 1,
            'col2' => 2
        );
        $this->db->insert('meta_data', $data);
        return true;
        }elseif($type==2){
            $this->db->from('meta_data');
            $this->db->where('type', 71);
            $this->db->where('rid', $in);
           $query = $this->db->get();
           return $query->row_array();
        }else{
              $this->db->delete('meta_data', array('type' => 71,'rid'=> $in));
        }
    }




}