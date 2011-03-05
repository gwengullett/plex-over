<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thumb {
	
	function __construct()
	{
		$this->ci =& get_instance();
		
		$this->cache_path		= $this->ci->config->item('thumbs_folder');
		$this->cache_folder = FCPATH.$this->cache_path;
		$this->thumb_width	= $this->ci->config->item('thumb_width');
		$this->thumb_ext		= '.png';
		
		$main_cache =  dirname($this->cache_folder);
		
		if (! file_exists($main_cache) OR ! is_dir($main_cache))
		{
			@mkdir($main_cache, DIR_WRITE_MODE);
		}
		
		if (! file_exists($this->cache_folder) OR ! is_dir($this->cache_folder))
		{
			@mkdir($this->cache_folder, DIR_WRITE_MODE);
		}
		
		$this->ci->load->library('image_lib'); 
	}
	
	/**
	 * get function.
	 * 
	 * @access public
	 * @param string $url. (default: '')
	 * @return void
	 */
	public function get($url = '', $resize = true)
	{
		if (! $url) return false;
		
		$cached_filename = md5($url).$this->thumb_ext;
		
		$cached_file = $this->cache_folder.$cached_filename;
		
		if (! file_exists($cached_file) OR ! is_file($cached_file))
		{
			$thumb = $this->create_thumb($url, $cached_filename, $resize);
		}
		else
		{
			$thumb = $this->cache_path.$cached_filename;
		}
		
		return ($thumb) ? base_url().$thumb : $thumb;
	}
	
	/**
	 * create_thumb function.
	 * We dont use the CI image lib because file is url
	 * 
	 * @access private
	 * @param mixed $orig_url
	 * @param mixed $cached_url
	 * @return void
	 */
	private function create_thumb($orig_url, $cached_url, $resize)
	{
		// The file
		$filename = $orig_url;
		// Get new dimensions
		$sizes =  @getimagesize($filename);
				
		if ($sizes != false)
		{
			list($width, $height) = $sizes;
			
			$new_width	= ($resize) ? $this->thumb_width : $width;
			$new_height = ($resize) ? $height / ($width / $new_width) : $height;
			
			// Resample
			$image_p = imagecreatetruecolor($new_width, $new_height);
			
			$mime = array_pop(explode('/', $sizes['mime']));
			
			switch ($mime)
			{
				case 'png':
				$image = imagecreatefrompng($filename);
				break;
				
				case 'jpeg':
				$image = imagecreatefromjpeg($filename);
				break;
				
				case 'gif':
				$image = imagecreatefromgif($filename);
				break;
			}
			
			if (isset($image) AND $image)
			{
				imagealphablending($image,false);
  			imagesavealpha($image,true);
				
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				//else imagecopy($image_p, $image, 0, 0, 0, 0, $width, $height);
				
				imagepng($image_p, $this->cache_path.'/'.$cached_url, 5);
			}
			
			return $this->cache_path.$cached_url;
		}
		return false;
	}
	
}