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
		$this->load->model('Admin_site_settings');

		
	}
	
	public function index()
	{           
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		// Set the validation rules
		$this->form_validation->set_rules($this->Admin_site_settings->validate_site_settings);
		
		if($this->form_validation->run()==TRUE)
		{
			//update site setting            
			$this->Admin_site_settings->update_site_settings();
			$this->session->set_flashdata('message','The site settings records are update successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/site-settings/index','refresh');
			exit;
		}
		
		$this->data['site_set'] = $this->Admin_site_settings->get_site_setting();
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Site Settings')
			->build('site_settings', $this->data);
	}
    
    public function notification()
    {
		$this->data['notification'] = $this->general->get_notification();
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - notification')
			->build('notification', $this->data);	
		
	}
    
    public function change_to_read()
    {
        if(is_ajax())
        {
            $id = $this->input->post('id');
            if($id == 'all'){
                $data = array('read'=>'yes');
                $this->db->limit(10);                
                $this->db->update('notification',$data);
            }else{
                $data = array('read'=>'yes');
                $this->db->where('id',$id);
                $this->db->update('notification',$data);    
            }
            
        }
    }
    
    public function delete_notification()
    {
        if(is_ajax())
        {   
            $id = $this->input->post('id');
            $this->db->where('id',$id);
            $this->db->delete('notification');
        }
    }
    
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */