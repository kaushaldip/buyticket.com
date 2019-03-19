<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General
{
    /**
     * CodeIgniter global
     *
     * @var string
     **/
    protected $ci;

    /**
     * account status ('not_activated', etc ...)
     *
     * @var string
     **/
    protected $status;

    /**
     * error message (uses lang file)
     *
     * @var string
     **/
    protected $errors = array();


    public function __construct()
    {
        
        
        $this->ci = &get_instance();
        //Check block id and exit it.
        ini_set('error_reporting', !E_NOTICE & !E_WARNING);
        $user_ip = $this->get_real_ipaddr();

        if ($this->check_block_ip($user_ip) !== 0) {
            exit;
        }
        

        /*for currency start*/
		$ip =  $this->get_real_ipaddr();
        
        $addressFromIP = file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=9572dd79d587c691a58731f7ae4ea125d1c234b1063352b73ab4c6401e5f46c5&ip=$ip&format=json");         
        define('ADDRESS_FROM_IP', $addressFromIP);
        
		$currency_symbol = "USD";
		$currecny_code = "$";
            
		//define site settings info
		$site_info = $this->get_site_settings_info();
        define('SITE_NAME', $site_info['site_name']);
        define('CONTACT_EMAIL', $site_info['contact_email']);
        define('CONTACT_PHONE', $site_info['contact_phone']);
        define('CONTACT_ADDRESS', $site_info['contact_address']);
		define('DEFAULT_PAGE_TITLE', $site_info['default_page_title']);
        define('DEFAULT_META_KEYS', $site_info['default_meta_keys']);
        define('DEFAULT_META_DESC', $site_info['default_meta_desc']);
        define('SITE_STATUS', $site_info['site_status']);
        define('SITE_OFFLINE_MSG', $site_info['site_offline_msg']);

        //rate settings website_fee_percent 	website_fee_rate 	affiliate_referral_rate 	event_affiliate_referral_rate
        define('WEBSITE_FEE', $site_info['website_fee_rate']);
        define('WEBSITE_FEE_PRICE', $site_info['website_fee_price']);
        define('AFFILIATE_REFERRAL_RATE', $site_info['affiliate_referral_rate']);
        define('EVENT_AFFILIATE_RATE', $site_info['event_affiliate_referral_rate']);

        //fb detail
        //define('FACEBOOK_APP_ID',$site_info['facebook_app_id']);
        //define('FACEBOOK_SECRET_KEY',$site_info['facebook_secret_key']);
        //manual assign
        define('FACEBOOK_APP_ID', '154968791329023');
        define('FACEBOOK_SECRET_KEY', '67926c59d9fbdbb8f70c88f07cb82b66');

        //social url
        define('FACEBOOK_PAGE_URL', $site_info['facebook_page_url']);
        define('TWITTER_PAGE_URL', $site_info['twitter_page_url']);
        define('YOUTUBE_PAGE_URL', $site_info['youtube_page_url']);
        define('GOOGLEPLUS_PAGE_URL', $site_info['googleolus_page_url']);

        define("CURRENCY_SYMBOL", $currency_symbol);
        define("CURRENCY_CODE", $currecny_code);

        //paypal details
        define('PAYPAL_API_USERNAME', $site_info['paypal_api_username']);
        define('PAYPAL_API_SIGNATURE', $site_info['paypal_api_signature']);
        define('PAYPAL_API_PASSWORD', $site_info['paypal_api_password']);
        
        define('COUNTRY_CODE',@strtoupper($jsn->geoplugin_countryCode));
        
        

        $this->ci->config->set_item('facebook', array('appId' => FACEBOOK_APP_ID,
            'secret' => FACEBOOK_SECRET_KEY, 'fileUpload' => true, 'cookie' => true));


    }


    //function to check admin logged in
    public function admin_logged_in()
    {
        return $this->ci->session->userdata(SESSION . ADMIN_LOGIN_ID);
    }

    //function to admin logout
    public function admin_logout()
    {
        $this->ci->session->unset_userdata(SESSION . ADMIN_LOGIN_ID);
        return true;
    }
    public function geoCheckIP($ip)
    {
        //check, if the provided ip is valid
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException("IP is not valid");
        }

        //contact ip-server
        $response = @file_get_contents('http://www.netip.de/search?query=' . $ip);
        if (empty($response)) {
            throw new InvalidArgumentException("Error contacting Geo-IP-Server");
        }

        //Array containing all regex-patterns necessary to extract ip-geoinfo from page
        $patterns = array();
        $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
        $patterns["country"] = '#Country: (.*?)&nbsp;#i';
        $patterns["state"] = '#State/Region: (.*?)<br#i';
        $patterns["town"] = '#City: (.*?)<br#i';

        //Array where results will be stored
        $ipInfo = array();

        //check response from ipserver for above patterns
        foreach ($patterns as $key => $pattern) {
            //store the result in array
            $ipInfo[$key] = preg_match($pattern, $response, $value) && !empty($value[1]) ? $value[1] :
                'not found';
        }

        return $ipInfo;
    }
    //find user real ip address
    public function get_real_ipaddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet

            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            //to check ip is pass from proxy

            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];
        
        return '110.34.14.70';                
        return $ip;
    }

    //get GMT time from database
    function get_gmt_info()
    {
        $data = array();
        $CI = &get_instance();
        $CI->db->select("gmt_time");
        $query = $CI->db->get_where("time_zone_setting", array("status" => "on"));
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        $query->free_result();
        return $data['gmt_time'];
    }
    //Change & Get Time Zone based on settings
    function get_local_time($time = "none")
    {
        $gmt_info = $this->get_gmt_info();
        $gmt_time = explode(':', $gmt_info);
        $hour_delay = $gmt_time[0];
        $minute_delay = $gmt_time[1];
        //$hour_delay=6; $minute_delay=00;

        if ($time != 'none')
            return date("Y-m-d H:i:s", mktime(gmdate("H") + $hour_delay, gmdate("i") + $minute_delay,
                gmdate("s"), gmdate("m"), gmdate("d"), gmdate("Y")));
        else
            return date("Y-m-d", mktime(gmdate("H") + $hour_delay, gmdate("i") + $minute_delay,
                gmdate("s"), gmdate("m"), gmdate("d"), gmdate("Y")));
    }

    //date format only
    function date_formate($date)
    {
        $str_date = strtotime($date);
        $dt_frmt = date("dS F Y", $str_date);

        return $dt_frmt;
    }

    //date & time format only
    function date_time_formate($str)
    {
        $str_date = strtotime($str);
        $dt_frmt = date("D, d M Y g:i a", $str_date);

        return $dt_frmt;
    }
    //date & time format only
    function full_date_time_formate($str)
    {
        return date("d M Y H:i:s", strtotime($str));
    }

    function get_local_time_clock()
    {
        $gmt_info = $this->get_gmt_info();
        $gmt_time = explode(':', $gmt_info);
        $hour_delay = $gmt_time[0];
        $minute_delay = $gmt_time[1];

        $time = date("H:i:s", mktime(gmdate("H") + $hour_delay, gmdate("i") + $minute_delay,
            gmdate("s")));

        $piece = explode(":", $time);
        return $piece[0] * 60 * 60 + $piece[1] * 60 + $piece[2];
    }

    public function get_site_settings_info()
    {
        $query = $this->ci->db->get("site_settings");
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        $query->free_result();
        return $data;
    }

    public function get_cms_lists()
    {
        $data = array();

        $ids = array('1', '3', '4', '23');
        $this->ci->db->where("is_display", "Yes");
        $this->ci->db->where_in("id", $ids);
        $this->ci->db->order_by('id', 'ASC');
        $query = $this->ci->db->get("cms");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        }

        $query->free_result();
        return $data;

    }
    public function get_event_list()
    {
        $this->ci->db->where("status", '1');
        $query = $this->ci->db->get("event");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        }

        $query->free_result();
        return $data;
    }
    public function get_event_list_for_sitemap()
    {
        //$this->ci->db->select("id, title, updated_date");
//        $this->ci->db->where("status !='0' AND publish != '2'");
//        $query = $this->ci->db->get("event");
        $sql = "select e.id, e.organizer_id, e.title, e.updated_date FROM es_event as e LEFT JOIN es_event_date as d ON d.id = e.date_id WHERE e.status ='1' AND e.publish !='2' AND if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )";
        $query = $this->ci->db->query($sql);
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }

        $query->free_result();
        return $data;
    }
    public function get_country_lists()
    {

        $query = $this->ci->db->get("country");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        }

        $query->free_result();
        return $data;
    }
    public function get_countryevent_lists($c)
    {
        $this->ci->db->select('e.id,e.title,e.description,e.updated_date');
        $this->ci->db->from('es_event AS e');
        $this->ci->db->join('es_event_location AS u', 'u.event_id = e.id', 'left');
        $this->ci->db->where("u.country", $c);
        $query = $this->ci->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        }
        return false;

    }


    public function get_how_lists_event()
    {
        $data = array();

        $ids = array('27', '28', '29');
        $this->ci->db->where("is_display", "Yes");
        $this->ci->db->where_in("id", $ids);
        $this->ci->db->order_by('id', 'ASC');
        $query = $this->ci->db->get("cms");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        }

        $query->free_result();
        return $data;

    }
    
    public function get_how_lists_affiliate()
    {
        $data = array();

        $ids = array('33', '34', '35');
        $this->ci->db->where("is_display", "Yes");
        $this->ci->db->where_in("id", $ids);
        $this->ci->db->order_by('id', 'ASC');
        $query = $this->ci->db->get("cms");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        }

        $query->free_result();
        return $data;

    }

    
    public function get_how_lists_referral()
    {
        $data = array();

        $ids = array('30', '31', '32');
        $this->ci->db->where("is_display", "Yes");
        $this->ci->db->where_in("id", $ids);
        $this->ci->db->order_by('id', 'ASC');
        $query = $this->ci->db->get("cms");

        if ($query->num_rows() > 0) {
            $data = $query->result();
        }

        $query->free_result();
        return $data;

    }
    public function get_remaining_time($end_time)
    {
        return strtotime($end_time) - strtotime($this->get_local_time('time'));
    }

    function auction_reset_time($auc_remaining_time, $auction_reset_time)
    {
        if ($auc_remaining_time < $auction_reset_time) {
            $reset_time = $auction_reset_time - $auc_remaining_time;
        } else {
            $reset_time = 0;
        }
        return $reset_time;
    }


    function random_number()
    {
        return mt_rand(100, 999) . mt_rand(100, 999) . mt_rand(11, 99);
    }

    function genRandomString($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    function clean_url($str, $replace = array(), $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array )$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    function check_block_ip($ip_address)
    {
        $this->ci->db->select('ip_address');
        $query = $this->ci->db->get_where("block_ips", array("ip_address" => $ip_address));
        return $query->num_rows();
    }

    public function get_country()
    {
        $data = array();
        $this->ci->db->order_by("country", "asc");
        $query = $this->ci->db->get("country");
        if ($query->num_rows() > 0) {
            $data = $query->result();
        }
        $query->free_result();
        return $data;
    }

    function check_voting($nomination_id, $album_id, $user_id)
    {
        $query = $this->ci->db->get_where('nomination_vote', array('nomination_id' => $nomination_id,
            'album_id' => $album_id, 'user_id' => $user_id));
        return $query->num_rows();

    }

    function check_float_vlaue($str)
    {
        if (preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $str)) {
            return true;
        } else {
            return false;
        }
    }
    function check_int_vlaue($str)
    {
        if (preg_match("/^[0-9]+$/", $str)) {
            return true;
        } else {
            return false;
        }
    }


    public function get_event_type_lists($main="", $limit="")
    {
        if(!empty($main)){
            $this->ci->db->where('image !=', '');
            $this->ci->db->order_by('name',"ASC");                        
            $this->ci->db->group_by('name');
        }
        if(!empty($limit)){
            $this->ci->db->limit($limit);
        }
        $this->ci->db->where('is_display', 'Yes');
        
        $this->ci->db->order_by('name',"ASC");
        $this->ci->db->order_by('id', 'ASC');        
        $query = $this->ci->db->get('event_type');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return false;
    }
        
    public function get_single_record($table, $field, $key, $value)
    {
        $this->ci->db->where($key, $value);
        $this->ci->db->select($field);
        $query = $this->ci->db->get($table);
        //echo $this->ci->db->last_query();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->$field;

        }
        return false;

    }

    /*upload image file start*/
    public function uploadImage($myFile, $folder = '', $height = '120', $width =
        '120')
    {
        $this->ci->load->library('upload');
        $this->ci->load->library('image_lib');

        $image1_name = $this->file_settings_do_upload($myFile, $folder);


        if ($image1_name['file_name']) {
            $this->image_name_path1 = $image1_name['file_name'];
            //resize image
            $this->resize_image($this->image_name_path1, 'thumb_' . $image1_name['raw_name'] .
                $image1_name['file_ext'], $folder, $height, $width);

            return $image1_name['raw_name'] . $image1_name['file_ext'];
        } else {
            $this->ci->session->set_flashdata('message', $this->error_img);
        }

    }


    public function resize_image($file_name, $thumb_name, $folder, $height, $width)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = './' . UPLOAD_FILE_PATH . $folder . "/" . $file_name;
        //$config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = true;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = './' . UPLOAD_FILE_PATH . $folder . "/" . $thumb_name;

        $this->ci->image_lib->initialize($config);

        $this->ci->image_lib->resize();
        // $this->image_lib->clear();

    }


    public function file_settings_do_upload($file, $folder)
    {
        $config['upload_path'] = './' . UPLOAD_FILE_PATH . $folder . "/"; //define in constants
        $config['allowed_types'] = 'gif|jpg|png';
        $config['remove_spaces'] = true;
        $config['max_size'] = '50000';
        $config['max_width'] = '10240';
        $config['max_height'] = '10240';
        $this->ci->upload->initialize($config);


        $this->ci->upload->do_upload($file);
        if ($this->ci->upload->display_errors()) {
            $this->error_img = $this->ci->upload->display_errors();
            return false;
        } else {
            $data = $this->ci->upload->data();
            return $data;
        }


    }
    /*upload image file end*/

    public function get_nice_name($str)
    {
        $str = preg_replace('/[^(A-z0-9)|\s|\-]/', "-", $str, -1);
        $str = preg_replace('/[\W|\s|\-]/', "-", $str, -1);
        $str = preg_replace('/(-)+/', "-", $str, -1);
        $str = rtrim($str, "-");
        $str = strtolower($str);

        return $str;
    }
    
    public function get_url_name($str)
    {
        //$str = urlencode($str);
        //$str = preg_replace('/[^(A-z0-9)|\s|\-]/', "-", $str, -1);
        //$str = preg_replace('/[\W|\s|\-]/', "-", $str, -1);
        $str = str_replace(' ','-', $str);
        $str = str_replace('{','-', $str);
        $str = str_replace('}','-', $str);
        $str = str_replace('(','-', $str);
        $str = str_replace(')','-', $str);
        $str = str_replace('[','-', $str);
        $str = str_replace(']','-', $str);
        $str = str_replace('!','-', $str);
        $str = str_replace('#','-', $str);
        $str = str_replace('$','-', $str);
        $str = str_replace('%','-', $str);
        $str = str_replace('^','-', $str);
        $str = str_replace('&','-', $str);
        $str = str_replace('/','', $str);
        $str = preg_replace('/(-)+/', "-", $str, -1);
        //$str = preg_replace('/[\s\W]+/','-',$str); 
        $str = rtrim($str, "-");
        $str = strtolower($str);
        $str = htmlentities($str);
        return $str;
    }

    public function get_user_full_name($user_id)
    {
        $this->ci->db->select('first_name, last_name');
        $this->ci->db->where('id', $user_id);
        $query = $this->ci->db->get('user');
        if ($query->num_rows() > 0) {
            $user = $query->row();
            return ucwords($user->first_name . " " . $user->last_name);
        }
        return false;
    }

    public function get_referral_url($url_id)
    {
        $this->ci->db->select('referral_url');
        $this->ci->db->from('user_referral_url');
        $this->ci->db->where('id', $url_id);

        $query = $this->ci->db->get();

        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {

            return $query->row();
        }

        return false;
    }

    public function get_user_short_detail_byID($user_id)
    {
        //username 	password 	email 	email_alternate 	prefix 	first_name 	last_name 	email_event_notify 	email_update_notify 	slug 	parent 	referral_id 	status 0 inactive, 1 active, 2 pending	organizer 0 for inactive, 1 for active organizer, 2 pending organizer	inactive_reason 	dob 	last_login_date 	reg_date 	last_modify_date 	last_ip_address 	reg_ip_address 	activation_code 	image 	user_source_from_id how did user hear about	is_fb_user 	is_twitter_user 	is_google_user
        //id 	user_id 	description 	address 	address1 	street 	city 	state 	country 	zip 	gender 	mobile_number 	home_number 	work_number 	work_website 	work_company 	work_address 	work_city 	work_state 	work_country 	work_zip 	work_job_title
        $this->ci->db->select('u.id,u.username,u.email, u.first_name,u.prefix,u.last_name');
        $this->ci->db->from('user u');
        $this->ci->db->where('u.id', $user_id);

        $query = $this->ci->db->get();

        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return false;
    }

    public function get_event_lists_byOrganizer($user_id = '')
    {
        $this->ci->db->select('id, organizer_id, name, title, target_gender, visit_count, created_date, updated_date,status, publish');
        if (!empty($user_id)) {
            $this->ci->db->where('organizer_id', $user_id);
        }

        $query = $this->ci->db->get('event');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
    }

    public function total_events_admin($status = '')
    {
        $this->ci->db->select('e.id');
        $this->ci->db->from('es_event AS e');
        $this->ci->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');

        $this->ci->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not

        if ($status <> '')
            $this->ci->db->where("e.status = '$status'");
        else
            $this->ci->db->where("e.status <> 0");


        $query = $this->ci->db->get();
        // echo $this->db->last_query();exit;
        return $query->num_rows();


    }


    public function total_events($status = '')
    {
        $data = array();
        if (($status == ''))
            $query = $this->ci->db->get_where("event");
        else {
            $this->ci->db->where("now() BETWEEN start_date AND end_date"); //compare with event duration
            $query = $this->ci->db->get_where("event", array("status" => $status));

        }


        //echo $this->ci->db->last_query();exit;
        return $query->num_rows();

    }

    public function total_users($organizers = '')
    {
        $data = array();
        if (empty($organizers))
            $query = $this->ci->db->get_where("user");
        else
            $query = $this->ci->db->get_where("user", array("organizer" => "1"));
        return $query->num_rows();
    }

    public function dash_total_revenue()
    {
        $this->ci->db->select('SUM(paid) as total');
        $this->ci->db->from('es_event_ticket_order');

        $this->ci->db->where("refund_id", '0');

        $q = $this->ci->db->get();

        if ($q->num_rows() > 0) {
            $row = $q->row();
            $total = $row->total;
            return (empty($total)) ? '0' : $total;
        }
        return $q->num_rows();
    }

    public function total_paid_events($paid = 'yes')
    {
        $this->ci->db->select("COUNT(t.paid_event) as count");
        $this->ci->db->from('event as e');
        $this->ci->db->join('event_type as t', 't.id = e.event_type_id');
        $this->ci->db->where('t.paid_event', $paid);


        $query = $this->ci->db->get();
        //echo $this->ci->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->row();
        }
        $query->free_result();
        return $data->count;
    }

    public function is_paid_event($event_id)
    {
        $this->ci->db->select("t.paid_event");
        $this->ci->db->from('event as e');
        $this->ci->db->join('event_type as t', 't.id = e.event_type_id');
        $this->ci->db->where('e.id', $event_id);


        $query = $this->ci->db->get();
        //echo $this->ci->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $query->free_result();
            return true;
        }

        return false;
    }

    public function is_organizer_of_event($event_id)
    {
        $this->ci->db->select("id,organizer_id");
        $this->ci->db->from('event');
        $this->ci->db->where('id', $event_id);
        $this->ci->db->where('organizer_id', $this->ci->session->userdata(SESSION .
            'user_id'));

        $query = $this->ci->db->get();
        //echo $this->ci->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $query->free_result();
            return true;
        }

        return false;
    }
    
    public function has_event_by_organizer()
    {
        $this->ci->db->select("organizer_id");
        $this->ci->db->from('event');        
        $this->ci->db->where('organizer_id', $this->ci->session->userdata(SESSION .
            'user_id'));

        $query = $this->ci->db->get();
        //echo $this->ci->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $query->free_result();
            return true;
        }

        return false;
    }

    public function has_tickets($event_id, $admin = '')
    {
        $this->ci->db->select("event_id");
        $this->ci->db->from('event_ticket');
        $this->ci->db->where('event_id', $event_id);
        if ($admin == '')
            $this->ci->db->where('status', '1');

        $query = $this->ci->db->get();
        //echo $this->ci->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $query->free_result();
            return true;
        }

        return false;
    }

    public function has_affilate_parent()
    {
        $this->ci->db->select("parent");
        $this->ci->db->from('user');
        $this->ci->db->where('parent', '1');
        $this->ci->db->where('id', $this->ci->session->userdata(SESSION . 'user_id'));

        $query = $this->ci->db->get();
        //echo $this->ci->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $query->free_result();
            return true;
        }

        return false;
    }

    public function get_user_id_from_event_id($event_id)
    {
        $this->ci->db->select('organizer_id');
        $query = $this->ci->db->get_where('event', array('id' => $event_id));
        if ($query->num_rows() > 0) {
            $data = $query->row();
            return $data->organizer_id;
        } else
            return false;

    }

    public function is_organizer($user_id)
    {
        $query = $this->ci->db->get_where('user', array('organizer' => '1', 'id' => $user_id));
        if ($query->num_rows() > 0)
            return true;
        else
            return false;
    }


    public function set_organizer($user_id, $status = '2')
    {
        $data = array('organizer' => $status, );

        $this->ci->db->where('id', $user_id);
        $this->ci->db->update('user', $data);
    }
    public function test_username_keywords($username)
    {
        $keywords = array('autocomplete', 'block-ip', 'category', 'change-password',
            'cms', 'cron', 'dashboard', 'email-settings', 'error', 'help', 'home', 'help',
            'login', 'members', 'page', 'sale', 'site-settings', 'test', 'testimonial',
            'time-zone-settings', 'users', 'voting', 'winners');
        if (in_array($username, $keywords)) {
            return true;
        }
        return false;
    }


    /*to generate random unique number start*/
    public function createRandomString($string_length, $character_set)
    {
        $random_string = array();
        for ($i = 1; $i <= $string_length; $i++) {
            $rand_character = $character_set[rand(0, strlen($character_set) - 1)];
            $random_string[] = $rand_character;
        }
        shuffle($random_string);
        return implode('', $random_string);
    }

    public function validUniqueString($string_collection, $new_string, $existing_strings =
        '')
    {
        if (!strlen($string_collection) && !strlen($existing_strings))
            return true;
        $combined_strings = $string_collection . ", " . $existing_strings;
        return (strlen(strpos($combined_strings, $new_string))) ? false : true;
    }

    public function createRandomStringCollection($string_length = '10', $number_of_strings =
        '1', $character_set = CHARACTER_SET, $existing_strings = "NXC, BRL, CVN")
    {
        $string_collection = '';
        for ($i = 1; $i <= $number_of_strings; $i++) {
            $random_string = $this->createRandomString($string_length, $character_set);
            while (!$this->validUniqueString($string_collection, $random_string, $existing_strings)) {
                $random_string = $this->createRandomString($string_length, $character_set);
            }
            $string_collection .= (!strlen($string_collection)) ? $random_string : ", " . $random_string;
        }
        return $string_collection;
    }


    //$existing_strings = "NXC, BRL, CVN";
    //$string_length = 3;
    //$number_of_strings = 10;
    //echo createRandomStringCollection($string_length, $number_of_strings, $character_set, $existing_strings);
    /*to generate random unique number end*/

    public function getSubString($string, $len = 0, $uc = '')
    {
        $new_string = str_replace(' ', '', $string);
        $str_len = strlen($new_string);
        if ($str_len < $len)
            $new_string = substr($new_string, 0, $str_len);
        else
            $new_string = substr($new_string, 0, $len);
        if ($uc == '')
            return $new_string;
        else
            return ucwords($new_string);
    }

    public function get_country_code_using_ip()
    {
        $ip = $_SERVER["REMOTE_ADDR"]; //"91.208.156.100"; //
        $jsn = json_decode(file_get_contents("http://api.hostip.info/get_json.php?ip=$ip"));
        return $jsn;
    }
    public function get_event_catalog()
    {
        $this->ci->db->group_by("name");
        $query = $this->ci->db->get("es_event_type");
        if ($query->num_rows() > 0) {
            return $query->result();

        } else
            return false;

    }
    public function get_event_sub_catalog()
    {
        $this->ci->db->group_by("sub_type");
        $query = $this->ci->db->get("es_event_type");
        if ($query->num_rows() > 0) {
            return $query->result();

        } else
            return false;

    }
    function get_autocomplete_keyword($key)
    {
        //$this->ci->db->like('keyword', $key, 'after');
        $this->ci->db->like('keyword', $key);
        $this->ci->db->group_by("keyword");
        $query = $this->ci->db->get("es_event_keyword");
        //echo $this->ci->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();

        } else
            return false;

    }
    
    
    
    function get_cities_from_country($country,$country1='')
    {
        $this->ci->db->select("city_en");
        $this->ci->db->group_by("city_en");
        $this->ci->db->where("country",$country);
        if(!empty($country1))
            $this->ci->db->or_where("country",$country1);      
        $query = $this->ci->db->get("event_location");
        
        //echo $this->ci->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();

        } else
            return false;
    }
    public function getlatandlon_without_key($where, $lang="en")
    {
        $whereurl = urlencode($where);
        $url = ('http://maps.googleapis.com/maps/api/geocode/json?address=' . $whereurl . '&sensor=false&language='.$lang);
        $geocode = file_get_contents($url);
        $output = json_decode($geocode);
        return $output;
    }
    
    public function get_city_ar_en($city,$lang='en')
    {        
        $whereurl = urlencode($city);
        $url = ('http://maps.googleapis.com/maps/api/geocode/json?address=' . $whereurl . '&sensor=false&language='.$lang);        $geocode = file_get_contents($url);
        $output = json_decode($geocode);
        
        if ($output->status == "OK") {
            for ($j = 0; $j < count($output->results[0]->address_components); $j++) {                 
                if ($output->results[0]->address_components[$j]->types[0] == 'locality'){
                    $city = $output->results[0]->address_components[$j]->long_name;                            
                }                           
            }                    
          
        }
        return $city;
    }
    
    
    function get_cities_search_module()
    {
        $ln = $this->ci->config->item('language_abbr');
        
        $lat = $lng = $city = $country = '';
        if ($location=$this->ci->input->get('location')) {            
            if($location==1 || $location == ''){              
                $country = ($this->ci->input->cookie(SESSION.'country_cookie'))? $this->ci->input->cookie(SESSION.'country_cookie'): '';  
            }else{
                $output2 = $this->getlatandlon_without_key($location);
                //print_r($output2);
                //json_encode($output2);
                if ($output2->status == "OK") {
                    for ($j = 0; $j < count($output2->results[0]->address_components); $j++) {
                        if ($output2->results[0]->address_components[$j]->types[0] == 'country'){
                            $country = $output2->results[0]->address_components[$j]->long_name;
                        } 
                        if ($output2->results[0]->address_components[$j]->types[0] == 'locality'){
                            $city = $output2->results[0]->address_components[$j]->long_name;                            
                        }                           
                    }                    
                  
                } else {
                    //redirect(site_url('event'));
                }  
                $output21 = $this->getlatandlon_without_key($location,'en');
                //print_r($output2);
                //json_encode($output2);
                if ($output21->status == "OK") {
                    for ($j = 0; $j < count($output21->results[0]->address_components); $j++) {
                        if ($output21->results[0]->address_components[$j]->types[0] == 'country'){
                            $country1 = $output21->results[0]->address_components[$j]->long_name;
                        } 
                        if ($output21->results[0]->address_components[$j]->types[0] == 'locality'){
                            $city1 = $output21->results[0]->address_components[$j]->long_name;                            
                        }                           
                    }                    
                  
                } else {
                    //redirect(site_url('event'));
                }   
            } 
            
            
        }
         
        if($get_city=$this->ci->input->get('city')){
            if($get_city == '1' || $get_city == ''){
                if($this->ci->input->cookie(SESSION.'lat') && $this->ci->input->cookie(SESSION.'lng'))        
                {
                    $lat = ($this->ci->input->cookie(SESSION.'lat'))? $this->ci->input->cookie(SESSION.'lat'): '';
                    $lng = ($this->ci->input->cookie(SESSION.'lng'))? $this->ci->input->cookie(SESSION.'lng'): '';
                    
                   
                }else{
                    $country = $this->ci->input->cookie(SESSION.'country_cookie');
                }                 
            }else{
                $output2 = $this->getlatandlon_without_key($get_city);
                if ($output2->status == "OK") {
                    for ($j = 0; $j < count($output2->results[0]->address_components); $j++) {
                        $lat = $output2->results[0]->geometry->location->lat;
                        $cookieA = array('name' => SESSION."lat",'value'  => $lat,'expire' => time()+3600*24*30);
                        $this->ci->input->set_cookie($cookieA); 
                        $lng = $output2->results[0]->geometry->location->lng;
                        $cookieB = array('name' => SESSION."lng",'value'  => $lng,'expire' => time()+3600*24*30);
                        $this->ci->input->set_cookie($cookieB);
                    }                    
                  
                }else {
                    //redirect(site_url('event'));
                }                    
            }  
            
            $this->ci->db->select("city_en,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( $lng) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance");
            $this->ci->db->having(array('distance <' => 100));
        }
        
        if($city !='')
            $this->ci->db->where('city_'.$ln, $city);
        $this->ci->db->where('country', $country); 
        if(!empty($country1))
            $this->ci->db->or_where('country', $country1);
        $this->ci->db->group_by('city_'.$ln);        
        $query = $this->ci->db->get("es_event_location");
        //echo $this->ci->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result();

        } else
            return false;
        
    }
    function get_location_latilong()
    {
        //echo $this->ci->input->cookie(SESSION.'country_cookie') ;
        $lat = $lng = $city = $country = '';
        if($this->ci->input->get('location')){
            if($this->ci->input->get('location')=='1' || $this->ci->input->get('location')==''){
                if($this->ci->input->cookie(SESSION.'lat') && $this->ci->input->cookie(SESSION.'lng')){
                    //
                    $lat = $this->ci->input->cookie(SESSION.'lat');
                    $lng = $this->ci->input->cookie(SESSION.'lng');
                   //
                }else{
                    $id = $this->get_real_ipaddr();// "202.70.64.2";
                    $jsn1 = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=9572dd79d587c691a58731f7ae4ea125d1c234b1063352b73ab4c6401e5f46c5&ip=$id&format=json"));
                    $lat = $jsn1->latitude;
                    $lng = $jsn1->longitude;    
                }
                
            }else{
                $whereurl = urlencode($this->ci->input->get('location')); 
                $geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' .$whereurl . '&sensor=false');
                $output = json_decode($geocode);
                $lat = $output->results[0]->geometry->location->lat;
                $lng = $output->results[0]->geometry->location->lng;    
            }
            
        }else if($this->ci->input->cookie(SESSION.'lat') && $this->ci->input->cookie(SESSION.'lng')){
            //           
            //$whereurl = urlencode($this->ci->input->cookie(SESSION.'city_cookie').','.$this->ci->input->cookie(SESSION.'country_cookie')); 
            //$geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' .$whereurl. '&sensor=false');
            //$output = json_decode($geocode);
            //$lat = $output->results[0]->geometry->location->lat;
            //$lng = $output->results[0]->geometry->location->lng;
            $lat = $this->ci->input->cookie(SESSION.'lat');
            $lng = $this->ci->input->cookie(SESSION.'lng');
           //
        }else{
            $id = $this->get_real_ipaddr();// "202.70.64.2";
            $jsn1 = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=9572dd79d587c691a58731f7ae4ea125d1c234b1063352b73ab4c6401e5f46c5&ip=$id&format=json"));
            //$lat = $jsn1->latitude;            
            //$lng = $jsn1->longitude;
            $country = $jsn1->countryName;
            $city = $jsn1->cityName;
            
        }
        if($lat || $lng){
            $this->ci->db->select("city,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( $lng) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance");
            $this->ci->db->having(array('distance <' => 100));
                
        }else if($country){
            $this->ci->db->select('city');
            $this->ci->db->where("country",$country);   
        }
        $this->ci->db->group_by("city");
        $query = $this->ci->db->get("es_event_location");
        if ($query->num_rows() > 0) {
            return $query->result();

        } else
            return false;

    }
    function total_ticket_sold()
    {
        $q = $this->ci->db->query("SELECT SUM( ticket_quantity ) AS total_quantity
FROM  `es_event_ticket_order` 
WHERE payment_status =  'complete'
AND create_ticket =  'yes'");


        if ($q->num_rows() > 0) {
            return $q->row()->total_quantity;
        }
        return false;
    }
    function total_ticket_sold_paid()
    {
        $q = $this->ci->db->query("SELECT SUM( ticket_quantity ) AS total_quantity
FROM  `es_event_ticket_order` 
WHERE payment_status =  'complete'
AND create_ticket =  'yes' AND ticket_type =  'paid'");


        if ($q->num_rows() > 0) {
            return $q->row()->total_quantity;
        }
        return false;
    }

    function total_ticket_sold_free()
    {
        $q = $this->ci->db->query("SELECT SUM( ticket_quantity ) AS total_quantity
FROM  `es_event_ticket_order` 
WHERE payment_status =  'complete'
AND create_ticket =  'yes' AND ticket_type !=  'paid'");


        if ($q->num_rows() > 0) {
            return $q->row()->total_quantity;
        }
        return false;
    }
    function total_web_fee()
    {
        $q = $this->ci->db->query("SELECT SUM( fee ) AS total_fee
FROM  `es_event_ticket_order` 
WHERE payment_status =  'complete'
AND create_ticket =  'yes'");


        if ($q->num_rows() > 0) {
            return $q->row()->total_fee;
        }
        return false;
    }
    function total_referer()
    {
        $q = $this->ci->db->query("SELECT referral_id 
FROM  `es_user` 
WHERE is_referral_user ='yes'");


        return $q->num_rows();

    }
    function total_affilate_referer()
    {
        $q = $this->ci->db->query("SELECT id 
FROM  `es_affiliate_event_earning` 
group by user_id");
        return $q->num_rows();

    }

    function price($price, $currency = 'USD')
    {
        return CURRENCY_CODE . " " . number_format($price, 2, ".", ",");
    }

    function price_clean($price, $currency = 'SAR')
    {
        return number_format($price, 2, ".", ",");

    }
    
    function price_conversion($price, $from_currency, $to_currency)
    {
		return $price;
    }
	
    function price_conversion_new($price, $from_currency, $to_currency)
    {
        return $price;
    }
    

    function get_id_from_email($email)
    {
        $this->ci->db->select('email,id');
        $this->ci->db->where('email', $email);
        $query = $this->ci->db->get('user');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id;
        }

        return false;
    }

    public function get_value_from_id($table, $id, $select = "id")
    {
        $sql = "SELECT $select
            FROM $table              
            WHERE id =  '$id'  
            LIMIT 1";
        $q = $this->ci->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0) {
            $row = $q->row_array();
            return $row[$select];
        }
        return false;
    }

    function create_subdomain($subDomain, $cPanelUser, $cPanelPass, $rootDomain)
    {

        //	$buildRequest = "/frontend/x3/subdomain/doadddomain.html?rootdomain=" . $rootDomain . "&domain=" . $subDomain;

        $buildRequest = "/frontend/x3/subdomain/doadddomain.html?rootdomain=" . $rootDomain .
            "&domain=" . $subDomain . "&dir=public_html/subdomains/" . $subDomain;

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        $authString = $cPanelUser . ":" . $cPanelPass;
        $authPass = base64_encode($authString);
        $buildHeaders = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);

        $newDomain = "http://" . $subDomain . "." . $rootDomain . "/";

        //	return "Created subdomain $newDomain";

    }

    function delete_subdomain($subDomain, $cPanelUser, $cPanelPass, $rootDomain)
    {
        $buildRequest = "/frontend/x3/subdomain/dodeldomain.html?domain=" . $subDomain .
            "_" . $rootDomain;

        $openSocket = fsockopen('localhost', 2082);
        if (!$openSocket) {
            return "Socket error";
            exit();
        }

        $authString = $cPanelUser . ":" . $cPanelPass;
        $authPass = base64_encode($authString);
        $buildHeaders = "GET " . $buildRequest . "\r\n";
        $buildHeaders .= "HTTP/1.0\r\n";
        $buildHeaders .= "Host:localhost\r\n";
        $buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
        $buildHeaders .= "\r\n";

        fputs($openSocket, $buildHeaders);
        while (!feof($openSocket)) {
            fgets($openSocket, 128);
        }
        fclose($openSocket);

        $passToShell = "rm -rf /home/" . $cPanelUser . "/public_html/subdomains/" . $subDomain;
        system($passToShell);
    }

    function get_current_url()
    {
        $CI = &get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
    }
    
    
    function get_performet_type()
    {
        return $this->ci->db->get('es_performer_type')->result();
    }

    public function has_event_referral_url($user_id)
    {
        $this->ci->db->select('user_id');
        $this->ci->db->where('user_id', $user_id);
        $query = $this->ci->db->get('event_referral_url');

        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }

    public function is_referral_user($user_id)
    {
        $this->ci->db->select('id');
        $this->ci->db->where('is_referral_user', "yes");
        $this->ci->db->where('id', $user_id);
        $query = $this->ci->db->get('user');

        if ($query->num_rows() > 0) {
            return true;
        }

        return false;
    }
   
    
    public function city_has_active_event($city,$lang='en')
    {
        $sql = "SELECT e.id, e.title, l.city_$lang
            FROM es_event AS e
            LEFT JOIN es_event_location AS l ON e.id = l.event_id
            LEFT JOIN es_event_date AS d ON e.date_id = d.id
            WHERE e.publish = '1'
            AND e.status = '1'
            AND l.city_$lang = '$city'
            AND if( e.date_id = '0', now( ) <= e.end_date, now( ) <= d.end ) ";
        $q = $this->ci->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;        
    }
    
    
    public function date_language($date_string)
    {
        return $date_string;
        
    }
    
    public function get_date($date)
    {       
        $date = str_replace($this->ci->lang->line('am'),'am',$date);
        $date = str_replace($this->ci->lang->line('pm'),'pm',$date);       
        $date = str_replace('ص','am',$date);
        $date = str_replace('م','pm',$date);                     
        $new_date =date('Y-m-d H:i:s', strtotime($date));
        return $new_date;
    }
    
    public function get_date_ar($date)
    {       
        return $date;
    }
    
    public function verified_email($email)
    {
        $this->ci->db->select('email');
        $this->ci->db->where('verified_email', 'yes');
        $this->ci->db->where('email', $email);
        $this->ci->db->limit('1');
        $query = $this->ci->db->get("user");
        
        if ($query->num_rows() > 0) {            
            return true;
        }else{
            return false;
        }   
    }
    
    public function get_notification($limit = '')
	{	
		if(!empty($limit))
            $this->ci->db->limit($limit);
        $this->ci->db->order_by('id','DESC');
        
		$query = $this->ci->db->get('notification');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
    }
    
    public function notification_count()
    {	
		$this->ci->db->where('read','no');
		$query = $this->ci->db->get('notification');
        return $query->num_rows();		
    }
    
    public function set_notification($notification, $link)
    {
        $data = array('notification'=>$notification,'link'=>$link);
        $this->ci->db->insert('notification',$data);
    }
    
    public function is_event_with_no_order($event_id)
    {
        $this->ci->db->select('event_id');
        $this->ci->db->from('event_ticket_order');
        $this->ci->db->where('event_id',$event_id);
        $q = $this->ci->db->get();
        if ($q->num_rows() == 0)
		{
		   return true;
		} 

		return false;
    }
    
    
    /*new added*/
    function getCountry()
    {
        if($this->ci->input->cookie(SESSION."country_cookie")){  
            //echo "from cookies country";
            $country = ($this->ci->input->cookie(SESSION."country_cookie"))? $this->ci->input->cookie(SESSION."country_cookie"): "";            
        }else{
            //echo "from ip country";
            $jsn = json_decode(ADDRESS_FROM_IP);
            $country = $jsn->countryName;
            $cookieA = array('name' => SESSION."country_cookie",'value'  => $country,'expire' => time()+3600*24*30);
            $this->ci->input->set_cookie($cookieA);
        }
//        return $country;
        return "";
    }

    
    function getCity()
    {
        if($this->ci->input->cookie(SESSION."city_cookie")){  
            //echo "from cookies country";
            $city = ($this->ci->input->cookie(SESSION."city_cookie"))? $this->ci->input->cookie(SESSION."city_cookie"): "";            
        }else{
            //echo "from ip country";
            $jsn = json_decode(ADDRESS_FROM_IP);
            $city = $jsn->cityName;
            $cookieA = array('name' => SESSION."city_cookie",'value'  => $city,'expire' => time()+3600*24*30);
            $this->ci->input->set_cookie($cookieA);
        }
//        return $city;
        return "";
    }
    
    function getCurrentLocation()
    {
        if($this->ci->input->cookie(SESSION."current_location_cookie")){
            //echo "from cookies location";
            $current_location = ($this->ci->input->cookie(SESSION."current_location_cookie"))? $this->ci->input->cookie(SESSION."current_location_cookie"): "";
        }else{
            //echo "from ip location";            
            $jsn = json_decode(ADDRESS_FROM_IP);
            
            $current_location_Arr = get_object_vars($jsn);
            $removeKeyArr = array("statusCode", "statusMessage","ipAddress", "countryCode", "latitude", "longitude", "timeZone" );
            foreach($removeKeyArr as $rKey){
                unset($current_location_Arr[$rKey]);
            }
            $current_location_Arr = array_reverse($current_location_Arr);
            $current_location = implode(", ",$current_location_Arr);
            $cookieB = array('name' => SESSION."current_location_cookie",'value'  => $current_location,'expire' => time()+3600*24*30);
            $this->ci->input->set_cookie($cookieB);
        }
        return $current_location;
    } 
    /*new added*/
}
