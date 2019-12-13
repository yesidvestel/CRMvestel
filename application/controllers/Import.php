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
use PhpOffice\PhpSpreadsheet\IOFactory;
class Import extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('export_model', 'export');
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
            exit;
        }

        if ($this->aauth->get_user()->roleid < 5) {

            exit('Not Allowed!');
        }
        $this->date = 'backup_' . date('Y_m_d_H_i_s');


    }




    function products()
    {
        $this->load->helper(array('form'));
        $this->load->model('categories_model');
        $head['title'] = "Import Products";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['cat'] = $this->categories_model->category_list();
        $data['warehouse'] = $this->categories_model->warehouse_list();
        $this->load->view('fixed/header', $head);
        $this->load->view('import/products', $data);
        $this->load->view('fixed/footer');

    }

    public function products_upload()
    {

        $this->load->helper(array('form'));
        $data['response'] = 3;
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Import Product';

        $this->load->view('fixed/header', $head);

        if ($this->input->post('product_cat')) {
            $data['pc'] = $this->input->post('product_cat');
            $data['wid'] = $this->input->post('product_warehouse');
            $config['upload_path'] = './userfiles';
            $config['allowed_types'] = 'csv';
            $config['max_size'] = 6000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('userfile')) {
                $data['response'] = 0;
                $data['responsetext'] = 'File Upload Error';

            } else {
                $data['response'] = 1;
                $data['responsetext'] = 'Document Uploaded Successfully.';
                $data['filename'] = $this->upload->data()['file_name'];

            }

            $this->load->view('import/wizard', $data);
        } else {


           echo' error';


        }
        $this->load->view('fixed/footer');


    }


    public function start_process()
    {
        require APPPATH . 'third_party/vendor/autoload.php';

        $name = $this->input->post('name');
        $pcat = $this->input->post('pc');
        $warehouse = $this->input->post('wid');
        $inputFileName = FCPATH . 'userfiles/' . $name;

        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);
//print_r($sheetData);

        $products=array();

        foreach ($sheetData as $row) {


            $products[] = array(
                'pid' => null,
                'pcat' => $pcat,
                'warehouse' => $warehouse,
                'product_name' => $row[0],
                'product_code' => $row[1],
                'product_price' => $row[2],
                'fproduct_price' => $row[3],
                'taxrate' => $row[4],
                'disrate' => $row[5],
                'qty' => $row[6],
                'product_des' => $row[7],
                'alert' => $row[8]
            );


        }
        unlink( FCPATH . 'userfiles/' . $name);
        if(count($sheetData[0])==9) {
            $out = $this->db->insert_batch('products', $products);
            if($out) {
                echo json_encode(array('status' => 'Success', 'message' =>
                    "Product Data Imported Successfully!"));
            }
            else{
                echo json_encode(array('status' => 'Error', 'message' =>
                    "Database Import Error! Please use proper encoding of file and its content."));
            }
        }
        else{
            echo json_encode(array('status' => 'Error', 'message' =>
                "Please correct the format of CSV file, it should be as per template."));
        }


    }


    //customer





}