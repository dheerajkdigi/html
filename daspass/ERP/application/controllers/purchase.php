<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("vendorModel");
        $this->load->model("materialModel");
        $this->load->model('purchaseModel');
        $this->poTypes = array("IN_DIRECT", "IT_ACCESSORIES", "TRADING_ITEM", "PLANT_&_MACHINERY", "RAW_MATERIAL");
        $this->deliveryModes = array("AIR", "ROAD", "TRAIN");
    }
	public function index()
    {
        $data['purchases'] = $this->purchaseModel->purchases();
        $data['content'] = 'purchase/list';
        $this->load->view('layout',$data);
    }
    
    public function listing($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category'] = $this->inventoryModel->categoryDetail($categoryId);
        $data['purchases'] = $this->purchaseModel->purchases($categoryId);
        //debug($data);die;
        $data['content'] = 'purchase/list';
        $this->load->view('layout',$data);
    }
    
    public function detail($purchaseId) {
        $ajax = $this->input->post("ajax",TRUE);
        $data['purchase']   = $this->purchaseModel->purchaseDetail($purchaseId);
        $data['purchaseMaterials'] = $this->purchaseModel->purchaseMaterials($purchaseId);
        if($ajax){
            echo json_encode($data);
        }
        else{
            $data['content']    = 'purchase/detail';
            $this->load->view('layout',$data);    
        }
        
    }

    public function shortMaterials(){
        $data['materials'] = $this->purchaseModel->shortMaterials();
        $data['content'] = 'purchase/shortMaterials';

        $this->load->view('layout',$data);
    }

    public function add(){
        //isAuthorized();
        //$data['languages']      = $this->purchaseModel->languages(1);
        $data['poTypes']        = $this->poTypes;
        $data['deliveryModes']  = $this->deliveryModes;
        $data['vendors']        = $this->vendorModel->vendors();
        $data['materials']      = $this->materialModel->materials();
        $data['form_action']    = base_url().'purchase/save';
        $data['content']        = 'purchase/add';
        $this->load->view('layout',$data);
    }
    
    public function save(){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);
        //debug($postData);die;
        $purchaseData['PO_TYPE']            = $postData['PO_TYPE'];
        //$purchaseData['PO_NUMBER']          = $postData['PO_NUMBER'];
        //$purchaseData['APPROVE']           = $postData['APPROVE'];
        //$purchaseData['STATUS']             = $postData['STATUS'];
        $purchaseData['DELIVERY_ADDRESS']   = $postData['DELIVERY_ADDRESS'];
        $purchaseData['DELIVERY_MODE']      = $postData['DELIVERY_MODE'];
        $purchaseData['DELIVERY_SCHEDULE']  = $postData['DELIVERY_SCHEDULE'];
        $purchaseData['REMARKS']            = $postData['REMARKS'];
        $purchaseData['VENDOR_ID']          = $postData['VENDOR_ID'];
        $purchaseData['VENDOR_NAME']        = $postData['VENDOR_NAME'];
        $purchaseData['VENDOR_ADDRESS']     = $postData['VENDOR_ADDRESS'];
        $purchaseData['VENDOR_STATE']       = $postData['VENDOR_STATE'];
        $purchaseData['GSTIN']              = $postData['GSTIN'];
        $purchaseData['TOTAL_PRICE']        = $postData['TOTAL_PRICE'];
        //$purchaseData['CATEGORY_ID']    = (int)$postData['CATEGORY_ID'];
        
        $purchaseId = $this->purchaseModel->insert($purchaseData);
        if($purchaseId){
            //debug($postData['INVENTORY_ID']);
            $purchaseItemData = array();
            foreach ($postData['MATERIAL_ID'] as $key => $materialId) {
                $purchaseItem['PURCHASE_ID']    = $purchaseId;
                $purchaseItem['MATERIAL_ID']    = $postData['MATERIAL_ID'][$key];
                $purchaseItem['ITEM_NAME']      = $postData['ITEM_NAME'][$key];
                $purchaseItem['UOM']            = $postData['UOM'][$key];
                $purchaseItem['QUANTITY']       = $postData['QUANTITY'][$key];
                $purchaseItem['RATE']           = $postData['RATE'][$key];
                $purchaseItem['SGST']           = $postData['SGST'][$key];
                $purchaseItem['CGST']           = $postData['CGST'][$key];
                $purchaseItem['IGST']           = $postData['IGST'][$key];
                $purchaseItem['PRICE']          = $postData['PRICE'][$key];
                $purchaseItemData[]             = $purchaseItem;
            }
            //print_r($purchaseItemData);exit;
            $purchaseId = $this->purchaseModel->insertItem($purchaseItemData);
            $this->session->set_flashdata('msg', 'Purchase Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('purchase'), 'refresh');
        exit;
    }
    
    public function edit($purchaseId){
        //die($purchaseId);
        //isAuthorized();
        $data['poTypes']        = $this->poTypes;
        $data['deliveryModes']  = $this->deliveryModes;
        $data['vendors']        = $this->vendorModel->vendors();
        $data['materials']      = dbResultToArrayById($this->materialModel->materials());
        $data['purchase']       = $this->purchaseModel->purchaseDetail($purchaseId);
        $data['purchaseMaterials']= $this->purchaseModel->purchaseMaterials($purchaseId);
        $data['form_action']    = base_url().'purchase/update/'.$purchaseId;
        $data['content']        = 'purchase/add';
        //dd($data['purchase']);
        $this->load->view('layout',$data);
    }
    public function update($purchaseId){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        
        $purchaseData['PO_TYPE']            = $postData['PO_TYPE'];
        //$purchaseData['PO_NUMBER']          = $postData['PO_NUMBER'];
        //$purchaseData['APPROVE']           = $postData['APPROVE'];
        //$purchaseData['STATUS']             = $postData['STATUS'];
        $purchaseData['DELIVERY_ADDRESS']   = $postData['DELIVERY_ADDRESS'];
        $purchaseData['DELIVERY_MODE']      = $postData['DELIVERY_MODE'];
        $purchaseData['DELIVERY_SCHEDULE']  = $postData['DELIVERY_SCHEDULE'];
        $purchaseData['REMARKS']            = trim($postData['REMARKS']);
        $purchaseData['VENDOR_ID']          = $postData['VENDOR_ID'];
        $purchaseData['VENDOR_NAME']        = $postData['VENDOR_NAME'];
        $purchaseData['VENDOR_ADDRESS']     = $postData['VENDOR_ADDRESS'];
        $purchaseData['VENDOR_STATE']       = $postData['VENDOR_STATE'];
        $purchaseData['GSTIN']              = $postData['GSTIN'];
        $purchaseData['TOTAL_PRICE']        = $postData['TOTAL_PRICE'];

        //$purchaseData['TOTAL_PRICE']        = $postData['TOTAL_PRICE'];
        //debug($purchaseData);die;
        
        //debug($purchaseData);die;
        $this->purchaseModel->update($purchaseId,$purchaseData);
        
        foreach ($postData['MATERIAL_ID'] as $key => $materialId) {
            $purchaseItem                   = array();
            if($postData['QUANTITY'][$key]) {
                $purchaseItem['PURCHASE_ID']    = $purchaseId;
                $purchaseItem['MATERIAL_ID']    = $postData['MATERIAL_ID'][$key];
                $purchaseItem['ITEM_NAME']      = $postData['ITEM_NAME'][$key];
                $purchaseItem['UOM']            = $postData['UOM'][$key];
                $purchaseItem['QUANTITY']       = $postData['QUANTITY'][$key];
                $purchaseItem['RATE']           = $postData['RATE'][$key];
                $purchaseItem['SGST']           = $postData['SGST'][$key];
                $purchaseItem['CGST']           = $postData['CGST'][$key];
                $purchaseItem['IGST']           = $postData['IGST'][$key];
                $purchaseItem['PRICE']          = $postData['PRICE'][$key];
                if(isset($postData['PURCHASE_MATERIAL_ID'][$key]) && $postData['PURCHASE_MATERIAL_ID'][$key]){
                    $purchaseItem['ID']        = $postData['PURCHASE_MATERIAL_ID'][$key];
                    $purchaseItemDataUpdate[]  = $purchaseItem;
                }
                else{
                    $purchaseItemData[]        = $purchaseItem;    
                }
            }
            else{
                unset($postData['PURCHASE_MATERIAL_ID'][$key]);
            }
        }
        //debug($purchaseItemDataUpdate);dd($purchaseItemData);
        $this->purchaseModel->deleteItem($purchaseId, $postData['PURCHASE_MATERIAL_ID']);
        if(!empty($purchaseItemData)){
            $purchaseItemInsertRes = $this->purchaseModel->insertItem($purchaseItemData);
        }
        if(!empty($purchaseItemDataUpdate)){
            $purchaseItemUpdateRes = $this->purchaseModel->updateItem($purchaseItemDataUpdate);
        }
        $this->session->set_flashdata('msg', 'Purchase Updated Successfully');
        redirect(base_url('purchase'), 'refresh');
        exit;
    }
    

    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->purchaseModel->update($ADD_PACK_ID,$postData);
    }

    public function gate() {
        $data['vendors']        = $this->vendorModel->vendors();
        $condition              = array("STATUS"=>NULL,"IS_ACTIVE"=>1);
        $data['purchases']      = $this->purchaseModel->purchases($condition);
        $data['form_action']    = base_url().'purchase/gate_update/';
        $data['content']        = 'purchase/gate';
        //debug($data);
        $this->load->view('layout',$data);
    }
    public function gate_update() {
        $postData           = $this->input->post(null,TRUE);
        $purchaseId         = $postData['PURCHASE_ID'];

        $purchaseData['BILL_NUMBER']    = $postData['BILL_NUMBER'];
        $purchaseData['BILL_DATE']      = $postData['BILL_DATE'];
        $purchaseData['CHALLAN_NUMBER'] = $postData['CHALLAN_NUMBER'];
        $purchaseData['CHALLAN_DATE']   = $postData['CHALLAN_DATE'];
        $purchaseData['STATUS']         = "GATE";
        //echo "<pre>";print_r($postData);exit;
        $this->purchaseModel->update($purchaseId,$purchaseData);

        foreach ($postData['PURCHASE_MATERIAL_ID'] as $key => $purchaseMaterialId) {
            $purchaseItem['ID']             = $purchaseMaterialId;
            $purchaseItem['ACTUAL_QUANTITY']= $postData['ACTUAL_QUANTITY'][$key];
            $purchaseItem['GATE_STATUS']    = $postData['GATE_STATUS'][$key];
            $purchaseItem['GATE_DATE']      = date("Y-m-d H:i:s");
            $purchaseItemData[]             = $purchaseItem;
        }
        // print_r($purchaseData);
        // print_r($purchaseItemData);exit;
        $purchaseId = $this->purchaseModel->updateItem($purchaseItemData);

        $this->session->set_flashdata('msg', 'Gate Pass Updated Successfully');
        redirect(base_url('purchase'), 'refresh');
        exit;
    }
    public function quality() {
        $data['form_action']    = base_url().'purchase/quality_update/';
        $data['vendors']        = $this->vendorModel->vendors();
        $condition              = array("STATUS"=>"GATE","IS_ACTIVE"=>1);
        $data['purchases']      = $this->purchaseModel->purchases($condition);
        $data['content']        = 'purchase/quality';
        //debug($data);
        $this->load->view('layout',$data);
    }
    public function quality_update() {
        $postData               = $this->input->post(null,TRUE);
        $purchaseId             = $postData['PURCHASE_ID'];
        $purchaseData['STATUS'] = "QUALITY";
        $this->purchaseModel->update($purchaseId,$purchaseData);
        //echo "<pre>";print_r($postData);exit;
        //$this->purchaseModel->update($purchaseId,$purchaseData);

        foreach ($postData['PURCHASE_MATERIAL_ID'] as $key => $purchaseMaterialId) {
                $purchaseItem['ID']             = $purchaseMaterialId;
                $purchaseItem['QUALITY_STATUS'] = $postData['QUALITY_STATUS'][$key];
                $purchaseItem['QUALITY_DATE']   = date("Y-m-d H:i:s");
                $purchaseItemData[]             = $purchaseItem;
            }
        // print_r($purchaseData);
        // print_r($purchaseItemData);exit;
        $purchaseId = $this->purchaseModel->updateItem($purchaseItemData);

        $this->session->set_flashdata('msg', 'Quality Updated Successfully');
        redirect(base_url('purchase'), 'refresh');
        exit;
    }
    public function store() {
        $data['form_action']    = base_url().'purchase/store_submit/';
        $data['vendors']        = $this->vendorModel->vendors();
        $condition              = array("STATUS"=>"QUALITY","IS_ACTIVE"=>1);
        $data['purchases']      = $this->purchaseModel->purchases($condition);
        $data['content']        = 'purchase/store';
        //debug($data);
        $this->load->view('layout',$data);
    }
    public function store_submit() {
        $postData           = $this->input->post(null,TRUE);
        $purchaseId         = $postData['PURCHASE_ID'];
        $purchaseItemData   = array();

        //echo "<pre>";print_r($postData);
        foreach ($postData['MATERIAL_ID'] as $key => $materialId) {
            //echo $key."|".$postData['QUALITY_STATUS'][$key];
            $purchaseItem['ID']             = $materialId;
            $purchaseItem['STORE_QUANTITY'] = "STORE_QUANTITY + ".$postData['ACTUAL_QUANTITY'][$key];
            $purchaseItemData[]             = $purchaseItem;
            if($postData['QUALITY_STATUS'][$key] == "APPROVE") {
                //echo $postData['ACTUAL_QUANTITY'][$key];
                
                $this->db->set('STORE_QUANTITY', 'STORE_QUANTITY+'.$postData['ACTUAL_QUANTITY'][$key], FALSE);
                $this->db->where('ID', $materialId);
                $this->db->update('material');
                
                $insertMaterialHistory['PURCHASE_ID']= $purchaseId;
                $insertMaterialHistory['MATERIAL_ID']= $materialId;
                $insertMaterialHistory['QUANTITY']  = $postData['ACTUAL_QUANTITY'][$key];
                $insertMaterialHistory['TYPE']      = "IN";
                $insertMaterialHistory['CREATED_BY']= $this->session->userdata('user')->email;
                $insertMaterialHistoryData[]        = $insertMaterialHistory;
            }
            
        }
        //dd($insertMaterialHistoryData);
        if(!empty($insertMaterialHistoryData)){
            $insertMaterialHistoryRes    = $this->materialModel->insertMaterialHistory($insertMaterialHistoryData);
        }

        
        $purchaseData['STATUS'] = "SUBMIT";
        $this->purchaseModel->update($purchaseId,$purchaseData);
        // print_r($purchaseData);
        //print_r($purchaseItemData);exit;
        //$updateMaterial = $this->purchaseModel->updateMaterial($purchaseItemData);
        //print_r($updateMaterial);exit;
        $this->session->set_flashdata('msg', 'Purchase Stored Successfully');
        redirect(base_url('purchase'), 'refresh');
        exit;
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */