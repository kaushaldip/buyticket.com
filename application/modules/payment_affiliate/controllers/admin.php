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
        $this->load->model('payment_affiliate_admin_model');
        $this->lang->load('english', 'english');        
        $this->load->library(array('email','general','form_validation'));       	
    }
    
/*event affiliate payment section start */    
    public function event_affiliate()
    {
        $end_of_month= $this->data['end_of_month'] = 1;// date("Y-m-t", strtotime($this->general->get_local_time('time')));    
        $today = $this->data['today'] = 1;// date("Y-m-d", strtotime($this->general->get_local_time('time')));
        
        if($end_of_month == $today)
            $this->data['payment_details'] = $this->payment_affiliate_admin_model->get_event_affiliate_payment_details();
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - Payment: Event Affiliate Program ')->build('event_affiliate', $this->data);
    }
    
    public function event_affiliate_pay($affilate_user_id)
    {
        if(is_ajax())
        {
            $this->data['affilate_user_id'] = $affilate_user_id;
            $this->data['user_detail'] = $this->payment_affiliate_admin_model->get_user_detail($affilate_user_id);
            $this->data['payment_details'] = $this->payment_affiliate_admin_model->get_event_affiliate_payment_details_byId($affilate_user_id);
            
            $this->template->enable_parser(false)->title(SITE_NAME .' - Payment: Pay Referral Affiliate Program  ')->build('event_affiliate_pay', $this->data);
        }
    }
    public function event_affiliate_pay_release()
    {
        if(is_ajax())
        {
            $order_ids = $this->input->post('order_ids');            
            $user_id = $this->input->post('user_id');
            $pay_through = $this->input->post('pay_through');
            $pay_detail = $this->input->post('pay_detail');
            
            //echo $pay_through." ".$pay_detail;exit;
            $total = 0;
            
            if(empty($order_ids) || empty($user_id)){
                $arr = array('result'=>'error','msg'=>"Something went wrong. Please try again.");
            }else{
                $order_id_arr = explode(',',$order_ids);
                foreach($order_id_arr as $ticket_order_id)
                {                   
                    $ticket_order_detail = $this->payment_affiliate_admin_model->get_ticket_order_detail($ticket_order_id, "event_id, referral_event_url_id , ticket_id, event_referral_payment, event_referral_payment_status");
                    
                    if(strtolower($ticket_order_detail->event_referral_payment_status) == 'no')
                    {
                        $affiliate_percent = $this->general->get_value_from_id('es_event',$ticket_order_detail->event_id,'affiliate_referral_rate');
                    
                        $this->payment_affiliate_admin_model->insert_event_affiliate_payment($user_id, $ticket_order_detail->event_id, $ticket_order_id, $ticket_order_detail->referral_event_url_id, $ticket_order_detail->ticket_id, $affiliate_percent, $ticket_order_detail->event_referral_payment, $pay_through, $pay_detail);   
                    
                        $total +=  $ticket_order_detail->event_referral_payment;
                        
                        $this->payment_affiliate_admin_model->update_ticket_order_event_affiliate($ticket_order_id);
                    }
                                        
                }  
                /*email section start*/
                    //set variables                
                    $user_email = $this->general->get_value_from_id('es_user',$user_id, "email");
                    $payment = "USD ".$total;
                    $pay_detail_1 = (strtoupper($pay_through)=='WU')? "Western Union " : "Bank Transaction";
                    $payment_detail = $pay_detail_1."<br/>".$pay_detail;
                
                $this->payment_affiliate_admin_model->send_event_affiliate_payment_release_email($user_email, $payment, $payment_detail);
                /*email section end*/
                
                $arr = array('result'=>'success', 'msg'=>"You have successfully release event affiliate payment. You have paid USD $total.");  
            }
            
            echo json_encode($arr);            
        }
    }
/*event affiliate payment section end */

/*referral affiliate payment section start */    
    public function referral_affiliate()
    {
        $end_of_month= $this->data['end_of_month'] =  date("Y-m-t", strtotime($this->general->get_local_time('time')));    
        $today = $this->data['today'] = date("Y-m-d", strtotime($this->general->get_local_time('time')));
        
        if($today != $end_of_month)
            $this->data['payment_details'] = $this->payment_affiliate_admin_model->get_referral_affiliate_payment_details();
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - Payment: Referral Affiliate Program ')->build('referral_affiliate', $this->data);
    }
    
    public function referral_affiliate_pay($affilate_user_id, $month)
    {
        if(is_ajax())
        {
            $this->data['affilate_user_id'] = $affilate_user_id;
            $this->data['month'] = $month;
            $this->data['user_detail'] = $this->payment_affiliate_admin_model->get_user_detail($affilate_user_id);
            $this->data['payment_details'] = $this->payment_affiliate_admin_model->get_referral_affiliate_payment_details_byId($affilate_user_id,$month);
            $this->template->enable_parser(false)->title(SITE_NAME .' - Payment: Pay Referral Affiliate Program  ')->build('referral_affiliate_pay', $this->data);
        }
    }
    
    public function referral_affiliate_pay_release()
    {
        if(is_ajax())
        {
            $order_ids = $this->input->post('order_ids');            
            $user_id = $this->input->post('user_id');
            $pay_through = $this->input->post('pay_through');
            $pay_detail = $this->input->post('pay_detail');
            
            //echo $pay_through." ".$pay_detail;exit;
            $total = 0;
            
            if(empty($order_ids) || empty($user_id)){
                $arr = array('result'=>'error','msg'=>"Something went wrong. Please try again.");
            }else{
                $order_id_arr = explode(',',$order_ids);
                foreach($order_id_arr as $ticket_order_id)
                {                   
                    $ticket_order_detail = $this->payment_affiliate_admin_model->get_ticket_order_detail($ticket_order_id, "event_id, fee * ticket_quantity as web_fee , ticket_id, referral_pay, referral_pay_status");
                    
                    if(strtolower($ticket_order_detail->referral_pay_status) == 'no')
                    {
                        $referral_user_url_id = $this->payment_affiliate_admin_model->get_referral_user_url_id_from_ticketOrderId($ticket_order_id);
                        
                        $affiliate_percent = AFFILIATE_REFERRAL_RATE;
                    
                        $this->payment_affiliate_admin_model->insert_referral_affiliate_payment($user_id, $ticket_order_detail->event_id, $ticket_order_id, $ticket_order_detail->ticket_id, $affiliate_percent,$ticket_order_detail->web_fee, $ticket_order_detail->referral_pay, $pay_through, $pay_detail, $referral_user_url_id);   
                    
                        $total +=  $ticket_order_detail->referral_pay;
                        
                        $this->payment_affiliate_admin_model->update_ticket_order_referral_affiliate($ticket_order_id);
                    }
                                        
                }  
                /*email section start*/
                    //set variables                
                    $user_email = $this->general->get_value_from_id('es_user',$user_id, "email");
                    $payment = "USD ".$total;
                    $pay_detail_1 = (strtoupper($pay_through)=='WU')? "Western Union " : "Bank Transaction";
                    $payment_detail = $pay_detail_1."<br/>".$pay_detail;
                
                $this->payment_affiliate_admin_model->send_referral_affiliate_payment_release_email($user_email, $payment, $payment_detail);
                /*email section end*/
                
                $arr = array('result'=>'success', 'msg'=>"You have successfully release referral affiliate payment. You have paid USD $total.");  
            }
            
            echo json_encode($arr);            
        }
    }
/*referral affiliate payment section end */
}