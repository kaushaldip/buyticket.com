<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Affiliate_model extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
			
	}
	
	public function get_user_referral_url_detail($referral_url)
	{
		$query = $this->db->get_where('user_referral_url',array('referral_url'=>$referral_url));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return false;
	}
    
    public function get_referral_event_url_detail($referral_url)
    {
		$query = $this->db->get_where('event_referral_url',array('url'=>$referral_url));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return false;
	}
    
    public function get_referral_event_url_detail_by_id($id)
    {
		$query = $this->db->get_where('event_referral_url',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return false;
	}
    
    public function increase_user_referral_visit_counter($id)
    {
        $this->db->query("UPDATE `es_user_referral_url` SET `visits` = visits + 1 WHERE `id` = '$id'");
                
    }
    
    public function increase_event_referral_visit_counter($id)
    {
        $this->db->query("UPDATE `es_event_referral_url` SET `visits` = visits + 1 WHERE `id` = '$id'");
                
    }

    public function get_referral_urls()
    {
        $this->db->select('*');
        $this->db->where('user_id', $this->session->userdata(SESSION.'user_id'));
        $this->db->order_by('id','DESC');
        $query = $this->db->get('user_referral_url');
        if ($query->num_rows() > 0)
		{
		   return $query->result();
		}     
		return false;
    }
    
    public function get_event_referral_urls()
    {
        $this->db->select('*');
        $this->db->where('user_id', $this->session->userdata(SESSION.'user_id'));
        $this->db->order_by('id','DESC');
        $query = $this->db->get('event_referral_url');
        if ($query->num_rows() > 0)
		{
		   return $query->result();
		}     
		return false;
    }
    
    public function check_url_used($url_id)
    {
        $this->db->select('COUNT(referral_url_id) as counts');
        $this->db->where('referral_url_id', $url_id);        
        $query = $this->db->get('user');
        if ($query->num_rows() > 0)
		{
		   $row =  $query->row();
           return $row->counts;
		}     
		return false;
    }
     
    public function get_affiliate_earning_by_urlid($url_id)
    {
        $this->db->select('SUM(revenue) as total_revenue , SUM(earning) as total_earning');
        $this->db->where('user_referral_url_id', $url_id);        
        $query = $this->db->get('affiliate_referral_earning');
        if ($query->num_rows() > 0)
		{		   
           return  $query->row();
		}     
		return false;
    }    
    
    public function get_affiliate_earning_unpaid_by_urlid($url_id)
    {
        $this->db->select('SUM(revenue) as total_unpaid_revenue , SUM(earning) as total_unpaid_earning');
        $this->db->where('user_referral_url_id', $url_id);
        $this->db->where('paid_status','unpaid');        
        $query = $this->db->get('affiliate_referral_earning');
        
        if ($query->num_rows() > 0)
		{		   
           return  $query->row();
		}     
		return false;
    }     
	
    public function get_affiliate_earning_unpaid_by_urlid_new($url_id)
    {
        $this->db->select('SUM(fee * ticket_quantity) as total_unpaid_revenue , SUM(referral_pay) as total_unpaid_earning');
        $this->db->where('user_referral_url_id', $url_id);
        $this->db->where('referral_pay_status','no');        
        $query = $this->db->get('event_ticket_order');
        
        if ($query->num_rows() > 0)
		{		   
           return  $query->row();
		}     
		return false;
    }
    
    public function get_affiliate_event_lists($for='all')
    {
        
        $sql = "SELECT 
                e.id,e.title, e.affiliate_referral_rate,e.organizer_id,
                e.date_id, e.start_date, e.end_date, d.end
                FROM `es_event` AS e
                LEFT JOIN es_event_date AS d ON d.id = e.date_id
                WHERE 
                if( date_id = '0', now( ) <= end_date, now( ) <=END )
                
                AND e.affiliate_referral_rate != '0.00'
                AND e.free_paid = 'paid'
                AND e.status = '1'
                ";
        //$this->db->select("id,title, affiliate_referral_rate,organizer_id");
//        if($for!='all')
//            $this->db->where("organizer_id !='".$this->session->userdata(SESSION.'user_id')."'");
//        $this->db->where('status','1');
//        $this->db->where('free_paid','paid');
//        $this->db->where("affiliate_referral_rate != '0.00'");
//        $this->db->from('event');
        
        $query=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0)
		{
		    return $query->result();		      
		                
		} 
		return false;
        
        
    }
    
    public function check_joined_event_affiliate($event_id)
    {
        $user_id = $this->session->userdata(SESSION.'user_id');
        $this->db->select("url");
        $this->db->where("user_id",$user_id);
        $this->db->where('event_id',$event_id);
        $this->db->from('event_referral_url');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
            $row = $query->row();		      
		    return $row->url;          
		} 
		return false;
    }
    
    function get_total_event_referral_payment($referral_event_url_id)
    {
        $this->db->select("SUM(ticket_quantity) as total_ticket_sold , SUM(event_referral_payment) as total_paid_earning");
        $this->db->where("referral_event_url_id",$referral_event_url_id);        
        $this->db->from('event_ticket_order');
        
        $query = $this->db->get();
        //echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
            return  $query->row();
		} 
		return false;
    }
    function get_total_unpaid_event_referral_payment($referral_event_url_id)
    {
        $this->db->select("SUM(event_referral_payment) as total_paid_earning");
        $this->db->where("referral_event_url_id",$referral_event_url_id);
        $this->db->where("event_referral_payment_status",'no');                
        $this->db->from('event_ticket_order');
        
        $query = $this->db->get();
        //echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
            return  $query->row();
		} 
		return false;
    }
    
    function get_payment_event_affiliate_earning($time='today')
    {
        if($time=='today')
            $this->db->where("DATE(create_date) = DATE(DATE_SUB(NOW(), INTERVAL 0 DAY))");    
        else if($time=='yesterday')
            $this->db->where("DATE(create_date) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))");
        else if($time=='month'){
            $this->db->where("create_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK)");
        }            
        else if($time=='last_month'){
            $this->db->where("MONTH(create_date) = MONTH(NOW()) -1");            
            $this->db->where("YEAR(create_date) = YEAR(NOW())");
        }   
        else if($time=='year'){
            $this->db->where("YEAR(create_date) = YEAR(NOW())");
        }
            
        
        $user_id = $this->session->userdata(SESSION.'user_id');
        $this->db->select("SUM(earning) as event_earning");
        $this->db->where("user_id",$user_id);
        $this->db->from('affiliate_event_earning');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
            $row = $query->row();		      
		    return ($row->event_earning)? $row->event_earning : '0';          
		} 
		return false;
    }
    
    function get_payment_referral_affiliate_earning($time='today')
    {
        if($time=='today')
            $this->db->where("DATE(`create_date`) = DATE(DATE_SUB(NOW(), INTERVAL 0 DAY))");    
        else if($time=='yesterday')
            $this->db->where("DATE(`create_date`) = DATE(DATE_SUB(NOW(), INTERVAL 1 DAY))");
        else if($time=='month'){
            $this->db->where("`create_date` >= DATE_SUB(NOW(), INTERVAL 1 WEEK)");
        }            
        else if($time=='last_month'){
            $this->db->where("MONTH(`create_date`) = MONTH(NOW()) -1");            
            $this->db->where("YEAR(`create_date`) = YEAR(NOW())");
        }   
        else if($time=='year'){
            $this->db->where("YEAR(`create_date`) = YEAR(NOW())");
        }
            
        
        $user_id = $this->session->userdata(SESSION.'user_id');
        $this->db->select("SUM(earning) as event_earning");
        $this->db->where("user_id",$user_id);
        $this->db->from('affiliate_referral_earning');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
            $row = $query->row();		      
		    return ($row->event_earning)? $row->event_earning : '0';          
		} 
		return false;
    }
    
    function get_payment_recent_earning()
    {
        $user_id =$this->session->userdata(SESSION.'user_id');
        $sql  = "SELECT T.user_id
    , CAST(SUBSTRING_INDEX(GROUP_CONCAT(T.earning ORDER BY T.create_date DESC), ',', 1) AS DECIMAL) AS latest_earning
                FROM (
                    SELECT user_id
                        , create_date
                        , earning
                        FROM es_affiliate_event_earning
            
                    UNION ALL
            
                    SELECT user_id
                        , create_date
                        , earning
                        FROM es_affiliate_referral_earning
                ) T    
                WHERE T.user_id = '$user_id'            
                GROUP BY T.user_id
                LIMIT 1
                ";

        $query=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0)
		{
		    $row = $query->row();		      
		    return ($row->latest_earning)? $row->latest_earning : '0';            
		} 
		return false;
                
    }
    
    function get_unpaid_earning_affiliate_referral()
    {
        $user_id =$this->session->userdata(SESSION.'user_id');
        $sql = "SELECT SUM(referral_pay) as unpaid_referral_pay
                FROM es_event_ticket_order
                WHERE referral_user_id = '$user_id' and referral_pay_status = 'no' and referral_user_id != '0' and due = '0.00' and payment_status = 'COMPLETE' and refund_id = '0' and organizer_paid != '0.00'
                ";
        $query=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0)
		{
		    $row = $query->row();		      
		    return ($row->unpaid_referral_pay)? $row->unpaid_referral_pay : '0';            
		} 
		return false;
    }
    
    function get_referral_payment_details()
    {
        $user_id =$this->session->userdata(SESSION.'user_id');
        $sql="SELECT T.user_id
        , MONTH(create_date) as month
        , SUM(earning) as total_earning
        , CAST(SUBSTRING_INDEX(GROUP_CONCAT(T.earning ORDER BY T.create_date DESC), ',', 1) AS DECIMAL) AS latest_earning
        , create_date
        , pay_detail
        , pay_through
                FROM (
                    SELECT user_id
                        , create_date
                        , earning  
                        , pay_through
                        , pay_detail
                        FROM es_affiliate_event_earning
            
                    UNION ALL
            
                    SELECT user_id
                        , create_date
                        , earning
                        , pay_through
                        , pay_detail
                        FROM es_affiliate_referral_earning
                ) T    
                WHERE T.user_id = '$user_id'            
                GROUP BY T.create_date
                ORDER BY T.create_date DESC
                limit 1, 18446744073709551615
                ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;   
    }
    
    function get_last_referral_payment_details()
    {
        $user_id =$this->session->userdata(SESSION.'user_id');
        $sql="SELECT T.user_id
        , MONTH(create_date) as month
        , SUM(earning) as total_earning
        , CAST(SUBSTRING_INDEX(GROUP_CONCAT(T.earning ORDER BY T.create_date DESC), ',', 1) AS DECIMAL) AS latest_earning
        , create_date
        , pay_detail
        , pay_through
                FROM (
                    SELECT user_id
                        , create_date
                        , earning  
                        , pay_through
                        , pay_detail
                        FROM es_affiliate_event_earning
            
                    UNION ALL
            
                    SELECT user_id
                        , create_date
                        , earning
                        , pay_through
                        , pay_detail
                        FROM es_affiliate_referral_earning
                ) T    
                WHERE T.user_id = '$user_id'            
                GROUP BY T.create_date
                ORDER BY T.create_date DESC
                limit 1
                ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;   
    }

}
