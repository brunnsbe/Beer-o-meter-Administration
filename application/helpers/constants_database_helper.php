<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Database constants
 *
 * @author André Brunnsberg
 *
*/

//Temporary tables, views and columns
define('DB_TOTALCOUNT',						'TotalCount');
define('DB_TOTALSUM',						'TotalSum');

//Table Language
define('DB_TABLE_LANGUAGE',					'Election_Language');
define('DB_LANGUAGE_ID',					'Id');
define('DB_LANGUAGE_LANGUAGEKEY',			'LanguageKey');
define('DB_LANGUAGE_LANGUAGECODEID',		'LanguageCodeId');
define('DB_LANGUAGE_DATA',					'Data');

//Table Country
define('DB_TABLE_COUNTRY',					'Election_Country');
define('DB_COUNTRY_ID',						'Id');
define('DB_COUNTRY_NAME',					'Name');

//Table District
define('DB_TABLE_DISTRICT',					'Election_District');
define('DB_DISTRICT_ID',					'Id');
define('DB_DISTRICT_NAME',					'Name');
define('DB_DISTRICT_COUNTRYID',				'CountryId');

//Table Party
define('DB_TABLE_PARTY',					'Election_Party');
define('DB_PARTY_ID',						'Id');
define('DB_PARTY_COUNTRYID',				'CountryId');
define('DB_PARTY_NAME',						'Name');

//Table Question
define('DB_TABLE_QUESTION',					'Election_Question');
define('DB_QUESTION_ID',					'Id');
define('DB_QUESTION_SUBJECT',				'Subject');
define('DB_QUESTION_DESCRIPTION',			'Description');
define('DB_QUESTION_ORDERNUMBER',			'OrderNumber');

//Table Candidate
define('DB_TABLE_CANDIDATE',				'Election_Candidate');
define('DB_CANDIDATE_ID',					'Id');
define('DB_CANDIDATE_LASTNAME',				'LastName');
define('DB_CANDIDATE_FIRSTNAME',			'FirstName');
define('DB_CANDIDATE_PARTYID',				'PartyId');
define('DB_CANDIDATE_DISTRICTID',			'DistrictId');
define('DB_CANDIDATE_NUMBER',				'Number');
define('DB_CANDIDATE_USERNAME',				'UserName');
define('DB_CANDIDATE_PASSWORD',				'Password');
define('DB_CANDIDATE_EMAIL',				'Email');
define('DB_CANDIDATE_DESCRIPTION',			'Description');
define('DB_CANDIDATE_FACEBOOK',				'Facebook');
define('DB_CANDIDATE_TWITTER',				'Twitter');
define('DB_CANDIDATE_HOMEPAGE',				'Homepage');
define('DB_CANDIDATE_ISINVITED',			'IsInvited');
define('DB_CANDIDATE_ISREMINDERINVITED',	'IsReminderInvited');

//Table Country_has_LanguageCode
define('DB_TABLE_COUNTRY_HAS_LANGUAGECODE',				'Election_Country_has_LanguageCode');
define('DB_COUNTRY_HAS_LANGUAGECODE_COUNTRYID',			'CountryId');
define('DB_COUNTRY_HAS_LANGUAGECODE_LANGUAGECODEID',	'LanguageCodeId');

//Table LanguageCode
define('DB_TABLE_LANGUAGECODE',				'Election_LanguageCode');
define('DB_LANGUAGECODE_NAME',				'Name');
define('DB_LANGUAGECODE_CODE',				'Code');
define('DB_LANGUAGECODE_ID',				'Id');