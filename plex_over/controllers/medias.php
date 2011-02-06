<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Medias class.
 * 
 * @extends PE_Controller
 */
class Medias extends PE_Controller {
	
	private $section_key = null;
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct()
	{
	  parent::__construct(__CLASS__);
	  
	  if (! $this->media_id = $this->uri->segment(3))
	  {
	  	show_404();
	  }
	  $this->load->model(array('media', 'section'));
	  $this->load->helper(array('medias', 'number'));
	}
		
	/**
	 * season function.
	 * display main index of a specific show
	 * 
	 * @access public
	 * @param mixed $item
	 * @return void
	 */
	public function season($item)
	{
		$this->breadcrumb[''] 	= $item->title2;
		$data['show_link']			= '/show/'.(string)$item->key;
		$data['item']						= $item;
	  $data['views']->top_nav	= $this->topnav_view();
	  $data['active_sb']			= 'show_'.$this->section_key;
	  $this->render('media/'.__FUNCTION__, $data);
	}
	
	/**
	 * episode function.
	 * Details about a season.
	 * TODO: simplify breadcrumb production ?
	 * 
	 * @access public
	 * @param mixed $item
	 * @return void
	 */
	public function episode($item)
	{
		if (in_array('show', $this->segments)) // get the serie key
		{
			$temp_segs = $this->segments[array_search('show', $this->segments)+1];
			$data['show_link'] = '/show/'.$temp_segs;
			$this->breadcrumb['medias/show/'. $temp_segs.'/section/'.$this->section_key] = $item->grandparentTitle;
		}
	  
	  $data['item']		= $item;
		$data['link']	= link_episode($this->segments, $item->viewGroup);
		$data['active_sb']	= 'show_'.$this->section_key;
		
		// Get episode
	  if (in_array($item->viewGroup, $this->segments))
	  {
	  	$key		 = array_search($item->viewGroup, $this->segments)+1;
	  	$segment = $this->segments[$key];
	  	
			$data['episode'] = $this->add_subtitles($this->media->find_details($segment));
	  	unset($this->segments[$key], $this->segments[$key-1]);
	  	$this->breadcrumb[implode('/', $this->segments)] = $item->title2;				
			$this->breadcrumb[''] = $data['episode']->title;

			$data['views']->top_nav	= $this->topnav_view();
	  	$this->render('media/episode_watch', $data);
	  	return;
	  }
	  else if ($item->viewGroup == 'unknown')
	  {
	  	$this->segments[] = 'season';
			$this->_section_breadcrumb();
	  	$this->breadcrumb[''] = $item->grandparentTitle.' '.$item->title2;
	  	$data['episode'] = $this->add_subtitles($this->media->find_details($this->uri->segment(3)));
			$data['views']->top_nav	= $this->topnav_view();
	  	$this->render('media/episode_watch', $data);
			return;
	  }
	  // get episodes index
		$this->breadcrumb[''] = $item->title2;
		$data['views']->top_nav	= $this->topnav_view();
		$this->render('media/'.__FUNCTION__, $data);
	}
			
	/**
	 * album function.
	 * Artist + albums...
	 * 
	 * @access public
	 * @param mixed $item
	 * @return void
	 */
	public function album($item)
	{
	  $data['item']						= $item;
	  $data['artist_link']		= '/artist/'.$item->key;
	  $this->breadcrumb[] = @$item->title2;
	  $data['views']->top_nav	= $this->topnav_view();
	  $data['active_sb']			= 'artist_'.$this->section_key;
	  $this->render('media/'.__FUNCTION__, $data);
	}
	
	/**
	 * track function.
	 * Albums details from an Artist
	 * 
	 * @access public
	 * @return void
	 */
	public function track($item)
	{
		if (in_array('artist', $this->segments))
		{
			$artist = $this->media->find_children($this->uri->segment(5));
			$link		= $this->controller.'/artist/'.(string)$artist->key;
			$this->breadcrumb[$link.'/section/'.$this->section_key] = $artist->title2;
			$this->breadcrumb[''] = $item->title2;
		}
		else
		{
			$this->segments[] = 'artist';
			$this->breadcrumb[] = $item->grandparentTitle.' - '.$item->parentTitle;
		}
	  $data['item'] = $item;
	  $data['views']->top_nav	= $this->topnav_view();
	  $data['active_sb']	= 'artist_'.$this->section_key;
	  $this->render('media/'.__FUNCTION__, $data);
	}
	
	/**
	 * movie function.
	 * 
	 * @access public
	 * @param mixed $item
	 * @return void
	 */
	public function movie($item)
	{
		$this->breadcrumb[''] = $item->title2;
		$data['convert']			= $this->config->item('video_conv');
	  $data['item']					= $this->media->find_details($item->key);
		$data['views']->top_nav	= $this->topnav_view();
		$data['active_sb']	= 'movie_'.$this->section_key;
		
		// check subtitles and copy them under apache access
		$data['item'] = $this->add_subtitles($data['item']);
		
		$this->render('media/'.__FUNCTION__, $data);
	}
	
	/**
	 * unknown function.
	 * We try to rescue our _remap function with uri segment
	 * if we get a viewGroup = unknown 
	 * 
	 * @access public
	 * @return void
	 */
	public function unknown($item)
	{
	  $function = $this->uri->segment(2);

	  if (method_exists($this, $function))
	  {
	  	$this->$function($item);
	  }
	  else
	  {
	  	show_404();
	  }
	}

	
	/**
	 * _remap function.
	 * Call the right function by viewGroup
	 * 
	 * @access public
	 * @return void
	 */
	public function _remap()
	{
		 // section the sections object for sidebar
	  if ($item = $this->media->find_children($this->media_id))
	  {
	  	$data	= $this->_prepare_links($item);
	  	$data['title'] = @$item->title1.' - '.@$item->title2;
			$this->load->vars($data);
			$this->_section_breadcrumb();
	  	// run the apppropriate function
	  	$this->{strtolower($item->viewGroup)}($item);
	  }
	  else
	  {
	  	show_404();
	  }
	}
	
	/**
	 * _breadcrumb function.
	 * 
	 * @access private
	 * @param mixed $data['section']
	 * @return void
	 */
	private function _section_breadcrumb()
	{
		$segs = $this->segments;
		$section_id = end($segs);

		if (in_array('season', $this->segments))
		{
			$segs[] = 'show';
		}
		else if (in_array('album', $this->segments))
		{
			$segs[] = 'artist';
		}
		foreach ($this->sidebar_library->content as $section)
		{
			if (in_array($section->type, $segs) AND $section->key == $section_id)
			{
				$this->section_key = (string)$section->key;
				$link = $this->section_url.(string)$section->type.'/'.$this->section_key.'/all';
				$this->breadcrumb[$link] = $section->title;
			}
		}
	}
		
	/**
	 * prepare_links function.
	 * Just define links to send to the views...
	 * 
	 * @access private
	 * @return void
	 */
	private function _prepare_links($item)
	{
		$data['links'] = (object)array(
			'section' => 'library/sections',
			'item'		=> $this->controller.$item->viewGroup,
			'top_nav'	=> base_topnav($this->segments)
		);
		return $data;
	}	

}