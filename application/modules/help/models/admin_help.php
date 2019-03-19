<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_help extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
			
	}

	public $validate_settings =  array(			
			
			array('field' => 'name', 'label' => 'Help Title', 'rules' => 'trim|required'),
			array('field' => 'description', 'label' => 'Help Description', 'rules' => 'trim|required'),
		);
		
	public function get_help_lists()
	{	
				  $this->db->order_by('last_update','DESC');
		$query = $this->db->get('help');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
	public function get_help_byid($id)
	{
		$query = $this->db->get_where('help',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	
	public function insert_record()
	{
					//set auction details info
					$array_data = array(					   
					   'title' => $this->input->post('name', TRUE),
					   'description' => $this->input->post('description', TRUE),
					   'is_display' => $this->input->post('is_display', TRUE),
					   'last_update' => $this->general->get_local_time('time')
					);
					
					$this->db->insert('help', $array_data); 

	}
	
	public function update_record($id)
	{
		//set value
		$data = array(			  
			   'title' => $this->input->post('name', TRUE),
			   'description' => $this->input->post('description', TRUE),
			   'is_display' => $this->input->post('is_display', TRUE),
			   'last_update' => $this->general->get_local_time('time')
			   
            );
		$this->db->where('id', $id);
		$this->db->update('help', $data);
        //echo $this->db->last_query();exit;
	}
	
	public function get_help_category_byid()
	{
		$query = $this->db->get('help_category');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	

}
