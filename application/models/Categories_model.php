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
	public function supplier_list()
    {
        $query = $this->db->query("SELECT id,name
FROM supplier

ORDER BY id DESC");
        return $query->result_array();
    }
	public function almacen_list()
    {
        $query = $this->db->query("SELECT id,almacen
FROM almacen_equipos

ORDER BY id DESC");
        return $query->result_array();
    }
	public function customers_list()
    {
        $query = $this->db->query("SELECT id,abonado,name
FROM customers

ORDER BY id DESC");
        return $query->result_array();
    }

    public function category_stock()
    {
        $query = $this->db->query("SELECT c.*,p.pc,p.salessum,p.worthsum,p.qty FROM product_cat AS c LEFT JOIN ( SELECT pcat,COUNT(pid) AS pc,SUM(product_price*qty) AS salessum, SUM(fproduct_price*qty) AS worthsum,SUM(qty) AS qty FROM products GROUP BY pcat ) AS p ON c.id=p.pcat");
        return $query->result_array();
    }
	public function almacenquery()
    {
        $query = $this->db->query("SELECT c.*,p.pc FROM almacen_equipos AS c LEFT JOIN ( SELECT almacen,COUNT(id) AS pc FROM equipos GROUP BY almacen) AS p ON c.id=p.almacen");
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
	public function pro_ware($id)
    {
        $query = $this->db->query("SELECT w.id AS wid, w.name AS watt FROM equipos AS e LEFT JOIN supplier AS w ON e.proveedor=w.id WHERE e.id='$id' ");
        return $query->row_array();
    }
	public function alm_ware($id)
    {
        $query = $this->db->query("SELECT w.id AS wid, w.almacen AS watt FROM equipos AS e LEFT JOIN almacen_equipos AS w ON e.almacen=w.id WHERE e.id='$id' ");
        return $query->row_array();
    }
	public function cus_ware($id)
    {
        $query = $this->db->query("SELECT w.id AS wid, w.name AS watt, w.abonado AS abon FROM equipos AS e LEFT JOIN customers AS w ON e.asignado=w.id WHERE e.id='$id' ");
        return $query->row_array();
    }
	

    public function addnew($cat_name, $cat_desc)
    {
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc
        );

        if ($this->db->insert('product_cat', $data)) {
            
            $data_h=array();
            $data_h['modulo']="Inventarios";
            $data_h['accion']="Agregar nueva categoría de producto {insert}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode($data);
            $data_h['id_fila']=$this->db->insert_id();
            $data_h['tabla']="product_cat";
            $this->db->insert("historial_crm",$data_h);

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
	public function addalequipo($cat_name, $cat_desc)
    {
        $data = array(
            'almacen' 		=> $cat_name,
            'descripcion' 	=> $cat_desc
        );

        if ($this->db->insert('almacen_equipos', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function addwarehouse($cat_name, $cat_desc,$tecnico)
    {
        $data = array(
            'title' => $cat_name,
            'extra' => $cat_desc
        );
        if($tecnico!=null || $tecnico!=0){
            $data['id_tecnico']=$tecnico;
        }

        if ($this->db->insert('product_warehouse', $data)) {

            $data_h=array();
            $data_h['modulo']="Inventarios";
            $data_h['accion']="Agregar nuevo almacén de productos {insert}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode($data);
            $data_h['id_fila']=$this->db->insert_id();
            $data_h['tabla']="product_warehouse";
            $this->db->insert("historial_crm",$data_h);
            
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

            $data2=array();
            $data2['modulo']="Inventarios";
            $data2['accion']="Edit Product Category {update}";
            $data2['id_usuario']=$this->aauth->get_user()->id;
            $data2['fecha']=date("Y-m-d H:i:s");
            $data2['descripcion']=json_encode($data);
            $data2['id_fila']=$catid;
            $data2['tabla']="product_cat";
            $data2['nombre_columna']="id";
            $this->db->insert("historial_crm",$data2);

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
	public function editalmacen($catid, $almacen, $descripcion)
    {
        $data = array(
            'almacen' => $almacen,
            'descripcion' => $descripcion
        );


        $this->db->set($data);
        $this->db->where('id', $catid);

        if ($this->db->update('almacen_equipos')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editwarehouse($catid, $product_cat_name, $product_cat_desc,$tecnico)
    {
        $data = array(
            'title' => $product_cat_name,
            'extra' => $product_cat_desc
        );

        if($tecnico!=null || $tecnico!=0 ){
            $data['id_tecnico']=$tecnico;
        }
        $this->db->set($data);
        $this->db->where('id', $catid);

        if ($this->db->update('product_warehouse')) {
            
            $data_h=array();
            $data_h['modulo']="Inventarios";
            $data_h['accion']="Edit Product warehouse {update}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode($data);
            $data_h['id_fila']=$catid;
            $data_h['tabla']="product_warehouse";
            $data_h['nombre_columna']="id";
            $this->db->insert("historial_crm",$data_h);

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


}