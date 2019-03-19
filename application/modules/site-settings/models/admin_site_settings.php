<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_site_settings extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public $validate_site_settings =  array(
    //contact_phone 	website_fee_percent 	website_fee_rate 	affiliate_referral_rate 	event_affiliate_referral_rate
			array('field' => 'site_name', 'label' => 'Website Name', 'rules' => 'required'),
			array('field' => 'contact_email', 'label' => 'Contact Email', 'rules' => 'required|valid_email'),			
			array('field' => 'contact_phone', 'label' => 'Contact Phone', 'rules' => 'required'),			
            array('field' => 'contact_address', 'label' => 'Contact Address', 'rules' => 'required'),
			array('field' => 'website_fee_rate', 'label' => 'Website Fee Rate', 'rules' => 'required|decimal'),			
			array('field' => 'affiliate_referral_rate', 'label' => 'Affiliate Referral Rate', 'rules' => 'required|decimal'),			
			array('field' => 'event_affiliate_referral_rate', 'label' => 'Event Affiliate Referral Rate', 'rules' => 'required'),			
            array('field' => 'website_fee_price','rules'=>'trim'),
			array('field' => 'default_page_title', 'label' => 'Default Page Title', 'rules' => 'required'),
			array('field' => 'default_meta_keys', 'label' => 'Default Meta Key', 'rules' => 'required'),
			array('field' => 'default_meta_desc', 'label' => 'Default Meta Description', 'rules' => 'required'),
			array('field' => 'site_offline_msg', 'label' => 'Site Offline Message', 'rules' => 'required'),
            array('field' => 'paypal_api_username', 'label' => 'Paypal API Username', 'rules' => 'required'),
            array('field' => 'paypal_api_signature', 'label' => 'Paypal API Signature', 'rules' => 'required'),
            array('field' => 'paypal_api_password', 'label' => 'Paypal API Password', 'rules' => 'required'),            			
			
		);
		
		
	public function get_site_setting()
	{		
		$query = $this->db->get('site_settings');

		if ($query->num_rows() > 0)
		{
		   return $query->row_array();
		} 

		return false;
	}
	
	public function update_site_settings()
	{
		//contact_phone 	website_fee_percent 	website_fee_rate 	affiliate_referral_rate 	event_affiliate_referral_rate
        $data = array(
               'site_name' => $this->input->post('site_name', TRUE),
               'contact_email' => $this->input->post('contact_email', TRUE),               
			   'contact_phone' => $this->input->post('contact_phone', TRUE),
               'contact_address' => $this->input->post('contact_address', TRUE),
			   'website_fee_rate' => $this->input->post('website_fee_rate', TRUE),
               'website_fee_price' => $this->input->post('website_fee_price', TRUE),                
			   'affiliate_referral_rate' => $this->input->post('affiliate_referral_rate', TRUE),               
			   'event_affiliate_referral_rate' => $this->input->post('event_affiliate_referral_rate', TRUE),               
			   'facebook_page_url' => $this->input->post('facebook_page_url', TRUE),               
            'googleolus_page_url' => $this->input->post('googleolus_page_url', TRUE),  
			   'twitter_page_url' => $this->input->post('twitter_page_url', TRUE),               
			   'youtube_page_url' => $this->input->post('youtube_page_url', TRUE),               
			   'facebook_app_id' => $this->input->post('facebook_app_id', TRUE),               
			   'default_page_title' => $this->input->post('default_page_title', TRUE),
			   'default_meta_keys' => $this->input->post('default_meta_keys', TRUE),
			   'default_meta_desc' => $this->input->post('default_meta_desc', TRUE),
			   'site_offline_msg' => $this->input->post('site_offline_msg', TRUE),
			   'site_status' => $this->input->post('site_status', TRUE),
               'paypal_api_username' => $this->input->post('paypal_api_username',TRUE),
               'paypal_api_signature' => $this->input->post('paypal_api_signature',TRUE),
               'paypal_api_password' => $this->input->post('paypal_api_password',TRUE),
            );

		$this->db->update('site_settings', $data); 

	}
	
	

}
