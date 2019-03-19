<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->general->admin_logged_in()) {
            redirect(ADMIN_LOGIN_PATH, 'refresh');
            exit;
        }
        $this->load->model('payment_admin_model');
        $this->lang->load('english', 'english');        
        $this->load->library(array('email','general','form_validation'));       	
    }
/*
    function index()
    {
        $this->data['payment_details'] = $this->payment_admin_model->
            get_payment_details();
        //$this->data['payment_details']=$this->payment_admin_model->get_user_from_payment_details();
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .
            ' - Payment Details View')->build('payment_details', $this->data);
    }
    function pay($id)
    {
        $this->data['event_id'] = $id;
        $this->data['payment_detail'] = $this->payment_admin_model->
            get_payment_event_detail($id);
        $this->template->enable_parser(false)->title(SITE_NAME .
            ' - Payment Details View')->build('payment_form', $this->data);
    }
    function pay_add()
    {
        $data = array('details' => $this->input->post('payment_details'), 'event_id' =>
            $this->input->post('event_id'));

        $this->db->insert('es_payment', $data);
        redirect(site_url(ADMIN_DASHBOARD_PATH . '/payment/index'));
    }
    function pay_edit($id)
    {
        $data = array('details' => $this->input->post('payment_details'), 'event_id' =>
            $this->input->post('event_id'));

        $this->db->where('id', $id);
        $this->db->update('es_payment', $data);
        redirect(site_url(ADMIN_DASHBOARD_PATH . '/payment/index'));
    }
*/

/*approve transaction section functions start*/
    function approve_transaction()
    {
        $this->load->model('event/event_model');
        $this->data['payment_details'] = $this->payment_admin_model->get_approve_transaction();
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - Approve Transaction ')->build('approve_transaction', $this->data);
    }
    
    function view_approve_transaction($ticket_order_id)
    {
        if(is_ajax()){
            $this->data['ticket_order_id'] = $ticket_order_id;
            $this->data['order_detail'] = $this->payment_admin_model->get_view_approve_transaction($ticket_order_id);
            $this->template->enable_parser(false)->title(SITE_NAME .
                ' - Approve Transaction ')->build('view_approve_transaction', $this->data);    
        }
        
    }
    
    function confirm_approve_payment()
    {
        if(is_ajax()){
            $ticket_order_id = $this->input->post('ticket_order_id');
            $amount_paid = $this->input->post('amount_paid');
            $due = $this->input->post('due');
            $received_amount = $this->input->post('received_amount');
            
            $payment_status = ($due == $amount_paid)? "COMPLETE" : "PENDING";
            
            /*in case the event has been cancelled*/
            $event_cancel = $this->general->get_value_from_id('es_event_ticket_order',$ticket_order_id,'event_cancel');
            if($event_cancel == 'yes')
            {
                $array_data = array(
                        'ticket_order_id'=> $ticket_order_id,
                        'percent' => '100.00',
                        'event_id' => $this->general->get_value_from_id('es_event_ticket_order',$ticket_order_id,'event_id'),
                        'refund_date' => $this->general->get_local_time('time'),
                    );
                $this->db->insert('event_ticket_order_refund', $array_data);  
                $ticket_refund_id = $this->db->insert_id();
                
                $array_data2 = array(
                        'refund_id' => $ticket_refund_id,
                    );        
                $this->db->where("id", $ticket_order_id);            
                $this->db->update("event_ticket_order",$array_data2);
            }
            /*in case the event has been cancelled*/
            
            $data = array('paid'=>($received_amount + $amount_paid), 'payment_status'=>$payment_status, 'due'=>($due - $amount_paid));
            
            $this->db->where('id', $ticket_order_id);
            $res = $this->db->update('es_event_ticket_order', $data);
            if($res)
                $arr = array ('response'=>'success','due_amount'=>($due - $amount_paid),'payment_status'=>$payment_status, 'received_amount'=>($received_amount + $amount_paid),'event_cancel'=>$event_cancel);
            else 
                $arr = array ('response'=>'error','due_amount'=>($due - $amount_paid),'payment_status'=>$payment_status, 'received_amount'=>($received_amount + $amount_paid));
            
            echo json_encode($arr);
                
        }        
        
    }
/*approve transaction section functions end*/


/*organizerpayment section functions start*/
    function organizer_payment()
    {
        $this->data['payment_details'] = $this->payment_admin_model->get_organizer_payment_detail();
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - Organizer Payment ')->build('organizer_payment', $this->data);
    }
    
    function view_organizer_payment($event_id)
    {
        if(is_ajax())
        {
            $this->data['event_id'] = $event_id;
            $this->data['event_organizer'] = $this->payment_admin_model->show_organizer_and_event($event_id);
            //$this->data['order_detail'] = $this->payment_admin_model->get_view_organizer_payment($event_id);
            $this->data['ticketwise_order'] = $this->payment_admin_model->get_ticketwise_order($event_id);
            $this->template->enable_parser(false)->title(SITE_NAME .
                ' - Approve Transaction ')->build('view_organizer_payment', $this->data);    
        }
        
    }
    
    function confirm_organizer_payment()
    {
        if(is_ajax())
        {
            $ticket_id = intval($this->input->post('ticket_id'));   
            $event_id = intval($this->input->post('event_id'));
                                 
            $event_organizer = $this->payment_admin_model->show_organizer_and_event($event_id);
                        
            $this->data['organizer_id'] = $event_organizer->id;
            $this->data['event_id'] = $event_id;
            
            $this->data['event_and_ticket'] = $this->payment_admin_model->get_event_and_ticket($event_id,$ticket_id); 
            $this->data['order_detail'] = $this->payment_admin_model->get_order_detail_byid($event_id,$ticket_id);
            
            $this->template->enable_parser(false)->title(SITE_NAME .' - Confirm Organizer Payment ')->build('confirm_organizer_payment', $this->data);
        }
        
    }
    
    function release_organizer_payment()
    {
        if(is_ajax())
        {
            $payment = $this->input->post('payment');
            $ticket_order_ids = $this->input->post('ticket_order_ids');
            $event_id = $this->input->post('event_id'); 
            $organizer_id = $this->input->post('organizer_id');
            $pay_through = $this->input->post('pay_through');
            $pay_detail = $this->input->post('pay_detail');  
            
            if(empty($ticket_order_ids) || empty($event_id) || empty($organizer_id) || empty($pay_through) || empty($payment))
            {
                $arr = array('result'=>'error','msg'=>"Something went wrong. Please try again.");
            }else{
                $ticket_order_id_arr = explode(',',$ticket_order_ids);
                foreach($ticket_order_id_arr as $ticket_order_id)
                {
                    $ticket_order_detail = $this->payment_admin_model->get_ticket_order_detail($ticket_order_id, "order_id, organizer_payment, ticket_id");
                    $this->payment_admin_model->insert_organizer_payment($organizer_id, $event_id, $ticket_order_detail->ticket_id, $ticket_order_id, $ticket_order_detail->order_id, $ticket_order_detail->organizer_payment, $pay_through, $pay_detail );
                    $this->payment_admin_model->update_ticket_order($ticket_order_id, $ticket_order_detail->organizer_payment);
                    
                    $ticket_id = $ticket_order_detail->ticket_id;
                }
                /*email section start*/
                    //set variables                
                    $organizer_email = $this->payment_admin_model->get_value_from_id('es_user',$organizer_id, "email");
                    $payment = "USD ".$payment;
                    $event_name = $this->payment_admin_model->get_value_from_id('es_event',$event_id, "title");
                    $ticket_name = $this->payment_admin_model->get_value_from_id('es_event_ticket',$ticket_id, "name");
                    $pay_detail_1 = (strtoupper($pay_through)=='WU')? "Western Union " : "Bank Transaction";
                    $payment_detail = $pay_detail_1."<br/>".$pay_detail;
                
                $this->payment_admin_model->send_organizer_payment_release_email($organizer_email, $payment, $event_name, $ticket_name, $payment_detail);
                /*email section end*/
                
                $arr = array('result'=>'success', 'msg'=>"You have successfully release organzier payment. You have paid USD $payment.");
            }
            echo json_encode($arr);
        }
    }
/*organizerpayment section functions end*/


/*refund transaction section functions end*/
    function refund_transaction()
    {
        $this->data['payment_details'] = $this->payment_admin_model->get_refund_transaction();
        $this->load->model('event/event_model');
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - Refund Transaction Details View ')->build('refund_transaction', $this->data);
                  
    } 
    
    function view_refund_transaction($ticket_order_id)
    {
        if(is_ajax())
        {
            $this->data['ticket_order_id'] = $ticket_order_id;
                        
            $this->data['refund_detail'] = $this->payment_admin_model->get_view_refund_transaction($ticket_order_id);
            $this->template->enable_parser(false)->title(SITE_NAME .
                ' - Refund Transaction ')->build('view_refund_transaction', $this->data);       
        }
    }   
    
    function refund_transaction_approved()
    {
        if(is_ajax())
        {
            $ticket_order_id = $this->input->post('ticket_order_id');
            $ticket_quantity = $this->general->get_value_from_id('es_event_ticket_order',$ticket_order_id,'ticket_quantity');
            $ticket_id  = $this->general->get_value_from_id('es_event_ticket_order',$ticket_order_id,'ticket_id');
            
            $data = array(                    
                   'refund_complete' => "yes",
                );
    		$this->db->where('id', $ticket_order_id);
    		$ok = $this->db->update('event_ticket_order', $data);
            if($ok)
            {
                /*update ticket table to remove seat*/            
                $this->db->where('id', $ticket_id);
                $this->db->set('ticket_used', "ticket_used-$ticket_quantity", FALSE);
                $this->db->update('es_event_ticket');        		
                /*update ticket table to remove seat*/
                
                /*delete tickets */
                $this->db->where('ticket_order_id', $ticket_order_id);
                $this->db->delete('es_event_ticket_sold'); 
                /*delete tickets */
            
                $arr = array('result'=>'success');
            }else{
                $arr = array('result'=>'error');
            }
            echo json_encode($arr);
        }
    }
/*refund transaction section functions end*/
    function cancel_payment($ticket_order_id)
    {
        if(is_ajax())
        {
            $this->data['ticket_order_id'] = $ticket_order_id;
            $this->template->enable_parser(false)->title(SITE_NAME .
                ' - Cancel Payment')->build('cancel_payment', $this->data);       
        }
    }
    
    function delete_ticket_order()
    {
        $ticket_order_id = $this->input->post('ticket_order_id');
        if($ticket_order_id=='')
            $arr = array('result'=>'error');
        else{
            $this->payment_admin_model->send_order_cancel_detail($ticket_order_id);
        
            $t = $this->db->delete('event_ticket_order', array('id' => $ticket_order_id));
            if($t)
                $arr = array('result'=>'success');
            else
                $arr = array('result'=>'error');
        }
        echo json_encode($arr);        
    }
    
    function refund_payment($ticket_order_id)
    {
        if(is_ajax())
        {
            $this->load->model('myticket/myticket_model');
            $this->data['ticket_order_id'] = $ticket_order_id;
            $this->template->enable_parser(false)->title(SITE_NAME .
                ' - Refund Payment')->build('refund_payment', $this->data);       
        }
    }
/* 
    function approve_transation_action($status, $id)
    {
        $data = array('payment_status' => 'pending');
        if ($status == 1)
            $data = array('payment_status' => 'complete');

        $this->db->where('id', $id);
        $this->db->update('es_event_ticket_order', $data);
        redirect(site_url(ADMIN_DASHBOARD_PATH . '/payment/approve_transaction'));

    }
    
    function affilate_payment()
    {
        $this->data['payment_details'] = $this->payment_admin_model->
            get_payment_details();
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .
            ' - Payment Details View')->build('affilate_payment', $this->data);
    }
*/
}
