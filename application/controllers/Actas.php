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
class Actas extends CI_Controller
{
    
    public function __construct()
    {

        parent::__construct();
        $this->load->model('actas_model', 'actas');
               
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }
    public function view(){
        
        $data=array("id_acta"=>$_GET['id']);
        $data['acta']=$this->db->get_where("acta_transferencias",array("id"=>$_GET['id']))->row();
        $data['almacen_origen']=$this->db->get_where("product_warehouse",array("id"=>$data['acta']->almacen_origen))->row();
        $data['almacen_destino']=$this->db->get_where("product_warehouse",array("id"=>$data['acta']->almacen_destino))->row();
        if($data['almacen_destino']->id_tecnico!=null){
            $data['almacen_destino']->id_tecnico=$this->db->get_where("employee_profile",array("username"=>$data['almacen_destino']->id_tecnico))->row();
        }
        $data['lista_productos']=$this->db->query("select pr_b.product_name as nombre_producto,pr_a.pid as pid_origen,pr_b.pid as pid_destino, item_tr.cantidad as cantidad_transferida, pr_b.qty as cantidad_total from items_acta_transferencias as item_tr inner join transferencias as tr1 on tr1.id_transferencia=item_tr.id_transferencia inner join products as pr_a on pr_a.pid=tr1.producto_a inner join products as pr_b on pr_b.pid=tr1.producto_b where item_tr.id_acta_transferencia=".$_GET['id'])->result();
        $data['employee']=$this->db->get_where("employee_profile",array("id"=>$this->aauth->get_user()->id))->row();
        $data['employee_aauth_users']=$this->db->get_where("aauth_users",array("id"=>$this->aauth->get_user()->id))->row();

        //var_dump($data['tecnicoslista']);
        $head['title']="Acta De Transferencia de Material #".$_GET['id'];
        $this->load->view('fixed/header',$head);

        $this->load->view('actas/view',$data);
        $this->load->view('fixed/footer');
    }
}