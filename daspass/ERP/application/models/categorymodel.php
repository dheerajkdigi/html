<?php
class CategoryModel extends CI_Model {

    function categories(){
        return $query = $this->db->get('category')->result();
    }


    function categoryDetail($categoryId) {
       $query = $this->db->get_where('category', array('id' => $categoryId));
        return $result = $query->row();
    }

    function insert($data){
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('category', $data);
        return $this->db->insert_id();
    }

    function update($categoryId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('category', $data, array('ID'=> $categoryId)); 
    }

    function setPositioning($updateArray){
        $this->db->update_batch('category',$updateArray, 'ID'); 
    }
}
?>