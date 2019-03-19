<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admin extends CI_Controller
{
    function __construct() {
        parent::__construct();
        if (!$this->general->admin_logged_in()) {
            redirect(ADMIN_LOGIN_PATH, 'refresh');
            exit;
        }
        $this->config->set_item('language', 'en');
		$this->lang->load('english', 'english');
        $this->load->library(array('general','form_validation'));
    }
    
    function view(){
        
       $this->data['performer_type']=$this->general->get_performet_type();
       $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - performer type ')->build('performer_view', $this->data);
       
    }
    function add_performer(){
        $this->form_validation->set_rules('performer_type', 'Performer Type', 'required');

		if ($this->form_validation->run() == TRUE)
		{
			$data_a=array(
                          'performer_type'=>$this->input->post('performer_type')
                        );
                        $this->db->insert('es_performer_type',$data_a);
                        $this->session->set_flashdata('message','Performer type has been successfully added.');
			redirect(ADMIN_DASHBOARD_PATH.'/performer/view/','refresh');
		}
		
        
        $this->data['']='';
        $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - Add performer type ')->build('performer_add', $this->data);
    }
    function delete($id){
        $this->db->where('id',$id);
        $this->db->delete('es_performer_type');
        redirect(ADMIN_DASHBOARD_PATH.'/performer/view/','refresh');
        
    }
    function edit($id){
         $this->form_validation->set_rules('performer_type', 'Performer Type', 'required');
		

		if ($this->form_validation->run() == TRUE)
		{
			$data_a=array(
                          'performer_type'=>$this->input->post('performer_type')
                        );
                        $this->db->where('id',$id);
                        $this->db->update('es_performer_type',$data_a);
                        $this->session->set_flashdata('message','Performer type has been successfully updated.');
			redirect(ADMIN_DASHBOARD_PATH.'/performer/view/','refresh');
		}
		
        
        $this->data['performer_d']= $this->db->get_where('es_performer_type', array('id' => $id))->row();
          $this->template->set_layout('dashboard')->enable_parser(false)->title(SITE_NAME .' - Edit performer type ')->build('performer_edit', $this->data);
    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
