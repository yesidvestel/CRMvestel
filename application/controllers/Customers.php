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
        if ($this->aauth->get_user()->roleid < 3) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }

    public function index()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Customers';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/clist');
        $this->load->view('fixed/footer');
    }

    public function create()
    {

        $data['customergrouplist'] = $this->customers->group_list();
				
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Create Customer';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/create', $data);
        $this->load->view('fixed/footer');
    }

    public function view()
    {

        $custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);
        $data['customergroup'] = $this->customers->group_info($data['details']['gid']);
        $data['money'] = $this->customers->money_details($custid);
        $data['due'] = $this->customers->due_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['activity']=$this->customers->activity($custid);
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
            $row[] = '<a href="customers/view?id=' . $customers->id . '">' . $customers->name . '</a>';
            $row[] = $customers->address . ',' . $customers->city . ',' . $customers->country;
            $row[] = $customers->email;
            $row[] = $customers->phone;
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

    //edit section
    public function edit()
    {
        $pid = $this->input->get('id');

        $data['customer'] = $this->customers->details($pid);
        $data['customergroup'] = $this->customers->group_info($data['customer']['gid']);
        $data['customergrouplist'] = $this->customers->group_list();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Edit Customer';
        $this->load->view('fixed/header', $head);
        $this->load->view('customers/edit', $data);
        $this->load->view('fixed/footer');

    }

    public function addcustomer()
    {
        $name = $this->input->post('name');
        $company = $this->input->post('company');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $region = $this->input->post('region');
        $country = $this->input->post('country');
        $postbox = $this->input->post('postbox');
        $taxid = $this->input->post('taxid');
        $customergroup = $this->input->post('customergroup');
        $name_s = $this->input->post('name_s');
        $phone_s = $this->input->post('phone_s');
        $email_s = $this->input->post('email_s');
        $address_s = $this->input->post('address_s');
        $city_s = $this->input->post('city_s');
        $region_s = $this->input->post('region_s');
        $country_s = $this->input->post('country_s');
        $postbox_s = $this->input->post('postbox_s');
        $this->customers->add($name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s);

    }

    public function editcustomer()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $company = $this->input->post('company');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $region = $this->input->post('region');
        $country = $this->input->post('country');
        $postbox = $this->input->post('postbox');
        $customergroup = $this->input->post('customergroup');
        $taxid = $this->input->post('taxid');
        $name_s = $this->input->post('name_s');
        $phone_s = $this->input->post('phone_s');
        $email_s = $this->input->post('email_s');
        $address_s = $this->input->post('address_s');
        $city_s = $this->input->post('city_s');
        $region_s = $this->input->post('region_s');
        $country_s = $this->input->post('country_s');
        $postbox_s = $this->input->post('postbox_s');
        if ($id) {
            $this->customers->edit($id, $name, $company, $phone, $email, $address, $city, $region, $country, $postbox, $customergroup, $taxid, $name_s, $phone_s, $email_s, $address_s, $city_s, $region_s, $country_s, $postbox_s);
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
            $row[] = $this->lang->line($prd->method);

            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span>  '.$this->lang->line('View').'</a> <a href="#" data-object-id="' . $pid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-bin"></span>  '.$this->lang->line('Delete').'</a>';
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

    public function inv_list()
    {

		$cid = $this->input->post('cid');
        $list = $this->customers->inv_datatables($cid);
        $data = array();

        $no = $this->input->post('start');
        foreach ($list as $invoices) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $invoices->tid;
            $row[] = $invoices->name;
            $row[] = $invoices->invoicedate;
            $row[] = amountFormat($invoices->total);
            $row[] = '<span class="st-' . $invoices->status . '">' . $this->lang->line(ucwords($invoices->status)) . '</span>';
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> '.$this->lang->line('View').'</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-object-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-object"><span class="icon-trash"></span></a>';

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

    public function invoices()
    {

		$custid = $this->input->get('id');
        $data['details'] = $this->customers->details($custid);

        $data['money'] = $this->customers->money_details($custid);
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'View Customer Invoices';
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


}