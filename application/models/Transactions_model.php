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

class Transactions_model extends CI_Model
{
    var $table = 'transactions';
    var $column_order = array( 'date', 'account', 'debit', 'credit', 'payer', 'customers.documento', 'tid','note',  'method','cat','estado');
    var $column_search = array('transactions.id', 'date', 'account', 'transactions.debit', 'transactions.credit', 'payer', 'customers.documento', 'tid','note',  'method','cat','estado');
    var $order = array('date' => 'desc');
    var $opt = '';

    private function _get_datatables_query($filt2)
    {
		$this->db->select('transactions.*,customers.documento, customers.id AS iduser');
        $this->db->from($this->table);
		if($filt2['opcselect']!=''){

            $dateTime= new DateTime($filt2['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($filt2['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($filt2['opcselect']=="fcreada"){
                $this->db->where('date>=', $sdate);   
                $this->db->where('date<=', $edate);       
            }
            
        }
          

        if($filt2['cuentas']!=""){
            $this->db->where('account', $filt2['cuentas']);       
        }
		if($filt2['categorias']!=""){
            $this->db->where('cat', $filt2['categorias']);       
        }
		if($filt2['metodo']!=""){
            $this->db->where('method', $filt2['metodo']);       
        }
        switch ($this->opt) {
            case 'income':
                $this->db->where('type', 'Income');
				$this->db->where('tid !=', -1);
				$this->db->where('estado');
                break;
            case 'expense':
                //var_dump($this->opt);
                $this->db->where('type', 'Expense');
                $this->db->where('tid !=', -1);
				$this->db->where('estado');
                break;
			case 'transferencia':
                //var_dump($this->opt);
                $this->db->where('type', 'transfer');
                break;
			default:
				$this->db->where('estado');
				break;
        }
		
        if($_GET['id_tr']){
            $this->db->where("transactions.id",$_GET['id_tr']);
            $this->db->where("estado",null);
        }else{
            //$this->db->where("estado!=","Anulada");
        $this->db->where("estado IS NULL",NULL);    
        }
		$this->db->join('customers', 'transactions.payerid=customers.id', 'left');
        
        $i = 0;
        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        if(empty($_GET['todas_las_tr'])){
            $this->db->where('transactions.id>'. $_SESSION['number_tr_min']);
            $this->db->order_by("transactions.id","desc");    
        }
        
    }

    function get_datatables($opt = 'all',$filt2)
    {
        $this->opt = $opt;
        $this->_get_datatables_query($filt2);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query($ttype,$_GET);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
       $this->_get_datatables_query($ttype,$_GET);
        $query = $this->db->get();
        return $query->num_rows();  
    }

    public function categories()
    {
        $this->db->select('*');
        $this->db->from('transactions_cat');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function acc_list()
    {
		
		$user = $this->aauth->get_user()->id;
		$this->load->model('employee_model', 'employee'); 
		$asignacion = $this->db->get_where('asignaciones', array('detalle' => 'caja','colaborador'=>$user))->row();		
        $this->db->select('*');
        $this->db->from('accounts');
		if ($this->employee->get_client_specific_permission($this->aauth->get_user()->id,"testran") == null){
			$this->db->where('id', $asignacion->tipo);
			$this->db->or_where('sede', '0');
		}
        $query = $this->db->get();
        return $query->result_array();
    } 
    public function groups_list()
    {
        
        $user = $this->aauth->get_user()->id;
        //$this->load->model('employee_model', 'employee'); 
        //$asignacion = $this->db->get_where('asignaciones', array('detalle' => 'caja','colaborador'=>$user))->row();     
        $this->db->select('*');
        $this->db->from('customers_group');
       /* if ($this->employee->get_client_specific_permission($this->aauth->get_user()->id,"testran") == null){
            $this->db->where('id', $asignacion->tipo);
            $this->db->or_where('id', '0');
        }*/
        $query = $this->db->get();
        return $query->result_array();
    } 
	public function tdascuentas()
    {			
        $this->db->select('*');
        $this->db->from('accounts');
        $query = $this->db->get();
        return $query->result_array();
    }
	public function edit($id, $deb, $cred, $fcha, $nte,$tid)
    {
        $data = array(
			'debit' => $deb,
            'credit' => $cred,
			'date' => $fcha,
            'note' => $nte,

        );
        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('transactions')) {
			$factura = $this->db->get_where('invoices', array('tid' => $tid))->row();
				$data2 = array(
					'pamnt' => $cred,
				);
			$this->db->set($data2);
        	$this->db->where('tid', $tid);
			$this->db->update('invoices');
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function addcat($name)
    {
        $data = array(
            'name' => $name
        );

        return $this->db->insert('transactions_cat', $data);
    }

    public function addtrans($payer_id, $payer_name, $pay_acc, $date, $debit, $credit, $pay_type, $pay_cat, $paymethod, $note, $eid)
    {

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('accounts');
            $this->db->where('id', $pay_acc);
            $query = $this->db->get();
            $account = $query->row_array();


            $data = array(
                'payerid' => $payer_id,
                'payer' => $payer_name,
                'acid' => $pay_acc,
                'account' => $account['holder'],
                'date' => $date,
                'debit' => $debit,
                'credit' => $credit,
                'type' => $pay_type,
                'cat' => $pay_cat,
                'method' => $paymethod,
                'eid' => $eid,
                'note' => $note,
                //'tid'=>$factura_id
            );
            $amount = $credit - $debit;
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $pay_acc);
            $this->db->update('accounts');
            $tr_result=$this->db->insert('transactions', $data);

            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            ob_clean();
            $files = (string)$this->uploadhandler_generic->filenaam();
            
            if ($files != '') {

                $this->purchase->meta_insert($this->db->insert_id(), 77, $files, "Pago","");
            }
        

            $this->load->model('customers_model', 'customers');
            $this->customers->actualizar_debit_y_credit($payer_id);
            return $tr_result;
        }
    }

    public function addtransfer($pay_acc, $pay_acc2, $amount, $eid)
    {

        if ($pay_acc > 0) {

            $this->db->select('holder');
            $this->db->from('accounts');
            $this->db->where('id', $pay_acc);
            $query = $this->db->get();
            $account = $query->row_array();
            $this->db->select('holder');
            $this->db->from('accounts');
            $this->db->where('id', $pay_acc2);
            $query = $this->db->get();
            $account2 = $query->row_array();


            $data = array(
                'payerid' => '',
                'payer' => '',
                'acid' => $pay_acc2,
                'account' => $account2['holder'],
                'date' => date('Y-m-d'),
                'debit' => 0,
                'credit' => $amount,
                'type' => 'Transfer',
                'cat' => '',
                'method' => '',
                'eid' => $eid,
                'note' => 'Transferido por ' . $account['holder'],
                'ext'=>9
            );
           $this->db->insert('transactions', $data);
           $id_transferencia2= $this->db->insert_id();


            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $pay_acc2);
            $this->db->update('accounts');
            $datec = date('Y-m-d');

            $data = array(
                'payerid' => '',
                'payer' => '',
                'acid' => $pay_acc,
                'account' => $account['holder'],
                'date' => $datec,
                'debit' => $amount,
                'credit' => 0,
                'type' => 'Transfer',
                'cat' => '',
                'method' => '',
                'eid' => $eid,
                'note' => 'Transferido a ' . $account2['holder'],
                'ext'=>9
            );

            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $pay_acc);
            $this->db->update('accounts');
$RESULT_TR=$this->db->insert('transactions', $data);
            $this->load->library("Uploadhandler_generic", array(
                'accept_file_types' => '/\.(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i', 'upload_dir' => FCPATH . 'userfiles/attach/', 'upload_url' => base_url() . 'userfiles/attach/'
            ));
            ob_clean();
            $files = (string)$this->uploadhandler_generic->filenaam();
            
            if ($files != '') {

                $this->meta_insert($this->db->insert_id(), 77, $files, "Pago","");
                $this->meta_insert($id_transferencia2, 77, $files, "Pago","");
            }
            return $RESULT_TR;
        }
    }
    public function meta_insert($id, $type, $meta_data, $comp,$id_transfer2)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data, 'col2' => $comp,"col3"=>$id_transfer2);
        if ($id) {
            return $this->db->insert('meta_data', $data);
        } else {
            return 0;
        }
    }


    public function delt($id)
    {
        $this->db->select('acid,credit,debit,tid,ext,cat,payerid,type');
        $this->db->from('transactions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $transaction_var = $query->row_array();
        $amt = $transaction_var['debit'];
		$crt = $transaction_var['credit'];
        $this->db->set('lastbal', "lastbal-$amt", FALSE);
        $this->db->where('id', $transaction_var['acid']);
        $this->db->update('accounts');
		//echo $transaction_var['tid'];
		    


    //validando que sea un transaccion en la que se pague una factura
    if($transaction_var['tid']!=null && $transaction_var['tid']!='' && $transaction_var['tid']!=0){
        if($transaction_var['cat']=="Sales" && $transaction_var['type']!="Expense"){
            $invoice = $this->db->get_where("invoices",array('tid' => $transaction_var['tid']))->row();
            $data_invoice['pamnt']=$invoice->pamnt-$transaction_var['credit'];
            if($data_invoice['pamnt']<=0){
                $data_invoice['pamnt']=0;
                $data_invoice['status']="due";
            }else{
                $data_invoice['status']="partial";
            }

            $this->db->update("invoices",$data_invoice,array('tid' =>$invoice->tid));
        }else if($transaction_var['type']=="Expense"){
                $purchase = $this->db->get_where("purchase",array('tid' => $transaction_var['tid']))->row();
                $data_purchase['pamnt']=$purchase->pamnt-$transaction_var['debit'];
                if($data_purchase['pamnt']<=0){
                    $data_purchase['pamnt']=0;
                    $data_purchase['status']="due";
                }else{
                    $data_purchase['status']="partial";
                }
                $this->db->update("purchase",$data_purchase,array('tid' =>$purchase->tid));
                $transaction_var['ext']=1;
        }

    }

//insertando datos en anulaciones
        $dataa['fecha_hora']=date("Y-m-d 00:00:00");
        $dataa['detalle']=$this->input->post("anulacion");
        $dataa['razon_anulacion']=$this->input->post("razon_anulacion");
        if($dataa['razon_anulacion']==null){
            $dataa['razon_anulacion']="Eliminado desde administrar facturas";
        }
        $dataa['usuario_anula']=$this->aauth->get_user()->username;
        $dataa['transactions_id']=$id;
        $this->db->insert('anulaciones',$dataa);
//actualizando transacciones
        $datat['estado']="Anulada";
        $this->db->update("transactions",$datat,array("id"=>$id));

        $var1="0";
        if(isset($_GET['id_tr'])){
            $var1=$transaction_var['tid'];
        }
        $this->load->model('customers_model', 'customers');
        $this->customers->actualizar_debit_y_credit($transaction_var['payerid']);
        //$this->db->delete('transactions', array('id' => $id));
        return array('status' => 'Success', 'message' => "Transferencia Anulada","id_inv"=>$var1,"cat"=>$transaction_var['cat'],"type"=>$transaction_var['type']);


    }

    public function view($id)
    {
        $this->db->select('*');
        $this->db->from('transactions');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function metodos()
    {
        $query = $this->db->query('SELECT method FROM transactions GROUP BY method');
        return $query->result_array();
    }

    public function cview($id,$ext=0)
    {

		$this->db->select('*');
        if($ext==1){
 $this->db->from('supplier');
		}else{


		
        $this->db->from('customers');
		}
        $this->db->where('id', $id);
		$this->db->join('ciudad', 'customers.ciudad=ciudad.idCiudad', 'left');
        $query = $this->db->get();
        return $query->row_array();

		
    }

    public function cat_details($id)
    {

        $this->db->select('*');
        $this->db->from('transactions_cat');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function cat_update($id, $cat_name)
    {

        $data = array(
            'name' => $cat_name

        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('transactions_cat')) {
            return true;
        } else {
            return false;
        }
    }

    public function check_balance($id)
    {
        $this->db->select('balance');
        $this->db->from('customers');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


}