<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_module extends CI_Model 
{
	
	public $validate_settings =  array(			
			array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email|is_unique[user.email]'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|min_length[4]|max_length[12]'),
			array('field' => 're_password', 'label' => 'Retype Password', 'rules' => 'required|matches[password]'),            
			array('field' => 't_c', 'label' => 'Terms of Services', 'rules' => 'required')
		);

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function insert_user()
	{		
		//get random 10 numeric degit
		$activation_code = $this->general->random_number();
		$ip_address = $this->general->get_real_ipaddr();        
		$parent = (($this->input->cookie(SESSION."referral_id", TRUE)))? '1': '0';
        $referal_id = (($this->input->cookie(SESSION."referral_id", TRUE)))? $this->input->cookie(SESSION."referral_id", TRUE): '0';
        $referal_url_id = (($this->input->cookie(SESSION."referral_url_id", TRUE)))? $this->input->cookie(SESSION."referral_url_id", TRUE): '0';
		$password = base64_encode($this->input->post('password', TRUE));
        $is_referral_user = ($this->session->userdata(SESSION."is_referral_user"))? $this->session->userdata(SESSION."is_referral_user") : 'no';

		//set member info
		$data = array(			   
			   'email' => $this->input->post('email', TRUE),			   
			   'password' => $password,
			   'reg_ip_address' => $ip_address,
			   'activation_code'=>$activation_code,			   			  
			   'reg_date' => $this->general->get_local_time('time'),
               'last_modify_date' => $this->general->get_local_time('time'),
               'parent' =>$parent,
               'referral_id'=>$referal_id,
               'referral_url_id' => $referal_url_id,
			   'is_referral_user' =>$is_referral_user,
               'status' => '1',               
            );
			
		if($this->session->userdata('is_fb_user')=="Yes")
		{			
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
        $this->user_id=$this->db->insert_id();
        
        //insert records in user_detail table
        $data1 = array('user_id'=>$this->db->insert_id(),'gender'=>'');
        $this->db->insert('user_detail',$data1);
        
        
        
        //Complete Transactions
        $this->db->trans_complete();
			
		if ($this->db->trans_status() === FALSE)
		{
			return "system_error";
		}
        else
        {
        	if($this->session->userdata(SESSION."is_referral_user")=='yes')
            {
                $this->load->library('general');        	      
                $url1 = $this->general->genRandomString().$this->user_id;
                $data_url1 = array('user_id'=>$this->user_id,'referral_url'=>$url1);
                $this->db->insert('user_referral_url',$data_url1);   
        	}            
            return $activation_code;
        }
	}
	
	public function reg_confirmation_email($activation_code='', $email='',$password='')
    {        
		//load email library
    	$this->load->library(array('email','general'));        
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
			
					
		$this->load->model('email_model');		
		        
        
		//get subjet & body
		$template=$this->email_model->get_email_template("register_notification");
		
        
            $subject = $template['subject'];
            $emailbody = $template['email_body'];
        
        if($email=='')
            $email = $this->input->post('email');
        else    
            $email = $email;
            
        if($password=='')
            $password = $this->input->post('password');
        else
            $password = $password;
		
		$this->user_id = $this->general->get_id_from_email($email);
        
        //check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{
			//parse email
			
            if($activation_code=='')
                $confirm = "<a href='".site_url('login')."'>".site_url('login')."</a>";
            else
                $confirm="<a href='".site_url('/users/register/activation/'.$activation_code.'/'.$this->user_id)."'>".site_url('/users/register/activation/'.$activation_code.'/'.$this->user_id)."</a>";
              
            //echo $confirm;exit;   
					$parseElement=array("LOGINURL"=>$confirm,
                                        "CONFIRM" => $confirm,
										"SITENAME"=>SITE_NAME,
										"EMAIL"=>$email,	
                                        "USERNAME" => $email,								
										"PASSWORD"=> $password,
                                        );
	
					$subject=$this->email_model->parse_email($parseElement,$subject);
					$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
				//echo $emailbody;exit;	
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($this->input->post('email', TRUE)); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			//echo $this->email->print_debugger();exit;
            /*test email from localhost*/
           // $headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            mail($email,$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
    }
	
	public function activated($activation_code,$user_id)
	{
		
		 $query = $this->db->get_where('user',array('activation_code'=>$activation_code,'id'=>$user_id));
		 if($query->num_rows()>0)
         {
		 		$user_data = $query->row_array();

				$user_id = $user_data['id'];
                $username = $user_data['username'];
				//$referral_id = $user_data['referral_id'];
				
				//update signup bonus
			 	$data=array('status'=>'1','verified_email'=>'yes');
                $this->db->where('id',$user_id);
                $this->db->update('user',$data);
				
				//create own referral url1
                /*
                $url1 = site_url($username);
                $data_url1 = array('user_id'=>$user_id,'url'=>$url1);
                $this->db->insert('user_refferal_url',$data_url1);
                
                
                //create own referral url2
                $url2 = site_url("users/view/$user_id");
                $data_url2 = array('user_id'=>$user_id,'url'=>$url2);
                $this->db->insert('user_refferal_url',$data_url2);
                */
                
           
				return TRUE;
		 }
	}
	
	
	
	
	public function get_user_source_from()
	{		
		$data = array();
		//$this->db->order_by("user_source_from", "asc"); 
		$query = $this->db->get("user_source_from");
		if($query->num_rows() > 0) 
		{
			$data=$query->result();				
		}		
		$query->free_result();
		return $data;
	}
	
	public function get_cms($id)
	{
		
		$data = array();
		$query = $this->db->get_where("cms",array("id"=>$id));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();				
		}
			
		$query->free_result();
		return $data;
	}
	
	public function get_user_id_byusername()
	{
		$data = array();
		$query = $this->db->get_where("members",array("user_name"=>$this->session->userdata('refer_username')));
		if ($query->num_rows() > 0) 
		{
			$data=$query->row();	
			
			$query->free_result();
			return $data->id;				
		}
		
	}
}

