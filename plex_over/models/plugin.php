<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plugin extends Plex {
		
	public function __construct()
	{
		parent::__construct('plugins');
		$this->curl_options = array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_NOBODY					=> true,
			 	CURLOPT_URL						 => '',
        CURLOPT_HEADER         => true,    // don't return headers 
        CURLOPT_AUTOREFERER => true,     // follow redirects 
        CURLINFO_HEADER_OUT	=> true,       // handle all encodings 
        CURLOPT_MAXREDIRS      => 1       // stop after 10 redirects 
    );
	}
	
	/**
	 * scan function.
	 * Directory analyze...
	 * 
	 * @access public
	 * @param mixed $url. (default: null)
	 * @return void
	 */
	public function scan($url = null)
	{
		$items = $this->load($url);
		$return						= $this->get_attributes($items);
		$return->content	= $this->get_childrens($items);
		$return->view			= $this->get_view($items);
		$return->keyname	= $items->children()->getName($items);
		
		// get url in something understandable for our app
		foreach ($return->content as $key => $content)
		{
			$params = explode('/:/', (string)$content->key);

			if (isset($params[1]))
			{
				// convert as segments
				$params[1] = implode('/', parse_url($params[1]));
				$content->addAttribute('pe_key', implode('/', $params));
			}
			// directory whitout base path
			else if (substr($content->key, 0, strlen($this->uri->segment(1))) != $this->uri->segment(1))
			{
				$params = $this->uri->uri_string().'/'.urlencode($content->key);
				$content->addAttribute('pe_key', $params);
			}
		}
		return $return;
	}
	
	/**
	 * scan_function function.
	 * Well now, we have to rebuild the uri for plex...
	 * 
	 * @access public
	 * @return void
	 */
	public function scan_function()
	{
		$segments = $this->segments;
		$base		= array_slice($segments, 0, 2);
		$base[] = ':/function';
		$function = array_slice($segments, 3);
		$end		= array(implode('?',  array_slice($segments, 3)));
		$final	= implode('/', array_merge($base, $end));
		
		return $this->scan($final);
	}
	
	/**
	 * test_url function.
	 * 
	 * @access public
	 * @param mixed $url
	 * @return void
	 */
	public function test_redirection($url)
	{
		$this->chi = curl_init();
		$this->curl_options[CURLOPT_URL] = $url;
    curl_setopt_array( $this->chi, $this->curl_options );
    $return = curl_exec($this->chi);
		preg_match("/Location:(.*?)\r/", $return, $match);
		
		$out->url 		= (isset($match[1]) AND is_plex_link($match[1])) ? $match[1] : $url;
		$out->status	= (isset($match[1])) ? true : false;
		
		return $out;
	}
	
	/**
	 * get_view function.
	 * Try to find the veiwGroup or Name of view
	 * 
	 * @access public
	 * @param mixed $item
	 * @return void
	 */
	public function get_view($item)
	{
		if (isset($item->attributes()->viewGroup))
		{
			return $item->attributes()->viewGroup;
		}
		else // get the Name of childs
		{
			return $item->children()->getName();
		}
	}

}