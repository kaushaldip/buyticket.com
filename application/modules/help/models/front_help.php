<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front_help extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
			
	}
	
	public function get_all_help()
	{
		$data = array();
		$query = $this->db->get_where("help",array("is_display"=>"Yes"));
		if ($query->num_rows() > 0) 
		{
			$data=$query->result();				
		}			
		$query->free_result();
		return $data;
	}

}
