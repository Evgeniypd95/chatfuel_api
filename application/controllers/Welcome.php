<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('chatfuel_model');
        $this->load->database();
    }

	public function index()
	{	
		
		$item = $this->chatfuel_model->get_item(1);
		$data['user_item'] =  $item;
		$this->load->view('welcome_message', $data);
	}
}
