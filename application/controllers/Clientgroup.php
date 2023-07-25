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
class Clientgroup extends CI_Controller
{
    
    public function __construct()
    {

        parent::__construct();
        $this->load->model('clientgroup_model', 'clientgroup');
        $this->load->model('customers_model', 'customers');
               
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    //groups
    public function index()
    {
        $data['group'] = $this->customers->group_sedes();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Client Groups';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groups', $data);
        $this->load->view('fixed/footer');
    }
    public function apis_vars_edit(){
        $head['usernm'] = $this->aauth->get_user()->username;   
        $head['title'] = "Editar Variables apis";   
        $data['apis']=$this->db->get_where("variables_de_entorno")->result_array();

        $this->load->view('fixed/header', $head);
        $this->load->view('groups/configuraciones',$data);
        $this->load->view('fixed/footer');
    }
    public function guardar_datos_api(){
        //var_dump();
        $data=array();
        foreach ($_POST as $key => $value) {
            
            if($key!="name_api"){
                $nombre_key=str_replace($_POST['name_api']."_", "", $key);
                if($nombre_key!=$key){
                    $data[$nombre_key]=$value;    
                }
                
            }
        }
        $this->db->update("variables_de_entorno",array("valor"=>json_encode($data)),array("nombre_api"=>$_POST['name_api']));
        $api_vars=$this->db->get_where("variables_de_entorno",array("nombre_api"=>$_POST['name_api']))->row();
        $_SESSION['variables_'.$_POST['name_api']]=json_decode($api_vars->valor);
        echo "Guardado";
    }
    public function explortar_a_excel(){
        set_time_limit(3000);
        $query_consulta="select * from customers where gid=".$_GET['id']." and";
        $condicionales="";
        if(isset($_GET['estados_multiple'])){
                    $estados_multiple=explode(",", $_GET['estados_multiple']) ;
                    
                    if($estados_multiple[0]!="null" && $estados_multiple[0]!=null){
                    
                        $varx="";
                        $c1=count($estados_multiple)-1;
                        foreach ($estados_multiple as $key => $x) {
                            $varx.="'".$x."'";   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }
                        $condicionales.=" usu_estado in(".$varx.")";
                    }   
            }

        $var_bool=false;
                $_GET['barrios_multiple']=str_replace("-", "", $_GET['barrios_multiple']);
                 $multiplev=explode(",", $_GET['barrios_multiple']) ;

                    
        if (isset($_GET['direccion']) &&$_GET['direccion'] =="Personalizada"){
            if(isset($_GET['localidad_multiple'])){
                $_GET['localidad_multiple']=str_replace("-", "", $_GET['localidad_multiple']);
                    
                    $localidad_multiple=explode(",", $_GET['localidad_multiple']) ;
                    
                        $localidades2=array();
                        if($multiplev[0]!="null" && $multiplev[0]!=null){
                               $customer_b= $this->db->get_where("customers",array("barrio"=>intval($multiplev[0])))->row();
                                foreach ($localidad_multiple as $key => $value) {
                                        if($value!=$customer_b->localidad){
                                            $localidades2[]=$value;
                                        }    
                                }
                        }else{
                            $localidades2=$localidad_multiple;
                        }
                        

                    if($localidades2[0]!="null" && $localidades2[0]!=null && $localidades2[0]!="" && count($localidades2)!=0){
                        
                        $varx="";
                        $c1=count($localidades2)-1;
                        foreach ($localidades2 as $key => $x) {
                            $varx.=$x;   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }

                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.=" ( localidad in(".$varx.") ";
                        $var_bool=true;
                    }  
            }
            $var_bool2=false;
            if(isset($_GET['barrios_multiple'])){                    
                    if($multiplev[0]!="null" && $multiplev[0]!=null){                        
                        $varx="";
                        $c1=count($multiplev)-1;
                        foreach ($multiplev as $key => $x) {
                            $varx.=$x;   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }
                        $parentesis="";
                        if($condicionales!=""){
                            if($var_bool){
                                $condicionales.=" or ";       
                                $parentesis=")";
                            }else{
                                $condicionales.=" and ";       
                            }
                            
                        }
                        $condicionales.=" barrio in(".$varx.")".$parentesis;
                        $var_bool2=true;
                    }    
            }
            if($var_bool && $var_bool2==false){
                $condicionales.=")";
            }
            
            if ($_GET['nomenclatura'] != '' && $_GET['nomenclatura'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  nomenclatura ='".$_GET['nomenclatura']."' ";
            }
            if ($_GET['numero1'] != '') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero1 ='".$_GET['numero1']."' ";
            }
            if ($_GET['adicionauno'] != '' && $_GET['adicionauno'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  adicionauno ='".$_GET['adicionauno']."' ";
            }
            if ($_GET['numero2'] != '' && $_GET['numero2'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero2 ='".$_GET['numero2']."' ";
            }
            if ($_GET['adicional2'] != '' && $_GET['adicional2'] != '-') {
                
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  adicional2 ='".$_GET['adicional2']."' ";
            }
            if ($_GET['numero3'] != '' && $_GET['numero3'] != '-') {
                
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero3 ='".$_GET['numero3']."' ";
            }
            if ($_SESSION[md5("variable_datos_pin")]['db_name'] == "admin_crmvestel" && $_GET['ciudad_ottis'] != '' && $_GET['ciudad_ottis'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  ciudad ='".$_GET['ciudad_ottis']."' ";
            }
        }
        if($this->input->post('search')['value']!=""){

                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  documento like '%".$this->input->post('search')['value']."%' ";
        }
        if($condicionales==""){
            $query_consulta= str_replace("and", "", $query_consulta);    
        }
        $query_consulta.=$condicionales;
      
      //fechas contratacion filtro
       if (isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="fecha_contrato" && $_GET['ingreso_select']!=null) {
        $dateTime_c= new DateTime($_GET['sdate']);
                $sdate_c=$dateTime_c->format("Y-m-d");
                
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                
          $query_consulta.= " and (f_contrato>= '".$sdate_c."' and f_contrato<='".$edate_c."') ";
      }else if (isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="1_despues_contrato" && $_GET['ingreso_select']!=null) {
                $dateTime_c= new DateTime($_GET['sdate']);
                $sdate_c=$dateTime_c->format("Y-m-d");
                $sdate_c=date("Y-m-d",strtotime($sdate_c."- 1 year"));
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                $edate_c=date("Y-m-d",strtotime($edate_c."- 1 year"));
                $query_consulta.= " and (f_contrato>= '".$sdate_c."' and f_contrato<='".$edate_c."') ";
      }else if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="desde_siempre_a_fecha" && $_GET['ingreso_select']!=null){
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                
          $query_consulta.= " and ( f_contrato<='".$edate_c."') ";
      }
//end 
        $query_consulta." order by id DESC";
        
        $lista_customers=$this->db->query($query_consulta)->result();
        
        $cust_group=$this->db->get_where("customers_group",array('id' => $_GET['id']))->row();
        $filtro_deudores_multiple=explode(",", $_GET['deudores_multiple']) ;
        $filtro_deudores_multiple_2=array();        

        $n_filtro_deudores=0;
        foreach ($filtro_deudores_multiple as $key => $value) {
            if($value!="null" || $value!=null){
                $filtro_deudores_multiple_2[$value]=$value;    
            }
            
        }
        $n_filtro_deudores=count($filtro_deudores_multiple_2);
        //codigo para hacer filtros por mora y servicios

        $lista_customers2=array();
        
        foreach ($lista_customers as $key => $customers) {
            $due=$this->customers->due_details($customers->id);
            $money=array();
                    if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="fecha_ingreso" && $_GET['ingreso_select']!=null){
                        $money=$this->customers->money_details($customers->id);
                    }else{
                            $money['credit']=$customers->credit;
                            $money['debit']=$customers->debit;
                    }
            $customers->money=$money['credit'];
			$var_excluir=false;
            $debe_customer=($due['total']-$due['pamnt']);//se agrego el campo de money debit por el item de gastos que se mencino en fechas anteriores
            $lista_invoices = $this->db->from("invoices")->where("csd",$customers->id)->order_by('invoicedate,tid',"DESC")->get()->result();
            $customer_moroso=false;
            $valor_ultima_factura=0;
            $_var_tiene_internet=false;
            $_var_tiene_tv=false;
            $suscripcion_str="";
            if($debe_customer==0){
                $customer_moroso=false;
            }
                $fact_valida=false;
                $filtros_deuda_customers=0;
                foreach ($lista_invoices as $key => $invoice) {
                    $suma=0;
					$suscripcion_str="";
                    if($invoice->combo!="no" && $invoice->combo!="" && $invoice->combo!="-"){
                        $fact_valida=true;
                        $_var_tiene_internet=true;
                    }
                    if($invoice->television!="no" && $invoice->television!="" && $invoice->television!="-"){
                        $fact_valida=true;
                        $_var_tiene_tv=true;
                    }
                    if($invoice->ron!="" && $invoice->ron!=null){
                        $fact_valida=true;
                    }
                    $afiliacion_traslado_omitir=$this->db->query('SELECT * FROM `invoice_items` where (product like "%afiliacion%" or product like "%traslado%") and tid="'.$invoice->tid.'"')->result_array();
                        if(count($afiliacion_traslado_omitir)!=0){
                            $fact_valida=false;
                    }
                    if($invoice->tipo_factura=="Fija" || $invoice->tipo_factura=="Nota Credito" || $invoice->tipo_factura=="Nota Debito"){
                         $fact_valida=false;
                    }
                    $puntosvar="";
                    if($fact_valida){
                        if($_var_tiene_tv){
							$producto=null;
                            if(str_replace(" ", "", $invoice->refer)=="Mocoa"){
                                $producto=$this->db->get_where('products', array("pid"=>"159"))->row();
                                $suma+=$producto->product_price;
                            }else{
                                $producto=$this->db->get_where('products', array("pid"=>"27"))->row();
                                if(strtolower($invoice->television)!="television"){
                                    $producto=$this->db->get_where('products', array("product_name"=>$invoice->television))->row();
                                    $iva2=0;
                                    if(isset($producto) && $producto->taxrate!="0"){
                                        $iva2=round(($producto->product_price*$producto->taxrate)/100);
                                    }
                                    $suma+=$producto->product_price+$iva2;    
                                }else{
                                    $suma+=$producto->product_price+3992;    
                                }
                            }
                            if($producto!=null){$var_excluir=false;
                                $suscripcion_str="Tv";
                                if(strtolower($invoice->television)!="television"){
                                    $suscripcion_str=$invoice->television;
                                }
                            }
                            
                        }
                        if($invoice->puntos!="" && $invoice->puntos!="0" && $invoice->puntos!=null && $invoice->puntos!="no"){
                            $puntosvar="+".$invoice->puntos." Pts";
                            $suscripcion_str.="+".$invoice->puntos." Pts";
                          
                            $punto_adicional=$this->db->get_where("products", array('product_name' =>"Punto Adicional"))->row();
                            $suma+=$punto_adicional->product_price*$invoice->puntos;
                       }
                        //esto es para los estados
            if($_var_tiene_tv && $invoice->estado_tv=="Cortado"){
				if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
                    //$var_excluir=true;    
                }
                $var_excluir=false;
                if(strpos($_GET['estados_multiple'], "Cortado")!==false ){
                    $var_excluir=false;                    
                }
                $suscripcion_str="(Tv cortada".$puntosvar.")";   
            }else if($_var_tiene_tv && $invoice->estado_tv=="Suspendido"){
                $suscripcion_str="(Tv suspendida".$puntosvar.")";
				if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
                    //$var_excluir=true;    
                }
                if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                    $var_excluir=false;                    
                }	
                $var_excluir=false;			
            }

//esto es para los estados

                        if($_var_tiene_internet){
                            $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                            $var_e=strtolower(str_replace(" ", "",$invoice->combo));
                            foreach ($lista_de_productos as $key => $prod) {
                                $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                                if($prod->product_name==$var_e){
                                    $suma+=$prod->product_price;                                    
                                    break;
                                }
                            }

                            if(!empty($var_e)){$var_excluir=false;
                                if($suscripcion_str!=""){
                                    if($invoice->estado_combo=="Cortado"){
										if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Cortado")!==false ){
                                            $var_excluir=false;                    
                                        }										
									$var_excluir=false;
                                        $suscripcion_str.="+"."(".$var_e." cortado)";   
                                    }else if($invoice->estado_combo=="Suspendido"){
										if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                           // $var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                                            $var_excluir=false;                    
                                        }
                                        $var_excluir=false;
                                        $suscripcion_str.="+"."(".$var_e." suspendido)";   
                                    }else{
                                        $suscripcion_str.="+".$var_e;    
                                    }
                                    
                                }else{
                                    if($invoice->estado_combo=="Cortado"){
										if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                           // $var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Cortado")!==false){
                                            $var_excluir=false;                    
                                        }  
                                        $var_excluir=false;										
                                        $suscripcion_str="(".$var_e." cortado)";   
                                    }else if($invoice->estado_combo=="Suspendido"){
										 if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                           // $var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                                            $var_excluir=false;                    
                                        }
                                        $var_excluir=false;
                                        $suscripcion_str="(".$var_e." suspendido)";   
                                    }else{
                                        $suscripcion_str=$var_e;
                                    }
                                }    
                            }
                        }
                        
                    }else{
                        $var_excluir=true;
                    }
                    $invoice->total=$suma;
                   // if(!$fact_valida){
                        /*    $query=$this->db->query('SELECT * FROM `invoice_items` WHERE tid='.$invoice->tid.' and (product like "%mega%" or product like "%tele%" or product like "%punto adicional%")')->result_array();
                            if(count($query)!=0){
                                $fact_valida=true;
                                $suma=0;
                                foreach ($query as $key => $value) {
                                    if(strpos(strtolower($value['product']),"reconexi" )!==false || strpos(strtolower($value['product']),"afiliaci" )!==false){
                                            
                                    }else{
                                        $suma+=$value['subtotal'];    
                                    }
                                    
                                    //si se selecciona el filtro por servicios realiza este filtro
                                    if(isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null){
                                        if(strpos(strtolower($value['product']),"mega" )!==false){
                                            $_var_tiene_internet=true;
                                        }
                                        if(strpos(strtolower($value['product']),"television" )!==false){
                                            $_var_tiene_tv=true;   
                                        }
                                    }

                                }
                                $invoice->total=$suma;
                            }*/
                   // }
                     if( isset($filtro_deudores_multiple_2['menosdeunmes'])){
                        if($fact_valida && $debe_customer<$invoice->total && $debe_customer>0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }    
                    if( isset($filtro_deudores_multiple_2['1mes'])){
                        if($fact_valida && $debe_customer==$invoice->total && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['masdeunmes'])){
                        if($fact_valida && $debe_customer>$invoice->total && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if(isset($filtro_deudores_multiple_2['2meses'])){
                        if($fact_valida && $debe_customer>=($invoice->total*2) && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['3y4meses'])){
                        if($fact_valida && $debe_customer>=($invoice->total*3) && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['Todos'])){
                        if($fact_valida && $debe_customer>0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if(isset($filtro_deudores_multiple_2['saldoaFavor'])){
                        if($fact_valida && $debe_customer<0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }

                    }
                     if( isset($filtro_deudores_multiple_2['al Dia'])){
                        if($fact_valida && $debe_customer==0 && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }

                    }
                     if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null ||$_GET['deudores_multiple']=="null"){
                        if($fact_valida){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;
                        }

                    }

                    
                }    
            
            //filtro por servicios con morosos
            if(isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null ){
                //aunque sea moroso pero para aplicar el filtro se va a cambiar la variable moroso
               
                 if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null || $_GET['deudores_multiple']=="null"){//para que muestre todos si esta seleccionada esta opcion, probar si colocando esta condicion encima del if funciona bien para eliminar y dejar solo una
                    $customer_moroso=true;
                }

                if($_GET['sel_servicios']=="Internet" && !$_var_tiene_internet){
                            $customer_moroso=false;                        
                }else if($_GET['sel_servicios']=="TV" && !$_var_tiene_tv){//preguntar que si solo debe de filtrar los que tienen tv o si tiene tv pero tambien internet lo puede listar lo mismo con la de internet
                            $customer_moroso=false;     
                }else if($_GET['sel_servicios']=="Combo" ){
                    if(!$_var_tiene_internet || !$_var_tiene_tv){
                        $customer_moroso=false;
                    }
                }

                if($_GET['checked_ind_service']=="true"){
                    if($_GET['sel_servicios']=="Internet" && $_var_tiene_tv ){
                            $customer_moroso=false;                        
                    }else if($_GET['sel_servicios']=="TV" && $_var_tiene_internet){//preguntar que si solo debe de filtrar los que tienen tv o si tiene tv pero tambien internet lo puede listar lo mismo con la de internet
                                $customer_moroso=false;     
                    }                        
                }

                if($_GET['check_usuarios_a_facturar']=="true"){
                                          

                    if($customers->facturar_electronicamente==0){
                        $customer_moroso=false; 
                    }
                }
				 if($var_excluir){
                     $customer_moroso=false;
                }

            }else{
                 if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null || $_GET['deudores_multiple']=="null"){//para que muestre todos si esta seleccionada esta opcion, probar si colocando esta condicion encima del if funciona bien para eliminar y dejar solo una
                    $customer_moroso=true;
                }
            }
            //end fitro por servicios con morosos 
            $equipo=$this->db->get_where("equipos",array("asignado"=>$customers->id))->row();
            //end fitro por servicios con morosos 
            $tegnologia="Sin Teg.";
            if(isset($equipo)){
                $tegnologia=$equipo->t_instalacion;
                if($tegnologia==""){
                    $tegnologia="Sin Teg.";
                }
            }

            if($customer_moroso && $_GET['tegnologia_multiple']!="null"){

                if($tegnologia=="FTTH"  && strpos($_GET['tegnologia_multiple'], "FTTH")!==false){
                    $customer_moroso=true;
                }else if($tegnologia=="EOC"  && strpos($_GET['tegnologia_multiple'], "EOC")!==false){
                    $customer_moroso=true;
                }else if($tegnologia=="Sin Teg." && strpos($_GET['tegnologia_multiple'], "Sin Teg")!==false){
                    $customer_moroso=true;
                }else{
                    $customer_moroso=false;
                }
            }
             $array_add=array("id"=>$customers->id,"valido"=>$customer_moroso);

                if($_GET['ultimo_estado_sel']=="Si"){
                               if($customer_moroso){
                                    $array_add= $this->customers->calculo_ultimo_estado($array_add,$customers);  
                                    $customer_moroso=$array_add['valido'];
                                    $customers->fecha_ultimo_estado=$array_add['fecha_ultimo_estado']."";
                                    $customers->ultimo_estado=$array_add['ultimo_estado'];
                               }
                }
                if($_GET['check_sin_factura_actual']=="true" && $customer_moroso){
                    $fecha_actual=new DateTime();
                    $f1=$fecha_actual->format("Y-m")."-01";
                    $f2=$fecha_actual->format("Y-m-d");
                    $ultima=$this->db->query("select * from invoices where csd=".$customers->id." and invoicedate BETWEEN '".$f1."' and '".$f2."'")->result_array();
                    if(count($ultima)!=0){
                        $customer_moroso=false;
                    }
                    
                }
                if($_GET['check_equipos_asignados']=="true" && $customer_moroso){
                    $equipo_x=$this->db->get_where("equipos",array("asignado"=>$customers->id))->row();
                    if(empty($equipo_x)){
                        $customer_moroso=false;
                    }
                }
            if($customer_moroso){
                $customers->deuda=$debe_customer;
                $customers->suscripcion=$valor_ultima_factura;            
                $customers->suscripcion_str=$suscripcion_str;
                $customers->tegnologia=$tegnologia;
                 if($_GET['check_agregar_ultima_transaccion']=="true"){

                        $ultima=$this->db->query("select * from transactions where payerid=".$customers->id." and credit>0 ORDER BY transactions.date desc,transactions.id desc ")->result_array();
                        if(count($ultima)!=0){

                                $customers->fechaUltimaTransaccion=$ultima[0]['date'];
                                $customers->ValorUltimaTransaccion=amountFormat($ultima[0]['credit']);    
                        }else{
                            $customers->fechaUltimaTransaccion="No Tiene";
                            $customers->ValorUltimaTransaccion="No Tiene";    
                        }
                        
                 }
                $lista_customers2[] = $customers;
            }else{

            }
             
        }
        //fin codigo para hacer filtros por mora y servicios
		//$this->db->join('customers', 'tickets.cid=customers.id ', 'left');
		//$this->db->join('ciudad', 'customers.ciudad=ciudad.idCiudad ', 'left');
		//$this->db->join('barrio', 'customers.barrio=barrio.idBarrio', 'left');

        
        $this->load->library('Excel');
    
    //define column headers
    $headers = array('ID' => 'integer','Abonado' => 'string','Cedula' => 'string', 'Nombre' => 'string', 'Celular' => 'string', 'Correo' => 'string' ,'Direccion' => 'string','Barrio' => 'string','Serv. Suscritos' => 'string', 'Tegnologia' => 'string','Estado' => 'string','Deuda' => 'integer','Suscripcion' => 'integer','Ingreso' => 'integer');
    if($_GET['ultimo_estado_sel']=="Si"){
        $headers['UltimoEstado']="string";
        $headers['FechaCambio']="string";
    }
    if($_GET['check_agregar_ultima_transaccion']=="true"){
        $headers['fechaUltimaTransaccion']="string";
        $headers['ValorUltimaTransaccion']="string";   
    }

#if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']!="" && $_GET['ingreso_select']!="fecha_ingreso" && $_GET['ingreso_select']!=null){
        $headers['Fecha Contrato']="string";
         
#}
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte Customers '.$cust_group->title);
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte Customers '.$cust_group->title);
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $col_options = array(

['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
);
     if($_GET['ultimo_estado_sel']=="Si"){
        $col_options[]=array('font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center');
        $col_options[]=array('font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center');
    }
    if($_GET['check_agregar_ultima_transaccion']=="true"){
        $col_options[]=array('font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center');
        $col_options[]=array('font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center');
    }
    #if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']!="" && $_GET['ingreso_select']!="fecha_ingreso" && $_GET['ingreso_select']!=null){
     $col_options[]=array('font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center');
         
    #}
    $writer->writeSheetHeader('Customers '.$cust_group->title, $headers,$col_options);

    
    //write rows to sheet1
    foreach ($lista_customers2 as $key => $customer) {            
            $direccion= $customer->nomenclatura . ' ' . $customer->numero1 . $customer->adicionauno.' Nº '.$customer->numero2.$customer->adicional2.' - '.$customer->numero3;
                    $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$customer->barrio))->row();
                    $str_barrio="";
                            if(isset($obj_barrio)){                                
                                $str_barrio = $obj_barrio->barrio;    
                            }else{
                                $str_barrio= $obj_barrio->barrio;    
                            }
                            $array_excel=array();
                            if($_GET['ultimo_estado_sel']=="Si"){
                                $array_excel=array($customer->id,$customer->abonado,$customer->documento ,$customer->name.' '.$customer->unoapellido, $customer->celular, $customer->email,$direccion,$str_barrio ,$customer->suscripcion_str,$customer->tegnologia,$customer->usu_estado,$customer->deuda,$customer->suscripcion,$customer->money,$customer->ultimo_estado,$customer->fecha_ultimo_estado);
                            }else{
                                $array_excel=array($customer->id,$customer->abonado,$customer->documento ,$customer->name.' '.$customer->unoapellido, $customer->celular,$customer->email, $direccion,$str_barrio ,$customer->suscripcion_str,$customer->tegnologia,$customer->usu_estado,$customer->deuda,$customer->suscripcion,$customer->money);
                            }

                            if($_GET['check_agregar_ultima_transaccion']=="true"){
                                $array_excel[]=$customer->fechaUltimaTransaccion;
                                $array_excel[]=$customer->ValorUltimaTransaccion; 
                            }
                            #if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']!="" && $_GET['ingreso_select']!="fecha_ingreso" && $_GET['ingreso_select']!=null){
                                    $array_excel[]=$customer->f_contrato; 
         
                            #}
                            $writer->writeSheetRow('Customers '.$cust_group->title,$array_excel);
            
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Customers '.$cust_group->title.' '.$fecha_actual.'.xlsx';
    
    //write to xlsx file
    $writer->writeToFile($fileLocation);
    //echo $writer->writeToString();
    
    //force download
    header('Content-Description: File Transfer');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=".basename($fileLocation));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Pragma: public");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Length: ' . filesize($fileLocation)); //Remove

    ob_clean();
    flush();

    readfile($fileLocation);
    unlink($fileLocation);
    exit(0);
       

    }
    //view
    public function groupview()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $id = $this->input->get('id');		
        $data['group'] = $this->clientgroup->details($id);
        $this->db->update("customers",array("checked_seleccionado"=>0),array("gid"=>$_GET['id']));
        $data['cuenta']=$this->clientgroup->get_numero_seleccionados($id);
        $head['title'] = 'Group View';
		$data['sede'] =$this->clientgroup->group_info($data['group']['title']);
        $company=$this->db->get_where("app_system",array("id"=>1))->row();
        $data['mensaje_correos']="Cordial saludo. Para OTTIS COMUNICACIONES es muy valiosa la confianza que ha depositado en nuestra compañía y esperamos poder satisfacer sus requerimientos y necesidades tecnológicas.Gracias por utilizar nuestros servicios, abre la siguiente url para visualizarlo: {url-automatica-segun-el-usuario}" ;
        //var_dump($array);
        $this->load->model('templates_model','templates');
        $data['plantillas'] = $this->templates->get_template();
        if($_SESSION[md5("variable_datos_pin")]['db_name'] == "admin_crmvestel"){
            $data['ciudades_filtro']=$this->clientgroup->get_citys();
        }
        //var_dump($data['plantillas']);
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupview', $data);
        $this->load->view('fixed/footer');
    }

    //datatable
    public function grouplist()

    {
        $base = base_url() . 'customers/';
        $id = $this->input->get('id');
        $list = $this->customers->get_datatables($id);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {

            if(isset($customers->idx)){
                $customers->id=$customers->idx;
            }
            $servicios_detail=$this->customers->servicios_detail($customers->id);            
            $servicios_str="";
            if($servicios_detail['television']!="" && $servicios_detail['television']!="no" && $servicios_detail['television']!="-"){
                $servicios_str="Tv";
                if(strtolower($servicios_detail['television'])!="television"){
                    $servicios_str=$servicios_detail['television'];
                }
            }
//esto es para los estados
            

            

            if($servicios_detail['estado_tv']=="Cortado"){
                $servicios_str="<b><i class='sts-Cortado'>Tv</i></b>";   
            }else if($servicios_detail['estado_tv']=="Suspendido"){
                $servicios_str="<b><i class='sts-Suspendido'>Tv</i></b>";   
            }
            if($servicios_detail['estado_combo']=="Cortado"){
                $servicios_detail['combo']="<b><i class='sts-Cortado'>".$servicios_detail['paquete']."</i></b>";   
            }else if($servicios_detail['estado_combo']=="Suspendido"){
                $servicios_detail['combo']="<b><i class='sts-Suspendido'>".$servicios_detail['paquete']."</i></b>";   
            }
//esto es para los estados 
            if($servicios_detail['combo']!="" && $servicios_detail['combo']!="no" && $servicios_detail['combo']!="-"){
                if($servicios_str==""){
                    $servicios_str=$servicios_detail['combo'];
                }else{
                    $servicios_str.="+".$servicios_detail['combo'];
                }   
            }

            $no++;

            $row = array();
            $str_checked="";
            if($customers->checked_seleccionado==1){
                $str_checked="checked";
            }
            $equipo=$this->db->get_where("equipos",array("asignado"=>$customers->id))->row();
            $row[] = '<input '.$str_checked.' id="input_'.$customers->id.'" type="checkbox" name="x" class="clientes_para_enviar_sms" data-id-customer="'.$customers->id.'"  data-celular="'.$customers->celular.'" style="cursor:pointer; margin-left: 9px;" onclick="agregar_customer_envio_sms(this)" ></input>';    
            $row[] = $no;
			$row[] = $customers->abonado;
			$row[] = $customers->documento;
            $row[] = '<a href="' . $base . 'view?id=' . $customers->id . '">' . $customers->name .' '.$customers->unoapellido. ' </a>';
			$row[] = $customers->celular;			
            $row[] = $customers->email;           
            $row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
            $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$customers->barrio))->row();
                            if(isset($obj_barrio)){
                                
                                $row[] = $obj_barrio->barrio;    
                            }else{
                                $row[] = $customers->barrio;    
                            }
            if($servicios_str!=""){
                $servicios_str="<a class='cl-servicios' style='cursor:pointer;' data-id='".$customers->id."' onclick='facturas_electronicas_ev(this);'>".$servicios_str."</a>";
                $str_checked="";
                if($customers->facturar_electronicamente==1){
                    $str_checked="checked";
                }
                $servicios_str="<input ".$str_checked." onclick='ck_facturas_electronicas(this)' data-id='".$customers->id."' class='cl-ck-f-electronicas' style='cursor:pointer;' title='activar o desactivar este usuario de la facturacion electronica' type='checkbox'/>&nbsp".$servicios_str;
            }
            $row[] = $servicios_str;
            $tegnologia="Sin definir";
            if(isset($equipo)){
                $tegnologia=$equipo->t_instalacion;
            }
            $row[] = $tegnologia;
			$row[] = '<span class="st-'.$customers->usu_estado. '">' .$customers->usu_estado. '</span>';
            $row[]="";
            $row[]="";
            $row[]="";
            $row[]="";
            $row[]="";
            $row[] = $customers->f_contrato;
            $row[] = '<a href="' . base_url() . 'llamadas/index?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class=" icon-mobile-phone"></span> Llamar</a>';
			if ($this->aauth->get_user()->roleid == 5) {
			$row[] = '<a href="' . $base . 'edit?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="icon-pencil"></span> '.$this->lang->line('Edit').'</a>
						<a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';}


            $data[] = $row;
            
        }
        //para el filtro replico el for each pero por un for y reacomodo los items de a 10 cubriendo espacios en blanco

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all($id),
            "recordsFiltered" => $this->customers->count_filtered($id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function activar_desactivar_usuario(){
        $id=$this->input->post("id");
        $selected=$this->input->post("selected");
        if($selected=="true"){
            $data['checked_seleccionado']=1;
        }else{
            $data['checked_seleccionado']=0;
        }
        $this->db->update("customers",$data,array("id"=>$id));
        echo json_encode(array("status"=>"guardao"));
        
    }

    public function load_morosos(){ 
        set_time_limit(10000);
        
        if($this->input->post('start')!="0"  || (isset($_POST['order'][0]['column']) && $_POST['order'][0]['column']=="12") ){
            if(isset($_POST['order'][0]['column']) && $_POST['order'][0]['column']=="12" && $this->input->post('start')=="0" ){
                $this->ordenar_clientes_por_deuda();
            }
            $this->list_data_precargada();
            
        }else{

        $listax=array();
       
        $query_consulta="select * from customers where gid=".$_GET['id']." and";
        $condicionales="";
        if(isset($_GET['estados_multiple'])){
                    $estados_multiple=explode(",", $_GET['estados_multiple']) ;
                    
                    if($estados_multiple[0]!="null" && $estados_multiple[0]!=null){
                    
                        $varx="";
                        $c1=count($estados_multiple)-1;
                        foreach ($estados_multiple as $key => $x) {
                            $varx.="'".$x."'";   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }
                        $condicionales.=" usu_estado in(".$varx.")";
                    }   
            }

        $var_bool=false;
                $_GET['barrios_multiple']=str_replace("-", "", $_GET['barrios_multiple']);
                 $multiplev=explode(",", $_GET['barrios_multiple']) ;

                   
        if (isset($_GET['direccion']) &&$_GET['direccion'] =="Personalizada"){
            if(isset($_GET['localidad_multiple'])){
                $_GET['localidad_multiple']=str_replace("-", "", $_GET['localidad_multiple']);
                    
                    $localidad_multiple=explode(",", $_GET['localidad_multiple']) ;
                 
                        $localidades2=array();
                        if($multiplev[0]!="null" && $multiplev[0]!=null){
                               $customer_b= $this->db->get_where("customers",array("barrio"=>intval($multiplev[0])))->row();
                               
                                foreach ($localidad_multiple as $key => $value) {
                                        if($value!=$customer_b->localidad){
                                            $localidades2[]=$value;
                                        }    
                                }
                        }else{
                            $localidades2=$localidad_multiple;
                        }
                        

                    if($localidades2[0]!="null" && $localidades2[0]!=null && $localidades2[0]!="" && count($localidades2)!=0){
                        
                        $varx="";
                        $c1=count($localidades2)-1;
                        foreach ($localidades2 as $key => $x) {
                            $varx.=$x;   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }

                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.=" ( localidad in(".$varx.") ";
                        $var_bool=true;
                    }  
            }
            $var_bool2=false;
            if(isset($_GET['barrios_multiple'])){                    
                    if($multiplev[0]!="null" && $multiplev[0]!=null){                        
                        $varx="";
                        $c1=count($multiplev)-1;
                        foreach ($multiplev as $key => $x) {
                            $varx.=$x;   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }
                        $parentesis="";
                        if($condicionales!=""){
                            if($var_bool){
                                $condicionales.=" or ";       
                                $parentesis=")";
                            }else{
                                $condicionales.=" and ";       
                            }
                            
                        }
                        $condicionales.=" barrio in(".$varx.")".$parentesis;
                        $var_bool2=true;
                    }    
            }
            if($var_bool && $var_bool2==false){
                $condicionales.=")";
            }
            
            if ($_GET['nomenclatura'] != '' && $_GET['nomenclatura'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  nomenclatura ='".$_GET['nomenclatura']."' ";
            }
            if ($_GET['numero1'] != '') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero1 ='".$_GET['numero1']."' ";
            }
            if ($_GET['adicionauno'] != '' && $_GET['adicionauno'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  adicionauno ='".$_GET['adicionauno']."' ";
            }
            if ($_GET['numero2'] != '' && $_GET['numero2'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero2 ='".$_GET['numero2']."' ";
            }
            if ($_GET['adicional2'] != '' && $_GET['adicional2'] != '-') {
                
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  adicional2 ='".$_GET['adicional2']."' ";
            }
            if ($_GET['numero3'] != '' && $_GET['numero3'] != '-') {
                
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero3 ='".$_GET['numero3']."' ";
            }
            if ($_SESSION[md5("variable_datos_pin")]['db_name'] == "admin_crmvestel" && $_GET['ciudad_ottis'] != '' && $_GET['ciudad_ottis'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  ciudad ='".$_GET['ciudad_ottis']."' ";
            }
        }
        if($this->input->post('search')['value']!=""){

                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  documento like '%".$this->input->post('search')['value']."%' ";
        }
        if($condicionales==""){
            $query_consulta= str_replace("and", "", $query_consulta);    
        }
        $query_consulta.=$condicionales;
       if (isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="fecha_contrato" && $_GET['ingreso_select']!=null) {
        $dateTime_c= new DateTime($_GET['sdate']);
                $sdate_c=$dateTime_c->format("Y-m-d");
                
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                
          $query_consulta.= " and (f_contrato>= '".$sdate_c."' and f_contrato<='".$edate_c."') ";
      }else if (isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="1_despues_contrato" && $_GET['ingreso_select']!=null) {
                $dateTime_c= new DateTime($_GET['sdate']);
                $sdate_c=$dateTime_c->format("Y-m-d");
                $sdate_c=date("Y-m-d",strtotime($sdate_c."- 1 year"));
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                $edate_c=date("Y-m-d",strtotime($edate_c."- 1 year"));
                $query_consulta.= " and (f_contrato>= '".$sdate_c."' and f_contrato<='".$edate_c."') ";
      }else if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="desde_siempre_a_fecha" && $_GET['ingreso_select']!=null){
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                
          $query_consulta.= " and ( f_contrato<='".$edate_c."') ";
      }
        $query_consulta." order by id DESC";
        //var_dump($query_consulta);
        $lista_customers=$this->db->query($query_consulta)->result();
        $filtro_deudores_multiple=explode(",", $_GET['deudores_multiple']) ;
        $filtro_deudores_multiple_2=array();        
        $n_filtro_deudores=0;
        foreach ($filtro_deudores_multiple as $key => $value) {
            if($value!="null" || $value!=null){
                $filtro_deudores_multiple_2[$value]=$value;    
            }
            
        }
        $n_filtro_deudores=count($filtro_deudores_multiple_2);

        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        if($_POST['length']=="10"){
            $maximo=$minimo+10;
        }else if($_POST['length']=="25"){
            $maximo=$minimo+25;
        }else if($_POST['length']=="50"){
            $maximo=$minimo+50;
        }else{
            $maximo=$minimo+10;
        }
        $descontar=0;
        foreach ($lista_customers as $key => $customers) {
            $due=$this->customers->due_details2($customers->id);
            //$money=$this->customers->money_details($customers->id);//para poder arreglar el tema de la velocidad de carga esta ligado con este proceso la solucion a la que llegamos es crear los campos debit y credit en customers y en cada proceso del sistema en los que se cree elimine o editen transacciones se debe de editar el valor de customers;
            //$customers->money=0;//$money['credit'];
            $debe_customer=($due['total']-$due['pamnt']);//se agrego el campo de money debit por el item de gastos que se mencino en fechas anteriores
            $var_excluir=false;
            $lista_invoices = $this->db->from("invoices")->where("csd",$customers->id)->order_by('invoicedate,tid',"DESC")->get()->result();
            $customer_moroso=false;
            $valor_ultima_factura=0;
            $_var_tiene_internet=false;
            $_var_tiene_tv=false;
            $suscripcion_str='';
            if($debe_customer==0){
                $customer_moroso=false;
            }
                $fact_valida=false;
                $filtros_deuda_customers=0;
                foreach ($lista_invoices as $key => $invoice) {
                    $suma=0;
                    $suscripcion_str='';
                    if($invoice->combo!="no" && $invoice->combo!="" && $invoice->combo!="-"){
                        $fact_valida=true;
                        $_var_tiene_internet=true;
                    }
                    if($invoice->television!="no" && $invoice->television!="" && $invoice->television!="-"){
                        $fact_valida=true;
                        $_var_tiene_tv=true;
                    }
                    if($invoice->ron!="" && $invoice->ron!=null){
                        $fact_valida=true;
                    }
                    $afiliacion_traslado_omitir=$this->db->query('SELECT * FROM `invoice_items` where (product like "%afiliacion%" or product like "%traslado%") and tid="'.$invoice->tid.'"')->result_array();
                        if(count($afiliacion_traslado_omitir)!=0){
                            $fact_valida=false;
                    }
                    if($invoice->tipo_factura=="Fija" || $invoice->tipo_factura=="Nota Credito" || $invoice->tipo_factura=="Nota Debito"){
                         $fact_valida=false;
                     }
                    $puntosvar="";
                    if($fact_valida){
                        if($_var_tiene_tv){
                            $producto=null;
                            if(str_replace(" ", "", $invoice->refer)=="Mocoa"){
                                $producto=$this->db->get_where('products', array("pid"=>"159"))->row();
                                $suma+=$producto->product_price;
                            }else{
                                $producto=$this->db->get_where('products', array("pid"=>"27"))->row();
                                if(strtolower($invoice->television)!="television"){
                                    $producto=$this->db->get_where('products', array("product_name"=>$invoice->television))->row();
                                    $iva2=0;
                                    if(isset($producto) && $producto->taxrate!="0"){
                                        $iva2=round(($producto->product_price*$producto->taxrate)/100);
                                    }
                                    $suma+=$producto->product_price+$iva2;    
                                }else{
                                    $suma+=$producto->product_price+3992;    
                                }
                                
                            }
                            if($producto!=null){$var_excluir=false;
                                $suscripcion_str='Tv';
                                if(strtolower($invoice->television)!="television"){
                                    $suscripcion_str=$invoice->television;
                                }
                            }
                            
                        }
                       if($invoice->puntos!="" && $invoice->puntos!="0" && $invoice->puntos!=null && $invoice->puntos!="no"){
                            $puntosvar='+'.$invoice->puntos." Pts";
                            $suscripcion_str.='+'.$invoice->puntos.' Pts';

                            $punto_adicional=$this->db->get_where("products", array('product_name' =>"Punto Adicional"))->row();
                            $suma+=$punto_adicional->product_price*$invoice->puntos;
                       }
//esto es para los estados
            if($_var_tiene_tv && $invoice->estado_tv=="Cortado"){
                
                if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
                    //$var_excluir=true;    
                }
                if(strpos($_GET['estados_multiple'], "Cortado")!==false ){
                    $var_excluir=false;                    
                }$var_excluir=false;
                $suscripcion_str='<b><i class="sts-Cortado">Tv'.$puntosvar.'</i></b>';   
            }else if($_var_tiene_tv && $invoice->estado_tv=="Suspendido"){                
                $suscripcion_str='<b><i class="sts-Suspendido">Tv'.$puntosvar.'</i></b>';   
                if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
                  //  $var_excluir=true;    
                }$var_excluir=false;
                if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                    $var_excluir=false;                    
                }
            }

//esto es para los estados 
                        if($_var_tiene_internet){$var_excluir=false;
                            $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                            $var_e=strtolower(str_replace(" ", "",$invoice->combo));
                            foreach ($lista_de_productos as $key => $prod) {
                                $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                                if($prod->product_name==$var_e){
                                    $suma+=$prod->product_price;                                    
                                    break;
                                }
                            }
                            if(!empty($var_e)){
                                if($suscripcion_str!=""){
                                    if($invoice->estado_combo=="Cortado"){
                                        if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Cortado")!==false ){
                                            $var_excluir=false;                    
                                        }
                                        $var_excluir=false;
                                        $suscripcion_str.='+'.'<b><i class="sts-Cortado">'.$var_e.'</i></b>';   
                                    }else if($invoice->estado_combo=="Suspendido"){
                                        if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                                            $var_excluir=false;                    
                                        }$var_excluir=false;
                                        $suscripcion_str.='+'.'<b><i class="sts-Suspendido">'.$var_e.'</i></b>';   
                                    }else{
                                        $suscripcion_str.='+'.$var_e;    
                                    }
                                    
                                }else{
                                    if($invoice->estado_combo=="Cortado"){
                                        if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Cortado")!==false){
                                            $var_excluir=false;                    
                                        }  $var_excluir=false;             
                                        $suscripcion_str='<b><i class="sts-Cortado">'.$var_e.'</i></b>';   
                                    }else if($invoice->estado_combo=="Suspendido"){
                                        if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                                            $var_excluir=false;                    
                                        }$var_excluir=false;
                                        $suscripcion_str='<b><i class="sts-Suspendido">'.$var_e.'</i></b>';   
                                    }else{
                                        $suscripcion_str=$var_e;    
                                    }
                                    
                                }    
                            }
                            
                        }
                        
                    }else{
                        $var_excluir=true;
                    }
                    $invoice->total=$suma;
                   // if(!$fact_valida){
                          /*  $query=$this->db->query('SELECT * FROM `invoice_items` WHERE tid='.$invoice->tid.' and (product like "%mega%" or product like "%tele%" or product like "%punto adicional%")')->result_array();
                            if(count($query)!=0){
                                $fact_valida=true;
                                $suma=0;
                                foreach ($query as $key => $value) {
                                    if(strpos(strtolower($value['product']),"reconexi" )!==false || strpos(strtolower($value['product']),"afiliaci" )!==false){
                                            
                                    }else{
                                        $suma+=$value['subtotal'];    
                                    }
                                    
                                    //si se selecciona el filtro por servicios realiza este filtro
                                    if(isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null){
                                        if(strpos(strtolower($value['product']),"mega" )!==false){
                                            $_var_tiene_internet=true;
                                        }
                                        if(strpos(strtolower($value['product']),"television" )!==false){
                                            $_var_tiene_tv=true;   
                                        }
                                    }

                                }
                                $invoice->total=$suma;
                            }*/
                   // }
                    if( isset($filtro_deudores_multiple_2['menosdeunmes'])){
                        if($fact_valida && $debe_customer<$invoice->total && $debe_customer>0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }        
                    if( isset($filtro_deudores_multiple_2['1mes'])){
                        if($fact_valida && $debe_customer==$invoice->total && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['masdeunmes'])){
                        if($fact_valida && $debe_customer>$invoice->total && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                           $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if(isset($filtro_deudores_multiple_2['2meses'])){
                        if($fact_valida && $debe_customer>=($invoice->total*2) && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['3y4meses'])){
                        if($fact_valida && $debe_customer>=($invoice->total*3) && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['Todos'])){
                        if($fact_valida && $debe_customer>0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }
                    }
                     if(isset($filtro_deudores_multiple_2['saldoaFavor'])){
                        if($fact_valida && $debe_customer<0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }

                    }
                     if( isset($filtro_deudores_multiple_2['al Dia'])){
                        if($fact_valida && $debe_customer==0 && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                        }

                    }
                     if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null ||$_GET['deudores_multiple']=="null"){
                        if($fact_valida){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;
                        }

                    }

                    
                }    
            
            //filtro por servicios con morosos
            if(isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null ){
                //aunque sea moroso pero para aplicar el filtro se va a cambiar la variable moroso
               
                if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null || $_GET['deudores_multiple']=="null"){//para que muestre todos si esta seleccionada esta opcion, probar si colocando esta condicion encima del if funciona bien para eliminar y dejar solo una
                    $customer_moroso=true;
                }

                if($_GET['sel_servicios']=="Internet" && !$_var_tiene_internet){
                            $customer_moroso=false;                        
                }else if($_GET['sel_servicios']=="TV" && !$_var_tiene_tv){//preguntar que si solo debe de filtrar los que tienen tv o si tiene tv pero tambien internet lo puede listar lo mismo con la de internet
                            $customer_moroso=false;     
                }else if($_GET['sel_servicios']=="Combo" ){
                    if(!$_var_tiene_internet || !$_var_tiene_tv){
                        $customer_moroso=false;
                    }
                }

                if($_GET['checked_ind_service']=="true"){
                    if($_GET['sel_servicios']=="Internet" && $_var_tiene_tv ){
                            $customer_moroso=false;                        
                    }else if($_GET['sel_servicios']=="TV" && $_var_tiene_internet){//preguntar que si solo debe de filtrar los que tienen tv o si tiene tv pero tambien internet lo puede listar lo mismo con la de internet
                                $customer_moroso=false;     
                    }                        
                }
                if($_GET['check_usuarios_a_facturar']=="true"){
                                    

                    if($customers->facturar_electronicamente==0){
                        $customer_moroso=false; 
                    }
                }
                
                if($var_excluir){
                     $customer_moroso=false;
                }
            }else{
                if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null || $_GET['deudores_multiple']=="null"){//para que muestre todos si esta seleccionada esta opcion, probar si colocando esta condicion encima del if funciona bien para eliminar y dejar solo una
                    $customer_moroso=true;
                }

                /*if($_GET['check_usuarios_a_facturar']=="true" && $customers->facturar_electronicamente==0){                    
                        $customer_moroso=false;                     
                }*/
            }
            $equipo=$this->db->get_where("equipos",array("asignado"=>$customers->id))->row();
            //end fitro por servicios con morosos 

            $tegnologia="Sin Teg.";
            if(isset($equipo)){
                $tegnologia=$equipo->t_instalacion;
            }
            if($customer_moroso && $_GET['tegnologia_multiple']!="null"){

                if($tegnologia=="FTTH"  && strpos($_GET['tegnologia_multiple'], "FTTH")!==false){
                    $customer_moroso=true;
                }else if($tegnologia=="EOC"  && strpos($_GET['tegnologia_multiple'], "EOC")!==false){
                    $customer_moroso=true;
                }else if(($tegnologia=="Sin Teg." || $tegnologia=="") && strpos($_GET['tegnologia_multiple'], "Sin Teg")!==false){
                    $customer_moroso=true;
                }else{
                    $customer_moroso=false;
                }
            }
           $array_add=array("id"=>$customers->id,"valido"=>$customer_moroso);

                if($_GET['ultimo_estado_sel']=="Si"){
                               if($customer_moroso){
                                    $array_add= $this->customers->calculo_ultimo_estado($array_add,$customers);  
                                    $customer_moroso=$array_add['valido'];
                               }
                }   
                if($_GET['check_sin_factura_actual']=="true" && $customer_moroso){
                    $fecha_actual=new DateTime();
                    $f1=$fecha_actual->format("Y-m")."-01";
                    $f2=$fecha_actual->format("Y-m-d");
                    $ultima=$this->db->query("select * from invoices where csd=".$customers->id." and invoicedate BETWEEN '".$f1."' and '".$f2."'")->result_array();
                    if(count($ultima)!=0){
                        $customer_moroso=false;
                    }
                    
                }
                if($_GET['check_equipos_asignados']=="true" && $customer_moroso){
                    $equipo_x=$this->db->get_where("equipos",array("asignado"=>$customers->id))->row();
                    if(empty($equipo_x)){
                        $customer_moroso=false;
                    }
                }
            if($customer_moroso){
                
$suscripcion_str2=$suscripcion_str;
                if(($x>=$minimo && $x<$maximo) || $_POST['length']=="100"){
                    $no++;                
                    
                    $row = array();
                    $money=array();
                    if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="fecha_ingreso" && $_GET['ingreso_select']!=null){
                        $money=$this->customers->money_details($customers->id);
                    }else{
                            $money['credit']=$customers->credit;
                            $money['debit']=$customers->debit;
                    }
                    $str_checked="";
                    if($customers->checked_seleccionado==1){
                        $str_checked="checked";
                    }
                            $row[] = '<input '.$str_checked.' id="input_'.$customers->id.'" type="checkbox" name="x" class="clientes_para_enviar_sms" data-id-customer="'.$customers->id.'"  data-celular="'.$customers->celular.'" style="cursor:pointer; margin-left: 9px;" onclick="agregar_customer_envio_sms(this)" ></input>';    
                            $row[] = $no;
                            $row[] = $customers->abonado;
                            $row[] = $customers->documento;
                            $row[] = '<a href="'.base_url().'customers/view?id=' . $customers->id . '">' . $customers->name .' '.$customers->unoapellido. ' </a>';
                            $row[] = $customers->celular;   
                            $row[] = $customers->email;           
                            $row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                            $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$customers->barrio))->row();
                            if(isset($obj_barrio)){
                                
                                $row[] = $obj_barrio->barrio;    
                            }else{
                                $row[] = $customers->barrio;    
                            }
                            

                            if($suscripcion_str!=""){
                                $suscripcion_str='<a class="cl-servicios" style="cursor:pointer;" data-id="'.$customers->id.'" onclick="facturas_electronicas_ev(this);">'.$suscripcion_str.'</a>';
                                $str_checked="";
                                if($customers->facturar_electronicamente==1){
                                    $str_checked='checked';
                                }
                                $suscripcion_str='<input '.$str_checked.' onclick="ck_facturas_electronicas(this)" data-id="'.$customers->id.'" class="cl-ck-f-electronicas" style="cursor:pointer;" title="activar o desactivar este usuario de la facturacion electronica" type="checkbox"/>&nbsp'.$suscripcion_str;
                            }
                            $row[] = $suscripcion_str;

                           if($tegnologia==""){
                                $tegnologia="Sin Teg.";
                            }
                            $row[] = $tegnologia;
                            $row[] = '<span class="st-'.$customers->usu_estado. '">' .$customers->usu_estado. '</span>';
                            
                                

                            $row[] = amountFormat($debe_customer);
                            $row[] = amountFormat($valor_ultima_factura);
                            $row[] = amountFormat($money['credit']-$money['debit']);
                            if($_GET['ultimo_estado_sel']=="Si"){
                                    $row[] = $array_add['fecha_ultimo_estado'];
                                    $row[] = '<span class="st-'.$array_add['ultimo_estado']. '">' .$array_add['ultimo_estado']. '</span>';
                            }else {
                                $row[]="";
                                $row[]="";
                            }
                            //$row[]="0";
                            /*if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']!="" && $_GET['ingreso_select']!="fecha_ingreso" && $_GET['ingreso_select']!=null){
                                    $row[] = $customers->f_contrato;
                            }else{
                                $row[]="";
                            }*/
                            $row[] = $customers->f_contrato;
                            $row[] = '&nbsp<a href="' . base_url() . 'llamadas/index?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class=" icon-mobile-phone"></span> Llamar</a>
							&nbsp<a style="margin-top:1px;" target="_blanck" class="btn btn-info btn-sm"  href="'.base_url().'customers/invoices?id='.$customers->id.'"><span class="icon-eye"></span>&nbsp;Facturas</a>';
                            if ($this->aauth->get_user()->roleid == 5) {
                            $row[] = '<a href="' . base_url() . 'customers/edit?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="icon-pencil"></span> '.$this->lang->line('Edit').'</a>
							<a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';
                            }
                            
                            

                        $data[] = $row;
                    

                }

                $x++;
                $array_add['debe_customer']=$debe_customer;
                $array_add['valor_ultima_factura']=$valor_ultima_factura;
                $array_add['suscripcion_str']=$suscripcion_str2;
                $array_add['tegnologia']=$tegnologia;
                //$customers->ingreso=$money['credit']-$money['debit'];
                $listax[]=$array_add;
                
            }else{
                $descontar++;
            }
             
        }
        //var_dump($c);
        $datax['datos']=json_encode($listax);//cuanto esto falle por ser muchos customers y toque buscar una solucion seria guardarlo en dos campos mitad y mitad es decir el count /2 serian los items a guardar en datoa y en dato b el resto de igual forma en el proceso de lectura se leen los dos y de unifican en una sola variable
        $this->db->update("filtros_historial",$datax, array("id"=>$this->aauth->get_user()->id));                
        if($this->db->affected_rows()==0){
            $datax['id']=$this->aauth->get_user()->id;
            $this->db->insert("filtros_historial",$datax);
        }
        $var_recordsFiltered=count($lista_customers)-$descontar;
        if($_POST['length']=="100"){
            $var_recordsFiltered=0;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($lista_customers)-$descontar,
            "recordsFiltered" => $var_recordsFiltered,
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    }
    public function ordenar_clientes_por_deuda(){
            
            $lista=$this->db->get_where("filtros_historial",array('id' =>$this->aauth->get_user()->id))->row();
            //var_dump($lista->datos);
            $lista2=json_decode($lista->datos);
            //var_dump($lista);
            $orden=SORT_DESC;
            if($_POST['order'][0]['dir'] == "asc"){
                $orden=SORT_ASC;
            }
            $lista_ordenada=$this->customers->array_sortOBJECT($lista2,"debe_customer",$orden);
            $lista_ordenada=json_encode($lista_ordenada);
            //var_dump($lista_ordenada);
            $this->db->update("filtros_historial",array("datos"=>$lista_ordenada),array('id' =>$this->aauth->get_user()->id));
            

    }
    public function list_data_precargada(){
        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        
        if($_POST['length']=="10"){
            $maximo=$minimo+10;
        }else if($_POST['length']=="25"){
            $maximo=$minimo+25;
        }else if($_POST['length']=="50"){
            $maximo=$minimo+50;
        }else{
            $maximo=$minimo+10;
        }
        
        $descontar=0;
        $lista=$this->db->get_where("filtros_historial",array('id' =>$this->aauth->get_user()->id))->row();
        $lista2=json_decode($lista->datos);
        
        foreach ($lista2 as $key => $customers) {
            
            if(($x>=$minimo && $x<$maximo) || $_POST['length']=="100"){
                     $no++; 
                     $datos_cuentas=$customers;
                     $customers=$this->db->get_where("customers",array("id"=>$customers->id))->row();
                     $money=array();     
                     if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="fecha_ingreso" && $_GET['ingreso_select']!=null){
                        $money=$this->customers->money_details($customers->id);
                    }else{
                            $money['credit']=$customers->credit;
                            $money['debit']=$customers->debit;
                    }          
                    
                    $row = array();
                    $str_checked="";
                    if($customers->checked_seleccionado==1){
                        $str_checked="checked";
                    }
                            $row[] = '<input '.$str_checked.' id="input_'.$customers->id.'" type="checkbox" name="x" class="clientes_para_enviar_sms" data-id-customer="'.$customers->id.'"  data-celular="'.$customers->celular.'" style="cursor:pointer; margin-left: 9px;" onclick="agregar_customer_envio_sms(this)" ></input>';    
                            $row[] = $no;
                            $row[] = $customers->abonado;
                            $row[] = $customers->documento;
                            $row[] = '<a href="'.base_url().'customers/view?id=' . $customers->id . '">' . $customers->name . ' </a>';
                            $row[] = $customers->celular; 
                            $row[] = $customers->email;           
                            $row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                            $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$customers->barrio))->row();
                            if(isset($obj_barrio)){
                                
                                $row[] = $obj_barrio->barrio;    
                            }else{
                                $row[] = $customers->barrio;    
                            }
                            if($datos_cuentas->suscripcion_str!=""){
                                $datos_cuentas->suscripcion_str="<a class='cl-servicios' style='cursor:pointer;' data-id='".$customers->id."' onclick='facturas_electronicas_ev(this);'>".$datos_cuentas->suscripcion_str."</a>";
                                $str_checked="";
                                if($customers->facturar_electronicamente==1){
                                    $str_checked="checked";
                                }
                                $datos_cuentas->suscripcion_str="<input ".$str_checked." onclick='ck_facturas_electronicas(this)' data-id='".$customers->id."' class='cl-ck-f-electronicas' style='cursor:pointer;' title='activar o desactivar este usuario de la facturacion electronica' type='checkbox'/>&nbsp".$datos_cuentas->suscripcion_str;
                            }
                            $row[] = $datos_cuentas->suscripcion_str;
                            if($datos_cuentas->tegnologia==""){
                                $datos_cuentas->tegnologia="Sin Teg.";
                            }
                            $row[] = $datos_cuentas->tegnologia;
                            $row[] = '<span class="st-'.$customers->usu_estado. '">' .$customers->usu_estado. '</span>';
                            //var_dump($datos_cuentas->fecha_ultimo_estado);
                            
                            $row[] = amountFormat($datos_cuentas->debe_customer);
                            $row[] = amountFormat($datos_cuentas->valor_ultima_factura);
                            $row[] = amountFormat($money['credit']-$money['debit']);
                            if($_GET['ultimo_estado_sel']=="Si"){
                                $row[] = $datos_cuentas->fecha_ultimo_estado;
                                $row[] = '<span class="st-'.$datos_cuentas->ultimo_estado. '">' .$datos_cuentas->ultimo_estado. '</span>';
                            }else{
                                $row[]="";
                                $row[]="";
                            }
                            /*if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']!="" && $_GET['ingreso_select']!="fecha_ingreso" && $_GET['ingreso_select']!=null){
                                    $row[] = $customers->f_contrato;
                            }*/
                            $row[] = $customers->f_contrato;
                            $row[] = '<a href="' . base_url() . 'customers/edit?id=' . $customers->id . '" class="btn btn-success btn-sm"><span class="icon-pencil"></span> '.$this->lang->line('Edit').'</a>&nbsp;<a style="margin-top:1px;" target="_blanck" class="btn btn-info btn-sm"  href="'.base_url().'customers/invoices?id='.$customers->id.'"><span class="icon-eye"></span>&nbsp;Facturas</a>';
                            if ($this->aauth->get_user()->roleid > 4) {
                            $row[] = '<a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';
                            }
                            

                        $data[] = $row;
                    

                }

                $x++;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($lista2),
            "recordsFiltered" => count($lista2),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

     public function get_filtrados_para_checked(){ 
        set_time_limit(6000);
        
        $this->db->update("customers",array("checked_seleccionado"=>0),array("gid"=>$_GET['id']));

        $listax=array();
        $query_consulta="select * from customers where gid=".$_GET['id']." and";
        $condicionales="";
        if(isset($_GET['estados_multiple'])){
                    $estados_multiple=explode(",", $_GET['estados_multiple']) ;
                    
                    if($estados_multiple[0]!="null" && $estados_multiple[0]!=null){
                    
                        $varx="";
                        $c1=count($estados_multiple)-1;
                        foreach ($estados_multiple as $key => $x) {
                            $varx.="'".$x."'";   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }
                        $condicionales.=" usu_estado in(".$varx.")";
                    }   
            }

        $var_bool=false;
                $_GET['barrios_multiple']=str_replace("-", "", $_GET['barrios_multiple']);
                 $multiplev=explode(",", $_GET['barrios_multiple']) ;

                   
        if (isset($_GET['direccion']) &&$_GET['direccion'] =="Personalizada"){
            if(isset($_GET['localidad_multiple'])){
                $_GET['localidad_multiple']=str_replace("-", "", $_GET['localidad_multiple']);
                    
                    $localidad_multiple=explode(",", $_GET['localidad_multiple']) ;
                    
                        $localidades2=array();
                        if($multiplev[0]!="null" && $multiplev[0]!=null){
                               $customer_b= $this->db->get_where("customers",array("barrio"=>intval($multiplev[0])))->row();
                                foreach ($localidad_multiple as $key => $value) {
                                        if($value!=$customer_b->localidad){
                                            $localidades2[]=$value;
                                        }    
                                }
                        }else{
                            $localidades2=$localidad_multiple;
                        }
                        

                    if($localidades2[0]!="null" && $localidades2[0]!=null && $localidades2[0]!="" && count($localidades2)!=0){
                        
                        $varx="";
                        $c1=count($localidades2)-1;
                        foreach ($localidades2 as $key => $x) {
                            $varx.=$x;   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }

                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.=" ( localidad in(".$varx.") ";
                        $var_bool=true;
                    }  
            }
            $var_bool2=false;
            if(isset($_GET['barrios_multiple'])){                    
                    if($multiplev[0]!="null" && $multiplev[0]!=null){                        
                        $varx="";
                        $c1=count($multiplev)-1;
                        foreach ($multiplev as $key => $x) {
                            $varx.=$x;   
                            if($key!=$c1){
                                $varx.=",";
                            }
                        }
                        $parentesis="";
                        if($condicionales!=""){
                            if($var_bool){
                                $condicionales.=" or ";       
                                $parentesis=")";
                            }else{
                                $condicionales.=" and ";       
                            }
                            
                        }
                        $condicionales.=" barrio in(".$varx.")".$parentesis;
                        $var_bool2=true;
                    }    
            }
            if($var_bool && $var_bool2==false){
                $condicionales.=")";
            }
            
            if ($_GET['nomenclatura'] != '' && $_GET['nomenclatura'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  nomenclatura ='".$_GET['nomenclatura']."' ";
            }
            if ($_GET['numero1'] != '') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero1 ='".$_GET['numero1']."' ";
            }
            if ($_GET['adicionauno'] != '' && $_GET['adicionauno'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  adicionauno ='".$_GET['adicionauno']."' ";
            }
            if ($_GET['numero2'] != '' && $_GET['numero2'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero2 ='".$_GET['numero2']."' ";
            }
            if ($_GET['adicional2'] != '' && $_GET['adicional2'] != '-') {
                
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  adicional2 ='".$_GET['adicional2']."' ";
            }
            if ($_GET['numero3'] != '' && $_GET['numero3'] != '-') {
                
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  numero3 ='".$_GET['numero3']."' ";
            }
            if ($_SESSION[md5("variable_datos_pin")]['db_name'] == "admin_crmvestel" && $_GET['ciudad_ottis'] != '' && $_GET['ciudad_ottis'] != '-') {
                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  ciudad ='".$_GET['ciudad_ottis']."' ";
            }
        }
        if($this->input->post('search')['value']!=""){

                        if($condicionales!=""){
                            $condicionales.=" and " ;   
                        }
                        $condicionales.="  documento like '%".$this->input->post('search')['value']."%' ";
        }
        if($condicionales==""){
            $query_consulta= str_replace("and", "", $query_consulta);    
        }
        $query_consulta.=$condicionales;
      
//filtro por fechas contratacion

 if (isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="fecha_contrato" && $_GET['ingreso_select']!=null) {
        $dateTime_c= new DateTime($_GET['sdate']);
                $sdate_c=$dateTime_c->format("Y-m-d");
                
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                
          $query_consulta.= " and (f_contrato>= '".$sdate_c."' and f_contrato<='".$edate_c."') ";
      }else if (isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="1_despues_contrato" && $_GET['ingreso_select']!=null) {
                $dateTime_c= new DateTime($_GET['sdate']);
                $sdate_c=$dateTime_c->format("Y-m-d");
                $sdate_c=date("Y-m-d",strtotime($sdate_c."- 1 year"));
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                $edate_c=date("Y-m-d",strtotime($edate_c."- 1 year"));
                $query_consulta.= " and (f_contrato>= '".$sdate_c."' and f_contrato<='".$edate_c."') ";
      }else if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']=="desde_siempre_a_fecha" && $_GET['ingreso_select']!=null){
                $dateTime_c= new DateTime($_GET['edate']);
                $edate_c=$dateTime_c->format("Y-m-d");
                
          $query_consulta.= " and ( f_contrato<='".$edate_c."') ";
      }
// end filtro por fechas contratacion

        $query_consulta." order by id DESC";
        
        $lista_customers=$this->db->query($query_consulta)->result();
        
        $filtro_deudores_multiple=explode(",", $_GET['deudores_multiple']) ;
        $filtro_deudores_multiple_2=array();        

        $n_filtro_deudores=0;
        foreach ($filtro_deudores_multiple as $key => $value) {
            if($value!="null" || $value!=null){
                $filtro_deudores_multiple_2[$value]=$value;    
            }
            
        }
        $n_filtro_deudores=count($filtro_deudores_multiple_2);
    
        $data=array();
        $x=0;
    
    
        $descontar=0;
        foreach ($lista_customers as $key => $customers) {
            $due=$this->customers->due_details($customers->id);
            //$money=$this->customers->money_details($customers->id);//para poder arreglar el tema de la velocidad de carga esta ligado con este proceso la solucion a la que llegamos es crear los campos debit y credit en customers y en cada proceso del sistema en los que se cree elimine o editen transacciones se debe de editar el valor de customers;
            //$customers->money=$money['credit'];
            $debe_customer=($due['total']-$due['pamnt']);//se agrego el campo de money debit por el item de gastos que se mencino en fechas anteriores
			$var_excluir=false;
            $lista_invoices = $this->db->from("invoices")->where("csd",$customers->id)->order_by('invoicedate,tid',"DESC")->get()->result();
            $customer_moroso=false;
            $valor_ultima_factura=0;
            $_var_tiene_internet=false;
            $_var_tiene_tv=false;
            $suscripcion_str="";
            if($debe_customer==0){
                $customer_moroso=false;
            }
                $fact_valida=false;
                $filtros_deuda_customers=0;
                foreach ($lista_invoices as $key => $invoice) {
                    $suma=0;
                    if($invoice->combo!="no" && $invoice->combo!="" && $invoice->combo!="-"){
                        $fact_valida=true;
                        $_var_tiene_internet=true;
                    }
                    if($invoice->television!="no" && $invoice->television!="" && $invoice->television!="-"){
                        $fact_valida=true;
                        $_var_tiene_tv=true;
                    }
                    if($invoice->ron!="" && $invoice->ron!=null){
                        $fact_valida=true;
                    }
                    $afiliacion_traslado_omitir=$this->db->query('SELECT * FROM `invoice_items` where (product like "%afiliacion%" or product like "%traslado%") and tid="'.$invoice->tid.'"')->result_array();
                        if(count($afiliacion_traslado_omitir)!=0){
                            $fact_valida=false;
                    }

                    if($invoice->tipo_factura=="Fija" || $invoice->tipo_factura=="Nota Credito" || $invoice->tipo_factura=="Nota Debito"){
                         $fact_valida=false;
                    }
                    if($fact_valida){
                        if($_var_tiene_tv){
                            $producto=null;
                            if(str_replace(" ", "", $invoice->refer)=="Mocoa"){
                                $producto=$this->db->get_where('products', array("pid"=>"159"))->row();
                                $suma+=$producto->product_price;
                            }else{
                                $producto=$this->db->get_where('products', array("pid"=>"27"))->row();
                                $suma+=$producto->product_price+3992;
                            }
                            if($producto!=null){$var_excluir=false;
                                $suscripcion_str="Tv";
                            }
                            
                        }
					if($invoice->puntos!="" && $invoice->puntos!="0" && $invoice->puntos!=null && $invoice->puntos!="no"){
                            $puntosvar="+".$invoice->puntos." Pts";
                            $suscripcion_str.="+".$invoice->puntos." Pts";

                            $punto_adicional=$this->db->get_where("products", array('product_name' =>"Punto Adicional"))->row();
                            $suma+=$punto_adicional->product_price*$invoice->puntos;
                       }
						
				//esto es para los estados
							if($_var_tiene_tv && $invoice->estado_tv=="Cortado"){
								if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
									//$var_excluir=true;    
								}
								if(strpos($_GET['estados_multiple'], "Cortado")!==false ){
									$var_excluir=false;                    
								}$var_excluir=false; 
								$suscripcion_str="<b><i class='sts-Cortado'>Tv".$puntosvar."</i></b>";   
							}else if($_var_tiene_tv && $invoice->estado_tv=="Suspendido"){
								$suscripcion_str="<b><i class='sts-Suspendido'>Tv".$puntosvar."</i></b>";   
								if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
									//$var_excluir=true;    
								}$var_excluir=false; 
								if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
									$var_excluir=false;                    
								}
							}

				//esto es para los estados 

                        if($_var_tiene_internet){
                            $lista_de_productos=$this->db->from("products")->like("product_name","mega","both")->get()->result();
                            $var_e=strtolower(str_replace(" ", "",$invoice->combo));
                            foreach ($lista_de_productos as $key => $prod) {
                                $prod->product_name=strtolower(str_replace(" ", "",$prod->product_name ));
                                if($prod->product_name==$var_e){
                                    $suma+=$prod->product_price;                                    
                                    break;
                                }
                            }
                            if(!empty($var_e)){$var_excluir=false;
                                if($suscripcion_str!=""){
                                    if($invoice->estado_combo=="Cortado"){
                                        if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                           // $var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Cortado")!==false ){
                                            $var_excluir=false;                    
                                        }$var_excluir=false; 
                                        
                                        $suscripcion_str.="+"."<b><i class='sts-Cortado'>".$var_e."</i></b>";   
                                    }else if($invoice->estado_combo=="Suspendido"){
                                        if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                                            $var_excluir=false;                    
                                        }$var_excluir=false; 
                                        $suscripcion_str.="+"."<b><i class='sts-Suspendido'>".$var_e."</i></b>";   
                                    }else{
                                        $suscripcion_str.="+".$var_e;    
                                    }
                                    
                                }else{
                                    if($invoice->estado_combo=="Cortado"){
										if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Cortado")!==false){
                                            $var_excluir=false;                    
                                        } $var_excluir=false;               
                                        $suscripcion_str="<b><i class='sts-Cortado'>".$var_e."</i></b>";   
                                    }else if($invoice->estado_combo=="Suspendido"){
                                        if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                                            //$var_excluir=true;    
                                        }
                                        if(strpos($_GET['estados_multiple'], "Suspendido")!==false){
                                            $var_excluir=false;                    
                                        }$var_excluir=false; 
                                        $suscripcion_str="<b><i class='sts-Suspendido'>".$var_e."</i></b>";   
                                    }else{
                                        $suscripcion_str=$var_e;    
                                    }
                                    
                                }   
                            }
                            
                        }
                        
                    }else{
                        $var_excluir=true;
                    }
                    $invoice->total=$suma;
                   // if(!$fact_valida){
                          /*  $query=$this->db->query('SELECT * FROM `invoice_items` WHERE tid='.$invoice->tid.' and (product like "%mega%" or product like "%tele%" or product like "%punto adicional%")')->result_array();
                            if(count($query)!=0){
                                $fact_valida=true;
                                $suma=0;
                                foreach ($query as $key => $value) {
                                    if(strpos(strtolower($value['product']),"reconexi" )!==false || strpos(strtolower($value['product']),"afiliaci" )!==false){
                                            
                                    }else{
                                        $suma+=$value['subtotal'];    
                                    }
                                    
                                    //si se selecciona el filtro por servicios realiza este filtro
                                    if(isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null){
                                        if(strpos(strtolower($value['product']),"mega" )!==false){
                                            $_var_tiene_internet=true;
                                        }
                                        if(strpos(strtolower($value['product']),"television" )!==false){
                                            $_var_tiene_tv=true;   
                                        }
                                    }

                                }
                                $invoice->total=$suma;
                            }*/
                   // }
                    if( isset($filtro_deudores_multiple_2['menosdeunmes'])){
                        if($fact_valida && $debe_customer<$invoice->total && $debe_customer>0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }    
                    if(isset($filtro_deudores_multiple_2['1mes'])){
                        if($fact_valida && $debe_customer==$invoice->total && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['masdeunmes'])){
                        if($fact_valida && $debe_customer>$invoice->total && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['2meses'])){
                        if($fact_valida && $debe_customer>=($invoice->total*2) && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['3y4meses'])){
                        if($fact_valida && $debe_customer>=($invoice->total*3) && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['Todos'])){
                        if($fact_valida && $debe_customer>0 && $customer_moroso==false && $invoice->total>0){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }
                    }
                     if( isset($filtro_deudores_multiple_2['saldoaFavor']) && $invoice->total>0){
                        if($fact_valida && $debe_customer<0 && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }

                    }
                     if( isset($filtro_deudores_multiple_2['al Dia'])){
                        if($fact_valida && $debe_customer==0 && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            $filtros_deuda_customers++;
                            if($filtros_deuda_customers==$n_filtro_deudores){
                                break;    
                            }
                            
                        }

                    }
                     if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null ||$_GET['deudores_multiple']=="null"){
                        if($fact_valida){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;
                        }

                    }

                    
                }    
            
            //filtro por servicios con morosos
            if(isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null ){
                //aunque sea moroso pero para aplicar el filtro se va a cambiar la variable moroso
               
                 if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null || $_GET['deudores_multiple']=="null"){//para que muestre todos si esta seleccionada esta opcion, probar si colocando esta condicion encima del if funciona bien para eliminar y dejar solo una
                    $customer_moroso=true;
                }

                if($_GET['sel_servicios']=="Internet" && !$_var_tiene_internet){
                            $customer_moroso=false;                        
                }else if($_GET['sel_servicios']=="TV" && !$_var_tiene_tv){//preguntar que si solo debe de filtrar los que tienen tv o si tiene tv pero tambien internet lo puede listar lo mismo con la de internet
                            $customer_moroso=false;     
                }else if($_GET['sel_servicios']=="Combo" ){
                    if(!$_var_tiene_internet || !$_var_tiene_tv){
                        $customer_moroso=false;
                    }
                }

                if($_GET['checked_ind_service']=="true"){
                    if($_GET['sel_servicios']=="Internet" && $_var_tiene_tv ){
                            $customer_moroso=false;                        
                    }else if($_GET['sel_servicios']=="TV" && $_var_tiene_internet){//preguntar que si solo debe de filtrar los que tienen tv o si tiene tv pero tambien internet lo puede listar lo mismo con la de internet
                                $customer_moroso=false;     
                    }                        
                }

                if($_GET['check_usuarios_a_facturar']=="true"){
                                        

                    if($customers->facturar_electronicamente==0){
                        $customer_moroso=false; 
                    }
                }
				
				 if($var_excluir){
                     $customer_moroso=false;
                }
            }else{
                 if($_GET['deudores_multiple']=="" || $_GET['deudores_multiple']==null || $_GET['deudores_multiple']=="null"){//para que muestre todos si esta seleccionada esta opcion, probar si colocando esta condicion encima del if funciona bien para eliminar y dejar solo una
                    $customer_moroso=true;
                }
            }
            //end fitro por servicios con morosos 
            $equipo=$this->db->get_where("equipos",array("asignado"=>$customers->id))->row();
            //end fitro por servicios con morosos 

            $tegnologia="Sin Teg.";
            if(isset($equipo)){
                $tegnologia=$equipo->t_instalacion;
            }
            if($customer_moroso && $_GET['tegnologia_multiple']!="null"){

                if($tegnologia=="FTTH"  && strpos($_GET['tegnologia_multiple'], "FTTH")!==false){
                    $customer_moroso=true;
                }else if($tegnologia=="EOC"  && strpos($_GET['tegnologia_multiple'], "EOC")!==false){
                    $customer_moroso=true;
                }else if(($tegnologia=="Sin Teg." || $tegnologia=="") && strpos($_GET['tegnologia_multiple'], "Sin Teg")!==false){
                    $customer_moroso=true;
                }else{
                    $customer_moroso=false;
                }
            }
             $array_add=array("id"=>$customers->id,"valido"=>$customer_moroso);

                if($_GET['ultimo_estado_sel']=="Si"){
                               if($customer_moroso){
                                    $array_add= $this->customers->calculo_ultimo_estado($array_add,$customers);  
                                    $customer_moroso=$array_add['valido'];
                               }
                }
                if($_GET['check_sin_factura_actual']=="true" && $customer_moroso){
                    $fecha_actual=new DateTime();
                    $f1=$fecha_actual->format("Y-m")."-01";
                    $f2=$fecha_actual->format("Y-m-d");
                    $ultima=$this->db->query("select * from invoices where csd=".$customers->id." and invoicedate BETWEEN '".$f1."' and '".$f2."'")->result_array();
                    if(count($ultima)!=0){
                        $customer_moroso=false;
                    }
                    
                }
                if($_GET['check_equipos_asignados']=="true" && $customer_moroso){
                    $equipo_x=$this->db->get_where("equipos",array("asignado"=>$customers->id))->row();
                    if(empty($equipo_x)){
                        $customer_moroso=false;
                    }
                }
            if($customer_moroso){
                $this->db->update("customers",array("checked_seleccionado"=>1),array('id' =>$customers->id));
                    //$listax[]=array('id' =>$customers->id ,"celular"=>$customers->celular);                                    
            }
             
        }
        
        echo json_encode($listax);
    
    }
    public function deseleccionar_customers(){
        $this->db->update("customers",array("checked_seleccionado"=>0),array("gid"=>$_GET['id']));
        echo json_encode(array("estatus"=>"desdeleccionados"));
    }
    public function get_seleccionados_sms_y_cortar(){
        $lista = $this->db->get_where("customers",array("checked_seleccionado"=>1,"gid"=>$_GET['id']))->result_array();
        $listax=array();
        foreach ($lista as $key => $customers) {
             
            $listax[]=array('id' =>$customers['id'] ,"celular"=>$customers['celular']);    
        }

        echo json_encode($listax);    
    }

    public function create()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create Group';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/add');
        $this->load->view('fixed/footer');
    }

    public function add()
    {
        $group_name = $this->input->post('group_name');
        $group_desc = $this->input->post('group_desc');

        if ($group_name) {
            $this->clientgroup->add($group_name, $group_desc);
        }
    }

    public function editgroup()
    {
        $gid = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('customers_group');
        $this->db->where('id', $gid);
        $query = $this->db->get();
        $data['group'] = $query->row_array();

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Group';
        $this->load->view('fixed/header', $head);
        $this->load->view('groups/groupedit', $data);
        $this->load->view('fixed/footer');

    }
      public function comprovar_facturas_que_se_van_a_editar(){
        $lista=$this->db->get_where("invoices",array("notes"=>".","invoicedate"=>"2021-11-01"))->result_array();
        foreach ($lista as $key => $value) {
            $query="select * from invoices where csd=".$value['csd']." and tid!='".$value['tid']."' order by id desc limit 1";
            $l2=$this->db->query($query)->result();
            foreach ($l2 as $key => $value2) {
                if($value2->estado_combo=="Suspendido" || $value2->estado_combo=="Cortado"){
                    var_dump(" este customer ".$value2->csd);
                  
                }
                if($value2->estado_tv=="Suspendido" || $value2->estado_tv=="Cortado"){
                    var_dump(" este customer ".$value2->csd);
                } 
            }
            
        }
    }
    public function editar_estado_de_facturas_generadas(){
        set_time_limit(3000);
        $lista=$this->db->get_where("invoices",array("notes"=>".","invoicedate"=>"2021-11-01"))->result_array();
        foreach ($lista as $key => $value) {
            $query="select * from invoices where csd=".$value['csd']." and tid!='".$value['tid']."' order by id desc limit 1";
            $l2=$this->db->query($query)->result();
            foreach ($l2 as $key => $value2) {
                if($value2->estado_combo=="Suspendido" || $value2->estado_combo=="Cortado"){
                    var_dump(" este customer ".$value2->csd);
                    $this->db->update("invoices",array("estado_combo"=>$value2->estado_combo),array("tid"=>$value['tid']));
                }
                if($value2->estado_tv=="Suspendido" || $value2->estado_tv=="Cortado"){
                    var_dump(" este customer ".$value2->csd);
                }   $this->db->update("invoices",array("estado_tv"=>$value2->estado_tv),array("tid"=>$value['tid']));
            }
            
        }
    }

    public function editgroupupdate()
    {
        $gid = $this->input->post('gid');
        $group_name = $this->input->post('group_name');
        $group_desc = $this->input->post('group_desc');
        if ($gid) {
            $this->clientgroup->editgroupupdate($gid, $group_name, $group_desc);
        }
    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');
        if ($id != 1) {
            $this->db->delete('customers_group', array('id' => $id));
            $this->db->set(array('gid' => 1));
            $this->db->where('gid', $id);
            $this->db->update('customers');
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else if ($id == 1) {
            echo json_encode(array('status' => 'Error', 'message' => 'You can not delete the default group!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    function sendGroup()
    {
        $id = $this->input->post('gid');
        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $recipients = $this->clientgroup->recipients($id);
        $this->load->model('communication_model');
        $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);
    }
    public function cancelar_envio_de_mensajes(){
        $_COOKIE['cancelar_envio_mensajes']="true";
    }
    public function sendGroupSms()
    {set_time_limit(400);
        /*$id = $this->input->post('gid');
        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $recipients = $this->clientgroup->recipients($id);
        $this->load->model('communication_model');
        $this->communication_model->group_email($recipients, $subject, $message, $attachmenttrue, $attachment);*/
        //var_dump($_POST);
        $message = $this->input->post('text2');
        $number = $this->input->post('number2');
        $name_campaign = $this->input->post('name_campaign');
        $this->load->library('CellVozApi');
        $api = new CellVozApi();
        $retorno=$api->getToken(); 
        $valido=false;
        $alerta=" ";        

        if($_POST['numerosMasivos']==""){

            if(is_integer(intval($number)) && strlen($number)==10){
                $valido=true;
            }else{
                $alerta.="Numero no valido <br> ";
                $valido=false;
            }
        }else{

            //falta validar cada numero que sea de 10 dijitos y letra o si no borrarlo y si no hay ninguno valido, enviar alerta y tambien dar informacion de los que se excluyeron
            //y leer todo el codigo de la libreria metodo a metodo para ver como puedo aplicar los componentes json necesarios para el envio de mensajes masivos enves de individuales;        
            //Con la Ayuda de Dios lo saco jejejeje :)
            //pero mañana con el favor de el ...
            $numeros=str_replace(" ","",$_POST['numerosMasivos']);
            $numeros=explode(",",$numeros);        
            $valido=true;
            //var_dump($numeros);
        }
        //var_dump($_POST);
        //var_dump($_POST['numerosMasivos']);
        if($message==""){
            $alerta.=" Mensaje no puede ser vacio";
            $valido=false;
        }else{

        }
        
if ($valido) {
            $mensaje="";
            $caracteres_pasados="";
            if(is_array($numeros)){
                $mensajes_a_enviar="";
                $this->load->model('Reports_model', 'reports');


                foreach ($numeros as $key => $numer) {
                    
                        $msg_customer=$message;
                        $datosy=explode("-", $numer);
                    if(strlen($datosy[1])==10){    

                        //asignacion de variables
                        $customer= $this->db->get_where("customers",array("id"=>$datosy[0]))->row();
                        
                        $due=$this->customers->due_details($customer->id);
                        
                        //$customers->money=$money['credit']-$money['debit'];
                        $debe_customer=($due['total']-$due['pamnt']);//se agrego el campo de money debit por el item de gastos que se mencino en fechas anteriores
                        //$msg_customer="Señor(a) ".$customer->name." ".$customer->unoapellido." su saldo es ".amountFormat($debe_customer)." ".$message;
                        $url_str=$_SESSION[md5("variable_datos_pin")]['url']."/co/es?clcs=".$customer->id;
                        $msg_customer=str_replace("{primer_nombre}",$customer->name,$msg_customer);
                        $msg_customer=str_replace("{segundo_nombre}",$customer->dosnombre,$msg_customer);
                        $msg_customer=str_replace("{primer_apellido}",$customer->unoapellido,$msg_customer);
                        $msg_customer=str_replace("{segundo_apellido}",$customer->dosapellido,$msg_customer);
                        $msg_customer=str_replace("{monto_debe}",amountFormat($debe_customer),$msg_customer);
                        $msg_customer=str_replace("{documento}",$customer->documento,$msg_customer);
                        $msg_customer=str_replace("{url-automatica-segun-el-usuario}",$url_str,$msg_customer);
                        $msg_customer=str_replace("{mes_actual}",$this->reports->devolver_nombre_mes(date("m")),$msg_customer);
                        if(strlen($msg_customer)>=160){
                            $caracteres_pasados.=$msg_customer.","; 
                        }else{
                        $ultimo_mensaje=$msg_customer;
                    //end asignacion de variables
                        $msg_customer='               {
                                  "codeCountry": "57",
                                  "number": "'.$datosy[1].'",
                                  "message": "'.$msg_customer.'",
                                  "type": 1
                                }';

                        $mensajes_a_enviar.=$msg_customer.","; 
                        }
                    }else{
                        /*$msg_customer='               {
                                  "codeCountry": "57",
                                  "number": "notiene",
                                  "message": "no tiene",
                                  "type": 1
                                }';*/

                        //$caracteres_pasados.=$msg_customer.","; 
                    }  

                }
                        //$mensajes_a_enviar = trim($mensajes_a_enviar, ',');
                if($_POST['ultimo_lote']=="si"){
                //agregar numero del jefe
                    $mensajes_a_enviar.='{
                                  "codeCountry": "57",
                                  "number": "3106247129",
                                  "message": "'.$ultimo_mensaje.'",
                                  "type": 1
                                }';
                }else{
                    $mensajes_a_enviar = trim($mensajes_a_enviar, ',');
                }
                //var_dump($mensajes_a_enviar);
                if($_COOKIE['cancelar_envio_mensajes']=="false" || isset($_POST['envio_desde_factura'])){//var_dump($mensajes_a_enviar);
                    $var=$api->envio_sms_masivos_por_curl($retorno['token'],$mensajes_a_enviar,$name_campaign);            
                }                
                //$mensaje=json_decode($var);
                /*if($mensaje->success==true){
                    $mensaje="Enviado";
                }else{
                    $mensaje=$mensaje->message;
                }*/
//falta agregar los numeros del usuario y mensajes de exito
                $mensaje="Enviado";
            }else{
                if($_COOKIE['cancelar_envio_mensajes']=="false"){
                    $var=$api->alternativa_por_curl_envio_sms_invividual($retorno['token'],$number,$message);    
                }
                $mensaje="Enviado";
                $mensaje=$var->getMessage();
            }

            if($mensaje=="Enviado"){
                echo json_encode(array('status' => 'Success-sms', 'message' => 'SMS Enviado Con Exito',"variable completa"=>$var,"caracteres_pasados"=>$caracteres_pasados));    
            }else{
                echo json_encode(array('status' => 'Error-sms', 'message' => $mensaje, "variable completa"=>$var));    
            }
            
        } else {
            echo json_encode(array('status' => 'Error-sms', 'message' => $alerta));
        }                      
        
    }
    public function cambiar_barrios(){
        set_time_limit(6000);
        $lista_customers=$this->db->get_where("customers")->result_array();
        foreach ($lista_customers as $key => $value) {
            $barrio =ucwords(strtolower($value['barrio']));
            
            $this->db->update("customers",array("barrio"=>$barrio),array('id' => $value['id']));
        }
        
        var_dump("Exito");
    }
    public function prueba_envio_masivo_sms_curl(){
        set_time_limit(6000);
        $this->load->library('CellVozApi');
        $api = new CellVozApi();
        $retorno=$api->getToken(); 
        var_dump($api->envio_sms_masivos_por_curl_2($retorno->getToken(),"",""));
    }
    public function cortar_usuarios_multiple(){
        include (APPPATH."libraries/RouterosAPI.php");
        $API = new RouterosAPI();
        $API->debug = false;
        $tipo_corte=$this->input->post("tipo_corte");
        $ids_customers_corte=$this->input->post("ids_customers_corte");
        $description_corte=$this->input->post("description_corte");
        $tiket_en_pendiente=$this->input->post("tiket_en_pendiente");
        $this->load->model("quote_model","quote");
        
        $valido=true;
        $alerta="";
        if($tipo_corte==""){
            $alerta="<li>Tipo de corde no puede ser vacio</li>";                
            $valido=false;
        }
        
        if($ids_customers_corte==""){
            $alerta.="<li>Selecciona usuarios por favor</li>";                
            $valido=false;
        }
        $ids_customers_corte=explode(",", $ids_customers_corte);

            if($valido){
                $bill_llegada=date("Y-m-d");
                foreach ($ids_customers_corte as $key => $customer_id) {
                    $obtenido_de_servicio_details=$this->customers->servicios_detail($customer_id);
                    $factura=0;
                        if(isset($obtenido_de_servicio_details['tid']) && $obtenido_de_servicio_details['tid']!=0){
                                $factura=$obtenido_de_servicio_details;
                                $status="Resuelto";
                                if($tiket_en_pendiente=="true" || $tiket_en_pendiente==true){
                                    $status="Pendiente";
                                }
                                $nticket=($this->quote->lastquote())+1;
                                $data = array(
                                    'codigo' => $nticket,
                                    'subject' => "servicio",
                                    'detalle' => $tipo_corte,
                                    'created' => $bill_llegada,
                                    'cid' => $customer_id,
                                    'status' => $status,
                                    'section' => $description_corte,
                                    'fecha_final' => $bill_llegada,
                                    'id_invoice' => 'null',
                                    'id_factura' => $factura['tid'],          
                                );   
                                if($tiket_en_pendiente=="true" || $tiket_en_pendiente==true){
                                    $data['codigo']=$this->quote->comprobar_codigo($nticket);
                                    $this->db->insert('tickets', $data);
                                }                 
                                //$this->db->insert('tickets', $data);
                        //falta realizar el corte en la factura y en el customer
                        //y en la microtik y terminariamos con este tema Gloria a Dios
                        //desactivacion en la mikrotik
                    if($tiket_en_pendiente=="false" || $tiket_en_pendiente==false){
                        $customer = $this->db->get_where("customers",array("id"=>$customer_id))->row();
                        if($tipo_corte=="Corte Combo") {
                            $reconexion = '0';
                            if ($factura['combo']!='no' || $factura['combo']!='' || $factura['combo']!='-'){
                                    $reconexion = '1';
                            }
                            
                            /*$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexion Combo'))->row();
                                $data2['tid']=$factura['tid'];
                                $data2['pid']=$producto2->pid;
                                $data2['product']=$producto2->product_name;
                                $data2['price']=$producto2->product_price;
                                $data2['qty']=1;
                                $data2['subtotal']=$producto2->product_price;*/
                                //SELECT * FROM `invoice_items` where product like "%Reconexión Internet%"
                                
                                    $data['codigo']=$this->quote->comprobar_codigo($nticket);
                                    $this->db->insert('tickets', $data);
                                    //$this->db->insert('invoice_items',$data2);    
                                    //actualizar factura
                                //$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
                                    //$this->db->set('subtotal', $factura['subtotal']+$producto2->product_price);
                                    $this->db->set('ron', 'Cortado');               
                                    /*$this->db->set('total', $factura['total']+$producto2->product_price);
                                    $this->db->set('items', $factura['items']+1);*/
                                    $this->db->set('rec', $reconexion);
                                    /*$this->db->set('television', 'no');
                                    $this->db->set('combo', 'no');*/
                                     $this->db->set('estado_tv', 'Cortado');
                                    $this->db->set('estado_combo', 'Cortado');

                                    $this->db->where('tid', $factura['tid']);
                                    $this->db->update('invoices');
                                //actualizar estado usuario
                                    $this->db->set('usu_estado', 'Cortado');
                                    $this->db->set('perfil', "-");
                                    $this->db->where('id', $customer_id);
                                    $this->db->update('customers');
                                                                
                            
                            //microtik
                            $this->customers->desactivar_estado_usuario_multiple($customer->name_s,$customer->gid,$API,$customer->tegnologia_instalacion);
                            
                        }else if($tipo_corte=="Corte Internet"){
                            //$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
                            $producto2 = $this->db->get_where('products',array('product_name'=>'Reconexión Internet'))->row();
                                if ($factura['television']==='no' || $factura['television']=='' || $factura['television']==null || $factura['television']=='-' || $factura['estado_tv']=="Cortado" ||  $factura['estado_tv']=="Suspendido"){
                                    $nestado = 'Cortado';
                                    $reconexion = '0';
                                }else{
                                    $nestado = 'Activo';
                                    $reconexion = '1';
                                }
                                //actualizar estado usuario
                                $this->db->set('usu_estado', $nestado);
                                $this->db->set('perfil', "-");
                                $this->db->where('id', $customer_id);
                                $this->db->update('customers');
                                //agregar reconexion    
                                /*$data2['tid']=$factura['tid'];
                                $data2['pid']=$producto2->pid;
                                $data2['product']=$producto2->product_name;
                                $data2['price']=$producto2->product_price;
                                $data2['qty']=1;
                                $data2['subtotal']=$producto2->product_price; */          

                                
                                
                                $data['codigo']=$this->quote->comprobar_codigo($nticket);
                                    $this->db->insert('tickets', $data);
                                    //$this->db->insert('invoice_items',$data2);

                                         //actualizar factura
                                    /*$this->db->set('subtotal', $factura['subtotal']+$producto2->product_price);
                                    $this->db->set('total', $factura['total']+$producto2->product_price);
                                    $this->db->set('items', $factura['items']+1);*/
                                    $this->db->set('ron', $nestado);
                                    $this->db->set('rec', $reconexion);
                                    //$this->db->set('combo', 'no');
                                    $this->db->set('estado_combo', 'Cortado');
                                    $this->db->where('tid', $factura['tid']);
                                    $this->db->update('invoices');
                                
                                
                           

                            $this->customers->desactivar_estado_usuario_multiple($customer->name_s,$customer->gid,$API,$customer->tegnologia_instalacion);
                        }else{
                                /*$producto2 = $this->db->get_where('products',array('product_name'=>'Reconexión Television'))->row();
                                $data2['tid']=$factura['tid'];
                                $data2['pid']=$producto2->pid;
                                $data2['product']=$producto2->product_name;
                                $data2['price']=$producto2->product_price;
                                $data2['qty']=1;
                                $data2['subtotal']=$producto2->product_price;*/

                                
                                $data['codigo']=$this->quote->comprobar_codigo($nticket);
                                    $this->db->insert('tickets', $data);
                                    //$this->db->insert('invoice_items',$data2);

                                    //actualizar factura
                            //$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
                                    /*$this->db->set('subtotal', $factura['subtotal']+$producto2->product_price);
                                    $this->db->set('total', $factura['total']+$producto2->product_price);
                                    $this->db->set('items', $factura['items']+1);*/
                                    $this->db->set('estado_tv', 'Cortado');
                                    $this->db->where('tid', $factura['tid']);
                                    $this->db->update('invoices');
                                    if ($factura['combo']==='no' || $factura['combo']=='' || $factura['combo']==null || $factura['combo']=='-' || $factura['estado_combo']=="Cortado" || $factura['estado_combo']=="Suspendido"){
                                        $this->db->set('ron', 'Cortado');
                                        //$this->db->set('television', 'no');
                                        $this->db->where('tid', $factura['tid']);
                                        $this->db->update('invoices');
                                        //actualizar estado usuario
                                        $this->db->set('usu_estado', 'Cortado');
                                        $this->db->where('id', $customer_id);
                                        $this->db->update('customers');
                                    }else{
                                        //actualizar factura
                                        $this->db->set('ron', 'Activo');
                                        //para generar reconexion
                                        $this->db->set('rec', '1'); 
                                        //$this->db->set('television', 'no');         
                                        $this->db->where('tid', $factura['tid']);
                                        $this->db->update('invoices');
                                        //actualizar estado usuario
                                        $this->db->set('usu_estado', 'Activo');
                                        $this->db->where('id', $customer_id);
                                        $this->db->update('customers');
                                    }
                                          
                                
                            
                        }
                    }
                        //end desactivacion en la mikrotik
                    }else{
                        //aqui seria crear la factura si no la tiene;
                    }                    
                    
                }
                echo json_encode(array('status' => 'Success', 'message' => 'Usuarios cortados con exito...'));           
            }else{
                echo json_encode(array('status' => 'Error', 'message' => $alerta));       
            }
         

         
    }
    public function pay_due_customer_p(){
       ob_end_clean();
        $data_response['cid']="17185";
        $data_response['monto']="64929";
        
        $this->customers->pay_invoices($data_response['cid'],$data_response['monto']);
        echo json_encode($data_response);
    }
    public function descargar_pdf_falctura_usuarios_media_carta(){
        ob_end_clean();
        setlocale(LC_TIME, "spanish");
        ini_set('memory_limit', '1500000M');
        ini_set("pcre.backtrack_limit", "3000000");

        $data=array();

        $fecha_actual= new DateTime(date("Y-m-d 00:00:00"));
        $sede=$this->db->get_where("accounts",array("sede"=>$_GET['gid']))->row();
        $data['sede']=$sede->holder;
        $data['sede_var']=$sede;
        $data['company']=$this->db->get_where("app_system",array("id"=>1))->row();
        $data['fecha']=$fecha_actual->format("Y-m-d");
        $x= new DateTime($data['fecha']);
        $data['fecha']=utf8_encode(strftime("%A,".$x->format("d")." de %B del ".$x->format("Y"), strtotime($data['fecha'])));
        $data['lista']=$this->db->query("SELECT * FROM customers where checked_seleccionado=1 and gid=".$_GET['gid']." order by barrio")->result();
        //var_dump($lista[0]['abonado']);
        /*datos nuevos*/
         $this->load->model('accounts_model');
         $this->load->model('invoices_model', 'invocies');
        
        $data['acclist'] = $this->accounts_model->accountslist();
        $csd = intval($this->input->get('id'));
        $data['customer'] = $this->db->get_where("customers",array("id"=>$csd))->row();
        
        $data['due'] = $this->customers->due_details($csd);
        $total_customer=$data['due']['total']-$data['due']['pamnt'];
        //$data['transaccion'] = $this->invocies->ultima_transaccion_realizada($csd);
        if($total_customer>0){
            $data['products'] = $this->invocies->invoice_sin_pagar($csd);        
        }else if($total_customer==0){
            $data['products'] = $this->invocies->ultima_factura($csd);        
        }else{
            $informacion = $this->invocies->pagadas_adelantadas($csd);        
            $data['products']=array("0"=>$informacion['factura_saldo_adelantado']);
            $data['tr_saldo_adelantado']=$informacion['tr_saldo_adelantado'][0];
            //$data['transaccion']=$informacion['tr_saldo_adelantado'];
            $data['facturas_adelantadas']=$informacion['facturas_adelantadas'];

        }
        $data['total_customer']=$total_customer;
        

//end cambios nuevos


        $data['id'] = $tid;
        $data['title'] = "Estado Usuario $tid";
        $data['customer']->ciudad=$this->db->get_where("ciudad",array("idCiudad"=>$data['customer']->ciudad))->row()->ciudad;               
        //$data['invoice'] = $this->invocies->invoice_details($tid, $this->limited);
        //if ($data['invoice']) $data['products'] = $this->invocies->invoice_products($tid);
        if(isset($data['products'][0]['eid'])){
            $data['employee']=$this->invocies->employee($data['products'][0]['eid']);     
        }else{
            $data['employee']=null;
        }

        //PDF Rendering
        
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        $data['pdf']=$pdf;
        $html = $this->load->view('invoices/generar_pdf_facturas_media_carta.php', $data, true);
       // $pdf->SetHTMLFooter("<div style='text-align:right;'><i><b><small>{PAGENO}/{nbpg}</small></b></i></div>");
        $pdf->WriteHTML($html);
        if ($this->input->get('d')) {
            $pdf->Output('Reporte Facturas Generadas '.$data['sede']." - ".$fecha_actual->format("Y-m-d").".pdf", 'D');
        } else {
            $pdf->Output('Reporte Facturas Generadas '.$data['sede']." - ".$fecha_actual->format("Y-m-d").".pdf", 'I');
        }

    }
    public function procesar_usuarios_a_enviar_correo(){
       
        $customer=$this->db->get_where("customers",array("id"=>$_POST['id']))->row();
$this->load->model('Communication_model', 'communication'); 
//$customer->email="pescafelipe@gmail.com";
$url_str=$_SESSION[md5("variable_datos_pin")]['url']."/comprobantes/estado_de_cuenta?clcs=".$_POST['id'];
$company=$this->db->get_where("app_system",array("id"=>1))->row();
$_POST['texto']=str_replace("{url-automatica-segun-el-usuario}", "",$_POST['texto']);
$cuerpo=$_POST['texto'].$url_str;
        $this->communication->send_email($customer->email,"Estado de Cuenta Usuario ".$company->cname,"Estado de Cuenta Usuario ".$company->cname,$cuerpo);    
        $retorno=array();
        ob_clean();
        $retorno["estado"]="procesado";
            echo json_encode($retorno);
    }
}