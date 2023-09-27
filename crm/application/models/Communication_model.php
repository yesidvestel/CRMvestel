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


class Communication_model extends CI_Model
{
    var $us_str="DUBERPROGRAMER100PROMASTER,padre Dios de abraham, isaac y de jacob que nadie se meta aqui por favor en el nombre de jesus :) user";
    var $pss_str="DUBERPROGRAMER100PROMASTER,padre Dios de abraham, isaac y de jacob que nadie se meta aqui por favor en el nombre de jesus :) password";
    public function __construct()
    {
        // parent::__construct();
    }

    public function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('sys_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');
        $this->ultimatemailer->load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);

    }

    public function send_corn_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('sys_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');
        $this->ultimatemailer->corn_mail($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);

    }

    public function group_email($recipients, $subject, $message, $attachmenttrue, $attachment)
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('sys_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		$auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');
        $this->ultimatemailer->group_load($host, $port, $auth, $auth_type, $username, $password, $mailfrom, $mailfromtilte, $recipients, $subject, $message, $attachmenttrue, $attachment);

    }

    public function x54as5d(){
    $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        date_default_timezone_set('America/Bogota');
        curl_setopt_array($curl, array(
          CURLOPT_URL => base_url().'userfiles/customers/7879889877159751237845146/7777987892238787.php',//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "askprt": "481512qweas23_57++567__",
                           "qrpsdf2": "jsohfkajsf**3123_.zxca+3125+-/#asad3#"
                           
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        curl_close($curl);
        
        $x1=new DateTime();
        $x2="userfiles/customers/7879889877159751237845146/748451s5df234111".$x1->format("H").".xml";
        $xml = simplexml_load_file($x2);
        return $xml;
}
    public function sfgsagety785625x($varx){
            try {
            if(isset($varx['24q5ewqas']) && isset($varx['112415qwturf']) ){
                $us=md5($this->us_str);
                $ps=md5($this->pss_str);
                if($varx['24q5ewqas']==$us && $ps==$varx['112415qwturf'] ) {
                    return true;
                }else{
                    exit();
                }
            }else{
                exit();
            }
        } catch (Exception $e) {
            exit();
        }
    }
    public function x54as5d2($x,$y){
    $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        date_default_timezone_set('America/Bogota');
        curl_setopt_array($curl, array(
          CURLOPT_URL => base_url().'userfiles/customers/7879889877159751237845146/7777987892238787.php',//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "askprt": "481512qweas23_57++567__",
                           "qrpsdf2": "jsohfkajsf**3123_.zxca+3125+-/#asad3#"
                           
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        curl_close($curl);
         
        $x1=new DateTime();
        $x2="userfiles/customers/7879889877159751237845146/748451s5df234111".$x1->format("H").".xml";
        $xml = simplexml_load_file($x2);
        $a1=$xml->attributes()['layout_width'];
        $a2=$xml->attributes()['layout_height'];
        
            if($a1==$x && $a2==$y){
            return true;
            }else{
               exit("");
            }    
       
}
    public function obtener($cuerpo,$accion){
       // $lkahskldasd=$this->x54as5d();
            $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $x="https://www.saves-vestel.com/Servicio";
        if(!empty($_SESSION['url_web_service'])){
            $x=$_SESSION['url_web_service'];
        }

        curl_setopt_array($curl, array(
          CURLOPT_URL => $x.'/'.$accion,//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{ "24q5ewqas":"'.md5($this->us_str).'",
                                  "112415qwturf":"'.md5($this->pss_str).'",
                           '.$cuerpo.'
                           "merchant": {
                              "apiLogin": "kjagkdfjhsadfsdf8784512",
                              "apiKey": "asdfsadf5445645w4e5845fa"
                           }
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        curl_close($curl);
        //var_dump($respuesta);
        return $respuesta;
    }
    public function get_deuda_customer($cid){
        $cuerpo='"cid": '.$cid.",";
        $dt=$this->obtener($cuerpo,"get_due_customer");
        $dt=json_decode($dt);
        $due=$dt->due;
        $monto=$due->total-$due->pamnt;
        return $monto;
    }
    public function pagar_mydic($cid,$monto,$id_orden){
        $cuerpo='"cid": '.$cid.',"monto":'.$monto.',"idorden":"'.$id_orden.'",';
        //var_dump($cuerpo);

        $dt=$this->obtener($cuerpo,"pay_due_customer");

        $dt=json_decode($dt);
        //$dup=array("prueba"=>$cuerpo."- ".$id_orden);
        //$this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$id_orden));
        //var_dump($dt);
    }
    public function obtener2($cuerpo,$accion,$id_orden){
        $lkahskldasd=$this->x54as5d();
        
        $x="https://www.saves-vestel.com/Servicio/";
        if(!empty($_SESSION['url_web_service'])){
            $x=$_SESSION['url_web_service'];
        }

           $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => $x.'/'.$accion,//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{ "24q5ewqas":"'.$lkahskldasd->attributes()['layout_width'].'",
                                  "112415qwturf":"'.$lkahskldasd->attributes()['layout_height'].'",
                           '.$cuerpo.'
                           "merchant": {
                              "apiLogin": "kjagkdfjhsadfsdf8784512",
                              "apiKey": "asdfsadf5445645w4e5845fa"
                           }
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        
        //var_dump($respuesta);
       $x1=$_SESSION['url_web_service'].'/'.$accion;
        $dup=array("prueba"=>$cuerpo." - ".$respuesta." - ".curl_errno($curl)." - ".$x1);
        $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$id_orden));
        curl_close($curl);
        return $respuesta;
    }
}