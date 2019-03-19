<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
			
		//load CI library
			$this->load->library('form_validation');		
		//load custom module
			$this->load->model('admin_user');
		
		//load custom helper
			$this->load->helper('editor_helper');
            
		$this->lang->load('english', 'english');
	}
	
	public function index()
	{
		
        
		$this->data['result_data'] = $this->admin_user->get_user_lists();
		$this->data['key'] = 'organizers';
        $this->data['menu'] = 'List Organizers';
		$this->data['head_title'] = "List of Users";
        
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Users List')
			->build('admin_list', $this->data);	
		
	}
    
    public function organizers()
    {
        $this->data['result_data'] = $this->admin_user->get_organizer_lists();
        $this->data['key'] = 'index';
        $this->data['menu'] = 'List Users';
		$this->data['head_title'] = "List of Orgnizers";
        
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Organizers List')
			->build('admin_list', $this->data);
    }
    
    public function organizer($id)
    {
        if(is_ajax())
        {  	
            $this->data['organizer_id'] = $id;
            $organizer = $this->data['organizer'] = $this->admin_user->get_organizer_info($id);
            
    		$this->template    			
    			->enable_parser(FALSE)
    			->title(SITE_NAME.' - Organizer')
    			->build('admin_organizer_detail', $this->data);    
        }
    }
    function organizer_document($organizer_id)
    {
        $user_id = $organizer_id;
        $doc_file = $this->general->get_value_from_id('es_user',$user_id,"organizer_official_doc"); 
        if($doc_file==''){
            $this->session->set_flashdata('message',"<font color='#900'>Document file not found.</font>");
            redirect(site_url(ADMIN_DASHBOARD_PATH.'/users/organizer'));
        }else{
            $file_name = './'.UPLOAD_FILE_PATH.'organizer_doc/'.$doc_file;
            $mime = 'application/force-download';
            header('Pragma: public');    
            header('Expires: 0');        
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private',false);
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
            header('Content-Transfer-Encoding: binary');
            header('Connection: close');
            readfile($file_name);    
            exit();
        }
    }
    
    public function view($id)
    {
        $user = $this->data['profile_data'] = $this->admin_user->get_user_byID($id);    
        if(empty($user))
        {
            $this->session->set_flashdata('error', 'No result found.');
            redirect(site_url(ADMIN_DASHBOARD_PATH));
        }    
        $this->data['full_user_name'] = $this->general->get_user_full_name($id);
        /*referal account information*/
        if($user->referral_id!='0')
        {            
            $this->data['referral_url'] = $this->general->get_referral_url($user->referral_url_id);   
            $this->data['referral'] = $this->general->get_user_short_detail_byID($user->referral_id);   
        }
        /*referal account information*/
        
        /*event lists */
        $this->data['events'] = $this->general->get_event_lists_byOrganizer($id);
        /*event lists */
        
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - '.$this->data['full_user_name'])
			->build('admin_view', $this->data);
    }
	
    public function reset_password()
    {
        if(is_ajax())
        {
            $user_id = $this->input->post('uid');
            $password = rand(10000,10000000);
            
            $this->admin_user->send_reset_password_email($user_id, $password);
            $data = array(
               'password' => base64_encode($password),               
            );
            
            $this->db->where('id', $user_id);
            $query = $this->db->update('user', $data);
            if($query)
            {
                $htm = "Reset password has been sent. $password";
                echo "result=success@@message=".$htm;                
            } 
            else
            {
                echo "result=error@@message=Something went wrong. Session out! Please login.";
            }
        }
    }
    public function change_status($user_id)
    {
        if(is_ajax())
        {
            $status = $this->input->post('status');
            if($status=='1')
            {
                $key = 'active';
                $status_msg = "Active";
            }
            else if($status == '2')
            {
                $key = "pending";
                $status_msg = "Pending";
            }
            else 
            {
                $key = "inactive";    
                $status_msg = "Blocked / Inactive";
            }
            
            $data = array(
               'status' => $status,               
            );

            $this->db->where('id', $user_id);
            $query = $this->db->update('user', $data);
            if($query)
            {
                echo "result=success@@message=".$status_msg."@@key=status-$key-bg";                
            } 
            else
            {
                echo "result=error@@message=Something went wrong. Session out! Please login."."@@key=status-$key-bg";
            }
            
        }
    }
    
    public function change_user_to_organizer()
    {
        if(is_ajax())
        {
            $user_id = $this->input->post('id');            
            
            $data = array(
               'organizer' => '1',               
            );
            $this->db->where('id', $user_id);
            $query = $this->db->update('user', $data);

            if($query)
            {
                $this->admin_user->send_approve_organizer($user_id);
                echo "result=success@@message=active";                
            } 
            else
            {
                echo "result=error@@message=Something went wrong. Session out! Please login.";
            }
            
        }        
    } 
    
    public function administrator()
    {
        $this->data['result_data'] = $this->admin_user->get_administrator_lists();
		$this->data['head_title'] = "List of Administrators";
        
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Administrator List')
			->build('admin_administrator_list', $this->data);	
    }
    
    public function administrator_add()
    {
        $validate_settings =  array(
			array('field' => 'user_name', 'label' => 'Username', 'rules' => 'required|trim'),
            array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required'),
			array('field' => 'email', 'label' => 'Email Address', 'rules' => 'trim|required|valid_email|callback_check_email_check'),			
            array('field' => 'type','label'=>'Admin Role' ,'rules' => 'required'),
        );
        $this->form_validation->set_rules($validate_settings);
		
		if($this->form_validation->run()==TRUE)
		{			
			$this->admin_user->add_admin_user();
			$this->session->set_flashdata('message','Admin User is added successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/users/administrator/');
			exit;
		}
		
        
        $this->data['head_title'] = "Add Administrator";
        $this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Administrator List')
			->build('admin_administrator_add', $this->data);
    }
	
    public function administrator_delete($id='')
    {
        if($id=='' || $id == '101'){            
			$this->session->set_flashdata('message','Can not delete this admin.');
			redirect(ADMIN_DASHBOARD_PATH.'/users/administrator/');
			exit;
        }else{
            $this->db->where('id',$id);
            $this->db->delete('admin_users');   
            
			$this->session->set_flashdata('message','Admin User is deleted successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/users/administrator/');
			exit;
        }
        
    }
    public function administrator_edit($id)    
    {
        if($id=='' || $id == '101'){            
			$this->session->set_flashdata('message','Can not edit this admin.');
			redirect(ADMIN_DASHBOARD_PATH.'/users/administrator/');
			exit;
        }
        
        $data_detail = $this->data['data_detail'] = $this->admin_user->get_admin_user($id);
        
        $validate_settings =  array(
    		array('field' => 'user_name', 'label' => 'Username', 'rules' => 'required|trim'),            
			array('field' => 'email', 'label' => 'Email Address', 'rules' => 'trim|required|valid_email|callback_check_email_check'),			
            array('field' => 'type','label'=>'Admin Role' ,'rules' => 'required'),
        );
        $this->form_validation->set_rules($validate_settings);
		
		if($this->form_validation->run()==TRUE)
		{			
            if(($this->input->post('password', TRUE))=='')
            {
                $password = $data_detail->password;                
            }else{
                $password = md5($this->input->post('password', TRUE)) ;
            }		      
			$this->admin_user->edit_admin_user($id,$password);
			$this->session->set_flashdata('message','Admin User is edited successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/users/administrator/');
			exit;
		}
		
        
        $this->data['head_title'] = "Edit Administrator";
        $this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Administrator List')
			->build('admin_administrator_edit', $this->data);
    }
    
    function enable_user_login($user_id)
    {
        if(is_ajax())
        {
            $data = array(
                    'status'=>'1'
                );
            $this->db->where('id', $user_id);
            $query = $this->db->update('user', $data);
            
            if($query)
                echo "success";
            else 
                echo "error";
        }
    }
    
    function disable_user_login($user_id)
    {
        if(is_ajax())
        {
            $data = array(
                    'status'=>'0'
                );
            $this->db->where('id', $user_id);
            $query = $this->db->update('user', $data);
            if($query)
                echo "success";
            else 
                echo "error";
        }
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */