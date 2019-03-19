<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Myticket extends CI_Controller {

	function __construct() {
		parent::__construct();
		
		if(SITE_STATUS == 'offline')
		{
			redirect(site_url('offline'));exit;
		}
        
        /*converting language start*/
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        
        
		
		if($this->session->userdata(SESSION.'user_id'))
        {
          	//for login users only
            $this->load->model('users/account_module');
            $this->data['profile_data'] = $this->account_module->get_user_profile_data();            
        }else{
            $this->session->set_userdata(array('redirect_url' => site_url('myticket'))); //to define redirect url
            redirect(site_url('login'));
        }
		//load CI library
		$this->load->library('form_validation');			
			
		//Changing the Error Delimiters
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		//load module
		$this->load->model(array('event/event_model','event/event_payment_model','myticket_model'));
		
		
	}
	
	public function index()
    {
        $this->data['orders'] = $this->myticket_model->get_current_orders();
        
        $this->data['events'] = '';               
        //set SEO data
		$this->page_title = $this->lang->line('my_tickets');
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'myticket';
        $this->data['head'] = $this->lang->line('current_tickets');
        $this->data['link'] = "<a href='".site_url('myticket/past')."'>".$this->lang->line('previous_tickets')."</a>";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('myticket', $this->data);
    }
    
    public  function past()
    {
        //$this->data['current_orders'] = $this->myticket_model->get_current_orders();
        $this->data['orders'] = $this->myticket_model->get_past_orders();
        
        $this->data['events'] = ''; 
               
        //set SEO data
		$this->page_title = $this->lang->line('my_past_tickets');
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'myticket';
        $this->data['head'] = $this->lang->line('previous_tickets');
        $this->data['link'] = "<a href='".site_url('myticket')."'>".$this->lang->line('current_tickets')."</a>";
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('myticket', $this->data);
    }
    
    public function view($order_id)
    {
        $order = $this->data['orders'] = $this->myticket_model->get_order_by_order_id($order_id);        
        if(!$order)
            redirect('myticket'); 
        $this->data['contact'] = $this->myticket_model->get_order_contact_by_order_id($order_id);
        $this->data['event'] = $this->myticket_model->get_event_detail_by_order_id($order_id);
        //set SEO data
		$this->page_title = $this->lang->line('my_tickets');
		$this->data['meta_keys'] = DEFAULT_PAGE_TITLE;
		$this->data['meta_desc'] = DEFAULT_PAGE_TITLE;
        $this->data['navigation'] = 'myticket';
        
        /*get event id start*/
        $this->data['event_id'] = $this->myticket_model->get_event_id_from_order_id($order_id);
        /*get event id start*/
		
		$this->template
			->set_layout('general')
			->enable_parser(FALSE)
			->title($this->page_title)			
			->build('view_order_ticket', $this->data);
    }
    
    public function cancelOrder()
    {
        if(is_ajax())
        {
            $ticket_order_id = $this->input->post('ticket_order_id');
            
            $order_status = $this->myticket_model->check_order_payment_status($ticket_order_id); //if order status is pending, only then order is cancelled otherwise no
            
            if($order_status->ticket_type=='paid'){
                if(!$order_status || strtoupper($order_status->payment_status) != 'PENDING')
                {
                    echo 'failure';
                    exit;
                }    
            }          

            $ticket_qty = $this->input->post('ticket_qty');
            $ticket_id = $this->input->post('ticket_id');
            
            $this->db->query("UPDATE `es_event_ticket` SET `ticket_used` = ticket_used - $ticket_qty WHERE `id` = '$ticket_id'");
            
            //check if the ticket is available already
            $this->db->where('id', $ticket_order_id);
            $r = $this->db->delete('event_ticket_order');
            if($r)
                echo 'success';
            else
                echo 'error';
        }
    }
    public function refundOrder()
    {
        if(is_ajax())
        {
            $ticket_order_id = $this->data['ticket_order_id'] = $this->input->post('ticket_order_id');
            $event_id =$this->data['event_id'] = $this->general->get_value_from_id('es_event_ticket_order',$ticket_order_id,'event_id');
            
            $refund_id = $this->data['refund_id'] = $this->general->get_value_from_id('es_event',$event_id,'refund_id');            
            $organizer_paid_amount = $this->general->get_value_from_id('es_event_ticket_order',$ticket_order_id,'organizer_paid');
            
            if($refund_id == 0)
            {
                echo $this->lang->line('no_refund_msg');
            }else if($organizer_paid_amount > 0){
                echo $this->lang->line('payment_organizer_is_made');
            }else{
                $this->data['refund_detail'] = $this->myticket_model->get_refund_policy_by_event($event_id);
                $this->template->enable_parser(false)->title(SITE_NAME .'refund')->build('refund_order', $this->data);
            }
            
            
        }
    }
    
    public function refund_confirmed()
    {
        if(is_ajax())
        {            
            $ticket_order_id = $this->input->post('ticket_order_id');
            $percent = $this->input->post('percent');
            $event_id = $this->input->post('event_id');
            
            if($ticket_order_id=='' || $percent == '' || $event_id == ''){
                $arr = array('result'=>'failure','msg'=>$this->lang->line('no_refund_msg'));
            }else{
                $array_data = array(
                            'ticket_order_id'=> $ticket_order_id,
                            'percent' => $percent,
                            'event_id' => $event_id,
                            'refund_date' => $this->general->get_local_time('time'),
                        );
                $this->db->insert('event_ticket_order_refund', $array_data);  
                $ticket_refund_id = $this->db->insert_id();
                
                $array_data2 = array(
                        'refund_id' => $ticket_refund_id,
                    );        
                $this->db->where("id", $ticket_order_id);            
                $this->db->update("event_ticket_order",$array_data2);
                
                $arr = array('result'=>'success','msg'=>$this->lang->line('refund_msg'));
            }
            
            echo json_encode($arr);
            
        }
    }
    
    public function getmyticket()
    {
        if(is_ajax())
        {
            $ticket_order_id = $this->input->post('ticket_order_id');
        
            $this->load->library('ciqrcode');           
            
            //check if the ticket is available already
            $this->db->select("id");
            $this->db->from('event_ticket_sold');
            $this->db->where('ticket_order_id',$ticket_order_id);
            $query1 = $this->db->get();
            //echo $this->db->last_query();exit;
    		if ($query1->num_rows() > 0)
    		{
    		     $data = array(
                       'create_ticket' => "yes",
                    );
        		$this->db->where('id', $ticket_order_id);
        		$ok = $this->db->update('event_ticket_order', $data);
                
                echo "success";
                exit;  
            }
            
            
            $this->db->select("o.ticket_quantity,o.event_id, o.order_id, o.order_for_date_start, o.order_for_date_end, o.first_name, o.last_name, o.email,o.ticket_id, o.order_date, e.title, e.logo, l.address, l.physical_name,l.longitude,l.latitude, l.event_id, t.name, t.symbol, t.ticket_price,t.paid_free");
            $this->db->from('es_event_ticket_order as o');
            $this->db->join('es_event AS e',"e.id = o.event_id");
            $this->db->join('es_event_location AS l',"l.event_id = o.event_id");
            $this->db->join('es_event_ticket AS t',"t.id = o.ticket_id");
            $this->db->where("o.id = '$ticket_order_id'");
            $query = $this->db->get();
            //echo $this->db->last_query();exit;
    		if ($query->num_rows() > 0)
    		{
    		    $row = $query->row();          
                      
                $barcode = $row->order_id.rand(1000000,99999999);
                $datetime = date('M j, Y \a\t g:i A ', strtotime($row->order_for_date_start))." TO ".date('M j, Y \a\t g:i A ', strtotime($row->order_for_date_end));
                $location = $row->physical_name." \n<br/>".$row->address;
                $order_info = "Order #".$row->order_id.". Ordered by ".$row->first_name." ".$row->last_name." on ".date('M j, Y \a\t g:i A ', strtotime($row->order_date));
                
                for($i=1;$i<=$row->ticket_quantity;$i++){                    
                    $array_data = array(
                            'attendee' =>ucwords($row->first_name." ".$row->last_name),
                            'email' => $row->email,
                            'event_name'=>$row->title,
                            'event_logo' =>$row->logo,
                            'ticket_order_id'=>$ticket_order_id,
                            'barcode' =>$barcode.$i,
                            'datetime_detail'=>$datetime,
                            'ticket_name' => $row->name,
                            'location' => $location,
                            'order_info' =>$order_info,
                            'rate' => $row->ticket_price,
                            'payment_status' =>ucwords($row->paid_free." order"),
                            'price' =>$row->symbol." ".$row->ticket_price,
                            'longitude' =>$row->longitude,
                            'latitude' =>$row->latitude,
                        );                    
                    $this->db->insert('event_ticket_sold', $array_data);
                    
                    /*create AND save QR code start*/
                    $params['data'] = $barcode.$i;
                    $params['level'] = 'H';
                    $params['size'] = 3;
                    $params['savename'] = UPLOAD_FILE_PATH."qrcode/".$barcode.$i.'.png';
                    $this->ciqrcode->generate($params);
                    /*create AND save QR code end*/
                                        
                }             
                    
                /*update table es_event_ticket_order */
                $data = array(
                       'create_ticket' => "yes",
                    );
        		$this->db->where('id', $ticket_order_id);
        		$ok = $this->db->update('event_ticket_order', $data);
                /*update table es_event_ticket_order */
                if($ok)
                    echo "success";
                else
                    echo "error";             
    		}else{
                echo "error"; 
    		}
    		
        }
    }
    function printTicket($ticket_order_id)
    {	
        $tickets = $data['tickets'] = $this->myticket_model->get_tickets_sold($ticket_order_id); 
        
        //if(!$tickets){
           // redirect(site_url("myticket"));    
       // }
                
        $own_order = $this->myticket_model->check_my_order($ticket_order_id);
        
        if(!$own_order){
            redirect(site_url("myticket"));    
        }
        header('Content-type: text/html; charset=utf-8');
        $this->load->view('print_ticket',$data);        
        
        $html = $this->output->get_output();
     
	}
    function pdf($ticket_order_id)
    {	
        $this->lang->load('english', 'english');
        header('Content-type: text/html; charset=utf-8');
        $tickets = $data['tickets'] = $this->myticket_model->get_tickets_sold($ticket_order_id); 
        
        if(!$tickets){
            redirect(site_url("myticket"));    
        }
        
        $own_order = $this->myticket_model->check_my_order($ticket_order_id);
        
        if(!$own_order){
            redirect(site_url("myticket"));    
        }
        
        
        $this->load->view('pdf_gen',$data);        
        
        
        $html = $this->output->get_output();
        //$html = utf8_decode($html);
		$pdf_filename  = $ticket_order_id.'_ticket.pdf';
		$this->load->library('dompdf_lib');
        //$this->dompdf_lib = iconv('UTF-8','WINDOWS-1250',$this->dompdf_lib);// Create   new instance of dompdf
		$this->dompdf_lib->convert_html_to_pdf($html, $pdf_filename, TRUE);
	}
    
    function refund_policy($event_id)
    {
        if(is_ajax())
        {
            $this->data['refund_detail'] = $this->myticket_model->get_refund_policy_by_event($event_id);
            $this->data['event_id'] = $event_id;
            
            $this->template->enable_parser(false)->title(SITE_NAME ."Refund policy")->build('refund_policy_by_event', $this->data);
        }
    }    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */