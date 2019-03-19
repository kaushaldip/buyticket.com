<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
		/*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
        
		//load module
		$this->load->model('front_help');
	}
	
	public function index()
	{		
		
		$this->data['helps'] = $this->front_help->get_all_help();
		
		//set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'help';
        
        /*new added for buytickat*/
        $this->data['main_event_types'] = $this->general->get_event_type_lists("main","5");
        $this->data['banner'] = 'yes';
        /*new added for buytickat*/
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('help_body', $this->data);	
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */