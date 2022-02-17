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

class Ticket_model extends CI_Model
{


    //documents list
	var $table = 'customers';
    var $doccolumn_order = array(null, null, 'codigo', 'subject', 'detalle', 'created','fecha_final','abonado','documento', 'id_factura', 'ciudad','status', null);
    var $doccolumn_search = array('idt', 'codigo', 'detalle', 'created', 'abonado', 'id_factura', 'ciudad.ciudad','barrio.barrio','status');


    public function thread_list($id)
    {
        $this->db->select('tickets_th.*,customers.name AS custo,employee_profile.name AS emp');
        $this->db->from('tickets_th');
        $this->db->join('customers', 'tickets_th.cid=customers.id', 'left');
        $this->db->join('employee_profile', 'tickets_th.eid=employee_profile.id', 'left');
        $this->db->where('tickets_th.tid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    private function send_email($mailto, $mailtotitle, $subject, $message, $attachmenttrue = false, $attachment = '')
    {
        $this->load->library('ultimatemailer');
        $this->db->select('host,port,auth,auth_type,username,password,sender');
        $this->db->from('sys_smtp');
        $query = $this->db->get();
        $smtpresult = $query->row_array();
        $host = $smtpresult['host'];
        $port = $smtpresult['port'];
        $auth = $smtpresult['auth'];
		 $auth_type = $smtpresult['auth_type'];
        $username = $smtpresult['username'];;
        $password = $smtpresult['password'];
        $mailfrom = $smtpresult['sender'];
        $mailfromtilte = $this->config->item('ctitle');

        $this->ultimatemailer->bin_send($host, $port, $auth,$auth_type, $username, $password, $mailfrom, $mailfromtilte, $mailto, $mailtotitle, $subject, $message, $attachmenttrue, $attachment);

    }

    public function thread_info($id)
    {
        $this->db->select('tickets.*, customers.id,customers.abonado,customers.name,customers.dosnombre,customers.dosapellido,customers.email,customers.ciudad,customers.nomenclatura,customers.numero1,customers.adicionauno,customers.numero2,customers.adicional2,customers.numero3,customers.documento,customers.barrio,customers.celular,customers.referencia,customers.residencia,customers.unoapellido,customers.macequipo');
        $this->db->from('tickets');
        $this->db->join('customers', 'tickets.cid=customers.id', 'left');
        $this->db->where('tickets.idt', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function thread_agen($codigo)
    {
        $this->db->select('*');
        $this->db->from('events');        
        $this->db->where('events.idorden', $codigo);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function barrios_list($id)
    { 
		$this->db->select('*');
        $this->db->from('barrio');
        $this->db->where('idLocalidad', $id);
        $query = $this->db->get();
        return $query->result_array(); 
    }
	public function group_barrio($id)
    {

        $this->db->from('barrio');
        $this->db->where('idBarrio', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function details($thread_id)
    {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $thread_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function ticket()
    {
        $this->db->select('*');
        $this->db->from('univarsal_api');
        $this->db->where('id', 3);
        $query = $this->db->get();
        return $query->row();
    }
	public function tecnico_list()
    {
        //$query = $this->db->query("SELECT id,username FROM aauth_users WHERE UPPER(roleid) >= '1'");
		$sedeacc = $this->aauth->get_user()->sede_accede;
		$this->db->select('aauth_users.*,employee_profile.id,employee_profile.name,employee_profile.dto');
        $this->db->from('aauth_users');
		$this->db->join('employee_profile', 'aauth_users.id=employee_profile.id', 'left');
        //$this->db->where('roleid', '2');
		if ($sedeacc != '0'){
			$this->db->where('sede_accede', $sedeacc);
			$this->db->or_where('sede_accede', '0');
		}
        $this->db->order_by("username");
        $query = $this->db->get();
        return $query->result_array();		
		
    }
	public function factura_list($custid)
    {
        $query = $this->db->query('SELECT id, tid, invoicedate FROM invoices WHERE tipo_factura="Recurrente" AND csd=\''.$custid.'\'');
        return $query->result_array();
		
    }

    function addreply($thread_id, $message, $filename)
    {
        $data = array('tid' => $thread_id, 'message' => $message, 'cid' => 0, 'eid' => $this->aauth->get_user()->id, 'cdate' => date('Y-m-d H:i:s'), 'attach' => $filename);
        if ($this->ticket()->key2) {

            $customer = $this->thread_info($thread_id);

            //$this->send_email($customer['email'], $customer['name'], '[Customer Ticket] #' . $thread_id, $message . $this->ticket()->other, $attachmenttrue = false, $attachment = '');

        }
        return $this->db->insert('tickets_th', $data);

    }

    function deleteticket($id)
    {
        $this->db->delete('tickets', array('idt' => $id));

        $this->db->select('attach');
        $this->db->from('tickets_th');
        $this->db->where('tid', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $row) {
            if ($row['attach'] != '') {

                unlink(FCPATH . 'userfiles/support/' . $row['attach']);

            }
        }
		
        $this->db->delete('tickets_th', array('tid' => $id));
        return true;
    }
	function deletedoc($id)
    {
        $this->db->delete('tickets_th', array('id' => $id));

        $this->db->select('attach');
        $this->db->from('tickets_th');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        foreach ($result as $row) {
            if ($row['attach'] != '') {

                unlink(FCPATH . 'userfiles/support/' . $row['attach']);

            }
        }
        $this->db->delete('tickets_th', array('id' => $id));
        return true;
    }

    public function ticket_stats()
    {

        $query = $this->db->query("SELECT
				COUNT(IF( status = 'Pendiente', idt, NULL)) AS Pendiente,
				COUNT(IF( status = 'Realizando', idt, NULL)) AS Realizando,
				COUNT(IF( status = 'Resuelto', idt, NULL)) AS Resuelto
				FROM tickets ");
        echo json_encode($query->result_array());

    }
 

    function ticket_datatables($filt,$filt2)
    {
        $this->ticket_datatables_query($filt,$filt2);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    private function ticket_datatables_query($filt,$filt2)
    {
       //$this->db->select("*,");
        $this->db->from('tickets');
         if ($filt2['estado'] != '' && $filt2['estado'] != 'null' && $filt2['estado'] != null) {
            $this->db->where_in('status', explode(",", $filt2['estado']));       
        }
        if($filt2['tecnico']!='' && $filt2['tecnico']!='0' && $filt2['tecnico']!='undefined' && $filt2['tecnico']!=null && $filt2['tecnico']!="null"){
            if(strpos($filt2['tecnico'],"Sin Asignar")!==false){
             $filt2['tecnico']= str_replace("Sin Asignar", "", $filt2['tecnico']);   
            }
            $this->db->where_in('asignado', explode(",", $filt2['tecnico']));       
        }
        
        if($filt2['opcselect']!=''){

            $dateTime= new DateTime($filt2['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($filt2['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($filt2['opcselect']=="fcreada"){
                $this->db->where('created>=', $sdate);   
                $this->db->where('created<=', $edate);       
            }else{
                $this->db->where('fecha_final>=', $sdate);   
                $this->db->where('fecha_final<=', $edate);       
            }
            
        }

        if($filt2['sede_filtrar']!="" && $filt2['sede_filtrar']!=null && $filt2['sede_filtrar']!="null"){
            $this->db->where_in('gid', explode(",", $filt2['sede_filtrar']));       
        }
		if($filt2['detalle']!="" && $filt2['detalle']!=null && $filt2['detalle']!="null"){
            $this->db->where_in('detalle', explode(",", $filt2['detalle']));       
        }
		$this->db->join('customers', 'tickets.cid=customers.id', 'left');
		$this->db->join('ciudad', 'customers.ciudad=ciudad.idCiudad', 'left');
		$this->db->join('barrio', 'customers.barrio=barrio.idBarrio', 'left');
        $i = 0;

        foreach ($this->doccolumn_search as $item) // loop column
        {
            $search = $this->input->post('search');
            $value = $search['value'];
            if ($value) {

                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $value);
                } else {
                    $this->db->or_like($item, $value);
                }

                if (count($this->doccolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('order');
        if ($search) {
            $this->db->order_by($this->doccolumn_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function ticket_count_filtered($filt)
    {
		 $x_prueba=array('estado'=>"",'tecnico'=>"");
        $this->ticket_datatables_query($filt,$_GET);
        $query = $this->db->get();
        return $query->num_rows();
    }
	 public function get_ticfiltrado($tec, $trans_type)
    {

        if ($trans_type == 'All') {
            $where = "asignado='$tec'";
        } else {
            $where = "asignado='$tec' AND status='$trans_type'";
        }
		$this->db->join('customers', 'tickets.cid=customers.id', 'left');
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where($where);
        //  $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    public function ticket_count_all($filt)
    {   $x_prueba=array('estado'=>"",'tecnico'=>"");
        $this->ticket_datatables_query($filt,$_GET);
        $query = $this->db->get();
        return $query->num_rows();
    }
	function addticket($subject, $message, $filename)
    {
        $data = array('subject' => $subject, 'created' => date('Y-m-d H:i:s'), 'cid' => $this->session->userdata('user_details')[0]->cid, 'status' => 'Waiting');
        $this->db->insert('tickets', $data);
        $thread_id = $this->db->insert_id();


        $data = array('tid' => $thread_id, 'message' => $message, 'cid' => $this->session->userdata('user_details')[0]->cid, 'eid' => 0, 'cdate' => date('Y-m-d H:i:s'), 'attach' => $filename);
        if ($this->ticket()->key2) {


            $this->send_email($this->ticket()->url, $this->ticket()->name, '[Customer Ticket] #' . $thread_id, $message, $attachmenttrue = false, $attachment = '');

        }

        return $this->db->insert('tickets_th', $data);


    }
	public function meta_insert($id, $type, $meta_data)
    {

        $data = array('type' => $type, 'rid' => $id, 'col1' => $meta_data);
        if ($id) {
            return $this->db->insert('meta_data', $data);
        } else {
            return 0;
        }
    }

    public function attach($id)
    {
        $this->db->select('meta_data.*');
        $this->db->from('meta_data');
        $this->db->where('meta_data.type', 5);
        $this->db->where('meta_data.rid', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function meta_delete($id,$type,$name)
    {
        if (@unlink(FCPATH . 'userfiles/attach/' . $name)) {
            return $this->db->delete('meta_data', array('rid' => $id, 'type' => $type, 'col1' => $name));
        }
    }


}