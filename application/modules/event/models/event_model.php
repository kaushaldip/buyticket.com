<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }


    public $validate_settings = array(array('field' => 'event_title', 'label' =>
        'Event title', 'rules' => 'trim|required'), array('field' => 'physical_address',
        'label' => 'Venue', 'rules' => 'trim|required'), array('field' =>
        'event_website', 'label' => 'Website', 'rules' => 'trim'), array('field' =>
        'event_description', 'rules' => ''), array('field' => 'ticket_name0',
        'rules' => 'trim'), array('field' => 'ticket_quantity0', 'rules' => 'trim'),
        array('field' => 'ticket_start_date0', 'rules' => 'trim'), array('field' =>
        'ticket_your_price0', 'rules' => 'trim'),
        //array('field' => 'check_captcha', 'rules' => 'required|trim'),
        );

    public $validate_settings_ticket = array(array('field' => 'name', 'label' =>
        'Ticket Name', 'rules' => 'trim|required'), array('field' => 'max_number',
        'label' => 'Maximum number', 'rules' => 'trim|is_natural'), array('field' =>
        'start_date', 'label' => 'Start Date', 'rules' => 'trim|required'), array('field' =>
        'end_date', 'label' => 'End Date', 'rules' => 'trim|required'), array('field' =>
        'currency', 'rules' => 'trim'), array('field' => 'price', 'label' => 'Price',
        'rules' => 'trim|number'), array('field' => 'web_fee_included_in_ticket',
        'rules' => 'trim'), //array('field' => 'payment_method_fee','label' => 'Payment method fee' , 'rules' =>'trim|number' ),
        //array('field' => 'affiliate_rate','label' => 'Affiliate rate' , 'rules' =>'trim|decimal' ),

    );
    /*old one*/
    public function get_email_setting_byemailcode($emailcode)
    {
        $query = $this->db->get_where('email_settings', array("email_code " => $emailcode));

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }

        return false;
    }

    public function update_email_settings()
    {
        $data = array('subject' => $this->input->post('subject', true), 'email_body' =>
            $this->input->post('content', true), 'last_update' => $this->general->
            get_local_time('time'));

        $email_code = $this->uri->segment(3);
        $this->db->where('email_code', $email_code);
        $this->db->update('email_settings', $data);
    }
    /*old one*/
    public function insert_record($status_s)
    {

        if ($this->session->userdata(SESSION . 'organizer') == '1' && $status_s == '1') {
            $publish = 1;
        } else {
            //change for new registered user to be organizer
            //$array_data11 = array('organizer' => '2', );
            //$this->db->where("id", $this->session->userdata(SESSION . 'user_id'));
            //$this->db->update("user", $array_data11);
            //change for new registered user to be organizer

            $publish = 0;
        }
        
        $logo = $this->general->uploadImage('event_logo', 'event','100','100');
        $date_id = $this->session->userdata(SESSION . 'date_id');
        $specific_email = $this->input->post('specific_email');
        $s_email = 0;
        if ($specific_email):
            $s_email = join(",", $specific_email);
            
        endif;
        
        
        
        $affiliate_referral_rate = ($this->input->post('affilate_event', true) !='yes')? 0 :$this->input->post('affiliate_referral_rate', true);        

        $array_data = array(
                    'organizer_id' => $this->session->userdata(SESSION .'user_id'), 
                    'title' => $this->input->post('event_title', true), 
                    'event_type_id' => $this->input->post('event_type_id', true), 
                    'logo' => $logo, 
                    'description' => $this->input->post('event_description', true), 
                    'frequency' => $this->input->post('date_type', true),
                    'start_date' => $this->general->get_date($this->input->post('start_date', true)),
                    'end_date' => $this->general->get_date($this->input->post('end_date', true)),
                    'date_id' => ($date_id) ? $date_id : "", 
                    'date_time_detail' => $this->input->post('date_time_detail', true), 
                    'target_gender' => $this->input->post('target_gender', true),
                    'website' => $this->input->post('event_website', true),//'keywords' => $this->input->post('keywords',TRUE),
                    'status' => $this->input->post('status', true), 
                    'created_date' => $this->general->get_local_time('time'), 
                    'updated_date' => $this->general->get_local_time('time'), 
                    'extra_performer' => 'yes', 
                    'affiliate_referral_rate' => $affiliate_referral_rate, 
                    'publish' => $publish,
                    'show_url' => $this->input->post('op', true), 
                    'specific_url' => $s_email,
                    );


        $this->db->insert('event', $array_data);
        //echo $this->db->last_query();exit;
        $this->session->unset_userdata(SESSION . 'date_id');
        
        $last_event_id = $this->db->insert_id();
        
        $this->email_to_specific_emails_of_event($s_email, $last_event_id); //send email to all
        
        return $last_event_id;
    }

    public function insert_record_old()
    {
        $days = "";
        foreach ($this->input->post('days') as $day) {
            $days .= $day . ",";
        }
        $logo = $this->general->uploadImage('logo', 'event');

        $extra_performer = ($this->input->post('change_performer') == 'on') ? 'yes' :
            'no';

        $array_data = array('organizer_id' => $this->session->userdata(SESSION .
            'user_id'), 'title' => $this->input->post('title', true), 'event_type_id' => $this->
            input->post('event_type_id', true), 'logo' => $logo, 'description' => $this->
            input->post('description', true), 'frequency' => $this->input->post('frequency', true),
            'days' => $days, 'start_date' => $this->input->post('start_date', true),
            'end_date' => $this->input->post('end_date', true), 'if_never_end' => ($this->
            input->post('if_never_end') == 'on') ? 'yes' : 'no', 'custom_date' => $this->
            input->post('custom_date', true), 'target_gender' => $this->input->post('target_gender', true),
            'website' => $this->input->post('website', true), 'keywords' => $this->input->
            post('keywords', true), 'created_date' => $this->general->get_local_time('time'),
            'updated_date' => $this->general->get_local_time('time'), 'extra_performer' => $extra_performer, );

        $this->db->insert('event', $array_data);

        return $this->db->insert_id();
    }
    public function update_record($id, $status_s)
    {
        if ($this->session->userdata(SESSION . 'organizer') == '1' && $status_s == '1') {
            $publish = 1;
        } else {
            $publish = 0;
        }
        
        $s_email = '';        
        
        $affiliate_referral_rate = '0.00';
        if($this->input->post('affilate_event') == 'yes')
        {
            $affiliate_referral_rate = $this->input->post('affiliate_referral_rate', true);
        }
        
        if($this->input->post('status', true) == '1'){ //public event
            $show_url = '1';
            $event_type_id = $this->input->post('event_type_id', true);
        }else{ //private event
            $event_type_id = 0;
            $show_url = $this->input->post('op', true);
            if($show_url == '0'){
                $specific_email = $this->input->post('specific_email');
                if ($specific_email):
                    $specific_email = preg_replace( '/\s+/', ' ', $specific_email );
                    $s_email = join(",", $specific_email);        
                endif;    
            }
            
        }
        $extra_performer = ($this->input->post('change_performer') == 'on') ? 'yes' : 'no';
        $date_id = $this->session->userdata(SESSION . 'date_id');
        //echo $date_id;exit; 
        
        $array_data = array(
            'organizer_id' => $this->session->userdata(SESSION .'user_id'), 
            'title' => $this->input->post('event_title', true), 
            'event_type_id' =>$event_type_id, 
            'description' => $this->input->post('event_description'),
            'frequency' => $this->input->post('date_type', true), 
            'start_date' => $this->general->get_date($this->input->post('start_date', true)), 
            'end_date' => $this->general->get_date($this->input->post('end_date', true)), 
            'date_id' => ($date_id) ? $date_id :"", 
            'date_time_detail' => $this->input->post('date_time_detail', true),
            'target_gender' => $this->input->post('target_gender', true), 
            //'website' => $this->input->post('event_website', true),
            //'keywords' => $this->input->post('keywords',TRUE),
            'status' => $this->input->post('status', true),
            // 'created_date' => $this->general->get_local_time('time'),
            'updated_date' => $this->general->get_local_time('time'), 
            'extra_performer' =>'yes', 
            'affiliate_referral_rate' => $affiliate_referral_rate, //$this->input->post('affiliate_referral_rate', true),
            'publish' => $publish, 
            'show_url' => $show_url,
            'specific_url' => $s_email, );


        if (($_FILES['event_logo']['size'] > 0)) {
            $logo = $this->general->uploadImage('event_logo', 'event');
            $arry1 = array('logo' => $logo);
            $array_data = array_merge($array_data, $arry1);
            //exit;
        }
        $this->db->where('id', $id);
        $this->db->update('event', $array_data);
        

        $this->email_to_specific_emails_of_event($s_email, $id); //send email to all
        //echo $this->db->last_query();
        /*create subdomain start*/
        //$this->general->create_subdomain($this->input->post('event_website', true),"buyticket", 'cpanel_pass', "buyticket.com");
        /*create subdomain end*/

    }

    public function insert_new_performer($event_id)
    {
        $array_data = array('performer_name' => $this->input->post('performer_name'),
            'performer_type' => $this->input->post('performer_type'),
            'performer_description' => $this->input->post('performer_description'),
            'user_id' => $this->session->userdata(SESSION . 'user_id'), );
        $this->db->insert('performers', $array_data); //insert to new performer into es_performers table
        $performer_id = $this->db->insert_id();


        $array_data1 = array('performer_id' => $performer_id);
        $this->db->where('id', $event_id);
        $this->db->update('event', $array_data1);

    }

    public function insert_existing_performer($event_id)
    {
        $array_data = array('performer_id' => $this->input->post('performer_id'));
        $this->db->where('id', $event_id);
        $this->db->update('event', $array_data);
    }

    public function insert_existing_performer_after_edit($event_id)
    {
        $array_data = array('performer_id' => $this->input->post('performer_check_edit'));
        $this->db->update($event_id, 'event', $array_data);
    }
    public function update_existing_performer($performer_id)
    {
        $array_data = array('name' => $this->input->post('performer_name'), 'type' => $this->
            input->post('performer_type'), 'description' => $this->input->post('performer_description'),
            'user_id' => $this->session->userdata(SESSION . 'user_id'), );
        $this->db->update($performer_id, 'performers', $array_data);
    }
    
    public function event_has_location($event_id)
    {
        $this->db->select('id');
        $query = $this->db->get_where('event_location', array("event_id " => $event_id));

        if ($query->num_rows() > 0) {
            $row =  $query->row();
            return $row->id;
        }

        return false;
    }

    public function update_event_location($output,$event_id)
    {
        //var_dump($output->results[0]);exit;
        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;
        $formatted_address = $output->results[0]->formatted_address;

        $location = $city = $state = $country = $postal_code = "";

        for ($j = 0; $j < count($output->results[0]->address_components); $j++) {
            if ($output->results[0]->address_components[$j]->types[0] == 'locality')
                $city = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] == 'country')
                $country = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] == 'postal_code')
                $postal_code = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] ==
                'administrative_area_level_1')
                $state = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] == 'route')
                $location = $output->results[0]->address_components[$j]->long_name;


        }
        
            $city_en = $city;
        

        $array_data = array('latitude' => $lat, 'longitude' => $long, 'event_id' => $event_id,
            'address' => $formatted_address, 'physical_name' => $this->input->post('physical_address'),
            'location' => $location, 'city' => $city, 
            'city_en' => $city_en,
            'state' => $state, 'country' => $country,
            'postal_code' => $postal_code);
        
        if($this->event_has_location($event_id)){
            $this->db->where('id', $this->event_has_location($event_id));        
            $this->db->update('event_location', $array_data);    
        }else{
            $this->db->insert('event_location', $array_data);    
        }
        
    }
    
    public function insert_event_location($output, $event_id)
    {
        //var_dump($output->results[0]);exit;
        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;
        $formatted_address = $output->results[0]->formatted_address;

        $location = $city = $state = $country = $postal_code = "";

        for ($j = 0; $j < count($output->results[0]->address_components); $j++) {
            if ($output->results[0]->address_components[$j]->types[0] == 'locality')
                $city = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] == 'country')
                $country = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] == 'postal_code')
                $postal_code = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] ==
                'administrative_area_level_1')
                $state = $output->results[0]->address_components[$j]->long_name;
            if ($output->results[0]->address_components[$j]->types[0] == 'route')
                $location = $output->results[0]->address_components[$j]->long_name;


        }
        
            $city_en = $city;
                
        $array_data = array('latitude' => $lat, 'longitude' => $long, 'event_id' => $event_id,
            'address' => $formatted_address, 'physical_name' => $this->input->post('physical_address'),
            'location' => $location, 'city' => $city, 
            'city_en' => $city_en,
            'state' => $state, 'country' => $country,
            'postal_code' => $postal_code);
        $this->db->insert('event_location', $array_data);
    }

    public function insert_event_physical_address_only($event_id)
    {

        $array_data = array('event_id' => $event_id, 'physical_name' => $this->input->
            post('physical_address'), );
        $this->db->insert('event_location', $array_data);
    }

    public function insert_event_ticket($event_id)
    {
        $free_event = 0;
        for ($i = 0; $i < $this->input->post('ticket_count') - 1; $i++) {
            $conversion = 1;

            $web_fee_include_in_ticket = (($this->input->post('web_fee_included_in_ticket'.$i)) == 'on') ? '1' : '0';
            $ticket_prefix = $this->general->getSubString($this->input->post('ticket_name'.$i), '3', 'uc');

            if (strtolower($this->input->post('paid_free_select' . $i, true)) == 'paid' && $this->input->post('ticket_name'.$i)!='') {
                $your_price = $this->input->post('ticket_your_price' . $i) / $conversion;
                //$website_fee = WEBSITE_FEE / 100 * $your_price + WEBSITE_FEE_PRICE;
                $website_fee = $your_price - (($your_price - WEBSITE_FEE_PRICE)/(1 + (WEBSITE_FEE /100)));
                $ticket_price = (($this->input->post('web_fee_included_in_ticket' . $i)) == 'on') ? $your_price : $your_price + $website_fee;
                /*update event table start*/
                $data4 = array('free_paid' => 'paid', );
                $this->db->where('id', $event_id);
                $this->db->update('event', $data4);
                /*update event table end*/                
            } else {
                $your_price = $website_fee = $ticket_price = 0; //for free ticket
                $free_event++;
            }


            if($this->input->post('ticket_name'.$i)!=''){
                $array_data = array(
                'event_id' => $event_id, 
                'name' => $this->input->post('ticket_name'.$i, true), 
                'max_number' => $this->input->post('ticket_quantity' . $i, true),
                'start_date' => $this->general->get_date($this->input->post('ticket_start_date'.$i, true)),
                'end_date' => $this->general->get_date($this->input->post('ticket_end_date'.$i, true)),
                'currency' => 'USD',//$this->input->post('ticket_currency' . $i, true),
                'price' => $your_price, 'website_fee' => $website_fee,
                'web_fee_include_in_ticket' => $web_fee_include_in_ticket, 
                'ticket_price' => $ticket_price,
                'ticket_prefix' => $ticket_prefix,//'payment_method_fee' => $this->input->post('payment_method_fee',TRUE),
                'paid_free' => $this->input->post('paid_free_select' . $i, true),
                'affiliate_rate' => $this->input->post('affiliate_rate' . $i, true), 
                'status' =>'1', 
                );
                $this->db->insert('event_ticket', $array_data);    
            }
            
        }

        if(($this->input->post('ticket_count') - 1)==$free_event && $this->session->userdata(SESSION . 'organizer') == '1')
        {
            /*update event table start*/
            $data5 = array('publish' => '1', );
            $this->db->where('id', $event_id);
            $this->db->update('event', $data5);
            /*update event table end*/ 
        }
        
        $paid_tic = $this->db->select('paid_free')->from('event_ticket')->where(array('event_id'=>$event_id,'paid_free'=>'paid'))->get()->num_rows();
        if($paid_tic > 0)
            $data6 = array('free_paid' => 'paid', );
        else
            $data6 = array('free_paid' => 'free', );
        
        $this->db->where('id', $event_id);
        $this->db->update('event', $data6);


    }

    public function insert_event_organizer($event_id)
    {

        if ($this->input->post('organizer_name', true)) {
            //user_id 	event_id 	name 	logo 	description

            /*multiple images upload*/
            $files = $_FILES;
            $this->load->library('upload');
            $this->load->library('image_lib');
            $organizer_logo = array();
            $cpt = count($_FILES['organizer_logo']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                $new_image = "oraganizer_" . time() . rand(0, 99) . "." . pathinfo($files['organizer_logo']['name'][$i],
                    PATHINFO_EXTENSION);
                $_FILES['organizer_logo']['name'] = $new_image;
                $_FILES['organizer_logo']['type'] = $files['organizer_logo']['type'][$i];
                $_FILES['organizer_logo']['tmp_name'] = $files['organizer_logo']['tmp_name'][$i];
                $_FILES['organizer_logo']['error'] = $files['organizer_logo']['error'][$i];
                $_FILES['organizer_logo']['size'] = $files['organizer_logo']['size'][$i];

                $this->upload->initialize($this->set_upload_options("organizer"));
                $this->upload->do_upload('organizer_logo');
                if ($this->upload->display_errors()) {
                    $this->error_img = $this->upload->display_errors();
                    return false;
                } else {
                    $data = $this->upload->data();
                }

                //resize image
                $this->general->resize_image($data['file_name'], 'thumb_' . $data['raw_name'] .
                    $data['file_ext'], 'organizer', 100, 100);
                //echo $new_image;
                $organizer_logo[] = $new_image; //$files['organizer_logo']['name'][$i];
            }
            //var_dump($organizer_logo);exit;
            /*multiple images upload*/


            foreach ($this->input->post('organizer_name') as $key => $organizer_name):
                $organizer_descriptions = $this->input->post('organizer_description');
                //$organizer_logo = $this->general->uploadImage("organizer_logo",'organizer',$key);
                $array_data = array('user_id' => $this->session->userdata(SESSION . 'user_id'),
                    //'event_id' => $event_id,
                    'name' => $organizer_name, 'logo' => $organizer_logo[$key], 'description' => $organizer_descriptions[$key], );
                $this->db->insert('event_organizer', $array_data);
                $organizer_id = $this->db->insert_id();

                $array_data_r = array('organizer_id' => $organizer_id, 'event_id' => $event_id, );
                $this->db->insert('event_organizer_relation', $array_data_r);
            endforeach;
        }

    }
    public function insert_event_performer_multi($event_id)
    {
        $check = $this->input->post('performer_name', true);
        $check = array_filter($check);
        if (!empty($check)) {
            foreach ($this->input->post('performer_name') as $key => $performer_name):
                $performer_descriptions = $this->input->post('performer_description');
                $performer_type = $this->input->post('performer_type');
                $array_data = array('user_id' => $this->session->userdata(SESSION . 'user_id'),
                    //'event_id' => $event_id,
                    'performer_name' => $performer_name, 'performer_type' => $performer_type[$key],
                    'performer_description' => $performer_descriptions[$key], );
                $this->db->insert('es_performers', $array_data);
                //echo $this->db->last_query();
                $performer_id = $this->db->insert_id();

                $array_data_r = array('performer_id' => $performer_id, 'event_id' => $event_id, );
                $this->db->insert('es_performer_relation', $array_data_r);
            endforeach;
        }

    }


    public function insert_event_keyword($event_id)
    {
        $this->db->where('event_id', $event_id);
        $this->db->delete('event_keyword');
        $keywords = $this->input->post('event_keywords', true);        
        
        $arr_key = explode(',', $keywords);    
               
        if (is_array($arr_key)) {
            foreach ($arr_key as $keyword):
                $keyword = ltrim($keyword);            
                if($keyword !=''){
                    $array_data_r = array('keyword' => $keyword, 'event_id' => $event_id, );
                    $this->db->insert('event_keyword', $array_data_r);    
                }                
            endforeach;
        } else {
            if($keywords!=''){
                $keywords = ltrim($keywords);                
                $array_data_r = array('keyword' => $keywords, 'event_id' => $event_id, );
                $this->db->insert('event_keyword', $array_data_r);    
            }
            
        }


    }

    public function insert_existing_event_organizer($event_id, $count_existing_organizers)
    {
        for ($i = 0; $i < $count_existing_organizers; $i++) {
            if ($this->input->post('old_organizer' . $i)) {
                $array_data_r = array('organizer_id' => $this->input->post('old_organizer' . $i),
                    'event_id' => $event_id, );
                $this->db->insert('event_organizer_relation', $array_data_r);
            }
        }
    }
    public function insert_existing_event_performer($event_id, $count_existing_performer)
    {
        for ($i = 0; $i < $count_existing_performer; $i++) {
            if ($this->input->post('old_performer' . $i)) {
                $array_data_r = array('performer_id' => $this->input->post('old_performer' . $i),
                    'event_id' => $event_id, );
                $this->db->insert('es_performer_relation', $array_data_r);
            }
        }
    }
    private function set_upload_options($folder)
    {
        //  upload an image options
        $config = array();
        $config['upload_path'] = './' . UPLOAD_FILE_PATH . $folder . "/"; //define in constants
        $config['allowed_types'] = 'gif|jpg|png';
        $config['remove_spaces'] = true;
        $config['max_size'] = '50000';
        $config['max_width'] = '10240';
        $config['max_height'] = '10240';

        return $config;
    }

    public function insert_event_sponsor($event_id)
    {
        if ($this->input->post('sponsor_name')) {
            //event_id name slug title logo capital
            /*multiple images upload*/
            $files = $_FILES;
            $this->load->library('upload');
            $this->load->library('image_lib');
            $organizer_logo = array();
            $cpt = count($_FILES['sponsor_logo']['name']);
            for ($i = 0; $i < $cpt; $i++) {
                //$_FILES['sponsor_logo']['name']= $files['sponsor_logo']['name'][$i];
                $new_image = "sponsor_" . time() . rand(0, 99) . "." . pathinfo($files['sponsor_logo']['name'][$i],
                    PATHINFO_EXTENSION);
                $_FILES['sponsor_logo']['name'] = $new_image;
                $_FILES['sponsor_logo']['type'] = $files['sponsor_logo']['type'][$i];
                $_FILES['sponsor_logo']['tmp_name'] = $files['sponsor_logo']['tmp_name'][$i];
                $_FILES['sponsor_logo']['error'] = $files['sponsor_logo']['error'][$i];
                $_FILES['sponsor_logo']['size'] = $files['sponsor_logo']['size'][$i];

                $this->upload->initialize($this->set_upload_options("sponsor"));
                $this->upload->do_upload('sponsor_logo');
                if ($this->upload->display_errors()) {
                    $this->error_img = $this->upload->display_errors();
                    return false;
                } else {
                    $data = $this->upload->data();
                }

                //resize image
                $this->general->resize_image($data['file_name'], 'thumb_' . $data['raw_name'] .
                    $data['file_ext'], 'sponsor', 100, 100);

                $sponsor_logo[] = $new_image; //$files['sponsor_logo']['name'][$i];
            }
            /*multiple images upload*/
            foreach ($this->input->post('sponsor_name') as $key => $sponsor_name):
                $sponsor_descriptions = $this->input->post('sponsor_description');
                $sponsor_types = $this->input->post('sponsor_type');
                //$sponsor_logos = $this->input->post('sponsor_logo');
                //$sponsor_logo = $this->general->uploadImage($sponsor_logos[$key],'sponsor');
                $array_data = array('event_id' => $event_id, 'name' => $sponsor_name, 'type' =>
                    $sponsor_types[$key], 'logo' => $sponsor_logo[$key], 'slug' => $this->general->
                    get_nice_name($sponsor_name), 'title' => $sponsor_name, 'sponsor_description' =>
                    $sponsor_descriptions[$key], );
                $this->db->insert('event_sponser', $array_data);
            endforeach;
        }
    }
    public function get_all_event($status = '', $admin = '', $perpage, $offset)
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        if ($status <> '')
            $this->db->where("e.status = '$status'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            //  $this->db->where("now() < e.end_date"); //compare with event duration
        }
        $this->db->where("e.publish = '1'");


        $this->db->order_by("e.updated_date", "desc");
        $this->db->limit($perpage, $offset);
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else
            return false;

    }

    public function get_all_event_admin($status = '')
    {
        $this->db->select('e.id,e.title,e.logo,e.name, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.publish, e.visit_count,e.created_date, e.updated_date, u.id as userid, u.email, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');

        $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
        if ($status <> '')
            $this->db->where("e.status = '$status'");
        else
            $this->db->where("e.status <> 0");

        $this->db->order_by("e.updated_date", "desc");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else
            return false;

    }

    public function get_all_event_number($status = '', $admin = '')
    {
        $this->db->select('e.id,e.title,e.logo,e.name, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');

        if ($status <> '')
            $this->db->where("e.status = '$status'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            //  $this->db->where("now() < e.end_date"); //compare with event duration
        }
        $this->db->where("e.publish = '1'");


        $this->db->order_by("e.updated_date", "desc");

        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->num_rows();
            $query->free_result();
            return $data;
        } else
            return false;

    }
    public function get_search_event($status = '', $admin = '', $perpage, $offset)
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        if ($status <> '')
            $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            $this->db->where($status); //compare with event duration
        }

        $this->db->order_by("e.updated_date", "desc");
        $this->db->limit($perpage, $offset);

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else
            return false;

    }
    public function get_search_event_number($status = '', $admin = '')
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        if ($status <> '')
            $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            $this->db->where($status); //compare with event duration
        }


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->num_rows();
            $query->free_result();
            return $data;
        } else
            return false;

    }
    public function get_search_event_find($status = '', $admin = '', $sq = '', $perpage,
        $offset)
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_keyword AS k', 'e.id = k.event_id');
        $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            //compare with event duration
        }
        if (!empty($status))
            $this->db->where("k.keyword = '$status'");
        if (!empty($sq))
            $this->db->where("$sq");
        $this->db->group_by('e.title');
        $this->db->order_by("e.updated_date", "desc");
        $this->db->limit($perpage, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();

            return $data;
        } else
            return false;

    }
    public function get_search_event_find_number($status = '', $admin = '', $sq = '')
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_keyword AS k', 'e.id = k.event_id');
        $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            //compare with event duration
        }
        if (!empty($status))
            $this->db->where("k.keyword = '$status'");
        if (!empty($sq))
            $this->db->where("$sq");
        $this->db->group_by('e.title');

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->num_rows();
            $query->free_result();

            return $data;
        } else
            return false;

    }

    public function get_search_event_find_loc($status = '', $admin = '', $country, $country1, $city, $lat, $lng,
        $perpage, $offset)
    {
        $this->db->select("e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type,
                    e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, 
                    l.address, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id', 'left');
        if (!empty($status))
            $this->db->join('es_event_keyword AS k', 'e.id = k.event_id');
        $this->db->where("e.status = '1'");
        $this->db->where("e.publish = '1'");


        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            //compare with event duration
        }
        if (!empty($status))
            $this->db->where("k.keyword = '$status'");
        if (!empty($sq))
            $this->db->where("$sq");
        //$this->db->where("(l.city = '$city' OR l.country = '$country')" );  
        if(!empty($lng) and (!empty($lat))){
            $this->db->select("l.city,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( $lng) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance");
            $this->db->having(array('distance <' => 100));
            $this->db->group_by("l.city");
        }     
        
        if($country)
            $this->db->where('l.country', $country);
               
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');
        $this->db->order_by("e.updated_date", "desc");
        $this->db->limit($perpage, $offset);
        $query = $this->db->get();
        //echo $country;
        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();

            return $data;
        } else
            return false;

    }
    
    public function get_search_event_find_loc_final($status = '', $admin = '', $country='',$country1='',
        $city='', $lat='', $lng='',$perpage='', $offset='')
    {
        $this->db->select("e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type,
                    e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date,
                    l.physical_name, l.address, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id', 'left');
        if (!empty($status))
            $this->db->join('es_event_keyword AS k', 'e.id = k.event_id');
        $this->db->where("e.status = '1'");
        $this->db->where("e.publish = '1'");

        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            //$this->db->where("u.organizer = '1'");
            $this->db->where("u.status = '1'"); 
            //compare with event duration
        }
        if (!empty($status))
            $this->db->where("k.keyword = '$status'");
        if (!empty($sq))
            $this->db->where("$sq");
        //if((!empty($country)))
//            $this->db->where("(l.country = '$country')" );
        if(!empty($lng) and (!empty($lat))){
            $this->db->select("l.city,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( $lng) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance");
            $this->db->having(array('distance <' => 100));
            $this->db->group_by("l.city");
        }  
        
        if($country)
            $this->db->where("(l.country = '$country1' OR l.country = '$country')"); 
        if($city!='')
            $this->db->where("(city_en = '$city')");         
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');
        $this->db->order_by("e.updated_date", "desc");
        
        if(!empty($perpage))
            $this->db->limit($perpage, $offset);

        $query = $this->db->get();
//    echo "<pre>";
//    print_r($query);
//        echo $this->db->last_query();
//        exit;

        
        if ($query->num_rows() > 0) {
            return $query;
        } else
            return false;

    }
    
    
    public function get_search_event_find_loc_number($status = '', $admin = '', $country='',$country1='',
        $city='', $lat='', $lng='')
    {
        $this->db->select("e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type,
                    e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date,
                    l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id', 'left');
        if (!empty($status))
            $this->db->join('es_event_keyword AS k', 'e.id = k.event_id');
        $this->db->where("e.status = '1'");
        $this->db->where("e.publish = '1'");

        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            //$this->db->where("u.organizer = '1'");
            $this->db->where("u.status = '1'"); 
            //compare with event duration
        }
        if (!empty($status))
            $this->db->where("k.keyword = '$status'");
        if (!empty($sq))
            $this->db->where("$sq");
        //if((!empty($country)))
//            $this->db->where("(l.country = '$country')" );
        if(!empty($lng) and (!empty($lat))){
            $this->db->select("l.city,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( $lng) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance");
            $this->db->having(array('distance <' => 100));
            $this->db->group_by("l.city");
        }  
        
        if($country)
            $this->db->where("(l.country = '$country1' OR l.country = '$country')");      
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');

        $query = $this->db->get();
    
        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            $data = $query->num_rows();
            $query->free_result();

            return $data;
        } else
            return false;

    }

    public function get_search_event_type($status = '', $admin = '', $perpage, $offset)
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        if ($status <> '')
            $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            $this->db->where("t.name ='$status'"); //compare with event duration
        }
        $this->db->where("e.publish = '1'");
        $this->db->order_by("e.updated_date", "desc");
        $this->db->limit($perpage, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else
            return false;

    }
    public function get_search_event_type_number($status = '', $admin = '')
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type, e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        if ($status <> '')
            $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            $this->db->where("t.name ='$status'"); //compare with event duration
        }
        $this->db->where("e.publish = '1'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->num_rows();
            $query->free_result();
            return $data;
        } else
            return false;

    }
    public function get_search_event_sub_type($status = '', $admin = '', $perpage, $offset)
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type,e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        if ($status <> '')
            $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            $this->db->where("t.sub_type ='$status'"); //compare with event duration
        }
        $this->db->where("e.publish = '1'");
        $this->db->order_by("e.updated_date", "desc");
        $this->db->limit($perpage, $offset);


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else
            return false;

    }
    public function get_search_event_sub_type_number($status = '', $admin = '')
    {
        $this->db->select('e.id,e.title,e.logo,e.name,t.name as type_name,t.sub_type as sub_type,e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        if ($status <> '')
            $this->db->where("e.status = '1'");
        if ($admin == '') {
            $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
            $this->db->where("t.sub_type ='$status'"); //compare with event duration
        }
        $this->db->where("e.publish = '1'");


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->num_rows();
            $query->free_result();
            return $data;
        } else
            return false;

    }


    public function get_event_byid($id, $admin = '')
    {
        $this->db->select('e.id,e.affiliate_referral_rate, e.title,e.withlist, e.event_type_id, e.logo,e.name,e.description, e.organizer_id, e.frequency, e.start_date, e.end_date, e.date_id,e.date_time_detail,  e.`target_gender`,e.website , e.status, e.keywords, e.publish, e.extra_performer, e.show_url, e.specific_url, e.free_paid, l.physical_name,l.latitude, l.longitude, l.address, u.first_name, u.last_name');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->where("e.id = '$id'");
        if ($admin == '')
            $this->db->where("(e.publish = '1' OR e.status = '1' OR e.status = '2')");
        
        //$this->db->where("(if(e.specific_url = '', e.status = '2' OR e.publish = '1' OR e.status = '1', (e.status = '2'  AND e.specific_url LIKE '$myemail') OR e.status = '1'))");

        //$this->db->where("now() BETWEEN e.start_date AND e.end_date");
        //$this->db->or_where("now() = e.custom_date ");
        $this->db->limit('1');


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    
    public function get_event_description_byid($id, $admin = '')
    {
        $this->db->select('e.id,e.description');
        $this->db->from('es_event AS e');
        $this->db->where("e.id = '$id'");
        
        $this->db->limit('1');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
    }
    public function get_event_byid_popup($id, $admin = '')
    {
        $this->db->select('e.id,e.affiliate_referral_rate, e.title,e.withlist, e.event_type_id, e.logo,e.name,e.description, e.organizer_id, e.frequency, e.start_date, e.end_date, e.date_id,e.date_time_detail,  e.`target_gender`,e.website , e.status, e.keywords, e.extra_performer, l.physical_name,l.latitude, l.longitude, l.address, u.first_name, u.last_name');
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->where("e.id = '$id'");
        if (empty($admin)) //$this->db->where("e.status = '1'");
            //$this->db->where("e.status != '0'");
        //$this->db->where("now() BETWEEN e.start_date AND e.end_date");
        //$this->db->or_where("now() = e.custom_date ");

            $this->db->limit('1');


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function check_event_active($event_id)
    {
        $this->db->select('e.id');
        $this->db->from('es_event AS e');
        $this->db->where("e.id = '$event_id'");
        $this->db->where("e.status = '1'");
        $this->db->where("now() BETWEEN e.start_date AND e.end_date");
        $this->db->or_where("now() = e.custom_date ");
        $this->db->limit('1');


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    public function get_event_short_info_by_id($id, $admin = '')
    {
        $this->db->select('e.id, e.title, e.logo,e.name, e.start_date, e.end_date, e.custom_date, e.status');
        $this->db->from('es_event AS e');
        $this->db->where("e.id = '$id'");
        if (empty($admin))
            $this->db->where("e.status = '1'");
        //$this->db->where("now() BETWEEN e.start_date AND e.end_date");
        //$this->db->or_where("now() = e.custom_date ");
        $this->db->limit('1');


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_tickets_of_event($event_id, $admin = '')
    {
        $this->db->select('*');
        $this->db->from('es_event_ticket');
        $this->db->where("event_id = '$event_id'");
        if ($admin == '')
            $this->db->where("status = '1'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    public function get_keywords_of_event($event_id)
    {
        $this->db->select('keyword');
        $this->db->from('event_keyword');
        $this->db->where("event_id = '$event_id'");
        $this->db->group_by('keyword');
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    
    public function get_ticket_detail_by_id($id,$select="*")
    {
        $this->db->select("$select");
        $this->db->from('es_event_ticket');
        $this->db->where("id = '$id'");
        
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_sponsors_of_event($event_id)
    {
        $this->db->select('*');
        $this->db->from('es_event_sponser');
        $this->db->where("event_id = '$event_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function get_category_detail_of_event($event_type_id)
    {
        $this->db->select('name, sub_type, sub_sub_type, paid_event');
        $this->db->from('es_event_type');
        $this->db->where("id = '$event_type_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_extra_performers_of_event($event_id)
    {
        $this->db->select('p.*,e.performer_id,e.id');
        $this->db->from('es_event as e');
        $this->db->join('es_performers as p', "p.id=e.performer_id");
        $this->db->where("e.id = '$event_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    
    public function get_extra_performers_of_event_new($event_id)
    {
        $this->db->select('p.*,e.performer_id,e.id');
        $this->db->from('es_performer_relation as ep');
        $this->db->join('es_event as e', "ep.event_id = e.id");
        $this->db->join('es_performers as p', "p.id = ep.performer_id");
        $this->db->where("e.id = '$event_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function get_performers_of_event($event_type_id)
    {
        $this->db->select('p.*,t.performer,t.id');
        $this->db->from('es_event_type as t');
        $this->db->join('es_performer as p', "p.id = t.performer");
        $this->db->where("t.id = '$event_type_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function get_organizers_of_event($event_id)
    {
        $this->db->select('*');
        $this->db->from('event_organizer as eo');
        $this->db->join('event_organizer_relation as eor', 'eor.organizer_id = eo.id');
        $this->db->where("eor.event_id = '$event_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function get_sponser_of_event($event_id)
    {
        $this->db->select('*');
        $this->db->from('es_event_sponser as es');
        //$this->db->join('event_organizer_relation as eor','eor.organizer_id = eo.id');
        $this->db->where("es.event_id = '$event_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function get_previous_organizers_of_user($user_id)
    {
        $this->db->select('id, user_id,name');
        $this->db->from('event_organizer');
        $this->db->where("user_id = '$user_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }


    public function already_organizer_of_event($organizer_id, $event_id)
    {
        $this->db->select('id');
        $this->db->from('event_organizer_relation');
        $this->db->where("event_id = '$event_id'");
        $this->db->where("organizer_id = '$organizer_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    public function already_performer_of_event($performer_id, $event_id)
    {
        $this->db->select('id');
        $this->db->from('es_performer_relation');
        $this->db->where("event_id = '$event_id'");
        $this->db->where("performer_id = '$performer_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    public function already_organizer_of_event_details($organizer_id, $event_id)
    {
        $this->db->select('*,event_organizer_relation.id as relation_id,es_event_organizer.id as organizer_id');
        $this->db->from('event_organizer_relation');
        $this->db->join('es_event_organizer',
            'es_event_organizer.id=event_organizer_relation.organizer_id');
        $this->db->where("event_id = '$event_id'");


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    public function already_performer_of_event_details($organizer_id, $event_id)
    {
        $this->db->select('*,es_performer_relation.id as relation_id,es_performers.id as performer_id');
        $this->db->from('es_performer_relation');
        $this->db->join('es_performers',
            'es_performers.id=es_performer_relation.performer_id');
        $this->db->where("event_id = '$event_id'");


        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    function get_edit_organiser($organiser_id)
    {
        $this->db->select('*');
        $this->db->from('es_event_organizer');

        $this->db->where("id = '$organiser_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    function get_edit_sponser($organiser_id)
    {
        $this->db->select('*');
        $this->db->from('es_event_sponser');

        $this->db->where("int = '$organiser_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    function get_edit_performer($organiser_id)
    {
        $this->db->select('*');
        $this->db->from('es_performers');

        $this->db->where("id = '$organiser_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function count_previous_organizers_of_user($user_id)
    {
        $this->db->select('id, user_id,name');
        $this->db->from('event_organizer');
        $this->db->where("user_id = '$user_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->num_rows();
    }
    public function count_previous_performer_of_user($user_id)
    {
        $this->db->select('id');
        $this->db->from('es_performers');
        $this->db->where("user_id = '$user_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->num_rows();
    }
    public function get_sold_tickets($ticket_id)
    {
        $this->db->select('invoice_id');
        $this->db->from('es_transaction');
        $this->db->where("ticket_id = '$ticket_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;

        return $query->num_rows();


    }
    public function get_performers_of_user($user_id)
    {
        $this->db->select('*');
        $this->db->from('performers');
        $this->db->where("user_id = '$user_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function get_performer($performer_id)
    {
        $this->db->select('*');
        $this->db->from('performers');
        $this->db->where("id = '$performer_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function create_date_time()
    {
        $date_id = $this->session->userdata(SESSION . "date_id");
        if (isset($date_id)) {
            $this->db->where('id', $date_id);
            $this->db->delete('event_date');
        }
        $repeat_weekday = "";
        $repeat_day = "";
        if ($this->input->post('type') == 'Weekly') {
            foreach ($this->input->post('days') as $day) {
                $repeat_weekday .= $day . ",";
            }
        } else
            if ($this->input->post('type') == 'Monthly') {
                $check_repeat = $this->input->post('check_repeat');
                if ($check_repeat == 'day')
                    $repeat_day = $this->input->post('repeat_day');
                else {
                    $repeat_weekday = $this->input->post('repeat_rank') . "-" . $this->input->post('repeat_weekday');
                }

            }


        $array_data = array('type' => $this->input->post('type'), 'repeat' => $this->input->post('repeat'), 
            'start_time' => $this->general->get_date($this->input->post('start_time')), 
            'end_time' => $this->general->get_date($this->input->post('end_time')),
            'end' => $this->input->post('end'), 'repeat_weekday' => $repeat_weekday,
            //$this->input->post('repeat_weekday'),
            'repeat_day' => $repeat_day, );
        $result = $this->db->insert('event_date', $array_data);
        $date_new_id = $this->db->insert_id();
        $this->session->set_userdata(array(SESSION . 'date_id' => $date_new_id));
        if ($result)
            return true;
        else
            return false;
    }
    public function get_date_detail($event_id)
    {
        $this->db->select("e.date_id, e.start_date, e.end_date, d . * , d.id AS date_id");
        $this->db->from('event as e');
        $this->db->join('event_date as d', "d.id=e.date_id");
        $this->db->where("e.id = '$event_id'");

        $query = $this->db->get();
        $sql = "select * from es_event where id='$event_id'";
        $q = $this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        } elseif ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function last_date_from_event_date_by_id($id)
    {
        $this->db->select("end");
        $this->db->from('event_date');
        $this->db->where("id = '$id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->end;
        }
        return false;
    }

    public function get_ticket_name_from_id($ticket_id)
    {
        $this->db->select('name');
        $this->db->from('event_ticket');
        $this->db->where("id = '$ticket_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->row();
            return $res->name;
        }
        return false;
    }

    public function get_event_name_from_id($event_id)
    {
        $this->db->select('title');
        $this->db->from('event');
        $this->db->where("id = '$event_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->row();
            return $res->title;
        }
        return false;
    }

    public function get_ticket_detail_from_id($ticket_id)
    {
        $this->db->select('name,symbol,price,website_fee,ticket_price,paid_free, web_fee_include_in_ticket, max_number');
        $this->db->from('event_ticket');
        $this->db->where("id = '$ticket_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function insert_order_temp($event_id, $order_id, $token_id, $discount, $promotion_code_id)
    {
        $ticket_id = implode(',', $this->input->post('ticket_id'));
        $ticket_quantity = implode(',', $this->input->post('ticket_no'));
        
        $url = ($_POST['order_btn'] == ($this->lang->line('register_btn'))? "event/register/" : "event/order/"). $event_id ."/". $order_id . "/". $token_id ."/"; 

        $array_data = array(
            'order_id' => $order_id, 
            'token_id' => $token_id, 
            'event_id' => $event_id, 
            'ticket_id' => $ticket_id, 
            'ticket_quantity' => $ticket_quantity,
            'discount' => $discount, 
            'promotion_code_id' => $promotion_code_id, 
            'date_time' => $this->input->post('tickets_date'), 
            'current_date' => $this->general->get_local_time('time'),
            'url' => $url, 
        );
        $result = $this->db->insert('temp_cart', $array_data);
        $temp_cart_id = $this->db->insert_id();
        return $temp_cart_id;
    }

    public function get_temp_cart_detail($id, $order_id, $token_id, $temp_cart_id)
    {
        $this->db->select('*');
        $this->db->from('temp_cart');
        $this->db->where("id = '$temp_cart_id' and event_id = '$id' and order_id='$order_id' and token_id = '$token_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function check_paypal_pay()
    {
        //load module
        $this->load->library('paypal/paypal');

        $total = 0; //initialize
        $total_arr = $this->input->post('total');
        foreach ($this->input->post('ticket_id') as $key => $ticket_id) {
            $total += $total_arr[$key];
        }

        $paymentInfo['Member']['first_name'] = $this->input->post('first_name');
        $paymentInfo['Member']['last_name'] = $this->input->post('last_name');
        //        $paymentInfo['CreditCard']['credit_type'] = $this->input->post('credit_card_type');
        //
        //        $paymentInfo['CreditCard']['card_number'] = $this->input->post('credit_card_number');
        //        $paymentInfo['CreditCard']['expiration_month'] = $this->input->post('month');
        //
        //        $paymentInfo['CreditCard']['expiration_year'] = $this->input->post('year');
        //        $paymentInfo['CreditCard']['cv_code'] = $this->input->post('csc');
        //        $paymentInfo['Member']['billing_address'] = $this->input->post('billing_address');
        $paymentInfo['Member']['billing_address2'] = $this->input->post('billing_address2');
        $paymentInfo['Member']['billing_country'] = $this->input->post('billing_country');
        $paymentInfo['Member']['billing_city'] = $this->input->post('billing_city');
        $paymentInfo['Member']['billing_state'] = $this->input->post('billing_state');
        $paymentInfo['Member']['billing_zip'] = $this->input->post('billing_postal_code');
        $paymentInfo['Order']['theTotal'] = $total;
        $paymentInfo['Bill']['month'] = urlencode("Month");
        $paymentInfo['bill']['frequency'] = urlencode("1");
        //for recuring
        $result = $this->paypal->DoDirectPayment($paymentInfo);
        //$ack = strtoupper($result["ACK"]);
        return $result;
    }

    public function insert_ticket_order($event_id)
    {
        //load module
        $this->load->model('users/register_module');
        //load module
        $this->load->model('users/login_module');

        /*user block start*/
        if ($this->session->userdata(SESSION . 'user_id')) {
            $user_id = $this->session->userdata(SESSION . 'user_id');
            $data1 = array('first_name' => $this->input->post('first_name', true),
                'last_name' => $this->input->post('last_name', true), );
            $this->db->where("id", $this->session->userdata(SESSION . 'user_id'));
            $this->db->update("user", $data1);

            if ($this->input->post('ticket_type') == 'paid') {
                $data2 = array('address' => $this->input->post('billing_address', true),
                    'address1' => $this->input->post('billing_address2', true), 'city' => $this->
                    input->post('billing_city', true), 'state' => $this->input->post('billing_state', true),
                    'zip' => $this->input->post('billing_postal_code', true), 'country' => $this->
                    input->post('billing_country', true), );
                $this->db->where("user_id", $this->session->userdata(SESSION . 'user_id'));
                $this->db->update("user_detail", $data2);
            }

        } else {

            //get random 10 numeric degit
            $activation_code = $this->general->random_number();
            $ip_address = $this->general->get_real_ipaddr();
            $parent = (($this->input->cookie(SESSION . "referral_id", true))) ? '1' : '0';
            $referal_id = (($this->input->cookie(SESSION . "referral_id", true))) ? $this->
                input->cookie(SESSION . "referral_id", true) : '0';
            $password = base64_encode($this->input->post('password'));

            //set member info
            $data = array('email' => $this->input->post('email', true), 'first_name' => $this->
                input->post('first_name', true), 'last_name' => $this->input->post('last_name', true),
                'password' => $password, 'reg_ip_address' => $ip_address, 'activation_code' => $activation_code,
                'reg_date' => $this->general->get_local_time('time'), 'parent' => $parent,
                'referral_id' => $referal_id, 'status' => '1', );

            if ($this->session->userdata('is_fb_user') == "Yes") {
                $data['status'] = '1';
                $data['is_fb_user'] = 'Yes';
            } else {
                $data['is_fb_user'] = 'No';
            }


            //Running Transactions
            $this->db->trans_start();
            //insert records in the database
            $this->db->insert('user', $data);
            $user_id = $this->user_id = $this->db->insert_id();

            //insert records in user_detail table


            if ($this->input->post('ticket_type') == 'paid') {
                $data1 = array('user_id' => $this->db->insert_id(), 'address' => $this->input->
                    post('billing_address', true), 'address1' => $this->input->post('billing_address2', true),
                    'city' => $this->input->post('billing_city', true), 'state' => $this->input->
                    post('billing_state', true), 'zip' => $this->input->post('billing_postal_code', true),
                    'country' => $this->input->post('billing_country', true), );
            } else {
                $data1 = array('user_id' => $this->db->insert_id());
            }
            $this->db->insert('user_detail', $data1);


            //Complete Transactions
            $this->db->trans_complete();

            if ($this->db->trans_status() === false) {
                return "system_error";
            } else {
                $this->register_module->reg_confirmation_email($activation_code);
            }
        }
        /*user block ends*/

        $ticket_quantity_arr = $this->input->post('ticket_no');
        $ticket_type_arr = $this->input->post('ticket_type');
        $payment_status_arr = $this->input->post('payment_status');
        $currency_arr = $this->input->post('currency');
        $price_arr = $this->input->post('price');
        $fee_arr = $this->input->post('fee');
        $total_arr = $this->input->post('total');
        $temp_date = $this->input->post('year') . "-" . $this->input->post('month');
        ;
        $expiration_date = date('Y-m-d', strtotime($temp_date));

        //var_dump($fallback);exit;
        foreach ($this->input->post('ticket_id') as $key => $ticket_id):
            $ticket_quantity = $ticket_quantity_arr[$key];
            $ticket_type = $ticket_type_arr[$key];
            if ($this->input->post('ticket_type') == 'paid' || is_array($fallback)) {
                $payment_status = 'pending'; //(strtoupper($fallback['ACK'])=="SUCCESS")?'complete' :'pending';
                $currency = $fallback['CURRENCYCODE'];
                $transaction_method = 'paypal';
                $transaction_id = ""; //$fallback['TRANSACTIONID'];
                $transaction_amt = ''; // $fallback['AMT'];
            } else {
                $payment_status = $payment_status_arr[$key];
                $currency = $currency_arr[$key];
                $transaction_method = '';
                $transaction_id = '';
                $transaction_amt = '';
            }
            $price = $price_arr[$key];
            $fee = $fee_arr[$key];
            $total = $total_arr[$key];


            $array_data = array('user_id' => $user_id, 'event_id' => $event_id, 'order_id' =>
                $this->input->post('order_id'), 'order_for_date_start' => $this->input->post('order_for_date_start'),
                'order_for_date_end' => $this->input->post('order_for_date_end'), 'first_name' =>
                $this->input->post('first_name'), 'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'), 'billing_country' => $this->input->post
                ('billing_country'), 'billing_address' => $this->input->post('billing_address'),
                'billing_address2' => $this->input->post('billing_address2'), 'billing_city' =>
                $this->input->post('billing_city'), 'billing_state' => $this->input->post('billing_state'),
                'billing_postal_code' => $this->input->post('billing_postal_code'),
                //                        'credit_card_type' => $this->input->post('credit_card_type'),
                //                        'credit_card_number' => $this->input->post('credit_card_number'),
            //                        'expiration_date' => $expiration_date,
            //                        'csc' => $this->input->post('csc'),
            //
            'ticket_id' => $ticket_id, 'ticket_quantity' => $ticket_quantity, 'ticket_type' =>
                $ticket_type, 'currency' => (!empty($currency)) ? $currency : '0', 'price' => (!
                empty($price)) ? $price : '0', 'fee' => (!empty($fee)) ? $fee : '0', 'total' =>
                (!empty($total)) ? $total : '0', 'order_date' => $this->general->get_local_time
                ('time'), 'payment_status' => $payment_status, 'transaction_method' => $transaction_method,
                'transaction_id' => $transaction_id, 'transaction_amt' => $transaction_amt, );
            $result = $this->db->insert('event_ticket_order', $array_data);

            /*affiliate_event_earning start*/
            $referral_event_url_id = $this->input->cookie(SESSION . "referral_event_url_id");
            if (!empty($referral_event_url_id)) {
                $referral_event_url = $this->affiliate_model->
                    get_referral_event_url_detail_by_id($referral_event_url_id);
                if ($referral_event_url->event_id == $event_id and !empty($price) and $price !=
                    0) {
                    $array_data_r = array('event_id' => $event_id, 'order_id' => $this->input->post
                        ('order_id'), 'user_id' => $referral_event_url->user_id, 'organizer_id' => $referral_event_url->
                        organizer_id, 'url_id' => $referral_event_url_id, 'ticket_id' => $ticket_id,
                        'affiliate_percent' => $referral_event_url->affiliate_percent, 'earning' => $price *
                        $referral_event_url->affiliate_percent / 100, );
                    $this->db->insert('affiliate_event_earning', $array_data_r);
                }

            }
            /*affiliate_event_earning end*/

        endforeach;

        if (!empty($referral_event_url_id)) {
            delete_cookie(SESSION . "referral_event_url_id");
        }

        return true;

    }

    public function delete_temp_order($order_id)
    {
        $this->db->where('order_id', $order_id);
        $this->db->delete('temp_cart');

    }

    public function get_ticket_order_detail($event_id, $order_id)
    {
        $this->db->select('*,sum( `ticket_quantity` ) as total_tickets');
        $this->db->from('event_ticket_order');
        $this->db->where("event_id = '$event_id' and order_id = '$order_id' ");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function event_visit_counter($id)
    {
        $this->db->query("UPDATE `es_event` SET `visit_count` = visit_count + 1 WHERE `id` = '$id'");
        $this->db->query("INSERT INTO `es_event_view` (`id`, `event_id`, `datetime`) VALUES (NULL, '$id', CURRENT_TIMESTAMP);");
    }

    public function get_total_sold_ticket($id)
    {
        $q = $this->db->query("SELECT DATE_FORMAT(order_date,'%Y-%m-%d') as on_date, SUM(ticket_quantity) AS total_quantity
FROM  `es_event_ticket_order` 
WHERE event_id =$id and payment_status='complete' and create_ticket='yes' and refund_id = 0
group by on_date");


        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;

    }
    
    public function get_total_sold_ticket_pending($id)
    {
        $q = $this->db->query("SELECT DATE_FORMAT(order_date,'%Y-%m-%d') as on_date, SUM(ticket_quantity) AS total_quantity
            FROM  `es_event_ticket_order` 
            WHERE event_id =$id and payment_status='PENDING' and refund_id = 0
            group by on_date");


        if ($q->num_rows() > 0) {
            $res = $q->row();
            return $res->total_quantity;
        }
        return false;

    }
    public function get_total_sold_ticket_free($id)
    {
        $this->db->select('SUM(ticket_quantity) AS total_quantity');
        $this->db->from('es_event_ticket_order');
        $this->db->where("event_id = '$id'");
        $this->db->where("payment_status", "complete");
        $this->db->where("create_ticket", "yes");
        $this->db->where("(ticket_type = '' OR ticket_type = 'free')");
        //$this->db->or_where("ticket_type", "free");
        $total = 0;
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->row();
            return $res->total_quantity;
        }
        return false;

    }
    public function get_total_sold_ticket_paid($id)
    {
        $this->db->select('SUM(ticket_quantity) AS total_quantity');
        $this->db->from('es_event_ticket_order');
        $this->db->where("event_id = '$id'");
        $this->db->where("payment_status", "complete");
        $this->db->where("create_ticket", "yes");
        $this->db->where("refund_id", "0");
        $this->db->where("ticket_type", "paid");

        $total = 0;
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $res = $query->row();
            return $res->total_quantity;
        }
        return false;
    }
    public function get_event_attends($id)
    {

        $this->db->select('*')->from('es_event_ticket_sold as ets');
        $this->db->join('es_event_ticket_order as eto', 'ets.ticket_order_id=eto.id');
        $this->db->group_by('ets.ticket_order_id');
        $this->db->where('eto.event_id', $id);
        $this->db->where('eto.refund_id', '0');
        $this->db->order_by('ets.id','DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }
    
    public function get_event_all_attendees_details($id)
    {
        //$this->db->select('*')->from('es_event_ticket_sold as ets');
        //$this->db->join('es_event_ticket_order as eto', 'ets.ticket_order_id=eto.id');
        $this->db->select('id, order_id, order_form_detail, total,order_date, ticket_id, ticket_quantity')->from('es_event_ticket_order as eto');        
        $this->db->where('eto.event_id', $id);
        $this->db->where('eto.refund_id', '0');        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }
    public function get_total_tick_sold($ticket_id)
    {
        $this->db->select('ticket_quantity');
        $this->db->from('es_event_ticket_order');
        $this->db->where("ticket_id = '$ticket_id'");
        //$this->db->where("payment_status", "complete");

        $total = 0;
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $no = $query->result();
            foreach ($no as $n) {
                $total += $n->ticket_quantity;

            }

            return $total;
        }
        return false;
    }
    public function get_total_tick_sold_new($ticket_id, $email, $order_id)
    {
        $this->db->select('ticket_quantity');
        $this->db->from('es_event_ticket_order');
        $this->db->where("ticket_id = '$ticket_id' and email = '$email' and order_id = '$order_id'");
        //$this->db->where("payment_status", "complete");

        $total = 0;
        $query = $this->db->get();

        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $no = $query->result();
            foreach ($no as $n) {
                $total += $n->ticket_quantity;

            }

            return $total;
        }
        return false;
    }
    
    
    public function get_promotion_code_used($id)
    {
        $this->db->select('used');
        $this->db->where("used > 0");
        $this->db->where('id',$id);
        $this->db->from('es_promotional_code');
        
        
        $q = $this->db->get();
        //return $this->db->last_query();exit;
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }


    /*credit card validation start*/
    public function creditCard_check($ccnumber, $cardtype = '', $allowTest = false)
    {
        // Check for test cc number
        if ($allowTest == false && $ccnumber == '4111111111111111') {
            return false;
        }

        $ccnumber = preg_replace('/[^0-9]/', '', $ccnumber); // Strip non-numeric characters

        $creditcard = array('visa' => "/^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/", 'mastercard' =>
            "/^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/", 'discover' => "/^6011-?\d{4}-?\d{4}-?\d{4}$/",
            'amex' => "/^3[4,7]\d{13}$/", 'diners' => "/^3[0,6,8]\d{12}$/", 'bankcard' =>
            "/^5610-?\d{4}-?\d{4}-?\d{4}$/", 'jcb' => "/^[3088|3096|3112|3158|3337|3528]\d{12}$/",
            'enroute' => "/^[2014|2149]\d{11}$/", 'switch' =>
            "/^[4903|4911|4936|5641|6333|6759|6334|6767]\d{12}$/");

        if (empty($cardtype)) {
            $match = false;
            foreach ($creditcard as $cardtype => $pattern) {
                if (preg_match($pattern, $ccnumber) == 1) {
                    $match = true;
                    break;
                }
            }

            if (!$match) {
                return false;
            }
        } elseif (@preg_match($creditcard[strtolower(trim($cardtype))], $ccnumber) == 0) {
            return false;
        }

        $return['valid'] = $this->ccnumber_check($ccnumber);
        $return['ccnum'] = $ccnumber;
        $return['type'] = $cardtype;
        return $return;
    }

    public function ccnumber_check($ccnum)
    {
        $checksum = 0;
        for ($i = (2 - (strlen($ccnum) % 2)); $i <= strlen($ccnum); $i += 2) {
            $checksum += (int)($ccnum{$i - 1});
        }

        // Analyze odd digits in even length strings or even digits in odd length strings.
        for ($i = (strlen($ccnum) % 2) + 1; $i < strlen($ccnum); $i += 2) {
            $digit = (int)($ccnum{$i - 1}) * 2;
            if ($digit < 10) {
                $checksum += $digit;
            } else {
                $checksum += ($digit - 9);
            }
        }

        if (($checksum % 10) == 0) {
            return true;
        } else {
            return false;
        }
    }
    /*credit card validation end*/

    function get_email_of_ticket_buyer($ticket_id)
    {
        $this->db->distinct();
        $this->db->select('email');
        $this->db->where('ticket_id', $ticket_id);
        $query = $this->db->get('es_event_ticket_order');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;

    }
    function get_created_time($ticket_id)
    {
        $this->db->select('created_date');
        $this->db->where('id', $ticket_id);
        $query = $this->db->get('es_event_ticket');
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    function get_default_checkin($start_t, $end_t)
    {
        $this->db->select('*,ets.id as etsid')->from('es_event_ticket_order as ets');
        $this->db->join('es_event_ticket as eto', 'ets.ticket_id=eto.id');


        $this->db->where(array('ets.order_for_date_start' => $start_t, 'ets.order_for_date_end' => $end_t, 'ets.payment_status' => 'COMPLETE','ets.create_ticket'=>'yes', 'ets.refund_complete'=>'no', 'ets.refund_id' => '0'));
        
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    function get_total_tick_checkin($id)
    {
        $this->db->select('check_in')->from('es_event_ticket_order');
        $this->db->where('id', $id);
        $query = $this->db->get();
        // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    function get_ticket_type_sale($id)
    {
        $q = $this->db->query("SELECT SUM( ticket_quantity ) AS total_quantity
                FROM  `es_event_ticket_order` 
                WHERE ticket_id =$id
                AND payment_status =  'complete'
                AND create_ticket =  'yes'
                AND refund_id = 0
                GROUP BY ticket_id");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_affiliate_detail_from_event_id($event_id)
    {
        $q = $this->db->query("SELECT u.`referral_id` , u.`referral_url_id` , e.id, e.organizer_id
                FROM es_event AS e
                LEFT JOIN `es_user` AS u ON u.id = e.organizer_id
                WHERE e.id = '$event_id'");
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function insert_affiliate_earning($row, $order_id)
    {
        $fee_arr = $this->input->post('fee');
        $ticket_quantity_arr = $this->input->post('ticket_no');
        $fee = 0;
        foreach ($this->input->post('ticket_id') as $key => $ticket_id):
            $fee += ($fee_arr[$key] * $ticket_quantity_arr[$key]);
        endforeach;
        //referral_id 	referral_url_id 	id 	organizer_id
        $array_data = array('user_id' => $row->referral_id, 'order_id' => $order_id,
            'referee_id' => $row->organizer_id, 'url_id' => $row->referral_url_id, 'revenue' =>
            $fee, 'earning' => $fee * AFFILIATE_REFERRAL_RATE / 100, 'affiliate_percent' =>
            AFFILIATE_REFERRAL_RATE, );

        $this->db->insert('affiliate_referral_earning', $array_data);
        return true;
    }
    function email_organizer_of_event($org_id)
    {
        $this->db->select('email');
        $query = $this->db->get_where('es_user', array('id' => $org_id));
        return $query->row()->email;
    }
    function get_event_attends_email($id)
    {
        $this->db->select('*')->from('es_event_ticket_sold as ets');
        $this->db->join('es_event_ticket_order as eto', 'ets.ticket_order_id=eto.id');
        $this->db->group_by('eto.email');
        $this->db->where('eto.event_id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }
    function event_page_view_count($event_id)
    {
        $query = $this->db->get_where('es_event_view', array('event_id' => $event_id));
        return $query->num_rows();

    }

    function event_page_view($event_id)
    {
        $query = $this->db->query("SELECT DATE_FORMAT(datetime,'%Y-%m-%d') as on_date,COUNT('event_id') AS count_event
                FROM  `es_event_view` 
                WHERE event_id =$event_id
                GROUP BY on_date");
        return $query->result();

    }
    function insert_promocode($id)
    {        
        $start_time = $this->general->get_date($this->input->post('start_date', true));       
        $end_time = $this->general->get_date($this->input->post('end_date', true));
        $percent = $this->input->post('percent_off');
        $checkbox = $this->input->post('is_upload');
        if ($checkbox == 1) {
            $loop = $this->input->post('multiple_number_single');
            $val_tot = 1;
        } else {
            $loop = 1;
            $val_tot = $this->input->post('multiple_number');
        }

        for ($i = 0; $i < $loop; $i++):
            if($loop == 1)
                $p_code = $this->general->get_nice_name($this->input->post('p_name'));
            else
                $p_code = $this->general->genRandomString(8);
            $data = array('event_id' => $id, 'p_code' => $p_code, 'start_time' => $start_time,
                'end_time' => $end_time, 'percentage' => $percent, 'total' => $val_tot, 'p_name' =>
                $this->input->post('p_name'));
            $this->db->insert('es_promotional_code', $data);
        endfor;
    }

    function get_promotion_detail($id)
    {
        $query = $this->db->get_where('es_promotional_code', array('event_id' => $id));
        return $query->result();
    }

    public function check_for_promotional_code_discount($promotional_code, $event_id)
    {
        $this->db->select('percentage,id')->from('promotional_code');
        $this->db->where('event_id', $event_id);
        $this->db->where('p_code', $promotional_code);
        $this->db->where("now() BETWEEN start_time AND end_time");
        $this->db->where("total > used");
        $query = $this->db->get();

        //echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    function get_sale_service_dis($event_id)
    {
        $query = $this->db->query("SELECT SUM(  `ticket_quantity` ) AS total_tickets_sold, SUM(  `total` ) AS total_sales, SUM(`organizer_payment`) AS total_price,  SUM(discount * ticket_quantity) AS total_discount,  SUM(ticket_quantity * fee) AS total_fee, SUM(  `event_referral_payment`+`referral_pay` ) AS affilate_total
            FROM es_event_ticket_order AS eto
            WHERE eto.event_id = '$event_id'
            AND eto.payment_status = 'COMPLETE'
            AND eto.create_ticket = 'yes'
            AND eto.refund_id = 0
            GROUP BY eto.event_id");
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function update_event_organizer()
    {

        if ($this->input->post('organiser_name', true)) {
            //user_id 	event_id 	name 	logo 	description
            $id = $this->input->post('organiser_id');
            /*multiple images upload*/
            $files = $_FILES;
            $this->load->library('upload');
            $this->load->library('image_lib');
            $organizer_name = $this->input->post('organiser_name');

            $organizer_descriptions = $this->input->post('organizer_description');
            if (isset($_FILES['organiser_image'])) {
                $new_image = "oraganizer_" . time() . rand(0, 99) . "." . pathinfo($files['organiser_image']['name'],
                    PATHINFO_EXTENSION);
                $_FILES['organiser_image']['name'] = $new_image;
                $_FILES['organiser_image']['type'] = $files['organiser_image']['type'];
                $_FILES['organiser_image']['tmp_name'] = $files['organiser_image']['tmp_name'];
                $_FILES['organiser_image']['error'] = $files['organiser_image']['error'];
                $_FILES['organiser_image']['size'] = $files['organiser_image']['size'];

                $this->upload->initialize($this->set_upload_options("organizer"));
                $this->upload->do_upload('organiser_image');
                if ($this->upload->display_errors()) {
                    $this->error_img = $this->upload->display_errors();
                    return false;
                } else {
                    $data = $this->upload->data();
                }

                //resize image
                $this->general->resize_image($data['file_name'], 'thumb_' . $data['raw_name'] .
                    $data['file_ext'], 'organizer', 100, 100);
                //echo $new_image;
                $organizer_logo = $new_image; //$files['organizer_logo']['name'][$i];
                $array_data = array('user_id' => $this->session->userdata(SESSION . 'user_id'),
                    //'event_id' => $event_id,
                    'name' => $organizer_name, 'logo' => $organizer_logo, 'description' => $organizer_descriptions, );
                $organizer_image = UPLOAD_FILE_PATH . "organizer/thumb_" . $organizer_logo;
                $organizer_logo = (file_exists($organizer_image)) ? $organizer_image :
                    UPLOAD_FILE_PATH . 'sponsor_logo.jpg';
                echo "<img src='" . base_url() . $organizer_logo . "' >--$organizer_name--$id";
            } else {
                $array_data = array('user_id' => $this->session->userdata(SESSION . 'user_id'),
                    //'event_id' => $event_id,
                    'name' => $organizer_name, 'description' => $organizer_descriptions, );
                echo "<img src='" . $this->input->post('contact_organizer_image') . "' >--$organizer_name--$id";
            }
        }
        //var_dump($organizer_logo);exit;
        /*multiple images upload*/


        //$organizer_logo = $this->general->uploadImage("organizer_logo",'organizer',$key);

        $this->db->where('id', $id);
        $this->db->update('event_organizer', $array_data);

        //                $organizer_id = $this->db->insert_id();
        //
        //                $array_data_r = array(
        //                        'organizer_id' => $organizer_id,
        //                        'event_id' => $event_id,
        //                    );
        //                $this->db->insert('event_organizer_relation', $array_data_r);


    }
    public function update_event_sponser()
    {

        if ($this->input->post('organiser_name', true)) {
            //user_id 	event_id 	name 	logo 	description
            $id = $this->input->post('organiser_id');
            /*multiple images upload*/
            $files = $_FILES;
            $this->load->library('upload');
            $this->load->library('image_lib');
            $organizer_name = $this->input->post('organiser_name');
            $organizer_type = $this->input->post('organiser_type');

            $organizer_descriptions = $this->input->post('organizer_description');
            if (isset($_FILES['organiser_image'])) {
                $new_image = "sponsor_" . time() . rand(0, 99) . "." . pathinfo($files['organiser_image']['name'],
                    PATHINFO_EXTENSION);
                $_FILES['sponsor_logo']['name'] = $new_image;
                $_FILES['sponsor_logo']['type'] = $files['organiser_image']['type'];
                $_FILES['sponsor_logo']['tmp_name'] = $files['organiser_image']['tmp_name'];
                $_FILES['sponsor_logo']['error'] = $files['organiser_image']['error'];
                $_FILES['sponsor_logo']['size'] = $files['organiser_image']['size'];

                $this->upload->initialize($this->set_upload_options("sponsor"));
                $this->upload->do_upload('sponsor_logo');
                if ($this->upload->display_errors()) {
                    $this->error_img = $this->upload->display_errors();
                    return false;
                } else {
                    $data = $this->upload->data();
                }

                //resize image
                $this->general->resize_image($data['file_name'], 'thumb_' . $data['raw_name'] .
                    $data['file_ext'], 'sponsor', 100, 100);
                //echo $new_image;
                $organizer_logo = $new_image; //$files['organizer_logo']['name'][$i];
                $array_data = array( //'event_id' => $this->session->userdata(SESSION.'user_id'),
                    //'event_id' => $event_id,
                'name' => $organizer_name, 'type'=> $organizer_type, 'logo' => $organizer_logo, 'sponsor_description' => $organizer_descriptions, );
                $organizer_image = UPLOAD_FILE_PATH . "sponsor/thumb_" . $organizer_logo;
                $organizer_logo = (file_exists($organizer_image)) ? $organizer_image :
                    UPLOAD_FILE_PATH . 'sponsor_logo.jpg';
                echo "<img src='" . base_url() . $organizer_logo . "' >--$organizer_name--$id--$organizer_type";
            } else {
                $array_data = array( //'user_id' => $this->session->userdata(SESSION.'user_id'),
                    //'event_id' => $event_id,
                'name' => $organizer_name, 'type'=> $organizer_type, 'sponsor_description' => $organizer_descriptions, );
                echo "<img src='" . $this->input->post('contact_organizer_image') . "' >--$organizer_name--$id--$organizer_type";
            }
        }


        $this->db->where('int', $id);
        $this->db->update('es_event_sponser', $array_data);


    }
    public function update_event_performer()
    {
        $check = $this->input->post('performer_name', true);
        //$check=array_filter($check);
        if (!empty($check)) {
            //user_id 	event_id 	name 	logo 	description
            //echo 'asdhkasd---'.$this->input->post('performer_name');
            // exit;
            /*multiple images upload*/


            //var_dump($organizer_logo);exit;
            /*multiple images upload*/

            $id = $this->input->post('performer_id');
            $performer_name = $this->input->post('performer_name');
            $performer_descriptions = $this->input->post('performer_description');
            $performer_type = $this->input->post('performer_type');
            $array_data = array('user_id' => $this->session->userdata(SESSION . 'user_id'),
                //'event_id' => $event_id,
                'performer_name' => $performer_name, 'performer_type' => $performer_type,
                'performer_description' => $performer_descriptions, );


            $this->db->where('id', $id);
            $this->db->update('es_performers', $array_data);
            
            $per_type = $this->db->select('performer_type')->where(array('id'=>$performer_type))->from('es_performer_type')->get()->row();
                $performer_type_name = $per_type->performer_type;

            echo $performer_name . '--' . $id . '--' . $performer_type_name;


        }


    }
    function get_event_keywords($id)
    {
        $query = $this->db->query("SELECT keyword FROM `es_event_keyword` WHERE event_id='$id'");
        if ($query->num_rows() > 0) {
            $keywords = $query->result();
            $i = 1;
            $keyword = '';
            foreach ($keywords as $k):
                if ($i == 1){
                    $keyword .= $k->keyword;
                }                    
                else{
                    
                        $keyword .= ',' . $k->keyword;    
                }
                    
                ++$i;
            endforeach;
            return $keyword;
        }
        return false;

    }
    public function email_create_event($user_id, $event_id)
    {
        //load email library
        $this->load->library('email');
        //configure mail
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        $config['protocol'] = 'sendmail';
        $this->email->initialize($config);


        $this->load->model('email_model');

        //get subjet & body
        $template = $this->email_model->get_email_template("create_event_notification");

        if ($template) {

            $this->db->select('username,email');
            $query = $this->db->get_where('user', array('id' => $user_id));
            $user = $query->row();

            $username = $user->username;
            $useremail = $user->email;

            
                $subject = $template['subject'];
                $emailbody = $template['email_body'];

            $url = site_url('event/view/' . $event_id);
            //check blank valude before send message
            if (isset($subject) && isset($emailbody)) {
                $event_name = $this->input->post('event_title', true);
                $parseElement = array("USERNAME" => $username, "EVENTNAME" => $event_name,
                    "DATE" => $this->general->get_local_time('time'), "SITENAME" => SITE_NAME, "URL" =>
                    $url);

                $subject = $this->email_model->parse_email($parseElement, $subject);
                $emailbody = $this->email_model->parse_email($parseElement, $emailbody);
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
                //                $headers .= "From: " . CONTACT_EMAIL . "" . "\r\n";
                //                mail($useremail, $subject, $emailbody, $headers);
                //                /*test email from localhost*/
                //echo $this->email->print_debugger();exit;
            }
        }

    }
    public function email_update_event($user_id, $event_id)
    {
        //load email library
        $this->load->library('email');
        //configure mail
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        $config['protocol'] = 'sendmail';
        $this->email->initialize($config);


        $this->load->model('email_model');

        //get subjet & body
        $template = $this->email_model->get_email_template("update-event-notification");

        if ($template) {

            $this->db->select('username,email');
            $query = $this->db->get_where('user', array('id' => $user_id));
            $user = $query->row();

            $username = $user->username;
            $useremail = $user->email;


            
                $subject = $template['subject'];
                $emailbody = $template['email_body'];

            $url = site_url('event/view/' . $event_id);
            //check blank valude before send message
            if (isset($subject) && isset($emailbody)) {
                $event_name = $this->input->post('event_title', true);
                $parseElement = array("USERNAME" => $username, "EVENTNAME" => $event_name,
                    "SITENAME" => SITE_NAME, "URL" => $url);

                $subject = $this->email_model->parse_email($parseElement, $subject);
                $emailbody = $this->email_model->parse_email($parseElement, $emailbody);
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
                //                $headers .= "From: " . CONTACT_EMAIL . "" . "\r\n";
                //                mail($useremail, $subject, $emailbody, $headers);
                //                /*test email from localhost*/
                //echo $this->email->print_debugger();exit;
            }
        }

    }
    function get_question_order($event_id)
    {
        $sql = "SELECT order_form_details from es_event where id=$event_id";
        $q = $this->db->query($sql);
        //echo $this->db->last_query();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    function current_url()
    {
        $CI = &get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
    }

    public function has_promotion_code($event_id)
    {
        $this->db->select('id')->from('promotional_code');
        $this->db->where('event_id', $event_id);
        $this->db->where("now() BETWEEN start_time AND end_time");
        $this->db->where("total > used");
        $query = $this->db->get();

        //echo $this->db->last_query();

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;

    }
    
    public function is_active_event($event_id)
    {
        $query=$this->db->query("SELECT  e.id
                    FROM (
                    `es_event` AS e
                    )
                    LEFT JOIN es_event_date as eed on  e.date_id = eed .id
                    
                    WHERE  
                        IF(e.date_id > 0, NOW( ) < eed.end, NOW( ) < e.end_date)                        
                        AND e.id = '$event_id'
                        AND e.publish < 2
                    LIMIT 1
                    "); 
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) 
		{			
            return true;			
		}else
            return false;			
		
    }
    
    public function is_active_public_event($event_id)
    {
        $query=$this->db->query("SELECT  e.id
                    FROM (
                    `es_event` AS e
                    )
                    LEFT JOIN es_event_date as eed on  e.date_id = eed .id
                    
                    WHERE  
                        IF(e.date_id > 0, NOW( ) < eed.end, NOW( ) < e.end_date)                        
                        AND e.id = '$event_id'
                        AND e.publish < 2
                        AND e.status = '1'
                    LIMIT 1
                    "); 
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0) 
		{			
            return true;			
		}else
            return false;			
		
    }
    
    public function list_ticket_attendees($ticket_order_id)
    {
        $this->db->select('attendee, email, barcode');
        $this->db->from('event_ticket_sold');
        $this->db->where('ticket_order_id', $ticket_order_id);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;    
        }                
    }
    
    public function get_performer_name_from_id($peformer_type_id)
    {
        $this->db->select('performer_type');
        $this->db->from('performer_type');
        $this->db->where('id', $peformer_type_id);
        $this->db->limit(1);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $r = $query->row();
                return $r->performer_type;
            
        }else{
            return false;    
        }   
    }
    
    public function email_to_specific_emails_of_event($specific_emails, $event_id)
    {
        //load email library
        $this->load->library('email');
        //configure mail
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = true;
        $config['mailtype'] = 'html';
        $config['protocol'] = 'sendmail';
        $this->email->initialize($config);


        $this->load->model('email_model');

        //get subjet & body
        $template = $this->email_model->get_email_template("invitation-to-event");

        if ($template) {

            
                $subject = $template['subject'];
                $emailbody = $template['email_body'];

            $url = site_url('event/view/' . $event_id);
            //check blank valude before send message
            if (isset($subject) && isset($emailbody)) {
                $event_name = $this->input->post('event_title', true);
                $event_owner = $this->session->userdata(SESSION.'email');
                
                $specific_emails = explode(',',$specific_emails);
                
                foreach($specific_emails as $email){
                    if($email=='' || $email==' ')
                        continue;
                    $parseElement = array("USERNAME" => $email, "EVENTOWNER" => $event_owner, "EVENTNAME" => $event_name, "SITENAME" => SITE_NAME, "EVENTLINK" => $url);
    
                    $subject = $this->email_model->parse_email($parseElement, $subject);
                    $emailbody = $this->email_model->parse_email($parseElement, $emailbody);
    
                    $this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
                    $this->email->to($email);
                    $this->email->subject($subject);
                    $this->email->message($emailbody);
                    $this->email->send();    
                }
            }
        }

    }
    
    public function resend_activation_code_email($activation_code='', $email='')
    {        
		//load email library
    	$this->load->library(array('email','general'));        
			//configure mail
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$config['protocol'] = 'sendmail';
			$this->email->initialize($config);
			
					
		$this->load->model('email_model');
		//get subjet & body
		$template=$this->email_model->get_email_template("verify-email-address");
		
        $subject=$template['subject'];
        $emailbody=$template['email_body'];
        
         
        $email = $email;
                		
		$this->user_id = $this->general->get_id_from_email($email);
        
        //check blank valude before send message
		if(isset($subject) && isset($emailbody))
		{
			//parse email
			
            if($activation_code=='')
                $confirm = "<a href='".site_url('login')."'>".site_url('login')."</a>";
            else
                $confirm="<a href='".site_url('/users/account/verify_email/'.$activation_code.'/'.$this->user_id)."'>".site_url('/users/account/verify_email/'.$activation_code.'/'.$this->user_id)."</a>";
              
            //echo $confirm;exit;   
					$parseElement=array("VERIFY_EMAIL_LINK"=>$confirm,
										"SITENAME"=>SITE_NAME,
										"EMAIL"=>$email,
                                        );
	
					$subject=$this->email_model->parse_email($parseElement,$subject);
					$emailbody=$this->email_model->parse_email($parseElement,$emailbody);
				//echo $emailbody;exit;	
			//set the email things
			$this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
			$this->email->to($email); 
			$this->email->subject($subject);
			$this->email->message($emailbody); 
			$this->email->send();
			//echo $this->email->print_debugger();exit;
            /*test email from localhost*/
           // $headers = "MIME-Version: 1.0" . "\r\n";
//            $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
//            $headers .= "From: ".CONTACT_EMAIL."" . "\r\n";
//            mail($email,$subject,$emailbody,$headers);        
            /*test email from localhost*/
		}
    }
    
    
}
