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


if (!defined('BASEPATH')) exit('No direct script access allowed');


function dateformat($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat'));
    return $date;
}
function dateformat_time($input)
{
    $ci =& get_instance();
    $date = new DateTime($input);
    $date = $date->format($ci->config->item('dformat').' H:i:s');
    return $date;
}
function datefordatabase($input)
{
    $date = new DateTime($input);
    $date = $date->format('Y-m-d H:i:s');
    return $date;
}

function user_role($id = 5)
{  $ci =& get_instance();
    switch ($id) {
        case 5:
            return $ci->lang->line('super user');
            break;
        case 4:
            return $ci->lang->line('administracion');
            break;
        case 3:
            return $ci->lang->line('cash and sales');
            break;
        case 2:
            return $ci->lang->line('technicians');
            break;
        case 1:
            return $ci->lang->line('Inventory Manager');
            break;
        case -1:
            return $ci->lang->line('Project Manager');
            break;
    }
}

function amountFormat($number)
{
    $ci =& get_instance();
    $ci->load->database();
    $query = $ci->db->query("SELECT currency FROM app_system WHERE id=1 LIMIT 1");
    $row = $query->row_array();
    $currency = $row['currency'];
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    if ($row['method'] == 'l') {
        return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
    } else {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
    }
}

function prefix($number)
{
    $ci =& get_instance();
    $ci->load->database();
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=51 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
  switch ($number){
      case 1: return $row['name'];
      break;
       case 2: return $row['key1'];
      break;
       case 3: return $row['key2'];
      break;
       case 4: return $row['url'];
      break;
       case 5: return $row['method'];
      break;
        case 6: return $row['other'];
      break;
  }
}

function user_premission($input1, $input2)
{
    if (hash_equals($input1, $input2)) {
        return true;
    } else {
        return false;
    }
}

function active($input1)
{

    $t_file = APPPATH . "/config/lic.php";
    if ($t_file) {
        file_put_contents($t_file, $input1);
        if ($input1 == 0) {
            echo json_encode(array('status' => 'Error', 'message' => 'License error!'));
        } else {
            echo json_encode(array('status' => 'Success', 'message' => 'License updated!'));
        }
    } else {
        echo json_encode(array('status' => 'Error', 'message' => 'Server write premissions denied'));
    }

}

function amountFormat_s($number)
{
    $ci =& get_instance();
    $ci->load->database();
    //get data from database
    $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
    $row = $query2->row_array();
    //Format money as per country
    if ($row['method'] == 'l') {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']);
    } else {
        return @number_format($number, $row['url'], $row['key1'], $row['key2']);
    }
}


function amountExchange($number, $id = 0)
{
    $ci =& get_instance();
    $ci->load->database();
    if ($id > 0) {
        $query = $ci->db->query("SELECT * FROM currencies WHERE id='$id' LIMIT 1");
        $row = $query->row_array();
        $currency = $row['symbol'];
        $rate = $row['rate'];
        $thosand = $row['thous'];
        $dec_point = $row['dpoint'];
        $decimal_after = $row['decim'];
        $totalamount = $rate * $number;
        if ($row['cpos'] == 0) {
            return $currency . ' ' . @number_format($totalamount, $decimal_after, $dec_point, $thosand);
        } else {
            return @number_format($totalamount, $decimal_after, $dec_point, $thosand) . ' ' . $currency;
        }
    } else {
        $query = $ci->db->query("SELECT currency FROM app_system WHERE id=1 LIMIT 1");
        $row = $query->row_array();
        $currency = $row['currency'];
        //get data from database
        $query2 = $ci->db->query("SELECT * FROM univarsal_api WHERE id=4 LIMIT 1");
        $row = $query2->row_array();
        //Format money as per country
        if ($row['method'] == 'l') {
            return $currency . ' ' . @number_format($number, $row['url'], $row['key1'], $row['key2']);
        } else {
            return @number_format($number, $row['url'], $row['key1'], $row['key2']) . ' ' . $currency;
        }
    }

}
function array_compare() {
    $criteriaNames = func_get_args();
    $compare = function($first, $second) use ($criteriaNames) {
        while(!empty($criteriaNames)) {
            $criterion = array_shift($criteriaNames);
            $sortOrder = 1;
            if (is_array($criterion)) {
                $sortOrder = $criterion[1] == SORT_DESC ? -1 : 1;
                $criterion = $criterion[0];
            }
            if ($first[$criterion] < $second[$criterion]) {
                return -1 * $sortOrder;
            }
            else if ($first[$criterion] > $second[$criterion]) {
                return 1 * $sortOrder;
            }
        }
        return 0;
    };
    return $compare;
}
