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

class facturasElectronicas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }
    public function index(){
    	$head['title'] = "Administrar Facturas Electronicas Customer";
        $head['usernm'] = $this->aauth->get_user()->username;
$this->load->model("customers_model","customers");
        $data['servicios'] = $this->customers->servicios_detail($_GET['id']);
        $data['due'] = $this->customers->due_details($_GET['id']);
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/facturas_electronicas',$data);
        $this->load->view('fixed/footer');
    }

    public function ajax_list()
    {
    	$this->load->model('Facturas_electronicas_model', 'facturas');

        $list = $this->facturas->get_datatables();
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $facturas) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $facturas->id;
            $row[] = dateformat($facturas->fecha);
            $row[] = $facturas->customer_id;
            if($facturas->invoice_id=="" || $facturas->invoice_id==null || $facturas->invoice_id=="")
            $row[] = $facturas->invoice_id;
            $row[] = $facturas->servicios_facturados;
            $row[] = amountFormat($facturas->s1TotalValue);
           // $row[] = '<span class="st-' . $invoices->status . '">' . $invoices->status . '</span>';			
           // $row[] = '<a href="' . base_url("purchase/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp';
			

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->facturas->count_all(),
            "recordsFiltered" => $this->facturas->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }
    public function guardar(){
    	$this->load->library('SiigoAPI');
        $api = new SiigoAPI();
        $this->load->model("customers_model","customers");
        $dataApi;
        if($_POST['servicios']=="Combo"){        	
            if(isset($_POST['puntos']) && $_POST['puntos']!="no"){
                $dataApi= $this->customers->getClientData3Productos();//verificar este caso
            }else{
                $dataApi= $this->customers->getClientData2Productos();    
            }
        }else if($_POST['servicios']=="Internet"){
        	$dataApi= $this->customers->getClientData();
        }else if($_POST['servicios']=="Television"){
            if(isset($_POST['puntos']) && $_POST['puntos']!="no"){
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
        $customer = $this->db->get_where("customers",array('id' =>$_POST['id']))->row();
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

        $dataApi->Header->Account->Address=$customer->nomenclatura . ' ' . $customer->numero1 . $customer->adicionauno.' Nº '.$customer->numero2.$customer->adicional2.' - '.$customer->numero3;
         if(strlen($customer->celular)>10 || is_int($customer->celular)==false){
            $customer->celular="0";
        }
        if(strlen($customer->celular2)>10 || is_int($customer->celular2)==false){
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
        $dateTime=new DateTime($_POST['sdate']);
        $dataApi->Header->DocDate=$dateTime->format("Ymd");

        //cambio de fecha de vencimiento sumandole 20 dias a la fecha seleccionada
            $fecha_actual = date($dateTime->format("Y-m-d"));
            $date=date("d-m-Y",strtotime($fecha_actual."+ 20 days")); 
            $dateTimeVencimiento=new DateTime($date);
        //end fecha vencimiento
        $dataApi->Payments[0]->DueDate=$dateTimeVencimiento->format("Ymd");
       	//falta el manejo de los saldos saldos
        if($_POST['servicios']=="Television"){
        	$dataApi->Items[0]->Description="Servicio de Televisión por Cable";
        	//agregar valores reales de televicion deacuerdo a que en diferentes a yopal cambia el valor

            if(isset($_POST['puntos']) && $_POST['puntos']!="no"){
                    $dataApi->Items[1]->Description="Puntos de tv adicionales ".$_POST['puntos'];
                    $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                    $prod=$lista_de_productos[0];

                    $prod->product_price=$prod->product_price*intval($_POST['puntos']);

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
        }else if($_POST['servicios']=="Internet"){
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

        if($_POST['servicios']=="Combo"){
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
	        				//$dataApi->Header->VATTotalValue="0";	//se comenta porque se mantiene el de la tv
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
        				
        				if(isset($_POST['puntos']) && $_POST['puntos']!="no"){
                                $dataApi->Items[2]->Description="Puntos de tv adicionales ".$_POST['puntos'];
                                $lista_de_productos=$this->db->from("products")->where("pid","158")->get()->result();
                                $prod=$lista_de_productos[0];
                                $prod->product_price=$prod->product_price*intval($_POST['puntos']);
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
        $dataInsert['customer_id']=$_POST['id'];
        $dataInsert['servicios_facturados']=$_POST['servicios'];
        // end customer data facturacion_electronica_siigo table insert
        $dataApi=json_encode($dataApi); 
        //var_dump($dataApi);
        $retorno = $api->accionar($api,$dataApi); 

        if($retorno['mensaje']=="Factura Guardada"){
        	$this->db->insert("facturacion_electronica_siigo",$dataInsert);
        	redirect("facturasElectronicas?id=".$customer->id);
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
        		var_dump($retorno['respuesta']);
        	//}
        }
    }
    public function activar_desactivar_usuario(){
        $id=$this->input->post("id");
        $selected=$this->input->post("selected");
        if($selected=="true"){
            $data['facturar_electronicamente']=1;
        }else{
            $data['facturar_electronicamente']=0;
        }
        $this->db->update("customers",$data,array("id"=>$id));
        echo json_encode(array("status"=>"guardao"));
        
    }
    public function get_datos_customer(){
        $this->load->model('customers_model', 'customers');
        $id=$this->input->post("id");
        $servicios=$this->customers->servicios_detail($id);
        $puntos = $this->customers->due_details($id);
        $customer=$this->db->get_where("customers",array("id"=>$id))->row();

        echo json_encode(array("status"=>"success","f_elec_tv"=>$customer->f_elec_tv,"f_elec_internet"=>$customer->f_elec_internet,"f_elec_puntos"=>$customer->f_elec_puntos,"servicios"=>$servicios,"puntos"=>$puntos['puntos']));
    }
    public function guardar_seleccion_usuario(){
        $id=$this->input->post("id");
        $servicio=$this->input->post("servicio");
        $puntos=$this->input->post("puntos");
        $data['f_elec_tv']=null;
        $data['f_elec_internet']=null;
        $data['f_elec_puntos']=null;
        if($servicio=="Internet"){
            $data['f_elec_internet']=1;
            $data['f_elec_tv']=0;
        }else if($servicio=="Television"){
            $data['f_elec_tv']=1;
            $data['f_elec_internet']=0;
        }else{
            $data['f_elec_internet']=1;
            $data['f_elec_tv']=1;
        }
        if($servicio=="Television" || $servicio=="Combo"){
            if($puntos=="si"){
                $data['f_elec_puntos']=1;
            }else if($puntos=="no"){
                $data['f_elec_puntos']=0;
            }
        }
        $this->db->update("customers",$data,array("id"=>$id));
        echo json_encode(array("status"=>"success"));
        
    }
    public function generar_facturas_electronicas_multiples(){
        $this->load->model('customers_model', 'customers');
        $this->load->model('transactions_model');
        $head['title'] = "Generar Facturas Electronicas";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['accounts'] = $this->transactions_model->acc_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('facturas_electronicas/configuraciones',$data);
        $this->load->view('fixed/footer');       
    }
    public function generar_facturas_action(){
        set_time_limit(10000);
        $this->load->model("customers_model","customers");
        $this->load->model("facturas_electronicas_model","facturas_electronicas");
        $caja1=$this->db->get_where('accounts',array('id' =>$_POST['pay_acc']))->row();
        $caja1->holder =strtolower($caja1->holder);
        $customers = $this->db->query("select * from customers where (usu_estado='Activo' or usu_estado='Compromiso') and (lower(ciudad) ='".$caja1->holder."' and facturar_electronicamente='1')")->result_array();
        $datos_del_proceso=array("facturas_creadas"=>array(),"facturas_con_errores"=>array(),"facturas_anteriormente_creadas"=>array());
        $dateTime=new DateTime($_POST['sdate']);
        foreach ($customers as $key => $value) {
                $servicios=$this->customers->servicios_detail($value['id']);
                $puntos = $this->customers->due_details($value['id']);
                //guardare en un array la variable servicios = combo o tv o internet y la variable puntos con no o el numero de puntos
                // el orden es prima los servicios que tiene actualmente como hay seleccion por el admin si el servicio existe se toma la seleccion si no se omite,
                //°° IMPORTANTE °°  por otro lado si agrega servicios y estan seteadas las opciones con un solo servicio ejemplo, el admin debe de setear las opciones de facturacion electronica porque generara segun este seteado
                

                $datos=array();
                if($puntos['puntos']=="0"){
                    $datos['puntos']="no";
                }else{
                    $datos['puntos']=$puntos['puntos'];
                }
                if($value['f_elec_puntos']=="0"){
                    $datos['puntos']="no";
                }
                $datos['servicios']=null;
                if($servicios['television']!="no" && $servicios['television']!="-" &&$servicios['television']!="" &&$servicios['television']!="null" && $servicios['television']!=null){
                    
                    if($servicios['combo']!="no" && $servicios['combo']!="-" && $servicios['combo']!="" && $servicios['combo']!="null" && $servicios['combo']!=null){
                            $datos['servicios']="Combo";
                            if($value['f_elec_internet']=="0"){
                                $datos['servicios']="Television";
                            }else if($value['f_elec_tv']=="0"){
                                $datos['servicios']="Internet";
                            }
                    }else{
                        $datos['servicios']="Television";    
                    }                    
                }else if($servicios['combo']!="no" && $servicios['combo']!="-" && $servicios['combo']!="" && $servicios['combo']!="null" && $servicios['combo']!=null){
                      $datos['servicios']="Internet";                    
                }
                $datos['sdate']=$_POST['sdate'];
                $datos['id']=$value['id'];
                if($datos['servicios']!=null){
                    
                    $fecha_1=$dateTime->format("Y-m-d");
                    $factura_tabla=$this->db->get_where("facturacion_electronica_siigo",array("fecha"=>$fecha_1,'customer_id'=>$value['id']))->row();
                    if(empty($factura_tabla)){


                        $creo=$this->facturas_electronicas->generar_factura_customer_para_multiple($datos);
                        if($creo['status']==true){
                            $datos_del_proceso['facturas_creadas'][]=$value['id'];
                        }else{
                            $datos_del_proceso['facturas_con_errores'][]=array("id"=>$value['id'],"error"=>$creo['respuesta']);
                        }
                    }else{
                            $datos_del_proceso['facturas_anteriormente_creadas'][]=$value['id'];
                    }
                    //--CostCenterCode para agregar la sede 
                    //--falta agregar el centro de costo 
                    //se agrego centro de costo falta validar las demas sedes
                    // y validar que si ya se creo la factura en esta fecha no volverla a crear

                }

            

        }
        $_SESSION['errores']=$datos_del_proceso['facturas_con_errores'];
     //   var_dump($datos_del_proceso);
        $head['title'] = "Facturas electronicas generadas ";        
        $data['datos_del_proceso'] = $datos_del_proceso;
        $data['fecha'] = $dateTime->format("Y-m-d");
        $data['pay_acc'] = $caja1->holder;
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('facturas_electronicas/facturas_creadas', $data);
        $this->load->view('fixed/footer');
        
    }
    public function obtener_token(){
        $this->load->library('SiigoAPI');
        $api = new SiigoAPI();
        var_dump($api->getInvoicesByID());

    }
    public function lista_facturas_generadas(){

        $lista_invoices=$this->db->query("SELECT *,facturacion_electronica_siigo.id as id_fac_elec FROM facturacion_electronica_siigo inner join customers on customers.id=facturacion_electronica_siigo.customer_id where fecha='".$_GET['fecha']."' and ciudad='".$_GET['pay_acc']."'")->result_array();
        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        $maximo=$minimo+10;
        foreach ($lista_invoices as $key => $value) {
            
            if($x>=$minimo && $x<$maximo){
                $no++;
                $customers = $this->db->get_where("customers", array('id' => $value['customer_id']))->row();
                $row = array();
                $row[] = $no;
                //$row[] = $customers->abonado;
                $row[] = '<a href="'.base_url().'customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
                $row[] = $customers->celular;
                $row[] = $customers->documento;
                //$row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                //$row[] = $customers->usu_estado;
                
                $row[] = '<a href="#" id="id_'.$value["id_fac_elec"].'" data-nombre="'.$customers->name .' '. $customers->unoapellido.'" onclick="eliminar_factura_electronica('.$value['id_fac_elec'].');" class="btn btn-info btn-sm"><span class="icon-trash"></span>  Elminar</a>';//'<a href="'.base_url().'customers/invoices?id='.$value['csd'].'" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Facturas</a> <a href="'.base_url().'invoices/view?id='.$value['tid'].'" class="btn btn-info btn-sm"><span class="icon-eye"></span>  Factura Creada</a>';
                $data[] = $row;

            }
            $x++;
             
             
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($lista_invoices),
            "recordsFiltered" => count($lista_invoices),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function delete_factura_electronica_local(){
        $this->db->delete("facturacion_electronica_siigo",array("id"=>$_POST['id']));
        echo "eliminado";
    }
     public function lista_facturas_no_generadas(){
        

        $lista_invoices=$_SESSION['errores'];
        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        $maximo=$minimo+10;
        foreach ($lista_invoices as $key => $value) {
            
            if($x>=$minimo && $x<$maximo){
                $no++;
                $customers = $this->db->get_where("customers", array('id' => $value['id']))->row();
                $row = array();
                $row[] = $no;
                //$row[] = $customers->abonado;
                $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
                $row[] = $customers->celular;
                $row[] = $customers->documento;
                //$row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                //$row[] = $customers->usu_estado;
                $row[] = $value['error'];
                $data[] = $row;

            }
            $x++;
             
             
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($lista_invoices),
            "recordsFiltered" => count($lista_invoices),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
}