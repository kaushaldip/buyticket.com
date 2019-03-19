<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_search_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }
    public function event_search($keywords = '', $location = '', $get_city = '',  $cat = '', $date =
        '', $type = '', $price = '', $gender='', $perpage='', $offset='')
    {

        if(!empty($keywords)){
            $event_ids='';
            $this->db->select('event_id');
            $this->db->from('event_keyword');
            $this->db->where("keyword like '$keywords'");
            $query1 = $this->db->get();
            if ($query1->num_rows() > 0) {
                foreach($query1->result() as $ar)
                {
                    $event_ids .= $ar->event_id.",";
                }                
                $query1->free_result();                
            }else{
                $event_ids ='0';
            }
            
            if (substr($event_ids,0,1) == ",") {
    			$event_ids = substr($event_ids,1,$event_ids);
    		}
    		
    		//Remove 2nd
    		$strLength = strlen($event_ids);
    		if (substr($event_ids,-1, 1) == ",") {
    			$event_ids = substr($event_ids,0,$strLength-1);
    		}
        }
            
    
        $this->db->select("e.id,e.title,e.logo,e.name,t.name as type_name, t.sub_type as sub_type,
                    e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date,
                    l.address, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id','left');
        if ($keywords)
            $this->db->where("(e.id IN ($event_ids) OR e.title LIKE '%$keywords%')"); //$this->db->join('es_event_keyword AS k', 'e.id = k.event_id');
        $this->db->where("e.status = '1'");
        $this->db->where("e.publish = '1'");
        if ($price=='1'){
            
        }else if($price)
            $this->db->where("e.free_paid = '$price'");
        if ($cat=='1'){
            
        }else if($cat)
            $this->db->where("t.name ='$cat'");

        if ($type=='1'){
            
        }else if($type){
            $type = urldecode($type);
            $this->db->where("t.sub_type ='$type'");
        }        
        
        if($gender){
            if($gender=='1'){
                
            }            
            else if($gender=='both')
                $this->db->where("(e.target_gender ='B' OR e.target_gender ='')");
            else if($gender=='male')
                $this->db->where("e.target_gender ='M'");
            else if($gender=='female')
                $this->db->where("e.target_gender ='F'");
        }    
            
        /*
        if ($date == 'today') {
            $this->db->where('now() BETWEEN e.start_date AND e.end_date');
        } else if($date == 'tomorrow'){
            $this->db->where('(now() + INTERVAL 1 DAY) BETWEEN e.start_date AND e.end_date');
        }else if ($date == 'week') {
            $this->db->where('(WEEK( start_date ) = WEEK( CURDATE( ) ) OR WEEK( end_date ) = WEEK( CURDATE( ) ))');
        } else if ($date == 'month') {
                $this->db->where('(MONTH( start_date ) = MONTH( CURDATE( ) ) OR MONTH( end_date ) = MONTH( CURDATE( ) ))');
        } else if($date == 'months'){
            
            $this->db->where("PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM start_date),EXTRACT(YEAR_MONTH FROM NOW())) <= 3");
        }
        */
        if ($date == 'today') {
            $this->db->where("if( e.date_id = '0', now() BETWEEN e.start_date AND e.end_date, now() <=d.end )");
        } else if($date == 'tomorrow'){
            $this->db->where("if( e.date_id = '0',(now() + INTERVAL 1 DAY) BETWEEN e.start_date AND e.end_date,(now() + INTERVAL 1 DAY)<=d.end )");
        }else if ($date == 'week') {
            $this->db->where("if( e.date_id = '0', (WEEK( start_date ) = WEEK( CURDATE( ) ) OR WEEK( end_date ) = WEEK( CURDATE( ) )), (WEEK( d.end ) = WEEK( CURDATE( ) )))");
        } else if ($date == 'month') {
            $this->db->where("if( e.date_id = '0',(MONTH( start_date ) = MONTH( CURDATE( ) ) OR MONTH( end_date ) = MONTH( CURDATE( ) )), MONTH( d.end ) = MONTH( CURDATE( )))");
        }else if($date == 'months'){            
            $this->db->where("if( e.date_id = '0',PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM start_date),EXTRACT(YEAR_MONTH FROM NOW())) <= 3, PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM d.end),EXTRACT(YEAR_MONTH FROM NOW())) <= 3)");
        }
        $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
        //compare with event duration

                    
        $city = '';
        $country = '';
        $lng = '';
        $lat = '';
        if ($location) {    
            
            if($location==1 || $location == ''){              
                $country = ($this->input->cookie(SESSION.'country_cookie'))? $this->input->cookie(SESSION.'country_cookie'): '';                
            }else{                
                $output2 = $this->getlatandlon_without_key($location,'en');
                //var_dump($output2->results[0]);exit;
                if ($output2->status == "OK") {
                    for ($j = 0; $j < count($output2->results[0]->address_components); $j++) {
                        if ($output2->results[0]->address_components[$j]->types[0] == 'country'){
                            $country = $output2->results[0]->address_components[$j]->long_name;
                            $cookie2 = array('name' => SESSION."country_cookie",'value'  => $country,'expire' => time()+3600*24*30);
                            $this->input->set_cookie($cookie2);   
                        }
                        if ($output2->results[0]->address_components[$j]->types[0] == 'locality'){
                            $city = $output2->results[0]->address_components[$j]->long_name;
                            $cookie21 = array('name' => SESSION."city_cookie",'value'  => $city,'expire' => time()+3600*24*30);
                            $this->input->set_cookie($cookie21);                            
                        }
                    }   
                    /*added for buytickat*/
                    $current_location = $location;
                    $cookie_location = array('name' => SESSION."current_location_cookie",'value'  => $current_location,'expire' => time()+3600*24*30);
                    $this->input->set_cookie($cookie_location);
                    /*added for buytickat*/
                }
                else {
                    redirect(site_url('event'));
                }    
            }  
        }else{
            $country = $this->input->cookie(SESSION.'country_cookie');
        }
         
        $ln = $this->config->item('language_abbr');
        if($get_city){
            if($get_city == '1' || $get_city == ''){
                if($this->input->cookie(SESSION.'lat') && $this->input->cookie(SESSION.'lng'))        
                {
                    $lat = ($this->input->cookie(SESSION.'lat'))? $this->input->cookie(SESSION.'lat'): '';
                    $lng = ($this->input->cookie(SESSION.'lng'))? $this->input->cookie(SESSION.'lng'): '';
                    $this->db->select("l.city,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( $lng) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance");
                    $this->db->having(array('distance <' => 100));
                    $this->db->group_by("l.city");
                   
                }else{
                    $country = $this->input->cookie(SESSION.'country_cookie');                    
                }                 
            }else{
                $output2 = $this->getlatandlon_without_key($get_city);
                //print_r($output2);
                //json_encode($output2);
                if ($output2->status == "OK") {
                    for ($j = 0; $j < count($output2->results[0]->address_components); $j++) {
                        $lat = $output2->results[0]->geometry->location->lat;
                        $cookieA = array('name' => SESSION."lat",'value'  => $lat,'expire' => time()+3600*24*30);
                        $this->input->set_cookie($cookieA); 
                        $lng = $output2->results[0]->geometry->location->lng;
                        $cookieB = array('name' => SESSION."lng",'value'  => $lng,'expire' => time()+3600*24*30);
                        $this->input->set_cookie($cookieB);
                    }                    
                  
                }
                
                else {
                    redirect(site_url('event'));
                }
                $this->db->where("(l.city_en = '$get_city')");    
            }            
        }
        
           
        //echo $city; echo $country."<br/>";
        if($country!='')
            $this->db->where("(country = '$country')");
        if($city!='')
            $this->db->where("(city_$ln = '$city')");            
            
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');
        $this->db->order_by("e.updated_date", "desc");
        if(!empty($perpage))
            $this->db->limit($perpage, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query();

        return $query;
    }
    
    public function event_search_for_rss($keywords = '', $location = '', $get_city = '',  $cat = '', $date =
        '', $type = '', $price = '', $gender='', $perpage, $offset)
    {

        if(!empty($keywords)){
            $event_ids='';
            $this->db->select('event_id');
            $this->db->from('event_keyword');
            $this->db->where("keyword like '$keywords'");
            $query1 = $this->db->get();
            if ($query1->num_rows() > 0) {
                foreach($query1->result() as $ar)
                {
                    $event_ids .= $ar->event_id.",";
                }                
                $query1->free_result();                
            }else{
                $event_ids ='0';
            }
            
            if (substr($event_ids,0,1) == ",") {
    			$event_ids = substr($event_ids,1,$event_ids);
    		}
    		
    		//Remove 2nd
    		$strLength = strlen($event_ids);
    		if (substr($event_ids,-1, 1) == ",") {
    			$event_ids = substr($event_ids,0,$strLength-1);
    		}
        }
            
    
        $this->db->select("e.id,e.title,e.logo,e.name,t.name as type_name, t.sub_type as sub_type,
                    e.organizer_id,e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date,
                    l.address, l.physical_name, u.id as userid, u.username, u.first_name, u.last_name,u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id','left');
        if ($keywords)
            $this->db->where("(e.id IN ($event_ids) OR e.title LIKE '%$keywords%')"); //$this->db->join('es_event_keyword AS k', 'e.id = k.event_id');
        $this->db->where("e.status = '1'");
        $this->db->where("e.publish = '1'");
        if ($price=='1'){
            
        }else if($price)
            $this->db->where("e.free_paid = '$price'");
        if ($cat=='1'){
            
        }else if($cat)
            $this->db->where("t.name ='$cat'");

        if ($type=='1'){
            
        }else if($type){
            $type = urldecode($type);
            $this->db->where("t.sub_type ='$type'");
        }        
        
        if($gender){
            if($gender=='1'){
                
            }            
            else if($gender=='both')
                $this->db->where("e.target_gender ='B' OR e.target_gender =''");
            else if($gender=='male')
                $this->db->where("e.target_gender ='M'");
            else if($gender=='female')
                $this->db->where("e.target_gender ='F'");
        }    
            
        if ($date == 'today') {
            $this->db->where("if( e.date_id = '0', now() BETWEEN e.start_date AND e.end_date, now() <=d.end )");
        } else if($date == 'tomorrow'){
            $this->db->where("if( e.date_id = '0',(now() + INTERVAL 1 DAY) BETWEEN e.start_date AND e.end_date,(now() + INTERVAL 1 DAY)<=d.end )");
        }else if ($date == 'week') {
            $this->db->where("if( e.date_id = '0', (WEEK( start_date ) = WEEK( CURDATE( ) ) OR WEEK( end_date ) = WEEK( CURDATE( ) )), (WEEK( d.end ) = WEEK( CURDATE( ) )))");
        } else if ($date == 'month') {
            $this->db->where("if( e.date_id = '0',(MONTH( start_date ) = MONTH( CURDATE( ) ) OR MONTH( end_date ) = MONTH( CURDATE( ) )), MONTH( d.end ) = MONTH( CURDATE( )))");
        }else if($date == 'months'){            
            $this->db->where("if( e.date_id = '0',PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM start_date),EXTRACT(YEAR_MONTH FROM NOW())) <= 3, PERIOD_DIFF(EXTRACT(YEAR_MONTH FROM d.end),EXTRACT(YEAR_MONTH FROM NOW())) <= 3)");
        }
        $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not

           
        $city = '';
        $country = '';
        $lng = '';
        $lat = '';
        if ($location) {    
            
            if($location==1 || $location == ''){              
                $country = ($this->input->cookie(SESSION.'country_cookie'))? $this->input->cookie(SESSION.'country_cookie'): '';            
            }else{                
                $output2 = $this->getlatandlon_without_key($location,'en');
                
                if ($output2->status == "OK") {
                    for ($j = 0; $j < count($output2->results[0]->address_components); $j++) {
                        if ($output2->results[0]->address_components[$j]->types[0] == 'country'){
                            $country = $output2->results[0]->address_components[$j]->long_name;
                            $cookie2 = array('name' => SESSION."country_cookie",'value'  => $country,'expire' => time()+3600*24*30);
                            $this->input->set_cookie($cookie2);   
                        }
                        if ($output2->results[0]->address_components[$j]->types[0] == 'locality'){
                            $city = $output2->results[0]->address_components[$j]->long_name;
                            $cookie21 = array('name' => SESSION."city_cookie",'value'  => $city,'expire' => time()+3600*24*30);
                            $this->input->set_cookie($cookie21);                            
                        }
                    }   
                                    
                  
                } 
            }  
        }else{
            $country = $this->input->cookie(SESSION.'country_cookie');
        }
         
        if($get_city){
            if($get_city == '1' || $get_city == ''){
                if($this->input->cookie(SESSION.'lat') && $this->input->cookie(SESSION.'lng'))        
                {
                    $lat = ($this->input->cookie(SESSION.'lat'))? $this->input->cookie(SESSION.'lat'): '';
                    $lng = ($this->input->cookie(SESSION.'lng'))? $this->input->cookie(SESSION.'lng'): '';
                    $this->db->select("l.city,( 3959 * ACOS( COS( RADIANS( $lat ) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS( $lng) ) + SIN( RADIANS( $lat ) ) * SIN( RADIANS( latitude ) ) ) ) AS distance");
                    $this->db->having(array('distance <' => 100));
                    $this->db->group_by("l.city");
                   
                }else{
                    $country = $this->input->cookie(SESSION.'country_cookie');
                }                 
            }else{
                $output2 = $this->getlatandlon_without_key($get_city);

                if ($output2->status == "OK") {
                    for ($j = 0; $j < count($output2->results[0]->address_components); $j++) {
                        $lat = $output2->results[0]->geometry->location->lat;
                        $lng = $output2->results[0]->geometry->location->lng;
                    }                    
                  
                }
                $this->db->where("l.city = '$get_city' ");    
            }            
        }
      
        if($country!='')
            $this->db->where("(country = '$country')");
        if($city!='')
            $this->db->where("(city = '$city')");
            
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');
        $this->db->order_by("e.updated_date", "desc");
        $this->db->limit($perpage, $offset);
        $query = $this->db->get();

        return $query;
    }
    public function getlatandlon_without_key($where, $lang="en")
    {
        $whereurl = urlencode($where);
        $url = ('http://maps.googleapis.com/maps/api/geocode/json?address=' . $whereurl . '&sensor=false&language='.$lang);
        $geocode = file_get_contents($url);
        $output = json_decode($geocode);
        return $output;
    }
    
    public function get_cities_by_country_name($country_name)
    {
        $this->db->select('city');
        $this->db->from('event_location');
        $this->db->where('country',$country_name);
        $this->db->order_by('city');
        $this->db->group_by('city');
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }else{
            return false;
        }
    }
    
    /*new added for buytickat*/
    public function getPopularEvents($country="",$city="",$perpage="",$offset="")
    {
        $this->db->select("e.id,e.title,e.logo,t.name as type_name, t.sub_type as sub_type,
                  e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,
                    l.address, l.physical_name, u.id as userid, u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id','left');
        
        $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
        //compare with event duration
        
        if($country!='')
            $this->db->where("(country = '$country')");
        if($city!='')
            $this->db->where("(city_en = '$city')");            
            
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');
        $this->db->order_by("e.visit_count", "desc");
        if(!empty($perpage))
            $this->db->limit($perpage, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }else{
            return false;
        }
    }
    public function getUpcomingEvents($country="",$city="",$perpage="",$offset="")
    {
        $this->db->select("e.id,e.title,e.logo,t.name as type_name, t.sub_type as sub_type,
                  e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,
                    l.address, l.physical_name, u.id as userid, u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id','left');
        
        $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
        //compare with event duration
        
        if($country!='')
            $this->db->where("(country = '$country')");
        if($city!='')
            $this->db->where("(city_en = '$city')");            
            
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');
        $this->db->order_by("e.end_date", "asc");
        $this->db->order_by("d.end", "asc");
        if(!empty($perpage))
            $this->db->limit($perpage, $offset);
        $query = $this->db->get();
//        echo $this->db->last_query();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }else{
            return false;
        }
    }
    public function getLatestEvents($country="",$city="",$perpage="",$offset="")
    {
        $this->db->select("e.id,e.title,e.logo,t.name as type_name, t.sub_type as sub_type,
                  e.frequency, e.start_date, e.end_date,e.date_id,e.date_time_detail,  e.`target_gender` , e.status, e.visit_count,
                    l.address, l.physical_name, u.id as userid, u.closed_account");
        $this->db->from('es_event AS e');
        $this->db->join('es_user AS u', 'u.id = e.organizer_id', 'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_type AS t', 't.id = e.event_type_id');
        $this->db->join('es_event_date AS d', 'd.id = e.date_id','left');
        
        $this->db->where("u.closed_account = 'no'"); // compare with user / organize exits or not
        //compare with event duration
        
        if($country!='')
            $this->db->where("(country = '$country')");
        if($city!='')
            $this->db->where("(city_en = '$city')");            
            
        $this->db->where("if( e.date_id = '0', now( ) <= e.end_date, now( ) <=d.end )");
        $this->db->where("u.organizer != '0' ");
        $this->db->group_by('e.title');
        $this->db->order_by("e.id", "desc");
        if(!empty($perpage))
            $this->db->limit($perpage, $offset);
        $query = $this->db->get();
        //echo $this->db->last_query();

        if($query->num_rows() > 0)
        {
            return $query->result();
        }else{
            return false;
        }
    }
    
    public function getAllEvents()
    {                
        $query = $this->db->query("SELECT  CONCAT('event/view/',`e`.`id`,'/',`e`.`title`) as `url` ,  `e`.`title` ,  CONCAT(`t`.`name` ,' / ' ,  `t`.`sub_type`) as description ,  `e`.`frequency` ,  `e`.`start_date` as `date`
            FROM (
            `es_event` AS e
            )
            LEFT JOIN  `es_user` AS u ON  `u`.`id` =  `e`.`organizer_id` 
            JOIN  `es_event_type` AS t ON  `t`.`id` =  `e`.`event_type_id` 
            WHERE  `u`.`closed_account` =  'no'
            AND  `u`.`organizer` !=  '0'
            GROUP BY  `e`.`id` 
            ORDER BY  `e`.`id` DESC ");
        //echo $this->db->last_query();

        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return false;
        }
    }
    /*new added for buytickat*/

}
?>
