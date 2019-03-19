<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->model(array('event_model','category/category'));
		
		
	}
	
	public function index($status='')
	{
        	   
		$this->data['events'] = $this->event_model->get_all_event_admin($status);
        
        $this->data['total_events'] = $this->general->total_events_admin();
        $this->data['total_private_events'] = $this->general->total_events_admin('2');
        $this->data['total_public_events'] = $this->general->total_events_admin('1');        
			
        $this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - '."Event List")
			->build('admin_event_list', $this->data);            
		
	}
    
    public function view($id)
    {
        if(!isset($id))
		{	
			redirect('event/index','refresh');
			exit;
		}
		
		$data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,'admin');
		//check data, if it is not set then redirect to view page
		if($this->data['data_event'] ==false)
		{
            $this->session->set_flashdata('message','No event found');		      
			redirect('event/index','refresh');
			exit;
		}
        
        $this->data['sponsors'] = $this->event_model->get_sponsors_of_event($data_event->id);
        $this->data['performer'] = $this->event_model->get_performers_of_event($data_event->event_type_id);
        $this->data['organizers'] = $this->event_model->get_organizers_of_event($data_event->id);
        $this->data['keywords'] = $this->event_model->get_keywords_of_event($data_event->id);
        
        //set SEO data
		$this->page_title = $data_event->title;
		$this->data['meta_keys'] = $data_event->keywords;
		$this->data['meta_desc'] = $data_event->title;
        $this->data['header_small'] = 'yes';
		
		$this->template
			->set_layout('event_layout')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('admin_event_view', $this->data);
    }
    public function change_publish($event_id)
    {
        if(is_ajax())
        {
            $status = $this->input->post('status');
            //echo $status;exit;
            if($status=='1')
            {
                /*organizer information block*/   
                $user_id = $this->general->get_user_id_from_event_id($event_id);                
                if($user_id)
                {
                    $organizer = $this->general->is_organizer($user_id);                    
                    if(!$organizer)
                        $this->general->set_organizer($user_id,'1');    
                }                             
                /*organizer information block*/
                
                $key = 'active_1';
                $status_msg = "PUBLISHED";
                $data = array(
                   'publish' => $status,               
                );
            }
            
            else if($status == '0')
            {
                $key = "pending_1";    
                $status_msg = "<nobr>NOT PUBLISHED</nobr>";
                $data = array(
                   'publish' => $status,               
                );
            }
            else if($status == '2')
            {
                $key = "inactive_1";    
                $status_msg = "CLOSED";
                $data = array(
                   'publish' => $status,
                   'status' => '0'               
                );
            }
            
            

            $this->db->where('id', $event_id);
            $query = $this->db->update('event', $data);
                        
            if($query)
            {
                echo "result=success@@message=".$status_msg."@@key=status-$key@@active=".$this->general->total_events();                
            } 
            else
            {
                echo "result=error@@message=Something went wrong. Session out! Please login."."@@key=status-$key";
            }
            
        }
    }
    public function change_status($event_id)
    {
        if(is_ajax())
        {
            $status = $this->input->post('status');
            //echo $status;exit;
            if($status=='1')
            {
                /*organizer information block*/   
                $user_id = $this->general->get_user_id_from_event_id($event_id);                
                if($user_id)
                {
                    $organizer = $this->general->is_organizer($user_id);                    
                    if(!$organizer)
                        $this->general->set_organizer($user_id,'1');    
                }                             
                /*organizer information block*/
                
                $key = 'active_1';
                $status_msg = "PUBLIC";
                $data = array(
                   'status' => $status,               
                );
            }
            
            else if($status == '2')
            {
                $key = "pending_1";    
                $status_msg = "<nobr>PRIVATE</nobr>";
                $data = array(
                   'status' => $status,               
                );
            }
            
            else if($status == '0')
            {
                $key = "inactive_1";    
                $status_msg = "CLOSED";
                $data = array(
                   'status' => $status,
                   'publish' => '2'               
                );
            }
            
            

            $this->db->where('id', $event_id);
            $query = $this->db->update('event', $data);
                        
            if($query)
            {
                echo "result=success@@message=".$status_msg."@@key=status-$key@@active=".$this->general->total_events();                
            } 
            else
            {
                echo "result=error@@message=Something went wrong. Session out! Please login."."@@key=status-$key";
            }
            
        }
    }
    
           
              
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */