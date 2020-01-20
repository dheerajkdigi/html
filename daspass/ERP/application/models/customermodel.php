<?php
class CustomerModel extends CI_Model {

    function customers() {
        return $query = $this->db->get('customer')->result();
    }

    function customers1() {
        $limit = 100;
        $offset = 0 ;
        $query = $this->db->get('customer', array('status' => 1), $limit, $offset);
        return $result = $query->result();
    }

    function customerDetail($customerId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->get_where('customer', array('id' => $customerId))->row();
    }

    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('customer', $data);
        return $this->db->insert_id();
    }

    function update($customerId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('customer', $data, array('ID'=> $customerId)); 
    }
}
?>