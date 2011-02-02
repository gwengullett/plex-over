<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Transcode class.
 * Create the trancode url for images, music and video
 * 
 */
class Transcode {

	// default parameters for image transcoding
	public $img_opts = array(
		'width'		=> 100,
		'height'	=> 100,
		'alt'			=> 'image',
		'class'		=> 'rounded',
		'type'		=> 'lazy',
		'scale'		=> 'width',
	);
	
	// default parameters for video transcoding
	public $video_opts = array(
		'offset'	=> 0,
		'quality'	=> 5
	);
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param array $config. (default: array())
	 * @return void
	 */
	public function __construct($config = array())
	{
	  if (count($config) > 0)
	  {
	  	foreach ($config as $key => $value)
	  	{
	  		$this->$key = $value;
	  	}
	  }
	  $this->ci =& get_instance();
	}
	
	/**
	 * img function.
	 * Url for transcoded images. index of width height is important, 
	 * cause we wants to just fit one of them. the First is considered.
	 * 
	 * @access public
	 * @param mixed $item : Images atributes (check art or thumb)
	 * @param int $width. (default: 200): width parameter
	 * @param int $height. (default: 200): height parameter
	 * @param string $type. (default: 'lazy'): form the image tags for lazy load
	 * @param string $class. (default: 'rounded'): image class
	 * @return html image tag
	 */
	public function img($item, $opts = array())
	{
		$opts = $this->extend($opts, $this->img_opts);
	  
	  $params->width	= $opts->width;
	  $params->height	= $opts->height;
	  $params->url		= $this->ci->plex_url.thumb($item);
	  
	  // define the source attribute
	  $source = ($opts->type == 'lazy') ? 'original' : 'src';
	  
	  // create image
	  $image = img(array(
	  	$source				=> $this->ci->plex_url.$this->img_transpath.http_build_query($params),
			$opts->scale	=> $opts->{$opts->scale},
	  	'alt'					=> (isset($item->title)) ? $item->title : 'image',
	  	'class'				=> $opts->class
	  ));
	  
	  return $image;
	}
	
	/**
	 * video function.
	 * 
	 * @access public
	 * @param mixed $part
	 * @param array $opts. (default: array())
	 * @return void
	 */
	public function video($part, $opts = array())
	{
		$opts = $this->extend($opts, $this->video_opts);
		
		$params->quality		= $opts->quality;
		$params->offset			= $opts->offset;
		$params->ratingKey	= (string)$opts->ratingKey;
		$params->url				= $this->ci->plex_url.$part->key;
		//$params->httpCookies= '';
		//$params->userAgent	= '';
		$transcode_url = $this->video_transpath.http_build_query($params);
		$codes 	= $this->generate_keys($transcode_url);
		
		foreach ($codes as $key => $value)
		{
			$params->$key = $value;
		} 
		$transcode_url =	$this->ci->plex_url.$this->video_transpath.http_build_query($params);
	 	
	 	return $transcode_url;
	}
	
	/**
	 * generate_keys function.
	 * create hash and keys for url parameters
	 * Read more: http://forums.plexapp.com/index.php/topic/22303-plex-transcode-api/page__view__findpost__p__137653
	 * 
	 * @access private
	 * @param string $url. (default: '')
	 * @return void
	 */
	private function generate_keys($url = '')
	{
		$now	= time();
		$priv = base64_decode($this->private_key);
		$hash = hash_hmac('sha256', $url.'@'.$now, $priv, TRUE);
		$hash	= base64_encode($hash);
		
		$params['X-Plex-Access-Key']	= $this->public_key;
		$params['X-Plex-Access-Time']	= $now;
		$params['X-Plex-Access-Code']	= $hash;

		return $params;
	}
	
	/**
	 * extend function.
	 * Helper function that merge default options and passed options.
	 * 
	 * @access private
	 * @param array $opts. (default: array())
	 * @param string $media. (default: '')
	 * @return options Object
	 */
	private function extend($opts = array(), $def_opts = array())
	{		
		if (is_array($opts) AND count($opts) > 0)
		{
			$opts = $opts + $def_opts;
		}
		return (object)$opts;
	}
	
	
}