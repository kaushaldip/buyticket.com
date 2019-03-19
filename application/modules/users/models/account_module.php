<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_module extends CI_Model 
{

	public $validate_settings =  array(	
    //Array ( [prefix] => mr [first_name] => sudeep [last_name] => bagale [email] => sudeep777@gmail.com [home_number] => 121212 [mobile_number] => 12122 [address] => 1212 [address1] => 1212 [city] => 2112 [province] => 121 [zip] => 2121 [country] => 121212 [work_job_title] => 1212 [work_company] => 121 [work_address] => 121 [work_city] => 1221 [work_state] => 121 [work_zip] => 1212 [work_country] => 1212 [work_website] => 12 [email_update_notify] => 0 [email_event_notify] => 1 ) 
			array('field' => 'prefix', 'label' => 'Prefix', 'rules' => 'trim'),
            array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'trim|required'),
			array('field' => 'last_name', 'label' => 'Last Name', 'rules' => 'trim|required'),			
			array('field' => 'email', 'label' => 'Email Address', 'rules' => 'trim|required|valid_email|callback_check_email_check'),			
            array('field' => 'home_number', 'rules' => 'trim'),
            array('field' => 'mobile_number', 'rules' => 'trim'),			
			array('field' => 'address', 'label' => 'Address', 'rules' => 'trim|required'),
            array('field' => 'address1', 'rules' => 'trim'),            
			array('field' => 'city', 'label' => 'City Name', 'rules' => 'trim|required'),
            
            
            array('field' => 'province', 'rules' => 'trim'),
            array('field' => 'zip', 'rules' => 'trim'),
            array('field' => 'country', 'label' => 'Country', 'rules' => 'required'),
            array('field' => 'work_job_title', 'rules' => 'trim'),            
            array('field' => 'work_company', 'rules' => 'trim'),
            array('field' => 'work_address', 'rules' => 'trim'),
            array('field' => 'work_city', 'rules' => 'trim'),
            array('field' => 'work_state', 'rules' => 'trim'),            
            array('field' => 'work_zip', 'rules' => 'trim'),
            array('field' => 'work_country', 'rules' => 'trim'),
            array('field' => 'work_website', 'rules' => 'trim|prep_url'),
            
            array('field' => 'email_update_notify', 'rules' => 'trim'),
            array('field' => 'email_event_notify', 'rules' => 'trim'),
		);

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	
	public function file_settings_do_upload($file)
	{
				$config['upload_path'] = './'.PROFILE_IMG_PATH;//define in constants
				$config['allowed_types'] = 'gif|jpg|png';
				$config['remove_spaces'] = TRUE;		
				$config['max_size'] = '5000';
				$config['max_width'] = '1024';
				$config['max_height'] = '1024';
				$this->upload->initialize($config);
				//print_r($_FILES);
		
		$this->upload->do_upload($file);
		if($this->upload->display_errors())
		{
			$this->error_img=$this->upload->display_errors();
			return false;
		}
		else
		{
			$data = $this->upload->data();
			return $data;
		}
					
	}
	
	public function resize_image($file_name,$thumb_name)
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = './'.PROFILE_IMG_PATH.$file_name;
		//$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 137;
		$config['height'] = 137;
		$config['new_image'] = './'.PROFILE_IMG_PATH.$thumb_name;
		
		$this->image_lib->initialize($config);
		
		$this->image_lib->resize();
		// $this->image_lib->clear(); 
		
	}
	
	public function upload_profile_image()
	{			
		//make file settins and do upload it
			$image1_name = $this->file_settings_do_upload('myfile');
			
            if ($image1_name['file_name'])
            {
				$this->image_name_path1 = $image1_name['file_name'];
				//resize image
				$this->resize_image($this->image_name_path1,'thumb_'.$image1_name['raw_name'].$image1_name['file_ext']);
				
				//update user profile image
				
				$this->db->where('id', $this->session->userdata(SESSION.'user_id'));
			 	$this->db->update('user',array('image'=>PROFILE_IMG_PATH.'thumb_'.$image1_name['raw_name'].$image1_name['file_ext']));
				$this->session->set_userdata(array(SESSION.'image' => PROFILE_IMG_PATH.'thumb_'.$image1_name['raw_name'].$image1_name['file_ext']));
				return site_url(PROFILE_IMG_PATH.'thumb_'.$image1_name['raw_name'].$image1_name['file_ext'], TRUE);
            }
            else
            {			  
               $this->session->set_flashdata('message',$this->error_img);
            }
	}
	
	public function get_user_profile_data()
	{
		//get member info based on login value
		/*for single table
        $options = array('id'=>$this->session->userdata(SESSION.'user_id') );
        $query = $this->db->get_where('user',$options);
        */
		//echo $this->db->last_query();exit;
        $this->db->select('u.id as uid,u.*, ud.*');
		$this->db->from('user u');
		$this->db->join('user_detail ud','u.id=ud.user_id','left');
		
		$this->db->where('u.id', $this->session->userdata(SESSION.'user_id'));
        $this->db->where('u.status','1');        		
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		//check valide login
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	public function update_user_profile()
	{
		//set member info
        /*
        var_dump($this->input->post());exit;
        array
        'prefix' => string 'mr' (length=2)
        'first_name' => string 'ajay' (length=4)
        'last_name' => string 'yogal shrestha' (length=14)
        'gender' => string 'm' (length=1)
        'email' => string 'esajayyogal@gmail.com' (length=21)
        'home_number' => string '9851139958' (length=10)
        'mobile_number' => string '9841844058' (length=10)
        'address' => string 'chabahil' (length=8)
        'address1' => string 'ason' (length=4)
        'city' => string 'kathmandu' (length=9)
        'province' => string 'bagmati' (length=7)
        'zip' => string '00977' (length=5)
        'country' => string 'nepal' (length=5)
        'work_job_title' => string 'Sr. PHP Developer' (length=17)
        'work_company' => string 'esignature' (length=10)
        'work_address' => string 'tangal' (length=6)
        'work_city' => string 'kathmandu' (length=9)
        'work_state' => string 'bagmati' (length=7)
        'work_country' => string 'nepal' (length=5)
        'work_website' => string 'http://www.esignature.com' (length=25)
        'email_update_notify' => string '1' (length=1)
        'email_event_notify' => string '1' (length=1)
         
		$data = array(		
                'prefix' => $this->input->post('prefix', TRUE),                	   
                'first_name' => $this->input->post('first_name', TRUE),			   
                'last_name' => $this->input->post('last_name', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'email' => $this->input->post('email', TRUE),
                'home_number' => $this->input->post('home_number', TRUE),
                'mobile_number' => $this->input->post('mobile_number', TRUE),
                'address' => $this->input->post('address', TRUE),
                'address1' => $this->input->post('address1', TRUE),
                'city' => $this->input->post('city', TRUE),
                'state' => $this->input->post('province', TRUE),
                'zip' => $this->input->post('zip', TRUE),			  
                'country' => $this->input->post('country', TRUE),
                'work_job_title' => $this->input->post('work_job_title', TRUE),
                'work_company' => $this->input->post('work_company', TRUE),
                'work_address' => $this->input->post('work_address', TRUE),
                'work_city' => $this->input->post('work_city', TRUE),
                'work_state' => $this->input->post('work_state', TRUE),
                'work_country' => $this->input->post('work_country', TRUE),
                'work_website' => $this->input->post('work_website', TRUE),
                'email_update_notify' => $this->input->post('email_update_notify', TRUE),
                'email_event_notify' => $this->input->post('email_event_notify', TRUE),                      			   
                'last_modify_date' => $this->general->get_local_time('time')			   
            );
            */
			//print_r($this->input->post());
            //Array ( [prefix] => mr [first_name] => sudeep [last_name] => bagale [email] => sudeep77@gmail.com [home_number] => 9851139958 [mobile_number] => 9841844058 [address] => kathmandu [address1] => ason [city] => kathmandu [province] => bagmati [zip] => 75240 [country] => nepal [work_job_title] => FB developer [work_company] => esignature [work_address] => tangal [work_city] => kathmandu [work_state] => bagmati [work_zip] => 0044 [work_country] => india [work_website] => http://www.esignature.com [email_update_notify] => 0 [email_event_notify] => 1 ) 
			//insert records in the database            
            $data1 = array(
                    'prefix'=>$this->input->post('prefix',TRUE),
                    'first_name' =>$this->input->post('first_name',TRUE),
                    'last_name' => $this->input->post('last_name',TRUE),                    
                    'email_update_notify'=>$this->input->post('email_update_notify',TRUE),
                    'email_event_notify'=>$this->input->post('email_event_notify',TRUE),
                    'last_modify_date'=>$this->general->get_local_time('time'),
                'bank_name'=>$this->input->post('bank_name',TRUE),
                'account_number'=>$this->input->post('account_number',TRUE),
                'account_holder_name'=>$this->input->post('account_holder_name',TRUE),
                'western_payee_name'=>$this->input->post('western_payee_name',TRUE),
                'western_city'=>$this->input->post('western_city',TRUE),
                'western_country'=>$this->input->post('western_country',TRUE)
            );
            $this->db->where("id", $this->session->userdata(SESSION.'user_id'));            
            $this->db->update("user",$data1);
            
            $data2 = array(
                    'gender' => $this->input->post('gender',TRUE),
                    'home_number' =>$this->input->post('home_number',TRUE),
                    'mobile_number' =>$this->input->post('mobile_number',TRUE),
                    'address' =>$this->input->post('address',TRUE),
                    'address1' =>$this->input->post('address1',TRUE),
                    'city'=>$this->input->post('city',TRUE),
                    'state' =>$this->input->post('state',TRUE),
                    'zip' => $this->input->post('zip',TRUE),
                    'country' =>$this->input->post('country',TRUE),
                    'work_job_title' =>$this->input->post('work_job_title',TRUE),
                    'work_company' => $this->input->post('work_company',TRUE),
                    'work_address' =>$this->input->post('work_address',TRUE),
                    'work_city'=>$this->input->post('work_city',TRUE),
                    'work_state'=>$this->input->post('work_state',TRUE),
                    'work_zip' =>$this->input->post('work_zip',TRUE),
                    'work_country'=>$this->input->post('work_country',TRUE),
                    'work_website'=>$this->input->post('work_website',TRUE),
                    
            );
            $this->db->where("user_id", $this->session->userdata(SESSION.'user_id'));            
            $r = $this->db->update("user_detail",$data2);
            
            if($r)
                return true;
            /*
            $this->db->set("prefix",$this->input->post('prefix',TRUE));
            $this->db->set('first_name',$this->input->post('first_name',TRUE));            
            $this->db->set('last_name',$this->input->post('last_name',TRUE));
            $this->db->set('gender',$this->input->post('gender',TRUE));
                        
            $this->db->set('email',$this->input->post('email',TRUE));
            $this->db->set('home_number',$this->input->post('home_number',TRUE));
            $this->db->set('mobile_number',$this->input->post('mobile_number',TRUE));
            $this->db->set('address',$this->input->post('address',TRUE));
            $this->db->set('address1',$this->input->post('address1',TRUE));
            $this->db->set('city',$this->input->post('city',TRUE));
            $this->db->set('state',$this->input->post('province',TRUE));
            $this->db->set('zip',$this->input->post('zip',TRUE));
            $this->db->set('country',$this->input->post('country',TRUE));
            
            $this->db->set('work_job_title',$this->input->post('work_job_title',TRUE));
            $this->db->set('work_company',$this->input->post('work_company',TRUE));
            $this->db->set('work_address',$this->input->post('work_address',TRUE));
            $this->db->set('work_city',$this->input->post('work_city',TRUE));
            $this->db->set('work_state',$this->input->post('work_state',TRUE));
            $this->db->set('work_zip',$this->input->post('work_zip',TRUE));
            $this->db->set('work_country',$this->input->post('work_country',TRUE));
            $this->db->set('work_website',$this->input->post('work_website',TRUE));
            $this->db->set('email_update_notify',$this->input->post('email_update_notify',TRUE));
            $this->db->set('email_event_notify',$this->input->post('email_event_notify',TRUE));
            $this->db->set('last_modify_date',$this->general->get_local_time('time'));
            
			$this->db->where("user_id", $this->session->userdata(SESSION.'user_id'));
            $this->db->where("user.id = es_user_detail.user_id");
            $this->db->update("user , es_user_detail");	
            */
            //$this->db->last_query();exit;		
	}
	
    public function mail_update_user_profile($user_id)
    {
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
		$template=$this->email_model->get_email_template("edit-profile");
		
        if($template)
        {
            
            $this->db->select('username,email'); 
            $query = $this->db->get_where('user',array('id'=>$user_id));
            $user = $query->row();
            
            $username = $user->username;
            $useremail = $user->email;
            
               
                $subject = $template['subject'];
                $emailbody = $template['email_body'];
            
    		//check blank valude before send message
    		if(isset($subject) && isset($emailbody))
    		{    			
				$account_link ="<a href= '".site_url("users/account/index")."'>account link</a>" ;
                $parseElement=array("USERNAME"=>$username,
									"ACCOUNT_LINK"=>$account_link,
									"SITENAME"=>SITE_NAME,
									);

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
                //echo $emailbody;exit;					
    			//set the email things
    			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
    			$this->email->to($useremail); 
    			$this->email->subject($subject);
    			$this->email->message($emailbody); 
    			$this->email->send();
                
                /*test email from localhost*/
//                $headers = "MIME-Version: 1.0" . "\r\n";
//                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//                $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//                mail($useremail,$subject,$emailbody,$headers);        
                /*test email from localhost*/
 			    //echo $this->email->print_debugger();exit;
    		}
        }
    }
    
	public function get_aleady_registered_email()
	{
		$this->db->where('email',$this->input->post('email'));
		$this->db->where('id !=',$this->session->userdata(SESSION.'user_id'));
		$query = $this->db->get('user');
			
		if($query->num_rows()>0)
			return TRUE;
		else return NULL;
	}
	
	public function update_new_email_confirmation_email($profile)
	{
	   //var_dump($profile);exit;
		$activation_code = $this->general->random_number();
		//set member info
		$data = array('email_alternate' => $this->input->post('email', TRUE),'activation_code'=>$activation_code);
			
			 //insert records in the database
			 $this->db->where('id', $this->session->userdata(SESSION.'user_id'));
			 $this->db->update('user',$data);
		
		//send email confirm to user
		
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
		$template=$this->email_model->get_email_template("email_confirmation");
		
            $subject = $template['subject'];
            $emailbody = $template['email_body'];
        
		
		//check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{
			//parse email			
			$confirm="<a href='".site_url('users/account/activation/email/'.$activation_code.'/'.$profile->uid)."'>Confirm Your Email</a>";
	
					$parseElement=array("USERNAME"=>$profile->email,
										"CONFIRM"=>$confirm,
										"SITENAME"=>SITE_NAME,
										"EMAIL"=>$this->input->post('email'),									
										"FIRSTNAME"=>$this->input->post('firstname'));
	
					$subject=$this->email_model->parse_email($parseElement,$subject);
					$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
					
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($this->input->post('email', TRUE)); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
            /*test email from localhost*/
 //           $headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
            //mail($this->input->post('email', TRUE),$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
		
	}
	public function mail_close_account($user_id)
    {
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
		$template=$this->email_model->get_email_template("account_closed_notification_admin");
		
        if($template)
        {
            
            $this->db->select('username,email'); 
            $query = $this->db->get_where('user',array('id'=>$user_id));
            $user = $query->row();
            
            $username = $user->username;
            $useremail = $user->email;
            
               
            
                $subject = $template['subject'];
                $emailbody = $template['email_body'];
    		
    		//check blank valude before send message
    		if(isset($subject) && isset($emailbody))
    		{    			
				$parseElement=array("USERNAME"=>$username,									
									"SITENAME"=>SITE_NAME,
									);

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
                //echo $emailbody;exit;					
    			//set the email things
    			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
    			$this->email->to($useremail); 
    			$this->email->subject($subject);
    			$this->email->message($emailbody); 
    			$this->email->send();
                
                /*test email from localhost*/
               // $headers = "MIME-Version: 1.0" . "\r\n";
//                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//                $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//                mail($useremail,$subject,$emailbody,$headers);        
                /*test email from localhost*/
    			//echo $this->email->print_debugger();exit;
    		}
        }
    }
    
	public function check_old_password()
	{
		$option = array('password'=>base64_encode($this->input->post('old_password')),'id'=>$this->session->userdata(SESSION.'user_id'));
		$query = $this->db->get_where('user',$option);
		return $query->num_rows();
	}
	public function change_password()
	{
		//set member info
		$data = array(
			   'password' => base64_encode($this->input->post('new_password', TRUE)),
			   'last_modify_date' => $this->general->get_local_time('time')
			   
            );
			 //insert records in the database
			 $this->db->where('id', $this->session->userdata(SESSION.'user_id'));
			 $this->db->update('user',$data);
        return true;
	}
    
    public function mail_change_password()
    {
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
		$template=$this->email_model->get_email_template("change-password");
		
        if($template)
        {
            
            $this->db->select('username,email'); 
            $query = $this->db->get_where('user',array('id'=>$this->session->userdata(SESSION.'user_id')));
            $user = $query->row();
            
            $username = $user->username;
            $new_password = $this->input->post('new_password');
            $useremail = $user->email;
            
               
                $subject = $template['subject'];
                $emailbody = $template['email_body'];
            
    		//check blank valude before send message
    		if(isset($subject) && isset($emailbody))
    		{    			
				$parseElement=array("USERNAME"=>$username,
									"PASSWORD"=>$new_password,
									"SITENAME"=>SITE_NAME,
									);

				$subject=$this->email_model->parse_email($parseElement,$subject);
				$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
                //echo $emailbody;exit;					
    			//set the email things
    			$this->email->from(CONTACT_EMAIL);
    			$this->email->to($useremail); 
    			$this->email->subject($subject);
    			$this->email->message($emailbody); 
    			$this->email->send();
                
                /*test email from localhost*/
//                $headers = "MIME-Version: 1.0" . "\r\n";
//                $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//                $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//                mail($useremail,$subject,$emailbody,$headers);        
                /*test email from localhost*/
    			//echo $this->email->print_debugger();exit;
    		}
        }
    }

}
