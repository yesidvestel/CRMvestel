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

use Twilio\Rest\Client;

class Sms Extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('plugins_model', 'plugins');

        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->library('parser');

    }

    //todo section

    public function template()
    {

        $id = $this->input->post('invoiceid');
        $ttype = $this->input->post('ttype');
        if ($ttype == 'quote') {

            $invoice['tid'] = $id;

            $validtoken = hash_hmac('ripemd160', 'q' . $invoice['tid'], $this->config->item('encryption_key'));

            $link = base_url('billing/quoteview?id=' . $invoice['tid'] . '&token=' . $validtoken);
        } elseif ($ttype == 'purchase') {
            $invoice['tid'] = $id;
            $validtoken = hash_hmac('ripemd160', $invoice['tid'], $this->config->item('encryption_key'));

            $link = base_url('billing/purchase?id=' . $invoice['tid'] . '&token=' . $validtoken);
        } else {
            $invoice['tid'] = $id;
            $validtoken = hash_hmac('ripemd160', $invoice['tid'], $this->config->item('encryption_key'));

            $link = base_url('billing/view?id=' . $invoice['tid'] . '&token=' . $validtoken);
        }

        $sms_service = $this->plugins->universal_api(1);

        if ($sms_service['active']) {

            $this->load->library("Shortenurl");
            $this->shortenurl->setkey($sms_service['key1']);
            $link = $this->shortenurl->shorten($link);

        }

        $this->load->model('templates_model','templates');
        switch ($ttype) {
            case 'notification':
                $template = $this->templates->template_info(30);
                break;

            case 'reminder':
                $template = $this->templates->template_info(31);
                break;

            case 'refund':
                $template = $this->templates->template_info(32);
                break;


            case 'received':
                $template = $this->templates->template_info(33);
                break;

            case 'overdue':
                $template = $this->templates->template_info(34);
                break;


            case 'quote':
                $template = $this->templates->template_info(35);
                break;


            case 'purchase':
                $template = $this->templates->template_info(36);
                break;


        }

        $data = array(
            'BillNumber' => $invoice['tid'],
            'URL' => $link,
            'DueDate'=>dateformat($invoice['invoiceduedate']),
            'Amount'=>amountExchange($invoice['total'], $invoice['multi'])
        );
        $message= $this->parser->parse_string($template['other'], $data, TRUE);


        echo json_encode(array('message' => $message));
    }


    public function send_sms()
    {

        set_time_limit(400);
        $this->load->library('CellVozApi');
        $api = new CellVozApi();
        $retorno=$api->getToken(); 
        $valido=false;
		$name_campaign="mensolo1";
        $alerta=" "; 
		$mensajes_a_enviar.='{
                                  "codeCountry": "57",
                                  "number": "3154066407",
                                  "message": "Gracias por preferirnos, VESTEL te da la BIENVENIDA.  Sabemos que tu experiencia con nosotros será extraordinaria",
                                  "type": 1
                                }';
		var_dump($mensajes_a_enviar);
        $var=$api->envio_sms_masivos_por_curl($retorno['token'],$mensajes_a_enviar,$name_campaign);            
                

        if ($var) {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sending successful. Current Message Status is ' . $message->status));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'SMS Service Error'));
        }


    }


}


