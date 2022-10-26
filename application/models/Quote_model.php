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

class Quote_model extends CI_Model
{
    var $table = 'tickets';	
    var $column_order = array(null,'codigo', 'subject', 'detalle', null);
    var $column_search = array('codigo', 'subject', 'detalle');
    var $order = array('codigo' => 'desc');

    public function __construct()
    {
        parent::__construct();
    }

    public function lastquote()
    {
        $this->db->select('codigo');
        $this->db->from($this->table);
        $this->db->order_by('codigo', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->codigo;
        } else {
            return 1000;
        }
    }

    public function warehouses()
    {
        $this->db->select('*');
        $this->db->from('product_warehouse');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function quote_details($id)
    {

        $this->db->select('quotes.*,customers.*,customers.id AS cid,billing_terms.id AS termid,billing_terms.title AS termtit,billing_terms.terms AS terms');
        $this->db->from($this->table);
        $this->db->where('quotes.tid', $id);
        $this->db->join('customers', 'quotes.csd = customers.id', 'left');
        $this->db->join('billing_terms', 'billing_terms.id = quotes.term', 'left');
        $query = $this->db->get();
        return $query->row_array();

    }

    public function quote_products($id)
    {

        $this->db->select('*');
        $this->db->from('quotes_items');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        return $query->result_array();

    }
	public function group_tempo($id)
    {
		$this->db->select('*');
        $this->db->from('temporales');
        $this->db->where('corden', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function quote_delete($id)
    {

        $this->db->trans_start();


        $this->db->delete('quotes', array('tid' => $id));
        $this->db->delete('quotes_items', array('tid' => $id));

        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }
    }


    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $this->db->join('customers', 'quotes.csd=customers.id', 'left');

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


    public function billingterms()
    {
        $this->db->select('id,title');
        $this->db->from('billing_terms');
        $this->db->where('type', 2);
        $this->db->or_where('type', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee($id)
    {
        $this->db->select('employee_profile.name,employee_profile.sign,aauth_users.roleid');
        $this->db->from('employee_profile');
        $this->db->where('employee_profile.id', $id);
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }
	public function addticket($customer_id, $gen, $nticket, $subject, $detalle, $created, $problema, $bapaquete, $supaquete, $section, $factura, $agendar, $fagenda, $tec, $hora,$hora2,$nomen,$nuno,$auno,$ndos,$ados,$ntres,$local,$barrio,$recider, $refer,$tv,$inter,$bainter, $suinter,$punto,$movil)
    {
		$bill_llegada = datefordatabase($created);
		if ($tv=='no' || $tv==''){
				$tv2 = '';
			}else{
				$tv2 = $tv;
			}
			if ($inter=='no' || $inter==''){
				$int2 = '';
			}else{
				$int2 = ' + '.$inter;
			}
			if ($punto=='0' || $punto==''){
				$pto2 = '';
			}else{
				$pto2 = ' + '.$punto.' Puntos';
			}
		$start = new DateTime($fagenda);
        $nticket=($this->lastquote())+1;
		if($movil==0){
            $movil=null;
        }
		if($detalle=='Instalacion' || $detalle=='Activacion'){
			$obs = $tv2.$int2.$pto2.$section;
		}else if($detalle=='AgregarInternet'){
			$obs = $int2.' '.$section;
		}else if($detalle=='AgregarTelevision'){
			$obs = $tv2.' '.$pto2.' '.$section;
		}else if($detalle=='Subir megas'){
			$obs = $suinter.' '.$section;
		}else if($detalle=='Bajar megas'){
			$obs = $bainter.' '.$section;
		}else{
			$obs = $section;
		}
		if ($detalle=='Reconexion Combo'){
				//internet
				$data2['codigo']=$nticket;
                $data2['subject']=$subject;
                $data2['detalle']='Reconexion Internet';
                $data2['created']=$bill_llegada;
                $data2['cid']=$customer_id;
				$data2['col']=$gen;
                $data2['status']='Pendiente';
                $data2['section']=$obs;
                $data2['id_factura']=$factura;
               $in = $this->db->insert('tickets',$data2);
				//tv
				$data3['codigo']=$nticket+1;
                $data3['subject']=$subject;
                $data3['detalle']='Reconexion Television';
                $data3['created']=$bill_llegada;
                $data3['cid']=$customer_id;
				$data3['col']=$gen;
                $data3['status']='Pendiente';
                $data3['section']=$obs;
                $data3['id_factura']=$factura;
                $this->db->insert('tickets',$data3);
			}else{
        $data = array(
			'codigo' => $nticket,
            'subject' => $subject,
            'detalle' => $detalle,
            'created' => $bill_llegada,
            'cid' => $customer_id,
			'col' => $gen,
            'status' => 'Pendiente',
			'problema' => $problema,
            'section' => $obs,
            'fecha_final' => '',
            'id_invoice' => 'null',
            'id_factura' => $factura,
			'asignado' => $tec,
            'asignacion_movil'=>$movil,
        );
			$in = $this->db->insert('tickets', $data);
		}
		if ($in) {
			$id_t1=$this->db->insert_id();
            $servicios_adicionales="";
                            foreach ($_POST as $llave => $valor) {
                                    if(strpos($llave,"serv_add_")!==false){
                                        if($valor!="0"){
                                                $pid_serv=str_replace("serv_add_", "", $llave);
                                                $product_serv=$this->db->get_where("products",array("pid"=>$pid_serv))->row();
                                                $servicios_adicionales.=" + ".$valor." ".$product_serv->product_name;    
                                                $data_serv=array();
                                                $data_serv['tid_invoice']=0;
                                                $data_serv['idt_ticket']=$id_t1;
                                                $data_serv['pid']=$pid_serv;
                                                $data_serv['valor']=$valor;
                                                $precio=$product_serv->product_price;
                                                if(is_int($valor)){
                                                    //$precio*$valor;
                                                }
                                                $data_serv['subtotal']=$precio;
                                                $data_serv['total']=$precio;
                                                $this->db->insert("servicios_adicionales",$data_serv);
                                        }
                                        
                                    }
                            }
                            if($servicios_adicionales!=""){
                                $servicios_adicionales=$obs." ".$servicios_adicionales;
                                $this->db->update("tickets",array("section"=>$servicios_adicionales),array("idt"=>$id_t1));
                            }

			//agregar agenda
		$boleta = $this->db->get_where('tickets', array('codigo' => $nticket))->row();
		$abonado = $this->db->get_where('customers', array('id' => $boleta->cid))->row();
		if ($agendar=="si"){
		$data2 = array(
			'idorden' => $nticket,
			'title' => ' Usuario #'.$abonado->abonado.' '.$detalle.' '.$hora,
            'start' => date($start->format("Y-m-d")." ".$hora2),
            'end' => '',
            'description' => strip_tags($section),
            'color' => '#4CB0CB',
			'rol' => $tec,
			'asigno' => $this->aauth->get_user()->id
		);		
		$this->db->insert('events', $data2);
		}
			if ($detalle=='Traslado'){
				$data3 = array(
				'corden' => $nticket,
				'nomenclatura' => $nomen,
				'nuno' => $nuno,
				'auno' => $auno,
				'ndos' => $ndos,
				'ados' => $ados,
				'ntres' => $ntres,
				'localidad' => $local,
				'barrio' => $barrio,
				'residencia' => $recider,
				'referencia' => $refer
			);		
			$this->db->insert('temporales', $data3);
			}
			//servicio instalacion
			if ($detalle=='Instalacion' || $detalle=='Activacion'){
				$data4 = array(
				'corden' => $nticket,
				'tv' => $tv,
				'internet' => $inter,
				'puntos' => $punto
			);		
			$this->db->insert('temporales', $data4);
			}
			//agregar servicios
			if ($detalle=='AgregarInternet'){
				$data4 = array(
				'corden' => $nticket,
				'internet' => $inter,
			);		
			$this->db->insert('temporales', $data4);}
			//subir megas
			if ($detalle=='Subir megas'){
				$data4 = array(
				'corden' => $nticket,
				'internet' => $suinter,
				'puntos' => $supaquete,
			);		
			$this->db->insert('temporales', $data4);
			}
			//bajar megas
			if ($detalle=='Bajar megas'){
				$data4 = array(
				'corden' => $nticket,
				'internet' => $bainter,
				'puntos' => $bapaquete,
			);		
			$this->db->insert('temporales', $data4);
			}
			if ($detalle=='AgregarTelevision'){
				$data4 = array(
				'corden' => $nticket,
				'tv' => $tv,
				'puntos' => $punto
			);		
			$this->db->insert('temporales', $data4);
			}
		
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
		
        }
		
        
		
    }

    public function convert($id)
    {

        $invoice = $this->quote_details($id);
        $products = $this->quote_products($id);
        $this->db->trans_start();

        $this->db->select('tid');
        $this->db->from('invoices');
        $this->db->order_by('tid', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $iid = $query->row()->tid + 1;
        } else {
            $iid = 1000;
        }
        $productlist = array();
        $prodindex = 0;

        foreach ($products as $row) {

            $amt = $row['qty'];

            $data = array(
                'tid' => $iid,
                'pid' => $row['pid'],
                'product' => $row['product'],
                'qty' => $amt,
                'price' => $row['price'],
                'tax' => $row['tax'],
                'discount' => $row['discount'],
                'subtotal' => $row['subtotal'],
                'totaltax' => $row['totaltax'],
                'totaldiscount' => $row['totaldiscount'],
				'product_des' => $row['product_des']
            );

            $productlist[$prodindex] = $data;
            $prodindex++;

            $this->db->set('qty', "qty-$amt", FALSE);
            $this->db->where('pid', $row['pid']);
            $this->db->update('products');
        }


        $this->db->insert_batch('invoice_items', $productlist);


        $data = array('tid' => $iid, 'invoicedate' => $invoice['invoicedate'], 'invoiceduedate' => $invoice['invoicedate'], 'subtotal' => $invoice['invoicedate'], 'shipping' => $invoice['shipping'], 'discount' => $invoice['discount'], 'tax' => $invoice['tax'], 'total' => $invoice['total'], 'notes' => $invoice['notes'], 'csd' => $invoice['csd'], 'eid' => $invoice['eid'], 'items' => $invoice['items'], 'taxstatus' => $invoice['taxstatus'], 'discstatus' => $invoice['discstatus'], 'format_discount' => $invoice['format_discount'], 'refer' => $invoice['refer'], 'term' => $invoice['term']);

        $this->db->insert('invoices', $data);

        if ($this->db->trans_complete()) {
            return true;
        } else {
            return false;
        }


    }

    public function currencies()
    {

        $this->db->select('*');
        $this->db->from('currencies');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function currency_d($id)
    {
        $this->db->select('*');
        $this->db->from('currencies');
        $this->db->where('id', $id);
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
        $this->db->where('meta_data.type', 2);
        $this->db->where('meta_data.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id,$type,$name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('meta_data', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }



}