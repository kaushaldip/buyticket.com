<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_dashboard extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
    
    public function dash_total_events($status='')
	{        
		$this->db->select('e.id');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id','left');
                   
        $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
        
        if($status <> '')                
            $this->db->where("e.status = '$status'");
        else
            $this->db->where("e.status <> 0");                    
        
        
		$query = $this->db->get();
       // echo $this->db->last_query();exit;
        return $query->num_rows();              
					
		
	}
    
           
    public function dash_total_ticket_sold()
    {        
		$q=$this->db->query("select COUNT(DISTINCT ticket_id) as total FROM es_event_ticket_order where refund_id = '0'");
        
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    return  $row->total;           
		} 
		return $q->num_rows();         
					
		
	}   
    public function dash_total_attendees($type='')
    {        
		
        $this->db->select('SUM(ticket_quantity) as total');
        $this->db->from('es_event_ticket_order');
                           
        $this->db->where("refund_id",'0'); 
        if($type!='')
            $this->db->where("ticket_type",$type);
        
        
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    $total =  $row->total;
            return (empty($total))? '0' : $total;           
		} 
		return $q->num_rows();         
					
		
	}    
    
    public function dash_total_users()
    {
		$data = array();
        $this->db->where('closed_account','no');		
        $query = $this->db->get("user");  
        //echo $this->db->last_query();exit;          		
		return $query->num_rows();
	} 
    
    public function dash_total_organizer()
    {
		$data = array();
        $this->db->where('closed_account','no');
        $this->db->where('organizer','1');        		
        $query = $this->db->get("user");  
        //echo $this->db->last_query();exit;          		
		return $query->num_rows();
	}
    
    public function dash_total_affiliate_users()
    {		
        $this->db->where('referral_id <>','0');		
        $query = $this->db->get("user");  
        //echo $this->db->last_query();exit;          		
		return $query->num_rows();
	}
    
    function dash_total_referer()
    {
        $q=$this->db->query("SELECT referral_id 
            FROM  `es_user` 
            WHERE is_referral_user ='yes'");
        
		    return $q->num_rows();            
	
    }
    function dash_total_affilate_referer()
    {
        $q=$this->db->query("SELECT id 
                FROM  `es_affiliate_event_earning` 
                group by user_id");
        return $q->num_rows();            
	
    }
    
    function dash_total_revenue()
    {
        $this->db->select('SUM(paid) as total');
        $this->db->from('es_event_ticket_order');
                           
        $this->db->where("refund_id",'0'); 
                
        $q = $this->db->get();
        
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    $total =  $row->total;
            return (empty($total))? '0' : $total;           
		} 
		return $q->num_rows();   
    }
    
    function dash_total_webfee()
    {
        $this->db->select('SUM(ticket_quantity * fee) as total');
        $this->db->from('es_event_ticket_order');
                           
        $this->db->where("refund_id",'0'); 
                
        $q = $this->db->get();
        
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    $total =  $row->total;
            return (empty($total))? '0' : $total;           
		} 
		return $q->num_rows();   
    }
    function dash_total_referral_payment()
    {
        $this->db->select('SUM(referral_pay) as total');
        
        $this->db->from('es_event_ticket_order');
         
        $this->db->where("refund_id",'0'); 
                
        $q = $this->db->get();
        
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    $total =  $row->total;
            return (empty($total))? '0' : $total;           
		} 
		return $q->num_rows();   
    }
    function dash_total_referral_paid()
    {
        $this->db->select('SUM(referral_pay) as total');
        
        $this->db->from('es_event_ticket_order');
                           
        $this->db->where("referral_pay_status",'yes'); 
        $this->db->where("refund_id",'0'); 
                
        $q = $this->db->get();
        
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    $total =  $row->total;
            return (empty($total))? '0' : $total;           
		} 
		return $q->num_rows();   
    }
    
    function dash_total_event_affiliate_paid()
    {
        $this->db->select('SUM(event_referral_payment) as total');
        
        $this->db->from('es_event_ticket_order');
                           
        $this->db->where("referral_pay_status",'yes'); 
        $this->db->where("refund_id",'0'); 
                
        $q = $this->db->get();
        
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    $total =  $row->total;
            return (empty($total))? '0' : $total;           
		} 
		return $q->num_rows();   
    }
    
    function dash_total_event_affiliate_payment()
    {
        $this->db->select('SUM(event_referral_payment) as total');
        
        $this->db->from('es_event_ticket_order');
                           
        $this->db->where("event_referral_payment_status",'yes'); 
        $this->db->where("refund_id",'0'); 
                
        $q = $this->db->get();
        
        if ($q->num_rows() > 0)
		{
            $row = $q->row();		  
		    $total =  $row->total;
            return (empty($total))? '0' : $total;           
		} 
		return $q->num_rows();   
    }
	
}
