<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Languages extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_LANGUAGE, 	strtolower(MODEL_LANGUAGE),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function api_get($languageId = NULL) {
        if($languageId) {
        	$this->_listSingle($languageId);
        } else {
			$this->_listAll();
		}
	}	
	
	function api_post($languageId = NULL) {
		$this->_saveSingle($languageId);
	}
	
	function api_delete($languageId = NULL) {
		$this->_deleteSingle($languageId);
	}
	
	// ######################################################################################################			
	
	function _deleteSingle($languageId) {				
		if (!is_null($languageId) && isGuidValid($languageId)) {
			$this->language->deleteLanguage($languageId);
		} else {
			$this->response(NULL, 400);
		}	
	}	
	
	function _saveSingle($languageId) {		
		//Load the validation library
		$this->load->library('form_validation');	
	
		$httpData = $this->post();
		
		$_POST[DB_LANGUAGE_LANGUAGEKEY] 	= $httpData[DB_LANGUAGE_LANGUAGEKEY];
		$_POST[DB_LANGUAGE_LANGUAGECODEID]	= $httpData[DB_LANGUAGE_LANGUAGECODEID];
		$_POST[DB_LANGUAGE_DATA] 			= $httpData[DB_LANGUAGE_DATA];
		$_POST[DB_LANGUAGE_ID] 				= $languageId;
		
		//Validate the fields
		$this->form_validation->set_rules(DB_LANGUAGE_LANGUAGEKEY,		lang(LANG_KEY_FIELD_KEY),			'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_LANGUAGE_LANGUAGECODEID,	lang(LANG_KEY_FIELD_LANGUAGECODE),	'trim|required|callback__checkGuidValid');
		$this->form_validation->set_rules(DB_LANGUAGE_DATA,				lang(LANG_KEY_FIELD_DATA),			'trim|required|xss_clean');
		$this->form_validation->set_rules(DB_LANGUAGE_ID,				lang(LANG_KEY_FIELD_KEY),			'trim|callback__checkGuidValid');		
		
		if($this->form_validation->run() == FALSE) {
			$this->response("Validation failed", 400);
		} else {
			$data = array(			
				DB_LANGUAGE_LANGUAGEKEY 	=> $this->input->post(DB_LANGUAGE_LANGUAGEKEY),
				DB_LANGUAGE_LANGUAGECODEID 	=> $this->input->post(DB_LANGUAGE_LANGUAGECODEID),
				DB_LANGUAGE_DATA			=> $this->input->post(DB_LANGUAGE_DATA)
			);		
			
			$this->language->savelanguage($data, $languageId);		
			if ($languageId) {
				$this->response(null, 200);
			} else {
				$this->response(null, 201);
			}
		}
	}
	
	function _listSingle($languageId) {
		
		$data = $this->language->getlanguage($languageId);
		if ($data) {
			$this->response($data);
		} else {
			$this->response(NULL, 404);		
		}		
	}
	
	function _listAll() {
		$offset = $this->get("offset");
	
		$languageCodeId = $this->input->get(DB_LANGUAGE_LANGUAGECODEID, TRUE);
		$wildCardSearch = $this->input->get(HTTP_WILDCARDSEARCH, TRUE);		
		
		$data = $this->language->getLanguageList($languageCodeId, FALSE, $wildCardSearch, 20, $offset);
	
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