<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_sale extends CI_Model 
{

	public function __construct() 
	{
		parent::__construct();
		
	}
	
	public function get_total_buyer($cat_id)
    {
        $this->db->select('bl.*,m.user_name,m.first_name,m.last_name,m.title,am.nomination_id,am.album_name,am.popular_song_name,am.artist_name,am.bid_fee,am.buy_cost,am.album_image,am.category_id');
		$this->db->from('buy_list AS bl');
		$this->db->join('members AS m','m.id = bl.user_id');				 
        $this->db->join('album_music AS am','am.id = bl.album_id');
		$this->db->where('am.category_id', $cat_id);		
        $this->db->order_by("bl.date", "desc"); 
        
        $query = $this->db->get();

		return $query->num_rows();
    }	
	public function get_buy_list($cat_id,$perpage,$offset)
	{		
		/*
        SELECT `bl`. * , `m`.`user_name` , `m`.`first_name` , `m`.`last_name` , `m`.`title` , am.nomination_id, am.album_name, am.popular_song_name, am.artist_name, am.bid_fee, am.buy_cost
        FROM (
        `emts_buy_list` AS bl
        )
        JOIN emts_members AS m
        JOIN emts_album_music AS am ON ( am.id = bl.album_id
        AND m.id = bl.user_id )
        WHERE bl.album_id = '74'
        ORDER BY `bl`.`date` DESC
        LIMIT 30 
         */
        $this->db->select('bl.*,m.user_name,m.first_name,m.last_name,m.title,am.nomination_id,am.album_name,am.popular_song_name,am.artist_name,am.bid_fee,am.buy_cost,am.album_image,am.category_id');
		$this->db->from('buy_list AS bl');
		$this->db->join('members AS m','m.id = bl.user_id');				 
        $this->db->join('album_music AS am','am.id = bl.album_id');
		$this->db->where('am.category_id', $cat_id);		
        $this->db->order_by("bl.date", "desc");
        $this->db->limit($perpage, $offset); 
       
        //$this->db->join('post_tags', 'post_tags.post_id = posts.post_id' ,'inner');
        //$this->db->join('tags', 'tags.tag_id = posts.post_id', 'inner');
       
       
       
        
        $query = $this->db->get();

		if ($query->num_rows() > 0)
		{
		   return $query->result();
		} 

		return false;
	}
	
	

}
