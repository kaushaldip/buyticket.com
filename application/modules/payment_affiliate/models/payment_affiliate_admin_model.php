<?php

class Payment_affiliate_admin_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_ticket_order_detail($ticket_order_id, $select="*")
    {
        $sql="SELECT $select
            FROM es_event_ticket_order              
            WHERE id =  '$ticket_order_id'  
            LIMIT 1";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    function get_user_detail($user_id)
    {
        $sql="SELECT eu.id,eu.first_name, eu.last_name, eu.email, eu.bank_name, eu.account_number, eu.account_holder_name, eu.western_payee_name, eu.western_city, eu.western_country                  
            FROM es_user AS eu
            WHERE eu.id =  '$user_id'
            limit 1 ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    
    function get_event_affiliate_payment_details()
    {
        $sql="SELECT 
            u.user_id as affiliate_user_id,
            referral_event_url_id, SUM(paid) as total_paid,  SUM(organizer_paid) as total_organizer_paid, SUM(fee) as net_web_fee , SUM(fee * ticket_quantity) as total_web_fee, SUM(event_referral_payment) as total_er_pay 
            FROM es_event_ticket_order as o
            JOIN es_event_referral_url as u ON u.id = o.referral_event_url_id             
            WHERE referral_event_url_id != '0' and due = '0.00' and payment_status = 'COMPLETE' and refund_id = '0' and organizer_paid != '0.00'
            and event_referral_payment_status = 'no'
            GROUP BY referral_event_url_id
            ORDER BY order_date DESC ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function get_event_affiliate_payment_details_byId($id)
    {
        $sql="SELECT 
            o.id as ticket_order_id,
            u.user_id as affiliate_user_id,            
            referral_event_url_id, paid,  organizer_paid, fee, fee * ticket_quantity as web_fee, event_referral_payment, event_referral_payment_status
            FROM es_event_ticket_order as o
            JOIN es_event_referral_url as u ON u.id = o.referral_event_url_id             
            WHERE referral_event_url_id != '0' and due = '0.00' and payment_status = 'COMPLETE' and refund_id = '0' and organizer_paid != '0.00'
            and event_referral_payment_status = 'no'
            and u.user_id = '$id'            
            ORDER BY o.id ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function insert_event_affiliate_payment($user_id, $event_id, $ticket_order_id, $url_id, $ticket_id,$affiliate_percent, $earning, $pay_through='', $pay_detail='')
    {
        $array_data = array(
                'user_id' => $user_id,
                'event_id' => $event_id,
                'ticket_order_id' => $ticket_order_id,
                'url_id' => $url_id,
                'ticket_id' => $ticket_id,
                'affiliate_percent' => $affiliate_percent,
                'earning' => $earning,
                'pay_through' => $pay_through,
                'pay_detail' => $pay_detail,
                'paid_status' => 'paid'
            );
        $this->db->insert('es_affiliate_event_earning', $array_data);
    }
    
    function update_ticket_order_event_affiliate($ticket_order_id)
    {
        $array_data = array(
                'event_referral_payment_status' => 'yes',                  
            );
        $this->db->where("id", $ticket_order_id);            
        $this->db->update("event_ticket_order",$array_data);
    }
    
    function send_event_affiliate_payment_release_email($user_email, $payment, $payment_detail)
    {
        $this->load->library(array('email','general'));        
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
        
        $this->load->model('email_model');
        //get subjet & body
		$template=$this->email_model->get_email_template("release-event-affiliate-payment");
		
        $subject=$template['subject'];
        $emailbody=$template['email_body'];
        
                
        //check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{		  
                $link = "<a href='".site_url('affiliate/payment')."'>".site_url('affiliate/payment')."</a>"; 
				$parseElement=array("EMAIL"=>$user_email,
									"SITENAME"=>SITE_NAME,
									"PAYMENT"=>$payment,
                                    "MONTH" => date('M'),
                                    "PAYMENT_DETAIL" => $payment_detail,
                                    "LINK" => $link,
                                    );

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
				//echo $emailbody;exit;	
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($user_email); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			//echo $this->email->print_debugger();exit;
            /*test email from localhost*/
            //$headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            @mail($user_email,$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
    }
    
    function get_referral_affiliate_payment_details()
    {
        $sql="SELECT 
            referral_user_id,MONTH(order_date) as month ,MONTH(CURRENT_DATE - INTERVAL 0 MONTH), current_date,
            SUM(paid) as total_paid,  SUM(organizer_paid) as total_organizer_paid, SUM(fee) as net_web_fee , SUM(fee * ticket_quantity) as total_web_fee, SUM(referral_pay) as total_referral_pay 
            FROM es_event_ticket_order        
            WHERE referral_user_id != '0' and due = '0.00' and payment_status = 'COMPLETE' and refund_id = '0' and organizer_paid != '0.00'
            and
                YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 0 MONTH)
                AND MONTH(order_date) <= MONTH(CURRENT_DATE - INTERVAL 0 MONTH)
            and referral_pay_status = 'no'
            GROUP BY referral_user_id, MONTH(order_date) 
            ORDER BY MONTH(order_date) DESC ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function get_referral_affiliate_payment_details_byId($id, $month)
    {
        $sql="SELECT 
            id as ticket_order_id,
            referral_user_id,MONTH(order_date) as month ,
            fee * ticket_quantity as web_fee, referral_pay , referral_pay_status
            FROM es_event_ticket_order        
            WHERE referral_user_id != '0' and due = '0.00' and payment_status = 'COMPLETE' and refund_id = '0' and organizer_paid != '0.00'
            and 
                YEAR(order_date) = YEAR(CURRENT_DATE - INTERVAL 0 MONTH)
                AND MONTH(order_date) <= MONTH(CURRENT_DATE - INTERVAL 0 MONTH)
            and referral_pay_status = 'no'
            and referral_user_id = '$id'
            and MONTH(order_date) = '$month' 
            ORDER BY MONTH(order_date) DESC ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function insert_referral_affiliate_payment($user_id, $event_id, $ticket_order_id, $ticket_id, $affiliate_percent,$web_fee, $earning, $pay_through, $pay_detail, $referral_user_url_id)
    {
        $array_data = array(
                'user_id' => $user_id,
                'event_id' => $event_id,
                'ticket_order_id' => $ticket_order_id,
                'ticket_id' => $ticket_id,
                'affiliate_percent' => $affiliate_percent,
                'revenue' => $web_fee,                
                'earning' => $earning,
                'pay_through' => $pay_through,
                'pay_detail' => $pay_detail,
                'paid_status' => 'paid',
                'user_referral_url_id' => $referral_user_url_id
            );
        $this->db->insert('es_affiliate_referral_earning', $array_data);
    }
    
    function update_ticket_order_referral_affiliate($ticket_order_id)
    {
        $array_data = array(
                'referral_pay_status' => 'yes',                  
            );
        $this->db->where("id", $ticket_order_id);            
        $this->db->update("event_ticket_order",$array_data);
    }
    
    function send_referral_affiliate_payment_release_email($user_email, $payment, $payment_detail)
    {
        $this->load->library(array('email','general'));        
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
        
        $this->load->model('email_model');
        //get subjet & body
		$template=$this->email_model->get_email_template("release-referral-affiliate-payment");
		
        $subject=$template['subject'];
        $emailbody=$template['email_body'];
        
                
        //check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{		  
                $link = "<a href='".site_url('affiliate/index')."'>".site_url('affiliate/index')."</a>"; 
				$parseElement=array("EMAIL"=>$user_email,
									"SITENAME"=>SITE_NAME,
									"PAYMENT"=>$payment,
                                    "MONTH" => date('M'),
                                    "PAYMENT_DETAIL" => $payment_detail,
                                    "LINK" => $link,
                                    );

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
				//echo $emailbody;exit;	
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($user_email); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			//echo $this->email->print_debugger();exit;
            /*test email from localhost*/
           // $headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            @mail($user_email,$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
    }
    
    function get_referral_user_url_id_from_ticketOrderId($ticket_order_id)
    {
        $sql = "SELECT u.referral_url_id as url_id_id
                FROM es_user AS u
                JOIN es_event AS e ON u.id = e.organizer_id
                JOIN es_event_ticket_order AS o ON o.event_id = e.id
                WHERE o.id ='$ticket_order_id'";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    $row = $q->row_array();
            return $row['url_id_id'];            
		} 
		return false;
                             
    }
    
}
?>