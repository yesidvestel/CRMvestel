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

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchase_model', 'purchase');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    //create invoice
    public function create()
    {
        $this->load->model('customers_model', 'customers');
		$this->load->model('transactions_model', 'transactions');
		$data['cat'] = $this->transactions->categories();
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->purchase->lastpurchase();
        $data['terms'] = $this->purchase->billingterms();
        $head['title'] = "New Purchase";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/newinvoice', $data);
        $this->load->view('fixed/footer');
    }

    //edit invoice
    public function edit()
    {

        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['title'] = "Purchase Order $tid";
        $this->load->model('customers_model', 'customers');
		$this->load->model('transactions_model', 'transactions');
		$data['cat'] = $this->transactions->categories();
        $data['customergrouplist'] = $this->customers->group_list();
        $data['terms'] = $this->purchase->billingterms();
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);;
        $head['title'] = "Edit Invoice #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->purchase->warehouses();

        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/edit', $data);
        $this->load->view('fixed/footer');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/invoices');
        $this->load->view('fixed/footer');
    }
	
	public function orden_servicio()
    {
        $head['title'] = "Manage Purchase Orders";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/invoicesSer');
        $this->load->view('fixed/footer');
    }

    //action
    public function action()
    {

        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $cat = $this->input->post('categoria');
        $notes = $this->input->post('notes');
        $tax = $this->input->post('tax_handle');
        $subtotal = $this->input->post('subtotal');
        $shipping = $this->input->post('shipping');
        $refer = $this->input->post('refer');
        $total = $this->input->post('total');
        $warehouse = $this->input->post('warehouse');
        $actualizar_stock=$this->input->post('update_stock');
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $i = 0;
        $pid = $this->input->post('pid');
        foreach ($pid as $key => $value) {
            if($value=="0"){
                $product_name1 = $this->input->post('product_name');

                echo json_encode(array('status' => 'Error', 'message' =>
                "Por favor, selecciona un producto de la lista, mas no agregues uno que no existe, el producto con error es el de nombre =<strong> ".$product_name1[$key]." </strong>"));
                exit();   
            }
             
        }
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;
        }
        $this->db->trans_start();
        //products

        //$pid = $this->input->post('pid');
        $productlist = array();
        $prodindex = 0;
        $itc = 0;
        $flag = false;
        if ($tax == 'yes') {
            $textst = 1;

            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $total_discount += $ptotal_disc[$key];
                $total_tax += $ptotal_tax[$key];
                $product_des = $this->input->post('product_description');

                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'qty' => $product_qty[$key],
                    'price' => $product_price[$key],
                    'tax' => $product_tax[$key],
                    'discount' => $product_discount[$key],
                    'subtotal' => $product_subtotal[$key],
                    'totaltax' => $ptotal_tax[$key],
                    'totaldiscount' => $ptotal_disc[$key],
                    'product_des' => $product_des[$key]
                );

                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = intval($product_qty[$key]);

                if ($product_id[$key] > 0) {
                    if ($this->input->post('update_stock') == 'yes') {

                       /* $this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('products');//se debe comentar estas lineas pero para poder subir avances la descomento*/
                    }
                    $itc += $amt;//esto es para contar cuantos items tiene la orden
                }

            }
        } else {
            $textst = 0;
            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description');


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'qty' => $product_qty[$key],
                    'price' => $product_price[$key],
                    'discount' => $product_discount[$key],
                    'subtotal' => $product_subtotal[$key],
                    'totaldiscount' => $ptotal_disc[$key],
                    'product_des' => $product_des[$key]
                );


                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;
                $amt = intval($product_qty[$key]);
                if ($product_id[$key] > 0) {
                    if ($this->input->post('update_stock') == 'yes') {

                        /*$this->db->set('qty', "qty+$amt", FALSE);
                        $this->db->where('pid', $product_id[$key]);
                        $this->db->update('products');//se debe comentar estas lineas pero para poder subir avances la descomento*/
                    }
                }


                $itc += $amt;//esto es para contar cuantos items tiene la orden
            }
        }


        $transok = true;


        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $warehouse = $this->input->post('warehouse');
        $actualizar_stock=$this->input->post('update_stock');
        if($actualizar_stock=="yes"){
            $actualizar_stock="1";
        }else{
            $actualizar_stock="0";
        }//falta hacer el proceso en el lado de la actualzacion de estado
        $data = array(
			'tid' => $invocieno, 
			'invoicedate' => $bill_date, 
			'invoiceduedate' => $bill_due_date, 
			'subtotal' => $subtotal, 
			'shipping' => $shipping, 
			'discount' => $total_discount, 
			'tax' => $total_tax, 'total' => $total, 
			'notes' => $notes, 
			'csd' => $customer_id, 
			'idcat' => $cat,
			'eid' => $this->aauth->get_user()->id, 
			'items' => $itc, 
			'taxstatus' => $textst, 
			'discstatus' => $discstatus, 
			'format_discount' => $discountFormat, 
			'refer' => $refer, 
			'term' => $pterms,
			"almacen_seleccionado"=>$warehouse,
			"actualizar_stock"=>$actualizar_stock);

        if ($flag == true) {
            $this->db->insert_batch('purchase_items', $productlist);
                          $data_h=array();
                            $data_h['modulo']="Orden de Compra";
                            $data_h['accion']="Nueva Orden {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($productlist);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="purchase_items";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);
            if ($this->db->insert('purchase', $data)) {

                            $data_h=array();
                            $data_h['modulo']="Orden de Compra";
                            $data_h['accion']="Nueva Orden {insert}";
                            $data_h['id_usuario']=$this->aauth->get_user()->id;
                            $data_h['fecha']=date("Y-m-d H:i:s");
                            $data_h['descripcion']=json_encode($data);
                            $data_h['id_fila']=$this->db->insert_id();
                            $data_h['tabla']="purchase";
                            $data_h['nombre_columna']="id";
                            $this->db->insert("historial_crm",$data_h);

                echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('Purchase order success')."<a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span>".$this->lang->line('View')." </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
                $transok = false;
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please choose product from product list. Go to Item manager section if you have not added the products."));
            $transok = false;
        }


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }


    }


    public function ajax_list()
    {
		$ttype = $this->input->get('type');
        $list = $this->purchase->get_datatables($ttype);
        $data = array();

        $no = $this->input->post('start');

        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
			$row[] = $invoices->notes;
            $row[] = amountFormat($invoices->total);
			$row[] = $invoices->refer;
            $row[] = '<span class="st-' . $invoices->status . '">' . $invoices->status . '</span>';			
            $row[] = '<a href="' . base_url("purchase/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-eye"></i></a> &nbsp; <a href="' . base_url("purchase/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp';
			if ($this->aauth->get_user()->roleid > 4) { 
			 $row[] = '<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';}

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all(),
            "recordsFiltered" => $this->purchase->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function view()
    {
        $this->load->model('accounts_model');
        $data['acclist'] = $this->accounts_model->accountslist();
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $head['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);
        $data['activity'] = $this->purchase->purchase_transactions($tid);
        $data['attach'] = $this->purchase->attach($tid);
        $data['warehouse'] = $this->purchase->warehouses();
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['employeeaut'] = $this->purchase->employee($data['invoice']['aid']);
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('purchase/view', $data);
        $this->load->view('fixed/footer');

    }
	public function autorizar()
    {
        $idats = $this->input->post('idorden');
        $estado = $this->input->post('estado');
        $autor = $this->aauth->get_user()->id;
		var_dump($idats);
        if ($idats) {
            $this->purchase->aut($idats, $estado, $autor);
        }
    }

    public function printinvoice()
    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['employeeaut'] = $this->purchase->employee($data['invoice']['aid']);
        $data['invoice']['multi'] = 0;

        ini_set('memory_limit', '128M');

        $html = $this->load->view('purchase/view-print-'.LTR, $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #959595; font-weight: bold; font-style: italic;"><tr><td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $tid . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Purchase_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Purchase_#' . $tid . '.pdf', 'I');
        }


    }
	public function recibido()
    {

        $tid = $this->input->get('id');

        $data['id'] = $tid;
        $data['title'] = "Purchase $tid";
        $data['invoice'] = $this->purchase->purchase_details($tid);
        $data['products'] = $this->purchase->purchase_products($tid);
        $data['employee'] = $this->purchase->employee($data['invoice']['eid']);
        $data['invoice']['multi'] = 0;

        ini_set('memory_limit', '128M');

        $html = $this->load->view('purchase/view-print-'.RTL, $data, true);

        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<table width="100%" style="vertical-align: bottom; font-family: serif; font-size: 8pt; color: #959595; font-weight: bold; font-style: italic;"><tr><td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td><td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td><td width="33%" style="text-align: right; ">#' . $tid . '</td></tr></table>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Purchase_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Purchase_#' . $tid . '.pdf', 'I');
        }


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->purchase->purchase_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                "Purchase Order #$id has been deleted successfully!"));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                "There is an error! Purchase has not deleted."));
        }

    }

    public function editaction()
    {

        $customer_id = $this->input->post('customer_id');

        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $cat = $this->input->post('categoria');
        $notes = $this->input->post('notes');
        $tax = $this->input->post('tax_handle');
        $subtotal = $this->input->post('subtotal');
        $shipping = $this->input->post('shipping');
        $refer = $this->input->post('refer');
        $total = $this->input->post('total');
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }
        $pid = $this->input->post('pid');
        foreach ($pid as $key => $value) {
            if($value=="0"){
                $product_name1 = $this->input->post('product_name');

                echo json_encode(array('status' => 'Error', 'message' =>
                "Por favor, selecciona un producto de la lista, mas no agregues uno que no existe, el producto con error es el de nombre =<strong> ".$product_name1[$key]." </strong>"));
                exit();   
            }
             
        }
        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add a new supplier or search from a previous added!"));
            exit;


        }


        $this->db->trans_start();
        $flag = false;
        $transok = true;


        //Product Data
        $pid = $this->input->post('pid');
        $productlist = array();

        $prodindex = 0;

        $this->db->delete('purchase_items', array('tid' => $invocieno));
           $data_h=array();
            $data_h['modulo']="Orden de Compra";
            $data_h['accion']="Edicion del purchase {delete}";
            $data_h['id_usuario']=$this->aauth->get_user()->id;
            $data_h['fecha']=date("Y-m-d H:i:s");
            $data_h['descripcion']="Todos los purchase_items donde tid=".$invocieno;
            $data_h['tabla']="purchase_items";
            $data_h['nombre_columna']="tid";
            $data_h['id_fila']=$invocieno;
            $this->db->insert("historial_crm",$data_h);
        if ($tax == 'yes') {
            $taxstatus = 1;

            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = $this->input->post('old_product_qty');
                if ($old_product_qty == '') $old_product_qty = 0;
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $total_discount += $ptotal_disc[$key];
                $total_tax += $ptotal_tax[$key];
                $product_des = $this->input->post('product_description');


                $data = array(
                    'tid' => $invocieno,
                    'pid' => $product_id[$key],
                    'product' => $product_name1[$key],
                    'qty' => $product_qty[$key],
                    'price' => $product_price[$key],
                    'tax' => $product_tax[$key],
                    'discount' => $product_discount[$key],
                    'subtotal' => $product_subtotal[$key],
                    'totaltax' => $ptotal_tax[$key],
                    'totaldiscount' => $ptotal_disc[$key],
                    'product_des' => $product_des[$key]
                );


                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;

                if ($this->input->post('update_stock') == 'yes') {
                    $amt = intval($product_qty[$key]) - @intval($old_product_qty[$key]);
                    /*$this->db->set('qty', "qty+$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('products');*/
                }
                $flag = true;

            }
        } else {
            $taxstatus = 0;
            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = $this->input->post('old_product_qty');
                if ($old_product_qty == '') $old_product_qty = 0;
                $product_price = $this->input->post('product_price');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $product_des = $this->input->post('product_description');
                $ptotal_disc = $this->input->post('disca');
                $total_discount += $ptotal_disc[$key];


                $data = array(
                    'tid' => $invocieno,
                    'product' => $product_name1,
                    'qty' => $product_qty,
                    'price' => $product_price,
                    'discount' => $product_discount,
                    'subtotal' => $product_subtotal,
                    'product_des' => $product_des[$key]
                );


                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;

                if ($this->input->post('update_stock') == 'yes') {
                    $amt = intval($product_qty[$key]) - intval($old_product_qty[$key]);
                    /*$this->db->set('qty', "qty+$amt", FALSE);
                    $this->db->where('pid', $product_id[$key]);
                    $this->db->update('products');*/
                }
                $flag = true;

            }
        }

        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $warehouse = $this->input->post('warehouse');
        $actualizar_stock=$this->input->post('update_stock');
        if($actualizar_stock=="yes"){
            $actualizar_stock="1";
        }else{
            $actualizar_stock="0";
        }
        

        $data = array(
			'invoicedate' => $bill_date, 
			'invoiceduedate' => $bill_due_date, 
			'subtotal' => $subtotal, 
			'shipping' => $shipping, 
			'discount' => $total_discount, 
			'tax' => $total_tax, 
			'total' => $total, 
			'notes' => $notes, 
			'csd' => $customer_id, 
			'idcat' => $cat, 
			'items' => $i, 
			'taxstatus' => $taxstatus, 
			'discstatus' => $discstatus, 
			'format_discount' => $discountFormat, 
			'refer' => $refer, 
			'term' => $pterms,
			"almacen_seleccionado"=>$warehouse,
			"actualizar_stock"=>$actualizar_stock);
        $this->db->set($data);
        $this->db->where('tid', $invocieno);

        if ($flag) {

            if ($this->db->update('purchase', $data)) {
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Edicion del purchase {update}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode($data);
                    $data_h['id_fila']=$invocieno;
                    $data_h['tabla']="purchase";
                    $data_h['nombre_columna']="id";
                    
                $this->db->insert_batch('purchase_items', $productlist);
                    $data_h=array();
                    $data_h['modulo']="Orden de Compra";
                    $data_h['accion']="Edicion del purchase {insert}";
                    $data_h['id_usuario']=$this->aauth->get_user()->id;
                    $data_h['fecha']=date("Y-m-d H:i:s");
                    $data_h['descripcion']=json_encode($productlist);
                    $data_h['tabla']="purchase_items";
                    $data_h['nombre_columna']="id";
                    $data_h['id_fila']=$this->db->insert_id();;
                    $this->db->insert("historial_crm",$data_h);
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Purchase order has  been updated successfully! <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> View </a> "));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    "There is a missing field!"));
                $transok = false;
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add atleast one product in order!"));
            $transok = false;
        }

        /*if ($this->input->post('update_stock') == 'yes') {
            if ($this->input->post('restock')) {
                foreach ($this->input->post('restock') as $key => $value) {


                    $myArray = explode('-', $value);
                    $prid = $myArray[0];
                    $dqty = $myArray[1];
                    if ($prid > 0) {

                        $this->db->set('qty', "qty-$dqty", FALSE);
                        $this->db->where('pid', $prid);
                        $this->db->update('products');
                    }
                }


            }
        }*/


        if ($transok) {
            $this->db->trans_complete();
        } else {
            $this->db->trans_rollback();
        }
    }

    public function update_status()
    {
        $tid = $this->input->post('tid');
        $status = $this->input->post('status');
        if($status=="recibido" || $status=="recibido parcial"){
            $errores=false;
            $txt_errores="";
            $almacen = $this->input->post('almacen');
            $update_stock = $this->input->post('update_stock');
            if($update_stock=="yes"){

                if($almacen=="0" || $almacen==0){
                    
                     $this->db->set('status', "recibido");                     
                     $this->db->where('tid', $tid);
                     $this->db->update('purchase');
                        $data_h=array();
                        $data_h['modulo']="Orden de Compra";
                        $data_h['accion']="Cambiar Estado {update}";
                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                        $data_h['fecha']=date("Y-m-d H:i:s");
                        $data_h['descripcion']="recibido";
                        $data_h['id_fila']=$tid;
                        $data_h['tabla']="purchase";
                        $data_h['nombre_columna']="tid";
                        $this->db->insert("historial_crm",$data_h);

                }else{

                    $lista_productos=$this->db->get_where("purchase_items",array("tid"=>$tid))->result_array();
                    $pasar_a_recivido=true;
                    foreach ($lista_productos as $key => $pr1) {
                        $cantidad_a_pasar = $this->input->post('sl-pr-'.$pr1['id']);

                        $nombre_pr=mb_strtolower( str_replace(" ","",$pr1['product']),'UTF-8');
                        $productos=$this->db->query("SELECT * FROM products WHERE REPLACE(lower(product_name),' ','') LIKE '%".$nombre_pr."%' and warehouse='".$almacen."'")->result_array();
                        if(count($productos)==0){
                            $product=$this->db->get_where("products",array("pid"=>$pr1['pid']))->row();
                            $data=array();
                            $data['pcat']=$product->pcat;
                            $data['warehouse']=$almacen;
                            $data['sede']=0;
                            $data['product_name']=$product->product_name;
                            $data['product_code']=$product->product_code;
                            $data['product_price']=$product->product_price;
                            $data['fproduct_price']=$product->fproduct_price;
                            $data['fproduct_price']=$product->fproduct_price;
                            $data['taxrate']=$product->taxrate;
                            $data['disrate']=$product->disrate;
                            $data['qty']=$cantidad_a_pasar;
                            $data['product_des']=$product->product_des;
                            $data['alert']=$product->alert;
                            if($cantidad_a_pasar!=0){
                                $this->db->insert("products",$data);
                                        $data_h=array();
                                        $data_h['modulo']="Orden de Compra";
                                        $data_h['accion']="Cambiar Estado {insert}";
                                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                                        $data_h['fecha']=date("Y-m-d H:i:s");
                                        $data_h['descripcion']=json_encode($data);
                                        $data_h['id_fila']=$this->db->insert_id();;
                                        $data_h['tabla']="products";
                                        $data_h['nombre_columna']="pid";
                                        $this->db->insert("historial_crm",$data_h);
                            }

                        }else{
                            $data=array();
                            $data['qty']=$productos[0]['qty']+$cantidad_a_pasar;
                            $this->db->update("products",$data,array("pid"=>$productos[0]['pid']));

                                     $data_h=array();
                                        $data_h['modulo']="Orden de Compra";
                                        $data_h['accion']="Cambiar Estado {update}";
                                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                                        $data_h['fecha']=date("Y-m-d H:i:s");
                                        $data_h['descripcion']=json_encode($data);
                                        $data_h['id_fila']=$productos[0]['pid'];
                                        $data_h['tabla']="products";
                                        $data_h['nombre_columna']="pid";
                                        $this->db->insert("historial_crm",$data_h);
                        }
                        if($pr1['qty_en_almacen']==null || $pr1['qty_en_almacen']=='null'){
                            $pr1['qty_en_almacen']==0;
                        }
                        $pr1['qty_en_almacen']=$pr1['qty_en_almacen']+$cantidad_a_pasar;
                        if($pr1['qty_en_almacen']!=$pr1['qty']){
                            $pasar_a_recivido=false;
                        }
                        $this->db->update("purchase_items",array("qty_en_almacen"=>$pr1['qty_en_almacen']),array("id"=>$pr1['id']));
                                        $data_h=array();
                                        $data_h['modulo']="Orden de Compra";
                                        $data_h['accion']="Cambiar Estado {update}";
                                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                                        $data_h['fecha']=date("Y-m-d H:i:s");
                                        $data_h['descripcion']=json_encode(array("qty_en_almacen"=>$pr1['qty_en_almacen']));
                                        $data_h['id_fila']=$pr1['id'];
                                        $data_h['tabla']="purchase_items";
                                        $data_h['nombre_columna']="id";
                                        $this->db->insert("historial_crm",$data_h);
                    }
                    if($pasar_a_recivido){
                        $status="recibido";
                    }
                     $this->db->set('status', $status);
                     $this->db->set('almacen_seleccionado', $almacen);
                     if($update_stock=="yes"){
                        $update_stock=1;
                     }else{
                        $update_stock=0;
                     }
                     $this->db->set('actualizar_stock', $update_stock);
                     $this->db->where('tid', $tid);
                     $this->db->update('purchase');

                                        $data_h=array();
                                        $data_h['modulo']="Orden de Compra";
                                        $data_h['accion']="Cambiar Estado {update}";
                                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                                        $data_h['fecha']=date("Y-m-d H:i:s");
                                        $data_h['descripcion']="actualizar_stock=".$update_stock." almacen_seleccionado=".$almacen." status=".$status ;
                                        $data_h['id_fila']=$tid;
                                        $data_h['tabla']="purchase";
                                        $data_h['nombre_columna']="tid";
                                        $this->db->insert("historial_crm",$data_h);

                }

            }

            if($errores){
                echo json_encode(array('status' => 'Error-Recibido', 'message' =>
                '<ul>'.$txt_errores.'</ul>', 'pstatus' => $status));    
            }else{

                echo json_encode(array('status' => 'Success', 'message' =>
                'Purchase Order Status updated successfully!', 'pstatus' => $status));
            }

            
        }else{
            $this->db->set('status', $status);
            $this->db->where('tid', $tid);
            $this->db->update('purchase');
                                        $data_h=array();
                                        $data_h['modulo']="Orden de Compra";
                                        $data_h['accion']="Cambiar Estado {update}";
                                        $data_h['id_usuario']=$this->aauth->get_user()->id;
                                        $data_h['fecha']=date("Y-m-d H:i:s");
                                        $data_h['descripcion']="status=".$status ;
                                        $data_h['id_fila']=$tid;
                                        $data_h['tabla']="purchase";
                                        $data_h['nombre_columna']="tid";
                                        $this->db->insert("historial_crm",$data_h);

            echo json_encode(array('status' => 'Success', 'message' =>
            'Purchase Order Status updated successfully!', 'pstatus' => $status));

            

        }

        
        
    }

    public function file_handling()
    {
        if($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->purchase->meta_delete($invoice,4, $name)){
                echo json_encode(array('status' => 'Success'));
            }
        }
        else {
            $id = $this->input->get('id');
            $comp = $this->input->get('comprobante');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {
                $this->purchase->meta_insert($id, 4, $files, $comp,'');
            }
        }


    }
	public function historial_ord()
	{
		$head['title'] = "Historial CRM";
		$head['usernm'] = $this->aauth->get_user()->username;
		$this->load->view('fixed/header', $head);
			$this->load->view('purchase/historial_ord');
		$this->load->view('fixed/footer');
	}
	public function explortar_his_ord(){
		set_time_limit(20000);
        //$this->load->model('customers_model', 'customers');
		$this->db->select('*');
        $this->db->from('historial_crm');
		$this->db->where('modulo', 'Orden de Compra');
		if($_GET['tecnico']!='' && $_GET['tecnico']!='0' && $_GET['tecnico']!='undefined'){
         		$this->db->where('responsable=', $_GET['tecnico']);
        }
		if($_GET['tipo']!='' && $_GET['tipo']!='0' && $_GET['tipo']!='undefined'){
         $this->db->where('tllamada=', $_GET['tipo']);   
        }
        if($_GET['filtro_fecha']!='' && $_GET['filtro_fecha']!='undefined'){
            if($_GET['filtro_fecha']=='fcreada'){
            $fecha_incial= new DateTime($_GET['sdate']);
            $fecha_final= new DateTime($_GET['edate']);
         	$this->db->where('fecha>=', $fecha_incial->format("Y-m-d"));   
			$this->db->where('fecha<=', $fecha_final->format("Y-m-d"));
			} if($_GET['filtro_fecha']=='fecha_final'){
				$fecha_incial2= new DateTime($_GET['sdatefin']);
            	$fecha_final2= new DateTime($_GET['edatefin']);
         		$this->db->where('fecha_vence>=', $fecha_incial2->format("Y-m-d"));   
         		$this->db->where('fecha_vence<=', $fecha_final2->format("Y-m-d"));
			}
        }
		//$this->db->join('aauth_users', 'aauth_users.id=id_usuario', 'left');
        $this->db->order_by("id","DESC");
        $lista_historial=$this->db->get()->result();
        $this->load->library('Excel');
		$lista_historial2=array();
		
    
    //define column headers
    $headers = array(
        'id' => 'string', 
        'accion' => 'string',
		'fecha' => 'string',
		'Realizado' => 'string',
		'descripcion' => 'string'
	);
    
    //fetch data from database
    //$salesinfo = $this->product_model->get_salesinfo();
    
    //create writer object
    $writer = new Excel();
    
        //meta data info
    $keywords = array('xlsx','CUSTOMERS','VESTEL');
    $writer->setTitle('Reporte historial');
    $writer->setSubject('');
    $writer->setAuthor('VESTEL');
    $writer->setCompany('VESTEL');
    $writer->setKeywords($keywords);
    $writer->setDescription('Reporte historial');
    $writer->setTempDir(sys_get_temp_dir());
    
    //write headers el primer campo que es nombre de la hoja de excel deve de coincidir en writeSheetHeader y writeSheetRow para tener en cuenta si se piensan agregar otras hojas o algo por el estilo
    $writer->writeSheetHeader('Historial ',$headers,$col_options = array(

		['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
		['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
		['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
		['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
		['font'=>'Arial','font-style'=>'bold','font-size'=>'12',"fill"=>"#BDD7EE",'halign'=>'center'],
		));
    
    //write rows to sheet1
	
    foreach ($lista_historial as $key => $historial) {
				$user = $this->db->get_where('aauth_users',array('id'=>$historial->id_usuario))->row();
				$fecha = date("d/m/Y",strtotime($historial->fecha));
					$writer->writeSheetRow('Historial ',array(
						$historial->id,
						$historial->accion,
						$fecha,
						$user->username,
						$historial->descripcion,
					));
        
    }
        
        
    
    $fecha_actual= date("d-m-Y");
    $dia= date("N");
    $this->load->model('reports_model', 'reports');
    $fecha_actual=$this->reports->obtener_dia($dia)." ".$fecha_actual;
    $fileLocation = 'Historial '.$fecha_actual.'.xlsx';
    
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


}