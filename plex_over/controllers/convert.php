<?php

class Convert extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	 * h264 function.
	 * 
	 * @access public
	 * @return void
	 */
	public function h264()
	{
		$this->load->library('ffmpeg');
		
		$converted = $this->ffmpeg->avi_to_mp4($_POST);
		
		$this->output->set_output($converted);
	}
	
	/**
	 * parse_stream function.
	 * 
	 * @access public
	 * @return void
	 */
	public function parse_stream($url = '')
	{
		$this->load->model('plugin');
		
		$url = urldecode($this->input->post('url', true));
		$is_internal = is_internal_link($url, $this->plex_url);
		$is_relative = is_relative_link($url);
		
		// it should be a direct external link, so no treatment
		if (! $is_internal AND ! is_plex_link($url) AND ! $is_relative)
		{
			$object->url = $url;
		}
		else
		{
			if (! is_plex_link($url)) // the url is a local link, so we check curl header of this url
			{
				$url 	= ($is_relative) ? $this->plex_local.$url : $url;
				$curl = $this->plugin->test_redirection($url);
				$url	= $curl->url;
				
				if (is_internal_link($url, $this->plex_local))
				{
					return $this->local_to_network($curl);
				}
			}
			// both situations
			if ($online_player = is_online_request($url))
			{
				$object = $this->build_stream_object($url);
			}
			else
			{
				$url = parse_online_request($url);
				$object->url = urldecode($url->url);
			}
		}
		//print_r($object);
		return $this->render_ajax($object);	
	}
	
	/**
	 * build_stream_object function.
	 * 
	 * @access public
	 * @param mixed $url
	 * @return void
	 */
	public function build_stream_object($url)
	{
		list($base, $query) = explode('www.plexapp.com/player/', urldecode($url));
		// request is the full path, player is player.php or silvernight...
		$request = preg_split('/([\?|\&]stream=|[\?|\&]clip=)/', urldecode($query), null);
		
		foreach ($request as $key => $segment)
		{
		  $request[$key] = parse_online_request($segment);
		}
		// we are almost ready: just parse parameters
		$object->url = (isset($request[1]->url)) ? $request[1]->url : '';
		$object->connexion_url = (isset($request[0]->url)) ? $request[0]->url : '';
		
		return $object;
	}
	
	/**
	 * local_to_network function.
	 * 
	 * @access public
	 * @param mixed $object
	 * @return void
	 */
	public function local_to_network($object)
	{
		$object->connexion_url = '';
		$object->url = str_replace($this->plex_local, $this->plex_url, $object->url);
		return $this->render_ajax($object);
	}

}