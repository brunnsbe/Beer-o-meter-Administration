<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH . 'libraries/REST_Controller.php');

class Questions extends REST_Controller {

	function __construct() {
		parent::__construct();	
		
		$this->load->model(MODEL_QUESTION, 	strtolower(MODEL_QUESTION),	TRUE);
		
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function api_get($questionId = NULL) {
        if($questionId) {
        	$this->_listSingle($questionId);
        } else {
			$this->_listAll();
		}
	}	
	
	function api_post($questionId = NULL) {
		$this->_saveSingle($questionId);
	}
	
	function api_delete($questionId = NULL) {
		$this->_deleteSingle($questionId);
	}
	
	// ######################################################################################################		

	function _saveSingle($questionId = NULL) {
		//Load the validation library
		$this->load->library('form_validation');	
	
		$httpData = $this->post();
		
		$_POST[DB_QUESTION_SUBJECT]		= $httpData[DB_QUESTION_SUBJECT];
		$_POST[DB_QUESTION_DESCRIPTION]	= $httpData[DB_QUESTION_DESCRIPTION];
		$_POST[DB_QUESTION_ORDERNUMBER]	= $httpData[DB_QUESTION_ORDERNUMBER];
		$_POST[DB_QUESTION_ID]			= $questionId;
		
		//Validate the fields
		$this->form_validation->set_rules(DB_QUESTION_SUBJECT,		lang(LANG_KEY_FIELD_SUBJECT),		'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules(DB_QUESTION_DESCRIPTION,	lang(LANG_KEY_FIELD_DESCRIPTION),	'trim|max_length[8000]|xss_clean');
		$this->form_validation->set_rules(DB_QUESTION_ORDERNUMBER,	lang(LANG_KEY_FIELD_ORDERNUMBER),	'trim|required|integer');
		$this->form_validation->set_rules(DB_QUESTION_ID,			lang(LANG_KEY_FIELD_SUBJECT),		'trim|callback__checkGuidValid');		
		
		if($this->form_validation->run() == FALSE) {
			$this->response("Validation failed", 400);
		} else {
			$data = array(			
				DB_QUESTION_SUBJECT		=> $this->input->post(DB_QUESTION_SUBJECT),
				DB_QUESTION_DESCRIPTION => $this->input->post(DB_QUESTION_DESCRIPTION),
				DB_QUESTION_ORDERNUMBER => $this->input->post(DB_QUESTION_ORDERNUMBER)
			);
			
			$this->question->saveQuestion($data, $questionId);		
			if ($questionId) {
				$this->response(null, 200);
			} else {
				$this->response(null, 201);
			}
		}
	}	
		
	function _deleteSingle($questionId) {				
		if (!is_null($questionId) && isGuidValid($questionId)) {
			$this->question->deleteQuestion($questionId);
		} else {
			$this->response(NULL, 400);
		}	
	}	
	
	function _listSingle($questionId) {		
		$data = $this->question->getQuestion($questionId);
		if ($data) {
			$this->response($data);			
		} else {
			$this->response(NULL, 404);		
		}		
	}	
	
	function _listAll() {
		$offset = $this->get("offset");			
		$data = $this->question->getQuestionList(LIST_DEF_PAGING, $offset);	
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