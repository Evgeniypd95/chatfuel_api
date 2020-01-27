<?php

class Chatfuel_model extends CI_Model
{	

	function __construct(){
  		parent::__construct();
 	}

	public function get_item($id) {
	  $query = $this->db->get_where('items', array('id' => $id));
	  return $query->row();
	}

	public function get_active_user() {
		$query = $this->db->get_where('global_users', array('status' => 1));
        return $query->result();
	}

	public function check_unique($pairs){
		foreach ($pairs as $pair) {
			sort($pair);
			$this->db->where('partner_1', $pair[0]);
			$this->db->where('partner_2', $pair[1]);
			$counted = $this->db->count_all_results('pairs');
		}
			if ($counted>0) {
				return false;
			} else {
				return true;
			}
	}

	public function count_all_pairs() {
		return $this->db->count_all_results('pairs');
	}
	public function no_pairs() {
		$message = 'Sorry, we could not find any partner for you this week. Please stay tuned for the next week.';
		$data = array(
        'week_message' => $message
		);
		$this->db->where('status', 1);
		$this->db->update('global_users', $data);
		return false;
	}
	public function unlucky_update($id) {
		$message = 'Sorry, we did not find you a pair this week due to an odd number of participant, but we will prioritize you the next week! Please, try signup again on Friday.';
		$data = array(
        'week_message' => $message
		);
		$this->db->where('id', $id);
		$this->db->update('global_users', $data);
	}

	public function populate_pair($partners) {
		
		sort($partners);
		var_dump($partners);
		if ($partners[0]==$partners[1]) {
			return false;
		} else {
			//first iteration
		$this->db->where_in('id', $partners);
		$query = $this->db->select('fb_profile');
		$query = $this->db->select('first_name');
		$query = $this->db->select('last_name');
        $query = $this->db->get('global_users');
        $fb_profiles = $query->result();

        var_dump($fb_profiles);
        
		$message1 = 'Your partner this week is'.' '.$fb_profiles[1]->first_name.' '.$fb_profiles[1]->last_name.'.'.' '.'Message them here:'.$fb_profiles[1]->fb_profile;
		$message2 = 'Your partner this week is'.' '.$fb_profiles[0]->first_name.' '.$fb_profiles[0]->last_name.'.'.' '.'Message them here:'.$fb_profiles[0]->fb_profile;
		
		// var_dump($message1);

		$data1 = array(
        'week_message' => $message1
		);
		$this->db->where('id', $partners[0]);
		$this->db->update('global_users', $data1);

		$data2 = array(
        'week_message' => $message2
		);
		$this->db->where('id', $partners[1]);
		$this->db->update('global_users', $data2);

		$data = array(
        'partner_1' => $partners[0],
        'partner_2' => $partners[1],
        'week' => date('W'),
        'status' => 1
		);

		$this->db->insert('pairs', $data);
			
        }
	}

}