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
			$this->load->model('admin_bank');
		
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	public function index()
	{		
		$this->data['result_data'] = $this->admin_bank->get_bank_lists();
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Bank View')
			->build('view', $this->data);	
		
	}
	
	public function add_bank()
	{
		$this->data['jobs'] = 'Add';
				
		// Set the validation rules
		$this->form_validation->set_rules($this->admin_bank->validate_settings);		
		
		if($this->form_validation->run()==TRUE)
		{			
			//Insert Lang Settings
			$this->admin_bank->insert_record();
			$this->session->set_flashdata('message','The bank records are insert successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/bank/index','refresh');
			exit;			
		}
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Add Bank')
			->build('add', $this->data);	
	}
	
	
	public function edit_bank($id)
	{
		$this->data['jobs'] = 'Edit';
		
		//check id, if it is not set then redirect to view page
		if(!isset($id))
		{	
			redirect(ADMIN_DASHBOARD_PATH.'/bank/index','refresh');
			exit;
		}
		
		$this->data['data_bank'] = $this->admin_bank->get_bank_byid($id);
		//print_r($this->data['data_help']);
		
		//check data, if it is not set then redirect to view page
		if($this->data['data_bank'] ==false)
		{
			redirect(ADMIN_DASHBOARD_PATH.'/bank/index','refresh');
			exit;
		}

		//Set the validation rules
		$this->form_validation->set_rules($this->admin_bank->validate_settings);		
	
			
		if($this->form_validation->run()==TRUE)
		{
			//Insert Lang Settings
			$this->admin_bank->update_record($id);
			$this->session->set_flashdata('message','The bank records are update successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/bank/index/','refresh');			
			exit;
		}
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Edit Bank')
			->build('edit', $this->data);	
	}
	
	public function delete_bank($id)
	{
			$query = $this->db->get_where('bank', array('id' => $id));
            
			if($query->num_rows() > 0) 
			{
                $val = $query->row();                			     
				$q = $this->db->delete('bank', array('id' => $id));
				if($q)
                    @unlink(UPLOAD_FILE_PATH.'bank/'.$val->bank_logo);
				$this->session->set_flashdata('message','The bank record delete successful.');
				redirect(ADMIN_DASHBOARD_PATH.'/bank/index/','refresh');
				exit;
			}
			else
				{
					$this->session->set_flashdata('message','Sorry no record found.');
					redirect(ADMIN_DASHBOARD_PATH.'/bank/index/','refresh');
					exit;
				}
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */