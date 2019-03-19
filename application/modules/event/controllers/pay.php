<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pay extends CI_Controller {
		
	private $currency = 'USD'; // currency for the transaction
	private $ec_action = 'Sale'; // for PAYMENTREQUEST_0_PAYMENTACTION, it's either Sale, Order or Authorization
	
	function __construct() {
		parent::__construct();
		$paypal_details = array(
			// you can get this from your Paypal account, or from your
			// test accounts in Sandbox
			'API_username' => PAYPAL_API_USERNAME, // 'esajayyogal-facilitator_api1.gmail.com', // 'paypal_api1.somedomain.com', 
			'API_signature' => PAYPAL_API_SIGNATURE, // 'Aw96tTs-bXJR73B7RYZX6RIxnL3HAtTK1bvcaktTcWfunTX39b-PT0Mu',// 'ABCDEFGHIJKLMNOPQRSTUVWXYZabc.0123456789abcdefgihjklmn-e', 
			'API_password' => PAYPAL_API_PASSWORD, // '1369132902',// 'ABCDEFGHIJ123456',
			// Paypal_ec defaults sandbox status to true
			// Change to false if you want to go live and
			// update the API credentials above
			 'sandbox_status' => true,
		);
		$this->load->library('paypal_ec', $paypal_details);
        $this->load->model(array('event_model','event_payment_model','category/category','affiliate/affiliate_model','event_payment_model'));
	}
	
	/* -------------------------------------------------------------------------------------------------
	* a sample order page, which just iterate $this->product and display them
	* --------------------------------------------------------------------------------------------------
	*/
	//function index() {
//		echo "<p>You are about to buy</p>";
//		echo "<ul>";
//		foreach($this->product as $p) {
//			echo "<li>{$p['name']} - \${$p['price']}</li>";
//		}
//		echo "</ul>";
//		echo "<h1><a href='" . site_url('event/test/buy') . "'>BUY NOW</a></h1>";
//	}
	
	/* -------------------------------------------------------------------------------------------------
	* a sample buy function in your Controller that does the SetExpressCheckout and redirects to Paypal
	* --------------------------------------------------------------------------------------------------
	*/
	function paypal($id,$order_id,$token_id,$temp_cart_id) {
		$to_buy = array(
			'desc' => 'Payment for '.SITE_NAME, 
			'currency' => $this->currency, 
			'type' => $this->ec_action, 
			'return_URL' => site_url("event/pay/order_complete/$id/$order_id/$token_id/$temp_cart_id"), 
			// see below have a function for this -- function back()
			// whatever you use, make sure the URL is live and can process
			// the next steps
			'cancel_URL' => site_url("event/order/$id/$order_id/$token_id/$temp_cart_id"), // this goes to this controllers index()
			//'shipping_amount' => 5.00, 
			'get_shipping' => true);
		// I am just iterating through $this->product from defined
		// above. In a live case, you could be iterating through
		// the content of your shopping cart.
        $order = $this->event_model->get_temp_cart_detail($id,$order_id,$token_id,$temp_cart_id);
        if(!$order){
            $this->session->set_flashdata('message','Your session has expired. Try ordering again.');		      
			redirect('event/view/'.$id,'refresh');
			exit;
        }
        $tickets_no = explode(',',$order->ticket_quantity); 
        $tickets_id = explode(',',$order->ticket_id);
        $total = 0;
        $net_total = 0;
        $event_name = $this->event_model->get_event_name_from_id($id);
        foreach($tickets_no as $key=>$ticket)
        {
            if($ticket=='')
                continue;
            $ticket_detail = $this->event_model->get_ticket_detail_from_id($tickets_id[$key]);                       
            $temp_product = array(
				'name' => ucwords($event_name." : ".$ticket_detail->name), 
				//'desc' => $p['desc'], 
				'number' => strtoupper($ticket_detail->max_number), 
				'quantity' => $ticket, // simple example -- fixed to 1
				'amount' => $ticket_detail->ticket_price
                );
				
			// add product to main $to_buy array
			$to_buy['products'][] = $temp_product;
            //$net_total += ($ticket_detail->ticket_price - $ticket_detail->website_fee) * $ticket;
            $net_total += $ticket_detail->ticket_price * $ticket;
        }
        if($order->promotion_code_id != 0)
        {
            $discount_per = $order->discount;        
            $discount =  number_format($net_total * $discount_per / 100, 2, '.', '');
            $discount_product = array(
    				'name' => 'Coupon Code', 
    				'desc' => $discount_per." %", 
    				//'number' => '87965', 
    				'quantity' => -1, // simple example -- fixed to 1
    				'amount' => $discount);
            $to_buy['products'][] = $discount_product;
        }        
        
                       
		// enquire Paypal API for token
		$set_ec_return = $this->paypal_ec->set_ec($to_buy);
		if (isset($set_ec_return['ec_status']) && ($set_ec_return['ec_status'] === true)) {
			// redirect to Paypal
			$this->paypal_ec->redirect_to_paypal($set_ec_return['TOKEN']);
			// You could detect your visitor's browser and redirect to Paypal's mobile checkout
			// if they are on a mobile device. Just add a true as the last parameter. It defaults
			// to false
			// $this->paypal_ec->redirect_to_paypal( $set_ec_return['TOKEN'], true);
		} else {
			$this->_error($set_ec_return);
		}
	}
	
	/* -------------------------------------------------------------------------------------------------
	* a sample back function that handles
	* --------------------------------------------------------------------------------------------------
	*/
    /*
	function back() {
		// we are back from Paypal. We need to do GetExpressCheckoutDetails
		// and DoExpressCheckoutPayment to complete.
		$token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
		// GetExpressCheckoutDetails
		$get_ec_return = $this->paypal_ec->get_ec($token);
		if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {
			// at this point, you have all of the data for the transaction.
			// you may want to save the data for future action. what's left to
			// do is to collect the money -- you do that by call DoExpressCheckoutPayment
			// via $this->paypal_ec->do_ec();
			//
			// I suggest to save all of the details of the transaction. You get all that
			// in $get_ec_return array
			$ec_details = array(
				'token' => $token, 
				'payer_id' => $payer_id, 
				'currency' => $this->currency, 
				'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
				'IPN_URL' => site_url('test/ipn'), 
				// in case you want to log the IPN, and you
				// may have to in case of Pending transaction
				'type' => $this->ec_action);
				
			// DoExpressCheckoutPayment
			$do_ec_return = $this->paypal_ec->do_ec($ec_details);
			if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {
				// at this point, you have collected payment from your customer
				// you may want to process the order now.
				echo "<h1>Thank you. We will process your order now.</h1>";
				echo "<pre>";
				echo "\nGetExpressCheckoutDetails Data\n" . print_r($get_ec_return, true);
				echo "\n\nDoExpressCheckoutPayment Data\n" . print_r($do_ec_return, true);
				echo "</pre>";
			} else {
			 echo 'first';
				$this->_error($do_ec_return);
			}
		} else {
		  echo "second";
			$this->_error($get_ec_return);
		}
	}
    */
    function order_complete($id,$order_id,$token_id,$temp_cart_id)
    {		
		$token = $_GET['token'];
		$payer_id = $_GET['PayerID'];
		// GetExpressCheckoutDetails
		$get_ec_return = $this->paypal_ec->get_ec($token);
		if (isset($get_ec_return['ec_status']) && ($get_ec_return['ec_status'] === true)) {			
			$ec_details = array(
				'token' => $token, 
				'payer_id' => $payer_id, 
				'currency' => $this->currency, 
				'amount' => $get_ec_return['PAYMENTREQUEST_0_AMT'], 
				'IPN_URL' => site_url('event/pay/ipn'), 
				// in case you want to log the IPN, and you
				// may have to in case of Pending transaction
				'type' => $this->ec_action);
				
			// DoExpressCheckoutPayment
			$do_ec_return = $this->paypal_ec->do_ec($ec_details);
			if (isset($do_ec_return['ec_status']) && ($do_ec_return['ec_status'] === true)) {				
//				echo "<h1>Thank you. We will process your order now.</h1>";
//				echo "<pre>";
//				echo "\nGetExpressCheckoutDetails Data\n" . print_r($get_ec_return, true);
//				echo "\n\nDoExpressCheckoutPayment Data\n" . print_r($do_ec_return, true);
//				echo "</pre>";
                $paypal_info_id = $this->event_payment_model->insert_paypal_info($get_ec_return,$do_ec_return);                
                if($paypal_info_id > 0){
                    //insert order
                    $res = $this->event_payment_model->insert_paypal_order($id,$order_id,$token_id,$temp_cart_id,$get_ec_return,$do_ec_return,$paypal_info_id);
                    if($res){
                        $temp_order = $this->event_model->get_temp_cart_detail($id,$order_id,$token_id,$temp_cart_id);
                        $this->event_payment_model->send_mail_to_organiser($temp_order);
                        $this->event_payment_model->send_mail_to_buyer($order_id);
                        //create tickets
                        $this->event_model->delete_temp_order($order_id); //delete temp_cart row
                        
                        $this->general->set_notification($this->session->userdata(SESSION.'email'). " has made a payment for order <strong>#$order_id</strong> via PAYPAL transaction and proceed to identify payment.","payment/approve_transaction"); //notification
                        
                        redirect('event/orderconfirm/'.$id."/".$order_id);    
                    }else{
                        $err_msg = "Something went wrong here. Please try again.";
                        $this->session->set_flashdata('message',$err_msg);
                        redirect(site_url('event/view/'.$id));
                    }
                    
                    
                }else{
                    $err_msg = "Something went wrong. Please try again.";
                    $this->session->set_flashdata('message',$err_msg);
                    redirect(site_url('event/view/'.$id));
                }
                
			} else {
			    $err_msg = "Error at Express Checkout. Invalid token.";
                $this->session->set_flashdata('message',$err_msg);
                redirect(site_url('event/view/'.$id));
            	//$this->_error($do_ec_return);
			}
		} else {			
            $err_msg = "Error at Express Checkout. The PayerID value is invalid.";
            $this->session->set_flashdata('message',$err_msg);
            redirect(site_url('event/view/'.$id));
            //$this->_error($get_ec_return);
		}
	}
	
	/* -------------------------------------------------------------------------------------------------
	* The location for your IPN_URL that you set for $this->paypal_ec->do_ec(). obviously more needs to
	* be done here. this is just a simple logging example. The /ipnlog folder should the same level as
	* your CodeIgniter's index.php
	* --------------------------------------------------------------------------------------------------
	*/
	function ipn() {
		$logfile = 'ipnlog/' . uniqid() . '.html';
		$logdata = "<pre>\r\n" . print_r($_POST, true) . '</pre>';
		file_put_contents($logfile, $logdata);
	}
	
	/* -------------------------------------------------------------------------------------------------
	* a simple message to display errors. this should only be used during development
	* --------------------------------------------------------------------------------------------------
	*/
	function _error($ecd) {
		echo "<br>error at Express Checkout<br>";
		echo "<pre>" . print_r($ecd, true) . "</pre>";
		echo "<br>CURL error message<br>";
		echo 'Message:' . $this->session->userdata('curl_error_msg') . '<br>';
		echo 'Number:' . $this->session->userdata('curl_error_no') . '<br>';
	}
}
/* Sample controller for Paypal_ec.php Library */
/* End of file test.php */
/* Location: ./application/controllers/test.php */
