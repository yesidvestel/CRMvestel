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

class Cronjob extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('cronjob_model', 'cronjob');
        $this->load->library("Aauth");


    }


    public function index()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $data['message'] = false;
        $data['corn'] = $this->cronjob->config();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cron Job Panel';
        $this->load->view('fixed/header', $head);
        $this->load->view('cronjob/info', $data);
        $this->load->view('fixed/footer');

    }


    public function generate()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            if ($this->aauth->get_user()->roleid < 5) {

                exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

            }
        }


        if ($this->cronjob->generate()) {

            $data['message'] = true;


            $data['corn'] = $this->cronjob->config();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Generate New Key';
            $this->load->view('fixed/header', $head);
            $this->load->view('cronjob/info', $data);
            $this->load->view('fixed/footer');
        }


    }

    public function reccuring()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for recurring invoices-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";

            if ($this->cronjob->rec_inv()) {

                echo "---------------Success! Process Done! -------------------------\n";
            } else {
                echo "---------------Error! Process Halted! -------------------------\n";
            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }


    function rec_invoices_email()
    {

        $corn = $this->cronjob->config();
		$this->load->library('parser');
		


        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for recurring invoices-------\n";


        if ($cornkey == $this->input->get('token')) {
            $i = 1;
			$this->load->model('templates_model', 'templates');
		    $template = $this->templates->template_info(6);

            $emails = $this->cronjob->rec_inv_due_mail();


            $this->load->model('communication_model', 'communication');

            foreach ($emails as $invoice) {


                $validtoken = hash_hmac('ripemd160', 'rec' .$invoice['tid'], $this->config->item('encryption_key'));

                $link = base_url('billing/invoice?id=' . $invoice['tid'] . '&token=' . $validtoken);

               
				$data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invoice['tid']
        );
        $subject= $this->parser->parse_string($template['key1'], $data, TRUE);
		$data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invoice['tid'],
            'URL' => "<a href='$link'>$link</a>",
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
            Phone: ' . $this->config->item('phone') . '<br> Email: ' . $this->config->item('email'),
            'DueDate'=>dateformat($invoice['invoiceduedate']),
            'Amount'=>amountExchange($invoice['total'], $invoice['multi'])
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);
                

                if ($this->communication->send_corn_email($invoice['email'], $invoice['name'], $subject, $message)) {
                    echo "---------------$i. Email Sent! -------------------------\n";
                } else {

                    echo "---------------$i. Error! -------------------------\n";
                }


                $i++;

            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }
    }

    function due_invoices_email()
    {

        $corn = $this->cronjob->config();
		$this->load->library('parser');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for due invoices-------\n";


        if ($cornkey == $this->input->get('token')) {
            $i = 1;

            $emails = $this->cronjob->due_mail();
			$this->load->model('templates_model', 'templates');
		    $template = $this->templates->template_info(7);

            $this->load->model('communication_model', 'communication');

            foreach ($emails as $invoice) {


                $validtoken = hash_hmac('ripemd160', $invoice['tid'], $this->config->item('encryption_key'));

                $link = base_url('billing/view?id=' . $invoice['tid'] . '&token=' . $validtoken);

               $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invoice['tid']
        );
        $subject= $this->parser->parse_string($template['key1'], $data, TRUE);


        $data = array(
            'Company' => $this->config->item('ctitle'),
            'BillNumber' => $invoice['tid'],
            'URL' => "<a href='$link'>$link</a>",
            'CompanyDetails' => '<h6><strong>' . $this->config->item('ctitle') . ',</strong></h6>
<address>' . $this->config->item('address') . '<br>' . $this->config->item('address2') . '</address>
            Phone: ' . $this->config->item('phone') . '<br> Email: ' . $this->config->item('email'),
            'DueDate'=>dateformat($invoice['invoiceduedate']),
            'Amount'=>amountExchange($invoice['total'], $invoice['multi'])
        );
        $message = $this->parser->parse_string($template['other'], $data, TRUE);

                if ($this->communication->send_corn_email($invoice['email'], $invoice['name'], $subject, $message)) {
                    echo "---------------$i. Email Sent! -------------------------\n";
                } else {

                    echo "---------------$i. Error! -------------------------\n";
                }


                $i++;

            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }
    }


    function reports()
    {

        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Updating Reports-------\n";


        if ($cornkey == $this->input->get('token')) {


            echo "---------------Cron started-------\n";

            $this->cronjob->reports();

            echo "---------------Task Done-------\n";

        }


    }


    public function update_exchange_rate()
    {

        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];

        echo "---------------Updating Exchange Rates-------\n";
        if ($cornkey == $this->input->get('token')) {

            echo "---------------Cron started-------\n";
            $this->load->model('plugins_model', 'plugins');
            $exchange = $this->plugins->universal_api(5);
            if ($exchange['active']) {
                $endpoint = $exchange['key2'];
                $access_key = $exchange['key1'];
                $base = $exchange['url'];


                $ch = curl_init('http://apilayer.net/api/' . $endpoint . '?access_key=' . $access_key . '');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                $json = curl_exec($ch);
                curl_close($ch);


                $exchangeRates = json_decode($json, true);


                $this->cronjob->exchange_rate($base, $exchangeRates['quotes']);
                echo "---------------Task Done-------\n";
            }
        }


    }

}