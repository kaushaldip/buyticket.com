<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myticket_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		
	}
  
    public $validate_settings =  array(
            array('field' => 'event_type_id', 'label' => 'Event Category', 'rules' => 'required'),			
			);
    
    public function get_current_orders()
    {
        $user_id = $this->session->userdata(SESSION."user_id");
        
        $this->db->select("id,order_id,order_for_date_start, order_date, user_id,event_id");
        $this->db->from('event_ticket_order');
        $this->db->where("user_id = '$user_id' and order_for_date_start > now() and refund_complete='no'");
        $this->db->group_by('order_id');
        $this->db->order_by('id','desc');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    return $query->result();            
		} 
		return false;
    }
    
    public function get_past_orders()
    {
        $user_id = $this->session->userdata(SESSION."user_id");
        
        $this->db->select("id,order_id,order_for_date_start, order_date, user_id,event_id");
        $this->db->from('event_ticket_order');
        $this->db->where("user_id = '$user_id' and order_for_date_start < now() and refund_complete='no'");
        $this->db->group_by('order_id');
        $this->db->order_by('id','desc');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    return $query->result();            
		} 
		return false;
    }
    
    public function get_order_by_order_id($order_id)
    {
        $user_id = $this->session->userdata(SESSION."user_id");
        
        $this->db->select("id,user_id,event_id,order_id,order_for_date_start,order_for_date_end,ticket_id,ticket_quantity,ticket_type,currency,price,paid,fee,total,payment_status,create_ticket,refund_complete, refund_id, transaction_method, bank_transaction_id,bank_transaction_status"); //not repeated data fetch
        $this->db->from('event_ticket_order');
        $this->db->where("user_id = '$user_id' and order_id = '$order_id' and refund_complete='no'");        
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    return $query->result();            
		} 
		return false;
    }
    
    public function get_order_contact_by_order_id($order_id)
    {
        $this->db->select("e.user_id,e.event_id,e.order_id,u.first_name, u.last_name, u.email, e.paypal_info_id, e.order_form_detail, e.bank_transaction_id"); //repeated data fetch
        $this->db->from('es_event_ticket_order as e');
        $this->db->where("e.order_id = '$order_id'");
        $this->db->join('es_user as u',"u.id = e.user_id");
        $this->db->limit('1');                
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    return $query->row();  // only single row            
		} 
		return false;
    }
    
    public function get_event_detail_by_order_id($order_id)
    {
        $this->db->select("e.title,e.id,e.date_time_detail,o.*");
        $this->db->from('event_ticket_order as o');
        $this->db->join('event as e','o.event_id = e.id');
        $this->db->where("o.order_id = '$order_id'");        
        $this->db->limit('1');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    return $query->row();
                        
		} 
		return false;
    }
    public function get_organizer_id_from_event_id($event_id)
    {
        $this->db->select('organizer_id');
        $this->db->from('event');
        $this->db->where("id = '$event_id'");
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    $res =  $query->row();
            return $res->organizer_id;            
		} 
		return false;
    }
    
    public function get_tickets_sold($ticket_order_id)
    {
        $this->db->select('*');
        $this->db->from('event_ticket_sold');
        $this->db->where("ticket_order_id",$ticket_order_id);        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    return  $query->result();                        
		} 
		return false;
    }
    
    public function check_my_order($ticket_order_id)
    {
        $user_id = $this->session->userdata(SESSION."user_id");
        
        $this->db->select('id');
        $this->db->from('event_ticket_order');
        $this->db->where("id = '$ticket_order_id' and user_id = '$user_id' and create_ticket = 'yes'");        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    return  true;                        
		} 
		return false;
    }
    
    public function check_order_payment_status($ticket_order_id)
    {
        $this->db->select('payment_status,ticket_type,organizer_paid');
        $this->db->from('event_ticket_order');
        $this->db->where("id = '$ticket_order_id'");
        $this->db->limit('1');        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{            
            return  $query->row();                        
		} 
		return false;
    }
    
    public function get_event_id_from_order_id($order_id)
    {
        $this->db->select('event_id');
        $this->db->from('event_ticket_order');
        $this->db->where("order_id = '$order_id'");
        $this->db->limit('1');        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{           
            $row = $query->row(); 		      
            return $row->event_id;                        
		} 
		return false;
    }
    
    public function get_refund_policy_by_event($event_id)
    {
        $this->db->select('*');
        $this->db->from('event_refund');
        $this->db->where("event_id = '$event_id'");
        $this->db->limit('1');        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{    
            return $query->row();                        
		} 
		return false;
    }
    
}
