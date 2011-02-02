<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
		
		$this->load->model('audio');
		$this->load->helper(array('music', 'number'));
	}
	
	public function index()
	{
		$data['items'] = $this->directory;
		$this->render('third/index', $data);
	}
	
	/**
	 * itunes function.
	 * Artists & Genre: we have a multiples albums, so ATM a model function and view each.
	 * TODO: Make it more solid, linke juste one view
	 * 
	 * @access public
	 * @return void
	 */
	public function itunes($type = 'Artists')
	{
		if (count($this->segments) < 3) array_push($this->segments, $type);
				
		if ($key = $this->uri->segment(4))
		{	
			$data['link']	= $this->plex_url.itunes_url($this->uri->uri_string());
			$data['item'] = $this->_load_content('/iTunes/'.$this->uri->segment(3).'/'.rawurlencode($key));
			
			$this->breadcrumb[$this->controller.__FUNCTION__] = 'iTunes';
			$this->breadcrumb[$this->controller.__FUNCTION__.'/'.$this->segments[3]] = $this->segments[3];
			$this->breadcrumb[] = (isset($data['item']->title2)) ? $data['item']->title2 : $data['item']->title1;

			$data['views']->top_nav	= $this->topnav_view();
			$data['content_type'] = $this->content_type;
			$this->render('media/artist', $data);
		}
		else
		{
			$this->breadcrumb[] = 'iTunes';
			$data['link']			= implode('/', $this->segments);
			$data['items']		= $this->audio->find_by($this->segments);
			$data['filters']	= $this->_top_nav($this->directory, 'artist');
			$data['id']				= 'music';
			$this->render('music/itunes', $data);
		}
	}
	
	/**
	 * _load_content function.
	 * We load here content of a part,
	 * All songs are laoded ATM.
	 * 
	 * @access private
	 * @return void
	 */
	private function _load_content($content)
	{
		$multi = array('artists', 'genre', 'playlists');
		
		if (in_array(strtolower($this->segments[3]), $multi))
		{
			if ($this->segments[3] == 'playlists')
			{
				// upcase playlist string.
				$segments 		= explode('/', $content);
				$playlist			= explode('.', end($segments));
				$playlist[0]	= strtoupper($playlist[0]);
				$segments[3]	= implode('.', $playlist);
				$data = $this->audio->album(implode('/', $segments));
				$data->albums[0]->thumb = $data->art;
			}
			else
			{
				$data = $this->audio->content($content);
			}
			$this->content_type = lang('album');
		}
		else
		{
			$data = $this->audio->album($content);
			// we need to 'stole' the jacket from the first song,
			// cause plex dont give the jacket for the album
			$data->albums[0]->thumb = $data->albums[0]->tracks[0]->thumb;
			$this->content_type = lang('track');
		}
		
		return $data;
	}
	
	/**
	 * _remap function.
	 * redirect to functions, Music is only a sub directory
	 * 
	 * @access protected
	 * @param mixed $arg
	 * @return void
	 */
	public function _remap($arg)
	{
		$url = ($arg == 'index') ? '' : '/'.$arg;
		$this->directory = $this->audio->find($url);
		$this->breadcrumb[$this->controller] = lang('music');
		//print_r($this->directory);
		//return;
		
		if (method_exists($this, $arg))
		{
			$data	= $this->_prepare_links();
	  	$data['title'] = __CLASS__;
			$data['active_sb'] = 'music';
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