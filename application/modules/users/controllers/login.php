<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
		
		if($this->session->userdata(SESSION.'user_id'))
        {
        redirect(site_url('home'));exit;
        }
         
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
         
		//load CI library
		$this->load->library('form_validation');
			
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="has-error"><span class="help-block">', '</span></div>');
		
		//load module
		$this->load->model('login_module');
		
	}
	
	public function index()
	{
        //set referral url after login
        //echo $this->session->userdata('redirect_url');
        $this->load->library('user_agent');
        if($this->session->userdata(SESSION.'now_create') == 'yes' ){
            $this->session->set_userdata(array('redirect_url'=>site_url('event/create')));
        }
        else if($this->session->userdata('redirect_url'))
        {
            $this->session->set_userdata(array('redirect_url'=>$this->session->userdata('redirect_url')));
        }        
        else if (!$this->session->userdata('redirect_url') and $this->agent->is_referral())
        {
             $this->session->set_userdata(array('redirect_url'=>$this->agent->referrer()));
        }else if(!$this->agent->is_referral()){            
            $this->session->set_userdata(array('redirect_url'=>site_url('home')));            
        }
        //echo $this->session->userdata('redirect_url');
        // Set the validation rules
		$this->form_validation->set_rules($this->login_module->validate_settings);
		
		if($this->form_validation->run()==TRUE)
		{
			$login_status = $this->login_module->check_login_process();
			if($this->session->userdata(SESSION.'user_id'))
			{       
                $redirect_url = $this->session->userdata('redirect_url');
                /*joined referral program start*/
                if($this->session->userdata('redirect_url')==site_url('affiliate') && $this->session->userdata(SESSION."is_referral_user")=='yes'){
                    $update_data1 = array('is_referral_user'=>'yes');							
                    $this->db->where('id',$this->session->userdata(SESSION.'user_id'));
                    $this->db->update('user',$update_data1);                    
                }
                /*joined referral program start*/
                $this->session->unset_userdata('redirect_url');
                $this->session->unset_userdata(SESSION.'is_referral_user');
                $this->session->unset_userdata(SESSION.'now_create');  
                redirect($redirect_url);                
				exit;
			}
			else
				{					
					$activate_link = "<a href='".site_url('users/login/activate')."'>sign up</a>";
                    if($login_status==='unregistered')					
						 $this->session->set_flashdata('error','You are not registered, Please register first.');
					else if($login_status==='unverified')
						 $this->session->set_flashdata('error','Your account not Verified yet.');	
					else if($login_status==='suspended')
						 $this->session->set_flashdata('error',"You have closed your account, Please $activate_link again to reactivate your account.\n ");		
					else if($login_status==='invalid')
						$this->session->set_flashdata('error','Wrong Password.');
                    else if($login_status==='blocked_ip')	
                        $this->session->set_flashdata('error','Your IP has been blocked.');
                    else                        
					   $this->session->set_flashdata('error','Something went very wrong. Please contact '.CONTACT_EMAIL);
					
                    
                    redirect('users/login');
					exit;
				}
            
		}
		
		//set SEO data
		$this->page_title = $this->lang->line('signin_account').": ".DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('login_body', $this->data);
	}
	
	public function forgot()
	{		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if($this->form_validation->run()==TRUE)
		{
			//check email from our database record
			if($this->login_module->check_email() == 1)
			{
		 		$this->login_module->forget_password_reminder_email();
				$this->session->set_flashdata('message',"Please check your email for new passwod.");
				redirect('/users/login/forgot');
				exit;
			}
            else
            {
            	$this->session->set_flashdata('error',"You are not registered yet. Please sign up for ".SITE_NAME." account.");
            	redirect('/users/login/forgot');
            	exit;
            }
			
		}
		
		//set SEO data
		$this->page_title = "Forgot your password";
		$this->data['meta_keys'] = "Forgot your password";
		$this->data['meta_desc'] = "Forgot your password";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('forgot_password', $this->data);
	}
    
    function activate()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if($this->form_validation->run()==TRUE)
		{
			//check email from our database record
			if($this->login_module->check_email() == 1)
			{
		 		
				if($this->login_module->check_email_activate()== 1)
                {
                    $this->login_module->change_activate_code();
                    $this->login_module->activate_account_email();
                    $this->session->set_flashdata('message',"Please check your email to activate your account.");
    				redirect('/users/login/activate');
    				exit;    
                }
                else
                {
                    $this->session->set_flashdata('message',"Your account is in active mode.");
    				redirect('/users/login/activate');
    				exit;
                }
                
			}
            else
            {
            	$signup = "<a href='".site_url('users/register')."'>sign up</a>";
                $this->session->set_flashdata('error',"You are not registered yet. Please $signup for ".SITE_NAME." account.");
            	redirect(site_url('/users/login/activate'));
            	exit;
            }
			
		}
		
        
        //set SEO data
		$this->page_title = "Activate account : ".DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('activate_account', $this->data);
    }
    
    public function confirm_activation($activation_code,$user_md5,$user_id)
	{
		
		if($this->login_module->make_activate_account($activation_code,$user_md5,$user_id)==true)
		{
		  	$this->session->set_userdata(array(SESSION.'now_create' => "yes"));    	
            $this->session->set_flashdata('message',"Welcome! your account has been activated.");		
		}
		else
		{
			$this->session->set_flashdata('error',"Failed to activate your account.");
		}
		redirect(site_url('login'));
	}
    
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */