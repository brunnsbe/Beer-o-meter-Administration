<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Districts extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_DISTRICT, 	strtolower(MODEL_DISTRICT),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function api_get($districtId = NULL) {
        if($districtId) {
        	$this->_listSingle($districtId);
        } else {
			$this->_listAll();
		}
	}	
	
	function api_post($districtId = NULL) {
		$this->_saveSingle($districtId);
	}
	
	function api_delete($districtId = NULL) {
		$this->_deleteSingle($districtId);
	}
	
	// ######################################################################################################			
	
	function _deleteSingle($districtId) {				
		if (!is_null($districtId) && isGuidValid($districtId)) {
			$this->district->deleteDistrict($districtId);
		} else {
			$this->response(NULL, 400);
		}	
	}	
	
	function _saveSingle($districtId) {		
		//Load the validation library
		$this->load->library('form_validation');	
	
		$httpData = $this->post();
		
		$_POST[DB_DISTRICT_NAME] 		= $httpData[DB_DISTRICT_NAME];
		$_POST[DB_DISTRICT_COUNTRYID]	= $httpData[DB_DISTRICT_COUNTRYID];
		$_POST[DB_DISTRICT_ID] 			= $districtId;
		
		//Validate the fields
		$this->form_validation->set_rules(DB_DISTRICT_NAME,			lang(LANG_KEY_FIELD_NAME),		'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_DISTRICT_COUNTRYID,	lang(LANG_KEY_FIELD_COUNTRY),	'trim|required|callback__checkGuidValid');
		$this->form_validation->set_rules(DB_DISTRICT_ID,			lang(LANG_KEY_FIELD_NAME),		'trim|callback__checkGuidValid');		
		
		if($this->form_validation->run() == FALSE) {
			$this->response("Validation failed", 400);
		} else {
			$data = array(			
				DB_DISTRICT_NAME 	=> $this->input->post(DB_DISTRICT_NAME),
				DB_DISTRICT_COUNTRYID 	=> $this->input->post(DB_DISTRICT_COUNTRYID)
			);		
			
			$this->district->saveDistrict($data, $districtId);		
			if ($districtId) {
				$this->response(null, 200);
			} else {
				$this->response(null, 201);
			}
		}
	}
	
	function _listSingle($districtId) {
		
		$data = $this->district->getDistrict($districtId);
		if ($data) {
			$this->response($data);
		} else {
			$this->response(NULL, 404);		
		}		
	}
	
	function _listAll() {
		$offset = $this->get("offset");
	
		$countryId 		= $this->input->get(DB_DISTRICT_COUNTRYID, TRUE);
		$wildCardSearch = $this->input->get(HTTP_WILDCARDSEARCH, TRUE);		
		
		$data = $this->district->getDistrictList($countryId, $wildCardSearch, 20, $offset);
	
		$this->response($data);	
	}

	// ######################################################################################################		
	
	function _checkGuidValid($guid) {
		if ($guid != "" && !isGuidValid($guid)) {
			$this->form_validation->set_message('_checkGuidValid', lang(LANG_KEY_ERROR_INVALID_GUID) . '%s');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}