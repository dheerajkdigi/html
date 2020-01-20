<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('materialModel');
    }
	public function index()
    {
        $data['vendors'] = $this->vendorModel->vendors();
        $data['content'] = 'vendor/list';
        $this->load->view('layout',$data);
    }
    
    public function listing($categoryId)
    {
        $data['categoryId'] = $categoryId;
        $data['category'] = $this->inventoryModel->categoryDetail($categoryId);
        $data['vendors'] = $this->vendorModel->vendors($categoryId);
        //debug($data);die;
        $data['content'] = 'vendor/list';
        $this->load->view('layout',$data);
    }
    
    public function detail($vendor_id){
        $data['detail'] = $this->vendorModel->vendorDetail($vendor_id);
        // $data['vendor'] = $this->vendorModel->vendorDetail($vendor_id);
        // $data['content'] = 'vendor/detail';
        // $this->load->view('layout',$data);
        echo json_encode($data);
    }
    public function add(){
        //isAuthorized();
        //$data['languages']      = $this->vendorModel->languages(1);
        $data['materialGroups'] = $this->materialModel->materialGroups();
        //$data['categories']     = $this->inventoryModel->categories();
        $data['form_action']    = base_url().'vendor/save';
        $data['content']        = 'vendor/add';
        $this->load->view('layout',$data);
    }
    public function edit($vendorId){
        //die($vendorId);
        //isAuthorized();
        $data['materialGroups'] = $this->materialModel->materialGroups();
        $data['form_action']    = base_url().'vendor/update/'.$vendorId;
        //$data['categories']     = $this->inventoryModel->categories();
        $data['vendor']           = $this->vendorModel->vendorDetail($vendorId);
        $data['content']        = 'vendor/add';
        //dd($data);
        $this->load->view('layout',$data);
    }
    public function save(){
        //isAuthorized();
        $postData   = $this->input->post(null,TRUE);
        $postData   = array_change_key_case($postData, CASE_UPPER);
        $vendorData = $postData;
        $vendor_id  = $this->vendorModel->insert($vendorData);
        if($vendor_id){
            $this->session->set_flashdata('msg', 'Vendor Added Successfully!');
        }
        else{
            $this->session->set_flashdata('msg', 'Something went wrong.');
        }
        redirect(base_url('vendor'), 'refresh');
        exit;
    }
    public function update($vendorId){
        //isAuthorized();
        $postData   = $this->input->post(null,TRUE);
        $postData   = array_change_key_case($postData, CASE_UPPER);
        //debug($postData);die;
        $vendorData = $postData;
        /*
        $vendorData['NAME']            = $postData['NAME'];
        $vendorData['ADDRESS']          = $postData['ADDRESS'];
        $vendorData['CONTACT_PERSON']   = $postData['CONTACT_PERSON'];
        $vendorData['CONTACT_NO']       = $postData['CONTACT_NO'];
        //debug($vendorData);die;
        */
        //debug($vendorData);die;
        $this->vendorModel->update($vendorId,$vendorData);
        $this->session->set_flashdata('msg', 'Vendor Updated Successfully');
        redirect(base_url('vendor'), 'refresh');
        exit;
    }
    
    public function changeStatus(){
        //isAuthorized();
        $ADD_PACK_ID = $this->input->post('id',TRUE);
        $postData['IS_ACTIVE'] = $this->input->post('status',TRUE);
        echo $updated = $this->vendorModel->update($ADD_PACK_ID,$postData);
    }
    public function pinCodeDetail($pinCode){
        $url = "https://api.postalpincode.in/pincode/".$pinCode;
        $Curl_Session = curl_init($url);
        curl_setopt($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
        $curlResponse = curl_exec($Curl_Session);
        curl_close($Curl_Session);
        $curlResponseArr = json_decode($curlResponse,true);
        $postOfficeDetail = $curlResponseArr[0]['PostOffice'];
        //echo "<pre>";print_r($postOfficeDetail);
        $result = array('state' => $postOfficeDetail[0]['State'],
                        'district' => $postOfficeDetail[0]['District'], );
        echo json_encode($result);
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */