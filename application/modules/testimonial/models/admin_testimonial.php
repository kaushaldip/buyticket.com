<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_testimonial extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		//load CI library
			$this->load->library('form_validation');
	}
	
	public $validate_settings =  array(	
			array('field' => 'winner_name', 'label' => 'Winner Name', 'rules' => 'required'),
			array('field' => 'product_name', 'label' => 'Product Name', 'rules' => 'required'),
			array('field' => 'description', 'label' => 'Description', 'rules' => 'required')			
		);
		
	public function file_settings_do_upload()
	{
				$config['upload_path'] = './'.TESTIMONIAL_PATH;//define in constants
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['remove_spaces'] = TRUE;		
				$config['max_size'] = '100';
				$config['max_width'] = '160';
				$config['max_height'] = '128';

				// load upload library and set config				
				if(isset($_FILES['img']['tmp_name']))
				{
					$this->upload->initialize($config);
					$this->upload->do_upload('img');
				}		
	}
	public function get_details()
	{		
		$this->db->order_by("last_update", "desc"); 
		$query = $this->db->get('testimonial');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}


	public function get_details_by_id($id)
	{
		$query = $this->db->get_where('testimonial',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	public function insert($img)
	{
		$data = array(               
			   'winner_name' => $this->input->post('winner_name', TRUE),
			   'product_name' => $this->input->post('product_name', TRUE),	
			   'description' => $this->input->post('description', TRUE),				   
			   'image' => $img,
			   'last_update' => $this->general->get_local_time('time')
			   
            );

		$this->db->insert('testimonial', $data); 

	}
	
	public function update($id,$img_full_path)
	{
		$data = array(               
			   'winner_name' => $this->input->post('winner_name', TRUE),
			   'product_name' => $this->input->post('product_name', TRUE),	
			   'description' => $this->input->post('description', TRUE),				   			   
			   'last_update' => $this->general->get_local_time('time')
			   
            );

		//only if new img is uploaded
		if(isset($img_full_path) && $img_full_path !="")
		{
			@unlink('./'.$this->input->post('img_old'));
			$data['image'] = $img_full_path;
		}
		//print_r($data);exit;
		$this->db->where('id', $id);
		
		$this->db->update('testimonial', $data);

	}
	
	
	

}
