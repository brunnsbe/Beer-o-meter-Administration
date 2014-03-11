<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Language in database.
 *
 * @author André Brunnsberg
 *
*/
Class Language extends CI_Model {

	/**
	* Function used for loading a single language
	*
	* @param string $languageId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/
	function getLanguage($languageId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_LANGUAGE);
		$this->db->where(DB_LANGUAGE_ID,	$languageId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function getLanguageList($languageCodeId = NULL, $languageCode = NULL, $wildCardSearch = NULL, $limit = FALSE, $offset = FALSE) {
		$this->db->select(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_ID);
		$this->db->select(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_LANGUAGEKEY);
		$this->db->select(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_LANGUAGECODEID);		
		$this->db->select(DB_TABLE_LANGUAGECODE . '.' . DB_LANGUAGECODE_CODE);
		$this->db->select(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_DATA);				
		$this->db->select("COUNT(*) OVER () AS " . DB_TOTALCOUNT, FALSE);
		
		$this->db->from(DB_TABLE_LANGUAGE);
		$this->db->join(DB_TABLE_LANGUAGECODE, DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_LANGUAGECODEID . ' = ' . DB_TABLE_LANGUAGECODE . '.' . DB_LANGUAGECODE_ID, 'left');		

		if ($languageCodeId) {
			$this->db->where(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_LANGUAGECODEID, $languageCodeId);
		}
		
		if ($languageCode) {
			$this->db->where(DB_TABLE_LANGUAGECODE . '.' . DB_LANGUAGECODE_CODE, $languageCode);
		}		
		
		if ($wildCardSearch) {
			$this->db->like(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_LANGUAGEKEY, $wildCardSearch);
			$this->db->or_like(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_DATA, $wildCardSearch); 		
		}
		
		$this->db->order_by(DB_TABLE_LANGUAGE . '.' . DB_LANGUAGE_LANGUAGEKEY, "asc");
		$this->db->order_by(DB_TABLE_LANGUAGECODE . '.' . DB_LANGUAGECODE_CODE, "asc");

		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}		
		
		$query = $this->db->get();
		return $query->result();
	}

	/**
	* Function used for saving a single language
	*
	* @param string $languageId GUID of the language, if NULL an INSERT is made, otherwise UPDATE
	*/
	function saveLanguage($data, $languageId = NULL) {
		if (!is_null($languageId)) {
			$this->db->where(DB_LANGUAGE_ID, $languageId);
			$this->db->update(DB_TABLE_LANGUAGE, $data);
		} else {
			$data[DB_LANGUAGE_ID] = substr(generateGuid(), 1, 36);
			$this->db->insert(DB_TABLE_LANGUAGE, $data);
		}
	}	
	
	/**
	* Function used for delete a single language
	*
	* @param string $languageId GUID of the language
	*/
	function deleteLanguage($languageId = NULL) {
		if (!is_null($languageId)) {
			$this->db->where(DB_LANGUAGE_ID,	$languageId);
			$this->db->delete(DB_TABLE_LANGUAGE);
		}
	}	
}