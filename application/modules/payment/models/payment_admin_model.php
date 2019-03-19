<?php

class Payment_admin_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_user_from_payment_details(){
        $sql="SELECT eu.id, eu.first_name, eu.last_name, SUM( eto.organizer_payment ) AS total_price_pay, SUM( eto.organizer_paid ) AS total_price_paid
FROM es_user AS eu
LEFT JOIN es_event AS ee ON ee.organizer_id = eu.id
LEFT JOIN es_event_ticket_order AS eto ON eto.event_id = ee.id
WHERE eu.organizer =  '1'
GROUP BY eu.id";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    function get_event_old_ticket_from_uid($uid){
        $sql="SELECT * 
FROM es_event AS es
JOIN es_event_ticket_order AS eto ON es.id = eto.event_id
where organizer_id=$uid
";
    }
    function get_payment_event_detail($id){
        
        $q = $this->db->get_where('es_payment', array('event_id' => $id));
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    function get_approve_transaction()
    {        
        $sql="SELECT eto.id as ticket_order_id, eto.event_id as eeeid, eto.ticket_id, eto.order_id, eto.ticket_quantity, eto.total, eto.transaction_method, eto.payment_status, eto.event_cancel, ee.name, ee.ticket_price
            FROM es_event_ticket_order AS eto
            JOIN es_event_ticket AS ee ON ee.id = eto.ticket_id
            WHERE eto.ticket_type =  'paid' and eto.refund_id = 0
            ORDER BY eto.order_date, eto.ticket_id DESC  ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function get_view_approve_transaction($ticket_order_id)
    {
        $sql="SELECT eto.email as main_email ,eto.transaction_method, eto.paypal_info_id, eto.bank_transaction_id, eto.order_date, eto.total, eto.order_for_date_start, eto.order_for_date_end, eto.order_id, (eto.discount * eto.ticket_quantity) as discount, eto.payment_price, eto.due, eto.paid,eto.ticket_quantity, eto.payment_status, eto.id as ticket_order_id, eto.ticket_quantity, eto.ticket_id, eto.event_cancel,
            eet.paid_free, eet.ticket_price, eet.website_fee, eet.price, eet.currency, eet.name AS ticket_name,
            eu.email, eu.first_name, eu.last_name, 
            event.title, 
            ebt . * , epi . *, ebt.amount as ebt_amount, epi.amount as epi_amount
            FROM es_event_ticket_order AS eto
            JOIN es_event_ticket AS eet ON eet.id = eto.ticket_id
            JOIN es_user AS eu ON eu.id = eto.user_id
            JOIN es_event AS event ON event.id = eto.event_id
            LEFT JOIN es_paypal_info AS epi ON epi.id = eto.paypal_info_id
            LEFT JOIN es_bank_transaction AS ebt ON ebt.id = eto.bank_transaction_id
            WHERE eto.ticket_type = 'paid'
            AND eto.id = '$ticket_order_id'
            LIMIT 1
             ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    
    
    function get_organizer_payment_detail()
    {        
        $sql="SELECT eu.id,eu.first_name, eu.last_name, eu.email,
            ee.title, ee.id as event_id            
            FROM es_user AS eu            
            JOIN es_event AS ee ON ee.organizer_id = eu.id
             
            WHERE eu.organizer =  '1'
            ORDER BY eu.id ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function get_view_organizer_payment($event_id)
    {
        $sql="SELECT id, order_id, ticket_id, event_id, organizer_payment, organizer_paid,payment_status, refund_id          
            FROM es_event_ticket_order 
            WHERE event_id =  '$event_id' and payment_status = 'COMPLETE' and refund_id = '0' and organizer_paid = '0.00'
            ORDER BY ticket_id, order_id ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function get_ticketwise_order($event_id)
    {
        $sql="SELECT eo.id,eo.event_id, eo.ticket_id, SUM(eo.organizer_payment) as total_organizer_payment, SUM(eo.organizer_paid) as total_organizer_paid,
            t.name  as ticket_name       
            FROM es_event_ticket_order as eo
            JOIN es_event_ticket as t on t.id = eo.ticket_id 
            WHERE eo.event_id =  '$event_id' and eo.payment_status = 'COMPLETE' and eo.refund_id = '0' and eo.organizer_paid = '0.00'
            GROUP BY eo.ticket_id
            ORDER BY eo.order_id ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function show_organizer_and_event($event_id)
    {
        $sql="SELECT eu.id,eu.first_name, eu.last_name, eu.email, eu.bank_name, eu.account_number, eu.account_holder_name, eu.western_payee_name, eu.western_city, eu.western_country,
            ee.title, ee.id as event_id            
            FROM es_user AS eu            
            JOIN es_event AS ee ON ee.organizer_id = eu.id
             
            WHERE ee.id =  '$event_id'
            limit 1 ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    
    function get_order_detail_byid($event_id, $ticket_id)
    {
        $sql="SELECT eo.id,eo.event_id, eo.ticket_id, eo.organizer_payment, eo.organizer_paid, eo.order_id, eo.payment_status, eo.refund_id ,
            t.name  as ticket_name       
            FROM es_event_ticket_order as eo
            JOIN es_event_ticket as t on t.id = eo.ticket_id             
            WHERE eo.event_id =  '$event_id' and eo.ticket_id = '$ticket_id' and eo.payment_status = 'COMPLETE' and eo.refund_id = '0' and organizer_paid = '0.00' 
            ORDER BY order_id ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function get_event_and_ticket($event_id, $ticket_id)
    {
        $sql="SELECT
            t.name  as ticket_name       
            FROM es_event_ticket_order as eo
            JOIN es_event_ticket as t on t.id = eo.ticket_id             
            WHERE eo.event_id =  '$event_id' and eo.ticket_id = '$ticket_id' and eo.payment_status = 'COMPLETE' and eo.refund_id = '0' and organizer_paid = '0.00' 
            LIMIT 1";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
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
    
    function get_value_from_id($table, $id,$select="id")
    {
        $sql="SELECT $select
            FROM $table              
            WHERE id =  '$id'  
            LIMIT 1";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    $row = $q->row_array();
            return $row[$select];            
		} 
		return false;
    }
    
    function insert_organizer_payment($organizer_id, $event_id, $ticket_id, $ticket_order_id, $order_id, $organizer_payment, $pay_through, $pay_detail )
    {
        $array_data = array(
                'organizer_id' => $organizer_id,
                'event_id' => $event_id,
                'ticket_id' => $ticket_id,
                'ticket_order_id' => $ticket_order_id,
                'order_id' => $order_id,
                'payment' => $organizer_payment,
                'pay_through' => $pay_through,
                'pay_detail' => $pay_detail,
            );
        $this->db->insert('organizer_payment', $array_data);
    }
    
    function update_ticket_order($ticket_order_id, $organizer_payment)
    {
        $array_data = array(
                'organizer_paid' => $organizer_payment,                  
            );
        $this->db->where("id", $ticket_order_id);            
        $this->db->update("event_ticket_order",$array_data);
    }
    
    function send_organizer_payment_release_email($organizer_email, $payment, $event_name, $ticket_name, $payment_detail)
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
		$template=$this->email_model->get_email_template("release-organizer-payment");
		
        $subject=$template['subject'];
        $emailbody=$template['email_body'];
        
                
        //check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{		  
				$parseElement=array("ORGANIZER"=>$organizer_email,
									"SITENAME"=>SITE_NAME,
									"PAYMENT"=>$payment,
                                    "EVENT_NAME" => $event_name,									
									"TICKET_NAME"=> $ticket_name,
                                    "PAYMENT_DETAIL" => $payment_detail,
                                    );

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
				//echo $emailbody;exit;	
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($organizer_email); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			//echo $this->email->print_debugger();exit;
            /*test email from localhost*/
            //$headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            @mail($organizer_email,$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
    }
    
    
    function get_refund_transaction()
    {        
        $sql="SELECT eto.id as ticket_order_id, eto.event_id as eeeid, eto.email ,eto.ticket_id, eto.order_id, eto.ticket_quantity, eto.total, eto.transaction_method, eto.payment_status, eto.paid, eto.total, eto.due, eto.organizer_paid, eto.organizer_payment, eto.order_date, 
        ee.name, ee.ticket_price,
        etor.percent as refund_percent, etor.refund_date
            FROM es_event_ticket_order AS eto
            JOIN es_event_ticket AS ee ON ee.id = eto.ticket_id
            JOIN es_event_ticket_order_refund AS etor ON etor.id = eto.refund_id
            WHERE eto.ticket_type =  'paid' and eto.refund_id > 0 and eto.payment_status = 'COMPLETE' 
            ORDER BY eto.order_date, eto.ticket_id DESC  ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->result();            
		} 
		return false;
    }
    
    function get_view_refund_transaction($ticket_order_id)
    {
        $sql="SELECT eto.id as ticket_order_id, eto.email,eto.event_id ,eto.ticket_id, eto.order_id, eto.ticket_quantity, eto.total, eto.transaction_method, eto.payment_status, eto.paid, eto.total, eto.due, eto.organizer_paid, eto.organizer_payment, eto.order_date, eto.refund_complete,
        ee.name, ee.ticket_price,
        etor.percent as refund_percent, etor.refund_date
            FROM es_event_ticket_order AS eto
            JOIN es_event_ticket AS ee ON ee.id = eto.ticket_id
            JOIN es_event_ticket_order_refund AS etor ON etor.id = eto.refund_id
            WHERE eto.ticket_type =  'paid' and eto.refund_id > 0 and eto.payment_status = 'COMPLETE'
            AND eto.id = '$ticket_order_id'
            ORDER BY eto.order_date, eto.ticket_id DESC
            LIMIT 1
             ";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    
    public function get_ticket_order_detail_to_cancel($ticket_order_id)
    {
        $sql = "SELECT eto.id AS ticket_order_id, eto.order_id, eto.email, eto.ticket_quantity, ee.title, eet.name AS ticket_name
            FROM `es_event_ticket_order` eto
            JOIN es_event AS ee ON ee.id = eto.event_id
            JOIN es_event_ticket AS eet ON eet.id = eto.ticket_id
            WHERE eto.id ='$ticket_order_id'";
        $q=$this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    
    function send_order_cancel_detail($ticket_order_id)
    {
        $od = $this->get_ticket_order_detail_to_cancel($ticket_order_id);
        
        $this->load->library(array('email','general'));        
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
        
        $this->load->model('email_model');
        //get subjet & body
		$template=$this->email_model->get_email_template("cancel-ticket-order");

        
        
        $subject=$template['subject'];
        $emailbody=$template['email_body'];
        
                
        //check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{		  
				$parseElement=array("EMAIL"=>$od->email,
									"SITENAME"=>SITE_NAME,
									"ORDER"=>$od->order_id,
                                    "SUB_ORDER" => $ticket_order_id,									
									"EVENT"=> $od->title,
                                    "TICKET" => $od->ticket_name,
                                    "QUANTITY" => $od->ticket_quantity,
                                    );

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
				//echo $emailbody;exit;	
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($od->email); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			//echo $this->email->print_debugger();exit;
            /*test email from localhost*/
            //$headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            @mail($od->email,$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
    }
}
?>
