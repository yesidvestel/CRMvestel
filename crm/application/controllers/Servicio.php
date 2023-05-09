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
class Servicio extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $request=file_get_contents("php://input",true);
        $body_post=json_decode($request,true);    
        $this->load->model('Communication_model', 'communication');
        $bool=$this->communication->sfgsagety785625x($body_post);
    }
    public function update_user(){
        $body_post=json_decode(file_get_contents("php://input",true));//obteniendo datos post
        
        $cid = $body_post->cid;
        $data['name']=$body_post->name;
        $data['password']=$body_post->ps;
        $data['email']=$body_post->email;
        $data['user_id']=$body_post->userid;
        $customer=$this->db->get_where("users",array("cid"=>$cid))->row();
        if(empty($customer)){
            $data['cid']=$cid;
            
            $data['status']="active";
            $data['is_deleted']=0;
            $data['user_type']="Member";
            echo $this->db->insert("users",$data);
        }else{
            echo $this->db->update("users",$data,array("cid"=>$cid));
        }
        
    }



}