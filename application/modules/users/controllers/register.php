<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
		
	
		//load CI library
		$this->load->library('form_validation');
        
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
        
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="has-error"><span class="help-block">', '</span></div>');
		
		//load module
		$this->load->model('register_module');
		//load module
		$this->load->model('login_module');
		
		if($this->uri->segment(3))
		{
			$this->session->set_userdata('refer_username',$this->uri->segment(3));
		}
		
	}
	
	public function index()
	{
		if($this->session->userdata(SESSION.'user_id'))
        {
            redirect(site_url(''));exit;
        }
        //save referral url for 14days
        $this->load->library('user_agent');
        
        // Set the validation rules
		$this->form_validation->set_rules($this->register_module->validate_settings);
		
		if($this->form_validation->run()==TRUE)
		{
			/*username final testing for not lying keywords*/            
            if($this->general->test_username_keywords($this->input->post('user_name')))
            {
                $username  = $this->input->post('user_name');
                $this->session->set_userdata('user_name','Username is invalid or unauthorized.');		
                //redirect('users/register','refresh');
                //exit;
            }else{
                /*username final testing for not lying keywords*/
                $activation_code=$this->register_module->insert_user();
                if($activation_code!='system_error')
                {
                    delete_cookie(SESSION."referral_id") ;              			     
                    delete_cookie(SESSION."referral_url") ;
                    
                    //make login after register start
                    $this->load->model('event/event_payment_model');                    
                    $this->event_payment_model->make_login($this->register_module->user_id);
                    
                	if($this->session->userdata('is_fb_user')=="Yes")
                	{
                		$login_status = $this->login_module->check_login_process();
                		if($this->session->userdata(SESSION.'user_id'))
                		{
                			//unset CUSTOM SESSION FOR FB
                			$this->session->unset_userdata('fb_signup');
                			$this->session->unset_userdata('me');
                			$this->session->unset_userdata('is_fb_user');
                			redirect(site_url(''));
                			exit;
                		}
                
                	}
                	else
                	{
                		$this->session->set_userdata("registration","success");
                		$this->register_module->reg_confirmation_email($activation_code);
                        if($this->session->userdata(SESSION.'is_referral_user') == 'yes'){
                            $this->session->unset_userdata(SESSION.'is_referral_user');
                            $this->session->unset_userdata(SESSION.'is_affiliate_user');
                            $this->general->set_notification($this->input->post('email', TRUE). " has registered as new referral user.",'users/index'); //notification
                            redirect('users/register/success_affiliate/','refresh');
                        }                            
                        else if($this->session->userdata(SESSION.'is_affiliate_user') == 'yes'){
                            $this->session->unset_userdata(SESSION.'is_referral_user');
                            $this->session->unset_userdata(SESSION.'is_affiliate_user');
                            $this->general->set_notification($this->input->post('email', TRUE). " has registered as new affiliate user.",'users/index'); //notification
                            redirect('users/register/success_affiliate/','refresh');
                        }                            
                        else{
                            $this->session->unset_userdata(SESSION.'is_referral_user');
                            $this->session->unset_userdata(SESSION.'is_affiliate_user');
                            $this->general->set_notification($this->input->post('email', TRUE). " has registered as new organizer user.",'users/index'); //notification
                            redirect('users/register/success_organizer/','refresh');
                        }                            
                		exit;
                	}
                }
            }
            
            
		}
		
		//set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('register_body', $this->data);
	}
	
	public function success()
	{				
        if($this->session->userdata(SESSION.'user_id'))
        {
            redirect(site_url(''));exit;
        }
    	if($this->session->userdata("registration") != "success")
		{
			redirect('users/register','refresh');
			exit;
		}
		$this->data['cms'] = $this->register_module->get_cms(19);
		
		//set SEO data
		$this->page_title = SITE_NAME." | Registration Success" ;//DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		$this->session->set_userdata(array(SESSION.'now_create' => "yes"));    	
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('register_status', $this->data);
	}
    public function success_organizer()
    {	       
    	if($this->session->userdata("registration") != "success")
		{
			redirect('users/register','refresh');
			exit;
		}
        $this->data['main_event_types'] =  $this->general->get_event_type_lists("main","5");
        $this->data['banner'] = "yes";
		$this->data['cms'] = $this->register_module->get_cms(36);
		
		//set SEO data
		$this->page_title = SITE_NAME." | Registration Success" ;//DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		$this->session->set_userdata(array(SESSION.'now_create' => "yes"));    	
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('register_status', $this->data);
	}
    
    public function success_affiliate()
    {
    	if($this->session->userdata("registration") != "success")
		{
			redirect('users/register','refresh');
			exit;
		}
		$this->data['cms'] = $this->register_module->get_cms(37);
		
		//set SEO data
		$this->page_title = SITE_NAME." | Registration Success" ;//DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		$this->session->set_userdata(array(SESSION.'now_create' => "yes"));    	
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('register_status', $this->data);
	}
	
	public function activation($activation_code,$user_id)
	{
		if($this->session->userdata(SESSION.'user_id'))
        {
            redirect(site_url(''));exit;
        }
		if($this->register_module->activated($activation_code,$user_id)==true)
		{
		  	$this->session->set_userdata(array(SESSION.'now_create' => "yes"));    	
            $cms_id = 21;			
		}
		else
		{
			$cms_id = 22;			
		}
				
		$this->data['cms'] = $this->register_module->get_cms($cms_id);
		
		//set SEO data
		$this->page_title = "Registraion Activation" ;//DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('register_status', $this->data);
	}
    
    public function join_referral()
    {        
        if($this->session->userdata(SESSION.'user_id')){
            $this->load->library('general');      
            if($this->general->is_referral_user($this->session->userdata(SESSION.'user_id'))){
               // $this->session->set_flashdata('message',"You have already joined referral user.");
            }else{
                $user_id = $this->session->userdata(SESSION.'user_id');                  	      
                
                $data=array('is_referral_user'=>'yes');
                $this->db->where('id',$user_id);
                $this->db->update('user',$data);
				
                
                $url1 = $this->general->genRandomString().$user_id;
                $data_url1 = array('user_id'=>$user_id,'referral_url'=>$url1);
                $this->db->insert('user_referral_url',$data_url1);
            }
            redirect(site_url('affiliate/index'));    
        }else{
            $this->session->set_userdata(array('redirect_url'=>site_url('affiliate')));
            $this->session->set_userdata(array(SESSION.'is_referral_user'=>'yes'));    
            redirect(site_url());    
        }
    }
    
    public function register_organizer()
    {
        $this->session->set_userdata(array('redirect_url'=>site_url('event/create')));
        $this->session->unset_userdata(SESSION.'is_referral_user');
        $this->session->unset_userdata(SESSION.'is_affiliate_user');
        redirect(site_url('users/register'));
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */