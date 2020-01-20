<?php
class QuotationModel extends CI_Model {

    function quotations($condition="") {
        if(is_array($condition)){
            $query = $this->db->get_where('quotation', $condition)->result();
        }
        else{
            $query = $this->db->get('quotation')->result();
        }
        return $query;
    }

    function groupByStatus($condition="") {
        if(is_array($condition)){
            $query = $this->db->select("IS_ACTIVE, COUNT(IS_ACTIVE) as STATUS_COUNT")->group_by('IS_ACTIVE')->get_where('quotation', $condition)->result();
        }
        else{
            $query = $this->db->select("IS_ACTIVE, COUNT(IS_ACTIVE) as STATUS_COUNT")->group_by('IS_ACTIVE')->get('quotation')->group_by('IS_ACTIVE')->result();
        }
        return $query;
    }
    
    function quotationDetail($quotationId){
        //$query = $this->db->get_where('t_addgames_tmp',array('ADD_PACK_ID' =>$game_id));
        return $query = $this->db->get_where('quotation', array('id' => $quotationId))->row();
    }

    function insert($data) {
        $data['CREATED_ON'] = date('Y-m-d H:i:s');
        $data['CREATED_BY'] = $this->session->userdata('user')->email;
        $this->db->insert('quotation', $data);
        return $this->db->insert_id();
    }
    function insertItem($data) {
        return $this->db->insert_batch('quotation_product', $data);
    }
    function updateItem($data) {
        return $this->db->update_batch('quotation_product', $data, 'ID'); 
    }
    function deleteItem($quotationId, $productIds){
        $this->db->where('QUOTATION_ID', $quotationId);
        $this->db->where_not_in('ID', $productIds);
        $this->db->delete('quotation_product');
    }
    function quotationProducts($quotationId){
        return $query = $this->db->get_where('quotation_product', array('quotation_id' => $quotationId))->result();
    }
    function update($quotationId,$data){
        $data['MODIFIED_BY']      = $this->session->userdata('user')->email;
        return $this->db->update('quotation', $data, array('ID'=> $quotationId)); 
    }
}
?>