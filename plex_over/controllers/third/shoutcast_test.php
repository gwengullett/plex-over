<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shoutcast extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
		$this->load->model('plugin');
	}
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		echo 'test';
	}
	
	/**
	 * _remap function.
	 * 
	 * @access public
	 * @param mixed $arg
	 * @return void
	 */
	public function _remap()
	{
		echo 'test';
	}
	
}