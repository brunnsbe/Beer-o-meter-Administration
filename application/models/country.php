<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Country in database.
 *
 * @author André Brunnsberg
 *
*/
Class Country extends CI_Model {

	/**
	* Function used for loading a single country
	*
	* @param string $countryId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/
	function getCountry($countryId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_COUNTRY);
		$this->db->where(DB_COUNTRY_ID,	$countryId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}
	
	function getCountryListAsArray($addEmpty = FALSE) {
		$result = $this->getCountryList(FALSE, FALSE);

		$data = array();
		
		if ($addEmpty) {
			$data[''] = '-';
		}

		foreach($result as $row){
            $data[$row->{DB_COUNTRY_ID}] = $row->{DB_COUNTRY_NAME};
		}
		
		return $data;		
	}

	function getCountryList($limit = FALSE, $offset = FALSE) {
		$this->db->select(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_ID);
		$this->db->select(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME);		
		$this->db->select('COUNT(' . DB_TABLE_DISTRICT . '.' . DB_DISTRICT_ID . ') AS ' . DB_TOTALCOUNT);
		$this->db->from(DB_TABLE_COUNTRY);
		$this->db->join(DB_TABLE_DISTRICT, DB_TABLE_COUNTRY . '.' . DB_COUNTRY_ID . ' = ' . DB_TABLE_DISTRICT . '.' . DB_DISTRICT_COUNTRYID, 'left');
		$this->db->group_by(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_ID);
		$this->db->group_by(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME);
		$this->db->order_by(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME, "asc");

		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}		
		
		$query = $this->db->get();
		return $query->result();
	}

	/**
	* Function used for saving a single country
	*
	* @param string $countryId GUID of the language, if NULL an INSERT is made, otherwise UPDATE
	*/
	function saveCountry($data, $countryId = NULL, $languageCodeIds = NULL) {
		$this->db->trans_start();
	
		if (!is_null($countryId)) {
			$this->db->where(DB_COUNTRY_ID, $countryId);
			$this->db->update(DB_TABLE_COUNTRY, $data);
		} else {
			$data[DB_COUNTRY_ID] = substr(generateGuid(), 1, 36);
			$this->db->insert(DB_TABLE_COUNTRY, $data);
		}
		
		if ($countryId) {
			$this->db->where(DB_COUNTRY_HAS_LANGUAGECODE_COUNTRYID, $countryId);
			$this->db->delete(DB_TABLE_COUNTRY_HAS_LANGUAGECODE); 
		}

		foreach($languageCodeIds as $languageCodeId) {
			$this->db->set(DB_COUNTRY_HAS_LANGUAGECODE_COUNTRYID, $countryId);
			$this->db->set(DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID, $languageCodeId);
			$this->db->insert(DB_TABLE_COUNTRY_HAS_LANGUAGECODE);
		}
		
		$this->db->trans_complete();
	}	
	
	/**
	* Function used for delete a single country
	*
	* @param string $countryId GUID of the country
	*/
	function deleteCountry($countryId = NULL) {
		if (!is_null($countryId)) {
			$this->db->where(DB_COUNTRY_ID,	$countryId);
			$this->db->delete(DB_TABLE_COUNTRY);
		}
	}	
}