<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public $vars;

	public function __construct()
	{
		parent::__construct();
		
		if ( $this->settings->website('maintenance') == 'N' )
			redirect(site_url());
	}
	
	public function index()
	{
		$this->load->view('maintenance', $this->vars);
	}
} // End class.