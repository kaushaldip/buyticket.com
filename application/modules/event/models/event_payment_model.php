<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_payment_model extends CI_Model 
{
	public function __construct() 
	{
		parent::__construct();
		
	}
    
    public function insert_paypal_info($get_ec_return,$do_ec_return)
    {       
        $array_data = array(			   
		   'token' => $get_ec_return['TOKEN'],
           'payid' => $get_ec_return['PAYERID'],
           'email' => $get_ec_return['EMAIL'],			   
		   'checkoutstatus' => $get_ec_return['CHECKOUTSTATUS'],
		   'timestamp' => $get_ec_return['TIMESTAMP'],
		   'ack'=> $get_ec_return['ACK'],			   			  
		   'payerstatus' => $get_ec_return['PAYERSTATUS'],
           'currencycode' => $get_ec_return['CURRENCYCODE'],
           'amount'=> $get_ec_return['AMT'],
           
		   'feeamt' => $do_ec_return['PAYMENTINFO_0_FEEAMT'],
           'paymentstatus' => $do_ec_return['PAYMENTINFO_0_PAYMENTSTATUS'],
           'GetExpressCheckoutDetails' => json_encode($get_ec_return),
           'DoExpressCheckoutPayment' => json_encode($do_ec_return),
        );
        
        $result = $this->db->insert('paypal_info', $array_data);
        if($result)
            return $insert_id = $this->db->insert_id();
        else 
            false;
        
    }
    
    public function insert_paypal_order($id,$order_id,$token_id,$temp_cart_id,$get_ec_return,$do_ec_return,$paypal_info_id)
    {
        /*user details start*/
        $email =  $this->session->userdata(SESSION.'email');// $get_ec_return['EMAIL'];
        //echo $this->session->userdata(SESSION.'user_id');exit;
        if($this->session->userdata(SESSION.'user_id')){
            $user_id = $this->session->userdata(SESSION.'user_id');
        }else if($this->check_email_exit($email)){//update user fields
            $user_id = $this->check_email_exit($email);  
            $this->make_login($user_id);          
        }else{//insert user fields            
            $user_id = $this->register_new_paypal_user($email,$get_ec_return);
            if(!$user_id){   
                $this->session->set_flashdata('message',$this->lang->line('insert_paypal_order_message')."<br/> Token id =".$do_ec_return['TOKEN']." and Payer Id = ".$get_ec_return['PAYERID']);
                redirect(site_url('event/view/'.$id));
            }else{
                $this->make_login($user_id); 
            }                            
        }   
        /*user details end*/
        
        /*insert order from temp cart start*/
        $order = $this->event_model->get_temp_cart_detail($id,$order_id,$token_id,$temp_cart_id);
        
        $tickets_no = explode(',',$order->ticket_quantity);                     
        $tickets_id = explode(',',$order->ticket_id);
                        
        $grand_total = 0;
        $total_discount = 0;
        $discount = 0;
        $discount_per = 0;
        if($order->promotion_code_id != 0)
        {
            $discount_per = $order->discount;
        }
        /*/for order dates, get_for_date_in_event_byid start */
        $data_event = $this->get_for_date_in_event_byid($id);
        if($data_event->date_id !='0')
            $date_attendings = explode(',',$order->date_time);
        if($data_event->date_id =='0'){ 
            $order_for_date_start = date('Y-m-d H:i:s',strtotime($data_event->start_date)) ; 
        }else{ 
            $order_for_date_start = date('Y-m-d H:i:s',strtotime($date_attendings[0])) ;
        }
        if($data_event->date_id =='0'){ 
            $order_for_date_end = date('Y-m-d H:i:s',strtotime($data_event->end_date)) ; 
        }else{ 
            $order_for_date_end = date('Y-m-d H:i:s',strtotime($date_attendings[1])) ;
        }
        /*/for order dates, get_for_date_in_event_byid end*/  
        
        /*affilate initialize part start*/
        $referral_event_url_id = ($this->input->cookie(SESSION."referral_event_url_id")) ? $this->input->cookie(SESSION."referral_event_url_id") : 0; 
        $event_affiliate_referral_rate = ($this->input->cookie(SESSION."referral_event_url_id")) ? $this->get_event_referral_percent_from_event($id): 0;
        $referral_user = $this->get_parent_id_from_event_id($id);
        $referral_user_id =   $referral_user->referral_id; //parent id of the organizer
        $user_referral_url_id = $referral_user->referral_url_id; 
        /*affilate initialize part end*/
        
        foreach($tickets_no as $key=>$ticket_qty):            
            if($ticket_qty=='')
                continue;                      
            
            $ticket_detail = $this->event_model->get_ticket_detail_from_id($tickets_id[$key]);
            //$discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee) * $discount_per / 100, 2, '.', '');
            $discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee) * $discount_per / 100, 2, '.', '');
            
            $referral_pay = ($referral_user_id!=0)? ($ticket_detail->website_fee  * AFFILIATE_REFERRAL_RATE / 100 * $ticket_qty):0;
            
            
            $event_referral_payment = 0;
            
            //referral_event_url_id cookie should be set and event_id should be matched to get affiliate price by affiliate user
            if($this->input->cookie(SESSION."referral_event_url_id")){                
                $event_id_referral = $this->general->get_value_from_id('es_event_referral_url',$referral_event_url_id,'event_id');
                if($event_id_referral == $event_id){
                    $event_referral_payment = ($ticket_detail->ticket_price - $ticket_detail->website_fee -$discount) * $event_affiliate_referral_rate / 100 * $ticket_qty;
                    
                }                    
                else{
                    $event_referral_payment = 0;
                }                        
            }
            
            
            $total = ($ticket_detail->ticket_price - $discount) * $ticket_qty;
            
            //for order form details
            $jsn_order_form_detail = $this->session->userdata('order_form_details');
            $ar_order_form_detail = json_decode($jsn_order_form_detail, TRUE);           
            $tic_id = $tickets_id[$key];
            $tic_id = "a".$tic_id;
            
            $array_data = array(
                    'user_id' => $user_id,
                    'event_id' =>$id, 
                    'order_id' =>$order_id,
                    'order_form_detail'=>json_encode($ar_order_form_detail[$tic_id]),
                    'order_for_date_start' => $order_for_date_start,
                    'order_for_date_end' => $order_for_date_end,
                    
                    //'first_name' => $get_ec_return['FIRSTNAME'],
                    //'last_name' => $get_ec_return['LASTNAME'],
                    //'email' => $get_ec_return['EMAIL'],
                    'email' => $this->session->userdata(SESSION.'email'),
                                                                  
                    'ticket_id' =>$tickets_id[$key],
                    'ticket_quantity' =>$ticket_qty,
                    'ticket_type' => $ticket_detail->paid_free,
                    
                    'currency' =>  'USD',
                    'ticket_price' => $ticket_detail->ticket_price,
                    'price' => ($ticket_detail->ticket_price - $ticket_detail->website_fee), //ticket rate = ticket_price - website_fee
                    'fee' => $ticket_detail->website_fee, //wesite fee
                    
                    'referral_pay' => $referral_pay, // AFFILIATE_REFERRAL_RATE of web fee total
                    'referral_user_id' => $referral_user_id, //parent of event organizer
                    'user_referral_url_id' => $user_referral_url_id,
                    
                    'discount' => $discount, //unit
                    'promotion_code_id' => $order->promotion_code_id,
                    
                    'event_referral_payment' => $event_referral_payment, //in total
                    'referral_event_url_id' => $referral_event_url_id,
                    
                    'payment_price' => ($ticket_detail->ticket_price - $discount), //payment by payer rate
                    'due' => ($ticket_detail->ticket_price - $discount) * $ticket_qty,
                    'paid' => 0,
                    'total' => ($ticket_detail->ticket_price - $discount) * $ticket_qty, //payment by payer  total
                                                    
                    'organizer_payment' => (($ticket_detail->ticket_price - $ticket_detail->website_fee - $discount) * $ticket_qty) -  $event_referral_payment,
                    
                    'order_date' => $this->general->get_local_time('time'),
                    'payment_status' => (strtoupper($ticket_detail->paid_free)=='FREE')?'COMPLETE':'PENDING',
                    'create_ticket' => 'yes', //since its paypal, so being PENDING create ticket 
                    
                    
                    'transaction_method'=> 'PAYPAL',
                    'paypal_info_id'=> $paypal_info_id,
                    'check_in' => 0,                    
            );
            $result = $this->db->insert('event_ticket_order', $array_data);
            $ticket_order_id = $this->db->insert_id();    
            $this->make_myticket($ticket_order_id);   //create ticket
            $this->db->query("UPDATE `es_event_ticket` SET `ticket_used` = ticket_used + $ticket_qty WHERE `id` = '$tickets_id[$key]'");
            
        endforeach;        
        /*insert order from temp cart end*/
        
        if($order->promotion_code_id != 0)
            $this->db->query("UPDATE `es_promotional_code` SET `used` = used + 1 WHERE `id` = '$order->promotion_code_id'");
               
        
        if(!empty($referral_event_url_id)){            
            delete_cookie(SESSION."referral_event_url_id");    
        }
                
                
        return true;        
    }
    
    public function make_login($user_id)
    {
        $this->load->library('general');        
        $user_ip = $this->general->get_real_ipaddr();
        
        $options = array('id'=>$user_id);
        $query = $this->db->get_where('user',$options);
        
        $record = $query->row_array();
        
        $current_date = $this->general->get_local_time('time');
							
		$update_data = array('last_login_date'=>$current_date,'last_ip_address'=>$user_ip);
		
        $this->db->where('id',$user_id);
        $this->db->update('user',$update_data);
			
		$this->session->set_userdata(array(SESSION.'user_id' => $record['id']));                             	
	    $this->session->set_userdata(array(SESSION.'email' => $record['email']));								
		$this->session->set_userdata(array(SESSION.'first_name' => $record['first_name']));								
		$this->session->set_userdata(array(SESSION.'last_name' => $record['last_name']));								
		//$this->session->set_userdata(array(SESSION.'username' => $record['username']));
        
		$this->session->set_userdata(array(SESSION.'profile_image' => $record['image']));			
        
        $this->session->set_userdata(array(SESSION.'organizer' => $record['organizer']));
        					
        $this->session->set_userdata(array('last_login' => $this->general->date_time_formate($record['last_login_date'])));
    }
    
    public function make_myticket($ticket_order_id)
    {       
        $this->load->library('ciqrcode');           
        
        //check if the ticket is available already
        $this->db->select("id");
        $this->db->from('event_ticket_sold');
        $this->db->where('ticket_order_id',$ticket_order_id);
        $query1 = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query1->num_rows() > 0)
		{
		     $data = array(
                   'create_ticket' => "yes",
                );
    		$this->db->where('id', $ticket_order_id);
    		$ok = $this->db->update('event_ticket_order', $data);
            
           // echo "success";
            exit;  
        }
        
        
        $this->db->select("o.ticket_quantity,o.event_id, o.order_id,o.order_form_detail, o.order_for_date_start, o.order_for_date_end, o.email,o.ticket_id, o.order_date, e.title, e.logo, l.address, l.physical_name,l.longitude,l.latitude, l.event_id, t.name, t.symbol, t.ticket_price,t.paid_free");
        $this->db->from('es_event_ticket_order as o');
        $this->db->join('es_event AS e',"e.id = o.event_id");
        $this->db->join('es_event_location AS l',"l.event_id = o.event_id");
        $this->db->join('es_event_ticket AS t',"t.id = o.ticket_id");
        $this->db->where("o.id = '$ticket_order_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		    $row = $query->row();          
                  
            $barcode = $row->order_id.rand(1000000,99999999);
            $datetime = date('M j, Y \a\t g:i A ', strtotime($row->order_for_date_start))." TO ".date('M j, Y \a\t g:i A ', strtotime($row->order_for_date_end));
            $location = $row->physical_name." \n<br/>".$row->address;
            //$order_info = "Order #".$row->order_id.". Ordered by ".$row->first_name." ".$row->last_name." on ".date('M j, Y \a\t n:s A ', strtotime($row->order_date));
            $order_info = "Order #".$row->order_id.". Ordered on ".date('M j, Y \a\t g:i A ', strtotime($row->order_date));            
            if(!empty($row->order_form_detail)){
                $form_detail = json_decode($row->order_form_detail, TRUE);                    
            }
            for($i=1;$i<=$row->ticket_quantity;$i++){ 
                if(!empty($row->order_form_detail)){
                    $attendee_name = ucwords($form_detail['first_name'.$i]." ".$form_detail['last_name'.$i]);                                        
                }else{
                    $attendee_name = $row->email;
                }                
                
                $array_data = array(
                        'attendee' => $attendee_name,//ucwords($row->first_name." ".$row->last_name),
                        'email' => $row->email,
                        'event_name'=>$row->title,
                        'event_logo' =>$row->logo,
                        'ticket_order_id'=>$ticket_order_id,
                        'barcode' =>$barcode.$i,
                        'datetime_detail'=>$datetime,
                        'ticket_name' => $row->name,
                        'location' => $location,
                        'order_info' =>$order_info,
                        'rate' => $row->ticket_price,
                        'payment_status' =>ucwords($row->paid_free." order"),
                        'price' =>$row->symbol." ".$row->ticket_price,
                        'longitude' =>$row->longitude,
                        'latitude' =>$row->latitude,
                    );                    
                $this->db->insert('event_ticket_sold', $array_data);
                
                /*create AND save QR code start*/
                $params['data'] = $barcode.$i;
                $params['level'] = 'H';
                $params['size'] = 3;
                $params['savename'] = UPLOAD_FILE_PATH."qrcode/".$barcode.$i.'.png';
                $this->ciqrcode->generate($params);
                /*create AND save QR code end*/
                                    
            }             
                
            /*update table es_event_ticket_order */
            $data = array(
                   'create_ticket' => "yes",
                );
    		$this->db->where('id', $ticket_order_id);
    		$ok = $this->db->update('event_ticket_order', $data);
            /*update table es_event_ticket_order */
                         
		}else{
            
		}
		
    }
    
    public function update_existing_user_detail($user_id, $free='')
    {        
        $data1 = array(                    
                'first_name' =>$this->input->post('first_name',TRUE),
                'last_name' => $this->input->post('last_name',TRUE),
        );
        $this->db->where("id",$user_id);            
        $this->db->update("user",$data1);
        
        if($free==''){
            $data2 = array(
                'address' =>$this->input->post('billing_address',TRUE),
                'address1' =>$this->input->post('billing_address2',TRUE),
                'city'=>$this->input->post('billing_city',TRUE),
                'state' =>$this->input->post('billing_state',TRUE),
                'zip' => $this->input->post('billing_postal_code',TRUE),
                'country' =>$this->input->post('billing_country',TRUE),
            );
            $this->db->where("user_id", $user_id);            
            $this->db->update("user_detail",$data2);    
        }
        
    }
    public function register_new_user_free()
    {
        $this->load->model('users/register_module');
        
        //get random 10 numeric degit		
		$activation_code = $this->general->random_number();
		$ip_address = $this->general->get_real_ipaddr();        
		$parent = (($this->input->cookie(SESSION."referral_id", TRUE)))? '1': '0';
        $referal_id = (($this->input->cookie(SESSION."referral_id", TRUE)))? $this->input->cookie(SESSION."referral_id", TRUE): '0';
		$password = base64_encode($this->input->post('password',TRUE));

		//set member info
		$data = array(			   
			   'email' => $this->input->post('email',TRUE),
               //'first_name' => $this->input->post('first_name',TRUE),
               //'last_name' => $this->input->post('last_name',TRUE),			   
			   'password' => $password,
			   'reg_ip_address' => $ip_address,
			   'activation_code'=>$activation_code,			   			  
			   'reg_date' => $this->general->get_local_time('time'),
               'parent' =>$parent,
               'referral_id'=>$referal_id,
			   'status' => '2',
            );
			
		if($this->session->userdata('is_fb_user')=="Yes")
		{
			$data['status'] = '1';
			$data['is_fb_user'] = 'Yes';			
		}
		else
		{
			$data['is_fb_user'] = 'No';            
		}
		
		
        //Running Transactions
        $this->db->trans_start();
        //insert records in the database
        $this->db->insert('user',$data);
        $user_id = $this->user_id = $this->db->insert_id();
        
        //insert records in user_detail table        
        $data1 = array(
            'user_id'=>$this->db->insert_id(), 
        );                    
        
        $this->db->insert('user_detail',$data1);
        
        
        
        //Complete Transactions
        $this->db->trans_complete();
			
		if ($this->db->trans_status() === FALSE)
		{
			return "system_error";
		}
        else
        {
        	$this->register_module->reg_confirmation_email($activation_code);
            return $this->user_id;
        }
    }
    
    public function register_new_user()
    {
        $this->load->model('users/register_module');
        
        //get random 10 numeric degit		
		$activation_code = $this->general->random_number();
		$ip_address = $this->general->get_real_ipaddr();        
		$parent = (($this->input->cookie(SESSION."referral_id", TRUE)))? '1': '0';
        $referal_id = (($this->input->cookie(SESSION."referral_id", TRUE)))? $this->input->cookie(SESSION."referral_id", TRUE): '0';
		$password = base64_encode($this->input->post('password',TRUE));

		//set member info
		$data = array(			   
			   'email' => $this->input->post('email',TRUE),
               'first_name' => $this->input->post('first_name',TRUE),
               'last_name' => $this->input->post('last_name',TRUE),			   
			   'password' => $password,
			   'reg_ip_address' => $ip_address,
			   'activation_code'=>$activation_code,			   			  
			   'reg_date' => $this->general->get_local_time('time'),
               'parent' =>$parent,
               'referral_id'=>$referal_id,
			   'status' => '2',
            );
			
		if($this->session->userdata('is_fb_user')=="Yes")
		{
			$data['status'] = '1';
			$data['is_fb_user'] = 'Yes';			
		}
		else
		{
			$data['is_fb_user'] = 'No';            
		}
		
		
        //Running Transactions
        $this->db->trans_start();
        //insert records in the database
        $this->db->insert('user',$data);
        $user_id = $this->user_id = $this->db->insert_id();
        
        //insert records in user_detail table        
        $data1 = array(
            'user_id'=>$this->db->insert_id(),            
            'address' =>$this->input->post('billing_address',TRUE),
            'address1' =>$this->input->post('billing_address2',TRUE),
            'city'=>$this->input->post('billing_city',TRUE),
            'state' =>$this->input->post('billing_state',TRUE),
            'zip' => $this->input->post('billing_postal_code',TRUE),
            'country' =>$this->input->post('billing_country',TRUE),
        );                    
        
        $this->db->insert('user_detail',$data1);
        
        
        
        //Complete Transactions
        $this->db->trans_complete();
			
		if ($this->db->trans_status() === FALSE)
		{
			return "system_error";
		}
        else
        {
        	$this->register_module->reg_confirmation_email($activation_code);
            return $this->user_id;
        }
    }
    
    public function register_new_user_order()
    {
        $this->load->model('users/register_module');
        
        //get random 10 numeric degit		
		$activation_code = $this->general->random_number();
		$ip_address = $this->general->get_real_ipaddr();        
		$parent = (($this->input->cookie(SESSION."referral_id", TRUE)))? '1': '0';
        $referal_id = (($this->input->cookie(SESSION."referral_id", TRUE)))? $this->input->cookie(SESSION."referral_id", TRUE): '0';
		$password = base64_encode($this->input->post('password',TRUE));

		//set member info
		$data = array(			   
			   'email' => $this->input->post('email',TRUE),
               //'first_name' => $this->input->post('first_name1',TRUE),
               //'last_name' => $this->input->post('last_name1',TRUE),			   
			   'password' => $password,
			   'reg_ip_address' => $ip_address,
			   'activation_code'=>$activation_code,			   			  
			   'reg_date' => $this->general->get_local_time('time'),
               'parent' =>$parent,
               'referral_id'=>$referal_id,
			   'status' => '1',
            );
			
		if($this->session->userdata('is_fb_user')=="Yes")
		{
			$data['status'] = '1';
			$data['is_fb_user'] = 'Yes';			
		}
		else
		{
			$data['is_fb_user'] = 'No';            
		}
		
		
        //Running Transactions
        $this->db->trans_start();
        //insert records in the database
        $this->db->insert('user',$data);
        $user_id = $this->user_id = $this->db->insert_id();
        
        //insert records in user_detail table        
        $data1 = array(
            'user_id'=>$this->db->insert_id(),            
            //'address' =>$this->input->post('billing_address1',TRUE),
            //'address1' =>$this->input->post('billing_address21',TRUE),
            //'city'=>$this->input->post('billing_city1',TRUE),
            //'state' =>$this->input->post('billing_state1',TRUE),
            //'zip' => $this->input->post('billing_postal_code1',TRUE),
            //'country' =>$this->input->post('billing_country1',TRUE),
        );                    
        
        $this->db->insert('user_detail',$data1);
        
        
        
        //Complete Transactions
        $this->db->trans_complete();
			
		if ($this->db->trans_status() === FALSE)
		{
			return "system_error";
		}
        else
        {
        	$this->register_module->reg_confirmation_email($activation_code);
            return $this->user_id;
        }
    }
    
    public function update_user_detail($event_id)
    {
        $user_id = $this->session->userdata(SESSION.'user_id');
        $data1 = array(                    
                'first_name' =>$this->input->post('first_name',TRUE),
                'last_name' => $this->input->post('last_name',TRUE),
        );
        $this->db->where("id", $this->session->userdata(SESSION.'user_id'));            
        $this->db->update("user",$data1);
        
        $data2 = array(
            'address' =>$this->input->post('billing_address',TRUE),
            'address1' =>$this->input->post('billing_address2',TRUE),
            'city'=>$this->input->post('billing_city',TRUE),
            'state' =>$this->input->post('billing_state',TRUE),
            'zip' => $this->input->post('billing_postal_code',TRUE),
            'country' =>$this->input->post('billing_country',TRUE),
            'home_number' =>$this->input->post('home_number',TRUE),
            'mobile_number' =>$this->input->post('mobile_number',TRUE),
            'street' =>$this->input->post('street_address',TRUE),
            'work_job_title' =>$this->input->post('work_job_title',TRUE),
            'work_company' =>$this->input->post('work_company',TRUE),
            'work_address' =>$this->input->post('work_address',TRUE),
            'work_number' =>$this->input->post('work_number',TRUE),
            'work_city' =>$this->input->post('work_city',TRUE),
            'work_state' =>$this->input->post('work_state',TRUE),
            'work_country' =>$this->input->post('work_country',TRUE),
            'work_zip' =>$this->input->post('work_zip',TRUE),
            'gender' =>$this->input->post('gender',TRUE)
            
            
        );
        $this->db->where("user_id", $this->session->userdata(SESSION.'user_id'));            
        $this->db->update("user_detail",$data2);
         
        return $user_id; 
    
    }
    
    public function update_user_detail_order($event_id)
    {
        $user_id = $this->session->userdata(SESSION.'user_id');
        $data1 = array(                    
                'first_name' =>$this->input->post('first_name1',TRUE),
                'last_name' => $this->input->post('last_name1',TRUE),
        );
        $this->db->where("id", $this->session->userdata(SESSION.'user_id'));            
        $this->db->update("user",$data1);
        
        $data2 = array(
            'address' =>$this->input->post('billing_address1',TRUE),
            'address1' =>$this->input->post('billing_address21',TRUE),
            'city'=>$this->input->post('billing_city1',TRUE),
            'state' =>$this->input->post('billing_state1',TRUE),
            'zip' => $this->input->post('billing_postal_code1',TRUE),
            'country' =>$this->input->post('billing_country1',TRUE),
            'home_number' =>$this->input->post('home_number1',TRUE),
            'mobile_number' =>$this->input->post('mobile_number1',TRUE),
            'street' =>$this->input->post('street_address1',TRUE),
            'work_job_title' =>$this->input->post('work_job_title1',TRUE),
            'work_company' =>$this->input->post('work_company1',TRUE),
            'work_address' =>$this->input->post('work_address1',TRUE),
            'work_number' =>$this->input->post('work_number1',TRUE),
            'work_city' =>$this->input->post('work_city1',TRUE),
            'work_state' =>$this->input->post('work_state1',TRUE),
            'work_country' =>$this->input->post('work_country1',TRUE),
            'work_zip' =>$this->input->post('work_zip1',TRUE),
            'gender' =>$this->input->post('gender1',TRUE)
            
            
        );
        $this->db->where("user_id", $this->session->userdata(SESSION.'user_id'));            
        $this->db->update("user_detail",$data2);
         
        return $user_id; 
    
    }
    
    public function register_new_paypal_user($email,$get_ec_return)
    {
        $this->load->model('users/register_module');
        
        //get random 10 numeric degit		
		$activation_code = $this->general->random_number();
		$ip_address = $this->general->get_real_ipaddr();        
		$parent = (($this->input->cookie(SESSION."referral_id", TRUE)))? '1': '0';
        $referal_id = (($this->input->cookie(SESSION."referral_id", TRUE)))? $this->input->cookie(SESSION."referral_id", TRUE): '0';
		$password = base64_encode('123456');

		//set member info
		$data = array(			   
			   'email' => $email,
               'first_name' => $get_ec_return['FIRSTNAME'],
               'last_name' => $get_ec_return['LASTNAME'],			   
			   'password' => $password,
			   'reg_ip_address' => $ip_address,
			   'activation_code'=>$activation_code,			   			  
			   'reg_date' => $this->general->get_local_time('time'),
               'parent' =>$parent,
               'referral_id'=>$referal_id,
			   'status' => '2',
            );
			
		if($this->session->userdata('is_fb_user')=="Yes")
		{
			$data['status'] = '1';
			$data['is_fb_user'] = 'Yes';			
		}
		else
		{
			$data['is_fb_user'] = 'No';            
		}
		
		
        //Running Transactions
        $this->db->trans_start();
        //insert records in the database
        $this->db->insert('user',$data);
        $user_id = $this->user_id = $this->db->insert_id();
        
        //insert records in user_detail table        
        $data1 = array(
            'user_id'=>$this->db->insert_id(),            
            'country' => $get_ec_return['SHIPTOCOUNTRYNAME'],
            'address' => $get_ec_return['SHIPTOSTREET'],            
            'city' => $get_ec_return['SHIPTOCITY'],
            'state' => $get_ec_return['SHIPTOSTATE'],
            'zip' => $get_ec_return['SHIPTOZIP'],
        );                    
        
        $this->db->insert('user_detail',$data1);
        
        
        
        //Complete Transactions
        $this->db->trans_complete();
			
		if ($this->db->trans_status() === FALSE)
		{
			return "system_error";
		}
        else
        {
        	$this->register_module->reg_confirmation_email($activation_code, $email, $password);
            return $this->user_id;
        }
    }
    
    public function check_email_exit($email)
    {        
        $options = array('email'=>$email);
        $this->db->select('id,email');        
        $query = $this->db->get_where('user',$options);
        
		if($query->num_rows() > 0){
            $row = $query->row();               
            return $row->id;		   
		}            
        else 
            return false;
    }
    
    public function get_for_date_in_event_byid($id)
    {
        $this->db->select('id,date_id,start_date, end_date');
        $this->db->from('es_event');
        $this->db->where("id = '$id'");
        $this->db->limit('1');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 
		return false;
    }
    
    public function get_parent_id_from_event_id($event_id)
    {
        $q=$this->db->query("SELECT u.`referral_id` , u.`referral_url_id` , e.id, e.organizer_id
                FROM es_event AS e
                LEFT JOIN `es_user` AS u ON u.id = e.organizer_id
                WHERE e.id = '$event_id'");
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0)
		{
		    return $q->row();            
		} 
		return false;
    }
    
    public function insert_ticket_payment_order($event_id,$order_id,$token_id,$temp_cart_id,$bank_trans_id) //for credit card order
    {
        $id = $event_id;
        /*user details start*/
        if($this->session->userdata(SESSION.'user_id')){
            $user_id = $this->session->userdata(SESSION.'user_id');
            //$this->update_existing_user_detail($user_id); //update existing user details
        }else{//insert user fields            
            $user_id = $this->register_new_user();
            if(!$user_id){   
                $this->session->set_flashdata('message',$this->language->line('order_failure_msg'));
                redirect(site_url('event/view/'.$id));
            }else{
                $this->make_login($user_id); 
            }                            
        }   
        /*user details end*/
        
        /*get order from temp cart start*/
        $order = $this->event_model->get_temp_cart_detail($event_id,$order_id,$token_id,$temp_cart_id);
        if(!$order)
        {
            $this->session->set_flashdata('message',$this->language->line('order_failure_msg'));
            redirect(site_url('event/view/'.$event_id));
        }
        
        
        $tickets_no = explode(',',$order->ticket_quantity);                     
        $tickets_id = explode(',',$order->ticket_id);
                        
        $grand_total = 0;
        $total_discount = 0;
        $discount = 0;
        $discount_per = 0;
        if($order->promotion_code_id != 0)
        {
            $discount_per = $order->discount;
        }
        /*/for order dates, get_for_date_in_event_byid start */
        $data_event = $this->get_for_date_in_event_byid($id);
        if($data_event->date_id !='0')
            $date_attendings = explode(',',$order->date_time);
        if($data_event->date_id =='0'){ 
            $order_for_date_start = date('Y-m-d H:i:s',strtotime($data_event->start_date)) ; 
        }else{ 
            $order_for_date_start = date('Y-m-d H:i:s',strtotime($date_attendings[0])) ;
        }
        if($data_event->date_id =='0'){ 
            $order_for_date_end = date('Y-m-d H:i:s',strtotime($data_event->end_date)) ; 
        }else{ 
            $order_for_date_end = date('Y-m-d H:i:s',strtotime($date_attendings[1])) ;
        }
        /*/for order dates, get_for_date_in_event_byid end*/  
        
        /*affilate initialize part start*/
        $referral_event_url_id = ($this->input->cookie(SESSION."referral_event_url_id")) ? $this->input->cookie(SESSION."referral_event_url_id") : 0; 
        $referral_user = $this->get_parent_id_from_event_id($id);
        $referral_user_id =   $referral_user->referral_id;
        $user_referral_url_id = $referral_user->referral_url_id; 
        /*affilate initialize part end*/
        $event_affiliate_referral_rate = $this->general->get_value_from_id('es_event',$event_id,'affiliate_referral_rate');
        //credit card expirtation date
        $temp_date = $this->input->post('year')."-".$this->input->post('month');;
        $expiration_date = date('Y-m-d', strtotime($temp_date));
        
        foreach($tickets_no as $key=>$ticket_qty):            
            if($ticket_qty=='')
                continue;                      
            
            $ticket_detail = $this->event_model->get_ticket_detail_from_id($tickets_id[$key]);
            //$discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee) * $discount_per / 100, 2, '.', '');
            $discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee) * $discount_per / 100, 2, '.', '');
            
            $referral_pay = ($referral_user_id!=0)? ($ticket_detail->website_fee  * AFFILIATE_REFERRAL_RATE / 100 * $ticket_qty):0;
            
            $event_referral_payment = 0;
            
            //referral_event_url_id cookie should be set and event_id should be matched to get affiliate price by affiliate user
            if($this->input->cookie(SESSION."referral_event_url_id")){                
                $event_id_referral = $this->general->get_value_from_id('es_event_referral_url',$referral_event_url_id,'event_id');
                if($event_id_referral == $event_id){
                    $event_referral_payment = ($ticket_detail->ticket_price - $ticket_detail->website_fee -$discount) * $event_affiliate_referral_rate / 100 * $ticket_qty;
                    
                }                    
                else{
                    $event_referral_payment = 0;
                }                        
            }
            
            $total = ($ticket_detail->ticket_price - $discount) * $ticket_qty;
            
            //for order form details
            $jsn_order_form_detail = $this->session->userdata('order_form_details');
            $ar_order_form_detail = json_decode($jsn_order_form_detail, TRUE);           
            $tic_id = $tickets_id[$key];
            $tic_id = "a".$tic_id;
            $array_data = array(
                    'user_id' => $user_id,
                    'event_id' =>$id, 
                    'order_id' =>$order_id,
                    'order_form_detail'=>json_encode($ar_order_form_detail[$tic_id]),
                    'order_for_date_start' => $order_for_date_start,
                    'order_for_date_end' => $order_for_date_end,
                    
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' =>  $this->input->post('email'),
       
                                                            
                    'ticket_id' =>$tickets_id[$key],
                    'ticket_quantity' =>$ticket_qty,
                    'ticket_type' => $ticket_detail->paid_free,
                    
                    'currency' =>  'USD',
                    'ticket_price' => $ticket_detail->ticket_price,
                    'price' => ($ticket_detail->ticket_price - $ticket_detail->website_fee), //ticket rate = ticket_price - website_fee
                    'fee' => $ticket_detail->website_fee, //wesite fee
                    
                    'referral_pay' => $referral_pay, // AFFILIATE_REFERRAL_RATE of web fee total
                    'referral_user_id' => $referral_user_id, //parent of event organizer
                    'user_referral_url_id' => $user_referral_url_id,
                    
                    'discount' => $discount,
                    'promotion_code_id' => $order->promotion_code_id,
                    
                    'event_referral_payment' => $event_referral_payment, //in total
                    'referral_event_url_id' => $referral_event_url_id,
                    
                    'payment_price' => ($ticket_detail->ticket_price - $discount), //payment by payer rate
                    'due' => ($ticket_detail->ticket_price - $discount) * $ticket_qty,
                    'paid' => 0,
                    'total' => ($ticket_detail->ticket_price - $discount) * $ticket_qty, //payment by payer  total
                                                    
                    'organizer_payment' => (($ticket_detail->ticket_price - $ticket_detail->website_fee - $discount) * $ticket_qty) -  $event_referral_payment,
                    
                    'order_date' => $this->general->get_local_time('time'),
                    'payment_status' => (strtoupper($ticket_detail->paid_free)=='FREE')?'COMPLETE':'PENDING',
                    'create_ticket' => 'no', //since its paypal, so being PENDING create ticket 
                    'bank_transaction_status'=>'no',
                    
                    'transaction_method'=> 'BANK',
                    'bank_transaction_id'=> $bank_trans_id,
                    'check_in' => 0,                    
            );
            $result = $this->db->insert('event_ticket_order', $array_data);
            $ticket_order_id = $this->db->insert_id();    
            //$this->make_myticket($ticket_order_id);   //create ticket
            $this->db->query("UPDATE `es_event_ticket` SET `ticket_used` = ticket_used + $ticket_qty WHERE `id` = '$tickets_id[$key]'");
            
        endforeach;        
        /*insert order from temp cart end*/
        
        if($order->promotion_code_id != 0)
            $this->db->query("UPDATE `es_promotional_code` SET `used` = used + 1 WHERE `id` = '$order->promotion_code_id'");
               
        
        if(!empty($referral_event_url_id)){            
            delete_cookie(SESSION."referral_event_url_id");    
        }
                
                
        return true;        
    }
    
    public function get_paypal_details($paypal_info_id)
    {
        $query = $this->db->get_where('paypal_info',array("id "=>$paypal_info_id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
    }
    
    public function get_bank_details($bank_transaction_id)
    {
        $query = $this->db->get_where('bank_transaction',array("id "=>$bank_transaction_id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
    }
    
    public function insert_free_ticket_payment_order($event_id,$order_id,$token_id,$temp_cart_id)
    {
        $id = $event_id;
        /*user details start*/
        if($this->session->userdata(SESSION.'user_id')){
            $user_id = $this->session->userdata(SESSION.'user_id');
            //$this->update_existing_user_detail($user_id,'free'); //update existing user details
        }else{//insert user fields            
            $user_id = $this->register_new_user_free();
            if(!$user_id){   
                $this->session->set_flashdata('message',$this->language->line('order_failure_msg'));
                redirect(site_url('event/view/'.$id));
            }else{
                $this->make_login($user_id); 
            }                            
        }   
        /*user details end*/
        
        /*get order from temp cart start*/
        $order = $this->event_model->get_temp_cart_detail($event_id,$order_id,$token_id,$temp_cart_id);
        if(!$order)
        {
            $this->session->set_flashdata('message',$this->language->line('order_failure_msg'));
            redirect(site_url('event/view/'.$event_id));
        }
        
        
        $tickets_no = explode(',',$order->ticket_quantity);                     
        $tickets_id = explode(',',$order->ticket_id);
                        
        $grand_total = 0;
        $total_discount = 0;
        $discount = 0;
        $discount_per = 0;
        if($order->promotion_code_id != 0)
        {
            $discount_per = $order->discount;
        }
        /*/for order dates, get_for_date_in_event_byid start */
        $data_event = $this->get_for_date_in_event_byid($id);
        if($data_event->date_id !='0')
            $date_attendings = explode(',',$order->date_time);
        if($data_event->date_id =='0'){ 
            $order_for_date_start = date('Y-m-d H:i:s',strtotime($data_event->start_date)) ; 
        }else{ 
            $order_for_date_start = date('Y-m-d H:i:s',strtotime($date_attendings[0])) ;
        }
        if($data_event->date_id =='0'){ 
            $order_for_date_end = date('Y-m-d H:i:s',strtotime($data_event->end_date)) ; 
        }else{ 
            $order_for_date_end = date('Y-m-d H:i:s',strtotime($date_attendings[1])) ;
        }
        /*/for order dates, get_for_date_in_event_byid end*/  
        
        /*affilate initialize part start*/
        $referral_event_url_id = ($this->input->cookie(SESSION."referral_event_url_id")) ? $this->input->cookie(SESSION."referral_event_url_id") : 0; 
        $referral_user = $this->get_parent_id_from_event_id($id);
        $referral_user_id =   $referral_user->referral_id;
        $user_referral_url_id = $referral_user->referral_url_id;
        
        /*affilate initialize part end*/
        
        //credit card expirtation date
        $temp_date = $this->input->post('year')."-".$this->input->post('month');;
        $expiration_date = date('Y-m-d', strtotime($temp_date));
        
        $jsn_order_form = json_encode($_POST);
              
        foreach($tickets_no as $key=>$ticket_qty):            
            if($ticket_qty=='')
                continue;                      
            
            $ticket_detail = $this->event_model->get_ticket_detail_from_id($tickets_id[$key]);
            $discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee) * $discount_per / 100, 2, '.', '');
            
            //for order form details            
            $ar_order_form_detail = json_decode($jsn_order_form, TRUE);           
            $tic_id = $tickets_id[$key];
            $tic_id = "a".$tic_id;
            
            $array_data = array(
                    'user_id' => $user_id,
                    'event_id' =>$id, 
                    'order_id' =>$order_id,
                    'order_form_detail'=>json_encode($ar_order_form_detail[$tic_id]),
                    'order_for_date_start' => $order_for_date_start,
                    'order_for_date_end' => $order_for_date_end,
                    
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'email' =>  $this->input->post('email'),
       
//                    'billing_address' =>$this->input->post('billing_address',TRUE),
//                    'billing_address2' =>$this->input->post('billing_address2',TRUE),
//                    'billing_city'=>$this->input->post('billing_city',TRUE),
//                    'billing_state' =>$this->input->post('billing_state',TRUE),
//                    'billing_postal_code' => $this->input->post('billing_postal_code',TRUE),
//                    'billing_country' =>$this->input->post('billing_country',TRUE),
                        
                                                            
                    'ticket_id' =>$tickets_id[$key],
                    'ticket_quantity' =>$ticket_qty,
                    'ticket_type' => $ticket_detail->paid_free,
                    
                    'currency' =>  'USD',
                    'ticket_price' => $ticket_detail->ticket_price,
                    'price' => ($ticket_detail->ticket_price - $ticket_detail->website_fee), //actual price without webfee
                    'fee' => $ticket_detail->website_fee, //wesite fee
                    'referral_pay' => 0, //define later when payment status is COMPLETE by ADMIN
                    'referral_user_id' => $referral_user_id, //parent of event organizer
                    'user_referral_url_id' => $user_referral_url_id,
                    
                    'discount' => 0,
                    'promotion_code_id' => $order->promotion_code_id,
                    'net_actual_price' => 0, //net price after reducing discount in PRICE(actual price)
                    'event_referral_payment' => 0, //define later when payment status is COMPLETE by ADMIN
                    'referral_event_url_id' => $referral_event_url_id,
                    'payment_price' => 0, //net_actual_price PLUS web_fee
                    'due' => 0,
                    'paid' => 0,
                    'total' => 0,
                                                    
                    'order_date' => $this->general->get_local_time('time'),
                    'payment_status' => 'COMPLETE',
                    'create_ticket' => 'yes', //since its paypal, so being PENDING create ticket 
                    
                    
                    'transaction_method'=> 'FREE',                   
                    'check_in' => 0,                    
            );
            $result = $this->db->insert('event_ticket_order', $array_data);
            $ticket_order_id = $this->db->insert_id();    
            $this->make_myticket($ticket_order_id);   //create ticket
            $this->db->query("UPDATE `es_event_ticket` SET `ticket_used` = ticket_used + $ticket_qty WHERE `id` = '$tickets_id[$key]'");
            
        endforeach;        
        /*insert order from temp cart end*/
        
        if($order->promotion_code_id != 0)
            $this->db->query("UPDATE `es_promotional_code` SET `used` = used + 1 WHERE `id` = '$order->promotion_code_id'");
               
        
        if(!empty($referral_event_url_id)){            
            delete_cookie(SESSION."referral_event_url_id");    
        }
                
                
        return true;        
    }
    
    public function get_event_referral_percent_from_event($event_id)
    {
        $this->db->select('affiliate_referral_rate');
        $this->db->from('event');        
        $this->db->where("id = '$event_id'");        
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
            $row = $query->row();  
            return $row->affiliate_referral_rate;
		} 
		return false;
    }
    function insert_bank_transation(){
        $data_array=array(
            'bank_name_from'=>'',
            'transaction_id'=>'',
            'account_number'=>'',
            'account_holder_name'=>'',
            'amount' => '0.00',
            'bank_name_to' =>''
        );
        $this->db->insert('es_bank_transaction',$data_array);
        return $this->db->insert_id();
    }
    function send_mail_to_buyer($order_id){
        $this->load->model('email_model');	
        $user_emails = $this->session->userdata(SESSION.'email');
            if($user_emails){
                 $template = $this->email_model->get_email_template("buyer-ticket-notification");
            //echo $this->db->last_query();
            //exit;
                //print_r($template);
                $subject = $template['subject'];
                $emailbody = $template['email_body'];
            
            if(isset($subject) && isset($emailbody))
    		{
               $this->load->library('email');
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
    			//parse email
    	
    			
    	
    					$parseElement=array("EMAIL"=>$user_emails,
    										"ORDER_NUMBER"=>'<a href="'.  site_url().'/myticket/view/'.$order_id.'" >'.$order_id.'</a>',
    																			
    										"SITENAME"=>ROOT_SITE_PATH);
    	
    					$subject=$this->email_model->parse_email($parseElement,$subject);
    					$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
    					$emaillss=$this->input->get('from_email');
    			//set the email things
                                        
    			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
    			$this->email->to($user_emails); 
    			$this->email->subject($subject);
    			$this->email->message($emailbody); 
    			$this->email->send();
                        
    			//echo $this->email->print_debugger();exit;
                /*test email from localhost*/
//                $headers = "MIME-Version: 1.0" . "\r\n";
//                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//                $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//                
//                mail($user_emails,$subject,$emailbody,$headers); 
//                 
                }
            }
    }
    function send_mail_to_organiser($order){
        $this->load->model('email_model');	
        $this->load->model('event_model');
        $ticket_details='<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_rows_add table table-striped">
                    <tr>                            
                        <th>TYPE</th> 
                        <th>PRICE</th>
                        <th>FEE</th>                       
                        <th>QUANTITY</th>
                        <th>TOTAL</th>
                    </tr>';
                    
                    $tickets_no = explode(',',$order->ticket_quantity);                     
                    $tickets_id = explode(',',$order->ticket_id);
                    $event_id=$order->event_id;
                    $grand_total = 0;
                    $total_discount = 0;
                    $discount = 0;
                    $discount_per = 0;
                    if($order->promotion_code_id != 0)
                    {
                        $discount_per = $order->discount;
                    }
                    foreach($tickets_no as $key=>$ticket):
                        if($ticket=='')
                            continue;
                        $ticket_detail = $this->event_model->get_ticket_detail_from_id($tickets_id[$key]);
                        //$discount =  number_format(($ticket_detail->ticket_price - $ticket_detail->website_fee)* $ticket * $discount_per / 100, 2, '.', '');
                        $discount =  number_format(($ticket_detail->ticket_price)* $ticket * $discount_per / 100, 2, '.', '');
                        $ticket_details.='
                        <tr>                        
                            <td>'.ucwords($ticket_detail->name).'</td>
                            <td>'.$this->general->price($ticket_detail->ticket_price - $ticket_detail->website_fee).'</td>
                            <td>'.$this->general->price($ticket_detail->website_fee).'</td>
                            <td>'.$ticket.'</td>
                            <td>'.$this->general->price($ticket_detail->ticket_price * $ticket).'</td>
                        </tr>';
                        $grand_total += ($ticket_detail->ticket_price * $ticket); 
                        $symbol = $ticket_detail->symbol;
                        $total_discount += $discount;
                        endforeach; 
                        if($order->promotion_code_id != 0){ 
                    $ticket_details.='<tr>                       
                        <th colspan="4" align="right">AMOUNT TOTAL</th>
                        <th>'.$this->general->price($grand_total).'</th>
                    </tr>
                    <tr>                       
                        <th colspan="2" align="right">Discount Allowed</th>
                        <th colspan="2">'.$order->discount." %".'</th>
                        <th>'.'- '.$this->general->price($total_discount).'</th>
                    </tr>
                    <tr>                       
                        <th colspan="4" align="right">TOTAL AMOUNT DUE</th>
                        <th>'.$this->general->price($grand_total - $total_discount).'</th>
                    </tr>'; } else {
                   $ticket_details.= '<tr>                       
                        <th colspan="4" align="right">TOTAL AMOUNT DUE</th>
                        <th>'.$this->general->price($grand_total).'</th>
                    </tr>';}
                    $ticket_details.='</table> ';
                    
             $email_organiser=$this->get_organiser_email_from_event($event_id);  
             
             if($email_organiser){
                  $template = $this->email_model->get_email_template("organiser-ticket-notification");
            //echo $this->db->last_query();
            //exit;
                //print_r($template);
             
                $subject = $template['subject'];
                $emailbody = $template['email_body'];
            
            if(isset($subject) && isset($emailbody))
    		{
               $this->load->library('email');
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
    			//parse email
    	
    			
    	
    					$parseElement=array("EMAIL"=>$email_organiser,
    										"TICKET_DETAILS"=>$ticket_details,    																			
    										"SITENAME"=>ROOT_SITE_PATH);
    	
    					$subject=$this->email_model->parse_email($parseElement,$subject);
    					$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
    					$emaillss=$this->input->get('from_email');
    			//set the email things
                                        
    			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
    			$this->email->to($email_organiser); 
    			$this->email->subject($subject);
    			$this->email->message($emailbody); 
    			$this->email->send();
                        
    			//echo $this->email->print_debugger();exit;
                /*test email from localhost*/
//                $headers = "MIME-Version: 1.0" . "\r\n";
//                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//                $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//                
//                mail($email_organiser,$subject,$emailbody,$headers); 
//                 
                }
             }
        
    }
    function get_organiser_email_from_event($event_id){
        $this->db->where('id',$event_id);
        $organizer_id=$this->db->get('es_event')->row()->organizer_id;
        $this->db->where('id',$organizer_id);
        return $this->db->get('es_user')->row()->email;
        
    }
    
    function order_already_exits($user_id,$event_id, $order_id)
    {   
        $this->db->where('user_id',$user_id);
        $this->db->where('event_id',$event_id);
        $this->db->where('order_id',$order_id);
        $this->db->from('event_ticket_order');
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if($query->num_rows() >0){           
            $res = $query->row();
            return $res->id;
        }
        else
            return FALSE;
    }
    
 }