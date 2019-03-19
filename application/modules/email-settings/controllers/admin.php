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
			
		//load CI library
			$this->load->library('form_validation');		
		//load custom module
			$this->load->model('admin_email_settings');
		
		//load custom helper
			$this->load->helper('editor_helper');
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
	}
	
	public function index($email_code='')
	{
		//if parent id is blank then redirect to dashboard page
		//if(!isset($email_code)){redirect(ADMIN_DASHBOARD_PATH,'refresh');exit;}
        $this->data['email_code'] = $email_code;					
		$this->data['emails'] = $this->admin_email_settings->get_all_emails();
		//print_r($_POST);
		// Set the validation rules
		$this->form_validation->set_rules($this->admin_email_settings->validate_settings);
		
		if($this->form_validation->run()==TRUE)
		{
			//update site setting
			$this->admin_email_settings->update_email_settings();
			$this->session->set_flashdata('message','The email settings are update successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/email-settings/index/'.$email_code,'refresh');
			exit;
		}
		
		$this->data['email_data'] = $this->admin_email_settings->get_email_setting_byemailcode($email_code);
				
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Email Settings Management System')
			->build('email_view', $this->data);	
		
	}
	
    public function add()
    {

		$this->form_validation->set_rules($this->admin_email_settings->validate_settings);
		
		if($this->form_validation->run()==TRUE)
		{
			//update site setting
			$this->admin_email_settings->add_email_settings();
			$this->session->set_flashdata('message','The email settings are added successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/email-settings/index/','refresh');
			exit;
		}
				
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Add Email Settings Management System')
			->build('email_add');	
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */