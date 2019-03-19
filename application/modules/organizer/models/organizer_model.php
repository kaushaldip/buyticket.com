<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Organizer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }
    public $validate_settings = array(
        array(
            'field' => 'organizer_name',
            'label' => 'Organizer Name',
            'rules' => 'trim|required'),
        array(
            'field' => 'organizer_office_number',
            'label' => 'Organizer Mobile Number',
            'rules' => 'trim|required'),
        );

    public function get_organizer_info()
    {
        $this->db->select('organizer_name, organizer_official_doc, organizer_description, organizer_home_number,organizer_office_number');
        $this->db->from('user');
        $this->db->where("id = '" . $this->session->userdata(SESSION . 'user_id') . "'");
        $this->db->limit('1');

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();

        } else
            return false;
    }


    public function update_organizer_information()
    {
        if (!empty($_FILES['organizer_official_doc']['name'])) {
            $this->load->library('upload');
            $config['allowed_types'] = "doc|txt|pdf|pptx|ppt|docx|jpg|jpeg|bmp|gif|png";
            $config['upload_path'] = './' . UPLOAD_FILE_PATH . 'organizer_doc/';
            $config['file_name'] = $doc_name = 'organizer_doc' . '-' . $this->session->
                userdata(SESSION . 'user_id');
            $config['max_size'] = '2097152'; //~2MB
            $config['overwrite'] = true;
            $this->upload->initialize($config);
            $uploaded = $this->upload->do_upload('organizer_official_doc');

            $errors = $this->upload->display_errors('<div class="error">', '</div>');

            if (!$errors && $uploaded) {
                $fileData = $this->upload->data();
                //var_dump($fileData);exit;
                $array_data = array(
                    'organizer_name' => $this->input->post('organizer_name', true),
                    'organizer_home_number' => $this->input->post('organizer_home_number', true),
                    'organizer_office_number' => $this->input->post('organizer_office_number', true),
                    'organizer_official_doc' => $fileData['file_name'],
                    'organizer_description' => $this->input->post('organizer_description', true),
                    'organizer' => '2',
                    'last_modify_date' => $this->general->get_local_time('time'),
                    );
                $this->db->where("id", $this->session->userdata(SESSION . 'user_id'));
                $this->db->update("user", $array_data);
                return true;
            } else {
                $this->session->set_flashdata('message', $errors);
                return false;
            }
        } else {
            $array_data = array(
                'organizer_name' => $this->input->post('organizer_name', true),
                'organizer_home_number' => $this->input->post('organizer_home_number', true),
                'organizer_office_number' => $this->input->post('organizer_office_number', true),
                'organizer_description' => $this->input->post('organizer_description', true),
                'organizer' => '2',
                'last_modify_date' => $this->general->get_local_time('time'),
                );
            $this->db->where("id", $this->session->userdata(SESSION . 'user_id'));
            $this->db->update("user", $array_data);
            return true;
        }


    }

    public function get_current_event()
    {
        $user_id = $this->session->userdata(SESSION . 'user_id');

        $query = $this->db->query("SELECT  `e`.`id` ,  `e`.`title` ,  `e`.`logo` ,  `e`.`name` ,  `e`.`organizer_id` ,  `e`.`frequency` ,  `e`.`start_date` ,  `e`.`end_date` ,  `e`.`date_id` ,  `e`.`date_time_detail` ,  `e`.`target_gender` ,  `e`.`status` , e.publish,  `e`.`visit_count` ,  `e`.`created_date` , `e`.`updated_date` ,  `l`.`physical_name` ,  `u`.`id` AS userid,  `u`.`username` ,  `u`.`first_name` ,  `u`.`last_name` ,  `u`.`closed_account` , `u`.`organizer_name`,
                    eed.end
                    FROM (
                    `es_event` AS e
                    )
                    LEFT JOIN  `es_user` AS u ON  `u`.`id` =  `e`.`organizer_id` 
                    LEFT JOIN  `es_event_location` AS l ON  `e`.`id` =  `l`.`event_id`
                    Left join es_event_date as eed on  e.date_id = eed .id
                    
                    WHERE  `e`.`status` <>  '0'
                    AND  `e`.`organizer_id` =  '$user_id'
                    AND  `u`.`closed_account` =  'no'
                                            
                    AND 
                    IF(e.date_id > 0, NOW( ) < eed.end, NOW( ) < e.end_date)
                    AND e.publish < 2
                    
                    ORDER BY e.updated_date DESC, e.id desc
                    
                    "); //compare with event duration
        //$this->db->or_where("now() = e.custom_date ");
        //since 0 means deleted here

        //$query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else
            return false;

    }

    public function get_past_event()
    {
        $user_id = $this->session->userdata(SESSION . 'user_id');

        $query = $this->db->query("SELECT  `e`.`id` ,  `e`.`title` ,  `e`.`logo` ,  `e`.`name` ,  `e`.`organizer_id` ,  `e`.`frequency` ,  `e`.`start_date` ,  `e`.`end_date` ,  `e`.`date_id` ,  `e`.`date_time_detail` ,  `e`.`target_gender` ,  `e`.`status` ,  `e`.`visit_count` ,  `e`.`created_date` , `e`.`updated_date` ,  `l`.`physical_name` ,  `u`.`id` AS userid,  `u`.`username` ,  `u`.`first_name` ,  `u`.`last_name` ,  `u`.`closed_account` ,
            eed.end
            FROM (
            `es_event` AS e
            )
            LEFT JOIN  `es_user` AS u ON  `u`.`id` =  `e`.`organizer_id` 
            LEFT JOIN  `es_event_location` AS l ON  `e`.`id` =  `l`.`event_id`
            Left join es_event_date as eed on  e.date_id=eed .id
            
            WHERE  `e`.`status` <>  '0'
            AND  `e`.`organizer_id` =  '$user_id'
            AND  `u`.`closed_account` =  'no'
                                    
            AND 
            (
            IF(e.date_id > 0, NOW( ) > eed.end, NOW( ) > e.end_date)
            
            OR e.publish > 1
            )
            ORDER BY e.id DESC
            ");
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        } else
            return false;

    }
    public function get_organizers($org_id)
    {
        $this->db->select('*');
        $this->db->from('event_organizer as eo');
        $this->db->where("eo.id = '$org_id'");

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }
    public function get_events_of_organizer_past($org_id)
    {
                
        $query = $this->db->query("SELECT `e`.`id`, `e`.`title`, `e`.`logo`, `e`.`name`, `e`.`organizer_id`, `e`.`frequency`, `e`.`start_date`, `e`.`end_date`, `e`.`date_id`, `e`.`date_time_detail`, `e`.`target_gender`, `e`.`status`, `e`.`visit_count`, `e`.`created_date`, `e`.`updated_date`, `l`.`physical_name` 
            FROM (`es_event` AS e)
            LEFT JOIN `es_event_organizer_relation` as eor ON `eor`.`event_id` = `e`.`id` 
            LEFT JOIN `es_event_location` AS l ON `e`.`id` = `l`.`event_id`
            LEFT JOIN es_event_date as eed on  e.date_id=eed .id 
            WHERE `eor`.`organizer_id` = '$org_id' 
            AND 
            (
            IF(e.date_id > 0, NOW( ) > eed.end, NOW( ) > e.end_date)
            
            OR e.publish > 1
            )
            AND `e`.`status` <> '0'
            ");
        
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        }
        return false;
    }
    public function get_user_organiser($org_id)
    {
        $this->db->select('user_id');
        $this->db->from('es_event_organizer');
        $this->db->where("id = '$org_id'");
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    //       public function get_events_of_organizer_past($org_id)
    //    {
    //        $this->db->select('*');
    //        $this->db->from('es_event as ee');
    //        $this->db->join('es_event_organizer_relation as eor','eor.event_id = ee.id');
    //        $this->db->where("eor.organizer_id = '$org_id'");
    //
    //        $query = $this->db->get();
    //        //echo $this->db->last_query();exit;
    //		if ($query->num_rows() > 0)
    //		{
    //		   return $query->result();
    //		}
    //		return false;
    //    }

    public function get_events_of_organizer_current($org_id)
    {

        $this->db->select('e.id,e.title,e.logo,e.name, e.organizer_id,e.frequency, e.start_date, e.end_date, e.date_id,e.date_time_detail, e.`target_gender` , e.status, e.visit_count,e.created_date, e.updated_date, l.physical_name');
        $this->db->from('es_event AS e');
        $this->db->join('es_event_organizer_relation as eor', 'eor.event_id = e.id',
            'left');
        $this->db->join('es_event_location AS l', 'e.id = l.event_id', 'left');
        $this->db->join('es_event_date as eed', 'e.date_id = eed .id', 'left');
        
        $this->db->where("eor.organizer_id = '$org_id'");

        $this->db->where("IF(e.date_id > 0, NOW( ) < eed.end, NOW( ) < e.end_date)"); //compare with event duration
        
        $this->db->where('e.publish < 2');

        $this->db->where("e.status <> '0'"); //since 0 means deleted here

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            $data = $query->result();
            $query->free_result();
            return $data;
        }
        return false;
    }
    public function get_email_organizer($id)
    {
        $this->db->select('username, email');
        $this->db->from('user');
        $this->db->where("id = '" . $id . "'");
        $this->db->limit('1');

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->row();

        } else
            return false;
    }
    function dublicate_event_org($event_id)
    {
        $this->db->select('*');
        $this->db->from('es_event');
        $this->db->where("id = '" . $event_id . "'");
        $this->db->limit('1');

        $query = $this->db->get();
        // echo $this->db->last_query();//exit;
        if ($query->num_rows() > 0) {
            $event_dub = $query->row();

        } else
            return false;

        $rand = $this->general->genRandomString(5);
        $array_data = array(
            'organizer_id' => $event_dub->organizer_id,
            'title' => 'Copy #' . $rand . " " . $event_dub->title,
            'event_type_id' => $event_dub->event_type_id,
            'logo' => '',// $event_dub->logo,
            'description' => $event_dub->description,
            'frequency' => $event_dub->frequency,
            'date_id' => $event_dub->date_id,
            'start_date' => $event_dub->start_date,
            'end_date' => $event_dub->end_date,
            //'if_never_end' => ($this->input->post('if_never_end')=='on')?'yes':'no',
            'date_time_detail' => $event_dub->date_time_detail,
            'target_gender' => $event_dub->target_gender,
            'website' => $event_dub->website,
            'keywords' => $event_dub->keywords,
            'publish' => 0,
            'status' => $event_dub->status,
            'created_date' => $event_dub->created_date,
            'updated_date' => $event_dub->updated_date,
            'extra_performer' => $event_dub->extra_performer,
            );


        $this->db->insert('event', $array_data);
        $new_event_id = $this->db->insert_id();
        echo $new_event_id.','.$rand;  //return id and random number 
        $query->free_result();
        //event date table clone
        if ($event_dub->date_id != 0) {
            $query_d = $this->db->get_where('es_event_date', array('id' => $event_dub->
                    date_id));
            if ($query_d->num_rows() > 0) {
                $time_dub = $query_d->row();

            }
            $dat_t_array = array(
                'type' => $time_dub->type,
                'repeat' => $time_dub->repeat,
                'start_time' => $time_dub->start_time,
                'end_time' => $time_dub->end_time,
                'end' => $time_dub->end,
                'repeat_weekday' => $time_dub->repeat_weekday,
                'repeat_day' => $time_dub->repeat_day);
            $this->db->insert('es_event_date', $dat_t_array);
        }
        $query_d->free_result();
        //event location table clone
        $query_l = $this->db->get_where('es_event_location', array('event_id' => $event_id));
        if ($query_l->num_rows() > 0) {
            $loc_dub = $query_l->row();

        }
        $dat_lo_array = array(
            'event_id' => $new_event_id,
            'latitude' => $loc_dub->latitude,
            'longitude' => $loc_dub->longitude,
            'address' => $loc_dub->address,
            'physical_name' => $loc_dub->physical_name);
        $this->db->insert('es_event_location', $dat_lo_array);
        $query_l->free_result();

        // event organizer relation table clone
        $query_or = $this->db->get_where('es_event_organizer_relation', array('event_id' =>
                $event_id));
        if ($query_or->num_rows() > 0) {
            $rel_dub = $query_or->result();

        }
        foreach ($rel_dub as $rel):
            $dat_rel_array = array('event_id' => $new_event_id, 'organizer_id' => $rel->
                    organizer_id);
            $this->db->insert('es_event_organizer_relation', $dat_rel_array);
        endforeach;
        $query_or->free_result();

    }
    function get_payment_summary_current()
    {
        $user_id = $this->session->userdata(SESSION . 'user_id');


        $old_sql = "SELECT 
                ee.id as event_id, ee.title, SUM(`ticket_quantity`) AS total_tickets_sold, 
                SUM(total) AS total_revenue,
                SUM(fee * ticket_quantity) AS total_service_fee,
                SUM(net_actual_price * ticket_quantity) AS total_discount,
                SUM(event_referral_payment)    AS total_affiliate_fee,
                SUM(organizer_payment) AS total_net_income,
                SUM(organizer_paid) AS total_net_income_paid
                FROM es_event AS ee
                JOIN es_event_ticket_order AS eto ON ee.id = eto.event_id
                WHERE ee.organizer_id =$user_id AND eto.ticket_type='paid' AND refund_id = '0' and due = '0'
                GROUP BY ee.title ORDER BY eto.order_date DESC";

        $sql = "SELECT 
                ee.id as event_id, ee.title, SUM(`ticket_quantity`) AS total_tickets_sold, 
                SUM(ticket_price * ticket_quantity) AS total_revenue,
                SUM(fee * ticket_quantity) AS total_service_fee,
                SUM(discount * ticket_quantity) AS total_discount,
                SUM(event_referral_payment)    AS total_affiliate_fee,
                SUM(organizer_payment) AS total_net_income,
                SUM(organizer_paid) AS total_net_income_paid
                FROM es_event AS ee
                LEFT JOIN es_event_ticket_order AS eto ON ee.id = eto.event_id
                WHERE ee.organizer_id ='$user_id'
                AND eto.payment_status = 'COMPLETE'
                AND eto.create_ticket = 'yes'
                AND eto.refund_id = '0' 	 	
                GROUP BY ee.title ORDER BY eto.order_date DESC";
        $q = $this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    function get_organizer_payment_by_event($event_id, $past = '')
    {

        if ($past == '')
            $limit = '';
        else
            if ($past == 'past')
                $limit = " limit 1, 18446744073709551615";
            else
                $limit = " limit $past ";

        $user_id = $this->session->userdata(SESSION . 'user_id');

        $sql = "SELECT 
            op.id as oid,
            op.event_id as event_id,
            op.ticket_id as ticket_id,
            op.timestamp as payment_date, op.pay_through, op.pay_detail,
            
            SUM(op.payment) as total_earning,
            SUM(eto.ticket_quantity) as total_ticket_sold, 
            SUM(eto.ticket_quantity * eto.ticket_price) as total_revenue, 
            SUM(fee * ticket_quantity) as total_service_fee, 
            SUM(discount * ticket_quantity) AS total_discount, 
            SUM(event_referral_payment) AS total_affiliate_fee, 
            SUM(organizer_payment) AS total_net_income, 
            SUM(organizer_paid) AS total_net_income_paid
            
            FROM es_organizer_payment AS op
            JOIN es_event_ticket_order AS eto ON eto.id = op.ticket_order_id
            WHERE eto.event_id = '$event_id'
            AND op.organizer_id = '$user_id'
            AND eto.ticket_type = 'paid'
            AND refund_id = '0'
            AND due = '0'   
            GROUP BY op.timestamp         
            ORDER BY `op`.`timestamp` DESC 
            $limit";
        $q = $this->db->query($sql);
        //echo $this->db->last_query();
        if ($q->num_rows() > 0) {
            if ($past == '1')
                return $q->row();
            else
                return $q->result();
        }
        return false;
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
    function get_organizer_payment_detail()
    {
        $sql = "SELECT eu.id,eu.first_name, eu.last_name, eu.email,
            ee.title, ee.id as event_id            
            FROM es_user AS eu            
            JOIN es_event AS ee ON ee.organizer_id = eu.id
             
            WHERE eu.organizer =  '1'
            ORDER BY eu.id ";
        $q = $this->db->query($sql);
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    function get_refund_policy_detail($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('event_refund');
        $q = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    function refunding_after_event_cancel($event_id)
    {
        $sql = "SELECT id, email, payment_status, create_ticket, ticket_type            
            FROM es_event_ticket_order   
            WHERE event_id =  '$event_id'
            ORDER BY id ";
            
        $q = $this->db->query($sql);        
        if ($q->num_rows() > 0) {
            $res = $q->result();
            foreach($res as $r){                
                if(strtoupper($r->payment_status) == 'COMPLETE' && strtoupper($r->create_ticket) == 'YES' && strtoupper($r->ticket_type) == 'PAID' ){
                    $array_data = array(
                            'ticket_order_id'=> $r->id,
                            'percent' => '100.00',
                            'event_id' => $event_id,
                            'refund_date' => $this->general->get_local_time('time'),
                        );
                    $this->db->insert('event_ticket_order_refund', $array_data);  
                    $ticket_refund_id = $this->db->insert_id();
                    
                    $array_data2 = array(
                            'refund_id' => $ticket_refund_id,
                        );        
                    $this->db->where("id", $r->id);            
                    $this->db->update("event_ticket_order",$array_data2);
                }else if(strtoupper($r->payment_status) == 'COMPLETE' && strtoupper($r->create_ticket) == 'YES' && strtoupper($r->ticket_type) == 'FREE' ){
                    $this->db->where('id', $r->id);
                    $this->db->delete('event_ticket_order');
                }         
            }
        }
        
    }
    
    function email_to_refunding_after_event_cancel($event_id)
    {
        $this->load->model('event/event_model');
        $event_title = $this->event_model->get_event_name_from_id($event_id);
        $sql = "SELECT email, order_id            
            FROM es_event_ticket_order   
            WHERE event_id =  '$event_id'
            GROUP BY order_id
            ORDER BY id ";
        
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
        $template = $this->email_model->get_email_template("cancellation-of-event");
                    
        $q = $this->db->query($sql);        
        if ($q->num_rows() > 0) {
            $res = $q->result();
            foreach($res as $r)
            {
                if ($template) {        
                    
                        $subject = $template['subject'];
                        $emailbody = $template['email_body'];
        
                    $url = site_url('event/view/' . $event_id);
                    //check blank valude before send message
                    if (isset($subject) && isset($emailbody)) {                        
                        $parseElement = array(
                                    "EMAIL" => $r->email, 
                                    "EVENTNAME" => $event_title,
                                    "DATE" => $this->general->get_local_time('time'), 
                                    "SITENAME" => SITE_NAME, 
                                    "EVENTURL" => "<a href='".$url."'>".$event_title."</a>"
                            );
        
                        $subject = $this->email_model->parse_email($parseElement, $subject);
                        $emailbody = $this->email_model->parse_email($parseElement, $emailbody);
                        //echo $emailbody;exit;
                        //set the email things
                        $this->email->from(CONTACT_EMAIL, $this->lang->line("buyticket_customer_care"));
                        $this->email->to($r->email);
                        $this->email->subject($subject);
                        $this->email->message($emailbody);
                        $this->email->send();
                    }
                }
        
            }
        }
        
    }

}
