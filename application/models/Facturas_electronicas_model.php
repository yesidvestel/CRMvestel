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
        /*validaciones por tipo documento*/
            if($customer->tipo_documento=="NIT"){
                $json_customer->id_type="31";
                $json_customer->person_type="Company";
                $json_customer->name[0].=" ".$first_last_name." ".$second_last_name;
                unset($json_customer->name[1]);
            }
        /*end validaciones por tipo documento*/
        $json_customer->address->address=$customer->nomenclatura . ' ' . $customer->numero1 . $customer->adicionauno.' Nº '.$customer->numero2.$customer->adicional2.' - '.$customer->numero3;
        //$tv_product= $this->db->get_where("products", array('pid' => "27"))->row();
            if($customer->gid==4 ){//monterrey
                        $json_customer->address->city->city_code="85162";
                        $centro_de_costo_code="1070";
                        $centro_de_costo_codeNET="165";                                   
            }else if($customer->gid==3 ){//villanueva
                $json_customer->address->city->city_code="85440";                                   
                $centro_de_costo_code="1072";
                $centro_de_costo_codeNET="167";
            }else if($customer->gid==5 ){//mocoa
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
            $json_customer->contacts[0]->email="vesgatelevision@gmail.com";
            /* contacto 2 para configurar email del usuario 
                $json_customer->contacts[1]->first_name=$firs_name." ".$second_name;
                $json_customer->contacts[1]->last_name=$first_last_name." ".$second_last_name;
                $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";

               // if(preg_match($regex, $customer->email)){
                    $json_customer->contacts[1]->email=$customer->email;    
                //}
                
             end */

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
           
            
            if($consulta_siigo1['pagination']['total_results']==0){
                    $api->saveCustomer($json_customer,1);//para crear cliente en siigo si no existe
            }else{
                //var_dump($json_customer);
//                var_dump($consulta_siigo1);
                  //  $api->updateCustomer($json_customer,$consulta_siigo1['results'][0]['id'],1);//para acturalizar cliente en siigo 
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
          
            
            if($consulta_siigo1['pagination']['total_results']==0){
                    $json_customer=json_decode($json_customer);
                    $json_customer->related_users->seller_id=282;
                    $json_customer->related_users->collector_id=282;
                    $json_customer->contacts[0]->email="vestelsas@gmail.com";
                    $json_customer=json_encode($json_customer);
                    //$json_customer=str_replace("321", "282", subject)
                    $api->saveCustomer($json_customer,2);//para crear cliente en siigo si no existe
            }else{ /*esto estaba comentado el update
                    $json_customer=json_decode($json_customer);
                    $json_customer->related_users->seller_id=282;
                    $json_customer->related_users->collector_id=282;
                    $json_customer->contacts[0]->email="vestelsas@gmail.com";
                    $json_customer=json_encode($json_customer);

                    $api->updateCustomer($json_customer,$consulta_siigo1['results'][0]['id'],2);//para acturalizar cliente en siigo 
                    */
            }
        }
        
        
        //var_dump($dataApiNET);
        //falta el manejo de los saldos saldos
        

        if($dataApiTV!=null){
            $dataApiTV->items[0]->description="Servicio de Televisión por Cable";
            

            $itemPuntoComercial=$this->db->get_where("invoice_items",array("product"=>"PuntoComercial","tid"=>$datos_facturar['tid_ult_fact']))->row();
            if(!empty($itemPuntoComercial)){
                $dataApiTV->items[0]->description="Puntos de Tv Comerciales ".$itemPuntoComercial->qty;
                //$itemPuntoComercial->price=$itemPuntoComercial->price*$itemPuntoComercial->qty;
                         
                 $dataApiTV->items[0]->code="001";
                            //$v1=($itemPuntoComercial->price*19)/100;
                            $v2=$itemPuntoComercial->price*$itemPuntoComercial->qty;
                            //$dataApiNET->items[0]->taxes[0]->id=5869;
                            $dataApiTV->items[0]->quantity=$itemPuntoComercial->qty;
                            $dataApiTV->items[0]->price=$itemPuntoComercial->price;
                            //$dataApiTV->items[0]->taxes[0]->value=$v1;
                            $dataApiTV->payments[0]->value=$v2;
                             unset($dataApiTV->items[0]->taxes);
                           
            }else if(strtolower($datos_facturar['serv_tv_real'])!="television" && $datos_facturar['serv_tv_real']!="no" && $datos_facturar['serv_tv_real']!="" && $datos_facturar['serv_tv_real']!="-"){
                    $paquete_tv_diff=$this->db->get_where("products", array('product_name' => $datos_facturar['serv_tv_real']))->row();
                    if(isset($paquete_tv_diff)){
                        $dataApiTV->items[0]->description="Television ".$paquete_tv_diff->product_name;
                        
                            $v2=$paquete_tv_diff->product_price;
                            $dataApiTV->items[0]->price=$paquete_tv_diff->product_price;
                            $dataApiTV->payments[0]->value=$v2;
                            if($paquete_tv_diff->taxrate!=0){
                                $v1=($paquete_tv_diff->product_price*19)/100;
                                $v2=$paquete_tv_diff->product_price+$v1;
                                $dataApiTV->items[0]->price=$paquete_tv_diff->product_price;
                                $dataApiTV->items[0]->taxes[0]->value=$v1;
                                $dataApiTV->payments[0]->value=$v2;
                                
                             
                            }else{
                                 $dataApiTV->items[0]->code="001";
                                unset($dataApiTV->items[0]->taxes);
                            }

                    }
            }
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                    /*$dataApiTV->items[1]->description="Puntos de tv adicionales ".$datos_facturar['puntos'];
                    $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                    $prod=$lista_de_productos[0];

                    $prod->product_price=$prod->product_price*intval($datos_facturar['puntos']);

                    $dataApiTV->items[1]->code="001";

                            $dataApiTV->items[1]->price=$prod->product_price;
                            $dataApiTV->payments[0]->value=$dataApiTV->payments[0]->value+$prod->product_price;


*/
                    $dataApiTV->items[1]->description="Puntos de tv adicionales ".$datos_facturar['puntos'];
                    $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                    $prod=$lista_de_productos[0];

                    $v2=$prod->product_price*intval($datos_facturar['puntos']);

                    $dataApiTV->items[1]->code="001";
                            $dataApiTV->items[1]->quantity=$datos_facturar['puntos'];
                            $dataApiTV->items[1]->price=$prod->product_price;
                            $dataApiTV->payments[0]->value=$dataApiTV->payments[0]->value+$v2;                            

            }

            //falta verificar el caso de la tv de mocoa que cambian los valores
        }
        $producto_existe=false;
         if($dataApiNET!=null){
            $array_servicios=$this->customers->servicios_detail($customer->id);
            /*  cambios de abajo se comentan son para facturar cortados*/
            /*
            if($array_servicios['estado']=="Cortado"){
                    if($array_servicios['estado_tv']=="Cortado"){
                            $array_servicios['television']="si";
                    }
                    if($array_servicios['estado_combo']=="Cortado"){
                            $array_servicios['combo']=$array_servicios['paquete'];
                    }
                }*/
            if($array_servicios['combo']!="no"){
                $dataApiNET->items[0]->description="Servicio de Internet ".$array_servicios['combo'];
                $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                $array_servicios['combo']=strtolower(str_replace(" ", "",$array_servicios['combo'] ));
                foreach ($lista_de_productos as $key => $prod) {
                    $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                    if($prod->product_name==$array_servicios['combo']){
                        $producto_existe=true;
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
             
            if($dataApiNET!=null && $dataApiNET!="null" && $producto_existe==true){
                $retorno = $api->accionar($api,$dataApiNET,2);     
              
            }
        }else if($dataApiNET!=null && $dataApiNET!="null" && $producto_existe==true){
            $retorno = $api->accionar($api,$dataApiNET,2);     
          
        }
        

        if($retorno['mensaje']=="Factura Guardada"){
            //$dataInsert['customer_id']=$datos_facturar['id'];
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
    public function cargar_configuraciones_para_facturar(){
        $list=$this->db->get_where("config_facturacion_electronica")->result_array();
        $data_ses=array();
        if($list[0]['nombre']=="Todo"){
            $data_ses[0]=array("username"=>$list[0]['username'],"access_key"=>$list[0]['access_key']);
        }else{
            $data_ses[0]=array("username"=>$list[0]['username'],"access_key"=>$list[0]['access_key'],"nombre"=>$list[0]['nombre']);
            $data_ses[1]=array("username"=>$list[1]['username'],"access_key"=>$list[1]['access_key'],"nombre"=>$list[1]['nombre']);

        }
        $_SESSION['array_accesos_siigo']=$data_ses;
    }
     public function generar_factura_customer_para_multiple_ottis($datos_facturar,$api){
        $this->load->model("Reports_model","reports");
         /*$this->load->library('SiigoAPI');
        $api = new SiigoAPI();*/
        $this->load->model("customers_model","customers");
        $this->load->model("invoices_model","invocies");
        $dataApiNET=null;
        $items_facturados=array();
        $invoice_facturar = $this->db->get_where("invoices",array('id' =>$datos_facturar['id_facturar']))->row();
        $datos_facturar['tid']=$invoice_facturar->tid;
        $customer = $this->db->get_where("customers",array('id' =>$invoice_facturar->csd))->row();

        $dataApiNET= $this->customers->getFacturaElectronicaOttis_reaciendo();       

         //var_dump($datos_facturar['servicios']);
        $centro_de_costo_codeNET="341";
    
        
        //cuadrando customer para crear o actualizar en siigo
        
        $json_customer=json_decode($this->customers->getCustomerJson());

        $json_customer->identification=$customer->documento;
        $firs_name=strtoupper(str_replace("?", "Ñ",$customer->name));
        $second_name=strtoupper(str_replace("?", "Ñ",$customer->dosnombre));
        $first_last_name=strtoupper(str_replace("?", "Ñ",$customer->unoapellido));
        $second_last_name=strtoupper(str_replace("?", "Ñ",$customer->dosapellido));
        $json_customer->name[0]=$firs_name." ".$second_name;
        $json_customer->name[1]=$first_last_name." ".$second_last_name;
        /*validaciones por tipo documento*/
            if($customer->tipo_documento=="NIT"){
                $json_customer->id_type="31";
                $json_customer->person_type="Company";
                $json_customer->name[0].=" ".$first_last_name." ".$second_last_name;
                unset($json_customer->name[1]);
            }
        /*end validaciones por tipo documento*/
        $json_customer->address->address=$customer->nomenclatura . ' ' . $customer->numero1 . $customer->adicionauno.' Nº '.$customer->numero2.$customer->adicional2.' - '.$customer->numero3;
        //$tv_product= $this->db->get_where("products", array('pid' => "27"))->row();
            
            $json_customer->address->city->city_code="15759";
             $json_customer->address->city->state_code="15";   
                        

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
            $json_customer->contacts[0]->email="prof.ottis01@gmail.com";
            /* contacto 2 para configurar email del usuario 
                $json_customer->contacts[1]->first_name=$firs_name." ".$second_name;
                $json_customer->contacts[1]->last_name=$first_last_name." ".$second_last_name;
                $regex = "/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/";

               // if(preg_match($regex, $customer->email)){
                    $json_customer->contacts[1]->email=$customer->email;    
                //}
                
             end */

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
        
      
        
        if($dataApiNET!=null){
            $dataApiNET=json_decode($dataApiNET);
            $dataApiNET->document->id="28186";
            $dataApiNET->customer->identification=$customer->documento;
            $dataApiNET->cost_center=$centro_de_costo_codeNET;
            $dataApiNET->seller="738";
            $dataApiNET->date=$dateTime->format("Y-m-d");
            $dataApiNET->payments[0]->due_date=$dateTimeVencimiento->format("Y-m-d");
            $accoun_tr="";
            $dataApiNET->payments[0]->id=$datos_facturar['estcuenta'];//efectivo 6960 credito 6941
            if($datos_facturar['estcuenta']=="6960"){
                $ult_tr=$this->db->query("select * from transactions where (estado !='Anulada' or estado is null) and tid=".$datos_facturar['tid']." order by id desc")->result_array();
                if(count($ult_tr)>0){
                    $accoun_tr=$this->db->get_where("accounts",array("id"=>$ult_tr[0]['acid']))->row();
                    if(isset($accoun_tr) && $accoun_tr->cuenta_siigo!=null){
                        $dataApiNET->payments[0]->id=$accoun_tr->cuenta_siigo;
                        $accoun_tr=$accoun_tr->holder;
                    }else{
                        if(isset($accoun_tr)){
                            $accoun_tr=$accoun_tr->holder;
                        }else{
                            $accoun_tr="";    
                        }
                        
                    }
                }    
            }
            $dt_ob=new DateTime($invoice_facturar->invoicedate);
            $str_obs=$this->reports->devolver_nombre_mes($dt_ob->format("m"))." - ".$dt_ob->format("Y");
            $dataApiNET->observations="TID : ".$datos_facturar['tid'].", Factura : ".$str_obs." ,metodo pago: ".$accoun_tr;
            $consulta_siigo1=$api->getCustomer($customer->documento,1);
          
            
            if($consulta_siigo1['pagination']['total_results']==0){
                    $json_customer=json_decode($json_customer);
                    $json_customer->related_users->seller_id=738;
                    $json_customer->related_users->collector_id=738;
                    $json_customer->contacts[0]->email="prof.ottis01@gmail.com";
                    if($customer->email!="" && $customer->email!=null && filter_var($customer->email, FILTER_VALIDATE_EMAIL) ) {
                        $json_customer->contacts[0]->email=$customer->email;
                    }
                    $json_customer=json_encode($json_customer);
                    //$json_customer=str_replace("321", "282", subject)
                    $api->saveCustomer($json_customer,1);//para crear cliente en siigo si no existe
            }else{
                    /*$json_customer=json_decode($json_customer);
                    $json_customer->related_users->seller_id=282;
                    $json_customer->related_users->collector_id=282;
                    $json_customer->contacts[0]->email="vestelsas@gmail.com";
                    $json_customer=json_encode($json_customer);

                    $api->updateCustomer($json_customer,$consulta_siigo1['results'][0]['id'],2);//para acturalizar cliente en siigo */
            }
        }
        
        
        //var_dump($dataApiNET);
        //falta el manejo de los saldos saldos
        

      
        $producto_existe=false;
         if($dataApiNET!=null){
            $count=0;
            $retencion_aplicada=false;
            $porcentaje_retefuente_servicios=4;
            $porcentaje_compras=2.5;
            $porcentaje_personas_no_declarantes=3.5;
           
           $reteiva_aplicado=false;
                $lista_items=$this->db->get_where("invoice_items",array("tid"=>$datos_facturar['tid']))->result_array();
                if(isset($lista_items) && count($lista_items)>0){
                        $otro_pr='{
                          "code": "12SOPIVA1",
                          "description": "DESCRIPCION",
                          "quantity": 1,
                          "price": 21008,
                          "discount": 0.0,
                          "taxes": [
                           {
                                "id": 16992,
                                "name": "RETEFUENTE Compras no declarantes",
                                "type": "Retefuente",
                                "percentage": 3.5,
                                "value": 4200.0
                            },
                            {"id": 4189,
                             "name": "IVA 19% sev",
                             "type": "IVA",
                             "percentage": 19,
                             "value": 3991.6
                            }
                          ]            
                        }';
              
                        foreach ($lista_items as $keysv => $sv) {
                            if($sv['product']=="Nota Credito"){

                            }else{
                            //$dataApiNET->items[]=$prod_add;
                                $prod_add=json_decode($otro_pr);
                                array_push($dataApiNET->items, $prod_add);
                                $pr_sr=$this->db->get_where("products",array("pid"=>$sv['pid']))->row();
                                //$pr_sr->product_price=$sv['price'];
                                $dataApiNET->items[$count]->description="".$sv['product'];
                                $dataApiNET->items[$count]->code=$pr_sr->product_code;
                                $sv['total']=0;
                                $iva_des=0;
                                if($sv['totaldiscount']>0){
                                    if($sv['totaldiscount']>$sv['price']){
                                        $iva_des=$sv['totaldiscount']-$sv['price'];
                                        $sv['price']=0;
                                    }else{
                                        $sv['price']-=$sv['totaldiscount'];                                        
                                    }
                                }
                                if(isset($pr_sr) && $sv['tax']!="0"){
                                    $iva2=($sv['price']*$sv['tax'])/100;//round(($sv['price']*$sv['tax'])/100);
                                    if($iva_des>0){
                                        //$iva2-=$iva_des;
                                    }
                                    $sv['total']+=$iva2;   

                                        //$v1=($prod->product_price*19)/100;
                                        //$v2=$v1+$prod->product_price;
                                        $dataApiNET->items[$count]->quantity=$sv['qty'];
                                        $dataApiNET->items[$count]->taxes[1]->id=4189;
                                        $dataApiNET->items[$count]->price=($sv['price']);
                                        $dataApiNET->items[$count]->taxes[1]->value=($iva2*$sv['qty']);
                                        

                                }else{
                                    unset($dataApiNET->items[$count]->taxes[1]);   
                                    //$dataApiNET->items[$count]->taxes = array_values($dataApiNET->items[$count]->taxes);

                                     $dataApiNET->items[$count]->quantity=$sv['qty'];
                                     $dataApiNET->items[$count]->price=$sv['price'];
                                }
                                $sv['total']+=$sv['price'];
                                $suma=($sv['total']*$sv['qty']);
                                $dataApiNET->payments[0]->value+=$suma;
                                if($invoice_facturar->tipo_retencion!=null){
                                    $id_r="16984";
                                    $name_r='RETEFUENTE Compras no declarantes';
                                    $percentage_r="4.0";
                                    $percentage_r_calculo=4;
                                    $value_r="0";
                                    if($invoice_facturar->tipo_retencion=="Retefuente Servicios"){
                                        $percentage_r_calculo=$porcentaje_retefuente_servicios;
                                        $percentage_r="4.0";
                                        $id_r="16984";
                                        $name_r='RETEFUENTE Servicios declarante';
                                    }else if($invoice_facturar->tipo_retencion=="Compras"){
                                        $percentage_r_calculo=$porcentaje_compras;
                                        $percentage_r="2.5";
                                        $id_r="16991";
                                        $name_r='RETEFUENTE Compras declarante';
                                    }else if($invoice_facturar->tipo_retencion=="Personas no declarantes"){
                                        $percentage_r_calculo=$porcentaje_personas_no_declarantes;
                                        $percentage_r="3.5";
                                        $id_r="16992";
                                        $name_r='RETEFUENTE Compras no declarantes';
                                    }

                                    if($invoice_facturar->tipo_retencion=="Reteiva"){
                                        if( $sv['tax']!="0"){

                                            $v1=$dataApiNET->items[$count]->taxes[1]->value;
                                            $total_reteiva=($v1*15)/100;
                                            $dataApiNET->payments[0]->value-=$total_reteiva;   
                                            $dataApiNET->retentions[0]->value+=$total_reteiva;
                                            $reteiva_aplicado=true;
                                            unset($dataApiNET->items[$count]->taxes[0]);   
                                            $dataApiNET->items[$count]->taxes = array_values($dataApiNET->items[$count]->taxes);
                                            
                                        }
                                        
                                    }else{
                                        //si dicen que el valor no es el que tienen en saves, es porque siigo solo toma en cuenta la retencion sobre el valor sin iva ;
                                        $value_r=(($sv['price']*$sv['qty'])*$percentage_r_calculo)/100;
                                        $row_retencion=',
                                         {
                                            "id": '.$id_r.',
                                            "name": "'.$name_r.'",
                                            "type": "Retefuente",
                                            "percentage": '.$percentage_r.',
                                            "value": '.$value_r.'
                                        }';
                                         $dataApiNET->items[$count]->taxes[0]->id=$id_r;
                                         $dataApiNET->items[$count]->taxes[0]->name=$name_r;
                                         $dataApiNET->items[$count]->taxes[0]->percentage=$percentage_r;
                                         $dataApiNET->items[$count]->taxes[0]->value=$value_r;
                                        $dataApiNET->payments[0]->value-=$value_r;   
                                    }
                                    

                                }else{
                                   unset($dataApiNET->items[$count]->taxes[0]);   
                                   $dataApiNET->items[$count]->taxes = array_values($dataApiNET->items[$count]->taxes);
                                   
                                }
								if(count($dataApiNET->items[$count]->taxes)==0){
									unset($dataApiNET->items[$count]->taxes);
								}	
                                
                                $count++;
                            }
                     
                        }
						if(!$reteiva_aplicado){
							 unset($dataApiNET->retentions);
						}
                }
            

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
        $dataInsert['customer_id']=$invoice_facturar->csd;
        $dataInsert['invoice_id']=$datos_facturar['id_facturar'];        
        $dataInsert['servicios_facturados']="";
        $dataInsert['creado_con_multiple']=1;
        // end customer data facturacion_electronica_siigo table insert
        //var_dump($dataApiNET);
        //$dataApiTV=json_encode($dataApiTV);

        $dataApiNET=json_encode($dataApiNET); 
        $retorno=array("mensaje"=>"No");
        //var_dump($datos_facturar['servicios']);
//var_dump($dataApiNET);
//exit();
        if($dataApiNET!=null && $dataApiNET!="null"){
            $retorno = $api->accionar($api,$dataApiNET,1);     
        }
        //$retorno['mensaje']="Factura Guardada";

        if($retorno['mensaje']=="Factura Guardada"){
            $dt_in=array();
            $dataInsert['tid']=$invoice_facturar->tid;
            //$dataInsert["json"]=$dataApiNET;
            $dataInsert['fecha_ejecucion']=date("Y-m-d H:i:s");
            if($datos_facturar['estcuenta']=="6941"){
                $dt_in['metodo_pago_f_e']="credito";    
                $dataInsert['metodo_pago']="credito";    
            }else{
                $dt_in['metodo_pago_f_e']="efectivo";    
                $dataInsert['metodo_pago']="efectivo";    
            }
            $this->db->insert("facturacion_electronica_siigo",$dataInsert);
            
            $dt_in['facturacion_electronica']="Factura Electronica Creada";
            $dt_in['fecha_f_electronica_generada']=$dataInsert['fecha'];
            $dt_in['servicios_facturados_electronicamente']=$dataInsert['servicios_facturados'];
            $this->db->update("invoices",$dt_in,array("id"=>$datos_facturar['id_facturar']));
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
             $dataInsert['tid']=$invoice_facturar->tid;
             $dataInsert['tipo']='error';
             $dataInsert['invoice_id']=$datos_facturar['id_facturar']."-error";        
            $dataInsert["json"]=$dataApiNET."  errores: ".$retorno['respuesta'];
            $dataInsert['fecha_ejecucion']=date("Y-m-d H:i:s");
            $this->db->insert("facturacion_electronica_siigo",$dataInsert);
            $retor=array("status"=>false,'respuesta'=>$retorno['respuesta']);
            return $retor;
        }
    }
    public function get_ultima_factura_electronica($doc){
        
    }
    public function get_m_pago_f_e($varx){
        $codigo_m_pago=6960;
        $retorno =array("observaciones"=>"","codigo"=>$codigo_m_pago);
        $accoun_tr="";
           // $dataApiNET->payments[0]->id=$datos_facturar['estcuenta'];//efectivo 6960 credito 6941
           
                $ult_tr=$this->db->query("select * from transactions where (estado !='Anulada' or estado is null) and tid=".$varx['tid']." order by id desc")->result_array();
                if(count($ult_tr)>0){
                    $accoun_tr=$this->db->get_where("accounts",array("id"=>$ult_tr[0]['acid']))->row();
                    if(isset($accoun_tr) && $accoun_tr->cuenta_siigo!=null){
                        $retorno['codigo']=$accoun_tr->cuenta_siigo;
                        $accoun_tr=$accoun_tr->holder;
                    }else{
                        if(isset($accoun_tr)){
                            $accoun_tr=$accoun_tr->holder;
                        }else{
                            $accoun_tr="";    
                        }
                        
                    }
                }    
            

            $dt_ob=new DateTime($varx['invoicedate']);
            $str_obs=$this->reports->devolver_nombre_mes($dt_ob->format("m"))." - ".$dt_ob->format("Y");
            $retorno['observaciones']="TID : ".$varx['tid'].", Factura : ".$str_obs." ,metodo pago: ".$accoun_tr;

            return $retorno;
    }
        public function get_invoice_credito($cc,$fecha){
            $this->load->model("Reports_model","reports");
        $api=$_SESSION['api_siigox'];
        //$resultado=$api->getInvoicesCreditoOttis("51859748","2023-11-05");
        $resultado=$api->getInvoicesCreditoOttis($cc,$fecha);
        ob_clean();
        //var_dump($resultado);
        //echo "<br><br>";
        $res_obj=json_decode($resultado);
        //var_dump($res_obj->results);
        //echo "<br><br><br>";
        if(isset($res_obj) && isset($res_obj->results)){
            foreach ($res_obj->results as $key => $factura) {
                if(strpos($factura->observations,"TID : ".$_POST['invoice_actualizacion_fe']['tid']) !==false && $factura->payments[0]->id=="6941"){//cambiar metodo de pago por 6941
                    //2863
                    //var_dump($factura->observations);var_dump($factura->payments[0]->id);var_dump($factura->id);
                    $id_f=$factura->id;
                    //echo "<br>";
                    unset($factura->stamp);
                    unset($factura->id);
                    unset($factura->mail);
                    unset($factura->metadata);
                    unset($factura->number);
                    //echo json_encode($factura);
                    var_dump($_POST['invoice_actualizacion_fe']);
                    $DATOS_ACTUALIZACION=$this->get_m_pago_f_e($_POST['invoice_actualizacion_fe']);
                    $factura->observations=$DATOS_ACTUALIZACION['observaciones'];
                    $factura->payments[0]->id=$DATOS_ACTUALIZACION['codigo'];
                    $var_actualizada=json_encode($factura);
                    $api->updateInvoice($var_actualizada,$id_f,1);
                    $date_now=date("Y-m-d H:i:s");
                    $data_inv=array("metodo_pago_f_e"=>"efectivo","fecha_actualizacion"=>$date_now);
                    $this->db->update("invoices",$data_inv,array("tid"=>$_POST['invoice_actualizacion_fe']['tid']));
                    $data_insert=array();
                    $data_insert['fecha']=$date_now;
                    $data_insert['fecha_ejecucion']=$date_now;
                    $data_insert['customer_id']=$_POST['invoice_actualizacion_fe']['csd'];
                    $data_insert['invoice_id']=$_POST['invoice_actualizacion_fe']['id'];
                    $data_insert['tid']=$_POST['invoice_actualizacion_fe']['tid'];
                    $data_insert['tipo']="actualizada";
                    $data_insert['metodo_pago']="efectivo";
                    $this->db->insert("facturacion_electronica_siigo",$data_insert);
                    //todo esta listo, falta actualizar tabla de facturas_electronicas y tabla de invoices, crear campo fecha de actualizacion, y luego probar en ottis;
                    return true;
                }
                
            }
        }
        return false;


    }

}