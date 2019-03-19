<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Affiliate extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
		
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
        
		if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }
		//load CI library
		$this->load->library('form_validation');			
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		//load module
		$this->load->model('affiliate_model');
		
		
	}
	
	public function index()
	{
		if($this->session->userdata(SESSION.'user_id'))
        {
            $profile_data = $this->data['profile_data'];
            if($profile_data->is_referral_user == 'yes')
            {
                $this->data['referral_member'] = TRUE;
                $this->data['referral_urls'] = $this->affiliate_model->get_referral_urls();    
            }else{
                $this->data['referral_member'] = FALSE;                             
            }        
                    
            //set SEO data
    		$this->page_title = DEFAULT_PAGE_TITLE;
    		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
    		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
            $this->data['nav'] = 'affiliate';
    		
    		$this->template
    			->set_layout('account')
    			->enable_parser(FALSE)
    			->title($this->page_title)			
    			->build('affiliate_index', $this->data);		    
		}else{
            redirect(site_url());		  
		}
	}
    
    public function ea_program()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
            $profile_data = $this->data['profile_data'];
            if($profile_data->organizer == '1')
            {
                $this->data['organizer'] = TRUE;
                $this->data['affiliate_events'] = $this->affiliate_model->get_event_referral_urls();    
            }else{
                $this->data['organizer'] = FALSE;                             
                $this->data['affiliate_events'] = $this->affiliate_model->get_event_referral_urls();
            } 
            
            //set SEO data
    		$this->page_title = DEFAULT_PAGE_TITLE;
    		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
    		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
            $this->data['nav'] = 'affiliate';
    		
    		$this->template
    			->set_layout('account')
    			->enable_parser(FALSE)
    			->title($this->page_title)			
    			->build('affiliate_ea_program', $this->data);            
        }else{
            redirect(site_url());
        }
        
    }
    
    public function payments()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {            
            $profile_data = $this->data['profile_data'];
            if($profile_data->is_referral_user == 'yes')
            {
                $this->data['affilates'] = TRUE;                    
            }else{
                $this->data['affilates'] = FALSE;                             
            } 
            
            //set SEO data
    		$this->page_title = DEFAULT_PAGE_TITLE;
    		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
    		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;    
            $this->data['nav'] = 'affiliate';        
    		
    		$this->template
    			->set_layout('account')
    			->enable_parser(FALSE)
    			->title($this->page_title)			
    			->build('affiliate_payments', $this->data);            
        }else{
            redirect(site_url());
        }
        
    }
    public function payments_detail()
    {
        if(is_ajax())
        {
            
            $this->data['last_payments_detail'] =$this->affiliate_model->get_last_referral_payment_details(); ;
            $this->data['payments_detail'] =$this->affiliate_model->get_referral_payment_details(); ;
            $this->load
    			->view('affiliate_payments_detail', $this->data);
        }
    }
    
    public function event_list()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
            $profile_data = $this->data['profile_data'];
            $this->data['affiliate_events'] = $this->affiliate_model->get_affiliate_event_lists("limited");
        }else{
            $this->data['affiliate_events'] = $this->affiliate_model->get_affiliate_event_lists("all");
        }    
        //set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'event';
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('affiliate_event_list', $this->data);             
    
        
        
    }
    
    public function reff_url($url)
    {
        if(!$url){
            redirect(site_url());exit;            
        }        
        $referral_url = $this->affiliate_model->get_user_referral_url_detail($url);
        
        if($referral_url){    
            //var_dump($referral_url);exit;
            $this->affiliate_model->increase_user_referral_visit_counter($referral_url->id);            
            $cookie_ref2 = array('name'   => SESSION."referral_id",'value'  => $referral_url->user_id,'expire' => time()+3600*24*14,site_url());            
            $this->input->set_cookie($cookie_ref2);            
            
            $cookie_ref1 = array('name'   => SESSION."referral_url_id",'value'  => $referral_url->id,'expire' => time()+3600*24*14,site_url());            
            $this->input->set_cookie($cookie_ref1);
            
            redirect(site_url('register'));                
        }else{            
            redirect(site_url());exit;            
        }        
    }
    
    public function reff_event_url($url)
    {
        if(!$url){
            redirect(site_url());exit;            
        } 
        
        $referral_url = $this->affiliate_model->get_referral_event_url_detail($url);
        
        if($referral_url){  
            //var_dump($referral_url);exit;
            $this->affiliate_model->increase_event_referral_visit_counter($referral_url->id);            
            $cookie_ref2 = array('name'   => SESSION."referral_event_url_id",'value'  => $referral_url->id,'expire' => time()+3600*24*14,site_url());            
            $this->input->set_cookie($cookie_ref2);
            
            redirect(site_url('event/'.$referral_url->event_id));
        }else{            
            redirect(site_url());exit;            
        }
    }
    
    public function add_referral_url()
    {
        if(is_ajax())
        {
            $user_ses_id = $this->session->userdata(SESSION."user_id");
			
			if(!isset($user_ses_id))
			{
				echo 'result=error@@message='.$this->lang->line('session_expired_try_again');exit;
			}
            
            $this->load->library('general');        	      
            $url1 = $this->general->genRandomString(5).rand(0,$user_ses_id);
            $data_url1 = array('user_id'=>$user_ses_id,'referral_url'=>$url1);
            $res = $this->db->insert('user_referral_url',$data_url1); 
            
            if($res){
                $url_id = $this->db->insert_id();
                echo "result=success@@url=".$url1."@@url_id=".$url_id;    
            }else{
                echo "result=error@@message=".$this->lang->line('can_not_add_new_url');
            }
            
        }
    }
    
    public function remove_referral_url()
    {
        if(is_ajax())
        {
            $user_ses_id = $this->session->userdata(SESSION."user_id");
			$url_id = $this->input->post('url_id');            
			if(!isset($user_ses_id))
			{
				echo 'result=error@@message=Session out! Please login.';exit;
			}
            
            if(empty($url_id)){
                echo "result=error@@message=Referral url has been used. Can not be removed.";
                exit;
            }
            
            $check_url_used = $this->affiliate_model->check_url_used($url_id); 
            
            if($check_url_used)
            {
                echo "result=error@@message=Referral url has been used. Can not remove.";
                exit;
            }
            
            $this->db->where('id', $url_id);
            $res = $this->db->delete('user_referral_url');
            
            if($res)
            {
                echo "result=success@@message=Referral url has been deleted successfully.";                
            }else{
                echo "result=error@@message=Something went wrong.";
            }
        }
    }
    
    public function join_affiliate_event()
    {
        if(is_ajax())
        {
            $user_ses_id = $this->session->userdata(SESSION."user_id");			
            
			if(!isset($user_ses_id))
			{
				echo 'result=error@@message=Session out! Please login.';exit;
			}
            
            $event_id = $this->input->post('event_id');
            $organizer_id = $this->input->post('organizer_id');
            $affiliate_rate = $this->input->post('affiliate_rate');
            
            if(empty($event_id) || empty($organizer_id) || empty($affiliate_rate)){
                echo "result=error@@message=Something went wrong. Please try again.";
                exit;
            }
            
            //$url = $this->general->genRandomString(3).rand(0,$event_id).$this->general->genRandomString(3).rand(0,$user_ses_id);
            $url = $this->general->genRandomString(2).($event_id%100).$this->general->genRandomString(1).rand(0,$user_ses_id);
            $data_url1 = array('user_id'=>$user_ses_id,'event_id'=>$event_id,'organizer_id'=>$organizer_id,'url'=>$url,'affiliate_percent'=>$affiliate_rate);
            
            $res = $this->db->insert('event_referral_url',$data_url1);
            
            if($res){
                $this->db->query("UPDATE `es_user` SET `is_referral_user` = 'yes' WHERE `id` = '$user_ses_id'");
                echo "result=success@@message=".site_url("e/".$url)."@@link=".$this->lang->line('view_detail');
            }                
            else
                echo "result=error@@message=Something went wrong here. Please try again."; 
            
        }
    }
    
    public function register()
    {
        $this->session->set_userdata(array('redirect_url'=>site_url('affiliate/event_list')));
        $this->session->set_userdata(array(SESSION.'is_affiliate_user'=>'yes'));  
        redirect(site_url('login')); 
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */