<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photos extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @return void
	 */
	public function index()
	{
		$data['items'] = $this->directory;
		$this->render('third/index', $data);
	}
	
	/**
	 * iPhoto function.
	 * 
	 * @access public
	 * @return void
	 */
	public function iPhoto()
	{
		$this->load->helper('iphoto');

		if ($key = $this->uri->segment(4))
		{
			$data['link']	= $this->plex_url.$this->uri->uri_string();
			$data['item'] = $this->plex->load(implode('/', $this->segments));
			$this->breadcrumb[$this->controller.__FUNCTION__] = 'iPhoto';
			$this->breadcrumb[] = lang(strtolower($data['item']->attributes()->title1));
			$render = 'photo/iphoto_gallery';
		}
		else
		{
			$this->breadcrumb[] = 'iPhoto';
			$data['link']		= implode('/', $this->segments);
			$data['items']	= $this->plex->directory_scan($data['link'].'/');
			$data['filters']= $this->_top_nav($this->directory, 'events');
			$render = 'photo/iphoto';
		}
		$data['views']->top_nav	= $this->topnav_view();
		$this->render($render, $data);
	}
	
	/**
	 * _remap function.
	 * 
	 * @access public
	 * @param mixed $arg
	 * @return void
	 */
	public function _remap($arg)
	{
		$url = ($arg == 'index') ? '' : '/'.$arg;
		
		$this->directory = $this->plex->find($url);
		
		if (method_exists($this, $arg))
		{
			$this->breadcrumb[$this->controller] = lang('photos');
			$data	= $this->_prepare_links();
			$data['title'] = __CLASS__.' '.$arg;
			$data['active_sb'] = 'photos';
			$this->load->vars($data);
			$this->$arg();
		}
	}
	
		/**
	 * prepare_links function.
	 * Just define links to send to the views...
	 * 
	 * @access private
	 * @return void
	 */
	private function _prepare_links()
	{
		$segments = $this->segments;
		if (count($segments) > 2) array_pop($segments);
		$data['links'] = (object)array(
			'section' => 'library/sections',
			'item'		=> __CLASS__,
			'top_nav'	=> base_topnav($segments)
		);
		return $data;
	}	
	
}