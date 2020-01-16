<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("customerModel");
        $this->load->model("materialModel");
        $this->load->model("quotationModel");
        $this->load->model('orderModel');
        
    }
	public function index()
    {
        $data['orders']     = $this->orderModel->orders();
        $data['content']    = 'order/list';
        $this->load->view('layout',$data);
    }
    
    public function listing($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category']   = $this->inventoryModel->categoryDetail($categoryId);
        $data['orders']     = $this->orderModel->orders($categoryId);
        //debug($data);die;
        $data['content']    = 'order/list';
        $this->load->view('layout',$data);
    }
    
    public function detail($order_id) {
        $ajax                       = $this->input->post("ajax",TRUE);
        $data['order']              = $this->orderModel->orderDetail($order_id);
        $data['items']              = $this->orderModel->orderItems($order_id);
        $data['materials']          = $this->orderModel->orderMaterials($order_id);
        $data['productionStages']   = $this->orderModel->productionStages($order_id);
        if($ajax){
            echo json_encode($data);
        }
        else {
            $data['content']        = 'order/detail';
            $this->load->view('layout',$data);    
        }
    }
    public function add_old() {
        //isAuthorized();
        //$data['languages']      = $this->orderModel->languages(1);
        $data['industries']     = $this->inventoryModel->industries();
        $data['inventories']    = $this->inventoryModel->inventories();
        $data['form_action']    = base_url().'order/save';
        $data['content']        = 'order/add';
        $this->load->view('layout',$data);
    }
    
    public function save_old() {
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);
        //debug($postData);debug($_FILES);die;
        $orderData['NAME']             = $postData['NAME'];
        $orderData['ADDRESS']          = $postData['ADDRESS'];
        $orderData['CONTACT_NO']       = $postData['CONTACT_NO'];
        $orderData['INDUSTRY_ID']      = $postData['INDUSTRY_ID'];
        $orderData['PAYMENT_TERM']     = $postData['PAYMENT_TERM'];
        $orderData['DELIVERY_TERM']    = $postData['DELIVERY_TERM'];
        //$orderData['CATEGORY_ID']    = (int)$postData['CATEGORY_ID'];
        
        $order_id = $this->orderModel->insert($orderData);
        if($order_id){
            //debug($postData['INVENTORY_ID']);
            $orderItemData = array();
            foreach ($postData['INVENTORY_ID'] as $key => $inventoryId) {
                $orderItem['ORDER_ID']      = $order_id;
                $orderItem['INVENTORY_ID']  = $inventoryId;
                $orderItem['QUANTITY']      = $postData['QUANTITY'][$key];
                $orderItemData[] = $orderItem;
            }
            //print_r($orderItemData);exit;
            $order_id = $this->orderModel->insertItem($orderItemData);
            $this->session->set_flashdata('msg', 'Order Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('order'), 'refresh');
        exit;
    }
    public function add() {
        $data['customers']      = $this->customerModel->customers();
        //$data['quotations']     = $this->quotationModel->quotations();
        //$data['customers']      = $this->customerModel->customers();
        $data['form_action']    = base_url().'order/save';
        $data['content']        = 'order/add';
        //echo "<pre>";print_r($data);exit;
        $this->load->view('layout',$data);
    }
    public function planning() {
        $condition = array("STATUS"=>"");
        $data['orders']         = $this->orderModel->orders($condition);
        $data['materials']      = $this->materialModel->materials();
        $data['form_action']    = base_url().'order/save_planning';
        $data['content']        = 'order/planning';

        //echo "<pre>";print_r($data);exit;
        $this->load->view('layout',$data);
    }
    public function production() {
        $condition = array("STATUS"=>"PLANNING");
        $data['orders']         = $this->orderModel->orders($condition);
        $data['form_action']    = base_url().'order/save_production';
        $data['content']        = 'order/production';
        $this->load->view('layout',$data);
    }

    public function dispatch() {
        $condition              = array("STATUS"=>"PRODUCTION");
        $data['orders']         = $this->orderModel->orders($condition);
        $data['form_action']    = base_url().'order/save_dispatch';
        $data['content']        = 'order/dispatch';
        $this->load->view('layout',$data);
    }
    public function dispatch_doc() {
        $condition              = array("STATUS"=>"DISPATCH");
        $data['orders']         = $this->orderModel->orders($condition);
        $data['form_action']    = base_url().'order/save_dispatch_doc';
        $data['content']        = 'order/dispatch_doc';
        $this->load->view('layout',$data);
    }
    public function save() {
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);
        //debug($postData);die;
        $orderData['QUOTATION_ID']          = $postData['QUOTATION_ID'];
        $orderData['CUSTOMER_ID']           = $postData['CUSTOMER_ID'];
        $orderData['CUSTOMER_NAME']         = $postData['CUSTOMER_NAME'];
        $orderData['CUSTOMER_ADDRESS']      = $postData['CUSTOMER_ADDRESS'];
        $orderData['TOTAL_PRICE']           = $postData['TOTAL_PRICE'];
        $orderData['PO_NO']                 = $postData['PO_NO'];
        $orderData['PO_DATE']               = $postData['PO_DATE'];
        //$orderData['CUSTOMER_CONTACT_NO']   = $postData['CUSTOMER_CONTACT_NO'];
        //$orderData['INDUSTRY_ID']         = $postData['INDUSTRY_ID'];PACKING_TERM FREIGHT_TERM PAYMENT_TERM TAX_DETAIL
        $orderData['PACKING_TERM']          = $postData['PACKING_TERM'];
        $orderData['FREIGHT_TERM']          = $postData['FREIGHT_TERM'];
        $orderData['PAYMENT_TERM']          = $postData['PAYMENT_TERM'];
        $orderData['TAX_DETAIL']            = $postData['TAX_DETAIL'];
        $orderData['DELIVERY_DATE']         = $postData['DELIVERY_DATE'];
        //$orderData['DELIVERY_TERM']         = $postData['DELIVERY_TERM'];
        $orderData['REMARKS']               = $postData['REMARKS'];
        //$orderData['CATEGORY_ID']    = (int)$postData['CATEGORY_ID'];
        
        $order_id = $this->orderModel->insert($orderData);
        if($order_id) {
            //debug($postData['INVENTORY_ID']);
            $orderItemData = array();
            foreach ($postData['ITEM_NAME'] as $key => $ITEM_NAME) {
                $orderItem['ORDER_ID']      = $order_id;
                $orderItem['ITEM_NAME']     = $ITEM_NAME;
                $orderItem['QUANTITY']      = $postData['QUANTITY'][$key];
                $orderItem['RATE']          = $postData['RATE'][$key];
                $orderItem['PRICE']         = $postData['PRICE'][$key];
                $orderItemData[]            = $orderItem;
            }
            //print_r($orderItemData);exit;
            $order_id = $this->orderModel->insertItem($orderItemData);
            $this->session->set_flashdata('msg', 'Order Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }

        $this->quotationModel->update($postData['QUOTATION_ID'], array("IS_ACTIVE" => "0") );
        redirect(base_url('order'), 'refresh');
        exit;
    }
    public function save_planning() {
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);
       //debug($postData);die;
        $orderId    = $postData['ORDER_ID'];
        if($orderId){
            //debug($postData['INVENTORY_ID']);
            $orderMaterialData = array();
            //$updateMaterialData= array();
            foreach ($postData['MATERIAL_ID'] as $key => $materialId) {
                $orderMaterial['ORDER_ID']       = $orderId;
                $orderMaterial['MATERIAL_ID']    = $postData['MATERIAL_ID'][$key];
                $orderMaterial['ITEM_NAME']      = $postData['ITEM_NAME'][$key];
                $orderMaterial['UOM']            = $postData['UOM'][$key];
                $orderMaterial['QUANTITY']       = $postData['QUANTITY'][$key];
                $orderMaterialData[]             = $orderMaterial;
                /*
                $updateMaterial['ID']            = $postData['MATERIAL_ID'][$key];
                $updateMaterial['STORE_QUANTITY']= $postData['STORE_QUANTITY'][$key] - $postData['QUANTITY'][$key];
                $updateMaterialData[]            = $updateMaterial;
                */
            }
            //print_r($orderMaterialData);exit;
            $res            = $this->orderModel->insertMaterial($orderMaterialData);
            //$updateStore    = $this->orderModel->updateStore($updateMaterialData);
            $updateOrder    = $this->orderModel->update($orderId,array('STATUS' => 'PLANNING'));
            //print_r($updateOrder);exit;
            $this->session->set_flashdata('msg', 'Planned Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('order'), 'refresh');
        exit;
    }
    public function save_production() {
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);exit;
        //$productionStages = array("PIPE_CUTTING", "COILING", "FILLING", "FILLING_QUALITY_CHECK", "ROLLING", "ROLLING_QUALITY_CHECK", "BENDING", "FINNING", "ASSEMBLY", "ELECTRICAL_CONNECTION", "FINAL_TESTING");
        //$productionStages = array("PIPE_CUTTING", "COILING", "FILLING", "FILLING_QUALITY_CHECK", "ROLLING", "ANNEALING", "BENDING", "FINNING", "BRAZING", "BRAZING_QC", "SEALING", "MOUNTING", "MOUNTING_QC", "ELECTRICAL_CONNECTION", "FINAL_TESTING");
        $productionStages = array("MATERIAL_RECEIVED", "PIPE_CUTTING", "COILING", "FILLING", "ELECRICAL_TESTING_1", "ELECRICAL_TESTING_1_QC", "ROLLING", "ANNEALING", "BENDING", "FINNING", "BRAZING", "ELECRICAL_TESTING_2", "ELECRICAL_TESTING_2_QC", "SEALING", "MOUNTING", "FINAL_TESTING", "FINAL_TESTING_QC", "ELECTRICAL_CONNECTION",  "FINAL_INSPECTION",  "FINAL_INSPECTION_QC");
        //debug($postData);die;
        $productionStageData = array();
        $orderId    = $postData['ORDER_ID'];
        if($orderId) {
            foreach ($productionStages as $key => $value) {
                if(isset($postData[$value]) && $postData[$value] == "1") {
                    $productionStageData[$value."_DATE"] = date("Y-m-d H:i:s");
                } else if(isset($postData[$value]) && $postData[$value] == "0") {
                    $productionStageData[$value."_DATE"] = "";
                }
            }
            //echo "<pre>";print_r($productionStageData);exit;
            if(empty($productionStageData)){
                $this->session->set_flashdata('msg', 'Product Stages nothing to update!');
            }
            else{

                if(isset($postData["MATERIAL_RECEIVED"]) && $postData["MATERIAL_RECEIVED"] == "1") {
                    $orderMaterials = $this->orderModel->orderMaterialsStore($orderId);
                    $negativeQty = false;
                    //echo "<pre>"; print_r($orderMaterials);
                    foreach ($orderMaterials as $key => $orderMaterial) {
                        //echo "ITEM_NAME:".$orderMaterial->ITEM_NAME." | STORE_QUANTITY:".$orderMaterial->STORE_QUANTITY." - QUANTITY:".$orderMaterial->QUANTITY."<br/>";
                        $updateMaterial['ID']            = $orderMaterial->MATERIAL_ID;
                        $updateMaterial['STORE_QUANTITY']= $orderMaterial->STORE_QUANTITY - $orderMaterial->QUANTITY;
                        
                        $insertMaterialHistory['PURCHASE_ID']   = $orderMaterial->MATERIAL_ID;
                        $insertMaterialHistory['QUANTITY']      = $orderMaterial->QUANTITY;
                        $insertMaterialHistory['TYPE']          = "OUT";
                        $insertMaterialHistory['CREATED_BY']    = $this->session->userdata('user')->email;
                        if($updateMaterial['STORE_QUANTITY']<0){
                            $negativeQty = true;
                            //break;
                        }
                        $updateMaterialData[]            = $updateMaterial;
                        $insertMaterialHistoryData[]     = $insertMaterialHistory;
                    }
                    //echo "<pre>"; print_r($updateMaterialData);exit;
                    if($negativeQty){
                        $this->session->set_flashdata('msg', 'Material received should not be greater than Store material!');
                        redirect(base_url('order'), 'refresh');
                        exit;
                    }
                    $updateStore    = $this->orderModel->updateStore($updateMaterialData);
                    $insertMaterialHistoryRes    = $this->materialModel->insertMaterialHistory($insertMaterialHistoryData);
                }

                $orderProductionId = $this->orderModel->updateProductionStages($orderId,$productionStageData);
                if($postData['FINAL_INSPECTION_QC']) {
                    $updateOrder    = $this->orderModel->update($orderId,array('STATUS' => 'PRODUCTION'));
                }
                $this->session->set_flashdata('msg', 'Product Stages updated Successfully!');
            }
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('order'), 'refresh');
        exit;
    }
    public function save_dispatch() {
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);
        //debug($postData);die;
        $dispatchData['ORDER_ID']           = $postData['ORDER_ID'];
        $dispatchData['CUSTOMER_ID']        = $postData['CUSTOMER_ID'];
        $dispatchData['CUSTOMER_NAME']      = $postData['CUSTOMER_NAME'];
        $dispatchData['CUSTOMER_ADDRESS']   = $postData['CUSTOMER_ADDRESS'];
        $dispatchData['INVOICE_NO']         = $postData['INVOICE_NO'];
        $dispatchData['INVOICE_VALUE']      = $postData['INVOICE_VALUE'];
        $dispatchData['TRANSPORT_NAME']     = $postData['TRANSPORT_NAME'];
        $dispatchData['CR_NO']              = $postData['CR_NO'];
        $dispatchData['TRANSPORT_DATE']     = $postData['TRANSPORT_DATE'];
        $dispatchData['GR_DATE']            = $postData['GR_DATE'];
        $dispatchId = $this->orderModel->insertDispatch($dispatchData);
        if($dispatchId){
            $this->session->set_flashdata('msg', 'Dispatched Successfully!');
            $updateOrder    = $this->orderModel->update($postData['ORDER_ID'],array('STATUS' => 'DISPATCH'));
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('order'), 'refresh');
        exit;
    }
    public function save_dispatch_doc() {
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);

        $dispatchData['COURIER_NAME']   = $postData['COURIER_NAME'];
        $dispatchData['DOCKET_NO']      = $postData['DOCKET_NO'];
        $dispatchData['DOCKET_DATE']    = $postData['DOCKET_DATE'];
        $dispatchId = $this->orderModel->updateDispatch($postData['ORDER_ID'],$dispatchData);
        if($dispatchId){
            $this->session->set_flashdata('msg', 'Document Dispatched Successfully!');
            $updateOrder    = $this->orderModel->update($postData['ORDER_ID'],array('STATUS' => 'DISPATCH_DOC', 'IS_ACTIVE' => 0));
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('order'), 'refresh');
        exit;
    }
    /*
    public function edit($orderId){
        //die($orderId);
        //isAuthorized();
        $data['form_action']    = base_url().'order/update/'.$orderId;
        $data['categories']     = $this->inventoryModel->categories();
        $data['order']           = $this->orderModel->orderDetail($orderId);
        $data['content']        = 'order/add';
        //debug($data);
        $this->load->view('layout',$data);
    }
    public function update($orderId){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        
        $orderData['NAME']            = $postData['NAME'];
        $orderData['ADDRESS']          = $postData['ADDRESS'];
        $orderData['CONTACT_PERSON']   = $postData['CONTACT_PERSON'];
        $orderData['CONTACT_NO']       = $postData['CONTACT_NO'];
        //debug($orderData);die;
        
        //debug($orderData);die;
        $this->orderModel->update($orderId,$orderData);
        $this->session->set_flashdata('msg', 'Order Updated Successfully');
        redirect(base_url('order'), 'refresh');
        exit;
    }
    
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->orderModel->update($ADD_PACK_ID,$postData);
    }
    */
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */