<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Matching extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('chatfuel_model');
        $this->load->database();
    }

    public function match($callback=null) {
        $active_users = $this->chatfuel_model->get_active_user();
        $pre_shuffle = array();
        foreach ($active_users as $row) {
            
            array_push($pre_shuffle, $row->id);
        }

        if (sizeof($pre_shuffle) % 2 !==0) {
            
            $unlucky = rand(0, sizeof($pre_shuffle));
            
            $this->chatfuel_model->unlucky_update($pre_shuffle[$unlucky]);
            unset($pre_shuffle[$unlucky]);

        } 

        $result = $this->sortear_pair($pre_shuffle);
        
    }

    public function sortear_pair($ids) {
        shuffle($ids);
        $result = array_chunk($ids, 2);

        if(array_map('array_unique', $result) != $result) {
            return sortear_pair($ids);
        }
        return $this->publish_pair($result, $ids);
    }

    public function publish_pair($pairs, $ids) {
        $callback = $this->chatfuel_model->check_unique($pairs);
        if ($callback) {
            foreach ($pairs as $row) {
            
            $this->chatfuel_model->populate_pair($row);
            
            } 
        } else {
            $factorial_numerator=$this->factorial(sizeof($ids));
            $factorial_denominator=$this->factorial(sizeof($ids)-2);
            $combinations_total = $factorial_numerator/(2*$factorial_denominator);
            $total_pairs = $this->chatfuel_model->count_all_pairs();

            if ($combinations_total=$total_pairs) {
                $this->chatfuel_model->no_pairs();
                return false;
            } else {
                $this->sortear_pair($ids);
            }
        }
    }

    public function factorial($number){ 
    if($number <= 1){   
        return 1;   
    }   
    else{   
        return $number * $this->factorial($number - 1);   
    }   
    } 
}
