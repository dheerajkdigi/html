<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("customerModel");
        $this->load->model("quotationModel");
    }
	public function index()
    {
        $data['DATE_FROM'] = (isset($_POST["DATE_FROM"])) ? $_POST["DATE_FROM"] : date("Y-m-d", strtotime("-1 Month"));
        $data['DATE_TO'] = (isset($_POST["DATE_TO"])) ? $_POST["DATE_TO"] : date("Y-m-d");
        $condition = array("date(CREATED_ON) >=  " => $data['DATE_FROM'], "date(CREATED_ON) <=" => $data['DATE_TO']);
        $data['quotations'] = $this->quotationModel->quotations($condition);
        $data['quotation_status'] = dbResultToArrayById($this->quotationModel->groupByStatus($condition), "IS_ACTIVE");
        $data['content'] = 'quotation/list';
        $this->load->view('layout',$data);
    }
    
    public function listing($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category'] = $this->inventoryModel->categoryDetail($categoryId);
        $data['quotations'] = $this->quotationModel->quotations($categoryId);
        //debug($data);die;
        $data['content'] = 'quotation/list';
        $this->load->view('layout',$data);
    }
    
    public function detail($quotationId){
        $data['detail'] = $this->quotationModel->quotationDetail($quotationId);
        $data['products'] = $this->quotationModel->quotationProducts($quotationId);
        //$data['content'] = 'quotation/detail';
        //$this->load->view('layout',$data);
        echo json_encode($data);
    }
    public function add(){
        
        //$customers = $this->customerModel->customers();
        //debug($customers);die;
        //isAuthorized();
        //$data['languages']      = $this->quotationModel->languages(1);
        $data['customers']      = $this->customerModel->customers();
        $data['form_action']    = base_url().'quotation/save';
        $data['content']        = 'quotation/add';
        $this->load->view('layout',$data);
    }
    public function edit($quotationId){
        //die($quotationId);
        //isAuthorized();
        $data['customers']      = $this->customerModel->customers();
        $data['quotation']       = $this->quotationModel->quotationDetail($quotationId);
        $data['products'] = $this->quotationModel->quotationProducts($quotationId);
        $data['form_action']    = base_url().'quotation/update/'.$quotationId;
        
        $data['content']        = 'quotation/add';
        //dd($data);
        $this->load->view('layout',$data);
    }
    public function save() {
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        /*
        // We want to exclude posts from the following array
        $allowed = array( 'NAME', 'PRINT_NAME', 'MOBILE' );

        // Now do the filter, using a closure
        $quotationData = array_filter( $postData, function( $item ) use ( $allowed ) {
          if ( in_array( $item->ID, $exclude ) ) {
            return false;
          }

          return true;
        } );
        */
        //echo "<pre>";print_r($postData);exit;
        //$quotationData  = $postData;
        //debug($quotationData);exit;
        $quotationData['CUSTOMER_ID']       = $postData['CUSTOMER_ID'];
        $quotationData['CUSTOMER_NAME']     = $postData['CUSTOMER_NAME'];
        $quotationData['CONTACT_PERSON']    = $postData['CONTACT_PERSON'];
        $quotationData['ADDRESS']           = $postData['ADDRESS'];
        $quotationData['TOTAL_PRICE']       = $postData['TOTAL_PRICE'];
        $quotationData['PACKING_TERM']      = $postData['PACKING_TERM'];
        $quotationData['FREIGHT_TERM']      = $postData['FREIGHT_TERM'];
        $quotationData['PAYMENT_TERM']      = $postData['PAYMENT_TERM'];
        $quotationData['TAX_DETAIL']        = $postData['TAX_DETAIL'];
        $quotationId   = $this->quotationModel->insert($quotationData);
        if($quotationId) {
            foreach ($postData['PRODUCT_NAME'] as $key => $PRODUCT_NAME) {
                $quotationItem['QUOTATION_ID']  = $quotationId;
                $quotationItem['PRODUCT_NAME']  = $postData['PRODUCT_NAME'][$key];
                $quotationItem['QUANTITY']      = $postData['QUANTITY'][$key];
                $quotationItem['RATE']          = $postData['RATE'][$key];
                $quotationItem['PRICE']         = $postData['PRICE'][$key];
                $quotationItemData[]            = $quotationItem;
            }
            $quotationItemRes = $this->quotationModel->insertItem($quotationItemData);
            $this->session->set_flashdata('msg', 'Quotation Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('quotation'), 'refresh');
        exit;
    }
    public function update($quotationId){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        /*
        $quotationData['NAME']            = $postData['NAME'];
        $quotationData['ADDRESS']          = trim($postData['ADDRESS']);
        $quotationData['CONTACT_NO']       = $postData['CONTACT_NO'];
        */
        //$quotationData = $postData;
        //debug($quotationData);die;
        $quotationData['CUSTOMER_ID']       = $postData['CUSTOMER_ID'];
        $quotationData['CUSTOMER_NAME']     = $postData['CUSTOMER_NAME'];
        $quotationData['CONTACT_PERSON']    = $postData['CONTACT_PERSON'];
        $quotationData['ADDRESS']           = $postData['ADDRESS'];
        $quotationData['TOTAL_PRICE']       = $postData['TOTAL_PRICE'];
        $quotationData['PACKING_TERM']      = $postData['PACKING_TERM'];
        $quotationData['FREIGHT_TERM']      = $postData['FREIGHT_TERM'];
        $quotationData['PAYMENT_TERM']      = $postData['PAYMENT_TERM'];
        $quotationData['TAX_DETAIL']        = $postData['TAX_DETAIL'];
        //debug($postData);
        //$this->quotationModel->update($quotationId,$quotationData);
        foreach ($postData['PRODUCT_NAME'] as $key => $PRODUCT_NAME) {
            $quotationItem = array();
            $quotationItem['QUOTATION_ID']  = $quotationId;
            $quotationItem['PRODUCT_NAME']  = $postData['PRODUCT_NAME'][$key];
            $quotationItem['QUANTITY']      = $postData['QUANTITY'][$key];
            $quotationItem['RATE']          = $postData['RATE'][$key];
            $quotationItem['PRICE']         = $postData['PRICE'][$key];
            if(isset($postData['PRODUCT_ID'][$key])){
                $quotationItem['ID']        = $postData['PRODUCT_ID'][$key];
                $quotationItemDataUpdate[]  = $quotationItem;
            }
            else{
                $quotationItemData[]        = $quotationItem;    
            }
        }
        //dd($postData['PRODUCT_ID']);
        //debug($quotationItemDataUpdate);
        //dd($quotationItemData);
        $this->quotationModel->deleteItem($quotationId, $postData['PRODUCT_ID']);
        if(!empty($quotationItemData)){
            $quotationItemInsertRes = $this->quotationModel->insertItem($quotationItemData);
        }
        if(!empty($quotationItemDataUpdate)){
            $quotationItemUpdateRes = $this->quotationModel->updateItem($quotationItemDataUpdate);
        }

        $this->session->set_flashdata('msg', 'Quotation Updated Successfully');
        redirect(base_url('quotation'), 'refresh');
        exit;
    }
    
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->quotationModel->update($ADD_PACK_ID,$postData);
    }

    public function customerQuotations($customerId){
        $data['customerId'] = $customerId;
        $data['quotations'] = $this->quotationModel->quotations(array('CUSTOMER_ID' => $customerId));
        //$data['content'] = 'quotation/detail';
        //$this->load->view('layout',$data);
        echo json_encode($data);
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */