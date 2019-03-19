<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
		
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
		$this->load->model(array('event/event_model','ticket_model'));
		
		
	}
	
	public function lists($event_id)
	{
		//for signed up users only
        if(!$this->session->userdata(SESSION.'user_id')){
            redirect(site_url('users/login'));exit;
        }else if(!isset($event_id)){
            redirect(site_url('event/'));exit;
        }else if($this->general->is_organizer_of_event($event_id)){            
            redirect(site_url('event/add_ticket/'.$event_id));exit;
        }
        
        //set some data value
        $this->data['event_id'] = $event_id;
        $this->data['event_detail'] = $this->event_model->get_event_short_info_by_id($event_id);
        
        //if event status is not 1 
        if(!$this->data['event_detail']){
            redirect(site_url('event/'));exit;
        }
        
        $this->data['check_event_active'] = $this->event_model->check_event_active($event_id);        
        $this->data['tickets'] = $this->ticket_model->get_tickets_of_event($event_id);
        //set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['header_small'] = 'yes';
        
        
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('ticket_list', $this->data);	
		
	}
    public function cart()
    {
        if($this->input->post('ticket_id'))
        {
            $this->ticket_model->insert_temp_tickets($this->session->userdata(SESSION.'user_id'));
            redirect(site_url('ticket/cart'));
        }
        $this->data['tickets'] = $this->ticket_model->get_current_temp_tickets();
        
        //set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['header_small'] = 'yes';
        
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('ticket_cart', $this->data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */