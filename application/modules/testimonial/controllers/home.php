<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct() {
		parent::__construct();		
		//load custom module
			$this->load->model('admin_testimonial');
			//load custom library
		
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
	}
	
	public function index()
	{
		$this->data['testimonial_data'] = $this->admin_testimonial->get_details();
		
		//set SEO data
		$this->page_title = DEFAULT_PAGE_TITLE;
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('home_view', $this->data);
		
	}
    
    public function sitem()
    {
        $url = site_url("site.xml");
        
        $html =  simplexml_load_string(file_get_contents($url));
        var_dump($html);
    }
    
    public function geolocation()
    {
        $where = "Chifley Square, Sydney, New South Wales, Australia";
        $where = "South";
        $whereurl = urlencode($where);
        
        $geocode=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$whereurl.'&sensor=true');
        $output= json_decode($geocode);

        $location = $city = $state = $country = $postal_code = "";
        
        foreach($output->results[0]->address_components as $key=>$c){
            if($key == 0)
                $location = $c->long_name;
            else if($key==1)
                $city = $c->long_name;
            else if($key==2)
                $state = $c->long_name;
            else if($key==3)
                $country = $c->long_name;
            else if($key==4) 
                $postal_code = $c->long_name;
            else    
                break;
        }
        
        echo "location = ".$location."<br>";
        echo "city = ".$city."<br>";
        echo "state = ".$state."<br>";
        echo "country = ".$country."<br>";
        echo "postal_code = ".$postal_code."<br>";
        
        echo $lat = $output->results[0]->geometry->location->lat."<br>";
        echo $long = $output->results[0]->geometry->location->lng."<br>";
        echo $formatted_address = $output->results[0]->formatted_address."<br>";
    }
		
    public function map()
    {
        //$this->load->view('map');
        
        
    }  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */