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

class Payments extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('payments_model', 'payments');
        
        if (!is_login()) {
            redirect(base_url() . 'user/profile', 'refresh');
        }
    }

    //invoices list
    public function index()
    {
        $head['title'] = "Payments";
        $cid=$this->session->userdata('user_details')[0]->cid;
        $fecha_actual=date("Y-m-d");
        $this->db->query("DELETE FROM wompi_data_orden WHERE estado='inicial' and cid_user=".$cid." and fecha<'".$fecha_actual."'");
        //var_dump("DELETE FROM wompi_data_orden WHERE estado='inicial' and cid_user=".$cid." and fecha<'".$fecha_actual."'");
        
        $this->load->view('includes/header');
        $this->load->view('payments/payments');
        $this->load->view('includes/footer');
    }

    public function prueba2(){
        $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.payulatam.com/payments-api/4.0/service.cgi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
   "language": "es",
   "command": "SUBMIT_TRANSACTION",
   "merchant": {
      "apiKey": "'.$_SESSION['key_p'].'",
      "apiLogin": "'.$_SESSION['user_p'].'"
   },
   "transaction": {
      "order": {
         "accountId": "975762",
         "referenceCode": "PRODUCT_TEST_2021_06_23T19",
         "description": "Payment test description",
         "language": "es",
         "signature": "020d76e74528c63c95aa14f0bcf6decf",
         "notifyUrl": "https://vestel.com.co/crm/tickets/editarx",
         "additionalValues": {
            "TX_VALUE": {
               "value": 65000,
               "currency": "COP"
         },
            "TX_TAX": {
               "value": 10378,
               "currency": "COP"
         },
            "TX_TAX_RETURN_BASE": {
               "value": 54622,
               "currency": "COP"
         }
         },
         "buyer": {
            "merchantBuyerId": "1",
            "fullName": "First name and second buyer name",
            "emailAddress": "buyer_test@test.com",
            "contactPhone": "7563126",
            "dniNumber": "123456789",
            "shippingAddress": {
               "street1": "Cr 23 No. 53-50",
               "street2": "5555487",
               "city": "Bogotá",
               "state": "Bogotá D.C.",
               "country": "CO",
               "postalCode": "000000",
               "phone": "7563126"
            }
         },
         "shippingAddress": {
            "street1": "Cr 23 No. 53-50",
            "street2": "5555487",
            "city": "Bogotá",
            "state": "Bogotá D.C.",
            "country": "CO",
            "postalCode": "0000000",
            "phone": "7563126"
         }
      },
      "payer": {
         "merchantPayerId": "1",
         "fullName": "First name and second payer name",
         "emailAddress": "payer_test@test.com",
         "contactPhone": "7563126",
         "dniNumber": "5415668464654",
         "billingAddress": {
            "street1": "Cr 23 No. 53-50",
            "street2": "125544",
            "city": "Bogotá",
            "state": "Bogotá D.C.",
            "country": "CO",
            "postalCode": "000000",
            "phone": "7563126"
         }
      },
      "type": "AUTHORIZATION_AND_CAPTURE",
      "paymentMethod": "EFECTY",
      "expirationDate": "2022-05-12T20:58:35.804",//2022-05-14T11:24:32.804
      "paymentCountry": "CO",
      "ipAddress": "127.0.0.1"
   },
   "test": false
}
',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            //'Content-Length: length' //esta linea es la que causa el error por esta es la longitud de los bites de la informacion enviada por post, revisar codigo java en android ws
            
          ),
        ));

         $respuesta= curl_exec($curl);
        curl_close($curl);
        echo $respuesta;
    }
    public function pg_ef(){
      $this->load->model('Communication_model', 'communication');
        date_default_timezone_set('America/Bogota');
        $data_orden=array("user_id"=>$this->session->userdata('user_details')[0]->cid);
        
        $monto=$this->communication->get_deuda_customer($this->session->userdata('user_details')[0]->cid);
        if($monto<20000){
            $r=array("status"=>"Error","message"=>"Monto menor de 20000");
            echo json_encode($r);
            exit();
            //mensaje para que se hacerque a pagar en las oficinas o por pse pues es muy poco el valor
        }else{
        $data_orden['monto']="".$monto; 
        }

        
        //minimo baloto 15000 minimo efecty 20000
        if($_POST['a1']=="1"){
            $data_orden['metodo_pago']="EFECTY";    
        }else{
            $data_orden['metodo_pago']="BALOTO";    
        }
        $data_orden['fecha']=date("Y-m-d H:i:s");
        $data_orden['nombre_referencia']="pago_".date("Y_m_d_H_i_s_U");
        $fecha_actual = date("Y-m-d H:i:s");
        //sumo 1 día
         
        $data_orden['expire_date']=date("Y-m-d H:i:s",strtotime($fecha_actual."+ 1 days")); 
        $xd=new DateTime($data_orden['expire_date']);
        $fecha_expiracion=$xd->format("Y-m-d")."T".$xd->format("H:i:s").".804";
       $var=$_SESSION['key_p']."~967931~".$data_orden['nombre_referencia']."~".$data_orden['monto']."~COP";
        
        $this->db->insert("orden_de_pago",$data_orden);

        $signature=md5($var);

        $fullname=$_SESSION['dt_customer']->name." ".$_SESSION['dt_customer']->dosnombre." ".$_SESSION['dt_customer']->unoapellido." ".$_SESSION['dt_customer']->dosapellido;
        $email="buyer_test@test.com";
      $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";
        if(isset($_SESSION['dt_customer']->email) && preg_match($regex, $_SESSION['dt_customer']->email)){
            $email=$_SESSION['dt_customer']->email;
        }
        $celular="7563126";

        if(strlen($_SESSION['dt_customer']->celular)>10 || preg_match_all("/[^0-9]/",$_SESSION['dt_customer']->celular)!=0){
                
                if(strlen($_SESSION['dt_customer']->celular2)>10 || preg_match_all("/[^0-9]/",$_SESSION['dt_customer']->celular2)!=0){
                      $celular="7563126";
                
                }else{
                     $celular=$_SESSION['dt_customer']->celular2;                     
                }

         }else{
                  $celular=$_SESSION['dt_customer']->celular;  
         }

       $cuerpo_de_la_respuesta='{
        
   "language": "es",
   "command": "SUBMIT_TRANSACTION",
   "merchant": {
      "apiKey": "'.$_SESSION['key_p'].'",
      "apiLogin": "'.$_SESSION['user_p'].'"
   },
   "transaction": {
      "order": {
         "accountId": "975762",
         "referenceCode": "'.$data_orden['nombre_referencia'].'",
         "description": "pago servicios vestel",
         "language": "es",
         "signature": "'.$signature.'",
         "notifyUrl": "https://vestel.com.co/crm/tickets/data_reception",
         "partnerId":975762,
         "additionalValues": {
             "TX_VALUE": {
               "value": '.$data_orden['monto'].',
               "currency": "COP"
         },
            "TX_TAX": {
               "value": 0,
               "currency": "COP"
         }
            
         },
         "buyer": {
            "merchantBuyerId": "1",
            "fullName": "'.$fullname.'",
            "emailAddress": "'.$email.'",
            "contactPhone": "'.$celular.'",
            "dniNumber": "123456789",
            "shippingAddress": {
               "street1": "Cr 23 No. 53-50",
               "street2": "5555487",
               "city": "Bogotá",
               "state": "Bogotá D.C.",
               "country": "CO",
               "postalCode": "000000",
               "phone": "'.$celular.'"
            }
         },
         "shippingAddress": {
            "street1": "Cr 23 No. 53-50",
            "street2": "5555487",
            "city": "Bogotá",
            "state": "Bogotá D.C.",
            "country": "CO",
            "postalCode": "0000000",
            "phone": "'.$celular.'"
         }
      },
      "payer": {
         "merchantPayerId": "1",
         "fullName": "'.$fullname.'",
         "emailAddress": "'.$email.'",
         "contactPhone": "'.$celular.'",
         "dniNumber": "5415668464654",
         "billingAddress": {
            "street1": "Cr 23 No. 53-50",
            "street2": "125544",
            "city": "Bogotá",
            "state": "Bogotá D.C.",
            "country": "CO",
            "postalCode": "000000",
            "phone": "7563126"
         }
      },
      "type": "AUTHORIZATION_AND_CAPTURE",
      "paymentMethod": "'.$data_orden["metodo_pago"].'",
      "expirationDate": "'.$fecha_expiracion.'",
      "paymentCountry": "CO",
      "ipAddress": "127.0.0.1"
   },
   "test": false
}';
        //var_dump($cuerpo_de_la_respuesta);
          $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.payulatam.com/payments-api/4.0/service.cgi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$cuerpo_de_la_respuesta,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            //'Content-Length: length' //esta linea es la que causa el error por esta es la longitud de los bites de la informacion enviada por post, revisar codigo java en android ws
            
          ),
        ));

         $respuesta= curl_exec($curl);
        curl_close($curl);
        //var_dump($respuesta);
        //var_dump($cuerpo_de_la_respuesta);
        $dataup=array("data"=>$respuesta);
        $this->db->update("orden_de_pago",$dataup,array("nombre_referencia"=>$data_orden['nombre_referencia']));
        $data_json=json_decode($respuesta);
        //$x->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML
        $r=array("status"=>"SUCCESS");
        if($data_json->code=="SUCCESS"){
            $r['url']=$data_json->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML;
        }else{
            $r=array("status"=>"Error","message"=>"comunicate con nosotros");
        }
        echo json_encode($r);
        
    }
    public function prueba(){
        $var="K4N2CDMArYqCPshu5rvbycCnOG~967931~PRODUCT_TEST_2021_06_23T19~65000~COP";
        var_dump(md5($var));
           $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.payulatam.com/payments-api/4.0/service.cgi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "test": false,
                           "language": "es",
                           "command": "GET_PAYMENT_METHODS",
                           "merchant": {
                              "apiKey": "'.$_SESSION['key_p'].'",
                              "apiLogin": "'.$_SESSION['user_p'].'"
                           }
                        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            //'Content-Length: length' //esta linea es la que causa el error por esta es la longitud de los bites de la informacion enviada por post, revisar codigo java en android ws
            
          ),
        ));

         $respuesta= curl_exec($curl);
        curl_close($curl);
        echo $respuesta;
    }
    public function lsita_bancos(){
        $var="K4N2CDMArYqCPshu5rvbycCnOG~967931~PRODUCT_TEST_2021_06_23T19~65000~COP";
        var_dump(md5($var));
           $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.payulatam.com/payments-api/4.0/service.cgi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "test": false,
                           "language": "es",
                           "command": "GET_BANKS_LIST",
                           "merchant": {
                              "apiKey": "'.$_SESSION['key_p'].'",
                              "apiLogin": "'.$_SESSION['user_p'].'"
                           },
                            "bankListInformation": {
                              "paymentMethod": "PSE",
                              "paymentCountry": "CO"
                           }
                        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            //'Content-Length: length' //esta linea es la que causa el error por esta es la longitud de los bites de la informacion enviada por post, revisar codigo java en android ws
            
          ),
        ));

         $respuesta= curl_exec($curl);
        curl_close($curl);
        echo $respuesta;
    }
    public function pse_reseption(){
        //var_dump($_POST);
        $this->load->model('Communication_model', 'communication');
        $deviceSessionId = md5(session_id().microtime());
        //var_dump($deviceSessionId);
        //var_dump($_COOKIE['ci_sessions']);
        date_default_timezone_set('America/Bogota');
        $data_orden=array("user_id"=>$this->session->userdata('user_details')[0]->cid);
        //$data_orden['monto']=15000;
        $data_orden['monto']=$this->communication->get_deuda_customer($this->session->userdata('user_details')[0]->cid);
        //var_dump($data_orden['monto']);
        if($data_orden['monto']<15000){
            $r=array("status"=>"Error","message"=>"Monto menor de 15000");
            echo json_encode($r);
            exit();
            //mensaje para que se hacerque a pagar en las oficinas o por pse pues es muy poco el valor
        }else{
        $data_orden['monto']="".$data_orden['monto']; 
        }
        $data_orden['metodo_pago']="PSE";
        //minimo baloto 15000 minimo efecty 20000
        
        $data_orden['fecha']=date("Y-m-d H:i:s");
        $data_orden['nombre_referencia']="test_".date("Y_m_d_H_i_s")."_".$this->session->userdata('user_details')[0]->cid;
        $fecha_actual = date("Y-m-d H:i:s");
        //sumo 1 día
         
        $data_orden['expire_date']=date("Y-m-d H:i:s",strtotime($fecha_actual."+ 1 days")); 
        $xd=new DateTime($data_orden['expire_date']);
        $fecha_expiracion=$xd->format("Y-m-d")."T".$xd->format("H:i:s").".804";
       $var=$_SESSION['key_p']."~967931~".$data_orden['nombre_referencia']."~".$data_orden['monto']."~COP";
        $data_orden['SessionId']=$deviceSessionId;
        $this->db->insert("orden_de_pago",$data_orden);

        $signature=md5($var);
       $cuerpo_de_la_respuesta='{
   "language": "es",
   "command": "SUBMIT_TRANSACTION",
   "merchant": {
      "apiKey": "'.$_SESSION['key_p'].'",
      "apiLogin": "'.$_SESSION['user_p'].'"
   },
   "transaction": {
      "order": {
         "accountId": "975762",
         "referenceCode": "'.$data_orden['nombre_referencia'].'",
         "description": "Pago de facturas vestel",
         "language": "es",
         "signature": "'.$signature.'",
         "notifyUrl": "https://vestel.com.co/crm/tickets/data_reception",
         "additionalValues": {
            "TX_VALUE": {
               "value": '.$data_orden['monto'].',
               "currency": "COP"
         },
            "TX_TAX": {
               "value": 0,
               "currency": "COP"
         }
         },
         "buyer": {
            "merchantBuyerId": "1",
            "fullName": "'.$this->session->userdata('user_details')[0]->name.'",
            "emailAddress": "'.$_POST['pse_correo'].'",
            "contactPhone": "'.$_POST['pse_telefono'].'",
            "dniNumber": "'.$_POST['pse_doc'].'",
            "shippingAddress": {
               "street1": "Cr 23 No. 53-50",
               "street2": "5555487",
               "city": "Bogotá",
               "state": "Bogotá D.C.",
               "country": "CO",
               "postalCode": "000000",
               "phone": "7563126"
            }
         },
         "shippingAddress": {
            "street1": "Cr 23 No. 53-50",
            "street2": "5555487",
            "city": "Bogotá",
            "state": "Bogotá D.C.",
            "country": "CO",
            "postalCode": "0000000",
            "phone": "7563126"
         }
      },
      "payer": {
         "merchantPayerId": "1",
         "fullName": "'.$this->session->userdata('user_details')[0]->name.'",
         "emailAddress": "'.$_POST['pse_correo'].'",
         "contactPhone": "7563126",
         "dniNumber": "'.$_POST['pse_doc'].'",
         "billingAddress": {
            "street1": "Cr 23 No. 53-50",
            "street2": "125544",
            "city": "Bogotá",
            "state": "Bogotá D.C.",
            "country": "CO",
            "postalCode": "000000",
            "phone": "'.$_POST['pse_telefono'].'"
         }
      },
      "extraParameters": {
         "RESPONSE_URL": "https://vestel.com.co/crm/invoices/",
         "PSE_REFERENCE1": "127.0.0.1",
         "FINANCIAL_INSTITUTION_CODE": "'.$_POST['pse_bank'].'",
         "USER_TYPE": "'.$_POST['pse_person_type'].'",
         "PSE_REFERENCE2": "CC",
         "PSE_REFERENCE3": "123456789"
      },
      "type": "AUTHORIZATION_AND_CAPTURE",
      "paymentMethod": "PSE",
      "paymentCountry": "CO",
      "deviceSessionId": "'.$deviceSessionId.'",
      "ipAddress": "127.0.0.1",
      "cookie": "'.$_COOKIE['ci_sessions'].'",
      "userAgent": "'.$_SERVER['HTTP_USER_AGENT'].'"
   },
   "test": false
}';
        
          $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.payulatam.com/payments-api/4.0/service.cgi',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 399,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>$cuerpo_de_la_respuesta,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            //'Content-Length: length' //esta linea es la que causa el error por esta es la longitud de los bites de la informacion enviada por post, revisar codigo java en android ws
            
          ),
        ));

         $respuesta= curl_exec($curl);
        curl_close($curl);
        //var_dump($respuesta);
        //var_dump($cuerpo_de_la_respuesta);
        $dataup=array("data"=>$respuesta);
        $this->db->update("orden_de_pago",$dataup,array("nombre_referencia"=>$data_orden['nombre_referencia']));
        $data_json=json_decode($respuesta);
        //$x->transactionResponse->extraParameters->URL_PAYMENT_RECEIPT_HTML
        $r=array("status"=>"SUCCESS");
        if($data_json->code=="SUCCESS"){
            $r['url']=$data_json->transactionResponse->extraParameters->BANK_URL;
        }else{

            $r=array("status"=>"Error");
        }
        //pruebas@payulatam.com
        echo json_encode($r);
    }
    public function recharge()
    {
        $head['title'] = "Payments";
        $data['balance']=$this->payments->balance($this->session->userdata('user_details')[0]->cid);
        $data['activity']=$this->payments->activity($this->session->userdata('user_details')[0]->cid);
        $this->load->view('includes/header');
        $this->load->view('payments/recharge',$data);
        $this->load->view('includes/footer');
    }


    public function ajax_list()
    {
        //$query = $this->db->query("SELECT currency FROM app_system WHERE id=1 LIMIT 1");
        //$row = $query->row_array();

        //$this->config->set_item('currency', $row["currency"]);


        $list = $this->payments->get_datatables();
        $data = array();

        $no = $this->input->post('start');
       // $curr = $this->config->item('currency');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $invoices->fecha;
            $row[] = $invoices->debe;
            $row[] = $invoices->metodo_pago;
            if($invoices->estado=="Finalizada con Exito"){
                $row[] = "<div class='cl-pagado'>".$invoices->estado."</div>";    
            }else{
                $row[] = $invoices->estado;
            }
            $row[] = $invoices->reference;
            $row[] = $invoices->id_wompi;
            
            
            //$row[] = $invoices->data;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->payments->count_all(),
            "recordsFiltered" => $this->payments->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }




}