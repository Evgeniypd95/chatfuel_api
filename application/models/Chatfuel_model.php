<?php

class Chatfuel_model extends CI_Model
{	

	function __construct(){
  		parent::__construct();
 	}

	public function get_item($id) {
      // $this->db->select('items');
	  $query = $this->db->get_where('items', array('id' => $id));
	  return $query->row();
	}

}