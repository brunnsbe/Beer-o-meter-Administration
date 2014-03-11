<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Country in database.
 *
 * @author André Brunnsberg
 *
*/
Class District extends CI_Model {

	/**
	* Function used for loading a single district
	*
	* @param string $districtId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/
	function getDistrict($districtId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_DISTRICT);
		$this->db->where(DB_DISTRICT_ID,	$districtId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function getDistrictList($countryId = NULL, $wildCardSearch = NULL, $limit = FALSE, $offset = FALSE) {
		$this->db->select(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_ID);
		$this->db->select(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_NAME);
		$this->db->select(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_COUNTRYID);		
		$this->db->select(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME . ' AS ' . DB_TABLE_COUNTRY . DB_COUNTRY_NAME);

		$this->db->from(DB_TABLE_DISTRICT);
		$this->db->join(DB_TABLE_COUNTRY, DB_TABLE_DISTRICT . '.' . DB_DISTRICT_COUNTRYID . ' = ' . DB_TABLE_COUNTRY . '.' . DB_COUNTRY_ID);
		
		if ($countryId) {
			$this->db->where(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_COUNTRYID, $countryId);
		}
		
		if ($wildCardSearch) {
			$this->db->like(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_NAME, $wildCardSearch);
		}		
		
		$this->db->order_by(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME, "asc");
		$this->db->order_by(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_NAME, "asc");

		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}		
		
		$query = $this->db->get();
		return $query->result();
	}

	/**
	* Function used for saving a single district
	*
	* @param string $districtId GUID of the language, if NULL an INSERT is made, otherwise UPDATE
	*/
	function saveDistrict($data, $districtId = NULL) {
		if (!is_null($districtId)) {
			$this->db->where(DB_DISTRICT_ID, $districtId);
			$this->db->update(DB_TABLE_DISTRICT, $data);
		} else {
			$data[DB_DISTRICT_ID] = substr(generateGuid(), 1, 36);
			$this->db->insert(DB_TABLE_DISTRICT, $data);
		}
	}	
	
	/**
	* Function used for delete a single district
	*
	* @param string $districtId GUID of the district
	*/
	function deleteDistrict($districtId = NULL) {
		if (!is_null($districtId)) {
			$this->db->where(DB_DISTRICT_ID,	$districtId);
			$this->db->delete(DB_TABLE_DISTRICT);
		}
	}	
}