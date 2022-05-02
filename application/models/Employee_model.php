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

class Employee_model extends CI_Model
{

    
    var $column_order2 = array('employee_profile.id','employee_profile.name', 'aauth_users.roleid', 'aauth_users.banned', 'aauth_users.last_login');
    var $column_search2 = array('employee_profile.name', 'aauth_users.roleid', 'aauth_users.banned', 'aauth_users.last_login');
    var $order2 = array('aauth_users.roleid' => 'asc');
    

 private function _get_datatables_query2()
    {

        
        $this->db->select('employee_profile.*,aauth_users.banned,aauth_users.last_login,aauth_users.roleid');
        $this->db->from('employee_profile');
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $this->db->join("empleados_moviles"," empleados_moviles.id_empleado=employee_profile.id","left");
        if($_POST['tb']=="2"){
            $this->db->where("empleados_moviles.id_movil",$_POST['id_m_temporal']);    
        }else{
            $this->db->where('employee_profile.id not in ((SELECT id_empleado from empleados_moviles where id_movil='.$_POST['id_m_temporal'].'))');
            //$this->db->where("empleados_moviles.id_movil !=",$_POST['id_m_temporal']);    
            //$this->db->where("empleados_moviles.id !=","");    
            //$this->db->or_where('empleados_moviles.id_movil');
        }
        

        
        $i = 0;
        foreach ($this->column_search2 as $item) // loop column
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

                if (count($this->column_search2) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order2)) {
            $order = $this->order2;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        $this->db->group_by("employee_profile.id"); 
    }
    function get_datatables1()
    {
        $this->_get_datatables_query2();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered2()
    {
        $this->_get_datatables_query2();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all2()
    {
        $this->_get_datatables_query2();
        $query = $this->db->get();      
        return $query->num_rows();
    }
    public function list_employee()
    {
        $this->db->select('employee_profile.*,aauth_users.banned,aauth_users.last_login,aauth_users.roleid');
        $this->db->from('employee_profile');
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $this->db->order_by('aauth_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function list_project_employee($id)
    {
        $this->db->select('employee_profile.*');
        $this->db->from('project_meta');
        $this->db->where('project_meta.pid', $id);
        $this->db->where('project_meta.meta_key', 19);
        $this->db->join('employee_profile', 'employee_profile.id = project_meta.meta_data', 'left');
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $this->db->order_by('aauth_users.roleid', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function employee_details($id)
    {
        $this->db->select('employee_profile.*,aauth_users.*');
        $this->db->from('employee_profile');
        $this->db->where('employee_profile.id', $id);
        $this->db->join('aauth_users', 'employee_profile.id = aauth_users.id', 'left');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_employee(
		$id, $name,$dto,$ingreso,$rh,$eps,$pensiones, 
		$phone, $phonealt, $address, $city, $region, $country,
		$roleid,$co,$coape,$conue,$coadm,
		$cocie,$cofa,$cofae,$us,$usnue,$usadm,$usgru,
		$tik,$tiknue,$tikadm,$mo,$monue,$moadm,$pro,
		$pronue,$proadm,$enc,$encllam,$encnue,$encenc,
		$encats,$encatslis,$proy,$proynue,$proyadm,
		$cuen,$cuenadm,$cuennue,$cuenbal,$cuendec,
		$red,$reding,$redadm,$redbod,$com,$comnue,
		$comadm,$tes,$testran,$tesanu,$tesnuetransac,
		$tesnuetransfer,$tesing,$tesgas,$testransfer,
		$dat,$datest,$datdec,$datrep,$datusu,$datpro,
		$dating,$datgas,$dattrans,$datimp,$not,$cal,
		$doct,$pag,$pagconf,$pagvia,$pagmon,$pagcam,
		$pagban,$inv,$inving,$invadm,$invcat,$invalm,
		$invtrs,$emp,$comp,$comprec,$compurl,$comptwi,
		$compcurr,$pla,$placor,$plamen,$platem,$conf,
		$confemp,$conffa,$confmon,$conffec,$confcat,
		$confmet,$confrest,$confcorr,$confterm,$confaut,
		$confseg,$conftem,$confsop,$conface,$confupt,
		$confapi,$tar,$dathistorial,$datservicios,$conotas)
    {
        $data = array(
            'name' => $name,
			'dto' => $dto,
			'ingreso' => $ingreso,
			'rh' => $rh,
			'eps' => $eps,
			'pensiones' => $pensiones,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
        );


        $this->db->set($data);
        $this->db->where('id', $id);
		

        if ($this->db->update('employee_profile')) {
			$antrol=$this->db->get_where('aauth_users',array('id'=>$id))->row();
				if ($roleid == ''){
					$roleid2 = $antrol->roleid;
				}else{
					$roleid2 = $roleid;
				}
			 $data1 = array(
                'roleid' => $roleid2,
				'co'=>$co,
				'coape'=>$coape,
				'conue'=>$conue,
				'coadm'=>$coadm,
				'cocie'=>$cocie,
				'cofa'=>$cofa,
				'cofae'=>$cofae,
				'us'=>$us,
				'usnue'=>$usnue,
				'usadm'=>$usadm,
				'usgru'=>$usgru,
				'tik'=>$tik,
				'tiknue'=>$tiknue,
				'tikadm'=>$tikadm,
				'mo'=>$mo,
				'monue'=>$monue,
				'moadm'=>$moadm,
				'pro'=>$pro,
				'pronue'=>$pronue,
				'proadm'=>$proadm,
				'enc'=>$enc,
				'encllam'=>$encllam,
				'encnue'=>$encnue,
				'encenc'=>$encenc,
				'encats'=>$encats,
				'encatslis'=>$encatslis,
				'proy'=>$proy,
				'proynue'=>$proynue,
				'proyadm'=>$proyadm,
				'cuen'=>$cuen,
				'cuenadm'=>$cuenadm,
				'cuennue'=>$cuennue,
				'cuenbal'=>$cuenbal,
				'cuendec'=>$cuendec,
				'red'=>$red,
				'reding'=>$reding,
				'redadm'=>$redadm,
				'redbod'=>$redbod,
				'comp'=>$com,
				'comnue'=>$comnue,
				'comadm'=>$comadm,
				'tes'=>$tes,
				'testran'=>$testran,
				'tesanu'=>$tesanu,
				'tesnuetransac'=>$tesnuetransac,
				'tesnuetransfer'=>$tesnuetransfer,
				'tesing'=>$tesing,
				'tesgas'=>$tesgas,
				'testransfer'=>$testransfer,
				'dat'=>$dat,
				'datest'=>$datest,
				'datdec'=>$datdec,
				'datrep'=>$datrep,
				'datusu'=>$datusu,
				'datpro'=>$datpro,
				'dating'=>$dating,
				'datgas'=>$datgas,
				'dattrans'=>$dattrans,
				'datimp'=>$datimp,
				'not'=>$not,
				'cal'=>$cal,
				'doct'=>$doct,
				'pag'=>$pag,
				'pagconf'=>$pagconf,
				'pagvia'=>$pagvia,
				'pagmon'=>$pagmon,
				'pagcam'=>$pagcam,
				'pagban'=>$pagban,
				'inv'=>$inv,
				'inving'=>$inving,
				'invadm'=>$invadm,
				'invcat'=>$invcat,
				'invalm'=>$invalm,
				'invtrs'=>$invtrs,
				'emp'=>$emp,
				'com'=>$comp,
				'comprec'=>$comprec,
				'compurl'=>$compurl,
				'comptwi'=>$comptwi,
				'compcurr'=>$compcurr,
				'pla'=>$pla,
				'placor'=>$placor,
				'plamen'=>$plamen,
				'platem'=>$platem,
				'conf'=>$conf,
				'confemp'=>$confemp,
				'conffa'=>$conffa,
				'confmon'=>$confmon,
				'conffec'=>$conffec,
				'confcat'=>$confcat,
				'confmet'=>$confmet,
				'confrest'=>$confrest,
				'confcorr'=>$confcorr,
				'confterm'=>$confterm,
				'confaut'=>$confaut,
				'confseg'=>$confseg,
				'conftem'=>$conftem,
				'confsop'=>$confsop,
				'conface'=>$conface,
				'confupt'=>$confupt,
				'confapi'=>$confapi,
                'conotas'=>$conotas,
                'dathistorial'=>$dathistorial,
                'datservicios'=>$datservicios,
				'tar'=>$tar
            );

            $this->db->set($data1);
            $this->db->where('id', $id);

            $this->db->update('aauth_users');
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }
	 public function update_user(
		$id, $name,$dto,$ingreso,$rh,$eps,$pensiones, 
		$phone, $phonealt, $address, $city, $region, $country
		)
    {
        $data = array(
            'name' => $name,
			'dto' => $dto,
			'ingreso' => $ingreso,
			'rh' => $rh,
			'eps' => $eps,
			'pensiones' => $pensiones,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('employee_profile')) {
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('UPDATED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function update_password($id, $cpassword, $newpassword, $renewpassword)
    {
        $data = array(
            'name' => $name,
            'phone' => $phone,
            'phonealt' => $phonealt,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'postbox' => $postbox
        );


        $this->db->set($data);
        $this->db->where('id', $id);

        if ($this->db->update('employee_profile')) {
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
        $this->db->from('employee_profile');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'picture' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('employee_profile')) {
            $this->db->set($data);
            $this->db->where('id', $id);
            $this->db->update('aauth_users');
            unlink(FCPATH . 'userfiles/employee/' . $result['picture']);
            unlink(FCPATH . 'userfiles/employee/thumbnail/' . $result['picture']);
        }


    }


    public function editsign($id, $pic)
    {
        $this->db->select('sign');
        $this->db->from('employee_profile');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $result = $query->row_array();


        $data = array(
            'sign' => $pic
        );


        $this->db->set($data);
        $this->db->where('id', $id);
        if ($this->db->update('employee_profile')) {

            unlink(FCPATH . 'userfiles/employee_sign/' . $result['sign']);
            unlink(FCPATH . 'userfiles/employee_sign/thumbnail/' . $result['sign']);
        }


    }


    var $table = 'invoices';
    var $column_order = array(null, 'invoices.tid', 'invoices.invoicedate', 'invoices.total', 'invoices.status');
    var $column_search = array('invoices.tid', 'invoices.invoicedate', 'invoices.total', 'invoices.status');
    var $order = array('invoices.tid' => 'asc');


    private function _invoice_datatables_query($id)
    {

        $this->db->from('invoices');
        $this->db->where('invoices.eid', $id);
        $this->db->join('customers', 'invoices.csd=customers.id', 'left');

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

    function invoice_datatables($id)
    {
        $this->_invoice_datatables_query($id);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function invoicecount_filtered($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('invoices.eid', $id);
        }
        return $query->num_rows($id);
    }

    public function invoicecount_all($id)
    {
        $this->_invoice_datatables_query($id);
        $query = $this->db->get();
        if ($id != '') {
            $this->db->where('invoices.eid', $id);
        }
        return $query->num_rows($id = '');
    }

    //transaction


    var $tcolumn_order = array(null, 'account', 'type', 'cat', 'amount', 'stat');
    var $tcolumn_search = array('id', 'account');
    var $torder = array('id' => 'asc');
    var $eid = '';

    private function _get_datatables_query()
    {

        $this->db->from('transactions');

        $this->db->where('eid', $this->eid);


        $i = 0;

        foreach ($this->tcolumn_search as $item) // loop column
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

                if (count($this->tcolumn_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->tcolumn_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->torder)) {
            $order = $this->torder;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($eid)
    {
        $this->eid = $eid;
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->db->from('transactions');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from('transactions');
        $this->db->where('eid', $this->eid);
        return $this->db->count_all_results();
    }


    public function add_employee(
		$id, $username, $name,$dto,$ingreso,$rh,
		$eps,$pensiones, $roleid, $phone, 
		$address, $city, $region, $country,
		$co,$coape,$conue,$coadm,
		$cocie,$cofa,$cofae,$us,$usnue,$usadm,$usgru,
		$tik,$tiknue,$tikadm,$mo,$monue,$moadm,$pro,
		$pronue,$proadm,$enc,$encllam,$encnue,$encenc,
		$encats,$encatslis,$proy,$proynue,$proyadm,
		$cuen,$cuenadm,$cuennue,$cuenbal,$cuendec,
		$red,$reding,$redadm,$redbod,$com,$comnue,
		$comadm,$tes,$testran,$tesanu,$tesnuetransac,
		$tesnuetransfer,$tesing,$tesgas,$testransfer,
		$dat,$datest,$datdec,$datrep,$datusu,$datpro,
		$dating,$datgas,$dattrans,$datimp,$not,$cal,
		$doct,$pag,$pagconf,$pagvia,$pagmon,$pagcam,
		$pagban,$inv,$inving,$invadm,$invcat,$invalm,
		$invtrs,$emp,$comp,$comprec,$compurl,$comptwi,
		$compcurr,$pla,$placor,$plamen,$platem,$conf,
		$confemp,$conffa,$confmon,$conffec,$confcat,
		$confmet,$confrest,$confcorr,$confterm,$confaut,
		$confseg,$conftem,$confsop,$conface,$confupt,
		$confapi,$tar,$dathistorial,$conotas)
    {
        $data = array(
            'id' => $id,
            'username' => $username,
            'name' => $name,
			'dto' => $dto,
			'ingreso' => $ingreso,
			'rh' => $rh,
			'eps' => $eps,
			'pensiones' => $pensiones,
            'address' => $address,
            'city' => $city,
            'region' => $region,
            'country' => $country,
            'phone' => $phone
        );


        if ($this->db->insert('employee_profile', $data)) {
            $data1 = array(
                'roleid' => $roleid,
				'co'=>$co,
				'coape'=>$coape,
				'conue'=>$conue,
				'coadm'=>$coadm,
				'cocie'=>$cocie,
				'cofa'=>$cofa,
				'cofae'=>$cofae,
				'us'=>$us,
				'usnue'=>$usnue,
				'usadm'=>$usadm,
				'usgru'=>$usgru,
				'tik'=>$tik,
				'tiknue'=>$tiknue,
				'tikadm'=>$tikadm,
				'mo'=>$mo,
				'monue'=>$monue,
				'moadm'=>$moadm,
				'pro'=>$pro,
				'pronue'=>$pronue,
				'proadm'=>$proadm,
				'enc'=>$enc,
				'encllam'=>$encllam,
				'encnue'=>$encnue,
				'encenc'=>$encenc,
				'encats'=>$encats,
				'encatslis'=>$encatslis,
				'proy'=>$proy,
				'proynue'=>$proynue,
				'proyadm'=>$proyadm,
				'cuen'=>$cuen,
				'cuenadm'=>$cuenadm,
				'cuennue'=>$cuennue,
				'cuenbal'=>$cuenbal,
				'cuendec'=>$cuendec,
				'red'=>$red,
				'reding'=>$reding,
				'redadm'=>$redadm,
				'redbod'=>$redbod,
				'comp'=>$com,
				'comnue'=>$comnue,
				'comadm'=>$comadm,
				'tes'=>$tes,
				'testran'=>$testran,
				'tesanu'=>$tesanu,
				'tesnuetransac'=>$tesnuetransac,
				'tesnuetransfer'=>$tesnuetransfer,
				'tesing'=>$tesing,
				'tesgas'=>$tesgas,
				'testransfer'=>$testransfer,
				'dat'=>$dat,
				'datest'=>$datest,
				'datdec'=>$datdec,
				'datrep'=>$datrep,
				'datusu'=>$datusu,
				'datpro'=>$datpro,
				'dating'=>$dating,
				'datgas'=>$datgas,
				'dattrans'=>$dattrans,
				'datimp'=>$datimp,
				'not'=>$not,
				'cal'=>$cal,
				'doct'=>$doct,
				'pag'=>$pag,
				'pagconf'=>$pagconf,
				'pagvia'=>$pagvia,
				'pagmon'=>$pagmon,
				'pagcam'=>$pagcam,
				'pagban'=>$pagban,
				'inv'=>$inv,
				'inving'=>$inving,
				'invadm'=>$invadm,
				'invcat'=>$invcat,
				'invalm'=>$invalm,
				'invtrs'=>$invtrs,
				'emp'=>$emp,
				'com'=>$comp,
				'comprec'=>$comprec,
				'compurl'=>$compurl,
				'comptwi'=>$comptwi,
				'compcurr'=>$compcurr,
				'pla'=>$pla,
				'placor'=>$placor,
				'plamen'=>$plamen,
				'platem'=>$platem,
				'conf'=>$conf,
				'confemp'=>$confemp,
				'conffa'=>$conffa,
				'confmon'=>$confmon,
				'conffec'=>$conffec,
				'confcat'=>$confcat,
				'confmet'=>$confmet,
				'confrest'=>$confrest,
				'confcorr'=>$confcorr,
				'confterm'=>$confterm,
				'confaut'=>$confaut,
				'confseg'=>$confseg,
				'conftem'=>$conftem,
				'confsop'=>$confsop,
				'conface'=>$conface,
				'confupt'=>$confupt,
				'confapi'=>$confapi,
                'conotas'=>$conotas,
                'dathistorial'=>$dathistorial,
				'tar'=>$tar
            );

            $this->db->set($data1);
            $this->db->where('id', $id);

            $this->db->update('aauth_users');
            echo json_encode(array('status' => 'Success', 'message' =>
                $this->lang->line('ADDED')));
        } else {
            echo json_encode(array('status' => 'Error', 'message' =>
                $this->lang->line('ERROR')));
        }

    }

    public function employee_validate($email)
    {
        $this->db->select('*');
        $this->db->from('aauth_users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function money_details($eid)
    {
        $this->db->select('SUM(debit) AS debit,SUM(credit) AS credit');
        $this->db->from('transactions');
        $this->db->where('eid', $eid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function sales_details($eid)
    {
        $this->db->select('SUM(pamnt) AS total');
        $this->db->from('invoices');
        $this->db->where('eid', $eid);
        $query = $this->db->get();
        return $query->row_array();
    }


}