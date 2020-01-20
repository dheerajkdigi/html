<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends MY_Controller {
	public function index()
    {
        $data['customers'] = $this->customerModel->customers();
        $data['content'] = 'customer/list';
        $this->load->view('layout',$data);
    }
    
    public function listing($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category'] = $this->inventoryModel->categoryDetail($categoryId);
        $data['customers'] = $this->customerModel->customers($categoryId);
        //debug($data);die;
        $data['content'] = 'customer/list';
        $this->load->view('layout',$data);
    }
    
    public function detail($customer_id){
        $data['detail'] = $this->customerModel->customerDetail($customer_id);
        //$data['content'] = 'customer/detail';
        //$this->load->view('layout',$data);
        echo json_encode($data);
    }
    public function add(){
        //isAuthorized();
        //$data['languages']      = $this->customerModel->languages(1);
        $data['categories']     = $this->inventoryModel->categories();
        $data['form_action']    = base_url().'customer/save';
        $data['content']        = 'customer/add';
        $this->load->view('layout',$data);
    }
    public function edit($customerId){
        //die($customerId);
        //isAuthorized();
        $data['form_action']    = base_url().'customer/update/'.$customerId;
        $data['categories']     = $this->inventoryModel->categories();
        $data['customer']       = $this->customerModel->customerDetail($customerId);
        $data['content']        = 'customer/add';
        //debug($data);
        $this->load->view('layout',$data);
    }
    public function save(){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        /*
        // We want to exclude posts from the following array
        $allowed = array( 'NAME', 'PRINT_NAME', 'MOBILE' );

        // Now do the filter, using a closure
        $customerData = array_filter( $postData, function( $item ) use ( $allowed ) {
          if ( in_array( $item->ID, $exclude ) ) {
            return false;
          }

          return true;
        } );
        */
        $customerData = $postData;
        $customer_id = $this->customerModel->insert($customerData);
        if($customer_id){
            $this->session->set_flashdata('msg', 'Customer Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('customer'), 'refresh');
        exit;
    }
    public function update($customerId){
        //isAuthorized();
        $postData = $this->input->post(null,TRUE);
        $postData = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        /*
        $customerData['NAME']            = $postData['NAME'];
        $customerData['ADDRESS']          = trim($postData['ADDRESS']);
        $customerData['CONTACT_NO']       = $postData['CONTACT_NO'];
        */
        $customerData = $postData;
        //debug($customerData);die;
        $this->customerModel->update($customerId,$customerData);
        $this->session->set_flashdata('msg', 'Customer Updated Successfully');
        redirect(base_url('customer'), 'refresh');
        exit;
    }
    
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->customerModel->update($ADD_PACK_ID,$postData);
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */