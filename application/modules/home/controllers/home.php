<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (SITE_STATUS == 'offline') {
            redirect(site_url('offline'));
            exit;
        }
        /* converting language start */
        $this->config->set_item('language', 'en');
        $this->lang->load('english', 'english');


        //load module
        $this->load->model(array('home_module', 'event/event_search_model'));


        $this->load->helper('text');
    }


    public function index($event_type_name = '', $event_type_id = '') {
        //get event types
        //echo $this->config->item('language');
        //echo $this->config->item('language_abbr');
        
        $this->data['main_event_types'] = $this->general->get_event_type_lists("main","5");
        $this->data['event_types'] = $this->general->get_event_type_lists();
        $country = $this->general->getCountry();
        $city = $this->general->getCity();
        // removed cities
        $city="";
        $country="";
        $this->data['event_locations'] = $event_locations = $this->general->get_cities_from_country($country);
        $this->data['current_location'] = $this->general->getCurrentLocation();
        $this->data['popular_events'] = $this->event_search_model->getPopularEvents($country,$city,10,0); 
        $this->data['upcoming_events'] = $this->event_search_model->getUpcomingEvents($country,$city,10,0);
        $this->data['latest_events'] = $this->event_search_model->getLatestEvents($country,$city,10,0);

        //Get first event type if there is no event_type
        if ($event_type_id) {
            $this->data['type_id'] = $event_type_id;
        } else {
            $this->data['type_id'] = @$this->data['event_types'][0]->id;
        }

        //set SEO data        
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = '';
        $this->data['main_url'] = site_url("event/create");
        $this->data['main_button'] = $this->lang->line('get_started'); 
        $this->data['main_title'] = $this->lang->line('post_own_event');//'post your own event';

        $this->template
                ->set_layout('home')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('body', $this->data);
    }

    public function referral($event_type_name = '', $event_type_id = '') {
        //get event types
        $this->data['event_types'] = $this->general->get_event_type_lists();

        //Get first event type if there is no event_type
        if ($event_type_id) {
            $this->data['type_id'] = $event_type_id;
        } else {
            $this->data['type_id'] = @$this->data['event_types'][0]->id;
        }

        //set SEO data        
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = '';
        $this->data['main_url'] = site_url("join");
        $this->data['main_button'] = $this->lang->line("join_referral_program");
        $this->data['main_title'] = $this->lang->line('market_buyticket_make_money');
        
        $this->data['main_event_types'] = $this->general->get_event_type_lists("main","5");
        $country = $this->general->getCountry();
        $city = $this->general->getCity();
        $this->data['event_locations'] = $event_locations = $this->general->get_cities_from_country($country);


        $this->template
                ->set_layout('home')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('referral', $this->data);
    }

    public function event_affiliate($event_type_name = '', $event_type_id = '') {
        //get event types
        $this->data['event_types'] = $this->general->get_event_type_lists();

        //Get first event type if there is no event_type
        if ($event_type_id) {
            $this->data['type_id'] = $event_type_id;
        } else {
            $this->data['type_id'] = @$this->data['event_types'][0]->id;
        }

        //set SEO data        
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = '';
        $this->data['main_url'] = site_url("event/create");
        $this->data['main_button'] = $this->lang->line('join_event_affiliate_program'); 
        $this->data['main_title'] = $this->lang->line('market_event_make_money');//'post your own event';
        
        $this->data['main_event_types'] = $this->general->get_event_type_lists("main","5");
        $country = $this->general->getCountry();
        $city = $this->general->getCity();
        $this->data['event_locations'] = $event_locations = $this->general->get_cities_from_country($country);


        $this->template
                ->set_layout('home')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('event_affiliate', $this->data);
    }

    public function contact() {
        //set SEO data
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'contact';
        
        /*new added for buytickat*/
        $this->data['main_event_types'] = $this->general->get_event_type_lists("main","5");
        $this->data['banner'] = 'yes';
        /*new added for buytickat*/

        $this->template
                ->set_layout('general')
                ->enable_parser(FALSE)
                ->title($this->page_title)
                ->build('contact_us', $this->data);
    }

    public function language($code) {
        //echo $this->uri->uri_string();exit;
        if (strtolower($code) == 'ar' || strtolower($code) == 'en') {
            $this->config->set_item('language', $code);
            $this->session->set_userdata('language', $code);

            $url = $_GET['return_url'];
            redirect($url);
        } else {
            $this->session->set_userdata('message', $this->lang->line("illegal_attempt"));
            redirect(site_url());
        }
    }

    public function send_contact() {

        $emails = trim($this->input->get('from_email'));
        $name = $this->input->get('contact_name');
        $this->load->library('email');
        //configure mail
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $config['protocol'] = 'sendmail';
        $this->email->initialize($config);
        $subject = 'contact form';
        $emailbody = 'Name:- ' . $name . "<br/>";
        $emailbody.='Email:- ' . $emails . "<br/>";
        //$emailbody.='phone number:-'.$this->input->get('phone_no');
        $emailbody.='I am:- ' . $this->input->get('i_am') . "<br/>";
        $emailbody.='Message:- ' . $this->input->get('message') . "<br/>";
        $emaillss = $this->input->get('from_email');
        $this->email->from($emails, $name);
        $this->email->to(CONTACT_EMAIL);
        $this->email->subject($subject);
        $this->email->message($emailbody);
        $this->email->send();


        //$headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".$emails."" . "\r\n";
//            mail(CONTACT_EMAIL,$subject,$emailbody,$headers); 
        //print_r($_GET);   
    }

    function refund_policy($event_id) {
        if (is_ajax()) {
            //load module
            $this->load->model(array('myticket/myticket_model'));

            $this->data['refund_detail'] = $this->myticket_model->get_refund_policy_by_event($event_id);
            $this->data['event_id'] = $event_id;

            //var_dump($this->data);exit;
            $this->template->enable_parser(false)->title(SITE_NAME . "Refund policy")->build('refund_policy_by_event', $this->data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */