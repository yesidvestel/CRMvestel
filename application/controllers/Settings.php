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

class Settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('settings_model', 'settings');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }


    }

    public function company()
    {

        if ($this->input->post()) {
            $name = $this->input->post('name');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $address = $this->input->post('address');
            $city = $this->input->post('city');
            $region = $this->input->post('region');
            $country = $this->input->post('country');
            $postbox = $this->input->post('postbox');
            $taxid = $this->input->post('taxid');
            $this->settings->update_company(1, $name, $phone, $email, $address, $city, $region, $country, $postbox, $taxid);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Company Settings';
            $data['company'] = $this->settings->company_details(1);

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/company', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function currency()
    {

        if ($this->input->post()) {
            $currency = $this->input->post('currency');
            $thous_sep = $this->input->post('thous_sep');
            $deci_sep = $this->input->post('deci_sep');
            $decimal = $this->input->post('decimal');
            $spost = $this->input->post('spos');

            $this->settings->update_currency(1, $currency, $thous_sep, $deci_sep, $decimal, $spost);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Currency Settings';
            $data['currency'] = $this->settings->currency();

            $this->load->view('fixed/header', $head);
            $this->load->view('settings/currency', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function billing()
    {

        if ($this->input->post()) {
            $invoiceprefix = $this->input->post('invoiceprefix');
            $taxid = $this->input->post('taxid');
            $taxstatus = $this->input->post('taxstatus');
            $lang = $this->input->post('language');
            $q_prefix = $this->input->post('q_prefix');
            $p_prefix = $this->input->post('p_prefix');
            $r_prefix = $this->input->post('r_prefix');
            $s_prefix = $this->input->post('s_prefix');
            $t_prefix = $this->input->post('t_prefix');
            $o_prefix = $this->input->post('o_prefix');
            $this->settings->update_billing(1, $invoiceprefix, $taxid, $taxstatus, $lang);
            $this->settings->update_prefix($q_prefix, $p_prefix, $r_prefix, $s_prefix, $t_prefix,$o_prefix);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Billing & TAX Settings';
            $data['company'] = $this->settings->company_details(1);
            $data['prefix'] = $this->settings->prefix();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/billing', $data);
            $this->load->view('fixed/footer');
        }

    }

    public function dtformat()
    {

        if ($this->input->post()) {
            $tzone = $this->input->post('tzone');
            $dateformat = $this->input->post('dateformat');
            $this->settings->update_dtformat(1, $tzone, $dateformat);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Date Time Settings';
            $data['company'] = $this->settings->company_details(1);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/timeformat', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function companylogo()
    {
        $id = $this->input->get('id');
        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(gif|jpe?g|png)$/i', 'upload_dir' => FCPATH . 'userfiles/company/'
        ));
        $img = (string)$this->uploadhandler->filenaam();
        if ($img != '') {
            $this->settings->companylogo($id, $img);
        }


    }

    //tax


    public function email()
    {

        if ($this->input->post()) {
            $host = $this->input->post('host');
            $port = $this->input->post('port');
            $auth = $this->input->post('auth');
            $auth_type = $this->input->post('auth_type');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $sender = $this->input->post('sender');

			 $this->load->library('ultimatemailer');

			 $test = $this->ultimatemailer->bin_send($host, $port, $auth,$auth_type, $username, $password, $sender, 'Neo Billing Test', $sender, 'Neo Billing Test', 'Neo Billing SMTP Test', 'Hi, This is a Neo Billing SMTP Test! Working Perfectly', false, '');

			if($test) {
            $this->settings->update_smtp($host, $port, $auth,$auth_type, $username, $password, $sender);
			}
			else
			{
				echo json_encode(array('status' => 'Error', 'message' =>
                '<br>Your SMTP settings are invalid. If you think it is a correct configuration, please try with different ports like 465, 587.<br> Still not working please contact to your hosting provider. <br> Free smtp services are generally blocked by many hosting providers.<br>Please do not send support request to Neo Support Team, we can not help in this matter because in the application email system is working perfectly.'));
			}

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'SMTP Config';
            $data['email'] = $this->settings->email_smtp();
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/email', $data);
            $this->load->view('fixed/footer');
        }

    }


    public function billing_terms()
    {
        $data['terms'] = $this->settings->billingterms();
        $head['title'] = "Billing Terms";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('settings/terms', $data);
        $this->load->view('fixed/footer');
    }

    public function about()
    {

        $head['title'] = "About";

        $this->load->view('fixed/header', $head);
        $this->load->view('settings/about');
        $this->load->view('fixed/footer');
    }

    public function add_term()
    {

        if ($this->input->post()) {
            $title = $this->input->post('title');
            $type = $this->input->post('type');
            $term = $this->input->post('terms');

            $this->settings->add_term($title,$type , $term);

        } else {
            $head['title'] = "Add Billing Term";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/add_terms');
            $this->load->view('fixed/footer');
        }
    }


    public function edit_term()
    {

        if ($this->input->post()) {
            $id = $this->input->post('id');
            $title = $this->input->post('title');
            $type = $this->input->post('type');
            $term = $this->input->post('terms');



            $this->settings->edit_term($id, $title,$type, $term);

        } else {
            $id = $this->input->get('id');

            $data['term'] = $this->settings->get_terms($id);
            $head['title'] = "Edit Billing Term";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/edit_terms', $data);
            $this->load->view('fixed/footer');
        }
    }

	    public function delete_terms()
    {

        if ($this->input->post()) {
            $id = $this->input->post('deleteid');     

            

			if ($this->settings->delete_terms($id)) {
           
            echo json_encode(array('status' => 'Success', 'message' => $this->lang->line('DELETED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => $this->lang->line('ERROR')));
        }

        } 
    }

    public function activate()
    {

        if ($this->input->post()) {
            $email = $this->input->post('email');
            $code = $this->input->post('code');
            $this->settings->update_atformat($email, $code);
        } else {

            $head['title'] = "Neo Biiling Software Activation";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/active');
            $this->load->view('fixed/footer');


        }
    }

    public function theme()
    {

        if ($this->input->post()) {
            $tdirection = $this->input->post('tdirection');


            $this->settings->theme($tdirection);


        } else {

            $head['title'] = "Theme Settings";
            $head['usernm'] = $this->aauth->get_user()->username;
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/theme');
            $this->load->view('fixed/footer');


        }
    }

    public function themelogo()
    {

        $this->load->library("uploadhandler", array(
            'accept_file_types' => '/\.(png)$/i', 'upload_dir' => FCPATH . 'userfiles/theme/', 'name' => 'logo-header.png'
        ));


    }

    public function tickets()
    {
        $this->load->model('plugins_model', 'plugins');
        if ($this->input->post()) {
            $service = $this->input->post('service');
            $email = $this->input->post('email');
            $support = $this->input->post('support');
            $sign = $this->input->post('signature');

            $this->plugins->update_api(3, $service, $email, 1, $support, $sign);

        } else {

            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Support Ticket Settings';
            $data['support'] = $this->plugins->universal_api(3);
            $this->load->view('fixed/header', $head);
            $this->load->view('settings/ticket', $data);
            $this->load->view('fixed/footer');
        }

    }

}