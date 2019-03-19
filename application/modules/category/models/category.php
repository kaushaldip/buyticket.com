<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
			
	}

	public $validate_settings =  array(			
			array('field' => 'category_name', 'label' => 'Category Name', 'rules' => 'required'),
            array('field' => 'sub_type', 'label' => 'Sub category Name', 'rules' => 'trim'),
            array('field' => 'sub_sub_type', 'label' => 'Sub event option', 'rules' => 'trim'),
            array('field' => 'date_time_detail', 'label' => 'Duration', 'rules' => 'integer'),
            
		);
		
	public function get_category_lists()
	{	
				 $this->db->order_by('last_update','DESC');
		$query = $this->db->get('event_type');
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
    
    public function get_only_category_lists()
	{	
				 $this->db->select('id,name,last_update');
                 $this->db->order_by(' name,last_update','DESC');
                 $this->db->group_by('name');
		$query = $this->db->get('event_type');
        
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
    
    public function get_only_sub_category_lists()
    {	
				 $this->db->select('id,sub_type,sub_sub_type');
                 $this->db->order_by('sub_type,last_update','DESC');
                 $this->db->where('is_display','yes');                                  
		$query = $this->db->get('event_type');
        
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
    public function get_only_sub_category_lists_by_category($category)
    {	
        $this->db->cache_off();
        $this->db->cache_delete_all();		
        		 $this->db->select('id,sub_type');
                 $this->db->order_by('sub_type,last_update','DESC'); 
                 $this->db->where('name',$category);
                 $this->db->where('is_display','yes');
		$query = $this->db->get('event_type');
        
        //echo $this->db->last_query();exit;
		if ($query->num_rows() > 0)
		{
		   return $query->result();
           $this->db->free_result();
		} 

		return false;
	}
	
	public function get_category_byid($id)
	{
		$query = $this->db->get_where('event_type',array('id'=>$id));

		if ($query->num_rows() > 0)
		{
		   return $query->row();
		} 

		return false;
	}
	
    public function get_performer_by_catid($id)
    {
        $this->db->select('cat.id,cat.performer, per.*');
		$this->db->from('event_type cat');
		$this->db->join('performer per','cat.performer=per.id');
		
		$this->db->where('cat.id', $id);
             		
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
	
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		
		return false;
    }
	
	public function insert_record()
    {
		//set auction details info
        if($this->input->post('performer_want')=='on')
        {
            if($this->input->post('performer_id'))
            {
                $performer_id = $this->input->post('performer_id');
            }
            else{
                //add performer detail
                if(($this->input->post('performer_name')!='')){
                    $array_data = array(					   
        			   'name' => $this->input->post('performer_name', TRUE),
                       'type' => $this->input->post('performer_type', TRUE),
                       'description' => $this->input->post('performer_description', TRUE),                   
                       );
        					   
        			$this->db->insert('performer', $array_data);
                    $performer_id = $this->db->insert_id();    
                }else{
                    $performer_id = 0;
                }   
            }                        
        }else{
            $performer_id = 0;
        } 
        
        $category_image = $this->general->uploadImage('category_image', 'category');
            
		$array_data = array(					   
		   'name' => $this->input->post('category_name', TRUE),
           'sub_type' => $this->input->post('sub_type', TRUE),
           'date_time_detail' => $this->input->post('date_time_detail', TRUE),
           'image' => $category_image,
           'sub_sub_type' => $this->input->post('sub_sub_type', TRUE),
		   'is_display' => $this->input->post('is_display', TRUE),
           'performer' => $performer_id,               
		   'last_update' => $this->general->get_local_time('time')
           );
				   
		$this->db->insert('event_type', $array_data); 
    }
	
	public function update_record($id)
	{
        //performer details
        //echo $this->input->post('performer_want');exit;
        if($this->input->post('performer_want')=='on')
        {
                //add performer detail
            if(($this->input->post('performer_name')!=''))
            {
                $array_data = array(					   
    			   'name' => $this->input->post('performer_name', TRUE),
                   'type' => $this->input->post('performer_type', TRUE),
                   'description' => $this->input->post('performer_description', TRUE),                   
                   );
    			
                $this->db->where('id',$this->input->post('performer_id',TRUE));		   
    			$this->db->update('performer', $array_data);
                $performer_id = $this->input->post('performer_id');   
            }   
                
        }else{
            $performer_id = 0;            
        }
     
        $category_image = (isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name']))? $this->general->uploadImage('category_image', 'category'): $this->input->post('old_category_image') ;
        
        if(isset($_FILES['category_image']['name']) && !empty($_FILES['category_image']['name'])){
            $old_category_image = $this->input->post('old_category_image');
            @unlink(UPLOAD_FILE_PATH."category/".$old_category_image);
            @unlink(UPLOAD_FILE_PATH."category/thumb_".$old_category_image);
        }
        	   
		//set value
        $data = array(					   
		   'name' => $this->input->post('category_name', TRUE),
           'sub_type' => $this->input->post('sub_type', TRUE),
           'date_time_detail' => $this->input->post('date_time_detail', TRUE),
           'sub_sub_type' => $this->input->post('sub_sub_type', TRUE),
		   'is_display' => $this->input->post('is_display', TRUE),
           'image' => $category_image,
           'performer' => $performer_id,               
		   'last_update' => $this->general->get_local_time('time'),
           'paid_event' => $this->input->post('paid_event',TRUE),
           );
				   
		$this->db->where('id', $this->input->post('id', TRUE));
		$this->db->update('event_type', $data); 
		
		

	}
	
	
	

}
