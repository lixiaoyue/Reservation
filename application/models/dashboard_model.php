<?php

class dashboard_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }
    
public function add_new_room($room_type,$noOfRoom,$price,$description,$img_name){
        $data = array(
            'room_name' => $room_type,
            'no_of_room'=> $noOfRoom,
            'price'=> $price,
            'description'=> $description,
            'image'=> $img_name
                );
        
         $this->db->insert('room_registration', $data);
    }
    
    function booking_room()
        {   
            $query = $this->db->get('room_registration');
            return $query->result();
          
        }
}