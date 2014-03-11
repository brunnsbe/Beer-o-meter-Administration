<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model file for table Candidate in database.
 *
 * @author André Brunnsberg
 *
*/
Class Candidate extends CI_Model {

	/**
	* Function used for loading a single candidate
	*
	* @param string $candidateId GUID of the user
	* @return false if check fails, otherwise returns database result
	*/
	function getParty($candidateId) {
		$this->db->select('*');
		$this->db->from(DB_TABLE_CANDIDATE);
		$this->db->where(DB_CANDIDATE_ID,	$candidateId);

		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return false;
		}
	}

	function getCandidateList($countryId = NULL, $wildCardSearch = NULL, $limit = FALSE, $offset = FALSE) {
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_ID);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_LASTNAME);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_FIRSTNAME);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_NUMBER);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_EMAIL);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_DESCRIPTION);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_FACEBOOK);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_TWITTER);
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_HOMEPAGE);		
		
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_PARTYID);
		$this->db->select(DB_TABLE_PARTY . '.' . DB_PARTY_NAME . ' AS ' . DB_TABLE_PARTY . DB_PARTY_NAME);
		$this->db->select(DB_TABLE_COUNTRY . '.' . DB_COUNTRY_NAME . ' AS ' . DB_TABLE_COUNTRY . DB_COUNTRY_NAME);
		
		$this->db->select(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_DISTRICTID);
		$this->db->select(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_NAME . ' AS ' . DB_TABLE_DISTRICT . DB_DISTRICT_NAME);

		$this->db->from(DB_TABLE_CANDIDATE);
		$this->db->join(DB_TABLE_DISTRICT, DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_DISTRICTID . ' = ' . DB_TABLE_DISTRICT . '.' . DB_DISTRICT_ID, 'left');
		$this->db->join(DB_TABLE_COUNTRY, DB_TABLE_DISTRICT . '.' . DB_DISTRICT_COUNTRYID . ' = ' . DB_TABLE_COUNTRY . '.' . DB_COUNTRY_ID, 'left');
		$this->db->join(DB_TABLE_PARTY, DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_PARTYID . ' = ' . DB_TABLE_PARTY . '.' . DB_PARTY_ID, 'left');
		
		if ($countryId) {
			$this->db->where(DB_TABLE_DISTRICT . '.' . DB_DISTRICT_COUNTRYID, $countryId);
		}
		
		if ($wildCardSearch) {
			$this->db->like(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_LASTNAME, $wildCardSearch);
		}		
		
		$this->db->order_by(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_LASTNAME, "asc");
		$this->db->order_by(DB_TABLE_CANDIDATE . '.' . DB_CANDIDATE_FIRSTNAME, "asc");

		if ($limit !== FALSE && $offset !== FALSE) {
			$this->db->limit($limit, $offset);
		}		
		
		$query = $this->db->get();
		return $query->result();
	}

	/**
	* Function used for saving a single candidate
	*
	* @param string $candidateId GUID of the candidate, if NULL an INSERT is made, otherwise UPDATE
	*/
	function saveCandidate($data, $candidateId = NULL) {
		if (!is_null($candidateId)) {
			$this->db->where(DB_CANDIDATE_ID, $candidateId);
			$this->db->update(DB_TABLE_CANDIDATE, $data);
		} else {
			$data[DB_CANDIDATE_ID] = substr(generateGuid(), 1, 36);
			$this->db->insert(DB_TABLE_CANDIDATE, $data);
		}
	}	
	
	/**
	* Function used for delete a single candidate
	*
	* @param string $candidateId GUID of the candidate
	*/
	function deleteCandidate($candidateId = NULL) {
		if (!is_null($candidateId)) {
			$this->db->where(DB_CANDIDATE_ID,	$candidateId);
			$this->db->delete(DB_TABLE_CANDIDATE);
		}
	}	
}