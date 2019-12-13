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

class Quote extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('quote_model', 'quote');
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
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);
        $data['currency'] = $this->quote->currencies();
        $data['customergrouplist'] = $this->customers->group_list();
        $data['lastinvoice'] = $this->quote->lastquote();
        $data['terms'] = $this->quote->billingterms();
        $head['title'] = "New Quote";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->quote->warehouses();
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/newquote', $data);
        $this->load->view('fixed/footer');
    }

    //edit invoice
    public function edit()
    {
        $this->load->model('customers_model', 'customers');
        $data['customergrouplist'] = $this->customers->group_list();
        $tid = intval($this->input->get('id'));
        $data['id'] = $tid;
        $data['title'] = "Quote $tid";
        $data['terms'] = $this->quote->billingterms();
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
        $data['currency'] = $this->quote->currencies();
        $head['title'] = "Edit Quote #$tid";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['warehouse'] = $this->quote->warehouses();
        $this->load->model('plugins_model', 'plugins');
        $data['exchange'] = $this->plugins->universal_api(5);


        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/edit', $data);
        $this->load->view('fixed/footer');

    }

    //invoices list
    public function index()
    {
        $head['title'] = "Manage Quote";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/quotes');
        $this->load->view('fixed/footer');
    }

    //action
    public function action()
    {

        $customer_id = $this->input->post('customer_id');
        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
        $notes = $this->input->post('notes');
        $tax = $this->input->post('tax_handle');
        $subtotal = $this->input->post('subtotal');
        $shipping = $this->input->post('shipping');
        $refer = $this->input->post('refer');
        $total = $this->input->post('total');
        $proposal = $this->input->post('propos');
        $total_tax = 0;
        $total_discount = 0;
        $discountFormat = $this->input->post('discountFormat');
        $pterms = $this->input->post('pterms');
        $currency = $this->input->post('mcurrency');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new client')));
            exit;
        }
        $this->db->trans_start();
        //products

        $pid = $this->input->post('pid');
        $productlist = array();
        $prodindex = 0;
        $itc = 0;
        $flag = false;
        if ($tax == 'yes') {

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
                $product_des = $this->input->post('product_description');
                $total_discount += $ptotal_disc[$key];
                $total_tax += $ptotal_tax[$key];

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

                $itc += $amt;

            }
        } else {

            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');

                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $product_price = $this->input->post('product_price');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description');
                $total_discount += $ptotal_disc[$key];


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

                //stock
                $amt = intval($product_qty[$key]);


                $itc += $amt;
            }
        }


        $transok = true;


        //Invoice Data
        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);
        $data = array('tid' => $invocieno, 'invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'eid' => $this->aauth->get_user()->id, 'items' => $itc, 'taxstatus' => 1, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'proposal' => $proposal, 'multi' => $currency);

        if ($flag == true) {
            $this->db->insert_batch('quotes_items', $productlist);
            if ($this->db->insert('quotes', $data)) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Quote has  been created') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> View </a>"));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
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

        $list = $this->quote->get_datatables();
        $data = array();

        $no = $this->input->post('start');


        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = dateformat($invoices->invoicedate);
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("quote/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> ' . $this->lang->line('View') . '</a> &nbsp; <a href="' . base_url("quote/printquote?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->quote->count_all(),
            "recordsFiltered" => $this->quote->count_filtered(),
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
        $head['title'] = "Quote $tid";
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
        $data['attach'] = $this->quote->attach($tid);


        $data['employee'] = $this->quote->employee($data['invoice']['eid']);

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('quotes/view', $data);
        $this->load->view('fixed/footer');

    }


    public function printquote()
    {

        $tid = intval($this->input->get('id'));

        $data['id'] = $tid;
        $data['title'] = "Quote $tid";
        $data['invoice'] = $this->quote->quote_details($tid);
        $data['products'] = $this->quote->quote_products($tid);
        $data['employee'] = $this->quote->employee($data['invoice']['eid']);

        ini_set('memory_limit', '64M');

        $html = $this->load->view('quotes/view-print-'.LTR, $data, true);


        //PDF Rendering
        $this->load->library('pdf');

        $pdf = $this->pdf->load();

        $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

        $pdf->WriteHTML($html);

        if ($this->input->get('d')) {

            $pdf->Output('Quote_#' . $tid . '.pdf', 'D');
        } else {
            $pdf->Output('Quote_#' . $tid . '.pdf', 'I');
        }


    }

    public function delete_i()
    {
        $id = $this->input->post('deleteid');

        if ($this->quote->quote_delete($id)) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('DELETED')));

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editaction()
    {

        $customer_id = $this->input->post('customer_id');

        $invocieno = $this->input->post('invocieno');
        $invoicedate = $this->input->post('invoicedate');
        $invocieduedate = $this->input->post('invocieduedate');
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
        $propos = $this->input->post('propos');
        $currency = $this->input->post('mcurrency');
        $i = 0;
        if ($discountFormat == '0') {
            $discstatus = 0;
        } else {
            $discstatus = 1;
        }

        if ($customer_id == 0) {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('Please add a new client')));
            exit;


        }


        $this->db->trans_start();
        $flag = false;
        $transok = true;


        //Product Data
        $pid = $this->input->post('pid');
        $productlist = array();

        $prodindex = 0;

        $this->db->delete('quotes_items', array('tid' => $invocieno));
        if ($tax == 'yes') {
            $taxstatus = 1;

            foreach ($pid as $key => $value) {

                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = intval($this->input->post('old_product_qty'));
                $product_price = $this->input->post('product_price');
                $product_tax = $this->input->post('product_tax');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $ptotal_tax = $this->input->post('taxa');
                $ptotal_disc = $this->input->post('disca');
                $product_des = $this->input->post('product_description');
                $total_discount += $ptotal_disc[$key];
                $total_tax += $ptotal_tax[$key];

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


            }
        } else {
            $taxstatus = 0;
            foreach ($pid as $key => $value) {
                $product_id = $this->input->post('pid');
                $product_name1 = $this->input->post('product_name');
                $product_qty = $this->input->post('product_qty');
                $old_product_qty = $this->input->post('old_product_qty');
                $product_price = $this->input->post('product_price');
                $product_discount = $this->input->post('product_discount');
                $product_subtotal = $this->input->post('product_subtotal');
                $product_des = $this->input->post('product_description');


                $data = array(
                    'tid' => $invocieno,
                    'product' => $product_name1,
                    'qty' => $product_qty,
                    'price' => $product_price,
                    'discount' => $product_discount,
                    'subtotal' => $product_subtotal,
                    'product_des' => $product_des[$key]
                );


                $flag = true;
                $productlist[$prodindex] = $data;
                $i++;
                $prodindex++;


            }
        }

        $bill_date = datefordatabase($invoicedate);
        $bill_due_date = datefordatabase($invocieduedate);

        $data = array('invoicedate' => $bill_date, 'invoiceduedate' => $bill_due_date, 'subtotal' => $subtotal, 'shipping' => $shipping, 'discount' => $total_discount, 'tax' => $total_tax, 'total' => $total, 'notes' => $notes, 'csd' => $customer_id, 'items' => $i, 'taxstatus' => $taxstatus, 'discstatus' => $discstatus, 'format_discount' => $discountFormat, 'refer' => $refer, 'term' => $pterms, 'proposal' => $propos, 'multi' => $currency);
        $this->db->set($data);
        $this->db->where('tid', $invocieno);

        if ($flag) {

            if ($this->db->update('quotes', $data)) {
                $this->db->insert_batch('quotes_items', $productlist);
                echo json_encode(array('status' => 'Success', 'message' =>
                    $this->lang->line('Quote has  been updated') . " <a href='view?id=$invocieno' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> View </a> "));
            } else {
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('ERROR')));
                $transok = false;
            }


        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please add atleast one product in invoice $invocieno"));
            $transok = false;
        }


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


        $this->db->set('status', $status);
        $this->db->where('tid', $tid);
        $this->db->update('quotes');

        echo json_encode(array('status' => 'Success', 'message' =>
            $this->lang->line('Quote Status updated') . '', 'pstatus' => $status));
    }

    public function convert()
    {
        $tid = $this->input->post('tid');


        if ($this->quote->convert($tid)) {

            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('Quote to invoice conversion')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }
    }

    public function file_handling()
    {
        if($this->input->get('op')) {
            $name = $this->input->get('name');
            $invoice = $this->input->get('invoice');
            if ($this->quote->meta_delete($invoice,2, $name)){
                echo json_encode(array('status' => 'Success'));
            }
        }
        else {
            $id = $this->input->get('id');
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            $files = (string)$this->uploadhandler_generic->filenaam();
            if ($files != '') {
                $fid = rand(100, 9999);
                $this->quote->meta_insert($id, 2, $files);
            }
        }


    }


}