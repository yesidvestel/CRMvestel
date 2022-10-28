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

class Customers extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('customers_model', 'customers');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 1) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers';

        $this->db->select("*");
        $this->db->from("customers");        
        
        $this->db->order_by('id', 'DESC');
        $lista_customers=$this->db->get()->result();
        $total=count($lista_customers);
        $x=intval($total/7);
        //var_dump($x);
        $array= array('1' => array('start' => $lista_customers[0]->id,'end' => $lista_customers[$x]->id),//11
            '2' => array('start' => $lista_customers[$x+1]->id,'end' => $lista_customers[$x*2]->id),//12-22
            '3' => array('start' => $lista_customers[($x*2)+1]->id,'end' => $lista_customers[$x*3]->id),//23-33
            '4' => array('start' => $lista_customers[($x*3)+1]->id,'end' => $lista_customers[$x*4]->id),//34-44
            '5' => array('start' => $lista_customers[($x*4)+1]->id,'end' => $lista_customers[$x*5]->id),//45-55
            '6' => array('start' => $lista_customers[($x*5)+1]->id,'end' => $lista_customers[$x*6]->id),//56-66
            '7' => array('start' => $lista_customers[($x*6)+1]->id,'end' => $lista_customers[$total-1]->id),//
        );
        $data['array_pagination']=$array;

        $this->load->view('fixed/header', $head);
        $this->load->view('customers/clist',$data);
        $this->load->view('fixed/footer');
    }

    public function create()
    {

        $data['customergrouplist'] = $this->customers->group_list();				
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['codigo'] = $this->customers->codigouser();
        $head['title'] = 'Create Customer';		 
		$data['departamentos'] = $this->customers->departamentos_list();
        
        $data['ips_remotas']=$this->customers->devolver_ips_proximas();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/create', $data);
        $this->load->view('fixed/footer');
    }
    public function firmadigital(){
        $data['id']=$_GET['id'];
        if(isset($_GET['type'])){
            $data['type']=$_GET['type'];
        }
       // $this->load->view('fixed/header', $head);
        $this->load->view('customers/firma_digital', $data);
        //$this->load->view('fixed/footer');
    }
      public function save_firma(){
        //print_r($_POST);
        $img = $_POST['base64'];
        
        $img = str_replace('data:image/png;base64,', '', $img);
        $fileData = base64_decode($img);
        if(isset($_POST['type']) && $_POST['type']=="orden"){//en este caso variable customer id es el id de la orden
            $fileName = 'assets/firmas_digitales/orden_'.$_POST['customer_id'].'.png';
            file_put_contents($fileName, $fileData);
            $orden=$this->db->get_where("tickets",array("codigo"=>$_POST['customer_id']))->row();
            redirect(base_url()."tickets/thread?id=".$orden->idt);
        }else{
            $fileName = 'assets/firmas_digitales/'.$_POST['customer_id'].'.png';

            file_put_contents($fileName, $fileData);
            $this->db->update("customers",array("firma_digital"=>"1"),array("id"=>$_POST['customer_id']));
            redirect(base_url()."customers/view?id=".$_POST['customer_id']);
        }
        
    }
    public function subir_huella(){
        $data['id']=$_GET['id'];
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create Customer';  
        if(!empty($_POST)){
            if (isset($_FILES['archivo_huella']) && $_FILES['archivo_huella']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['archivo_huella']['tmp_name'];
                $fileName = $_FILES['archivo_huella']['name'];
                $fileSize = $_FILES['archivo_huella']['size'];
                $fileType = $_FILES['archivo_huella']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = 'Huella_CUS_'.$_POST['id'].'.png';
                $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
                $uploadFileDir = './assets/huellas_digitales/';
                $dest_path = $uploadFileDir . $newFileName;
                move_uploaded_file($fileTmpPath, $dest_path);
                redirect(base_url()."customers/view?id=".$_POST['id']);
            }
            
        } else{
        $this->load->view('fixed/header',$head);
        $this->load->view('customers/subir_huella',$data);
        $this->load->view('fixed/footer');    
        } 
        
    }
    public function conectar_microtik(){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = true;
        
        if ($API->connect('190.14.233.186:8728', 'soporte.yopal', 'duber123')) {

         $API->comm("/ppp/secret/add", array(
              "name"     => "user_prueba_duber_disabled",
              "password" => "user_prueba_duber_disabled",
              "remote-address" => "172.16.1.11",
              "local-address" => "10.0.0.5",
              "profile" => "5Megas",
              "comment"  => "{new VPN user}",
              "service"  => "pppoe",
              "disabled"=>"yes"
           ));
        


         $API->disconnect();

        }else{
            echo "no conecto";
        }

    }
    public function conectar_microtik_activos(){
        //para desactivar
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = true;
        
        if ($API->connect('190.14.233.186:8728', 'soporte.yopal', 'duber123')) {

          $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => "PaolaJimenez",
                  ));
        $API->comm("/ppp/active/remove",
            array(
                ".id" => $arrID[0][".id"],
                )
            );
        //var_dump($arrID);
        $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  ".proplist"=> ".id",
                  "?name" => "PaolaJimenez",
                  ));
        $API->comm("/ppp/secret/set",
              array(
                   ".id" => $arrID[0][".id"],
                   "disabled"  => "yes",
                   )
              );
        //var_dump($arrID);


         $API->disconnect();

        }else{
            echo "no conecto";
        }

    }
    public function conectar_microtik_edicion(){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = true;
        
        if ($API->connect('190.14.233.186:8728', 'api.crmvestel', 'duber123')) {

            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  //".proplist"=> ".id",
                  "?name" => "duberduber",
                  ));

           /* $API->comm("/ppp/secret/set",
              array(
                   ".id" => $arrID[0][".id"],
                   "disabled"  => "no",
                   )
              );
*/
            var_dump($arrID);
        


         $API->disconnect();

        }else{
           
        }

    }
	public function file_handling()
    {ini_set('memory_limit', '500M');

        if($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            $type = $this->input->get('type');
            if ($this->customers->meta_delete($invoice,$type, $name)){
                echo json_encode(array('status' => 'Success'));
            }
        }
        else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'//'accept_file_types' => '/\.(gif|jpeg|png|docx|docs|txt|pdf|xls)$/i',
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {

                $this->customers->meta_insert($id, 6, $files);
            }
        }


    }
	public function ciudades_list()
	{ 
		$id = $this->input->post('idDepartamento');
		$ciudades = $this->customers->ciudades_list($id);
		//echo '<select  id="cmbCiudades"  class="selectpicker form-control"><option>Seleccionar</option>';
		$lista_opciones="<option value=''>Seleccionar</option>";
		foreach ($ciudades as $row) {
			$lista_opciones.= '<option value="' . $row->idCiudad . '">' . $row->ciudad . '</option>';
		}
		
		echo $lista_opciones; 
	}
	
	public function localidades_list()
	{ 
		$id = $this->input->post('idCiudad');
		$ciudades = $this->customers->localidades_list($id);
		//echo '<select class="selectpicker form-control"><option>Seleccionar</option>';
		$lista_opciones2="<option value=''>Seleccionar</option>";
		foreach ($ciudades as $row) {
			$lista_opciones2.= '<option value="' . $row->idLocalidad . '">' . $row->localidad . '</option>';
		}
		
		echo $lista_opciones2; 
	}
	
	public function barrios_list()
	{ 
		$id = $this->input->post('idLocalidad');
		$ciudades = $this->customers->barrios_list($id);
		$lista_opciones3="<option value=''>Seleccionar</option>";
		foreach ($ciudades as $row) {
			$lista_opciones3.= '<option value="' . $row->idBarrio . '">' . $row->barrio . '</option>';
		}
		
		echo $lista_opciones3; 
	}
    public function actualizar_debit_y_credit(){
        set_time_limit(10000);
        $customers_lst=$this->db->get_where("customers")->result_array();
        foreach ($customers_lst as $key => $value) {
            $this->customers->actualizar_debit_y_credit($value['id']);
        }
    }
    public function cuenta_firmas(){
        $lista_customers=$this->db->get_where("customers")->result_array();
        $tienen=0;
        $no_tienen=0;
        foreach ($lista_customers as $key => $value) {
            if($this->customers->validar_firma($value['id'])){
               $this->db->update("customers",array("firma_digital"=>"1"),array("id"=>$value['id']));
               $tienen++;
            }else{
                $no_tienen++; 
            }
            
        }
        echo $tienen." usuarios tienen firma , ".$no_tienen." usuarios no tienen firma";

    }
    public function view()
    {
		
        $custid = $this->input->get('id');	
		$this->load->model('ticket_model', 'ticket');
        $data['details'] = $this->customers->details($custid);
        $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
        $data['money'] = $this->customers->money_details($custid);
		$data['departamento'] = $this->customers->group_departamentos($data['details']['departamento']);
		$data['ciudad'] = $this->customers->group_ciudad($data['details']['ciudad']);
		$data['localidad'] = $this->customers->group_localidad($data['details']['localidad']);
		$data['barrio'] = $this->customers->group_barrio($data['details']['barrio']);
		$data['equipo'] = $this->customers->equipo_details($custid);
        $data['due'] = $this->customers->due_details($custid);
        $data['servicios'] = $this->customers->servicios_detail($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['activity']=$this->customers->activity($custid);
		$data['facturalist'] = $this->ticket->factura_list($custid);
		$data['attach'] = $this->customers->attach($custid);
        $data['validar_firma']=$this->customers->validar_firma($custid);
        $data['estado_mikrotik']=$this->customers->get_estado_mikrotik($data['details']['name_s'],$data['details']['gid'],$data['details']['tegnologia_instalacion']);        
        $data['color']="#5ccb5f";
        if(empty($data['estado_mikrotik'])){
            $data['color']="red";
        }
        $this->customers->actualizar_debit_y_credit($custid);
        if($data['servicios']['estado_combo']=="Cortado"){
            $data['servicios']['combo']=$data['servicios']['combo']="<b><i class='sts-Cortado'>".$data['servicios']['paquete']."</i></b>";   
        }else if($data['servicios']['estado_combo']=="Suspendido"){
            $data['servicios']['combo']=$data['servicios']['combo']="<b><i class='sts-Suspendido'>".$data['servicios']['paquete']."</i></b>";   
        }

        if($data['servicios']['estado_tv']=="Cortado"){
            $data['servicios']['television']="<b><i class='sts-Cortado'>Tv</i></b>";   
        }else if($data['servicios']['estado_tv']=="Suspendido"){
            $data['servicios']['television']="<b><i class='sts-Suspendido'>Tv</i></b>";   
        }
if($data['servicios']['estado']=="Inactivo"){
    $customer1=$this->db->get_where("customers",array("id"=>$custid))->row();
    if($customer1->usu_estado!="Inactivo" && $customer1->usu_estado!="0"  && $customer1->usu_estado!=""){
        $data['servicios']['estado']=$customer1->usu_estado;
    }
}
        $head['title'] = 'View Customer';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/view', $data);
        $this->load->view('fixed/footer');
    }

    public function load_list()
    {
        $list = $this->customers->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $customers) {
            $no++;

            $row = array();
            $row[] = $no;
			$row[] = $customers->abonado;
            $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
			$row[] = $customers->celular;
			$row[] = $customers->documento;
            $row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
			$row[] = '<span class="st-'.$customers->usu_estado. '">' .$customers->usu_estado. '</span>';
            $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span>  '.$this->lang->line('Edit').'</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->count_all(),
            "recordsFiltered" => $this->customers->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function load_morosos(){
        ini_set('memory_limit', '250M');
        if($this->input->post('start')!="0"){
            
            $this->list_data_precargada();
            
        }else{

        $listax=array();
        $this->db->select("*");
        $this->db->from("customers");        
        
        if (isset($_GET['estado']) && $_GET['estado'] != '' && $_GET['estado'] != null) {
            $this->db->where('usu_estado=', $_GET['estado']);
        }
        if (isset($_GET['direccion']) &&$_GET['direccion'] =="Personalizada"){ 

            if($_GET['ciudad'] != '' && $_GET['ciudad'] != '-' && $_GET['ciudad'] != '0'){

                $ciudad = $_GET['ciudad'];
                if($ciudad=="Yopal"){
                    $ciudad="2";
                }else if($ciudad=="Villanueva"){
                    $ciudad="3";
                }else if($ciudad=="Monterrey"){
                    $ciudad="4";
                }else if($ciudad=="Mocoa"){
                    $ciudad="5";
                }
                $this->db->where("gid",$ciudad);    
            }
            

            if ($_GET['localidad'] != '' && $_GET['localidad'] != '-' && $_GET['localidad'] != '0') {
                $this->db->where('localidad=', $_GET['localidad']);
            }

            if ($_GET['barrio'] != '' && $_GET['barrio'] != '-' && $_GET['barrio'] != '0') {
                $this->db->where('barrio=', $_GET['barrio']);
            }
            if ($_GET['nomenclatura'] != '' && $_GET['nomenclatura'] != '-') {
                $this->db->where('nomenclatura=', $_GET['nomenclatura']);
            }
            if ($_GET['numero1'] != '') {
                $this->db->where('numero1=', $_GET['numero1']);
            }
            if ($_GET['adicionauno'] != '' && $_GET['adicionauno'] != '-') {
                $this->db->where('adicionauno=', $_GET['adicionauno']);
            }
            if ($_GET['numero2'] != '' && $_GET['numero2'] != '-') {
                $this->db->where('numero2=', $_GET['numero2']);
            }
            if ($_GET['adicional2'] != '' && $_GET['adicional2'] != '-') {
                $this->db->where('adicional2=', $_GET['adicional2']);
            }
            if ($_GET['numero3'] != '' && $_GET['numero3'] != '-') {
                $this->db->where('numero3=', $_GET['numero3']);
            }
        }

         if($_GET['pagination_start']!="" && $_GET['pagination_start']!=null){
                $this->db->where('id<',$_GET['pagination_start']);
                $this->db->where("id>",$_GET['pagination_end']);    
                //eh pensado una forma mucho mas compleja para realizar esto y es atraves de multihilo o multitarea algo muy complejo pero con tiempo seria bueno intentarlo
        }
        $this->db->order_by('id', 'DESC');
        $lista_customers=$this->db->get()->result();



        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        $maximo=$minimo+10;
        $descontar=0;
        foreach ($lista_customers as $key => $customers) {
            $due=$this->customers->due_details($customers->id);
            $debe_customer=$due['total']-$due['pamnt'];
            $lista_invoices = $this->db->from("invoices")->where("csd",$customers->id)->order_by('invoicedate',"DESC")->get()->result();
            $customer_moroso=false;
            $valor_ultima_factura=0;
            $_var_tiene_internet=false;
            $_var_tiene_tv=false;
            if($debe_customer==0){
                $customer_moroso=false;
            }
                $fact_valida=false;
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
                    if($fact_valida){
                        if($_var_tiene_tv){
                            if(str_replace(" ", "", $invoice->refer)=="Mocoa"){
                                $producto=$this->db->get_where('products', array("pid"=>"159"))->row();
                                $suma+=$producto->product_price;
                            }else{
                                $producto=$this->db->get_where('products', array("pid"=>"27"))->row();
                                $suma+=$producto->product_price+3992;
                            }
                            
                        }

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
                        }
                        
                    }
                    $invoice->total=$suma;
                   // if(!$fact_valida){
                           /* $query=$this->db->query('SELECT * FROM `invoice_items` WHERE tid='.$invoice->tid.' and (product like "%mega%" or product like "%tele%" or product like "%punto adicional%")')->result_array();
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
                                
                            }*/
                            
                   // }
                    if($_GET['morosos']=="1mes"){
                        if($fact_valida && $debe_customer==$invoice->total && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            break;
                        }
                    }else if($_GET['morosos']=="masdeunmes"){
                        if($fact_valida && $debe_customer>$invoice->total && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            break;
                        }
                    }else if($_GET['morosos']=="2meses"){
                        if($fact_valida && $debe_customer>=($invoice->total*2) && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            break;
                        }
                    }else if($_GET['morosos']=="3y4meses"){
                        if($fact_valida && $debe_customer>=($invoice->total*3) && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            break;
                        }
                    }else if($_GET['morosos']=="Todos"){
                        if($fact_valida && $debe_customer>0 && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            break;
                        }
                    }else if($_GET['morosos']=="saldoaFavor"){
                        if($fact_valida && $debe_customer<0 && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            break;
                        }

                    }else if($_GET['morosos']=="al Dia"){
                        if($fact_valida && $debe_customer==0 && $customer_moroso==false){
                            $customer_moroso=true;
                            $valor_ultima_factura=$invoice->total;
                            break;                    
                        }else if($fact_valida){
                            break;
                        }

                    }else if($_GET['morosos']==""){
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
               
                if($_GET['morosos']==""){//para que muestre todos si esta seleccionada esta opcion, probar si colocando esta condicion encima del if funciona bien para eliminar y dejar solo una
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

            }else{
                if($_GET['morosos']==""){//para que muestre todos si esta seleccionada esta opcion
                    $customer_moroso=true;
                }
            }
            //end fitro por servicios con morosos 

            if($customer_moroso){
                if(($x>=$minimo && $x<$maximo) || $_POST['length']=="100"){
                    $no++;                
                    
                    $row = array();
                        

                        $row[] = $no;
                        $row[] = $customers->abonado;
                        $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
                        $row[] = $customers->celular;
                        $row[] = $customers->documento;
                        $row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                        $row[] = '<span class="st-'.$customers->usu_estado. '">' .$customers->usu_estado. '</span>';
                        $row[] = amountFormat($debe_customer);
                        $row[] = amountFormat($valor_ultima_factura);
                        $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span>  '.$this->lang->line('Edit').'</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';                            

                        $data[] = $row;
                    

                }

                $x++;
                $customers->debe_customer=$debe_customer;
                $customers->valor_ultima_factura=$valor_ultima_factura;
                $listax[]=$customers;
            }else{
                $descontar++;
            }
             
        }

        $datax['datos']=json_encode($listax);
        $this->db->update("filtros_historial",$datax, array("id"=>$this->aauth->get_user()->id));
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
    public function list_data_precargada(){
        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        $maximo=$minimo+10;
        $descontar=0;
        $lista=$this->db->get_where("filtros_historial",array('id' =>$this->aauth->get_user()->id))->row();
        $lista2=json_decode($lista->datos);
        
        foreach ($lista2 as $key => $customers) {
            
            if(($x>=$minimo && $x<$maximo) || $_POST['length']=="100"){
                     $no++;                
                    
                    $row = array();
                            $row[] = $no;
                            $row[] = $customers->abonado;
                            $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name ." ". $customers->unoapellido. '</a>';
                            $row[] = $customers->celular;
                            $row[] = $customers->documento;
                            $row[] = $customers->nomenclatura . ' ' . $customers->numero1 . $customers->adicionauno.' Nº '.$customers->numero2.$customers->adicional2.' - '.$customers->numero3;
                            $row[] = '<span class="st-'.$customers->usu_estado. '">' .$customers->usu_estado. '</span>';
                            $row[] = amountFormat($customers->debe_customer);
                            $row[] = amountFormat($customers->valor_ultima_factura);
                            $row[] = '<a href="customers/view?id=' . $customers->id . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="customers/edit?id=' . $customers->id . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span>  '.$this->lang->line('Edit').'</a> <a href="#" data-object-id="' . $customers->id . '" class="btn btn-danger btn-sm delete-object"><span class="icon-bin"></span></a>';                            

                            

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
    public function edita_estado_usuario(){
        $customer1=$this->db->get_where("customers",array("id"=>$_GET['id_cm']))->row();
        $this->customers->editar_estado_usuario($_GET['username'],$_GET['id_sede'],$customer1->tegnologia_instalacion);
        redirect(base_url()."customers/view?id=".$_GET['id_cm']);
    }

    public function validar_user_name(){
        $resultado =$this->customers->validar_user_name($_POST['username'],$_POST['sede'],$_POST['tegnologia_instalacion']);
        if($resultado==null){
            echo "disponible";
        }else{
            echo "existe";
        }
       
        
    }
    //edit section
    public function edit()
    {
        $pid = $this->input->get('id');
        $data['customer'] = $this->customers->details($pid);
        $data['customergroup'] = $this->customers->group_info($data['customer']['gid']);
		$data['departamentos'] = $this->customers->departamentos_list();		
		$data['departamento'] = $this->customers->group_departamentos($data['customer']['departamento']);
		$data['ciudad'] = $this->customers->group_ciudad($data['customer']['ciudad']);
		$data['localidad'] = $this->customers->group_localidad($data['customer']['localidad']);
		$data['barrio'] = $this->customers->group_barrio($data['customer']['barrio']);
		$data['equipo'] = $this->customers->equipo_details($custid);
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Customer';	
		$data['departamentoslist'] = $this->customers->departamentos_list();		
        $data['ips_remotas']=$this->customers->devolver_ips_proximas();
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/edit', $data);
        $this->load->view('fixed/footer');

    }
    public function get_comentario_mikrotik(){
        $username=$this->customers->obtener_comentario_mikrotik($this->input->post("username"),$this->input->post("customergroup"),$this->input->post("tegnologia_instalacion"));
        echo json_encode(array("comentario"=>$username));
    }

    public function addcustomer()
    {
		$bill_due_date = datefordatabase($this->input->post('nacimiento'));
        $abonado = $this->customers->codigouser()+1;
		$name = $this->input->post('name');
		$dosnombre = $this->input->post('dosnombre');
        $unoapellido = $this->input->post('unoapellido');
		$dosapellido = $this->input->post('dosapellido');
        $company = $this->input->post('company');
        $celular = $this->input->post('celular');
        $celular2 = $this->input->post('celular2');
        $email = $this->input->post('email');
        $nacimiento = $bill_due_date;
        $tipo_cliente = $this->input->post('tipo_cliente');
        $tipo_documento = $this->input->post('tipo_documento');
        $documento = $this->input->post('documento');
		$fcontrato = date("Y-m-d");
		$estrato = $this->input->post('estrato');
        $departamento = $this->input->post('departamento');
        $ciudad = $this->input->post('ciudad');
        $localidad = $this->input->post('localidad');
        $barrio = $this->input->post('barrio');
        $nomenclatura = $this->input->post('nomenclatura');
        $numero1 = $this->input->post('numero1');
        $adicionauno = $this->input->post('adicionauno');
        $numero2 = $this->input->post('numero2');
        $adicional2 = $this->input->post('adicional2');
		$numero3 = $this->input->post('numero3');
		$residencia = $this->input->post('residencia');
		$referencia = $this->input->post('referencia');
		$customergroup = $this->input->post('customergroup');
		$name_s = $this->input->post('name_s');
		$contra = $this->input->post('contra');
		$servicio = $this->input->post('servicio');
		$perfil = $this->input->post('perfil');
		$Iplocal = $this->input->post('Iplocal');
		$Ipremota = $this->input->post('Ipremota2');
		$comentario = $this->input->post('comentario');
        $tegnologia_instalacion = $this->input->post('tegnologia_instalacion');
        $this->customers->add($abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $fcontrato, $estrato, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario,$tegnologia_instalacion);

    }

    public function editcustomer()
    {
		$bill_due_date = datefordatabase($this->input->post('nacimiento'));
        $id = $this->input->post('id');
		$abonado = $this->input->post('abonado');
        $name = $this->input->post('name');
		$dosnombre = $this->input->post('dosnombre');
        $unoapellido = $this->input->post('unoapellido');
		$dosapellido = $this->input->post('dosapellido');
        $company = $this->input->post('company');
        $celular = $this->input->post('celular');
        $celular2 = $this->input->post('celular2');
        $email = $this->input->post('email');
        $nacimiento = $bill_due_date;
        $tipo_cliente = $this->input->post('tipo_cliente');
        $tipo_documento = $this->input->post('tipo_documento');
        $documento = $this->input->post('documento');
		$fcontrato = $this->input->post('fcontrato');
		$estrato = $this->input->post('estrato');
        $departamento = $this->input->post('departamento');
        $ciudad = $this->input->post('ciudad');
        $localidad = $this->input->post('localidad');
        $barrio = $this->input->post('barrio');
        $nomenclatura = $this->input->post('nomenclatura');
        $numero1 = $this->input->post('numero1');
        $adicionauno = $this->input->post('adicionauno');
        $numero2 = $this->input->post('numero2');
        $adicional2 = $this->input->post('adicional2');
		$numero3 = $this->input->post('numero3');
		$residencia = $this->input->post('residencia');
		$referencia = $this->input->post('referencia');
		$customergroup = $this->input->post('customergroup');
		$name_s = $this->input->post('name_s');
		$contra = $this->input->post('contra');
		$servicio = $this->input->post('servicio');
		$perfil = $this->input->post('perfil');
		$Iplocal = $this->input->post('Iplocal');
		$Ipremota = $this->input->post('Ipremota');
		$comentario = $this->input->post('comentario');
        $tegnologia_instalacion = $this->input->post('tegnologia_instalacion');
        if ($id) {
            $this->customers->edit($id, $abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $fcontrato, $estrato, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario,$tegnologia_instalacion);
        }
   
    }

    public function changepassword()
    {
        if ($id = $this->input->post()) {
            $id = $this->input->post('id');
            $password = $this->input->post('password');

            if ($id) {
                $this->customers->changepassword($id, $password);
            }
        } else {
            $pid = $this->input->get('id');
            $data['customer'] = $this->customers->details($pid);
            $data['customergroup'] = $this->customers->group_info($pid);
            $data['customergrouplist'] = $this->customers->group_list();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Edit Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/edit_password', $data);
            $this->load->view('fixed/footer');
        }
    }


    public function delete_i()
    {
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }  $id = $this->input->post('deleteid');

        if ($this->customers->delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' => 'Customer details deleted Successfully!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
        }
    }
	public function delete_obs()
    {  
        $id = $this->input->post('deleteid');

        if ($this->customers->deleteobs($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function displaypic()
    {

		$id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/customers/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->customers->editpicture($id, $img);
        }


    }


    public function translist()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->trans_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');

        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);
            $row[] = $prd->account;
            $row[] = $prd->payer;
			$row[] = $prd->estado;
            $row[] = $this->lang->line($prd->method);

            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a>';
            $row[] = '<a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>  '.$this->lang->line('Delete').'</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->trans_count_all($cid),
            "recordsFiltered" => $this->customers->trans_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function suporlist()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->supor_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');

        foreach ($list as $ticket) {
            $row = array();
            $no++;			
            $row[] = $no;			
			$row[] = $ticket->codigo;
            $row[] = $ticket->subject;
			$row[] = $ticket->detalle;
            $row[] = $ticket->created;          
			$row[] = $ticket->fecha_final;			
          if($ticket->id_factura !=null){
                $row[]='<a href="'.base_url("invoices/view?id=".$ticket->id_factura).'">'.$ticket->id_factura.'</a>';
            }else{
                 $row[]="Sin Factura";
            }

            if($ticket->asignado!=null){
                //$tecnico=$this->db->get_where('aauth_users',array('id'=>$ticket->asignado))->row();
                $row[]=$ticket->asignado;
            }else{
                $row[] = "--";    
            }
			
			$row[] = '<span class="st-' . $ticket->status . '">' . $ticket->status . '</span>';
            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->idt) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i></a> ';
			if ($this->aauth->get_user()->roleid >= 3) {
			$row[] ='<a href="' . base_url('quote/edit/?id=' . $ticket->idt) . '" class="btn btn-primary btn-xs"><i class="icon-pencil"></i> </a>';}
			if ($this->aauth->get_user()->roleid == 5) {
			$row[] =	'<a class="btn btn-danger btn-xs" onclick="eliminar_ticket('.$ticket->idt.')" > <i class="icon-trash-o"></i> </a>';}
            

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->supor_count_all($cid),
            "recordsFiltered" => $this->customers->sup_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function validar_equipos_usuario(){
        $dt=$this->db->get_where("equipos",array("asignado"=>$_POST['id_customer']))->row();
        if(isset($dt)){
            echo "false";
        }else{
            echo "true";
        }
    }
	public function equipolist()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->equipo_table($cid);
        $data = array();
        // $no = $_POST['start'];
        $no = $this->input->post('start');

        foreach ($list as $prd) {
			
			$nap = $this->db->get_where('naps', array('idn' => $prd->nat))->row();
			$vlan = $this->db->get_where('vlans', array('idv' => $nap->vlan))->row();
            $no++;
            $row = array();
            $row[] = $no;
           	$pid = $prd->id;
			$row[] = $prd->codigo;
            $row[] = $prd->mac;
            $row[] = $prd->serial;
			$row[] = $prd->estado;			
			$row[] = $prd->marca;
			$row[] = $prd->t_instalacion;
			if ($prd->vlan!=='0'){
			$row[] = $vlan->vlan;
			}else{$row[]= 'N/A';}
			$row[] = $nap->nap;
			if ($prd->puerto!=='0'){
			$row[] = $prd->puerto;
			}else{$row[]= 'N/A';}
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customers->equi_count_all($cid),
            "recordsFiltered" => $this->customers->equi_count_filtered($cid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
	public function dev_equipo()
    {
        $id = $this->input->post('iduser');
		$user = $this->aauth->get_user()->username;
        $nota = $this->input->post('nota');
		$estado = $this->input->post('estado');
		$codigo = $this->input->post('codigo');
		$this->db->set('macequipo', 'sin asignar');		
        $this->db->where('id', $id);
        $this->db->update('customers');
		//guardar historial
		$data1 = array(				
			'id_user' => $id,
			'tipos' => 'Devolucion Equipo',			
			'fecha' => date("Y-m-d"),
			'observacion' => 'Codigo: '.$codigo.' Motivo '.$nota,
			'colaborador' => $user);		
       $this->db->insert('historiales', $data1);
		//actualizar equipo
		$datae = array(
				't_instalacion' => null,
				'puerto' => null,
			  	'vlan' => null,
				'nat' => null,
				'asignado' => null,
				'estado' => $estado,
				'observacion' => $nota
			);
        $this->db->where('codigo', $codigo);
        if($this->db->update('equipos', $datae)){
			$datap = array(
                    'estado' => 'Disponible',
                    'asignado' => 0,          
                );
				$this->db->where('asignado', $id);
				$this->db->update('puertos', $datap);
		}

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
	public function act_titular()
    {
		$this->load->model('tools_model', 'tools');
        $id = $this->input->post('iduser');
        $nombres = $this->input->post('dtosantes2');
		$doc_anterior = $this->input->post('doc12');
		$tcliente = $this->input->post('tcliente');
		$tdocumento = $this->input->post('tdocumento');
		$bill_due_date = datefordatabase($this->input->post('fecha'));
		$fecha = $bill_due_date;
		$observacion = $this->input->post('observ');
		$nom1 = $this->input->post('nom1');
        $nom2 = $this->input->post('nom2');
		$ape1 = $this->input->post('ape1');
		$ape2 = $this->input->post('ape2');
		$email = $this->input->post('email');
		$cel = $this->input->post('cel');
		$cel2 = $this->input->post('cel2');
		$tipo_cliente = $this->input->post('tipo_cliente');
		$tipo_documento = $this->input->post('tipo_documento');
		$doc2 = $this->input->post('doc2');
		
		
		$data2 = array(			
			'name' => $nom1,
			'dosnombre' => $nom2,
			'unoapellido' => $ape1,
			'dosapellido' => $ape2,
			'celular' => $cel,
			'celular2' => $cel2,
			'email' => $email,
			'tipo_cliente' => $tipo_cliente,
			'tipo_documento' => $tipo_documento,
			'documento' => $doc2);
        $this->db->where('id', $id);
        $this->db->update('customers', $data2);
		//tarea de revision
		$name = 'Revisar cambio de titular #'.$doc2;
		$estado = 'Due';
		$priority = 'Low';
		$stdate = date("Y-m-d");
		$tdate = '';
		$asignacion = $this->db->get_where('asignaciones', array('detalle' => 'titular'))->row();
		$employee = $asignacion->colaborador;
		$assign = $this->aauth->get_user()->id;
		$content = 'Revisar cambio de titular #'.$doc2;
		$ordenn = $doc2;
		$this->tools->addtask($name, $estado, $priority, $stdate, $tdate, $employee, $assign, $content, $ordenn);
		//---
		$dt1=new DateTime($fecha);
        $fecha=$dt1->format("Y-m-d");
		$user = $this->aauth->get_user()->username;
		$data1 = array(				
			'id_user' => $id,
			'tipos' => 'Cambio Titular',
			'nombres' => $nombres,
			'tcliente' => $tcliente,
			'tdocumento' => $tdocumento,
			'documento2' => $doc_anterior,
			'fecha' => $fecha,
			'observacion' => $observacion,
			'colaborador' => $user);		
       $this->db->insert('historiales', $data1);
		
        $data_h=array();
            $data_h['modulo']="Customers";
            $data_h['accion']="Cambio de titular {update}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']=json_encode($data1);
            $data_h['id_fila']=$id;
            $data_h['tabla']="customers";
            $data_h['nombre_columna']="id";
            $this->db->insert("historial_crm",$data_h);
		

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
	public function obser()
    {
        $id = $this->input->post('iduser2');
		$user = $this->aauth->get_user()->username;
        $tipo = $this->input->post('tipo');
		$detalle = $this->input->post('detalle2');
		$fcha = $this->input->post('fecha2');
		$dt1=new DateTime($fcha);
        $fecha=$dt1->format("Y-m-d");
		$datos = array(				
			'id_user' => $id,
			'tipos' => $tipo,
			'nombres' => '',
			'tcliente' => '',
			'tdocumento' => '',
			'documento2' => '',
			'fecha' => $fecha,
			'observacion' => $detalle,
			'colaborador' => $user);		
       $this->db->insert('historiales', $datos);
		
		

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
    }
	public function compromiso()
    {
        $id = $this->input->post('iduser2');
		$user = $this->aauth->get_user()->username;
        $fechalimite = $this->input->post('fechalimite');
		$detalle = $this->input->post('razon');
		$factura = $this->input->post('factura');
		$fcha = $this->input->post('fecha2');
		$dt1=new DateTime($fcha);
        $fecha=$dt1->format("Y-m-d");
		$datos = array(				
			'id_user' => $id,
			'tipos' => 'Compromiso',
			'nombres' => '',
			'tcliente' => '',
			'tdocumento' => '',
			'documento2' => '',
			'fecha' => $fecha,
			'observacion' => $fechalimite.'/'.$detalle,
			'colaborador' => $user);		
       if($this->db->insert('historiales', $datos)){
		   //actualizar estado factura
		   	$this->db->set('ron', 'Compromiso');
        	$this->db->where('tid', $factura);
        	$this->db->update('invoices');
		   //actualizar estado usuario
            $customer=$this->db->get_where("customers",array('id' =>$id))->row();  
            $this->db->set("ultimo_estado",$customer->usu_estado);
                $this->db->set("fecha_cambio",date("Y-m-d H:i:s"));
		   	$this->db->set('usu_estado', 'Compromiso');
        	$this->db->where('id', $id);
        	$this->db->update('customers');
	   
		
		

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
	   }
    }
	public function printpdf()
    {

        $custid = $this->input->get('id');
		$tid = $custid;
		$data['details'] = $this->customers->details($custid);
		$data['due'] = $this->customers->due_details($custid);
        $data['servicios'] = $this->customers->servicios_detail($custid);
        if($data['servicios']['estado_combo']!=null){
            $data['servicios']['combo']=$data['servicios']['paquete'];
        }
        if($data['servicios']['estado_tv']!=null){
            $data['servicios']['television']="Television";
        }
        $data['id'] = $custid;
        $data['title'] = "Contrato $custid";
        
        $data['invoice']['multi'] = 0;

        ini_set('memory_limit', '128M');

        $html = $this->load->view('customers/view-print-'.RTL, $data, true);

        //PDF Rendering
        $this->load->library('pdf_contrato');

        $pdf = $this->pdf_contrato->load();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #959595; font-weight: bold; font-style: italic;"><tr><td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $custid . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Contrato_#' . $custid . '.pdf', 'D');
        } else {
            $pdf->Output('Contrato_#' . $custid . '.pdf', 'I');
        }


    }

    public function inv_list()
    {

		$cid = $this->input->post('cid');
        if(empty($cid)){
            $cid=$_GET['cid'];
        }
        $list = $this->customers->inv_datatables($cid);
        $data = array();
        $ultima_factura=$this->customers->servicios_detail($cid);
        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            if($invoices->ron=="Cortado"){
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
			$row[0]=utf8_encode($row[0]);
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->tipo_factura;
            $row[] = $invoices->invoicedate;
			$row[] = '<span class="st-' . $invoices->ron . '">' . $invoices->ron . '</span>';
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
                                $lista_rb=$this->db->get_where("recibos_de_pago",array("tid"=>$invoices->tid))->result_array();
                                foreach ($lista_rb as $key_l => $value_rb) {
                                    $fecha = new DateTime($value_rb['date']);
                                    $lisa_resivos_agregar_st.='<a class="dropdown-item" style="padding:3px 0px;"
                                           href="'.base_url().'invoices/printinvoice2?file_name='.$value_rb['file_name'].'">&nbsp;&nbsp;R'.$key_l.' - '.$fecha->format("d/m/Y").'</a>';
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
                                        <div class="dropdown-divider"></div>
                                        <a onclick="eliminiar_resivos_de_pago(\''.$invoices->tid.'\');" class="dropdown-item" style="padding:3px 0px;text-align:center;">Eliminar</a>
                                    </div>
                                </div>';

            }else{
                $resivos_var='';
            }
            $row[] = '<a  href="' . base_url("invoices/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> '.$this->lang->line('View').'</a> &nbsp; '.$resivos_var.'&nbsp;&nbsp;';
			if ($this->aauth->get_user()->roleid == 5) {
			$row[] = '<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';
			}
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
	
 	public function validar_n_documento(){
        $lista=$this->db->get_where("customers",array("documento"=>$_POST['documento']))->result_array();
        echo json_encode(array("conteo"=>count($lista)));
    }
    public function validar_direccion(){
        $lista=$this->db->select("*")->from('customers')->where(array(
            "departamento"=>intval($_POST['id_departamento']),
            "ciudad"=>intval($_POST['cmbCiudades']),
            "localidad"=>intval($_POST['cmbLocalidades']),
            "barrio"=>intval($_POST['cmbBarrios']),
            "nomenclatura"=>$_POST['nomenclatura'],
            "numero1"=>$_POST['numero1'],
            "adicionauno"=>$_POST['adicionauno'],
            "numero2"=>$_POST['numero2'],
            "adicional2"=>$_POST['adicional2'],
            "numero3"=>$_POST['numero3'],
            "residencia"=>$_POST['residencia'],
            "referencia"=>$_POST['referencia']
            ))->get()->result();
        if(!empty($lista)){
            echo "existe";
        }else{
            echo "no existe";
        }
    }

    public function lista_por_documento(){
        $lista=array();
        if(isset($_GET['doc'])){
            $lista=$this->db->get_where("customers",array("documento"=>$_GET['doc']))->result_array();    
        }else{
            $lista=$this->db->get_where("customers",array(
            "departamento"=>intval($_GET['id_departamento']),
            "ciudad"=>intval($_GET['cmbCiudades']),
            "localidad"=>intval($_GET['cmbLocalidades']),
            "barrio"=>intval($_GET['cmbBarrios']),
            "nomenclatura"=>$_GET['nomenclatura'],
            "numero1"=>$_GET['numero1'],
            "adicionauno"=>$_GET['adicionauno'],
            "numero2"=>$_GET['numero2'],
            "adicional2"=>$_GET['adicional2'],
            "numero3"=>$_GET['numero3'],
            "residencia"=>$_GET['residencia'],
            "referencia"=>$_GET['referencia']
            ))->result_array();    
        }
        
        $no = $this->input->post('start');
        $data=array();
        $x=0;
        $minimo=$this->input->post('start');
        if($minimo==null){
            $minimo=0;
        }
        $maximo=$minimo+10;
        $descontar=0;

        foreach ($lista as $key => $customers) {
            if($x>=$minimo && $x<$maximo){
                
                    $no++;                                
                    $row = array();
                    $row[] = $no;
                    $row[] = $customers['abonado'];
                    $row[] = '<a href="'.base_url().'customers/view?id=' . $customers['id'] . '">' . $customers['name'] .' '.$customers['unoapellido']. ' </a>';
                    $row[] = $customers['celular'];  
                    $row[] = $customers['documento'];
                    $row[] = $customers['nomenclatura'] . ' ' . $customers['numero1'] . $customers['adicionauno'].' Nº '.$customers['numero2'].$customers['adicional2'].' - '.$customers['numero3'];
                    $servicio = $this->customers->servicios_detail($customers['id']);
                    if($servicio['estado']=="Inactivo"){                        
                        if($customers['usu_estado']!="Inactivo" && $customers['usu_estado']!="0"  && $customers['usu_estado']!=""){
                            $servicio['estado']=$customers['usu_estado'];
                        }
                    }
                    $row[] = '<span class="tag tag-default tag-pill float-xs-center st-'.$servicio['estado']. '">' .$servicio['estado']. '</span>';
                    
                    $data[] = $row;
            }
            $x++;
        }
         $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => count($lista),
            "recordsFiltered" => count($lista),
            "data" => $data,
        );
         
        //output to json format
        echo json_encode($output);


    }
	public function estados()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['estado'] = $this->customers->estado_list($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Estados';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/estados',$data);
        $this->load->view('fixed/footer');
    }
    public function transactions()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/transactions', $data);
        $this->load->view('fixed/footer');
    }
	public function hiscuenta()
    {

		$custid = $this->input->get('id');
        $data['facturas'] = $this->customers->invoice_list($custid);
        $data['details'] = $this->customers->details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/his_cuenta', $data);
        $this->load->view('fixed/footer');
    }
	public function soporte()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);        
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/tickets', $data);
        $this->load->view('fixed/footer');
    }
	public function equipos()
    {
		$this->load->model('redes_model', 'redes');
		$custid = $this->input->get('id');
		$data['naps'] = $this->redes->nap_todas();
        $data['details'] = $this->customers->details($custid);        
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Transactions';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/equipos', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices()
    {

		$custid = $this->input->get('id');
		$this->load->model('invoices_model', 'invocies');
        $data['details'] = $this->customers->details($custid);
        $data['money'] = $this->customers->money_details($custid);
		$data['paquete'] = $this->invocies->paquetes('tv');
        $head['usernm'] = $this->aauth->get_user()->username;
		$data['invoice'] = $this->customers->invoice_details($custid, $this->limited);
        $head['title'] = 'View Customer Invoices';
		$data['due'] = $this->customers->due_details($custid);
		$this->load->model('accounts_model');
		$data['acclist'] = $this->accounts_model->accountslist();
    if(isset($_GET['fac_pag'])){
            $x=$this->db->query("select transactions.id as id,recibos_de_pago.file_name from transactions inner join transactions_ids_recibos_de_pago on transactions_ids_recibos_de_pago.id_transaccion=transactions.id inner join recibos_de_pago on recibos_de_pago.id=transactions_ids_recibos_de_pago.id_recibo_de_pago where transactions.payerid=".$data['invoice']['csd']." order by id desc")->result_array();
            
            $data['ultimo_resivo']=$x[0]['file_name'];
    }
        
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function balance()
    {

        if($this->input->post()){
            $id = $this->input->post('id');
            $amount = $this->input->post('amount');


                 if ( $this->customers->recharge($id,$amount)) {
                     echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Balance Added')));
                 } else {
                     echo json_encode(array('status' => 'Error', 'message' => 'Error!'));
                 }

        }
        else {
            $custid = $this->input->get('id');
            $data['details'] = $this->customers->details($custid);
            $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
            $data['money'] = $this->customers->money_details($custid);
            $head['usernm'] = $this->aauth->get_user()->username;
            $data['activity'] = $this->customers->activity($custid);
            $head['title'] = 'View Customer';
            $this->load->view('fixed/header', $head);
            $this->load->view('customers/recharge', $data);
            $this->load->view('fixed/footer');
        }
    }
    public function prueba_api(){
        /* API URL */
        $url = 'https://siigonube.siigo.com:50050/connect/token';
             
        /* Init cURL resource */
        $ch = curl_init($url);            
        /* Array Parameter Data */
        //$data =  array('grant_type'=>'password', 'username'=>'VESGATELEVISIONSAS\\VESGAT17681@apionmicrosoft.com','password'=>')QP>x3(9dN','scope'=>'WebApi offline_access');
         $data =  array('grant_type'=>'password', 'username'=>'VesgaTelecomunicacionesSAS\\VesgaT49791@apionmicrosoft.com','password'=>'h1U~@r339B','scope'=>'WebApi offline_access');            
        /* set the content type json */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic U2lpZ29XZWI6QUJBMDhCNkEtQjU2Qy00MEE1LTkwQ0YtN0MxRTU0ODkxQjYx',
                    'Accept: application/json'
                ));
         /* pass encoded JSON string to the POST fields */
        //curl_setopt($ch, CURLOPT_POST, 4); al parecer esta linea no es necesaria        
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));        
        /* set return type json */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /* execute request */
        $result = curl_exec($ch);
         $err = curl_error($ch);  
        /* close cURL resource */
        curl_close($ch);
        $result =json_decode($result);
        var_dump($result->access_token);
        $_SESSION['token_var']=$result->access_token;
        $_SESSION['token_2']=$result->refresh_token;
        $_SESSION['fecha']=date("Y-m-d H:i:s");
        if ($err)
         {
              var_dump($err);
         }
    }
    public function guardar_factura(){
        //var_dump($_SESSION['token_var']);
        $url = "http://siigoapi.azure-api.net/siigo/api/v1/Invoice/Save?namespace=1";
        $data= $this->customers->getClientData();
        $data=json_decode($data);
        /* Init cURL resource */
        $ch = curl_init($url); 
         /* set the content type json */
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer {'.$_SESSION["token_var"].'}',
                    'Content-Type: application/json',
                    'Ocp-Apim-Subscription-Key: 38c6a1bdfbb948d182f03fe232ab310b'
                ));

        /* pass encoded JSON string to the POST fields */
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));        
        /* set return type json */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        /* execute request */
        $result = curl_exec($ch);
         $err = curl_error($ch);  
        /* close cURL resource */
        curl_close($ch);
        $result =json_decode($result);
        var_dump($result);
        
        
        if ($err)
         {
              var_dump($err);
         }
        
        
    }

    public function integracion(){
        $this->load->library('SiigoAPI');
        $api = new SiigoAPI();
        $x=json_decode($api->getAuth());
        var_dump($x->access_token);
        //$data= $this->customers->getClientData();
        //$data=json_decode($data);
        //$data->Header->Number=510;
        //$data=json_encode($data);
        //var_dump($data->Header->Number);
        //$api->accionar($api,$data);        
    }
    public function integracion_cellvoz(){
        $this->load->library('CellVozApi');
        $api = new CellVozApi();
        $retorno=$api->getToken();                
        var_dump($retorno['token']);
        //var_dump($_SESSION['variables_cellvoz']->api_key);
        $api->alternativa_por_curl_envio_sms_invividual($retorno['token'],"3142349563","mensaje duber");
               
    }
    public function conexion_prueba_po(){
        ///public_html/templates/shaper_helix3/index.php
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
                           "test": true,
                           "language": "es",
                           "command": "GET_PAYMENT_METHODS",
                           "merchant": {
                              "apiLogin": "8wOQ5r2pCRoSTjG",
                              "apiKey": "K4N2CDMArYqCPshu5rvbycCnOG"
                           }
                        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
            //'Content-Length: length' //esta linea es la que causa el error por esta es la longitud de los bites de la informacion enviada por post, revisar codigo java en android ws
            
          ),
        ));
/*
        POST /payments-api/4.0/service.cgi HTTP/1.1
        Host: sandbox.api.payulatam.com
        Content-Type: application/json; charset=utf-8
        Accept: application/json
        Content-Length: length


        //

        API KEY
        K4N2CDMArYqCPshu5rvbycCnOG
        API LOGIN
        8wOQ5r2pCRoSTjG
        Llave pública
        PK6j0O320V6rQb8Y0t76238y1t
*/
        $response = curl_exec($curl);

        curl_close($curl);
        var_dump($response);
    }
    public function actualizar_cortados_antiguos(){
        $lista=$this->db->query("SELECT * FROM `invoices` where ron='Cortado' and (combo is null or combo='' or combo='no') and (television is null or television='' or television='no') ORDER BY `estado_tv` DESC")->result();
        foreach ($lista as $key => $value) {
            $lista_facturas=$this->db->query("SELECT * FROM `invoices` WHERE csd=".$value->csd." order by tid desc")->result();
            $television="";
            $combo="";
            foreach ($lista_facturas as $key2 => $value2) {
                if($value2->combo!="null" && $value2->combo!=null && $value2->combo!="" && $value2->combo!="no"){
                    if($combo==""){
                        $combo=$value2->combo;    
                    }
                    
                }

                if($value2->television!="null"  && $value2->television!=null  && $value2->television!="" && $value2->television!="no"){
                    if($combo==""){
                        $television=$value2->television;    
                    }
                    
                }
            }
            $data=array();
            if($combo!="null" && $combo!=null || $combo!=""  && $combo!="no" && ($value->combo=="null" || $value->combo==null || $value->combo=="" || $value->combo=="no")){
                    
                    $data['combo']=$combo;
                    $data['estado_combo']="Cortado";

            }

            if($television!="null"  && $television!=null  && $television!=""  && $television!="no" && ($value->television=="null" || $value->television==null || $value->television=="" || $value->television=="no")){
                   $data['television']=$television;
                    $data['estado_tv']="Cortado";
                    
            }
            var_dump($value->tid);
            var_dump($data);
            echo"otro<br>";
            $this->db->update("invoices",$data,array("tid"=>$value->tid));

        }
    }

}