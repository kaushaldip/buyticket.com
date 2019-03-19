<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
		
		if($this->session->userdata(SESSION.'user_id'))
         {
          	redirect(site_url(''));exit;
         }
		//load CI library
			$this->load->library('form_validation');
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
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
		//save referral url for 14days
        $this->load->library('user_agent');
        if ($this->agent->is_referral())
        {
             $referal_url =  $this->agent->referrer();
            
            $options = array('url'=>$referal_url);
            $query_ref = $this->db->get_where('user_refferal_url',$options);
            
            if(($this->input->cookie(SESSION.'referral_url')))
            {
                $old_referral_url = $this->input->cookie(SESSION.'referral_url');
                $options = array('url'=>$old_referral_url);
                $query_ref = $this->db->get_where('user_refferal_url',$options);
                
                if(($query_ref->num_rows()==0))
                {
                    $record_ref = $query_ref->row_array();                
                    $cookie_ref1 = array('name'   => SESSION."referral_url",'value'  => $record_ref['url'],'expire' => time()+3600*24*14);
                    $this->input->set_cookie($cookie_ref1);	                
                    $cookie_ref2 = array('name'   => SESSION."referral_id",'value'  => $record_ref['user_id'],'expire' => time()+3600*24*14);
                    $this->input->set_cookie($cookie_ref2);
                }
                
            }
            else if($query_ref->num_rows()>0){
                $record_ref = $query_ref->row_array();                
                $cookie_ref1 = array('name'   => SESSION."referral_url",'value'  => $record_ref['url'],'expire' => time()+3600*24*14,site_url());
                $this->input->set_cookie($cookie_ref1);	                
                $cookie_ref2 = array('name'   => SESSION."referral_id",'value'  => $record_ref['user_id'],'expire' => time()+3600*24*14,site_url());
                $this->input->set_cookie($cookie_ref2);
            }else{
                //echo "no referal";
            }
            
		
        }
        echo $this->input->cookie(SESSION.'referral_url');
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
                		redirect('users/register/success/','refresh');
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
		
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('register_status', $this->data);
	}
	
	public function activation($activation_code,$user_id)
	{
		
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
        $this->session->set_userdata(array(SESSION.'referral_user'=>'yes'));
        redirect(site_url('register'));
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */