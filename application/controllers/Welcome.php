<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('chatfuel_model');
    }

	public function index()
	{	
		$this->load->database();
		$item = $this->chatfuel_model->get_item(1);
		$data['user_item'] =  $item;
		$this->load->view('welcome_message', $data);
	}
}
