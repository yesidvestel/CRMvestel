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

    public function generar_factura_customer_para_multiple($datos_facturar){
        $this->load->library('SiigoAPI');
        $api = new SiigoAPI();
        $this->load->model("customers_model","customers");
        $dataApi;
        if($datos_facturar['servicios']=="Combo"){           
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                $dataApi= $this->customers->getClientData3Productos();//verificar este caso
            }else{
                $dataApi= $this->customers->getClientData2Productos();    
            }
        }else if($datos_facturar['servicios']=="Internet"){
            $dataApi= $this->customers->getClientData();
        }else if($datos_facturar['servicios']=="Television"){
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                $dataApi= $this->customers->getClientData2Productos();    //y este caso
            }else{
                $dataApi= $this->customers->getClientData();    
            }            
        }
        
        $dataApi=json_decode($dataApi);
        //$consecutivo_siigo=$this->db->select("max(consecutivo_siigo)+1 as consecutivo_siigo")->from("facturacion_electronica_siigo")->get()->result();
        /*$dataApi->Header->Number=$consecutivo_siigo[0]->consecutivo_siigo;

        if($dataApi->Header->Number=="1" || $dataApi->Header->Number==NULL || $dataApi->Header->Number=="0"){
            $dataApi->Header->Number=500;
        }*/
        //customer data and facturacion_electronica_siigo table insert
        $customer = $this->db->get_where("customers",array('id' =>$datos_facturar['id']))->row();
        //data siigo api
        $dataApi->Header->Account->FullName=strtoupper($customer->name." ".$customer->dosnombre." ".$customer->unoapellido." ".$customer->dosapellido);         
        $dataApi->Header->Account->FullName=str_replace("?", "Ñ", $dataApi->Header->Account->FullName);
        $dataApi->Header->Account->FirstName=strtoupper(str_replace("?", "Ñ",$customer->name));
        $dataApi->Header->Account->LastName=strtoupper(str_replace("?", "Ñ",$customer->unoapellido));
        $dataApi->Header->Account->Identification=$customer->documento;
        if(strpos(strtolower($customer->ciudad),"monterrey" )!==false){
            $dataApi->Header->Account->City->CityCode="85162";
            $dataApi->Header->CostCenterCode="M01";                                   
        }else if(strpos(strtolower($customer->ciudad),"villanueva" )!==false){
            $dataApi->Header->Account->City->CityCode="85440";                                   
            $dataApi->Header->CostCenterCode="V01";
        }else if(strpos(strtolower($customer->ciudad),"mocoa" )!==false){
            $dataApi->Header->Account->City->StateCode="86";                                     
            $dataApi->Header->Account->City->CityCode="86001";
        }
        //$dataApi->Header->CostCenterCode="Y01";
        $dataApi->Header->Account->Address=$customer->nomenclatura . ' ' . $customer->numero1 . $customer->adicionauno.' Nº '.$customer->numero2.$customer->adicional2.' - '.$customer->numero3;
        if(strlen($customer->celular)>10){
            $customer->celular="0";
        }
        if(strlen($customer->celular2)>10){
            $customer->celular2="0";
        }
        $dataApi->Header->Account->Phone->Number=$customer->celular;
        $dataApi->Header->Contact->Phone1->Number=$customer->celular2;
        $dataApi->Header->Contact->Mobile->Number=$customer->celular;
        /*if($customer->email!=""){
            $dataApi->Header->Contact->EMail=$customer->email;
        }*/
        $dataApi->Header->Contact->EMail="vestelsas@gmail.com";
        //$dataApi->Header->Contact->EMail=$customer->email;//genera error sirve de validacion para mandar al final del desarrollo alertas con los posibles errores para que contacten con el desarrollador osease yo en caso tal
        $dataApi->Header->Contact->FirstName=$dataApi->Header->Account->FirstName;
        $dataApi->Header->Contact->LastName=$dataApi->Header->Account->LastName;
        $dateTime=new DateTime($datos_facturar['sdate']);
        $dataApi->Header->DocDate=$dateTime->format("Ymd");

        //cambio de fecha de vencimiento sumandole 20 dias a la fecha seleccionada
            $fecha_actual = date($dateTime->format("Y-m-d"));
            $date=date("d-m-Y",strtotime($fecha_actual."+ 20 days")); 
            $dateTimeVencimiento=new DateTime($date);
        //end fecha vencimiento
        $dataApi->Payments[0]->DueDate=$dateTimeVencimiento->format("Ymd");
        //falta el manejo de los saldos saldos
        if($datos_facturar['servicios']=="Television"){
            $dataApi->Items[0]->Description="Servicio de Televisión por Cable";
            //agregar valores reales de televicion deacuerdo a que en diferentes a yopal cambia el valor

            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                    $dataApi->Items[1]->Description="Puntos de tv adicionales ".$datos_facturar['puntos'];
                    $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                    $prod=$lista_de_productos[0];

                    $prod->product_price=$prod->product_price*intval($datos_facturar['puntos']);

                    $dataApi->Items[1]->ProductCode="001";

                            //valores para no generar iva
                            $dataApi->Items[1]->TaxAddName="";
                            $dataApi->Items[1]->TaxAddId="-1";
                            $dataApi->Items[1]->TaxAddValue="0";
                            $dataApi->Items[1]->TaxAddPercentage="0";   
                            //$dataApi->Header->VATTotalValue="0";  //se comenta porque se mantiene el de la tv
                            //valores de total;
                            $dataApi->Payments[0]->Value=$prod->product_price+$dataApi->Payments[0]->Value;
                            $dataApi->Items[1]->TotalValue=$prod->product_price;
                            $dataApi->Header->TotalValue=$prod->product_price+$dataApi->Header->TotalValue;//total de todo con iva
                            //valores restados
                            $dataApi->Items[1]->UnitValue=$prod->product_price;
                            $dataApi->Items[1]->BaseValue=$prod->product_price;
                            $dataApi->Items[1]->GrossValue=$prod->product_price;

                            $dataApi->Header->TotalBase=$prod->product_price+$dataApi->Header->TotalBase;//total de todo sin iva    

            }

            //falta verificar el caso de la tv de mocoa que cambian los valores
        }else if($datos_facturar['servicios']=="Internet"){
            $array_servicios=$this->customers->servicios_detail($customer->id);
            if($array_servicios['combo']!="no"){
                $dataApi->Items[0]->Description="Servicio de Internet ".$array_servicios['combo'];
                $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                $array_servicios['combo']=strtolower(str_replace(" ", "",$array_servicios['combo'] ));
                foreach ($lista_de_productos as $key => $prod) {
                    $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                    if($prod->product_name==$array_servicios['combo']){
                        //var_dump($prod->product_name);
                        $dataApi->Items[0]->ProductCode="l01";
                        if($prod->taxrate!=0){
                            //valores para generar iva
                            $valor_iva=($prod->product_price*$prod->taxrate)/100;
                            $valor_iva=round($valor_iva);
                            $dataApi->Items[0]->TaxAddName="IVA ".$prod->taxrate."%";
                            $dataApi->Items[0]->TaxAddId="6688";
                            $dataApi->Items[0]->TaxAddValue=$valor_iva;
                            $dataApi->Items[0]->TaxAddPercentage=$prod->taxrate;    
                            $dataApi->Header->VATTotalValue=$valor_iva;
                            //total
                            $prod->product_price+=$valor_iva;
                            $dataApi->Payments[0]->Value=$prod->product_price;
                            $dataApi->Items[0]->TotalValue=$prod->product_price;
                            $dataApi->Header->TotalValue=$prod->product_price;
                            //valores restados
                            $dataApi->Items[0]->UnitValue=$prod->product_price-$valor_iva;
                            $dataApi->Items[0]->BaseValue=$prod->product_price-$valor_iva;
                            $dataApi->Items[0]->GrossValue=$prod->product_price-$valor_iva;

                            $dataApi->Header->TotalBase=$prod->product_price-$valor_iva;

                        }else{
                            //valores para no generar iva
                            $dataApi->Items[0]->TaxAddName="";
                            $dataApi->Items[0]->TaxAddId="-1";
                            $dataApi->Items[0]->TaxAddValue="0";
                            $dataApi->Items[0]->TaxAddPercentage="0";   
                            $dataApi->Header->VATTotalValue="0";    
                            //valores de total;
                            $dataApi->Payments[0]->Value=$prod->product_price;
                            $dataApi->Items[0]->TotalValue=$prod->product_price;
                            $dataApi->Header->TotalValue=$prod->product_price;

                            $dataApi->Items[0]->UnitValue=$prod->product_price;
                            $dataApi->Items[0]->BaseValue=$prod->product_price;
                            $dataApi->Items[0]->GrossValue=$prod->product_price;

                            $dataApi->Header->TotalBase=$prod->product_price;   

                        }
                        
                        
                        break;
                    }
                }
            }
            //falta esta parte identificar el paquete de internet del usuario y agregar sus valores
        }

        if($datos_facturar['servicios']=="Combo"){
            //agregar valores reales de televicion deacuerdo a que en diferentes a yopal cambia el valor
            //falta esta parte identificar el paquete de internet del usuario y agregar sus valores
            $dataApi->Items[0]->Description="Servicio de Televisión por Cable";

            //valores de internet

            $array_servicios=$this->customers->servicios_detail($customer->id);
            if($array_servicios['combo']!="no"){
                $dataApi->Items[1]->Description="Servicio de Internet a ".$array_servicios['combo'];
                $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                $array_servicios['combo']=strtolower(str_replace(" ", "",$array_servicios['combo'] ));
                foreach ($lista_de_productos as $key => $prod) {
                    $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                    if($prod->product_name==$array_servicios['combo']){
                        //var_dump($prod->product_name);
                        $dataApi->Items[1]->ProductCode="l01";
                        if($prod->taxrate!=0){
                            //valores para generar iva
                            $valor_iva=($prod->product_price*$prod->taxrate)/100;
                            $valor_iva=round($valor_iva);
                            $dataApi->Items[1]->TaxAddName="IVA ".$prod->taxrate."% ";
                            $dataApi->Items[1]->TaxAddId="6688";
                            $dataApi->Items[1]->TaxAddValue=$valor_iva;
                            $dataApi->Items[1]->TaxAddPercentage=$prod->taxrate;    
                            $dataApi->Header->VATTotalValue=$valor_iva+$dataApi->Header->VATTotalValue;
                            //total
                            
                            $prod->product_price+=$valor_iva;
                            
                            
                            $dataApi->Payments[0]->Value=$prod->product_price+$dataApi->Payments[0]->Value;
                            $dataApi->Items[1]->TotalValue=$prod->product_price;
                            $dataApi->Header->TotalValue=$prod->product_price+$dataApi->Header->TotalValue;//total de todo con iva
                            //valores restados
                            $dataApi->Items[1]->UnitValue=$prod->product_price-$valor_iva;
                            $dataApi->Items[1]->BaseValue=$prod->product_price-$valor_iva;
                            $dataApi->Items[1]->GrossValue=$prod->product_price-$valor_iva;

                            $dataApi->Header->TotalBase=($prod->product_price-$valor_iva)+$dataApi->Header->TotalBase;//total de todo sin iva

                        }else{
                            //valores para no generar iva
                            $dataApi->Items[1]->TaxAddName="";
                            $dataApi->Items[1]->TaxAddId="-1";
                            $dataApi->Items[1]->TaxAddValue="0";
                            $dataApi->Items[1]->TaxAddPercentage="0";   
                            //$dataApi->Header->VATTotalValue="0";  //se comenta porque se mantiene el de la tv
                            //valores de total;
                            $dataApi->Payments[0]->Value=$prod->product_price+$dataApi->Payments[0]->Value;
                            $dataApi->Items[1]->TotalValue=$prod->product_price;
                            $dataApi->Header->TotalValue=$prod->product_price+$dataApi->Header->TotalValue;//total de todo con iva
                            //valores restados
                            $dataApi->Items[1]->UnitValue=$prod->product_price;
                            $dataApi->Items[1]->BaseValue=$prod->product_price;
                            $dataApi->Items[1]->GrossValue=$prod->product_price;

                            $dataApi->Header->TotalBase=$prod->product_price+$dataApi->Header->TotalBase;//total de todo sin iva    

                        }
                        
                        if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                                $dataApi->Items[2]->Description="Puntos de tv adicionales ".$datos_facturar['puntos'];
                                $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                                $prod=$lista_de_productos[0];
                                $prod->product_price=$prod->product_price*intval($datos_facturar['puntos']);
                                $dataApi->Items[2]->ProductCode="001";

                                        //valores para no generar iva
                                        $dataApi->Items[2]->TaxAddName="";
                                        $dataApi->Items[2]->TaxAddId="-1";
                                        $dataApi->Items[2]->TaxAddValue="0";
                                        $dataApi->Items[2]->TaxAddPercentage="0";   
                                        //$dataApi->Header->VATTotalValue="0";  //se comenta porque se mantiene el de la tv
                                        //valores de total;
                                        $dataApi->Payments[0]->Value=$prod->product_price+$dataApi->Payments[0]->Value;
                                        $dataApi->Items[2]->TotalValue=$prod->product_price;
                                        $dataApi->Header->TotalValue=$prod->product_price+$dataApi->Header->TotalValue;//total de todo con iva
                                        //valores restados
                                        $dataApi->Items[2]->UnitValue=$prod->product_price;
                                        $dataApi->Items[2]->BaseValue=$prod->product_price;
                                        $dataApi->Items[2]->GrossValue=$prod->product_price;

                                        $dataApi->Header->TotalBase=$prod->product_price+$dataApi->Header->TotalBase;//total de todo sin iva    

                        }
                        break;
                    }
                }
            }
        }

        /*var_dump($dateTime->format("Ymd"));
        var_dump($dataApi->Payments[0]->DueDate);
        var_dump($dataApi->Header->Number);
        var_dump($dataApi->Header->Account->Phone->Number);*/
        //facturacion_electronica_siigo table insert        
        $dataInsert=array();
        $dataInsert['consecutivo_siigo']=0;
        $dataInsert['fecha']=$dateTime->format("Y-m-d");
        $dataInsert['customer_id']=$datos_facturar['id'];
        $dataInsert['servicios_facturados']=$datos_facturar['servicios'];
        $dataInsert['creado_con_multiple']=1;
        // end customer data facturacion_electronica_siigo table insert
        $dataApi=json_encode($dataApi); 
        //var_dump($dataApi);
        $retorno = $api->accionar($api,$dataApi); 

        if($retorno['mensaje']=="Factura Guardada"){
            $this->db->insert("facturacion_electronica_siigo",$dataInsert);
            $retor=array("status"=>true);
            return $retor;
        }else{
            /*$error_era_consecutivo=false;
            for ($i=1; $i < 10 ; $i++) { 
                $dataApi=json_decode($dataApi);
                $dataApi->Header->Number= intval($dataApi->Header->Number)+$i;
                $dataInsert['consecutivo_siigo']=$dataApi->Header->Number;
                $dataApi=json_encode($dataApi);
                $retorno2 = $api->accionar($api,$dataApi);              
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