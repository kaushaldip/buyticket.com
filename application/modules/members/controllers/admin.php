<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); //error_reporting(0);

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
		$this->lang->load('english', 'english');	
		//load CI library
			$this->load->library('form_validation');
			$this->load->library('pagination');

		//load custom module
			$this->load->model('admin_member');
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	public function index()
	{		
		if($this->uri->segment(3)) $status = $this->uri->segment(3); else $status = 'active';
		//set pagination configuration			
		$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/members/index/'.$status;
		$config['total_rows'] = $this->admin_member->get_total_members($status);
		$config['num_links'] = 10;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['per_page'] = '30'; 
		$config['next_tag_open'] = '<span>';
		$config['next_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<span>';
		$config['cur_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span>';
		$config['num_tag_close'] = '</span>';		
		$config['uri_segment'] = '3';		
		$this->pagination->initialize($config); 
		
		$offset=$this->uri->segment(3,0);
		
		$this->data['result_data'] = $this->admin_member->get_members_details($this->uri->segment(3),$config['per_page'],$offset);
		
		//$this->data = '';
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Members View')
			->build('members_view', $this->data);	
		
	}
	
	
	public function edit_member($status,$id)
	{
		//check id, if it is not set then redirect to view page
		if(!isset($id)){redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');exit;}
		
		$this->data['profile'] = $this->admin_member->get_member_byid($id);
		
		//check data, if it is not set then redirect to view page
		if($this->data['profile'] == false){redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');exit;}
		$this->data['ship_addr'] = $this->admin_member->get_user_shipping_details($id);

		//Set the validation rules
		$this->form_validation->set_rules($this->admin_member->validate_settings_edit);
		
		if($this->form_validation->run()==TRUE)
		{
			//Insert Lang Settings
			$this->admin_member->update_record($id);
			$this->session->set_flashdata('message','The Member records are update successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');			
			exit;
		}
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Member Edit')
			->build('member_edit', $this->data);
	}
	
	public function delete_member($status,$id)
	{
		$query = $this->db->get_where('members', array('id' => $id));

			if($query->num_rows() > 0) 
			{
				$this->db->delete('members', array('id' => $id));				
				$this->session->set_flashdata('message','The member record delete successful.');
				redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');
				exit;
			}
			else
				{
					$this->session->set_flashdata('message','Sorry no record found.');
					redirect(ADMIN_DASHBOARD_PATH.'/members/index/'.$status,'refresh');
					exit;
				}
	}
	
	public function check_email()
	{
		
		$user_id = $this->input->post('user_id');
		$email = $this->input->post('email');
		$query = $this->db->get_where('members', array('id !=' => $user_id, 'email'=>$email));
		if($query->num_rows() > 0) 
		{
			$this->form_validation->set_message('check_email',"The email address is already in used.");
			return false;
		}
	}
	
	public function transaction($status,$user_id)
	{
		if($this->uri->segment(3)) $status = $this->uri->segment(3); else $status = 'active';
		//set pagination configuration			
		$config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/transaction/index/'.$status;
		$config['total_rows'] = $this->admin_member->count_member_transaction($user_id);
		$config['num_links'] = 10;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['per_page'] = '30'; 
		$config['next_tag_open'] = '<span>';
		$config['next_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<span>';
		$config['cur_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span>';
		$config['num_tag_close'] = '</span>';		
		$config['uri_segment'] = '5';		
		$this->pagination->initialize($config); 
		
		$offset=$this->uri->segment(5,0);
		
		$this->data['result_data'] = $this->admin_member->get_member_transaction($user_id,$config['per_page'],$offset);
				
		//$this->data = '';
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Members Transaction')
			->build('member_transaction', $this->data);
	}
	
	public function bids($status,$user_id)
	{
	
		$this->data['result_data'] = $this->admin_member->get_member_bids($user_id);
		$this->data['user_id'] = $user_id;
		
		//$this->data = '';
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title('Auktis - Members Bidding Information')
			->build('member_bidding', $this->data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */