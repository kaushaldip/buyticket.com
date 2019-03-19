<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_module extends CI_Model 
{

	public $validate_settings =  array(				
			array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
			array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required')
		);

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function check_login_process()
	{
		//get member info based on login value
		$options = array('email'=>$this->input->post('email',TRUE));
        $query = $this->db->get_where('user',$options);
		//echo $this->db->last_query();exit;
		//check valide login
		if($query->num_rows()>0)
		{
			$record = $query->row_array();
			//check active user
			if($record['status']==='1')
			{
				//re verify login info
				if($record['email']===$this->input->post('email') && $record['password']===base64_encode($this->input->post('password',TRUE)))
				{
					$user_ip = $this->general->get_real_ipaddr();
					//check blocked IP
					if($this->general->check_block_ip($user_ip)===0)
					{							
							$current_date = $this->general->get_local_time('time');
							
							$update_data = array('last_login_date'=>$current_date,'last_ip_address'=>$user_ip);
							
                            $this->db->where('id',$record['id']);
                            $this->db->update('user',$update_data);
								
							$this->session->set_userdata(array(SESSION.'user_id' => $record['id']));                             	
						    $this->session->set_userdata(array(SESSION.'email' => $record['email']));								
							$this->session->set_userdata(array(SESSION.'first_name' => $record['first_name']));								
							$this->session->set_userdata(array(SESSION.'last_name' => $record['last_name']));								
							//$this->session->set_userdata(array(SESSION.'username' => $record['username']));
                            
							$this->session->set_userdata(array(SESSION.'profile_image' => $record['image']));			
                            
                            $this->session->set_userdata(array(SESSION.'organizer' => $record['organizer']));
                            					
                            $this->session->set_userdata(array('last_login' => $this->general->date_time_formate($record['last_login_date'])));
                            // $this->session->set_userdata(array(SESSION.'session_id' => $unique_session_id));
								
								
                            if($this->input->post('remember')=='yes')
							{
                                $cookie1 = array('name' => SESSION."email",'value'  => $record['email'],'expire' => time()+3600*24*30);
								$this->input->set_cookie($cookie1);
										
								$cookie2 = array('name'   => SESSION."password",'value'  => $this->input->post('password'),'expire' => time()+3600*24*30);
								$this->input->set_cookie($cookie2);		
							}
							else
							{
                                $cookie1 = array('name'   => SESSION."email",'value'  => '','expire' => 0);
                                $this->input->set_cookie($cookie1);		
                                
                                $cookie2 = array('name'   => SESSION."password",'value'  => '','expire' => 0);
                                $this->input->set_cookie($cookie2);										
							}	
							return 'success';
							
					}
					else
					{
                        return 'blocked_ip';
					}
				}
				else
				{
				    return 'invalid';
				}
			}
			else if($record['status']==='2')
            {
            return 'unverified';
            }            
            else if($record['status']==='0')
            {
                return 'suspended';
            }
		}
		else
		{
			return 'unregistered';
		}
		
	}
	
	public function check_email()
	{
		$options = array('email'=>$this->input->post('email',TRUE));
        $query = $this->db->get_where('user',$options);
		return $query->num_rows();
	}
    
    public function check_email_activate()
    {
        $options = array(
                'email'=>$this->input->post('email',TRUE),
                'closed_account'=>'yes',
                'status'=>'0',
                );
        $query = $this->db->get_where('user',$options);
		return $query->num_rows();
    }
	
    public function change_activate_code()
    {
        $options = array(
                'activation_code'=> $this->general->random_number(),                
                );
        $this->db->where('email',$this->input->post('email',TRUE));
        $query = $this->db->update('user',$options);        
    }
	
	public function forget_password_reminder_email()
	{
		$options = array('email'=>$this->input->post('email',TRUE));
        $query = $this->db->get_where('user',$options);
		$row = $query->row();
		
		$user_name = $row->email;
		$password = base64_decode($row->password);
		$first_name = $row->first_name;
		//$lang_id = $row->lang_id;
		
		
		
		//load email library
    	$this->load->library('email');
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
			
					
		$this->load->model('email_model');		
		
		//get subjet & body
		$template=$this->email_model->get_email_template("forgot_password_notification");
		
		if(!isset($template['subject']))
		{
			$template=$this->email_model->get_email_template("forgot_password_notification",DEFAULT_LANG_ID);
		}

            $subject = $template['subject'];
            $emailbody = $template['email_body'];
        
		
		//check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{
		
			//parse email
	
	
					$parseElement=array("USERNAME"=>$user_name,
										"SITENAME"=>SITE_NAME,
										"EMAIL"=>strtolower($this->input->post('email')),									
										"FIRSTNAME"=>$first_name,
										"PASSWORD"=>$password);
	
					$subject=$this->email_model->parse_email($parseElement,$subject);
					$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
					
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($this->input->post('email', TRUE)); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
            /*test email from localhost*/
//            $headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            mail($this->input->post('email'),$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
	}
	
	public function get_fb_user($email) 
	{		
		$query = $this->db->select('is_fb_user')
						  ->where('email', $email)
						  ->where('status', 'active')						  
				 	      ->get('members');
						  
		if($query->num_rows()>0) 
		{ 
			$result = $query->row();
			if ($result->is_fb_user == 'Yes')
			{ 
				return 'success';
			}
			else 
			{
				return 'failed';
			}
		}
		else 
			{
				return 'failed';
			}
		
	}
    
    public function activate_account_email()
    {
		$options = array('email'=>$this->input->post('email',TRUE));
        $query = $this->db->get_where('user',$options);
		$row = $query->row();
		
		$user_name = $row->email;
        $activation_code = $row->activation_code;
        $user_id = $row->id;
	
		//load email library
    	$this->load->library('email');
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
			
					
		$this->load->model('email_model');		
		
		//get subjet & body
		$template=$this->email_model->get_email_template("activate-account");
	
            $subject = $template['subject'];
            $emailbody = $template['email_body'];
        
		
		//check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{
		
			//parse email
	
	       $activate_link = "<a href='".site_url('users/login/confirm_activation/'.$activation_code.'/'.md5($user_id).'/'.$user_id)."'>activation link</a>";
           
					$parseElement=array("USERNAME"=>$user_name,
										"SITENAME"=>SITE_NAME,
										"EMAIL"=>strtolower($this->input->post('email')),									
										"ACTIVATELINK"=>$activate_link,
										);
	
					$subject=$this->email_model->parse_email($parseElement,$subject);
					$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
					
			//set the email things
            //echo $emailbody;exit;
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($this->input->post('email', TRUE)); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
            /*test email from localhost*/
 //           $headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            mail($this->input->post('email'),$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
	}
    
    public function make_activate_account($activation_code,$user_md5,$user_id)
	{
		
		 $query = $this->db->get_where('user',array('activation_code'=>$activation_code,'id'=>$user_id));
		 if($query->num_rows()>0)
         {
		 		$user_data = $query->row_array();

				$user_id = $user_data['id'];
                $username = $user_data['username'];

			 	$data=array('status'=>'1','verified_email'=>'yes','closed_account'=>'no','inactive_reason'=>'');
                $this->db->where('id',$user_id);
                $this->db->update('user',$data);
				
           
				return TRUE;
		 }
	}
}
