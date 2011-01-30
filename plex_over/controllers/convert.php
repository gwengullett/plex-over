<?php

class Convert extends PE_Controller {
	
	public function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
	function h264()
	{
		$this->load->library('ffmpeg');
		
		$converted = $this->ffmpeg->avi_to_mp4($_POST);
		
		$this->output->set_output($converted);
	}
	
}