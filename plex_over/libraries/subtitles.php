<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Subtitles class.
 * Subtitles management
 * 
 */
class Subtitles {
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->subtitles_cache = $this->ci->config->item('subtitles_folder');
		$this->ext = 'srt';
	}
	
	/**
	 * get function.
	 * Check if the media have subtitles, then copy it 
	 * to have an access under apache, and add the ref to items.
	 * Subtitles have to get named as the media, with srt extension.
	 * 
	 * @access protected
	 * @param mixed $items
	 * @return void
	 */
	public function get($items)
	{
		if (isset($items->media->part))
		{
			foreach ($items->media->part as $part)
			{
				if ($subtitle = $this->find($part->file))
				{
					$subtitle_path = $this->subtitles_cache.basename($subtitle);
					
					if (! file_exists(FCPATH.$subtitle_path))
					{
						$encoded = $this->encode($subtitle);
						$this->copy($encoded, FCPATH.$subtitle_path);
					}
					$part->subtitles = site_url($subtitle_path);
				}
				else
				{
					$part->subtitles = '';
				}
			}
		}
		return $items;
	}
	
	
	/**
	 * subtitles_file function.
	 * return the subtitles file if found.
	 * 
	 * @access public
	 * @return void
	 */
	public function find($media)
	{
		$x = explode('.', $media);
		$file = substr($media, 0, - strlen('.'.end($x))).'.'.$this->ext;
		
		if (file_exists($file) AND is_file($file))
		{
			return $file;
		}
		return false;
	}
	
	/**
	 * copy_subtitles function
	 * add subtitles file to dest path
	 * 
	 * @access public
	 * @param mixed $subtitles
	 * @param mixed $dest_path
	 * @return void
	 */
	public function copy($subtitles, $dest_path)
	{
		return @file_put_contents($dest_path, $subtitles);
	}
	
	/**
	 * encode_subtitles function.
	 * properly convert to UT8 for videojs
	 * 
	 * @access protected
	 * @param mixed $orig_path
	 * @return encoded string
	 */
	protected function encode($orig_path)
	{
		$text = @file_get_contents($orig_path);
		
		return utf8_encode($text);
	}

}