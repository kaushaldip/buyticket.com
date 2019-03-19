<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        if (SITE_STATUS == 'offline') {
            redirect(site_url('offline'));
            exit;
        }

        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');


		//load module
		$this->load->model('page_module');


    }

    public function index($cms_slug)
    {
        $cms = $this->data['cms'] = $this->page_module->get_cms($cms_slug);
        //set SEO data
        $this->page_title = isset($this->data['cms']->page_title) ? $this->data['cms']->
            page_title : DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = isset($this->data['cms']->meta_keys) ? $this->data['cms']->
            meta_keys : DEFAULT_META_KEYS;
        $this->data['meta_desc'] = isset($this->data['cms']->meta_desc) ? $this->data['cms']->
            meta_desc : DEFAULT_META_DESC;
        $this->data['nav'] = $cms_slug;
        $this->data['cms_slug'] = $cms_slug;
        
        /*new added for buytickat*/
        $this->data['main_event_types'] = $this->general->get_event_type_lists("main","5");
        $this->data['banner'] = 'yes';
        /*new added for buytickat*/

        if ($cms_slug == 'refund-policy') {
            $this->template->enable_parser(false)->title(SITE_NAME . $cms_slug)->build('body',
                $this->data);
            //exit;
        } else {
           
                $this->template->set_layout('general')->enable_parser(false)->title($this->
                page_title)->build('body', $this->data);
           

        }


    }

    function sitemap()
    {
        $this->load->model('category/category');
        $this->data['cms'] = $this->general->get_cms_lists();
        $this->data['event'] = $this->general->get_event_list_for_sitemap();
        $this->data['type'] = $this->general->get_event_type_lists();
        $this->data['cat'] = $this->category->get_only_category_lists();
        $this->data['page_arr'] = array(
            'login',
            'event',
            'register',
            'rss',
            'help/index',
            'users/login/forgot',
            'event?location=1',
            'event?time=1',
            'event?time=today',
            'event?time=tomorrow',
            'event?time=week',
            'event?time=month',
            'event?time=months',
            'event?price=1',
            'event?price=paid',
            'event?price=free',
            'event?gender=1',
            'event?gender=both',
            'event?gender=male',
            'event?gender=female',
            'event?type=1');

        $this->data['navigation'] = '';
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;

        $this->template->enable_parser(false)->title($this->page_title)->build('sitemap',
            $this->data);
    }
    function rss_()
    {
        $this->data['country'] = $this->general->get_country_lists();
        $this->data['navigation'] = '';
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;

        $this->template->enable_parser(false)->set_layout('general')->title($this->
            page_title)->build('rss', $this->data);
    }
    function rss_action()
    {
        $country = $this->input->post('country');

        redirect('rss_country/' . $country);
        exit;
    }
    function rss_country($country)
    {

        // $country=$this->input->post('country');
        $this->data['country'] = $country;
        $this->data['country_feed'] = $this->general->get_countryevent_lists($country);
        $this->data['navigation'] = '';
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->template->enable_parser(false)->title($this->page_title)->build('rss_details',
            $this->data);


    }
    function rss_country_d($c)
    {
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->template->enable_parser(false)->title($this->page_title)->build('rss_details',
            $this->data);
    }
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
