<?php
class PurchaseModel extends CI_Model {

    function purchases($condition="") {
        if(is_array($condition)){
            $query = $this->db->get_where('purchase', $condition)->result();
        }
        else{
            $query = $this->db->get('purchase')->result();
        }
        return $query;
        //return $query = $this->db->get('purchase')->result();
    }

    function purchases1() {
        $limit  = 100;
        $offset = 0 ;
        $query  = $this->db->get('purchase', array('status' => 1), $limit, $offset);
        return $result = $query->result();
    }

    function purchaseDetail($purchaseId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->get_where('purchase', array('id' => $purchaseId))->row();
    }
    function purchaseMaterials($purchaseId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->get_where('purchase_material', array('purchase_id' => $purchaseId))->result();
        /*
        $this->db->select('purchase_item.*,inventory.NAME,category.UNIT');
        $this->db->from('purchase_item');
        $this->db->join('inventory', 'purchase_item.INVENTORY_ID = inventory.ID');
        $this->db->join('category', 'inventory.category_id = category.id');
        $this->db->where(array('purchase_item.purchase_id' => $purchaseId));
        $query = $this->db->get();
        return $result = $query->result();
        */
    }

    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('purchase', $data);
        return $this->db->insert_id();
    }
    function insertItem($data) {
        return $this->db->insert_batch('purchase_material', $data);
    }
    function updateItem($data) {
        return $this->db->update_batch('purchase_material', $data, 'ID'); 
    }
    function deleteItem($purchaseId, $productMaterialIds){
        $this->db->where('PURCHASE_ID', $purchaseId);
        $this->db->where_not_in('ID', $productMaterialIds);
        $this->db->delete('purchase_material');
    }
    function updateMaterial($data) {
        $this->db->update_batch('material', $data, 'ID'); 
        return $this->db->last_query();
    }

    function update($purchaseId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('purchase', $data, array('ID'=> $purchaseId)); 
    }
    function shortMaterials() {
        $qry = "SELECT m.*,sum(om.QUANTITY) QTY FROM `material` m INNER JOIN order_material om on m.ID = om.MATERIAL_ID LEFT JOIN `production_stage` ps on om.ORDER_ID = ps.ORDER_ID where ps.order_id is NULL GROUP BY om.MATERIAL_ID having m.STORE_QUANTITY <QTY ";
        $query = $this->db->query($qry);
        return $query->result();
    }
    
}
?>