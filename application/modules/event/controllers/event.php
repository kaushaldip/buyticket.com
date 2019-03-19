<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event extends CI_Controller
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


        if ($this->session->userdata(SESSION . 'user_id')) {
            //for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();
        }
        //load CI library
        $this->load->library('form_validation');

        //Changing the Error Delimiters
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        $this->load->library('pagination');
        //load module
        $this->load->model(array('event_model', 'event_payment_model',
            'category/category', 'affiliate/affiliate_model'));
        $this->load->helper('editor_helper');

    }

    public function index($type = '')
    {

//        header('Content-Type:text/html; charset=UTF-8');
        $keyword = $this->data['keyword1'] = $this->input->get('keywords');
        $location = $this->data['location1'] = $this->input->get('location');
        $get_city = $this->data['get_city1'] = $this->input->get('city');
        $cat = $this->data['cat1'] = $this->input->get('cat');
        $date = $this->data['date1'] = $this->input->get('time');
        $type = $this->data['type1'] = $this->input->get('type');
        $price = $this->data['price1'] = $this->input->get('price');
        $gender = $this->data['gender1'] = $this->input->get('gender');
        $all = $this->data['all1'] = $this->input->get('all');
        // $city=$this->input->get('city');
        $this->load->model('event_search_model');
        
        /*for pagination*/
        $config['base_url'] = site_url('/event/index/') ;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_links'] = 10;
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['per_page'] = '10';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['uri_segment'] = '2';
        /*for pagination*/
                                
        if ($keyword || $location || $cat || $date || $type || $price || $gender || $all || $get_city) 
        {
            $total_events = $this->data['total_events'] = $this->event_search_model->event_search($keyword, $location,$get_city, $cat, $date, $type, $price,$gender)->num_rows();            
            
            $config['total_rows'] = $total_events;
            if (count($_GET) > 0) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
            $this->pagination->initialize($config);

            $offset = $this->uri->segment(2, 0);
            
            $query =  $this->event_search_model->event_search($keyword, $location,$get_city, $cat, $date, $type, $price,$gender, $config['per_page'], $offset);            
            $this->data['events'] = ($total_events > 0)? $query->result() : false;             
            $query->free_result();
            
            
            //side bar cities list            
            $this->data['event_location'] = $event_location =$this->general->get_cities_search_module(); 
            
        } else {

            $country = $this->general->getCountry();
            $city = $this->general->getCity();
            
            $offset = $this->uri->segment(2, 0);
            
            //set pagination configuration            

            $config['total_rows'] = $total_events  = $this->event_model->get_search_event_find_loc_final('', '', $country,$country, $city,'', '');

            $this->pagination->initialize($config);

            $this->data['total_events'] = $config['total_rows'];
            $total_events  = $this->event_model->get_search_event_find_loc_final('', '', $country,$country,
                "",'', '', $config['per_page'], $offset);

            $this->data['events'] = $total_events->result();

            $total_events->free_result();

            //print_r($this->general->geoCheckIP('91.208.156.100'));
            $this->data['event_location'] = $event_location =$this->general->get_cities_from_country($country,$country);//side bar cities list
            
            $this->data['event_title'] = "All Events";
            
        }

        //set SEO data        
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'event';
        
        /*added for buytickat.com*/
        $this->data['location'] = ($location )?(($location!=1)? $location:  $this->general->getCountry() )  : $this->general->getCurrentLocation();        
        $this->data['main_event_types'] = $this->general->get_event_type_lists("main","5");
        $this->data['banner'] = 'yes';
        /*added for buytickat.com*/

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_index', $this->data);            

    }
    
    public function rss($type = '')
    {
        $keyword = $this->data['keyword1'] = $this->input->get('keywords');
        $location = $this->data['location1'] = $this->input->get('location');
        $get_city = $this->data['get_city1'] = $this->input->get('city');
        $cat = $this->data['cat1'] = $this->input->get('cat');
        $date = $this->data['date1'] = $this->input->get('time');
        $type = $this->data['type1'] = $this->input->get('type');
        $price = $this->data['price1'] = $this->input->get('price');
        $gender = $this->data['gender1'] = $this->input->get('gender');
        $all = $this->data['all1'] = $this->input->get('all');
        // $city=$this->input->get('city');
        $this->load->model('event_search_model');
                                
        if ($keyword || $location || $cat || $date || $type || $price || $gender || $all || $get_city) 
        {   
            $total_events = $this->data['total_events'] = $this->event_search_model->event_search($keyword, $location,$get_city, $cat, $date, $type, $price,$gender)->num_rows();            
                        
            $query =  $this->event_search_model->event_search($keyword, $location,$get_city, $cat, $date, $type, $price,$gender);            
            $this->data['events'] = ($total_events > 0)? $query->result() : false;             
            $query->free_result();
            
        }else{          
            if($this->input->cookie(SESSION."country_cookie")){
                $country = $this->data['country_name'] = ($this->input->cookie(SESSION."country_cookie"))? $this->input->cookie(SESSION."country_cookie"): "";
                
                
            }else{
                
                                 
                $ip = $this->general->get_real_ipaddr(); 
               
                $jsn = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=9572dd79d587c691a58731f7ae4ea125d1c234b1063352b73ab4c6401e5f46c5&ip=$ip&format=json"));
                
                $country = $this->data['country_name'] = $jsn->countryName; 
                $country1 = '';
    
                $cookieA = array('name' => SESSION."country_cookie",'value'  => $country,'expire' => time()+3600*24*30);
                $this->input->set_cookie($cookieA);
                
            }
    
            $total_events  = $this->event_model->get_search_event_find_loc_final('', '', $country,$country1,
                '','', '');
            
            $this->data['events'] = $total_events['data'];
        }
        
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        
        $this->template->enable_parser(false)->title($this->
            page_title)->build('rss', $this->data);

    }
    
    
    

    public function view($id = '',$name='')
    {
        if ($id == '') {
            redirect('event/index', 'refresh');
            exit;
        }
        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        //echo $is_organizer;
        if ($is_organizer) {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,
                'organizer');
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id);
            if($data_event){
                if($data_event->specific_url != '' and $data_event->status == '2' and $data_event->show_url == '0') //ie private event
                {
                    if($this->session->userdata(SESSION.'email')==''){
                        $current_view_link = site_url('event/view/'.$id);
                        $this->session->set_userdata("redirect_url", $current_view_link);
                        $l_url = "<a href='".site_url('login')."'>".$this->lang->line('login')."</a>";
                        $r_url = "<a href='".site_url('register')."'>".$this->lang->line('register')."</a>";
                        $efsu = $this->lang->line('event_for_specific_users');
                        $flash_msg = str_replace("[[L]]",$l_url, $efsu);
                        $flash_msg = str_replace("[[R]]",$r_url, $flash_msg);
                        $this->session->set_flashdata('message', $flash_msg);
                        redirect('event/index', 'refresh');
                        exit;
                    }            
                    $specific_url_arr = explode(',',trim($data_event->specific_url));
                    $flag = false;
                    foreach($specific_url_arr as $email){
                        if($email=='' || $email ==' ')
                            continue;
                        if($this->session->userdata(SESSION.'email') == trim($email)){
                            if($this->general->verified_email($this->session->userdata(SESSION. 'email')))
                                $flag = true;
                            else{
                                $this->session->set_flashdata('message', $this->lang->line('not_verified_email_account')." <a href='".site_url('event/verify_email')."' class='ajax'>".$this->lang->line('click_here')."</a>");
                                redirect('event/index', 'refresh');
                                exit;
                            } 
                                                            
                                
                            break;   
                        }                    
                    }            
                    if(!$flag){
                        $this->session->set_flashdata('message', $this->lang->line('no_event_found'));
                        redirect('event/index', 'refresh');
                        exit;
                    }
                        
                }
            }
            
        }
        //var_dump($data_event);exit;
        //print_r($_POST);
        //check data, if it is not set then redirect to view page
        if ($this->data['data_event'] == false) {
            $this->session->set_flashdata('message', $this->lang->line('no_event_found'));
            redirect('event/index', 'refresh');
            exit;
        }
        
        

        if (isset($_POST['order_btn']) and !empty($_POST['order_btn'])) {
            $discount = 0;
            $promotion_code_id = 0;
            /*promotional code start*/
            if (isset($_POST['promotional_code']) and !empty($_POST['promotional_code'])) {
                $promotional_code = $this->input->post('promotional_code');
                $has_discount = $this->event_model->check_for_promotional_code_discount($promotional_code,
                    $id);

                if (!$has_discount) {
                    $this->session->set_flashdata('error',$this->lang->line('wrong_promotion_code_msg'));
                    redirect(site_url("event/view/$id/"));
                    exit;
                } else {
                    $discount = $has_discount->percentage;
                    $promotion_code_id = $has_discount->id;
                }
            }
            /*promotional code end*/
            
            
            $order_id = rand(1000000, 9999999999);
            $token_id = md5($this->session->userdata('session_id'));
            $temp_order_id = $this->event_model->insert_order_temp($id, $order_id, $token_id,
                $discount, $promotion_code_id);
                
            /*book the ticket for a while*/
            $ticket_ids_arr = $this->input->post('ticket_id');
            $ticket_num_arr = $this->input->post('ticket_no');
            foreach($ticket_ids_arr as $key=>$tic_id){
                $ticket_num = intval($ticket_num_arr[$key]);                            
                $this->db->query("UPDATE `es_event_ticket` SET `ticket_used` = `ticket_used` + $ticket_num WHERE `id` = '$tic_id' ");
                //echo $this->db->last_query();exit;                                   
            }             
            /*book the ticket for a while*/

            if ($_POST['order_btn'] == $this->lang->line('register_btn')) {
                redirect("event/register/$id/$order_id/$token_id/$temp_order_id");
            } else
                if ($_POST['order_btn'] == $this->lang->line('ordernow_btn')) {
                    redirect("event/order/$id/$order_id/$token_id/$temp_order_id");
                }
        }
        
        $this->data['current_event'] = $this->event_model->is_active_event($id);
        $this->data['current_public_event'] = $this->event_model->is_active_public_event($id);
        
        $this->data['event_id'] = $id;
        $this->data['sponsors'] = $this->event_model->get_sponsors_of_event($data_event->id);
        $this->data['performers'] = $this->event_model->get_extra_performers_of_event_new($data_event->id);
        $this->data['organizers'] = $this->event_model->get_organizers_of_event($data_event->id);
        $this->data['tickets'] = $this->event_model->get_tickets_of_event($data_event->id);
        $this->data['keywords'] = $this->event_model->get_keywords_of_event($data_event->id);

        $this->event_model->event_visit_counter($id); //event visit counter

        //set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->data['header_small'] = 'yes';

        $this->template->set_layout('event_layout')->enable_parser(false)->title($this->
            page_title)->build('event_view', $this->data);
    }
    public function preview($id)
    {        
        if ($id == '') {
            redirect('event/index', 'refresh');
            exit;
        }
        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        //echo $is_organizer;
        if ($is_organizer) {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,
                'organizer');
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id);
            if($data_event){
                if($data_event->specific_url != '' and $data_event->status == '2' and $data_event->show_url == '0') //ie private event
                {
                    if($this->session->userdata(SESSION.'email')==''){
                        $l_url = "<a href='".site_url('login')."'>".$this->lang->line('login')."</a>";
                        $r_url = "<a href='".site_url('register')."'>".$this->lang->line('register')."</a>";
                        $efsu = $this->lang->line('event_for_specific_users');
                        $flash_msg = str_replace("[[L]]",$l_url, $efsu);
                        $flash_msg = str_replace("[[R]]",$r_url, $flash_msg);
                        $this->session->set_flashdata('message', $flash_msg);
                        redirect('event/index', 'refresh');
                        exit;
                    }            
                    $specific_url_arr = explode(',',trim($data_event->specific_url));
                    $flag = false;
                    foreach($specific_url_arr as $email){
                        if($this->session->userdata(SESSION.'email') == trim($email)){
                            if($this->general->verified_email($this->session->userdata(SESSION. 'email')))
                                $flag = true;
                            else{
                                $this->session->set_flashdata('message', $this->lang->line('not_verified_email_account')." <a href='".site_url('event/verify_email')."' class='ajax'>".$this->lang->line('click_here')."</a>");
                                redirect('event/index', 'refresh');
                                exit;
                            } 
                                                            
                                
                            break;   
                        }                    
                    }            
                    if(!$flag){
                        $this->session->set_flashdata('message', $this->lang->line('no_event_found'));
                        redirect('event/index', 'refresh');
                        exit;
                    }
                        
                }
            }
            
        }
        //var_dump($data_event);exit;
        //print_r($_POST);
        //check data, if it is not set then redirect to view page
        if ($this->data['data_event'] == false) {
            $this->session->set_flashdata('message', $this->lang->line('no_event_found'));
            redirect('event/index', 'refresh');
            exit;
        }
        
        

        if (isset($_POST['order_btn']) and !empty($_POST['order_btn'])) {
            $discount = 0;
            $promotion_code_id = 0;
            /*promotional code start*/
            if (isset($_POST['promotional_code']) and !empty($_POST['promotional_code'])) {
                $promotional_code = $this->input->post('promotional_code');
                $has_discount = $this->event_model->check_for_promotional_code_discount($promotional_code,
                    $id);

                if (!$has_discount) {
                    $this->session->set_flashdata('error',$this->lang->line('wrong_promotion_code_msg'));
                    redirect(site_url("event/view/$id/"));
                    exit;
                } else {
                    $discount = $has_discount->percentage;
                    $promotion_code_id = $has_discount->id;
                }
            }
            /*promotional code end*/

            $order_id = rand(1000000, 9999999999);
            $token_id = md5($this->session->userdata('session_id'));
            $temp_order_id = $this->event_model->insert_order_temp($id, $order_id, $token_id,
                $discount, $promotion_code_id);

            if ($_POST['order_btn'] == $this->lang->line('register_btn')) {
                redirect("event/register/$id/$order_id/$token_id/$temp_order_id");
            } else
                if ($_POST['order_btn'] == $this->lang->line('ordernow_btn')) {
                    redirect("event/order/$id/$order_id/$token_id/$temp_order_id");
                }
        }
        
        $this->data['current_event'] = $this->event_model->is_active_event($id);
        
        $this->data['event_id'] = $id;
        $this->data['sponsors'] = $this->event_model->get_sponsors_of_event($data_event->id);
        $this->data['performers'] = $this->event_model->get_extra_performers_of_event_new($data_event->id);
        $this->data['organizers'] = $this->event_model->get_organizers_of_event($data_event->id);
        $this->data['tickets'] = $this->event_model->get_tickets_of_event($data_event->id);
        $this->data['keywords'] = $this->event_model->get_keywords_of_event($data_event->id);

        $this->event_model->event_visit_counter($id); //event visit counter

        //set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->data['header_small'] = 'yes';

        $this->template->set_layout('event_layout_preview')->enable_parser(false)->title($this->
            page_title)->build('event_view_preview', $this->data);
    }

    public function edit($id)
    {   
        $event_id = $id;
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        }

        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if (!$is_organizer) {
            $this->session->set_flashdata('error', $this->lang->line('not_authorized_user'));
            redirect('organizer/event', 'refresh');
            exit;
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,'organizer');
            $this->data['event_description'] = $this->event_model->get_event_description_byid($id,'organizer'); //reason: object is not suporting by ckeditor. for ckeditor only array for description was fetched.

        }

        if (!$data_event) 
        {
            $this->session->set_flashdata('error',$this->lang->line('no_event_found_blocked'));
            redirect('organizer/event', 'refresh');
            exit;
        }
        if ($this->input->post('submit_organiser_edit')) {
            //echo "hello";
            //print_r($_POST);
            //print_r($_FILES);
            $this->event_model->update_event_organizer();
            exit;
        }
        //$this->data['data_event'] = $this->event_model->get_event_byid($id, 'organizer');

        
        
        $this->data['date_time_detail'] = $data_event->date_time_detail;

        $this->data['ticket_details'] = $this->event_model->get_tickets_of_event($id); //previous tickets

        $this->data['performers'] = $this->event_model->get_performers_of_user($this->
            session->userdata(SESSION . 'user_id'));

        $this->data['categories'] = $this->category->get_only_category_lists();
        $this->data['organizers'] = $this->event_model->get_previous_organizers_of_user($this->
            session->userdata(SESSION . 'user_id')); //list old organizers
        $this->data['organizers_alerady'] = $this->event_model->
            already_organizer_of_event_details($this->session->userdata(SESSION . 'user_id'),
            $id);
        $this->data['performer_alerady'] = $this->event_model->
            already_performer_of_event_details($this->session->userdata(SESSION . 'user_id'),
            $id);
        $this->data['current_organizers'] = $this->event_model->get_organizers_of_event($data_event->
            id);
        $this->data['event_keywords'] = $this->event_model->get_event_keywords($data_event->
            id);
        $total_existing_organizers = $this->event_model->
            count_previous_organizers_of_user($this->session->userdata(SESSION . 'user_id')); //count old organizers
        $total_existing_performer = $this->event_model->
            count_previous_performer_of_user($this->session->userdata(SESSION . 'user_id'));
        $this->data['current_sponser'] = $this->event_model->get_sponser_of_event($data_event->
            id);
        $this->data['idss'] = $id;
        // Set the validation rules
        $this->form_validation->set_rules($this->event_model->validate_settings);

        if (isset($_POST['save']) || isset($_POST['preview'])) {
            $status_s = 2;
        } else {
            $status_s = 1;
        }
        if (isset($_POST['publish'])) 
        {            
            //echo $this->input->post('location');exit;
            //var_dump($this->input->post());
            if ($this->form_validation->run() == true) {
//echo $this->input->post('event_description');exit();
                $this->event_model->update_record($id, $status_s); //update event details
                $this->event_model->insert_event_ticket($id); //insert ticket
                $this->event_model->insert_event_organizer($id); //insert organizers
                $this->event_model->insert_existing_event_organizer($id, $total_existing_organizers);
                $this->event_model->insert_event_sponsor($id);
                $this->event_model->insert_event_performer_multi($id);
                $this->event_model->insert_existing_event_performer($id, $total_existing_performer);
                $this->event_model->insert_event_keyword($id);
                // echo $this->db->last_query();
                //if($this->input->post('change_performer')=='on')
                // $this->event_model->update_new_performer($performer->id); //update new performer
                //exit;
                //exit;
                /*for map*/
                if ($this->input->post('location')) {
                    $output = $this->getlatandlon_without_key($this->input->post('location'));
                    $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                    if ($output->status) {
                        $this->event_model->update_event_location($output, $event_id); //insert location
                    } else {
                        $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                    }
                } else {
                    $this->event_model->insert_event_physical_address_only($event_id); //insert only physical address
                }
                
                $this->event_model->email_update_event($this->session->userdata(SESSION .'user_id'), $id);
                
                $this->session->set_flashdata('message', $this->lang->line('update_successfull_message'));
                
                if ($this->session->userdata(SESSION . 'organizer') == '1')
                    redirect('organizer/event');//redirect('event/view/' . $id);
                else
                    redirect(site_url('organizer/event'));
                exit;
            }
        } elseif (isset($_POST['save']) || isset($_POST['preview'])) {
            $this->event_model->update_record($id, $status_s); //update event details
            $this->event_model->insert_event_ticket($id); //insert ticket
            $this->event_model->insert_event_organizer($id); //insert organizers
            $this->event_model->insert_existing_event_organizer($id, $total_existing_organizers);
            $this->event_model->insert_event_sponsor($id);
            $this->event_model->insert_event_performer_multi($id);
            $this->event_model->insert_existing_event_performer($id, $total_existing_performer);
            $this->event_model->insert_event_keyword($id);
            // echo $this->db->last_query();
            //if($this->input->post('change_performer')=='on')
            // $this->event_model->update_new_performer($performer->id); //update new performer
            //exit;
            //exit;
            /*for map*/
            if ($this->input->post('location')) {
                $output = $this->getlatandlon_without_key($this->input->post('location'));
                $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                if ($output->status) {
                    $this->event_model->update_event_location($output, $event_id); //insert location
                } else {
                    $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                }
            } else {
                $this->event_model->insert_event_physical_address_only($event_id); //insert only physical address
            }
            
            if (isset($_POST['preview'])) {
                $this->session->set_flashdata('preview', 'value');
            }
            redirect(site_url('event/edit/' . $id));
            exit;
        }
        
        if($data_event->date_id <> 0)
            $this->session->set_userdata(SESSION . "date_id",$data_event->date_id);
            
        if($this->session->flashdata('preview') == 'value'){ //if preview button is clicked, it should omit this check 
             
        }else{
            $current_event = $this->data['current_event'] = $this->event_model->is_active_event($id);
            if(!$current_event){ 
                $event_with_no_order = $this->general->is_event_with_no_order($id);
                if($event_with_no_order){
                    
                }else{
                    redirect('event/view/'.$id);exit;    
                }                
            }
        }
        

        //set SEO data
        $this->page_title = $data_event->title . " - ".$this->lang->line('edit_event');
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';
        $this->data['non_responsive'] = 'yes';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_edit', $this->data);

    }

    public function add()
    {
        $this->session->set_userdata(array('redirect_url' => site_url('event/add'))); //to define redirect url
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        }
        if ($this->session->userdata(SESSION . 'event_id'))
            $this->session->unset_userdata(SESSION . 'event_id', $event_id);

        $this->data['categories'] = $this->category->get_category_lists();

        // Set the validation rules
        $this->form_validation->set_rules($this->event_model->validate_settings);
        //var_dump($this->input->post());
        if ($this->form_validation->run() == true) {

            $event_id = $this->event_model->insert_record(); //insert event details

            /*organizer information block*/
            $organizer = $this->general->is_organizer($this->session->userdata(SESSION .
                'user_id'));
            if (!$organizer)
                $this->general->set_organizer($this->session->userdata(SESSION . 'user_id'));
            /*organizer information block*/

            if ($this->input->post('change_performer') == 'on')
                $this->event_model->insert_new_performer($event_id); //insert new performer
            $this->session->set_userdata(SESSION . 'event_id', $event_id);
            redirect('event/add_location');
            exit;
        }


        //set SEO data
        $this->page_title = "Create New Event";
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_form', $this->data);
    }


    public function add_location()
    {
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        } else
            if (!$this->session->userdata(SESSION . 'event_id')) {
                redirect(site_url('event/add'));
                exit;
            }
        $event_id = $this->session->userdata(SESSION . 'event_id');

        // Set the validation rules
        $this->form_validation->set_rules($this->event_model->
            validate_settings_location);

        if ($this->form_validation->run() == true) {
            /*for map*/
            $output = $this->getlatandlon_without_key($this->input->post('location'));
            $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));

            if ($output->status) {
                $this->event_model->insert_event_location($output, $event_id); //insert location
                redirect('event/add_organizer', 'refresh');
                exit;
            } else {
                $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
            }
        }

        //set SEO data
        $this->page_title = "Add Location";
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_form_location', $this->data);

    }

    public function edit_location($id)
    {
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        }

        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if (!$is_organizer) {
            $this->session->set_flashdata('error', $this->lang->line('not_authorized_user'));
            redirect('organizer/event', 'refresh');
            exit;
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,
                'organizer');
        }

        if (!$data_event) {
            $this->session->set_flashdata('error', $this->lang->line('no_event_found_blocked'));
            redirect('organizer/event', 'refresh');
            exit;
        }

        // Set the validation rules
        $this->form_validation->set_rules($this->event_model->
            validate_settings_location);

        if ($this->form_validation->run() == true) {
            /*for map*/
            $output = $this->getlatandlon_without_key($this->input->post('location'));
            $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));

            if ($output->status) {
                $this->event_model->insert_event_location($output, $event_id); //insert location
                redirect('event/add_organizer', 'refresh');
                exit;
            } else {
                $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
            }
        }

        //set SEO data
        $this->page_title = "Edit Location";
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_form_location', $this->data);

    }

    public function add_organizer()
    {
        $this->load->library('upload');

        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        } else
            if (!$this->session->userdata(SESSION . 'event_id')) {
                redirect(site_url('event/add'));
                exit;
            }
        $event_id = $this->session->userdata(SESSION . 'event_id');

        // Set the validation rules
        $this->form_validation->set_rules($this->event_model->validate_settings_normal);

        if ($this->form_validation->run() == true) {
            //var_dump($_FILES);exit;
            if (($this->input->post('post_event') <> 'skip'))
                $this->event_model->insert_event_organizer($event_id); //insert organizers
            redirect('event/add_sponsor', 'refresh');
        }

        //set SEO data
        $this->page_title = $this->lang->line('add_organizer');
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_form_organzier', $this->data);

    }

    public function add_sponsor()
    {
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        } else
            if (!$this->session->userdata(SESSION . 'event_id')) {
                redirect(site_url('event/add'));
                exit;
            }
        $event_id = $this->session->userdata(SESSION . 'event_id');

        $this->form_validation->set_rules($this->event_model->validate_settings_normal);
        if ($this->form_validation->run() == true) {
            $this->event_model->insert_event_sponsor($event_id); //insert sponsors
            $this->session->unset_userdata(SESSION . 'event_id', $event_id);
            $this->session->set_flashdata('message', $this->lang->line('event_add_message'));
            redirect('event', 'refresh');
        }

        //set SEO data
        $this->page_title = "Add Sponsor";
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_form_sponsor', $this->data);

    }
    public function add_ticket($event_id)
    {
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        } else
            if (!isset($event_id)) {
                redirect(site_url('event/'));
                exit;
            } else
                if (!$this->general->is_organizer_of_event($event_id)) {
                    $this->session->set_flashdata('message', $this->lang->line('unauthorized_access'));
                    redirect(site_url('event/view/' . $event_id));
                    exit;
                }

        //set some data value
        $this->data['event_id'] = $event_id;
        $this->data['event_detail'] = $this->event_model->get_event_short_info_by_id($event_id);

        //if event status is not 1
        if (!$this->data['event_detail']) {
            redirect(site_url('event/'));
            exit;
        }

        $this->data['check_event_active'] = $this->event_model->check_event_active($event_id);
        $this->data['tickets'] = $this->event_model->get_tickets_of_event($event_id);

        //var_dump($this->input->post());

        $this->form_validation->set_rules($this->event_model->validate_settings_ticket);
        if ($this->form_validation->run() == true) {
            $this->event_model->insert_event_ticket($event_id); //insert ticket
            $this->session->set_flashdata('message', $this->lang->line('ticket_add_message'));
            redirect(current_url());
        }

        //set SEO data
        $this->page_title = "Add Ticket";
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_form_ticket', $this->data);

    }

    
    
    public function getlatandlon_without_key($where)
    {
        // $where = "karnataka, india";
        $whereurl = urlencode($where);
        $geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$whereurl . '&sensor=false&language='.$this->config->item('language_abbr'));
        $output = json_decode($geocode);
        return $output;
    }

    public function getlatandlon_without_key_lat($where)
    {
        // $where = "karnataka, india";
        $whereurl = $where;
        $geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng=27.70169,85.3206&sensor=false');
        $output = json_decode($geocode);
        return $output;
    }


    public function list_event_types()
    {
        if (is_ajax()) {
            $user_ses_id = $this->session->userdata(SESSION . "user_id");

            $event_type_id = intval($this->input->post('etid'));


            if (!isset($user_ses_id)) {
                echo 'result=error@@message=Session out! Please login.';
                exit;
            }

            $event_type = $this->category->get_category_byid($event_type_id);
            $performer = $this->category->get_performer_by_catid($event_type_id);

            if ($event_type) {
                $result = 'result=success@@category=' . $event_type->name . '@@sub_category=' .
                    $event_type->sub_type . "@@sub_sub_category=" . $event_type->sub_sub_type .
                    "@@paid=" . $event_type->paid_event;
                if ($performer) {
                    $result .= "@@performer_name=" . $performer->name . '@@performer_type=' . $performer->
                        type . "@@performer_description=" . $performer->description;
                }
                echo $result;
                exit;
            } else {
                echo 'result=error@@message=No event type details found.';
                exit;
            }

        }
    }

    public function change_event_logo($id)
    {
        if ($this->input->post('edit_event') == '') {
            $this->load->library('upload');
            $this->load->library('image_lib');

            //make file settins and do upload it
            $image1_name = $this->general->file_settings_do_upload('photoimg', 'event');

            if ($image1_name['file_name']) {
                $this->image_name_path1 = $image1_name['file_name'];
                //resize image
                $this->general->resize_image($this->image_name_path1, 'thumb_' . $image1_name['raw_name'] .
                    $image1_name['file_ext'], 'event', '120', '120');

                //update event logo
                $this->db->where('id', $id);
                $this->db->update('event', array('logo' => $image1_name['raw_name'] . $image1_name['file_ext']));
                echo "<img src='" . site_url(UPLOAD_FILE_PATH . 'event/' . 'thumb_' . $image1_name['raw_name'] .
                    $image1_name['file_ext']) . "' />";
            } else {
                echo "No image upload";
            }
        } else {
            redirect('event/edit_location/' . $id);
        }

    }

    /*new code started */
    public function create()
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: No-cache");
        
        $this->session->set_userdata(array('redirect_url' => site_url('event/create'))); //to define redirect url
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('login'));
            exit;
        }
        if ($this->session->userdata(SESSION . 'event_id'))
            $this->session->unset_userdata(SESSION . 'event_id', $event_id);

        $this->data['performers'] = $this->event_model->get_performers_of_user($this->
            session->userdata(SESSION . 'user_id'));
        $this->data['categories'] = $this->category->get_only_category_lists();
        //$this->data['subcategories'] = $this->category->get_only_sub_category_lists();
        $this->data['organizers'] = $this->event_model->get_previous_organizers_of_user($this->
            session->userdata(SESSION . 'user_id')); //list old organizers
        $total_existing_organizers = $this->event_model->
            count_previous_organizers_of_user($this->session->userdata(SESSION . 'user_id')); //count old organizers
        
        $total_existing_performer = $this->event_model->
            count_previous_performer_of_user($this->session->userdata(SESSION . 'user_id'));

        // Set the validation rules
        $this->form_validation->set_rules($this->event_model->validate_settings);
        //var_dump($this->input->post());
        //echo "what". $this->form_validation->run();
        //if($this->form_validation->run()==TRUE)
        if (isset($_POST['save']) || isset($_POST['preview'])) {
            $status_s = 2;
        } else {
            $status_s = 1;
        }
        if (isset($_POST['save']) || isset($_POST['preview'])) {
            //var_dump($this->input->post());
            $event_id = $this->event_model->insert_record($status_s); //insert event details
            $this->event_model->insert_event_ticket($event_id); //insert ticket
            $this->event_model->insert_event_organizer($event_id); //insert organizers
            $this->event_model->insert_existing_event_organizer($event_id, $total_existing_organizers); //insert existing organizers
            $this->event_model->insert_event_sponsor($event_id); //insert sponsors            
            $this->event_model->insert_event_keyword($event_id); //insert keywords

            /*performer operation start*/
            $this->event_model->insert_event_performer_multi($event_id);
            $this->event_model->insert_existing_event_performer($event_id, $total_existing_performer);
            /*performer operation end*/

            /*for map*/
            if ($this->input->post('location')) {
                $output = $this->getlatandlon_without_key($this->input->post('location'));
                $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                if ($output->status) {
                    $this->event_model->insert_event_location($output, $event_id); //insert location
                } else {
                    $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                }
            } else {
                $this->event_model->insert_event_physical_address_only($event_id); //insert only physical address
            }

            if (isset($_POST['preview'])) {
                $this->session->set_flashdata('preview', 'value');
            }

            redirect(site_url('event/edit/' . $event_id));
            exit;

        } elseif (isset($_POST['publish'])) {
            if ($this->form_validation->run() == true):
                $event_id = $this->event_model->insert_record($status_s); //insert event details
                $this->event_model->insert_event_organizer($event_id); //insert organizers
                $this->event_model->insert_existing_event_organizer($event_id, $total_existing_organizers); //insert existing organizers
                $this->event_model->insert_event_sponsor($event_id); //insert sponsors
                $this->event_model->insert_event_ticket($event_id); //insert ticket
                $this->event_model->insert_event_keyword($event_id); //insert keywords

                /*performer operation start*/
                $this->event_model->insert_event_performer_multi($event_id);
                $this->event_model->insert_existing_event_performer($event_id, $total_existing_performer);
                /*performer operation end*/

                /*for map*/
                if ($this->input->post('location')) {
                    $output = $this->getlatandlon_without_key($this->input->post('location'));
                    $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                    if (strtoupper($output->status) == 'OK') {
                        $this->event_model->insert_event_location($output, $event_id); //insert location
                    } else {
                        $this->session->set_flashdata('message', $this->lang->line('Google API is down right now.'));
                    }
                } else {
                    $this->event_model->insert_event_physical_address_only($event_id); //insert only physical address
                }

                //create event email notification to user
                $this->event_model->email_create_event($this->session->userdata(SESSION .'user_id'),$event_id);
                        
                $this->session->set_flashdata('message', $this->lang->line('create_successfull_event'));
                if ($this->session->userdata(SESSION . 'organizer') == '1')
                    redirect('organizer/event');
                else
                    redirect(site_url('organizer/event'));
                exit;
            endif;
        }


        //set SEO data
        $this->page_title = $this->lang->line('create_new_event');
        $this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
        $this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'create_event';
        $this->data['non_responsive'] = 'yes';

        $this->template->set_layout('general')->enable_parser(false)->title($this->
            page_title)->build('event_create', $this->data);
    }
    /*new code end */
    function ticket_checkout()
    {

    }

    public function show_performer_detail()
    {
        if (is_ajax()) {
            $user_ses_id = $this->session->userdata(SESSION . "user_id");

            $performer_id = intval($this->input->post('performer_id'));


            if (!isset($user_ses_id)) {
                echo 'result=error@@message=Session out! Please login.';
                exit;
            }

            $perfomer = $this->event_model->get_performer($performer_id);

            if ($perfomer) {
                $result = 'result=success@@name=' . $perfomer->performer_name . '@@type=' . $perfomer->
                    performer_type . "@@description=" . $perfomer->performer_description;
                echo $result;
                exit;
            } else {
                echo 'result=error@@message=No performer detail found.';
                exit;
            }
        }
    }

    public function create_date_time()
    {
        if (is_ajax()) {
            $date_time = $this->event_model->create_date_time();
            if ($date_time) {
                echo "result=success";
            } else {
                echo "result=error@@msg=Something went wrong. Please try again.";
            }
        }
    }

    public function order($id, $order_id, $token_id, $temp_cart_id)
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        if (!isset($id)) {
            redirect('event/index', 'refresh');
            exit;
        }
        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if ($is_organizer) {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,
                'organizer');
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id);
        }
        //print_r($_POST);
        //check data, if it is not set then redirect to view page
        if ($this->data['data_event'] == false) {
            $this->session->set_flashdata('message', $this->lang->line('no_event_found'));
            redirect('event/index', 'refresh');
            exit;
        }

        /*tempt cart start*/
        $temp_order = $this->data['order'] = $this->event_model->get_temp_cart_detail($id,
            $order_id, $token_id, $temp_cart_id);
        if ($this->data['order'] == false) {
            $this->session->set_flashdata('message', $this->lang->line('session_expired_try_again'));
            redirect('event/view/' . $id, 'refresh');
            exit;
        }
        /*tempt cart end*/
        $ticket = $temp_order->ticket_quantity;
        
        $validate_arr_before_login = array(
                array('field' => 'email', 'label' =>'Email address', 'rules' => 'trim|required|valid_email|is_unique[user.email]'),                
            );
        
        $validate_arr_after_login = array(array('field' => 'email', 'label' =>'Email address', 'rules' => 'trim|required|valid_email'),            
            );
        

        if ($this->session->userdata(SESSION . 'user_id')) {
            $this->form_validation->set_rules($validate_arr_after_login);
        } else {
            $this->form_validation->set_rules($validate_arr_before_login);
        }

        if ($this->form_validation->run() == true) {

            if ($this->session->userdata(SESSION . 'user_id')) {
                //$user_id = $this->event_payment_model->update_user_detail_order($id);
                $user_id =($this->session->userdata(SESSION . 'user_id'));
            } else {
                $user_id = $this->event_payment_model->register_new_user_order();
            }

            if (!$user_id) {
                $this->session->set_flashdata('message', $this->language->line('order_failure_msg'));
                redirect(site_url('event/view/' . $id));
            } else if (strtoupper($this->input->post('order_type_pb', true))=='PAYPAL') {
                $jsn_order_form = json_encode($_POST);
                $this->event_payment_model->make_login($user_id);
                $this->session->set_userdata('order_form_details', $jsn_order_form);
                redirect(site_url("event/pay/paypal/$temp_order->event_id/$temp_order->order_id/$temp_order->token_id/$temp_order->id"));
            } else if (strtoupper($this->input->post('order_type_pb', true))=='BANK') {
                $ticket_order_id = $this->event_payment_model->order_already_exits($this->session->userdata(SESSION.'user_id'), $id, $temp_order->order_id);
                if($ticket_order_id){                     
                    $order = $this->general->get_single_record('es_event_ticket_order','bank_transaction_id','id', $ticket_order_id);
                    $bank_tran_id = $order->bank_transaction_id;                
                }else{                    
                    $jsn_order_form = json_encode($_POST);
                    $this->event_payment_model->make_login($user_id);
                    $this->session->set_userdata('order_form_details', $jsn_order_form);
                    $bank_tran_id = $this->event_payment_model->insert_bank_transation();
                    $this->event_payment_model->insert_ticket_payment_order($temp_order->event_id, $temp_order->
                        order_id, $temp_order->token_id, $temp_order->id, $bank_tran_id);
    
                    $this->event_payment_model->send_mail_to_organiser($temp_order);
                    $this->event_payment_model->send_mail_to_buyer($order_id);    
                }
                
                //redirect(site_url('event/bank/' . $bank_tran_id . '/' . $temp_order->order_id));
                redirect(site_url('event/bank_detail/' . $bank_tran_id . '/' . $temp_order->order_id));
                exit;
            }

            /*
            if($this->event_model->creditCard_check($this->input->post('credit_card_number'), $this->input->post('credit_card_type')))
            {               
            $res = $this->event_payment_model->insert_ticket_payment_order($id,$order_id,$token_id,$temp_cart_id);
            if($res){                                           
            $this->event_model->delete_temp_order($this->input->post('order_id'));
            redirect('event/orderconfirm/'.$id."/".$this->input->post('order_id'));
            }                       
            
            
            }else{
            $this->session->set_flashdata('cc_error','Wrong credit card information');  
            redirect($this->uri->uri_string());               
            }
            */

        }

        $this->data['sponsors'] = $this->event_model->get_sponsors_of_event($data_event->
            id);
        $this->data['performer'] = $this->event_model->get_extra_performers_of_event($data_event->
            id);
        $this->data['organizers'] = $this->event_model->get_organizers_of_event($data_event->
            id);
        $this->data['tickets'] = $this->event_model->get_tickets_of_event($data_event->
            id);
        $this->data['selected_question'] = $this->event_model->get_question_order($data_event->
            id);

        //set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;

        $this->template->set_layout('event_layout')->enable_parser(false)->title($this->
            page_title)->build('event_order_paid', $this->data);
    }

    public function register($id, $order_id, $token_id, $temp_cart_id)
    {
        if (!isset($id)) {
            redirect('event/index', 'refresh');
            exit;
        }
        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if ($is_organizer) {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,
                'organizer');
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id);
        }
        //print_r($_POST);
        //check data, if it is not set then redirect to view page
        if ($this->data['data_event'] == false) {
            $this->session->set_flashdata('message', $this->lang->line('no_event_found'));
            redirect('event/index', 'refresh');
            exit;
        }

        /*tempt cart start*/
        $temp_order = $this->data['order'] = $this->event_model->get_temp_cart_detail($id,
            $order_id, $token_id, $temp_cart_id);
        if ($this->data['order'] == false) {
            $this->session->set_flashdata('message',
                $this->lang->line('session_expired_try_again'));
            redirect('event/view/' . $id, 'refresh');
            exit;
        }
        /*tempt cart end*/

        $validate_arr_before_login = array(
                //array('field' => 'first_name', 'label' =>'First Name', 'rules' => 'trim|required'), 
                //array('field' => 'last_name', 'label' =>'Last Name', 'rules' => 'trim|required'), 
                array('field' => 'email', 'label' =>'Email address', 'rules' => 'trim|required|valid_email|is_unique[user.email]'), );
        $validate_arr_after_login = array(
                //array('field' => 'first_name', 'label' =>'First Name', 'rules' => 'trim|required'), 
                //array('field' => 'last_name', 'label' =>'Last Name', 'rules' => 'trim|required'), 
                array('field' => 'email', 'label' =>'Email address', 'rules' => 'trim|required|valid_email'), );

        if ($this->session->userdata(SESSION . 'user_id')) {
            $this->form_validation->set_rules($validate_arr_after_login);
        } else {
            $this->form_validation->set_rules($validate_arr_before_login);
        }


        if ($this->form_validation->run() == true) {
            $this->load->model('event_payment_model');
            $this->event_payment_model->send_mail_to_organiser($temp_order);
            $this->event_payment_model->send_mail_to_buyer($order_id);
            $res = $this->event_payment_model->insert_free_ticket_payment_order($id, $order_id,
                $token_id, $temp_cart_id);
            if ($res) {
                $this->event_model->delete_temp_order($order_id);
                redirect('event/orderconfirm/' . $id . "/" . $order_id);
            }

        }

        $this->data['sponsors'] = $this->event_model->get_sponsors_of_event($data_event->
            id);
        $this->data['performer'] = $this->event_model->get_extra_performers_of_event($data_event->
            id);
        $this->data['organizers'] = $this->event_model->get_organizers_of_event($data_event->
            id);
        $this->data['tickets'] = $this->event_model->get_tickets_of_event($data_event->
            id);
        $this->data['selected_question'] = $this->event_model->get_question_order($data_event->
            id);

        //set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;

        $this->template->set_layout('event_layout')->enable_parser(false)->title($this->
            page_title)->build('event_order_register', $this->data);
    }
    
    function bank_detail($tran_id, $order_id)
    {   
        $this->event_model->delete_temp_order($order_id); //delete temp_cart row
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = DEFAULT_META_KEYS;
        $this->data['meta_desc'] = DEFAULT_META_DESC;
        $this->data['tran_id'] = $tran_id;
        $this->data['order_id'] = $order_id;
        
        $this->load->model('bank/admin_bank');
        $this->data['banks'] = $this->admin_bank->get_bank_lists(); 
        $this->data['total_amount'] = $this->db->query("SELECT SUM(due) as due FROM `es_event_ticket_order` WHERE order_id='$order_id'")->row();
        
        $this->template->set_layout('event_layout')->enable_parser(false)->title($this->
            page_title)->build('event_order_bank_detail', $this->data);
    }
    
    function bank($tran_id, $order_id)
    {
        $this->page_title = DEFAULT_PAGE_TITLE;
        $this->data['meta_keys'] = '';
        $this->data['meta_desc'] = '';
        $this->load->model('bank/admin_bank');
        $this->data['banks'] = $this->admin_bank->get_bank_lists();
        $this->data['tran_id'] = $tran_id;
        $this->data['order_id'] = $order_id;
        $total_amount = $this->data['total_amount'] = $this->db->query("SELECT SUM(due) as due FROM `es_event_ticket_order` WHERE order_id='$order_id'")->row();
        //$total_amount = $this->data['total_amount'] = $this->general->get_single_record('es_event_ticket_order','SUM (due)','order_id',$order_id);  
        if ($this->input->post()) {
            $amount = $this->input->post('amount');
            
            $total_amount_in_current_currency = $total_amount->due; //for compare only
            $amount_in_current_currency = $this->input->post('amount'); //for compare only
            
            //echo round($total_amount_in_current_currency); echo round($amount_in_current_currency);   exit;         
            if(round($total_amount_in_current_currency) == round($amount_in_current_currency)){
                $array = array(
                    'bank_name_from' => $this->input->post('bank_name_from'), 
                    //'transaction_id' => $this->input->post('transaction_id'), 
                    //'account_number' => $this->input->post('account_number'),
                    'account_holder_name' => $this->input->post('account_holder_name'),
                    'amount' => $amount, //$total_amount->due, //
                    'bank_name_to' => $this->input->post('bank_name_to'),                        
                    );
                $this->db->where('id', $tran_id);
                $this->db->update('es_bank_transaction', $array);
                
                $this->general->set_notification($this->session->userdata(SESSION.'email'). " has made a payment for order <strong>#$order_id</strong> via Bank transaction and proceed to identify payment.","payment/approve_transaction"); //notification
                
                /*create ticket start*/
                $q = $this->db->select('id, ticket_id, order_id, ticket_quantity')->where(array('order_id'=>$order_id))->from('event_ticket_order')->get();
                if($q->num_rows() > 0){
                    $ticket_orders = $q->result();
                    foreach($ticket_orders as $ticket_order){
                        $this->event_payment_model->make_myticket($ticket_order->id);   //create ticket
                        $this->db->query("UPDATE `es_event_ticket` SET `ticket_used` = ticket_used + $ticket_order->ticket_quantity WHERE `id` = '$ticket_order->ticket_id'");
                        
                        $this->db->where('id', $ticket_order->id);
                        $this->db->update('es_event_ticket_order', array('bank_transaction_status' => 'yes'));        
                    }
                }
                /*create ticket end*/
                
                //redirect(site_url('event/bank_thank'));
                $this->template->enable_parser(false)->title($this->page_title)->build('event_order_bank_thank', $this->data);                           
                
            }else{
                echo "wrong_amount";
            }
            
            
        }else{
            $this->template->enable_parser(false)->title($this->page_title)->build('event_order_bank', $this->data);    
        }
    
        
    }
    function bank_thank()
    {
        $this->page_title = 'thank you';
        $this->data['meta_keys'] = '';
        $this->data['meta_desc'] = '';
        $this->template->set_layout('event_layout')->enable_parser(false)->title($this->
            page_title)->build('event_order_bank_thank', $this->data);
    }
    public function orderconfirm($event_id, $order_id)
    {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

        $order_detail = $this->data['order_detail'] = $this->event_model->get_ticket_order_detail($event_id, $order_id);
        if (!$order_detail) {
            redirect('event');
        }
        $is_organizer = $this->general->is_organizer_of_event($event_id); //check for organizer
        if ($is_organizer) {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($event_id,
                'organizer');
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($event_id);
        }
        //print_r($_POST);
        //check data, if it is not set then redirect to view page
        if ($this->data['data_event'] == false) {
            $this->session->set_flashdata('message', $this->lang->line('no_event_found'));
            redirect('event/index', 'refresh');
            exit;
        }
        $this->data['organizers'] = $this->event_model->get_organizers_of_event($data_event->
            id);

        //set SEO data
        $this->page_title = $this->lang->line('you_are_attending')." " . $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;

        $this->template->set_layout('event_layout')->enable_parser(false)->title($this->
            page_title)->build('event_order_confirmation', $this->data);

    }

    public function loginajaxaccess()
    {
        if (is_ajax()) {
            $this->load->model('users/login_module');
            $this->load->model('users/account_module');
            $login_status = $this->login_module->check_login_process();
            if ($this->session->userdata(SESSION . 'user_id')) {
                $user = $this->account_module->get_user_profile_data();
                $result = 'result=success@@message=' . $user->email;
                echo $result;
            } else {
                echo 'result=error@@message='.$this->lang->line('login_failure_tryagain');
                exit;
            }
        }
    }

    public function logoutajaxaccess()
    {
        if (is_ajax()) {
            $array_items = array(SESSION . 'user_id' => '', SESSION . 'first_name' => '',
                SESSION . 'email' => '', SESSION . 'last_name' => '', SESSION . 'username' => '',
                SESSION . 'last_login' => '', SESSION . 'lang_flag' => '', SESSION .
                'short_code' => '', SESSION . 'lang_id' => '');
            $this->session->unset_userdata($array_items);
            $this->session->sess_destroy();
        }
    }

    public function organize($id)
    {
        //for signed up users only
        if (!$this->session->userdata(SESSION . 'user_id')) {
            redirect(site_url('users/login'));
            exit;
        }


        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if (!$is_organizer) {
            $this->session->set_flashdata('error', $this->lang->line('not_authorized_user'));
            redirect('organizer/event', 'refresh');
            exit;
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,'organizer');
            $active_event = $this->data['active_event'] = $this->event_model->is_active_event($id);
        }

        if (!$data_event) {
            $this->session->set_flashdata('error', $this->lang->line('no_event_found_blocked'));
            redirect('organizer/event', 'refresh');
            exit;
        }
        $this->form_validation->set_rules('ticket_name0', 'Ticket name', 'required');

        if ($this->form_validation->run() == true) {
            $this->event_model->insert_event_ticket($id); //insert ticket
            redirect('event/organize/' . $id);
            exit;
        } 
        $this->data['no_views'] = $this->event_model->event_page_view_count($id);
        $this->data['event_page_view'] = $this->event_model->event_page_view($id);
        $this->data['sale_service'] = $this->event_model->get_sale_service_dis($id);

        $this->data['id'] = $id;
        $ticket_sold = $this->data['total_sold_d'] = $this->event_model->get_total_sold_ticket($id);
        $total = 0;
        if ($ticket_sold):
            foreach ($ticket_sold as $n) {
                $total += $n->total_quantity;

            }
        endif;
        $this->data['total_sold'] = $total;
        $this->data['total_sold_free'] = $this->event_model->get_total_sold_ticket_free($id);
        $this->data['total_sold_paid'] = $this->event_model->get_total_sold_ticket_paid($id);        
        $this->data['total_sold_pending'] = $this->event_model->get_total_sold_ticket_pending($id);
        $this->data['attendes'] = $this->event_model->get_event_attends($id);
        $this->data['ticket_details'] = $this->event_model->get_tickets_of_event($id);

        //set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->data['navigation'] = 'event';
        $this->data['organizer_nav'] = 'yes';

        $this->template->set_layout('event_organizer_layout')->enable_parser(false)->
            title($this->page_title)->build('event_organize', $this->data);
    }
        
    function checkin($id)
    {
        $this->data['navigation'] = 'checkin';
        $this->data['id'] = $id;
        $is_organizer = $this->general->is_organizer_of_event($id); //check for organizer
        if (!$is_organizer) {
            $this->session->set_flashdata('error', $this->lang->line('not_authorized_user'));
            redirect('organizer/event', 'refresh');
            exit;
        } else {
            $active_event = $this->data['active_event'] = $this->event_model->is_active_event($id);
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($id,'organizer');
        }

        if (!$data_event) {
            $this->session->set_flashdata('error',
                $this->lang->line('no_event_found_blocked'));
            redirect('organize/event', 'refresh');
            exit;
        }
        $time = $this->input->post('tickets_date');
        if ($time) {
            $this->data['sele_dat'] = $this->input->post('select_date');
            $def_time = explode(',', $time);
            $def_start_time = trim($def_time[0]);
            $def_end_time = trim($def_time[1]);
            $def_start_time1 = strtotime($def_start_time);
            $def_end_time1 = strtotime($def_end_time);
            $def_end_time_str = date('Y-m-d H:i:s', $def_end_time1);
            $def_start_time_str = date('Y-m-d H:i:s', $def_start_time1);
            $def_end_time_str1 = date('l Y-m-d H:i:s', $def_end_time1);
            $def_start_time_str1 = date('l Y-m-d H:i:s', $def_start_time1);
            $this->data['default_check_in1'] = $def_start_time_str1 . ', ' . $def_end_time_str1;
            $this->data['default_check_in'] = $this->event_model->get_default_checkin($def_start_time_str,
                $def_end_time_str);

        }
        ////set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->data['organizer_nav'] = 'yes';
        
        $this->template->set_layout('event_organizer_layout')->enable_parser(false)->
            title($this->page_title)->build('event_checkin', $this->data);
    }
    public function event_create_ticket($id)
    {

        $this->form_validation->set_rules('ticket_name0', 'Ticket name', 'required');

        if ($this->form_validation->run() == true) {
            $this->event_model->insert_event_ticket($id); //insert ticket
            redirect('event/organize/' . $id);
            exit;
        } else {
            print_r($this->input->post());
        }
    }
    
    public function ticket_add_seat_from_id($id)
    {
        if(is_ajax())
        {            
            $this->data['i'] = $id;
            $this->data['td'] = $this->event_model->get_ticket_detail_by_id($id,"id, max_number");
            $this->template->enable_parser(false)->title(SITE_NAME )->build('ticket_add_seat_from_id', $this->data);
        }
        
    }
    
    public function update_seats()
    {
        // print_r($_GET);
        if(is_ajax()){
            if ($_GET['from_name'] == '') {
                echo "empty";
            } else {
                $val = $_GET['from_name'];
                $id = $_GET['ticket_id'];
                $totalticketsold = $this->event_model->get_total_tick_sold($id);
                if ($totalticketsold > $val) {
                    echo "value_exceed";
                } else {
                    $data = array('max_number' => $val);
    
                    $this->db->where('id', $id);
                    $this->db->update('es_event_ticket', $data);
                    echo 'successfully';
                }
            }    
        }
        

    }
    
    function ticket_edit_from_id($id)
    {
        if(is_ajax())
        {            
            $this->data['i'] = $id;
            $this->data['td'] = $this->event_model->get_ticket_detail_by_id($id);
            $this->template->enable_parser(false)->title(SITE_NAME )->build('ticket_edit_from_id', $this->data);
        }
    }
    
    function edit_ticket_name()
    {
        if (is_ajax()) {
            $id = $this->input->get('ticket_id');
            $time = $this->event_model->get_created_time($id);
            $ctime = $time->created_date;
            $dateFromDatabase = strtotime($ctime);
            $dateTwelveHoursAgo = strtotime("-48 hours");

            if ($dateFromDatabase >= $dateTwelveHoursAgo) {
                // less than 48 hours ago
                $name = $this->input->get('from_name');
                $this->load->model('email_model');
                $this->load->library('email');
                //configure mail
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = true;
                $config['mailtype'] = 'html';
                $config['protocol'] = 'sendmail';
                $this->email->initialize($config);
                //get subjet & body
                $template = $this->email_model->get_email_template("ticket-notification");

                $user_emails = $this->event_model->get_email_of_ticket_buyer($id);
                if ($user_emails) {                    
                    //echo $this->db->last_query();
                    //exit;
                    //print_r($template);
                    
                        $subject = $template['subject'];
                        $emailbody = $template['email_body'];
                    
                    if (isset($subject) && isset($emailbody)) {

                        //parse email


                        $parseElement = array("EMAIL" => 'user', "OLDTICKETNAME" => $this->input->get('ticket_name'),
                            "NEWTICKETNAME" => $name, "SITENAME" => ROOT_SITE_PATH);

                        $subject = $this->email_model->parse_email($parseElement, $subject);
                        $emailbody = $this->email_model->parse_email($parseElement, $emailbody);
                        $emaillss = $this->input->get('from_email');
                        //set the email things
                        foreach ($user_emails as $ur):
                            $this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
                            $this->email->to($ur->email);
                            $this->email->subject($subject);
                            $this->email->message($emailbody);
                            $this->email->send();
                        endforeach;
                        //echo $this->email->print_debugger();exit;
                        /*test email from localhost*/
                        //$headers = "MIME-Version: 1.0" . "\r\n";
//                        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//                        $headers .= "From: " . CONTACT_EMAIL . "" . "\r\n";
//                        foreach ($user_emails as $ur):
//                            mail($ur->email, $subject, $emailbody, $headers);
//                        endforeach;

                        $data = array('name' => $name);
                        $this->db->where('id', $id);
                        $this->db->update('es_event_ticket', $data);

                    }

                    echo $name . '@#@' . $id. '@#@' ."Can change only name as at least one ticket has been sold.";
                } else {                    
                    $web_fee_include_in_ticket = (($this->input->get('web_fee_included_in_ticket0')) ==
                        'on') ? '1' : '0';
                    $conversion = 1;
                    if (strtolower($this->input->get('paid_free_select0', true)) == 'paid') {
                        $your_price = $this->input->get('ticket_your_price0') / $conversion;                        
                        //$website_fee = WEBSITE_FEE / 100 * $your_price + WEBSITE_FEE_PRICE;
                        $website_fee = $your_price - (($your_price - WEBSITE_FEE_PRICE)/(1 + (WEBSITE_FEE /100)));
                        $ticket_price = (($this->input->get('web_fee_included_in_ticket0')) == 'on') ? $your_price :
                            $your_price + $website_fee;
                    } else {
                        $your_price = $website_fee = $ticket_price = 0; //for free ticket
                    }
                    $data = array(
                        'name' => $name, 
                        'currency' => 'USD',
                        'symbol' => 'USD',
                        'price' => $your_price, 
                        'start_date' => date('Y-m-d h:m:s', strtotime($this->input->get('ticket_start_date0', true))), 
                        'end_date' => date('Y-m-d h:m:s',strtotime($this->input->get('ticket_end_date0', true))),
                        'website_fee' => $website_fee,
                        'ticket_price' => $ticket_price, 
                        'web_fee_include_in_ticket' => $web_fee_include_in_ticket,
                        'paid_free' => $this->input->get('paid_free_select0', true), 
                    );
                    $this->db->where('id', $id);
                    $this->db->update('es_event_ticket', $data);
                    echo $name . '@#@' . $id . '@#@' . $this->general->price($ticket_price - $website_fee) .'@#@'.$this->general->price($ticket_price) . '@#@' . $this->input->get('paid_free_select0', true);

                }

            } else {
                echo "1";
                exit;
            }

        }
    }
    function delete_ticket()
    {
        if (is_ajax()) {
            $id = $this->input->post('id');
            $ticket_sold = $this->event_model->get_total_tick_sold($id);
            if ($ticket_sold) {
                echo '0';
            } else {
                $this->db->where('id', $id);
                $this->db->delete('es_event_ticket');
                //echo $this->db->last_query();
                echo '1';
            }
        }
    }
    
    function delete_promotion_code()
    {
        if (is_ajax()) {
            $id = $this->input->post('id');            
            $promotion_code_used = $this->event_model->get_promotion_code_used($id);
           //echo $promotion_code_used;
            if ($promotion_code_used) {
                echo '0';
            } else {
                $this->db->where('id', $id);
                $this->db->delete('es_promotional_code');
                //echo $this->db->last_query();
                echo '1';
            }
        }
    }
    
    function change_checkin()
    {

        $time = $this->input->post('tickets_date');
        $def_time = explode(',', $time);
        $def_start_time = trim($def_time[0]);
        $def_end_time = trim($def_time[1]);
        $def_start_time1 = strtotime($def_start_time);
        $def_end_time1 = strtotime($def_end_time);
        $def_end_time_str = date('Y-m-d H:i:s', $def_end_time1);
        $def_start_time_str = date('Y-m-d H:i:s', $def_start_time1);
        $data['default_check_in'] = $this->event_model->get_default_checkin($def_start_time_str,
            $def_end_time_str);
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->template->set_layout('event_organizer_layout')->enable_parser(false)->
            title($this->page_title)->build('event_checkin', $this->data);

    }
    function change_checking()
    {
        if (is_ajax()) {
            $id = $this->input->post('id');
            $value = $this->input->post('value');
            $data = array('check_in' => $value);
            $this->db->where('id', $id);
            $this->db->update('es_event_ticket_order', $data);
        }
    }
    function add_attendees($event_id)
    {
        $is_organizer = $this->general->is_organizer_of_event($event_id); //check for organizer
        if (!$is_organizer) {
            $this->session->set_flashdata('error', $this->lang->line('not_authorized_user'));
            redirect('organizer/event', 'refresh');
            exit;
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($event_id,
                'organizer');
        }

        if (!$data_event) {
            $this->session->set_flashdata('error',
                $this->lang->line('no_event_found_blocked'));
            redirect('organize/event', 'refresh');
            exit;
        }
        $active_event = $this->data['active_event'] = $this->event_model->is_active_event($event_id);
        
        if (isset($_POST['order_btn']) and !empty($_POST['order_btn'])) {
            $discount = 0;
            $promotion_code_id = 0;
            /*promotional code start*/
            if (isset($_POST['promotional_code']) and !empty($_POST['promotional_code'])) {
                $promotional_code = $this->input->post('promotional_code');
                $has_discount = $this->event_model->check_for_promotional_code_discount($promotional_code,
                    $event_id);

                if (!$has_discount) {
                    $this->session->set_flashdata('message',$this->lang->line('wrong_promotion_code_msg'));
                    redirect(site_url("event/view/$id/"));
                    exit;
                } else {
                    $discount = $has_discount->percentage;
                    $promotion_code_id = $has_discount->id;
                }
            }
            $order_id = rand(1000000, 9999999999);
            $token_id = md5($this->session->userdata('session_id'));
            $temp_order_id = $this->event_model->insert_order_temp($event_id, $order_id, $token_id,
                $discount, $promotion_code_id);

            if ($_POST['order_btn'] == 'Register') {
                redirect("event/register/$event_id/$order_id/$token_id/$temp_order_id");
            } else
                if ($_POST['order_btn'] == 'Order Now') {
                    redirect("event/order/$event_id/$order_id/$token_id/$temp_order_id");
                }
        }
        $this->data['ticket_details'] = $this->event_model->get_tickets_of_event($event_id);
        $this->data['navigation'] = 'Add attendees';
        ////set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->template->set_layout('event_organizer_layout')->enable_parser(false)->
            title($this->page_title)->build('add_attendes', $this->data);
    }
    function printAttendes($id)
    {
        $attends = $data['attendes'] = $this->event_model->get_event_all_attendees_details($id);
        //if (!$attends)
            //redirect(site_url("event/organize/" . $id));
        $this->load->view('print_attentes', $data);
        $html = $this->output->get_output();

    }
    function email_attendees($event_id)
    {
        $is_organizer = $this->general->is_organizer_of_event($event_id); //check for organizer
        if (!$is_organizer) {
            $this->session->set_flashdata('error', $this->lang->line('not_authorized_user'));
            redirect('organizer/event', 'refresh');
            exit;
        } else {
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($event_id,
                'organizer');
        }

        if (!$data_event) {
            $this->session->set_flashdata('error',
                $this->lang->line('no_event_found_blocked'));
            redirect('organize/event', 'refresh');
            exit;
        }
        $this->form_validation->set_rules('from_name', 'Name', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('attende_email_description',
            'Email description', 'required');
        $this->form_validation->set_rules('from_email', 'Email', 'required');
        $this->data['navigation'] = 'Add attendees';


        if ($this->form_validation->run() == true) {
            $user_name = $this->input->post('from_name');
            $subject = $this->input->post('subject');
            $emailbody = $this->input->post('attende_email_description');
            $attendes = $this->event_model->get_event_attends_email($event_id);
            //$email_from = $this->input->post('from_email');
            $this->load->library('email');
            //configure mail
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = true;
            $config['mailtype'] = 'html';
            $config['protocol'] = 'sendmail';
            $this->email->initialize($config);
            /*
            foreach ($attendes as $ur):
                $this->email->from($email_from, $user_name);
                $this->email->from($email_from);
                $this->email->to($ur->email);
                $this->email->subject($subject);
                $this->email->message($emailbody);
                $this->email->send();
            endforeach;
            */
            //echo $this->email->print_debugger();exit;
            /*test email from localhost*/
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
            $headers .= "From: " . CONTACT_EMAIL . "" . "\r\n";
            foreach ($attendes as $ur):
                mail($ur->email, $subject, $emailbody, $headers);
            endforeach;
            $this->session->set_flashdata('msgg', $this->lang->line('successful'));
            redirect('event/email_attendees/' . $event_id, 'refresh');
            exit;

        }
        ////set SEO data
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->template->set_layout('event_organizer_layout')->enable_parser(false)->
            title($this->page_title)->build('email_attendes', $this->data);

    }
    function promotion_code($event_id)
    {
        $this->data['id'] = $event_id;
        $is_organizer = $this->general->is_organizer_of_event($event_id); //check for organizer
        if (!$is_organizer) {
            $this->session->set_flashdata('error', $this->lang->line('not_authorized_user'));
            redirect('organizer/event', 'refresh');
            exit;
        } else {
            $active_event = $this->data['active_event'] = $this->event_model->is_active_event($event_id);
            $data_event = $this->data['data_event'] = $this->event_model->get_event_byid($event_id,
                'organizer');
        }

        if (!$data_event) {
            $this->session->set_flashdata('error',
                $this->lang->line('no_event_found_blocked'));
            redirect('organize/event', 'refresh');
            exit;
        }
        $this->data['promtional_details'] = $this->event_model->get_promotion_detail($event_id);
        $this->form_validation->set_rules('percent_off', 'Percentage',
            'required|numeric');
        $this->form_validation->set_rules('start_date', 'start date', 'required');
        $this->form_validation->set_rules('end_date', 'end date', 'required');
        $this->form_validation->set_rules('p_name', 'Name', 'required');
        if ($this->form_validation->run() == true) {
            $this->event_model->insert_promocode($event_id);
            $this->session->set_flashdata('msg', 'Successfully');
            redirect('event/promotion_code/' . $event_id);
        }


        $this->data['navigation'] = 'promotioncode';
        $this->page_title = $data_event->title;
        $this->data['meta_keys'] = $data_event->keywords;
        $this->data['meta_desc'] = $data_event->title;
        $this->data['organizer_nav'] = 'yes';
        
        $this->template->set_layout('event_organizer_layout')->enable_parser(false)->
            title($this->page_title)->build('promotional_code', $this->data);
    }
    function show_sub_category()
    {
        if (is_ajax()) {
            $category = $this->input->post('category');
            $subcategories = $this->data['subcategories'] = $this->category->get_only_sub_category_lists_by_category($category);
            
            if($subcategories){
                foreach ($subcategories as $subcategory):
                    echo '<option value="' . $subcategory->id . '">';
                    
                        echo ucwords($subcategory->sub_type);
                        //echo (!empty($subcategory->sub_sub_type)) ? ' / ' . $subcategory->sub_sub_type :'';
                    
                    
                    echo "</option>";
                endforeach;    
            }else{
                echo "empty";
            }
            

        }
    }
    function autocomplete()
    {
        // no term passed - just exit early with no response
        if (empty($_GET['term']))
            exit;
        $q = strtolower($_GET["term"]);
        // remove slashes if they were magically added
        if (get_magic_quotes_gpc())
            $q = stripslashes($q);
        $autocomplete = $this->general->get_autocomplete_keyword($q);
        //print_r($autocomplete);
        $items = array();
        foreach ($autocomplete as $auto):
            $keyword = $auto->keyword;
            $items = array_merge($items, array($keyword => $keyword));
        endforeach;

        $result = array();
        foreach ($items as $key => $value) {
            if (strpos(strtolower($key), $q) !== false) {
                array_push($result, array("id" => $value, "label" => $key, "value" => strip_tags
                    ($key)));
            }
            if (count($result) > 11)
                break;
        }

        // json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
        echo json_encode($result);


    }

    
    public function paypal()
    {
        //echo $this->session->userdata('orderId');exit;
        $this->load->library('paypal_class');
        if($_SERVER['HTTP_HOST'] == 'buyticket.com' || $_SERVER['HTTP_HOST'] == 'www.buyticket.com')
            $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal url
        else
            $this->paypal_class->paypal_url =  'https://www.sandbox.paypal.com/cgi-bin/webscr'; // testing paypal url        
        $this->paypal_class->add_field('currency_code', 'CHF');
        $this->paypal_class->add_field('business', $this->config->item('bussinessPayPalAccountTest'));
        //$this->paypal_class->add_field('business', $this->config->item('bussinessPayPalAccount'));
        $this->paypal_class->add_field('return', site_url() . '/checkout/success'); // return url
        $this->paypal_class->add_field('cancel_return', site_url() . '/checkout/step4'); // cancel url
        $this->paypal_class->add_field('notify_url', site_url().'/validate/validatePaypal'); // notify url
        $totalPrice = $this->session->userdata('totalPrice');
        $this->paypal_class->add_field('item_name', 'Testingasdfads');
        $this->paypal_class->add_field('amount', 900);
        $this->paypal_class->add_field('custom', $this->session->userdata('orderId'));
        $this->paypal_class->submit_paypal_post(); // submit the fields to paypal
        //$p->dump_fields();	  // for debugging, output a table of all the fields
        exit;
    }

    public function validatePaypal()
    {
        $this->load->library('paypal_class');
        if($_SERVER['HTTP_HOST'] == 'buyticket.com' || $_SERVER['HTTP_HOST'] == 'www.buyticket.com')
            $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';	 // paypal url
        else
            $this->paypal_class->paypal_url ='https://www.sandbox.paypal.com/cgi-bin/webscr'; // testing paypal url
        //
        if ($this->paypal_class->validate_ipn()) {
            $orderId = trim($_POST['custom']);
            $itemName = trim($_POST['item_name']);
            // put your code here
        }
        exit;
    }
    function edit_event_organizer($id)
    {
        if(is_ajax())
        {
            $this->data['meta_keys'] = 'Edit Event Organizer';
            $this->data['organizers_detail'] = $this->event_model->get_edit_organiser($id);
            $this->load->view('organiser_edit', $this->data);    
        }
        
    }
    function edit_event_sponser($id)
    {
        if(is_ajax())
        {
            $this->data['meta_keys'] = 'Edit Event Sponser';
            $this->data['organizers_detail'] = $this->event_model->get_edit_sponser($id);
            $this->load->view('sponser_edit', $this->data);    
        }
        
    }
    function edit_event_performer($id)
    {
        if(is_ajax()){
            $this->data['meta_keys'] = 'Edit Event Performer';
            $this->data['organizers_detail'] = $this->event_model->get_edit_performer($id);
            $this->load->view('performer_edit', $this->data);    
        }
        
    }
    function event_sponser_ajax()
    {
        if (is_ajax()) {
            //echo "hello";
            //print_r($_POST);
            //print_r($_FILES);
            $this->event_model->update_event_sponser();
            exit;
        }
    }
    function event_performer_ajax()
    {
        if (is_ajax()) {            
            $n =  $this->event_model->update_event_performer();
            
            $this->session->flashdata('message',$this->lang->line('update_successfull_message'));
            exit;
        }
    }
    function edit_organizer()
    {
        if(is_ajax()){
            $org_id = $this->input->get('organiser_id');
            $org_name = $this->input->get('organiser_name');
            $organizer_description = $this->input->get('organizer_description');    
        }
        
    }
    function delete_organiser_rel()
    {
        if(is_ajax())
        {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->delete('es_event_organizer_relation');    
        }
        


    }
    function delete_sponser_rel()
    {
        if(is_ajax())
        {
            $id = $this->input->post('id');
            $this->db->where('int', $id);
            $this->db->delete('es_event_sponser');    
        }
        


    }
    function delete_performer_rel()
    {
        if(is_ajax())
        {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->delete('es_performer_relation');    
        }
        


    }

    function order_cancel()
    {
        if (is_ajax()) {
            $id = $this->input->post('temp_id');
            
            /*remove book the ticket for a while*/
            $ticket_ids = $this->general->get_single_record("temp_cart",'ticket_id','id',$id);
            $ticket_nums = $this->general->get_single_record("temp_cart",'ticket_quantity','id',$id);
            $ticket_ids_arr = explode(',',$ticket_ids);
            $ticket_num_arr = explode(',',$ticket_nums);
            foreach($ticket_ids_arr as $key=>$tic_id){
                $ticket_num = intval($ticket_num_arr[$key]);                            
                $this->db->query("UPDATE `es_event_ticket` SET `ticket_used` = `ticket_used` - $ticket_num WHERE `id` = '$tic_id' ");                                                 
            }             
            /*remove book the ticket for a while*/
            
            $this->db->where('id', $id);
            $this->db->delete('es_temp_cart');
            $this->session->set_flashdata('err',
                $this->lang->line('time_for_registration_exceed'));
        }
    }
    
    function zform_for_catalog($country, $city)
    {
        if(is_ajax())
        {
            $this->load->model('event_search_model');
            $this->data['meta_keys'] = 'buyticket';
            $this->data['country'] = $country;
            $this->data['city'] = $city; 
            $this->data['countries'] = $this->general->get_country();
            $this->data['cities'] = $this->event_search_model->get_cities_by_country_name($country);                            
            $this->load->view('zform_for_catalog', $this->data);    
        }
    }
    function city_list()
    {
        if(is_ajax()){
            $this->load->model('event_search_model');
            $country = $this->input->post('countryName');
            $cities = $this->event_search_model->get_cities_by_country_name($country);  
            
            if($cities){
                foreach($cities as $ci):
                    echo "<option value='$ci->city'>$ci->city</option>";
                endforeach;
            }else{
                
            }
        }
    }
    
    function set_cookie_country()
    {
        if(is_ajax())
        {
            //var_dump($_POST);exit;
            if(isset($_POST['country_cookie'])){
                $cookie1 = array('name' => SESSION."country_cookie",'value'  => $_POST['country_cookie'],'expire' => time()+3600*24*30);
                $this->input->set_cookie($cookie1);   
            }
            
            if(isset($_POST['city_cookie'])){
                $cookie2 = array('name' => SESSION."city_cookie",'value'  => $_POST['city_cookie'],'expire' => time()+3600*24*30);
			     $this->input->set_cookie($cookie2);
            }
            
            echo "success";
        }
    }
    
    function show_attendees($ticket_order_id)
    {
        if(is_ajax())
        {
            $attendees = $this->data['attendees'] = $this->event_model->list_ticket_attendees($ticket_order_id); 
            //var_dump($attendees); 
            $this->load->view('show_attendees', $this->data);     
        }
    }
    
    function verify_email()
    {
        if(is_ajax())
        {
            $this->data['email'] = $this->session->userdata(SESSION.'email');
            if($_GET['s']=='yes'){
                
                echo "ok";
                $user_id = $this->session->userdata(SESSION.'user_id');
                $email = $this->session->userdata(SESSION.'email');
                $activation_code = $this->general->random_number();
                $data = array(
    			   'activation_code'=>$activation_code,
                );
                $this->db->where('id',$user_id);
                $this->db->where('email',$email);
                $this->db->update('user',$data); 
                
                $a = $this->event_model->resend_activation_code_email($activation_code, $email); //send mail                    
                echo $a;
                
                       
            }else{
                $this->load->view('verify_email', $this->data);    
            }            
        }
        
    }
    
    function description_only($event_id)
    {
        $this->data['description'] = $this->db->select('description')->where('id',$event_id)->get('es_event')->row()->description;
        $this->load->view('event_description_only', $this->data);   
    }
    
    /*new feature added for buytickat*/
    function datewise()
    {
        /*
        header('Content-type: text/json');
        echo '[';
        $separator = "";
        $days = 16;
         //   echo '  { "date": "2013-03-19 17:30:00", "type": "meeting", "title": "Test Last Year", "description": "Lorem Ipsum dolor set", "url": "" },';
          //  echo '  { "date": "2013-03-23 17:30:00", "type": "meeting", "title": "Test Next Year", "description": "Lorem Ipsum dolor set", "url": "http://www.event3.com/" },';
        
        $i = 1;
            echo $separator;
            $initTime = date("Y")."-".date("m")."-".date("d")." ".date("H").":00:00";
            //$initTime = date("Y-m-d H:i:00");
            echo '  { "date": "2013-04-01 17:30:00", "type": "meeting", "title": "Test Last Year", "description": "Lorem Ipsum dolor set", "url": "" },';
            echo '  { "date": "2013-04-02 17:30:00", "type": "meeting", "title": "Test Last Year", "description": "Lorem Ipsum dolor set", "url": "" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 1 days')); echo '", "type": "meeting", "title": "Project '; echo $i; echo ' meeting", "description": "Lorem Ipsum dolor set", "url": "" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 1 days + 4 hours')); echo '", "type": "demo", "title": "Project '; echo $i; echo ' demo", "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "url": "http://www.event2.com/" },';
        
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 1 days 8 hours')); echo '", "type": "meeting", "title": "Test Project '; echo $i; echo ' Brainstorming", "description": "Lorem Ipsum dolor set", "url": "http://www.event3.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 2 days 3 hours')); echo '", "type": "test", "title": "A very very long name for a f*cking project '; echo $i; echo ' events", "description": "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.", "url": "http://www.event4.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 2 days 3 hours')); echo '", "type": "meeting", "title": "Project '; echo $i; echo ' meeting", "description": "Lorem Ipsum dolor set", "url": "http://www.event5.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 4 days 3 hours')); echo '", "type": "demo", "title": "Project '; echo $i; echo ' demo", "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "url": "http://www.event6.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 7 days 1 hours')); echo '", "type": "meeting", "title": "Test Project '; echo $i; echo ' Brainstorming", "description": "Lorem Ipsum dolor set", "url": "http://www.event7.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 12 days 3 hours')); echo '", "type": "test", "title": "A very very long name for a f*cking project '; echo $i; echo ' events", "description": "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.", "url": "http://www.event8.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 20 days 10 hours')); echo '", "type": "demo", "title": "Project '; echo $i; echo ' demo", "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "url": "http://www.event9.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 22 days 3 hours')); echo '", "type": "meeting", "title": "Test Project '; echo $i; echo ' Brainstorming", "description": "Lorem Ipsum dolor set", "url": "http://www.event10.com/" },';
            echo '  { "date": "'; echo date("Y-m-d H:i:00",strtotime($initTime. ' + 28 days 1 hours')); echo '", "type": "test", "title": "A very very long name for a f*cking project '; echo $i; echo ' events", "description": "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.", "url": "http://www.event11.com/" }';
            $separator = ",";
        
        echo ']';
        */
//        echo '[  { "date": "2013-04-01 17:30:00", "type": "meeting", "title": "Test Last Year", "description": "Lorem Ipsum dolor set", "url": "" },  { "date": "2013-04-02 17:30:00", "type": "meeting", "title": "Test Last Year", "description": "Lorem Ipsum dolor set", "url": "" },  { "date": "2019-03-17 03:00:00", "type": "meeting", "title": "Project 1 meeting", "description": "Lorem Ipsum dolor set", "url": "" },  { "date": "2019-03-17 07:00:00", "type": "demo", "title": "Project 1 demo", "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "url": "http://www.event2.com/" },  { "date": "2019-03-17 11:00:00", "type": "meeting", "title": "Test Project 1 Brainstorming", "description": "Lorem Ipsum dolor set", "url": "http://www.event3.com/" },  { "date": "2019-03-18 06:00:00", "type": "test", "title": "A very very long name for a f*cking project 1 events", "description": "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.", "url": "http://www.event4.com/" },  { "date": "2019-03-18 06:00:00", "type": "meeting", "title": "Project 1 meeting", "description": "Lorem Ipsum dolor set", "url": "http://www.event5.com/" },  { "date": "2019-03-20 06:00:00", "type": "demo", "title": "Project 1 demo", "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "url": "http://www.event6.com/" },  { "date": "2019-03-23 04:00:00", "type": "meeting", "title": "Test Project 1 Brainstorming", "description": "Lorem Ipsum dolor set", "url": "http://www.event7.com/" },  { "date": "2019-03-28 06:00:00", "type": "test", "title": "A very very long name for a f*cking project 1 events", "description": "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.", "url": "http://www.event8.com/" },  { "date": "2019-04-05 13:00:00", "type": "demo", "title": "Project 1 demo", "description": "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.", "url": "http://www.event9.com/" },  { "date": "2019-04-07 06:00:00", "type": "meeting", "title": "Test Project 1 Brainstorming", "description": "Lorem Ipsum dolor set", "url": "http://www.event10.com/" },  { "date": "2019-04-13 04:00:00", "type": "test", "title": "A very very long name for a f*cking project 1 events", "description": "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.", "url": "http://www.event11.com/" }]';
//echo '[{"url":"event/view/15/test events","title":"test events","description":"sports / Football","date":"2019-04-01 07:00:00"},{"url":"event/view/14/Test events","title":"Test events","description":"religious / lesson","date":"2019-04-02 08:00:00"},{"url":"event/view/13/Fashion Show Summer","title":"Fashion Show Summer","description":"entertainment / contest","date":"2019-06-01 09:00:00"}]';
//exit;
        $this->load->model('event_search_model');

        $event_arr = $this->event_search_model->getAllEvents();
        //echo "<pre>";
        //var_dump($event_arr);        
        echo json_encode($event_arr);
        exit;
    }
    /*new feature added for buytickat*/
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
