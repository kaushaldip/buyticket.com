<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organizer extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
        
		
		
		//load CI library
		$this->load->library('form_validation');			
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		
		//load module
		$this->load->model(array('organizer_model'));
		
	}
	
	public function index()
	{
        if(!$this->session->userdata(SESSION.'user_id')){
            redirect(site_url('users/login'));exit;
        }	   
		$organizer = $this->data['organizer'] = $this->organizer_model->get_organizer_info(); 
        
        // Set the validation rules
		$this->form_validation->set_rules($this->organizer_model->validate_settings);
        //print_r($this->input->post());
		
		if($this->form_validation->run()==TRUE)
		{
            
            if($this->organizer_model->update_organizer_information()){
                $this->session->set_userdata(SESSION.'organizer','2');
                $this->session->set_flashdata('message', "Organizer Information $organizer->organizer_name updated successfully.");   
                $this->general->set_notification($this->session->userdata(SESSION.'email'). " has updated user verification form.",'users/organizers'); //notification                 
            }
            
            redirect('organizer/index');
            			
			  
        }
        //for login users only
        $this->load->model('users/account_module');
        $this->data['profile_data'] = $this->account_module->get_user_profile_data(); 
        
        //set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'index';        
        $this->data['nav'] = 'organizer';
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('organizer_index', $this->data);	
		
	}
    
    
   
    public function event()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        $this->data['organizer'] = $this->organizer_model->get_organizer_info(); 
		$this->data['current_events'] = $this->organizer_model->get_current_event();
                
        $this->data['past_events'] = $this->organizer_model->get_past_event();
        
        //$this->data['total_events'] = $this->organizer_model->total_events('1');
        //set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'event';
        $this->data['nav'] = 'organizer';
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('organizer_event', $this->data);	
		
	}
    public function view($id)
    {
        $organizer = $this->data['organizer'] = $this->organizer_model->get_organizers($id);        
        if(!$organizer){
            $this->session->set_flashdata('message','No organizer detail found.');
            redirect(site_url('event'));
        }
            
        //set SEO data
		$this->page_title = $organizer->name.": ".DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = $organizer->name." ".DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = $organizer->name." ".DEFAULT_PAGE_TITLE;
        //$this->data['navigation'] = 'event';
		 
                $this->data['current_events']=$this->organizer_model->get_events_of_organizer_current($id);
                $this->data['past_events']=$this->organizer_model->get_events_of_organizer_past($id);
                $this->data['user_organiser']=$this->organizer_model->get_user_organiser($id);
		$this->template
			->set_layout('organizer_layout')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('organizer_view', $this->data);
               
    }
    function send_contact_email()
    {
        if($_GET['contact_organizer_submit']==1)
        {            
            $this->load->model('email_model');		
    		$this->load->library('email');
    		//configure mail
    		$config['charset'] = 'utf-8';
    		$config['wordwrap'] = TRUE;
    		$config['mailtype'] = 'html';
    		$config['protocol'] = 'sendmail';
    		$this->email->initialize($config);
    		//get subjet & body
    		$template = $this->email_model->get_email_template("organiser-contact");
    		$user_id = $this->input->get('user_organiser');
            $user_emails = $this->organizer_model->get_email_organizer($user_id);
            
            $subject = $template['subject'];
            $emailbody = $template['email_body'];
            if(isset($subject) && isset($emailbody))
    		{
    			//parse email
    	
				$parseElement=array("ORGANISER"=>$user_emails->username,
									"NAME"=>$this->input->get('from_name'),
									"EMAIL"=>$this->input->get('from_email'),									
									"MESSAGE"=>$this->input->get('message'));

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
				$emaillss=$this->input->get('from_email');
    			//set the email things
    			$this->email->from($emaillss,$user_emails->username);
    			$this->email->to($user_emails->email); 
    			$this->email->subject($subject);
    			$this->email->message($emailbody); 
    			$this->email->send();
    			//echo $this->email->print_debugger();exit;
                /*test email from localhost*/
 //               $headers = "MIME-Version: 1.0" . "\r\n";
//                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//                $headers .= "From: ".$this->input->get('from_email', TRUE)."" . "\r\n";
//                mail($user_emails->email,$subject,$emailbody,$headers); 
                
            }
        }
    }
    
    function change_publish()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        
        $event_id=$this->input->post('id');
        $stat_id=$this->input->post('status');
        $data = array(
               'publish' => $stat_id               
            );

        $this->db->where('id', $event_id);
        $this->db->update('es_event', $data); 
    }
    function change_wishlist()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        $event_id=$this->input->post('id');
        $stat_id=$this->input->post('status');
        $data = array(
               'withlist' => $stat_id               
            );

        $this->db->where('id', $event_id);
        $this->db->update('es_event', $data); 
    }
    
    function delete_event()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        $event_id=$this->input->post('id');
        $stat_id='2';
        $data = array(
               'status' => $stat_id               
            );

        $this->db->where('id', $event_id);
        $this->db->update('es_event', $data);

    }
    
    function dublicate_event()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
                
        $event_id=$this->input->post('id');
        $this->organizer_model->dublicate_event_org($event_id);
    }
    function payment()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        $this->data['payment_summary_current']=$this->organizer_model->get_payment_summary_current();
        
        $this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'payment';        
        $this->data['nav'] = 'organizer';
		
		$this->template
			->set_layout('account')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('organizer_payment', $this->data);
    }
    
    function payment_details($id)
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        if(is_ajax())
        {
            $this->data['event_id'] = $id;
            $this->data['last_payment_detail']=$this->organizer_model->get_organizer_payment_by_event($id,'1');
            $this->data['payment_summary_past']=$this->organizer_model->get_organizer_payment_by_event($id,'past');		
    		$this->load
    					
    			->view('organizer_payment_details', $this->data);    
        }
    }
    
    function order_form($id)
    {
        //for signed up users only
        if(!$this->session->userdata(SESSION.'user_id')){
            redirect(site_url('users/login'));exit;
        }        
        
        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if(!$is_organizer)
        {
            $this->session->set_flashdata('error','You are not authorized user');		      
			redirect('organizer/event','refresh');
			exit;
        }else{
            $this->load->model('event/event_model');
            $active_event = $this->data['active_event'] = $this->event_model->is_active_event($id);
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,'organizer');
        }
        
        if(!$data_event)
        {
            $this->session->set_flashdata('error',$this->lang->line('no_event_found_blocked'));		      
			redirect('organizer/event','refresh');
			exit;
        }
        if(isset ($_POST['question'])){
             $jas_field=json_encode($_POST);
            
            $data=array(
                'order_form'=>1,
                'order_form_details'=>$jas_field
                
            );
            $this->db->where('id',$id);
            $this->db->update('es_event',$data);
            $this->session->set_flashdata('message',$this->lang->line('order_form_msg'));
            redirect(site_url('organizer/order_form/'.$id));
            exit;
        }
        elseif(isset ($_POST['question1'])){
            $data=array(
                'order_form'=>0,
                'order_form_details'=>''
                
            );
            $this->db->where('id',$id);
            $this->db->update('es_event',$data);
            $this->session->set_flashdata('message',$this->lang->line('order_form_msg'));
            redirect(site_url('organizer/order_form/'.$id));
            exit;
        }
        $this->data['selected_question']=$this->organizer_model->get_question_order($id);
        $this->data['id'] = $id;
        
        $this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'order_form';
        $this->data['organizer_nav'] = 'yes';
		
		$this->template
			->set_layout('event_organizer_layout')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('order_form.php', $this->data);
    }
    
    public function refund_policy($id)
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        //for signed up users only
        if(!$this->session->userdata(SESSION.'user_id')){
            redirect(site_url('users/login'));exit;
        }        
        
        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if(!$is_organizer)
        {
            $this->session->set_flashdata('error','You are not authorized user');		      
			redirect('organizer/event','refresh');
			exit;
        }else{
            $this->load->model('event/event_model');
            $active_event = $this->data['active_event'] = $this->event_model->is_active_event($id);
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,'organizer');
        }
        
        
        
        if(!$data_event)
        {
            $this->session->set_flashdata('error','No event found. Event might be blocked or deleted.');		      
			redirect('organizer/event','refresh');
			exit;
        }
        

        $this->data['id'] = $id;
        $refund_id = $this->data['refund_id'] = $this->general->get_value_from_id('es_event',$id,'refund_id');
        $this->data['refund_detail'] = 0;
        if($refund_id > 0)
        {
            $this->data['refund_detail'] = $this->organizer_model->get_refund_policy_detail($refund_id);
            
        }
        
        if($this->input->post('refund_policy') == 'refund'){
            $data = array(
               'event_id' => $id,
               'date_1' => $this->general->get_date($this->input->post('date_1',TRUE)),
               'date_2' => $this->general->get_date($this->input->post('date_2',TRUE)),
               'date_3' => $this->general->get_date($this->input->post('date_3',TRUE)),             
               'refund_2' => $this->input->post('refund_2',TRUE),
               'refund_3' => $this->input->post('refund_3',TRUE),
            );
            if($refund_id == 0){
                $this->db->insert('event_refund', $data);
                $re_id = $this->db->insert_id();
                $data = array(
                       'refund_id' => $re_id,                       
                    );                
                $this->db->where('id', $id);
                $this->db->update('event', $data); 
            }else{
                $this->db->where('id', $refund_id);
                $this->db->update('event_refund', $data);                                
            }
            $this->session->set_flashdata('message',$this->lang->line("change_to_refund"));
            redirect(site_url('organizer/refund_policy/'.$id));
        }else if($this->input->post('refund_policy') == 'no_refund'){
            if($refund_id > 0){
                //delete refund policy from es_event_refund                
                $this->db->delete('event_refund', array('id' => $refund_id));
                $data = array(
                       'refund_id' => '0',                       
                    );                
                $this->db->where('id', $id);
                $this->db->update('event', $data); 
            }else{
                $data = array(
                       'refund_id' => '0',                       
                    );                
                $this->db->where('id', $id);
                $this->db->update('event', $data);                                               
            }
            $this->session->set_flashdata('message',$this->lang->line("change_to_no_refund"));
            redirect(site_url('organizer/refund_policy/'.$id));
        }    
        
        
        
        
        
        $this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'refund_policy';
        $this->data['organizer_nav'] = 'yes';
		
		$this->template
			->set_layout('event_organizer_layout')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('organizer_refund_policy.php', $this->data);
    }
    
    public function approve_organizer()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        if($this->session->userdata(SESSION.'user_id'))
        {
            $organizer = $this->general->get_value_from_id('es_user',$this->session->userdata(SESSION.'user_id'),'organizer');
            if($organizer==1){
                $this->session->set_userdata(array(SESSION.'organizer' => $organizer));
                redirect(site_url('organizer/event'));    
            }else{
                $this->session->set_flashdata('message',"You are not approved as organizer yet.");
                redirect(site_url('users/account'));    
            }
            
        }else{
            redirect(site_url('login'));
        }
    }
    
    function document()
    {
        if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('organizer/event'))); //to define redirect url
            redirect(site_url('login'));
        }
        $user_id = $this->session->userdata(SESSION.'user_id');
        $doc_file = $this->general->get_value_from_id('es_user',$user_id,"organizer_official_doc"); 
        if($doc_file==''){
            $this->session->set_flashdata('message',"<font color='#900'>Document file not found.</font>");
            redirect(site_url('organizer/index'));
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
    
    public function cancel_event_permanently()
    {
        if(is_ajax())
        {
            $id = $this->input->post('id');
            $data = array(
                       'publish' => '2',     
                );                
            $this->db->where('id', $id);
            $r = $this->db->update('event', $data);
            if($r){
                $data_1 = array(
                        'event_cancel' => 'yes'
                    );
                $this->db->where('event_id', $id);
                $r = $this->db->update('event_ticket_order', $data_1);
                
                /*refunding procedure*/
                $this->organizer_model->refunding_after_event_cancel($id);
                $this->organizer_model->email_to_refunding_after_event_cancel($id);
                /*refunding procedure*/
                
                $this->session->set_flashdata('message',$this->lang->line("event_has_been_canceled_permanently"));
                echo $this->lang->line("event_has_been_canceled_permanently");
            }                
            else{
                $this->session->set_flashdata('error',$this->lang->line("failed_to_do"));
                echo $this->lang->line('failed_to_do');
            }                 
        }
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */