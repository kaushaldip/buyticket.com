<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		// Check if User has logged in
		if (!$this->general->admin_logged_in())			
		{
			redirect(ADMIN_LOGIN_PATH, 'refresh');exit;
		}
			
		//load CI library
			$this->load->library('form_validation');	
            $this->load->library('general');
            $this->load->library('pagination');	
		//load custom module
			$this->load->model('admin_sale');
            
        $this->lang->load('english', 'english');
		
	}
	
	public function index()
	{
		if($this->uri->segment(3)) $cat_id = $this->uri->segment(3); else $cat_id = '1';
		
        $config['base_url'] = site_url(ADMIN_DASHBOARD_PATH).'/sale/index/'.$cat_id;
		$config['total_rows'] = $this->admin_sale->get_total_buyer($cat_id);
		$config['num_links'] = 10;
		$config['prev_link'] = 'Prev';
		$config['next_link'] = 'Next';
		$config['per_page'] = '30'; 
		$config['next_tag_open'] = '<span>';
		$config['next_tag_close'] = '</span>';
		$config['cur_tag_open'] = '<span>';
		$config['cur_tag_close'] = '</span>';
		$config['num_tag_open'] = '<span>';
		$config['num_tag_close'] = '</span>';		
		$config['uri_segment'] = '4';		
		$this->pagination->initialize($config); 
		
		$offset=$this->uri->segment(4,0);
        
        
        $this->data['category_result'] = $this->general->get_category_lists();
		$this->data['result_data'] = $this->admin_sale->get_buy_list($cat_id,$config['per_page'],$offset);
		//echo $this->db->last_query();exit;
        
		$this->template
			->set_layout('dashboard')
			->enable_parser(FALSE)
			->title(SITE_NAME.' - Site Settings')
			->build('sale_page', $this->data);	
		
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */