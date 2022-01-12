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

class Customers_model extends CI_Model
{

    var $table = 'customers';
    var $column_order = array(null, 'name', 'address', 'email', 'phone', null);
    var $column_search = array('id','abonado','name', 'celular', 'documento', 'unoapellido', 'email','usu_estado');
    var $trans_column_order = array('date', 'debit', 'credit', 'account', null);
    var $trans_column_search = array('id', 'date');
	var $sup_column_order = array(null, 'codigo', 'subject', 'detalle', 'created','fecha_final','id_factura','status', null);
    var $sup_column_search = array('idt', 'codigo', 'detalle', 'created', 'abonado', 'id_factura', 'ciudad','asignado','status',);
	var $equi_column_search = array('id', 'codigo');
	var $equi_column_order = array('null', 'codigo', 'mac', 'serial', 'estado', 'marca', null);
    var $inv_column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $inv_column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('id' => 'desc');
    var $inv_order = array('invoices.tid' => 'desc');
	var $sup_order = array('tickets.codigo' => 'desc');
	var $equi_order = array('equipos.id' => 'desc');
    //var $ip_coneccion_mikrotik='190.14.233.186:8728';//192.168.201.1:8728 ip jefe |||| 190.14.233.186:8728 ip duber

    private function _get_datatables_query($id = '')
    {

        if (isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null) {
            $this->db->select("*,cus1.id as idx");
            
        }
        $this->db->from($this->table." as cus1");

        if (isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null) {
            $this->db->join("invoices as inv1","cus1.id=inv1.csd and inv1.tid=(select max(tid) from invoices as inv2 where inv2.csd=cus1.id and ((inv2.combo !='no' and inv2.combo !='' and inv2.combo !='-') or  (inv2.television !='no' and inv2.television !='' and inv2.television !='-')))");
            if($_GET['sel_servicios']=="Internet" || $_GET['sel_servicios']=="Combo"){
                $this->db->where('combo!=',"no" );
                $this->db->where('combo!=',"" );
                $this->db->where('combo!=',"-" );   
            }else if($_GET['sel_servicios']=="TV" || $_GET['sel_servicios']=="Combo"){
               $this->db->where('television=',"television" );                
            }
        }
        if ($id != '') {
            $this->db->where('cus1.gid', $id);
        }
        if (isset($_GET['estado']) && $_GET['estado'] != '' && $_GET['estado'] != null) {
            $this->db->where('usu_estado=', $_GET['estado']);
        }
        if (isset($_GET['direccion']) &&$_GET['direccion'] =="Personalizada"){ 
            if ($_GET['localidad'] != '' && $_GET['localidad'] != '-') {
                $this->db->where('localidad=', $_GET['localidad']);
            }

            if ($_GET['barrio'] != '' && $_GET['barrio'] != '-') {
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
        
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if (isset($_GET['sel_servicios']) && $_GET['sel_servicios'] != '' && $_GET['sel_servicios'] != null) {
                    if($item=="id"){
                        $item="cus1.id";
                    }
                }

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by("cus1.".$this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by("cus1.".key($order), $order[key($order)]);
        }
    }

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    public function validar_firma($id){
        $nombre="assets/firmas_digitales/".$id.".png";
        return file_exists($nombre);
    }
	public function invoice_details($custid)
    {

        $this->db->select('invoices.*,customers.*');
        $this->db->from('invoices');
        $this->db->where('invoices.csd', $custid);        
        $this->db->join('customers', 'invoices.csd = customers.id', 'left');
        
        $query = $this->db->get();
        return $query->row_array();

    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('gid', $id);
        }
        return $query->num_rows($id = '');
    }
	public function codigouser()
    {
        $this->db->select('abonado');
        $this->db->from($this->table);
        $this->db->order_by('abonado', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->abonado;
        } else {
            return 1000;
        }
    }

    public function details($custid)
    {

        $this->db->select('*');
        $this->db->from($this->table);
		//$this->db->join('departamentos', 'customers.departamento = departamentos.idDepartamento', 'left');
		//$this->db->join('ciudad', 'customers.ciudad = ciudad.idCiudad', 'left');
		//$this->db->join('localidad', 'customers.localidad = localidad.idLocalidad', 'left');
		//$this->db->join('barrio', 'customers.barrio = barrio.idBarrio', 'left');
        $this->db->where('id', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function equipo_details($custid)
    {

        $this->db->select('*');
        $this->db->from('equipos');
        $this->db->where('asignado', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
	 public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('meta_data', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('meta_data.*');
        $this->db->from('meta_data');
        $this->db->where('meta_data.type', 6);
        $this->db->where('meta_data.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
	public function meta_delete($id,$type,$name)
    {
        $x=@unlink(FCPATH . 'userfiles/attach/' . $name);
        $y=@unlink(FCPATH . 'userfiles/attach/thumbnail/' . $name);
        //$x=true;
        
        if ($x || $y) {
            if($type==null){
                $type=6;
            }
            return $this->db->delete('meta_data', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }

    public function money_details($custid)
    {

        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('transactions');
        $this->db->where('payerid', $custid);
		$this->db->where('estado' , null);
		$this->db->where('ext', '0');
        if(isset($_GET['ingreso_select']) && $_GET['ingreso_select']!="" && $_GET['ingreso_select']!=null){
                $dateTime= new DateTime($_GET['sdate']);
                $sdate=$dateTime->format("Y-m-d");
                $dateTime= new DateTime($_GET['edate']);
                $edate=$dateTime->format("Y-m-d");

                $this->db->where("date>=",$sdate);
                $this->db->where("date<=",$edate);
        }
        $query = $this->db->get();
        return $query->row_array();
    }
      public function actualizar_debit_y_credit($id_customer){
        set_time_limit(20000);
        $array=$this->money_details($id_customer);
        $data=array();
        $data['debit']=$array['debit'];
        $data['credit']=$array['credit'];
        $this->db->update("customers",$data,array("id"=>$id_customer));

    }

        public function due_details($custid)
    {

       $this->db->select('*, SUM(total) AS total,SUM(pamnt) AS pamnt,MAX(television) AS television,MAX(combo) AS combo,MAX(puntos) AS puntos,MAX(ron) AS estado');
        $this->db->from('invoices');
        $this->db->where('csd', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function due_details2($custid)
    {

       $this->db->select('SUM(total) AS total,SUM(pamnt) AS pamnt');
        $this->db->from('invoices');
        $this->db->where('csd', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
         public function servicios_detail($custid)
    {
        $lista_invoices = $this->db->from("invoices")->where("csd",$custid)->order_by('invoicedate,tid',"DESC")->get()->result();
        $customer_moroso=false;
        $valor_ultima_factura=0;
        $_var_tiene_internet=false;
        $_var_tiene_tv=false;

        $servicios= array('television' =>"no",'combo' =>"no","puntos"=>"no","estado"=>"Inactivo","estado_combo"=>null,"estado_tv"=>null,"paquete"=>"");
        foreach ($lista_invoices as $key => $invoice) {
            if($invoice->combo!="no" && $invoice->combo!="" && $invoice->combo!="-"){
                if($invoice->estado_combo=="null" || $invoice->estado_combo==null){
                        $fact_valida=true;
                        $_var_tiene_internet=true;
                        $servicios['combo']=$invoice->combo;
                }else{
                      $servicios['estado_combo']=$invoice->estado_combo;  
                      $servicios['paquete']=$invoice->combo;
                }
                    
            }
            if($invoice->television!="no" && $invoice->television!="" && $invoice->television!="-" ){
                if($invoice->estado_tv=="null" || $invoice->estado_tv==null){
                        $fact_valida=true;
                        $_var_tiene_tv=true;
                        $servicios['television']=$invoice->television;
                        
                }else{
                        $servicios['estado_tv']=$invoice->estado_tv;  
                }
                $servicios['puntos']=$invoice->puntos;
                    
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
                    $servicios['tid']=$invoice->tid;
                    $servicios['subtotal']=$invoice->subtotal;
                    $servicios['total']=$invoice->total;
                    $servicios['items']=$invoice->items;
                    //var_dump($invoice->ron);
                    $servicios['estado']=$invoice->ron;
                    if($invoice->ron=="Suspendido"){
                        $servicios['television']="no";
                        $servicios['combo']="no";
                        $servicios['estado']="Suspendido";
                    }else if($servicios['television']!="no" ||$servicios['combo']!="no"){

                        if($servicios['television']!="no" && $invoice->television=="no"){
                            $servicios['television']="no";
                            $servicios['estado']="Television suspendida";
                        }
                        if($servicios['combo']!="no" && $invoice->combo=="no"){
                            $servicios['combo']="no";
                            $servicios['estado']="Internet suspendido";
                        }

                    }
                    break;
                }
            

        }
        return $servicios;
        
    }

    public function get_ip_coneccion_microtik_por_sede($datos){
        //$this->load->library("Aauth");
        //$id_sede=$this->aauth->get_user()->sede_accede;
        $id_sede=$datos['id_sede'];
        if($id_sede==2){//yopal
            return $_SESSION['variables_MikroTik']->ip_Yopal;//190.14.233.186:8728
        }else if($id_sede==3){//Villanueva
            if($datos['tegnologia']=="GPON"){
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_GPON;
            }else if($datos['tegnologia']=="EPON"){
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_EPON;
            }else if($datos['tegnologia']=="EOC"){
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_EOC;
            }else{
                return $_SESSION['variables_MikroTik']->Ip_Villanueva_GPON;//default
                //return $_SESSION['variables_MikroTik']->ip_Villanueva;//190.14.238.114:8728
            }
            
        }else if($id_sede==4){//Monterrey
            return $_SESSION['variables_MikroTik']->ip_Monterrey;//190.14.248.42:8728
        }else{//default
            return $_SESSION['variables_MikroTik']->ip_Yopal;//190.14.233.186:8728
        }
    }

    public function add($abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $fcontrato, $estrato, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario,$tegnologia_instalacion)
    {
        if($tegnologia_instalacion==""){
            $tegnologia_instalacion=null;
        }
        $data = array(
			'abonado' => $abonado,
            'name' => $name,
			'dosnombre' => $dosnombre,
            'unoapellido' => $unoapellido,
			'dosapellido' => $dosapellido,
            'company' => $company,
            'celular' => $celular,
            'celular2' => $celular2,
            'email' => $email,
            'nacimiento' => $nacimiento,
            'tipo_cliente' => $tipo_cliente,
            'tipo_documento' => $tipo_documento,
            'documento' => $documento,
			'f_contrato' => $fcontrato,
			'estrato' => $estrato,
            'departamento' => $departamento,
            'ciudad' => $ciudad,
            'localidad' => $localidad,
            'barrio' => $barrio,
            'nomenclatura' => $nomenclatura,
            'numero1' => $numero1,
            'adicionauno' => $adicionauno,
            'numero2' => $numero2,
            'adicional2' => $adicional2,
			'numero3' => $numero3,
			'residencia' => $residencia,
			'referencia' => $referencia,
			'gid' => $customergroup,
			'name_s' => $name_s,
			'contra' => $contra,
			'servicio' => $servicio,
			'perfil' => $perfil,
			'Iplocal' => $Iplocal,
			'Ipremota' => $Ipremota,
			'comentario' => $comentario,
			'tegnologia_instalacion'=>$tegnologia_instalacion
			
        );

        if($data['name_s']=="" || $data['name_s']==null){
            //si no agrega un username no agregue ip
            $data['Ipremota']="";            
        }

        if ($this->db->insert('customers', $data)) {
            $cid = $this->db->insert_id();
            $temp_password = rand(200000, 999999);
            $pass = password_hash($temp_password, PASSWORD_DEFAULT);
            $data = array(
                'user_id' => 1,
                'status' => 'active',
                'is_deleted' => 0,
                'name' => $name,
                'password' => $pass,
                'email' => $email,
                'user_type' => 'Member',
                'cid' => $cid
            );

            $this->db->insert('users', $data);
            if($name_s!=""){
                include (APPPATH."libraries\RouterosAPI.php");
                set_time_limit(3000);
                 $API = new RouterosAPI();
                $API->debug = false;
                //192.168.201.1:8728 ip jefe
                $datos_consulta_ip=array("id_sede"=>$customergroup,"tegnologia"=>$tegnologia_instalacion);
                if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
                        $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$barrio))->row();
                        if(isset($obj_barrio)){
                            
                            $barrio = $obj_barrio->barrio;    
                        }

                 $API->comm("/ppp/secret/add", array(
                      "name"     => str_replace(' ', '', $name_s),
                      "password" => $contra,
                      "remote-address" => $Ipremota,
                      "local-address" => $Iplocal,
                      "profile" => $perfil,
                      "comment"  => $barrio." ".$abonado,
                      "service"  => $servicio,
                   ));
        

                $API->disconnect();

                }else{
                    //echo "no conecto";
                }
        }
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('ADDED') . ' Temporary Password is ' . $temp_password . ' &nbsp;<a href="' . base_url('customers/view?id=' . $cid) . '" class="btn btn-info btn-sm"><span class="icon-eye"></span>' . $this->lang->line('View') . '</a>', 'cid' => $cid, 'pass' => $temp_password));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
        

    }


    public function edit($id, $abonado, $name, $dosnombre, $unoapellido, $dosapellido, $company, $celular, $celular2, $email, $nacimiento, $tipo_cliente, $tipo_documento, $documento, $fcontrato, $estrato, $departamento, $ciudad, $localidad, $barrio, $nomenclatura, $numero1, $adicionauno, $numero2, $adicional2, $numero3, $residencia, $referencia, $customergroup, $name_s, $contra, $servicio, $perfil, $Iplocal, $Ipremota, $comentario,$tegnologia_instalacion)
    {
        if($tegnologia_instalacion==""){
            $tegnologia_instalacion=null;
        }
        $data = array(
			'abonado' => $abonado,
            'name' => $name,
			'dosnombre' => $dosnombre,
            'unoapellido' => $unoapellido,
			'dosapellido' => $dosapellido,
            'company' => $company,
            'celular' => $celular,
            'celular2' => $celular2,
            'email' => $email,
            'nacimiento' => $nacimiento,
            'tipo_cliente' => $tipo_cliente,
            'tipo_documento' => $tipo_documento,
            'documento' => $documento,
			'f_contrato' => $fcontrato,
			'estrato'	=> $estrato,
            'departamento' => $departamento,
            'ciudad' => $ciudad,
            'localidad' => $localidad,
            'barrio' => $barrio,
            'nomenclatura' => $nomenclatura,
            'numero1' => $numero1,
            'adicionauno' => $adicionauno,
            'numero2' => $numero2,
            'adicional2' => $adicional2,
			'numero3' => $numero3,
			'residencia' => $residencia,
			'referencia' => $referencia,
			'gid' => $customergroup,
			'name_s' => $name_s,
			'contra' => $contra,
			'servicio' => $servicio,
			'perfil' => $perfil,
			'Iplocal' => $Iplocal,
			'Ipremota' => $Ipremota,
			'comentario' => $comentario,
            'tegnologia_instalacion'=>$tegnologia_instalacion
        );

        if($data['name_s']=="" || $data['name_s']==null){
            //si no agrega un username no agregue ip
            $data['Ipremota']="";            
        }

        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('customers')) {
            $data = array(
                'name' => $name,
                'email' => $email
            );
            $this->db->set($data);
            $this->db->where('cid', $id);
            $this->db->update('users');
            if($name_s!=""){
                include (APPPATH."libraries\RouterosAPI.php");
                set_time_limit(3000);
                $API = new RouterosAPI();
                $API->debug = false;
                $datos_consulta_ip=array("id_sede"=>$customergroup,"tegnologia"=>$tegnologia_instalacion);
                if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {

                    $arrID=$API->comm("/ppp/secret/getall", 
                          array(
                          ".proplist"=> ".id",
                          "?name" => $name_s,
                          ));
                    if($arrID[0][".id"]!=null){
                        $API->comm("/ppp/secret/set",
                          array(
                               ".id" => $arrID[0][".id"],
                               "name"     => str_replace(' ', '', $name_s),
                               "password" => $contra,
                               "remote-address" => $Ipremota,
                               "local-address" => $Iplocal,
                               "profile" => $perfil,
                               "comment"  => $comentario,
                               "service"  => $servicio,
                               //"disabled"  => "no",
                               )
                          );  
                    }else{
                        $obj_barrio=$this->db->get_where("barrio",array("idBarrio"=>$barrio))->row();
                        if(isset($obj_barrio)){
                            
                            $barrio = $obj_barrio->barrio;    
                        }
                        $API->comm("/ppp/secret/add", array(
                          "name"     => str_replace(' ', '', $name_s),
                          "password" => $contra,
                          "remote-address" => $Ipremota,
                          "local-address" => $Iplocal,
                          "profile" => $perfil,
                          "comment"  => $barrio." ".$abonado." ".$comentario,
                          "service"  => $servicio,
                          "disabled"  => "no",
                        ));
                        
                    }
                    $API->disconnect();

                }else{
                   
                }
            }

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
    public function edit_profile_mikrotik($id_sede,$name_s,$profile,$tegnologia_instalacion){
        include (APPPATH."libraries\RouterosAPI.php");
                set_time_limit(3000);
                $API = new RouterosAPI();
                $API->debug = false;
                $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
                $arrID=$API->comm("/ppp/secret/getall", 
                          array(
                          ".proplist"=> ".id",
                          "?name" => $name_s,
                          ));
                    if($arrID[0][".id"]!=null){
                        $API->comm("/ppp/secret/set",
                          array(
                               ".id" => $arrID[0][".id"],
                               //"name"     => str_replace(' ', '', $name_s),
                               //"password" => $contra,
                               //"remote-address" => $Ipremota,
                               //"local-address" => $Iplocal,
                               "profile" => $profile,
                               //"comment"  => $barrio." ".$abonado,
                               //"service"  => $servicio,
                               "disabled"  => "no",
                               )
                          );  
                    }
            }

    }
    public function obtener_comentario_mikrotik($username,$customergroup,$tegnologia_instalacion){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
        $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$customergroup,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $username,
                  ));
         $API->disconnect();

         return $arrID[0]['comment'];

        }else{
            
        }
        return "No se pudo conectar a la mikrotik";
    }
    public function changepassword($id, $password)
    {
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $data = array(
            'password' => $pass

        );


        $this->db->set($data);
        $this->db->where('cid', $id);

        if ($this->db->update('users')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from($this->table);
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('customers') AND $result['picture']!='example.png') {

            unlink(FCPATH . 'userfiles/customers/' . $result['picture']);
            unlink(FCPATH . 'userfiles/customers/thumbnail/' . $result['picture']);
        }


    }

    public function group_list()
    {
        $query = $this->db->query("SELECT c.*,p.pc FROM customers_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM customers GROUP BY gid) AS p ON p.gid=c.id");
        return $query->result_array();
    }
	
	public function departamentos_list()
    {
        $query = $this->db->query("SELECT idDepartamento,departamento FROM departamentos ");
        return $query->result_array();
		
    }
	public function group_departamentos($id)
    {

        $this->db->from('departamentos');
        $this->db->where('idDepartamento', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function ciudades_list($id)
    { 
		$this->db->select('*');
        $this->db->from('ciudad');
        $this->db->where('idDepartamento', $id);
        $query = $this->db->get();
        return $query->result(); 
    }
	public function group_ciudad($id)
    {

        $this->db->from('ciudad');
        $this->db->where('idCiudad', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function localidades_list($id)
    { 
		$this->db->select('*');
        $this->db->from('localidad');
        $this->db->where('idCiudad', $id);
        $query = $this->db->get();
        return $query->result(); 
    }
	public function group_localidad($id)
    {

        $this->db->from('localidad');
        $this->db->where('idLocalidad', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	
	public function barrios_list($id)
    { 
		$this->db->select('*');
        $this->db->from('barrio');
        $this->db->where('idLocalidad', $id);
        $query = $this->db->get();
        return $query->result(); 
    }
	public function group_barrio($id)
    {

        $this->db->from('barrio');
        $this->db->where('idBarrio', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete($id)
    {
        $this->db->delete('users', array('cid' => $id));
        return $this->db->delete('customers', array('id' => $id));
    }
	public function deleteobs($id)
    {
        $this->db->delete('historiales', array('idn' => $id));
        return true;    
    }


    //transtables

    function trans_table($id)
    {
        $this->_get_trans_table_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	function supor_table($id)
    {
        $this->_sup_datatables_query($id);
        $this->db->order_by("codigo","DESC");
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	


    private function _get_trans_table_query($id)
    {

        $this->db->from('transactions');


        $this->db->where('payerid', $id);
        $this->db->where('ext', '0');

        $i = 0;

        foreach ($this->trans_column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->trans_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->trans_column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function trans_count_filtered($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }
        return $query->num_rows($id = '');
    }
	function sup_count_filtered($id = '')
    {
        $this->_sup_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('cid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function trans_count_all($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }


    }
	public function supor_count_all($id = '')
    {
        $this->_sup_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('cid', $id);
        }


    }

    private function _inv_datatables_query($id)
    {

        $this->db->from('invoices');
        $this->db->where('invoices.csd', $id);
        if(isset($_GET['filtrar'])){
            $this->db->where('invoices.status', 'due');    
        }
        
        $this->db->join('customers', 'invoices.csd=customers.id', 'left');

        $i = 0;

        foreach ($this->inv_column_search as $item) // loop column
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

                if (count($this->inv_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->inv_order)) {
            $order = $this->inv_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	private function _sup_datatables_query($id)
    {

        $this->db->from('tickets');
        $this->db->where('tickets.cid', $id);
        if(isset($_POST['tipo']) && $_POST['tipo']=="pendientes"){
            $this->db->where("status",'Pendiente');
        }
        $this->db->join('customers', 'tickets.cid=customers.id', 'left');

        $i = 0;

        foreach ($this->sup_column_search as $item) // loop column
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

                if (count($this->sup_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->sup_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->sup_order)) {
            $order = $this->sup_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	//busqueda equipo
	private function _equi_datatables_query($id)
    {

        $this->db->from('equipos');
        $this->db->where('equipos.asignado', $id);
        $this->db->join('customers', 'equipos.asignado=customers.id', 'left');

        $i = 0;

        foreach ($this->equi_column_search as $item) // loop column
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

                if (count($this->equi_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->equi_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->equi_order)) {
            $order = $this->equi_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	function equipo_table($id)
    {
        $this->_equi_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
	public function equi_count_all($id = '')
    {
        $this->_equi_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('abonado', $id);
        }


    }
	function equi_count_filtered($id = '')
    {
        $this->_equi_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('abonado', $id);
        }
        return $query->num_rows($id = '');
    }

    function inv_datatables($id)
    {
        $this->_inv_datatables_query($id);
        
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function inv_count_filtered($id)
    {
        $this->_inv_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function inv_count_all($id)
    {
        $this->db->from('invoices');
        $this->db->where('csd', $id);
        return $this->db->count_all_results();
    }

    public function group_info($id)
    {

        $this->db->from('customers_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function activity($id)
    {
        $this->db->select('*');
        $this->db->from('historiales');
        //$this->db->where('type', 21);
        $this->db->where('id_user', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function recharge($id, $amount)
    {

        $this->db->set('balance', "balance+$amount", FALSE);
        $this->db->where('id', $id);

        $this->db->update('customers');

        $data = array(
            'type' => 21,
            'rid' => $id,
            'col1' => $amount,
            'col2' => date('Y-m-d H:i:s').' Account Recharge by '.$this->aauth->get_user()->username
        );


        if ($this->db->insert('meta_data', $data)) {
            return true;
        } else {
            return false;
        }

    }

    public function get_estado_mikrotik($user_name,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
         $API->disconnect();

         return $arrID[0]['disabled'];

        }else{
            
        }
    }
     public function validar_user_name($user_name,$id_sede,$tegnologia_instalacion){
        //include (APPPATH."libraries\RouterosAPI.php");
            //$user_name="10.20.2.189";
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
         $API->disconnect();

        return $arrID[0]['.id'];

        }else{
            
        }
    }
     public function validar_ip($ip_remote,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries\RouterosAPI.php");
        //$user_name="10.20.2.189";
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?remote-address" => $ip_remote,
                  ));
         $API->disconnect();

        //return $arrID[0]['.id'];


 // ips yopal
        $ciclo=true;
        $ip=ip2long($ip_remote);//+intval($customers_yopal[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            //$comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2"))->row();
            //$comprovar=$this->db->query("select * from customers where gid='2' and Ipremota='".long2ip($nmask)."' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
            if(count($comprovar)==0){
                //no existe
                $ips_remotas['yopal']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips yopal
        }else{
            
        }
    }
     public function editar_estado_usuario($user_name,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            
            if($arrID[0]['disabled']=='false'){
               $secret_id=$arrID[0][".id"];
               $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => $user_name,
                  ));
                $API->comm("/ppp/active/remove",
                    array(
                        ".id" => $arrID[0][".id"],
                        )
                    );

                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $secret_id,
                       "disabled"  => "yes",
                       )
                  );  
                //var_dump($secret_id);
                //var_dump($arrID[0][".id"]);
                
            }else{
                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $arrID[0][".id"],
                       "disabled"  => "no",
                       )
                  );    
            }
            

         $API->disconnect();
         

        }else{
            
        }
    }

    public function activar_estado_usuario($user_name,$id_sede,$tegnologia_instalacion){
        include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            //activate
            $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $arrID[0][".id"],
                       "disabled"  => "no",
                       )
                  );              
         $API->disconnect();
         

        }else{
            
        }
    }

    public function desactivar_estado_usuario($user_name,$id_sede,$tegnologia_instalacion){
          include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         $API = new RouterosAPI();
        $API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            
            //desactivate
               $secret_id=$arrID[0][".id"];
               $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => $user_name,
                  ));
                $API->comm("/ppp/active/remove",
                    array(
                        ".id" => $arrID[0][".id"],
                        )
                    );

                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $secret_id,
                       "disabled"  => "yes",
                       )
                  );  
                //var_dump($secret_id);
                //var_dump($arrID[0][".id"]);                            

         $API->disconnect();
         

        }else{
            
        }
    }

    public function desactivar_estado_usuario_multiple($user_name,$id_sede,$API,$tegnologia_instalacion){
          //include (APPPATH."libraries\RouterosAPI.php");
        set_time_limit(3000);
         //$API = new RouterosAPI();
        //$API->debug = false;
        $datos_consulta_ip=array("id_sede"=>$id_sede,"tegnologia"=>$tegnologia_instalacion);
        if ($API->connect($this->get_ip_coneccion_microtik_por_sede($datos_consulta_ip), $_SESSION['variables_MikroTik']->username, $_SESSION['variables_MikroTik']->password)) {
            //$user_name="user_prueba_duber_disabled";
            $arrID=$API->comm("/ppp/secret/getall", 
                  array(
                  "?name" => $user_name,
                  ));
          
            
            //desactivate
               $secret_id=$arrID[0][".id"];
               $arrID=$API->comm("/ppp/active/getall", 
                  array(
                    ".proplist"=> ".id",
                  "?name" => $user_name,
                  ));
                $API->comm("/ppp/active/remove",
                    array(
                        ".id" => $arrID[0][".id"],
                        )
                    );

                $API->comm("/ppp/secret/set",
                  array(
                       ".id" => $secret_id,
                       "disabled"  => "yes",
                       )
                  );  
                //var_dump($secret_id);
                //var_dump($arrID[0][".id"]);                            

         $API->disconnect();
         

        }else{
            
        }
    }

    
    public function devolver_ips_proximas(){
        $ips_remotas = array('yopal' =>'10.0.0.2', 'yopal_gpon' =>'10.100.0.2',"monterrey"=>'10.1.100.2','villanueva'=>"80.0.0.2",'villanueva_gpon'=>"10.20.0.2" );    
        /*$customers_yopal=$this->db->query("select count(*) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
        $customers_yopal_gpon=$this->db->query("select count(*) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0' and tegnologia_instalacion='GPON'")->result_array();
        $customers_monterrey=$this->db->query("select count(*) as c_usuarios from customers where gid='4' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
        $customers_villanueva=$this->db->query("select count(*) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
        $customers_villanueva_gpon=$this->db->query("select count(*) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and tegnologia_instalacion='GPON'")->result_array();
*/
        $customers_yopal=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
        $customers_yopal_gpon=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='2' and Ipremota is not null and Ipremota!='' and Ipremota!='0' and tegnologia_instalacion='GPON'")->result_array();
        $customers_monterrey=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='4' and Ipremota is not null and Ipremota!='' and Ipremota!='0'")->result_array();
        $customers_villanueva=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
        $customers_villanueva_gpon=$this->db->query("select INET_NTOA(max(INET_ATON(Ipremota))) as c_usuarios from customers where gid='3' and Ipremota is not null and Ipremota!='' and tegnologia_instalacion='GPON'")->result_array();
        
        // ips yopal
        $ciclo=true;
        $ip=ip2long($customers_yopal[0]['c_usuarios'])+1;//+intval($customers_yopal[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            //$comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2"))->row();
            $comprovar=$this->db->query("select * from customers where gid='2' and Ipremota='".long2ip($nmask)."' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
            if(count($comprovar)==0){
                //no existe
                $ips_remotas['yopal']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips yopal

        // ips yopal gpon
        $ciclo=true;
        $ip=ip2long($customers_yopal_gpon[0]['c_usuarios'])+1;//+intval($customers_yopal[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            //$comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2"))->row();
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"2","tegnologia_instalacion"=>"GPON"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['yopal_gpon']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips yopal gpon
        // ips monterrey
        $ciclo=true;
        $ip=ip2long($customers_monterrey[0]['c_usuarios'])+1;//+intval($customers_monterrey[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"4"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['monterrey']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips monterrey

        // ips villanueva
        $ciclo=true;
        $ip=ip2long($customers_villanueva[0]['c_usuarios'])+1;//+intval($customers_villanueva[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->query("select * from customers where gid='3' and Ipremota='".long2ip($nmask)."' and (tegnologia_instalacion!='GPON' or tegnologia_instalacion is null)")->result_array();
            if(count($comprovar)==0){
                //no existe
                $ips_remotas['villanueva']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips villanueva
         // ips customers_villanueva_gpon
        $ciclo=true;
        $ip=ip2long($customers_villanueva_gpon[0]['c_usuarios'])+1;//+intval($customers_villanueva_gpon[0]['c_usuarios']) estas lineas hay que agregarlas si el sistema se pone lento al completar todas las casillas ips posibles
        
        while($ciclo){
            
            $bcast = $ip;
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            
            $comprovar=$this->db->get_where("customers",array("Ipremota"=>long2ip($nmask),"gid"=>"3","tegnologia_instalacion"=>"GPON"))->row();
            if(empty($comprovar)){
                //no existe
                $ips_remotas['villanueva_gpon']=long2ip($nmask);//aqui como la ip es correcta y no existe se deja como la ip a retornar
                $ciclo=false;
            }else{                
                //existe
                $ciclo=true;
                $ip=$ip+1;
            }
        }            
       // end ips customers_villanueva_gpon
return $ips_remotas;

        /* $bcast = ip2long("10.20.2.0"); //codigo de ejemplo de como sumar ips basico
            $smask = ip2long("255.255.255.255");
            $nmask = $bcast & $smask;
            var_dump( long2ip($nmask)); // Will give 192.168.178.0*/
    }
    public function getClientData(){
        $data_json_string='{
    "Header": {
        "Id": 0,
        "DocCode": 12434,
        "EmailToSend": null,
        "DocDate": "20210427",
        "MoneyCode": "COP",
        "ExchangeValue": 0,
        "DiscountValue": 0,
        "VATTotalValue": 3992,
        "ConsumptionTaxTotalValue": 0,
        "TaxDiscTotalValue": 0,
        "RetVATTotalID": -1,
        "RetVATTotalPercentage": -1,
        "RetVATTotalValue": 0,
        "RetICATotalID": -1,
        "RetICATotalValue": 0,
        "RetICATotaPercentage": -1,
        "TotalValue": 25000,
        "TotalBase": 21008,
        "SalesmanIdentification": "963852741",
        "Observations": "Registro automático API",
        "Account": {
            "IsSocialReason": true,
            "FullName": "JANNINI MAZIEL ESTUPIÑAN ALFONSO",
            "FirstName": "JANNINI",
            "LastName": "ESTUPIÑAN",
            "IdTypeCode": "13",
            "Identification": "1118197537",
            "CheckDigit": 0,
            "BranchOffice": 0,
            "IsVATCompanyType": false,
            "City": {
                "CountryCode": "Co",
                "StateCode": "85",
                "CityCode": "85001"
            },
            "Address": "Dirección Tercero prueba",
            "Comments": "",
            "Phone": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            }
        },
        "Contact": {
            "Code": 1,
            "Phone1": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "Mobile": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "EMail": "vestelsas@gmail.com",
            "FirstName": "Contacto",
            "LastName": "JOAO",
            "IsPrincipal": true,
            "Gender": 1,
            "BirthDate": ""
        },
        "CostCenterCode": "Y01",
        "SubCostCenterCode": "1"
    },
    "Items": [
        {
            "ProductCode": "001",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        }
    ],
    "Payments": [
        {
            "PaymentMeansCode": 2863,
            "Value": 25000,
            "DueDate": "20210427",
            "DueQuote": 0
        }
    ]
}';
return $data_json_string;
    }

public function getClientData2Productos(){
        $data_json_string='{
    "Header": {
        "Id": 0,
        "DocCode": 12434,
        
        "EmailToSend": null,
        "DocDate": "20210427",
        "MoneyCode": "COP",
        "ExchangeValue": 0,
        "DiscountValue": 0,
        "VATTotalValue": 3992,
        "ConsumptionTaxTotalValue": 0,
        "TaxDiscTotalValue": 0,
        "RetVATTotalID": -1,
        "RetVATTotalPercentage": -1,
        "RetVATTotalValue": 0,
        "RetICATotalID": -1,
        "RetICATotalValue": 0,
        "RetICATotaPercentage": -1,
        "TotalValue": 25000,
        "TotalBase": 21008,
        "SalesmanIdentification": "963852741",
        "Observations": "Registro automático API",
        "Account": {
            "IsSocialReason": true,
            "FullName": "JANNINI MAZIEL ESTUPIÑAN ALFONSO",
            "FirstName": "JANNINI",
            "LastName": "ESTUPIÑAN",
            "IdTypeCode": "13",
            "Identification": "1118197537",
            "CheckDigit": 0,
            "BranchOffice": 0,
            "IsVATCompanyType": false,
            "City": {
                "CountryCode": "Co",
                "StateCode": "85",
                "CityCode": "85001"
            },
            "Address": "Dirección Tercero prueba",
            "Comments": "",
            "Phone": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            }
        },
        "Contact": {
            "Code": 1,
            "Phone1": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "Mobile": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "EMail": "vestelsas@gmail.com",
            "FirstName": "Contacto",
            "LastName": "JOAO",
            "IsPrincipal": true,
            "Gender": 1,
            "BirthDate": ""
        },
        "CostCenterCode": "Y01",
        "SubCostCenterCode": "1"
    },
    "Items": [
        {
            "ProductCode": "001",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        },{
            "ProductCode": "l01",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        }
    ],
    "Payments": [
        {
            "PaymentMeansCode": 2863,
            "Value": 25000,
            "DueDate": "20210427",
            "DueQuote": 0
        }
    ]
}';
return $data_json_string;
    }

public function getClientData3Productos(){
        $data_json_string='{
    "Header": {
        "Id": 0,
        "DocCode": 12434,
        
        "EmailToSend": null,
        "DocDate": "20210427",
        "MoneyCode": "COP",
        "ExchangeValue": 0,
        "DiscountValue": 0,
        "VATTotalValue": 3992,
        "ConsumptionTaxTotalValue": 0,
        "TaxDiscTotalValue": 0,
        "RetVATTotalID": -1,
        "RetVATTotalPercentage": -1,
        "RetVATTotalValue": 0,
        "RetICATotalID": -1,
        "RetICATotalValue": 0,
        "RetICATotaPercentage": -1,
        "TotalValue": 25000,
        "TotalBase": 21008,
        "SalesmanIdentification": "963852741",
        "Observations": "Registro automático API",
        "Account": {
            "IsSocialReason": true,
            "FullName": "JANNINI MAZIEL ESTUPIÑAN ALFONSO",
            "FirstName": "JANNINI",
            "LastName": "ESTUPIÑAN",
            "IdTypeCode": "13",
            "Identification": "1118197537",
            "CheckDigit": 0,
            "BranchOffice": 0,
            "IsVATCompanyType": false,
            "City": {
                "CountryCode": "Co",
                "StateCode": "85",
                "CityCode": "85001"
            },
            "Address": "Dirección Tercero prueba",
            "Comments": "",
            "Phone": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            }
        },
        "Contact": {
            "Code": 1,
            "Phone1": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "Mobile": {
                "Indicative": 0,
                "Number": 0,
                "Extention": 0
            },
            "EMail": "vestelsas@gmail.com",
            "FirstName": "Contacto",
            "LastName": "JOAO",
            "IsPrincipal": true,
            "Gender": 1,
            "BirthDate": ""
        },
        "CostCenterCode": "Y01",
        "SubCostCenterCode": "1"
    },
    "Items": [
        {
            "ProductCode": "001",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        },{
            "ProductCode": "l01",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        },
        {
            "ProductCode": "l01",
            "Description": "Descripción producto",
            "GrossValue": 21008,
            "BaseValue": 21008,
            "Quantity": 1,
            "UnitValue": 21008,
            "DiscountValue": 0,
            "DiscountPercentage": 0,
            "TaxAddName": "IVA 19%",
            "TaxAddId": 6688,
            "TaxAddValue": 3992,
            "TaxAddPercentage": 19,
            "TaxDiscountName": "",
            "TaxDiscountId": -1,
            "TaxDiscountValue": 0,
            "TaxDiscountPercentage": 0,
            "TotalValue": 25000,
            "ProductSubType": 0,
            "TaxAdd2Name": "",
            "TaxAdd2Id": -1,
            "TaxAdd2Value": 0,
            "TaxAdd2Percentage": 0,
            "WareHouseCode": null,
            "SalesmanIdentification": 963852741
        }
    ],
    "Payments": [
        {
            "PaymentMeansCode": 2863,
            "Value": 25000,
            "DueDate": "20210427",
            "DueQuote": 0
        }
    ]
}';
return $data_json_string;
    }

public function getCustomerJson(){
        $str='{
  "type": "Customer",
  "person_type": "Person",
  "id_type": "13",
  "identification": "13832081",
  "check_digit": "4",
  "name": [
    "Marcos",
    "Castillo"
  ],
  "commercial_name": "Siigo",
  "branch_office": 0,
  "active": true,
  "vat_responsible": false,
  "fiscal_responsibilities": [
    {
      "code": "R-99-PN"
    }
  ],
  "address": {
    "address": "Cra. 18 #79A - 42",
    "city": {
      "country_code": "Co",
      "state_code": "85",
      "city_code": "85001"
    },
    "postal_code": "00000"
  },
  "phones": [
    {
      "indicative": "57",
      "number": "3006003345",
      "extension": "000"
    }
  ],
  "contacts": [
    {
      "first_name": "Marcos",
      "last_name": "Castillo",
      "email": "marcos.castillo@contacto.com",
      "phone": {
        "indicative": "57",
        "number": "3006003345",
        "extension": "000"
      }
    }
  ],
  "comments": "Comentarios",
  "related_users": {
    "seller_id": 282,
    "collector_id": 282
  }
}';
return $str;
    }

    public function getFacturaElectronica($n_productos=null){
        
    $otro_producto=',{
              "code": "001",
              "description": "DESCRIPCION",
              "quantity": 1,
              "price": 21008,
              "discount": 0.0              
            }';
            if($n_productos==null){
                $otro_producto="";
            }

        $str='{
  "document": {
    "id": 12434
  },
  "date": "2021-12-31",
  "customer": {
    "identification": "13832081",
    "branch_office": 0
  },
  "cost_center": 1074,
  "seller": 1011,
  "observations": "Observaciones",
  "items": [
    {
      "code": "001",
      "description": "DESCRIPCION",
      "quantity": 1,
      "price": 21008.4,
      "discount": 0.0,
      "taxes": [
        {"id": 6688,
         "name": "IVA 19%",
         "type": "IVA",
         "percentage": 19,
         "value": 3991.6
        }
      ]
    }'.$otro_producto.'
  ],
  "payments": [
    {
      "id": 2863,
      "value": 25000,
      "due_date": "2021-12-31"
    }
  ],
  "additional_fields": {}
  
}';
return $str;
    }

    public function calculoParaFacturaElectronica($valor_sin_iva){
        $iva=19;
        $valortotal=0;
        $valor_iva=0;
        //$valor_sin_iva=$valor_sin_iva;
        $valor_iva=($valor_sin_iva*$iva)/100;
        $valortotal=$valor_iva+$valor_sin_iva;

        
        if($valortotal!=round($valortotal)){
            $explode_iva=explode(".",$valor_iva);
            $decima1=$explode_iva[1][0];
            //$decima1=1;
            if($decima1==0){
                $valor_sin_iva--;
                $decima1=1;    
            }
            $decimal2=10-$decima1;
            $vari=($explode_iva[0].".".$decima1);
            
            $var_sub=($valor_sin_iva.".".$decimal2);
            $v=($var_sub*19)/100;
            $vt=$v+$var_sub;
            
            if($vt!=round($valortotal)){
                $decima1++;
                $decimal2=10-$decima1;
                $vari=($explode_iva[0].".".$decima1);
                $var_sub=($valor_sin_iva.".".$decimal2);
                $v=$vari;
                
                $valor_iva=$v;
                $valor_sin_iva=$var_sub;
                
            }else{
                $valor_iva=$v;
                $valor_sin_iva=$var_sub;
            }
        }


        
        $valortotal=$valor_iva+$valor_sin_iva;
        return array("valor_iva"=>$valor_iva,"valor_sin_iva"=>$valor_sin_iva,"valortotal"=>$valortotal);
      /*  var_dump($valor_iva); 
        var_dump($valor_sin_iva); 
        var_dump($valortotal);*/
    }

}
