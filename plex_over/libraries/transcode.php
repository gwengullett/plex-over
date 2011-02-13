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
		'type'		=> 'lazy', // lazy load
		'scale'		=> 'width', // html default yx scale
		'align'		=> '',
		'force'		=> '' // force the element to get (thumb, art ...etc)
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
	  $this->video_transcode = $this->ci->config->item('video_transcode');
	  $this->video_opts['quality'] = $this->ci->config->item('video_quality');
	}
	
	/**
	 * img function.
	 * Url for transcoded images. index of width height is important, 
	 * cause we wants to just fit one of them. the First is considered.
	 *
	 * @access public
	 * @param mixed $item
	 * @param array $opts. (default: array())
	 * @param bool $as_url. (default: false)
	 * @return void
	 */
	public function img($item, $opts = array(), $as_url = false)
	{
		$opts		= $this->extend($opts, $this->img_opts);
		$thumb	= thumb($item, $opts->force);

	  $params->width	= $opts->width;
	  $params->height	= $opts->height;
	  $params->url		= $this->ci->plex_url.$thumb;
		
		if (is_relative_link($thumb))
		{
			$thumb = $this->ci->plex_url.$this->img_transpath.http_build_query($params);
		}
	  // define the source attribute
	  $source = ($opts->type == 'lazy') ? 'data-src' : 'src';
	  // create image
	  $image = array(
	  	$source	=> $thumb,
	  	'alt'		=> (isset($item->title)) ? $item->title : 'image',
	  	'class'	=> $opts->class,
	  	'align'	=> $opts->align
	  );
	  // alignement
		if ($opts->scale == 'both')
		{
			$image['width']		= $opts->width;
			$image['height']	= $opts->height;
		}
		else
		{
			$image[$opts->scale] = $opts->{$opts->scale};
		}  			

	  return ($as_url === true) ? $thumb : img($image);
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
		if ( $this->video_transcode == false)
		{
			return $this->ci->plex_url.$part->key;
		}
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