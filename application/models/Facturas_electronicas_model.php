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
                    $dataApiTV->items[1]->description="Puntos de tv adicionales ".$_POST['puntos'];
                    $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                    $prod=$lista_de_productos[0];

                    $v2=$prod->product_price*intval($_POST['puntos']);

                    $dataApiTV->items[1]->code="001";
                            $dataApiTV->items[1]->quantity=$_POST['puntos'];
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
            $data_ses[1]=$data2=array("username"=>$list[1]['username'],"access_key"=>$list[1]['access_key'],"nombre"=>$list[1]['nombre']);

        }
        $_SESSION['array_accesos_siigo']=$data_ses;
    }
     public function generar_factura_customer_para_multiple_ottis($datos_facturar,$api){
        
         /*$this->load->library('SiigoAPI');
        $api = new SiigoAPI();*/
        $this->load->model("customers_model","customers");
        $this->load->model("invoices_model","invocies");
        $dataApiNET=null;
        $customer = $this->db->get_where("customers",array('id' =>$datos_facturar['id']))->row();
         $array_servicios=$this->customers->servicios_detail($customer->id);
        //var_dump($datos_facturar['servicios']);
        if($datos_facturar['servicios']=="Combo"){
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
               // $dataApiNET= $this->customers->getFacturaElectronicaOttis(2);//verificar este caso
            }else{
                $dataApiNET= $this->customers->getFacturaElectronicaOttis(1,$array_servicios['tipo_retencion']);    
            }
        }else if($datos_facturar['servicios']=="Internet"){
            $dataApiNET= $this->customers->getFacturaElectronicaOttis(null,$array_servicios['tipo_retencion']);
        }else if($datos_facturar['servicios']=="Television"){
            if(isset($datos_facturar['puntos']) && $datos_facturar['puntos']!="no"){
                //$dataApiNET= $this->customers->getFacturaElectronicaOttis(1);    //y este caso
            }else{
                $dataApiNET= $this->customers->getFacturaElectronicaOttis(null,$array_servicios['tipo_retencion']);    
            }            
        }        
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
            $dataApiNET->document->id="27183";
            $dataApiNET->customer->identification=$customer->documento;
            $dataApiNET->cost_center=$centro_de_costo_codeNET;
            $dataApiNET->seller="738";
            $dataApiNET->date=$dateTime->format("Y-m-d");
            $dataApiNET->payments[0]->due_date="2023-08-03";//$dateTimeVencimiento->format("Y-m-d");
            $accoun_tr="";
            $dataApiNET->payments[0]->id=$datos_facturar['estcuenta'];//efectivo 6960 credito 6941
            if($datos_facturar['estcuenta']=="6960"){
                $ult_tr=$this->db->query("select * from transactions where (estado !='Anulada' or estado is null) and tid=".$array_servicios['tid']." order by id desc")->result_array();
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

            $dataApiNET->observations="TID : ".$array_servicios['tid'].", metodo pago: ".$accoun_tr;
            $consulta_siigo1=$api->getCustomer($customer->documento,1);
          
            
            if($consulta_siigo1['pagination']['total_results']==0){
                    $json_customer=json_decode($json_customer);
                    $json_customer->related_users->seller_id=738;
                    $json_customer->related_users->collector_id=738;
                    $json_customer->contacts[0]->email="vestelsas@gmail.com";
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
            $count=0;
            $retencion_aplicada=false;
            $porcentaje_retefuente_servicios=4;
            $porcentaje_compras=2.5;
            $porcentaje_personas_no_declarantes=3.5;
            if($array_servicios['combo']!="no" && ($datos_facturar['servicios']=="Combo" || $datos_facturar['servicios']=="Internet")){
                $dataApiNET->items[0]->description="Servicio de Internet ".$array_servicios['combo'];
                $lista_de_productos=$this->db->from("products")->where("pcat","1")->get()->result();
                $array_servicios['combo']=strtolower(str_replace(" ", "",$array_servicios['combo'] ));
                foreach ($lista_de_productos as $key => $prod) {
                    $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                    if($prod->product_name==$array_servicios['combo']){
                        $producto_existe=true;
                        //var_dump($prod->product_name);
                        $dataApiNET->items[0]->code=$prod->product_code;
                        $prod_item=$this->db->get_where("invoice_items",array("tid"=>$array_servicios['tid'],"pid"=>$prod->pid))->row();
                        if(isset($prod_item)){
                            $prod->product_price=$prod_item->price;
                        }
                        if($prod->taxrate!=0){

                            //$precios=$this->customers->calculoParaFacturaElectronica($prod->product_price);
                            $v1=($prod->product_price*19)/100;
                            $v2=$v1+$prod->product_price;
                            $dataApiNET->items[0]->taxes[0]->id=4189;
                            $dataApiNET->items[0]->price=$prod->product_price;
                            $dataApiNET->items[0]->taxes[0]->value=$v1;
                            $dataApiNET->payments[0]->value=$v2;
                            if($array_servicios['tipo_retencion']=="Reteiva"){
                                $total_reteiva=($v1*15)/100;
                                $dataApiNET->retentions[0]->value=$total_reteiva;
                                $dataApiNET->payments[0]->value-=$total_reteiva;
                            }

                        }else{
                            unset($dataApiNET->items[0]->taxes[0]);   

                            $dataApiNET->items[0]->taxes = array_values($dataApiNET->items[0]->taxes);
                            $dataApiNET->items[0]->price=$prod->product_price;                            
                            $dataApiNET->payments[0]->value=$prod->product_price;
//var_dump(json_encode($dataApiNET));
                        }

                            
                        if($array_servicios['tipo_retencion']!=null && $array_servicios['tipo_retencion']!="Reteiva"){
                                $porcentaje_a_aplicar=4;
                                if($array_servicios['tipo_retencion']=="Retefuente Servicios"){
                                    $porcentaje_a_aplicar=$porcentaje_retefuente_servicios;
                                }else if($array_servicios['tipo_retencion']=="Compras"){
                                    $porcentaje_a_aplicar=$porcentaje_compras;
                                }else if($array_servicios['tipo_retencion']=="Personas no declarantes"){
                                    $porcentaje_a_aplicar=$porcentaje_personas_no_declarantes;
                                }
                                $v1=($prod->product_price*$porcentaje_a_aplicar)/100;
                                //$v2=$v1-$prod->product_price;
                                //$dataApiNET->items[0]->taxes[0]->id=4189;
                                //$dataApiNET->items[0]->price=$prod->product_price;
                                if($prod->taxrate!=0){
                                    $dataApiNET->items[0]->taxes[1]->value=$v1;
                                }else{
                                    $dataApiNET->items[0]->taxes[0]->value=$v1;
                                }                                
                                $dataApiNET->payments[0]->value-=$v1;                            
                        }else{
                            if($prod->taxrate!=0){
                                unset($dataApiNET->items[0]->taxes[1]);    
                                $dataApiNET->items[0]->taxes = array_values($dataApiNET->items[0]->taxes);
                            }else{
                                unset($dataApiNET->items[0]->taxes);
                            }
                            
                        }
                        
                        
                        break;
                    }
                }
                $count++;
            }
            if($datos_facturar['servicios']=="Combo" || $datos_facturar['servicios']=="Television"){
                $dataApiNET->items[$count]->description="Servicio de Televisión - ".$array_servicios['television'];
                $lista_de_productos=$this->db->from("products")->where("pcat","1")->get()->result();
                $array_servicios['television']=strtolower(str_replace(" ", "",$array_servicios['television'] ));
                foreach ($lista_de_productos as $key => $prod) {
                    $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                    if($prod->product_name==$array_servicios['television']){
                        $producto_existe=true;
                        //var_dump($prod->product_name);
                        $dataApiNET->items[$count]->code=$prod->product_code;

                        $prod_item=$this->db->get_where("invoice_items",array("tid"=>$array_servicios['tid'],"pid"=>$prod->pid))->row();
                        if(isset($prod_item)){
                            $prod->product_price=$prod_item->price;
                        }

                        if($prod->taxrate!=0){

                            //$precios=$this->customers->calculoParaFacturaElectronica($prod->product_price);
                            $v1=($prod->product_price*19)/100;
                            $v2=$v1+$prod->product_price;
                            $dataApiNET->items[$count]->taxes[0]->id=4189;
                            $dataApiNET->items[$count]->price=$prod->product_price;
                            $dataApiNET->items[$count]->taxes[0]->value=$v1;
                            $dataApiNET->payments[0]->value+=$v2;

                        }else{
                            if($array_servicios['tipo_retencion']==null){
                                unset($dataApiNET->items[$count]->taxes);    
                            }
                            $dataApiNET->items[$count]->price=$prod->product_price;                            
                            $dataApiNET->payments[0]->value+=$prod->product_price;

                        }
                        
                        
                        break;
                    }
                }
                $count++;
                //para puntos crear similar codigo de este if 
            }
            //falta esta parte identificar el paquete de internet del usuario y agregar sus valores
            $list_servs=$this->invocies->servicios_adicionales_recurrentes($array_servicios['tid']);
            //$list_servs=array();
            if(isset($list_servs) && count($list_servs)>0){
                $otro_pr='{
                  "code": "12SOPIVA1",
                  "description": "DESCRIPCION",
                  "quantity": 1,
                  "price": 21008,
                  "discount": 0.0,
                  "taxes": [
                    {"id": 4189,
                     "name": "IVA 19% sev",
                     "type": "IVA",
                     "percentage": 19,
                     "value": 3991.6
                    }
                  ]            
                }';
              
                foreach ($list_servs as $keysv => $sv) {
                    //$dataApiNET->items[]=$prod_add;
                      $prod_add=json_decode($otro_pr);
                    array_push($dataApiNET->items, $prod_add);
                    $pr_sr=$this->db->get_where("products",array("pid"=>$sv['pid']))->row();
                    
                    $dataApiNET->items[$count]->description="Servicio Adicional ".$pr_sr->product_name;
                    $dataApiNET->items[$count]->code=$pr_sr->product_code;
                    if(isset($pr_sr) && $pr_sr->taxrate!="0"){
                        $iva2=round(($pr_sr->product_price*$pr_sr->taxrate)/100);
                        $sv['total']+=$iva2;   

                            //$v1=($prod->product_price*19)/100;
                            //$v2=$v1+$prod->product_price;
                            $dataApiNET->items[$count]->quantity=$sv['valor'];
                            $dataApiNET->items[$count]->taxes[0]->id=4189;
                            $dataApiNET->items[$count]->price=($pr_sr->product_price);
                            $dataApiNET->items[$count]->taxes[0]->value=($iva2*$sv['valor']);
                            

                    }else{
                         unset($dataApiNET->items[$count]->taxes);    
                         $dataApiNET->items[$count]->quantity=$sv['valor'];
                         $dataApiNET->items[$count]->price=$pr_sr->product_price;
                    }
                    $suma=($sv['total']*$sv['valor']);
                    $dataApiNET->payments[0]->value+=$suma;
                    $count++;
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
        $dataInsert['customer_id']=$datos_facturar['id'];
        $dataInsert['servicios_facturados']=$datos_facturar['servicios'];
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
    public function get_ultima_factura_electronica($doc){
        
    }

}