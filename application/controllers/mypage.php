<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Controller file for login (and logout)
 *
 * @author André Brunnsberg
 *
*/
class MyPage extends CI_Controller {

	function __construct() {
		parent::__construct();	
		
		//Set headers to always load data dynamically
		header('Content-type: text/html; charset=utf-8');		
		header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	/**
	*	Default function for controller	
	*/
	function index() {		
		$this->load->view(VIEW_INDEX);
	}
}