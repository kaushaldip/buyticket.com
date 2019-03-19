<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
        /*converting language start*/
		$this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
		
		//load CI library
		$this->load->library('form_validation');
			

		//load custom module
		$this->load->model('category');
		
		//load helper
		$this->load->helper('editor_helper');

		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	public function index()
	{
		
		$this->data['result_data'] = $this->category->get_category_lists();
		
		
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Category View')
			->build('view', $this->data);	
		
	}
	
	public function add_category()
	{
		$this->data['jobs'] = 'Add';
		      
		// Set the validation rules
				
        if($this->input->post('performer_want')=='on')
        {
            $this->form_validation->set_rules('performer_name', 'Performer Name', 'trim|required');
    		$this->form_validation->set_rules('performer_type', 'Performer Type', 'trim|required');
        }
        $this->form_validation->set_rules($this->category->validate_settings);
		if($this->form_validation->run()==TRUE)
		{			
			//Insert Lang Settings
			$this->category->insert_record();
			$this->session->set_flashdata('message','The Category records are insert successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/category/index','refresh');
			exit;			
		}
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Add Category')
			->build('add', $this->data);	
	}
	
    public function autofill_category()
    {
        
        if($this->input->post('queryString')) {
            $queryString = $this->input->post('queryString');
                   
            if(strlen($queryString) >0) 
            {                
                //$query = $db->query("SELECT username FROM es_user WHERE username LIKE '$queryString%' LIMIT 10");
                
        		$this->db->from('event_type');
                $this->db->group_by('name');
        		$this->db->like('name',$queryString,'after');
        		$query = $this->db->get();
                       		
                if($query->num_rows()>0)
                {    
                    foreach($query->result() as $result)                     
                    {                        
                         echo '<li onClick="fill(\''.$result->name.'\',\'category\');">'.$result->name.'</li>';
                    }
                } else {
                    echo '<li onClick="close_this(\'category\');">No list found.</li>';
                }
            } 
            else 
            {
                // Dont do anything.
            } // There is a queryString.
        } 
        else 
        {
            echo 'There should be no direct access to this script!';
        }
    }
    
    public function autofill_performer()
    {
        
        if($this->input->post('queryString')) {
            $queryString = $this->input->post('queryString');
                   
            if(strlen($queryString) >0) 
            {   
        		$this->db->from('performer');
        		$this->db->like('name',$queryString,'after');
        		$query = $this->db->get();
                       		
                if($query->num_rows()>0)
                {    
                    foreach($query->result() as $result)                     
                    {                        
                         echo   '<li onClick="fill_performer(\''.$result->name.'\',\''.$result->type.'\',\''.$result->description.'\',\'performer\',\''.$result->id.'\');">'.$result->name.'('.$result->type.')'.'</li>';
                    }
                } else {
                    echo '<li onClick="close_this(\'performer\');">No list found.</li>';
                }
            } 
            else 
            {
                // Dont do anything.
            } // There is a queryString.
        } 
        else 
        {
            echo 'There should be no direct access to this script!';
        }
    }
	
	public function edit_category($id)
	{
		$this->data['jobs'] = 'Edit';
		
		//check id, if it is not set then redirect to view page
		if(!isset($id))
		{	
			redirect(ADMIN_DASHBOARD_PATH.'/category/index','refresh');
			exit;
		}
		
		$this->data['data_category'] = $this->category->get_category_byid($id);
        $this->data['performer'] = $this->category->get_performer_by_catid($id);
		
		//check data, if it is not set then redirect to view page
		if($this->data['data_category'] ==false)
		{
			redirect(ADMIN_DASHBOARD_PATH.'/category/index','refresh');
			exit;
		}
		


		//Set the validation rules
        				
        if($this->input->post('performer_want')=='on')
        {
            $this->form_validation->set_rules('performer_name', 'Performer Name', 'trim|required');
    		$this->form_validation->set_rules('performer_type', 'Performer Type', 'trim|required');
        }        
		$this->form_validation->set_rules($this->category->validate_settings);		
	
			
		if($this->form_validation->run()==TRUE)
		{
			//Insert Lang Settings
            
			$this->category->update_record($id);
			$this->session->set_flashdata('message','The Category records are update successful.');
			redirect(ADMIN_DASHBOARD_PATH.'/category/edit_category/'.$id);			
			exit;
		}
		
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Edit Category')
			->build('edit', $this->data);	
	}
	
	public function delete_category($id)
	{
			$query = $this->db->get_where('event_type', array('id' => $id));

			if($query->num_rows() > 0) 
			{
				$this->db->delete('event_type', array('id' => $id));
				
				$this->session->set_flashdata('message','The category record delete successful.');
				redirect(ADMIN_DASHBOARD_PATH.'/category/index/','refresh');
				exit;
			}
			else
				{
					$this->session->set_flashdata('message','Sorry no record found.');
					redirect(ADMIN_DASHBOARD_PATH.'/category/index/','refresh');
					exit;
				}
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */