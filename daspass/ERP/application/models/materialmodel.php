<?php
class MaterialModel extends CI_Model {

    
    function materials($categoryId=0){
        return $query = $this->db->get('material')->result();
    }

    function materialDetail($materialId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->select('ID, MATERIAL_GROUP_ID, MATERIAL_GROUP_NAME, MATERIAL_SUB_GROUP_ID, MATERIAL_SUB_GROUP_NAME, ITEM_NAME, DESCRIPTION, UOM, SGST, CGST, IGST, STORE_QUANTITY, ITEM_LOCATION')->get_where('material', array('id' => $materialId))->row();
    }

    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('material', $data);
        return $this->db->insert_id();
    }

    function update($materialId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('material', $data, array('ID'=> $materialId)); 
    }

    function materialGroups(){
        return $query = $this->db->get('material_group')->result();
    }

    function materialSubGroups($materialGroupId){
        return $query = $this->db->get_where('material_sub_group',array('MATERIAL_GROUP_ID' => $materialGroupId))->result();
    }
    function insertGroup($data) {
        //$data['CREATED_ON'] = date('Y-m-d H:i:s');
        //$data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('material_group', $data);
        return $this->db->insert_id();
    }
    function insertSubGroup($data) {
        //$data['CREATED_ON'] = date('Y-m-d H:i:s');
        //$data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('material_sub_group', $data);
        return $this->db->insert_id();
    }
    function insertMaterialHistory($data) {
        return $this->db->insert_batch('material_history', $data);
    }
}
?>