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

class Communication extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('communication_model');
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
    }

    public function send_invoice()
    {
        $mailtoc = $this->input->post('mailtoc');
        $mailtotilte = $this->input->post('customername');
        $subject = $this->input->post('subject');

        $message = $this->input->post('message');
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
    }

    public function send_general()
    {
        $mailtoc = $this->input->post('mailtoc');
        $mailtotilte = $this->input->post('customername');
        $subject = $this->input->post('subject');
        $message = $this->input->post('text');
        $attachmenttrue = false;
        $attachment = '';
        $this->communication_model->send_email($mailtoc, $mailtotilte, $subject, $message, $attachmenttrue, $attachment);
    }

}