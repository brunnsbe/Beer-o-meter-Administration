<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class LanguageKeys extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_LANGUAGE, 	strtolower(MODEL_LANGUAGE),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}

	function api_get() {
		$languageCode = $this->input->get("lang");
		$languagesFromDB = $this->language->getLanguageList(FALSE, $languageCode, FALSE, FALSE, FALSE);	
		
		$data = array();
		foreach($languagesFromDB as $key => $row) {
			$data[$row->{DB_LANGUAGE_LANGUAGEKEY}] = $row->{DB_LANGUAGE_DATA};
		}
		
		$this->response($data);	
	}
}