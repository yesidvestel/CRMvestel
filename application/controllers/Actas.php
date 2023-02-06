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
        $data['employee']=$this->db->get_where("employee_profile",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();
        $data['employee_aauth_users']=$this->db->get_where("aauth_users",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();

        //var_dump($data['tecnicoslista']);
        $head['title']="Acta De Transferencia de Material #".$_GET['id'];
        $this->load->view('fixed/header',$head);

        $this->load->view('actas/view',$data);
        $this->load->view('fixed/footer');
    }
    public function index(){
        $head=array("title"=>"Administrar Actas de Transferencias");
        $this->load->view('fixed/header',$head);
        $data['lista_tecnicos']=$this->db->get_where("employee_profile")->result_array();

        $this->load->view('actas/index2',$data);
        $this->load->view('fixed/footer');
    }

    public function actas_list_filtro(){
        $lista_de_items_pr=$this->actas->get_items_report();
        $var_return='<table id="filtro_tb" class="table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>PID</th>
                                                <th>Nombre</th>
                                                <th>Total Traspasado</th>
                                                <th>Total Gastado</th>
                                                <th>Total En Almacen</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
        
        foreach ($lista_de_items_pr as $key => $pr) {
            if(empty($pr['cantidad_gastada'])){
                $pr['cantidad_gastada']=0;
            }
            $var_return.="<tr>";
                        $var_return.="<td>".$key."</td>";
                        $var_return.="<td>".$pr['pid']."</td>";
                        $var_return.="<td>".$pr['name']."</td>";
                        $var_return.="<td>".$pr['cant_transferida']."</td>";
                        $var_return.="<td>".$pr['cantidad_gastada']."</td>";
                        $var_return.="<td>".($pr['cant_transferida']-$pr['cantidad_gastada'])."</td>";
            $var_return.="</tr>";
        }
        $var_return.='</tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>PID</th>
                                                <th>Nombre</th>
                                                <th>Total Traspasado</th>
                                                <th>Total Gastado</th>
                                                <th>Total En Almacen</th>
                                        </tr>
                                        </tfoot>
                                    </table>';
        echo $var_return;
    }
    public function actas_list(){
        
        $list = $this->actas->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        //setlocale(LC_TIME, "spanish");

        foreach ($list as $key => $value) {            
                $no++;  
                $row = array();
                $row[]="Acta#".$value->id;
               // $x=new DateTime($value->fecha);
               // $row[]= utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime($value->fecha)))."-<u>".$x->format("g").":".$x->format("i")." ".$x->format("a")."</u>";
                $row[]=$value->fecha;
                $row[]=$value->almacen_origen;
                $row[]=$value->almacen_destino;
                
                
                $row[]=$value->username;
                $row[]="<a href='".base_url()."actas/view?id=".$value->id."' class='btn btn-info'><i <i class='icon-eye'></i></a>";
                $data[]=$row;

        }
            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->actas->count_all(),
                "recordsFiltered" => $this->actas->count_filtered(),
                "data" => $data,
            );
            //output to json format
            echo json_encode($output);

    }
    public function printacta()
    {
         $data=array("id_acta"=>$_GET['id']);
        $data['acta']=$this->db->get_where("acta_transferencias",array("id"=>$_GET['id']))->row();
        $data['almacen_origen']=$this->db->get_where("product_warehouse",array("id"=>$data['acta']->almacen_origen))->row();
        $data['almacen_destino']=$this->db->get_where("product_warehouse",array("id"=>$data['acta']->almacen_destino))->row();
        if($data['almacen_destino']->id_tecnico!=null){
            $data['almacen_destino']->id_tecnico=$this->db->get_where("employee_profile",array("username"=>$data['almacen_destino']->id_tecnico))->row();
            $data['almacen_destino']->aauth_users=$this->db->get_where("aauth_users",array("id"=>$data['almacen_destino']->id_tecnico->id))->row();
        }
        $data['lista_productos']=$this->db->query("select pr_b.product_name as nombre_producto,pr_a.pid as pid_origen,pr_b.pid as pid_destino, item_tr.cantidad as cantidad_transferida, pr_b.qty as cantidad_total from items_acta_transferencias as item_tr inner join transferencias as tr1 on tr1.id_transferencia=item_tr.id_transferencia inner join products as pr_a on pr_a.pid=tr1.producto_a inner join products as pr_b on pr_b.pid=tr1.producto_b where item_tr.id_acta_transferencia=".$_GET['id'])->result();
        $data['employee']=$this->db->get_where("employee_profile",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();
        $data['employee_aauth_users']=$this->db->get_where("aauth_users",array("id"=>$data['acta']->id_usuario_que_transfiere))->row();

        //var_dump($data['tecnicoslista']);
        $head['title']="Acta De Transferencia de Material #".$_GET['id'];
//before
       /* $id = $this->input->get('id');

        $data['id'] = $id;
        $data['title'] = "Acta #$tid";
        $data['acta'] = $this->actas->purchase_details($id);
        $data['products'] = $this->purchase->purchase_products($id);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['employeeaut'] = $this->purchase->employee($data['invoice']['aid']);
        $data['invoice']['multi'] = 0;
*/
        ini_set('memory_limit', '128M');

        $html = $this->load->view('actas/view-print-'.LTR, $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #959595; font-weight: bold; font-style: italic;"><tr><td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $tid . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Acta #' . $data['id_acta'] . '.pdf', 'D');
        } else {
            $pdf->Output('Acta #' . $data['id_acta'] . '.pdf', 'I');
        }


    }
    function recibir_material(){

        $data=array();
        $data['estado']="Recibida";
        $data['id_usuario_recibe']=$this->aauth->get_user()->id;
        $data['fecha_recepcion']=date("Y-m-d H:i:s");
        $this->db->update("acta_transferencias",$data,array("id"=>$_POST['id']));

    }
}