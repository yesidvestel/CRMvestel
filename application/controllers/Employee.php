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

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model', 'employee');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>¡Lo siento! No tiene permisos suficientes para acceder a esta sección</h3>');

        }
    }
public function codigo_generar_inserts_permisos(){
    $users=$this->db->get_where("aauth_users")->result_array();
    $lista_de_modulos=$this->db->get_where("modulos")->result_array();
    foreach ($users as $key => $user) {
        
        foreach ($lista_de_modulos as $key2 => $mod) {
            $data_insert=array();
            $data_insert['id_modulo']=$mod['id_modulo'];
            $data_insert['id_usuario']=$user['id'];
            $data_insert['is_checked']=$user[$mod['codigo']];
            var_dump($data_insert);
            echo "<br>";    
            $this->db->insert("permisos_usuario",$data_insert);
        }
    }
}
    public function index()
    {
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employees List';
        $data['employee'] = $this->employee->list_employee();
        $data['modulos_padre']=$this->employee->get_modulos_padres();
        //$data['modulos_usuario']=$this->employee->get_modulos_cliente($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/list', $data);
        $this->load->view('fixed/footer');
    }
    public function get_permios_employe(){
            $lista=$this->employee->get_modulos_cliente($_POST['id']);
            echo json_encode($lista);
    }


    public function view()
    {
		$this->load->model('customers_model', 'customers');
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Details';
        $data['employee'] = $this->employee->employee_details($id);
		$data['attach'] = $this->customers->attach($id,35);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/view', $data);
        $this->load->view('fixed/footer');

    }


    public function add()
    {

        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Add Employee';
		$this->load->model('customers_model', 'customers');
		$data['modulos_padre']=$this->employee->get_modulos_padres();
		$data['customergrouplist'] = $this->customers->group_list();
		$data['area'] = $this->employee->employee_arealist('');
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/add',$data);
        $this->load->view('fixed/footer');


    }

    public function submit_user()
    {
        if ($this->aauth->get_user()->roleid < 4) {
            redirect('/dashboard/', 'refresh');
        }

        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $roleid = 3;
        if ($this->input->post('roleid')) {
            $roleid = $this->input->post('roleid');

        }

        if ($roleid > 3) {
            if ($this->aauth->get_user()->roleid < 5) {
                die('No! Permission');
            }
        }


        $name = $this->input->post('name');
		$dto = $this->input->post('documento');
		$ingreso = date("Y-m-d",strtotime($this->input->post('ingreso')));
		$rh = $this->input->post('rh');
		$eps = $this->input->post('eps');
		$pensiones = $this->input->post('pensiones');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $region = $this->input->post('region');
        $country = $this->input->post('country');
        $area = $this->input->post('area');
        $sede = $this->input->post('sede_accede');
        $a = $this->aauth->create_user($email, $password, $username);

            $data_perms=array();
            $lista_permisos=$this->employee->get_modulos_add();
            foreach ($lista_permisos as $key => $per) {
                    $data_perms[$per->codigo]=array("valor"=>$this->input->post($per->codigo),"id_modulo"=>$per->id_modulo);
            }
         

        if ((string)$this->aauth->get_user($a)->id != $this->aauth->get_user()->id) {
            $nuid = (string)$this->aauth->get_user($a)->id;

            if ($nuid > 0) {


                $this->employee->add_employee(
					$nuid, (string)$this->aauth->get_user($a)->username, 
					$name,$dto,$ingreso,$rh,$eps,$pensiones, 
					$roleid, $sede, $phone, $address, $city, 
					$region, $country,$area,$data_perms);

            }

        } else {

            echo json_encode(array('status' => 'Error', 'message' =>
                'There has been an error, please try again.'));
        }
    }

    public function invoices()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Invoices';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/invoices', $data);
        $this->load->view('fixed/footer');
    }

    public function invoices_list()
    {

        $eid = $this->input->post('eid');
        $list = $this->employee->invoice_datatables($eid);
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
            switch ($invoices->status) {
                case "paid" :
                    $out = '<span class="label label-success">Paid</span> ';
                    break;
                case "due" :
                    $out = '<span class="label label-danger">Due</span> ';
                    break;
                case "canceled" :
                    $out = '<span class="label label-warning">Canceled</span> ';
                    break;
                case "partial" :
                    $out = '<span class="label label-primary">Partial</span> ';
                    break;
                default :
                    $out = '<span class="label label-info">Pending</span> ';
                    break;
            }
            $row[] = $out;
            $row[] = '<a href="' . base_url("invoices/view?id=$invoices->tid") . '" class="btn btn-success btn-xs"><i class="icon-file-text"></i> View</a> &nbsp; <a href="' . base_url("invoices/printinvoice?id=$invoices->tid") . '&d=1" class="btn btn-info btn-xs"  title="Download"><span class="icon-download"></span></a>&nbsp; &nbsp;<a href="#" data-invoice-id="' . $invoices->tid . '" class="btn btn-danger btn-xs delete-invoice" title="Delete"><i class="icon-trash-o"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->invoicecount_all($eid),
            "recordsFiltered" => $this->employee->invoicecount_filtered($eid),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);

    }

    public function transactions()
    {
        $id = $this->input->get('id');
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Employee Transactions';
        $data['employee'] = $this->employee->employee_details($id);
        $data['eid'] = intval($id);
        $this->load->view('fixed/header', $head);
        $this->load->view('employee/transactions', $data);
        $this->load->view('fixed/footer');
    }

    public function translist()
    {
        $eid = $this->input->post('eid');
        $list = $this->employee->get_datatables($eid);
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $prd) {
            $no++;
            $row = array();
            $pid = $prd->id;
            $row[] = $prd->date;
            $row[] = $prd->account;
            $row[] = amountFormat($prd->debit);
            $row[] = amountFormat($prd->credit);

            $row[] = $prd->payer;
            $row[] = $prd->method;
            $row[] = '<a href="' . base_url() . 'transactions/view?id=' . $pid . '" class="btn btn-primary btn-xs"><span class="icon-eye"></span> View</a> <a data-item-id="' . $pid . '" class="btn btn-danger btn-xs delete-transaction"><span class="icon-bin"></span>Delete</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->employee->count_all(),
            "recordsFiltered" => $this->employee->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    function disable_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('deleteid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not disable yourself!'));
        } else {


            $a = $this->aauth->ban_user($uid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile disabled successfully!'));


        }
    }

    function delete_user()
    {
        if (!$this->aauth->get_user()->roleid == 5) {
            redirect('/dashboard/', 'refresh');
        }
        $uid = intval($this->input->post('empid'));

        $nuid = intval($this->aauth->get_user()->id);

        if ($nuid == $uid) {
            echo json_encode(array('status' => 'Error', 'message' =>
                'You can not delete yourself!'));
        } else {

            $this->db->delete('employee_profile', array('id' => $uid));

            $this->db->delete('aauth_users', array('id' => $uid));

            echo json_encode(array('status' => 'Success', 'message' =>
                'User Profile deleted successfully! Please refresh the page!'));


        }
    }


    public function calc_income()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->money_details($eid)) {
            $details = $this->employee->money_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                '<br> Total Income: ' . $details['credit'] . '<br> Total Expenses: ' . $details['debit']));

        }


    }

    public function calc_sales()
    {
        $eid = $this->input->post('eid');

        if ($this->employee->sales_details($eid)) {
            $details = $this->employee->sales_details($eid);

            echo json_encode(array('status' => 'Success', 'message' =>
                'Total Sales (Paid Payment):  ' . $details['total']));

        }


    }

    public function update()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');
        $this->load->model('customers_model', 'customers');

        if ($this->input->post()) {
            $eid = $this->input->post('eid');
            $name = $this->input->post('name');
			$dto = $this->input->post('documento');
			$ingreso = date("Y-m-d",strtotime($this->input->post('ingreso')));
			$rh = $this->input->post('rh');
			$eps = $this->input->post('eps');
			$pensiones = $this->input->post('pensiones');
            $phone = $this->input->post('phone');
            $phonealt = $this->input->post('phonealt');
            $address = $this->input->post('address');
            $city = $this->input->post('city');
            $region = $this->input->post('region');
            $country = $this->input->post('country');
            $area = $this->input->post('area');
			$roleid = $this->input->post('roleid');
			$sedeadd = $this->input->post('sede_accede');
            $data_perms=array();
            $lista_permisos=$this->employee->get_modulos_cliente2($eid);
            foreach ($lista_permisos as $key => $per) {
                    $data_perms[$per->codigo]=array("valor"=>$this->input->post($per->codigo),"id_permiso"=>$per->id);
            }
            $this->employee->update_employee(
				$eid, $name,$dto,$ingreso,$rh,$eps,$pensiones, 
				$phone, $phonealt, $address, $city, $region, $country,$area,
				$roleid, $sedeadd, $data_perms);

        } else {
            $head['usernm'] = $this->aauth->get_user($id)->username;
            $head['title'] = $head['usernm'] . ' Profile';
			

            $data['user'] = $this->employee->employee_details($id);
			$data['customergrouplist'] = $this->customers->group_list();
            $data['area'] = $this->employee->employee_arealist($data['user']['area']);
            $data['get_area'] = $this->employee->employee_area($data['user']['area']);
            $data['sede'] = $this->employee->group_detail($data['user']['sede_accede']);
            $data['eid'] = intval($id);
            $data['modulos_padre']=$this->employee->get_modulos_padres();
            $data['modulos_usuario']=$this->employee->get_modulos_cliente($id);
            $tdx=$data['user']['sede_accede'];
            $tdx=explode(",", $tdx);
            $str1="";
            foreach ($tdx as $k1 => $vl1) {
                $str1.="'".$vl1."',";
            }
            $data['str1']=$str1;
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/edit', $data);
            $this->load->view('fixed/footer');
        }


    }


    public function displaypic()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editpicture($id, $img);
        }


    }


    public function user_sign()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }


        $this->load->model('employee_model', 'employee');
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/employee_sign/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->employee->editsign($id, $img);
        }


    }


    public function updatepassword()
    {

        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library("form_validation");

        $id = $this->input->get('id');
        $this->load->model('employee_model', 'employee');


        if ($this->input->post()) {
            $eid = $this->input->post('eid');
            $this->form_validation->set_rules('newpassword', 'Password', 'required');
            $this->form_validation->set_rules('renewpassword', 'Confirm Password', 'required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('status' => 'Error', 'message' => '<br>Rules<br> Password length should  be at least 6 [a-z-0-9] allowed!<br>New Password & Re New Password should be same!'));
            } else {

                $newpassword = $this->input->post('newpassword');


                echo json_encode(array('status' => 'Success', 'message' => 'Password Updated Successfully!'));

                $this->aauth->update_user($eid, false, $newpassword, false);


            }


        } else {
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = $head['usernm'] . ' Profile';


            $data['user'] = $this->employee->employee_details($id);
            $data['eid'] = intval($id);
            $this->load->view('fixed/header', $head);
            $this->load->view('employee/password', $data);
            $this->load->view('fixed/footer');
        }


    }
	public function file_handling()
    {
		ini_set('memory_limit', '500M');
		$this->load->model('customers_model', 'customers');
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

                $this->customers->meta_insert($id, 35, $files);
            }
        }


    }


}