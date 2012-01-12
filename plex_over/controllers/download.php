<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Download class.
 * Force le header pour les donwloads...
 * 
 * @extends PE_Controller
 */
class Download extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	/**
	 * index function.
	 * Renvoi le fichier pour le download
	 *
	 * @access public
	 * @param mixed $file
	 * @return void
	 */
	function index()
	{
		if (file_exists($this->file) AND is_file($this->file))
		{
			header("Content-Disposition: attachment; filename=" . basename($this->file));   
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Description: File Transfer");            
			header("Content-Length: " . filesize($this->file));
			$fp = fopen($this->file, "r");
			while (!feof($fp))
			{
			    echo fread($fp, 65536);
			    flush();
			} 
			fclose($fp);
			return;
		}
		echo $this->file;
		show_404();
	}
	
	/**
	 * _remap function.
	 * -> vers index...
	 * 
	 * @access private
	 * @param mixed $file
	 * @return void
	 */
	function _remap($file)
	{
		$uri = $this->uri->segment_array();
		array_shift($uri);
		$this->file = html_entity_decode(urldecode('/'.implode('/', $uri)));
		$this->index();
		return;
	}
	
}