<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_cms extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public $validate_cms =  array(			
			array('field' => 'cms_slug', 'label' => 'CMS Slug', 'rules' => 'required'),
			array('field' => 'headtext', 'label' => 'Heading', 'rules' => 'required'),
			array('field' => 'content', 'label' => 'Content', 'rules' => 'required'),
		);
		
		
	public function get_cms_byid($id)
	{		
		$query = $this->db->get_where('cms',array("id"=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row_array();
		} 

		return false;
	}
	
	public function update_site_settings()
	{
		$data = array(
               'heading' => $this->input->post('headtext', TRUE),               
			   'cms_slug' => $this->general->clean_url($this->input->post('cms_slug', TRUE)),
			    'content' => $this->input->post('content', TRUE),
			   'page_title' => $this->input->post('page_title', TRUE),
			   'meta_key' => $this->input->post('meta_key', TRUE),
			   'meta_description' => $this->input->post('meta_description', TRUE),
			   'is_display' => $this->input->post('status', TRUE),
			   'last_update' => $this->general->get_local_time('time')
            );
		
		$id = $this->uri->segment(3);
		$this->db->where('id', $id);
		$this->db->update('cms', $data); 
        //echo $this->db->last_query();exit;
	}
        public function add_site_settings(){
            $data = array(
                'heading' => $this->input->post('headtext', TRUE),
                'cms_slug' => $this->general->clean_url($this->input->post('cms_slug', TRUE)),
                'content' => $this->input->post('content', TRUE),
                'page_title' => $this->input->post('page_title', TRUE),
                'meta_key' => $this->input->post('meta_key', TRUE),
                'meta_description' => $this->input->post('meta_description', TRUE),
                'is_display' => $this->input->post('status', TRUE),
                'last_update' => $this->general->get_local_time('time')
            );
		
		
		
		$this->db->insert('cms', $data); 
        }
        function get_all_cms(){
            $query = $this->db->get('cms');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
        }
	
	

}
