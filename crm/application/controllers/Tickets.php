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

class Tickets Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ticket_model', 'ticket');
        /*if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
        $this->load->model('general_model', 'general');
        $this->captcha = $this->general->public_key()->captcha;
        $this->user_id = isset($this->session->get_userdata()['user_details'][0]->id) ? $this->session->get_userdata()['user_details'][0]->users_id : '1';
        */

    }

public function editarx(){
                    $erfbsfa=fopen('creo.txt','w');  
                        fputs($erfbsfa,date("Y-m-d H:i:s")); 
                        fclose($erfbsfa); 
}
public function data_reception(){  
$this->load->model('Communication_model', 'communication');  

$data=array();
$data['data']=file_get_contents("php://input",true);
date_default_timezone_set('America/Bogota');
 $data['fecha']=date("Y-m-d H:i:s");
$this->db->insert("data_reception",$data);    
//echo json_encode($data);

/*procesando la informacion*/
   /* convirtiendo de url a array*/
$d1="https://vestel.com?";
    $d1.=$data['data'];
    $components = parse_url($d1, PHP_URL_QUERY);
//$component parameter is PHP_URL_QUERY
parse_str($components, $results);
/*validaciones del sistema*/

//var_dump($results['response_message_pol']); 
//var_dump($results['transaction_id']); 

$orden=$this->db->query("SELECT * FROM `orden_de_pago` WHERE `data` LIKE '%".$results['transaction_id']."%'")->result();
//var_dump($orden[0]->id_orden_de_pago);
if($results['response_message_pol']=="APPROVED"){
    $dup=array("estado"=>"Pagado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
    
    //$monto=$this->communication->get_deuda_customer($this->session->userdata('user_details')[0]->cid);
    $this->communication->pagar_mydic($orden[0]->user_id,$orden[0]->monto,$results['reference_sale']);

}else if($results['response_message_pol']=="EXPIRED_TRANSACTION"){
    $dup=array("estado"=>"Expirado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_REJECTED"){  $dup=array("estado"=>"Transacción rechazada por entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ENTITY_DECLINED"){   $dup=array("estado"=>"Transacción rechazada por el banco");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INSUFFICIENT_FUNDS"){    $dup=array("estado"=>"Fondos insuficientes");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_CARD"){  $dup=array("estado"=>"Tarjeta inválida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="CONTACT_THE_ENTITY"){    $dup=array("estado"=>"Contactar a la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_ACCOUNT_ACTIVATION_ERROR"){     $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_ACCOUNT_NOT_AUTHORIZED_FOR_AUTOMATIC_DEBIT"){   $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_AGENCY_BANK_ACCOUNT"){   $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_BANK_ACCOUNT"){  $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_BANK"){  $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="EXPIRED_CARD"){  $dup=array("estado"=>"Tarjeta vencida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="RESTRICTED_CARD"){   $dup=array("estado"=>"Tarjeta restringida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_EXPIRATION_DATE_OR_SECURITY_CODE"){  $dup=array("estado"=>"La fecha de expiración o el código de seguridad son inválidos");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="REPEAT_TRANSACTION"){    $dup=array("estado"=>"Reintentar pago");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_TRANSACTION"){   $dup=array("estado"=>"Transacción inválida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="EXCEEDED_AMOUNT"){   $dup=array("estado"=>"El valor excede el máximo permitido por la entidad");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ABANDONED_TRANSACTION"){     $dup=array("estado"=>"Transacción abandonada por el pagador");
    //$dt1=json_decode($orden[0]->data);
    $this->communication->pagar_mydic($orden[0]->user_id,$orden[0]->monto,$results['reference_sale']);
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
    
}else if($results['response_message_pol']=="CREDIT_CARD_NOT_AUTHORIZED_FOR_INTERNET_TRANSACTIONS"){  $dup=array("estado"=>"Tarjeta no autorizada para comprar por internet");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ANTIFRAUD_REJECTED"){    $dup=array("estado"=>"Transacción rechazada por sospecha de fraude");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_FRAUD_REJECTED"){   $dup=array("estado"=>"Transacción rechazada debido a sospecha de fraude en la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="DIGITAL_CERTIFICATE_NOT_FOUND"){     $dup=array("estado"=>"Certificado digital no encontrado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_UNREACHABLE"){  $dup=array("estado"=>"Error tratando de comunicarse con el banco");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_NO_CONNECTION"){     $dup=array("estado"=>"No fue posible establecer comunicación con la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_NO_RESPONSE"){   $dup=array("estado"=>"No se recibió respuesta de la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ENTITY_MESSAGING_ERROR"){    $dup=array("estado"=>"Error comunicándose con la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="NOT_ACCEPTED_TRANSACTION"){  $dup=array("estado"=>"Transacción no permitida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INTERNAL_PAYMENT_PROVIDER_ERROR"){   $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INACTIVE_PAYMENT_PROVIDER"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR_CONVERTING_TRANSACTION"){  $dup=array("estado"=>"9999 Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_ACCOUNT_ACTIVATION_ERROR"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="FIX_NOT_REQUIRED"){  $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="AUTOMATICALLY_FIXED_AND_SUCCESS"){   $dup=array("estado"=>"9999 Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="AUTOMATICALLY_FIXED_AND_UNSUCCESS"){     $dup=array("estado"=>"9999 Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="AUTOMATIC_FIXED_NOT_SUPPORTED"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="NOT_FIXED_FOR_ERROR_STATE"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR_FIXING_AND_REVERSING"){    $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR_FIXING_INCOMPLETE_DATA"){  $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_BAD_RESPONSE"){  $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}

/*else if($results['response_message_pol']=="ABANDONED_TRANSACTION"){
    $dup=array("estado"=>"Cancelado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}*/

}
public function data_reception_wompi(){
    $this->load->model('Communication_model', 'communication');  
    $data=array();
        $data['data']=file_get_contents("php://input",true);
        date_default_timezone_set('America/Bogota');
        $data['fecha']=date("Y-m-d H:i:s");
        $this->db->insert("data_reception",$data);

        $r=$data['data'];
        $r=json_decode($r);
        $datos=array();
        if(isset($r->data->transaction->payment_method_type) && $r->data->transaction->payment_method_type!="" && $r->data->transaction->payment_method_type!=null){
            $datos['metodo_pago']=$r->data->transaction->payment_method_type;
        }
        if(isset($r->data->transaction->id) && $r->data->transaction->id!="" && $r->data->transaction->id!=null){
            $datos['id_wompi']=$r->data->transaction->id;
             $datos['id_wompi']=str_replace(" ", "", $datos['id_wompi']);
            $datos['id_wompi']=str_replace("-", "", $datos['id_wompi']);
        }
        $procesada_q=$this->db->get_where("wompi_data_orden",array("reference"=>$r->data->transaction->reference) )->row();
    if(isset($procesada_q) && $procesada_q->estado=="Inicial" ){


        if($r->data->transaction->status=="APPROVED"){
            $datos['estado']="Finalizada con Exito";
            $this->db->update("wompi_data_orden",$datos,array("reference"=>$r->data->transaction->reference));
            $ordenx=$this->db->get_where("wompi_data_orden",array("reference"=>$r->data->transaction->reference))->row();

            $this->communication->pagar_mydic($ordenx->cid_user,$ordenx->debe,$ordenx->reference);
        }else{
            $datos['estado']="Finalizada sin Exito";
            $this->db->update("wompi_data_orden",$datos,array("reference"=>$r->data->transaction->reference));
        }
    }
        
        //var_dump($r->data->transaction->reference);
        //var_dump($r->data->transaction->payment_method_type);
        //var_dump($r->data->transaction->status);
}
public function data_reception2(){  
$this->load->model('Communication_model', 'communication');  

$data=array();
$data['data']="date=2022.06.27+02%3A29%3A00&pse_reference3=123456789&payment_method_type=4&pse_reference2=CC&pse_reference1=127.0.0.1&shipping_city=Bogot%C3%A1&bank_referenced_name=&sign=fc56cacf5a33d83411387a83372abe81&extra2=&extra3=&operation_date=2022-06-27+14%3A29%3A00&payment_request_state=R&billing_address=Cr+23+No.+53-50&extra1=&administrative_fee=0.00&administrative_fee_tax=0.00&bank_id=25&nickname_buyer=&payment_method=25&attempts=1&transaction_id=b7ab236b-c31b-4bca-b2b0-d481c6c72c93&transaction_date=2022-06-27+14%3A29%3A00&test=0&exchange_rate=1.00&ip=127.0.0.1&reference_pol=2041107064&tax=0.00&antifraudMerchantId=&pse_bank=NEQUI&state_pol=6&billing_city=Bogot%C3%A1&phone=7563126&error_message_bank=User+has+abandoned+the+transaction+in+PSE+returning+to+the+store&shipping_country=CO&error_code_bank=00020&cus=1524199596&customer_number=1&description=Payment+test+description&merchant_id=967931&administrative_fee_base=0.00&currency=COP&shipping_address=Cr+23+No.+53-50&nickname_seller=&installments_number=&value=65000.00&billing_country=CO&response_code_pol=19&payment_method_name=PSE&office_phone=7563126&email_buyer=pruebas2%40payulatam.com&payment_method_id=4&response_message_pol=ABANDONED_TRANSACTION&account_id=975762&airline_code=&pseCycle=null&risk=&reference_sale=test_2022_06_27_14_28_59_62&additional_value=0.00";

 $data['fecha']=date("Y-m-d H:i:s");
$this->db->insert("data_reception",$data);    
//echo json_encode($data);

/*procesando la informacion*/
   /* convirtiendo de url a array*/
$d1="https://vestel.com?";
    $d1.=$data['data'];
    $components = parse_url($d1, PHP_URL_QUERY);
//$component parameter is PHP_URL_QUERY
parse_str($components, $results);
/*validaciones del sistema*/

//var_dump($results['response_message_pol']); 
//var_dump($results['transaction_id']); 

$orden=$this->db->query("SELECT * FROM `orden_de_pago` WHERE `data` LIKE '%".$results['transaction_id']."%'")->result();
//var_dump($orden[0]->id_orden_de_pago);
if($results['response_message_pol']=="APPROVED"){
    $dup=array("estado"=>"Pagado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
    
    //$monto=$this->communication->get_deuda_customer($this->session->userdata('user_details')[0]->cid);
    $this->communication->pagar_mydic($orden[0]->user_id,$orden[0]->monto);

}else if($results['response_message_pol']=="EXPIRED_TRANSACTION"){
    $dup=array("estado"=>"Expirado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_REJECTED"){  $dup=array("estado"=>"Transacción rechazada por entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ENTITY_DECLINED"){   $dup=array("estado"=>"Transacción rechazada por el banco");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INSUFFICIENT_FUNDS"){    $dup=array("estado"=>"Fondos insuficientes");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_CARD"){  $dup=array("estado"=>"Tarjeta inválida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="CONTACT_THE_ENTITY"){    $dup=array("estado"=>"Contactar a la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_ACCOUNT_ACTIVATION_ERROR"){     $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_ACCOUNT_NOT_AUTHORIZED_FOR_AUTOMATIC_DEBIT"){   $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_AGENCY_BANK_ACCOUNT"){   $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_BANK_ACCOUNT"){  $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_BANK"){  $dup=array("estado"=>"Débito automático no permitido");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="EXPIRED_CARD"){  $dup=array("estado"=>"Tarjeta vencida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="RESTRICTED_CARD"){   $dup=array("estado"=>"Tarjeta restringida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_EXPIRATION_DATE_OR_SECURITY_CODE"){  $dup=array("estado"=>"La fecha de expiración o el código de seguridad son inválidos");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="REPEAT_TRANSACTION"){    $dup=array("estado"=>"Reintentar pago");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INVALID_TRANSACTION"){   $dup=array("estado"=>"Transacción inválida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="EXCEEDED_AMOUNT"){   $dup=array("estado"=>"El valor excede el máximo permitido por la entidad");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ABANDONED_TRANSACTION"){     $dup=array("estado"=>"Transacción abandonada por el pagador");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
    $this->communication->pagar_mydic($orden[0]->user_id,$orden[0]->monto);
}else if($results['response_message_pol']=="CREDIT_CARD_NOT_AUTHORIZED_FOR_INTERNET_TRANSACTIONS"){  $dup=array("estado"=>"Tarjeta no autorizada para comprar por internet");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ANTIFRAUD_REJECTED"){    $dup=array("estado"=>"Transacción rechazada por sospecha de fraude");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_FRAUD_REJECTED"){   $dup=array("estado"=>"Transacción rechazada debido a sospecha de fraude en la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="DIGITAL_CERTIFICATE_NOT_FOUND"){     $dup=array("estado"=>"Certificado digital no encontrado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_UNREACHABLE"){  $dup=array("estado"=>"Error tratando de comunicarse con el banco");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_NO_CONNECTION"){     $dup=array("estado"=>"No fue posible establecer comunicación con la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_NO_RESPONSE"){   $dup=array("estado"=>"No se recibió respuesta de la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ENTITY_MESSAGING_ERROR"){    $dup=array("estado"=>"Error comunicándose con la entidad financiera");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="NOT_ACCEPTED_TRANSACTION"){  $dup=array("estado"=>"Transacción no permitida");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INTERNAL_PAYMENT_PROVIDER_ERROR"){   $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="INACTIVE_PAYMENT_PROVIDER"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR_CONVERTING_TRANSACTION"){  $dup=array("estado"=>"9999 Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="BANK_ACCOUNT_ACTIVATION_ERROR"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="FIX_NOT_REQUIRED"){  $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="AUTOMATICALLY_FIXED_AND_SUCCESS"){   $dup=array("estado"=>"9999 Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="AUTOMATICALLY_FIXED_AND_UNSUCCESS"){     $dup=array("estado"=>"9999 Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="AUTOMATIC_FIXED_NOT_SUPPORTED"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="NOT_FIXED_FOR_ERROR_STATE"){     $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR_FIXING_AND_REVERSING"){    $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="ERROR_FIXING_INCOMPLETE_DATA"){  $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}else if($results['response_message_pol']=="PAYMENT_NETWORK_BAD_RESPONSE"){  $dup=array("estado"=>"Error interno");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}

/*else if($results['response_message_pol']=="ABANDONED_TRANSACTION"){
    $dup=array("estado"=>"Cancelado");
    $this->db->update("orden_de_pago",$dup,array("id_orden_de_pago"=>$orden[0]->id_orden_de_pago));
}*/
}

    //documents


    public function index()
    {

        $head['usernm'] = '';
        $head['title'] = 'Support Tickets';
        $this->load->view('includes/header', $head);
        if ($this->ticket->ticket()->key1) {
            $this->load->view('support/tickets');
        } else {
            $this->load->view('support/general');
        }
        $this->load->view('includes/footer');


    }

    public function tickets_load_list()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $list = $this->ticket->ticket_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $ticket) {
            $row = array();
            $no++;
            $row[] = $no;
            $row[] = $ticket->subject;
            $row[] = $ticket->created;
            $row[] = '<span class="st-' . $ticket->status . '">' . $this->lang->line($ticket->status) . '</span>';

            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->id) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> '.$this->lang->line('View').'</a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all(),
            "recordsFiltered" => $this->ticket->ticket_count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }


    public function thread()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $flag = true;
        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->general->public_key()->recaptcha_p;

        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');

        $data['response'] = 3;
        $head['usernm'] = '';
        $head['title'] = 'Add Support Reply';

        $this->load->view('includes/header', $head);

        if ($this->input->post('content')) {

            if ($this->captcha) {
                $this->load->helper('recaptchalib_helper');
                $reCaptcha = new ReCaptcha($this->general->public_key()->recaptcha_s);
                $resp = $reCaptcha->verifyResponse($this->input->server("REMOTE_ADDR"),
                    $this->input->post("g-recaptcha-response"));

                if (!$resp->success) {
                    $flag = false;

                }
            }

            if ($flag) {

                $message = $this->input->post('content');
                $attach = $_FILES['userfile']['name'];
                if ($attach) {
                    $config['upload_path'] = '../userfiles/support';
                    $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                    $config['max_size'] = 3000;
                    $config['file_name'] = time() . $attach;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('userfile')) {
                        $data['response'] = 0;
                        $data['responsetext'] = 'File Upload Error';

                    } else {
                        $data['response'] = 1;
                        $data['responsetext'] = 'Reply Added Successfully.';
                        $filename = $this->upload->data()['file_name'];
                        $this->ticket->addreply($thread_id, $message, $filename);
                    }
                } else {
                    $this->ticket->addreply($thread_id, $message, '');
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                }


            } else {

                $data['response'] = 0;
                $data['responsetext'] = 'Captcha Error!';

            }
            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);

            $this->load->view('support/thread', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);


            $this->load->view('support/thread', $data);


        }
        $this->load->view('includes/footer');


    }

    public function addticket()
    {
        if (!$this->ticket->ticket()->key1) {
            exit();
        }
        $flag = true;
        $data['captcha_on'] = $this->captcha;
        $data['captcha'] = $this->general->public_key()->recaptcha_p;

        $this->load->helper(array('form'));


        $data['response'] = 3;
        $head['usernm'] = '';
        $head['title'] = 'Add Support Ticket';

        $this->load->view('includes/header', $head);

        if ($this->input->post('content')) {
            if ($this->captcha) {
                $this->load->helper('recaptchalib_helper');
                $reCaptcha = new ReCaptcha($this->general->public_key()->recaptcha_s);
                $resp = $reCaptcha->verifyResponse($this->input->server("REMOTE_ADDR"),
                    $this->input->post("g-recaptcha-response"));

                if (!$resp->success) {
                    $flag = false;

                }
            }

            if ($flag) {

                $title = $this->input->post('title');
                $message = $this->input->post('content');
                $attach = $_FILES['userfile']['name'];
                if ($attach) {
                    $config['upload_path'] = '../userfiles/support';
                    $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                    $config['max_size'] = 3000;
                    $config['file_name'] = time() . $attach;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('userfile')) {
                        $data['response'] = 0;
                        $data['responsetext'] = 'File Upload Error';

                    } else {
                        $data['response'] = 1;
                        $data['responsetext'] = 'Ticket Submitted Successfully.';
                        $filename = $this->upload->data()['file_name'];
                        $this->ticket->addticket($title, $message, $filename);
                    }

                } else {
                    $this->ticket->addticket($title, $message, '');
                    $data['response'] = 1;
                    $data['responsetext'] = 'Ticket Submitted Successfully.';
                }
            } else {

                $data['response'] = 0;
                $data['responsetext'] = 'Captcha Error!.';

            }
            $this->load->view('support/addticket', $data);

        } else {


            $this->load->view('support/addticket', $data);


        }
        $this->load->view('includes/footer');


    }


}