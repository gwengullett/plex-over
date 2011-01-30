<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ffmpeg {

	public $temp_folder, $binaries;
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct($config)
	{
		$this->initialize($config);
	}
	
	/**
	 * initialize function.
	 * 
	 * @access public
	 * @param array $config. (default: array())
	 * @return void
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $item)
		{
			$this->$key = $item;
		}
	}
	
	/**
	 * avi_to_mp4 function.
	 * 
	 * @access public
	 * @param mixed $options
	 * @return void
	 */
	public function avi_to_mp4($options)
	{
		// check if file exist
		$final_path = $this->temp_folder.basename($options['path']).'.mp4';
		
		if (file_exists(FCPATH.$final_path) AND is_file(FCPATH.$final_path))
		{
			return site_url($final_path);
		}
		$command  = $this->binaries.' -i ';
		$command .= '"'.$options['path'].'"';
		//$command .= ' -acodec libfaac -ab 96k -vcodec libx264 -vpre veryfast -vpre ipod640 -crf 25 -threads 0';
		$command .= ' -acodec libfaac -ab 128k -ac 2 -vcodec libx264 -vpre veryfast -crf 25 -threads 0';
		//$command .= ' -s 480x'.round(640 / $options['ratio']);
		$command .= ' '.FCPATH.$this->temp_folder.basename($options['path']).'.mp4';
		
		shell_exec($command);
		
		return site_url($final_path);
	}
}