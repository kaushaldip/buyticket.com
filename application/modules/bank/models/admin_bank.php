<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_bank extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
			
	}

	public $validate_settings =  array(			
			
			array('field' => 'bank_name', 'label' => 'Bank name', 'rules' => 'trim|required'),
			array('field' => 'bank_account_number', 'label' => 'Acount Number', 'rules' => 'trim|required'),
            array('field' => 'bank_iban_number', 'label' => 'Bank IBAN number', 'rules' => 'trim|required'),
            array('field' => 'bank_account_name', 'label' => 'Bank account name', 'rules' => 'trim|required'),
		);
		
	public function get_bank_lists()
	{	
				  $this->db->order_by('bank_name','ASC');
		$query = $this->db->get('bank');

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
	public function get_bank_byid($id)
	{
		$query = $this->db->get_where('bank',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
	
	public function insert_record()
	{
        /*images upload*/
            $files = $_FILES;
            $this->load->library('upload');
            $this->load->library('image_lib');
            
            $new_image = "user_" . time() . rand(0, 99) . "." . pathinfo($files['image']['name'], PATHINFO_EXTENSION);
            $_FILES['image']['name'] = $new_image;
            $_FILES['image']['type'] = $files['image']['type'];
            $_FILES['image']['tmp_name'] = $files['image']['tmp_name'];
            $_FILES['image']['error'] = $files['image']['error'];
            $_FILES['image']['size'] = $files['image']['size'];
    
            $this->upload->initialize($this->set_upload_options());
            $this->upload->do_upload('image');
            if ($this->upload->display_errors()) {
                $this->error_img = $this->upload->display_errors();
                $new_image = "";
//                return false;
            } else {
                $data = $this->upload->data();
                //resize image
                $this->general->resize_image($data['file_name'], $data['raw_name'] . $data['file_ext'],'bank', 85, 85);
            }
        /*images upload*/
        	   
        //set auction details info
        $array_data = array(					   
           'bank_name' => $this->input->post('bank_name', TRUE),
           'bank_account_number' => $this->input->post('bank_account_number', TRUE),
           'bank_iban_number' => $this->input->post('bank_iban_number', TRUE),
           'bank_account_name' => $this->input->post('bank_account_name', TRUE),
           'bank_logo' => $new_image,           
        );
        
        $this->db->insert('bank', $array_data); 
	}
	
	public function update_record($id)
	{
		$files = $_FILES;
        $bank = $this->db->get_where('bank', array('id' => $id));
        if(!empty($files['image']['name'])){
            /*images upload*/
                $files = $_FILES;
                $this->load->library('upload');
                $this->load->library('image_lib');
                
                $new_image = "user_" . time() . rand(0, 99) . "." . pathinfo($files['image']['name'], PATHINFO_EXTENSION);
                $_FILES['image']['name'] = $new_image;
                $_FILES['image']['type'] = $files['image']['type'];
                $_FILES['image']['tmp_name'] = $files['image']['tmp_name'];
                $_FILES['image']['error'] = $files['image']['error'];
                $_FILES['image']['size'] = $files['image']['size'];
        
                $this->upload->initialize($this->set_upload_options());
                $this->upload->do_upload('image');
                if ($this->upload->display_errors()) {
                    $this->error_img = $this->upload->display_errors();
                    $new_image = "";
    //                return false;
                    $data = array(			  
        			   'bank_name' => $this->input->post('bank_name', TRUE),
        			   'bank_account_number' => $this->input->post('bank_account_number', TRUE),
                       'bank_iban_number' => $this->input->post('bank_iban_number', TRUE),
        			   'bank_account_name' => $this->input->post('bank_account_name', TRUE),
                    );
                } else {
                    $val = $bank->row();   
                    @unlink(UPLOAD_FILE_PATH.'bank/'.$val->bank_logo);
                      
                    $data = $this->upload->data();
                    //resize image
                    $this->general->resize_image($data['file_name'], $data['raw_name'] . $data['file_ext'],'bank', 85, 85);
                    $data = array(			  
        			   'bank_name' => $this->input->post('bank_name', TRUE),
        			   'bank_account_number' => $this->input->post('bank_account_number', TRUE),
                       'bank_iban_number' => $this->input->post('bank_iban_number', TRUE),
        			   'bank_account_name' => $this->input->post('bank_account_name', TRUE),
                       'bank_logo' => $new_image,
        			   
                    );
                }
            /*images upload*/
            
        }else{
            //set value
    		$data = array(			  
    			   'bank_name' => $this->input->post('bank_name', TRUE),
    			   'bank_account_number' => $this->input->post('bank_account_number', TRUE),
                   'bank_iban_number' => $this->input->post('bank_iban_number', TRUE),
    			   'bank_account_name' => $this->input->post('bank_account_name', TRUE),
    			   
                );
        }
        
		$this->db->where('id', $id);
		$this->db->update('bank', $data);
        //echo $this->db->last_query();exit;
	}
    
    private function set_upload_options()
    {
        //  upload an image options
        $config = array();
        $config['upload_path'] = './' . UPLOAD_FILE_PATH.'bank/' ; //define in constants
        $config['allowed_types'] = 'gif|jpg|png';
        $config['remove_spaces'] = true;
        $config['max_size'] = '500000';
        $config['max_width'] = '102400';
        $config['max_height'] = '102400';

        return $config;
    }

}
