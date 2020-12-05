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

class Tickets Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ticket_model', 'ticket');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }

    }


    //documents


    public function index()
    {
		
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Support Tickets';
		$data['tecnicoslista'] = $this->ticket->tecnico_list();
        $data['totalt'] = $this->ticket->ticket_count_all('');
        $this->load->view('fixed/header', $head);
        $this->load->view('support/tickets', $data);
        $this->load->view('fixed/footer');


    }

    public function tickets_load_list()
    {
        $filt = $this->input->get('stat');
        $list = $this->ticket->ticket_datatables($filt);
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $ticket) {
            $row = array();
            $no++;			
            $row[] = $no;
			$row[] = '<input id="input_'.$ticket->idt.'" type="checkbox" style="margin-left: 9px;cursor:pointer;" onclick="asignar_orden(this)" data-id="'.$ticket->idt.'">';
			$row[] = $ticket->idt;
            $row[] = $ticket->subject;
			$row[] = $ticket->detalle;
            $row[] = $ticket->created;          
			if($ticket->cid !=null){
                $row[]='<a href="'.base_url("customers/view?id=".$ticket->cid).'">'.$ticket->abonado.'</a>';
            }
			$row[] = $ticket->name;
          if($ticket->id_factura !=null){
                $row[]='<a href="'.base_url("invoices/view?id=".$ticket->id_factura).'">'.$ticket->id_factura.'</a>';
            }else{
                 $row[]="Sin Factura";
            }

            if($ticket->asignado!=null){
                $tecnico=$this->db->get_where('aauth_users',array('id'=>$ticket->asignado))->row();
                $row[]=$tecnico->username;
            }else{
                $row[] = "--";    
            }
			
			$row[] = '<span class="st-' . $ticket->status . '">' . $ticket->status . '</span>';
            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->idt) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> <a href="' . base_url('quote/edit/?id=' . $ticket->idt) . '" class="btn btn-primary btn-sm"><i class="icon-pencil"></i> ' . 'Editar' . '</a> <a class="btn btn-danger" onclick="eliminar_ticket('.$ticket->idt.')" > <i class="icon-trash-o "></i> </a>';

            

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all($filt),
            "recordsFiltered" => $this->ticket->ticket_count_filtered($filt),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function tickets_load_list_2()
    {
        $filt = $this->input->get('stat');
        $filt="Pendiente";
        $list = $this->ticket->ticket_datatables_2($filt,$_GET);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $ticket) {
            $row = array();
            $no++;          
            $row[] = $no;
            $row[] = '<input id="input_'.$ticket->idt.'" type="checkbox" style="margin-left: 9px;cursor:pointer;" onclick="asignar_orden(this)" data-id="'.$ticket->idt.'">';
            $row[] = $ticket->idt;
            $row[] = $ticket->subject;
            $row[] = $ticket->detalle;
            $row[] = $ticket->created;          
            if($ticket->cid !=null){
                $row[]='<a href="'.base_url("customers/view?id=".$ticket->cid).'">'.$ticket->abonado.'</a>';
            }
            $row[] = $ticket->name;
          if($ticket->id_factura !=null){
                $row[]='<a href="'.base_url("invoices/view?id=".$ticket->id_factura).'">'.$ticket->id_factura.'</a>';
            }else{
                 $row[]="Sin Factura jeje";
            }

            if($ticket->asignado!=null){
                $tecnico=$this->db->get_where('aauth_users',array('id'=>$ticket->asignado))->row();
                $row[]=$tecnico->username;
            }else{
                $row[] = "--";    
            }
            
            $row[] = '<span class="st-' . $ticket->status . '">' . $ticket->status . '</span>';
            $row[] = '<a href="' . base_url('tickets/thread/?id=' . $ticket->idt) . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> <a href="' . base_url('quote/edit/?id=' . $ticket->idt) . '" class="btn btn-primary btn-sm"><i class="icon-pencil"></i> ' . 'Editar' . '</a> <a class="btn btn-danger" onclick="eliminar_ticket('.$ticket->idt.')" > <i class="icon-trash-o "></i> </a>';

            

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->ticket_count_all($filt),
            "recordsFiltered" => $this->ticket->ticket_count_filtered($filt),
            "data" => $data,
        );
        echo json_encode($output);
    }
    
    public function asignar_ordenes(){
        foreach ($_POST['lista'] as $key => $id_orden) {
            $datos['asignado']=$_POST['id_tecnico_seleccionado'];
            $condicion['idt']=$id_orden;
            $this->db->update('tickets',$datos,$condicion);
        }
        echo "correcto";
    }

    public function ticket_stats()
    {

        $this->ticket->ticket_stats();


    }


    public function thread()
    {

        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');		
        $data['response'] = 3;
        $data['id_orden_n']	=$thread_id;	
        $orden = $this->db->get_where('tickets',array('idt'=>$thread_id))->row();
        $almacen= $this->db->get_where('product_warehouse',array('id_tecnico'=>$orden->asignado))->row();
		$data['lista_productos_tecnico']=$this->db->get_where('products',array('warehouse'=>$almacen->id))->result_array();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Support Reply';		
        $this->load->view('fixed/header', $head);

        if ($this->input->post('content')) {

            $message = $this->input->post('content');
            $attach = $_FILES['userfile']['name'];
            if ($attach) {
                $config['upload_path'] = './userfiles/support';
                $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                $config['max_size'] = 3000;
                $config['file_name'] = time() . $attach;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('userfile')) {
                    $data['response'] = 0;
                    $data['responsetext'] = 'File Upload Error';

                } else {
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                    $filename = $this->upload->data()['file_name'];
                    $this->ticket->addreply($thread_id, $message, $filename);
                }
            } else {
                $this->ticket->addreply($thread_id, $message, '');
                $data['response'] = 1;
                $data['responsetext'] = 'Reply Added Successfully.';
            }

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);			
            $this->load->view('support/thread', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);			
            $this->load->view('support/thread', $data);


        }
        $this->load->view('fixed/footer');
		


    }
    //consultas ajax referentes a tikets materiales add delet
    public function add_products_orden(){
        
        foreach ($_POST['lista'] as $key => $producto) {
             $vary=intval($producto['qty']);
             if($vary>0){
                $tf_prod_orden=$this->db->get_where('transferencia_products_orden',array("products_pid"=>$producto['pid'],"tickets_id"=>$_POST['id_orden_n']))->row();
                if(empty($tf_prod_orden)){
                    $dats['products_pid']=$producto['pid'];
                    $dats['tickets_id']=$_POST['id_orden_n'];
                    $dats['cantidad']=$producto['qty'];
                    //proceso de descontar cantidades del almacen
                    $producto_padre=$this->db->get_where('products',array('pid'=>$producto['pid']))->row();
                    $x1=intval($producto_padre->qty);
                    $x1=$x1-$vary;
                    $datx['qty']=$x1;
                    $this->db->update('products',$datx,array('pid'=>$producto['pid']));
                    // end proceso de descontar cantidades del almacen
                    $this->db->insert('transferencia_products_orden',$dats);
                }
             }
        }

        echo "Correcto";
    }

    public function eliminar_prod_lista(){
        $transferencia =  $this->db->get_where('transferencia_products_orden',array("idtransferencia_products_orden"=>$_POST['idt']))->row();
        $producto=$this->db->get_where('products',array("pid"=>$transferencia->products_pid))->row();
        $x1=intval($producto->qty);
        $y1=intval($transferencia->cantidad);
        $x1=$x1+$y1;
        $datosx['qty']=$x1;
        $this->db->update('products',$datosx,array('pid'=>$producto->pid));
        $this->db->delete('transferencia_products_orden',array("idtransferencia_products_orden"=>$_POST['id']));
        echo "Eliminado";
    }
    //fin consultas ajax referentes a tikets materiales add delet
    public function delete_ticket()
    {   
       
       
        $id = $this->input->post('deleteid');

        if ($this->ticket->deleteticket($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }
	public function delete_documento()
    {  
        $id = $this->input->post('deleteid');

        if ($this->ticket->deletedoc($id)) {
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');		
        $status = $this->input->post('status');
        $fecha_final = $this->input->post('fecha_final');        
        $ticket = $this->db->get_where('tickets', array('idt' => $tid))->row();
        $invoice = $this->db->get_where('invoices',array('tid'=>$ticket->id_invoice))->result_array();
		$idfactura = $ticket->id_factura;
        $data;
		$detalle = $this->input->post('detalle');
		
        foreach ($invoice[0] as $key => $value) {
            if($key!='id' && $key!='pmethod' && $key!='status' && $key!='pamnt'){
             $data[$key]=$value;
            }
        }
        $tidactualmasuno= $this->db->select('max(tid)+1 as tid')->from('invoices')->get()->result();
        //esta data es de la nueva factura para insertar
        $data['tid']=$tidactualmasuno[0]->tid;
        $data['status']='due';
        $data['ron']='Activo';
        //ssss
        $date_fecha_final = new DateTime($fecha_final);
        $var_mes ;
        if(intval($date_fecha_final->format('d')) >=27){
            $ms =intval($date_fecha_final->format('m'));
            if($ms==12){
                $var_mes='1';
            }else{
                $var_mes=$ms+1;    
            }
            
        }else{
            $var_mes ='m';
        }
        
        $date_fecha_corte=new DateTime(date('Y-'.$var_mes.'-27'));
        
        $diferencia = $date_fecha_final->diff($date_fecha_corte);
        $data['invoicedate']=$date_fecha_final->format("Y-m-d");
        $data['invoiceduedate']=$date_fecha_corte->format('Y-m-d');
        //ya tengo la diferencia entre las fechas ahora tengo que cojer el valortotal y dividirlo por los dias para obtener el valor de la factura que se cambia en $data['total'] y se insertan los datos al igual con cada item luego lo mando a http://localhost/CRMvestel/invoices/view?id=ticket->id_factura
        //end sss
        // lista_de_invoice_items es la lista de itemes para insertar
        $lista_de_invoice_items = $this->db->select('*')->from('invoice_items')->where("tid='".$ticket->id_invoice."' && ( pid =23 or pid =27)")->get()->result();
        $total=0;

        //cod x

        $datay['tid']=$data['tid'];
        $datay['qty']=1;
        $datay['tax']=0;
        $datay['discount']=0;
        $datay['totaltax']=0;
        $datay['totaldiscount']=0;			
                if($data['combo']!==no){
                    if($data['combo']==='3Megas'){
                        $datay['pid']=24;
					}else if($data['combo']==='3MegasSolo'){
                        $datay['pid']=170;
                    }else if($data['combo']==='5Megas'){
                        $datay['pid']=25;
					}else if($data['combo']==='5MegasSolo'){
                        $datay['pid']=171;
                    }else if($data['combo']==='10Megas'){
                        $datay['pid']=26;
					}else if($data['combo']==='10MegasSolo'){
                        $datay['pid']=172;
                    }
                    $producto = $this->db->get_where('products',array('pid'=>$datay['pid']))->row();
                    $x=intval($producto->product_price);
                    $x=($x/30)*$diferencia->days;
                    $total+=$x;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $datay['price']=$x;
                    $datay['subtotal']=$x;     
                    if($ticket->detalle=="Instalacion" && $ticket->id_factura==null){
                        $this->db->insert('invoice_items',$datay);    
                    }
                }
                
                if($data['television']!==no AND $data['refer']!==Mocoa){                
                    $producto = $this->db->get_where('products',array('pid'=>27))->row();
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $x=intval($producto->product_price);
                    $x=($x/30)*$diferencia->days;
                    $total+=$x;
                    $datay['price']=$x;
                    $datay['subtotal']=$x;
                    if($ticket->detalle=="Instalacion" && $ticket->id_factura==null){
                        $this->db->insert('invoice_items',$datay);
                    }
                }
				if($data['television']!==no AND $data['refer']==Mocoa){                
                    $producto = $this->db->get_where('products',array('pid'=>159))->row();
                    $datay['pid']=$producto->pid;
                    $datay['product']=$producto->product_name;
					$datay['qty']=1;
                    $x=intval($producto->product_price);
                    $x=($x/30)*$diferencia->days;
                    $total+=$x;
                    $datay['price']=$x;
                    $datay['subtotal']=$x;
                    if($ticket->detalle=="Instalacion" && $ticket->id_factura==null){
                        $this->db->insert('invoice_items',$datay);
                    }
                }
                
			
                
               
        //end cod x
        
        $data['subtotal']=$total;
        $data['total']=$total;
        //no haga ni insert ni update si no es instalacion y tambien si ya existe una factura
        $msg1="";
        if($ticket->detalle=="Instalacion" && $ticket->id_factura==null){
            $this->db->insert('invoices',$data);    
            $dataz['id_factura']=$data['tid'];
        }else{
            $msg1="no redirect";        
		}
		if($ticket->detalle=="Subir 5 Mg"){			
			$this->db->set('combo', '5Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Subir 10 Mg"){			
			$this->db->set('combo', '10Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Bajar 5 Mg"){			
			$this->db->set('combo', '5Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Bajar 3 Mg"){			
			$this->db->set('combo', '3Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Bajar 3 Mg"){			
			$this->db->set('combo', '3Megas');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Reconexion Combo"){
			$paquete = $this->input->post('paquete');
			$this->db->set('combo', $paquete);
			$this->db->set('television', 'Television');
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Reconexion Internet"){
			$paquete = $this->input->post('paquete');
			$this->db->set('combo', $paquete);			
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Reconexion Television"){
			$paquete = $this->input->post('paquete');
			$this->db->set('television', 'Television');			
			$this->db->set('ron', 'Activo');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Corte Combo"){
			//agregar reconexion
			$producto2 = $this->db->get_where('products',array('pid'=>169))->row();
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);
			//actualizar factura
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('ron', 'Cortado');				
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);
				$this->db->set('television', 'no');
				$this->db->set('combo', 'no');
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
		}
		if($ticket->detalle=="Corte Internet"){
			//agregar reconexion
			$producto2 = $this->db->get_where('products',array('pid'=>162))->row();
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);
			//actualizar factura
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);
				$this->db->set('ron', 'Cortado');
				$this->db->set('combo', 'no');			
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
		}
		if($ticket->detalle=="Corte Television"){
			//agregar reconexion
			$producto2 = $this->db->get_where('products',array('pid'=>161))->row();
				$data2['tid']=$idfactura;
				$data2['pid']=$producto2->pid;
                $data2['product']=$producto2->product_name;
                $data2['price']=$producto2->product_price;
				$data2['qty']=1;
                $data2['subtotal']=$producto2->product_price;			
            	$this->db->insert('invoice_items',$data2);
			//actualizar factura
			$factura = $this->db->get_where('invoices',array('tid'=>$idfactura))->row();
				$this->db->set('subtotal', $factura->subtotal+$producto2->product_price);
				$this->db->set('total', $factura->total+$producto2->product_price);
				$this->db->set('items', $factura->items+1);
				$this->db->set('ron', 'Cortado');
				$this->db->set('television', 'no');			
        		$this->db->where('tid', $idfactura);
        		$this->db->update('invoices');
		}
		
		if($ticket->detalle=="Suspencion Combo"){			
			$this->db->set('ron', 'Suspendido');
			$this->db->set('television', 'no');
			$this->db->set('combo', 'no');
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Suspencion Television"){			
			$this->db->set('ron', 'Activo');
			$this->db->set('television', 'no');			
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		if($ticket->detalle=="Suspencion Internet"){			
			$this->db->set('ron', 'Activo');
			$this->db->set('combo', 'no');			
        	$this->db->where('tid', $idfactura);
        	$this->db->update('invoices');
		}
		
        $dataz['status']=$status;
        $dataz['fecha_final']=$fecha_final;
        
        $this->db->update('tickets',$dataz,array('idt'=>$tid));
        
        echo json_encode(array('msg1'=>$msg1,'tid'=>$data['tid'],'status' => 'Success', 'message' =>
            $this->lang->line('UPDATED'), 'pstatus' => $status));
		
		
	}

	  
	
	public function addticket()
    {
        $this->load->helper(array('form'));
        $thread_id = $this->input->get('id');
		$data2['barrio'] = $this->ticket->group_barrio($data['details']['barrio']);
        $data['response'] = 3;		
		
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add ticket';		
        $this->load->view('fixed/header', $head);

        if ($this->input->post('content')) {

            $message = $this->input->post('content');
            $attach = $_FILES['userfile']['name'];
            if ($attach) {
                $config['upload_path'] = './userfiles/support';
                $config['allowed_types'] = 'docx|docs|txt|pdf|xls|png|jpg|gif';
                $config['max_size'] = 3000;
                $config['file_name'] = time() . $attach;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('userfile')) {
                    $data['response'] = 0;
                    $data['responsetext'] = 'File Upload Error';

                } else {
                    $data['response'] = 1;
                    $data['responsetext'] = 'Reply Added Successfully.';
                    $filename = $this->upload->data()['file_name'];
                    $this->ticket->addreply($thread_id, $message, $filename);
                }
            } else {
                $this->ticket->addreply($thread_id, $message, '');
                $data['response'] = 1;
                $data['responsetext'] = 'Reply Added Successfully.';
            }

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);

            $this->load->view('support/addticket', $data);
        } else {

            $data['thread_info'] = $this->ticket->thread_info($thread_id);
            $data['thread_list'] = $this->ticket->thread_list($thread_id);


            $this->load->view('support/addticket', $data);


        }
        $this->load->view('fixed/footer');
		


    }


    


}