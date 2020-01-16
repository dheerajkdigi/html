<?php
class OrderModel extends CI_Model {

    function orders($condition="") {
        if(is_array($condition)){
            $query = $this->db->get_where('order', $condition)->result();
        }
        else{
            $query = $this->db->get('order')->result();
        }
        return $query;
    }

    function orders1() {
        $limit = 100;
        $offset = 0 ;
        $query = $this->db->get('order', array('status' => 1), $limit, $offset);
        return $result = $query->result();
    }

    function orderDetail($orderId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->get_where('order', array('id' => $orderId))->row();
    }
    function orderItems_old($orderId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        //return $query = $this->db->get_where('order_item', array('order_id' => $orderId))->result();
        $this->db->select('order_item.*,inventory.NAME,category.UNIT');
        $this->db->from('order_item');
        $this->db->join('inventory', 'order_item.INVENTORY_ID = inventory.ID');
        $this->db->join('category', 'inventory.category_id = category.id');
        $this->db->where(array('order_item.order_id' => $orderId));
        $query = $this->db->get();
        return $result = $query->result();
    }
    function orderItems($orderId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        //return $query = $this->db->get_where('order_item', array('order_id' => $orderId))->result();
        return $query = $this->db->get_where('order_item', array('order_id' => $orderId))->result();
    }
    function orderMaterials($orderId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        //return $query = $this->db->get_where('order_item', array('order_id' => $orderId))->result();
        return $query = $this->db->get_where('order_material', array('order_id' => $orderId))->result();
    }
    function orderMaterialsStore($orderId){
        $this->db->select('material.*,order_material.QUANTITY,order_material.MATERIAL_ID');    
        $this->db->from('order_material');
        $this->db->join('material', 'order_material.material_id = material.id');
        $this->db->where(array('order_material.order_id' => $orderId));
        $query = $this->db->get();
        return $query->result();
    }
    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('order', $data);
        return $this->db->insert_id();
    }
    function insertItem($data) {
        return $this->db->insert_batch('order_item', $data);
    }
    function insertMaterial($data) {
        return $this->db->insert_batch('order_material', $data);
        $this->db->update_batch('order_material', $data, 'title');

    }
    function updateStore($data) {
        return $this->db->update_batch('material', $data, 'ID');
        //print_r($this->db->last_query());    

    }
    function update($orderId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        //print_r($this->db->last_query()); 
        // $this->db->where('ID', $orderId);
        // $this->db->update('order', $data);
        $this->db->update('order', $data, array('ID'=> $orderId));
        return $this->db->last_query();
    }

    function productionStages($orderId){
        return $query = $this->db->get_where('production_stage', array('ORDER_ID' => $orderId))->row();
    }
    function updateProductionStages($orderId,$data){
        $query = $this->db->get_where('production_stage', array('ORDER_ID' => $orderId))->row();
        if($query) {
            return $this->db->update('production_stage', $data, array('ORDER_ID'=> $orderId)); 
        }
        else {
            $data['ORDER_ID'] = $orderId;
            return $this->db->insert('production_stage', $data);
        }
    }
    function insertDispatch($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('order_dispatch', $data);
        return $this->db->insert_id();
    }
    function updateDispatch($orderId,$data) {
        $data['MODIFIED_BY'] = $this->session->userdata('user')->email;
        return $this->db->update('order_dispatch', $data, array('ORDER_ID'=> $orderId));
    }
}
?>