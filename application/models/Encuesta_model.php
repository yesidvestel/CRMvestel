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

class encuesta_model extends CI_Model
{

    var $table = 'encuestas';
    var $column_order = array(null, 'norden', 'idtec', 'idemp', 'presentacion', 'trato', 'estado', 'tiempo', 'recomendar', 'observacion');
    var $column_search = array('norden', 'idtec', 'idemp', 'presentacion', 'trato', 'estado', 'tiempo', 'recomendar', 'observacion');
    var $trans_column_order = array('user', 'fecha', null);
    var $trans_column_search = array('user', 'fecha');
    var $inv_column_order = array(null, 'tid', 'name', 'invoicedate', 'total', 'status', null);
    var $inv_column_search = array('tid', 'name', 'invoicedate', 'total');
    var $order = array('id' => 'desc');
    var $inv_order = array('purchase.tid' => 'desc');
	var $trans_order = array('formularioats.idats' => 'desc');


    private function _get_datatables_query($id = '')
    {

        $this->db->from($this->table);
        if($id['opcselect']!=''){

            $dateTime= new DateTime($id['sdate']);
            $sdate=$dateTime->format("Y-m-d");
            $dateTime= new DateTime($id['edate']);
            $edate=$dateTime->format("Y-m-d");
            if($id['opcselect']=="fcreada"){
                $this->db->where('fecha>=', $sdate);   
                $this->db->where('fecha<=', $edate);       
            }
            
        }
		if($id['tecnico']!=""){
            $this->db->where('idtec', $id['tecnico']);       
        }
		if($id['realizador']!=""){
            $this->db->where('idemp', $id['realizador']);       
        }
        $i = 0;

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

    function get_datatables($id = '')
    {
        $this->_get_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id = '')
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    public function count_all($id = '')
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function details($custid)
    {

        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('id', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function thread_info($id)
    {
        $this->db->select('tickets.*, customers.id,customers.name,customers.email,customers.nomenclatura,customers.numero1,customers.adicionauno,customers.numero2,customers.adicional2,customers.numero3,customers.documento,customers.barrio,customers.celular,customers.unoapellido,customers.macequipo');
        $this->db->from('tickets');
        $this->db->join('customers', 'tickets.cid=customers.id', 'left');
        $this->db->where('tickets.codigo', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function money_details($custid)
    {

        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('transactions');
        $this->db->where('payerid', $custid);
        $this->db->where('ext', 1);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function info_colaborador()
    {
		$datos = $this->aauth->get_user()->id;
        $this->db->select('employee_profile.*');
        $this->db->from('employee_profile');
		//$this->db->join('aauth_users', 'employee_profile.username=aauth_users.user', 'left');
        $this->db->where('id', $datos);
        $query = $this->db->get();
        return $query->row_array();
    }
	public function detall_colaborador($custid)
    {
		$this->db->select('*');
        $this->db->from('formularioats');
		$this->db->join('employee_profile', 'formularioats.user=employee_profile.id', 'left');
        $this->db->where('idats', $custid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function add($us, $emp, $codigo,$fcha, $detalle, $presentar, $trato, $estado, $tiempo, $recomendar, $obs)
    {
        $data = array(
            'idemp' => $us,
			'idtec' => $emp,
            'norden' => $codigo,
			'fecha' => $fcha,
            'detalle' => $detalle,
            'presentacion' => $presentar,
            'trato' => $trato,
            'estado' => $estado,
            'tiempo' => $tiempo,
            'recomendar' => $recomendar,
            'observacion' => $obs           

        );
			//cambiar estado de tarea
            if($codigo!=null && $codigo!=0){
                    $this->db->set('status', 'Done');
                    $this->db->where('idorden', $codigo);
                    $this->db->update('todolist');    
            }
			
	
        if ($this->db->insert('encuestas', $data)) {
            $cid = $this->db->insert_id();
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED') . ' <a href="' . base_url('encuesta/index') . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a>', 'cid' => $cid));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

	}
	public function addats(
		$us, $ubicacion, $fecha, $lugar, 
		$horain, $horafin, $tarea,$biologico,	
		$biologico2, $biomeca,$biomeca2,$condicion,
		$condicion2,$fenomeno,$fenomeno2,$fisico,
		$fisico2,$psico,$psico2,$quimico,
		$quimico2, $alturas, $casco, $gafas,
		$monogafas, $tapaoidos, $guantes,
		$careta, $arnes, $aux, $eslinga,
		$respirador, $mosquete, $otros,
		$manual1, $manual2, $electro1,$electro2,
		$mecan1,$mecan2,$otras1,$otras2,
		$alto,$acceso,$puntos,$distancia,
		$prevencion,$proteccion,$trabajadores,
		$materiales,$peligros,$peligro_otros,$tarea1,
		$tarea2,$tarea3,$tarea4,$tarea5,$tarea6,
		$tarea7,$tarea8,$riesgo1,$riesgo2,$riesgo3,
		$riesgo4,$riesgo5,$riesgo6,$riesgo7,$riesgo8,
		$consecuencia1,$consecuencia2,$consecuencia3,
		$consecuencia4,$consecuencia5,$consecuencia6,
		$consecuencia7,$consecuencia8,$control1,$control2,
		$control3,$control4,$control5,$control6,$control7,
		$control8,$incidente,$seguro)
    {
	 
		$biomeca2=json_encode($biomeca2);
		$biologico2=json_encode($biologico2);
		$fenomeno2=json_encode($fenomeno2);
		$fisico2=json_encode($fisico2);
		$manual2=json_encode($manual2);
		$electro2=json_encode($electro2);
		$mecan2=json_encode($mecan2);
		$proteccion=json_encode($proteccion);
        $data = array(
            'user' => $us,
			'ubicacion' => $ubicacion,
            'fecha' => $fecha,
            'lugar' => $lugar,
            'horain' => $horain,
            'horafin' => $horafin,
			'tarea' => $tarea,
            'biologico' => $biologico,
			'biologico2' => $biologico2,
			'biomeca' => $biomeca,
			'biomeca2' => $biomeca2,
			'condicion' => $condicion,
			'condicion2' => $condicion2,
			'fenomeno' => $fenomeno,
			'fenomeno2' => $fenomeno2,
			'fisico' => $fisico,
			'fisico2' => $fisico2,
			'psico' => $psico,
			'psico2' => $psico2,
			'quimico' => $quimico,
			'quimico2' => $quimico2,			
            'alturas' => $alturas,
            'gafas' => $gafas,
			'monogafas' => $monogafas,
			'tapaoidos' => $tapaoidos,
			'guantes' => $guantes,
			'careta' => $careta,
			'arnes' => $arnes,
			'1er_aux' => $aux,
			'eslinga' => $eslinga,
			'respirador' => $respirador,
			'mosquete' => $mosquete,
			'otros' => $otros,
			'manual1' => $manual1,
			'manual2' => $manual2,
			'electro1' => $electro1,
			'electro2' => $electro2,
			'mecan1' => $mecan1,
			'mecan2' => $mecan2,
			'otras1' => $otras1,
			'otras2' => $otras2,
			'alto' => $alto,
			'acceso' => $acceso,
			'puntos' => $puntos,
			'distancia' => $distancia,
			'prevencion' => $prevencion,
			'proteccion' => $proteccion,
			'trabajadores' => $trabajadores,
			'materiales' => $materiales,
			'peligros' => $peligros,
			'peligro_otros' => $peligro_otros,
			'tarea1' => $tarea1,
			'tarea2' => $tarea2,
			'tarea3' => $tarea3,
			'tarea4' => $tarea4,
			'tarea5' => $tarea5,
			'tarea6' => $tarea6,
			'tarea7' => $tarea7,
			'tarea8' => $tarea8,
			'riesgo1' => $riesgo1,
			'riesgo2' => $riesgo2,
			'riesgo3' => $riesgo3,
			'riesgo4' => $riesgo4,
			'riesgo5' => $riesgo5,
			'riesgo6' => $riesgo6,
			'riesgo7' => $riesgo7,
			'riesgo8' => $riesgo8,
			'consecuencia1' => $consecuencia1,
			'consecuencia2' => $consecuencia2,
			'consecuencia3' => $consecuencia3,
			'consecuencia4' => $consecuencia4,
			'consecuencia5' => $consecuencia5,
			'consecuencia6' => $consecuencia6,
			'consecuencia7' => $consecuencia7,
			'consecuencia8' => $consecuencia8,
			'control1' => $control1,
			'control2' => $control2,
			'control3' => $control3,
			'control4' => $control4,
			'control5' => $control5,
			'control6' => $control6,
			'control7' => $control7,
			'control8' => $control8,
			'incidente' => $incidente,
			'seguro' => $seguro          

        );
	
        if ($this->db->insert('formularioats', $data)) {
            $cid = $this->db->insert_id();
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED') . ' <a href="' . base_url('encuesta/listats') . '" class="btn btn-info btn-sm"><span class="icon-eye"></span> ' . $this->lang->line('View') . '</a>', 'cid' => $cid));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

	}

    public function edit($idats, $autor)
    {
        $data = array(
            'autoriza' => $autor,
        );


        $this->db->set($data);
        $this->db->where('idats', $idats);

        if ($this->db->update('formularioats')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function editpicture($id, $pic)
    {
        $this->db->select('picture');
        $this->db->from($this->table);
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('supplier')) {

            unlink(FCPATH . 'userfiles/supplier/' . $result['picture']);
            unlink(FCPATH . 'userfiles/supplier/thumbnail/' . $result['picture']);
        }


    }

    public function group_list()
    {
        $query = $this->db->query("SELECT c.*,p.pc FROM customers_group AS c LEFT JOIN ( SELECT gid,COUNT(gid) AS pc FROM supplier GROUP BY gid) AS p ON p.gid=c.id");
        return $query->result_array();
    }

    public function delete($id)
    {

        return $this->db->delete('formularioats', array('idats' => $id));
    }


    //transtables

    function trans_table()
    {
        $this->_get_trans_table_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    private function _get_trans_table_query()
    {

        $this->db->from('formularioats');
		$this->db->join('employee_profile', 'formularioats.user=employee_profile.id', 'left');
        $i = 0;

        foreach ($this->trans_column_search as $item) // loop column
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

                if (count($this->trans_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $search = $this->input->post('trans_order');
        if ($search) // here order processing
        {
            $this->db->order_by($this->trans_column_order[$search['0']['column']], $search['0']['dir']);
        } else if (isset($this->trans_order)) {
            $order = $this->trans_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function trans_count_filtered($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }
        return $query->num_rows($id = '');
    }

    public function trans_count_all($id = '')
    {
        $this->_get_trans_table_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('payerid', $id);
        }


    }

    private function _inv_datatables_query($id)
    {

        $this->db->from('purchase');
        $this->db->where('purchase.csd', $id);
        $this->db->join('supplier', 'purchase.csd=supplier.id', 'left');

        $i = 0;

        foreach ($this->inv_column_search as $item) // loop column
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

                if (count($this->inv_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->inv_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->inv_order)) {
            $order = $this->inv_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function inv_datatables($id)
    {
        $this->_inv_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function inv_count_filtered($id)
    {
        $this->_inv_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function inv_count_all($id)
    {
        $this->db->from('purchase');
        $this->db->where('csd', $id);
        return $this->db->count_all_results();
    }

    public function group_info($id)
    {

        $this->db->from('customers_group');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }


}