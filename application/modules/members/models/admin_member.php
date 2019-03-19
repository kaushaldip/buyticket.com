<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_member extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		//load CI library
			$this->load->library('form_validation');
			
			
	}
	
	public $validate_settings_edit =  array(	
			array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'trim|required'),
			array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'trim|required'),
			array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|callback_check_email'),		
			array('field' => 'country', 'label' => 'Country', 'rules' => 'required'),
			array('field' => 'address', 'label' => 'Address1', 'rules' => 'trim|required'),
			array('field' => 'city', 'label' => 'City', 'rules' => 'trim|required'),
			array('field' => 'post_code', 'label' => 'Post Code/ Zip Code', 'rules' => 'trim|required'),
			array('field' => 'name', 'label' => 'Name', 'rules' => 'trim|required'),			
			array('field' => 'ship_country', 'label' => 'Country', 'rules' => 'required'),
			array('field' => 'ship_address', 'label' => 'Address1', 'rules' => 'trim|required'),
			array('field' => 'ship_city', 'label' => 'City', 'rules' => 'trim|required'),
			array('field' => 'ship_post_code', 'label' => 'Post Code/ Zip Code', 'rules' => 'trim|required')
		);
		
	
	public function get_total_members($status)
	{		
		if($status) $status = $status; else $status = 'active';
		
		$this->db->where('status',$status);
		
		if($this->input->post('srch')!="")
		{
			$where = "(first_name LIKE '%".$this->input->post('srch')."%' OR user_name LIKE '%".$this->input->post('srch')."%' OR email LIKE '%".$this->input->post('srch')."%')";
			$this->db->where($where);
		}
		
		$query = $this->db->get('members');

		return $query->num_rows();
	}
	
	public function get_members_details($status,$perpage,$offset)
	{
		if($status) $status = $status; else $status = 'active';
		
		$this->db->from('members');
		$this->db->where('status',$status);
		
		if($this->input->post('srch')!="")
		{
			$where = "(first_name LIKE '%".$this->input->post('srch')."%' OR user_name LIKE '%".$this->input->post('srch')."%' OR email LIKE '%".$this->input->post('srch')."%')";
			$this->db->where($where);
		}
		
		$this->db->order_by("balance", "desc");
		$this->db->limit($perpage, $offset);
		$query = $this->db->get();
		//echo $this->db->last_query();

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
	
	
	public function get_member_byid($id)
	{				 
		$query = $this->db->get_where('members',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	public function get_user_shipping_details($user_id)
	{
		$option = array('user_id'=>$user_id);
		$query = $this->db->get_where('members_address',$option);
		if($query->num_rows()==1)
		{
			return $query->row();
		}
	}
	
	public function update_record($id)
	{
		//set  info
		$data_profile = array(
			   'title' => $this->input->post('title', TRUE),
               'first_name' => $this->input->post('first_name', TRUE),
               'last_name' => $this->input->post('last_name', TRUE),
			   'email' => $this->input->post('email', TRUE),
			   'status' => $this->input->post('status', TRUE),
			   'address' => $this->input->post('address', TRUE),	
			   'address2' => $this->input->post('address2', TRUE),
			   'country' => $this->input->post('country', TRUE),
			    'city' => $this->input->post('city', TRUE),
				 'post_code' => $this->input->post('post_code', TRUE),
				  'phone' => $this->input->post('phone', TRUE),
			   
            );
		
		$this->db->where('id', $this->input->post('user_id', TRUE));
		$this->db->update('members', $data_profile);
		
		//check shipping address
		
		$data_ship = array(			   
               'name' => $this->input->post('name', TRUE),			   
			   'address' => $this->input->post('ship_address', TRUE),	
			   'address2' => $this->input->post('ship_address2', TRUE),
			   'country_id' => $this->input->post('ship_country', TRUE),
			    'city' => $this->input->post('ship_city', TRUE),
				 'post_code' => $this->input->post('ship_post_code', TRUE),
				  'phone' => $this->input->post('ship_phone', TRUE),
			   
            );
			
		$option = array('user_id'=>$this->input->post('user_id', TRUE));
		$query = $this->db->get_where('members_address',$option);
		//echo $query->num_rows();exit;
		if($query->num_rows()==1)
		{
			 //update records in the database
			 $this->db->where('id', $this->input->post('ship_id', TRUE));
			 $this->db->where('user_id', $this->input->post('user_id', TRUE));
			 $this->db->update('members_address',$data_ship);
		}
		else
		{
			 //insert records in the database
			 $data_ship['user_id'] = $this->input->post('user_id', TRUE);
			 $this->db->insert('members_address', $data_ship); 

		}
		

	}
	
	public function count_member_transaction($user_id)
	{
		$option = array('user_id'=>$user_id,'credit_debit'=>'CREDIT');
		$query = $this->db->get_where('transaction',$option);
		return $query->num_rows();
	}
	public function get_member_transaction($user_id,$perpage,$offset)
	{
		$option = array('user_id'=>$user_id,'credit_debit'=>'CREDIT','transaction_status'=>'Completed');
				 $this->db->order_by("invoice_id", "desc");
				 $this->db->limit($perpage, $offset);
		$query = $this->db->get_where('transaction',$option);
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	public function get_member_bids($user_id)
	{
		$this->db->select('a.product_id,ad.name,a.bid_fee');
		$this->db->from('user_bids ub');
		$this->db->join('auction a', 'a.product_id = ub.auc_id', 'left');
		$this->db->join('auction_details ad', 'ad.auc_id = a.id', 'left');
		$this->db->where('ub.user_id',$user_id);
		$this->db->group_by('a.id');
		$this->db->order_by('ub.id','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	public function count_member_bids($user_id,$auc_id)
	{
		$option = array('user_id'=>$user_id,'auc_id'=>$auc_id);
		$this->db->select('type,count(*) no_bids');
		$this->db->group_by('type');
		$query = $this->db->get_where('user_bids',$option);
		//echo $this->db->last_query();exit;
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}

}
