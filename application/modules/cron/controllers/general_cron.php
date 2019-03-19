<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class General_cron extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			exit;
		}
		
		$this->load->model('general_cron_model');
	}
	
	public function index()
	{
		if(!is_ajax())
	    {	       
           $sql = "DELETE FROM `es_temp_cart` WHERE `current_date` < ( NOW( ) - INTERVAL 30 MINUTE ) ";
           $query = $this->db->query($sql);
           
	    }
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */