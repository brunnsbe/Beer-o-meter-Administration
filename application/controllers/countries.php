<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Countries extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_COUNTRY, 		strtolower(MODEL_COUNTRY),		TRUE);
		$this->load->model(MODEL_LANGUAGECODE, 	strtolower(MODEL_LANGUAGECODE),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function api_get($countryId = NULL) {
        if($countryId) {
        	$this->_listSingle($countryId);
        } else {
			$this->_listAll();
		}
	}	
	
	function api_post($countryId = NULL) {
		$this->_saveSingle($countryId);
	}
	
	function api_delete($countryId = NULL) {
		$this->_deleteSingle($countryId);
	}
	
	// ######################################################################################################		

	function _saveSingle($countryId = NULL) {
		//Load the validation library
		$this->load->library('form_validation');	
	
		$httpData = $this->post();
		
		$_POST[DB_COUNTRY_NAME]	= $httpData[DB_COUNTRY_NAME];		
		$_POST[DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID . '[]'] = $httpData[DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID];
		$_POST[DB_COUNTRY_ID]	= $countryId;
		
		//Validate the fields
		$this->form_validation->set_rules(DB_COUNTRY_NAME,										lang(LANG_KEY_FIELD_NAME),	'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID . '[]',	lang(LANG_KEY_FIELD_NAME),	'trim|callback__checkGuidValid');		
		$this->form_validation->set_rules(DB_LANGUAGE_ID,										lang(LANG_KEY_FIELD_NAME),	'trim|callback__checkGuidValid');		
		
		if($this->form_validation->run() == FALSE) {
			$this->response("Validation failed", 400);
		} else {
			$data = array(			
				DB_COUNTRY_NAME => $this->input->post(DB_COUNTRY_NAME)
			);		
			
			$this->country->saveCountry($data, $countryId, $this->input->post(DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID . '[]'));			
			
			if ($countryId) {
				$this->response(null, 200);
			} else {
				$this->response(null, 201);
			}
		}
	}	
		
	function _deleteSingle($countryId) {				
		if (!is_null($countryId) && isGuidValid($countryId)) {
			$this->country->deleteCountry($countryId);
		} else {
			$this->response(NULL, 400);
		}	
	}	
	
	function _listSingle($countryId) {		
		$data = $this->country->getCountry($countryId);
		if ($data) {
		
			$languageCodesDB = $this->languagecode->getLanguageCodeList($data->{DB_COUNTRY_ID});
			$languageCodes = array();
			foreach($languageCodesDB as $languageCode) {
				array_push($languageCodes, $languageCode->{DB_LANGUAGECODE_ID});
			}			
			$data->{DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID} = $languageCodes;

		
			$this->response($data);			
		} else {
			$this->response(NULL, 404);		
		}		
	}	
	
	function _listAll() {
		$offset = $this->get("offset");			
		$data = $this->country->getCountryList(LIST_DEF_PAGING, $offset);	
		
		if ($data) {
			foreach($data as $country) {
				$languageCodesDB = $this->languagecode->getLanguageCodeList($country->{DB_COUNTRY_ID});
				$languageCodes = array();
				foreach($languageCodesDB as $languageCode) {
					array_push($languageCodes, $languageCode->{DB_LANGUAGECODE_ID});
				}			
				$country->{DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID} = $languageCodes;
			}
		}
		
		
		$this->response($data);	
	}	
	
	function _checkGuidValid($guid) {
		if ($guid != "" && !isGuidValid($guid)) {
			$this->form_validation->set_message('_checkGuidValid', lang(LANG_KEY_ERROR_INVALID_GUID) . '%s');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}