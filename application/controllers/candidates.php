<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Candidates extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_CANDIDATE, 	strtolower(MODEL_CANDIDATE),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function api_get($candidateId = NULL) {
        if($candidateId) {
        	$this->_listSingle($candidateId);
        } else {
			$this->_listAll();
		}
	}	
	
	function api_post($candidateId = NULL) {
		$this->_saveSingle($candidateId);
	}
	
	function api_delete($candidateId = NULL) {
		$this->_deleteSingle($candidateId);
	}
	
	// ######################################################################################################			
	
	function _deleteSingle($candidateId) {				
		if (!is_null($candidateId) && isGuidValid($candidateId)) {
			$this->candidate->deleteCandidate($candidateId);
		} else {
			$this->response(NULL, 400);
		}	
	}	
	
	function _saveSingle($candidateId) {		
		//Load the validation library
		$this->load->library('form_validation');	
	
		$httpData = $this->post();
		
		$_POST[DB_CANDIDATE_LASTNAME] 		= $httpData[DB_CANDIDATE_LASTNAME];
		$_POST[DB_CANDIDATE_FIRSTNAME] 		= $httpData[DB_CANDIDATE_FIRSTNAME];
		$_POST[DB_CANDIDATE_NUMBER] 		= $httpData[DB_CANDIDATE_NUMBER];
		$_POST[DB_CANDIDATE_EMAIL] 			= $httpData[DB_CANDIDATE_EMAIL];		
		$_POST[DB_CANDIDATE_PARTYID]		= $httpData[DB_CANDIDATE_PARTYID];
		$_POST[DB_CANDIDATE_DISTRICTID]		= $httpData[DB_CANDIDATE_DISTRICTID];		
		$_POST[DB_CANDIDATE_HOMEPAGE] 		= $httpData[DB_CANDIDATE_HOMEPAGE];				
		$_POST[DB_CANDIDATE_FACEBOOK] 		= $httpData[DB_CANDIDATE_FACEBOOK];
		$_POST[DB_CANDIDATE_TWITTER] 		= $httpData[DB_CANDIDATE_TWITTER];		
		$_POST[DB_CANDIDATE_DESCRIPTION]	= $httpData[DB_CANDIDATE_DESCRIPTION];
		$_POST[DB_CANDIDATE_ID] 			= $candidateId;
		
		//Validate the fields
		$this->form_validation->set_rules(DB_CANDIDATE_LASTNAME,	lang(LANG_KEY_FIELD_LASTNAME),		'trim|required|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_CANDIDATE_FIRSTNAME,	lang(LANG_KEY_FIELD_FIRSTNAME),		'trim|required|max_length[50]|xss_clean');
		$this->form_validation->set_rules(DB_CANDIDATE_NUMBER,		lang(LANG_KEY_FIELD_NUMBER),		'trim|required|numeric');
		$this->form_validation->set_rules(DB_CANDIDATE_EMAIL,		lang(LANG_KEY_FIELD_EMAIL),			'trim|required|valid_email|max_length[255]');
		$this->form_validation->set_rules(DB_CANDIDATE_PARTYID,		lang(LANG_KEY_FIELD_PARTY),			'trim|required|callback__checkGuidValid');
		$this->form_validation->set_rules(DB_CANDIDATE_DISTRICTID,	lang(LANG_KEY_FIELD_DISTRICT),		'trim|required|callback__checkGuidValid');				
		$this->form_validation->set_rules(DB_CANDIDATE_HOMEPAGE,	lang(LANG_KEY_FIELD_HOMEPAGE),		'trim|prep_url|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_CANDIDATE_FACEBOOK,	lang(LANG_KEY_FIELD_FACEBOOK),		'trim|prep_url|max_length[255]|xss_clean');		
		$this->form_validation->set_rules(DB_CANDIDATE_TWITTER,		lang(LANG_KEY_FIELD_TWITTER),		'trim|prep_url|max_length[255]|xss_clean');				
		$this->form_validation->set_rules(DB_CANDIDATE_DESCRIPTION,	lang(LANG_KEY_FIELD_DESCRIPTION),	'trim|max_length[8000]|xss_clean');
		$this->form_validation->set_rules(DB_CANDIDATE_ID,			lang(LANG_KEY_FIELD_LASTNAME),		'trim|callback__checkGuidValid');
		
		if($this->form_validation->run() == FALSE) {
			$this->response("Validation failed", 400);
		} else {
			$data = array(			
				DB_CANDIDATE_LASTNAME 		=> $this->input->post(DB_CANDIDATE_LASTNAME),
				DB_CANDIDATE_FIRSTNAME 		=> $this->input->post(DB_CANDIDATE_FIRSTNAME),
				DB_CANDIDATE_NUMBER 		=> $this->input->post(DB_CANDIDATE_NUMBER),
				DB_CANDIDATE_EMAIL 			=> $this->input->post(DB_CANDIDATE_EMAIL),
				DB_CANDIDATE_DESCRIPTION	=> $this->input->post(DB_CANDIDATE_DESCRIPTION),
				DB_CANDIDATE_FACEBOOK 		=> $this->input->post(DB_CANDIDATE_FACEBOOK),
				DB_CANDIDATE_TWITTER 		=> $this->input->post(DB_CANDIDATE_TWITTER),
				DB_CANDIDATE_HOMEPAGE 		=> $this->input->post(DB_CANDIDATE_HOMEPAGE),		
				DB_CANDIDATE_PARTYID		=> $this->input->post(DB_CANDIDATE_PARTYID),
				DB_CANDIDATE_DISTRICTID		=> $this->input->post(DB_CANDIDATE_DISTRICTID)
			);		
			
			$this->candidate->saveCandidate($data, $candidateId);		
			if ($candidateId) {
				$this->response(null, 200);
			} else {
				$this->response(null, 201);
			}
		}
	}
	
	function _listSingle($candidateId) {
		
		$data = $this->candidate->getCandidate($candidateId);
		if ($data) {
			$this->response($data);
		} else {
			$this->response(NULL, 404);		
		}		
	}
	
	function _listAll() {
		$offset = $this->get("offset");
	
		$countryId 		= $this->input->get(DB_DISTRICT_COUNTRYID, 	TRUE);
		$wildCardSearch = $this->input->get(HTTP_WILDCARDSEARCH, 	TRUE);		
		
		$data = $this->candidate->getCandidateList($countryId, $wildCardSearch, 20, $offset);
	
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