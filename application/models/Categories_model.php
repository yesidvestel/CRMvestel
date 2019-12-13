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

class Categories_model extends CI_Model
{


    public function category_list()
    {
        $query = $this->db->query("SELECT id,title
FROM product_cat

ORDER BY id DESC");
        return $query->result_array();
    }

    public function warehouse_list()
    {
        $query = $this->db->query("SELECT id,title
FROM product_warehouse

ORDER BY id DESC");
        return $query->result_array();
    }

    public function category_stock()
    {
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM product_cat AS c LEFT JOIN ( SELECT pcat,COUNT(pid) AS pc,SUM(product_price*qty) AS salessum, SUM(fproduct_price*qty) AS worthsum,SUM(qty) AS qty FROM products GROUP BY pcat ) AS p ON c.id=p.pcat");
        return $query->result_array();
    }

    public function warehouse()
    {
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM product_warehouse AS c LEFT JOIN ( SELECT warehouse,COUNT(pid) AS pc,SUM(product_price*qty) AS salessum, SUM(fproduct_price*qty) AS worthsum,SUM(qty) AS qty FROM products GROUP BY warehouse ) AS p ON c.id=p.warehouse");
        return $query->result_array();
    }

    public function cat_ware($id)
    {
        $query = $this->db->query("SELECT c.id AS cid, w.id AS wid,c.title AS catt,w.title AS watt FROM products AS p LEFT JOIN product_cat AS c ON p.pcat=c.id LEFT JOIN product_warehouse AS w ON p.warehouse=w.id WHERE
p.pid='$id' ");
        return $query->row_array();
    }

    public function addnew($cat_name, $cat_desc)
    {
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc
        );

        if ($this->db->insert('product_cat', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function addwarehouse($cat_name, $cat_desc)
    {
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc
        );

        if ($this->db->insert('product_warehouse', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function edit($catid, $product_cat_name, $product_cat_desc)
    {
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc
        );


        $this->db->set($data);
        $this->db->where('id', $catid);

        if ($this->db->update('product_cat')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editwarehouse($catid, $product_cat_name, $product_cat_desc)
    {
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc
        );


        $this->db->set($data);
        $this->db->where('id', $catid);

        if ($this->db->update('product_warehouse')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


}