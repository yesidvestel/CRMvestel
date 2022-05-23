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
        $this->load->model('clientgroup_model', 'clientgroup');
        $this->load->model('customers_model', 'customers');
        $this->load->model('notas_model', 'notas');
               
        $this->load->library("Aauth");
        $bool=false;
        ob_end_clean();
        
                $request=file_get_contents("php://input",true);
                $body_post=json_decode($request,true);    
                $bool=$this->notas->sfgsagety785625($body_post['24q5ewqas'],$body_post['112415qwturf']);        

        
        
       
        /*if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>fuera de aqui en el nombre de jesus, o el señor se encargara de ti, no probloques su ira mejor arrepientete y ven a los pies de cristo.. bye</h3>');

        }*/
    }

    //groups
    public function index()
    {

        
          $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://vestel.com.co/crm/tickets/data_reception',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
   "language": "es",
   "command": "SUBMIT_TRANSACTION",
   "merchant": {
      "apiKey": "x",
      "apiLogin": "x"
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
         var_dump(curl_error($curl));
        curl_close($curl);
        var_dump($respuesta);
        echo $respuesta;
        /*$response['status'] = 200;
        $response['status_message'] = "asdasd";
        $response['data'] = null;
 ob_end_clean();


header("Content-Type:application/json");
        header("HTTP/1.1 200 ok");
        $json_response = json_encode($response);
        echo $json_response;*/
    }
   public function deliver_response($status, $status_message, $data)
    {
        header("HTTP/1.1 $status $status_message");
        $response['status'] = $status;
        $response['status_message'] = $status_message;
        $response['data'] = $data;
 
        $json_response = json_encode($response);
        echo $json_response;
    }
    public function get_due_customer(){
        $body_post=json_decode(file_get_contents("php://input",true));//obteniendo datos post        
        $data_response=array();
        $data_response['due']=$this->customers->due_details($body_post->cid);
        $data_response['data_customer']=$this->db->get_where("customers",array("cid"=>$body_post->cid))->row()
        echo json_encode($data_response);
    }


     public function inv_list()
    {
        //ob_end_clean(); //linea para borrar link de activate por no comprar premium
        $body_post=json_decode(file_get_contents("php://input",true));//obteniendo datos post
        
        $cid = $body_post->cid;
        $no = $body_post->start;
        $_POST['length']=$body_post->length;
        $_POST['start']=$body_post->start;
        if(isset($body_post->search)){
            $_POST['search']['value']=$body_post->search;
        }
        if(isset($body_post->order)){

            foreach ($body_post->order as $key => $value) {
                $_POST['order'][]=(array) $value;
            }
        }
        //var_dump($body_post->order);
        $list = $this->customers->inv_datatables($cid);
        $data = array();
        $ultima_factura=$this->customers->servicios_detail($cid);
        $usuario=$this->customers->get_customer_id($cid);
        
        foreach ($list as $invoices) {
            $no++;
            $row = array();
           /* if($invoices->ron=="Cortado"){
                $total_factura=$invoices->total;
                $refer_var =strtolower(str_replace(' ', '', $invoices->refer));
                if($invoices->status=="partial"){
                    $total_factura=$invoices->total-$invoices->pamnt;
                }
                if($invoices->status=="paid"){
                    $row[] = '<a href="'.base_url().'invoices/view?id='.$invoices->tid.'">Cortado</a>';
                }else{
                    $row[] = '<input type="checkbox" name="x" class="facturas_para_pagar" data-id-ultima-factura="'.$ultima_factura['tid'].'" data-total=" '.$total_factura.'" data-idfacturas="'.$invoices->tid.'" data-status="'.$invoices->status.'" data-ron="cortado" data-rec="'.$invoices->rec.'" data-refer="'.$refer_var.'" style="cursor:pointer; margin-left: 9px;" onclick="agregar_factura(this)" ></input><a href="'.base_url().'invoices/view?id='.$invoices->tid.'">&nbspCortado</a>';
                }
            }else if($invoices->status=="paid"){
                if($invoices->tid==$ultima_factura['tid']){

                    $row[] = '<a href="#" id="id-ultima-factura" class="btn btn-danger"><span class="icon-edit" title="Activar Seleccionar"></span></a><input id="ck-ultima-fac" type="checkbox" name="x" class="facturas_para_pagar" data-id-ultima-factura="'.$ultima_factura['tid'].'" data-total=" '.$invoices->total.'" data-idfacturas="'.$invoices->tid.'" data-status="'.$invoices->status.'" data-ron="no" data-rec="'.$invoices->rec.'" data-refer="" style="cursor:pointer; margin-left: 9px;display:none;" onclick="agregar_factura(this)" ></input>';//'';    
                }else{
                    $row[]="";
                }
                
            }else{
                $total_factura=$invoices->total;
                if($invoices->status=="partial"){
                    $total_factura=$invoices->total-$invoices->pamnt;
                }
                $row[] = '<input type="checkbox" name="x" class="facturas_para_pagar" data-id-ultima-factura="'.$ultima_factura['tid'].'" data-total=" '.$total_factura.'" data-idfacturas="'.$invoices->tid.'" data-status="'.$invoices->status.'" data-ron="no" data-rec="'.$invoices->rec.'" data-refer="" style="cursor:pointer; margin-left: 9px;" onclick="agregar_factura(this)" ></input>';    
            }
            */
            
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $usuario->name;
            //$row[] = $invoices->tipo_factura;
            $row[] = $invoices->invoicedate;
            //$row[] = '<span class="st-' . $invoices->ron . '">' . $invoices->ron . '</span>';
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';

            $lisa_resivos_agregar_st="";
                                //$transacciones = $this->db->get_where("transactions",array("tid"=>$invoices->tid,"estado"=>null))->result_array();
                                $lista_de_resivos=json_decode($invoices->resivos_guardados);
                                if($lista_de_resivos==null){
                                    $lista_de_resivos=array();
                                }
                                foreach ($lista_de_resivos as $key => $value) {
                                    $fecha = new DateTime($value->date);
                                    $lisa_resivos_agregar_st.='<a class="dropdown-item" style="padding:3px 0px;"
                                           href="'.base_url().'invoices/printinvoice2?file_name='.$value->file_name.'">&nbsp;&nbsp;R'.$key.' - '.$fecha->format("d/m/Y").'</a>';
                                    $lisa_resivos_agregar_st.='<div class="dropdown-divider"></div>';
                                }
            if($lisa_resivos_agregar_st!=""){
            $resivos_var='<div class="btn-group dropup">
                                    <button type="button" class="btn btn-success dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="icon-download"></i> 
                                    </button>
                                    <div class="dropdown-menu" style="left:-100">
                                        '.$lisa_resivos_agregar_st.'
                                        
                                        
                                    </div>
                                </div>';

            }else{
                $resivos_var='';
            }
            $row[] = '<a  href="https://vestel.com.co/crm/invoices/view?id='.$invoices->tid.'" class="btn btn-success btn-xs"><i class="icon-file-text"></i> '.$this->lang->line('View').'</a> &nbsp; '.$resivos_var.'&nbsp;&nbsp;';
            //$row[] = '<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';
            $data[] = $row;
        }
        

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->inv_count_all($cid),
            "recordsFiltered" => $this->customers->inv_count_filtered($cid),
            "data" => $data,
        );
        //output to json format

        echo json_encode($output);

    }
}