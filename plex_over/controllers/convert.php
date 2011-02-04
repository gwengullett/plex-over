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
	function h264()
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
	function parse_stream()
	{
		$params = parse_stream($this->input->post('url', true));
		
		$this->output->set_output(json_encode($params));
		
	}
	
}