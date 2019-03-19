<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class page_module extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function get_cms($slug)
	{	
		$data = array();
		$query = $this->db->get_where("cms",array("cms_slug"=>$slug,"is_display"=>"Yes"));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();				
		}	
		
		$query->free_result();
		return $data;
	}

}
