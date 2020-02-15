<?php
   
require APPPATH . 'libraries/REST_Controller.php';
     
class Custom_Handler extends REST_Controller {
    
	  /**
     * Constructs
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }
       
    /**
     * Get Method, used for getting weekly message
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
           
        }    
        $this->response($data[0], REST_Controller::HTTP_OK);
	}
      
    /**
     * Post method, cannot be renamed.
     *
     * @return Response
    */
    public function index_post()
    {
        $input = $this->input->post();
        $input = file_get_contents("php://input");
      	header('Content-type: application/json');
      	$obj = json_decode($input,true);
      	
        $this->db->insert('global_users',$obj);
        
        $this->response(['Item created successfully.'], REST_Controller::HTTP_OK);
    } 
     
    /**
     * Put method, not supported by Chatfuel
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
     * Delete method, not supported by Chatfuel
     *
     * @return Response
    */
    public function index_delete($id)
    {
        $this->db->delete('items', array('id'=>$id));
       
        $this->response(['Item deleted successfully.'], REST_Controller::HTTP_OK);
    }
    	
}