<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
        
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
        //load custom module
			$this->load->model('admin_dashboard');
		
	}
	
	public function index()
	{
		$this->data ='';
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Dashboard')
			->build('dashboard_body', $this->data);	
		
	}
  
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */