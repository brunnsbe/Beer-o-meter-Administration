<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class LanguageCodes extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_LANGUAGECODE, 	strtolower(MODEL_LANGUAGECODE),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function api_get() {
		$countryId = $this->input->get(DB_COUNTRY_HAS_LANGUAGECODE_COUNTRYID, TRUE);
	
		$data = $this->languagecode->getLanguageCodeList($countryId);			
		$this->response($data);	
	}	
}