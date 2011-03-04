<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User class.
 * User related function
 * 
 * @extends PE_Controller
 */
class User extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	
	
	public function set_view()
	{
		$redirect = $this->input->post('redirect', TRUE);
		$view			= ($this->input->post('grid', TRUE)) ? $this->input->post('grid', TRUE) : $this->input->post('flat', TRUE);
		$current	= $this->input->cookie('po_section_view', TRUE);

		$cookie = array(
		  'name'   => 'section_view',
		  'value'  => $view,
		  'expire' => '2592000',
		  'prefix' => 'po_'
		);
		$this->input->set_cookie($cookie);
		
	redirect($redirect);
	}

}