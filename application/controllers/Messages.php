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

class Messages extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

        $this->load->model('dashboard_model');
        $this->load->model('tools_model');


    }


    public function index()
    {

        $this->load->view('fixed/header');
        $this->load->view('messages/index');
        $this->load->view('fixed/footer');
    }

    public function sendpm()
    {


        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $receiver = $this->input->post('userid');

        if (/*strlen($subject) < 5 OR*/ $message == '') {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Mensaje vacio!"));
        } else {

            $this->aauth->send_pm($this->aauth->get_user()->id, $receiver, $subject, $message);

            echo json_encode(array('status' => 'Success', 'message' =>
                "Mensaje enviado!"));
        }


    }

    public function view()
    {


        $data['pmid'] = $this->input->get('id');
        $this->aauth->set_as_read_pm($data['pmid']);
		$chat=$this->db->get_where("aauth_pms",array("id"=>$data['pmid']))->row();
        $this->load->model('message_model', 'message');
        $data['employee'] = $this->message->employee_details($chat->sender_id,$chat->receiver_id);
		if($this->aauth->get_user()->id==$chat->sender_id){
			$idcol=$chat->receiver_id;
		}else{
			$idcol=$chat->sender_id;
		}
        $data['colaborador'] = $this->message->col_details($idcol);
        $this->load->view('fixed/header');
        $this->load->view('messages/view', $data);
        $this->load->view('fixed/footer');


    }

    public function deletepm()
    {


        $pmid = $this->input->post('pmid');


        if ($this->aauth->delete_pm($pmid)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Mensaje Eliminado!"));
        } else {


            echo json_encode(array('status' => 'Error', 'message' =>
                "Error !"));
        }


    }
    public function obtener_notificaciones(  ){
        $id_usuario=$this->aauth->get_user()->id;
        $retorno=array("status"=>"sin mensajes");
        $resultado=$this->db->query("select * from aauth_pms where receiver_id=".$id_usuario." order by date_sent DESC limit 1")->result_array();
        if(count($resultado)>0 && $resultado[0]['date_read']==null ){

                $retorno['status']="mensaje nuevo";
                $retorno['mensaje']=strip_tags($resultado[0]['message']);
                $origen=$this->db->get_where("aauth_users",array("id"=>$resultado[0]['sender_id']) )->row();
                $retorno['titulo']=$origen->username;
                $retorno['id_msj']=$resultado[0]['id'];
                

                if($origen->picture!=null){
                    $retorno['foto']=base_url()."userfiles/employee/".$origen->picture;    
                }else{
                    $retorno['foto']=base_url()."assets/images/logo/logo-80x80.png";  
                }

                

        }else{

        }
        echo json_encode($retorno);
    }


}