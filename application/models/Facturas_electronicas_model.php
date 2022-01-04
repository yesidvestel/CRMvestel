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

class Facturas_electronicas_model extends CI_Model
{
    var $table = 'facturacion_electronica_siigo';
    var $column_order = array('consecutivo_siigo', 'fecha', 'customer_id', 'invoice_id', 'servicios_facturados', "s1TotalValue","s1TaxValue");
    var $column_search = array('consecutivo_siigo', 'fecha', 'customer_id', 'invoice_id', 'servicios_facturados', "s1TotalValue","s1TaxValue");
    var $order = array('consecutivo_siigo' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

   

  
    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        //$this->db->join('supplier', 'purchase.csd=supplier.id', 'left');
        if(isset($_GET['id']) && $_GET['id']!=""){
           $this->db->where("customer_id",$_GET['id']); 
        }

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function generar_factura_customer_para_multiple($datos_facturar,$api){
        /*$this->load->library('SiigoAPI');
        $api = new SiigoAPI();*/
        $this->load->model("customers_model","customers");
        $dataApiTV=null;
        $dataApiNET=null;
        //var_dump($datos_facturar['servicios']);
        if($datos_facturar['servicios']=="Combo"){
            $dataApiNET=$this->customers->getFacturaElectronica(null);
            //var_dump($dataApiNET);
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                $dataApiTV= $this->customers->getFacturaElectronica(2);//verificar este caso
            }else{
                $dataApiTV= $this->customers->getFacturaElectronica(null);    
            }
        }else if($datos_facturar['servicios']=="Internet"){
            $dataApiNET= $this->customers->getFacturaElectronica(null);
        }else if($datos_facturar['servicios']=="Television"){
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                $dataApiTV= $this->customers->getFacturaElectronica(2);    //y este caso
            }else{
                $dataApiTV= $this->customers->getFacturaElectronica(null);    
            }            
        }
        $centro_de_costo_code="1074";
        $centro_de_costo_codeNET="69";
        
        //$consecutivo_siigo=$this->db->select("max(consecutivo_siigo)+1 as consecutivo_siigo")->from("facturacion_electronica_siigo")->get()->result();
        /*$dataApiTV->Header->Number=$consecutivo_siigo[0]->consecutivo_siigo;

        if($dataApiTV->Header->Number=="1" || $dataApiTV->Header->Number==NULL || $dataApiTV->Header->Number=="0"){
            $dataApiTV->Header->Number=500;
        }*/
        //customer data and facturacion_electronica_siigo table insert
        $customer = $this->db->get_where("customers",array('id' =>$datos_facturar['id']))->row();
        //cuadrando customer para crear o actualizar en siigo
        
        $json_customer=json_decode($this->customers->getCustomerJson());
//var_dump($json_customer->address->address);
//echo "<br>";
        $json_customer->identification=$customer->documento;
        $firs_name=strtoupper(str_replace("?", "Ñ",$customer->name));
        $second_name=strtoupper(str_replace("?", "Ñ",$customer->dosnombre));
        $first_last_name=strtoupper(str_replace("?", "Ñ",$customer->unoapellido));
        $second_last_name=strtoupper(str_replace("?", "Ñ",$customer->dosapellido));
        $json_customer->name[0]=$firs_name." ".$second_name;
        $json_customer->name[1]=$first_last_name." ".$second_last_name;
        $json_customer->address->address=$customer->nomenclatura . ' ' . $customer->numero1 . $customer->adicionauno.' Nº '.$customer->numero2.$customer->adicional2.' - '.$customer->numero3;
        //$tv_product= $this->db->get_where("products", array('pid' => "27"))->row();
            if(strpos(strtolower($customer->ciudad),"monterrey" )!==false){
                        $json_customer->address->city->city_code="85162";
                        $centro_de_costo_code="1070";
                        $centro_de_costo_codeNET="165";                                   
            }else if(strpos(strtolower($customer->ciudad),"villanueva" )!==false){
                $json_customer->address->city->city_code="85440";                                   
                $centro_de_costo_code="1072";
                $centro_de_costo_codeNET="167";
            }else if(strpos(strtolower($customer->ciudad),"mocoa" )!==false){
                $json_customer->address->city->state_code="86";                                   
                $json_customer->address->city->city_code="86001";   
                //$tv_product= $this->db->get_where("products", array('pid' => "159"))->row();                                
            }

            //var_dump(preg_match_all("/[^0-9]/",$customer->celular));
            
            if(strlen($customer->celular)>10 || preg_match_all("/[^0-9]/",$customer->celular)!=0){
                $customer->celular="0";
            }
            if(strlen($customer->celular2)>10 || preg_match_all("/[^0-9]/",$customer->celular2)!=0){
                $customer->celular2="0";
            }
            //falta validar que si no tiene celular al crear elimine el array de contactos para que no quede en cero y luego al actualizar cliente cree un contacto aparte y quede ese en 0
                   
            $json_customer->phones[0]->number=$customer->celular;
            $json_customer->contacts[0]->first_name=$firs_name." ".$second_name;
            $json_customer->contacts[0]->last_name=$first_last_name." ".$second_last_name;
            $json_customer->contacts[0]->email="vestelsas@gmail.com";

            $json_customer->contacts[0]->phone->number=$customer->celular;
            $json_customer->comments="Estrato : ".$customer->estrato;
    //llenando los datos para crear o actualizar segun sea el caso
           // var_dump($json_customer);
            
            $json_customer=json_encode($json_customer);


           
            
        
        // end cuadrando customer para crear o actualizar en siigo
        //data siigo api
        $dateTime=new DateTime($datos_facturar['sdate']);
            
        //cambio de fecha de vencimiento sumandole 20 dias a la fecha seleccionada
            $fecha_actual = date($dateTime->format("Y-m-d"));
            $date=date("d-m-Y",strtotime($fecha_actual."+ 20 days")); 
            $dateTimeVencimiento=new DateTime($date);
        //end fecha vencimiento
        
        if($dataApiTV!=null){
            $dataApiTV=json_decode($dataApiTV);
            $dataApiTV->document->id="12434";
            $dataApiTV->customer->identification=$customer->documento;
            $dataApiTV->cost_center=$centro_de_costo_code;
            $dataApiTV->seller="1011";
            $dataApiTV->date=$dateTime->format("Y-m-d");
            $dataApiTV->payments[0]->due_date=$dateTimeVencimiento->format("Y-m-d");
            $dataApiTV->observations="Estrato : ".$customer->estrato;
            $dataApiTV->payments[0]->id="2863";

            $consulta_siigo1=$api->getCustomer($customer->documento,1);
            //var_dump($consulta_siigo1['results']);
            if($consulta_siigo1['results'][0]['id']==null){
                    $api->saveCustomer($json_customer,1);//para crear cliente en siigo si no existe
            }else{
                    //$api->updateCustomer($json_customer,$consulta_siigo1['results'][0]['id'],2);//para acturalizar cliente en siigo 
            }
        }
        if($dataApiNET!=null){
            $dataApiNET=json_decode($dataApiNET);
            $dataApiNET->document->id="27274";
            $dataApiNET->customer->identification=$customer->documento;
            $dataApiNET->cost_center=$centro_de_costo_codeNET;
            $dataApiNET->seller="945";
            $dataApiNET->date=$dateTime->format("Y-m-d");
            $dataApiNET->payments[0]->due_date=$dateTimeVencimiento->format("Y-m-d");
            $dataApiNET->observations="Estrato : ".$customer->estrato;
            $dataApiNET->payments[0]->id="2512";

            $consulta_siigo1=$api->getCustomer($customer->documento,2);
            //var_dump($consulta_siigo1['results']);
            if($consulta_siigo1['results'][0]['id']==null){
                    $api->saveCustomer($json_customer,2);//para crear cliente en siigo si no existe
            }else{
                    //$api->updateCustomer($json_customer,$consulta_siigo1['results'][0]['id'],2);//para acturalizar cliente en siigo 
            }
        }
        
        
        //var_dump($dataApiNET);
        //falta el manejo de los saldos saldos
        

        if($dataApiTV!=null){
            $dataApiTV->items[0]->description="Servicio de Televisión por Cable";
            /*if($tv_product->taxrate!=0){
                $precios=$this->customers->calculoParaFacturaElectronica($tv_product->product_price);
                $dataApiTV->items[0]->price=$precios['valor_sin_iva'];
                $dataApiTV->items[0]->taxes->value=$precios['valor_iva'];
                $dataApiTV->payments[0]->value=$precios['valortotal'];
            }else{

            }*/
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                    $dataApiTV->items[1]->description="Puntos de tv adicionales ".$datos_facturar['puntos'];
                    $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                    $prod=$lista_de_productos[0];

                    $prod->product_price=$prod->product_price*intval($datos_facturar['puntos']);

                    $dataApiTV->items[1]->code="001";

                            $dataApiTV->items[1]->price=$prod->product_price;
                            $dataApiTV->payments[0]->value=$dataApiTV->payments[0]->value+$prod->product_price;                            

            }

            //falta verificar el caso de la tv de mocoa que cambian los valores
        }
         if($dataApiNET!=null){
            $array_servicios=$this->customers->servicios_detail($customer->id);
            if($array_servicios['combo']!="no"){
                $dataApiNET->items[0]->description="Servicio de Internet ".$array_servicios['combo'];
                $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                $array_servicios['combo']=strtolower(str_replace(" ", "",$array_servicios['combo'] ));
                foreach ($lista_de_productos as $key => $prod) {
                    $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                    if($prod->product_name==$array_servicios['combo']){
                        //var_dump($prod->product_name);
                        $dataApiNET->items[0]->code="I01";

                        if($prod->taxrate!=0){

                            //$precios=$this->customers->calculoParaFacturaElectronica($prod->product_price);
                            $v1=($prod->product_price*19)/100;
                            $v2=$v1+$prod->product_price;
                            $dataApiNET->items[0]->taxes[0]->id=5869;
                            $dataApiNET->items[0]->price=$prod->product_price;
                            $dataApiNET->items[0]->taxes[0]->value=$v1;
                            $dataApiNET->payments[0]->value=$v2;

                        }else{
                            unset($dataApiNET->items[0]->taxes);
                            $dataApiNET->items[0]->price=$prod->product_price;                            
                            $dataApiNET->payments[0]->value=$prod->product_price;

                        }
                        
                        
                        break;
                    }
                }
            }
            //falta esta parte identificar el paquete de internet del usuario y agregar sus valores
        }


//var_dump($dataApiNET);
     

        /*var_dump($dateTime->format("Ymd"));
        var_dump($dataApiTV->Payments[0]->DueDate);
        var_dump($dataApiTV->Header->Number);
        var_dump($dataApiTV->Header->Account->Phone->Number);*/
        //facturacion_electronica_siigo table insert        
        $dataInsert=array();
        $dataInsert['consecutivo_siigo']=0;
        $dataInsert['fecha']=$dateTime->format("Y-m-d");
        $dataInsert['customer_id']=$datos_facturar['id'];
        $dataInsert['servicios_facturados']=$datos_facturar['servicios'];
        $dataInsert['creado_con_multiple']=1;
        // end customer data facturacion_electronica_siigo table insert
        //var_dump($dataApiNET);
        $dataApiTV=json_encode($dataApiTV);
        $dataApiNET=json_encode($dataApiNET); 
        //var_dump($dataApiTV);
        $retorno=array("mensaje"=>"No");
        if($dataApiTV!=null && $dataApiTV!="null"){
            $retorno = $api->accionar($api,$dataApiTV,1);     
            if($dataApiNET!=null && $dataApiNET!="null"){
                $retorno = $api->accionar($api,$dataApiNET,2);     
            }
        }else if($dataApiNET!=null && $dataApiNET!="null"){
            $retorno = $api->accionar($api,$dataApiNET,2);     
        }
        

        if($retorno['mensaje']=="Factura Guardada"){
            $this->db->insert("facturacion_electronica_siigo",$dataInsert);
            $retor=array("status"=>true);
            return $retor;
        }else{
            /*$error_era_consecutivo=false;
            for ($i=1; $i < 10 ; $i++) { 
                $dataApiTV=json_decode($dataApiTV);
                $dataApiTV->Header->Number= intval($dataApiTV->Header->Number)+$i;
                $dataInsert['consecutivo_siigo']=$dataApiTV->Header->Number;
                $dataApiTV=json_encode($dataApiTV);
                $retorno2 = $api->accionar($api,$dataApiTV);              
                if($retorno2['mensaje']=="Factura Guardada"){
                    $this->db->insert("facturacion_electronica_siigo",$dataInsert);
                    $error_era_consecutivo=true;
                    $i=11;
                    redirect("facturasElectronicas?id=".$customer->id);
                    break;
                }
            }*/
            //if($error_era_consecutivo==false){
                //var_dump($retorno['respuesta']);
            //}
            $retor=array("status"=>false,'respuesta'=>$retorno['respuesta']);
            return $retor;
        }
    }

}