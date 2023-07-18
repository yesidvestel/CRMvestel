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

class Clientgroup_model extends CI_Model
{


    public function details($id)
    {

        $this->db->select('*');
        $this->db->from('customers_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_numero_seleccionados($id_sede){
        $data =$this->db->query("select count(checked_seleccionado) as cuenta from customers where gid=".$id_sede." and checked_seleccionado=1")->result();
        return $data[0]->cuenta;
    }

    public function recipients($id)
    {

        $this->db->select('name,email');
        $this->db->from('customers');
        $this->db->where('gid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
	public function group_info($id)
    {
		$this->db->select('*');
        $this->db->from('ciudad');
        $this->db->where('ciudad', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add($group_name, $group_desc)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc
        );

        if ($this->db->insert('customers_group', $data)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }


    public function editgroupupdate($gid, $group_name, $group_desc)
    {
        $data = array(
            'title' => $group_name,
            'summary' => $group_desc
        );


        $this->db->set($data);
        $this->db->where('id', $gid);

        if ($this->db->update('customers_group')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
       public function get_datos_customer_pdf($csd){
        $data=array();
        $data['acclist'] = $this->accounts_model->accountslist('');

        $csd = intval($csd);
        $data['customer'] = $this->db->get_where("customers",array("id"=>$csd))->row();
        
        $data['due'] = $this->customers->due_details($csd);

        $total_customer=$data['due']['total']-$data['due']['pamnt'];
        // var_dump($total_customer);
        //$data['transaccion'] = $this->invocies->ultima_transaccion_realizada($csd);
        if($total_customer>0){
            $data['products'] = $this->invocies->invoice_sin_pagar($csd);        
        }else if($total_customer==0){
            $data['products'] = $this->invocies->ultima_factura($csd);        
        }else{
            $informacion = $this->invocies->pagadas_adelantadas($csd);        
            $data['products']=array("0"=>$informacion['factura_saldo_adelantado']);
            $data['tr_saldo_adelantado']=$informacion['tr_saldo_adelantado'][0];
            //$data['transaccion']=$informacion['tr_saldo_adelantado'];
            $data['facturas_adelantadas']=$informacion['facturas_adelantadas'];

        }
        $data['total_customer']=$total_customer;

//end cambios nuevos

         $data['id'] = $csd;
        $data['title'] = "Estado Usuario $tid";
        $data['customer']->ciudad=$this->db->get_where("ciudad",array("idCiudad"=>$data['customer']->ciudad))->row()->ciudad;               
        //$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        //if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if(isset($data['products'][0]['eid'])){
            $data['employee']=$this->invocies->employee($data['products'][0]['eid']);     
        }else{
            $data['employee']=null;
        }
            return $data;
    }
    public function get_citys(){
        return $this->db->query("SELECT ciudad.idCiudad as id, ciudad.ciudad as name, departamentos.departamento as departamentName FROM `ciudad` inner join departamentos on departamentos.idDepartamento=ciudad.idDepartamento")->result_array();
    }
}