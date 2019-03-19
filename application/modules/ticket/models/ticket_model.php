<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		
	}
  
    public $validate_settings =  array(
            array('field' => 'event_type_id', 'label' => 'Event Category', 'rules' => 'required'),			
			);
    
    public function get_tickets_of_event($event_id, $admin='')
    {
        $this->db->select('*');
        $this->db->from('es_event_ticket');        
        $this->db->where("event_id = '$event_id'");
        if($admin=='')
            $this->db->where("status = '1'");
        
        
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
    }
    public function ticket_available($ticket_id)
    {
        $this->db->select('id');
        $this->db->from('es_event_ticket');  
        $this->db->where("id = '$ticket_id'");
        $this->db->where("now() BETWEEN start_date AND end_date");
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return true;
		} 
		return false;
    }   
    
    public function sold_ticket($ticket_id)
    {
        $this->db->select('COUNT(id) as count');
        $this->db->from('event_ticket_sold');  
        $this->db->where("ticket_id = '$ticket_id'");        
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		$row =  $query->row();
        return $row->count;
    }
    
    public function insert_temp_tickets($user_id)
    {
        $quantity = $this->input->post('quantity',TRUE);
        $prefix = $this->input->post('prefix',TRUE);
        for($i=1; $i<=$quantity; $i++ )
        {
            $ticket_number = $this->general->createRandomStringCollection();
            $array_data = array(
                'session_id' => $this->session->userdata('session_id'),
                'user_id' => $user_id,
                'event_id' => $this->input->post('event_id',TRUE),
                'ticket_id' => $this->input->post('ticket_id',TRUE),
                'rate' => $this->input->post('rate',TRUE),
                'ticket_number' => $prefix.$ticket_number, 
                'sub_total' =>  $this->input->post('rate',TRUE),                   
            );
        $this->db->insert('temp_cart', $array_data); 
        }   
    }
    
    public function get_current_temp_tickets()
    {
        $session_id = $this->session->userdata('session_id');
        $this->db->select('c.*, l.address as event_location, t.currency, t.name as ticket_name, e.name as event_name, e.title as event_title, u.first_name,u.last_name');
        $this->db->from('temp_cart as c');
        $this->db->join('event as e','e.id = c.event_id');        
        $this->db->join('user as u','u.id = c.user_id');
        $this->db->join('event_location as l','l.event_id = c.event_id');
        $this->db->join('event_ticket as t','t.id = c.ticket_id');
        $this->db->where("session_id = '$session_id'");
        
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 
		return false;
    }
}
