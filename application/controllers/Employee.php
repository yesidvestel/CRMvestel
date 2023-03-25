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
        if ($this->aauth->get_user()->roleid < 4) {

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
		$data['modulos_padre']=$this->employee->get_modulos_padres();
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
        /*$co = $this->input->post('co');
        $coape = $this->input->post('coape');
        $conue = $this->input->post('conue');
        $coadm = $this->input->post('coadm');
        $cocie = $this->input->post('cocie');
        $cofa = $this->input->post('cofa');
        $cofae = $this->input->post('cofae');
        $us = $this->input->post('us');
        $usnue = $this->input->post('usnue');
        $usadm = $this->input->post('usadm');
        $usgru = $this->input->post('usgru');
        $tik = $this->input->post('tik');
        $tiknue = $this->input->post('tiknue');
        $tikadm = $this->input->post('tikadm');
        $mo = $this->input->post('mo');
        $monue = $this->input->post('monue');
        $moadm = $this->input->post('moadm');
        $pro = $this->input->post('pro');
        $pronue = $this->input->post('pronue');
        $proadm = $this->input->post('proadm');
        $enc = $this->input->post('enc');
        $encllam = $this->input->post('encllam');
        $encnue = $this->input->post('encnue');
        $encenc = $this->input->post('encenc');
        $encats = $this->input->post('encats');
        $encatslis = $this->input->post('encatslis');
        $proy = $this->input->post('proy');
        $proynue = $this->input->post('proynue');
        $proyadm = $this->input->post('proyadm');
        $cuen = $this->input->post('cuen');
        $cuenadm = $this->input->post('cuenadm');
        $cuennue = $this->input->post('cuennue');
        $cuenbal = $this->input->post('cuenbal');
        $cuendec = $this->input->post('cuendec');
        $red = $this->input->post('red');
        $reding = $this->input->post('reding');
        $redadm = $this->input->post('redadm');
        $redbod = $this->input->post('redbod');
        $com = $this->input->post('com');
        $comnue = $this->input->post('comnue');
        $comadm = $this->input->post('comadm');
        $tes = $this->input->post('tes');
        $testran = $this->input->post('testran');
        $tesanu = $this->input->post('tesanu');
        $tesnuetransac = $this->input->post('tesnuetransac');
        $tesnuetransfer = $this->input->post('tesnuetransfer');
        $tesing = $this->input->post('tesing');
        $tesgas = $this->input->post('tesgas');
        $testransfer = $this->input->post('testransfer');
        $dat = $this->input->post('dat');
        $datest = $this->input->post('datest');
        $datdec = $this->input->post('datdec');
        $datrep = $this->input->post('datrep');
        $datusu = $this->input->post('datusu');
        $datpro = $this->input->post('datpro');
        $dating = $this->input->post('dating');
        $datgas = $this->input->post('datgas');
        $dattrans = $this->input->post('dattrans');
        $datimp = $this->input->post('datimp');
        $not = $this->input->post('not');
        $cal = $this->input->post('cal');
        $doct = $this->input->post('doct');
        $pag = $this->input->post('pag');
        $pagconf = $this->input->post('pagconf');
        $pagvia = $this->input->post('pagvia');
        $pagmon = $this->input->post('pagmon');
        $pagcam = $this->input->post('pagcam');
        $pagban = $this->input->post('pagban');
        $inv = $this->input->post('inv');
        $inving = $this->input->post('inving');
        $invadm = $this->input->post('invadm');
        $invcat = $this->input->post('invcat');
        $invalm = $this->input->post('invalm');
        $invtrs = $this->input->post('invtrs');
        $emp = $this->input->post('emp');
        $comp = $this->input->post('comp');
        $comprec = $this->input->post('comprec');
        $compurl = $this->input->post('compurl');
        $comptwi = $this->input->post('comptwi');
        $compcurr = $this->input->post('compcurr');
        $pla = $this->input->post('pla');
        $placor = $this->input->post('placor');
        $plamen = $this->input->post('plamen');
        $platem = $this->input->post('platem');
        $conf = $this->input->post('conf');
        $confemp = $this->input->post('confemp');
        $conffa = $this->input->post('conffa');
        $confmon = $this->input->post('confmon');
        $conffec = $this->input->post('conffec');
        $confcat = $this->input->post('confcat');
        $confmet = $this->input->post('confmet');
        $confrest = $this->input->post('confrest');
        $confcorr = $this->input->post('confcorr');
        $confterm = $this->input->post('confterm');
        $confaut = $this->input->post('confaut');
        $confseg = $this->input->post('confseg');
        $conftem = $this->input->post('conftem');
        $confsop = $this->input->post('confsop');
        $conface = $this->input->post('conface');
        $confupt = $this->input->post('confupt');
        $confapi = $this->input->post('confapi');
        $dathistorial = $this->input->post('dathistorial');
        $conotas = $this->input->post('conotas');
        $tar = $this->input->post('tar');
        $redcon = $this->input->post('redcon');*/


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
					$roleid, $phone, $address, $city, 
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