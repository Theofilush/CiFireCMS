<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filemanager extends Admin_controller {
	
	public $mod = 'filemanager';

	public function __construct() 
	{
		parent::__construct();
		
		$this->meta_title('File Manager');
	}

	
	public function index()
	{
		$this->render_view('view_index', $this->vars);
	}
} // End Class.