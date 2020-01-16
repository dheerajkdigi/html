<?php
class VendorModel extends CI_Model {

    function vendors() {
        return $query = $this->db->get('vendor')->result();
    }

    function vendors1() {
        $limit = 100;
        $offset = 0 ;
        $query = $this->db->get('vendor', array('status' => 1), $limit, $offset);
        return $result = $query->result();
    }

    function vendorDetail($vendorId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->select('ID, NAME, MATERIAL_GROUP_ID, MATERIAL_GROUP_NAME, CONTACT_PERSON, MOBILE, EMAIL_ID, ADDRESS_1, ADDRESS_2, CITY, STATE, COUNTRY, PIN_CODE, PAN, GSTIN')->get_where('vendor', array('id' => $vendorId))->row();
    }

    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('vendor', $data);
        return $this->db->insert_id();
    }

    function update($vendorId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('vendor', $data, array('ID'=> $vendorId)); 
    }
}
?>