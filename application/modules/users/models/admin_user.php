<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_user extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public $validate_user =  array(			
			array('field' => 'cms_slug', 'label' => 'CMS Slug', 'rules' => 'required'),
			array('field' => 'headtext', 'label' => 'Heading', 'rules' => 'required'),
			array('field' => 'content', 'label' => 'Content', 'rules' => 'required'),
			//array('field' => 'page_title', 'label' => 'Page Title', 'rules' => 'required'),
			//array('field' => 'meta_key', 'label' => 'Meta Key', 'rules' => 'required'),
			//array('field' => 'meta_description', 'label' => 'Meta Description', 'rules' => 'required')
		);
		
		
	public function get_user_lists()
	{	
                $this->db->where('organizer','0');
				$this->db->order_by('id','DESC');
		$query = $this->db->get('user');
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
    
    public function get_organizer_lists()
    {
        		 $this->db->where('organizer','1');
                 $this->db->or_where('organizer','2');
                 $this->db->order_by('id','DESC');
		$query = $this->db->get('user');
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
    }
    public function get_user_byID($id)
    {       
            $this->db->select('u.id as uid,u.*, ud.*');
    		$this->db->from('user u');
    		$this->db->join('user_detail ud','u.id=ud.user_id','left');
    		
    		$this->db->where('u.id', $id);
                    		
        $query = $this->db->get();
                               
        //echo $this->db->last_query();exit;	   
		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
    }
	
    public function get_username($user_id)
    {        
        $this->db->select('username');
        $this->db->where('id',$user_id);
        $query  = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $user =  $query->row();
            return $user->username;
        }
        return false;
    }
    
    public function count_user_refrees($user_id)
    {
        $this->db->select("COUNT(referral_id) as total");
        $this->db->where("referral_id = '$user_id'");
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $user = $query->row();
            return $user->total;
        }
        return "0";
    }
    public function list_user_refrees($user_id)
    {
        $this->db->select("username");
        $this->db->where("referral_id = '$user_id'");
        $query = $this->db->get('user');
        if($query->num_rows() > 0)
        {
            $user = $query->result();
            $refree ='';
            foreach($user as $u)
            {
                $refree .= $u->username."\n";
            }            
            return $refree;
        }
        return false;
    }
	public function update_site_settings()
	{
		$data = array(
               'heading' => $this->input->post('headtext', TRUE),               
			   'cms_slug' => $this->general->clean_url($this->input->post('cms_slug', TRUE)),
			    'content' => $this->input->post('content', TRUE),
			   'page_title' => $this->input->post('page_title', TRUE),
			   'meta_key' => $this->input->post('meta_key', TRUE),
			   'meta_description' => $this->input->post('meta_description', TRUE),
			   'is_display' => $this->input->post('status', TRUE),
			   'last_update' => $this->general->get_local_time('time')
            );
		
		$id = $this->uri->segment(3);
		$this->db->where('id', $id);
		$this->db->update('cms', $data); 
	}
	
    public function send_reset_password_email($user_id,$password)
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
		$template=$this->email_model->get_email_template("reset-user-password");
		
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
									"PASSWORD"=>$password,
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
	public function get_administrator_lists()
	{	                
				$this->db->order_by('id','DESC');
		$query = $this->db->get('admin_users');
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
    public function get_admin_user($id)
    {	        
		$query = $this->db->get_where('admin_users',array('id'=>$id));
        
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
    
    public function add_admin_user()
    {
        $data = array(
               'user_name' => $this->input->post('user_name', TRUE),
               'email' => $this->input->post('email', TRUE),
               'password' => md5($this->input->post('password', TRUE)),               
			   'type' => strtoupper($this->input->post('type', TRUE)),
            );
				
		$this->db->insert('admin_users', $data);
    }
    
    public function edit_admin_user($id,$password)
    {
        
        $data = array(
               'user_name' => $this->input->post('user_name', TRUE),
               'email' => $this->input->post('email', TRUE),
               'password' => $password,               
			   'type' => strtoupper($this->input->post('type', TRUE)),
            );
		$this->db->where('id', $id);		
		$this->db->update('admin_users',$data);        
    }
    
    public function send_approve_organizer($user_id)
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
		$template=$this->email_model->get_email_template("approve-organzier");
		
        if($template)
        {
            
            $this->db->select('email'); 
            $query = $this->db->get_where('user',array('id'=>$user_id));
            $user = $query->row();
            
            
            $useremail = $user->email;
            
               
                $subject = $template['subject'];
                $emailbody = $template['email_body'];
            
    		
    		//check blank valude before send message
    		if(isset($subject) && isset($emailbody))
    		{   
                $link = "<a href='".site_url("organizer/approve_organizer")."'>Go to event management page.</a>";    		  
				$parseElement=array("EMAIL"=>$useremail,
									"LINK"=>$link,
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
    
    public function get_organizer_info($organizer_id)
    {
        $this->db->select('email, organizer_name, organizer_official_doc, organizer_description, organizer_home_number,organizer_office_number');
        $this->db->from('user');
        $this->db->where("id = '".$organizer_id."'");     
        $this->db->limit('1');   
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) 
		{
			return $query->row();          
            			
		}else
            return false;
    }
   
	

}
