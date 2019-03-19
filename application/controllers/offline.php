<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offline extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'online')
		{
			redirect(site_url(''));
		}

	}
	
	public function index()
	{
		$this->load->view('offline');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */