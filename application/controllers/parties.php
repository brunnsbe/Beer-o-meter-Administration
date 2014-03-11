<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Parties extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_PARTY, 	strtolower(MODEL_PARTY),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function api_get($partyId = NULL) {
        if($partyId) {
        	$this->_listSingle($partyId);
        } else {
			$this->_listAll();
		}
	}	
	
	function api_post($partyId = NULL) {
		$this->_saveSingle($partyId);
	}
	
	function api_delete($partyId = NULL) {
		$this->_deleteSingle($partyId);
	}
	
	// ######################################################################################################			
	
	function _deleteSingle($partyId) {				
		if (!is_null($partyId) && isGuidValid($partyId)) {
			$this->party->deleteParty($partyId);
		} else {
			$this->response(NULL, 400);
		}	
	}	
	
	function _saveSingle($partyId) {		
		//Load the validation library
		$this->load->library('form_validation');	
	
		$httpData = $this->post();
		
		$_POST[DB_PARTY_NAME] 		= $httpData[DB_PARTY_NAME];
		$_POST[DB_PARTY_COUNTRYID]	= $httpData[DB_PARTY_COUNTRYID];
		$_POST[DB_PARTY_ID] 		= $partyId;
		
		//Validate the fields
		$this->form_validation->set_rules(DB_PARTY_NAME,		lang(LANG_KEY_FIELD_NAME),		'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_PARTY_COUNTRYID,	lang(LANG_KEY_FIELD_COUNTRY),	'trim|required|callback__checkGuidValid');
		$this->form_validation->set_rules(DB_PARTY_ID,			lang(LANG_KEY_FIELD_NAME),		'trim|callback__checkGuidValid');		
		
		if($this->form_validation->run() == FALSE) {
			$this->response("Validation failed", 400);
		} else {
			$data = array(			
				DB_PARTY_NAME 		=> $this->input->post(DB_PARTY_NAME),
				DB_PARTY_COUNTRYID 	=> $this->input->post(DB_PARTY_COUNTRYID)
			);		
			
			$this->party->saveParty($data, $partyId);		
			if ($partyId) {
				$this->response(null, 200);
			} else {
				$this->response(null, 201);
			}
		}
	}
	
	function _listSingle($partyId) {
		
		$data = $this->party->getParty($partyId);
		if ($data) {
			$this->response($data);
		} else {
			$this->response(NULL, 404);		
		}		
	}
	
	function _listAll() {
		$offset = $this->get("offset");
	
		$countryId 		= $this->input->get(DB_PARTY_COUNTRYID, TRUE);
		$wildCardSearch = $this->input->get(HTTP_WILDCARDSEARCH, TRUE);		
		
		$data = $this->party->getPartyList($countryId, $wildCardSearch, 20, $offset);
	
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