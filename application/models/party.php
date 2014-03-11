<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Country in database.
 *
 * @author André Brunnsberg
 *
*/
Class Party extends CI_Model {

	/**
	* Function used for loading a single party
	*
	* @param string $partyId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/
	function getParty($partyId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_PARTY);
		$this->db->where(DB_PARTY_ID,	$partyId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function getPartyList($countryId = NULL, $wildCardSearch = NULL, $limit = FALSE, $offset = FALSE) {
		$this->db->select(DB_TABLE_PARTY . '.' . DB_PARTY_ID);
		$this->db->select(DB_TABLE_PARTY . '.' . DB_PARTY_NAME);
		$this->db->select(DB_TABLE_PARTY . '.' . DB_PARTY_COUNTRYID);
		$this->db->select(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME . ' AS ' . DB_TABLE_COUNTRY . DB_COUNTRY_NAME);

		$this->db->from(DB_TABLE_PARTY);
		$this->db->join(DB_TABLE_COUNTRY, DB_TABLE_PARTY . '.' . DB_PARTY_COUNTRYID . ' = ' . DB_TABLE_COUNTRY . '.' . DB_COUNTRY_ID);
		
		if ($countryId) {
			$this->db->where(DB_TABLE_PARTY . '.' . DB_PARTY_COUNTRYID, $countryId);
		}
		
		if ($wildCardSearch) {
			$this->db->like(DB_TABLE_PARTY . '.' . DB_PARTY_NAME, $wildCardSearch);
		}		
		
		$this->db->order_by(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME, "asc");
		$this->db->order_by(DB_TABLE_PARTY . '.' . DB_PARTY_NAME, "asc");

		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}		
		
		$query = $this->db->get();
		return $query->result();
	}

	/**
	* Function used for saving a single party
	*
	* @param string $partyId GUID of the language, if NULL an INSERT is made, otherwise UPDATE
	*/
	function saveParty($data, $partyId = NULL) {
		if (!is_null($partyId)) {
			$this->db->where(DB_PARTY_ID, $partyId);
			$this->db->update(DB_TABLE_PARTY, $data);
		} else {
			$data[DB_PARTY_ID] = substr(generateGuid(), 1, 36);
			$this->db->insert(DB_TABLE_PARTY, $data);
		}
	}	
	
	/**
	* Function used for delete a single party
	*
	* @param string $partyId GUID of the party
	*/
	function deleteParty($partyId = NULL) {
		if (!is_null($partyId)) {
			$this->db->where(DB_PARTY_ID,	$partyId);
			$this->db->delete(DB_TABLE_PARTY);
		}
	}	
}