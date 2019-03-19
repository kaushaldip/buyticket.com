<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
		
		if(!$this->session->userdata(SESSION.'user_id'))
        {
          	redirect(site_url('home'));exit;
        }
		//load CI library
		$this->load->library('form_validation');
		
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
        	
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger"> ', '</span>');
		
		//load module
		$this->load->model('account_module');
		
		$this->data['profile_data'] = $this->account_module->get_user_profile_data();
		
	}
	public function index()
    {
        if($this->data['profile_data'] == false)
		{
          	$this->session->set_flashdata('message', 'Confirm email first to access your account. Please check your email.');
            redirect(site_url('event'));exit;
        }
        		
		// Set the validation rules
		$this->form_validation->set_rules($this->account_module->validate_settings);
        
        $this->page_title = ucwords($this->data['profile_data']->first_name." ".$this->data['profile_data']->last_name);        
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['nav'] = 'users';        
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('account_profile', $this->data);
            
        
    }
	public function editprofile()
	{

		if($this->data['profile_data'] == false)
		{
          	redirect(site_url('home'));exit;
        }
        		
		// Set the validation rules
		$this->form_validation->set_rules($this->account_module->validate_settings);
        //print_r($this->input->post());
		
		if($this->form_validation->run()==TRUE)
		{			
			$activation_code = $this->account_module->update_user_profile();
            
            if($activation_code){
                $this->session->set_userdata(array(SESSION.'first_name' => $this->input->post('first_name',TRUE)));								
				$this->session->set_userdata(array(SESSION.'last_name' => $this->input->post('last_name',TRUE),));
            }
            
            /*email to changes in mail start*/
            if($this->input->post('email_update_notify') == '1')
            {
                $this->account_module->mail_update_user_profile($this->session->userdata(SESSION.'user_id'));    
            }            
            /*email to changes in mail end*/
			
			if($this->data['profile_data']->email != $this->input->post('email', TRUE))
			{
				//update new email & send confirmation email
				$this->account_module->update_new_email_confirmation_email($this->data['profile_data']);
				$this->session->set_flashdata('message', 'The verification email is send to the your new email address.');
			}
			else
			$this->session->set_flashdata('message', $this->lang->line('your_profile_update_msg'));
			
			redirect('users/account/index','refresh');            
			exit;
		}
		
        $this->data['nav'] = "users";
		//set SEO data
		$this->page_title = "Edit Profile : ".ucwords($this->data['profile_data']->first_name." ".$this->data['profile_data']->last_name);
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('account_profile_edit', $this->data);
	}
	
	
	
	public function activation($email='',$code='',$id='')
	{
		 $query = $this->db->get_where('user',array('activation_code'=>$code,'id'=>$id));
		
		 if($query->num_rows()>0)
         {
		 		$user_data = $query->row_array();

				$user_id=$user_data['id'];
				$new_email=$user_data['email_alternate'];
			
			 	$data=array('email'=>$new_email);
                $this->db->where('id',$id);
                $this->db->update('user',$data);
								
				$this->session->set_flashdata('message', 'Your new email address is updated.');
			
				redirect('users/account/index','refresh');   
		 }
		 else
		 {
		 		$this->session->set_flashdata('message', 'There is no validation information to change your email.');
			
				redirect('users/account/index','refresh');   
		 }
	}
	
	public function changepassword()
	{
		
		// Set the validation rules
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('re_password', 'Re Password', 'trim|required|matches[new_password]');

		
		if($this->form_validation->run()==TRUE)
		{
			//check current password with previous password
			if($this->account_module->check_old_password()==1)
			{
				//change new password
				$change_password = $this->account_module->change_password();
                if($change_password)
                    $this->account_module->mail_change_password();
                
			 	$this->session->set_flashdata('message', 'Your new password has been changed successful.');
				$this->session->sess_destroy();
				redirect('/users/login','refresh');            
				exit;
			}
			else
			{
				 $this->session->set_flashdata('password_error', 'Invalid Password.' );
				 redirect('users/account/changepassword','refresh');
				 exit;
			}
			
			
		}
		
		//set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['nav'] = "users";
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title('My Account')			
			->build('change_password', $this->data);
	}
	
    public function closeaccount()
    {           
        $this->data['notification'] = $this->general->get_single_record('user','email_event_notify,email_update_notify','id',$this->session->userdata(SESSION.'user_id'));
        
        
        if($this->input->post('close_acc_submit'))
        {
            
                
            $msg = "";
            if($this->input->post('closing_reason')=='dislike_system')
            {
                if($this->input->post('dislike_system')=='')
                {
                    $this->session->set_flashdata('message', 'You must entry the reson to deactivate your account.');
                    redirect('/users/account/closeaccount','refresh'); 
                    exit;
                }
                $msg = "Dislike the system (reason): ";
                $msg .= $this->input->post('dislike_system');
            }                
            else{
                if($this->input->post('other')=='')
                {
                    $this->session->set_flashdata('message', 'You must entry the reson to deactivate your account.');
                    redirect('/users/account/closeaccount','refresh'); 
                    exit;
                }
                $msg = $this->input->post('other');
            }
                
            
            $this->db->set('inactive_reason',$msg);    
            $this->db->set('status','0');  
            $this->db->set('closed_account','yes');                  
			$this->db->where("id", $this->session->userdata(SESSION.'user_id'));                
            $query = $this->db->update("user");
            
            if($query)
                $this->account_module->mail_close_account($this->session->userdata(SESSION.'user_id'));
            
            $this->session->set_flashdata('message', lang('Your account is inactive now.') );
			$this->session->sess_destroy();
			redirect('/users/login','refresh'); 
            exit;                            
                                
        }    
        
        $this->data['nav'] = "users";    
        //set SEO data
		$this->page_title = "Close account";
		$this->data['meta_keys'] = "Close account,".DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = "Close account,".DEFAULT_PAGE_TITLE;
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title('My Account')			
			->build('close_account', $this->data);
    }
    
    public function change_notification()
    {
        if($this->input->post('checkpoint') =='event')
        {
            if($this->input->post('value')=='off'){
                $this->db->set('email_event_notify','1');            
    			$this->db->where("id", $this->session->userdata(SESSION.'user_id'));                
                $this->db->update("user ");
                echo 'on';	
            }                
            else if($this->input->post('value')=='on')
            {
                $this->db->set('email_event_notify','0');            
    			$this->db->where("id", $this->session->userdata(SESSION.'user_id'));                
                $this->db->update("user ");
                echo 'off';
            }
        }
        else if($this->input->post('checkpoint')=='update')
        {
            if($this->input->post('value')=='off'){
                $this->db->set('email_update_notify','1');            
    			$this->db->where("id", $this->session->userdata(SESSION.'user_id'));                
                $this->db->update("user ");
                echo 'on';	
            }                
            else if($this->input->post('value')=='on')
            {
                $this->db->set('email_update_notify','0');            
    			$this->db->where("id", $this->session->userdata(SESSION.'user_id'));                
                $this->db->update("user ");
                echo 'off';
            }
        }
    }
	
	public function invitefriends()
	{
		$this->form_validation->set_rules('email1', 'Email 1 Address', 'trim|required|valid_email');
		
		if($this->form_validation->run()==TRUE)
		{
			foreach($_POST as $key=>$val)
			{
				//load email library
				$this->load->library('email');
					//configure mail
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$config['mailtype'] = 'html';
					$config['protocol'] = 'sendmail';
					$this->email->initialize($config);
					
							
				$this->load->model('email_model');		
				
				//get subjet & body
				$template=$this->email_model->get_email_template("invite_friends");
				
                    $subject = $template['subject'];
                    $emailbody = $template['email_body'];
                
				//check blank valude before send message
				if(isset($subject) && isset($emailbody))
				{
					//parse email			
					$confirm="<a href='".site_url('users/register/index/'.$this->session->userdata(SESSION.'username'))."'>".site_url('users/register/index/'.$this->session->userdata(SESSION.'username'))."</a>";
			
							$parseElement=array("USERNAME"=>$this->session->userdata(SESSION.'username'),
												"CONFIRM"=>$confirm,
												"SITENAME"=>SITE_NAME,														
												"FIRSTNAME"=>$this->session->userdata(SESSION.'first_name').' '.$this->session->userdata(SESSION.'last_name'));
			
							$subject=$this->email_model->parse_email($parseElement,$subject);
							$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
							
					//set the email things
					$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
					$this->email->to($val); 
					$this->email->subject($subject);
					$this->email->message($emailbody); 
					$this->email->send();
				}
			}
		}
		//set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title('My Account')			
			->build('invitefriends', $this->data);
	}
	
	public function profileimage()
	{
		$this->load->library('upload');
		$this->load->library('image_lib');
		
		echo $this->account_module->upload_profile_image();
		
	}
	
	public function check_email_check()
	 {
		if($this->account_module->get_aleady_registered_email()==TRUE)
		{
			$this->form_validation->set_message('check_email_check', lang('register_email_in_used'));
			return false;
		}
		 return true;
	}
    
    public function verify_email($activation_code, $user_id)
    {
		 
         if($this->session->userdata(SESSION.'user_id') == $user_id){
            
             $query = $this->db->get_where('user',array('activation_code'=>$activation_code,'id'=>$user_id));
    		
    		 if($query->num_rows()>0)
             {
    		 		$user_data = $query->row_array();
    			
    			
    			 	$data=array('verified_email'=>'yes');
                    $this->db->where('id',$user_id);
                    $this->db->update('user',$data);
    								
    				$this->session->set_flashdata('message', 'Your new email address is verified.');
                    
                    $activation_code = $this->general->random_number();
                    $data = array(
        			   'activation_code'=>$activation_code,
                    );
                    $this->db->where('id',$user_id);
                    
    			
    				redirect('users/account/index','refresh');   
    		 }
    		 else
    		 {
    		 		$this->session->set_flashdata('message', 'There is no validation information to change your email.');
    			
    				redirect('users/account/index','refresh');   
    		 }
         }else{
            $this->session->set_flashdata('message', 'You are not logged in.');
    			
    		redirect(site_url('event/index'));
         }
         
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */