<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_email_settings extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public $validate_settings =  array(
            array('field' => 'name', 'label' => 'Title', 'rules' => 'required'),
			array('field' => 'subject', 'label' => 'Subject', 'rules' => 'required'),
			array('field' => 'content', 'label' => 'Email Body', 'rules' => 'required')
			);
		
		
	public function get_email_setting_byemailcode($emailcode)
	{		
		$query = $this->db->get_where('email_settings',array("email_code "=>$emailcode));

		if ($query->num_rows() > 0)
		{
		   return $query->row_array();
		} 

		return false;
	}
	
	public function update_email_settings()
	{
		$data = array(
               'name' => $this->input->post('name', TRUE),
               'subject' => $this->input->post('subject', TRUE),               
			   'email_body' => $this->input->post('content', TRUE),			  
			   'last_update' => $this->general->get_local_time('time')
            );
		
		$email_code = $this->uri->segment(3);
		$this->db->where('email_code', $email_code);
		$this->db->update('email_settings', $data); 
	}
    
    public function get_all_emails()
    {
        $this->db->select('name, email_code');
        $query = $this->db->get('email_settings');
        if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
        
    }
    public function add_email_settings()
    {
        $email_code = $this->general->get_nice_name($this->input->post('name'));
        
        $data = array(
               'name' => $this->input->post('name', TRUE),
               'email_code' => $email_code,
               'subject' => $this->input->post('subject', TRUE),               
			   'email_body' => $this->input->post('content', TRUE),			  
			   'last_update' => $this->general->get_local_time('time')
            );
				
		$this->db->insert('email_settings', $data);
    }
	

}
