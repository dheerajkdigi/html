<?php
class InventoryModel extends CI_Model {

    function industries() {
        return $query = $this->db->get('industry')->result();
    }

    function categories() {
        return $query = $this->db->order_by('POSITION', 'ASC')->get('category')->result();
    }


    function categoryDetail($categoryId) {
       $query = $this->db->get_where('category', array('id' => $categoryId));
        return $result = $query->row();
    }

    function catInsert($data){
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('category', $data);
        return $this->db->insert_id();
    }

    function catUpdate($categoryId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('category', $data, array('ID'=> $categoryId)); 
    }

    function inventories($categoryId=0){

        $limit = 100;
        $offset = 0 ;
        if($categoryId){
           $query = $this->db->order_by('POSITION', 'ASC')->get_where('inventory', array('category_id' => $categoryId), $limit, $offset); 
        }
        else{
            //$query = $this->db->get_where('inventory', array('IS_ACTIVE' => 1), $limit, $offset);
            $this->db->select('inventory.*,category.UNIT');
            $this->db->from('inventory');
            $this->db->join('category', 'inventory.category_id = category.id');
            $this->db->where(array('inventory.IS_ACTIVE' => 1));
            $query = $this->db->get();
        }
         //order by ADD_PACK_ID desc
        //$query = $this->db->query($qry);
        return $result = $query->result();
        //debug($result);die;
    }

    function inventoryDetail($inventoryId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->get_where('inventory', array('id' => $inventoryId))->row();
    }

    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('inventory', $data);
        return $this->db->insert_id();
    }

    function update($inventoryId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('inventory', $data, array('ID'=> $inventoryId)); 
    }
}
?>