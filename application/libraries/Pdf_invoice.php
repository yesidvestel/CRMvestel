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

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pdf_invoice
{

    function __construct()
    {
        $CI = &get_instance();
    }

    function load($param = NULL)
    {


        require_once APPPATH . '/third_party/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => 5, 'margin_right' => 5, 'margin_top' => 45, 'margin_bottom' => 12]);

        //$mpdf->SetDirectionality('RTL');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        return $mpdf;


    }

	function load_en($param = NULL)
    {


        require_once APPPATH . '/third_party/vendor/autoload.php';

        $mpdf = new \Mpdf\Mpdf();

        //$mpdf->SetDirectionality('RTL');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        return $mpdf;


    }
}