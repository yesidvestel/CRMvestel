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
class Moviles extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
       
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 2) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
    }
    public function index(){
        $head['usern']=$this->aauth->get_user()->username;
        $head['title']="Administrar Movil";
        $this->load->view("fixed/header",$head);
        $this->load->view("moviles/admin");
        $this->load->view("fixed/footer");
    }
    public function create(){
        $head['usern']=$this->aauth->get_user()->username;
        $head['title']="Nueva Movil";
        //la idea es que se crea al dar en nueva movil una movil temporal  vacia se le puede cambiar el nombre e ir agregando los empleados al dar guardar se cambia de temporal a nueva movil y aparecera en administrar moviles
        $this->load->view("fixed/header",$head);
        $this->load->view("moviles/create");
        $this->load->view("fixed/footer");
    }
}