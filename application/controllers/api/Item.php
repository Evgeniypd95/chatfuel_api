<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Item extends REST_Controller {
    
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
	public function index_get($id = 0)
	{
        if(!empty($id)){
            $datapre = $this->db->get_where("global_users", ['messenger_user_id' => $id])->row_array();
            $data = array();
            $datapost = [
						'set_attributes' => $obj = [
						'week_message' => $datapre['week_message']
						]
					];
			array_push($data, $datapost);
        }else{
            $datapre = $this->db->get("global_users")->result();
            $data = array();
            foreach ($datapre as $row) {
            	 $datapost = [
						'set_attributes' => $obj = [
						'week_message' => $row->week_message
						]
					];
			array_push($data, $datapost);
            }
            // $data->row_array();
            var_dump($data);die;
           
        }
		// print_r($data);die;     
        $this->response($data[0], REST_Controller::HTTP_OK);
	}
      
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        // $result = json_decode($input[1]);
        $input = file_get_contents("php://input");
      	header('Content-type: application/json');
      	$obj = json_decode($input,true);
      	
        $this->db->insert('global_users',$obj);
     
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    } 

    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function create_user()
    {
        $input = $this->input->post();
        // $result = json_decode($input[1]);
        $input = file_get_contents("php://input");
      	header('Content-type: application/json');
      	$obj = json_decode($input,true);
      	
        $this->db->insert('global_users',$obj);
     
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    } 
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_put($id)
    {
        $input = $this->put();
        $this->db->update('items', $input, array('id'=>$id));
     
        $this->response(['Item updated successfully.'], REST_Controller::HTTP_OK);
    }
     
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('items', array('id'=>$id));
       
        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}