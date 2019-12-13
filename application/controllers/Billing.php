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
require_once FCPATH . 'application/third_party/vendor/autoload.php';

use Omnipay\Omnipay;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

class Billing extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('invoices_model', 'invocies');
        $this->load->model('billing_model', 'billing');
    }

    public function view()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');
        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
        if (hash_equals($token, $validtoken)) {
            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Invoice $tid";
            $data['invoice'] = $this->invocies->invoice_details($tid);
            $data['online_pay'] = $this->billing->online_pay_settings();
            $data['products'] = $this->invocies->invoice_products($tid);
            $data['activity'] = $this->invocies->invoice_transactions($tid);
            $data['attach'] = $this->invocies->attach($tid);
            $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
            $data['gateway'] = $this->billing->gateway_list('Yes');
            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/view', $data);
            $this->load->view('billing/footer');
        }
    }

    public function invoice()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');
        $validtoken = hash_hmac('ripemd160', 'rec' . $tid, $this->config->item('encryption_key'));
        if (hash_equals($token, $validtoken)) {
            $this->load->model('rec_invoices_model', 'rec_invocies');
            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Invoice $tid";
            $data['attach'] = $this->rec_invocies->attach($tid);
            $data['invoice'] = $this->rec_invocies->invoice_details($tid);
            $data['online_pay'] = $this->billing->online_pay_settings();
            $data['products'] = $this->rec_invocies->invoice_products($tid);
            $data['activity'] = $this->rec_invocies->invoice_transactions($tid);
            $data['employee'] = $this->invocies->employee($data['invoice']['eid']);
            $data['gateway'] = $this->billing->gateway_list('Yes');
            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/reccur', $data);
            $this->load->view('billing/footer');
        }

    }


    public function quoteview()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'q' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $this->load->model('quote_model', 'quote');

            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Quote $tid";
            $data['invoice'] = $this->quote->quote_details($tid);
            $data['attach'] = $this->quote->attach($tid);

            $data['products'] = $this->quote->quote_products($tid);


            $data['employee'] = $this->quote->employee($data['invoice']['eid']);

            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/quoteview', $data);
            $this->load->view('billing/footer');
        }

    }

    public function purchase()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('purchase_model', 'purchase');

            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $data['attach'] = $this->purchase->attach($tid);
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Purchase $tid";
            $data['invoice'] = $this->purchase->purchase_details($tid);
            // $data['online_pay'] = $this->purchase->online_pay_settings();
            $data['products'] = $this->purchase->purchase_products($tid);
            $data['activity'] = $this->purchase->purchase_transactions($tid);;


            $data['employee'] = $this->purchase->employee($data['invoice']['eid']);

            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/purchase', $data);
            $this->load->view('billing/footer');
        }

    }


    public function stockreturn()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 's' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('stockreturn_model', 'stockreturn');

            $this->load->model('accounts_model');
            $data['acclist'] = $this->accounts_model->accountslist();
            $data['attach'] = $this->stockreturn->attach($tid);
            $tid = intval($this->input->get('id'));
            $data['id'] = $tid;
            $data['token'] = $token;
            $head['title'] = "Stock return $tid";
            $data['invoice'] = $this->stockreturn->purchase_details($tid);
            // $data['online_pay'] = $this->purchase->online_pay_settings();
            $data['products'] = $this->stockreturn->purchase_products($tid);
            $data['activity'] = $this->stockreturn->purchase_transactions($tid);;


            $data['employee'] = $this->stockreturn->employee($data['invoice']['eid']);

            $head['usernm'] = '';
            $this->load->view('billing/header', $head);
            $this->load->view('billing/stockreturn', $data);
            $this->load->view('billing/footer');
        }

    }


    public function gateway()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->post('tid'));
        $token = $this->input->post('token');
        $amount = $this->input->post('p_amount');
        $pay_gateway = $this->input->post('pay_gateway');

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {


            switch ($pay_gateway) {

                case 1 :
                    $this->card();
                    break;
            }
        }


    }


    public function printinvoice()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $data['id'] = $tid;
            $data['title'] = "Invoice $tid";
            $data['invoice'] = $this->invocies->invoice_details($tid);
            $data['products'] = $this->invocies->invoice_products($tid);
            $data['employee'] = $this->invocies->employee($data['invoice']['eid']);

            ini_set('memory_limit', '64M');
   $html = $this->load->view('invoices/view-print-'.LTR, $data, true);
        $html2 = $this->load->view('invoices/header-print-'.LTR, $data, true);
          

            //PDF Rendering
            $this->load->library('pdf_invoice');

            $pdf = $this->pdf_invoice->load();
 $pdf->SetHTMLHeader($html2);
            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Invoice_#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Invoice_#' . $tid . '.pdf', 'I');
            }


        }

    }

    public function print_rec()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'rec' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $this->load->model('rec_invoices_model', 'rec_invoices');

            $data['id'] = $tid;
            $data['title'] = "Invoice $tid";
            $data['invoice'] = $this->rec_invoices->invoice_details($tid);
            $data['products'] = $this->rec_invoices->invoice_products($tid);
            $data['employee'] = $this->rec_invoices->employee($data['invoice']['eid']);

            ini_set('memory_limit', '64M');

            $html = $this->load->view('rec_invoices/view-print-'.LTR, $data, true);

            //PDF Rendering
            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Rec_invoices_#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Rec_invoices_#' . $tid . '.pdf', 'I');
            }


        }


    }

    public function printquote()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'q' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {

            $this->load->model('quote_model', 'quote');

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


    }


    public function printorder()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 'p' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('purchase_model', 'purchase');

            $data['id'] = $tid;
            $data['title'] = "Invoice $tid";
            $data['invoice'] = $this->purchase->purchase_details($tid);
            $data['invoice']['multi'] =0;
            $data['products'] = $this->purchase->purchase_products($tid);
            $data['employee'] = $this->purchase->employee($data['invoice']['eid']);

            ini_set('memory_limit', '64M');

            $html = $this->load->view('purchase/view-print-'.LTR, $data, true);

            //PDF Rendering
            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Purchase_order#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Purchase_order#' . $tid . '.pdf', 'I');
            }


        }

    }

    public function printstockreturn()
    {
        if (!$this->input->get()) {
            exit();
        }
        $tid = intval($this->input->get('id'));
        $token = $this->input->get('token');

        $validtoken = hash_hmac('ripemd160', 's' . $tid, $this->config->item('encryption_key'));

        if (hash_equals($token, $validtoken)) {
            $this->load->model('stockreturn_model', 'stockreturn');

            $data['id'] = $tid;
            $data['title'] = "Invoice $tid";
            $data['invoice'] = $this->stockreturn->purchase_details($tid);
            $data['products'] = $this->stockreturn->purchase_products($tid);
            $data['employee'] = $this->stockreturn->employee($data['invoice']['eid']);

            ini_set('memory_limit', '64M');

            $html = $this->load->view('stockreturn/view-print', $data, true);

            //PDF Rendering
            $this->load->library('pdf');

            $pdf = $this->pdf->load();

            $pdf->SetHTMLFooter('<div style="text-align: right;font-family: serif; font-size: 8pt; color: #5C5C5C; font-style: italic;margin-top:-6pt;">{PAGENO}/{nbpg} #'.$tid.'</div>');

            $pdf->WriteHTML($html);

            if ($this->input->get('d')) {

                $pdf->Output('Stockreturn_order#' . $tid . '.pdf', 'D');
            } else {
                $pdf->Output('Stockreturn_order#' . $tid . '.pdf', 'I');
            }


        }

    }


    public function card()
    {
        if (!$this->input->get()) {
            exit();
        }
        $this->load->helper('form');
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 0) {
            exit();
        }
        $data['tid'] = $this->input->get('id');
        $data['token'] = $this->input->get('token');
        $data['itype'] = $this->input->get('itype');
        $data['gid'] = $this->input->get('gid');
        if ($data['itype'] == 'inv') {
            $validtoken = hash_hmac('ripemd160', $data['tid'], $this->config->item('encryption_key'));
            if (hash_equals($data['token'], $validtoken)) {
                $data['invoice'] = $this->invocies->invoice_details($data['tid']);
            } else {
                exit();
            }
        } else if ($data['itype'] == 'rinv') {
            $validtoken = hash_hmac('ripemd160', 'rec' . $data['tid'], $this->config->item('encryption_key'));
            if (hash_equals($data['token'], $validtoken)) {
                $this->load->model('rec_invoices_model', 'rec_invoices');
                $data['invoice'] = $this->rec_invoices->invoice_details($data['tid']);
            } else {
                exit();
            }

        }

                switch ($data['gid']) {
            case 1:
                $fname = 'stripe';
                break;
            case 2:
                $fname = 'authorize';
                break;
            case 3:
                $fname = 'pinpay';
                break;
            case 4:
                $fname = 'paypal';
                break;
            case 5:
                $fname = 'securepay';
                break;
            case 6:
                $fname = 'checkout';
                break;
            case 7:
                $fname = 'payumoney';
                break;
            case 8:
                $fname = 'razor';
                break;
            default :
                $fname = 'stripe';
                break;
        }


        $online_pay = $this->billing->online_pay_settings();
       // $data['gateway'] = $this->billing->gateway_list('Yes');
         $data['gateway'] = $this->billing->gateway($data['gid']);
        if ($online_pay['enable'] == 1) {
            $this->load->view('billing/header');
            $this->load->view('gateways/card_' . $fname, $data);
            $this->load->view('billing/footer');
        } else {
            echo '<h3>' . $this->lang->line('Online Payment Service') . '</h3>';
        }


    }

    public function process_card()
    {
        if (!$this->input->post()) {
            exit();
        }
        $tid = $this->input->post('id', true);
        $itype = $this->input->post('itype', true);
        $amount = number_format($this->input->post('amount', true), 2, '.', '');

        if ($itype == 'inv') {
            $customer = $this->invocies->invoice_details($tid);
            if (!$customer['tid']) {
                exit();
            }
        } else {
            $this->load->model('rec_invoices_model', 'rec_invoices');
            $customer = $this->rec_invoices->invoice_details($tid);
            if (!$customer['tid']) {
                exit();
            }
        }


        $hash = $this->input->post('token', true);
        $gateway = $this->input->post('gateway', true);
        $cardNumber = $this->input->post('cardNumber', true);
        $cardExpiry = $this->input->post('cardExpiry', true);
        $cardCVC = $this->input->post('cardCVC', true);

        $nmonth = substr($cardExpiry, 0, 2);
        $nyear = '20' . substr($cardExpiry, 5, 2);

        $note = 'Card Payment for #' . $tid;
        $pmethod = 'Card';

        $amount_o = $amount;

        if ($customer['multi'] > 0) {
            $multi_currency = $this->invocies->currency_d($customer['multi']);
            $amount = $multi_currency['rate'] * $amount;
            $gateway_data['currency'] = $multi_currency['code'];
            $note .= ' (Currency Conversion Applied)';
        }

        $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));

        $gateway_data = $this->billing->gateway($gateway);
        $surcharge = ($amount * $gateway_data['surcharge']) / 100;
        $amount_t = $amount + $surcharge;

        $amount = number_format($amount_t, 2, '.', '');

        if (hash_equals($hash, $validtoken)) {


            switch ($gateway) {

                case 1:
                     $response = $this->stripe($this->input->post('stripeToken', true), $amount, $gateway_data, $tid, $customer);
                    break;
                case 2:
                    $response = $this->authorizenet($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                    break;
                case 3:
                    $response = $this->pinpay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer);
                    break;
                case 4:
                    $response = $this->paypal($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data,$customer);
                    break;
                case 5:
                    $response = $this->securepay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                    break;

            }

            // Process response
            if ($response->isSuccessful()) {

                if ($this->billing->paynow($tid, $amount_o, $note, $pmethod)) {
                    header('Content-Type: application/json');
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('Thank you for the payment') . " <a href='" . base_url('billing/view?id=' . $tid . '&token=' . $hash) . "' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "</a>"));
                }

            } elseif ($response->isRedirect()) {

                // Redirect to offsite payment gateway
                $response->redirect();

            } else {

                // Payment failed
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Payment failed')));
            }


        }


    }


    private function stripe($token, $amount, $gateway_data, $tid, $customer, $currency = '')
    {
        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey($gateway_data['key1']);
        if (!$currency) $currency = $gateway_data['currency'];
        $meta = array(
            'Name' => $customer['name'],
            'email' => $customer['email']
        );
        return $gateway->purchase([
            'amount' => $amount,
            'currency' => $currency,
            'token' => $token,
            'description' => 'Paid for ' . $customer['name'] . ' INV#' . $tid,
            'metadata' => $meta
        ])->send();
    }


    private function authorizenet($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data)
    {
        $gateway = Omnipay::create('AuthorizeNet_AIM');
        $gateway->setApiLoginId($gateway_data['key2']);
        $gateway->setTransactionKey($gateway_data['key1']);
        $gateway->setDeveloperMode(true);

        try {
            return $gateway->purchase(
                array(
                    'card' => array(
                        'number' => $cardNumber,
                        'expiryMonth' => $nmonth,
                        'expiryYear' => $nyear,
                        'cvv' => $cardCVC
                    ),
                    'amount' => $amount,
                    'currency' => $gateway_data['currency'],
                    'description' => 'Paid on' . $this->config->item('ctitle'),
                    'transactionId' => 'INV#' . $tid
                )
            )->send();

        } catch (Exception $e) {
            return 0;
        }
    }


    private function pinpay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer)
    {
        $gateway = \Omnipay\Omnipay::create('Pin');

        // Initialise the gateway
        $gateway->initialize(array(
            'secretKey' => $gateway_data['key1'],
            'testMode' => $gateway_data['dev_mode'], // Or false when you are ready for live transactions
        ));

        // Create a credit card object
        // This card can be used for testing.
        // See https://pin.net.au/docs/api/test-cards for a list of card
        // numbers that can be used for testing.
        $card = new \Omnipay\Common\CreditCard(array(
            'firstName' => $customer['name'],
            'lastName' => 'Customer',
            'number' => $cardNumber,
            'expiryMonth' => $nmonth,
            'expiryYear' => $nyear,
            'cvv' => $cardCVC,
            'email' => $customer['email'],
            'billingAddress1' => $customer['address'],
            'billingCountry' => $customer['country'],
            'billingCity' => $customer['city'],
            'billingPostcode' => $customer['postbox'],
            'billingState' => $customer['region'],
        ));

        // Do a purchase transaction on the gateway
        $transaction = $gateway->purchase(array(
            'description' => 'Payment for INV#' . $tid,
            'amount' => $amount,
            'currency' => $gateway_data['currency'],
            'clientIp' => $_SERVER['REMOTE_ADDR'],
            'card' => $card,
        ));
        return $transaction->send();

    }


    private function securepay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data)
    {


        $gateway = \Omnipay\Omnipay::create('SecurePay_SecureXML');
        $gateway->setMerchantId($gateway_data['key1']);
        $gateway->setTransactionPassword($gateway_data['key2']);
        $gateway->setTestMode($gateway_data['dev_mode']);

        // Create a credit card object
        $card = new \Omnipay\Common\CreditCard(
            [
                'number' => $cardNumber,
                'expiryMonth' => $nmonth,
                'expiryYear' => $nyear,
                'cvv' => $cardCVC,
            ]
        );

        // Perform a purchase test
        $transaction = $gateway->purchase(
            [
                'amount' => $amount,
                'currency' => $gateway_data['currency'],
                'transactionId' => 'invoice_' . $tid,
                'card' => $card,
            ]
        );

        return $transaction->send();
    }


    private function paypal($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data,$customer)
    {

        $gateway = Omnipay::create('PayPal_Rest');
        // Initialise the gateway
        $gateway->initialize(array(
            'clientId' => $gateway_data['key1'],
            'secret' => $gateway_data['key2'],
            'testMode' => $gateway_data['dev_mode'], // Or false when you are ready for live transactions
        ));

        $card = new \Omnipay\Common\CreditCard(array(
            'firstName' => $customer['name'],
            'lastName' => 'Customer',
            'number' => $cardNumber,
            'expiryMonth' => $nmonth,
            'expiryYear' => $nyear,
            'cvv' => $cardCVC,
            'billingAddress1' => $customer['address'],
            'billingCountry' => $customer['country'],
            'billingCity' => $customer['city'],
            'billingPostcode' => $customer['postbox'],
            'billingState' => $customer['state'],
        ));

        try {
            $transaction = $gateway->purchase(array(
                'amount' => $amount,
                'currency' => $gateway_data['currency'],
                'description' => 'Payment for #inv ' . $tid,
                'card' => $card,
            ));
            return $transaction->send();
        } catch (\Exception $e) {
            return false;
        }


    }

    public function bank()
    {
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['bank'] == 1) {
            $data['accounts'] = $this->billing->bank_accounts('Yes');
            $this->load->view('billing/header');
            $this->load->view('payment/public_bank_view', $data);
            $this->load->view('billing/footer');
        }

    }


    public function recharge()
    {
        if (!$this->input->post()) {
            exit();
        }
        $online_pay = $this->billing->online_pay_settings();
        if ($online_pay['enable'] == 0) {
            exit();
        }
        $data['id'] = $this->input->post('id');
        $data['amount'] = $this->input->post('amount');

        $online_pay = $this->billing->online_pay_settings();
        $data['gateway'] = $this->billing->gateway_list('Yes');
        if ($online_pay['enable'] == 1) {
            $this->load->view('billing/header');
            $this->load->view('payment/recharge', $data);
            $this->load->view('billing/footer');
        } else {
            echo '<h3>' . $this->lang->line('Online Payment Service') . '</h3>';
        }


    }

    public function process_recharge()
    {
        if (!$this->input->post()) {
            exit();
        }
        $tid = $this->input->post('id', true);
        $amount = number_format($this->input->post('amount', true), 2, '.', '');
        $gateway = $this->input->post('gateway', true);
        $cardNumber = $this->input->post('cardNumber', true);
        $cardExpiry = $this->input->post('cardExpiry', true);
        $cardCVC = $this->input->post('cardCVC', true);

        $nmonth = substr($cardExpiry, 0, 2);
        $nyear = '20' . substr($cardExpiry, 5, 2);

        $note = 'Card Payment for #' . $tid;
        $pmethod = 'Card';

        $amount_o = $amount;

        $gateway_data = $this->billing->gateway($gateway);
        $surcharge = ($amount * $gateway_data['surcharge']) / 100;
        $amount_t = $amount + $surcharge;
        $this->load->model('customers_model', 'customers');
        $customer = $this->customers->details($tid);


        $amount = number_format($amount_t, 2, '.', '');


            switch ($gateway) {

                case 1:
                    $response = $this->stripe($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $gateway_data);
                    break;
                case 2:
                    $response = $this->authorizenet($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                    break;
                case 3:
                    $response = $this->pinpay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data, $customer);
                    break;
                case 4:
                    $response = $this->paypal($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data,$customer);
                    break;
                case 5:
                    $response = $this->securepay($cardNumber, $nmonth, $nyear, $cardCVC, $amount, $tid, $gateway_data);
                    break;

            }

            // Process response
            if ($response->isSuccessful()) {

                if ($this->billing->recharge_done($tid, $amount_o)) {
                    header('Content-Type: application/json');
                    echo json_encode(array('status' => 'Success', 'message' =>
                        $this->lang->line('Thank you for the payment') . " <a href='" . base_url('crm/payments/recharge') . "' class='btn btn-info btn-lg'><span class='icon-file-text2' aria-hidden='true'></span> " . $this->lang->line('View') . "</a>"));
                }

            } elseif ($response->isRedirect()) {

                // Redirect to offsite payment gateway
                $response->redirect();

            } else {

                // Payment failed
                echo json_encode(array('status' => 'Error', 'message' =>
                    $this->lang->line('Payment failed')));
            }
    }
     public function gateway_process()
    {
        //for paypal
        $invoice = $this->input->post('id', true);
        $token = $this->input->post('token', true);

        $gateway_data = $this->billing->gateway(4);
        $paypalConfig = [
            'sandbox' => $gateway_data['dev_mode'],
            'client_id' => $gateway_data['key1'],
            'client_secret' => $gateway_data['key2'],
            'return_url' => base_url('billing/gateway_response'),
            'cancel_url' => base_url('billing/view?id=' . $invoice . '&token=' . $token)
        ];

        $this->load->library("Paypal_gateway", $paypalConfig);

        $apiContext = $this->paypal_gateway->getApiContext();


        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

// Set some example data for the payment.
        $customer = $this->invocies->invoice_details($invoice);
        if (!$customer['tid']) {
            exit();
        }
        $amount = number_format($this->input->post('amount', true), 2, '.', '');
        if ($customer['multi'] > 0) {
            $multi_currency = $this->invocies->currency_d($customer['multi']);
            //    $amount =  $amount;
            $gateway_data['currency'] = $multi_currency['code'];

        }

        $validtoken = hash_hmac('ripemd160', $invoice, $this->config->item('encryption_key'));
        $surcharge = ($amount * $gateway_data['surcharge']) / 100;
        $amount_t = $amount + $surcharge;
        $amount = number_format($amount_t, 2, '.', '');

        if (hash_equals($token, $validtoken)) {

            $amountPayable = $amount;
            $invoiceNumber = $invoice;

            $amount = new Amount();
            $amount->setCurrency($gateway_data['currency'])
                ->setTotal($amountPayable);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setDescription('Some description about the payment being made')
                ->setInvoiceNumber($invoiceNumber);

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl($paypalConfig['return_url'])
                ->setCancelUrl($paypalConfig['cancel_url']);

            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions([$transaction])
                ->setRedirectUrls($redirectUrls);

            try {
                $payment->create($apiContext);
                $this->billing->token($invoice,1);
            } catch (Exception $e) {
                throw new Exception('Unable to create link for payment');
            }

            header('location:' . $payment->getApprovalLink());
            exit(1);
        }


    }

    public function gateway_response()
    {
        if (empty($this->input->get('paymentId', true)) || empty($this->input->get('PayerID', true))) {
            exit;
        }
        $gateway_data = $this->billing->gateway(4);
        $paypalConfig = [
            'sandbox' => $gateway_data['dev_mode'],
            'client_id' => $gateway_data['key1'],
            'client_secret' => $gateway_data['key2'],
            'return_url' => base_url('billing/gateway_response'),
            'cancel_url' => base_url('billing/view?id=105&token=ee2f511d44dd7f0212d46b92f2d6022754574bb3')
        ];
        $this->load->library("Paypal_gateway", $paypalConfig);
        $apiContext = $this->paypal_gateway->getApiContext();
        $paymentId = $_GET['paymentId'];
        $payment = Payment::get($paymentId, $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($_GET['PayerID']);
        try {
            // Take the payment
            $payment->execute($execution, $apiContext);
            try {
                $payment = Payment::get($paymentId, $apiContext);
                $data = [
                    'transaction_id' => $payment->getId(),
                    'payment_amount' => $payment->transactions[0]->amount->total,
                    'payment_status' => $payment->getState(),
                    'invoice_id' => $payment->transactions[0]->invoice_number
                ];
                 $validtoken = hash_hmac('ripemd160', $data['invoice_id'], $this->config->item('encryption_key'));
                $paypalConfig['bill_url']=base_url('billing/view?id=' . $data['invoice_id'] . '&token=' . $validtoken);
                if ($data['payment_status'] === 'approved') {
                    $customer = $this->invocies->invoice_details($data['invoice_id']);
                    $amount_o = $data['payment_amount'];

                    //$amount_o = rev_amountExchange_s($amount_o, $customer['multi'], $customer['loc']);

                    $note = 'Card Payment for #' . $customer['tid'];
                    $pmethod = 'Card';
                    if ($customer['multi'] > 0) {
                        //    $amount =  $amount;
                        $note .= ' (Currency Conversion Applied)';
                    }

                    $amount =  $amount_o / (($gateway_data['surcharge']/100) + 1);
                    $amount_o = number_format($amount, 2, '.', '');
                    $valid=$this->billing->token($customer['tid'],2);
                    if($valid['rid']==$customer['tid']){
                         $this->billing->paynow($customer['tid'], $amount_o, $note, $pmethod);
                          $this->billing->token($customer['tid'],3);
                    }
                   header('location:' . $paypalConfig['bill_url']);
                    exit(1);
                } else {
                    // Payment failed
                    header('location:' . $paypalConfig['bill_url']);
                    exit(1);
                }
            } catch (Exception $e) {
                // Failed to retrieve payment from PayPal
                $this->billing->token($customer['tid'],3);
                header('location:' . base_url());
            }
        } catch (Exception $e) {
            // Failed to take payment
            $this->billing->token($customer['tid'],3);
            header('location:' .  base_url());
        }
    }

}