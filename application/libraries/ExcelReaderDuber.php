<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/lib_excel_reader/autoload.php';

/**
 * 
 */
class ExcelReaderDuber 
{
	
	function __construct()
	{
		// code...
	}
	public function get_reader(){
		$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
		return $reader;
	}
}