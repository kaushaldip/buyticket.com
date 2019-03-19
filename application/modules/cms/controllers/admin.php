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
			$this->load->model('Admin_cms');
		
		//load custom helper
			$this->load->helper('editor_helper');
		
	}
	
	public function index($id)
	{	
		//if parent id is blank then redirect to dashboard page
		if(!isset($id)){redirect(ADMIN_DASHBOARD_PATH,'refresh');exit;}
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//print_r($_POST);
		// Set the validation rules
		$this->form_validation->set_rules($this->Admin_cms->validate_cms);
		
		if($this->form_validation->run()==TRUE)
		{
			//update site setting
			$this->Admin_cms->update_site_settings();
			$this->session->set_flashdata('message','The CMS Page are update successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/cms/index/'.$id,'refresh');
			exit;
		}
		
		$this->data['cms_data'] = $this->Admin_cms->get_cms_byid($id);
                $this->data['all_cms'] = $this->Admin_cms->get_all_cms();
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Content Management System')
			->build('cms_view', $this->data);	
		
	}
	public function add()
    {

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		//print_r($_POST);
		// Set the validation rules
		$this->form_validation->set_rules($this->Admin_cms->validate_cms);
		
		if($this->form_validation->run()==TRUE)
		{
			//update site setting
			$this->Admin_cms->add_site_settings();
                        $id=$this->db->insert_id();
			$this->session->set_flashdata('message','The Content are added successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/cms/index/'.$id,'refresh');
			exit;
		}
				
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Add Email Settings Management System')
			->build('cms_add');	
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */