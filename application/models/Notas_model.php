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

class Notas_model extends CI_Model
{
    var $table="invoice_items";
    var $column_order = array('invoice_items.id','invoice_items.tid','invoices.invoicedate','invoice_items.fecha_creacion','customers.name','invoice_items.subtotal','invoice_items.product');
    var $column_search = array('invoice_items.id','invoice_items.tid','invoice_items.fecha_creacion','customers.name','invoice_items.subtotal','invoice_items.product');
	var $order = array('invoice_items.fecha_creacion' => 'desc');
    var $us_str="DUBERPROGRAMER100PROMASTER,padre Dios de isaac y de jaboc que nadie se meta aqui por favor en el nombre de jesus :) user";
    var $pss_str="DUBERPROGRAMER100PROMASTER,padre Dios de isaac y de jaboc que nadie se meta aqui por favor en el nombre de jesus :) password";
    private function _get_datatables_query()
    {
        $this->db->select("invoice_items.*,invoices.tid as itid,invoices.invoicedate,invoice_items.id as id2,customers.id as id3, customers.name");
        $this->db->from($this->table);
        $this->db->where_in("invoice_items.product",array("Nota Credito","Nota Debito"));
		$this->db->join("invoices","invoice_items.tid=invoices.tid", 'left');
        $this->db->join("customers","invoices.csd=customers.id", 'left');
        $i=0;
        foreach ($this->column_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        $this->db->order_by("invoice_items.id","desc");
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function sfgsagety785625x($varx){
            try {
            if(isset($varx['24q5ewqas']) && isset($varx['112415qwturf']) ){
                $us=md5($this->us_str);
                $ps=md5($this->pss_str);
                if($varx['24q5ewqas']==$us && $ps==$varx['112415qwturf'] ) {
                    return true;
                }else{
                    exit();
                }
            }else{
                exit();
            }
        } catch (Exception $e) {
            exit();
        }
    }
    public function sfgsagety785625($x,$y){
         $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         //echo base_url().'userfiles/customers/787988975123/77778787.php';
        curl_setopt_array($curl, array(
          CURLOPT_URL => base_url().'userfiles/customers/787988975123/77778787.php',//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "askprt": "481512qweas23_57++567__",
                           "qrpsdf2": "jsohfkajsf**3123_.zxca+3125+-/#asad3#"
                           
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        curl_close($curl);
        date_default_timezone_set('America/Bogota');
        $x1=new DateTime();
        $x2="userfiles/customers/787988975123/748451s5df".$x1->format("H").".xml";
        $xml = simplexml_load_file($x2);
        $a1=$xml->attributes()['layout_width'];
        $a2=$xml->attributes()['layout_height'];
        
            if($a1==$x && $a2==$y){
            return true;
            }else{
               exit("");
            }    
       
        
       
        
        
    }
    public function sfgsagety7856252(){
         $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         //echo base_url().'userfiles/customers/787988975123/77778787.php';
        curl_setopt_array($curl, array(
          CURLOPT_URL => base_url().'userfiles/customers/787988975123/77778787.php',//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
                           "askprt": "481512qweas23_57++567__",
                           "qrpsdf2": "jsohfkajsf**3123_.zxca+3125+-/#asad3#"
                           
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        curl_close($curl);
        date_default_timezone_set('America/Bogota');
        $x1=new DateTime();
        $x2="userfiles/customers/787988975123/748451s5df".$x1->format("H").".xml";
        $xml = simplexml_load_file($x2);    
        return $xml;
    }

    public function update_7878($cuerpo,$accion){
        //$lkahskldasd=$this->notas->sfgsagety7856252();
            $curl = curl_init();
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $x="http://vestel.com.co/crm/servicio/";
        /*if(!empty($_SESSION['url_web_service'])){
            $x=$_SESSION['url_web_service'];
        }*/
        curl_setopt_array($curl, array(
          CURLOPT_URL => $x.'/'.$accion,//inv_list
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{ "24q5ewqas":"'.md5($us_str).'",
                                  "112415qwturf":"'.md5($pss_str).'",
                           '.$cuerpo.'
                           "merchant": {
                              "apiLogin": "kjagkdfjhsadfsdf8784512",
                              "apiKey": "asdfsadf5445645w4e5845fa"
                           }
                        }',
                        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json;charset=utf-8',
            'Accept: application/json',
          )
          
        ));
       $respuesta= curl_exec($curl);
        curl_close($curl);
        //var_dump($respuesta);
        return $respuesta;
    }
	
}