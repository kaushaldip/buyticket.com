<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home_module extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	

	function get_high_voter_info($album_id)
	{
		$this->db->select('SUM(pv.positive_vote+pv.negative_vote) AS total_vote, pv.user_id, m.*');
		$this->db->from('polls_vote as pv');
		$this->db->join('members as m','m.id=pv.user_id','left');
		$this->db->where('pv.album_id',$album_id);
		$this->db->group_by("pv.user_id");
		$this->db->order_by("total_vote desc");
		
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		
		if ($query->num_rows() > 0)
		{
		   return $query->row_array();
		} 

		return false;
	}
	
	public function get_latest_closed_album()
	{
		$this->db->select('am.*,po.end_date');
		$this->db->from('album_music AS am');
		$this->db->join('polls AS po','po.nomination_id=am.nomination_id');				 
		$this->db->where('po.status', 'Closed');
		$this->db->where('am.status', 'Closed');
		$this->db->where('is_won_album', 'Yes');
		$this->db->where('am.total_positive_vote !=', '0');
		$this->db->order_by("po.end_date", "desc"); 
				 
		$query = $this->db->get();
		//echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
}
