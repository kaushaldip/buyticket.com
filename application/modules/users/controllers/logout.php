<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(!$this->session->userdata(SESSION.'user_id'))
         {
          	redirect(site_url(''));exit;
         }

	}
	
	public function index()
	{
		$array_items = array(SESSION.'user_id' => '', SESSION.'first_name' => '', SESSION.'email' => '', SESSION.'last_name' => '', SESSION.'username' => ''
							, SESSION.'balance' => '', SESSION.'last_login' => '', SESSION.'lang_flag' => '', SESSION.'short_code' => '', SESSION.'lang_id' => '');	
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
		
		redirect(site_url());
        exit;
        //FB Logout
		$this->load->library('Facebook',$this->config->item('facebook'));
		$args['next'] = site_url('');
		$logoutUrl = $this->facebook->getLogoutUrl($args);
		//print_r($logoutUrl);exit;
		$this->facebook->destroySession();
			
		
		if($this->session->userdata('is_fb_user') == 'Yes')
			redirect($logoutUrl);
		else
			redirect(site_url(''));
		
		exit;
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */