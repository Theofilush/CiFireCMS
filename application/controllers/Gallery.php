<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Web_controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('web/gallery_model');
		$this->meta_title('Gallery');
	}
	
	public function index()
	{
		$this->vars['albums'] = $this->gallery_model->all_albums();
		$this->render_view('gallery', $this->vars);
	}
} // End class.