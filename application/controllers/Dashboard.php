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

class Dashboard extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        $this->load->model('dashboard_model');
        $this->load->model('tools_model');


    }


    public function index()
    {   
$_SESSION['permisos']=null;
    //var_dump($this->aauth->get_user()->co['pagconf']);
        
        $today = date("Y-m-d");
        $month = date("m");
        $year = date("Y");
		$sede = $this->input->get('sede');
        $this->load->model('employee_model', 'employee');        
        if ($this->aauth->get_user()->roleid > 4 || $this->employee->get_client_specific_permission($this->aauth->get_user()->id,"testran") != null) {
            $data['todayin'] = $this->dashboard_model->todayInvoice($today, $sede);
            $data['todayitems'] = $this->dashboard_model->todayItems($today,$sede);
            $data['incomechart'] = $this->dashboard_model->incomeChart($today, $month, $year, $sede);
            $data['expensechart'] = $this->dashboard_model->expenseChart($today, $month, $year, $sede);
            $data['countmonthlychart'] = $this->dashboard_model->countmonthlyChart();
            $data['monthin'] = $this->dashboard_model->monthlyInvoice($month, $year, $sede);
            $data['todaysales'] = $this->dashboard_model->todaySales($today, $sede);
            $data['monthsales'] = $this->dashboard_model->monthlySales($month, $year, $sede);
            $data['todayinexp'] = $this->dashboard_model->todayInexp($today, $sede);
            $data['recent_payments'] = $this->dashboard_model->recent_payments($sede);
            $data['tasks'] = $this->dashboard_model->tasks($this->aauth->get_user()->id);
            $data['list_users'] = $this->dashboard_model->lista_usuarios();
            $data['recent'] = $this->dashboard_model->recentInvoices($sede);
            $data['goals'] = $this->tools_model->goals(1);
            $data['stock'] = $this->dashboard_model->stock($sede);
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Panel';
            $this->load->view('fixed/header', $head);
            $this->load->view('dashboard', $data);
            $this->load->view('fixed/footer');
        } else if ($this->aauth->get_user()->roleid == -1) {
            $this->load->model('projects_model', 'projects');
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Project List';
            $data['totalt'] = $this->projects->project_count_all();

            $this->load->view('fixed/header', $head);
            $this->load->view('projects/index', $data);
            $this->load->view('fixed/footer');
        } else if ($this->aauth->get_user()->roleid == 1) {
            $head['title'] = "Products";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('products/products');
            $this->load->view('fixed/footer');
        } else if ($this->aauth->get_user()->roleid <= 4){
             $_POST['fecha']=date("d-m-Y");
            //$_POST['fecha']="30-12-2022";
            //$_POST['tecnico']="OscarTec";
            $this->load->model("Ticket_model","ticket");
            $this->load->model("Moviles_model","moviles");
            $this->load->model('events_model');
            
            $data = $this->events_model->getEventsNewCalendar();
            if($this->aauth->get_user()->roleid>=3){
                $data['tecnicoslista'] = $this->ticket->tecnico_list();
                $data['moviles'] = $this->moviles->get_datatables1();    
            }        
            $head['title']="Nuevo Calendario";
            $this->load->view('fixed/header',$head);
            $this->load->view('events/new',$data);
            $this->load->view('fixed/footer');


        }else {
            $head['title'] = "Manage Invoices";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('invoices/invoices');
            $this->load->view('fixed/footer');
        }
        //cambios para preguntar desde que sede se conecta para configurar ips en mikrotik
        $apis_vars=$this->db->get_where("variables_de_entorno")->result_array();
        foreach ($apis_vars as $key => $value) {
            $_SESSION['variables_'.$value['nombre_api']]=json_decode($value['valor']);    
        }
       //var_dump($_SESSION);
        $this->load->model('customers_model', 'customers');
        $datax['sede_accede']=$this->aauth->get_user()->sede_accede;
        $datax['customergrouplist'] = $this->customers->group_list();
        $this->load->view('fixed/pregunta_sede_se_conecta',$datax);
    }
    public function guardar_sede_user_se_conecta(){
        
        $id=$this->aauth->get_user()->id;
        $datax['sede_accede']=$_POST['sede'];
        $this->db->update("aauth_users",$datax,array('id' =>$id));        
        
    }
}