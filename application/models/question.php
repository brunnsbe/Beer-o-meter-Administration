<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Country in database.
 *
 * @author André Brunnsberg
 *
*/
Class Question extends CI_Model {

	/**
	* Function used for loading a single question
	*
	* @param string $questionId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/
	function getQuestion($questionId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_QUESTION);
		$this->db->where(DB_QUESTION_ID,	$questionId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function getQuestionList($limit = FALSE, $offset = FALSE) {
		$this->db->select(DB_TABLE_QUESTION . '.' . DB_QUESTION_ID);
		$this->db->select(DB_TABLE_QUESTION . '.' . DB_QUESTION_SUBJECT);		
		$this->db->select(DB_TABLE_QUESTION . '.' . DB_QUESTION_ORDERNUMBER);
		$this->db->select(DB_TABLE_QUESTION . '.' . DB_QUESTION_DESCRIPTION);
		$this->db->from(DB_TABLE_QUESTION);
		$this->db->order_by(DB_TABLE_QUESTION . '.' . DB_QUESTION_ORDERNUMBER, "asc");
		$this->db->order_by(DB_TABLE_QUESTION . '.' . DB_QUESTION_SUBJECT, "asc");

		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}		
		
		$query = $this->db->get();
		return $query->result();
	}

	/**
	* Function used for saving a single question
	*
	* @param string $questionId GUID of the language, if NULL an INSERT is made, otherwise UPDATE
	*/
	function saveQuestion($data, $questionId = NULL) {
		if (!is_null($questionId)) {
			$this->db->where(DB_QUESTION_ID, $questionId);
			$this->db->update(DB_TABLE_QUESTION, $data);
		} else {
			$data[DB_QUESTION_ID] = substr(generateGuid(), 1, 36);
			$this->db->insert(DB_TABLE_QUESTION, $data);
		}
	}	
	
	/**
	* Function used for delete a single question
	*
	* @param string $questionId GUID of the question
	*/
	function deleteCountry($questionId = NULL) {
		if (!is_null($questionId)) {
			$this->db->where(DB_QUESTION_ID,	$questionId);
			$this->db->delete(DB_TABLE_QUESTION);
		}
	}	
}