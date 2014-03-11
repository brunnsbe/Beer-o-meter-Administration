<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table LanguageCode in database.
 *
 * @author André Brunnsberg
 *
*/
Class LanguageCode extends CI_Model {
	
	function getLanguageCodeList($countryId = FALSE) {
		$this->db->select(DB_LANGUAGECODE_ID);
		$this->db->select(DB_LANGUAGECODE_CODE);
		$this->db->select(DB_LANGUAGECODE_NAME);
		$this->db->from(DB_TABLE_LANGUAGECODE);
		
		if ($countryId) {
			$this->db->join(DB_TABLE_COUNTRY_HAS_LANGUAGECODE, DB_TABLE_LANGUAGECODE . '.' . DB_LANGUAGECODE_ID . ' = ' . DB_TABLE_COUNTRY_HAS_LANGUAGECODE . '.' . DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID);
			$this->db->where(DB_TABLE_COUNTRY_HAS_LANGUAGECODE . '.' . DB_COUNTRY_HAS_LANGUAGECODE_COUNTRYID, $countryId);
		}
		
		$this->db->order_by(DB_LANGUAGECODE_NAME, "asc"); 
		
		$query = $this->db->get();
		return $query->result();
	}	
}