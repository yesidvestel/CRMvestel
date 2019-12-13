<?php
/**
 * Geo POS -  Accounting,  Invoicing  and CRM Application
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

class Webupdate Extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }


    }

    public function index()
    {
        $head['title'] = "Update";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('update/update');
        $this->load->view('fixed/footer');

    }

    public function download_update($ver=0)
    {
        $url=file_get_contents(FCPATH.'/version.json');
        $version=json_decode($url, true);
        $this->session->set_userdata('build',$version['build']);
        $this->session->set_userdata('step',0);
        $next_version=$version['build']+1;
        $this->session->set_userdata('upto',true);
        if($version['build']) {
            echo '<h5>Download Update</h5>';
            echo '<pre>';
            echo '
        
        License is valid....
        
	';
            echo 'Downloading update files from server...
        
	';
            $url = UPDATE_SERVICE."update_" . $next_version . ".zip";

            $zipFile = 'userfiles/update_' . $next_version . '.zip'; // Local Zip File Path
            $zipResource = fopen($zipFile, "w");
// Get The Zip File From Server
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FAILONERROR, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FILE, $zipResource);
            $page = curl_exec($ch);
            if (!$page) {
                //echo "Error :- ".curl_error($ch);
                $this->session->set_userdata('upto',false);
                exit('Your application is already up to date. Version is '.$version['version']);

            } else {
                echo 'Update files downloaded from server...
            
	';
            }
            curl_close($ch);

            echo '
        Extracting downloaded files...
        
	';
            $extractPath = 'userfiles/temp/up' . $next_version;
            if (!mkdir($extractPath, 0777, true)) {

                if(file_exists($extractPath)){

                }
                else {
                      exit('Failed to create folders...');
                }

            }
            $zip = new ZipArchive;

            if ($zip->open($zipFile) != "true") {
                echo "
            Error :- Extracting failed! Limited Permissions 
            
 ";
                exit('Update Process Halted! Update Extraction failed');
            }
            /* Extract Zip File */
            if ($zip->extractTo($extractPath)) {
                echo "Success :- Extracting Success!
";
                echo '</pre>';
                echo '<h5>Update Downloaded!</h5>';
            } else {
                echo '</pre>';
            }


            $zip->close();
        }

    }
    public function install_update(){

       $build= $this->session->userdata('build');
       $upto= $this->session->userdata('upto');
       $build=$build+1;
       if($build && $upto){

        echo'<h5>Installing Update</h5>';
echo'<pre>';
	echo '
	Updating files in your system... '.$build.'
	';
$url=file_get_contents(FCPATH.'userfiles/temp/up'.$build.'/files.json');

$files=json_decode($url, true);

$i=0;
$count_f= count($files);
$b=0;
echo 'File backup process started...
	';
$last_build=$build-1;
foreach($files as $row){

echo '
'.    FCPATH.$row['path'].$row['file'].'
';
if(copy(FCPATH.$row['path'].$row['file'],'userfiles/temp/up'.$build.'/'.$row['path'].'bak_v_'.$last_build.'_'.$row['file'])){
$b++;
echo 'Ok
    ';
}
else{
	$z=$b+1;
echo 'Files backup failed ... File number '.$z.'
	';
	exit('Update Process Halted! Files backup failed');
}
}
//update files
$f=0;
	echo '
	File update process started...
	';

foreach($files as $row){

echo '
'.    FCPATH.$row['path'].$row['file'].'
';
if(copy('userfiles/temp/up'.$build.'/'.$row['path'].$row['file'], $row['path'].$row['file'])){

    echo 'Ok
    ';

$f++;
}
else{
	$z=$f+1;
echo '
Files update failed ... File number '.$z.'
	';
}
}

if($count_f=$f)
	{
 $this->session->set_userdata('dbupdate',true);
 $this->session->set_userdata('step',2);
   echo'<h5>Files Updated!</h5>';
}
else{
echo '
Some Files update failed ... Update Failed!
	';
		exit('Update Process Halted! Files update failed');
}
}
else {
      exit('Your application is already up to date.');
}

echo'
</pre>';
    }

    public function update_db(){

       $ver= $this->session->userdata('build');
       $upto= $this->session->userdata('upto');
       $ver=$ver+1;
       if($ver && $upto){
      $bdate = 'backup_' . date('Y_m_d_H_i_s');
        $this->load->dbutil();
        $backup =& $this->dbutil->backup();
        $this->load->helper('file');
        write_file(FCPATH.'userfiles/temp/'.$bdate . '.gz', $backup);
echo'
<pre>';
echo 'Database Update Process Started...
	';

// Set the url
 $url=file_get_contents(FCPATH.'userfiles/temp/up'.$ver.'/update.sql');


  $mysqli = @new mysqli($this->db->hostname, $this->db->username,  $this->db->password,  $this->db->database);
    if (mysqli_connect_errno()) {
        echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
        exit();
    }
	   $mysqli->multi_query($url);
    do {

    } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));


if($mysqli->close()){
echo 'Database Update Done...
	';
echo'
</pre>';
$this->session->set_userdata('step',0);
}
       }

else {
      exit('Your application is already up to date.');
}

    }


}